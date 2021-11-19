@extends('layouts.frontend-master')

@section('title',(__('header.our-ambassadors')) )

@section('page-content')
    <!-- Page Content  -->
    <main class="content our-ambassadors-page">
        <div class="loader-section d-none" style="position: fixed; top: 10px; right: 10px; padding: 10px; background: #f3f3f3;border-radius: 60px;">
            <i class="fas fa-spinner fa-spin fa-3x"></i>
        </div>
        <div class="container">
            <div id="errors" class="w-100">
                @include('flash::message')
            </div>
            <form data-ajaxurl="{{localized_route('our-ambassadors')}}">
                <div class="row">
                    <div class="col-8 col-lg-7 sort-ambassador-dropdown-grid">
                        <input class="form-control w-100 search-ambassador-input" placeholder="{{__('general.search for an ambassador')}}">
                    </div>
                    <div class="col-4 col-lg-2 sort-btn-grid">
                        <button class="btn sort-btn" type="button" name="button" value="sort">{{__('general.search')}}</button>
                    </div>
                    <div class="col-12 col-lg-3 ">
                        <button class="btn sort-ambassador-dropdown dropdown-toggle w-100 text-left" name="sort_by" type="button" value="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{__('general.select sort')}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="javascript:void(0);" data-value=""> {{__('general.select sort')}}</a>
                            <a class="dropdown-item" href="javascript:void(0);" data-value="navn">{{__('general.name')}}</a>
                            <a class="dropdown-item" href="javascript:void(0);" data-value="heighest_km">{{__('general.highest km')}}</a>
                            <a class="dropdown-item" href="javascript:void(0);" data-value="lowest_km">{{__('general.lowest km')}}</a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="our-ambassadors-inner">
                @include('ambassadors.our-ambassadors-inner')
            </div>

        </div>

        @include('become-sponsor-success-model')

    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            @if(Session::has('become_sponsor_success_modal'))
                $('#become_sponsor_success_modal').modal('show');
            @endif


            $(document).on('click','.our-ambassadors-page .dropdown-menu .dropdown-item',function (e) {
                var html = $(this).html();
                var val = $(this).data('value');
                $(this).closest('form .col-12').find('.sort-ambassador-dropdown').html(html);
                $(this).closest('form .col-12').find('.sort-ambassador-dropdown').attr('value',val);

                var action = $(this).closest('form').data('ajaxurl');
                var sort = $('form .sort-ambassador-dropdown').val();
                var search = $('.our-ambassadors-page .search_ajax_data').val();
                var pagination = $('.our-ambassadors-page .pagination_input').val();
                send_ajax_request(action,sort,search,pagination);
            });

            function send_ajax_request(action,sort,search,pagination){
                if(action){
                    $.ajax({
                        url: action,
                        type:'GET',
                        data: {'search':search,'sort':sort,'pagination':pagination},
                        dataType:'json',
                        success: function (data) {
                            if(data && data.data){
                                $('.our-ambassadors-page .our-ambassadors-inner').html(data.data);
                            }
                            page_content_height();
                        }
                    });
                }
            }
            //Filter the our ambassador
            $(document).on('click', '.our-ambassadors-page form button[name="button"]', function(e) {
                var action = $(this).closest('form').data('ajaxurl');
                var sort = $('form .sort-ambassador-dropdown').val();
                var search = $('form .search-ambassador-input').val();
                var pagination = $('.our-ambassadors-page .pagination_input').val();
                send_ajax_request(action,sort,search,pagination);
            });

            $(document).on('keydown', 'form input', function(event) {
                if(event.keyCode == 13) {
                    event.preventDefault();
                    $('.our-ambassadors-page form button[name="button"]').click();
                    return false;
                }
            });

            $(document).on('click', '.our-ambassadors-page .show-more-button', function(e) {
                var val = (1+ parseInt($(this).val()));
                $(this).val(val);
                $('.pagination_input').val(val);
                var action = $(this).closest('.our-ambassadors-page').find('form').data('ajaxurl');
                var sort = $(this).closest('.our-ambassadors-page').find('form .sort-ambassador-dropdown').val();
                var search = $(this).closest('.our-ambassadors-page').find('form .search-ambassador-input').val();
                var pagination = val;
                send_ajax_request(action,sort,search,pagination);
            });
        });
    </script>
@endsection