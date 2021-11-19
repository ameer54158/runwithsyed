<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ambassador_payment(){
        return $this->hasMany(AmbassadorPayment::class,'payment_id','id');
    }

    public function sponsor_payment(){
        return $this->hasMany(SponsorAmbassadorPayment::class,'payment_id','id');
    }

    public function ambassador_membership_fee(){
        return $this->belongsTo(Meta::class,'id','value');
    }

    public function donation(){
        return $this->hasOne(Donation::class);
    }
}
