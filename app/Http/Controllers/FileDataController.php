<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Ie_data;
use App\Models\File_data;
use App\Helpers\LogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreFile_dataRequest;
use App\Http\Requests\UpdateFile_dataRequest;

class FileDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $file_datas = File_data::with('ie_data')->orderBy('status', 'DESC')->limit(1000)->get();
        return view('admin.file_datas.index', compact('file_datas'));
    }

    
    public function report(Request $request)
    {
        // Handle report type
        $reportType = $request->input('report_type', 'custom');

        switch ($reportType) {
            case 'monthly':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'yearly':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'previous_month':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'previous_year':
                $startDate = Carbon::now()->subYear()->startOfYear();
                $endDate = Carbon::now()->subYear()->endOfYear();
                break;
            default:
                $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
                $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();
        }


        // Get the base data
        $file_datas = File_data::whereBetween('file_date', [$startDate, $endDate])->get();

        return view('admin.file_datas.report', compact('file_datas', 'startDate', 'endDate'));
    }


    /**
     * Display a listing of the resource.
     */
    public function dueindex()
    {
        $file_datas = File_data::with('ie_data')->whereIn('status', ['Unpaid','Partial'])->get();
        return view('admin.file_datas.dueindex', compact('file_datas'));
    }
    
    /**
     * Display a listing of the resource.
     */
    public function paidindex()
    {
        $file_datas = File_data::with('ie_data')->where('status', 'Paid')->get();
        return view('admin.file_datas.paidindex', compact('file_datas'));
    }

    /**
     * Display a listing of the resource.
     */
    public function peymentBill()
    {
        $file_datas = File_data::with('ie_data')
        ->where('status', 'Paid')
        ->get();
        return view('admin.file_datas.peymentBill', compact('file_datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addPayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $peyment_method = 'Cash';


        if ($request->payment_method) {
            $peyment_method = $request->payment_method;
        }

        try {
            $file_data = File_data::findOrFail($id);

            // Initialize payments array if null
            $payments = $file_data->payments ?? [];

            // Add new payment
            $payments[] = [
                'amount' => $request->amount,
                'date' => $request->payment_date,
                'peyment_method' => $peyment_method,
                'recorded_at' => now(),
                'recorded_by' => Auth::id(),
            ];

            // Ensure Advance is in Payments array (Migration for legacy records)
            // Even though we are adding a NEW payment, we should ensure the BASE state matches our new logic
            // Check if advance is already included in payments
            $hasAdvancePayment = collect($payments)->contains('note', 'Advance Payment');
            
            if (!$hasAdvancePayment && $file_data->advance > 0) {
                 // Insert Advance payment at the beginning
                 array_unshift($payments, [
                    'amount' => $file_data->advance,
                    'date' => $file_data->advance_paid_date ?? now()->format('Y-m-d'), // Use existing date if available
                    'peyment_method' => 'Cash',
                    'recorded_at' => now(),
                    'recorded_by' => Auth::id(),
                    'note' => 'Advance Payment'
                ]);
            }

            // Update payment totals
            $total_paid = array_sum(array_column($payments, 'amount'));
            $balance = $file_data->total - $total_paid;

            // Check if a specific status was provided and isn't 'Auto'
            if ($request->status == 'Auto') {
                // If status is 'Auto' or not provided, determine status based on financial figures
                if ($balance <= 0) {
                    $payment_status = 'Paid';
                } elseif ($balance > 0 && $total_paid > 0) {
                    $payment_status = 'Partial';
                } else {
                    $payment_status = 'Unpaid';
                }
            } else {
                $payment_status = $request->status;
            }



            // Update file_data
            $file_data->payments = $payments;
            $file_data->total_paid = $total_paid;
            $file_data->balance = $balance;
            $file_data->status = $payment_status;

            // Recalculate profit
            $receptable_total = $file_data->receptable_total ?? 0;
            $miscellaneous_cost_total = $file_data->miscellaneous_cost_total ?? 0;
            $file_data->approximate_profit = $total_paid - ($receptable_total + $miscellaneous_cost_total);

            // Save all changes
            $file_data->save();

            return redirect()->back()->with('success', 'Payment recorded successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error recording payment: ' . $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        $ie_datas = Ie_data::select('id', 'org_name')->orderBy('org_name')->get();
        return view('admin.file_datas.create', compact('ie_datas'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFile_dataRequest $request)
    {
        try {
            // Process remarks array
            $remarks = [];
            if ($request->has('remarks_name') && $request->has('remarks_value')) {
                $remarksNames = $request->remarks_name ?? [];
                $remarksValues = $request->remarks_value ?? [];
                foreach ($remarksNames as $index => $name) {
                    if (isset($remarksValues[$index])) {
                        $remarks[] = [
                            'name' => $name,
                            'value' => $remarksValues[$index] ?? 0
                        ];
                    }
                }
            }

            // Process receptables array
            $receptables = [];
            if ($request->has('receptable_descriptions')) {
                $descriptions = $request->receptable_descriptions ?? [];
                $numbers = $request->receptable_numbers ?? [];
                $dates = $request->receptable_date ?? [];
                $amounts = $request->receptable_amounts ?? [];

                foreach ($descriptions as $index => $description) {
                    $receptables[] = [
                        'description' => $description ?? '-',
                        'number' => $numbers[$index] ?? '-',
                        'date' => $dates[$index] ?? '-',
                        'amount' => $amounts[$index] ?? 0
                    ];
                }
            }

            // Process miscellaneous array
            $miscellaneouses = [];
            if ($request->has('miscellaneous_detailses')) {
                $detailses = $request->miscellaneous_detailses ?? [];
                $numbers = $request->miscellaneous_numbers ?? [];
                $dates = $request->miscellaneous_dates ?? [];
                $costs = $request->miscellaneous_costs ?? [];
                $amounts = $request->miscellaneous_amounts ?? [];

                foreach ($detailses as $index => $details) {
                    $miscellaneouses[] = [
                        'details' => $details ?? '-',
                        'number' => $numbers[$index] ?? '-',
                        'date' => $dates[$index] ?? '-',
                        'cost' => $costs[$index] ?? 0,
                        'amount' => $amounts[$index] ?? 0
                    ];
                }
            }

            // Calculate totals
            $receptable_total = $request->receptable_total ?? 0;
            $miscellaneous_total = $request->miscellaneous_total ?? 0;
            $miscellaneous_cost_total = collect($miscellaneouses)->sum('cost');

            $total = $request->total ?? ($receptable_total + $miscellaneous_total);
            $advance = $request->advance ?? 0;
            $balance = $request->balance ?? ($total - $advance);

            // Create new File_data record
            $file_data = new File_data();
            $file_data->be_number = $request->be_number;
            $file_data->manifest_number = $request->manifest_number;
            $file_data->job_no = $request->job_no;
            $file_data->bill_no = $request->bill_no;
            $file_data->ie_data_id = $request->ie_data_id;
            $file_data->file_date = $request->file_date;
            $file_data->package = $request->package;

            // Handle date fields - convert d/m/Y format to Y-m-d if needed
            if ($request->delivary_date) {
                $file_data->delivary_date = $this->parseDate($request->delivary_date);
            }
            if ($request->be_date) {
                $file_data->be_date = $this->parseDate($request->be_date);
            }

            $file_data->lc_no = $request->lc_no;
            $file_data->net_wt = $request->net_wt;
            $file_data->goods_name = $request->goods_name;
            $file_data->invoice_number = $request->invoice_number;
            $file_data->invoice_date = $request->invoice_date;
            $file_data->lc_value = $request->lc_value;
            $file_data->dollar_rate = $request->dollar_rate;
            $file_data->ass_value = $request->ass_value;
            $file_data->goods_recept_date = $request->goods_recept_date;
            $file_data->document_recept_date = $request->document_recept_date;
            $file_data->bond_license_recept_date = $request->bond_license_recept_date;
            $file_data->advance_paid_date = $request->advance_paid_date;

            // Set JSON fields
            $file_data->remarks = !empty($remarks) ? $remarks : null;
            $file_data->receptables = !empty($receptables) ? $receptables : null;
            $file_data->miscellaneouses = !empty($miscellaneouses) ? $miscellaneouses : null;

            // Set totals
            $file_data->receptable_total = $receptable_total;
            $file_data->miscellaneous_total = $miscellaneous_total;
            $file_data->total = $total;
            $file_data->advance = $advance;
            $file_data->balance = $balance;
            $file_data->total_in_word = $request->totalInWord ?? null;

            // Set bank details
            $file_data->account_holder_name = $request->account_holder_name;
            $file_data->account_number = $request->account_number;
            $file_data->lc_bank = $request->lc_bank;

            // Initialize payment fields with Advance if present
        $payments = [];
        $total_paid = 0;

        if ($advance > 0) {
            $payments[] = [
                'amount' => $advance,
                'date' => $request->advance_paid_date ?? now()->format('Y-m-d'),
                'peyment_method' => 'Cash',
                'recorded_at' => now(),
                'recorded_by' => Auth::id(),
                'note' => 'Advance Payment'
            ];
            $total_paid = $advance;
        }

        $file_data->payments = $payments;
        $file_data->total_paid = $total_paid;
        $file_data->miscellaneous_cost_total = $miscellaneous_cost_total;
        $file_data->approximate_profit = $total_paid - ($receptable_total + $miscellaneous_cost_total);
        
        // Set Status based on balance and payments
        if ($file_data->balance <= 0) {
            $file_data->status = 'Paid';
        } elseif ($file_data->balance > 0 && $total_paid > 0) {
             $file_data->status = 'Partial';
        } else {
             $file_data->status = 'Unpaid';
        }

            $file_data->save();

            return redirect()->route('file_datas.index')->with(['status' => 200, 'message' => 'Invoice Created!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 500, 'message' => 'Error creating invoice: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Parse date from d/m/Y format to Y-m-d format
     */
    private function parseDate($date)
    {
        if (!$date) {
            return null;
        }

        // If already in Y-m-d format, return as is
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }

        // Try to parse d/m/Y format
        try {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            // If parsing fails, try to parse as is
            try {
                return Carbon::parse($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(File_data $file_data)
    {
        if (Auth::user()->hasRole('extra')) {
            $file_data->status = 'Printed';
            $file_data->save();
        }

        return view('admin.file_datas.show', compact('file_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File_data $file_data)
    {
        $file_data->load(['ie_data']);
        $ie_datas = Ie_data::select('id', 'org_name')->orderBy('org_name')->get();
        return view('admin.file_datas.edit', compact('file_data','ie_datas'));
    }
    /**
     * Show the form for printing/editing the specified resource.
     *
     * @param \App\Models\File_data $file_data The file data instance to edit
     * @return \Illuminate\View\View Returns the edit print view with file data
     */
    public function editprint(File_data $file_data)
    {
        // Eager load both ie_data and agent relationships in one query
        $ie_datas = Ie_data::select('id', 'org_name')->orderBy('org_name')->get();
        $file_data->load(['ie_data']);
        return view('admin.file_datas.editprint', compact('file_data','ie_datas'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFile_dataRequest $request, File_data $file_data)
    {
        try {
            // Process remarks array
            $remarks = [];
            if ($request->has('remarks_name') && $request->has('remarks_value')) {
                $remarksNames = $request->remarks_name ?? [];
                $remarksValues = $request->remarks_value ?? [];
                foreach ($remarksNames as $index => $name) {
                    if (isset($remarksValues[$index])) {
                        $remarks[] = [
                            'name' => $name,
                            'value' => $remarksValues[$index] ?? 0
                        ];
                    }
                }
            }

            // Process receptables array
            $receptables = [];
            if ($request->has('receptable_descriptions')) {
                $descriptions = $request->receptable_descriptions ?? [];
                $numbers = $request->receptable_numbers ?? [];
                $dates = $request->receptable_date ?? [];
                $amounts = $request->receptable_amounts ?? [];

                foreach ($descriptions as $index => $description) {
                    $receptables[] = [
                        'description' => $description ?? '-',
                        'number' => $numbers[$index] ?? '-',
                        'date' => $dates[$index] ?? '-',
                        'amount' => $amounts[$index] ?? 0
                    ];
                }
            }

            // Process miscellaneous array
            $miscellaneouses = [];
            if ($request->has('miscellaneous_detailses')) {
                $detailses = $request->miscellaneous_detailses ?? [];
                $numbers = $request->miscellaneous_numbers ?? [];
                $dates = $request->miscellaneous_dates ?? [];
                $costs = $request->miscellaneous_costs ?? [];
                $amounts = $request->miscellaneous_amounts ?? [];

                foreach ($detailses as $index => $details) {
                    $miscellaneouses[] = [
                        'details' => $details ?? '-',
                        'number' => $numbers[$index] ?? '-',
                        'date' => $dates[$index] ?? '-',
                        'cost' => $costs[$index] ?? 0,
                        'amount' => $amounts[$index] ?? 0
                    ];
                }
            }

            // Calculate totals
            $receptable_total = $request->receptable_total ?? 0;
            $miscellaneous_total = $request->miscellaneous_total ?? 0;
            $miscellaneous_cost_total = collect($miscellaneouses)->sum('cost');

            $total = $request->total ?? ($receptable_total + $miscellaneous_total);
            $advance = $request->advance ?? 0;

            // Basic Fields
            $file_data->ie_data_id = $request->ie_data_id;
            $file_data->be_number = $request->be_number;
            $file_data->manifest_number = $request->manifest_number;
            $file_data->job_no = $request->job_no;
            $file_data->bill_no = $request->bill_no;
            $file_data->file_date = $request->file_date;
            $file_data->package = $request->package;
            $file_data->lc_no = $request->lc_no;
            $file_data->lc_value = $request->lc_value;
            $file_data->lc_bank = $request->lc_bank;
            $file_data->net_wt = $request->net_wt;
            $file_data->goods_name = $request->goods_name;
            $file_data->invoice_number = $request->invoice_number;
            $file_data->invoice_date = $request->invoice_date;
            $file_data->dollar_rate = $request->dollar_rate;
            $file_data->ass_value = $request->ass_value;

             // Handle date fields
            if ($request->delivary_date) $file_data->delivary_date = $this->parseDate($request->delivary_date);
            if ($request->be_date) $file_data->be_date = $this->parseDate($request->be_date);
            
            $file_data->goods_recept_date = $request->goods_recept_date;
            $file_data->document_recept_date = $request->document_recept_date;
            $file_data->bond_license_recept_date = $request->bond_license_recept_date;
            $file_data->advance_paid_date = $request->advance_paid_date;

            // Update JSON fields
            $file_data->remarks = !empty($remarks) ? $remarks : null;
            $file_data->receptables = !empty($receptables) ? $receptables : null;
            $file_data->miscellaneouses = !empty($miscellaneouses) ? $miscellaneouses : null;

            // Update totals
            $file_data->receptable_total = $receptable_total;
            $file_data->miscellaneous_total = $miscellaneous_total;
            $file_data->miscellaneous_cost_total = $miscellaneous_cost_total;
            $file_data->total = $total;
            $file_data->advance = $advance;
            
             // Bank Details
            $file_data->account_holder_name = $request->account_holder_name;
            $file_data->account_number = $request->account_number;

            $file_data->total_in_word = $request->totalInWord ?? null;


            // Handle Balance and Status
            
            // Sync/Verify Advance in Payments
            $payments = $file_data->payments ?? [];
            $hasAdvancePayment = false;
            
            // Look for existing Advance Payment entry
            foreach ($payments as $key => $payment) {
                if (isset($payment['note']) && $payment['note'] === 'Advance Payment') {
                    $hasAdvancePayment = true;
                    if ($advance > 0) {
                         // Update amount if changed
                        $payments[$key]['amount'] = $advance;
                        $payments[$key]['date'] = $request->advance_paid_date ?? $payment['date'];
                    } else {
                        // Remove if advance is now 0
                        unset($payments[$key]);
                    }
                    break;
                }
            }

            // If not found and advance > 0, create it (prepend to array)
            if (!$hasAdvancePayment && $advance > 0) {
                array_unshift($payments, [
                    'amount' => $advance,
                    'date' => $request->advance_paid_date ?? now()->format('Y-m-d'),
                    'peyment_method' => 'Cash',
                    'recorded_at' => now(),
                    'recorded_by' => Auth::id(),
                    'note' => 'Advance Payment'
                ]);
            }
            
            // Re-index array after unset
            $payments = array_values($payments);
            
            // Save updated payments
            $file_data->payments = $payments;
            
            // Recalculate total_paid
            $file_data->total_paid = array_sum(array_column($payments, 'amount'));
            $file_data->approximate_profit = $file_data->total_paid - ($receptable_total + $miscellaneous_cost_total);
            
            // Calculate Balance (Simple Formula)
            $file_data->balance = $total - $file_data->total_paid;

            // Update Status
            if ($file_data->balance <= 0) {
                $file_data->status = 'Paid';
            } elseif ($file_data->balance > 0 && $file_data->total_paid > 0) {
                 $file_data->status = 'Partial';
            } else {
                 $file_data->status = 'Unpaid';
            }

            // Save all changes
            $file_data->save();

            return redirect()->route('file_datas.edit', $file_data->id)
                ->with(['status' => 200, 'message' => 'File data updated successfully!']);

        } catch (\Exception $e) {

            return redirect()->back()
                ->with(['status' => 500, 'message' => 'Error updating file: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File_data $file_data)
    {
        try {
            // Delete the record
            $file_data->delete();

            return redirect()->route('file_datas.index')->with(['status' => 200, 'message' => 'File deleted successfully!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 500, 'message' => 'Error deleting file: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the print data for the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\File_data $file_data
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateprint(Request $request, File_data $file_data)
    {
        try {

            // Update all bill-related fields from form
            $file_data->bill_coat_fee = $request->bill_coat_fee;
            $file_data->bill_asso_be_entry_fee = $request->bill_asso_be_entry_fee;
            $file_data->bill_cargo_branch_aro = $request->bill_cargo_branch_aro;
            $file_data->bill_cargo_branch_ro = $request->bill_cargo_branch_ro;
            $file_data->bill_cargo_branch_ac = $request->bill_cargo_branch_ac;
            $file_data->bill_manifest_dept = $request->bill_manifest_dept;
            $file_data->bill_fourtytwo_shed_aro = $request->bill_fourtytwo_shed_aro;
            $file_data->bill_examination_normal = $request->bill_examination_normal;
            $file_data->bill_examination_irm = $request->bill_examination_irm;
            $file_data->bill_examination_goinda = $request->bill_examination_goinda;
            $file_data->bill_assessement_aro = $request->bill_assessement_aro;
            $file_data->bill_assessement_ro = $request->bill_assessement_ro;
            $file_data->bill_assessement_ac = $request->bill_assessement_ac;
            $file_data->bill_assessement_dc = $request->bill_assessement_dc;
            $file_data->bill_assessement_jc = $request->bill_assessement_jc;
            $file_data->bill_assessement_adc = $request->bill_assessement_adc;
            $file_data->bill_assessement_commissionar = $request->bill_assessement_commissionar;
            $file_data->bill_lab_test_fee_receptable = $request->bill_lab_test_fee_receptable;
            $file_data->bill_lab_test_fee_sample_processing = $request->bill_lab_test_fee_sample_processing;
            $file_data->bill_group_sipay = $request->bill_group_sipay;
            $file_data->bill_bank_chalan = $request->bill_bank_chalan;
            $file_data->bill_bank_chalan_evening = $request->bill_bank_chalan_evening;
            $file_data->bill_delivery_cost = $request->bill_delivery_cost;
            $file_data->bill_unstamping_dep_ro = $request->bill_unstamping_dep_ro;
            $file_data->bill_unstamping_dep_aro = $request->bill_unstamping_dep_aro;
            $file_data->bill_load_unload = $request->bill_load_unload;
            $file_data->bill_shed = $request->bill_shed;
            $file_data->bill_exit = $request->bill_exit;
            $file_data->bill_finaly_out_get = $request->bill_finaly_out_get;
            $file_data->bill_file_commission = $request->bill_file_commission;
            $file_data->bill_other_cost = $request->bill_other_cost;
            $file_data->bill_total = $request->bill_total;

            // Save Advance and Bank Details
            $file_data->advance = $request->advance;
            $file_data->account_holder_name = $request->account_holder_name;
            $file_data->account_number = $request->account_number;
            $file_data->lc_bank = $request->lc_bank;
            $file_data->total_in_word = $request->totalInWord;

            $file_data->balance = $request->bill_total - $request->total_paid;
            $file_data->total_paid = $request->total_paid;

            // Update status if totalpaid covers bill total
            if ($file_data->balance <= 0) {
                $file_data->status = 'Paid';
            } elseif ($file_data->balance > 0 && $request->total_paid > 0) {
                $file_data->status = 'Partial';
            } else {
                $file_data->status = 'Unpaid';
            }

            // Recalculate profit
            $receptable_total = $file_data->receptable_total ?? 0;
            $miscellaneous_cost_total = $file_data->miscellaneous_cost_total ?? 0;
            $file_data->approximate_profit = $file_data->total_paid - ($receptable_total + $miscellaneous_cost_total);

            // Save all changes
            $file_data->save();



            // Return success response with print-ready data
            return response()->json([
                'status' => 'success',
                'message' => 'Bill updated successfully',
                'file_data' => $file_data,
                'print_data' => [
                    'title' => 'Bill Voucher',
                    'bill_no' => $file_data->bill_no,
                    'date' => $file_data->file_date,
                    'total' => number_format($file_data->bill_total, 2)
                ]
            ], 200);

        } catch (\Exception $e) {

            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating bill. Please try again or contact support.',
                'debug_message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
