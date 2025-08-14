<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningBalanceHistory extends Model
{
    protected $guarded = ['id'];

    public function history(){
         return $this->hasMany(Account::class);
    }
}
