<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Initiator extends Model
{
    use HasFactory;
    protected $guarded = [];

    //get initiator image
    public function image(){
        return $this->morphOne(Media::class, 'mediable')->where('type','image');
    }
    //Image size
    public function image_size(){
        return '140x140';
    }
}
