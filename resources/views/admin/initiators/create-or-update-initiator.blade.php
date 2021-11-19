@extends('layouts.backend-master')

@section('title', ($initiator->id ? 'Edit' : 'Add').' initiator')

@section('style')
    <link href="{{ asset('public/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@endsection

@section('page-content')
    <!-- Page Content  -->
    <main class="content">
        @include('flash::message')
        @include('errors')
        <div class="clearfix"></div>
        <h4>{{$initiator->id ? 'Edit' : 'Add'}} initiator </h4>
        <hr>
        <form method="POST" action="@if($initiator->id) {{route('admin.initiators.update',$initiator->id)}} @else {{route('admin.initiators.store')}} @endif" enctype="multipart/form-data">
            @csrf @if($initiator->id) @method('PUT') @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name',$initiator->name)}}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Description (In english) <small class="font-weight-bold">(field is required)</small></label>
                            <textarea class="text-editor" name="description_en">{{old('description_en',$initiator->description_en)}}</textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Description (In norwegian)<small class="font-weight-bold">(field is required)</small></label>
                            <textarea class="text-editor" name="description_no">{{old('description_no',$initiator->description_no)}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="title">Image  <span class="font-weight-bold image-size" data-size="{{ $initiator->image_size() }}">{{ \App\Helpers\common::SupportedImagesFormat() }} ({{ $initiator->image_size() }})</span></label>
                            <div class="clearfix"></div>
                            @php
                                $src = $required_attr = $file_unique_name = '';
                                $file_name = 'image';
                                if($initiator && $initiator->id){
                                    $src = $initiator->image ? asset(\App\Helpers\common::getMediaPath($initiator->image)) : '';
                                    $file_unique_name = $initiator->image ? $initiator->image->name_unique : '';
                                }
                            @endphp
                            @include('admin.partials.upload-single-image')
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{$initiator->id ? 'Update' : 'Add'}} initiator</button>
        </form>
    </main>
@endsection

@section('script')
    <script src="{{ asset('public/admin/js/bootstrap-fileinput.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/pyzh8nk5zts8kmnwuypdooa95t19aknwf2lnw5xg1pr8sjqc/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection