<?php

namespace App\Http\Controllers;

use App\Models\OurTopAmbassadors;
use App\Models\Payment;
use App\Models\Setting;
use DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AmbassadorRun;
use App\Models\AmbassadorPayment;
use App\Models\SponsorAmbassador;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\SponsorAmbassadorPayment;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::when(($request->first_name), function($query) use ($request) {
            if($request->first_name){
                $query->where('users.first_name', 'LIKE', '%'.$request->first_name.'%');
            }
        })->when(($request->last_name), function($query) use ($request) {
            if($request->last_name){
                $query->where('users.last_name', 'LIKE', '%'.$request->last_name.'%');
            }
        })->when(($request->email), function($query) use ($request) {
            if($request->email){
                $query->where('users.email', 'LIKE', '%'.$request->email.'%');
            }
        })->when(($request->mobile_no), function($query) use ($request) {
            if($request->mobile_no){
                $query->where('users.mobile_no', 'LIKE', '%'.$request->email.'%');
            }
        })->when(is_numeric($request->status), function($query) use ($request) {
            if(is_numeric($request->status)){
                $query->where('users.status',$request->status);
            }
        })->when(($request->role), function($query) use ($request) {
            if($request->role){
                $query->whereHas('roles',function ($q) use($request){
                    $q->where('roles.slug',$request->role);
                });
            }
        })->orderBy('id','DESC')->get();
        $roles = Role::where('slug','<>','user')->where('slug','<>','unverified')->where('slug','<>','contributor')->get();
        return view('admin.users.list-users',compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role_id' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'mobile_no' => ['nullable', 'digits:8'],
        ]);
        DB::beginTransaction();
        try{
            $org_password = $request->password;
            $password = Hash::make($org_password);
            $request->merge(['password'=>$password]);
            $user = new User($request->except('role_id'));
            $user->save();
            //attach user role
            $user->attachRole($request->role_id);

            $email = $user->email;
            $setting_obj = new Setting();
            Mail::send('mail.admin-create-user',compact('org_password','user','setting_obj'), function ($message) use ($email) {
                $message->to($email)->subject('Konto opprettet');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            DB::commit();

            flash('User has been created successfully.')->success()->important();
            return redirect()->route('admin.users.index');
        }catch (\Exception $e){
            DB::rollback();
            flash('Something went wrong.')->error()->important();
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if($user){
            $data = View::make('admin.users.edit-user',compact('user'))->render();
            $response = array();
            $response['data'] = $data;
            return json_encode($response);
            exit;
        }else{
            flash('Record not found.')->error()->important();
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($user){
            DB::beginTransaction();
            try{
                if($request->password){
                    $password = Hash::make($request->password);
                    $request->merge(['password'=>$password]);
                    $user->update($request->except('role_id'));
                }else{
                    $user->update($request->except('role_id','password'));
                }
                DB::commit();
                flash('User has been updated successfully.')->success()->important();
                return redirect()->route('admin.users.index');
            }catch (\Exception $e){
                DB::rollback();
                flash('Something went wrong.')->error()->important();
                return back()->withInput();
            }
        }else{
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user && $user->id != Auth::id()){
            DB::beginTransaction();
            try{

                if($user->metas->count()){
                    flash('User can\'t be deleted, it has some data. You can deactivate this user for accessing runwithsyed.')->error()->important();
                    return back();
                }

                if($user->hasRole('ambassador')){
                    if($user->runs->count()){
                        flash('User can\'t be deleted, it has some register runs. You can deactivate this user for accessing runwithsyed.')->error()->important();
                        return back();
                    }

                    if($user->ambassador_payments->count()){
                        flash('User can\'t be deleted, it has some payments. You can deactivate this user for accessing runwithsyed.')->error()->important();
                        return back();
                    }
                }

                if($user->hasRole('sponsor')){
                    if($user->ambassadors->count()){
                        flash('User can\'t be deleted, it has some ambassadors. You can deactivate this user for accessing runwithsyed.')->error()->important();
                        return back();
                    }

                    if($user->sponsor_payments->count()){
                        flash('User can\'t be deleted, it has some payments. You can deactivate this user for accessing runwithsyed.')->error()->important();
                        return back();
                    }
                }

                $user->delete();
                DB::commit();
                flash('User has been deleted successfully.')->success()->important();
                return redirect()->route('admin.users.index');
            }catch (\Exception $e){
                DB::rollback();
                flash('Something went wrong.')->error()->important();
                return back()->withInput();
            }
        }else{
            abort(404);
        }
    }

    //Edit user profile
    public function edit_profile($id){
        $user = User::find($id);
        if($user){
            if($user->hasRole('admin')){
                return view('admin.profile',compact('user'));
            }else{

            }
        }else{
            abort(404);
        }
    }

    //Update admin user profile
    public function update_profile(Request $request, $id){
        $user = User::find($id);
        if($user){
            $validatedData = $request->validate([
                'email' => 'required|unique:users,email,'.$id,
                'mobile_no' => ['nullable', 'digits:8'],
            ]);
            $change_password = false;
            if($request->new_password || $request->confirm_password){
                if($request->new_password != $request->confirm_password){
                    flash('Passord og bekreft passord må være det samme.')->error()->important();
                    return back()->withInput();
                }else{
                    $change_password = true;
                }
            }
            DB::beginTransaction();
            try{
                if($change_password){
                    $request->merge(['password'=>Hash::make($request->new_password)]);
                }
                $user->update($request->except('confirm_password','new_password'));
                DB::commit();
                flash('Profile has been update successfully.')->success()->important();
                return back()->withInput();
            }catch (\Exception $e){
                DB::rollback();
                flash('something went wrong.')->error()->important();
                return back()->withInput();
            }
        }else{
            abort(404);
        }
    }
    //get ambassador detail for admin role
    public function ambassador_detail($id, Request $request) {
        if (\Auth::check()) {
        if(session()->get('locale') !== 'en') {
            session()->put('locale', 'en');
        }
         $user = User::findOrFail($id);
         // amabasder history
        $user_runs = AmbassadorRun::where('user_id',$id)
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
            })->orderBy('date','DESC')->get();

            // ambasder payment history
            $payments = Payment::where('payment_user','ambassador')->whereHas('ambassador_payment',function ($q) use($id){
                $q->where('ambassador_payments.user_id',$id);
            })->when(($request->price_start), function($query) use ($request) {
                if($request->price_start){
                    $query->where('amount','>=',$request->price_start);
                }
            })->when(($request->price_end), function($query) use ($request) {
                if($request->price_end){
                    $query->where('amount','<=',$request->price_start);
                }
            })->when(($request->status), function($query) use ($request) {
                if($request->status){
                    $query->where('status',$request->status);
                }
            })->when(($request->payment_date_start), function($query) use ($request) {
                if($request->payment_date_start){
                    $query->whereDate('created_at','>=',$request->payment_date_start);
                }
            })->when(($request->payment_date_end), function($query) use ($request) {
                if($request->payment_date_end){
                    $query->whereDate('created_at','<=',$request->payment_date_end);
                }
            })->when(($request->paying_month), function($query) use ($request) {
                if($request->paying_month){
                    $paying_month = date('m-Y',strtotime($request->paying_month.'-01'));
                    $query->whereHas('ambassador_payment',function ($q) use($paying_month){
                        $q->where('month_year',$paying_month);
                    });
                }
            })->orderBy('id','DESC')->get();

            // Dine sponsorer
            $user_sponsors = SponsorAmbassador::where('ambassador_user_id',$id)
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
            })->orderBy('id','DESC')->get();

        return view('admin.users.ambassador-detail', compact('user', 'user_runs', 'payments', 'user_sponsors'));
        }else {
            abort(403);
        }
    }

    //Sponsor detail
    public function sponsor_detail($id, Request $request){
        $user = User::findOrFail($id);
        if(session()->get('locale') !== 'en') {
            session()->put('locale', 'en');
        }

        $payments = Payment::where('payment_user','sponsor')->whereHas('sponsor_payment.sponsor_ambassador',function ($q) use($id){
            $q->where('sponsor_ambassadors.sponsor_user_id',$id);
        })->when(($request->price_start), function($query) use ($request) {
            if($request->price_start){
                $query->where('amount','>=',$request->price_start);
            }
        })->when(($request->price_end), function($query) use ($request) {
            if($request->price_end){
                $query->where('amount','<=',$request->price_start);
            }
        })->when(($request->status), function($query) use ($request) {
            if($request->status){
                $query->where('status',$request->status);
            }
        })->when(($request->payment_date_start), function($query) use ($request) {
            if($request->payment_date_start){
                $query->whereDate('created_at','>=',$request->payment_date_start);
            }
        })->when(($request->payment_date_end), function($query) use ($request) {
            if($request->payment_date_end){
                $query->whereDate('created_at','<=',$request->payment_date_end);
            }
        })->when(($request->paying_month), function($query) use ($request) {
            if($request->paying_month){
                $paying_month = date('m-Y',strtotime($request->paying_month.'-01'));
                $query->whereHas('sponsor_payment',function ($q) use($paying_month){
                    $q->where('sponsor_ambassador_payments.month_year',$paying_month);
                });
            }
        })->orderBy('id','DESC')->get();

        $user_ambassadors = SponsorAmbassador::where('sponsor_user_id',$id)
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
            })->orderBy('id','DESC')->get();

        return view('admin.users.sponsor-detail',compact('user','payments','user_ambassadors'));
    }

    //Show all ambassadors in admin panel to show our top ambassadors in out ambassadors page
    public function edit_our_top_ambassadors(){
        $ambassadors = User::whereHas('roles',function ($query){
            $query->where('roles.slug','ambassador');
        })->whereStatus(1)->orderBy('id','DESC')->get();
        $our_top_ambassadors = OurTopAmbassadors::orderBy('order','ASC')->get();
        return view('admin.users.our-top-ambassadors',compact('ambassadors','our_top_ambassadors'));
    }

    //Store our top ambassadors
    public function store_our_top_ambassadors(Request $request){
        DB::beginTransaction();
        try{
            DB::table('our_top_ambassadors')->delete();
            if(isset($request->ambassador_id) && count($request->ambassador_id) && isset($request->ambassador_orders) && ($request->ambassador_orders)){
                $ambassador_orders_arr = json_decode($request->ambassador_orders);
                if(count($ambassador_orders_arr)){
                    foreach ($ambassador_orders_arr as $ambassador_obj){
                        if(isset($ambassador_obj[0]) && isset($ambassador_obj[0]->ambassador_id) && isset($ambassador_obj[1]) && isset($ambassador_obj[1]->order)){
                            OurTopAmbassadors::updateOrCreate(['user_id' => $ambassador_obj[0]->ambassador_id],['order' => $ambassador_obj[1]->order]);
                        }
                    }
                }
                flash('Record has been updated successfully')->success()->important();
            }else{
                flash('Record has been deleted successfully')->error()->important();
            }
            DB::commit();

            return back()->withInput();
        }catch (\Exception $e){
            DB::rollback();
            flash('something went wrong.')->error()->important();
            return back()->withInput();
        }
    }
}
