@extends('layouts.frontend-master')

@section('title',(__('header.home')) )

@section('page-content')
    @if($was_successful)
        <p>Yes, we can now use your instagram feed</p>
    @else
        <p>Sorry, we failed to get permission to use your insagram feed.</p>
    @endif
@endsection