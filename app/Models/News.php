<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $guarded = [];

    //get news image
    public function image(){
        return $this->morphOne(Media::class, 'mediable')->where('type','image');
    }

    //get news gallery
    public function gallery(){
        return $this->morphMany(Media::class, 'mediable')->where('type','gallery');
    }
    //Image size
    public function image_size(){
        return '360x220';
    }
}
