<?php

namespace App\Http\Controllers;

use App\Models\GatePass;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class GatePassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
             $business_id = request()->session()->get('user.business_id');

             $data = GatePass::where('business_id', $business_id)->get();
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
                    $btn = '<a href="' . route('gatepasses.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('gatepasses.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('gatepass.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gatepass.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:gate_passes',
            'description' => 'nullable',
        ]);

        $gatePass = $request->only(['name', 'description', 'status']);
         $gatePass['user_id'] = Auth::id();
    $gatePass['business_id'] = Auth::user()->business_id;


        GatePass::create($gatePass);

        return redirect()->route('gatepasses.index')->with('success', 'Gate Pass created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GatePass $gatePass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
             $business_id = request()->session()->get('user.business_id');
            $gatepass = GatePass::where('business_id' , $business_id)->findOrFail($id);
            return view('gatepass.create_edit', compact('gatepass'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:gate_passes,name,' . $id,
            'description' => 'nullable',
        ]);

        $gatePass = GatePass::findOrFail($id);

        $gatePass->update($request->only(['name', 'description', 'status']));

        return redirect()->route('gatepasses.index')->with('success', 'Gate Pass updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
            $business_id = request()->session()->get('user.business_id');
            $gatepass = GatePass::where('business_id' , $business_id)->findOrFail($id);
        $gatepass->delete();

        return redirect()->route('gatepasses.index')->with('success', 'Gate Pass deleted successfully.');
    }

}
