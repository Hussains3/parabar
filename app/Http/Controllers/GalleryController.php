<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Gallery::query())->make(true);
        }
        return view('admin.galleries.index');
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
            $data['image'] = 'images/' . $filename;
        }

        Gallery::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('galleries.index')->with('success', 'Gallery image added successfully.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image && file_exists(public_path($gallery->image))) {
                unlink(public_path($gallery->image));
            }

            // Upload new image
            $image = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
            $data['image'] = 'images/' . $filename;
        }

        $gallery->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('galleries.index')->with('success', 'Gallery image updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete image file
        if ($gallery->image && file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
        }

        $gallery->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('galleries.index')->with('success', 'Gallery image deleted successfully.');
    }
}
