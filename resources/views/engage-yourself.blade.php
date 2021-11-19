@extends('layouts.frontend-master')

@section('title',(__('header.engage-yourself')) )

@section('page-content')
    <!-- Page Content  -->
    <main class="content engage-yourself-page">
        <div class="container">
            <section class="user-section">
                <div class="row">
                    @include('user-section-cards')
                </div>
            </section>
            <div class="row">
                <div class="m-auto col-md-10 col-lg-8 col-sm-12 col-12">
                    <div class="contact-us">
                        <h3 class="heading">KONTAKT OSS</h3>
                        @include('contact-us-form')
                    </div>
                </div>
            </div>
        </div>
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
jQuery(document).ready(function(){
    jQuery(".donation-model-trigger").trigger("click");
});
</script>
@endif
@endsection