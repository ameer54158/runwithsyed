@extends('layouts.frontend-master')

@section('title', __('header.about-us'))

@section('page-content')
    <!-- Page Content  -->
    <main class="content about-us-page">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h5 style="line-height: 25px">
                   {{app()->getLocale() == 'nb' ? $setting->get_value('about_us_description_no') : $setting->get_value('about_us_description_en')}}
                    </h5>
                </div>

                @if($setting->get_value('vision_and_goal_title_no') || $setting->get_value('vision_and_goal_title_en') || $setting->get_value('vision_and_goal_description_no') || $setting->get_value('vision_and_goal_description_en'))
                    <div class="col-lg-6 col-12 mt-4">
                        <div class="vision-and-goals">
                            @if($setting->get_value('vision_and_goal_title_no') || $setting->get_value('vision_and_goal_title_en'))
                                <p class="title"> {{app()->getLocale() == 'nb' ? $setting->get_value('vision_and_goal_title_no') : $setting->get_value('vision_and_goal_title_en')}}</p>
                            @endif

                            @if($setting->get_value('vision_and_goal_description_no') || $setting->get_value('vision_and_goal_description_en'))
                                <p class="description" style="white-space: pre-line">
                                    {{app()->getLocale() == 'nb' ? $setting->get_value('vision_and_goal_description_no') : $setting->get_value('vision_and_goal_description_en')}}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($setting->get_value('how_we_help_title_no') || $setting->get_value('how_we_help_title_en') || $setting->get_value('how_we_help_description_no') || $setting->get_value('how_we_help_description_en'))
                    <div class="col-lg-6 col-12 mt-4">
                        <div class="how-we-help">
                            @if($setting->get_value('how_we_help_title_no') || $setting->get_value('how_we_help_title_en'))
                                <p class="title"> {{app()->getLocale() == 'nb' ? $setting->get_value('how_we_help_title_no') : $setting->get_value('how_we_help_title_en')}}</p>
                            @endif
                            @if($setting->get_value('how_we_help_description_no') || $setting->get_value('how_we_help_description_en'))
                                <p class="description" style="white-space: pre-line">
                                    {{app()->getLocale() == 'nb' ? $setting->get_value('how_we_help_description_no') : $setting->get_value('how_we_help_description_en')}}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                 @php
                     $setting_obj = \App\Models\Setting::where('key','about_us_image')->where('value','exist')->first();
                 @endphp
                @if(($setting_obj && $setting_obj->about_us_image) || $setting->get_value('about_us_last_description_no') || $setting->get_value('about_us_last_description_en'))
                    <div class="col-12 last-section">
                        <div class="row mx-0 mt-4">
                            @if($setting->get_value('about_us_last_description_no') || $setting->get_value('about_us_last_description_en'))
                                <div class="col-lg-6 col-12">
                                    <p class="title">  {{app()->getLocale() == 'nb' ? $setting->get_value('about_us_last_title_no') : $setting->get_value('about_us_last_title_en')}}</p>
                                    <p class="description" style="white-space: pre-line">
                                        {{app()->getLocale() == 'nb' ? $setting->get_value('about_us_last_description_no') : $setting->get_value('about_us_last_description_en')}}
                                    </p>
                                </div>
                            @endif

                            @if($setting_obj && $setting_obj->about_us_image)
                                <div class="col-lg-6 img-section">
                                    <img src="{{$setting_obj->about_us_image ? asset(\App\Helpers\common::getMediaPath($setting_obj->about_us_image,$setting_obj->about_us_image_size())) : asset('public/images/ambassador.jpg')}}">
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </main>
@endsection