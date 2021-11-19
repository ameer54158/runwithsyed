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

            <div class="float-right">
                @if(Auth::user()->hasRole('sponsor') && $ambassador->sponsors->count() && $ambassador->sponsors->where('sponsor_user_id',Auth::id())->first() && $ambassador->sponsors->where('sponsor_user_id',Auth::id())->first())
                    <a class="btn mb-0" data-toggle="modal" style="padding: 1px 0;" data-target="#pay_amount_modal" href="javascript:void(0);">{{__('profile.pay amount')}}</a>
                @endif
            </div>
            <div class="clearfix"></div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <table class="table mt-3 table-striped table-hover table-sm" id="year_runs_history">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{__('general.period')}}</th>
                            <th scope="col">{{__('general.num of km')}}</th>
                            <th scope="col">{{__('general.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if($user_run_year->count())
                            @php $year_key=0; @endphp
                            @foreach($user_run_year as $year=>$user_run_year_obj)
                                <tr class="text-center">
                                    <th scope="row">{{++$year_key}}</th>
                                    <td>{{ $year }}</td>
                                    <td>{{$user_run_year_obj->sum('distance')}}</td>
                                    <td><a class="text-info" href="javascript:void(0);" data-action="{{localized_route('ambassador-detail',$ambassador->id)}}" data-year="{{$year}}"><i class="fa fa-eye"></i></a></td>
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

                <div class="col-md-6 ambassador_months_table_section">
                    @include('ambassadors.view-ambassador-year-months-table')
                </div>
            </div>
        </div>
    </main>

    @include('sponsor-pay-amount-modal')
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    @if(app()->getLocale() && app()->getLocale() == 'nb')
        <script src="{{asset('public/js/date-no.js')}}"></script>
    @else
        <script src="{{asset('public/js/date-eu.js')}}"></script>
    @endif

    <script>
        $(document).ready(function () {
            $('.select2').select2({ width: '100%' });

            var data_table_date_type = '';
            @if(app()->getLocale() && app()->getLocale() == 'nb')
                data_table_date_type = 'date-no';
            @else
                data_table_date_type = 'date-eu';
            @endif

            @if($user_run_year->count())
                jquery_data_tables_languages($('#year_runs_history'),true);
            @endif

            @if($user_run_months->count())
                var columnDefs_type = [data_table_date_type];
                var columnDefs_target = [1];
                jquery_data_tables_languages($('#month_runs_history'),true,columnDefs_type,columnDefs_target);
            @endif

            //Register km using ajax
            $(document).on("click", "#year_runs_history a", function(event) {
                event.preventDefault();

                $.ajax({
                    url: $(this).data("action"),
                    dataType: "JSON",
                    data: {'year':$(this).data('year')},
                    success: function (responose)
                    {
                        if(responose.data){
                            $('.ambassador_months_table_section').html(responose.data);
                            var columnDefs_type = [data_table_date_type];
                            var columnDefs_target = [1];
                            jquery_data_tables_languages($('#month_runs_history'),true,columnDefs_type,columnDefs_target);
                        }
                    },
                    error: function (xhr, desc, err){

                    }
                });
            });
        });
    </script>
@endsection