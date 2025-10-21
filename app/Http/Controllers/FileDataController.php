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
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ie_datas = Ie_data::select('id', 'org_name')->orderBy('org_name')->get();
        return view('admin.file_datas.create', compact('ie_datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createin()
    {
        $year = Carbon::now()->year; // Get the current year
        $file_data = File_data::latest()->with('agent')->first(); // Retrieve the latest File_data with agent relationship

        // Determine the next lodgement number
        $currentYear = Carbon::now()->year;
        $file_data_year = $file_data ? $file_data->created_at->year : null;

        if ($file_data && $file_data_year == $currentYear) {
            $next_lodgement_no = ($file_data->lodgement_no == '94020')
            ? 1
            : ($file_data->lodgement_no ?? 0) + 1;
        } else {
            $next_lodgement_no = 1; // Reset to 1 at the start of a new year
        }

        // Get the last agent name and ID if available
        $lastagent = $file_data->agent->name ?? null;
        $lastagent_id = $file_data->agent->id ?? null;

        $agents = Agent::select('id', 'name', 'ain_no')->orderBy('name')->get(); // Retrieve only id, name, and ain_number of all agents, ordered by name
        // Return the view for creating a new File_data record
        return view('admin.file_datas.createin', compact('next_lodgement_no', 'file_data', 'lastagent', 'lastagent_id', 'agents', 'year'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFile_dataRequest $request)
    {
        // Store the File_data record
        $file_data = File_data::create($request->validated());
        return redirect()->route('file_datas.index')->with(['status' => 200, 'message' => 'Invoice Created!']);
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

        $now = Carbon::now();
        $year = $now->year;
        $file_data = File_data::where('id', $file_data->id)->with('ie_data')->first();
        $file_data->load(['ie_data', 'agent']);
        return view('admin.file_datas.edit', compact('file_data','year'));
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
        if ($request->agentain != null) {
            $agent_id = Agent::where('name', $request->agentain)->value('id');
            $file_data->agent_id = $agent_id;
        }
        // Assign ie_data_id if exist, if not create a new one and assign it

        if (!empty($request->impexp)) {
            $ie_data = Ie_data::firstOrCreate(
                ['name' => $request->impexp], // Check if an Ie_data with this name exists
                ['ie' => 'Import'] // If not, create it with the default 'Import' value
            );

            $file_data->ie_data_id = $ie_data->id; // Assign the ie_data_id to the file_data
        }
        // Calculate the number of pages
        $pages = $request->page;
        $numberofPages = ($pages > 1) ? ceil((($pages - 1) / 3 + 1)) : 1;
        $file_data->no_of_items = $numberofPages;
        $file_data->lodgement_no = $request->lodgement_no;
        $file_data->manifest_no = $request->manifest_no;


        $file_data->be_date = $request->be_date; // Automatically handled by the model
        $file_data->lodgement_date = $request->lodgement_date; // Automatically handled by the model
        $file_data->manifest_date = $request->manifest_date; // Automatically handled by the model


        $file_data->ie_type = $request->ie_type;
        $file_data->group = $request->group;
        $file_data->goods_name = $request->goods_name;
        $file_data->goods_type = $request->goods_type;
        $file_data->be_number = $request->be_number;
        $file_data->page = $request->page;

        $file_data->fees = $request->fees;
        $file_data->status = 'Delivered';
        $file_data->delivered_at = Carbon::now();
        $file_data->save();

        // Check if SMS has already been sent
        if (!$file_data->sms_sent) {
            $agent = Agent::where('id', $file_data->agent_id)->first();
            $agent_email = $agent->email;
            $agent_phone = $agent->phone;

            // Sms Data
            $ie_name = Ie_data::where('id', $file_data->ie_data_id)->first();
            $ie_name = $ie_name->name;
            $newSmsData = 'Benapole C&F Agents Association, Your register B/E No: ' . $file_data->be_number . ' Date:' . $file_data->be_date . ' Im/Ex: ' . $ie_name . ', Manifest No: ' . $file_data->manifest_no . ' Date:' . $file_data->manifest_date . '. Thank you.';

            $sendSMS = Http::post(env('SSL_SMS_BASE_URL'), [
                'api_token' => env('SSL_SMS_API_TOKEN'),
                'sid' => env('SSL_SMS_SID'),
                'msisdn' => $agent_phone,
                'sms' => $newSmsData,
                'csms_id' => bin2hex(random_bytes(10)),
            ]);
            $responseData = $sendSMS->json();


            // Extract status for logging
            $status = $responseData['status'] ?? 'FAILED';
            $statusCode = $responseData['status_code'] ?? 'Unknown';
            $statusMessage = $responseData['error_message'] ?? 'No error message';

            // Log the SMS response
            LogHelper::log(
                action: "SMS Sent to $agent_phone",
                description: "Status: $status, Code: $statusCode, Message: $statusMessage",
                log_type: 'sms',
                responseData: $responseData
            );

            // Mark SMS as sent
            $file_data->sms_sent = true;
            $file_data->save();
        }

        // Email sending logic
        try {
            if ($agent_email) {
                Mail::send('emails.file_notification', [
                    'be_number' => $file_data->be_number,
                    'be_date' => $file_data->be_date,
                    'ie_name' => $ie_name,
                    'manifest_no' => $file_data->manifest_no,
                    'manifest_date' => $file_data->manifest_date,
                    'agent_name' => $agent->name
                ], function($message) use ($agent_email, $agent) {
                    $message->to($agent_email, $agent->name)
                        ->subject('File Registration Notification - Benapole C&F Agents Association');
                });

                LogHelper::log(
                    action: "Email Sent",
                    description: "Email notification sent to agent {$agent->name} at {$agent_email}",
                    log_type: 'email'
                );
            }
        } catch (\Exception $e) {
            LogHelper::log(
                action: "Email Failed",
                description: "Failed to send email to {$agent_email}: " . $e->getMessage(),
                log_type: 'error'
            );
        }

        if (Auth::user()->hasRole('operator')) {
            // Mark SMS as sent
            $file_data->deliverer_id = Auth::user()->id;
            $file_data->save();
            return redirect()->route('dashboard')->with(['status' => 200, 'message' => 'File Operated and Delivered!']);
        }

        return redirect()->route('file_datas.show', $file_data->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File_data $file_data)
    {
        // Check if user has permission to delete files
        if (!Auth::user()->can('delete', $file_data)) {
            return redirect()->back()->with(['status' => 403, 'message' => 'Unauthorized to delete this file.']);
        }

        try {
            // Log the deletion
            LogHelper::log(
                action: "File Data Deleted",
                description: "File Data with BE number: {$file_data->be_number} was deleted",
                log_type: 'delete'
            );

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
}
