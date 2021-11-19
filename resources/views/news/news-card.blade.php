<div class="col-lg-4 col-md-6 col-sm-12 col-12">
    <a class="text-dark" href="{{localized_route('single-news',(app()->getLocale() == 'nb' ? $news_obj->slug_no : $news_obj->slug_en))}}">
    <img src="{{$news_obj->image ? asset(\App\Helpers\common::getMediaPath($news_obj->image,$news_obj->image_size())) : asset('public/images/no-news.jpg')}}" style="width: 100%; height: 220px;">
    <div class="single-news">
        @php
            $string_limit = 160;
            if(\Request::route()->getName() == 'home'){
                $string_limit = 170;
            }
        @endphp
        <p class="title mb-0" title="{{app()->getLocale() == 'nb' ? $news_obj->title_no : $news_obj->title_en}}">{{app()->getLocale() == 'nb' ? Str::limit($news_obj->title_no,30) : Str::limit($news_obj->title_en,30)}}</p>
        <p class="date mb-0">{{app()->getLocale() == 'nb' ? \App\Helpers\common::data_in_norwegian($news_obj->created_at) : $news_obj->created_at->format('M d, Y')}}</p>
        <div class="description" style="height: 80px">
            {!! (app()->getLocale() == 'nb' ? Str::limit(App\Helpers\common::remove_media_tag_from_string($news_obj->description_no,''),$string_limit) : Str::limit(App\Helpers\common::remove_media_tag_from_string($news_obj->description_en,''),$string_limit)) !!}
        </div>
        <a href="{{localized_route('single-news',(app()->getLocale() == 'nb' ? $news_obj->slug_no : $news_obj->slug_en))}}" class="btn w-auto">{{__('general.read more')}}</a>
    </div>
</a>
</div>

