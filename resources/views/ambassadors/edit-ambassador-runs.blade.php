<form action="{{route('ambassador-runs.update',$runs->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off" class="update-ambassador-runs-form">
    @csrf @method('PUT')
    <div class="modal-body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label style="font-weight: 600">{{__('profile.today num of km')}}:</label>
                <input type="number" class="form-control" name="distance" placeholder="{{__('profile.today num of km')}}" value="{{old('distance',$runs->distance)}}" min="1" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}">
            </div>
            <div class="form-group col-md-6">
                <label style="font-weight: 600">{{__('profile.select date')}}:</label>
                <div class="input-group">
                    <input type="text" id="datepicker" name="date" data-date-format="dd-mm-yyyy" class="form-control" placeholder="dd-mm-yyyy" value="{{date('d-m-Y',strtotime($runs->date))}}" @if(date('m',strtotime($runs->date)) != date('m')) style="pointer-events: none; background: lightgray" @endif required>
                    <span class="input-group-append" style="font-size: 20px;">
                        <button type="button" class="btn-default calendar-btn">
                        <i class="far fa-calendar"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label style="font-weight: 600">{{__('general.proof')}}:</label>
                <input type="file" class="form-control" name="proof" />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">{{__('profile.close')}}</button>
        <button type="submit" class="btn btn-success btn-sm">{{__('profile.update distance')}}</button>
    </div>
</form>