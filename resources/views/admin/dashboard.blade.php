@extends('layouts.backend-master')

@section('title', 'Dashboard')

<!-- Page Content  -->
@section('style')
	<link href="{{ asset('public/admin/css/dashboard.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<style>
		table tr td a{
			color: #005cabb5;
		}
	</style>
@endsection
@section('page-content')
	<!-- Page Content  -->
	<main class="content">
		<div class="">
			<div class="p-0 container-fluid">
				<form action="{{url('admin/dashboard')}}" method="GET" class="filter_form">
					<div class="m-0 row d-flex justify-content-between">
						<div class="d-flex align-content-center flex-wrap">
							<button name="export_users" value="yes" class="btn btn-primary mr-2" type="submit"><i class="fa fa-download pr-1"></i>Export users</button>
							<a style="margin-right: 10px;background: #343a40; color: white;padding: 7px 8px; border-radius: 4px;" href="javascript:" title="Advanced Search" data-toggle="collapse" data-target="#toggle-search-filters" aria-expanded="true" class="">
							<i class="fa fa-search fa-lg"></i>
								</a>
							<h3 class="mb-0">Dashboard</h3>
						</div>
						<div>
							<div class="card mb-2">
								<div class="py-2 card-body">
									<div class="media">
										<div class="d-inline-block mr-3">
											<span style="font-size: 36px; font-weight: 600; color: green;">kr</span>
										</div>
										<div class="media-body">
											<h3 class="mb-0">{{number_format($total_sales->sum('amount'),'2',',','.')}}</h3>
											<div class="mb-0">Total donation</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>

					<div id="toggle-search-filters" class="collapse {{\Request::get('start_date') ? 'show' : ''}}" style="">
						<div class="card clearfix mb-3">
							<div class="card-header bg-dark text-white px-2 py-2">
								<b>Advanced search</b>
								<a class="float-right" data-toggle="collapse" href="#toggle-search-filters" aria-expanded="true"> <i class="fa fa-times text-white"></i> </a>
								<div class="clearfix"></div>
							</div>
							<div class="card-body py-1">
								<div class="form-body">

									<div class="row mt-1">
										<div class="col-md-3 my-1 px-1">
											<label class="form-label mb-0">Date start</label>
											<input type="date" class="form-control" name="start_date" value="{{\Request::get('start_date')}}">
										</div>
										<div class="col-md-3 my-1 px-1">
											<label class="form-label mb-0">Date end</label>
											<input type="date" class="form-control" name="end_date" value="{{\Request::get('end_date')}}">
										</div>
									</div>
								</div><!-- .form-body -->
								<div class="clearfix"> </div>
							</div>
							<div class="card-footer py-1">
								<div class="row text-right d-block">
									<a href="{{url('admin/dashboard')}}" class="btn btn-sm btn-dark mb-0" style="width: auto">Reset search result</a>
									<button type="submit" class="btn btn-sm mb-0 btn-primary"> Search </button>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>

					</div>
				</form>
				<div class="row">

					<div class="col-md-4">
						<div class="flex-fill card">
							<div class="py-4 card-body">
								<a href="{{url('admin/users'.'?role=ambassador')}}">
									<div class="media">
										<div class="d-inline-block mt-2 mr-3">
											<i class="fas fa-users fa-3x" style="color: rgba(15,76,130,1);"></i>
										</div>
										<div class="media-body">
											<h3 class="mb-0">{{$ambassadors->count()}}</h3>
											<div class="mb-0" style="font-weight: 500">Ambassadors</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="flex-fill card">
							<div class="py-4 card-body">
								<a href="{{url('admin/users'.'?role=sponsor')}}">
									<div class="media">
										<div class="d-inline-block mt-2 mr-3">
											<i class="fas fa-user-tie fa-3x" style="color: #8a5917"></i>
										</div>
										<div class="media-body">
											<h3 class="mb-0">{{$sponsors->count()}}</h3>
											<div class="mb-0">Sponsors</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="flex-fill card">
							<div class="py-4 card-body">
								<a href="{{route('admin.initiators.index')}}">
									<div class="media">
										<div class="d-inline-block mt-2 mr-3">
											<i class="fas fa-info fa-3x" style="color: #75490f"></i>
										</div>
										<div class="media-body">
											<h3 class="mb-0">{{$initiators->count()}}</h3>
											<div class="mb-0">Initiators</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="flex-fill card" style="background: lightgoldenrodyellow">
							<div class="py-4 card-body">
								<a href="{{url('admin/payments'.'?payment_user=ambassador')}}">
									<div class="media">
										<div class="d-inline-block mt-2 mr-3">
											<span style="font-size: 36px; font-weight: 600; color: green;">kr</span>
										</div>
										<div class="media-body">
											<h3 class="mb-0">{{number_format($total_sales->where('payment_user','ambassador')->sum('amount'),'2',',','.')}}</h3>
											<div class="mb-0">Ambassador Amount</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="flex-fill card" style="background: aliceblue;">
							<div class="py-4 card-body">
								<a href="{{url('admin/payments'.'?payment_user=sponsor')}}">
									<div class="media">
										<div class="d-inline-block mt-2 mr-3">
											<span style="font-size: 36px; font-weight: 600; color: green;">kr</span>
										</div>
										<div class="media-body">
											<h3 class="mb-0">{{number_format($total_sales->where('payment_user','sponsor')->sum('amount'),'2',',','.')}}</h3>
											<div class="mb-0">Sponsor Amount</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="flex-fill card" style="background: #f5e3e3">
							<div class="py-4 card-body">
								<a href="{{url('admin/payments'.'?payment_user=donation')}}">
									<div class="media">
										<div class="d-inline-block mt-2 mr-3">
											<span style="font-size: 36px; font-weight: 600; color: green;">kr</span>
										</div>
										<div class="media-body">
											<h3 class="mb-0">{{number_format($total_sales->where('payment_user','donation')->sum('amount'),'2',',','.')}}</h3>
											<div class="mb-0">Total Donations</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="flex-fill card" style="background: bisque;">
							<div class="py-4 card-body">
								<a href="{{url('admin/payments'.'?payment_user=ambassador_membership_fee')}}">
									<div class="media">
										<div class="d-inline-block mt-2 mr-3">
											<span style="font-size: 36px; font-weight: 600; color: green;">kr</span>
										</div>
										<div class="media-body">
											<h3 class="mb-0">{{number_format($total_sales->where('payment_user','ambassador_membership_fee')->sum('amount'),'2',',','.')}}</h3>
											<div class="mb-0">Total Membership fee</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if($current_month_sales->count())
			<div class="row">
				<div class="col-12 mb-4">
					<div class="bg-white p-3">
						<h6>Date:
							<span class="alert alert-primary p-1">
								{{\Request::get('start_date') ? date('d M Y', strtotime(\Request::get('start_date'))) : date('01 M Y') }} to
								{{\Request::get('end_date') ? date('d M Y', strtotime(\Request::get('end_date'))) : date('t M Y') }}
							</span>
						</h6>
						{{--<h6>Date: <span class="alert alert-primary p-1">01 Mar 2021 to 31 Mar 2021</span></h6>--}}
						<canvas id="myChart" height="500" class=" w-100"></canvas>
					</div>
				</div>
			</div>
		@endif

		<div class="row">
			<div class="col-lg-12">
				<div class="flex-fill w-100 card">
					<div class="card-header">
						<h5 class="mb-3 card-title" style="border-bottom: 2px solid #dfdfdf; padding-bottom: 15px">Ambassadors</h5>
						<table class="table table-sm employees-table" id="ambassador_table">
							<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Date</th>
								<th class="text-center">Sponsors</th>
								<th class="text-center">Donation</th>
							</tr>
							</thead>
							<tbody>
							@if($ambassadors->count())
								@foreach($ambassadors as $ambassador_key=>$ambassador)
									<tr>
										<th>{{$ambassador_key+1}}</th>
										<td>
											{{$ambassador->first_name ? $ambassador->first_name : ''}}
											{{$ambassador->last_name ? $ambassador->last_name : ''}}
										</td>
										<td>{{$ambassador->email}}</td>
										<td>{{$ambassador->created_at->format('M d, Y')}}</td>
										<td class="text-center"><span class="font-weight-bold">{{$ambassador->sponsors->count()}}</span></td>
										<td class="text-center">
											<span class="font-weight-bold">
												@if($ambassador->ambassador_payments->count())
													@php
														$total_amount = 0;
														if($ambassador->ambassador_payments->count()){
															$payments = \App\Models\Payment::whereIn('id',$ambassador->ambassador_payments->pluck('payment_id')->toArray())->get();
															$total_amount = $payments->count() ? $payments->sum('amount') : 0;
														}
													@endphp
													{{$total_amount ? number_format($total_amount,'2',',','.') : 0}}
												@else
													0
												@endif
											</span>
										</td>
									</tr>
									@if($ambassador_key == 9)
										@break
									@endif
								@endforeach
							@else
								<tr><td colspan="6"><p class="alert alert-danger mb-0">No any record found.</p></td></tr>
							@endif

							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-lg-12">
				<div class="flex-fill w-100 card">
					<div class="card-header">
						<h5 class="mb-3 card-title" style="border-bottom: 2px solid #dfdfdf; padding-bottom: 15px">Sponsors</h5>
						<table class="table table-sm companies-table" id="sponsor_table">
							<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Date</th>
								<th class="text-center">Ambassadors</th>
								<th class="text-center">Donation</th>
							</tr>
							</thead>
							<tbody>
							@if($sponsors->count())
								@foreach($sponsors as $sponsor_key=>$sponsor)
									<tr>
										<th>{{$sponsor_key+1}}</th>
										<td>
											{{$sponsor->first_name ? $sponsor->first_name : ''}}
											{{$sponsor->last_name ? $sponsor->last_name : ''}}
										</td>
										<td>{{$sponsor->email}}</td>
										<td>{{$sponsor->created_at->format('M d, Y')}}</td>
										<td class="text-center"><span class="font-weight-bold">{{$sponsor->ambassadors->count()}}</span></td>
										<td class="text-center">
											<span class="font-weight-bold">
												@if($sponsor->sponsor_payments->count())
													@php
														$total_amount = 0;
														if($sponsor->sponsor_payments->count()){
															$payments = \App\Models\Payment::whereIn('id',$sponsor->sponsor_payments->pluck('payment_id')->toArray())->get();
															$total_amount = $payments->count() ? $payments->sum('amount') : 0;
														}
													@endphp
													{{$total_amount ? number_format($total_amount,'2',',','.') : 0}}
												@else
													0
												@endif
											</span>
										</td>
									</tr>
									@if($sponsor_key == 9)
										@break
									@endif
								@endforeach
							@else
								<tr><td colspan="6"><p class="alert alert-danger mb-0">No any record found.</p></td></tr>
							@endif

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection
@section('script')
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="{{asset('public/js/date-eu.js')}}"></script>
	<script src="{{asset('public/js/formatted-numbers.js')}}"></script>
	<script>
        $(document).ready(function () {

			@if($ambassadors->count())
				var columnDefs_type = ['date-eu','formatted-num','formatted-num'];
				var columnDefs_target = [3,4,5];
				jquery_data_tables_languages($('#ambassador_table'),columnDefs_type,columnDefs_target);
			@endif

			@if($sponsors->count())
				var columnDefs_type = ['date-eu','formatted-num','formatted-num'];
				var columnDefs_target= [3,4,5];
				jquery_data_tables_languages($('#sponsor_table'),columnDefs_type,columnDefs_target);
			@endif

			@if($current_month_sales->count())
            if($('#myChart'.length)){
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [
							@if($current_month_sales->count())
							@foreach($current_month_sales as $current_month_sale)
							{!! '"'.date('d, M', strtotime($current_month_sale->date)).'",' !!}
							@endforeach
							@endif
                            // "1,Mar", "2,Mar", "3,Mar", "4,Mar", "5,Mar","8,Mar", "12,Mar", "13,Mar", "18,Mar",
                        ],

                        datasets: [
                            {
                                // maxBarThickness: 100,
                                label: 'Total Donation',
                                data: [
									@if($current_month_sales->count())
									@foreach($current_month_sales as $current_month_sale)
									{!! '"'.$current_month_sale->sum.'",' !!}
									@endforeach
									@endif
                                    // 320, 490, 530, 600, 620, 500, 800, 700, 810
                                ],

                                backgroundColor: 'rgba(117, 73, 15, 0.5)',
                                borderColor: 'rgba(117, 73, 15, 1)',
                                borderWidth: 1.3
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                ticks: {
                                    maxRotation: 90,
                                    minRotation: 80
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
			@endif

            //Prevent to submit form thorugh pdf button when an enter is pressed in any input in the form
            $(document).on("keypress", ".filter_form", function(e){
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    $(this).closest('.filter_form').find('button[name="export_users"]').attr('type','button');
                }
            });
        });

	</script>
@endsection
