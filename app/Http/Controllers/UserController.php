<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Business;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\WhatsAppWelcomeNotification;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{

    // dd($request->all());

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'business_name' => 'required|string|max:255',
        'city'=> 'nullable',
        'state' => 'nullable',
        'country'=>'nullable',
    ]);

    try {
        DB::beginTransaction();


        $business = new Business();
        $business->name = $request->input('business_name');
        $business->city = $request->input('city');
        $business->state = $request->input('state');
        $business->country = $request->input('country');
        $business->start_date = now();
        $business->save();


        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->business_id = $business->id;
        $user->save();

        // $customer->notify(new WhatsAppWelcomeNotification($user));
        DB::commit();


        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with(['error' => 'Registration failed.']);
    }
}

    /**
     * Display the specified resource.
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function authenticate(Request $request)
    {
        // Validate the request data
      $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Login successful.');
        }

        return redirect()->back()->with(['error' => 'Invalid credentials.']);
    }

    /**
     * Update the specified resource in storage.
     */
        public function logout()
        {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Logout successful.');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
