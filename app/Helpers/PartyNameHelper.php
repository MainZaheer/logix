<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\OpeningBalanceHistory;


if (!function_exists('getPartyName')) {
    function getPartyName($row, $type)
    {
        if ($type === 'broker') {
            return optional($row->details->first()->broker)->name;
        } elseif ($type === 'customer') {
            return optional($row->customer)->first_name . ' ' . optional($row->customer)->last_name;
        } elseif ($type === 'gate_pass') {
            return optional($row->gatePass)->name;
        } elseif ($type === 'clearing_agent') {
            return optional($row->agent)->name;
        } elseif ($type === 'labour') {
            return optional($row->details->first()->labourCharges)->name;
        } elseif ($type === 'local') {
            return optional($row->details->first()->localCharges)->name;
        } elseif ($type === 'lifter') {
            return optional($row->details->first()->lifterCharges)->name;
        } elseif ($type === 'other') {
            return optional($row->details->first()->otherCharges)->name;
        } elseif ($type === 'party_commission') {
            return optional($row->details->first()->partyCommissionCharges)->name;
        } elseif ($type === 'tracker') {
            return optional($row->details->first()->trackerCharges)->name;
        }

        return '-';
    }
}


if (!function_exists('getPartyType')) {
    function getPartyType($type)
    {
        if ($type == 'broker') {
            return 'Broker';
        } elseif ($type == 'customer') {
            return 'Customer';
        } elseif ($type == 'gate_pass') {
            return 'Gate Pass';
        } elseif ($type == 'clearing_agent') {
            return "Clearing Agent";
        } elseif ($type == 'labour') {
            return 'Expense';
        } elseif ($type == 'local') {
            return 'Expense';
        } elseif ($type == 'lifter') {
            return 'Expense';
        } elseif ($type == 'other') {
            return 'Expense';
        } elseif ($type == 'party_commission') {
            return 'Expense';
        } elseif ($type == 'tracker') {
            return 'Expense';
        }
    }
}



if (!function_exists('getModalNames')) {
    function getModalNames($type)
    {

        if ($type == 'customer') {
            return 'App\Models\Customer';
        } else if ($type == 'broker') {
            return 'App\Models\Broker';
        } else if ($type == 'labour') {
            return 'App\Models\LabourCharges';
        } else if ($type == 'lifter') {
            return 'App\Models\LifterCharges';
        } else if ($type == 'local') {
            return 'App\Models\LocalCharges';
        } else if ($type == 'other') {
            return 'App\Models\OtherCharges';
        } else if ($type == 'party_commission') {
            return 'App\Models\PartyCommissionCharges';
        } else if ($type == 'tracker') {
            return 'App\Models\TrackerCharges';
        } else if ($type == 'clearing_agent') {
            return 'App\Models\ClearingAgent';
        } else if ($type == 'gate_pass') {
            return 'App\Models\GatePass';
        } else {
            return '';
        }
    }
}


if (!function_exists('getTotalAmount')) {
    function getTotalAmount($row, $type, $type_id, $details)
    {
        switch ($type) {
            case 'broker':
                $filtered = $details->where('broker_id', $type_id);
                return 'Rs. ' . number_format($filtered->sum('booker_vhicle_freight_amount') + $filtered->sum('booker_mt_charges_amount'), 2);

            case 'labour':

                return 'Rs. ' . number_format($details->where('labour_charges_id', $type_id)->sum('labour_charges_amount'), 2);

            case 'local':
                return 'Rs. ' . number_format($details->where('local_charges_id', $type_id)->sum('local_charges_amount'), 2);

            case 'lifter':
                return 'Rs. ' . number_format($details->where('lifter_charges_id', $type_id)->sum('lifter_charges_amount'), 2);

            case 'other':
                return 'Rs. ' . number_format($details->where('other_charges_id', $type_id)->sum('other_charges_amount'), 2);

            case 'party_commission':
                return 'Rs. ' . number_format($details->where('party_commission_charges_id', $type_id)->sum('party_commision_charges_amount'), 2);

            case 'tracker':
                return 'Rs. ' . number_format($details->where('tracker_charges_id', $type_id)->sum('tracker_charges_amount'), 2);

            case 'customer':
                if ($row->customer_id == $type_id) {
                    return 'Rs. ' . number_format($row->total_invoice_amount ?? 0, 2);
                }

            case 'gate_pass':

                if ($row->gate_pass_id == $type_id) {
                    return 'Rs. ' . number_format($row->details->sum('gate_pass_amount') ?? 0, 2);
                }
                return 'Rs. 0.00';

            case 'clearing_agent':
                if ($row->clearing_agent_id == $type_id) {
                    return 'Rs. ' . number_format($row->details->sum('clearing_agent_amount') ?? 0, 2);
                }
                return 'Rs. 0.00';

            default:
                return 'Rs. 0.00';
        }
    }
}


