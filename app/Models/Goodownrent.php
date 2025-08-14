<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goodownrent extends Model
{
    protected $fillable = ['name','status','description','user_id','business_id'];

      public function transactions()
    {
        return $this->morphMany(Transaction::class, 'model');
    }
}

