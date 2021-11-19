@extends('profile.profile-master')

@section('title',__('profile.my sponsor'))

@section('profile-content')

    <div class="padder">
        @if($user_sponsors->count() || count(\Request::all()))
            <div class="float-right">
                <a style="background: #ffffff;color: white;width: 60px;padding: 1px 0px;" href="javascript:" class="btn mb-0" title="{{__('profile.advanced search')}}" data-toggle="collapse" data-target="#my_sponsors_filters" aria-expanded="true"><i class="fa fa-search"></i></a>
            </div>
        @endif

        <div class="clearfix"></div>
        <form action="{{localized_route('my-sponsors')}}" method="GET">
            <div id="my_sponsors_filters" class="collapse {{\Request::has('first_name') ? 'show' : ''}}">
                <div class="card clearfix mt-3">
                    <div class="card-header bg-dark text-white px-2 py-2">
                        <b>{{__('profile.advanced search')}}</b>
                        <a class="float-right" data-toggle="collapse" href="#my_sponsors_filters" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body py-1">
                        <div class="form-body">
                            <div class="row mt-1">
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.fname')}}</label>
                                    <input type="text" class="form-control form-control-sm" name="first_name" value="{{Request()->first_name}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.lname')}}</label>
                                    <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request()->last_name}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.email')}}</label>
                                    <input type="text" class="form-control form-control-sm" name="email" value="{{Request()->email}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.date start')}}</label>
                                    <input type="date" class="form-control form-control-sm" name="date_start" value="{{Request()->date_start}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.date end')}}</label>
                                    <input type="date" class="form-control form-control-sm" name="date_end" value="{{Request()->date_end}}">
                                </div>
                                <div class="col-md-4 my-1 px-1">
                                    <label class="form-label mb-0">{{__('profile.status')}}</label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="">{{__('profile.select status')}}</option>
                                        <option value="1" {{Request()->status && Request()->status == '1' ? 'selected' : ''}}>{{__('profile.active')}}</option>
                                        <option value="0" {{Request()->status && Request()->status == '0' ? 'selected' : ''}}>{{__('profile.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div><!-- .form-body -->
                        <div class="clearfix"> </div>
                    </div>
                    <div class="card-footer py-1">
                        <div class="row text-right d-block">
                            <a href="{{localized_route('my-sponsors')}}" class="btn btn-sm btn-default mb-0" style="width: auto">{{__('profile.reset search result')}}</a>
                            <button type="submit" class="btn btn-sm mb-0"> {{__('profile.search')}}  </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>

        <div class="table-responsive">
            <table class="table mt-3 table-striped table-hover table-sm" id="my_sponsor_table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('profile.image')}}</th>
                    <th scope="col">{{__('profile.name')}}</th>
                    <th scope="col">{{__('profile.e-mail')}}</th>
                    <th scope="col">{{__('profile.status')}}</th>
                    <th scope="col">{{__('general.date')}}</th>
                    {{--<th scope="col">{{__('general.action')}}</th>--}}
                </tr>
                </thead>
                <tbody>

                @if($user_sponsors->count())
                    @foreach($user_sponsors as $sponsor_key=>$sponsor)
                        <tr class="text-center">
                            <th scope="row">{{$sponsor_key+1}}</th>
                            <td>
                                @if($sponsor->sponsor_user && $sponsor->sponsor_user->detail && $sponsor->sponsor_user->detail->profile_image_permission && $sponsor->sponsor_user->image)
                                    <img style="width: 60px; height: 60px; border-radius: 100px" src="{{asset(\App\Helpers\common::getMediaPath($sponsor->sponsor_user->image,'66x66'))}}">
                                @else
                                    <img style="width: 60px; height: 60px; border-radius: 100px" src="{{asset('public/images/user-avatar-1.png')}}">
                                @endif
                            </td>
                            <td>
                                {{$sponsor->sponsor_user && $sponsor->sponsor_user->first_name ? $sponsor->sponsor_user->first_name : ''}}
                                {{$sponsor->sponsor_user && $sponsor->sponsor_user->last_name ? $sponsor->sponsor_user->last_name : ''}}
                            </td>
                            <td>{{$sponsor->sponsor_user ? $sponsor->sponsor_user->email : ''}}</td>
                            <td><span class="{{$sponsor->status ? 'active' : 'deactivate'}}">{{ __('profile.'.($sponsor->status ? 'active' : 'deactivate'))}}</span></td>
                            <td>{{$sponsor->created_at->format('M d, Y')}}</td>
                            {{--<td></td>--}}
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7"><p class="alert alert-danger text-center mb-0">{{__('general.no any record found')}}</p></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <div class="pagination w-100">
            {{ $user_sponsors->appends(request()->query())->links() }}
        </div>
    </div>

@endsection