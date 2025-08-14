<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fuel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;


class FuelController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
             $business_id = request()->session()->get('user.business_id');

             $data = Fuel::where('business_id', $business_id)->get();
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
                    $btn = '<a href="' . route('fuels.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('fuels.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('fuels.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fuels.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:fuels',
            'description' => 'nullable',
        ]);

        $fuel = $request->only(['name', 'description', 'status']);
         $fuel['user_id'] = Auth::id();
    $fuel['business_id'] = Auth::user()->business_id;


        Fuel::create($fuel);

        return redirect()->route('fuels.index')->with('success', 'Fuel created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fuel $fuel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
             $business_id = request()->session()->get('user.business_id');
            $fuel = Fuel::where('business_id' , $business_id)->findOrFail($id);
            return view('fuels.create_edit', compact('fuel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:fuels,name,' . $id,
            'description' => 'nullable',
        ]);

        $fuel = Fuel::findOrFail($id);

        $fuel->update($request->only(['name', 'description', 'status']));

        return redirect()->route('fuels.index')->with('success', 'Fuel updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
            $business_id = request()->session()->get('user.business_id');
            $fuel = Fuel::where('business_id' , $business_id)->findOrFail($id);
            $fuel->delete();

        return redirect()->route('fuels.index')->with('success', 'Fuel deleted successfully.');
    }
}
