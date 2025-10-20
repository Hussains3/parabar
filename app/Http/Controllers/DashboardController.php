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


        return view('admin.dashboard');
    }

}
