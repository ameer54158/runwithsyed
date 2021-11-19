@extends('profile.profile-master')

@section('title',__('profile.payment history'))

@section('profile-content')

    <div class="padder">
        @if(Auth::check() && Auth::user()->current_month_runs->count())
            <p>
                <div class="alert alert-success" role="alert">
                    {{__('flash-messages.total km of this month')}}
                    <span class="font-weight-bold">({{Auth::user()->current_month_runs->count() ? Auth::user()->current_month_runs->sum('distance') : 0}}) km</span>
                </div>
            </p>
        @endif
        <form action="{{localized_route('ambassador-payment-history')}}" method="GET" class="filter_form">

            <div class="float-right">
                @if($ambassador_payments->count() || count(\Request::all()))
                    <a style="background: #ffffff;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="{{__('profile.advanced search')}}" data-toggle="collapse" data-target="#ambassador_payment_history_filters" aria-expanded="true"><i class="fa fa-search"></i></a>
                @endif
                <button class="btn mb-0 w-auto download_pdf" style="padding: 2px 12px" name="btn_type" value="pdf"><i class="fas fa-download"></i> PDF</button>
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
                    </div>
                    <div class="card-footer py-1">
                        <div class="row text-right d-block">
                            <a href="{{localized_route('ambassador-payment-history')}}" class="btn btn-sm btn-default mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                            <button type="submit" class="btn btn-sm mb-0"> {{__('profile.search')}}  </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>
        <div class="">
            <table class="table mt-3 table-striped table-hover table-sm" id="payment_history_table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('profile.paying month')}}</th>
                    <th scope="col">{{__('profile.paying date')}}</th>
                    <th scope="col">{{__('profile.pay amount')}}</th>
                    <th scope="col">{{__('profile.total km')}}</th>
                    <th scope="col">{{__('profile.status')}}</th>
                </tr>
                </thead>
                <tbody>

                @if($ambassador_payments->count())
                    @foreach($ambassador_payments as $ambassador_payment_key=>$ambassador_payment)
                        <tr class="text-center">
                            <th scope="row">{{$ambassador_payment_key+1}}</th>
                            @php
                                $first_date = date('Y-m-d', strtotime('01-'.$ambassador_payment->month_year));
                                $last_date = date('Y-m-t', strtotime(date('01-'.$ambassador_payment->month_year)));
                            @endphp
                            <td>{{date('M, Y', strtotime('01-'.$ambassador_payment->month_year))}}</td>
                            <td>{{$ambassador_payment->created_at->format('M, d Y')}}</td>
                            <td>{{$ambassador_payment->payment ? number_format($ambassador_payment->payment->amount,'2',',','.') : ''}}</td>
                            <td>{{Auth::user()->runs->whereBetween('date',[$first_date,$last_date])->sum('distance')}}</td>
                            <td>
                                <span class="{{$ambassador_payment->payment ? $ambassador_payment->payment->status : ''}}">{{$ambassador_payment->payment ? (__('profile.'.$ambassador_payment->payment->status)): ''}}</span>
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
        <div class="pagination w-100">
            {{ $ambassador_payments->appends(request()->query())->links() }}
        </div>
    </div>

@endsection