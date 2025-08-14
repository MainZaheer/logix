<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
    'name', 'email', 'type', 'phone',
    'country', 'state', 'city', 'address', 'zip', 'status','user_id','business_id'
];
}
