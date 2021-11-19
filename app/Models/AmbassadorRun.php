<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbassadorRun extends Model
{
    use HasFactory;
    protected $guarded = [];

    //get runs proof
    public function proof(){
        return $this->morphOne(Media::class, 'mediable')->where('type','proof');
    }

    //User
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = date('Y-m-d',strtotime($value));
    }

}
