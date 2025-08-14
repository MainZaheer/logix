<?php

namespace App\Http\Controllers;

use App\Http\Requests\LegderRequest;
use App\Models\Account;
use App\Models\Broker;
use App\Models\ClearingAgent;
use App\Models\Customer;
use App\Models\GatePass;
use App\Models\LabourCharges;
use App\Models\LifterCharges;
use App\Models\LocalCharges;
use App\Models\OtherCharges;
use App\Models\PartyCommissionCharges;
use App\Models\Shipping;
use App\Models\TrackerCharges;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $business_id = $request->session()->get('user.business_id');
        $type = $request->type;
        $type_id = $request->type_id;
        $ledger = $request->ledger_type;

        if ($request->ajax()) {

            if (!$type && !$type_id) {
                return DataTables::of(collect([]))->make(true);
            }


            $data = Shipping::with(
                'customer',
                'invoice',
                'details.broker',
                'details.lifterCharges',
                'details.labourCharges',
                'details.localCharges',
                'details.otherCharges',
                'details.partyCommissionCharges',
                'details.trackerCharges',
                'details.broker',
                'agent',
                'gatePass'
            )->where('business_id', $business_id)->get();
                $filtered = $data->filter(function ($row) use ($type, $type_id) {
                return getCondition($row, $type, $type_id);
            });

            return DataTables::of($filtered)

                ->addColumn('action', function ($row) use ($ledger, $type, $type_id) {

                    $html = '
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                            Action
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                      <div class="dropdown-menu">
                           <a class="dropdown-item view-shipping" href="javascript:void(0)" data-id="' . $row->id . '">
                            <i class="fa fa-eye text-primary mr-1"></i> View </a>';

                    if ($ledger == 'payable') {
                        $html .= '
                             <a class="dropdown-item paybale-ledger" href="#" data-toggle="modal" data-target="#payable-ledger-modal"
                             data-id="' . $row->id . '"
                             data-type="' . getPartyType($type) . '"
                             data-type-id="' . $type_id . '"
                             data-job-no="' . $row->job_no . '"
                             data-date="' . $row->date . '"
                             data-party-name="' . getPartyName($row, $type) . '"
                             data-total-amount="' . getTotalAmountWithOutCurrency($row, $type, $type_id, $row->details) . '"
                             data-model-type = "' . getModalNames($type) . '"
                             data-paid-amount="' . getPaidAmount($row, $type, $type_id , $ledger) . '"
                             data-ledger-type="' . 'payable' . '">
                                <i class="far fa-money-bill-alt mr-1"></i> Add Payment
                            </a>';
                    } else if ($ledger == 'receivable') {


                        $html .= '
                             <a class="dropdown-item receivable-ledger" href="#" data-toggle="modal" data-target="#payable-ledger-modal"
                             data-id="' . $row->id . '"
                             data-type="' . getPartyType($type) . '"
                             data-type-id="' . $type_id . '"
                             data-job-no="' . $row->job_no . '"
                             data-date="' . $row->date . '"
                             data-party-name="' . getPartyName($row, $type) . '"
                             data-total-amount="' . getTotalAmountWithOutCurrency($row, $type, $type_id, $row->details) . '"
                             data-model-type = "' . getModalNames($type) . '"
                             data-paid-amount="' . getPaidAmount($row, $type, $type_id , $ledger) . '"
                             data-ledger-type="' . 'receivable' . '">
                                <i class="far fa-money-bill-alt mr-1"></i> Add Payment
                            </a>';
                    } else {
                        $html .= '';
                    }

                    return $html;
                })


                ->addColumn('job_no', function ($row) {
                    return '<p class="badge bg-primary" style = "font-size: 15px;">' . $row->job_no . '</p>';
                })

                ->addColumn('bilty_container_number', function ($row) {
                    return $row->details->first()->bilty_container_number ? implode(', ', $row->details->first()->bilty_container_number) : '';
                })

                ->addColumn('date', function ($row) {
                    return $row->date ? date('d-m-Y', strtotime($row->date)) : '';
                })

                ->addColumn('party_name', function ($row) use ($type) {
                    return getPartyName($row, $type);
                })

                ->addColumn('type', function ($row) use ($type) {
                    return getPartyType($type);
                })

                ->addColumn('total_amount', function ($row) use ($type, $type_id) {
                    $details = $row->details;
                    return getTotalAmount($row, $type, $type_id, $details);
                })

                ->addColumn('status', function ($row) use ($type, $type_id , $ledger) {


                    if($ledger == 'payable') {
                        $paid = DB::table('transactions')
                        ->where('payment_type', 'debit')
                        ->where('model_id', $type_id)
                        ->where('model_type', getModalNames($type))
                        ->where('shipping_id', $row->id)
                        ->sum('amount');

                    }elseif($ledger == 'receivable') {
                        $paid = DB::table('transactions')
                        ->where('payment_type', 'credit')
                        ->where('model_id', $type_id)
                        ->where('model_type', getModalNames($type))
                        ->where('shipping_id', $row->id)
                        ->sum('amount');
                    }

                    $total = 0;

                    if ($type === 'customer') {
                        $total = $row->total_invoice_amount ?? 0;
                    } elseif ($type === 'broker') {
                        $total = $row->details->where('broker_id', $type_id)->sum('booker_vhicle_freight_amount') +
                            $row->details->where('broker_id', $type_id)->sum('booker_mt_charges_amount');
                    } elseif ($type === 'gate_pass') {

                        if ($row->gate_pass_id == $type_id) {

                            $total = $row->details->sum('gate_pass_amount');
                        } else {
                            $total = 0;
                        }
                    } elseif ($type === 'clearing_agent') {

                        if ($row->clearing_agent_id == $type_id) {
                            $total = $row->details->sum('clearing_agent_amount');
                        } else {
                            $total = 0;
                        }
                    } elseif ($type === 'labour') {
                        $total = $row->details->where('labour_charges_id', $type_id)->sum('labour_charges_amount');
                    } elseif ($type === 'local') {
                        $total = $row->details->where('local_charges_id', $type_id)->sum('local_charges_amount');
                    } elseif ($type === 'lifter') {
                        $total = $row->details->where('lifter_charges_id', $type_id)->sum('lifter_charges_amount');
                    } elseif ($type === 'other') {
                        $total = $row->details->where('other_charges_id', $type_id)->sum('other_charges_amount');
                    } elseif ($type === 'party_commission') {
                        $total = $row->details->where('party_commission_charges_id', $type_id)->sum('party_commision_charges_amount');
                    } elseif ($type === 'tracker') {
                        $total = $row->details->where('tracker_charges_id', $type_id)->sum('tracker_charges_amount');
                    }

                    if ($paid > $total) {
                        return '<span class="badge badge-danger">OverDue</span>';
                    } elseif ($paid == $total) {
                        return '<span class="badge badge-success">Paid</span>';
                    } elseif ($paid > 0 && $paid < $total) {
                        return '<span class="badge badge-info">Partial</span>';
                    } else {
                        return '<span class="badge badge-warning">Due</span>';
                    }
                })


                ->addColumn('paid_amount', function ($row) use ($type, $type_id , $ledger) {

                    if($ledger == 'payable') {
                        $paid = DB::table('transactions')
                        ->where('payment_type', 'debit')
                        ->where('model_id', $type_id)
                        ->where('model_type', getModalNames($type))
                        ->where('shipping_id', $row->id)
                        ->sum('amount');

                    }elseif($ledger == 'receivable') {
                        $paid = DB::table('transactions')
                        ->where('payment_type', 'credit')
                        ->where('model_id', $type_id)
                        ->where('model_type', getModalNames($type))
                        ->where('shipping_id', $row->id)
                        ->sum('amount');
                    }else{
                        $paid = 0;
                    }

                    return 'Rs. ' . number_format($paid, 2);


                })

                ->rawColumns(['job_no', 'date', 'bilty_container_number', 'type', 'party_name', 'total_amount', 'status', 'paid_amount', 'action'])

                ->make(true);
        }

        $accounts = DB::table('accounts')->where('business_id', $business_id)->where('status' , 'active')->select('id', 'account_name')->get();
        return view('ledger.index' , compact('accounts'));
    }


    public function getTypeNames(Request $request)
    {
        $business_id = session('user.business_id');

        $type = $request->type;
        $results = [];

        switch ($type) {

            case 'customer':

                $results = Customer::whereIn('id', function ($q) use ($business_id) {
                    $q->select('customer_id')
                        ->from('shippings')
                        ->whereNotNull('customer_id')
                        ->where('business_id', $business_id);
                })->select('id', DB::raw("CONCAT(first_name) as name"))->get();

                break;

            case 'broker':
                $results = Broker::whereIn('id', function ($q) use ($business_id) {
                    $q->select('broker_id')
                        ->from('shipment_details')
                        ->whereNotNull('broker_id')
                        ->where('business_id', $business_id);
                })->select('id', 'name')->get();
                break;

            case 'labour':
                $results = LabourCharges::whereIn('id', function ($q) use ($business_id) {
                    $q->select('labour_charges_id')
                        ->from('shipment_details')
                        ->whereNotNull('labour_charges_id')
                        ->where('business_id', $business_id);
                })->select('id', 'name')->get();
                break;
            case 'lifter':
                $results = LifterCharges::whereIn('id', function ($q) use ($business_id) {
                    $q->select('lifter_charges_id')
                        ->from('shipment_details')
                        ->whereNotNull('lifter_charges_id')
                        ->where('business_id', $business_id);
                })->select('id', 'name')->get();
                break;
            case 'local':
                $results = LocalCharges::whereIn('id', function ($q) use ($business_id) {
                    $q->select('local_charges_id')
                        ->from('shipment_details')
                        ->whereNotNull('local_charges_id')
                        ->where('business_id', $business_id);
                })->select('id', 'name')->get();
                break;
            case 'other':
                $results = OtherCharges::whereIn('id', function ($q) use ($business_id) {
                    $q->select('other_charges_id')
                        ->from('shipment_details')
                        ->whereNotNull('other_charges_id')
                        ->where('business_id', $business_id);
                })->select('id', 'name')->get();
                break;
            case 'party_commission':
                $results = PartyCommissionCharges::whereIn('id', function ($q) use ($business_id) {
                    $q->select('party_commission_charges_id')
                        ->from('shipment_details')
                        ->whereNotNull('party_commission_charges_id')
                        ->where('business_id', $business_id);
                })->select('id', 'name')->get();
                break;
            case 'tracker':
                $results = TrackerCharges::whereIn('id', function ($q) use ($business_id) {
                    $q->select('tracker_charges_id')
                        ->from('shipment_details')
                        ->whereNotNull('tracker_charges_id')
                        ->where('business_id', $business_id);
                })->select('id', 'name')->get();
                break;
            case 'clearing_agent':
                $results = ClearingAgent::whereIn('id', function ($q) use ($business_id) {
                    $q->select('clearing_agent_id')
                        ->from('shippings')
                        ->whereNotNull('clearing_agent_id')
                        ->where('business_id', $business_id);
                })->select('id', 'name')->get();
                break;
            case 'gate_pass':
                $results = GatePass::whereIn('id', function ($q) use ($business_id) {
                    $q->select('gate_pass_id')
                        ->from('shippings')
                        ->whereNotNull('gate_pass_id')
                        ->where('business_id', $business_id);
                })->select('id', 'name')->get();
                break;

            default:
                $results = [];
                break;
        }

        return response()->json($results);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(LegderRequest $request)
    {

        // dd( $request->all());
        try {

            DB::beginTransaction();
            $amount = floatval(str_replace(',', '', $request->amount));
            $totalAmount = floatval(str_replace(',', '', $request->total_amount));
            $ledger = $request->ledger_type;
                if($ledger == 'payable') {
                        $paid = DB::table('transactions')
                        ->where('payment_type', 'debit')
                        ->where('model_id', $request->type_id)
                        ->where('model_type', $request->model_type)
                        ->where('shipping_id', $request->shipping_id)
                        ->sum('amount');

                    }elseif($ledger == 'receivable') {
                        $paid = DB::table('transactions')
                        ->where('payment_type', 'credit')
                        ->where('model_id', $request->type_id)
                        ->where('model_type', $request->model_type)
                        ->where('shipping_id', $request->shipping_id)
                        ->sum('amount');
                    }else{
                        $paid = 0;
                    }

            $totalPaid = $paid + $amount;

            // if ($totalPaid > $totalAmount) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'You are trying to pay more than the remaining balance.'
            //     ], 422);
            // }

            // Check status paid , due or partial
            if ($totalPaid > $totalAmount) {
                $status =  'OverDue';
            } elseif ($totalPaid == $totalAmount) {
                $status =  'Paid';
            } elseif ($totalPaid > 0 &&  $totalPaid < $totalAmount) {
                $status =  'Partial';
            } else {
                $status =  'Due';
            }

            if(!empty($request->account_id) && $request->account_id !== 'null') {

             $account = Account::findOrFail($request->account_id);

             if( $account ){
                if ($ledger === 'receivable') {

                $account->balance += $amount;
            } elseif ($ledger === 'payable') {

                // if ($account->balance < $amount) {
                //     return response()->json(['success' => false, 'message' => 'Insufficient balance in the account.'], 422);
                // }

                $account->balance -= $amount;
            }

                  $account->save();
             }

            }


            // Check ledger type
            if ($ledger === 'payable') {
                $payment_type = 'debit';
            } elseif ($ledger === 'receivable') {
                $payment_type = 'credit';
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid ledger type.'], 422);
            }

            $transcation = new Transaction();
            $transcation->business_id = session('user.business_id');
            $transcation->user_id = session('user.id');
            $transcation->shipping_id = $request->shipping_id;
            $transcation->model_type = $request->model_type;
            $transcation->model_id = $request->type_id;
            $transcation->payment_type = $payment_type;
            $transcation->payment_status = $status;
            $transcation->payment_method = $request->payment_method;
            $transcation->amount =  $amount;
            $transcation->transaction_date = $request->paid_on;
            $transcation->description = $request->remarks;
            $transcation->transaction_reference = 'payment-' . rand(100000, 999999); // Generate a unique transaction reference
            $transcation->account_id = $account->id ?? null; // Set account ID if available
            $transcation->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Payment recorded successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong' . ' ' . $e->getMessage()], 404);
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
