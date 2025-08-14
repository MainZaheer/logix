<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    protected $guarded = ['id'];


  public function transactions()
    {
        return $this->morphMany(Transaction::class, 'model');
    }

}
