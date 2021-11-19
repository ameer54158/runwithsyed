<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbassadorPayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function payment(){
        return $this->hasOne(Payment::class,'id','payment_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
