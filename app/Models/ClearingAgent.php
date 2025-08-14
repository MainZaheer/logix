<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClearingAgent extends Model
{
    protected $fillable = [
         'name',
        'description',
        'status',
        'business_id',
        'user_id'
    ];

        public function transactions()
        {
            return $this->morphMany(Transaction::class, 'model');
        }
}
