<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorAmbassadorPayment extends Model
{
    use HasFactory;
    protected $guarded = [];


    //get ambassador payment
    public function payment(){
        return $this->hasOne(Payment::class,'id','payment_id');
    }

    //
    public function sponsor_ambassador(){
        return $this->belongsTo(SponsorAmbassador::class ,'sponsor_ambassador_id','id');
    }
}
