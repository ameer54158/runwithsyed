@extends('layouts.frontend-master')

@section('style')
    <style>
        .head form .form-control, .login-page .login-form .form-control, .reset-password-page .form-control {
            border-bottom: 1px solid #8080806b !important;
        }

        .profile-pic {
            max-width: 200px;
            max-height: 200px;
            display: block;
        }

        .file-upload {
            display: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .p-image {
            position: relative;
            top: 8rem;
            right: 44%;
            color: #666666;
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .p-image:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .upload-button {
            font-size: 1.2em;
        }

        .upload-button:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
            color: #999;
        }

        textarea {
            width: 100%;
            font-size: 20px;
        }
        .alert-success{
            font-size: 16px;
        }

        .description-box, .upload-button {
            cursor: pointer;
        }

        .my-button a{
            color:  #4f7f55 !important;;
        }
        .my-button{
            padding: 0 10px;
        }
        .my-button .btn{
            color: #4f7f55 !important;
            border: 1px solid #4f7f55;
            border-radius: 34px;
            font-weight: 600;
            width: 100% !important;
            margin-bottom: 20px;
            padding: 5px 15px;
            text-align: center;
        }
        .my-button .btn.active{
            color: white !important;
            background: #4f7f55 !important;
            border: 1px solid #4f7f55;
        }
        .btn:focus{
            box-shadow: none;
        }
        #runs_history, #ambassador_payment_history_table, #sponsor_payment_history_table, #my_ambassador_table, #my_sponsor_table, #month_runs_history{
            border-left: 1px solid #111111;
            border-right: 1px solid #111111;
        }
        #runs_history thead, #ambassador_payment_history_table thead,#sponsor_payment_history_table thead, #my_ambassador_table thead, #my_sponsor_table thead, #month_runs_history thead,
        .table thead{
            background: #4f7f55 !important;color: white !important;text-align: center;
        }
        #runs_history td, #runs_history th, #ambassador_payment_history_table td, #ambassador_payment_history_table th,  #sponsor_payment_history_table td, #sponsor_payment_history_table th
        , #my_ambassador_table td , #my_sponsor_table td, #my_ambassador_table th , #my_sponsor_table th,
        #month_runs_history th, #month_runs_history td{
            border: none;
            vertical-align: middle;
        }
        #my_ambassador_table .active,#my_sponsor_table .active{
            margin-bottom: 0;
            background: darkgreen;
            color: white;
            padding: 2px 10px;
            border-radius: 27px;
        }
        #my_ambassador_table .deactivate,#my_sponsor_table .deactivate{
            margin-bottom: 0;
            background: #ffb928;
            color: white;
            border: 0;
            padding: 2px 10px;
            border-radius: 27px;
        }
        #runs_history .Pending{
            margin-bottom: 0;
            background: gray;
            color: white;
            padding: 5px 10px;
            border-radius: 27px;
        }
        .calendar-btn{
            border: none;
            background: none;
            border-bottom: 1px solid #cacaca;
        }
        .calendar-btn:focus{
            outline: none;
        }
        .completed{
            background: darkgreen;
            color: white;
            padding: 5px 10px;
            border-radius: 37px;
            font-size: 13px;
        }
        .card-body .form-label{
            font-size: 14px;
        }
        .card-body .form-control:active, .card-body .form-control:focus, #my_sponsors_filters:focus, #ambassador_payment_history_filters:focus, #km_history_filters:focus
        {
            box-shadow: none !important;
        }
        /*.table-responsive{*/
            /*width: 99%;*/
        /*}*/
        .padder .float-right{
            margin-right: 10px;
        }
        .padder .card{
            /*width: 99%;*/
        }
        .tab-content .tab-pane.active{
            background: none;
            border: none;
        }
        .form-label{
            color: black !important;
        }
        .dataTables_scrollHeadInner, .dataTables_scrollHeadInner .table, .table{
            width: 100% !important;
            margin: 0 !important;
        }
        .dataTables_empty{
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        #month_runs_history .alert-warning, #month_runs_history .alert-success{
            font-size: 14px;
            padding: 2px 5px;
            font-weight: 600;
        }
        #my_ambassador_table img,#my_sponsor_table img{
            width: 60px;
            height: 60px;
            border-radius: 100px;
        }
        .datepicker tfoot tr th:hover {
            color: #ff6d81 !important;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ asset('public/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endsection

@section('page-content')

    <!-- Page Content  -->
    <main class="content contact-page profile-page">
        <div class="container padder">
            <div class="row mt-5">
                <img src="{{$user->image ? asset(\App\Helpers\common::getMediaPath($user->image)) : asset('public/images/user-avatar-1.png')}}"
                     class="rounded-circle mx-auto profile-pic" alt="profile"
                     style="width: 150px; height:150px; border: 1px solid #e5e5e5;">
                <div class="p-image d-none">
                    <i class="fa fa-camera upload-button"></i>

                </div>
            </div>
            <h3 class="h3 mx-auto mb-1">{{ $user->first_name.' '.$user->last_name }}</h3>
            <p class="para text-center mb-1">{{ $user->detail->description}} <a class="description-box d-block" href="javascript:void(0);" style="color: #4f7f55; visibility: hidden"><i class="fas fa-edit m-auto"></i></a></p>
        </div>
        <div class="container">
            <div class="profile-padder">
                <div id="errors" class="w-100">
                    @include('errors')
                    @include('flash::message')
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>
                <ul class="nav tab_links row mx-auto nav-tabs border-0" id="myTab"  style="justify-content: center;">
                    <li class="col-lg-2 col-md-3 col-sm-12 my-button"><a class="btn" href="#profile">{{ __('profile.my_profile') }}</a></li>
                    {{--<li class="col-lg-2 col-md-3 col-sm-12 my-button"><a class="btn {{Route::current()->getName() == 'nb.profile' || Route::current()->getName() == 'en.profile' ? 'active' : ''}}" href="{{localized_route('profile')}}">{{ __('profile.my_profile') }}</a></li>--}}

                    @if(Auth::user()->hasRole('ambassador'))
                        <li class="col-lg-3 col-md-4 col-sm-12 my-button"><a class="btn active" href="#register_km">{{ __('profile.register') }} KM</a></li>
                        <li class="col-lg-2 col-md-4 col-sm-12 my-button"><a class="btn" href="#history">{{ __('profile.history') }}</a></li>
                        <li class="col-lg-3 col-md-6 my-button"><a data-toggle="tab" class="btn" href="#ambassador_payment_history">{{ __('profile.payment history') }}</a></li>
                        <li class="col-lg-2 col-md-6 my-button"><a data-toggle="tab" class="btn" href="#my_sponsors">{{ __('profile.my sponsor') }}</a></li>
                        {{--<li class="col-lg-2 col-md-6 my-button"><a class="btn {{Route::current()->getName() == 'nb.my-sponsors' || Route::current()->getName() == 'en.my-sponsors' ? 'active' : ''}} my-sponsor-btn" href="{{localized_route('my-sponsors')}}">{{ __('profile.my sponsor') }}</a></li>--}}
                    @endif

                    @if(Auth::user()->hasRole('sponsor'))
                        <li class="col-lg-3 col-md-4 col-sm-12 my-button"><a class="btn" href="#sponsor_payment_history">{{ __('profile.payment history') }}</a></li>
                        <li class="col-lg-3 col-md-4 col-sm-12 my-button"><a class="btn active" href="#my_ambassadors">{{ __('profile.my ambassador') }}</a></li>
                    @endif
                </ul>
            </div>
            <div class="tab-content">

                <div id="profile" class="tab-pane fade">
                    <div class="head">
                        @if($user->metas->count() && $user->metas->where('key','ambassador_membership_fee_payment_id')->first())
                            <div class="padder">
                                @if(app()->getLocale() == 'nb')
                                    <p class="alert alert-success" style="font-size: 15px">Du har betalt {{$user->metas->where('key','ambassador_membership_fee_payment_id')->first()->payment ? $user->metas->where('key','ambassador_membership_fee_payment_id')->first()->payment->amount : $setting_obj->get_value('ambassador_membership_fee')}}kr medlemsavgift for T-skjorte.</p>
                                @else
                                    <p class="alert alert-success" style="font-size: 15px">You have paid {{$user->metas->where('key','ambassador_membership_fee_payment_id')->first()->payment ? $user->metas->where('key','ambassador_membership_fee_payment_id')->first()->payment->amount : $setting_obj->get_value('ambassador_membership_fee')}}kr membership fee for T-shirt.</p>
                                @endif
                            </div>
                        @elseif($user && $user->hasRole('ambassador') && $setting_obj->get_value('ambassador_membership_fee'))
                            <div class="padder">
                                @if(app()->getLocale() == 'nb')
                                    <p class="alert alert-warning" style="font-size: 15px">Betal {{$setting_obj->get_value('ambassador_membership_fee')}}kr for å bestille T-skjorte. Vi vil ta nærmere kontakt med deg vedrørende størrelse. <a href="{{route('pay-membership-fee',$user->id)}}">Klikk her</a> for å betale.</p>
                                @else
                                    <p class="alert alert-warning" style="font-size: 15px">Pay {{$setting_obj->get_value('ambassador_membership_fee')}}kr to order a T-shirt. We will contact you in more detail regarding size. <a href="{{route('pay-membership-fee',$user->id)}}">Click here</a> to pay</p>
                                @endif
                            </div>
                        @endif

                        <form class="padder" action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-12" id="desc_section" style="display:none;">
                                    <textarea name="description" class="form-control" maxlength="160" placeholder="{{ __('profile.description') }}">{{ $user->detail->description }}</textarea>
                                    <small class="float-right" style="font-size: 12px; font-weight: 600;">{{__('profile.description characters left:')}} <span class="characters">{{$user->detail && $user->detail->description ? (160-(strlen($user->detail->description))) : 160}}</span></small>
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-6 col-sm-12 my-2">
                                    <input type="number" name="mobile_no" class="form-control" placeholder="+47" value="{{ old('mobile_no',$user->mobile_no) }}" min="1" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" required>
                                </div>
                                <div class="col-md-6 col-sm-12 my-2">
                                    <input type="email" name="email" class="form-control" placeholder="{{ __('profile.email') }}" value="{{ old('email',$user->email) }}" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 col-sm-12 my-2">
                                    <input type="text" name="fname" class="form-control" placeholder="{{ __('profile.fname') }}" value="{{ old('fname',$user->first_name) }}" required>
                                </div>
                                <div class="col-md-4 col-sm-12 my-2">
                                    <input type="text" name="lname" class="form-control" placeholder="{{ __('profile.lname') }}" value="{{ old('lname',$user->last_name) }}" required>
                                </div>
                                <div class="col-md-4 col-sm-12 my-2">
                                    <select name="gender" class="form-control" required>
                                        <option value="">{{ __('profile.gender') }}</option>
                                        <option value="male" {{ $user->detail->gender === 'male' ? 'selected' : '' }}>{{__('register.male')}}</option>
                                        <option value="female" {{ $user->detail->gender === 'female' ? 'selected' : '' }}>{{__('register.female')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 col-sm-12 my-2">
                                    <input type="text" name="address" class="form-control" placeholder="{{ __('profile.address') }}" value="{{ $user->detail->address }}">
                                </div>
                                <div class="col-md-4 col-sm-12 my-2">
                                    <input type="text" name="postnummer" class="form-control"
                                           placeholder="{{ __('profile.postnummer') }}" value="{{ $user->detail->zip_code }}">
                                </div>
                                <div class="col-md-4 col-sm-12 my-2">
                                    <input type="text" name="city" class="form-control" placeholder="{{ __('profile.city') }}" value="{{ $user->detail->zip_city }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 col-sm-12 my-2">
                                    <input type="password" name="password" class="form-control" placeholder="{{ __('profile.password') }}" autocomplete="new-password">
                                </div>
                                <div class="col-md-6 col-sm-12 my-2">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('profile.confirm_password') }}" autocomplete="confirm-password">
                                </div>
                            </div>
                            <div class="form-row image-permission-div">
                                <div class="col-md-6 col-sm-12 my-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="profile_image_permission" id="show_image" value="1" {{$user->detail->profile_image_permission ? 'checked' : ''}}>
                                        <label class="form-check-label" for="show_image" style="font-size: 20px; font-weight: 100;">{{__('profile.show image to other users')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 my-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="profile_image_permission" id="hide_image" value="0" {{!$user->detail->profile_image_permission ? 'checked' : ''}}>
                                        <label class="form-check-label" for="hide_image" style="font-size: 20px; font-weight: 100;">{{__('profile.hide image to other users')}}</label>
                                    </div>
                                </div>
                            </div>
                            <input class="file-upload" name="profile_image" type="file" accept="image/*"/>
                            <div class="text-center">
                                <button class="btn mb-2 contact-btn" style="background-color: #4f7f55;color:#fff !important;" type="submit">{{ __('profile.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if(Auth::user()->hasRole('ambassador'))
                    <div id="register_km" class="tab-pane fade active show">
                        <div class="head">
                            <form class="padder register-km-form" action="{{ route('ambassador-runs.store') }}" method="POST" enctype="multipart/form-data"
                                  autocomplete="off">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12 my-2">
                                        <input type="number" name="distance" class="form-control"
                                               placeholder="{{__('profile.today num of km')}}" required value="" min="1"
                                               onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}">
                                    </div>
                                    <div class="col-md-6 col-sm-12 my-2">
                                        <input type="number" class="form-control total-km" placeholder="{{__('profile.num of km of this month')}}"
                                               value="{{Auth::user()->current_month_runs->count() ? Auth::user()->current_month_runs->sum('distance') : 0}}"
                                               disabled="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12 my-2">
                                        <div class="input-group">
                                            <input type="text" id="datepicker" name="date" class="form-control" placeholder="dd-mm-yyyy"
                                                   required value="" data-date-format="dd-mm-yyyy">
                                            <span class="input-group-append" style="font-size: 20px;">
                                                <button type="button" class="btn-default calendar-btn">
                                                <i class="far fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 my-2">
                                        <input type="file" class="form-control" name="proof"/>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn mb-2 contact-btn" style="background-color: #4f7f55;color:#fff !important;"
                                            type="submit">{{ __('profile.add km') }}</button>
                                    @php
                                        $not_paying_month_year = \App\Helpers\common::ambassador_not_paying_month();
                                    @endphp
                                    <div class="float-right">
                                        <a class="btn mb-2 pay-btn bg-danger" style="color: #fff !important;" data-toggle="modal" data-target="#pay_amount_modal"
                                           href="javascript:void(0);">{{__('profile.pay amount')}}</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div id="history" class="tab-pane fade">
                        <div class="padder">
                            @php
                                $not_paying_month_year = \App\Helpers\common::ambassador_not_paying_month();
                            @endphp
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    @if(Auth::check() && Auth::user()->current_month_runs->count())
                                        <div class="alert alert-success" role="alert">
                                            {{__('flash-messages.total km of this month')}}
                                            <span class="font-weight-bold">({{Auth::user()->current_month_runs->count() ? Auth::user()->current_month_runs->sum('distance') : 0}}) km</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="{{Auth::check() && Auth::user()->current_month_runs->count() ? 'col-lg-8' : 'col-lg-12'}} col-sm-12">
                                    <div class="alert alert-danger alert-dismissible fade show pr-0" role="alert">
                                        {{__('flash-messages.payment for the current month will only be possible when the month is over')}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <form action="{{localized_route('profile','#history')}}" method="GET" class="filter_form">
                                <div class="float-right">
                                    <a class="btn mb-0 bg-primary w-auto" href="{{localized_route('ambassador-detail',Auth::id())}}" target="_blank" style="color: #fff !important; padding: 2px 12px;border: none">{{__('profile.km year history')}}</a>
                                    <a class="btn mb-0 bg-danger pay-btn" style="color: #fff !important; padding: 2px 0" data-toggle="modal" data-target="#pay_amount_modal" href="javascript:void(0);">{{__('profile.pay amount')}}</a>
                                    @if($user_runs->count() || count(\Request::all()))
                                        <a style="background: #ffffff;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="{{__('profile.advanced search')}}" data-toggle="collapse" data-target="#km_history_filters" aria-expanded="true"><i class="fa fa-search"></i></a>
                                    @endif
                                    <button type="submit" class="btn mb-0 w-auto download_pdf" name="btn_type" value="km_pdf" style="padding: 2px 12px"><i class="fas fa-download"></i> PDF</button>
                                </div>

                                <div class="clearfix"></div>

                                <div id="km_history_filters" class="collapse {{\Request::has('range_start') ? 'show' : ''}} ">
                                    <div class="card clearfix mt-3">
                                        <div class="card-header bg-dark text-white px-2 py-2">
                                            <b>{{__('profile.advanced search')}}</b>
                                            <a class="float-right" data-toggle="collapse" href="#km_history_filters" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body py-1">
                                            <div class="form-body">
                                                <div class="row mt-1">
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.km range start')}}</label>
                                                        <input type="number" class="form-control form-control-sm" name="range_start" value="{{Request()->range_start}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="0">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.km range end')}}</label>
                                                        <input type="number" class="form-control form-control-sm" name="range_end" value="{{Request()->range_end}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="0">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.date start')}}</label>
                                                        <input type="date" class="form-control form-control-sm" name="start_date" value="{{Request()->start_date}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.date end')}}</label>
                                                        <input type="date" class="form-control form-control-sm" name="end_date" value="{{Request()->end_date}}">
                                                    </div>
                                                </div>
                                            </div><!-- .form-body -->
                                            <div class="clearfix"> </div>
                                            <input type="hidden" name="tab_type" value="history">
                                        </div>
                                        <div class="card-footer py-1">
                                            <div class="row text-right d-block">
                                                <a href="{{localized_route('profile','#history')}}" class="btn btn-sm btn-default mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                                                <button type="submit" class="btn btn-sm mb-0"> {{__('profile.search')}}  </button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <div class="row">
                                <div class="col-lg-5 col-md-6">
                                    <div class="alert alert-primary mt-3" role="alert">
                                        {{__('flash-messages.total km for each month')}}
                                    </div>
                                    <table class="table mt-3 table-striped table-hover table-sm" id="month_runs_history">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{__('general.period')}}</th>
                                            <th scope="col">{{__('general.num of km')}}</th>
                                            <th scope="col">Status</th>
                                            {{--                                            <th scope="col">{{__('general.payment status')}}</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if($user_run_months->count())
                                            @foreach($user_run_months as $month=>$user_run_month)
                                                <tr class="text-center">
                                                    <th scope="row">{{ $loop->index+1 }}</th>
                                                    <td>
                                                        <a href="{{localized_route('ambassador-detail-single-month-detail',[Auth::user()->id,$month])}}" target="_blank">
                                                            {{ \App\Helpers\common::date_in_locale_lang(('01-'.$month),'F Y') }}
                                                        </a>
                                                    </td>
                                                    {{--                                                    <td>{{ date('F, Y', strtotime('01-'.$month)) }}</td>--}}
                                                    <td>{{$user_run_month->sum('distance')}}</td>
                                                    <td>
                                                    <span class="alert {{$user->ambassador_payments->where('month_year',$month)->first() ? 'alert-success' : 'alert-warning'}}">
                                                        @if($user->ambassador_payments->where('month_year',$month)->first())
                                                            {{__('general.paid')}}
                                                        @else
                                                            <a data-toggle="modal" data-target="#pay_amount_modal" href="javascript:void(0);">
                                                            {{ __('general.unpaid') }}
                                                        </a>
                                                        @endif

                                                    </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4"><p class="alert alert-danger text-center mb-0">{{__('general.no any record found')}}</p></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-7 col-md-6">
                                    <div class="alert alert-primary mt-3" role="alert">
                                        {{__('flash-messages.number of km for each session')}}
                                    </div>
                                    <table class="table mt-3 table-striped table-hover table-sm" id="runs_history">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{__('general.date')}}</th>
                                            <th scope="col">{{__('general.num of km')}}</th>
                                            <th scope="col">{{__('general.proof')}}</th>
                                            <th scope="col">{{__('general.action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if($user_runs->count())
                                            @foreach($user_runs as $key=>$user_run)
                                                <tr class="text-center">
                                                    <th scope="row">{{$key+1}}</th>
                                                    <td>{{ \App\Helpers\common::date_in_locale_lang($user_run->date,'M d, Y') }}</td>
                                                    {{--<td>{{date('M d, Y',strtotime($user_run->date))}}</td>--}}
                                                    <td>{{$user_run->distance}}</td>
                                                    <td><a href="{{$user_run->proof ? asset(\App\Helpers\common::getMediaPath($user_run->proof)) : 'javascript:void(0);'}}" target="_blank"><img style="height: 50px; width: 50px" src="{{$user_run->proof ? asset(\App\Helpers\common::getMediaPath($user_run->proof)) : asset('public/images/no-image.png')}}"></a></td>
                                                    <td>
                                                        @if(Auth::user()->ambassador_payments->where('month_year',date('m-Y',strtotime($user_run->date)))->count())
                                                            <span class="alert alert-success p-1" style="font-weight: 600">{{__('general.paid')}}</span>
                                                        @else
                                                            <a href="javascript:void(0);" class="delete-modal" data-toggle="modal" data-modal_title="{{__('profile.update distance')}}" data-target="#editModal" data-initiator="show-edit-modal" data-ajaxurl="{{route('ambassador-runs.edit',$user_run->id)}}"><i class="fa fa-pen mr-2"></i></a>
                                                            <a href="#delModal" class="delete-modal" data-initiator="show-delete-modal" data-action="{{ route('ambassador-runs.destroy', $user_run->id) }}" data-toggle="modal" data-target="#delModal" ><i class="far fa-trash-alt text-danger"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5"><p class="alert alert-danger text-center mb-0">{{__('general.no any record found')}}</p></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="ambassador_payment_history" class="tab-pane fade">
                        <div class="padder">
                            @if(Auth::check() && Auth::user()->current_month_runs->count())
                                <p>
                                <div class="alert alert-success" role="alert">
                                    {{__('flash-messages.total km of this month')}}
                                    <span class="font-weight-bold">({{Auth::user()->current_month_runs->count() ? Auth::user()->current_month_runs->sum('distance') : 0}}) km</span>
                                </div>
                                </p>
                            @endif
                            <form action="{{localized_route('profile','#ambassador_payment_history')}}" method="GET" class="filter_form">

                                <div class="float-right">
                                    @if($ambassador_payments->count() || count(\Request::all()))
                                        <a style="background: #ffffff;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="{{__('profile.advanced search')}}" data-toggle="collapse" data-target="#ambassador_payment_history_filters" aria-expanded="true"><i class="fa fa-search"></i></a>
                                    @endif
                                    <button class="btn mb-0 w-auto download_pdf" style="padding: 2px 12px" name="btn_type" value="ambassador_payments_pdf"><i class="fas fa-download"></i> PDF</button>
                                </div>
                                <div class="clearfix"></div>
                                <div id="ambassador_payment_history_filters" class="collapse {{\Request::has('price_start') ? 'show' : ''}}">
                                    <div class="card clearfix mt-3">
                                        <div class="card-header bg-dark text-white px-2 py-2">
                                            <b>{{__('profile.advanced search')}}</b>
                                            <a class="float-right" data-toggle="collapse" href="#ambassador_payment_history_filters" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body py-1">
                                            <div class="form-body">
                                                <div class="row mt-1">
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.amount start')}}</label>
                                                        <input type="number" class="form-control form-control-sm" name="price_start" value="{{Request()->price_start}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="1">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.amount end')}}</label>
                                                        <input type="number" class="form-control form-control-sm" name="price_end" value="{{Request()->price_end}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="1">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.paying month start')}}</label>
                                                        <input type="month" class="form-control form-control-sm" name="payment_start_month" value="{{Request()->payment_start_month}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.paying month end')}}</label>
                                                        <input type="month" class="form-control form-control-sm" name="payment_end_month" value="{{Request()->payment_end_month}}">
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
                                            <input type="hidden" name="tab_type" value="ambassador_payment_history">
                                        </div>
                                        <div class="card-footer py-1">
                                            <div class="row text-right d-block">
                                                <a href="{{localized_route('profile','#ambassador_payment_history')}}" class="btn btn-sm btn-default mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                                                <button type="submit" class="btn btn-sm mb-0"> {{__('profile.search')}}  </button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <div class="mt-3">
                                <table class="table table-striped table-hover table-sm" id="ambassador_payment_history_table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__('profile.paying date')}}</th>
                                        <th scope="col">{{__('profile.pay amount')}}</th>
                                        <th scope="col">{{__('profile.paying month')}}</th>
                                        <th scope="col">{{__('profile.status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($ambassador_payments->count())
                                        @foreach($ambassador_payments as $ambassador_payment_key=>$ambassador_payment)
                                            <tr class="text-center">
                                                <th scope="row">{{$ambassador_payment_key+1}}</th>
                                                {{--<td>{{ \App\Helpers\common::date_in_locale_lang(('01-'.$ambassador_payment->month_year),'F Y') }}</td>--}}
                                                <td>{{ \App\Helpers\common::date_in_locale_lang($ambassador_payment->created_at,'M d, Y') }}</td>
                                                <td>{{$ambassador_payment->amount ? number_format($ambassador_payment->amount,'2',',','.') : ''}}</td>
                                                <td>
                                                    @if($ambassador_payment->ambassador_payment->count())
                                                        <ol class="pl-0">
                                                            @foreach($ambassador_payment->ambassador_payment as $ambassador_payment_obj_key=>$ambassador_payment_obj)
                                                                <li class="d-flex justify-content-center">
                                                                    {{++$ambassador_payment_obj_key.'. '}} {{ \App\Helpers\common::date_in_locale_lang(('01-'.$ambassador_payment_obj->month_year),'F Y') }}
                                                                    {{Auth::user() && Auth::user()->runs ? '('.Auth::user()->runs->whereBetween('date',[(date('Y-m-d',strtotime('01-'.$ambassador_payment_obj->month_year))),(date('Y-m-t',strtotime('01-'.$ambassador_payment_obj->month_year)))])->sum('distance').' Km)' : ''}}
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                </td>
                                                {{--<td>{{Auth::user()->runs->whereBetween('date',[$first_date,$last_date])->sum('distance')}}</td>--}}
                                                <td>
                                                    <span class="{{$ambassador_payment ? $ambassador_payment->status : ''}}">{{$ambassador_payment ? (__('profile.'.$ambassador_payment->status)): ''}}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"><p class="alert alert-danger text-center mb-0">{{__('general.no any record found')}}</p></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="my_sponsors" class="tab-pane fade">
                        <div class="padder">
                            @if($user_sponsors->count() || count(\Request::all()))
                                <div class="float-right">
                                    <a style="background: #ffffff;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="{{__('profile.advanced search')}}" data-toggle="collapse" data-target="#my_sponsors_filters" aria-expanded="true"><i class="fa fa-search"></i></a>
                                </div>
                            @endif

                            <div class="clearfix"></div>
                            <form action="{{localized_route('profile','#my_sponsors')}}" method="GET">
                                <div id="my_sponsors_filters" class="collapse {{\Request::has('first_name') ? 'show' : ''}}">
                                    <div class="card clearfix mt-3">
                                        <div class="card-header bg-dark text-white px-2 py-2">
                                            <b>{{__('profile.advanced search')}}</b>
                                            <a class="float-right" data-toggle="collapse" href="#my_sponsors_filters" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body py-1">
                                            <div class="form-body">
                                                <div class="row mt-1">
                                                    <div class="col-md-2 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.fname')}}</label>
                                                        <input type="text" class="form-control form-control-sm" name="first_name" value="{{Request()->first_name}}">
                                                    </div>
                                                    <div class="col-md-2 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.lname')}}</label>
                                                        <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request()->last_name}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.date start')}}</label>
                                                        <input type="date" class="form-control form-control-sm" name="date_start" value="{{Request()->date_start}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.date end')}}</label>
                                                        <input type="date" class="form-control form-control-sm" name="date_end" value="{{Request()->date_end}}">
                                                    </div>
                                                    <div class="col-md-2 my-1 px-1">
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
                                            <input type="hidden" name="tab_type" value="my_sponsors">
                                        </div>
                                        <div class="card-footer py-1">
                                            <div class="row text-right d-block">
                                                <a href="{{localized_route('profile','#my_sponsors')}}" class="btn btn-sm btn-default mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                                                <button type="submit" class="btn btn-sm mb-0"> {{__('profile.search')}}  </button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                </div>
                            </form>

                            <div class="mt-3">
                                <table class="table table-striped table-hover table-sm" id="my_sponsor_table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__('profile.image')}}</th>
                                        <th scope="col">{{__('profile.name')}}</th>
                                        <th scope="col">{{__('profile.status')}}</th>
                                        <th scope="col">{{__('general.date')}}</th>
                                        {{--<th scope="col">{{__('general.action')}}</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($user_sponsors->count())
                                        @foreach($user_sponsors as $sponsor_key=>$sponsor)
                                            <tr class="text-center">
                                                <th scope="row">{{$sponsor_key+1}}</th>
                                                <td class="pl-5">
                                                    @if($sponsor->sponsor_user && $sponsor->sponsor_user->detail && $sponsor->sponsor_user->detail->profile_image_permission && $sponsor->sponsor_user->image)
                                                        <img src="{{asset(\App\Helpers\common::getMediaPath($sponsor->sponsor_user->image,'66x66'))}}">
                                                    @else
                                                        <img src="{{asset('public/images/user-avatar-1.png')}}">
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$sponsor->sponsor_user && $sponsor->sponsor_user->first_name ? $sponsor->sponsor_user->first_name : ''}}
                                                    {{$sponsor->sponsor_user && $sponsor->sponsor_user->last_name ? $sponsor->sponsor_user->last_name : ''}}
                                                </td>
                                                <td><span class="{{$sponsor->status ? 'active' : 'deactivate'}}">{{ __('profile.'.($sponsor->status ? 'active' : 'deactivate'))}}</span></td>
                                                {{--<td>{{$sponsor->created_at->format('M d, Y')}}</td>--}}
                                                <td>{{ \App\Helpers\common::date_in_locale_lang($sponsor->created_at,'M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5"><p class="alert alert-danger text-center mb-0">{{__('general.no any record found')}}</p></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                @endif

                @if(Auth::user()->hasRole('sponsor'))
                    <div id="sponsor_payment_history" class="tab-pane fade">
                        <div class="padder">
                            <form action="{{localized_route('profile','#sponsor_payment_history')}}" method="GET" class="filter_form">
                                <div class="float-right">
                                    @if($sponsor_payments->count() || count(\Request::all()))
                                        <a style="background: #ffffff;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="{{__('profile.advanced search')}}" data-toggle="collapse" data-target="#sponsor_payment_history_filters" aria-expanded="true"><i class="fa fa-search"></i></a>
                                    @endif
                                    <button class="btn mb-0 w-auto download_pdf" name="btn_type" value="pdf" style="padding: 2px 12px"><i class="fas fa-download"></i> PDF</button>
                                </div>

                                <div class="clearfix"></div>
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
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.ambassador name')}}</label>
                                                        <input type="text" class="form-control form-control-sm" name="name" value="{{Request()->name}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.amount start')}}</label>
                                                        <input type="number" class="form-control form-control-sm" name="price_start" value="{{Request()->price_start}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="1">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.amount end')}}</label>
                                                        <input type="number" class="form-control form-control-sm" name="price_end" value="{{Request()->price_end}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="1">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.paying month start')}}</label>
                                                        <input type="month" class="form-control form-control-sm" name="payment_start_month" value="{{Request()->payment_start_month}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.paying month end')}}</label>
                                                        <input type="month" class="form-control form-control-sm" name="payment_end_month" value="{{Request()->payment_end_month}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.payment date start')}}</label>
                                                        <input type="date" class="form-control form-control-sm" name="payment_date_start" value="{{Request()->payment_date_start}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.payment date end')}}</label>
                                                        <input type="date" class="form-control form-control-sm" name="payment_date_end" value="{{Request()->payment_date_end}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.status')}}</label>
                                                        <select class="form-control form-control-sm" name="status">
                                                            <option value="">{{__('profile.select status')}}</option>
                                                            <option value="completed" {{Request()->status && Request()->status == 'completed' ? 'selected' : ''}}>{{__('profile.completed')}}</option>
                                                            <option value="pending" {{Request()->status && Request()->status == 'pending' ? 'selected' : ''}}>{{__('profile.pending')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div><!-- .form-body -->
                                            <input type="hidden" name="tab_type" value="sponsor_payment_history">
                                            <div class="clearfix"> </div>
                                        </div>
                                        <div class="card-footer py-1">
                                            <div class="row text-right d-block">
                                                <a href="{{localized_route('profile','#sponsor_payment_history')}}" class="btn btn-sm btn-default mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                                                <button type="submit" class="btn btn-sm mb-0"> {{__('profile.search')}}  </button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <div class="mt-3">
                                <table class="table table-striped table-hover table-sm" id="sponsor_payment_history_table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__('profile.ambassador name')}}</th>
                                        <th scope="col">{{__('profile.paying date')}}</th>
                                        <th scope="col">{{__('profile.pay amount')}}</th>
                                        <th scope="col">{{__('profile.paying month')}}</th>
                                        <th scope="col">{{__('profile.status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($sponsor_payments->count())
                                        @foreach($sponsor_payments as $sponsor_payment_key=>$sponsor_payment)
                                            <tr class="text-center">
                                                <th scope="row">{{$sponsor_payment_key+1}}</th>
                                                <td>
                                                    @php
                                                        $user_obj = '';
                                                        if($sponsor_payment->sponsor_payment->first() && $sponsor_payment->sponsor_payment->first()->sponsor_ambassador && $sponsor_payment->sponsor_payment->first()->sponsor_ambassador->ambassador_user){
                                                            $user_obj = $sponsor_payment->sponsor_payment->first()->sponsor_ambassador->ambassador_user;
                                                        }
                                                    @endphp
                                                    {{$user_obj && $user_obj->first_name ? $user_obj->first_name : '' }}
                                                    {{$user_obj && $user_obj->last_name ? $user_obj->last_name : '' }}
                                                </td>
                                                <td>{{ \App\Helpers\common::date_in_locale_lang($sponsor_payment->created_at,'M d, Y') }}</td>
                                                <td>{{$sponsor_payment ? number_format($sponsor_payment->amount,'2',',','.') : ''}}</td>
                                                <td>
                                                    @if($sponsor_payment->sponsor_payment->count())
                                                        <ol class="pl-0">
                                                            @foreach($sponsor_payment->sponsor_payment as $sponsor_payment_obj_key=>$sponsor_payment_obj)
                                                                <li class="d-flex justify-content-center">
                                                                    {{++$sponsor_payment_obj_key.'. '}} {{ \App\Helpers\common::date_in_locale_lang(('01-'.$sponsor_payment_obj->month_year),'M Y') }}
                                                                    {{$user_obj && $user_obj->runs ? '('.$user_obj->runs->whereBetween('date',[(date('Y-m-d',strtotime('01-'.$sponsor_payment_obj->month_year))),(date('Y-m-t',strtotime('01-'.$sponsor_payment_obj->month_year)))])->sum('distance').' Km)' : ''}}
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="{{$sponsor_payment ? $sponsor_payment->status : ''}}">{{$sponsor_payment ? (__('profile.'.$sponsor_payment->status)): ''}}</span>
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
                        </div>
                    </div>

                    <div id="my_ambassadors" class="tab-pane fade active show">
                        <div class="padder">
                            @if($user_ambassadors->count())
                                <div class="float-right">
                                    <a style="background: #ffffff;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="{{__('profile.advanced search')}}" data-toggle="collapse" data-target="#my_ambassadors_filter" aria-expanded="true"><i class="fa fa-search"></i></a>
                                </div>
                            @endif

                            <div class="clearfix"></div>
                            <form action="{{localized_route('profile','#my_ambassadors')}}" method="GET">
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
                                                    <div class="col-md-2 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.fname')}}</label>
                                                        <input type="text" class="form-control form-control-sm" name="first_name" value="{{Request()->first_name}}">
                                                    </div>
                                                    <div class="col-md-2 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.lname')}}</label>
                                                        <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request()->last_name}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.date start')}}</label>
                                                        <input type="date" class="form-control form-control-sm" name="date_start" value="{{Request()->date_start}}">
                                                    </div>
                                                    <div class="col-md-3 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.date end')}}</label>
                                                        <input type="date" class="form-control form-control-sm" name="date_end" value="{{Request()->date_end}}">
                                                    </div>
                                                    <div class="col-md-2 my-1 px-1">
                                                        <label class="form-label mb-0">{{__('profile.status')}}</label>
                                                        <select class="form-control form-control-sm" name="status">
                                                            <option value="">{{__('profile.select status')}}</option>
                                                            <option value="1" {{Request()->status && Request()->status == '1' ? 'selected' : ''}}>{{__('profile.active')}}</option>
                                                            <option value="0" {{Request()->status && Request()->status == '0' ? 'selected' : ''}}>{{__('profile.deactivate')}}</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div><!-- .form-body -->
                                            <input type="hidden" name="tab_type" value="my_ambassadors">
                                            <div class="clearfix"> </div>
                                        </div>
                                        <div class="card-footer py-1">
                                            <div class="row text-right d-block">
                                                <a href="{{localized_route('profile','#my_ambassadors')}}" class="btn btn-sm btn-default mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                                                <button type="submit" class="btn btn-sm mb-0"> {{__('profile.search')}}  </button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                </div>
                            </form>

                            <div class="mt-3">
                                <table class="table table-striped table-hover table-sm" id="my_ambassador_table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__('profile.image')}}</th>
                                        <th scope="col" class="pl-5">{{__('profile.name')}}</th>
                                        <th scope="col" style="padding-left: 50px;">{{__('profile.status')}}</th>
                                        <th scope="col">{{__('profile.KM this month')}}</th>
                                        <th scope="col">{{__('general.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($user_ambassadors->count())
                                        @foreach($user_ambassadors as $ambassador_key=>$ambassador)
                                            <tr class="text-center">
                                                <th scope="row">{{$ambassador_key+1}}</th>
                                                <td class="pl-4">
                                                    @if($ambassador->ambassador_user && $ambassador->ambassador_user->detail && $ambassador->ambassador_user->detail->profile_image_permission && $ambassador->ambassador_user->image)
                                                        <a target="_blank" href="{{asset(\App\Helpers\common::getMediaPath($ambassador->ambassador_user->image))}}">
                                                            <img src="{{asset(\App\Helpers\common::getMediaPath($ambassador->ambassador_user->image))}}">
                                                        </a>
                                                    @else
                                                        <img src="{{asset('public/images/user-avatar-1.png')}}">
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$ambassador->ambassador_user && $ambassador->ambassador_user->first_name ? $ambassador->ambassador_user->first_name : ''}}
                                                    {{$ambassador->ambassador_user && $ambassador->ambassador_user->last_name ? $ambassador->ambassador_user->last_name : ''}}
                                                </td>
                                                <td><span class="{{$ambassador->status ? 'active' : 'deactivate'}}">{{ __('profile.'.($ambassador->status ? 'active' : 'deactivate'))}}</span></td>
                                                <td>
                                                    {{$ambassador->ambassador_user && $ambassador->ambassador_user->current_month_runs->count() ? $ambassador->ambassador_user->current_month_runs->sum('distance') : 0}} Km
                                                </td>
                                                {{--<td>{{$ambassador->created_at->format('M d, Y')}}</td>--}}
                                                <td>
                                                    <a href="{{localized_route('ambassador-detail',$ambassador->ambassador_user->id)}}" target="_blank"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"><p class="alert alert-danger text-center mb-0">{{__('general.no any record found')}}</p></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <a class="btn mb-0" data-toggle="modal" style="padding: 1px 0;" data-target="#sponsor_pay_amount_modal" href="javascript:void(0);">{{__('profile.pay amount')}}</a>
                            </div>

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Update Modal -->
    @include('admin.partials.update-modal')

    <!-- Update Modal -->
    @include('admin.partials.delete-modal')

    @if(Auth::user()->hasRole('ambassador'))
        <!-- Pay last month amount Modal -->
        @include('ambassadors.pay-amount-modal')
    @endif

    <div class="modal fade" id="sponsor_pay_amount_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('profile.pay amount')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" data-url="{{route('sponsor-pay-amount','#')}}" method="POST" autocomplete="off" class="pay-amount-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>{{__('profile.select ambassador')}}:</label>
                                <select class="form-control" name="ambassador_id" data-ajaxaction="get-user-paying-month" data-sponsor_id="{{Auth::user()->id}}" data-ajaxurl="{{url('get-user-paying-month')}}">
                                    <option value="">{{__('profile.select ambassador')}}</option>
                                    @if($user_ambassadors->count())
                                        @foreach($user_ambassadors as $ambassador_key=>$ambassador)
                                            <option value="{{$ambassador->ambassador_user->id}}">
                                                {{$ambassador->ambassador_user && $ambassador->ambassador_user->first_name ? $ambassador->ambassador_user->first_name : ''}}
                                                {{$ambassador->ambassador_user && $ambassador->ambassador_user->last_name ? $ambassador->ambassador_user->last_name : ''}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>{{__('profile.enter amount you want to pay')}}:</label>
                                <input style="background-color: rgb(233, 236, 239); pointer-events: none;" type="number" class="form-control amount" name="amount" placeholder="{{__('profile.enter amount you want to pay')}}" value="" min="1" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}">
                                <small style="font-weight: 600;color: orange;">{{__('flash-messages.amount must be larger than 1kr.')}}</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{__('profile.total km')}}:</label>
                                <input class="form-control total_amount" placeholder="{{__('profile.total km')}}" value="" disabled/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="d-none month-section">
                                    <label>{{__('profile.last month')}}:</label>
                                    <select class="form-control select2" multiple name="month_year[]">

                                    </select>
                                </div>

                                <div class="alert alert-danger pr-0 d-none no-month-found-msg" role="alert">
                                    {{__('flash-messages.payment for the current month will only be possible when the month is over')}}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">{{__('profile.close')}}</button>
                        <button type="submit" class="btn btn-success btn-sm d-none">{{__('profile.pay')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="{{ asset('public/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    @if(app()->getLocale() && app()->getLocale() == 'nb')
        <script src="{{ asset('public/js/bootstrap-datepicker.no.js') }}"></script>
        <script src="{{asset('public/js/date-no.js')}}"></script>
    @else
        <script src="{{asset('public/js/date-eu.js')}}"></script>
    @endif

    <script src="{{asset('public/js/formatted-numbers.js')}}"></script>
    <script>

        $(document).ready(function () {
            var data_table_date_type = '';
            @if(app()->getLocale() && app()->getLocale() == 'nb')
                data_table_date_type = 'date-no';
            @else
                data_table_date_type = 'date-eu';
            @endif
            profile_register_km_date_picker();

            var readURL = function (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }


            $(".file-upload").on('change', function () {
                readURL(this);
            });

            $(".upload-button").on('click', function () {
                $(".file-upload").click();
            });
            $(document).on("click", ".description-box", function(event) {
                $('#desc_section').toggle();
            });

            //Count description characters and show remaining characters in span
            $(document).on("keyup", "#desc_section textarea", function(event) {
                $(this).closest('#desc_section').find(".characters").text(160 - $(this).val().length);
            });
            //Register km using ajax
            $(document).on("submit", ".register-km-form", function(event) {
                event.preventDefault();
                $(this).find('button[type="submit"]').addClass('disabled');
                $(this).find('button[type="submit"]').attr('type','button');

                if($('#errors div').length){
                    $('#errors div').remove();
                }

                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    dataType: "JSON",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (data)
                    {
                        location.reload();
                    },
                    error: function (xhr, desc, err){
                        var response = JSON.parse(xhr.responseText);
                        var errorString = '<div class="alert alert-danger"><ul class="mb-0 pl-0">';
                        $.each( response.errors, function( key, value) {
                            errorString += '<li class="list-unstyled">' + value + '</li>';
                        });
                        errorString += '</ul></div>';
                        $( '#errors' ).html( errorString );

                        $('.register-km-form button.btn').removeClass('disabled');
                        $('.register-km-form button.btn').attr('type','submit');
                    }
                });
            });

            //Prevent to submit form thorugh pdf button when an enter is pressed in any input in the form
            $(document).on("keypress", ".filter_form", function(e){
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    $(this).closest('.filter_form').find('.download_pdf').attr('type','button');
                }
            });

            $('#myTab a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            // store the currently selected tab in the hash value
            $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                if($('#pay_amount_modal .tab_type').length){
                    $('#pay_amount_modal .tab_type').val(id);
                }
                if(id === 'profile'){
                    $('.para .description-box').css('visibility','visible');
                    $('.p-image').removeClass('d-none');
                }else{
                    $('.p-image').addClass('d-none');
                    $('.para .description-box').css('visibility','hidden');
                }

                @if(!\Request::get('tab_type'))
                if(history.pushState) {
                    history.pushState(null, null, 'profil#'+id);
                }
                else {
                    location.hash = id;
                }
                @else
                    window.location.hash = id;
                @endif
                add_table_responsive_class();
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;
            @if(Session::get('show_tab') && Session::get('show_tab') == 'profile')
                hash = '#profile';
            @endif

            @if(Session::get('show_tab') && Session::get('show_tab') == 'history')
                hash = '#history';
            @endif

            @if(Session::get('show_tab') && Session::get('show_tab') == 'register_km')
                hash = '#register_km';
            @endif

            $('#myTab a[href="' + hash + '"]').tab('show');

            //scroll down to page on tab section
            $('html, body').animate({
                scrollTop: $('#myTab').offset().top
            },1);

            @if($user_runs->count())
                var columnDefs_type = [data_table_date_type];
                var columnDefs_target = [1];
                jquery_data_tables_languages($('#runs_history'),true,columnDefs_type,columnDefs_target);
            @endif



            @if($user_run_months->count())
                var columnDefs_type = [data_table_date_type];
                var columnDefs_target = [1];
                jquery_data_tables_languages($('#month_runs_history'),true,columnDefs_type,columnDefs_target);
            @endif

            @if($ambassador_payments->count())
                var columnDefs_type = [data_table_date_type,data_table_date_type,'formatted-num'];
                var columnDefs_target = [1,2,3];
                jquery_data_tables_languages($('#ambassador_payment_history_table'),true,columnDefs_type,columnDefs_target);
            @endif

            @if($user_sponsors->count())
                var columnDefs_type = [data_table_date_type];
                var columnDefs_target = [4];
                jquery_data_tables_languages($('#my_sponsor_table'),true,columnDefs_type,columnDefs_target);
            @endif

            @if($sponsor_payments->count())
                var columnDefs_type = [data_table_date_type,data_table_date_type,'formatted-num'];
                var columnDefs_target = [2,3,4];
                jquery_data_tables_languages($('#sponsor_payment_history_table'),true,columnDefs_type,columnDefs_target);
            @endif

            @if($user_ambassadors->count())
                jquery_data_tables_languages($('#my_ambassador_table'),true);
            @endif

            $('.select2').select2({ width: '100%', placeholder: $(this).data('placehoder_text') });
        });
    </script>
@endsection