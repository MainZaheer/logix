<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{

    protected $table = 'fuels';

   protected $fillable = [
        'name',
        'description',
        'status',
        'user_id',
        'business_id'
    ];
}
