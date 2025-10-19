<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Models\Agent;

class SmsController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function sendSms()
    {
        $agentCount = Agent::count();
        return view('admin.sms.sendSms',['agentCount'=>$agentCount]);
    }

    /**
     * Send a Single SMS
     */
    public function sendSingleSms(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^01[0-9]{9}$/'],
            'message' => 'required|string|max:480',
        ]);

        // Add 88 prefix to the phone number
        $phone = $request->phone;

        $response = $this->smsService->sendSingleSms($phone, $request->message);
        return response()->json($response);
    }

    /**
     * Send Bulk SMS
     */
    public function sendBulkSms(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:480',
        ]);
        // Extract phone number of all agents in an array
        $phones =

        $response = $this->smsService->sendBulkSms($phones, $request->message);
        return response()->json($response);
    }

    /**
     * Send Dynamic SMS
     */
    public function sendDynamicSms(Request $request)
    {
        $request->validate([
            'msisdn' => 'required|array',
            'msisdn.*' => ['required', 'regex:/^01[0-9]{9}$/'],
            'text' => 'required|array',
            'text.*' => 'required|string|max:480',
        ]);

        $messages = array_map(function($phone, $text) {
            // Add 88 prefix to the phone number
            $phone = '88' . $phone;
            return ['msisdn' => $phone, 'text' => $text];
        }, $request->msisdn, $request->text);

        $response = $this->smsService->sendDynamicSms($messages);
        return response()->json($response);
    }
}
