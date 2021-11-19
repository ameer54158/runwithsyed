<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title', 'Home') | {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/images/rws-favicon.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/css/admin.css') }}" rel="stylesheet">
    <script src="{{ asset('public/admin/js/fontawesome.min.js') }}"></script>
    <link href="{{ asset('public/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">

    @yield('style')

    <script>
        var site_url = "<?php echo url('/'); ?>";
    </script>

</head>

<body>

<div class="">

    @include('layouts.partials-backend.header')

    <div class="wrapper">
        @include('layouts.partials-backend.sidebar')

        @yield('page-content')

    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('public/admin/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('public/admin/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/admin/mediexpert-admin.js') }}"></script>
<script src="{{ asset('public/common.js') }}"></script>

<script>
    function jquery_data_tables_languages(table_id,columnDefs_type='',columnDefs_target=''){
        (table_id).DataTable({
            "scrollX": true,
            "lengthMenu": [[10,25,50,100,250,500, -1], [10,25,50,100,250,500, "All"]],
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
        });
    }
</script>

@yield('script')
</body>
