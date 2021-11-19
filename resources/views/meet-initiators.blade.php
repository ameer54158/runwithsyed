@extends('layouts.frontend-master')

@section('title',(__('header.meet-initiators')) )

@section('page-content')
    <!-- Page Content  -->
    <main class="content meet-initiators-page">
        <div class="container">
            <div class="row">
                @if($initiators->count())
                    @foreach($initiators as $key=>$initiator)
                        <div class="col-12">
                            <div class="media w-100 row">
                                @if((($key+1)%2) != 0)
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-12 order-1 order-sm-1 text-center">
                                        <img src="{{$initiator->image ? asset(\App\Helpers\common::getMediaPath($initiator->image,$initiator->image_size())) : asset('public/images/user-avatar-1.png')}}" alt="Generic placeholder image">
                                    </div>
                                @endif
                                <div class="media-body col-lg-10 col-md-9 col-sm-8 col-12 order-2">
                                    <h5 class="mt-0 name">{{$initiator->name}}</h5>
                                    @if(app()->getLocale() == 'nb')
                                        {!! $initiator->description_no !!}
                                    @elseif(app()->getLocale() == 'en')
                                        {!! $initiator->description_en !!}
                                    @endif
                                </div>
                                @if((($key+1)%2) == 0)
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-12 text-center order-1 order-sm-2">
                                        <img src="{{$initiator->image ? asset(\App\Helpers\common::getMediaPath($initiator->image,$initiator->image_size())) : asset('public/images/user-avatar-1.png')}}" alt="Generic placeholder image">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>
@endsection