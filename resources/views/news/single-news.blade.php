@extends('layouts.frontend-master')

@section('title',(__('header.news')) )

@section('page-content')
    <!-- Page Content  -->
    <main class="content single-news-page">
        <div class="container">
            <div class="row single-news-detail">
                <div class="col-lg-4 col-sm-6 col-12">
                    <img src="{{$single_news->image ? asset(\App\Helpers\common::getMediaPath($single_news->image,$single_news->image_size())) : asset('public/images/ambassador.jpg')}}" style="width: 100%; height: 220px;">
                </div>
                <div class="col-lg-8 col-sm-6 col-12 d-flex align-content-center flex-wrap">
                    <div>
                        <p class="title mb-0 pt-0">{{app()->getLocale() == 'nb' ? $single_news->title_no : $single_news->title_en}}</p>
                        <p class="date mb-0">
                            {{app()->getLocale() == 'nb' ? \App\Helpers\common::data_in_norwegian($single_news->created_at) : $single_news->created_at->format('M d, Y')}}
                        </p>
                    </div>
                </div>
                <div class="col-12 pt-4">
                    {!! (app()->getLocale() == 'nb' ? $single_news->description_no : $single_news->description_en) !!}
                </div>
            </div>

            @if($news->count())
                <div class="row related-news-section">
                    <div class="col-12">
                        <h5 style="font-weight: 600;border-bottom: 2px solid #d6d6d6;padding-bottom: 13px;">Se flere nyheter</h5>
                    </div>
                    @foreach($news as $news_obj)
                        @include('news.news-card',compact('news_obj'))
                    @endforeach

                </div>
            @endif

        </div>
    </main>
@endsection