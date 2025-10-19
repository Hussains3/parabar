<?php
// app/Http/Controllers/ITCReportController.php

namespace App\Http\Controllers;

use App\Models\ITCReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ITCReportController extends Controller
{
    // Display a listing of the reports
    public function index()
    {
        $reports = ITCReport::orderBy('created_at', 'DESC')->get();
        return view('itc_reports.index', compact('reports'));
    }

    // Show the form for creating a new report
    public function create()
    {
        $reports = ITCReport::all();
        return view('admin.itc_reports.create',compact('reports'));
    }

    // Store a newly created report in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:2048', // PDF file, max 2MB
        ]);

        // Upload the file to the public disk
        $filePath = $request->file('file')->store('reports', 'public');
        $fileLink = Storage::url($filePath); // Generates a URL like /storage/reports/filename.pdf

        // Create the report
        ITCReport::create([
            'name' => $request->name,
            'type' => $request->type,
            'file_link' => $fileLink,
        ]);

        return redirect()->route('itc-reports.create')->with('success', 'Report created successfully.');
    }

    // Display the specified report
    public function show(ITCReport $itcReport)
    {
        return view('itc_reports.show', compact('itcReport'));
    }

    // Show the form for editing the specified report
    public function edit(ITCReport $itcReport)
    {
        return view('admin.itc_reports.edit', compact('itcReport'));
    }

    // Update the specified report in the database
    public function update(Request $request, ITCReport $itcReport)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:2048', // Optional PDF file, max 2MB
        ]);

        // Update the file if a new one is uploaded
        if ($request->hasFile('file')) {
            // Delete the old file
            if ($itcReport->file_link) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $itcReport->file_link));
            }

            // Upload the new file
            $filePath = $request->file('file')->store('reports', 'public');
            $fileLink = Storage::url($filePath);
            $itcReport->file_link = $fileLink;
        }

        // Update the report
        $itcReport->update([
            'name' => $request->name,
            'type' => $request->type,
            'file_link' => $itcReport->file_link,
        ]);

        return redirect()->route('itc-reports.index')->with('success', 'Report updated successfully.');
    }

    // Remove the specified report from the database
    public function destroy(ITCReport $itcReport)
    {
        // Delete the file
        if ($itcReport->file_link) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $itcReport->file_link));
        }

        // Delete the report
        $itcReport->delete();

        return redirect()->route('itc-reports.create')->with('success', 'Report deleted successfully.');
    }

    public function monthly(){
        $reports = ITCReport::where('type','monthly')->orderBy('created_at', 'DESC')->get();
        return view('itc_reports.monthly', compact('reports'));
    }

    public function yearly(){
        $reports = ITCReport::where('type','yearly')->orderBy('created_at', 'DESC')->get();
        return view('itc_reports.yearly', compact('reports'));
    }
}
