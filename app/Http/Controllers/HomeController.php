<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\{Project,Member,Notice,Agent,AdvisoryCommittee,Marquee,Gallery};



class HomeController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //     $this->middleware('permission:admin-dash', ['only' => ['dashboard']]);
    //     $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display visitor home page.
     */
    public function index(Request $request): View
    {
        $notices = Notice::orderBy('publish_date', 'desc')->take(5)->get();
        // Get all active marquees ordered by 'order'
        $marquees = Marquee::where('active', true)->orderBy('order')->get();
        // Get all advisories ordered by 'order'
        $advisories = AdvisoryCommittee::where('active', true)->where('type','EC Committee')->orderBy('order')->get();

        // Get active gallery images ordered by order
        $galleries = Gallery::where('active', true)->where('order', 2)->get();

        $president = AdvisoryCommittee::where('active', true)->where('designation','সভাপতি')->first();
        $generalSecretary = AdvisoryCommittee::where('active', true)->where('designation','সাধারণ সম্পাদক')->first();



        return view('welcome', [
            'notices' => $notices,
            'marquees' => $marquees,
            'advisories' => $advisories,
            'galleries' => $galleries,
            'president' => $president,
            'generalSecretary' => $generalSecretary
        ]);
    }

    public function photoalbum(): View
    {
        $galleries = Gallery::where('active', true)->where('order', 1)->get();
        return view('photoalbum', [
            'galleries' => $galleries
        ]);
    }


    public function generalMember(Request $request): View
    {
        $agents = Agent::orderBy('name', 'asc')->get();
        return view('general-member',['agents' => $agents]);
    }



    // Displaying contact page
    public function contact(Request $request): View
    {
        return view('contact');
    }
    // Displaying documentation page
    public function documentation(Request $request): View
    {
        return view('documentation');
    }


    // Displaying my agency page
    public function myagency(Request $request): View
    {
        // $agent = Agent::with('donations')->find(auth()->user()->agency->id);

        // if (!$agent) {
        //     abort(404, 'Agency not found');
        // }

        // // Information completion percentage
        // $attributes = $agent->getAttributes();
        // $filledColumns = collect($attributes)->filter(fn($value) => !is_null($value) && $value !== '')->count();
        // $completionPercentage = ($filledColumns / count($attributes)) * 100;

        // return view('myagency', [
        //     'agent' => $agent,
        //     'completionPercentage' => round($completionPercentage) // Round to the nearest whole number
        // ]);
        // ---------------------------------------
        $agent = Agent::with(['donations', 'custom_files' => function($query) {
            $query->orderBy('status', 'desc'); // This will show Unpaid first (alphabetically)
        }])->find(auth()->user()->agency->id);

        // Get unpaid files info
        $unpaidFiles = $agent->custom_files->where('status', 'Unpaid');
        $unpaidCount = $unpaidFiles->count();
        $unpaidTotal = $unpaidFiles->sum('fees');



        // Information completions percentage
        $attributes = $agent->toArray();
        $totalColumns = count($attributes);
        $filledColumns = collect($attributes)->filter(function ($value) {
            return !is_null($value) && $value !== '';
        })->count();
        $completionPercentage = ($filledColumns / $totalColumns) * 100;

        return view('admin.agents.show', [
            'agent' => $agent,
            'completionPercentage' => round($completionPercentage, 2),
            'unpaidCount' => $unpaidCount,
            'unpaidTotal' => $unpaidTotal,
        ]);
    }




    public function expresidents(Request $request): View
    {
        $advisories = AdvisoryCommittee::where('active', true)->where('type','Ex-President')->orderBy('order')->get();
        return view('expresidents', ['advisories' => $advisories]);
    }
    public function exgsecratary(Request $request): View
    {
        $advisories = AdvisoryCommittee::where('active', true)->where('type','Ex-General Secretary')->orderBy('order')->get();
        return view('exgsecratary', ['advisories' => $advisories]);
    }
    public function electioncommittee(Request $request): View
    {
        $advisories = AdvisoryCommittee::where('active', true)->where('type','Election Committee')->orderBy('order')->get();
        return view('electioncommittee', ['advisories' => $advisories]);
    }
    public function internalaidcommittee(Request $request): View
    {
        $advisories = AdvisoryCommittee::where('active', true)->where('type','Internal Audit Committee')->orderBy('order')->get();
        return view('internalaidcommittee', ['advisories' => $advisories]);
    }


    /**
     * Display list of sample application files
     */
    public function sample_application(): View
    {
        $path = public_path('application_sample');

        // Check if directory exists
        if (!is_dir($path)) {
            return view('application_sample', [
                'files' => [],
                'error' => 'Sample application directory not found'
            ]);
        }

        // Get all files from the directory
        $files = collect(scandir($path))
            ->reject(function ($file) {
                // Remove . and .. directory entries and hidden files
                return in_array($file, ['.', '..']) || substr($file, 0, 1) === '.';
            })
            ->map(function ($file) {
                return [
                    'name' => pathinfo($file, PATHINFO_FILENAME),
                    'extension' => pathinfo($file, PATHINFO_EXTENSION),
                    'size' => filesize(public_path("application_sample/$file")),
                    'last_modified' => filemtime(public_path("application_sample/$file")),
                    'path' => asset("application_sample/$file")
                ];
            })
            ->values();

        return view('application_sample', [
            'files' => $files
        ]);
    }
    /**
     * Display list of application_form files
     */
    public function forms(): View
    {
        $path = public_path('application_form');

        // Check if directory exists
        if (!is_dir($path)) {
            return view('application_form', [
                'files' => [],
                'error' => 'Sample application directory not found'
            ]);
        }

        // Get all files from the directory
        $files = collect(scandir($path))
            ->reject(function ($file) {
                // Remove . and .. directory entries and hidden files
                return in_array($file, ['.', '..']) || substr($file, 0, 1) === '.';
            })
            ->map(function ($file) {
                return [
                    'name' => pathinfo($file, PATHINFO_FILENAME),
                    'extension' => pathinfo($file, PATHINFO_EXTENSION),
                    'size' => filesize(public_path("application_form/$file")),
                    'last_modified' => filemtime(public_path("application_form/$file")),
                    'path' => asset("application_form/$file")
                ];
            })
            ->values();

        return view('application_form', [
            'files' => $files
        ]);
    }




}
