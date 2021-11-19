@extends('layouts.backend-master')

@section('title', 'Payment detail')

@section('style')
    <style>
        .completed{
            padding: 5px 8px;
            background-color: green;
            color: white;
            font-size: 12px;
            border-radius: 5px;
            font-weight: 500;
        }
        .label{
            font-size: 14px;
            font-weight: 500;
            margin: 0;
        }
        .value{
            font-size: 16px;
            font-weight: 500;
            margin: 0;
        }
        .row{
            margin: 6px 0;
            padding: 10px 0;
        }
        .row:nth-child(odd){
            background: #f1f1f1;
        }
    </style>
@endsection

@section('page-content')
    <!-- Page Content  -->
    <main class="content">
        <div>
            <h4>Payment detail</h4>
        </div>
        <div class="clearfix"></div>
        <hr>
        @if($payment->transaction_id || $payment->order_id)
            <div class="row">
                @if($payment->transaction_id)
                    <div class="col-lg-2">
                        <label class="label">Transaction ID:</label>
                    </div>
                    <div class="col-lg-4">
                        <label class="value">
                            {{$payment->transaction_id}}
                        </label>
                    </div>
                @endif

                @if($payment->order_id)
                    <div class="col-lg-2">
                        <label class="label">Order ID:</label>
                    </div>
                    <div class="col-lg-4">
                        <label class="value">
                            {{$payment->order_id}}
                        </label>
                    </div>
                @endif
            </div>
        @endif

        <div class="row">
            <div class="col-lg-2">
                <label class="label">Payment type:</label>
            </div>
            <div class="col-lg-4">
                <label class="value">
                    @if($payment->payment_user == 'ambassador_membership_fee')
                        Ambassador membership fee
                    @else
                        {{ucfirst($payment->payment_user).' user'}}
                    @endif
                </label>
            </div>

            @if($payment->payment_user != 'donation')
                <div class="col-lg-2">
                    <label class="label">Name:</label>
                </div>
                <div class="col-lg-4">
                    <label class="value">
                        @if($payment->payment_user == 'ambassador_membership_fee')
                            @if($payment->ambassador_membership_fee && $payment->ambassador_membership_fee->metable)
                                {{$payment->ambassador_membership_fee->metable->first_name ? $payment->ambassador_membership_fee->metable->first_name : ''}}
                                {{$payment->ambassador_membership_fee->metable->last_name ? $payment->ambassador_membership_fee->metable->last_name : ''}}
                            @endif
                        @endif

                        @if($payment->payment_user == 'ambassador')
                            @if($payment->ambassador_payment->first() && $payment->ambassador_payment->first()->user)
                                {{$payment->ambassador_payment->first()->user->first_name ? $payment->ambassador_payment->first()->user->first_name : ''}}
                                {{$payment->ambassador_payment->first()->user->last_name ? $payment->ambassador_payment->first()->user->last_name : ''}}
                            @endif
                        @endif

                        @if($payment->payment_user == 'sponsor')
                            @if($payment->sponsor_payment && $payment->sponsor_payment->first()->sponsor_ambassador && $payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user)
                                {{$payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user->first_name ? $payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user->first_name : ''}}
                                {{$payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user->last_name ? $payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user->last_name : ''}}
                            @endif
                        @endif
                    </label>
                </div>
            @endif
        </div>

        @if($payment->payment_user != 'donation')
            <div class="row">
                <div class="col-lg-2">
                    <label class="label">Email:</label>
                </div>
                <div class="col-lg-4">
                    <label class="value">
                        @if($payment->payment_user == 'ambassador_membership_fee')
                            @if($payment->ambassador_membership_fee && $payment->ambassador_membership_fee->metable)
                                {{$payment->ambassador_membership_fee->metable->email ? $payment->ambassador_membership_fee->metable->email : ''}}
                            @endif
                        @endif

                        @if($payment->payment_user == 'ambassador')
                            @if($payment->ambassador_payment->first() && $payment->ambassador_payment->first()->user)
                                {{$payment->ambassador_payment->first()->user->email ? $payment->ambassador_payment->first()->user->email : ''}}
                            @endif
                        @endif

                        @if($payment->payment_user == 'sponsor')
                            @if($payment->sponsor_payment && $payment->sponsor_payment->first()->sponsor_ambassador && $payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user)
                                {{$payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user->email ? $payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user->email : ''}}
                            @endif
                        @endif
                    </label>
                </div>

                <div class="col-lg-2">
                    <label class="label">Mobile no:</label>
                </div>
                <div class="col-lg-4">
                    <label class="value">
                        @if($payment->payment_user == 'ambassador_membership_fee')
                            @if($payment->ambassador_membership_fee && $payment->ambassador_membership_fee->metable)
                                {{$payment->ambassador_membership_fee->metable->mobile_no ? $payment->ambassador_membership_fee->metable->mobile_no : ''}}
                            @endif
                        @endif

                        @if($payment->payment_user == 'ambassador')
                            @if($payment->ambassador_payment->first() && $payment->ambassador_payment->first()->user)
                                {{$payment->ambassador_payment->first()->user->mobile_no ? $payment->ambassador_payment->first()->user->mobile_no : ''}}
                            @endif
                        @endif

                        @if($payment->payment_user == 'sponsor')
                            @if($payment->sponsor_payment && $payment->sponsor_payment->first()->sponsor_ambassador && $payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user)
                                {{$payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user->mobile_no ? $payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user->mobile_no : ''}}
                            @endif
                        @endif
                    </label>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-2">
                <label class="label">Amount:</label>
            </div>
            <div class="col-lg-4">
                <label class="value">{{number_format($payment->amount,'2',',','.')}} kr</label>
            </div>

            <div class="col-lg-2">
                <label class="label">Date:</label>
            </div>
            <div class="col-lg-4">
                <label class="value">{{$payment->created_at->format('M d, Y')}}</label>
            </div>
        </div>
        <div class="row">
            @if($payment->payment_user == 'ambassador' || $payment->payment_user == 'sponsor')
                <div class="col-lg-2">
                    <label class="label">Payment month:</label>
                </div>
                <div class="col-lg-4">
                    <label class="value">
                        @if($payment->payment_user == 'ambassador')
                            @if($payment->ambassador_payment->count())
                                <ul class="pl-3">
                                    @foreach($payment->ambassador_payment as $ambassador_payment)
                                        <li>{{$ambassador_payment->month_year ? date('M Y',strtotime('01-'.$ambassador_payment->month_year)) : ''}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif

                        @if($payment->payment_user == 'sponsor')
                            @if($payment->sponsor_payment->count())
                                <ul class="pl-3">
                                    @foreach($payment->sponsor_payment as $sponsor_payment)
                                        <li>{{$sponsor_payment->month_year ? date('M Y',strtotime('01-'.$sponsor_payment->month_year)) : ''}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </label>
                </div>
            @endif


            <div class="col-lg-2">
                <label class="label">Status:</label>
            </div>
            <div class="col-lg-4">
                <label class="value"><span class="{{$payment->status}}">{{ucfirst($payment->status)}}</span></label>
            </div>
        </div>

        @php
            $user = '';
            if($payment->payment_user == 'ambassador_membership_fee'){
                $user = $payment->ambassador_membership_fee && $payment->ambassador_membership_fee->metable ? $payment->ambassador_membership_fee->metable : '';
            }
            if($payment->payment_user == 'ambassador'){
                $user = $payment->ambassador_payment->first() && $payment->ambassador_payment->first()->user ? $payment->ambassador_payment->first()->user : '';
            }
            if($payment->payment_user == 'sponsor'){
                $user = $payment->sponsor_payment->first() && $payment->sponsor_payment->first()->sponsor_ambassador && $payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user ? $payment->sponsor_payment->first()->sponsor_ambassador->sponsor_user : '';
            }
        @endphp

        @if($user && $user->detail && ($user->detail->zip_code || $user->detail->zip_city || $user->detail->address))
            <div class="row">
                @if($user->detail->address)
                    <div class="col-lg-2">
                        <label class="label">Address:</label>
                    </div>
                    <div class="col-lg-4">
                        <label class="value">{{$user->detail->address}}</label>
                    </div>
                @endif

                @if($user->detail->zip_code ||  $user->detail->zip_city)
                    <div class="col-lg-2">
                        <label class="label">{{$user->detail->zip_code ? 'Post no' : ''}} {{$user->detail->zip_code && $user->detail->zip_city ? '&' : ''}} {{$user->detail->zip_city ? 'City' : ''}}:</label>
                    </div>
                    <div class="col-lg-4">
                        <label class="value">{{$user->detail->zip_code.' '.$user->detail->zip_city}} </label>
                    </div>
                @endif
            </div>
        @endif
    </main>
@endsection