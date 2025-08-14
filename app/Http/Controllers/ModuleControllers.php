<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use App\Models\ClearingAgent;
use App\Models\Contact;
use App\Models\CrainCharges;
use App\Models\GatePass;
use App\Models\Customer;
use App\Models\Goodownrent;
use App\Models\LabourCharges;
use App\Models\LifterCharges;
use App\Models\LocalCharges;
use App\Models\OtherCharges;
use App\Models\PartyCommissionCharges;
use App\Models\TrackerCharges;
use App\Models\YarnUnloading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ModuleControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function brokerModule(Request $request)
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

            $data = [
                'success' => true,
                'message' => 'Broker created successfully.',
                'broker' => $broker
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function gatePassModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:gate_passes',
            'description' => 'nullable',
        ]);

        try {
            DB::beginTransaction();
            $gatePass = $request->only(['name', 'description', 'status']);
             $gatePass['user_id'] = Auth::id();
            $gatePass['business_id'] = Auth::user()->business_id;
            $gp = GatePass::create($gatePass);
            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Gate Pass created successfully.',
                'gatePass' => $gp
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function clearingAgentModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:clearing_agents',
            'description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $ClearingAgent = $request->only(['name', 'description', 'status']);
             $ClearingAgent['user_id'] = Auth::id();
             $ClearingAgent['business_id'] = Auth::user()->business_id;

            $ca = ClearingAgent::create($ClearingAgent);
            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Agent created successfully.',
                'ca' => $ca
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }





    public function labourChargesModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:labour_charges',
            'description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $labourCharges= $request->only('name', 'description');
            $labourCharges['status'] = 'active';
            $labourCharges['user_id'] = Auth::id();
            $labourCharges['business_id'] = Auth::user()->business_id;

            $lc = LabourCharges::create($labourCharges);
            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Labour Charges created successfully.',
                'lc' => $lc
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }



      public function lifterChargesModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:lifter_charges',
            'description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $lifterCharges= $request->only('name', 'description');
            $lifterCharges['status'] = 'active';
            $lifterCharges['user_id'] = Auth::id();
            $lifterCharges['business_id'] = Auth::user()->business_id;

            $lif = LifterCharges::create($lifterCharges);
            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Lifter Charges created successfully.',
                'lif' => $lif
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }







     public function localChargesModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:local_charges',
            'description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $localCharges= $request->only('name', 'description');
            $localCharges['status'] = 'active';
            $localCharges['user_id'] = Auth::id();
            $localCharges['business_id'] = Auth::user()->business_id;

            $localc = LocalCharges::create($localCharges);
            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Local Charges created successfully.',
                'localc' => $localc
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }

     public function otherChargesModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:other_charges',
            'description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $otherCharges= $request->only('name', 'description');
            $otherCharges['status'] = 'active';
            $otherCharges['user_id'] = Auth::id();
            $otherCharges['business_id'] = Auth::user()->business_id;

            $otherc = OtherCharges::create($otherCharges);
            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Other Charges created successfully.',
                'otherc' => $otherc
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }


      public function trackerChargesModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tracker_charges',
            'description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $trackerCharges= $request->only('name', 'description');
            $trackerCharges['status'] = 'active';
            $trackerCharges['user_id'] = Auth::id();
            $trackerCharges['business_id'] = Auth::user()->business_id;

            $tracker = TrackerCharges::create($trackerCharges);
            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Tracker Charges created successfully.',
                'tracker' => $tracker
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }





    public function partyCommisionChargesModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:party_commission_charges',
            'description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $partyCommisionCharges= $request->only('name', 'description');
            $partyCommisionCharges['status'] = 'active';
            $partyCommisionCharges['user_id'] = Auth::id();
            $partyCommisionCharges['business_id'] = Auth::user()->business_id;

            $party = PartyCommissionCharges::create($partyCommisionCharges);
            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Party Commission Charges created successfully.',
                'party' => $party
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function sendarModule(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:50',
            'email'   => 'nullable|email|max:50',
            'phone'   => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'state'   => 'nullable|string|max:100',
            'city'    => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'zip'     => 'nullable|string|max:20',
            'status'  => 'required|in:active,inactive',
        ]);


        try {
            DB::beginTransaction();
            $validated['type'] = 'sender';
             $validated['user_id'] = Auth::id();
            $validated['business_id'] = Auth::user()->business_id;
            $sendar = Contact::create($validated);
            DB::commit();

            $data = [
                'success' => true,
                'message' => 'Sendar created successfully.',
                'sendar'      => $sendar
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function recipientModule(Request $request)
    {
        $validated = $request->validate([
             'name'    => 'required|string|max:50',
            'email'   => 'nullable|email|max:50',
            'phone'   => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'state'   => 'nullable|string|max:100',
            'city'    => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'zip'     => 'nullable|string|max:20',
        ]);


        try {
            DB::beginTransaction();
            $validated['type'] = 'recipient';

            $validated['user_id'] = Auth::id();
            $validated['business_id'] = Auth::user()->business_id;
            $recipient = Contact::create($validated);
            DB::commit();

            $data = [
                'success' => true,
                'message' => 'Recipient created successfully.',
                'recipient'      => $recipient
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function customerModule(Request $request)
    {
         $validated = $request->validate([
            'first_name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email',
            'phone'   => 'nullable|string|max:20',
            'last_name' => 'nullable|string|max:100',
            'status'  => 'required|in:active,inactive',
        ]);


        try {
            DB::beginTransaction();
            $validated['business_id'] = Auth::user()->business_id;
            $cus = Customer::create($validated);
            DB::commit();

            $data = [
                'success' => true,
                'message' => 'Customer created successfully.',
                'cus'      => $cus
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
