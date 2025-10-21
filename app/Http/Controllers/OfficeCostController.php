<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\OfficeCost;
use App\Models\CostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfficeCostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OfficeCost::with(['category', 'creator'])
            ->orderBy('cost_date', 'desc');

        // Apply filters if provided
        if ($request->filled('start_date')) {
            $query->whereDate('cost_date', '>=', Carbon::parse($request->start_date));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('cost_date', '<=', Carbon::parse($request->end_date));
        }
        if ($request->filled('category')) {
            $query->where('cost_category_id', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $officeCosts = $query->paginate(15)->withQueryString();
        $categories = CostCategory::where('is_active', true)->get();

        return view('admin.office_costs.index', compact('officeCosts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CostCategory::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.office_costs.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cost_category_id' => 'required|exists:cost_categories,id',
            'cost_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png'
        ]);

        DB::beginTransaction();
        try {
            $officeCost = new OfficeCost($validated);
            $officeCost->status = 'pending';
            $officeCost->created_by = Auth::id();

            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('office-costs', 'public');
                $officeCost->attachment_path = $path;
            }

            $officeCost->save();
            DB::commit();

            return redirect()->route('office-costs.index')
                ->with('success', 'Office cost created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating office cost: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficeCost $officeCost)
    {
        $officeCost->load(['category', 'creator', 'updater']);
        return view('admin.office_costs.show', compact('officeCost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficeCost $officeCost)
    {
        $categories = CostCategory::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.office_costs.form', compact('officeCost', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfficeCost $officeCost)
    {
        $validated = $request->validate([
            'cost_category_id' => 'required|exists:cost_categories,id',
            'cost_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('attachment')) {
                // Delete old attachment if exists
                if ($officeCost->attachment_path) {
                    Storage::disk('public')->delete($officeCost->attachment_path);
                }
                $path = $request->file('attachment')->store('office-costs', 'public');
                $validated['attachment_path'] = $path;
            }

            $validated['updated_by'] = Auth::id();
            $officeCost->update($validated);

            DB::commit();
            return redirect()->route('office-costs.index')
                ->with('success', 'Office cost updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating office cost: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficeCost $officeCost)
    {
        DB::beginTransaction();
        try {
            if ($officeCost->attachment_path) {
                Storage::disk('public')->delete($officeCost->attachment_path);
            }

            $officeCost->delete();

            DB::commit();
            return redirect()->route('office-costs.index')
                ->with('success', 'Office cost deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error deleting office cost: ' . $e->getMessage());
        }
    }

    /**
     * Generate a summary report of office costs
     */
    public function report(Request $request)
    {
        $query = OfficeCost::with('category');

        // Handle report type
        $reportType = $request->input('report_type', 'custom');

        switch ($reportType) {
            case 'monthly':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'yearly':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'previous_month':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'previous_year':
                $startDate = Carbon::now()->subYear()->startOfYear();
                $endDate = Carbon::now()->subYear()->endOfYear();
                break;
            default:
                $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
                $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();
        }

        // Apply category filter
        if ($request->filled('category_id')) {
            $query->where('cost_category_id', $request->category_id);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply min/max amount filters
        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }
        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        // Get the base data
        $summary = $query->whereBetween('cost_date', [$startDate, $endDate])
            ->select(
                'cost_category_id',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('DATE_FORMAT(cost_date, "%Y-%m") as month')
            )
            ->groupBy('cost_category_id', 'month')
            ->orderBy('month')
            ->get();

        // Get monthly trends
        $monthlyTrends = $query->whereBetween('cost_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE_FORMAT(cost_date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Calculate total amount and get categories
        $totalAmount = $summary->sum('total_amount');
        $categories = CostCategory::where('is_active', true)->get();

        return view('admin.office_costs.report', compact('summary', 'totalAmount', 'categories', 'monthlyTrends'));
    }
}
