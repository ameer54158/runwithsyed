@if(!Session::has('flash_contact') && !Session::has('donation-model') && !Session::has('show_donation_modal'))
    <div id="errors" class="w-100">
        @include('errors')
        @include('flash::message')
    </div>
@endif
<form action="{{route('contact-us-store')}}" method="POST">
    @csrf
    <div class="form-row my-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="{{__('general.first name')}}" name="first_name" value="{{old('first_name')}}" required>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="{{__('general.last name')}}" name="last_name" value="{{old('last_name')}}" required>
        </div>
    </div>

    <div class="form-row my-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="{{__('general.telephone')}}" name="telephone" value="{{old('telephone')}}">
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="{{__('general.e-mail')}}" name="email" value="{{old('email')}}" required>
        </div>
    </div>
    <div class="form-row my-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="{{__('general.subject')}}" name="subject" value="{{old('subject')}}" required>
        </div>
    </div>
    <div class="form-row my-3">
        <div class="col">
            <textarea class="form-control" rows="4" placeholder="{{__('general.message')}}" name="message" required>{{old('message')}}</textarea>
        </div>
    </div>
    <div class="text-center">
        <button class="btn mb-2" type="submit">SEND</button>
    </div>
</form>