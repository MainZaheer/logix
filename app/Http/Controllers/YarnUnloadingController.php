<?php

namespace App\Http\Controllers;

use App\Models\YarnUnloading;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class YarnUnloadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         if (request()->ajax()) {
                $business_id = request()->session()->get('user.business_id');
            $data = YarnUnloading::where('business_id',$business_id)->get();
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
                    $btn = '<a href="' . route('yarnUnloading.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('yarnUnloading.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('yarnUnloading.index');
    }
    /**
     * Display a listing of the resource.
     */
   public function create()
    {
        return view("yarnUnloading.create_edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" =>'required|unique:yarn_unloadings',
            "description"=>'nullable',
        ]);
       $yarnUnloading = $request->only('name', 'description');
    $yarnUnloading['status'] = 'active';
    $yarnUnloading['user_id'] = Auth::id();
     $yarnUnloading['business_id'] = Auth::user()->business_id;

    YarnUnloading::create($yarnUnloading);

        return redirect()->route('yarnUnloading.index')->with('success','Yarn Unloading created successfully');
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
        $yarnUnloading = YarnUnloading::findOrFail($id);
        return view('yarnUnloading.create_edit', compact('yarnUnloading'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|unique:yarn_unloadings,name,' . $id,
            'description'=>'nullable',
        ]);

        $yarnUnloading = YarnUnloading::findOrFail($id);
        $yarnUnloading->update($request->only('name','description','status'));
        return redirect()->route('yarnUnloading.index')->with('success', 'Yarn Unloading updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $yarnUnloading = YarnUnloading::findOrFail($id);
        $yarnUnloading->delete();
        return redirect()->route('yarnUnloading.index')->with('success','Yarn Unloading Deleted successfully');
    }
}