if (!function_exists('getTotalAmountWithOutCurrency')) {
    function getTotalAmountWithOutCurrency($row, $type, $type_id, $details)
    {
        switch ($type) {
            case 'broker':
                $filtered = $details->where('broker_id', $type_id);
                return number_format($filtered->sum('booker_vhicle_freight_amount') + $filtered->sum('booker_mt_charges_amount'), 2);

            case 'labour':

                $filtered = $details->where('labour_charges_id', $type_id);
                return number_format($filtered->sum('labour_charges_amount'), 2);

            case 'local':
                return number_format($details->where('local_charges_id', $type_id)->sum('local_charges_amount'), 2);

            case 'lifter':
                return number_format($details->where('lifter_charges_id', $type_id)->sum('lifter_charges_amount'), 2);

            case 'other':
                return number_format($details->where('other_charges_id', $type_id)->sum('other_charges_amount'), 2);

            case 'party_commission':
                return number_format($details->where('party_commission_charges_id', $type_id)->sum('party_commision_charges_amount'), 2);

            case 'tracker':
                return number_format($details->where('tracker_charges_id', $type_id)->sum('tracker_charges_amount'), 2);

            case 'customer':
                if ($row->customer_id == $type_id) {
                    return number_format($row->total_invoice_amount ?? 0, 2);
                }
            case 'gate_pass':

                if ($row->gate_pass_id == $type_id) {
                    return number_format($row->details->sum('gate_pass_amount') ?? 0, 2);
                }
                return '0.00';

            case 'clearing_agent':
                if ($row->clearing_agent_id == $type_id) {
                    return number_format($row->details->sum('clearing_agent_amount') ?? 0, 2);
                }
                return '0.00';

            default:
                return '0.00';
        }
    }
}


if (!function_exists('getPaidAmount')) {
    function getPaidAmount($row, $type, $type_id, $ledger)
    {

        $paid = 0;
        if ($ledger == 'payable') {

            $paid = DB::table('transactions')
                ->where('payment_type', 'debit')
                ->where('model_id', $type_id)
                ->where('model_type', getModalNames($type))
                ->where('shipping_id', $row->id)
                ->sum('amount');
        } elseif ($ledger == 'receivable') {


            $paid = DB::table('transactions')
                ->where('payment_type', 'credit')
                ->where('model_id', $type_id)
                ->where('model_type', getModalNames($type))
                ->where('shipping_id', $row->id)
                ->sum('amount');
        }


        $total_amount = getTotalAmountWithOutCurrency($row, $type, $type_id, $row->details);
        $total_amount = str_replace(',', '', $total_amount); // Remove commas for calculation
        $paid = $total_amount - $paid;


        return number_format($paid, 2);
    }
}
if (!function_exists('getCondition')) {
    function getCondition($row, $type, $type_id)
    {
        $firstDetail = $row->details->first();

        if ($type == 'customer') {
            return $row->customer_id == $type_id;
        } elseif ($type == 'broker') {
            return $firstDetail && $firstDetail->broker_id == $type_id;
        } elseif ($type == 'gate_pass') {
            return $row->gate_pass_id == $type_id;
        } elseif ($type == 'clearing_agent') {
            return $row->clearing_agent_id == $type_id;
        } elseif ($type == 'labour') {
            return $firstDetail && $firstDetail->labour_charges_id == $type_id;
        } elseif ($type == 'local') {
            return $firstDetail && $firstDetail->local_charges_id == $type_id;
        } elseif ($type == 'lifter') {
            return $firstDetail && $firstDetail->lifter_charges_id == $type_id;
        } elseif ($type == 'other') {
            return $firstDetail && $firstDetail->other_charges_id == $type_id;
        } elseif ($type == 'party_commission') {
            return $firstDetail && $firstDetail->party_commission_charges_id == $type_id;
        } elseif ($type == 'tracker') {
            return $firstDetail && $firstDetail->tracker_charges_id == $type_id;
        }
    }
}



if (!function_exists('openingBalanceHistory')) {
    function openingBalanceHistory($id,  $old_opening_balance,  $difference,  $new_opening_balance)
    {

        $OBH =    OpeningBalanceHistory::create([
            'account_id'   => $id,
            'old_balance'  => $old_opening_balance,
            'new_balance'  => $new_opening_balance,
            'difference'   => $difference,
            'updated_by'   => auth()->user()->id,
            'business_id'  => auth()->user()->business_id
        ]);

        return $OBH;
    }
}


if (!function_exists('getModalTypeNames')) {
    function getModalTypeNames($type , $row)
    {

        if ($type == 'App\Models\Customer') {
           return '<p><strong>Customer: </strong>' . $row->model->first_name.' '. $row->model->last_name . '</p>';
        } else if ($type == 'App\Models\Broker') {
            return '<p><strong>Broker: </strong>' . $row->model->name . '</p>';
        } else if ($type == 'App\Models\LabourCharges') {
            return '<p><strong>Expense: </strong>' . $row->model->name . '</p>';
        } else if ($type == 'App\Models\LifterCharges') {
            return '<p><strong>Expense: </strong>' . $row->model->name . '</p>';
        }else if ($type == 'App\Models\LocalCharges') {
            return '<p><strong>Expense: </strong>' . $row->model->name . '</p>';
        } else if ($type == 'App\Models\OtherCharges') {
            return '<p><strong>Expense: </strong>' . $row->model->name . '</p>';
        }else if($type == 'App\Models\PartyCommissionCharges'){
            return '<p><strong>Expense: </strong>' . $row->model->name . '</p>';
        }else if($type == 'App\Models\TrackerCharges'){
            return '<p><strong>Clearing Agent: </strong>' . $row->model->name . '</p>';
        } else if ($type == 'App\Models\ClearingAgent') {
            return '<p><strong>Clearing Agent: </strong>' . $row->model->name . '</p>';
        } else if ($type == 'App\Models\GatePass') {
            return '<p><strong>GatePass: </strong>' . $row->model->name . '</p>';
        } else {
            return '';
        }
    }
}
