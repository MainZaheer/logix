<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BrokerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $business_id = $request->session()->get('user.business_id');
            $data = Broker::where('business_id', $business_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('brokers.edit', $row->id) . '" class="edit btn btn-primary btn-sm">
                            <i class = "fa fa-edit"></i></a>';
                    $btn .= ' <form action="' . route('brokers.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm delete-btn"><i class="fa fa-trash"></i></button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('brokers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brokers.create_or_update');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:brokers',
            'phone' => 'required|string|max:15',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $broker = new Broker();
            $broker->name = $request->input('name');
            $broker->email = $request->input('email');
            $broker->phone = $request->input('phone');
            $broker->state = $request->input('state');
            $broker->country = $request->input('country');
            $broker->city = $request->input('city');
            $broker->address = $request->input('address');
            $broker->zip = $request->input('zip');
            $broker->business_id = Auth::user()->business_id;
            $broker->user_id = Auth::id();
            $broker->save();
            DB::commit();
            return redirect()->route('brokers.index')->with('success', 'Broker created successfully.');
            // return response()->json(['success' => true, 'message' => 'Broker created successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            // return response()->json(['error' => 'Something went wrong.']);

            return redirect()->back()->with(['error' => 'Something went wrong.']);
        }
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

        $broker = Broker::where('business_id',  $business_id)->findOrFail($id);

        return view('brokers.create_or_update', compact('broker'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:brokers,email,' . $id,
            'phone' => 'required|string|max:15',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        try {
            $broker = Broker::find($id);
            $broker->name = $request->input('name');
            $broker->email = $request->input('email');
            $broker->phone = $request->input('phone');
            $broker->state = $request->input('state');
            $broker->country = $request->input('country');
            $broker->city = $request->input('city');
            $broker->address = $request->input('address');
            $broker->zip = $request->input('zip');
            $broker->save();

            return redirect()->route('brokers.index')->with('success', 'Broker Update successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $business_id = request()->session()->get('user.business_id');

        $brokers = Broker::where('business_id', $business_id)->find($id)->delete();

        return redirect()->route('brokers.index')->with('success', 'Broker Delete successfully.');
    }
}
