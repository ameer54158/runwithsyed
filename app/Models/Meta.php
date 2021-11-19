<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;
    protected $table = 'metas';
    protected $guarded = [];

    public function metable() {
        return $this->morphTo();
    }

    public function payment(){
        return $this->hasOne(Payment::class,'id','value');
    }
}
