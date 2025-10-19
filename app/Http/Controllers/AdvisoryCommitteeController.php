<?php

namespace App\Http\Controllers;

use App\Models\AdvisoryCommittee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AdvisoryCommitteeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = AdvisoryCommittee::select([
                'id', 'name', 'designation', 'photo', 'order', 'active', 'type',
                'message', 'email', 'phone', 'officename', 'officeaddress'
            ]);
            return DataTables::of($query)->make(true);
        }
        return view('admin.advisory.index');
    }

    public function create()
    {
        return view('admin.advisory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
            'type' => 'nullable',
            'message' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'officename' => 'nullable|string|max:255',
            'officeaddress' => 'nullable|string|max:255'
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $filename);
            $data['photo'] = 'images/' . $filename;
        }

        AdvisoryCommittee::create($data);
        return redirect()->route('advisory.index')->with('success', 'Member added successfully.');
    }

    public function edit(AdvisoryCommittee $advisory)
    {
        return view('admin.advisory.edit', compact('advisory'));
    }

    public function update(Request $request, AdvisoryCommittee $advisory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
            'type' => 'nullable',
            'message' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'officename' => 'nullable|string|max:255',
            'officeaddress' => 'nullable|string|max:255'
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($advisory->photo && file_exists(public_path($advisory->photo))) {
                unlink(public_path($advisory->photo));
            }

            $photo = $request->file('photo');
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $filename);
            $data['photo'] = 'images/' . $filename;
        }

        $advisory->update($data);
        return redirect()->route('advisory.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(AdvisoryCommittee $advisory)
    {
        if ($advisory->photo && file_exists(public_path($advisory->photo))) {
            unlink(public_path($advisory->photo));
        }

        $advisory->delete();
        return response()->json(['success' => 'Member deleted successfully.']);
    }
}
