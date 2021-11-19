@extends('layouts.backend-master')

@section('title', 'News')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endsection
@section('page-content')
    <!-- Page Content  -->
    <main class="content">
        @include('flash::message')
        @include('errors')
        <div class="clearfix mb-1"></div>
        <div class="float-left">
            <h4>News</h4>
        </div>

        <div class="float-right">
            <a class="btn btn-brown" href="{{route('admin.news.create')}}">Create news</a>
            <a style="background: #8a5917; color: white;" href="javascript:" class="btn mb-0" title="Advanced Search" data-toggle="collapse" data-target="#news_filter" aria-expanded="true"><i class="fa fa-search fa-lg"></i></a>
        </div>
        <div class="clearfix"></div>
        <form action="{{route('admin.news.index')}}" method="GET">
            <div id="news_filter" class="collapse <?php if(Request()->has('title_en')) echo 'show'; ?>">
                <div class="card clearfix">
                    <div class="card-header bg-dark text-white px-2 py-2">
                        <b>Advanced search</b>
                        <a class="float-right" data-toggle="collapse" href="#news_filter" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body py-1">
                        <div class="form-body">
                            <div class="row mt-1">
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Title (en)</label>
                                    <input type="text" class="form-control form-control-sm" name="title_en" value="{{Request()->title_en}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Title (no)</label>
                                    <input type="text" class="form-control form-control-sm" name="title_no" value="{{Request()->title_no}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Description (en)</label>
                                    <input type="text" class="form-control form-control-sm" name="description_en" value="{{Request()->description_en}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Description (no)</label>
                                    <input type="text" class="form-control form-control-sm" name="description_no" value="{{Request()->description_no}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Date start</label>
                                    <input type="date" class="form-control form-control-sm" name="date_start" value="{{Request()->date_start}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Date end</label>
                                    <input type="date" class="form-control form-control-sm" name="date_end" value="{{Request()->date_end}}">
                                </div>
                            </div>
                        </div><!-- .form-body -->
                        <div class="clearfix"> </div>
                    </div>
                    <div class="card-footer py-1">
                        <div class="row text-right d-block">
                            <a href="{{route('admin.news.index')}}" class="btn btn-sm btn-dark mb-0" style="width: auto">Reset search result</a>
                            <button type="submit" class="btn btn-sm mb-0 btn-primary"> Search </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>
        <div class="clearfix my-3"></div>
        <table class="table table-striped table-hover" id="news_table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Title (en)</th>
                <th scope="col">Title (no)</th>
                <th scope="col">Description (en)</th>
                <th scope="col">Description (no)</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @if($news->count())
                @foreach($news as $key=>$news_obj)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td><img src="{{$news_obj->image ? asset(\App\Helpers\common::getMediaPath($news_obj->image,'66x66')) : ''}}"></td>
                        <td>{{Str::limit($news_obj->title_en,30)}}</td>
                        <td>{{Str::limit($news_obj->title_no,30)}}</td>
                        <td>{!! Str::limit(\App\Helpers\common::remove_media_tag_from_string($news_obj->description_en,''),30) !!}</td>
                        <td>{!!Str::limit(\App\Helpers\common::remove_media_tag_from_string($news_obj->description_no,''),30) !!}</td>
                        <td>{{$news_obj->created_at->format('M d, Y')}}</td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" data-ajaxurl="{{route('admin.change-status')}}" data-model_name="{{\App\Models\News::class}}" data-column_name="status" class="custom-control-input status" id="news_{{$news_obj->id}}"  {{$news_obj->status ? 'checked' : ''}}>
                                <label class="custom-control-label" for="news_{{$news_obj->id}}"></label>
                            </div>
                        </td>
                        <td>
                            <a href="{{route('admin.news.edit',$news_obj->id)}}"><i class="fa fa-pen mr-2"></i></a>
                            <a href="#delModal" class="delete-modal" data-initiator="show-delete-modal" data-action="{{ route('admin.news.destroy', $news_obj->id) }}" data-toggle="modal" data-target="#delModal" ><i class="far fa-trash-alt text-danger"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9"><p class="alert alert-danger text-center mb-0">Record not found.</p></td>
                </tr>
            @endif

            </tbody>
        </table>
    </main>

    <!-- delete modal-->
    @include('admin.partials.delete-modal')

@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/js/date-eu.js')}}"></script>
    <script>
        $(document).ready(function () {
            var columnDefs_type = ['date-eu'];
            var columnDefs_target = [6];
            @if($news->count())
            jquery_data_tables_languages($('#news_table'),columnDefs_type,columnDefs_target);
            @endif
        });

    </script>
@endsection