<table class="table mt-3 table-striped table-hover table-sm" id="month_runs_history">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">{{__('general.period')}}</th>
        <th scope="col">{{__('general.num of km')}}</th>
        <th scope="col">{{__('profile.status')}}</th>
        <th scope="col">{{__('general.action')}}</th>
    </tr>
    </thead>
    <tbody>

    @if($user_run_months->count())
        @php $key=0; @endphp
        @foreach($user_run_months as $month=>$user_run_month)
            <tr class="text-center">
                <th scope="row">{{++$key}}</th>
                <td>{{ \App\Helpers\common::date_in_locale_lang(('01-'.$month),'F Y') }}</td>

                {{--<td>{{ date('F, Y', strtotime('01-'.$month)) }}</td>--}}
                <td>{{$user_run_month->sum('distance')}}</td>
                <td>
                    @php
                        if(Auth::user()->hasRole('sponsor')){
                            $not_paying_month_year = \App\Helpers\common::sponsor_not_paying_month($ambassador);
                        }

                        if(Auth::user()->hasRole('ambassador')){
                            $not_paying_month_year = \App\Helpers\common::ambassador_not_paying_month();
                        }
                        $status = 'paid';
                        if(date('m-Y') == $month || (isset($not_paying_month_year[date('Y-m', strtotime('01-'.$month))]) && $not_paying_month_year[date('Y-m', strtotime('01-'.$month))])){
                            $status = 'not_paid';
                        }
                    @endphp
                    <span style="font-weight: 600; font-size: 13px" class="p-1 alert {{$status == 'not_paid' ? 'alert-warning' : 'alert-success'}}">
                        @if($status == 'not_paid')
                            @if(Auth::user()->hasRole('sponsor') && $ambassador->sponsors->count() && $ambassador->sponsors->where('sponsor_user_id',Auth::id())->first() && $ambassador->sponsors->where('sponsor_user_id',Auth::id())->first()->status)
                                <a data-toggle="modal" data-target="#pay_amount_modal" href="javascript:void(0);">{{__('general.unpaid')}}</a>
                            @else
                                {{__('general.unpaid')}}
                            @endif
                        @else
                            {{__('general.paid')}}
                        @endif
                    </span>
                </td>
                <td><a class="text-info" href="{{localized_route('ambassador-detail-single-month-detail',[$ambassador->id,$month])}}" target="_blank"><i class="fa fa-eye"></i></a></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5"><p class="alert alert-danger text-center mb-0">{{__('general.no any record found')}}</p></td>
        </tr>
    @endif
    </tbody>
</table>

