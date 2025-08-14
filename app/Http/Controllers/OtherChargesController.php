<?php

namespace App\Http\Controllers;

use App\Models\OtherCharges;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class OtherChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         if (request()->ajax()) {
                $business_id = request()->session()->get('user.business_id');
             $data = OtherCharges::where('business_id', $business_id)->get();
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
                    $btn = '<a href="' . route('otherCharges.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('otherCharges.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('otherCharges.index');
    }
    /**
     * Display a listing of the resource.
     */
   public function create()
    {
        return view("otherCharges.create_edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" =>'required|unique:other_charges',
            "description"=>'nullable',
        ]);
       $otherCharges = $request->only('name', 'description');
    $otherCharges['status'] = 'active';
    $otherCharges['user_id'] = Auth::id();
     $otherCharges['business_id'] = Auth::user()->business_id;

    OtherCharges::create($otherCharges);

        return redirect()->route('otherCharges.index')->with('success','other Charges created successfully');
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
        $otherCharges = OtherCharges::findOrFail($id);
        return view('otherCharges.create_edit', compact('otherCharges'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|unique:other_charges,name,' . $id,
            'description'=>'nullable',
        ]);

        $otherCharges = OtherCharges::findOrFail($id);
        $otherCharges->update($request->only('name','description','status'));
        return redirect()->route('otherCharges.index')->with('success', 'Other Charges updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $otherCharges = OtherCharges::findOrFail($id);
        $otherCharges->delete();
        return redirect()->route('otherCharges.index')->with('success','other Charges Deleted successfully');
    }
}
