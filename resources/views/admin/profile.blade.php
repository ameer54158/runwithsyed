@extends('layouts.backend-master')

@section('title', 'Edit profile')

@section('page-content')
    <!-- Page Content  -->
    <main class="content">
        @include('flash::message')
        @include('errors')
        <h4>Update profile</h4>
        <form autocomplete="off" method="POST" action="{{route('update-profile',Auth::id())}}">
            @csrf @method('PUT')
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Role</label>
                    <input type="text" class="form-control" value="{{$user->roles->first() ? $user->roles->first()->name : ''}}" disabled>
                </div>
                <div class="form-group col-md-4">
                    <label>E-mail</label>
                    <input type="email" class="form-control" name="email" autocomplete="new-email" value="{{$user->email}}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>First name</label>
                    <input type="text" class="form-control" name="first_name" value="{{old('first_name',$user->first_name)}}">
                </div>
                <div class="form-group col-md-4">
                    <label>Last name</label>
                    <input type="text" class="form-control" name="last_name" value="{{old('last_name',$user->last_name)}}">
                </div>
                <div class="form-group col-md-4">
                    <label>Mobile</label>
                    <input type="number" class="form-control" name="mobile_no" value="{{old('mobile_no',$user->mobile_no)}}"  minlength="8" maxlength="8" step="1" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
                </div>
            </div>

            <hr>
            <h5>Change password</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" autocomplete="new-password" name="new_password">
                </div>
                <div class="form-group col-md-6">
                    <label for="confirm-password">Confirm password</label>
                    <input type="password" class="form-control" id="confirm-password" autocomplete="new-password" name="confirm_password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update profile</button>
        </form>
    </main>
@endsection