<?php

namespace App\Http\Controllers;

use App\Models\Marquee;
use Illuminate\Http\Request;

class MarqueeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marquees = Marquee::orderBy('order')->get();
        return view('marquees.index', compact('marquees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marquees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'active' => 'boolean',
            'order' => 'integer'
        ]);

        Marquee::create($validated);
        return redirect()->route('marquees.index')->with('success', 'Marquee created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Marquee $marquee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marquee $marquee)
    {
        return view('marquees.edit', compact('marquee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marquee $marquee)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'active' => 'boolean',
            'order' => 'integer'
        ]);

        $marquee->update($validated);
        return redirect()->route('marquees.index')->with('success', 'Marquee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marquee $marquee)
    {
        $marquee->delete();
        return redirect()->route('marquees.index')->with('success', 'Marquee deleted successfully');
    }
}
