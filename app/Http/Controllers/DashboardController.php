<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\File_data;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:admin-dash', only: ['dashboard']),
        ];
    }





    // Displaying dashboard work page
    public function dashboard(Request $request)//: View
    {
        //If auth user have checker or payunpay role then redirect him to custom file page
        if (auth()->user()->hasRole('checker') || auth()->user()->hasRole('payunpay')) {
            return redirect()->route('customfiles.index');
        }

        if (auth()->user()->hasRole('accountant') ) {
            return redirect()->route('baccounts.index');
        }


        // Today's file data count
        $todayFileDataCount = File_data::whereDate('created_at', Carbon::today())->count();
        $currentYearFileDataCount = File_data::whereYear('created_at', Carbon::now()->year)->count(); // Count entries for this year
        $printedFileDataCount = File_data::where('status', 'Printed')->count(); // Count entries with status 'Printed'
        $deliveredFileDataCount = File_data::where('status', 'Delivered')->count(); // Count entries with status 'Delivered'
        // Dashboard search
        if ($request->search) {
            if ($request->stype == 'ain_no') {
                $file_datas = File_data::with('agent')
                    ->with('ie_data')
                    ->whereHas('agent', function ($query) use ($request) {
                        $query->where('ain_no', 'like', '%' . $request->search . '%');
                    })
                    ->orderBy('id', 'DESC')
                    ->get();
                return view('admin.dashboard', compact('file_datas', 'todayFileDataCount', 'currentYearFileDataCount', 'printedFileDataCount', 'deliveredFileDataCount'));
            }else{

                $file_datas = File_data::with('agent')
                    ->with('ie_data')
                    ->where($request->stype,$request->search)
                    ->orderBy('id', 'DESC')
                    ->get();
                return view('admin.dashboard', compact('file_datas', 'todayFileDataCount', 'currentYearFileDataCount', 'printedFileDataCount', 'deliveredFileDataCount'));
            }
        }

        $file_datas = File_data::with('agent')->with('ie_data')->orderBy('id', 'DESC')->limit(1000)->get();
        return view('admin.dashboard', compact('file_datas', 'todayFileDataCount', 'currentYearFileDataCount', 'printedFileDataCount', 'deliveredFileDataCount'));
    }

}
