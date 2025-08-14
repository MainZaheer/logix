<?php

namespace App\Http\Controllers;

use App\Models\LabourCharges;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class LabourChargesController extends Controller
{


      public function index()
    {
         if (request()->ajax()) {
                $business_id = request()->session()->get('user.business_id');
             $data = LabourCharges::where('business_id', $business_id)->get();
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
                    $btn = '<a href="' . route('labourCharges.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('labourCharges.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('labourCharges.index');
    }
    /**
     * Display a listing of the resource.
     */
   public function create()
    {
        return view("labourCharges.create_edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" =>'required|unique:labour_charges',
            "description"=>'nullable',
        ]);
       $labourCharges = $request->only('name', 'description');
    $labourCharges['status'] = 'active';
    $labourCharges['user_id'] = Auth::id();
     $labourCharges['business_id'] = Auth::user()->business_id;

    LabourCharges::create($labourCharges);

        return redirect()->route('labourCharges.index')->with('success','labour Charges created successfully');
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
        $labourCharges = LabourCharges::findOrFail($id);
        return view('labourCharges.create_edit', compact('labourCharges'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|unique:labour_charges,name,' . $id,
            'description'=>'nullable',
        ]);

        $labourCharges = labourCharges::findOrFail($id);
        $labourCharges->update($request->only('name','description','status'));
        return redirect()->route('labourCharges.index')->with('success', 'labourCharges updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
            $business_id = request()->session()->get('user.business_id');
        $labourCharges = LabourCharges::where('business_id' , $business_id)->findOrFail($id);
        $labourCharges->delete();
        return redirect()->route('labourCharges.index')->with('success','labour Charges Deleted successfully');
    }
}
