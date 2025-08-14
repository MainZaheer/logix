<?php

namespace App\Http\Controllers;

use App\Models\ClearingAgent;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ClearingAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $data = ClearingAgent::where('business_id', $business_id)->get();
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
                    $btn = '<a href="' . route('clearingagents.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('clearingagents.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('cleaningagent.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cleaningagent.create_edit');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:clearing_agents',
            'description' => 'nullable',
        ]);

        $ClearingAgent = $request->only(['name', 'description', 'status']);
        $ClearingAgent['user_id'] = Auth::id();
        $ClearingAgent['business_id'] = Auth::user()->business_id;


        ClearingAgent::create($ClearingAgent);

        return redirect()->route('clearingagents.index')->with('success', 'Cleaning Agent created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClearingAgent $clearingAgent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $business_id = request()->session()->get('user.business_id');
        $acg = ClearingAgent::where('business_id', $business_id)->findOrFail($id);
        return view('cleaningagent.create_edit', compact('acg'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:clearing_agents,name,' . $id,
            'description' => 'nullable',
        ]);

        $ClearingAgent = ClearingAgent::findOrFail($id);

        $ClearingAgent->update($request->only(['name', 'description', 'status']));

        return redirect()->route('clearingagents.index')->with('success', 'Cleaning Agent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $business_id = request()->session()->get('user.business_id');
        $ClearingAgent = ClearingAgent::where('business_id', $business_id)->findOrFail($id);

        $ClearingAgent->delete();

        return redirect()->route('clearingagents.index')->with('success', 'Cleaning Agent deleted successfully.');
    }
}
