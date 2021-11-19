<?php

namespace App\Console\Commands;

use App\Models\AmbassadorRun;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MonthOverEmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendMonthOverEmail:monthOverEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to ambassador and sponsor when an month is over to pay the amount against register kms and his/her ambassador respectively';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $first_day_of_last_month = date('Y-m-d', strtotime('first day of previous month'));
        $last_day_of_last_month  = date('Y-m-d', strtotime('last day of previous month'));
        $month_name = date('m-Y', strtotime('first day of previous month'));

        //Send email to ambassador when an month is over
        $ambassadors = User::whereHas('roles',function ($query){
            $query->where('roles.slug','ambassador');
        })->orderBy('id','DESC')->get();

        if($ambassadors->count()){
            foreach ($ambassadors as $ambassador){
                if($ambassador && $ambassador->email){
                    $ambassador_runs = AmbassadorRun::where('user_id',$ambassador->id)
                        ->whereBetween('date',[$first_day_of_last_month,$last_day_of_last_month])->get();

                    if($ambassador_runs->count() && !$ambassador->ambassador_payments->where('month_year',date('m-Y', strtotime('first day of previous month')))->first()){
                        $ambassador_email = $ambassador->email;
                        Mail::send('mail.ambassador-month-over-email-notification',compact('month_name'), function ($message) use ($ambassador_email) {
                            $message->to($ambassador_email)->subject('Venter på betaling');
                            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        });
                    }
                }
            }
        }


        //Send email to sponsor pay his/her ambassador payment
        $sponsors = User::whereHas('roles',function ($query){
            $query->where('roles.slug','sponsor');
        })->orderBy('id','DESC')->get();

        if($sponsors->count()){
            foreach ($sponsors as $sponsor){
                if($sponsor && $sponsor->email && $sponsor->ambassadors->count()){
                    foreach ($sponsor->ambassadors as $sponsor_ambassador){
                        if($sponsor_ambassador->ambassador_user){
                            $ambassador_runs = AmbassadorRun::where('user_id',$sponsor_ambassador->ambassador_user->id)
                                ->whereBetween('date',[$first_day_of_last_month,$last_day_of_last_month])->get();
                            if($ambassador_runs->count()){
                                $sponsor_email = $sponsor->email;
                                $ambassador_user = $sponsor_ambassador->ambassador_user;
                                $not_paying_month_year = \App\Helpers\common::sponsor_not_paying_month($sponsor_ambassador->ambassador_user,$sponsor->id);

                                $month = date('Y-m', strtotime('first day of previous month'));
                                if((isset($not_paying_month_year[date('Y-m', strtotime($month.'-01'))]) && $not_paying_month_year[date('Y-m', strtotime($month.'-01'))])){
                                    Mail::send('mail.sponsor-month-over-email-notification',compact('month_name','ambassador_user'), function ($message) use ($sponsor_email) {
                                        $message->to($sponsor_email)->subject('Venter på betaling');
                                        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                    });
                                }

                            }
                        }
                    }
                }
            }
        }

        $this->info('Email has been sent to all users.');
    }
}
