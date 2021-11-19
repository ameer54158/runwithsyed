<?php

namespace App\Http\Controllers;

use App\Helpers\common;
use App\Models\AmbassadorPayment;
use App\Models\Meta;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\SponsorAmbassador;
use App\Models\SponsorAmbassadorPayment;
use App\Models\User;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    //Ambassador pay some amount against his/her register Km's
    public function ambassador_pay_amount(Request $request,$call_by=''){
        DB::beginTransaction();
        try{
            $tab_type = 'history';
            if(isset($request->tab_type)){
                $tab_type = $request->tab_type;
            }

            $total_amount = 0;

            if(isset($request->month_year) && count($request->month_year)){
                foreach ($request->month_year as $month_year){
                    if(count($request->month_year) == 1){
                        //Store payment data
                        $total_amount = $request->amount;
                    }else{
                        $not_paying_month = common::ambassador_not_paying_month();
                        if($not_paying_month->count()){
                            $get_specific = $not_paying_month[date('Y-m',strtotime('01-'.$month_year))];
                            $total_amount += $get_specific->sum('distance');
                        }
                    }
                }
            }
            if($total_amount > 1){
                if(!$call_by){
                    session(['payment_type'=> 'ambassador_pay_amount','form_request' => $request->all()]);
                    return redirect()->route('payment',$total_amount);
                }
                if(session('order_id') && session('transaction_id') && session('status') && session('status') == 'captured'){
                    $payment = Payment::create(['order_id' => session('order_id'),'transaction_id' => session('transaction_id'), 'amount'=> $total_amount , 'status' => 'completed','payment_user' => 'ambassador']);
                    if($payment){
                        foreach ($request->month_year as $month_year){
//                        if(count($request->month_year) == 1){
//                            //Store payment data
//                            $payment = Payment::create(['amount'=> $request->amount , 'status' => 'completed','payment_user' => 'ambassador']);
//                        }else{
//                            $not_paying_month = common::ambassador_not_paying_month();
//                            $amount = 0;
//                            if($not_paying_month->count()){
//                                $get_specific = $not_paying_month[date('Y-m',strtotime('01-'.$month_year))];
//                                $amount = $get_specific->sum('distance');
//                            }
//                            //Store payment data
//                            $payment = Payment::create(['order_id' => session('order_id'),'transaction_id' => session('transaction_id'), 'amount'=> $amount , 'status' => 'completed','payment_user' => 'ambassador']);
//                        }

                            if(Auth::user()->hasRole('ambassador')){
                                //Ambassador Payment detail
                                $ambassador_payment = AmbassadorPayment::create([
                                    'user_id' => Auth::id(),
                                    'month_year' => $month_year,
                                    'payment_id' => $payment->id,
                                ]);
                            }
                        }
                        if($ambassador_payment){
                            //Send email to user and admin
                            $this->ambassador_payment_email($payment,$ambassador_payment);
                        }
                    }
                }
            } else{
                flash(__('flash-messages.amount must be larger than 1kr.'))->error()->important();
                return back();
            }
            DB::commit();
            session()->forget(['order_id','transaction_id', 'status','payment_type','form_request']);
            flash(__('flash-messages.amount paid'))->success()->important();
            return redirect(localized_route('profile').'#'.$tab_type);
        }catch (\Exception $e){
            DB::rollback();
            flash(__('flash-messages.Something went wrong.'))->error()->important();
            return redirect(localized_route('profile').'#'.$tab_type);
        }
    }

    //Send email to ambassador and admin when ambassador paid some amount
    public function ambassador_payment_email($payment,$ambassador_payment){
        //Send email to ambassador user
        $email = $ambassador_payment->user && $ambassador_payment->user->email ? $ambassador_payment->user->email : '';
        if($email){
            Mail::send('mail.ambassador-pay-amount',compact('payment'), function ($message) use ($email) {
                $message->to($email)->subject('Beløpet er betalt');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        }

        //Send email to all admin user
        $admin_users = (new User())->admin_users();
        if($admin_users->count()){
            foreach ($admin_users as $admin_user){
                $admin_email = $admin_user->email;
                $email_text = "Vi vil informere deg om at <strong>".($ambassador_payment->user && $ambassador_payment->user->first_name ? $ambassador_payment->user->first_name : '' )." ".($ambassador_payment->user && $ambassador_payment->user->last_name ? $ambassador_payment->user->last_name : '' )."</strong> har betalt <strong>".number_format($ambassador_payment->payment->amount,'2',',','.')."kr</strong>";
                if($payment->ambassador_payment->count() > 1){
                    $email_text .= " for de neste månedene.<ul style='padding-left: 10px;'>";
                    foreach ($payment->ambassador_payment as $ambassador_payment){
                        $email_text .= "<strong><li>".common::date_in_locale_lang(('01-'.$ambassador_payment->month_year),'M Y','nb')."</li></strong>";
                    }
                    $email_text .= "</ul>";
                }else{
                    $email_text .= " for <strong>".common::date_in_locale_lang(('01-'.$payment->ambassador_payment->first()->month_year),'M Y','nb')."</strong> måneden.";
                }
//                                for <strong>".date('M, Y', strtotime('01-'.$ambassador_payment->month_year))."</strong> måneden.";
                Mail::send('mail.admin-payment-notification',compact('email_text'), function ($message) use ($admin_email) {
                    $message->to($admin_email)->subject('En ambassadør har betalt');
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });
            }
        }
    }

    //Sponsor pay some amount against his/her ambassador
    public function sponsor_pay_amount(Request $request, $ambassador_id,$call_by=''){
        DB::beginTransaction();
        try{
            $ambassador = User::find($ambassador_id);
            $sponsor_ambassador = SponsorAmbassador::where('sponsor_user_id',Auth::id())->where('ambassador_user_id',$ambassador_id)->first();
            if($ambassador && $sponsor_ambassador){
                $not_paying_month = common::sponsor_not_paying_month($ambassador);
                $amount = 0;

                //Calculate the total amount
                if(isset($request->month_year) && count($request->month_year)){
                    foreach ($request->month_year as $month_year){
                        if($not_paying_month->count()){
                            $get_specific = $not_paying_month[date('Y-m',strtotime('01-'.$month_year))];
                            $amount += $get_specific->sum('distance');
                        }
                    }
                }else{
                    flash(__('profile.Please select a month to complete the payment. Thanks!'))->error()->important();
                    return back();
                }
                if($amount > 1){
                    if(!$call_by){
                        session(['payment_type'=> 'sponsor_pay_amount','ambassador_id'=> $ambassador_id,'form_request' => $request->all()]);
                        return redirect()->route('payment',$amount);
                    }

                    if(session('order_id') && session('transaction_id') && session('status') && session('status') == 'captured') {
                        $payment = Payment::create(['order_id' => session('order_id'), 'transaction_id' => session('transaction_id'), 'amount' => $amount, 'status' => 'completed', 'payment_user' => 'sponsor']);
                        if($payment){
                            foreach ($request->month_year as $month_year) {
                                //                        if($not_paying_month->count()){
                                //                            $get_specific = $not_paying_month[date('Y-m',strtotime('01-'.$month_year))];
                                //                            $amount = $get_specific->sum('distance');
                                //                        }

                                if ($amount) {
                                    //Store payment data
                                    //$payment = Payment::create(['amount' => $amount ? $amount : $request->amount, 'status' => 'completed', 'payment_user' => 'sponsor']);

                                    if ($sponsor_ambassador) {
                                        //Sponsor Payment detail
                                        $sponsor_payment = SponsorAmbassadorPayment::create([
                                            'sponsor_ambassador_id' => $sponsor_ambassador->id,
                                            'month_year' => $month_year,
                                            'payment_id' => $payment->id
                                        ]);
                                    }
                                }
                            }
                            if($sponsor_payment){
                                //Send email to sponsor
                                $this->sponsor_payment_email($payment, $sponsor_payment);
                            }
                        }
                    }
                }else{
                    flash(__('flash-messages.amount must be larger than 1kr.'))->error()->important();
                    return back();
                }

                //End code
                DB::commit();
                session()->forget(['order_id','transaction_id', 'status','payment_type','form_request','ambassador_id']);
                flash(__('flash-messages.amount paid'))->success()->important();
                return redirect(localized_route('ambassador-detail',$ambassador_id));
            }else{
                DB::rollback();
                flash(__('flash-messages.Something went wrong.'))->error()->important();
                return redirect(localized_route('ambassador-detail',$ambassador_id));
            }
        }catch (\Exception $e){
            DB::rollback();
            flash(__('flash-messages.Something went wrong.'))->error()->important();
            return redirect(localized_route('ambassador-detail',$ambassador_id));
        }
    }

    //Send email to sponsor and admin when an sponsor paid some amount of his/her ambassador
    public function sponsor_payment_email($payment, $sponsor_payment){
        $email = $sponsor_payment->sponsor_ambassador && $sponsor_payment->sponsor_ambassador->sponsor_user && $sponsor_payment->sponsor_ambassador->sponsor_user->email ? $sponsor_payment->sponsor_ambassador->sponsor_user->email : '';
        if($email){
            Mail::send('mail.sponsor-pay-amount', compact('sponsor_payment','payment'), function ($message) use ($email) {
                $message->to($email)->subject('Beløpet er sponset');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        }

        //Send email to all admin user
        $admin_users = (new User())->admin_users();
        if ($admin_users->count()) {
            foreach ($admin_users as $admin_user) {
                $admin_email = $admin_user->email;
                $email_text = "Vi vil informere deg om at <strong>" .
                    ($sponsor_payment->sponsor_ambassador && $sponsor_payment->sponsor_ambassador->sponsor_user &&
                    $sponsor_payment->sponsor_ambassador->sponsor_user->first_name ? $sponsor_payment->sponsor_ambassador->sponsor_user->first_name : '') . " " .
                    ($sponsor_payment->sponsor_ambassador && $sponsor_payment->sponsor_ambassador->sponsor_user &&
                    $sponsor_payment->sponsor_ambassador->sponsor_user->last_name ? $sponsor_payment->sponsor_ambassador->sponsor_user->last_name : '')
                    . "</strong> har betalt <strong>" . number_format($sponsor_payment->payment->amount, '2', ',', '.') . "kr</strong>";

                if($payment->sponsor_payment->count() > 1){
                    $email_text .= " for de neste månedene.<ul style='padding-left: 10px;'>";
                    foreach ($payment->sponsor_payment as $sponsor_payment){
                        $email_text .= "<strong><li>".common::date_in_locale_lang(('01-'.$sponsor_payment->month_year),'M Y','nb')."</li></strong>";
                    }
                    $email_text .= "</ul>";
                }else{
                    $email_text .= " for <strong>".common::date_in_locale_lang(('01-'.$payment->sponsor_payment->first()->month_year),'M Y','nb')."</strong> måneden.";
                }

                $email_text .= "<br> Dette gjelder for amabassadøren <strong>" .
                    ($sponsor_payment->sponsor_ambassador && $sponsor_payment->sponsor_ambassador->ambassador_user &&
                    $sponsor_payment->sponsor_ambassador->ambassador_user->first_name ? $sponsor_payment->sponsor_ambassador->ambassador_user->first_name : '') . " " .
                    ($sponsor_payment->sponsor_ambassador && $sponsor_payment->sponsor_ambassador->ambassador_user &&
                    $sponsor_payment->sponsor_ambassador->ambassador_user->last_name ? $sponsor_payment->sponsor_ambassador->ambassador_user->last_name : '')
                    . "</strong>";

                Mail::send('mail.admin-payment-notification', compact('email_text'), function ($message) use ($admin_email) {
                    $message->to($admin_email)->subject('En sponsor har betalt');
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });
            }
        }
    }

    //List payments to admin side
    public function admin_list_payments(Request $request){
        $month_range = common::get_month_between_range($request->all());
        $month_range_arr = $month_range['month_range_arr'];
        $month_range_filter = $month_range['month_range_filter'];
        $show_message = $month_range['show_message'];

        $payments = Payment::when($request->name, function($query) use ($request) {
            if($request->name){
                $query->where(function($query) use ($request){
                    $query->where(function ($query) use ($request) {
                        $query->whereHas('ambassador_payment.user', function ($q) use ($request) {
                            $q->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', '%' . $request->name . '%');
                        });
                    });
                    $query->orWhere(function ($query) use ($request) {
                        $query->whereHas('sponsor_payment.sponsor_ambassador.sponsor_user', function ($q) use ($request) {
                            $q->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', '%' . $request->name . '%');
                        });
                    });
                    $query->orWhere(function ($query) use ($request) {
                        $query->whereHas('ambassador_membership_fee.metable', function ($q) use ($request) {
                            $q->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', '%' . $request->name . '%');
                        });
                    });
                });
            }
        })->when(is_numeric($request->start_amount), function($query) use ($request) {
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
        })->when(($request->payment_user), function($query) use ($request) {
            if($request->payment_user){
                $query->where('payment_user',$request->payment_user);
            }
        })->when(($request->status), function($query) use ($request) {
            if($request->status){
                $query->where('status',$request->status);
            }
        })->when(($month_range_filter), function($query) use ($request,$month_range_filter,$month_range_arr) {
            if($month_range_filter && count($month_range_arr)) {
                $query->where(function ($query) use ($request,$month_range_arr) {
                    $query->whereHas('ambassador_payment', function ($q) use ($request, $month_range_arr) {
                        $q->whereIn('ambassador_payments.month_year', $month_range_arr);
                    });

                })->orWhere(function ($query) use ($request,$month_range_arr) {
                    $query->whereHas('sponsor_payment', function ($q) use ($request,$month_range_arr) {
                        $q->whereIn('sponsor_ambassador_payments.month_year',$month_range_arr);
                    });
                });
            }
        })->when($request->email, function($query) use ($request) {
            if($request->email){
                $query->where(function ($query) use ($request) {
                    $query->whereHas('ambassador_payment.user', function ($q) use ($request) {
                        $q->where('users.email', 'LIKE', '%'.$request->email.'%');
                    });
                });
                $query->orWhere(function ($query) use ($request) {
                    $query->whereHas('sponsor_payment.sponsor_ambassador.sponsor_user', function ($q) use ($request) {
                        $q->where('users.email', 'LIKE', '%'.$request->email.'%');
                    });
                });
                $query->orWhere(function ($query) use ($request) {
                    $query->whereHas('ambassador_membership_fee.metable', function ($q) use ($request) {
                        $q->where('users.email', 'LIKE', '%'.$request->email.'%');
                    });
                });
            }
        })->orderBy('id','DESC')->get();
        if($show_message){
            flash('Please select a valid month range')->error()->important();
        }
        return view('admin.list-payments',compact('payments'));
    }

    //Ambassador pay profile membership fee
    public function paid_membership_fee($user_id,$call_by=''){
        DB::beginTransaction();
        try{
            $setting_obj = new Setting();
            $amount = $setting_obj->get_value('ambassador_membership_fee');

            if(Auth::user()->hasRole('ambassador')){
                if(!$call_by){
                    session(['payment_type'=>'ambassador_membership_fee']);
                    return redirect()->route('payment',$amount);
                }


                //Store payment data
                $payment = Payment::create(['order_id'=>session('order_id'), 'transaction_id' => session('transaction_id') ,'amount'=> $amount , 'status' => 'completed','payment_user' => 'ambassador_membership_fee']);

                //Store meta
                Meta::create(['metable_id' => $user_id,'metable_type'=> User::class,'key' => 'ambassador_membership_fee_payment_id','value'=>$payment->id]);
                $auth_user_email = Auth::user()->email;
                Mail::send('mail.ambassador-paid-membership-fee',compact('amount'), function ($message) use ($auth_user_email) {
                    $message->to($auth_user_email)->subject('Betalt medlemsavgift');
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });

                //Send email to all admin user
                $admin_users = (new User())->admin_users();
                if($admin_users->count()){
                    foreach ($admin_users as $admin_user){
                        $admin_email = $admin_user->email;
                        $email_text = 'Vi vil informere deg om at <strong>'.(Auth::user()->first_name ? Auth::user()->first_name : '').' '.(Auth::user()->last_name ? Auth::user()->last_name : '').'</strong> betalte medlemsavgiften på <strong>'.(number_format($amount,'2',',','.')).'kr</strong> for T-skjorte.';
                        Mail::send('mail.admin-payment-notification',compact('email_text'), function ($message) use ($admin_email) {
                            $message->to($admin_email)->subject('Betalt medlemsavgift');
                            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        });
                    }
                }

            }

            DB::commit();
            session()->forget(['order_id','transaction_id', 'status','payment_type']);
            flash(__('flash-messages.Paid ambassador membership fee'))->success()->important();
            return redirect(localized_route('profile').'#profile');
        }catch (\Exception $e){
            DB::rollback();
            flash(__('flash-messages.Something went wrong.'))->error()->important();
            return redirect(localized_route('profile').'#profile');
        }
    }

    //View payment detail
    public function view_payment_detail($id){
        $payment = Payment::find($id);
        if($payment){
            return view('admin.payment-detail',compact('payment'));
        }else{
            flash('Record not found.')->error()->important();
            return back();
        }
    }

    //Vipps payment integration
    public function vipps_payment($amount){
        $amount = number_format($amount,'2','','');
        $order_id = 1;

        $token_arr = $this->vipps_access_token();
        if(isset($token_arr['flag']) && $token_arr['flag'] && $token_arr['token']){
            $token = $token_arr['token'];

            //Fetch initiate payment arr
            $initiate_payment_arr = $this->vipps_initiate_payment($token,$amount);

            if(isset($initiate_payment_arr['flag']) && $initiate_payment_arr['flag'] && isset($initiate_payment_arr['order_id']) && $initiate_payment_arr['order_id']
                && isset($initiate_payment_arr['url']) && $initiate_payment_arr['url']
            ){
                $order_id = $initiate_payment_arr['order_id'];
                $url = $initiate_payment_arr['url'];
                return redirect($url);
            }else{
                $msg = 'Something went wrong.';
                if(isset($initiate_payment_arr['msg']) && $initiate_payment_arr['msg']){
                    $msg = $initiate_payment_arr['msg'];
                }
                flash($msg)->error()->important();
                return back();
            }
        }else{
            $msg = 'Something went wrong.';
            if(isset($token_arr['msg']) && $token_arr['msg']){
                $msg = $token_arr['msg'];
            }
            flash($msg)->error()->important();
            return back();
        }
    }

    //Get vipps access token
    public function vipps_access_token(){
        $arr = array();
        $headers = array('application/json;charset=UTF-8',
            'client_id' => env('vipps_client_id'),
            'client_secret' => env('vipps_client_secret'),
            'Ocp-Apim-Subscription-Key' => env('vipps_subscription_key'),
        );
        $client = new \GuzzleHttp\Client();
        // Define array of request body.
        $request_body = array();

        try {
            $response = $client->request('POST', 'https://api.vipps.no/accesstoken/get', array(
                    'headers' => $headers,
                    'json' => $request_body,
                )
            );
            $arr['flag'] = true;
            $arr['token'] = json_decode($response->getBody()->getContents())->access_token;
        }catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $arr['flag'] = false;
            $arr['msg'] = $e->getMessage();
        }
        return $arr;
    }

    //Vipps initiate payment
    public function vipps_initiate_payment($token,$amount,$order_id = '')
    {
        $arr = array();
        $headers = array('application/json;charset=UTF-8',
            'Accept' => 'application/json;charset=UTF-8',
            'Authorization' => $token,
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => env('vipps_subscription_key'),
            'Merchant-Serial-Number' => env('vipps_merchant_serial_no'),
            'Vipps-System-Name' => 'runwithsyed',
            'Vipps-System-Version' => '5.4',
            'Vipps-System-Plugin-Name' => 'vipps-runwithsyed',
            'Vipps-System-Plugin-Version' => '1.2.1',
        );

        $client = new \GuzzleHttp\Client();

        // Define array of request body.
        $request_body = array(); //array();

        $request_body['customerInfo'] =  [
            "mobileNumber" => "", //90809500
        ];

        if($order_id){
            $temp_order_id = $order_id;
        }elseif (session('order_id')){
            $temp_order_id = session('order_id');
        } else{
            $temp_order_id = (date('dm-Y-hi-s')).rand(100, '1000');
        }

        $request_body['merchantInfo'] = [
            "authToken" => $token,
            "callbackPrefix" => url('/fallback-order-result-page/' . $temp_order_id),
//            "callbackPrefix" => url('vipps/callbacks-for-payment-updates'),
//                "consentRemovalPrefix" => localized_route('about-us'),
            "fallBack" => url('/fallback-order-result-page/' . $temp_order_id),
            "isApp" => false,
            "merchantSerialNumber" => env('vipps_merchant_serial_no'),
//                "shippingDetailsPrefix" => localized_route('about-us'),
//                "paymentType" => "eComm Regular Payment",
//                "staticShippingDetails" => [
//                    "isDefault" => "Y",
//                    "priority" => 0,
//                    "shippingCost" => 0,
//                    "shippingMethod" => "Running",
//                    "shippingMethodId" => "321abc",
//                ]
        ];


        $request_body['transaction'] = [
            "amount" => $amount,
            "orderId" => $temp_order_id,
//                "timeStamp" => "2021-06-07T15:34:26.590Z",
            "transactionText" => "Payment for rws.no",
//                "skipLandingPage" => false,
//                "scope" => "name address email",
//                "additionalData" => [
//                    "passengerName" => "FLYER / MARY MS.",
//                    "airlineCode" => "074",
//                    "airlineDesignatorCode" => "KL",
//                    "ticketNumber" => "string",
//                    "agencyInvoiceNumber" => "string",
//                ],
//                "useExplicitCheckoutFlow" => true,
        ];

        try {
            $response = $client->request('POST', 'https://api.vipps.no/ecomm/v2/payments', array(
                    'headers' => $headers,
                    'json' => $request_body,
                )
            );

            $response_decode = json_decode($response->getBody()->getContents());

            $arr['flag'] = true;
            $arr['url'] = isset($response_decode->url) && $response_decode->url ? $response_decode->url : '';
            $arr['order_id'] = isset($response_decode->orderId) && $response_decode->orderId ? $response_decode->orderId : '';

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $arr['flag'] = false;
            $arr['msg'] = $e->getMessage();
        }

        return $arr;
    }

    //Capture VIPPS payment
    public function vipps_capture_payment($order_id, $amount=0){
        $token_arr = $this->vipps_access_token();
        $token = '';
        $order_status_arr = $this->payment_status($order_id);
        $transaction_id = '';

        //When payment is initiate but no paid
        if(isset($order_status_arr['status']) && $order_status_arr['status'] == 'INITIATE' && $order_status_arr['amount']){
            return redirect()->route('payment',substr($order_status_arr['amount'], 0, -2));
        }

        //When payment is cancelled
        if(isset($order_status_arr['status']) && $order_status_arr['status'] == 'CANCEL'){
            return redirect()->route('payment-status',strtolower($order_status_arr['status']));
        }

        if(isset($token_arr['flag']) && $token_arr['flag'] && $token_arr['token']){
            $token = $token_arr['token'];
        }


        if($token && isset($order_status_arr['status']) && $order_status_arr['status'] == 'RESERVE'){

            $headers = array('application/json;charset=UTF-8',
                'orderId' => $order_id,
                'Accept' => 'application/json;charset=UTF-8',
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => env('vipps_subscription_key'),
                'X-Request-Id' => 'kRk3uEeiogxLu1yGSZRlNgsIv3TuNS',
                'Merchant-Serial-Number' => env('vipps_merchant_serial_no'),
                'Vipps-System-Name' => 'runwithsyed',
                'Vipps-System-Version' => '5.4',
                'Vipps-System-Plugin-Name' => 'vipps-runwithsyed',
                'Vipps-System-Plugin-Version' => '1.2.1',
            );
            $client = new \GuzzleHttp\Client();

            // Define array of request body.
            $request_body = array();
            $request_body['merchantInfo'] = [  "merchantSerialNumber" => env('vipps_merchant_serial_no'),];
            $request_body['transaction'] = [ "amount"=> $amount, "transactionText" => "Payment for rws.no"];

            try {

                $response = $client->request('POST','https://api.vipps.no/ecomm/v2/payments/'.$order_id.'/capture', array(
                        'headers' => $headers,
                        'json' => $request_body,
                    )
                );

                $decode_response = json_decode($response->getBody()->getContents());
                if(isset($decode_response->transactionInfo) && isset($decode_response->transactionInfo->status) && $decode_response->transactionInfo->status == 'Captured'){
                    if(isset($decode_response->orderId) && $decode_response->orderId && isset($decode_response->transactionInfo->transactionId) && $decode_response->transactionInfo->transactionId){
                        $order_id = $decode_response->orderId;
                        $transaction_id = $decode_response->transactionInfo->transactionId;
                        //$return_arr = array('order_id'=>$order_id, 'transaction_id'=>$transaction_id, 'status'=> strtolower($decode_response->transactionInfo->status));
//                        return $return_arr;
                        session(['order_id'=> $order_id]);
                        session(['transaction_id'=> $transaction_id]);
                        session(['status' => strtolower('Captured')]);

                        if(session('payment_type') && session('payment_type') == 'ambassador_membership_fee'){
                            return $this->paid_membership_fee(Auth::user()->id,'controller');
                            exit();
                        }elseif (session('payment_type') && session('payment_type') == 'ambassador_pay_amount'){
                            $request_obj = new \Illuminate\Http\Request();
                            $request_obj->replace(session('form_request'));
                            return $this->ambassador_pay_amount($request_obj,'controller');
                            exit(); //sponsor_pay_amount
                        }elseif (session('payment_type') && session('payment_type') == 'sponsor_pay_amount'){
                            $request_obj = new \Illuminate\Http\Request();
                            $request_obj->replace(session('form_request'));
                            return $this->sponsor_pay_amount($request_obj,session('ambassador_id'),'controller');
                            exit();
                        }elseif (session('payment_type') && session('payment_type') == 'donation'){
                            $request_obj = new \Illuminate\Http\Request();
                            $request_obj->replace(session('form_request'));
                            $donation_obj = new DonationController();
                            return $donation_obj->store($request_obj,'controller');
                            exit();
                        } else{
                            return redirect()->route('payment-status',strtolower($decode_response->transactionInfo->status));
                        }
                        //return redirect()->route('payment-status',strtolower($decode_response->transactionInfo->status));
                    }else{
                        //Refund payment if payment is captured but didn't provide the the order id or transaction id

                    }
                }
            }
            catch (\GuzzleHttp\Exception\BadResponseException $e) {
                $result = $this->get_order_details($order_id);
                if($result){
                    return redirect()->route('payment-status','captured');
                }else{
                    return redirect()->route('payment-status','Something went wrong. Please try again later');
                }
            }
        }
    }

    //Get order status
    public function payment_status($order_id){
        $return_arr = array();
        $token_arr = $this->vipps_access_token();
        $token = '';

        if(isset($token_arr['flag']) && $token_arr['flag'] && $token_arr['token']){
            $token = $token_arr['token'];
        }

        if($token){
            $headers = array(
                'Authorization' => $token,
                'Ocp-Apim-Subscription-Key' => env('vipps_subscription_key')
            );

            $client = new \GuzzleHttp\Client();

            // Define array of request body.
            $request_body = array();

            try {
                $response = $client->request('GET','https://api.vipps.no/ecomm/v2/payments/'.$order_id.'/status', array(
                        'headers' => $headers,
                        'json' => $request_body,
                    )
                );

                $response_decode = json_decode($response->getBody()->getContents());

                if(isset($response_decode->orderId) && $response_decode->orderId && isset($response_decode->transactionInfo) && isset($response_decode->transactionInfo->amount) && $response_decode->transactionInfo->amount && isset($response_decode->transactionInfo->status) && $response_decode->transactionInfo->status){
                    $return_arr['amount'] = $response_decode->transactionInfo->amount;
                    $return_arr['token'] = $token;
                    $return_arr['order_id'] = $response_decode->orderId;
                    $return_arr['status'] = $response_decode->transactionInfo->status;
                }
            }
            catch (\GuzzleHttp\Exception\BadResponseException $e) {
                // handle exception or api errors.
                $return_arr['status'] = $e->getMessage();
            }
        }
        return $return_arr;
    }

    //Show the payment status result page
    public function payment_status_result_page($status){
        return view('order-result-page',compact('status'));
    }

    //Get order detail
    public function get_order_details($order_id){

        $token_arr = $this->vipps_access_token();
        $token = '';

        if(isset($token_arr['flag']) && $token_arr['flag'] && $token_arr['token']){
            $token = $token_arr['token'];
        }
        $headers = array( 'application/json;charset=UTF-8',
            'Authorization' => $token,
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => env('vipps_subscription_key'),
            'Merchant-Serial-Number' => env('vipps_merchant_serial_no'),
            'Vipps-System-Name' => 'runwithsyed',
            'Vipps-System-Version' => '5.4',
            'Vipps-System-Plugin-Name' => 'vipps-runwithsyed',
            'Vipps-System-Plugin-Version' => '1.2.1',
        );

        $client = new \GuzzleHttp\Client();

        // Define array of request body.
        $request_body = array();

        try {
            $response = $client->request('GET','https://api.vipps.no/ecomm/v2/payments/'.$order_id.'/details', array(
                    'headers' => $headers,
                    'json' => $request_body,
                )
            );

            $result_found = '';

            foreach(json_decode($response->getBody()->getContents())->transactionLogHistory as $value){

                if(strtolower($value->operation) == 'captured' && $value->operationSuccess){
                    $result_found = true;
                    break;
                }
            }

            if($result_found){
                return true;
            }else{
                return false;
            }
        }
        catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return false;
        }
    }

    //Create custom payment
    public function create_custom_payment(){
        $users = User::whereHas('roles',function ($query){
            $query->where('roles.slug','<>','admin');
        })->get();
        return view('admin.create-custom-payment',compact('users'));
    }

    //add custom amount
    public function add_custom_payment(Request $request){
        if(isset($request->user_id) && $request->user_id){
            $user = User::find($request->user_id);
            if($user){
                DB::beginTransaction();
                try{
                    if($user->hasRole('ambassador')){
                        $total_amount = 0;

                        if(isset($request->month_year) && count($request->month_year)){
                            foreach ($request->month_year as $month_year){
                                if(count($request->month_year) == 1){
                                    //Store payment data
                                    $total_amount = $request->amount;
                                }else{
                                    $not_paying_month = common::ambassador_not_paying_month($user);
                                    if($not_paying_month->count()){
                                        $get_specific = $not_paying_month[date('Y-m',strtotime('01-'.$month_year))];
                                        $total_amount += $get_specific->sum('distance');
                                    }
                                }
                            }
                        }else{
                            flash('Please select month of a user to complete the payment. Thanks!')->error()->important();
                            return back();
                        }
                        if($total_amount > 0){
                            $payment = Payment::create(['order_id' => 'custom payment','transaction_id' => 'custom payment', 'amount'=> $total_amount , 'status' => 'completed','payment_user' => 'ambassador']);
                            if($payment){
                                foreach ($request->month_year as $month_year){
                                    //Ambassador Payment detail
                                    $ambassador_payment = AmbassadorPayment::create([
                                        'user_id' => $user->id,
                                        'month_year' => $month_year,
                                        'payment_id' => $payment->id,
                                    ]);
                                }
                                if($ambassador_payment){
                                    $this->ambassador_payment_email($payment,$ambassador_payment);
                                }
                            }
                        }else{
                            flash('Amount must be larger than 0kr.')->error()->important();
                            return back();
                        }
                    }

                    if($user->hasRole('sponsor')){
                        if(isset($request->ambassador_id) && $request->ambassador_id){
                            $ambassador = User::find($request->ambassador_id);
                            $sponsor_ambassador = SponsorAmbassador::where('sponsor_user_id',$request->user_id)->where('ambassador_user_id',$request->ambassador_id)->first();
                            if($ambassador && $sponsor_ambassador){
                                $not_paying_month = common::sponsor_not_paying_month($ambassador,$request->user_id);
                                $amount = 0;

                                //Calculate the total amount
                                if(isset($request->month_year) && count($request->month_year)){
                                    foreach ($request->month_year as $month_year){
                                        if($not_paying_month->count()){
                                            $get_specific = $not_paying_month[date('Y-m',strtotime('01-'.$month_year))];
                                            $amount += $get_specific->sum('distance');
                                        }
                                    }
                                }else{
                                    flash('Please select month of a user to complete the payment. Thanks!')->error()->important();
                                    return back();
                                }
                                if($amount > 0){
                                    $payment = Payment::create(['order_id' => 'custom payment','transaction_id' => 'custom payment', 'amount' => $amount, 'status' => 'completed', 'payment_user' => 'sponsor']);
                                    if($payment){
                                        foreach ($request->month_year as $month_year) {
                                            if ($amount) {
                                                if ($sponsor_ambassador) {
                                                    //Sponsor Payment detail
                                                    $sponsor_payment = SponsorAmbassadorPayment::create([
                                                        'sponsor_ambassador_id' => $sponsor_ambassador->id,
                                                        'month_year' => $month_year,
                                                        'payment_id' => $payment->id
                                                    ]);
                                                }
                                            }
                                        }
                                        if($sponsor_payment){
                                            $this->sponsor_payment_email($payment,$sponsor_payment);
                                        }
                                    }
                                }else{
                                    flash('Amount must be larger than 0kr.')->error()->important();
                                    return back();
                                }
                            }else{
                                flash('Record not found.')->error()->important();
                                return back();
                            }
                        }else{
                            flash('Please select an ambassador to complete the payment. Thanks!')->error()->important();
                            return back();
                        }
                    }
                    DB::commit();
                    flash('Payment has created successfully.')->success()->important();
                    return redirect()->route('admin.payments');
                }catch (\Exception $e){
                    DB::rollback();
                    flash('Something went wrong.')->error()->important();
                    return back()->withInput();
                }
            }else{
                flash('User not found.')->error()->important();
                return back();
            }
        }else{
            flash('Something went wrong.')->error()->important();
            return back();
        }
    }
}