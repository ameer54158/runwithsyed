@extends('profile.profile-master')

@section('title',__('profile.register'))

@section('profile-content')
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
                    <a class="btn mb-0 pay-btn bg-danger" style="color: #fff !important;" data-toggle="modal"
                       style="padding: 1px 0;" data-target="#pay_amount_modal"
                       href="javascript:void(0);">{{__('profile.pay amount')}}</a>
                </div>
            </div>

        </form>
    </div>
@endsection