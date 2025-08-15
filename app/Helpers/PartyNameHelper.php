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
        // Normalize type_id to array of integers
        $type_ids = is_array($type_id) ? $type_id : [$type_id];
        $type_ids = collect($type_ids)
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->map(fn ($v) => (int) $v)
            ->values()
            ->all();

        if (empty($type_ids)) {
            return 'Rs. 0.00';
        }

        switch ($type) {
            case 'broker':
                $filtered = $details->whereIn('broker_id', $type_ids);
                return 'Rs. ' . number_format(
                    $filtered->sum('booker_vhicle_freight_amount') + $filtered->sum('booker_mt_charges_amount'),
                    2
                );

            case 'labour':
                return 'Rs. ' . number_format(
                    $details->whereIn('labour_charges_id', $type_ids)->sum('labour_charges_amount'),
                    2
                );

            case 'local':
                return 'Rs. ' . number_format(
                    $details->whereIn('local_charges_id', $type_ids)->sum('local_charges_amount'),
                    2
                );

            case 'lifter':
                return 'Rs. ' . number_format(
                    $details->whereIn('lifter_charges_id', $type_ids)->sum('lifter_charges_amount'),
                    2
                );

            case 'other':
                return 'Rs. ' . number_format(
                    $details->whereIn('other_charges_id', $type_ids)->sum('other_charges_amount'),
                    2
                );

            case 'party_commission':
                return 'Rs. ' . number_format(
                    $details->whereIn('party_commission_charges_id', $type_ids)->sum('party_commision_charges_amount'),
                    2
                );

            case 'tracker':
                return 'Rs. ' . number_format(
                    $details->whereIn('tracker_charges_id', $type_ids)->sum('tracker_charges_amount'),
                    2
                );

            case 'customer':
                if (in_array($row->customer_id, $type_ids)) {
                    return 'Rs. ' . number_format($row->total_invoice_amount ?? 0, 2);
                }
                break;

            case 'gate_pass':
                if (in_array($row->gate_pass_id, $type_ids)) {
                    return 'Rs. ' . number_format($row->details->sum('gate_pass_amount') ?? 0, 2);
                }
                break;

            case 'clearing_agent':
                if (in_array($row->clearing_agent_id, $type_ids)) {
                    return 'Rs. ' . number_format($row->details->sum('clearing_agent_amount') ?? 0, 2);
                }
                break;
        }

        return 'Rs. 0.00';
    }
}


if (!function_exists('getTotalAmountWithOutCurrency')) {
    function getTotalAmountWithOutCurrency($row, $type, $type_id, $details)
    {
        // Normalize to an array of ints
        $type_ids = is_array($type_id) ? $type_id : [$type_id];
        $type_ids = collect($type_ids)
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->map(fn ($v) => (int) $v)
            ->values()
            ->all();

        if (empty($type_ids)) {
            return '0.00';
        }

        switch ($type) {
            case 'broker': {
                $filtered = $details->whereIn('broker_id', $type_ids);
                $sum = ($filtered->sum('booker_vhicle_freight_amount') ?? 0)
                     + ($filtered->sum('booker_mt_charges_amount') ?? 0);
                return number_format($sum, 2);
            }

            case 'labour': {
                $sum = $details->whereIn('labour_charges_id', $type_ids)->sum('labour_charges_amount');
                return number_format($sum, 2);
            }

            case 'local': {
                $sum = $details->whereIn('local_charges_id', $type_ids)->sum('local_charges_amount');
                return number_format($sum, 2);
            }

            case 'lifter': {
                $sum = $details->whereIn('lifter_charges_id', $type_ids)->sum('lifter_charges_amount');
                return number_format($sum, 2);
            }

            case 'other': {
                $sum = $details->whereIn('other_charges_id', $type_ids)->sum('other_charges_amount');
                return number_format($sum, 2);
            }

            case 'party_commission': {
                $sum = $details->whereIn('party_commission_charges_id', $type_ids)->sum('party_commision_charges_amount');
                return number_format($sum, 2);
            }

            case 'tracker': {
                $sum = $details->whereIn('tracker_charges_id', $type_ids)->sum('tracker_charges_amount');
                return number_format($sum, 2);
            }

            case 'customer': {
                $ok = in_array((int) $row->customer_id, $type_ids, true);
                $sum = $ok ? ($row->total_invoice_amount ?? 0) : 0;
                return number_format($sum, 2);
            }

            case 'gate_pass': {
                $ok = in_array((int) $row->gate_pass_id, $type_ids, true);
                $sum = $ok ? ($row->details->sum('gate_pass_amount') ?? 0) : 0;
                return number_format($sum, 2);
            }

            case 'clearing_agent': {
                $ok = in_array((int) $row->clearing_agent_id, $type_ids, true);
                $sum = $ok ? ($row->details->sum('clearing_agent_amount') ?? 0) : 0;
                return number_format($sum, 2);
            }

            default:
                return '0.00';
        }
    }
}

if (!function_exists('getPaidAmount')) {
    function getPaidAmount($row, $type, $type_id, $ledger)
    {
        // Normalize type_id to an array of integers
        $type_ids = is_array($type_id) ? $type_id : [$type_id];
        $type_ids = collect($type_ids)
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->map(fn ($v) => (int) $v)
            ->values()
            ->all();

        if (empty($type_ids)) {
            return '0.00';
        }

        // Build query for paid amount
        $query = DB::table('transactions')
            ->whereIn('model_id', $type_ids)
            ->where('model_type', getModalNames($type))
            ->where('shipping_id', $row->id);

        if ($ledger === 'payable') {
            $query->where('payment_type', 'debit');
        } elseif ($ledger === 'receivable') {
            $query->where('payment_type', 'credit');
        } else {
            return '0.00';
        }

        $paid = $query->sum('amount');

        // Get total amount without currency
        $total_amount = getTotalAmountWithOutCurrency($row, $type, $type_ids, $row->details);
        $total_amount = (float) str_replace(',', '', $total_amount); // remove commas

        // Remaining balance
        $remaining = $total_amount - $paid;

        return number_format($remaining, 2);
    }
}




if (!function_exists('getCondition')) {
    function getCondition($row, $type, $type_ids)
    {
        $firstDetail = $row->details->first();
        $type_ids = collect($type_ids)->map(fn($id) => (int) $id);

        if ($type == 'customer') {
            return $type_ids->contains($row->customer_id);
        } elseif ($type == 'broker') {
            return $firstDetail && $type_ids->contains($firstDetail->broker_id);
        } elseif ($type == 'gate_pass') {
            return $type_ids->contains($row->gate_pass_id);
        } elseif ($type == 'clearing_agent') {
            return $type_ids->contains($row->clearing_agent_id);
        } elseif ($type == 'labour') {
            return $firstDetail && $type_ids->contains($firstDetail->labour_charges_id);
        } elseif ($type == 'local') {
            return $firstDetail && $type_ids->contains($firstDetail->local_charges_id);
        } elseif ($type == 'lifter') {
            return $firstDetail && $type_ids->contains($firstDetail->lifter_charges_id);
        } elseif ($type == 'other') {
            return $firstDetail && $type_ids->contains($firstDetail->other_charges_id);
        } elseif ($type == 'party_commission') {
            return $firstDetail && $type_ids->contains($firstDetail->party_commission_charges_id);
        } elseif ($type == 'tracker') {
            return $firstDetail && $type_ids->contains($firstDetail->tracker_charges_id);
        }

        return false;
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
