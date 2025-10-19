<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreBankAccountRequest;
use App\Http\Requests\UpdateBankAccountRequest;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return Datatables::of(BankAccount::query())
            ->addColumn('bank_name', function ($query){
                return $query->bank->name;
            })
            ->rawColumns(['bank_name'])
            ->make(true);
        }


        $banks = Bank::all();
        return view('admin.baccounts.index',['banks' => $banks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankAccountRequest $request)
    {
        BankAccount::create($request->all());
        return response()->json(['success' => 'Bank account created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bankAccount = BankAccount::with('transactions')->find($id);
        return view('admin.baccounts.show', ['bankAccount'=>$bankAccount]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bankAccount = BankAccount::find($id);
        $banks = Bank::all();

        return view('admin.baccounts.edit',['banks' => $banks,'bankAccount'=>$bankAccount]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $bankAccount = BankAccount::find($id);
        $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'account_number' => 'required|string|unique:bank_accounts,account_number,' . $bankAccount->id,
            'account_holder_name' => 'nullable|string|max:255',
            'balance' => 'nullable|numeric|min:0',
        ]);

        $bankAccount->update($request->all());
        return redirect()->route('baccounts.show', $bankAccount->id)->with(['status' => 200, 'message' => 'Bank account updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankAccount $bankAccount)
    {
        //
    }
}
