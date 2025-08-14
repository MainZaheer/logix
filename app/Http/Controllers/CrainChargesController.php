<?php

namespace App\Http\Controllers;

use App\Models\CrainCharges;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class CrainChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
         if (request()->ajax()) {
                $business_id = request()->session()->get('user.business_id');
             $data = CrainCharges::where('business_id', $business_id)->get();
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
                    $btn = '<a href="' . route('crainCharges.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('crainCharges.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('crainCharges.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("crainCharges.create_edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" =>'required|unique:crain_charges',
            "description"=>'nullable',
        ]);
       $crainCharges = $request->only('name', 'description');
    $crainCharges['status'] = 'active';
    $crainCharges['user_id'] = Auth::id();
    $crainCharges['business_id'] = Auth::user()->business_id;

    CrainCharges::create($crainCharges);

        return redirect()->route('crainCharges.index')->with('success','Crain Charges created successfully');
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
                $business_id = request()->session()->get('user.business_id');

                $crainCharges = CrainCharges::where('business_id', $business_id)->findOrFail($id);
                return view('crainCharges.create_edit', compact('crainCharges'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|unique:crain_charges,name,' . $id,
            'description'=>'nullable',
        ]);

        $crainCharges = CrainCharges::findOrFail($id);
        $crainCharges->update($request->only('name','description','status'));
        return redirect()->route('crainCharges.index')->with('success', 'Crain Charges updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $business_id = request()->session()->get('user.business_id');

        $crainCharges = CrainCharges::where('business_id', $business_id)->findOrFail($id);
        $crainCharges->delete();
        return redirect()->route('crainCharges.index')->with('success','Crain Charges Deleted successfully');
    }
}
