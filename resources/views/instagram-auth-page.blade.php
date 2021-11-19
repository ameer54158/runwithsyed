@extends('layouts.frontend-master')

@section('title',(__('header.home')) )

@section('page-content')
    <a href="{{ $instagram_auth_url }}">Click to get Instgram permission</a>
@endsection