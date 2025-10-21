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



    /**
     * Display a listing of the resource.
     */
    public function dueindex()
    {
        $file_datas = File_data::with('ie_data')->where('status', 'Unpaid')->get();
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
     * Show the form for creating a new resource.
     */
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

            // Create new File_data record
            $file_data = new File_data();
            $file_data->ie_data_id = $request->ie_data_id;
            $file_data->be_number = $request->be_number;
            $file_data->manifest_number = $request->manifest_number;
            $file_data->package = $request->package;
            $file_data->file_date = $request->file_date;
            $file_data->lc_no = $request->lc_no;
            $file_data->lc_value = $request->lc_value;
            $file_data->lc_bank = $request->lc_bank;
            $file_data->bill_no = $request->bill_no;

            //Actual values
            $file_data->actual_coat_fee = $request->actual_coat_fee;
            $file_data->actual_asso_be_entry_fee = $request->actual_asso_be_entry_fee;
            $file_data->actual_cargo_branch_aro = $request->actual_cargo_branch_aro;
            $file_data->actual_cargo_branch_ro = $request->actual_cargo_branch_ro;
            $file_data->actual_cargo_branch_ac = $request->actual_cargo_branch_ac;
            $file_data->actual_manifest_dept = $request->actual_manifest_dept;
            $file_data->actual_fourtytwo_shed_aro = $request->actual_fourtytwo_shed_aro;
            $file_data->actual_examination_normal = $request->actual_examination_normal;
            $file_data->actual_examination_irm = $request->actual_examination_irm;
            $file_data->actual_examination_goinda = $request->actual_examination_goinda;
            $file_data->actual_assessement_aro = $request->actual_assessement_aro;
            $file_data->actual_assessement_ro = $request->actual_assessement_ro;
            $file_data->actual_assessement_ac = $request->actual_assessement_ac;
            $file_data->actual_assessement_dc = $request->actual_assessement_dc;
            $file_data->actual_assessement_jc = $request->actual_assessement_jc;
            $file_data->actual_assessement_adc = $request->actual_assessement_adc;
            $file_data->actual_assessement_commissionar = $request->actual_assessement_commissionar;
            $file_data->actual_lab_test_fee_receptable = $request->actual_lab_test_fee_receptable;
            $file_data->actual_lab_test_fee_sample_processing = $request->actual_lab_test_fee_sample_processing;
            $file_data->actual_group_sipay = $request->actual_group_sipay;
            $file_data->actual_bank_chalan = $request->actual_bank_chalan;
            $file_data->actual_bank_chalan_evening = $request->actual_bank_chalan_evening;
            $file_data->actual_delivery_cost = $request->actual_delivery_cost;
            $file_data->actual_unstamping_dep_ro = $request->actual_unstamping_dep_ro;
            $file_data->actual_unstamping_dep_aro = $request->actual_unstamping_dep_aro;
            $file_data->actual_load_unload = $request->actual_load_unload;
            $file_data->actual_shed = $request->actual_shed;
            $file_data->actual_exit = $request->actual_exit;
            $file_data->actual_finaly_out_get = $request->actual_finaly_out_get;
            $file_data->actual_file_commission = $request->actual_file_commission;
            $file_data->actual_other_cost = $request->actual_other_cost;
            $file_data->actual_total = $request->actual_total;
            $file_data->status = 'Unpaid';

            $file_data->save();

            return redirect()->route('file_datas.index')->with(['status' => 200, 'message' => 'Invoice Created!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 500, 'message' => 'Error creating invoice: ' . $e->getMessage()]);
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
            // Bill values
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

            //Actual values
            $file_data->actual_coat_fee = $request->actual_coat_fee;
            $file_data->actual_asso_be_entry_fee = $request->actual_asso_be_entry_fee;
            $file_data->actual_cargo_branch_aro = $request->actual_cargo_branch_aro;
            $file_data->actual_cargo_branch_ro = $request->actual_cargo_branch_ro;
            $file_data->actual_cargo_branch_ac = $request->actual_cargo_branch_ac;
            $file_data->actual_manifest_dept = $request->actual_manifest_dept;
            $file_data->actual_fourtytwo_shed_aro = $request->actual_fourtytwo_shed_aro;
            $file_data->actual_examination_normal = $request->actual_examination_normal;
            $file_data->actual_examination_irm = $request->actual_examination_irm;
            $file_data->actual_examination_goinda = $request->actual_examination_goinda;
            $file_data->actual_assessement_aro = $request->actual_assessement_aro;
            $file_data->actual_assessement_ro = $request->actual_assessement_ro;
            $file_data->actual_assessement_ac = $request->actual_assessement_ac;
            $file_data->actual_assessement_dc = $request->actual_assessement_dc;
            $file_data->actual_assessement_jc = $request->actual_assessement_jc;
            $file_data->actual_assessement_adc = $request->actual_assessement_adc;
            $file_data->actual_assessement_commissionar = $request->actual_assessement_commissionar;
            $file_data->actual_lab_test_fee_receptable = $request->actual_lab_test_fee_receptable;
            $file_data->actual_lab_test_fee_sample_processing = $request->actual_lab_test_fee_sample_processing;
            $file_data->actual_group_sipay = $request->actual_group_sipay;
            $file_data->actual_bank_chalan = $request->actual_bank_chalan;
            $file_data->actual_bank_chalan_evening = $request->actual_bank_chalan_evening;
            $file_data->actual_delivery_cost = $request->actual_delivery_cost;
            $file_data->actual_unstamping_dep_ro = $request->actual_unstamping_dep_ro;
            $file_data->actual_unstamping_dep_aro = $request->actual_unstamping_dep_aro;
            $file_data->actual_load_unload = $request->actual_load_unload;
            $file_data->actual_shed = $request->actual_shed;
            $file_data->actual_exit = $request->actual_exit;
            $file_data->actual_finaly_out_get = $request->actual_finaly_out_get;
            $file_data->actual_file_commission = $request->actual_file_commission;
            $file_data->actual_other_cost = $request->actual_other_cost;
            $file_data->actual_total = $request->actual_total;


            // Save all changes
            $file_data->save();

            return redirect()->route('file_datas.edit', $file_data->id)
                ->with(['status' => 200, 'message' => 'File data updated successfully!']);

        } catch (\Exception $e) {

            return redirect()->back()
                ->with(['status' => 500, 'message' => 'Error updating file: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('file_datas.edit', $file_data->id);
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

    public function isBeNumberUnique(Request $request){
        // $year = date('Y');
        $be_number = $request->be_number;

        // $file_data = File_data::whereYear('created_at', $year )->where('be_number', $be_number)->first();
        $file_data = Dj_year_be_numbers::where('be_number', $be_number)->first();

      //  return $file_data;
      return response()->json(['success' => $file_data]);
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
            $file_data->status = $request->status ?? 'Paid';

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
