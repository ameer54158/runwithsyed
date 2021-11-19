<div class="modal fade" id="registersponsormodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content pt-0">
            <div class="modal-header border-0 p-0 pt-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        @if(Session::has('flash_contact') && Session::has('show_sponsor_register_modal'))
                            <div id="errors" class="w-100">
                                @include('errors')
                                @include('flash::message')
                            </div>
                        @endif
                        <h5 class="title">{{__('register.register-as-an-sponsor')}}</h5>
                        <p class="description">{{__('register.register-sponsor-form-description')}}</p>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-12">
                            <input type="text" class="form-control" placeholder="+47" name="mobile_no" value="{{old('mobile_no')}}" minlength="8"  maxlength="8" required>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="text" class="form-control" placeholder="E-post" name="email" value="{{old('email')}}" autocomplete="new-email" required>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <input type="text" class="form-control" placeholder="Fornavn" name="first_name" value="{{old('first_name')}}" required>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <input type="text" class="form-control" placeholder="Etternavn" name="last_name" value="{{old('last_name')}}" required>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <select class="form-control" name="gender" required>
                                <option value="">{{__('register.gender')}}</option>
                                <option value="male" {{old('gender') == 'male' ? 'selected' : ''}}>{{__('register.male')}}</option>
                                <option value="female" {{old('gender') == 'female' ? 'selected' : ''}}>{{__('register.female')}}</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <input type="text" class="form-control" placeholder="Adresse" name="address" value="{{old('address')}}">
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <input type="text" class="form-control" placeholder="Postnummer" name="zip_code" value="{{old('zip_code')}}">
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <input type="text" class="form-control" placeholder="By" name="zip_city" value="{{old('zip_city')}}">
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="password" class="form-control" placeholder="Velg passord" name="password" autocomplete="new-password" required>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="password" class="form-control" placeholder="Gjenta passord" name="password_confirmation" autocomplete="new-password-confirm" required>
                        </div>
                    </div>
                    <div class="form-row my-3 form-check ml-1">
                        <label class="form-check-label" for="inlineFormCheck1" style="font-size: 14px">
                            <input class="form-check-input" type="checkbox" id="inlineFormCheck1" name="accept_all_terms" checked required>
                            {!! __('register.terms and conditions') !!}
                        </label>
                    </div>
                    <div class="form-row d-flex justify-content-center mt-4">
                        <button class="btn" type="submit" name="register-button" value="sponsor-button">{{__('register.become-sponsor-btn')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>