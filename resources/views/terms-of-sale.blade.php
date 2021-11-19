@extends('layouts.frontend-master')

@section('title', (__('general.terms of sale')))

@section('page-content')
    <!-- Page Content  -->
    <main class="content privacy-page">
    <div class="container">
     @if(App\Helpers\common::site_setting('sales_terms_title_en') || App\Helpers\common::site_setting('sales_terms_title_no'))
    <h2 class="text-center">{{app()->getLocale() == 'nb' ? App\Helpers\common::site_setting('sales_terms_title_no') : App\Helpers\common::site_setting('sales_terms_title_en')}}</h2>
    @endif
     @if(App\Helpers\common::site_setting('sales_terms_description_en') || App\Helpers\common::site_setting('sales_terms_description_no'))
        <p>{!! app()->getLocale() == 'nb' ? App\Helpers\common::site_setting('sales_terms_description_no') : App\Helpers\common::site_setting('sales_terms_description_en') !!}</p>
        @endif
    </div>
    </main>
@endsection