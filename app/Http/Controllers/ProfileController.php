<?php

namespace App\Http\Controllers;

use App\Models\AmbassadorPayment;
use App\Models\AmbassadorRun;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\SponsorAmbassador;
use App\Models\SponsorAmbassadorPayment;
use App\Models\User;
use App\Helpers\common;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PDF;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    public function index(Request $request,$call_by = '') {
        if (\Auth::check()) {
            $user = auth()->user();
            $setting_obj = new Setting();

            //User run
            $user_runs = AmbassadorRun::where('user_id',Auth::id())
                ->when(($request->tab_type), function($query) use ($request) {
                    if($request->tab_type == 'history'){
                        $query->when(($request->start_date), function($query) use ($request) {
                            if($request->start_date){
                                $query->whereDate('date','>=',$request->start_date);
                            }
                        })->when(($request->end_date), function($query) use ($request) {
                            if($request->end_date){
                                $query->whereDate('date','<=',$request->end_date);
                            }
                        })->when(($request->range_start), function($query) use ($request) {
                            if($request->range_start){
                                $query->where('distance','>=',$request->range_start);
                            }
                        })->when(($request->range_end), function($query) use ($request) {
                            if($request->range_end){
                                $query->where('distance','<=',$request->range_end);
                            }
                        });
                    }
                })->orderBy('date','DESC');
            if(isset($request->btn_type) && $request->btn_type == 'km_pdf'){
                $user_runs = $user_runs->get();
                $pdf = \PDF::loadView('pdf.pdf-km-history', compact('user','user_runs'));
                return $pdf->download('runs-report.pdf');
            }
            $user_runs = $user_runs->get();
            $first_date_of_current_year = date('Y-m-d',strtotime(date('Y-01-01')));
            $last_date_of_current_year = date('Y-m-d', strtotime('Dec 31'));
            $user_run_months = AmbassadorRun::where('user_id', Auth::id())->whereBetween('date',[$first_date_of_current_year,$last_date_of_current_year])->orderBy('date','DESC')->get()->groupBy(function ($value) {
                return \Illuminate\Support\Carbon::parse($value->date)->format('m-Y');
            });

            //Ambassador payment history
            $month_range = common::get_month_between_range($request->all());
            $month_range_arr = $month_range['month_range_arr'];
            $month_range_filter = $month_range['month_range_filter'];
            $show_message = $month_range['show_message'];

            $ambassador_payments = Payment::where('payment_user','ambassador')->whereHas('ambassador_payment',function ($q) use($request){
                $q->where('ambassador_payments.user_id','<=',Auth::id());
            })->when(($request->tab_type), function($query) use ($request,$month_range_filter,$month_range_arr) {
                if($request->tab_type == 'ambassador_payment_history'){
                    $query->when(($request->price_start), function($query) use ($request) {
                        if($request->price_start){
                            $query->where('amount','>=',$request->price_start);
                        }
                    })->when(($request->price_end), function($query) use ($request) {
                        if($request->price_end){
                            $query->where('amount','<=',$request->price_end);
                        }
                    })->when(($request->status), function($query) use ($request) {
                        if($request->status){
                            $query->where('status',$request->status);

                            $query->whereHas('payment',function ($q) use($request){
                                $q->where('payments.status',$request->status);
                            });
                        }
                    })->when(($month_range_filter), function($query) use ($request,$month_range_filter,$month_range_arr) {
                        if($month_range_filter && count($month_range_arr)) {
                            $query->whereHas('ambassador_payment',function ($q) use($month_range_arr){
                                $q->where('ambassador_payments.month_year',$month_range_arr);
                            });
                        }
                    })->when(($request->payment_date_start), function($query) use ($request) {
                        if($request->payment_date_start){
                            $query->whereDate('created_at','>=',$request->payment_date_start);
                        }
                    })->when(($request->payment_date_end), function($query) use ($request) {
                        if($request->payment_date_end){
                            $query->whereDate('created_at','<=',$request->payment_date_end);
                        }
                    });
                }
            })->orderBy('id','DESC');

            if(!$show_message && isset($request->btn_type) && $request->btn_type == 'ambassador_payments_pdf'){
                $ambassador_payments = $ambassador_payments->get();
                $pdf = \PDF::loadView('pdf.pdf-ambassador-payment-history', compact('user','ambassador_payments'));
                return $pdf->download('payment-report.pdf');
            }

            $ambassador_payments = $ambassador_payments->get();

            if($show_message){
                flash(__('flash-messages.Please select a valid month range to get accurate result.'))->error()->important();
            }

            //My sponsors
            $user_sponsors = SponsorAmbassador::where('ambassador_user_id',Auth::id())
                ->when(($request->tab_type), function($query) use ($request) {
                    if($request->tab_type == 'my_sponsors'){
                        $query->when(($request->first_name), function($query) use ($request) {
                            if($request->first_name){
                                $query->whereHas('sponsor_user',function ($q) use($request){
                                    $q->where('users.first_name', 'LIKE', '%'.$request->first_name.'%');
                                });
                            }
                        })->when(($request->last_name), function($query) use ($request) {
                            if($request->last_name){
                                $query->whereHas('sponsor_user',function ($q) use($request){
                                    $q->where('users.last_name', 'LIKE', '%'.$request->last_name.'%');
                                });
                            }
                        })->when(($request->email), function($query) use ($request) {
                            if($request->email){
                                $query->whereHas('sponsor_user',function ($q) use($request){
                                    $q->where('users.email', 'LIKE', '%'.$request->email.'%');
                                });
                            }
                        })->when(($request->date_start), function($query) use ($request) {
                            if($request->date_start){
                                $query->whereDate('created_at','>=',$request->date_start);
                            }
                        })->when(($request->date_end), function($query) use ($request) {
                            if($request->date_end){
                                $query->whereDate('created_at','<=',$request->date_end);
                            }
                        })->when(($request->status), function($query) use ($request) {
                            if(is_numeric($request->status)){
                                $query->where('status',$request->status);
                            }
                        });
                    }
                })->orderBy('id','DESC')->get();


            $sponsor_month_range = common::get_month_between_range($request->all());
            $sponsor_month_range_arr = $sponsor_month_range['month_range_arr'];
            $sponsor_month_range_filter = $sponsor_month_range['month_range_filter'];
            $sponsor_show_message = $sponsor_month_range['show_message'];


            $sponsor_payments = Payment::where('payment_user','sponsor')->whereHas('sponsor_payment.sponsor_ambassador',function ($q) use($request){
                $q->where('sponsor_ambassadors.sponsor_user_id',Auth::id());
            })->when(($request->tab_type), function($query) use ($request,$sponsor_month_range_filter,$sponsor_month_range_arr) {
                if($request->tab_type == 'sponsor_payment_history'){
                    $query->when(($request->name), function($query) use ($request) {
                        if($request->name){
                            $query->whereHas('sponsor_payment.sponsor_ambassador.ambassador_user',function ($q) use($request) {
                                $q->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', '%' . $request->name . '%');
                            });
                        }
                    })->when(($request->email), function($query) use ($request) {
                        if($request->email){
                            $query->whereHas('sponsor_payment.sponsor_ambassador.ambassador_user',function ($q) use($request){
                                $q->where('users.email', 'LIKE', '%'.$request->email.'%');
                            });
                        }
                    })->when(($request->price_start), function($query) use ($request) {
                        if($request->price_start){
                            $query->where('payments.amount','>=',$request->price_start);
                        }
                    })->when(($request->price_end), function($query) use ($request) {
                        if($request->price_end){
                            $query->where('payments.amount','<=',$request->price_end);
                        }
                    })->when(($request->status), function($query) use ($request) {
                        if($request->status){
                            $query->where('payments.status',$request->status);
                        }
                    })->when(($sponsor_month_range_filter), function($query) use ($request,$sponsor_month_range_filter,$sponsor_month_range_arr) {
                        if($sponsor_month_range_filter && count($sponsor_month_range_arr)) {
                            $query->whereHas('sponsor_payment',function ($q) use($sponsor_month_range_arr){
                                $q->whereIn('sponsor_ambassador_payments.month_year',$sponsor_month_range_arr);
                            });
                        }
                    })->when(($request->payment_date_start), function($query) use ($request) {
                        if($request->payment_date_start){
                            $query->whereDate('created_at','>=',$request->payment_date_start);
                        }
                    })->when(($request->payment_date_end), function($query) use ($request) {
                        if($request->payment_date_end){
                            $query->whereDate('created_at','<=',$request->payment_date_end);
                        }
                    });
                }
            })->orderBy('id','DESC');

            if(!$sponsor_show_message && isset($request->btn_type) && $request->btn_type == 'pdf'){
                $sponsor_payments = $sponsor_payments->get();
                $pdf = \PDF::loadView('pdf.pdf-sponsor-payment-history', compact('user','sponsor_payments'));
                return $pdf->download('payment-report.pdf');
            }
            if($sponsor_show_message){
                flash(__('flash-messages.Please select a valid month range to get accurate result.'))->error()->important();
            }
            $sponsor_payments = $sponsor_payments->get();

            $user_ambassadors = SponsorAmbassador::where('sponsor_user_id',Auth::id())
                ->when(($request->tab_type), function($query) use ($request) {
                    if($request->tab_type == 'my_ambassadors'){
                        $query->when(($request->first_name), function($query) use ($request) {
                            if($request->first_name){
                                $query->whereHas('ambassador_user',function ($q) use($request){
                                    $q->where('users.first_name', 'LIKE', '%'.$request->first_name.'%');
                                });
                            }
                        })->when(($request->last_name), function($query) use ($request) {
                            if($request->last_name){
                                $query->whereHas('ambassador_user',function ($q) use($request){
                                    $q->where('users.last_name', 'LIKE', '%'.$request->last_name.'%');
                                });
                            }
                        })->when(($request->email), function($query) use ($request) {
                            if($request->email){
                                $query->whereHas('ambassador_user',function ($q) use($request){
                                    $q->where('users.email', 'LIKE', '%'.$request->email.'%');
                                });
                            }
                        })->when(($request->date_start), function($query) use ($request) {
                            if($request->date_start){
                                $query->whereDate('created_at','>=',$request->date_start);
                            }
                        })->when(($request->date_end), function($query) use ($request) {
                            if($request->date_end){
                                $query->whereDate('created_at','<=',$request->date_end);
                            }
                        })->when(($request->status), function($query) use ($request) {
                            if(is_numeric($request->status)){
                                $query->where('status',$request->status);
                            }
                        });
                    }
                })->orderBy('id','DESC')->get();
            return view('profile', compact('user','setting_obj','user_runs','ambassador_payments','user_sponsors','user_run_months','sponsor_payments','user_ambassadors'));
        }else {
            abort(403);
        }
    }

    //Update profile for ambassador or sponsor users
    public function update_profile(Request $request, $id)
    {
        $validator = $request->validate([
            'mobile_no' => 'required|digits:8',
            'email' => 'required|unique:users,email,'.$id,
            'fname' => 'required',
            'lname' => 'required',
            'gender' => 'required',
            'address' => 'nullable',
            'postnummer' => 'nullable',
            'city' => 'nullable',
            'password' => 'nullable|confirmed',
            'description' => 'nullable'
        ]);
        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);
            $user->first_name = $request->fname;
            $user->last_name = $request->lname;
            $user->email = $request->email;
            $user->mobile_no = $request->mobile_no;
            if($request->password && $request->password_confirmation){
                $user->password = bcrypt($request->password);
            }
            $user->save();

            //update Detail
            UserDetail::updateOrCreate([
                'user_id' => \Auth::user()->id,
            ], [
                'gender' => $request->gender,
                'zip_code' => $request->postnummer,
                'zip_city' => $request->city,
                'address' => $request->address,
                'description' => $request->description,
                'profile_image_permission' => $request->profile_image_permission,
            ]);

            //save profile image
            if($request->has('profile_image')) {
                common::update_media($request->profile_image,$user->id,User::class,'profile-image', $user->image_size(), true);
            }

            DB::commit();
            flash(__('flash-messages.profile update'))->success()->important();
            return back()->with(['show_tab'=>'profile']);
        }catch (\Exception $e){
            DB::rollback();
            flash(__('flash-messages.Something went wrong.'))->error()->important();
            return back();
        }
    }

    //Register Km
    public function register_km(){
        $user = auth()->user();
        $setting_obj = new Setting();
        return view('profile.register-km',compact('user','setting_obj'));
    }

    //km history
    public function km_history(Request $request){
        $user = auth()->user();
        $user_runs = AmbassadorRun::where('user_id',Auth::id())
            ->when(($request->start_date), function($query) use ($request) {
                if($request->start_date){
                    $query->whereDate('date','>=',$request->start_date);
                }
            })->when(($request->end_date), function($query) use ($request) {
                if($request->end_date){
                    $query->whereDate('date','<=',$request->end_date);
                }
            })->when(($request->range_start), function($query) use ($request) {
                if($request->range_start){
                    $query->where('distance','>=',$request->range_start);
                }
            })->when(($request->range_end), function($query) use ($request) {
                if($request->range_end){
                    $query->where('distance','<=',$request->range_end);
                }
            })->orderBy('date','DESC');
        if(isset($request->btn_type) && $request->btn_type == 'pdf'){
            $user_runs = $user_runs->get();
            $pdf = \PDF::loadView('pdf.pdf-km-history', compact('user','user_runs'));
            return $pdf->download('runs-report.pdf');
        }
        $user_runs = $user_runs->paginate(20);
            $user_run_months = AmbassadorRun::where('user_id', Auth::id())->orderBy('date','DESC')->get()->groupBy(function ($value) {
                return \Illuminate\Support\Carbon::parse($value->date)->format('F, Y');
            });
           

        return view('profile.km-history',compact('user_runs','user', 'user_run_months'));
    }

    //ambassador payment history
    public function ambassador_payment_history(Request $request){
        $user = auth()->user();
        $month_range = common::get_month_between_range($request->all());
        $month_range_arr = $month_range['month_range_arr'];
        $month_range_filter = $month_range['month_range_filter'];
        $show_message = $month_range['show_message'];

        $ambassador_payments = AmbassadorPayment::where('ambassador_payments.user_id',Auth::id())
            ->when(($request->price_start), function($query) use ($request) {
                if($request->price_start){
                    $query->whereHas('payment',function ($q) use($request){
                        $q->where('payments.amount','>=',$request->price_start);
                    });
                }
            })->when(($request->price_end), function($query) use ($request) {
                if($request->price_end){
                    $query->whereHas('payment',function ($q) use($request){
                        $q->where('payments.amount','<=',$request->price_end);
                    });
                }
            })->when(($request->status), function($query) use ($request) {
                if($request->status){
                    $query->whereHas('payment',function ($q) use($request){
                        $q->where('payments.status',$request->status);
                    });
                }
            })->when(($month_range_filter), function($query) use ($request,$month_range_filter,$month_range_arr) {
                if($month_range_filter && count($month_range_arr)) {
                    $query->whereIn('month_year',$month_range_arr);
                }
            })->when(($request->payment_date_start), function($query) use ($request) {
                if($request->payment_date_start){
                    $query->whereDate('created_at','>=',$request->payment_date_start);
                }
            })->when(($request->payment_date_end), function($query) use ($request) {
                if($request->payment_date_end){
                    $query->whereDate('created_at','<=',$request->payment_date_end);
                }
            })->orderBy('id','DESC');

        if(!$show_message && isset($request->btn_type) && $request->btn_type == 'pdf'){
            $ambassador_payments = $ambassador_payments->get();
            $pdf = \PDF::loadView('pdf.pdf-ambassador-payment-history', compact('user','ambassador_payments'));
            return $pdf->download('payment-report.pdf');
        }

        $ambassador_payments = $ambassador_payments->paginate(20);

        if($show_message){
            flash(__('flash-messages.Please select a valid month range to get accurate result.'))->error()->important();
        }

        return view('profile.ambassador-payment-history',compact('user','ambassador_payments'));
    }

    //My sponsors
    public function my_sponsors(Request $request){
        $user = auth()->user();
        $user_sponsors = SponsorAmbassador::where('ambassador_user_id',Auth::id())
            ->when(($request->first_name), function($query) use ($request) {
                if($request->first_name){
                    $query->whereHas('sponsor_user',function ($q) use($request){
                        $q->where('users.first_name', 'LIKE', '%'.$request->first_name.'%');
                    });
                }
            })->when(($request->last_name), function($query) use ($request) {
                if($request->last_name){
                    $query->whereHas('sponsor_user',function ($q) use($request){
                        $q->where('users.last_name', 'LIKE', '%'.$request->last_name.'%');
                    });
                }
            })->when(($request->email), function($query) use ($request) {
                if($request->email){
                    $query->whereHas('sponsor_user',function ($q) use($request){
                        $q->where('users.email', 'LIKE', '%'.$request->email.'%');
                    });
                }
            })->when(($request->date_start), function($query) use ($request) {
                if($request->date_start){
                    $query->whereDate('created_at','>=',$request->date_start);
                }
            })->when(($request->date_end), function($query) use ($request) {
                if($request->date_end){
                    $query->whereDate('created_at','<=',$request->date_end);
                }
            })->when(($request->status), function($query) use ($request) {
                if(is_numeric($request->status)){
                    $query->where('status',$request->status);
                }
            })->orderBy('id','DESC')->paginate(20);

        return view('profile.my-sponsors',compact('user_sponsors','user'));
    }

    //Sponsor payment history
    public function sponsor_payment_history(Request $request){
        $user = auth()->user();
        $month_range = common::get_month_between_range($request->all());
        $month_range_arr = $month_range['month_range_arr'];
        $month_range_filter = $month_range['month_range_filter'];
        $show_message = $month_range['show_message'];

        $sponsor_payments = SponsorAmbassadorPayment::whereHas('sponsor_ambassador',function ($q) use($request){
            $q->where('sponsor_ambassadors.sponsor_user_id',Auth::id());
        })->when(($request->name), function($query) use ($request) {
            if($request->name){
                $query->whereHas('sponsor_ambassador.ambassador_user',function ($q) use($request) {
                    $q->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', '%' . $request->name . '%');
                });
            }
        })->when(($request->email), function($query) use ($request) {
            if($request->email){
                $query->whereHas('sponsor_ambassador.ambassador_user',function ($q) use($request){
                    $q->where('users.email', 'LIKE', '%'.$request->email.'%');
                });
            }
        })->when(($request->price_start), function($query) use ($request) {
            if($request->price_start){
                $query->whereHas('payment',function ($q) use($request){
                    $q->where('payments.amount','>=',$request->price_start);
                });
            }
        })->when(($request->price_end), function($query) use ($request) {
            if($request->price_end){
                $query->whereHas('payment',function ($q) use($request){
                    $q->where('payments.amount','<=',$request->price_end);
                });
            }
        })->when(($request->status), function($query) use ($request) {
            if($request->status){
                $query->whereHas('payment',function ($q) use($request){
                    $q->where('payments.status',$request->status);
                });
            }
        })->when(($month_range_filter), function($query) use ($request,$month_range_filter,$month_range_arr) {
            if($month_range_filter && count($month_range_arr)) {
                $query->whereIn('month_year',$month_range_arr);
            }
        })->when(($request->payment_date_start), function($query) use ($request) {
            if($request->payment_date_start){
                $query->whereDate('created_at','>=',$request->payment_date_start);
            }
        })->when(($request->payment_date_end), function($query) use ($request) {
            if($request->payment_date_end){
                $query->whereDate('created_at','<=',$request->payment_date_end);
            }
        })->orderBy('id','DESC');

        if(!$show_message && isset($request->btn_type) && $request->btn_type == 'pdf'){
            $sponsor_payments = $sponsor_payments->get();
            $pdf = \PDF::loadView('pdf.pdf-sponsor-payment-history', compact('user','sponsor_payments'));
            return $pdf->download('payment-report.pdf');
        }
        if($show_message){
            flash(__('flash-messages.Please select a valid month range to get accurate result.'))->error()->important();
        }
        $sponsor_payments = $sponsor_payments->paginate(20);
        return view('profile.sponsor-payment-history',compact('user','sponsor_payments'));
    }

    //My ambassadors
    public function my_ambassadors(Request $request){
        $user = auth()->user();
        $user_ambassadors = SponsorAmbassador::where('sponsor_user_id',Auth::id())
            ->when(($request->first_name), function($query) use ($request) {
                if($request->first_name){
                    $query->whereHas('ambassador_user',function ($q) use($request){
                        $q->where('users.first_name', 'LIKE', '%'.$request->first_name.'%');
                    });
                }
            })->when(($request->last_name), function($query) use ($request) {
                if($request->last_name){
                    $query->whereHas('ambassador_user',function ($q) use($request){
                        $q->where('users.last_name', 'LIKE', '%'.$request->last_name.'%');
                    });
                }
            })->when(($request->email), function($query) use ($request) {
                if($request->email){
                    $query->whereHas('ambassador_user',function ($q) use($request){
                        $q->where('users.email', 'LIKE', '%'.$request->email.'%');
                    });
                }
            })->when(($request->date_start), function($query) use ($request) {
                if($request->date_start){
                    $query->whereDate('created_at','>=',$request->date_start);
                }
            })->when(($request->date_end), function($query) use ($request) {
                if($request->date_end){
                    $query->whereDate('created_at','<=',$request->date_end);
                }
            })->when(($request->status), function($query) use ($request) {
                if(is_numeric($request->status)){
                    $query->where('status',$request->status);
                }
            })->orderBy('id','DESC')->paginate(20);
        return view('profile.my-ambassadors',compact('user','user_ambassadors'));
    }
}
