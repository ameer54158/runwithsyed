@extends('layouts.backend-master')

@section('title', 'Users')
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
            <h4>Users</h4>
        </div>

        <div class="float-right">
            <a class="btn btn-primary" href="{{route('admin.edit-our-top-ambassadors')}}">Our top ambassadors</a>
            <a class="btn btn-brown" href="javascript:void(0);" data-toggle="modal" data-target="#createModal">Create user</a>
            <a style="background: #8a5917; color: white;" href="javascript:" class="btn mb-0" title="Advanced Search" data-toggle="collapse" data-target="#user_filter" aria-expanded="true"><i class="fa fa-search fa-lg"></i></a>
        </div>
        <div class="clearfix"></div>
        <form action="{{route('admin.users.index')}}" method="GET">
            <div id="user_filter" class="collapse <?php if(Request()->has('first_name')) echo 'show'; ?>">
                <div class="card clearfix mt-3">
                    <div class="card-header bg-dark text-white px-2 py-2">
                        <b>{{__('profile.advanced search')}}</b>
                        <a class="float-right" data-toggle="collapse" href="#user_filter" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body py-1">
                        <div class="form-body">
                            <div class="row mt-1">
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">First name</label>
                                    <input type="text" class="form-control form-control-sm" name="first_name" value="{{Request()->first_name}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">Last name</label>
                                    <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request()->last_name}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">Email</label>
                                    <input type="text" class="form-control form-control-sm" name="email" value="{{Request()->email}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">Mobile no</label>
                                    <input type="number" class="form-control form-control-sm" name="mobile_no" value="{{Request()->mobile_no}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="0">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">Role</label>
                                    <select class="form-control form-control-sm" name="role">
                                        <option value="">Select Role</option>
                                        @if($roles->count())
                                            @foreach($roles as $role)
                                                <option value="{{$role->slug}}" {{Request()->role == $role->slug ? 'selected' : ''}}>{{$role->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">Status</label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="">Select Status</option>
                                        <option value="1" {{Request()->status == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{is_numeric(Request()->status) && Request()->status == 0 ? 'selected' : ''}}>Deactivate</option>
                                    </select>
                                </div>
                            </div>
                        </div><!-- .form-body -->
                        <div class="clearfix"> </div>
                    </div>
                    <div class="card-footer py-1">
                        <div class="row text-right d-block">
                            <a href="{{route('admin.users.index')}}" class="btn btn-sm btn-dark mb-0" style="width: auto">Reset search result</a>
                            <button type="submit" class="btn btn-sm mb-0 btn-primary"> Search </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>
        <div class="clearfix my-3"></div>
        <table class="table table-striped table-hover" id="users_table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">First name</th>
                <th scope="col">Last name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Mobile no</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            @if($users->count())
                @foreach($users as $key=>$user)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$user->first_name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->roles->first()->name}}</td>
                        <td>{{$user->mobile_no}}</td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" data-ajaxurl="{{route('admin.change-status')}}" data-model_name="{{\App\Models\User::class}}" data-column_name="status" class="custom-control-input status" id="user_{{$user->id}}"  {{$user->status ? 'checked' : ''}} {{$user->id == Auth::id() ? 'disabled' : ''}}>
                                <label class="custom-control-label" for="user_{{$user->id}}"></label>
                            </div>
                        </td>
                        <td>
                        @if($user->roles->first()->slug !== 'admin')
                            @if($user->roles->first()->slug === 'sponsor')
                                <a href="{{ route('admin.sponsor.detail', $user->id) }}" target="_blank"><i class="fa fa-eye"></i></a>
                            @else
                                <a href="{{ route('admin.ambassador.detail', $user->id) }}" target="_blank"><i class="fa fa-eye"></i></a>
                            @endif  
                         @endif 
                            <a href="javascript:void(0);" class="delete-modal" data-toggle="modal" data-modal_size="modal-lg" data-target="#editModal" data-initiator="show-edit-modal" data-ajaxurl="{{route('admin.users.edit',$user->id)}}"><i class="fa fa-pen mr-2"></i></a>
                            <a href="#delModal" class="delete-modal {{$user->id == Auth::id() ? 'd-none' : ''}}" data-initiator="show-delete-modal" data-action="{{ route('admin.users.destroy', $user->id) }}" data-toggle="modal" data-target="#delModal" ><i class="far fa-trash-alt text-danger"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8"><p class="alert alert-danger text-center mb-0">Record not found.</p></td>
                </tr>
            @endif
            </tbody>
        </table>
    </main>

    <!-- Update Modal -->
    @include('admin.partials.update-modal')
    <!-- delete modal-->
    @include('admin.partials.delete-modal')

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create ambassador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.users.store')}}" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Role</label>
                                <select class="form-control" name="role_id">
                                    <option value="">Select role</option>
                                    @if($roles->count())
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" {{old('role_id') == $role->id ? 'selected' : ''}}>{{$role->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>First name</label>
                                <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Last name</label>
                                <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Mobile no</label>
                                <input type="number" class="form-control" name="mobile_no" value="{{old('mobile_no')}}" min="1" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" autocomplete="new-email" name="email" value="{{old('email')}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" autocomplete="new-password" name="password" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm">Create user</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/js/date-eu.js')}}"></script>
    <script src="{{asset('public/js/formatted-numbers.js')}}"></script>
    <script>
        $(document).ready(function () {
            @if($users->count())
            jquery_data_tables_languages($('#users_table'));
            @endif
        });
    </script>
@endsection