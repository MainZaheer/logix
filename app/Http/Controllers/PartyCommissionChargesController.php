<?php

namespace App\Http\Controllers;

use App\Models\PartyCommissionCharges;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PartyCommissionChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
         if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $data = PartyCommissionCharges::where('business_id', $business_id)->get();
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
                    $btn = '<a href="' . route('partyCommissionCharges.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('partyCommissionCharges.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('partyCommissionCharges.index');
    }
    /**
     * Display a listing of the resource.
     */
   public function create()
    {
        return view("partyCommissionCharges.create_edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" =>'required|unique:party_commission_charges',
            "description"=>'nullable',
        ]);
       $partyCommissionCharges = $request->only('name', 'description');
    $partyCommissionCharges['status'] = 'active';
    $partyCommissionCharges['user_id'] = Auth::id();
     $partyCommissionCharges['business_id'] = Auth::user()->business_id;

    PartyCommissionCharges::create($partyCommissionCharges);

        return redirect()->route('partyCommissionCharges.index')->with('success','partyCommission Charges created successfully');
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
        $partyCommissionCharges = PartyCommissionCharges::findOrFail($id);
        return view('partyCommissionCharges.create_edit', compact('partyCommissionCharges'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|unique:party_commission_charges,name,' . $id,
            'description'=>'nullable',
        ]);

        $partyCommissionCharges = PartyCommissionCharges::findOrFail($id);
        $partyCommissionCharges->update($request->only('name','description','status'));
        return redirect()->route('partyCommissionCharges.index')->with('success', 'partyCommission Charges updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $partyCommissionCharges = PartyCommissionCharges::findOrFail($id);
        $partyCommissionCharges->delete();
        return redirect()->route('partyCommissionCharges.index')->with('success','partyCommission Charges Deleted successfully');
    }
}
