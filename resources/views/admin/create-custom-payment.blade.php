@extends('layouts.backend-master')

@section('title', 'Create payment')

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    <style>
        .select2-container{
            width: inherit !important;
        }
    </style>
@endsection

@section('page-content')
    <main class="content">
        @include('flash::message')
        @include('errors')

        <h4>Create Payment</h4>
        <hr>
        <form action="{{route('admin.store-custom-payment')}}" method="POST" class="custom-payment-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Select User</label>
                            <select class="form-select select2" name="user_id" data-ajaxaction="get-user-ambassador-or-paying-month" data-ajaxurl="{{url('get-user-ambassador-or-paying-month')}}" required>
                                @if($users->count())
                                    <option value="">Select user</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">
                                            {{$user->first_name.' '.$user->last_name}} ({{$user->email}}) ({{$user->roles->first()->name.' user'}})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 ambassador-section d-none">
                            <label>Select ambassador</label>
                            <select class="custom-select select2" name="ambassador_id" data-ajaxaction="get-user-paying-month" data-ajaxurl="{{url('get-user-paying-month')}}">
                                <option value="">Select ambassador</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 month-section d-none">
                            <label>Select month</label><br>
                            <select class="custom-select select2" name="month_year[]" multiple>
                                <option value="">Select month</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Amount</label>
                            <input type="text" class="form-control amount" name="amount">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Pay amount</button>
        </form>
    </main>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();
        })
    </script>
@endsection

