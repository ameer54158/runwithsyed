@extends('layouts.frontend-master')

@section('title', 'Payment')

@section('page-content')

    @if(isset($status) && $status == 'cancel')
        <h4 class="alert alert-danger w-75 m-auto">
            @if(app()->getLocale() == 'nb')
                Betalingen er avbrutt og du må gjerne prøve igjen senere.
            @else
                Payment has been cancelled and you may want to try again later.
            @endif
        </h4>
    @elseif(isset($status) && $status == 'captured')
        <h4 class="alert alert-success w-75 m-auto">
            @if(app()->getLocale() == 'nb')
                Betalingen er avbrutt og du må gjerne prøve igjen senere.
            @else
                Takk! Betalingen er fullført.
            @endif
        </h4>
    @else
        <h4 class="alert alert-danger w-75 m-auto">{{$status}}</h4>
    @endif

@endsection