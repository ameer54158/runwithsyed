@extends('layouts.backend-master')

@section('title', 'Donations')

@section('style')
    <style>
        .completed{
            padding: 5px 8px;
            background-color: green;
            color: white;
            font-size: 12px;
            border-radius: 5px;
            font-weight: 500;
        }
        .amount span{
            padding: 5px 8px;
            background-color: darkmagenta;
            color: white;
            font-size: 12px;
            border-radius: 5px;
            font-weight: 500;
        }
         .pending{
            padding: 5px 8px;
            background-color: #e74c3c;
            color: white;
            font-size: 12px;
            border-radius: 5px;
            font-weight: 500;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

@endsection
@section('page-content')
    <!-- Page Content  -->
    <main class="content">
        @include('flash::message')
        @include('errors')
        <div class="clearfix mb-1"></div>
        <div class="float-left">
            <h4>Donations</h4>
        </div>

        <div class="float-right">
            <a style="background: #8a5917; color: white;" href="javascript:" class="btn mb-0" title="Advanced Search" data-toggle="collapse" data-target="#user_filter" aria-expanded="true"><i class="fa fa-search fa-lg"></i></a>
        </div>
        <div class="clearfix"></div>
        <form action="{{route('admin.donations.index')}}" method="GET">
            <div id="user_filter" class="collapse <?php if(Request()->has('email')) echo 'show'; ?>">
                <div class="card clearfix mt-3">
                    <div class="card-header bg-dark text-white px-2 py-2">
                        <b>Advanced search</b>
                        <a class="float-right" data-toggle="collapse" href="#user_filter" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body py-1">
                        <div class="form-body">
                            <div class="row mt-1">
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">First Name</label>
                                    <input type="text" class="form-control form-control-sm" name="first_name" value="{{Request()->first_name}}">
                                </div>
                                 <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Last Name</label>
                                    <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request()->last_name}}">
                                </div>
                              
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Amount start</label>
                                    <input type="number" class="form-control form-control-sm" name="start_amount" value="{{Request()->start_amount}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="0">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Amount end</label>
                                    <input type="number" class="form-control form-control-sm" name="end_amount" value="{{Request()->end_amount}}" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}" step=any min="0">
                                </div>
                                  <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Email</label>
                                    <input type="text" class="form-control form-control-sm" name="email" value="{{Request()->email}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Donation date start</label>
                                    <input type="date" class="form-control form-control-sm" name="payment_start_date" value="{{Request()->payment_start_date}}">
                                </div>
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Donation date end</label>
                                    <input type="date" class="form-control form-control-sm" name="payment_end_date" value="{{Request()->payment_end_date}}">
                                </div>
    
                                <div class="col-md-3 my-1 px-1">
                                    <label class="form-label mb-0">Status</label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="">Select status</option>
                                        <option value="completed" {{Request()->status == 'completed' ? 'selected' : ''}}>Completed</option>
                                        <option value="pending" {{Request()->status == 'pending' ? 'selected' : ''}}>Pending</option>
                                    </select>
                                </div>
                            </div>
                        </div><!-- .form-body -->
                        <div class="clearfix"> </div>
                    </div>
                    <div class="card-footer py-1">
                        <div class="row text-right d-block">
                            <a href="{{route('admin.donations.index')}}" class="btn btn-sm btn-dark mb-0" style="width: auto">Reset search result</a>
                            <button type="submit" class="btn btn-sm mb-0 btn-primary"> Search </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </form>
        <div class="clearfix my-3"></div>
        <table class="table table-striped table-hover" id="donations_table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Transaction Id</th>
                <th scope="col">Name</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            @if($donations->count())
                @foreach($donations as $key=>$donation)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td><span style="font-weight: 500">{{$donation->transaction_id ? $donation->transaction_id : 'N/A'}}</span></td>
                        <td>
                            {{$donation->donation && $donation->donation->name ? $donation->donation->name : 'N/A'}}
                        </td>
                        <td class="amount"><span class="font-weight-bold">{{number_format($donation->amount,'2',',','.')}} kr</span></td>
                        <td>{{$donation->created_at->format('M d, Y')}}</td>
                        <td><span class="{{$donation->status}}">{{ucfirst($donation->status)}}</span></td>
                        <td>
                            <a href="{{route('admin.payment-detail',$donation->id)}}"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9"><p class="alert alert-danger text-center mb-0">Record not found.</p></td>
                </tr>
            @endif
            </tbody>
        </table>
    </main>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/js/date-eu.js')}}"></script>
    <script src="{{asset('public/js/formatted-numbers.js')}}"></script>
    <script>
        $(document).ready(function () {
            var columnDefs_type = ['formatted-num','date-eu'];
            var columnDefs_target = [3,4];
            @if($donations->count())
            jquery_data_tables_languages($('#donations_table'),columnDefs_type,columnDefs_target);
            @endif
        });

    </script>
@endsection