@extends('layouts.backend-master')

@section('title', 'Payment')

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
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endsection
@section('page-content')
    <!-- Page Content  -->
    <main class="content">
        @include('flash::message')
        @include('errors')
        <div class="clearfix mb-1"></div>
        <div class="float-left">
            <h4>Payment</h4>
        </div>

        <div class="float-right">
            <a style="background: #8a5917; color: white;" href="{{route('admin.create-custom-payment')}}" class="btn mb-0" title="Pay some amount against user">Create payment</a>
            <a style="background: #8a5917; color: white;" href="javascript:" class="btn mb-0" title="Advanced Search" data-toggle="collapse" data-target="#user_filter" aria-expanded="true"><i class="fa fa-search fa-lg"></i></a>
        </div>
        <div class="clearfix"></div>

        <form action="{{route('admin.payments')}}" method="GET">
            <div id="user_filter" class="collapse <?php if(Request()->has('email')) echo 'show'; ?>">
                <div class="card clearfix mt-3">
                    <div class="card-header bg-dark text-white px-2 py-2">
                        <b>Advanced search</b>
                        <a class="float-right" data-toggle="collapse" href="#user_filter" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body py-1">
                        <div class="form-body">
                            <div class="row mt-1">
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Name</label>
                                    <input type="text" class="form-control form-control-sm" name="name" value="{{Request()->name}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Email</label>
                                    <input type="text" class="form-control form-control-sm" name="email" value="{{Request()->email}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Amount start</label>
                                    <input type="number" class="form-control form-control-sm" name="start_amount" value="{{Request()->start_amount}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="0">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Amount end</label>
                                    <input type="number" class="form-control form-control-sm" name="end_amount" value="{{Request()->end_amount}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="0">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Payment date start</label>
                                    <input type="date" class="form-control form-control-sm" name="payment_start_date" value="{{Request()->payment_start_date}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Payment date end</label>
                                    <input type="date" class="form-control form-control-sm" name="payment_end_date" value="{{Request()->payment_end_date}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Payment month start</label>
                                    <input type="month" class="form-control form-control-sm" name="payment_start_month" value="{{Request()->payment_start_month}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Payment month end</label>
                                    <input type="month" class="form-control form-control-sm" name="payment_end_month" value="{{Request()->payment_end_month}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Payment user</label>
                                    <select class="form-control form-control-sm" name="payment_user">
                                        <option value="">Select type</option>
                                        <option value="ambassador_membership_fee" {{Request()->payment_user == 'ambassador_membership_fee' ? 'selected' : ''}}>Ambassador membership fee</option>
                                        <option value="ambassador" {{Request()->payment_user == 'ambassador' ? 'selected' : ''}}>Ambassador user</option>
                                        <option value="donation" {{Request()->payment_user == 'donation' ? 'selected' : ''}}>Donation</option>
                                        <option value="sponsor" {{Request()->payment_user == 'sponsor' ? 'selected' : ''}}>Sponsor user</option>
                                    </select>
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Status</label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="">Select status</option>
                                        <option value="completed" {{Request()->status == 'completed' ? 'selected' : ''}}>Completed</option>
                                        <option value="pending" {{Request()->status == 'pending' ? 'selected' : ''}}>Pending</option>
                                    </select>
                                </div>
                            </div>
                        </div><!-- .form-body -->
                        <div class="clearfix"> </div>
                    </div>
                    <div class="card-footer py-1">
                        <div class="row text-right d-block">
                            <a href="{{route('admin.payments')}}" class="btn btn-sm btn-dark mb-0" style="width: auto">Reset search result</a>
                            <button type="submit" class="btn btn-sm mb-0 btn-primary"> Search </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>
        <div class="clearfix my-3"></div>

        <table class="table table-striped table-hover" id="payment_history">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Transaction Id</th>
                <th scope="col">Payment user</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Payment month</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            @if($payments->count())
                @foreach($payments as $key=>$payment)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td><span style="font-weight: 500">{{$payment->transaction_id ? $payment->transaction_id : 'N/A'}}</span></td>
                        <td>
                            @if($payment->payment_user == 'ambassador_membership_fee')
                                Ambassador membership fee
                            @else
                                {{ucfirst($payment->payment_user).' user'}}
                            @endif
                        </td>
                        <td>
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

                            @if($payment->payment_user == 'donation')
                               {{$payment->donation && $payment->donation->name ? $payment->donation->name : 'N/A'}}
                            @endif
                        </td>
                        <td>
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
                            @if($payment->payment_user == 'donation')
                                N/A
                            @endif
                        </td>
                        <td><span class="font-weight-bold">{{number_format($payment->amount,'2',',','.')}} kr</span></td>
                        <td>{{$payment->created_at->format('M d, Y')}}</td>
                        <td>
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

                            @if($payment->payment_user == 'ambassador_membership_fee')
                                N/A
                            @endif

                            @if($payment->payment_user == 'donation')
                                N/A
                            @endif
                        </td>
                        <td><span class="{{$payment->status}}">{{ucfirst($payment->status)}}</span></td>
                        <td>
                            <a href="{{route('admin.payment-detail',$payment->id)}}"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10"><p class="alert alert-danger text-center mb-0">Record not found.</p></td>
                </tr>
            @endif
            </tbody>
        </table>
    </main>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/js/date-eu.js')}}"></script>
    <script src="{{asset('public/js/formatted-numbers.js')}}"></script>
    <script>
        $(document).ready(function () {
            var columnDefs_type = ['formatted-num','date-eu','date-eu'];
            var columnDefs_target = [5,6,7];
            @if($payments->count())
            jquery_data_tables_languages($('#payment_history'),columnDefs_type,columnDefs_target);
            @endif
        });

    </script>
@endsection