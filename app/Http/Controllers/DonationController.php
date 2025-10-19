<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Agent;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donations = Donation::orderBy('id', 'desc')->get(); // Order by 'id' in descending order
        return view('admin.donations.index', compact('donations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agents = Agent::all();
        return view('admin.donations.create', compact('agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date',
            'purpose' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'agent_id' => 'nullable|exists:agents,id',
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);
        
        // Create a new Donation record
        if ($request->has('agentain')) {
            $agent = Agent::where('name', $request->input('agentain'))->first();
            if ($agent) {
                $request->merge(['agent_id' => $agent->id]);
            } else {
                return redirect()->back()->with('error', 'Agent not found.');
            }
        }

        Donation::create($request->all());
        return redirect()->route('donations.index')->with('success', 'Donation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        $agents = Agent::all();
        return view('admin.donations.edit', ['donation'=>$donation,'agents'=>$agents]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'date' => 'nullable|date',
            'purpose' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'agent_id' => 'nullable|exists:agents,id',
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $donation->update($request->all());
        return redirect()->route('donations.index')->with('success', 'Donation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donations.index')->with('success', 'Donation deleted successfully.');
    }
}
