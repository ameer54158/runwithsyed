<?php

namespace App\Models;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];

    //get Setting value
    public function get_value($key){
        return Setting::where('key',$key)->pluck('value')->first();
    }
    //get about us page image
    public function about_us_image(){
        return $this->morphOne(Media::class, 'mediable')->where('type','about_us_image');
    }
    //About us page image size
    public function about_us_image_size(){
        return '555x457';
    }

}
