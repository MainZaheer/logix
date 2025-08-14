<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $business = Business::where('id', $user->business_id)->first();
        return view('profile.index', compact('user', 'business'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profileUpdate(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);
        // Update the user's profile
        try {

            $business_id = request()->session()->get('user.business_id');
            $userId = request()->session()->get('user.id');

            $user = User::where('id', $userId)->where('business_id', $business_id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $business = Business::where('id', $business_id)->first();
            $business->city = $request->city;
            $business->state = $request->state;
            $business->country = $request->country;
            $business->save();

            Db::commit();
            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Db::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function changePasswordForm()
    {
            return view('profile.change_password');
    }

    /**
     * Display the specified resource.
     */
    public function changePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8|same:new_password',

        ]);

        $user = Auth::user();

        // Check if the current password is correct
        if(Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
