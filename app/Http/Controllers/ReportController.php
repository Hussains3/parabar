<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\Agent;
use App\Models\File_data;
use App\Models\User;
use App\Models\CustomFile;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Financial report Monthly
    public function financialMonth(Request $request){
        $targatedMonth = now()->month;
        if ($request->targatedMonth) {
            $targatedMonth = $request->targatedMonth;
        }

        if ($request->ajax()) {
            $bankTransactions = BankTransaction::with('bankAccount')->whereMonth('transaction_date', $targatedMonth)->orderBy('transaction_date', 'DESC');
            return Datatables::of($bankTransactions)->make(true);
        }
        $bankAccounts = BankAccount::all();
        return view('admin.reports.financialmonthly',['bankAccounts' => $bankAccounts,'thisMonth' => $targatedMonth]);
    }

    // Receiver report
    public function receiver_report(Request $request)
    {
        // Get all agents for the dropdown
        $agents = Agent::select('id', 'name', 'ain_no')->orderBy('name', 'asc')->get();

        if ($request->ajax()) {
            $file_datas = File_data::with('agent')
                ->with('ie_data');

            if (!empty($request->from_date)) {
                $startdate = $request->from_date;
                $enddate = $request->to_date;
                $query = 'date(created_at) between "' . $startdate . '" AND "' . $enddate . '"';

            }else {
                $query = 'date(created_at) = "' . now()->format('Y-m-d') . '"';
            }

            $file_datas->whereRaw($query);

            if (!empty($request->agent_id)) {
                $file_datas->where('agent_id', $request->agent_id);
            }

            return DataTables::of($file_datas)->make(true);
        }

        return view('admin.reports.receiver', ['agents' => $agents]);
    }

    // Deliver report
    public function deliver_report(Request $request)
    {
        $agents = Agent::select('id', 'name', 'ain_no')
            ->orderBy('name', 'asc')
            ->get();

        if ($request->ajax()) {
            $query = File_data::query()
                ->with(['agent:id,name,ain_no', 'ie_data:id,name'])
                ->select('file_datas.*')
                ->where('status', 'Printed');

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            }else {
                $query->whereDate('created_at', now());
            }

            if ($request->filled('agent_id')) {
                $query->where('agent_id', $request->agent_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('lodgement_date', function($row) {
                    return $row->lodgement_date ? date('d M Y', strtotime($row->lodgement_date)) : '';
                })
                ->editColumn('status', function($row) {
                    return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' .
                           ($row->status === 'Printed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') .
                           '">' . $row->status . '</span>';
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('admin.reports.deliverer', ['agents' => $agents]);
    }

    // Operator report
    public function operator_report(Request $request)
    {
        $users = User::role('operator')->get();

        if ($request->ajax()) {
            $query = File_data::query()
                ->select([
                    'deliverer_id',
                    DB::raw('COUNT(*) as total_files')
                ])
                ->whereNotNull('deliverer_id')
                ->with('deliverer:id,name');

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween(DB::raw('DATE(created_at)'), [
                    $request->from_date,
                    $request->to_date
                ]);
            }else {
                $query->whereDate('created_at', now());
            }

            if ($request->filled('deliverer_id')) {
                $query->where('deliverer_id', $request->deliverer_id);
            }

            $query->groupBy('deliverer_id');

            return DataTables::of($query)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.reports.operator', ['users' => $users]);
    }

    // Unpaid Customs File Report
    public function unpaid_report(Request $request)
    {
        // Get overall statistics
        $statistics = [
            'total_unpaid' => CustomFile::where('status', 'Unpaid')->count(),
            'total_unpaid_im' => CustomFile::where('status', 'Unpaid')->where('type', 'IM')->count(),
            'total_unpaid_ex' => CustomFile::where('status', 'Unpaid')->where('type', 'EX')->count(),
            'total_due' => CustomFile::where('status', 'Unpaid')->sum('fees'),
        ];

        if ($request->ajax()) {
            $query = Agent::query()
                ->select([
                    'agents.id',
                    'agents.name',
                    DB::raw('(SELECT COUNT(*) FROM custom_files WHERE custom_files.agent_id = agents.id AND status = "Unpaid" AND type = "IM") as unpaid_im_count'),
                    DB::raw('(SELECT COUNT(*) FROM custom_files WHERE custom_files.agent_id = agents.id AND status = "Unpaid" AND type = "EX") as unpaid_ex_count'),
                    DB::raw('(SELECT COUNT(*) FROM custom_files WHERE custom_files.agent_id = agents.id AND status = "Unpaid") as total_unpaid_count'),
                    DB::raw('(SELECT SUM(fees) FROM custom_files WHERE custom_files.agent_id = agents.id AND status = "Unpaid") as total_unpaid_amount')
                ])
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('custom_files')
                        ->whereColumn('custom_files.agent_id', 'agents.id')
                        ->where('status', 'Unpaid');
                });

            return DataTables::of($query)
                ->filterColumn('name', function($query, $keyword) {
                    $query->where('agents.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('unpaid_im_count', function($query, $keyword) {
                    $query->whereRaw('(SELECT COUNT(*) FROM custom_files WHERE custom_files.agent_id = agents.id AND status = "Unpaid" AND type = "IM") like ?', ["%{$keyword}%"]);
                })
                ->filterColumn('unpaid_ex_count', function($query, $keyword) {
                    $query->whereRaw('(SELECT COUNT(*) FROM custom_files WHERE custom_files.agent_id = agents.id AND status = "Unpaid" AND type = "EX") like ?', ["%{$keyword}%"]);
                })
                ->filterColumn('total_unpaid_count', function($query, $keyword) {
                    $query->whereRaw('(SELECT COUNT(*) FROM custom_files WHERE custom_files.agent_id = agents.id AND status = "Unpaid") like ?', ["%{$keyword}%"]);
                })
                ->filterColumn('total_unpaid_amount', function($query, $keyword) {
                    $query->whereRaw('(SELECT SUM(fees) FROM custom_files WHERE custom_files.agent_id = agents.id AND status = "Unpaid") like ?', ["%{$keyword}%"]);
                })
                ->addIndexColumn()
                ->editColumn('total_unpaid_amount', function($row) {
                    return '৳' . number_format($row->total_unpaid_amount ?? 0, 2);
                })
                ->editColumn('unpaid_im_count', function($row) {
                    return $row->unpaid_im_count ?? 0;
                })
                ->editColumn('unpaid_ex_count', function($row) {
                    return $row->unpaid_ex_count ?? 0;
                })
                ->editColumn('total_unpaid_count', function($row) {
                    return $row->total_unpaid_count ?? 0;
                })
                ->make(true);
        }

        return view('admin.reports.unpaid', compact('statistics'));
    }


    // Daily Paid Customs File Report
    public function paid_report(Request $request)
    {
        // Get the target date (today by default)
        $targetDate = $request->date ? date('Y-m-d', strtotime($request->date)) : date('Y-m-d');

        // Calculate statistics for the specified date
        $statistics = [
            'total_paid_im' => CustomFile::where('status', 'Paid')
                ->where('type', 'IM')
                ->whereDate('updated_at', $targetDate)
                ->sum('fees'),
            'total_paid_ex' => CustomFile::where('status', 'Paid')
                ->where('type', 'EX')
                ->whereDate('updated_at', $targetDate)
                ->sum('fees'),
            'total_paid_files' => CustomFile::where('status', 'Paid')
                ->whereDate('updated_at', $targetDate)
                ->count(),
            'total_paid_amount' => CustomFile::where('status', 'Paid')
                ->whereDate('updated_at', $targetDate)
                ->sum('fees')
        ];

        if ($request->ajax()) {
            $query = CustomFile::query()
                ->with('agent:id,name,ain_no')
                ->where('status', 'Paid')
                ->whereDate('updated_at', $targetDate);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('agent_name', function($row) {
                    return $row->agent ? $row->agent->name : 'N/A';
                })
                ->addColumn('agent_ain', function($row) {
                    return $row->agent ? $row->agent->ain_no : 'N/A';
                })
                ->editColumn('date', function($row) {
                    return $row->date ? date('d-M-Y', strtotime($row->date)) : 'N/A';
                })
                ->editColumn('fees', function($row) {
                    return '৳' . number_format($row->fees, 2);
                })
                ->editColumn('type', function($row) {
                    return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' .
                        ($row->type === 'IM' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') .
                        '">' . $row->type . '</span>';
                })
                ->rawColumns(['type'])
                ->make(true);
        }

        return view('admin.reports.paid', compact('statistics', 'targetDate'));
    }
}
