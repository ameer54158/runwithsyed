@extends('layouts.frontend-master')

@section('title', __('login.login'))

@section('page-content')

    <!-- Page Content  -->
    <main class="content login-page">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="login-form">
                        <div class="title">{{ __('login.login') }}</div>
                        {{--@include('errors')--}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-row my-3">
                                <div class="col">
                                    <input type="email" class="form-control @if(!Session::has('flash_contact')) @error('email') is-invalid @enderror @endif" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('login.e-mail') }}">
                                    @if(!Session::has('flash_contact'))
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    @endif
                                </div>
                            </div>

                            <div class="form-row my-3">
                                <div class="col">
                                    <input type="password" class="form-control @if(!Session::has('flash_contact')) @error('password') is-invalid @enderror @endif"  name="password" required autocomplete="current-password" placeholder="{{ __('login.password') }}">
                                    @if(!Session::has('flash_contact'))
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            @if (Route::has('password.request'))
                                <div>
                                    <a class="forgot-password" href="{{ route('password.request') }}">{{ __('login.forgot-password') }}?</a>
                                </div>
                            @endif
                            <div class="form-row">
                                <button class="btn login-btn" type="submit">{{ __('login.login') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="register-section h-100">
                        <div class="title">{{__('login.register')}}</div>
                        <div class="form-row mt-5 mb-4">
                            <button class="btn ambassador-reg-btn" data-toggle="modal" data-target="#registerambassadormodal">{{__('login.register-ambassador')}}</button>
                        </div>
                        <div class="form-row my-3">
                            <button class="btn sponsor-reg-btn" data-toggle="modal" data-target="#registersponsormodal">{{__('login.register-sponsor')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Ambassador registration modal -->
    @include('register-ambassador-user-modal')

    <!-- Sponsor registration modal -->
    @include('register-sponsor-user-modal')

@endsection