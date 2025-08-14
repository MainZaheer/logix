<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrainCharges extends Model
{
    protected $fillable = ['name','user_id','status','description','business_id'];

     public function transactions()
        {
            return $this->morphMany(Transaction::class, 'model');
        }
}
