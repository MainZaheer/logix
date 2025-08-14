<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $guarded = ['id'];

    public function details()
{
    return $this->hasMany(ShipmentDetail::class , 'shipment_id');
}

public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}

public function invoice(){
    return $this->hasOne(Invoice::class, 'shipment_id');
}

public function agent()
{
    return $this->belongsTo(ClearingAgent::class, 'clearing_agent_id');
}

public function gatePass()
{
    return $this->belongsTo(GatePass::class, 'gate_pass_id');
}

}
