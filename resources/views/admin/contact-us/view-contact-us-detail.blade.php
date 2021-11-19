<div class="modal-body">
    <div class="form-row">
        <div class="form-group col-md-2">
            <label class="label">First name:</label>
        </div>
        <div class="form-group col-md-4">
            <label class="value">{{$contact_us_obj->first_name}}</label>
        </div>
        <div class="form-group col-md-2">
            <label class="label">Last name:</label>
        </div>
        <div class="form-group col-md-4">
            <label class="value">{{$contact_us_obj->last_name}}</label>
        </div>
    </div>
    <div class="form-row">
        @if($contact_us_obj->telephone)
            <div class="form-group col-md-2">
                <label class="label">Telephone no:</label>
            </div>
            <div class="form-group col-md-4">
                <label class="value">{{$contact_us_obj->telephone ? $contact_us_obj->telephone : ''}}</label>
            </div>
        @endif
        <div class="form-group col-md-2">
            <label class="label">Email:</label>
        </div>
        <div class="form-group col-md-4">
            <label class="value">{{$contact_us_obj->email}}</label>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label class="label">Subject:</label>
        </div>
        <div class="form-group col-md-4">
            <label class="value">{{$contact_us_obj->subject}}</label>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label class="label">Message:</label><br>
            <label class="value" style="white-space: pre-line">{{$contact_us_obj->message}}</label>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
</div>
