@extends('layouts.backend-master')

@section('title', 'Sponser')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endsection

@section('page-content')
    <style>
        .table thead th {
            text-align: center;
        }

        .user_detail .label {
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 5px;
            color: #525252;
        }

        .user_detail .value {
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 5px;
        }
    </style>
    <!-- Page Content  -->
    <main class="content">
        @include('flash::message')
        @include('errors')
        <div class="clearfix mb-1"></div>
        <div class="row mb-4 user_detail">
            <div class="col-md-3 col-4 label">Name:</div>
            <div class="col-md-3 col-8 value">{{$user->first_name ? $user->first_name : ''}} {{$user->last_name ? $user->last_name : ''}}</div>
            <div class="col-md-3 col-4 label">E-mail:</div>
            <div class="col-md-3 col-8 value">{{$user->email}}</div>
            <div class="col-md-3 col-4 label">Mobile no:</div>
            <div class="col-md-3 col-8 value">{{$user->mobile_no}}</div>
            </div>

            <div class="padder" style="background-color: #d5f7d5; padding: 10px;margin-bottom: 30px;border-radius: 10px;">
               <div class="float-left">
                <h4>Payment history</h4>
            </div>
        <div class="float-right">
            <a style="background: green;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="Advanced Search" data-toggle="collapse" data-target="#sponsor_payment_history_filters" aria-expanded="true"><i class="fa fa-search"></i></a>
        </div>

        <div class="clearfix"></div>
        <form class="mb-3" action="{{route('admin.sponsor.detail', $user->id)}}" method="GET">
            <div id="sponsor_payment_history_filters" class="collapse {{\Request::has('price_start') ? 'show' : ''}}">
                <div class="card clearfix mt-3">
                    <div class="card-header bg-dark text-white px-2 py-2">
                        <b>{{__('profile.advanced search')}}</b>
                        <a class="float-right" data-toggle="collapse" href="#sponsor_payment_history_filters" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body py-1">
                        <div class="form-body">
                            <div class="row mt-1">
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.amount start')}}</label>
                                    <input type="number" class="form-control form-control-sm" name="price_start" value="{{Request()->price_start}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="1">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.amount end')}}</label>
                                    <input type="number" class="form-control form-control-sm" name="price_end" value="{{Request()->price_end}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="1">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.paying month')}}</label>
                                    <input type="month" class="form-control form-control-sm" name="paying_month" value="{{Request()->paying_month}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.status')}}</label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="">{{__('profile.select status')}}</option>
                                        <option value="completed" {{Request()->status && Request()->status == 'completed' ? 'selected' : ''}}>{{__('profile.completed')}}</option>
                                        <option value="pending" {{Request()->status && Request()->status == 'pending' ? 'selected' : ''}}>{{__('profile.pending')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.payment date start')}}</label>
                                    <input type="date" class="form-control form-control-sm" name="payment_date_start" value="{{Request()->payment_date_start}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.payment date end')}}</label>
                                    <input type="date" class="form-control form-control-sm" name="payment_date_end" value="{{Request()->payment_date_end}}">
                                </div>
                            </div>
                        </div><!-- .form-body -->
                        <div class="clearfix"> </div>
                    </div>
                    <div class="card-footer py-1">
                        <div class="row text-right d-block">
                            <a href="{{route('admin.sponsor.detail',$user->id)}}" class="btn btn-sm btn-warning mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                            <button type="submit" class="btn btn-sm mb-0 btn-primary"> {{__('profile.search')}}  </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>

        <table class="table table-sm bg-white" id="payment_history_table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{__('profile.order id')}}</th>
                <th scope="col">{{__('profile.transaction id')}}</th>
                <th scope="col">{{'Ambassador'}}</th>
                <th scope="col">{{__('profile.paying date')}}</th>
                <th scope="col">{{__('profile.pay amount')}}</th>
                <th scope="col">{{__('profile.paying month')}}</th>
                <th scope="col">{{__('profile.status')}}</th>
            </tr>
            </thead>
            <tbody>

            @if($payments->count())
                @foreach($payments as $sponsor_payment_key=>$payment)
                    <tr class="text-center">

                        <th scope="row">{{$sponsor_payment_key+1}}</th>
                        <td style="font-weight: 500">{{$payment->order_id}}</td>
                        <td style="font-weight: 500">{{$payment->transaction_id}}</td>
                        <td>
                            {{$payment->sponsor_payment && $payment->sponsor_payment->first()->sponsor_ambassador && $payment->sponsor_payment->first()->sponsor_ambassador
                             && $payment->sponsor_payment->first()->sponsor_ambassador->ambassador_user ? $payment->sponsor_payment->first()->sponsor_ambassador->ambassador_user->first_name.' '.$payment->sponsor_payment->first()->sponsor_ambassador->ambassador_user->last_name : ''
                            }}
                        </td>
                        <td>{{$payment->created_at->format('M d, Y')}}</td>
                        <td>{{$payment ? number_format($payment->amount,'2',',','.') : ''}}</td>
                        <td>
                            @if($payment->sponsor_payment->count())
                                <ul style="padding-left: 40px">
                                    @foreach($payment->sponsor_payment as $sponsor_payment)
                                        <li style="text-align: start">{{date('M, Y',strtotime('01-'.$sponsor_payment->month_year))}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            <span class="{{$payment ? $payment->status : ''}}">{{$payment ? (__('profile.'.$payment->status)): ''}}</span>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8"><p class="alert alert-danger text-center mb-0">{{__('general.no any record found')}}</p></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

        <hr>

        <div class="padder" style="background-color: #ffe5e5; padding: 10px;margin-bottom: 30px;border-radius: 10px;">
          <div class="float-left">
                <h4>Sponsers</h4>
            </div>
        <div class="float-right">
            <a style="background: green;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="Advanced Search" data-toggle="collapse" data-target="#my_ambassadors_filter" aria-expanded="true"><i class="fa fa-search"></i></a>
        </div>

        <div class="clearfix"></div>
        <form class="mb-3" action="{{route('admin.sponsor.detail', $user->id)}}" method="GET">
            <div id="my_ambassadors_filter" class="collapse {{\Request::has('first_name') ? 'show' : ''}}">
                <div class="card clearfix mt-3">
                    <div class="card-header bg-dark text-white px-2 py-2">
                        <b>{{__('profile.advanced search')}}</b>
                        <a class="float-right" data-toggle="collapse" href="#my_ambassadors_filter" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body py-1">
                        <div class="form-body">
                            <div class="row mt-1">
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.fname')}}</label>
                                    <input type="text" class="form-control form-control-sm" name="first_name" value="{{Request()->first_name}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.lname')}}</label>
                                    <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request()->last_name}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.email')}}</label>
                                    <input type="text" class="form-control form-control-sm" name="email" value="{{Request()->email}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.date start')}}</label>
                                    <input type="date" class="form-control form-control-sm" name="date_start" value="{{Request()->date_start}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.date end')}}</label>
                                    <input type="date" class="form-control form-control-sm" name="date_end" value="{{Request()->date_end}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.status')}}</label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="">{{__('profile.select status')}}</option>
                                        <option value="1" {{Request()->status && Request()->status == '1' ? 'selected' : ''}}>{{__('profile.active')}}</option>
                                        <option value="0" {{Request()->status && Request()->status == '0' ? 'selected' : ''}}>{{__('profile.deactivate')}}</option>
                                    </select>
                                </div>

                            </div>
                        </div><!-- .form-body -->
                        <div class="clearfix"> </div>
                    </div>
                    <div class="card-footer py-1">
                        <div class="row text-right d-block">
                            <a href="{{route('admin.sponsor.detail', $user->id)}}" class="btn btn-sm btn-warning mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                            <button type="submit" class="btn btn-sm btn-primary mb-0"> {{__('profile.search')}}  </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>

        <table class="table bg-white table-sm" id="my_ambassador_table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{__('profile.image')}}</th>
                <th scope="col">{{__('profile.name')}}</th>
                <th scope="col">{{__('profile.e-mail')}}</th>
                <th scope="col">{{__('profile.status')}}</th>
                <th scope="col">{{__('general.date')}}</th>
                <th scope="col">{{__('general.action')}}</th>
            </tr>
            </thead>
            <tbody>

            @if($user_ambassadors->count())
                @foreach($user_ambassadors as $ambassador_key=>$ambassador)
                    <tr class="text-center">
                        <th scope="row">{{$ambassador_key+1}}</th>
                        <td>
                            @if($ambassador->ambassador_user && $ambassador->ambassador_user->detail && $ambassador->ambassador_user->detail->profile_image_permission && $ambassador->ambassador_user->image)
                                <a target="_blank" href="{{asset(\App\Helpers\common::getMediaPath($ambassador->ambassador_user->image))}}">
                                    <img style="width: 60px; height: 60px; border-radius: 100px" src="{{asset(\App\Helpers\common::getMediaPath($ambassador->ambassador_user->image))}}">
                                </a>
                            @else
                                <img style="width: 60px; height: 60px; border-radius: 100px" src="{{asset('public/images/user-avatar-1.png')}}">
                            @endif
                        </td>
                        <td>
                            {{$ambassador->ambassador_user && $ambassador->ambassador_user->first_name ? $ambassador->ambassador_user->first_name : ''}}
                            {{$ambassador->ambassador_user && $ambassador->ambassador_user->last_name ? $ambassador->ambassador_user->last_name : ''}}
                        </td>
                        <td>{{$ambassador->ambassador_user ? $ambassador->ambassador_user->email : ''}}</td>
                        <td><span class="{{$ambassador->status ? 'active' : 'deactivate'}}">{{ __('profile.'.($ambassador->status ? 'active' : 'deactivate'))}}</span></td>
                        <td>{{$ambassador->created_at->format('M d, Y')}}</td>
                        <td>
                            <a href="{{route('admin.ambassador.detail',$ambassador->ambassador_user->id)}}" target="_blank"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7"><p class="alert alert-danger text-center mb-0">{{__('general.no any record found')}}</p></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    </main>

@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/js/date-eu.js')}}"></script>
    <script src="{{asset('public/js/formatted-numbers.js')}}"></script>
    <script>
        $(document).ready(function () {
            @if($user_ambassadors->count())
            var columnDefs_type = ['date-eu'];
            var columnDefs_target = [5];
            jquery_data_tables_languages($('#my_ambassador_table'),columnDefs_type,columnDefs_target);
            @endif

            @if($payments->count())
            var columnDefs_type = ['date-eu','formatted-num','date-eu'];
            var columnDefs_target = [4,5,6];
            jquery_data_tables_languages($('#payment_history_table'),columnDefs_type,columnDefs_target);
            @endif


        });
    </script>
@endsection