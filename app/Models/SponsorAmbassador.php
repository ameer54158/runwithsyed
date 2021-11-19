<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorAmbassador extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ambassador_user(){
        return $this->belongsTo(User::class,'ambassador_user_id','id');
    }

    public function sponsor_user(){
        return $this->belongsTo(User::class,'sponsor_user_id','id');
    }

    //get ambassador payment
    public function payments(){
        return $this->hasMany(SponsorAmbassadorPayment::class,'sponsor_ambassador_id','id')->orderBy('id','DESC');
    }
}
