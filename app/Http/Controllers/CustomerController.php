<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
             $business_id = request()->session()->get('user.business_id');

             $data = Customer::where('business_id', $business_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactive</span>';
                    }

                })

                ->addColumn('name', function ($row) {

                        return $row->first_name." ".$row->last_name;
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('customers.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('customers.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action' , 'status' , 'name'])
                ->make(true);
        }

        return view('customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        return view('customer.create_edit');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $cus = new Customer();
            $cus->first_name = $request->input('first_name');
            $cus->last_name = $request->input('last_name');
            $cus->email = $request->input('email');
            $cus->phone = $request->input('phone');
            $cus->status = $request->input('status');
            $cus->business_id = Auth::user()->business_id;
            $cus->save();
            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Something went wrong.']);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
            $business_id = request()->session()->get('user.business_id');
            $customer = Customer::where('business_id' , $business_id)->findOrFail($customer->id);
            return view('customer.create_edit', compact('customer'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // dd($customer);
      $cus =  $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'phone' => 'nullable|max:15',
            'email' => 'required|unique:customers,email,' . $customer->id,
            'status' => 'required'
        ]);

            $business_id = request()->session()->get('user.business_id');
            $cus['business_id'] =  $business_id;
            $customer->update($cus);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
           $customer->delete();
           return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
