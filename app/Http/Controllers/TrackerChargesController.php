<?php

namespace App\Http\Controllers;

use App\Models\TrackerCharges;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class TrackerChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
         if (request()->ajax()) {
                $business_id = request()->session()->get('user.business_id');
            $data = TrackerCharges::where('business_id',$business_id)->get();
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
                    $btn = '<a href="' . route('trackerCharges.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('trackerCharges.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('trackerCharges.index');
    }
    /**
     * Display a listing of the resource.
     */
   public function create()
    {
        return view("trackerCharges.create_edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" =>'required|unique:tracker_charges',
            "description"=>'nullable',
        ]);
       $trackerCharges = $request->only('name', 'description');
    $trackerCharges['status'] = 'active';
    $trackerCharges['user_id'] = Auth::id();
     $trackerCharges['business_id'] = Auth::user()->business_id;

    TrackerCharges::create($trackerCharges);

        return redirect()->route('trackerCharges.index')->with('success','tracker Charges created successfully');
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
        $trackerCharges = TrackerCharges::findOrFail($id);
        return view('trackerCharges.create_edit', compact('trackerCharges'));
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

        $trackerCharges = TrackerCharges::findOrFail($id);
        $trackerCharges->update($request->only('name','description','status'));
        return redirect()->route('trackerCharges.index')->with('success', 'local Charges updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $trackerCharges = TrackerCharges::findOrFail($id);
        $trackerCharges->delete();
        return redirect()->route('trackerCharges.index')->with('success','tracker Charges Deleted successfully');
    }
}
