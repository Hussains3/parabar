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
     * Get all importers/exporters with unpaid actual_total
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getUnpaidFiles(Request $request)
    {
        $ie_datas = Ie_data::whereHas('file_datas', function($query) {
            $query->where('actual_total', '>', 0);
        })
        ->with(['file_datas' => function($query) {
            $query->where('actual_total', '>', 0);
        }])
        ->get();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $ie_datas
            ]);
        }

        return view('admin.ie_datas.unpaid', compact('ie_datas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ie_datas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIe_dataRequest $request)
    {
        $ie_data = new Ie_data();
        $ie_data->org_name = $request->org_name;
        if ($request->hasFile('org_logo')) {
            $image = $request->org_logo;
            $ext = $image->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $request->org_logo->move(public_path('images'), $filename);
            $ie_data->org_logo = 'images/'.$filename;
        }
        $ie_data->bin_no = $request->bin_no;
        $ie_data->tin_no = $request->tin_no;
        $ie_data->name = $request->name;
        $ie_data->fax_telephone = $request->fax_telephone;
        $ie_data->phone_primary = $request->phone_primary;
        $ie_data->phone_secondary = $request->phone_secondary;
        $ie_data->whatsapp = $request->whatsapp;
        $ie_data->email_primary = $request->email_primary;
        $ie_data->email_secondary = $request->email_secondary;
        $ie_data->house_distric = $request->house_distric;
        $ie_data->address = $request->address;
        $ie_data->post = $request->post;
        $ie_data->save();

        return redirect()->route('ie_datas.index')->with(['status' => 200, 'message' => 'Importer / Exporter Created']);

    }

    /**
     * Display the specified resource.
     */
    public function show(Ie_data $ie_data)
    {
        $ie_data->load(['file_datas' => function($query) {
            $query->orderByRaw("CASE
                WHEN status = 'Unpaid' AND actual_total > 0 THEN 1
                ELSE 2
            END")
            ->orderBy('created_at', 'desc');
        }]);
        return view('admin.ie_datas.show', compact('ie_data'));
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
        $ie_data = Ie_data::findOrFail($id);

        $ie_data = new Ie_data();


        $ie_data->org_name = $request->org_name;
        if ($request->hasFile('org_logo')) {
            $image = $request->org_logo;
            $ext = $image->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            Storage::delete("images/{$ie_data->image}");
            $request->org_logo->move(public_path('images'), $filename);
            $ie_data->org_logo = 'images/'.$filename;
        }
        $ie_data->bin_no = $request->bin_no;
        $ie_data->tin_no = $request->tin_no;
        $ie_data->name = $request->name;
        $ie_data->fax_telephone = $request->fax_telephone;
        $ie_data->phone_primary = $request->phone_primary;
        $ie_data->phone_secondary = $request->phone_secondary;
        $ie_data->whatsapp = $request->whatsapp;
        $ie_data->email_primary = $request->email_primary;
        $ie_data->email_secondary = $request->email_secondary;
        $ie_data->house_distric = $request->house_distric;
        $ie_data->address = $request->address;
        $ie_data->post = $request->post;
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
