@extends('layouts.backend-master')

@section('title', 'Contact us')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
        #contact_us_table{
            margin-top: 0!important;
        }
        .modal-body label.label{
            font-weight: 500;
            font-size: 14px;
        }
        .modal-body label.value{
            font-size: 17px;
        }
    </style>
@endsection
@section('page-content')
    <!-- Page Content  -->
    <main class="content">
        <div class="float-left">
            <h4>Contact us</h4>
        </div>
        <div class="float-right">
            <a style="background: #8a5917; color: white;" href="javascript:" class="btn mb-0" title="Advanced Search" data-toggle="collapse" data-target="#user_filter" aria-expanded="true"><i class="fa fa-search fa-lg"></i></a>
        </div>
        <div class="clearfix"></div>
        <form action="{{route('admin.contact-us.index')}}" method="GET">
            <div id="user_filter" class="collapse <?php if(Request()->has('first_name')) echo 'show'; ?>">
                <div class="card clearfix">
                    <div class="card-header bg-dark text-white px-2 py-2">
                        <b>Advanced search</b>
                        <a class="float-right" data-toggle="collapse" href="#user_filter" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body py-1">
                        <div class="form-body">
                            <div class="row mt-1">
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">First name</label>
                                    <input type="text" class="form-control form-control-sm" name="first_name" value="{{Request()->first_name}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Last name</label>
                                    <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request()->last_name}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Email</label>
                                    <input type="text" class="form-control form-control-sm" name="email" value="{{Request()->email}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Telephone no</label>
                                    <input type="number" class="form-control form-control-sm" name="telephone" value="{{Request()->telephone}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="1">
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
                            <a href="{{route('admin.contact-us.index')}}" class="btn btn-sm btn-dark mb-0" style="width: auto">Reset search result</a>
                            <button type="submit" class="btn btn-sm mb-0 btn-primary"> Search </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>
        <div class="clearfix my-3"></div>
        @include('flash::message')

        <table class="table table-striped table-hover w-100" id="contact_us_table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Subject</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Telephone</th>
                <th scope="col">Date</th>
                <th scope="col">Message</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            @if($contact_us->count())
                @foreach($contact_us as $key=>$contact_us_obj)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$contact_us_obj->subject}}</td>
                        <td>{{$contact_us_obj->first_name}}</td>
                        <td>{{$contact_us_obj->last_name}}</td>
                        <td>{{$contact_us_obj->email}}</td>
                        <td>{{$contact_us_obj->telephone}}</td>
                        <td>{{$contact_us_obj->created_at ? $contact_us_obj->created_at->format('M d, Y') : ''}}</td>
                        <td title="{{$contact_us_obj->message}}">{{Str::limit($contact_us_obj->message,30)}}</td>
                        <td>
                            <a href="javascript:void(0);" data-modal_title="Contact us detail" class="delete-modal" data-toggle="modal" data-modal_size="modal-lg" data-target="#editModal" data-initiator="show-edit-modal" data-ajaxurl="{{route('admin.contact-us.show',$contact_us_obj->id)}}"><i class="fa fa-eye mr-2"></i></a>
                            <a href="#delModal" class="delete-modal" data-initiator="show-delete-modal" data-action="{{ route('admin.contact-us.destroy', $contact_us_obj->id) }}" data-toggle="modal" data-target="#delModal" ><i class="far fa-trash-alt text-danger"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9"><p class="alert alert-danger text-center mb-0">No any record found</p></td>
                </tr>
            @endif
            </tbody>
        </table>
    </main>

    @include('admin.partials.delete-modal')
    <!-- Update Modal -->
    @include('admin.partials.update-modal')
@endSection

@section('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/js/date-eu.js')}}"></script>
    <script>
        $(document).ready( function () {
            var columnDefs_type = ['date-eu'];
            var columnDefs_target = [5];
            @if($contact_us->count())
                jquery_data_tables_languages($('#contact_us_table'),columnDefs_type,columnDefs_target);
            @endif
        });
    </script>
@endsection