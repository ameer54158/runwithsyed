@extends('layouts.frontend-master')

@section('title',(__('header.home')) )

@section('style')
    <style>
        .header-container{
            margin-bottom: 0 !important;
            border-bottom: none;
        }
    </style>
@endsection

@section('page-content')
    <!-- Page Content  -->
    <main class="content home-page">
        {{--<div class="container">--}}
            {{--@include('flash::message')--}}
        {{--</div>--}}

        <section class="first-section">
            <div class="top-banner">
                <img src="{{asset('public/images/slider-img.png')}}" alt="Snow">
                <div class="container">
                    <div class="top-left">
                        <div class="row">
                            <div class="col-md-12 col-lg-9 col-sm-12">
                             @if(App\Helpers\common::site_setting('home_banner_section_title_en') || App\Helpers\common::site_setting('home_banner_section_title_no'))
                                <p class="banner-title">{{app()->getLocale() == 'nb' ? Str::limit(App\Helpers\common::site_setting('home_banner_section_title_no'),36) : Str::limit(App\Helpers\common::site_setting('home_banner_section_title_en'),36)}}</p>
                                @endif
                                @if(App\Helpers\common::site_setting('banner_section_description_en') || App\Helpers\common::site_setting('banner_section_description_no'))
                                <p class="banner-description">{{app()->getLocale() == 'nb' ? Str::limit(App\Helpers\common::site_setting('banner_section_description_no'),200) : Str::limit(App\Helpers\common::site_setting('banner_section_description_en'),200)}}</p>
                                @endif
                                <a class="btn register-button" href="{{localized_route('about-us')}}">{{__('general.read more')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="centered col-12">
                    <section class="user-section container">
                        <div class="row">
                            @include('user-section-cards')
                        </div>
                    </section>
                </div>
            </div>
        </section>
        @if($news->count())
            <section class="bg-news-section bg-white">
                <div style='background-image: url("{{asset('public/images/gray-bg-paint.png')}}"); background-size: 100% 100%;'>
                    <div class="news-section container">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="heading-title">{{__('general.latest news')}}</h3>
                            </div>

                            @foreach($news as $news_obj)
                                @include('news.news-card',compact('news_obj'))
                            @endforeach

                            <div class="col-12 text-center mt-3">
                                <a class="btn see-more-news-button" href="{{localized_route('list-news')}}">{{__('general.see more news')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="container facebook-contact-us-section">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="contact-us">
                        <h3 class="heading">{{__('general.contact us')}}</h3>
                        @include('contact-us-form')
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    @if(count($feed))
                        <div class="instagram-feed-section">
                            <div class="row">
                                @include('instagram-feed-inner')
                            </div>
                            @if(count($all_feeds) > 12)
                                <div class="row">
                                    <a class="btn btn-primary btn-sm text-white show_more_feed_button col-sm-6 col-md-3 m-auto" data-value="0"> {{__('general.load more')}}</a>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </section>

    </main>


    <!-- Ambassador registration modal -->
    @include('register-ambassador-user-modal')

    <!-- Sponsor registration modal -->
    @include('register-sponsor-user-modal')

    <!-- Donation modal -->
    @include('donation-modal')

        <!-- Donation Success model -->
    @include('donation-success-model')

@endsection

@section('script')
@if(Session::has('donation-model'))
<script>
$(document).ready(function(){
    $(".donation-model-trigger").trigger("click");
});
</script>
@endif
<script>
    $(document).ready(function () {
        $(document).on('mouseenter', '.img-section', function(e) {
           $(this).closest('.col-lg-4.col-md-6.col-6.container-section').find('.centered').css('display','block');
        });
        $(document).on('mouseleave', '.container-section', function(e) {
            $(this).closest('.col-lg-4.col-md-6.col-6.container-section').find('.centered').css('display','none');
        });

        //Change the status
        $(document).on('click', '.show_more_feed_button', function(e) {
            var action = '{{route('admin.show-more-instagram-feed')}}';
            var page = $('.show_more_feed_button').data('value');
            var new_value = ++page;
            $('.show_more_feed_button').data('value', new_value);
            if(action){
                $.ajax({
                    url: action,
                    type:'GET',
                    data: {'page_value':page},
                    dataType:'json',
                    success: function (data) {
                        if(data.data){
                            $('.instagram-feed-section .row').append(data.data);
                        }
                        if(!data.more_feed_available_flag){
                            $('.show_more_feed_button').remove();
                        }
                    }
                });
            }

        });
    });
</script>
@endsection
