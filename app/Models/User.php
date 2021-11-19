<?php

namespace App\Models;

use App\Models\Media;
use App\Models\UserDetail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_no',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function detail() {
       return $this->hasOne(UserDetail::class)->withDefault();
    }

    public function image(){
        return $this->morphOne(Media::class, 'mediable')->where('type','profile-image');
    }

    public function image_size(){
        return '105x105';
    }

    //Get user runs
    public function runs(){
        return $this->hasMany(AmbassadorRun::class)->orderBy('date','DESC');
    }

    //Get current month runs
    public function current_month_runs(){
        $first_day_this_month = date('Y-m-01'); //Get first date of the current month
        $last_day_this_month  = date('Y-m-t'); //Get last date of the current month
        return $this->hasMany(AmbassadorRun::class)->whereBetween('date',[$first_day_this_month,$last_day_this_month]);
    }

    //get ambassador payment
    public function ambassador_payments(){
        return $this->hasMany(AmbassadorPayment::class)->orderBy('id','DESC');
    }

    //To get ambassador sponsors
    public function sponsors(){
        return $this->hasMany(SponsorAmbassador::class,'ambassador_user_id','id');
    }

    //To get sponsor ambassadors
    public function ambassadors(){
        return $this->hasMany(SponsorAmbassador::class,'sponsor_user_id','id');
    }

    //To get sponsor payments that will be made against ambassadors
    public function sponsor_payments(){
        return $this->hasManyThrough(
            SponsorAmbassadorPayment::class,
            SponsorAmbassador::class,
            'sponsor_user_id',
            'sponsor_ambassador_id',
            'id',
            'id'
        )->orderBy('sponsor_ambassador_payments.id','DESC');
    }
    //To get user metas
    public function metas() {
        return $this->morphMany(Meta::class, 'metable');
    }

    //To get all admin users
    public function admin_users(){
        $admin_users = User::whereHas('roles',function ($query){
            $query->where('roles.slug','admin');
        })->whereStatus(1)->get();
        return $admin_users;
    }

    //
    public function our_top_ambassador(){
        return $this->hasOne(OurTopAmbassadors::class);
    }

}
