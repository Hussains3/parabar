<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentFee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgentFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Agent $agent)
    {
        return view('admin.agents.fees.create', compact('agent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Agent $agent)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0',
            'fees_type' => 'required|string',
            'monthly' => 'required|numeric|min:0',
        ]);



        //Check fees type
        if ($request->fees_type == 'member_fee') {
            //Check if the agent has 'member_fee_paid_till_date'
            if ($agent->member_fee_paid_till_date == null) {
                //If the 'member_fee_paid_till_date' is null then set it to the current date
                $agent->member_fee_paid_till_date = $request->member_fee_paid_till_date;
                $agent->save();
            }

            //Determine how many months are in the past
            $duemonths = Carbon::now()->diffInMonths($agent->member_fee_paid_till_date);

            //Check how many month can be paid with the payment_amount
            $duemonthspaid = $request->payment_amount / $request->monthly;

            //Now add those duemonthspaid with member_fee_paid_till_date
            $newmemberfeepaidtilldate = $agent->member_fee_paid_till_date->addMonths($duemonthspaid);
            //Set the new member_fee_paid_till_date
            $agent->member_fee_amount = $request->monthly;
            $agent->member_fee_paid_till_date = $newmemberfeepaidtilldate;
            if ($request->last_fee_paid_date) {
                $agent->last_fee_paid_date = Carbon::parse($request->last_fee_paid_date);
            }

            // Save the changes
            $agent->save();

            
            return redirect()->route('agents.show', $agent)
            ->with('success', 'Fee payments recorded successfully');

        } elseif ($request->fees_type == 'welfare_fund') {
            //Check if the agent has 'welfare_fund_paid_till_date'
            if ($agent->welfare_fund_paid_till_date == null) {
                //If the 'welfare_fund_paid_till_date' is null then set it to the current date
                $agent->welfare_fund_paid_till_date = $request->welfare_fund_paid_till_date;
                $agent->save();
            }

            //Determine how many months are in the past
            $duemonths = Carbon::now()->diffInMonths($agent->welfare_fund_paid_till_date);

            //Check how many month can be paid with the payment_amount
            $duemonthspaid = $request->payment_amount / $request->monthly;

            //Now add those duemonthspaid with welfare_fund_paid_till_date
            $newwelfarefundpaidtilldate = $agent->welfare_fund_paid_till_date->addMonths($duemonthspaid);
            //Set the new welfare_fund_paid_till_date
            $agent->welfare_fund_amount = $request->monthly;
            $agent->welfare_fund_paid_till_date = $newwelfarefundpaidtilldate;

            if ($request->last_fee_paid_date) {
                $agent->last_fee_paid_date = Carbon::parse($request->last_fee_paid_date);
            }

            // Save the changes
            $agent->save();

            
            return redirect()->route('agents.show', $agent)
            ->with('success', 'Fee payments recorded successfully');

        } else {
            return redirect()->back()->withErrors(['fees_type' => 'Invalid fees type']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agent $agent, AgentFee $fee)
    {
        return view('admin.agents.fees.edit', compact('agent', 'fee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agent $agent, AgentFee $fee)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'fee_for_month' => 'required|date',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string',
            'transaction_id' => 'nullable|string',
            'status' => 'required|in:paid,pending',
            'remarks' => 'nullable|string'
        ]);

        $fee->update([
            'amount' => $request->amount,
            'fee_for_month' => Carbon::parse($request->fee_for_month),
            'payment_date' => Carbon::parse($request->payment_date),
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => $request->status,
            'remarks' => $request->remarks
        ]);

        // Update agent's payment dates if this is the latest payment
        $latestFee = $agent->fees()
            ->where('type', $fee->type)
            ->where('status', 'paid')
            ->latest('fee_for_month')
            ->first();

        if ($latestFee && $latestFee->id === $fee->id) {
            if ($fee->type === 'member_fee') {
                $agent->member_fee_paid_till_date = Carbon::parse($request->fee_for_month);
            } else {
                $agent->welfare_fund_paid_till_date = Carbon::parse($request->fee_for_month);
            }
            $agent->last_fee_paid_date = Carbon::parse($request->payment_date);
            $agent->save();
        }

        return redirect()->route('agents.show', $agent)
            ->with('success', 'Fee payment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agent $agent, AgentFee $fee)
    {
        $fee->delete();

        // Update agent's payment dates
        $latestMemberFee = $agent->fees()
            ->where('type', 'member_fee')
            ->where('status', 'paid')
            ->latest('fee_for_month')
            ->first();

        $latestWelfareFee = $agent->fees()
            ->where('type', 'welfare_fund')
            ->where('status', 'paid')
            ->latest('fee_for_month')
            ->first();

        $agent->member_fee_paid_till_date = $latestMemberFee ? $latestMemberFee->fee_for_month : null;
        $agent->welfare_fund_paid_till_date = $latestWelfareFee ? $latestWelfareFee->fee_for_month : null;
        $agent->last_fee_paid_date = collect([$latestMemberFee, $latestWelfareFee])
            ->filter()
            ->sortByDesc('payment_date')
            ->first()?->payment_date;
        $agent->save();

        return redirect()->route('agents.show', $agent)
            ->with('success', 'Fee payment deleted successfully');
    }
}
