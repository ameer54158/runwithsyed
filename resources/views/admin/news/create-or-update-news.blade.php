@extends('layouts.backend-master')

@section('title', ($news->id ? 'Edit' : 'Add').' news')

@section('style')
    <link href="{{ asset('public/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@endsection

@section('page-content')
    <main class="content">
        @include('flash::message')
        @include('errors')
        <input name="csrf-token" value="{{ csrf_token() }}" id="csrf_token" type="hidden"/>
        <div class="clearfix"></div>
        <h4>{{$news->id ? 'Edit' : 'Add'}} news </h4>
        <hr>
        <form action="{{$news->id ? route('admin.news.update',$news->id) : route('admin.news.store')}}" method="POST" enctype="multipart/form-data">
            @csrf @if($news->id) @method('PUT') @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">
                            <h6>English</h6>
                            <hr>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <h6>Norwegian</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title_en" value="{{old('title_en',$news->title_en)}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title_no" value="{{old('title_no',$news->title_no)}}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Description <small class="font-weight-bold">(in english)</small></label>
                            <textarea class="form-control text-editor-with-media" name="description_en" rows="5">{{old('description_en',$news->description_en)}}</textarea>
                            <small class="font-weight-bold text-danger">This field is required.</small>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Description <small class="font-weight-bold">(in norwegian)</small></label>
                            <textarea class="form-control text-editor-with-media" name="description_no" rows="5">{{old('description_no',$news->description_no)}}</textarea>
                            <small class="font-weight-bold text-danger">This field is required.</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="title">Image  <span class="font-weight-bold image-size" data-size="{{ $news->image_size() }}">{{ \App\Helpers\common::SupportedImagesFormat() }} ({{ $news->image_size() }})</span></label>
                            <div class="clearfix"></div>
                            @php
                                $src = $required_attr = $file_unique_name = '';
                                $file_name = 'image';
                                $required_attr = $news->id ? '' : 'required';
                                if($news && $news->id){
                                    $src = $news->image ? asset(\App\Helpers\common::getMediaPath($news->image)) : '';
                                    $file_unique_name = $news->image ? $news->image->name_unique : '';
                                }
                            @endphp
                            @include('admin.partials.upload-single-image')
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">{{$news->id ? 'Update' : 'Create'}} news</button>
        </form>
    </main>
@endsection
@section('script')
    <script src="{{ asset('public/admin/js/bootstrap-fileinput.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/pyzh8nk5zts8kmnwuypdooa95t19aknwf2lnw5xg1pr8sjqc/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    <script>

        tinymce.init({
            menubar: false, // remove menubar if you want to show the menubar
            statusbar: false,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table paste imagetools wordcount",
                "media"
            ],
            media_live_embeds: true,
            height : "400",
            selector: '.text-editor-with-media',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media",

            media_url_resolver: function (data, resolve/*, reject*/) {
                if (data.url.indexOf("https://rws.no/public/uploads") >= 0 ) {
                    var embedHtml = '<iframe src="' + data.url +
                        '" sandbox></iframe>';
                    resolve({html: embedHtml});
                } else {
                    resolve({html: ''});
                }
            },
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                if(meta.filetype == 'image'){
                    input.setAttribute('accept', 'image/*');
                }

                if(meta.filetype == 'media'){
                    input.setAttribute('accept', 'video/*');
                }

                /*
                  Note: In modern browsers input[type="file"] is functional without
                  even adding it to the DOM, but that might not be the case in some older
                  or quirky browsers like IE, so you might want to add it to the DOM
                  just in case, and visually hide it. And do not forget do remove it
                  once you do not need it anymore.
                */

                input.onchange = function () {
                    var file = this.files[0];

                    var reader = new FileReader();

                    // reader.onload = function () {
                    //     /*
                    //       Note: Now we need to register the blob in TinyMCEs image blob
                    //       registry. In the next release this part hopefully won't be
                    //       necessary, as we are looking to handle it internally.
                    //     */
                    //     var id = 'blobid' + (new Date()).getTime();
                    //     var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    //     var base64 = reader.result.split(',')[1];
                    //     var blobInfo = blobCache.create(id, file, base64);
                    //     blobCache.add(blobInfo);
                    //
                    //     /* call the callback and populate the Title field with the file name */
                    //     cb(blobInfo.blobUri(), { description: file.name });
                    // };

                    // FormData
                    var fd = new FormData();
                    var files = file;
                    fd.append('filetype',meta.filetype);
                    fd.append("file",files);

                    var filename = "";
                    var url = "{{route('admin.news-save-media')}}";

                    // AJAX
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', url);
                    var token = document.getElementById("csrf_token").value;
                    xhr.setRequestHeader("X-CSRF-Token", token);

                    xhr.onload = function() {
                        var json;
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }

                        filename = json.location;
                        reader.onload = function(e) {
                            cb(filename);
                        };
                        reader.readAsDataURL(file);

                        // success(json.location);
                        // filename = json.location;
                    };
                    xhr.send(fd);
                    return

                };

                input.click();
            }
        });


        $(document).ready(function () {
            $(document).on('click','.remove-single-image',function (e) {
                $('.single-image-input').prop('required','true');
            });
        });
    </script>
@endsection