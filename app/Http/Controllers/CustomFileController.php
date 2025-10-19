<?php

namespace App\Http\Controllers;

use App\Models\CustomFile;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomFileRequest;
use App\Http\Requests\UpdateCustomFileRequest;
use Maatwebsite\Excel\Facades\Excel;

class CustomFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all CustomFile records from the database and order by status
        // and then by created_at in descending order
        $customFiles = CustomFile::orderBy('status', 'desc')
            ->get();

        //If auth user have checker or payunpay role then redirect him to custom file page
        if (auth()->user()->hasRole('payunpay')|| auth()->user()->hasRole('checker')) {
            $customFiles = CustomFile::where('status', 'Unpaid')
            ->get();
        }

        // Return a view with the list of CustomFiles
        return view('admin.customfiles.index', compact('customFiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view to display the form for creating a new CustomFile
        return view('admin.customfiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
      public function store(StoreCustomFileRequest $request)
    {
        try {
            $file = $request->file('excel_file');

            if (!$file) {
                return redirect()->back()->with('error', 'No file was uploaded.');
            }

            // Validate file extension
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, ['xlsx', 'xls'])) {
                return redirect()->back()->with('error', 'Please upload a valid Excel file.');
            }

            // Use Laravel Excel to import the file
            $data = Excel::toArray([], $file);

            // Process each row from the first sheet
            foreach ($data[0] as $index => $row) {
                // Skip header row
                if ($index === 0) continue;

                // Only process non-empty rows
                if (!empty(array_filter($row))) {
                    // Set fees based on type (IM/EX)
                    $type = trim(strtoupper($row[5] ?? '')); // Convert to uppercase and trim
                    $fees = $type === 'IM' ? 600 : ($type === 'EX' ? 500 : null);

                    // Search for matching agent by name
                    $agentain = trim($row[2] ?? '');
                    $agent = null;
                    if ($agentain) {
                        $agent = Agent::where('ain_no', 'LIKE', '%' . $agentain . '%')
                                    ->first();
                    }
                    // Setting the date
                    $date = $row[4] ?? null;
                    if ($date) {
                        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
                        $date = $date->format('Y-m-d');
                    }

                    CustomFile::create([
                        'name' => $row[1] ?? null,
                        'be_number' => $row[3] ?? null,
                        'fees' => $fees, // Use calculated fees
                        'type' => $type,
                        'status' => 'Unpaid',
                        'date' => $date,
                        'agent_id' => $agent ? $agent->id : null
                    ]);
                }
            }

            return redirect()->route('customfiles.index')->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomFile $customFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($customFile)
    {
        $customFile = CustomFile::find($customFile);
        $agents = Agent::orderBy('name')->get();
        return view('admin.customfiles.edit', compact('customFile', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomFileRequest $request, $customFile)
    {
        $customFile = CustomFile::find($customFile);

        try {
            // Set fees based on type if it's changed
            if ($request->type !== $customFile->type) {
                $request->merge([
                    'fees' => $request->type === 'IM' ? 600 : 500
                ]);
            }

            $customFile->update($request->validated());

            return redirect()->route('customfiles.index')
                ->with('success', 'Custom file updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating custom file: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $customFile)
    {
        $customFile = CustomFile::find($customFile);
        try {
            $customFile->delete();
            return redirect()->route('customfiles.index')
                ->with('success', 'Custom file deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting custom file: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the status of the custom file between Paid and Unpaid
     */
    public function toggleStatus($id)
    {
        try {
            $customFile = CustomFile::with('agent')->findOrFail($id);

            // Only allow changing from Unpaid to Paid
            if ($customFile->status === 'Paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot change status from Paid to Unpaid'
                ]);
            }

            $customFile->status = 'Paid';
            $customFile->save();

            return response()->json([
                'success' => true,
                'status' => $customFile->status,
                'agent_id' => $customFile->agent ? $customFile->agent->id : null,
                'agent_name' => $customFile->agent ? $customFile->agent->name : null,
                'type' => $customFile->type,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete all paid custom files older than 2 years
     */
    public function clearOld()
    {
        try {
            $twoYearsAgo = now()->subYears(2);

            // Find and delete old paid records
            $deletedCount = CustomFile::where('status', 'Paid')
                ->where('updated_at', '<', $twoYearsAgo)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => $deletedCount . ' old paid records have been deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting old records: ' . $e->getMessage()
            ], 500);
        }
    }
}
