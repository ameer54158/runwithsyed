@extends('profile.profile-master')

@section('title', __('profile.my_profile'))

@section('profile-content')
    <div class="head">
        @if($user->metas->count() && $user->metas->where('key','ambassador_membership_fee_payment_id')->first())
            <div class="padder">
                @if(app()->getLocale() == 'nb')
                    <p class="alert alert-success" style="font-size: 15px">Du har betalt {{$setting_obj->get_value('ambassador_membership_fee')}}kr medlemsavgift for T-skjorte.</p>
                @else
                    <p class="alert alert-success" style="font-size: 15px">You have paid {{$setting_obj->get_value('ambassador_membership_fee')}}kr membership fee for T-shirt.</p>
                @endif
            </div>
        @elseif($user && $user->hasRole('ambassador') && $setting_obj->get_value('ambassador_membership_fee'))
            <div class="padder">
                @if(app()->getLocale() == 'nb')
                    <p class="alert alert-warning" style="font-size: 15px">Betal {{$setting_obj->get_value('ambassador_membership_fee')}}kr for å bestille T-skjorte. Vi vil ta nærmere kontakt med deg vedrørende størrelse.. <a href="{{route('pay-membership-fee',$user->id)}}">Klikk her</a> for å betale.</p>
                @else
                    <p class="alert alert-warning" style="font-size: 15px">Pay {{$setting_obj->get_value('ambassador_membership_fee')}}kr to order a T-shirt. We will contact you in more detail regarding size. <a href="{{route('pay-membership-fee',$user->id)}}">Click here</a> to pay</p>
                @endif
            </div>
        @endif

        <form class="padder" action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-12" id="desc_section" style="display:none;">
                    <textarea name="description" class="form-control" maxlength="160" placeholder="{{ __('profile.description') }}">{{ $user->detail->description }}</textarea>
                    <small class="float-right" style="font-size: 12px; font-weight: 600;">{{__('profile.description characters left:')}} <span class="characters">{{$user->detail && $user->detail->description ? (160-(strlen($user->detail->description))) : 160}}</span></small>
                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="form-row">
                <div class="col-md-6 col-sm-12 my-2">
                    <input type="number" name="mobile_no" class="form-control" placeholder="+47" value="{{ old('mobile_no',$user->mobile_no) }}" min="1" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" required>
                </div>
                <div class="col-md-6 col-sm-12 my-2">
                    <input type="email" name="email" class="form-control" placeholder="{{ __('profile.email') }}" value="{{ old('email',$user->email) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 col-sm-12 my-2">
                    <input type="text" name="fname" class="form-control" placeholder="{{ __('profile.fname') }}" value="{{ old('fname',$user->first_name) }}" required>
                </div>
                <div class="col-md-4 col-sm-12 my-2">
                    <input type="text" name="lname" class="form-control" placeholder="{{ __('profile.lname') }}" value="{{ old('lname',$user->last_name) }}" required>
                </div>
                <div class="col-md-4 col-sm-12 my-2">
                    <select name="gender" class="form-control" required>
                        <option value="">{{ __('profile.gender') }}</option>
                        <option value="male" {{ $user->detail->gender === 'male' ? 'selected' : '' }}>{{__('register.male')}}</option>
                        <option value="female" {{ $user->detail->gender === 'female' ? 'selected' : '' }}>{{__('register.female')}}</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 col-sm-12 my-2">
                    <input type="text" name="address" class="form-control" placeholder="{{ __('profile.address') }}" value="{{ $user->detail->address }}">
                </div>
                <div class="col-md-4 col-sm-12 my-2">
                    <input type="text" name="postnummer" class="form-control"
                           placeholder="{{ __('profile.postnummer') }}" value="{{ $user->detail->zip_code }}">
                </div>
                <div class="col-md-4 col-sm-12 my-2">
                    <input type="text" name="city" class="form-control" placeholder="{{ __('profile.city') }}" value="{{ $user->detail->zip_city }}">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 col-sm-12 my-2">
                    <input type="password" name="password" class="form-control" placeholder="{{ __('profile.password') }}" autocomplete="new-password">
                </div>
                <div class="col-md-6 col-sm-12 my-2">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('profile.confirm_password') }}" autocomplete="confirm-password">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 col-sm-12 my-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="profile_image_permission" id="show_image" value="1" {{$user->detail->profile_image_permission ? 'checked' : ''}}>
                        <label class="form-check-label" for="show_image" style="font-size: 20px; font-weight: 100;">{{__('profile.show image to other users')}}</label>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 my-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="profile_image_permission" id="hide_image" value="0" {{!$user->detail->profile_image_permission ? 'checked' : ''}}>
                        <label class="form-check-label" for="hide_image" style="font-size: 20px; font-weight: 100;">{{__('profile.hide image to other users')}}</label>
                    </div>
                </div>
            </div>
            <input class="file-upload" name="profile_image" type="file" accept="image/*"/>
            <div class="text-center">
                <button class="btn mb-2 contact-btn" style="background-color: #4f7f55;color:#fff !important;" type="submit">{{ __('profile.save') }}</button>
            </div>
        </form>
    </div>
@endsection