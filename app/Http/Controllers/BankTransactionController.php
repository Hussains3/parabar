<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\BankTransaction;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreBankTransactionRequest;
use App\Http\Requests\UpdateBankTransactionRequest;

class BankTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(BankTransaction::with('bankAccount')
            ->orderBy('transaction_date', 'DESC')
            )->make(true);
        }

        $bankAccounts = BankAccount::all();
        return view('admin.transactions.index', ['bankAccounts' => $bankAccounts]);
    }


    /**
     * Display a listing of the resource.
     */
    public function deposit(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(BankTransaction::with('bankAccount')
            ->where('type', 'deposit')
            ->orderBy('transaction_date', 'DESC')
            )->make(true);
        }

        $bankAccounts = BankAccount::all();
        return view('admin.transactions.deposit', ['bankAccounts' => $bankAccounts]);
    }


    /**
     * Display a listing of the resource.
     */
    public function withdrawal(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(BankTransaction::with('bankAccount')
            ->where('type', 'withdrawal')
            ->orderBy('transaction_date', 'DESC')
            )->make(true);
        }

        $bankAccounts = BankAccount::all();
        return view('admin.transactions.withdrawal', ['bankAccounts' => $bankAccounts]);
    }

    /**
     * Display a listing of the resource.
     */
    public function trash(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(BankTransaction::with('bankAccount')
            ->onlyTrashed()
            ->orderBy('transaction_date', 'DESC')
            )->make(true);
        }

        $bankAccounts = BankAccount::all();
        return view('admin.transactions.trash', ['bankAccounts' => $bankAccounts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bankAccounts = BankAccount::all();
        return view('transactions.create', compact('bankAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'txn_number' => 'required|string|unique:bank_transactions,txn_number',
            'type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        BankTransaction::create($request->all());
        return response()->json(['success' => 'Transaction created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(BankTransaction $bankTransaction)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankTransaction $bankTransaction)
    {
        $bankAccounts = BankAccount::all();
        return view('transactions.edit', compact('transaction', 'bankAccounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankTransactionRequest $request, BankTransaction $bankTransaction)
    {
        $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'txn_number' => 'required|string|unique:bank_transactions,txn_number,' . $transaction->id,
            'type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index') ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = BankTransaction::findOrFail($id);
        $transaction->delete(); // Soft delete the transaction
        return response()->json(['success' => 'Transaction deleted successfully.']);
    }


    /**
     * Restore a soft-deleted transaction.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $transaction = BankTransaction::withTrashed()->findOrFail($id);
        $transaction->restore();
        return response()->json(['success' => 'Transaction restored successfully.']);
    }

    /**
     * Permanently delete a soft-deleted transaction.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        $transaction = BankTransaction::withTrashed()->findOrFail($id);
        $transaction->forceDelete();
        return response()->json(['success' => 'Transaction permanently deleted.']);
    }

}
