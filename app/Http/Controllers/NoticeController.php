<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = Notice::orderBy('publish_date', 'desc')->get();
        return view('notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:2048', // PDF file, max 2MB
            'publish_date' => 'required|date',
        ]);

        // Upload the file to the public disk
        $filePath = $request->file('file')->store('notices', 'public');
        $fileLink = Storage::url($filePath); // Generates a URL like /storage/notices/filename.pdf

        // Create the notice
        Notice::create([
            'title' => $request->title,
            'file_link' => $fileLink,
            'publish_date' => Carbon::parse($request->publish_date)->format('Y-m-d H:i:s'),
            'status' => 'active',
        ]);

        return redirect()->route('notices.index')->with('success', 'Notice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        return view('notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        return view('notices.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:2048', // Optional PDF file, max 2MB
            'publish_date' => 'required|date',
            'archive_date' => 'required|date',
            'status' => 'required|string|in:active,archived',
        ]);

        // Prepare the data to update
        $data = [
            'title' => $request->title,
            'publish_date' => $request->publish_date,
            'archive_date' => $request->archive_date,
            'status' => $request->status,
        ];

        // Update the file if a new one is uploaded
        if ($request->hasFile('file')) {
            // Delete the old file
            if ($notice->file_link) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $notice->file_link));
            }

            // Upload the new file
            $filePath = $request->file('file')->store('notices', 'public');
            $fileLink = Storage::url($filePath);
            $data['file_link'] = $fileLink;
        }

        // Update the notice
        $notice->update($data);

        return redirect()->route('notices.index')->with('success', 'Notice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        // Delete the file
        if ($notice->file_link) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $notice->file_link));
        }

        // Delete the notice
        $notice->delete();

        return redirect()->route('notices.index')->with('success', 'Notice deleted successfully.');
    }
}
