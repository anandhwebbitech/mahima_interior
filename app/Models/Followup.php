<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    //
    protected $guarded = []; 
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
