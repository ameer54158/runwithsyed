@extends('layouts.frontend-master')

@section('title',(__('header.contact')) )

@section('style')
    <style>
        .head #errors {
            font-size: 1rem;
            font-weight: 400;
        }
        .contact-page .btn:focus{
            box-shadow: none;
        }
    </style>
@endsection
@section('page-content')
    <!-- Page Content  -->
    <main class="content contact-page">
        <div class="container">
            <div class="row boxer">
                <div class="col-lg-4 col-md-6 col-sm-12 br-right">
                    <h3 class="head">RunWithSyed</h3>
                    @if(App\Helpers\common::site_setting('contact_us_phone'))
                        <a href="tel:{{ App\Helpers\common::site_setting('contact_us_phone') }}">
                            <div class="contact-detail">
                                <span><i class="fas fa-phone fa-lg icon"></i></span>
                                <span class="link">{{ App\Helpers\common::site_setting('contact_us_phone') }}</span>
                            </div>
                        </a>
                    @endif
                    @if(App\Helpers\common::site_setting('contact_us_email'))
                        <div class="contact-detail">
                            <a href="mailto:{{ App\Helpers\common::site_setting('contact_us_email') }}">
                                <span><i class="fas fa-envelope fa-lg icon"></i></span>
                                <span class="link">{{ App\Helpers\common::site_setting('contact_us_email') }}</span>
                            </a>
                        </div>
                    @endif
                    @if(App\Helpers\common::site_setting('contact_us_website'))
                        <a href="{{url('/')}}">
                            <div class="contact-detail">
                                <span><i class="fas fa-globe fa-lg icon"></i></span>
                                <span class="link">{{ App\Helpers\common::site_setting('contact_us_website') }}</span>
                            </div>
                        </a>
                    @endif
                    @if(App\Helpers\common::site_setting('organization_no'))
                        <a href="{{url('/')}}">
                            <div class="contact-detail">
                                <span><i class="fas fa-university fa-lg icon"></i></span>
                                <span class="link"><span style="color: black">Org.nr.</span> {{ App\Helpers\common::site_setting('organization_no') }}</span>
                            </div>
                        </a>
                    @endif
                    @if(App\Helpers\common::site_setting('contact_us_description_en'))
                        <div class="contact-detail">
                            <span><i class="fas fa-info-circle icon"></i></span>
                            <span class="link">{{ App\Helpers\common::site_setting('contact_us_description_en') }}</span>
                        </div>
                    @endif
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="m-auto">
                        <div class="head">
                            @include('contact-us-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </br>
        <div class="row">
            <iframe src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Vipeveien%2015,%201384%20ASKER+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            {{--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2003.4590889690282!2d10.468283515954376!3d59.85812287555338!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46411458cee280db%3A0xa4656cd21aba4b2c!2sKirkeveien%2015%2C%201395%20Hvalstad%2C%20Norway!5e0!3m2!1sen!2s!4v1615447466861!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>--}}
        </div>
    </main>
@endsection