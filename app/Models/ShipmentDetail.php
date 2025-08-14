<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{

    protected $guarded = ['id'];

    protected $casts = [
        'bilty_container_number' => 'array',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function sendar()
    {
        return $this->belongsTo(Contact::class, 'sendar_id');
    }

    public function recipient()
    {
        return $this->belongsTo(Contact::class, 'recipient_id');
    }

    public function broker()
    {
        return $this->belongsTo(Broker::class, 'broker_id' );
    }


    public function lifterCharges()
    {
        return $this->belongsTo(LifterCharges::class, 'lifer_charges_id');
    }

    public function labourCharges()
    {
        return $this->belongsTo(LabourCharges::class, 'labour_charges_id');
    }

    public function localCharges()
    {
        return $this->belongsTo(LocalCharges::class, 'local_charges_id');
    }

    public function otherCharges()
    {
        return $this->belongsTo(OtherCharges::class, 'other_charges_id');
    }

    public function partyCommissionCharges()
    {
        return $this->belongsTo(PartyCommissionCharges::class, 'party_commission_charges_id');
    }

    public function trackerCharges()
    {
        return $this->belongsTo(TrackerCharges::class, 'tracker_charges_id');
    }


}
