<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = ['id'];

    public function shipment()
    {
        return $this->belongsTo(Shipping::class, 'shipment_id');
    }

    public function fuel(){
        return $this->belongsTo(Fuel::class, 'fuel_id');
    }
}
