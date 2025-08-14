<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
        $contacts = Contact::where('business_id', $business_id)->get();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'nullable|email|max:50',
            'type'    => 'required|in:recipient,sender',
            'phone'   => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'state'   => 'nullable|string|max:100',
            'city'    => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'zip'     => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['business_id'] = Auth::user()->business_id;

        Contact::create($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $business_id = request()->session()->get('user.business_id');
        $contact = Contact::where('business_id' , $business_id)->findOrFail($id);
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $business_id = request()->session()->get('user.business_id');
        $contact = Contact::where('business_id' , $business_id)->findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'nullable|email|max:50',
            'type' => 'required|in:recipient,sender',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $contact->update($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $business_id = request()->session()->get('user.business_id');
        $contact = Contact::where('business_id' , $business_id)->findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}
