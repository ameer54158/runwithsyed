@extends('profile.profile-master')

@section('title',__('profile.history'))

@section('profile-content')

    <div class="padder">
        @php
            $not_paying_month_year = \App\Helpers\common::ambassador_not_paying_month();
        @endphp
    @if($not_paying_month_year->count())
    <div class="row">
        <div class="col-md-4 col-sm-12">
            @if(Auth::check() && Auth::user()->current_month_runs->count())
                <div class="alert alert-success" role="alert">
                    {{__('flash-messages.total km of this month')}}
                    <span class="font-weight-bold">({{Auth::user()->current_month_runs->count() ? Auth::user()->current_month_runs->sum('distance') : 0}}) km</span>
                </div>
            @endif
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="alert alert-danger alert-dismissible fade show pr-0" role="alert">
                {{__('flash-messages.payment for the current month will only be possible when the month is over')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif
    <form action="{{localized_route('km-history')}}" method="GET" class="filter_form">
        <div class="float-right">
            <a class="btn mb-0 bg-danger pay-btn" style="color: #fff !important; padding: 2px 0" data-toggle="modal" style="padding: 1px 0;" data-target="#pay_amount_modal" href="javascript:void(0);">{{__('profile.pay amount')}}</a>
            @if($user_runs->count() || count(\Request::all()))
                <a style="background: #ffffff;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="{{__('profile.advanced search')}}" data-toggle="collapse" data-target="#km_history_filters" aria-expanded="true"><i class="fa fa-search"></i></a>
            @endif
            <button type="submit" class="btn mb-0 w-auto download_pdf" name="btn_type" value="pdf" style="padding: 2px 12px"><i class="fas fa-download"></i> PDF</button>
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
                    </div>
                    <div class="card-footer py-1">
                        <div class="row text-right d-block">
                            <a href="{{localized_route('km-history')}}" class="btn btn-sm btn-default mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                            <button type="submit" class="btn btn-sm mb-0"> {{__('profile.search')}}  </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>
        <div class="row">
        <div class="table-responsive col-md-5">
          <div class="alert alert-primary mt-3" role="alert">
            {{__('flash-messages.total km for each month')}}
        </div>
            <table class="table mt-3 table-striped table-hover table-sm" id="runs_history">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('general.month')}}</th>
                    <th scope="col">{{__('general.num of km')}}</th>
                </tr>
                </thead>
                <tbody>

                @if($user_run_months->count())
                    @foreach($user_run_months as $month=>$user_run_month)
                        <tr class="text-center">
                            <th scope="row">{{ $loop->index+1 }}</th>
                            <td>{{ $month }}</td>
                            <td>{{$user_run_month->sum('distance')}}</td>
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
         <div class="table-responsive col-md-7">
         <div class="alert alert-primary mt-3" role="alert">
            {{__('flash-messages.number of km for each session')}}
        </div>
            <table class="table mt-3 table-striped table-hover table-sm" id="runs_history">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('general.proof')}}</th>
                    <th scope="col">{{__('general.num of km')}}</th>
                    <th scope="col">{{__('general.date')}}</th>
                    <th scope="col">{{__('general.action')}}</th>
                </tr>
                </thead>
                <tbody>

                @if($user_runs->count())
                    @foreach($user_runs as $key=>$user_run)
                        <tr class="text-center">
                            <th scope="row">{{$key+1}}</th>
                            <td><a href="{{$user_run->proof ? asset(\App\Helpers\common::getMediaPath($user_run->proof)) : 'javascript:void(0);'}}" target="_blank"><img style="height: 50px; width: 50px" src="{{$user_run->proof ? asset(\App\Helpers\common::getMediaPath($user_run->proof)) : asset('public/images/no-image.png')}}"></a></td>
                            <td>{{$user_run->distance}}</td>
                            <td>{{date('M d, Y',strtotime($user_run->date))}}</td>
                            <td>
                                @if(Auth::user()->ambassador_payments->where('month_year',date('m-Y',strtotime($user_run->date)))->count())
                                    <span class="alert alert-warning p-1" style="font-weight: 600">{{__('profile.not access')}}</span>
                                @else
                                    <a href="javascript:void(0);" class="delete-modal" data-toggle="modal" data-modal_title="{{__('profile.update distance')}}" data-target="#editModal" data-initiator="show-edit-modal" data-ajaxurl="{{route('ambassador-runs.edit',$user_run->id)}}"><i class="fa fa-pen mr-2"></i></a>
                                    <a href="#delModal" class="delete-modal" data-initiator="show-delete-modal" data-action="{{ route('ambassador-runs.destroy', $user_run->id) }}" data-toggle="modal" data-target="#delModal" ><i class="far fa-trash-alt text-danger"></i></a>
                                @endif
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
        <div class="pagination w-100">
            {{ $user_runs->appends(request()->query())->links() }}
        </div>
    </div>
@endsection