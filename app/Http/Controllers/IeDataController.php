<?php

namespace App\Http\Controllers;

use App\Models\Ie_data;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreIe_dataRequest;
use App\Http\Requests\UpdateIe_dataRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class IeDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Ie_data::all())->make(true);
        }

        return view('admin.ie_datas.index');

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
    public function store(StoreIe_dataRequest $request)
    {
        $ie_data = new Ie_data();
        $ie_data->bin_no = $request->bin_no;
        $ie_data->ie = $request->ie;
        $ie_data->name = $request->name;
        $ie_data->owners_name = $request->owners_name;

        if ($request->hasFile('photo')) {
            $image = $request->photo;
            $ext = $image->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $request->photo->move(public_path('images'), $filename);
            $ie_data->photo = 'images/'.$filename;
        }

        $ie_data->destination = $request->destination;
        $ie_data->office_address = $request->office_address;
        $ie_data->phone = $request->phone;
        $ie_data->email = $request->email;
        $ie_data->house = $request->house;
        if ($request->note) {
            $ie_data->note = $request->note;
        }
        $ie_data->save();

        return response()->json(['success' => 'Added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ie_data $ie_data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ie_data = Ie_data::find($id);

        return view('admin.ie_datas.edit', compact('ie_data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIe_dataRequest $request, $id)
    {
        $ie_data = Ie_data::find($id);

        $ie_data->bin_no = $request->bin_no;
        $ie_data->ie = $request->ie;
        $ie_data->name = $request->name;
        $ie_data->owners_name = $request->owners_name;

        if ($request->hasFile('photo')) {
            $image = $request->photo;
            $ext = $image->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
             Storage::delete("images/{$ie_data->image}");
            $request->photo->move(public_path('images'), $filename);
            $ie_data->photo = 'images/'.$filename;
        }

        $ie_data->destination = $request->destination;
        $ie_data->office_address = $request->office_address;
        $ie_data->phone = $request->phone;
        $ie_data->email = $request->email;
        $ie_data->house = $request->house;
        if ($request->note) {
            $ie_data->note = $request->note;
        }
        $ie_data->save();


        return redirect()->route('ie_datas.index')->with(['status' => 200, 'message' => 'Importer / Exporter Update']);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $ie_data = Ie_data::find($id);
        // Delete old photo
        if ($ie_data->photo) {
            unlink($ie_data->photo);
        }
        $ie_data->delete();
        return response()->json(['success' => 'Deleted Successfully!']);
    }
}
