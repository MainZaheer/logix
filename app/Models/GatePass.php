<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'user_id',
        'business_id'
    ];

     public function transactions()
        {
            return $this->morphMany(Transaction::class, 'model');
        }

}
