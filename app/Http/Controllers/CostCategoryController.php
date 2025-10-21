<?php

namespace App\Http\Controllers;

use App\Models\CostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CostCategory::orderBy('name')->get();
        return view('admin.cost_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cost_categories.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cost_categories',
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        CostCategory::create($validated);

        return redirect()->route('cost-categories.index')
            ->with('success', 'Cost category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CostCategory $costCategory)
    {
        return view('admin.cost_categories.show', compact('costCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CostCategory $costCategory)
    {
        return view('admin.cost_categories.form', compact('costCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CostCategory $costCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cost_categories,name,' . $costCategory->id,
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $costCategory->update($validated);

        return redirect()->route('cost-categories.index')
            ->with('success', 'Cost category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CostCategory $costCategory)
    {
        // Check if category has any associated costs
        if ($costCategory->officeCosts()->exists()) {
            return redirect()->route('cost-categories.index')
                ->with('error', 'Cannot delete category: It has associated office costs.');
        }

        $costCategory->delete();

        return redirect()->route('cost-categories.index')
            ->with('success', 'Cost category deleted successfully.');
    }
}
