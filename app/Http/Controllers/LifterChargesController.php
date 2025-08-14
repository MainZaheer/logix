<?php

namespace App\Http\Controllers;

use App\Models\LifterCharges;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;


class LifterChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         if (request()->ajax()) {

                $business_id = request()->session()->get('user.business_id');

             $data = LifterCharges::where('business_id', $business_id)->get();
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
                    $btn = '<a href="' . route('lifterCharges.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('lifterCharges.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('lifterCharges.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("lifterCharges.create_edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" =>'required|unique:lifter_charges',
            "description"=>'nullable',
        ]);
       $lifterCharges = $request->only('name', 'description');
    $lifterCharges['status'] = 'active';
    $lifterCharges['user_id'] = Auth::id();
     $lifterCharges['business_id'] = Auth::user()->business_id;

    LifterCharges::create($lifterCharges);

        return redirect()->route('lifterCharges.index')->with('success','Lifter Charges created successfully');
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
        $lifterCharges = LifterCharges::findOrFail($id);
        return view('lifterCharges.create_edit', compact('lifterCharges'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|unique:lifter_charges,name,' . $id,
            'description'=>'nullable',
        ]);
        $business_id = request()->session()->get('user.business_id');
        $lifterCharges = LifterCharges::where('business_id' , $business_id)->findOrFail($id);
        $lifterCharges->update($request->only('name','description','status'));
        return redirect()->route('lifterCharges.index')->with('success', 'Lifter Charges updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $business_id = request()->session()->get('user.business_id');
        $lifterCharges = LifterCharges::where('business_id' , $business_id)->findOrFail($id);
        $lifterCharges->delete();
        return redirect()->route('lifterCharges.index')->with('success','Lifter Charges Deleted successfully');
    }
}
