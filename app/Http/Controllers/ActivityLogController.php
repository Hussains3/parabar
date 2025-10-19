<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(50);
        return view('admin.activity-logs.index', compact('logs'));
    }

    public function clear()
    {
        ActivityLog::truncate();
        return redirect()->route('activity-logs.index')
            ->with('success', 'All activity logs have been cleared successfully.');
    }
}
