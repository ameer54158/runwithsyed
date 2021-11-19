@extends('layouts.backend-master')

@section('title', 'Initiators')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

@endsection

@section('page-content')
    <!-- Page Content  -->
    <main class="content">
        <div class="flash-message">
            @include('flash::message')
        </div>
        @include('errors')
        <div class="clearfix"></div>
        <div class="float-left">
            <h4>Initiators</h4>
        </div>

        <div class="float-right">
            <a class="btn btn-brown" href="{{route('admin.initiators.create')}}">Create initiator</a>
        </div>
        <div class="clearfix mb-3"></div>
        <table class="table table-striped table-hover" id="initators_table">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="5%">#</th>
                <th scope="col" width="15%">Name</th>
                <th scope="col" width="30%">Description (en)</th>
                <th scope="col" width="30%">Description (no)</th>
                <th scope="col" width="5%">Status</th>
                <th scope="col" width="10%">Action</th>
            </tr>
            </thead>
            <tbody class="initiators_position">
            @if($initiators->count())
                @foreach($initiators as $key=>$initiator)
                    <tr id="{{$initiator->id}}">
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$initiator->name}}</td>
                        <td>{!! Str::limit($initiator->description_en,90) !!}</td>
                        <td>{!!  Str::limit($initiator->description_no,90) !!}</td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" data-ajaxurl="{{route('admin.change-status')}}" data-model_name="{{\App\Models\Initiator::class}}" data-column_name="status" class="custom-control-input status" id="initiator_{{$initiator->id}}"  {{$initiator->status ? 'checked' : ''}}>
                                <label class="custom-control-label" for="initiator_{{$initiator->id}}"></label>
                            </div>
                        </td>
                        <td>
                            <a href="{{route('admin.initiators.edit',$initiator->id)}}"><i class="fa fa-pen mr-2"></i></a>
                            <a href="#delModal" class="delete-modal" data-initiator="show-delete-modal" data-action="{{ route('admin.initiators.destroy', $initiator->id) }}" data-toggle="modal" data-target="#delModal" ><i class="far fa-trash-alt text-danger"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6"><p class="alert alert-danger text-center mb-0">Record not found.</p></td>
                </tr>
            @endif

            </tbody>
        </table>
    </main>

    <!-- delete modal-->
    @include('admin.partials.delete-modal')
@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script>

        $(document).ready( function () {
            @if($initiators->count())
            jquery_data_tables_languages($('#initators_table'));
            @endif
            function update_initiator_order(dataArr) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route('admin.update-initiator-order')}}',
                    dataType: "json",
                    data: {"dataArr": JSON.stringify(dataArr)},
                    success: function (response) {
                        if (response.flag == "success") {
                            var success_message = '<div class="order_change_success_message alert alert-success alert-important" role="alert">\n' +
                                ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Initiators position has been changed successfully..</div>';
                            if(!$('.product_features_position').closest('.modal-body').find('.order_change_success_message').length){
                                $('.product_features_position').closest('.modal-body').find('.flash-message').html(success_message);
                            }
                        }
                    }
                });
            }

            if($('.initiators_position').length){
                var initiators_order = new Array();
                $( ".initiators_position" ).sortable({
                    scroll: true,
                    scrollSensitivity: 80,
                    scrollSpeed: 3,
                    stop: function() {
                        var this_obj = $(this);
                        (this_obj.children('tr')).each(function() {
                            var feature_position = $(this).index() + 1;
                            initiators_order[$(this).index()] = [{'initiator_id':$(this).attr("id")},{'order':feature_position}];
                        });
                        update_initiator_order(initiators_order);
                    }
                });
            }
        });
    </script>
@endsection