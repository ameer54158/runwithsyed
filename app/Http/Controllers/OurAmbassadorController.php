<?php

namespace App\Http\Controllers;

use App\Models\AmbassadorRun;
use App\Models\Setting;
use App\Models\SponsorAmbassador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class OurAmbassadorController extends Controller
{

    //our ambassadors page (list all ambassador at front end )
    public function our_ambassadors(Request $request){
        $paginate = 15;
        $total = 0;
        if($request->ajax()){
            if($request->pagination){
                $paginate = $paginate * $request->pagination;
            }
            $ambassadors = User::whereHas('roles',function ($query){
                $query->where('roles.slug','ambassador');
            })->whereStatus(1)->when(($request->search), function($query) use ($request) {
                if($request->search){
                    $query->where(function($query) use ($request){
                        $query->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', '%' . $request->search . '%')
                            ->orWhere(function($query) use ($request){
                                $query->whereHas('detail',function ($q) use($request){
                                    $q->where('user_details.description', 'LIKE', '%'.$request->search.'%');
                                });
                            });
                    });
                }
            });
            //$ambassadors = $ambassadors->doesntHave('our_top_ambassador');
            if($request->pagination && !$request->search && !$request->sort){
                $ambassadors = $ambassadors->doesntHave('our_top_ambassador');
            }
            if($request->sort && $request->sort == 'navn'){
                $ambassadors = $ambassadors->orderBy('users.first_name','ASC');

            }elseif($request->sort && $request->sort == 'heighest_km'){
                $ambassadors = $ambassadors->withCount(['runs as sum' => function ($query) {
                       return $query->select(\DB::raw('SUM(ambassador_runs.distance) AS sum'));
                   }])->orderBy('sum', 'DESC');

            }elseif($request->sort && $request->sort == 'lowest_km'){
                $ambassadors = $ambassadors->withCount(['runs as sum' => function ($query) {
                    return $query->select(\DB::raw('SUM(ambassador_runs.distance) AS sum'));
                }])->orderBy('sum', 'ASC');

            }else{
                $ambassadors = $ambassadors->orderBy('id','DESC');
            }
            $our_top_ambassadors = collect();
            if(!$request->search && !$request->sort){
                $our_top_ambassadors = User::whereHas('roles',function ($query){
                    $query->where('roles.slug','ambassador');
                })->whereStatus(1)->join('our_top_ambassadors','our_top_ambassadors.user_id','users.id')
                    ->select('users.*','our_top_ambassadors.order')->orderBy('our_top_ambassadors.order','ASC')->get();
            }

            $total = $ambassadors->count();
            $ambassadors = $ambassadors->take($paginate)->get();
            $data = View::make('ambassadors.our-ambassadors-inner',compact('ambassadors','total','our_top_ambassadors'))->render();
            $response = array();
            $response['data'] = $data;
            return json_encode($response);
        }else{
         $ambassadors = User::whereHas('roles',function ($query){
             $query->where('roles.slug','ambassador');
         })->whereStatus(1)->doesntHave('our_top_ambassador')->orderBy('id','DESC');

         $our_top_ambassadors = User::whereHas('roles',function ($query){
             $query->where('roles.slug','ambassador');
         })->whereStatus(1)->join('our_top_ambassadors','our_top_ambassadors.user_id','users.id')
             ->orderBy('our_top_ambassadors.order','ASC')->select('users.*','our_top_ambassadors.order')->get();
         $total = $ambassadors->count();
         $ambassadors = $ambassadors->take($paginate)->get();
            return view('ambassadors.our-ambassadors',compact('ambassadors','total','our_top_ambassadors'));
        }
    }

    //Become a sponsor against an ambassador
    public function become_sponsor_of_ambassador($id){
        if(Auth::user()->hasRole('sponsor')){
            $user = User::find($id);
            if($user){
                try{
                    $sponsor_ambassador = SponsorAmbassador::where('sponsor_user_id',Auth::id())->where('ambassador_user_id',$user->id)->first();
                    if($sponsor_ambassador && $sponsor_ambassador->status == 1){
                        flash(__('flash-messages.Your are already sponsor of this ambassador.'))->success();
                        return redirect(localized_route('our-ambassadors'));
                    }
                    $sponsor_ambassador = SponsorAmbassador::updateOrCreate([
                        'sponsor_user_id' => Auth::id(),'ambassador_user_id'=> $user->id,
                    ], [
                        'status' => 1,
                    ]);
                    $become_ambassador_status = 'active';
                    $setting_obj = new Setting();

                    if($sponsor_ambassador->sponsor_user && $sponsor_ambassador->sponsor_user->email && $sponsor_ambassador->ambassador_user && $sponsor_ambassador->ambassador_user->email){
                        $sponsor_user_name = ($sponsor_ambassador->sponsor_user && $sponsor_ambassador->sponsor_user->first_name ? $sponsor_ambassador->sponsor_user->first_name : "").' '.($sponsor_ambassador->sponsor_user && $sponsor_ambassador->sponsor_user->last_name ? $sponsor_ambassador->sponsor_user->last_name : "");
                        $ambassador_user_name = ($sponsor_ambassador->ambassador_user && $sponsor_ambassador->ambassador_user->first_name ? $sponsor_ambassador->ambassador_user->first_name : "").' '.($sponsor_ambassador->ambassador_user && $sponsor_ambassador->ambassador_user->last_name ? $sponsor_ambassador->ambassador_user->last_name : "");
                        //Send email to sponsor
                        $sponsor_email = $sponsor_ambassador->sponsor_user->email;
                        Mail::send('mail.ambassador-sponsorship',compact('become_ambassador_status','setting_obj','sponsor_user_name','ambassador_user_name'), function ($message) use ($sponsor_email,$ambassador_user_name) {
                            $message->to($sponsor_email)->subject('Sponsor er lagt til for '.$ambassador_user_name);
                            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        });

                        //Send email to ambassador
                        $ambassador_email = $sponsor_ambassador->ambassador_user->email;
                        Mail::send('mail.ambassador-sponsorship',compact('become_ambassador_status','setting_obj','sponsor_user_name','ambassador_user_name'), function ($message) use ($ambassador_email,$ambassador_user_name) {
                            $message->to($ambassador_email)->subject('Sponsor er lagt til for '.$ambassador_user_name);
                            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        });

                        //Send email to all admin user
                        $admin_users = (new User())->admin_users();
                        if($admin_users->count()) {
                            foreach ($admin_users as $admin_user) {
                                $admin_email = $admin_user->email;
                                if($admin_email){
                                    Mail::send('mail.ambassador-sponsorship',compact('become_ambassador_status','setting_obj','sponsor_user_name','ambassador_user_name'), function ($message) use ($admin_email,$ambassador_user_name) {
                                        $message->to($admin_email)->subject('Sponsor er lagt til for '.$ambassador_user_name);
                                        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                    });
                                }

                            }
                        }
                    }

                    Session::flash('become_sponsor_success_modal', true);
                    flash(__('flash-messages.Congratulations! You are now become sponsor of this ambassador.'))->success();
                    return redirect(localized_route('our-ambassadors'));
                }catch (\Exception $e){
                    DB::rollback();
                    flash(__('flash-messages.Something went wrong.'))->error()->important();
                    return back();
                }
            }else{
                abort(404);
            }

        }else{
            flash(__('flash-messages.Your are not authorized to become sponsor.'))->error();
            return redirect(localized_route('our-ambassadors'));
        }
    }

    //Remove sponsorship against an ambassador
    public function remove_sponsor_of_ambassador($id){
        if(Auth::user()->hasRole('sponsor')){
            $user = User::find($id);
            if($user){
                if(Auth::user()->ambassadors->count() && Auth::user()->ambassadors->where('ambassador_user_id',$user->id)->count()){
                    $sponsor_ambassador = SponsorAmbassador::updateOrCreate([
                        'sponsor_user_id' => Auth::id(),'ambassador_user_id'=> $user->id,
                    ], [
                        'status' => 0,
                    ]);

                    if($sponsor_ambassador->sponsor_user && $sponsor_ambassador->sponsor_user->email && $sponsor_ambassador->ambassador_user && $sponsor_ambassador->ambassador_user->email){
                        $become_ambassador_status = 'deactivate';
                        $sponsor_user_name = ($sponsor_ambassador->sponsor_user && $sponsor_ambassador->sponsor_user->first_name ? $sponsor_ambassador->sponsor_user->first_name : "").' '.($sponsor_ambassador->sponsor_user && $sponsor_ambassador->sponsor_user->last_name ? $sponsor_ambassador->sponsor_user->last_name : "");
                        $ambassador_user_name = ($sponsor_ambassador->ambassador_user && $sponsor_ambassador->ambassador_user->first_name ? $sponsor_ambassador->ambassador_user->first_name : "").' '.($sponsor_ambassador->ambassador_user && $sponsor_ambassador->ambassador_user->last_name ? $sponsor_ambassador->ambassador_user->last_name : "");

                        //Send email to sponsor
                        $sponsor_email = $sponsor_ambassador->sponsor_user->email;
                        Mail::send('mail.ambassador-sponsorship',compact('become_ambassador_status','sponsor_user_name','ambassador_user_name'), function ($message) use ($sponsor_email, $ambassador_user_name) {
                            $message->to($sponsor_email)->subject('Sponsor er fjernet for '.$ambassador_user_name);
                            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        });

                        //Send email to ambassador
                        $ambassador_email = $sponsor_ambassador->ambassador_user->email;
                        Mail::send('mail.ambassador-sponsorship',compact('become_ambassador_status','sponsor_user_name','ambassador_user_name'), function ($message) use ($ambassador_email, $ambassador_user_name) {
                            $message->to($ambassador_email)->subject('Sponsor er fjernet for '.$ambassador_user_name);
                            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        });

                        //Send email to all admin user
                        $admin_users = (new User())->admin_users();
                        if($admin_users->count()) {
                            foreach ($admin_users as $admin_user) {
                                $admin_email = $admin_user->email;
                                Mail::send('mail.ambassador-sponsorship',compact('become_ambassador_status','sponsor_user_name','ambassador_user_name'), function ($message) use ($admin_email, $ambassador_user_name) {
                                    $message->to($admin_email)->subject('Sponsor er fjernet for '.$ambassador_user_name);
                                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                });
                            }
                        }
                    }


                    flash(__('flash-messages.Successfully! You have been remove sponsorship of this ambassador.'))->success();
                    return redirect(localized_route('our-ambassadors'));

                }else{
                    flash(__('flash-messages.Your are not sponsor of this ambassador.'))->error();
                    return redirect(localized_route('our-ambassadors'));
                }
            }else{
                abort(404);
            }

        }else{
            flash(__('flash-messages.Your are not authorized to become sponsor.'))->error();
            return redirect(localized_route('our-ambassadors'));
        }
    }

    //View ambassador detail
    public function view_ambassador($id,Request $request){
        $ambassador = User::find($id);
        if($ambassador && ((Auth::user()->ambassadors->count() && Auth::user()->ambassadors->where('ambassador_user_id',$ambassador->id)->first()) || $ambassador->id == Auth::id())){
            $ambassador_user_created_date = Auth::user()->ambassadors->where('ambassador_user_id',$ambassador->id)->first()->created_at->format('Y-m-d');
            if($request->ajax() && isset($request->year) && $request->year){
                $first_date_of_current_year = date('Y-m-d',strtotime(date($request->year.'-01-01')));
                $last_date_of_current_year = $request->year.'-12-31';
            }else{
                $first_date_of_current_year = date('Y-m-d',strtotime(date('Y-01-01')));
                $last_date_of_current_year = date('Y-m-d', strtotime('Dec 31'));
            }

            if(strtotime($first_date_of_current_year) <= strtotime($ambassador_user_created_date)){
                $first_date_of_current_year = date('Y-m-01',strtotime($ambassador_user_created_date));
            }
            $user_created_year = date('Y',strtotime($ambassador_user_created_date));

            $user_run_year = AmbassadorRun::where('user_id', $id)->whereDate('date','>=',date('Y-m-d',strtotime(date($user_created_year.'-01-01'))))->orderBy('date','DESC')->get()->groupBy(function ($value) {
                return \Illuminate\Support\Carbon::parse($value->date)->format('Y');
            });

            $user_run_months = AmbassadorRun::where('user_id', $id)->whereBetween('date',[$first_date_of_current_year,$last_date_of_current_year])->orderBy('date','DESC')->get()->groupBy(function ($value) {
                return \Illuminate\Support\Carbon::parse($value->date)->format('m-Y');
            });
            if($request->ajax() && isset($request->year) && $request->year){
                $data = View::make('ambassadors.view-ambassador-year-months-table',compact('ambassador','user_run_months'))->render();
                $response = array();
                $response['data'] = $data;
                return json_encode($response);
                exit;
            }else{
                return view('ambassadors.view-ambassador',compact('ambassador','user_run_months','user_run_year'));

            }
        }else{
            abort(404);
        }
    }

    //View ambassador single month runs detail
    public function view_ambassador_single_month_runs($id,$month,Request $request){
        $ambassador = User::find($id);
        if($ambassador && ((Auth::user()->ambassadors->count() && Auth::user()->ambassadors->where('ambassador_user_id',$ambassador->id)->first()) || $ambassador->id == Auth::id())){
            $start_date = isset($request->start_date) && $request->start_date ? $request->start_date : date('Y-m-01',strtotime('01-'.$month));
            $end_date =  isset($request->end_date) && $request->end_date ? $request->end_date : date('Y-m-t',strtotime('01-'.$month));
            $ambassador_runs = AmbassadorRun::where('user_id',$id)
                ->when(($start_date), function($query) use ($start_date) {
                    if($start_date){
                        $query->whereDate('date','>=',$start_date);
                    }
                })->when(($end_date), function($query) use ($end_date) {
                    if($end_date){
                        $query->whereDate('date','<=',$end_date);
                    }
                })->when(($request->range_start), function($query) use ($request) {
                    if($request->range_start){
                        $query->where('distance','>=',$request->range_start);
                    }
                })->when(($request->range_end), function($query) use ($request) {
                    if($request->range_end){
                        $query->where('distance','<=',$request->range_end);
                    }
                })->orderBy('date','DESC')->get();

            return view('ambassadors.view-ambassador-single-month-detail',compact('ambassador','ambassador_runs','month'));

        }else{
            abort(404);
        }

    }
}
