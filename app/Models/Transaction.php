<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $fillable = [
        'shipping_id',
        'business_id',
        'user_id',
        'account_id',
        'transaction_reference',
        'model_type',
        'model_id',
        'payment_method',
        'payment_type',
        'payment_status',
        'description',
        'transaction_date',
        'amount'
    ];


    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

            public function model()
            {
            return $this->morphTo();
            }




}
