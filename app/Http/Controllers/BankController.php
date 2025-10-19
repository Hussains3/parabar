<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return Datatables::of(Bank::query())->make(true);
        }
        return view('admin.banks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankRequest $request)
    {
        $bank = Bank::create(['name' => $request->name]);
        return response()->json(['success' => 'Bank Created!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $bank = Bank::with('accounts')->find($id);
        return view('admin.banks.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:banks,name,' . $bank->id,
        ]);

        $bank->update($request->all());
        return redirect()->route('banks.index')->with('success', 'Bank updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();

        return response()->json(['success' => 'Bank deleted !']);
    }
}
