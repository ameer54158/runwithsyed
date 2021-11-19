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
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-8 m-auto">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('reset-password.e-mail') }}" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 m-auto text-center">
                                    <button type="submit" class="btn">
                                        {{ __('reset-password.send-password-reset-link') }}
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
