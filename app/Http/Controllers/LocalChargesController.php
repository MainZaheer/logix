<?php

namespace App\Http\Controllers;

use App\Models\LocalCharges;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class LocalChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         if (request()->ajax()) {
                $business_id = request()->session()->get('user.business_id');
            $data = LocalCharges::where('business_id', $business_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactive</span>';
                    }

                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('localCharges.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('localCharges.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('localCharges.index');
    }
    /**
     * Display a listing of the resource.
     */
   public function create()
    {
        return view("localCharges.create_edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" =>'required|unique:local_charges',
            "description"=>'nullable',
        ]);
       $localCharges = $request->only('name', 'description');
    $localCharges['status'] = 'active';
    $localCharges['user_id'] = Auth::id();
     $localCharges['business_id'] = Auth::user()->business_id;

    LocalCharges::create($localCharges);

        return redirect()->route('localCharges.index')->with('success','local Charges created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $localCharges = LocalCharges::findOrFail($id);
        return view('localCharges.create_edit', compact('localCharges'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|unique:local_charges,name,' . $id,
            'description'=>'nullable',
        ]);

        $localCharges = LocalCharges::findOrFail($id);
        $localCharges->update($request->only('name','description','status'));
        return redirect()->route('localCharges.index')->with('success', 'local Charges updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $localCharges = LocalCharges::findOrFail($id);
        $localCharges->delete();
        return redirect()->route('localCharges.index')->with('success','local Charges Deleted successfully');
    }
}
