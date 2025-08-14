<?php

namespace App\Http\Controllers;

use App\Models\Goodownrent;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class GoodownRentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
         if (request()->ajax()) {
               $business_id = request()->session()->get('user.business_id');
            $data = Goodownrent::where('business_id', $business_id)->get();
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
                    $btn = '<a href="' . route('goodownRent.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('goodownRent.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status'])
                ->make(true);
        }

        return view('goodownRent.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("goodownRent.create_edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" =>'required|unique:goodownrents',
            "description"=>'nullable',
        ]);
       $goodownRent = $request->only('name', 'description');
    $goodownRent['status'] = 'active';
    $goodownRent['user_id'] = Auth::id();
     $goodownRent['business_id'] = Auth::user()->business_id;

    Goodownrent::create($goodownRent);

        return redirect()->route('goodownRent.index')->with('success','Goodown Rent created successfully');
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
        $goodownRent = Goodownrent::findOrFail($id);
        return view('goodownRent.create_edit', compact('goodownRent'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|unique:goodownrents,name,' . $id,
            'description'=>'nullable',
        ]);

        $goodownRent = goodownRent::findOrFail($id);
        $goodownRent->update($request->only('name','description','status'));
        return redirect()->route('goodownRent.index')->with('success', 'goodown Rent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
            $business_id = request()->session()->get('user.business_id');
        $goodownRent = Goodownrent::where('business_id' , $business_id)->findOrFail($id);
        $goodownRent->delete();
        return redirect()->route('goodownRent.index')->with('success','goodown Rent Deleted successfully');
    }


}
