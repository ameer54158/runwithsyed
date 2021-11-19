@extends('layouts.backend-master')

@section('title', 'Top ambassadors')

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    <style>
        .sorting .ui-state-highlight{
            background: #e4e4e4;
            padding: 6px;
            border-radius: 3px;
            width: 50%;
            margin-bottom: 20px;
            cursor: move;
        }
    </style>
@endsection

@section('page-content')
    <!-- Page Content  -->
    <main class="content our-top-ambassadors">
        @include('flash::message')
        @include('errors')

        <h4>Our top ambassadors</h4>

        <form method="POST" action="{{route('admin.store-our-top-ambassadors')}}">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-10">
                    <hr>
                    <label class="font-weight-bold">Ambassadors</label>
                    <select class="form-control select2" multiple name="ambassador_id[]">
                        <option value="">Select ambassadors</option>
                        @if($ambassadors->count())
                            @foreach($ambassadors as $ambassador)
                                <option value="{{$ambassador->id}}" {{$our_top_ambassadors->count() && $our_top_ambassadors->where('user_id',$ambassador->id)->first() ? 'selected' : ''}}>
                                    {{$ambassador->first_name}} {{$ambassador->last_name}} ({{$ambassador->email}})
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <input type="hidden" name="ambassador_orders">

            <div class="selected-ambassadors">
                <label class="font-weight-bold d-none">Change position</label>
                <div class="sorting">
                    @if($our_top_ambassadors->count())
                        @foreach($our_top_ambassadors as $our_top_ambassador)
                            @if($our_top_ambassador->user)
                                <div class="ui-state-highlight" id="{{$our_top_ambassador->user->id}}">
                                    {{$our_top_ambassador->user->first_name ? $our_top_ambassador->user->first_name : ''}}
                                    {{$our_top_ambassador->user->last_name ? $our_top_ambassador->user->last_name : ''}}
                                    ({{$our_top_ambassador->user->email ? $our_top_ambassador->user->email : ''}})

                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({width: '100%', placeholder: "Select ambassadors", allowClear: true});

            function sorting_arr(){
                var ambassadors_order = new Array();
                $('.sorting').children('div').each(function() {
                    var position = $(this).index() + 1;
                    ambassadors_order[$(this).index()] = [{'ambassador_id':$(this).attr("id")},{'order':position}];
                });
                $('input[name="ambassador_orders"]').val('');
                if(ambassadors_order.length){
                    $('input[name="ambassador_orders"]').val(JSON.stringify(ambassadors_order));
                }
            }
            //
            $('select.select2').on("select2:select", function (e) {
                var items = '"'+$(this).val()+'"';
                if(items.search(",") !== -1 ){
                    var explode = items.split(',');
                    $( explode ).each(function( index, value ) {
                        var element = '';
                        var text = '';
                        var val = value.replace('"','');
                        if(!($('.sorting #'+val).length)){
                            text = $("select.select2 option[value='"+val+"']").text();
                            element = '<div class="ui-state-highlight" id="'+val+'">'+text+'</div>';
                            $('.sorting').append(element);
                        }
                    });
                }else{

                    var element = '';
                    items = items.replace('"','');
                    items = items.replace('"','');
                    var text = $("select.select2 option[value='"+items+"']").text();
                    if(!($('.sorting #'+items).length)){
                        element = '<div class="ui-state-highlight" id="'+items+'">'+text+'</div>';
                        $('.sorting').append(element);
                    }
                }
                sorting_arr();
            });

            //
            $('select.select2').on("select2:unselect", function (e) {
                var value= e.params.data.id;
                if(value){
                    if(($('.sorting #'+value).length)){
                        $('.sorting #'+value).remove();
                    }
                }
                sorting_arr();

            });

            $('select.select2').on("select2:select select2:unselect", function (e) {
                $('.selected-ambassadors label').addClass('d-none');
                if($('.sorting .ui-state-highlight').length){
                    $('.selected-ambassadors label').removeClass('d-none');
                }
            });

            $(".selected-ambassadors div").sortable({
                connectWith: ".sorting",
                scroll: true,
                scrollSensitivity: 80,
                scrollSpeed: 3,
                stop: function() {
                    // var this_obj = $(this);
                    sorting_arr();
                }
            }).disableSelection();
        });
    </script>
@endsection