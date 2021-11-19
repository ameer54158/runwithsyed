<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @if($_SERVER['SERVER_NAME'] != 'localhost')
        <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PBTXPK3');</script>
<!-- End Google Tag Manager -->
    @endif

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Hjem') | {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{asset('public/images/rws-favicon.png')}}">

    @if($_SERVER['SERVER_NAME'] != 'localhost')
        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-WMC036QFSP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-WMC036QFSP');
</script>
    @endif


    <!-- Core CSS and JS -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/mq-style.css') }}" rel="stylesheet">

    <script src="{{ asset('public/js/fontawesome.min.js') }}"></script>

    @yield('style')

    <script>
        var site_url = "<?php echo url('/'); ?>";
    </script>

</head>
<body>
    @if($_SERVER['SERVER_NAME'] != 'localhost')
        <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PBTXPK3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    @endif
<!-- header  -->
@include('layouts.partials-frontend.header')
<!-- end header -->

<div class="wrapper">
    <div class="loader-section d-none" style="position: fixed; top: 10px; right: 10px; padding: 10px; background: #f3f3f3;border-radius: 60px;">
        <i class="fas fa-spinner fa-spin fa-3x"></i>
    </div>
    <div class="page-content-section">
        <!-- Page Content  -->
        @yield('page-content')
    </div>

    <!-- footer  -->
    @include('layouts.partials-frontend.footer')
    <!-- end footer -->
</div>

@include('user-registration-success-model')


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('public/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/js/script.js') }}"></script>
<script src="{{ asset('public/common.js') }}"></script>
@yield('script')
<script>
    function jquery_data_tables_languages(table_id,pagination = '',columnDefs_type='',columnDefs_target=''){
        (table_id).DataTable({
            // "scrollX": true,
            "lengthMenu": [[10,50,100,250,500, -1], [10,50,100,250,500, "All"]],
            "paging":   pagination ? true : false,
            "info":     true,
            "columnDefs" : [
                {
                    "targets": (typeof(columnDefs_target) != "undefined" && columnDefs_target !== null ? columnDefs_target[0] : ''),
                    "type": (typeof(columnDefs_type) != "undefined" && columnDefs_type !== null ? columnDefs_type[0] : '')
                },
                {
                    "targets": (typeof(columnDefs_target) != "undefined" && columnDefs_target !== null ? columnDefs_target[1] : ''),
                    "type": (typeof(columnDefs_type) != "undefined" && columnDefs_type !== null ? columnDefs_type[1] : '')
                },
            ],
            "language": {
                // "info": "Showing page _PAGE_ of _PAGES_",
                "info": "{{app()->getLocale() == 'nb' ? 'Viser' : 'Showing'}} _START_ {{app()->getLocale() == 'nb' ? 'til' : 'to'}} _END_ {{app()->getLocale() == 'nb' ? 'av' : 'of'}} _TOTAL_ {{app()->getLocale() == 'nb' ? 'innganger' : 'entries'}}",
                "sSearch":"{{__('general.search')}}",
                "sZeroRecords": "{{__('general.no any record found')}}",
                "sLengthMenu":   "{{app()->getLocale() == 'nb' ? 'Vis _MENU_' : 'Show _MENU_'}}",//"Vis _MENU_ linjer",
                "oPaginate": {
                    "sFirst":    "{{__('general.first')}}",
                    "sPrevious": "{{__('general.previous')}}",
                    "sNext":     "{{__('general.next')}}",
                    "sLast":     "{{__('general.last')}}"
                }
            },

        });
    }
    //Set page content height according to screen height for different devices
    function page_content_height(){
        var window_height = $( window ).height();
        var main_content_height = parseInt(window_height) - (parseInt($('.header-container').outerHeight()) + parseInt($('footer').outerHeight()));
        $('.wrapper .page-content-section').css('min-height',main_content_height+'px');
    }

    function add_table_responsive_class(){
        setTimeout(function () {
            $( "table" ).each(function( index ) {
                var table_id = $(this).attr('id');
                var table_width = $('#'+table_id).width();
                var parent_width = $('#'+table_id).closest('div').width();

                if(table_width > parent_width){
                    $('#'+table_id).addClass('table-responsive');
                }else{
                    $('#'+table_id).removeClass('table-responsive');
                }
            });
        },200);
    }

    add_table_responsive_class();

    $(window).resize(function () {
        add_table_responsive_class();
    });

    $(document).ready(function () {
        page_content_height();

        @if(Session::has('flash_contact') && Session::has('show_ambassador_register_modal'))
            $('#registerambassadormodal').modal('show');
        @endif

        @if(Session::has('flash_contact') && Session::has('show_sponsor_register_modal'))
            $('#registersponsormodal').modal('show');
        @endif

        @if(Session::has('show_success_register_modal'))
            $('#user_registration_success_modal').modal('show');
        @endif

        @if(Session::has('show_donation_modal'))
            $('#donationmodal').modal('show');
        @endif

    });
</script>
</body>

</html>