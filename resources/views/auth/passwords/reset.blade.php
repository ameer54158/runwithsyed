@extends('layouts.frontend-master')

@section('page-content')
    <!-- Page Content  -->
    <main class="content reset-password-page">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-12 col-12 m-auto">
                    <div class="section">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <p class="title text-center">{{ __('reset-password.reset-password') }}</p>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <div class="col-md-8 m-auto">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"  placeholder="{{ __('reset-password.e-mail') }}" autofocus>


                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8 m-auto">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"  placeholder="{{ __('reset-password.password') }}">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8 m-auto">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('reset-password.confirm-password') }}">

                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 m-auto text-center">
                                    <button type="submit" class="btn">
                                        {{ __('reset-password.reset-password-button') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
