
<div class="row">
    @if(isset($our_top_ambassadors) && $our_top_ambassadors->count())
        @foreach($our_top_ambassadors as $our_top_ambassador)

            <div class="col-lg-4 col-md-6 col-12">
                <div class="ambassador-card card">
                    @if($our_top_ambassador->image && $our_top_ambassador->detail && $our_top_ambassador->detail->profile_image_permission)
                        <img src="{{asset(\App\Helpers\common::getMediaPath($our_top_ambassador->image,$our_top_ambassador->image_size()))}}">
                    @else
                        <img class="no-image" src="{{asset('public/images/user-avatar-1.png')}}">
                    @endif
                    <h6 class="name">
                        {{$our_top_ambassador->first_name ? $our_top_ambassador->first_name : ''}} {{$our_top_ambassador->last_name ? $our_top_ambassador->last_name : ''}}
                        {{!$our_top_ambassador->first_name && !$our_top_ambassador->last_name ? 'N/A' : ''}}
                    </h6>
                    <div class="description">
                        <p class="description-text">
                            {{$our_top_ambassador->detail && $our_top_ambassador->detail->description ? Str::limit($our_top_ambassador->detail->description,160) : ''}}
                        </p>
                        <p>{{__('general.since member ran')}}: <span class="total-runs">{{$our_top_ambassador->runs->sum('distance')}}km</span></p>
                        <p class="mb-0" style="font-size: 14px; color: #717171">{{__('general.since member date')}}: {{$our_top_ambassador->created_at->format('d/m/Y')}}</p>
                    </div>

                    @if(Auth::user() && Auth::user()->ambassadors->count() && Auth::user()->ambassadors && Auth::user()->ambassadors->where('ambassador_user_id',$our_top_ambassador->id)->first() && Auth::user()->ambassadors->where('ambassador_user_id',$our_top_ambassador->id)->first()->status)
                        <a href="{{route('remove-sponsorship',$our_top_ambassador->id)}}" class="btn become-sponsor-btn">{{__('general.remove sponsorship')}}</a>
                    @else
                        <a href="{{route('become-sponsor',$our_top_ambassador->id)}}" class="btn become-sponsor-btn">{{ucfirst(strtolower(__('general.become sponsor')))}}</a>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    @if($ambassadors->count())
        @foreach($ambassadors as $ambassador)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="ambassador-card card">
                    @if($ambassador->image && $ambassador->detail && $ambassador->detail->profile_image_permission)
                        <img src="{{asset(\App\Helpers\common::getMediaPath($ambassador->image,$ambassador->image_size()))}}">
                    @else
                        <img class="no-image" src="{{asset('public/images/user-avatar-1.png')}}">
                    @endif
                    <h6 class="name">
                        {{$ambassador->first_name ? $ambassador->first_name : ''}} {{$ambassador->last_name ? $ambassador->last_name : ''}}
                        {{!$ambassador->first_name && !$ambassador->last_name ? 'N/A' : ''}}
                    </h6>
                    <div class="description">
                        <p class="description-text">
                            {{$ambassador->detail && $ambassador->detail->description ? Str::limit($ambassador->detail->description,160) : ''}}
                        </p>
                        <p>{{__('general.since member ran')}}: <span class="total-runs">{{$ambassador->runs->sum('distance')}}km</span></p>
                        <p class="mb-0" style="font-size: 14px; color: #717171">{{__('general.since member date')}}: {{$ambassador->created_at->format('d/m/Y')}}</p>
                    </div>

                    @if(Auth::user() && Auth::user()->ambassadors->count() && Auth::user()->ambassadors && Auth::user()->ambassadors->where('ambassador_user_id',$ambassador->id)->first() && Auth::user()->ambassadors->where('ambassador_user_id',$ambassador->id)->first()->status)
                        <a href="{{route('remove-sponsorship',$ambassador->id)}}" class="btn become-sponsor-btn">{{__('general.remove sponsorship')}}</a>
                    @else
                        <a href="{{route('become-sponsor',$ambassador->id)}}" class="btn become-sponsor-btn">{{ucfirst(strtolower(__('general.become sponsor')))}}</a>
                    @endif
                </div>
            </div>
        @endforeach

        <input type="hidden" class="pagination_input" value="{{\Request::get('pagination') ? \Request::get('pagination') : 1}}">
        @if($total > ((\Request::get('pagination') ? \Request::get('pagination') : 1)*15))
            <div class="col-12 text-center mt-5 mb-3 show_more_products">
                <button class="btn show-more-button" value="{{\Request::get('pagination') ? \Request::get('pagination') : 1}}">
                    {{__('general.load more')}}
                </button>
            </div>
        @endif
    @else
        <p class="alert alert-danger text-center" style="width: 95%; margin: 20px auto;">{{__('general.no any record found')}}</p>
    @endif

    <input class="search_ajax_data" type="hidden" value="{{Request::get('search')}}"/>
</div>
