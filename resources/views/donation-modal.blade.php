<style>
    .radio-toolbar input[type="radio"] {
        opacity: 0;
        position: fixed;
        width: 0;
    }
    .radio-toolbar label {
        display: inline-block;
        background-color: #005CAB;
        padding: 3px 10px;
        font-size: 15px;
        border: 1px solid #005CAB;
        border-radius: 4px;
        color: white;
        cursor: pointer;
    }
    .radio-toolbar input[type="radio"]:checked + label {
        background-color:#28a745;
        border-color: #28a745;
    }
</style>
<div class="modal fade" id="donationmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content py-0">
            <div class="modal-header border-0 p-0 pt-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(Session::has('show_donation_modal'))
                    @include('flash::message')
                @endif
                <form action="{{ route('donations.store') }}" method="POST">
                @csrf
                    <div class="form-row" style="border-bottom: 2px solid gainsboro;">
                        <h5 class="title mb-2">{{__('general.donate')}}</h5>
                    </div>
                    <div class="form-row">
                        <div class="col-12 mt-3">
                            <div class="radio-toolbar">
                                <input type="radio" id="50kr" name="amount" value="50" checked>
                                <label for="50kr">50 Kr</label>

                                <input type="radio" id="100kr" name="amount" value="100">
                                <label for="100kr">100 Kr</label>

                                <input type="radio" id="200kr" name="amount" value="200">
                                <label for="200kr">200 Kr</label>

                                <input type="radio" id="300kr" name="amount" value="300">
                                <label for="300kr">300 Kr</label>

                                <input type="radio" id="500kr" name="amount" value="500">
                                <label for="500kr">500 Kr</label>

                                <input type="radio" id="1000kr" name="amount" value="1000">
                                <label for="1000kr">1000 Kr</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-5 col-md-4 pr-0">
                            <div class="radio-toolbar">
                                <input type="radio" id="custom_amount" name="amount" value="custom_amount">
                                <label for="custom_amount" style="margin-bottom: 0;margin-top: 8px;">{{__('general.other amount')}}</label>
                            </div>
                        </div>
                        <div class="col-7 col-md-8 pl-0 d-none amount-input">
                            <input type="number" name="custom_amount" class="form-control" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" min="2" placeholder="Tast inn beløp">
                            <small style="font-weight: 600;color: orange;">{{__('flash-messages.amount must be larger than 1kr.')}}</small>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">{{__('general.your name (optional)')}}</label>
                        <div class="col-sm-7 pl-0">
                            <input type="text" name="name" class="form-control" placeholder="{{__('general.enter name')}}">
                        </div>
                    </div>

                    <!--
                    <div class="form-row">
                        <div class="col-md-6 col-12">
                            <input type="number" name="phone" class="form-control" placeholder="+47" min="1" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" required>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="text" name="email" class="form-control" placeholder="E-post" required>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="text" name="first_name" class="form-control" placeholder="Fornavn">
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="text" name="last_name" class="form-control" placeholder="Etternavn">
                        </div>
                        <div class="col-md-12 col-12">
                            <input type="text" class="form-control" name="address" placeholder="Adresse">
                        </div>
                        <div class="col-md-12 col-12">
                            <textarea name="additional_note" class="form-control" placeholder="Tilleggsmerknad" rows="3"></textarea>
                        </div>
                    </div>
                    -->
                    <!--
                    <div class="form-row">
                        <div class="col-12">
                            <h6 style="font-weight: 600;margin-top: 15px;"><span style="border-bottom: 2px solid #4f7f55;padding-bottom: 5px;">Velg din betalingsmetode</span></h6>
                        </div>
                    </div>
                    <div class="form-row my-2">
                        <div class="col-md-3 col-6">
                            <div class="form-check">
                                <input class="form-check-input" name="payment_method" type="radio" id="vips-input" value="vipps" required>
                                <label class="form-check-label" for="vips-input" style="font-size: 14px">
                                    Vipps
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-check">
                                <input class="form-check-input" name="payment_method" type="radio" id="klarna-input" value="klarna" required>
                                <label class="form-check-label" for="klarna-input" style="font-size: 14px">
                                    Klarna
                                </label>
                            </div>
                        </div>
                    </div>
                    -->
                    <div class="form-row d-flex justify-content-center mt-4">
                        <button class="btn">{{__('general.donate now')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
