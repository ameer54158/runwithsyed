<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $donations = Payment::where('payment_user','donation')->when(is_numeric($request->start_amount), function($query) use ($request) {
                if(is_numeric($request->start_amount)){
                    $query->where('amount','>=',$request->start_amount);
                }
            })->when(is_numeric($request->end_amount), function($query) use ($request) {
                if(is_numeric($request->end_amount)){
                    $query->where('amount','<=',$request->end_amount);
                }
            })->when(($request->payment_start_date), function($query) use ($request) {
                if($request->payment_start_date){
                    $query->whereDate('created_at','>=',$request->payment_start_date);
                }
            })->when(($request->payment_end_date), function($query) use ($request) {
                if($request->payment_end_date){
                    $query->whereDate('created_at','<=',$request->payment_end_date);
                }
            })->when(($request->status), function($query) use ($request) {
                if($request->status){
                    $query->where('status',$request->status);
                }
            })->orderBy('id','DESC')->get();
            return view('admin.list-donations', compact('donations'));
        }catch (\Exception $e){
            flash('Something went wrong.')->error()->important();
            return back()->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$call_by='')
    {
        $validatedData = $request->validate([
            'amount' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $amount = ($request->amount === 'custom_amount' ? $request->custom_amount : $request->amount);
            if($amount <= 1){
                Session::flash('show_donation_modal', true);
                flash(__('flash-messages.amount must be larger than 1kr.'))->error()->important();
                return back();
            }
            if(!$call_by){
                session(['payment_type' => 'donation','form_request' => $request->all()]);
                return redirect()->route('payment',$amount);
            }

            if(session('order_id') && session('transaction_id') && session('status') && session('status') == 'captured'){
                //Create payment
                $payment = Payment::create([
                    'order_id' => session('order_id'),'transaction_id' => session('transaction_id'), 'amount' => $amount, 'payment_user' => 'donation', 'status'=> 'completed'
                ]);

                if($payment && $payment->id && $request->name){
                    //Create donation
                    Donation::create([
                        'name' => $request->name, 'payment_id' => $payment->id
                    ]);
                }

                //Send email to all admin user
                $admin_users = (new User())->admin_users();
                if($admin_users->count()){
                    foreach ($admin_users as $admin_user){
                        $admin_email = $admin_user->email;
                        $email_text = (isset($request->name) && $request->name ? $request->name : 'Noen')." har donert RWS med <strong>".number_format($amount,'2',',','.')."kr</strong> gjennom engangsbidrag.";
                        Mail::send('mail.admin-payment-notification',compact('email_text'), function ($message) use ($admin_email) {
                            $message->to($admin_email)->subject('Donasjon mottatt');
                            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        });
                    }
                }
            }
            DB::commit();
            session()->forget(['order_id','transaction_id', 'status','payment_type','form_request']);
            flash( __('flash-messages.you have donated successfully.'))->success()->important();
            return redirect()->route('home')->with('donation-model','true');
        }catch (\Exception $e){
            DB::rollback();
            Session::flash('show_donation_modal', true);
            flash(__('flash-messages.Something went wrong.'))->error()->important();
            return back();
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
        try {
            $donation = Donation::findOrFail($id);
            return view('admin.donation-detail',compact('donation'));
        } catch (\Exception $e) {
            flash('Record not found.')->error()->important();
            return back();
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
        //
    }
}
