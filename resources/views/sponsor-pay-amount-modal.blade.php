<div class="modal fade" id="pay_amount_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('profile.pay amount')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('sponsor-pay-amount',$ambassador->id)}}" method="POST" autocomplete="off" class="pay-amount-form">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>{{__('profile.enter amount you want to pay')}}:</label>
                            <input type="number" class="form-control amount" name="amount" placeholder="{{__('profile.enter amount you want to pay')}}" value="" min="1" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}">
                            <small style="font-weight: 600;color: orange;">{{__('flash-messages.amount must be larger than 1kr.')}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('profile.total km')}}:</label>
                            <input class="form-control total_amount" placeholder="{{__('profile.total km')}}" value="" disabled/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>{{__('profile.last month')}}:</label>
                            @if(isset($not_paying_month_year) && $not_paying_month_year->count())
                                <select class="form-control select2" multiple name="month_year[]" required>
                                    @foreach($not_paying_month_year as $key=>$not_paying_month_year_obj)
                                        <option value="{{date('m-Y',strtotime($key))}}" data-total_km="{{$not_paying_month_year_obj->sum('distance')}}">{{ \App\Helpers\common::date_in_locale_lang($key,'M Y')}}</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="alert alert-danger pr-0" role="alert">
                                    {{__('flash-messages.payment for the current month will only be possible when the month is over')}}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">{{__('profile.close')}}</button>
                    @if(isset($not_paying_month_year) && $not_paying_month_year->count())
                        <button type="submit" class="btn btn-success btn-sm">{{__('profile.pay')}}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>