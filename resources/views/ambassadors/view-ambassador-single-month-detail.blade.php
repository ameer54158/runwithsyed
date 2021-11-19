@extends('layouts.frontend-master')

@section('title',(__('general.ambassador detail')) )

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

    <style>
        #ambassador_runs_history, .table{
            border: 1px solid #4f7f55;
        }
        #ambassador_runs_history thead, .table thead{
            background: #4f7f55;color: white;text-align: center;
        }
        #ambassador_runs_history td, #ambassador_runs_history th, .table th{
            border: none;
            vertical-align: middle;
        }
        .label{
            font-size: 14px;
            margin: 3px 0;
        }
        .value {
            font-size: 16px;
            font-weight: 600;
            margin: 3px 0;
        }
        #pay_amount_modal input[name="amount"]{
            pointer-events: none;
            background: #e9ecef;
        }
        .card-body .form-label{
            font-size: 14px;
        }
        .card-body .form-control:active, .card-body .form-control:focus, #my_sponsors_filters:focus, #ambassador_payment_history_filters:focus, #km_history_filters:focus
        {
            box-shadow: none !important;
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
    </style>
@endsection

@section('page-content')
    <!-- Page Content  -->
    <main class="content ambassador-runs-history-page">
        <div class="container">
            <div id="errors" class="w-100">
                @include('errors')
                @include('flash::message')
            </div>
            @php
                $not_paying_month_year = \App\Helpers\common::sponsor_not_paying_month($ambassador);
            @endphp
            <div class="row">
                <div class="col-md-3 col-4 label">{{__('profile.name')}}:</div>
                <div class="col-md-9 col-8 value">{{$ambassador->first_name ? $ambassador->first_name : ''}} {{$ambassador->last_name ? $ambassador->last_name : ''}}</div>
                <div class="col-md-3 col-4 label">{{__('profile.total km')}}:</div>
                <div class="col-md-3 col-8 value">{{$ambassador->runs->sum('distance')}}Km</div>
                <div class="col-md-3 col-4 label">{{__('profile.num of km of this month')}}:</div>
                <div class="col-md-3 col-8 value">{{$ambassador->current_month_runs->count() ? $ambassador->current_month_runs->sum('distance') : 0}}Km</div>
            </div>
            @if(Auth::user()->hasRole('sponsor'))
                <div class="alert alert-danger mt-2" role="alert">
                    {{__('flash-messages.payment for the current month will only be possible when the month is over')}}
                </div>
            @else
                <hr>
            @endif
            <div class="float-left">

                <h4>{{\App\Helpers\common::date_in_locale_lang(('01-'.$month),'M Y')}}</h4>
            </div>
            <div class="float-right">
                @if(Auth::user()->hasRole('sponsor') && $ambassador->sponsors->count() && $ambassador->sponsors->where('sponsor_user_id',Auth::id())->first() && $ambassador->sponsors->where('sponsor_user_id',Auth::id())->first()->status)
                    <a class="btn mb-0" data-toggle="modal" style="padding: 1px 0;" data-target="#pay_amount_modal" href="javascript:void(0);">{{__('profile.pay amount')}}</a>
                @endif
                @if($ambassador_runs->count() || count(\Request::all()))
                    <a style="background: #ffffff;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="{{__('profile.advanced search')}}" data-toggle="collapse" data-target="#km_history_filters" aria-expanded="true"><i class="fa fa-search"></i></a>
                @endif
            </div>
            <div class="clearfix"></div>
            <form action="{{localized_route('ambassador-detail-single-month-detail',[$ambassador->id,$month])}}" method="GET">
                <div id="km_history_filters" class="collapse <?php if(Request()->has('range_start')) echo 'show'; ?>">
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
                        </div>
                        <div class="card-footer py-1">
                            <div class="row text-right d-block">
                                <a href="{{localized_route('ambassador-detail-single-month-detail',[$ambassador->id,$month])}}" class="btn btn-sm btn-default mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                                <button type="submit" class="btn btn-sm mb-0"> {{__('profile.search')}}  </button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="mt-3">
                <table class="table table-striped table-hover table-sm" id="ambassador_runs_history">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__('general.proof')}}</th>
                        <th scope="col">{{__('general.num of km')}}</th>
                        <th scope="col">{{__('general.date')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($ambassador_runs->count())
                        @foreach($ambassador_runs as $key=>$user_run)
                            <tr class="text-center">
                                <th scope="row">{{$key+1}}</th>
                                <td><a href="{{$user_run->proof ? asset(\App\Helpers\common::getMediaPath($user_run->proof)) : 'javascript:void(0);'}}" target="_blank"><img style="height: 50px; width: 50px" src="{{$user_run->proof ? asset(\App\Helpers\common::getMediaPath($user_run->proof)) : asset('public/images/no-image.png')}}"></a></td>
                                <td>{{$user_run->distance}}</td>
                                <td>{{ \App\Helpers\common::date_in_locale_lang($user_run->date,'M d, Y') }}</td>

                                {{--<td>{{date('M d, Y',strtotime($user_run->date))}}</td>--}}
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
        </div>
    </main>

    @include('sponsor-pay-amount-modal')

@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({ width: '100%', placeholder: "{{__('profile.select period')}}", allowClear: true });

            @if($ambassador_runs->count())
                jquery_data_tables_languages($('#ambassador_runs_history'),true);
            @endif
        });
    </script>
@endsection