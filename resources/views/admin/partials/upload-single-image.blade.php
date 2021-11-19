
<div class="fileinput fileinput-{{$src ? trim('exists') : trim('new')}} " data-provides="fileinput">
    <div class="fileinput-new thumbnail">
        <img src="{{asset('public/images/no-image-placeholder.png')}}" alt="">
    </div>
    <div class="fileinput-preview fileinput-exists thumbnail">
        @if($src)
            <img src="{{$src}}" alt="" style="width: 100%"/>
        @endif
    </div>

    <div class="ml-3">
        <span class="btn default btn-file">
        <span class="fileinput-new btn btn-primary btn-sm"> Select image </span>

        <input type="file" name="{{$file_name}}" class="single-image-input" {{$required_attr}}> </span>
        <a href="javascript:void(0);" class="btn red fileinput-exists btn btn-danger btn-sm remove-single-image" id="{{$file_unique_name}}" data-dismiss="fileinput"> Remove </a>
    </div>
</div>

<input type="hidden" class="deleted_media" name="deleted_media">