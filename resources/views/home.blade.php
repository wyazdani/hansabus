@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')

<!--Statistics cards Starts-->

<div class="row">
							<div class="col-xl-3 col-lg-6 col-12">
								<div class="card">
									<div class="card-body">
										<div class="px-3 py-3">
											<div class="media">
												<div class="media-body text-left align-self-center">
													<i class="fa fa-car info font-large-2 float-left"></i>

												</div>
												<div class="media-body text-right">
													<h3>{{ $totalVehicles }}</h3>
													<span>Vehicles</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-12">
								<div class="card">
									<div class="card-body">
										<div class="px-3 py-3">
											<div class="media">
												<div class="media-body text-left align-self-center">
													<i class="icon-users warning font-large-2 float-left"></i>
												</div>
												<div class="media-body text-right">
													<h3>{{ $totalDrivers  }}</h3>
													<span>Drivers</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-12">
								<div class="card">
									<div class="card-body">
										<div class="px-3 py-3">
											<div class="media">
												<div class="media-body text-left align-self-center">
													<i class="fa fa-university success font-large-2 float-left"></i>
												</div>
												<div class="media-body text-right">
													<h3>{{ $totalCustomers  }}</h3>
													<span>Companies</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-12">
								<div class="card">
									<div class="card-body">
										<div class="px-3 py-3">
											<div class="media">
												<div class="media-body text-left align-self-center">
													<i class="icon-settings danger font-large-2 float-left"></i>
												</div>
												<div class="media-body text-right">
													<h3>423</h3>
													<span>Vehicles Mentinance</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--Statistics cards Ends-->

						<div class="row match-height">

							<div class="col-12 col-md-7" id="recent-sales">
								<div class="card">
									<div class="card-header">
										<div class="card-title-wrap bar-primary">
											<h4 class="card-title">Recent Add Trip</h4>
										</div>
										<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
									</div>

									<div class="card-content mt-1">
										<div class="table-responsive">
											<table class="table table-hover table-xl mb-0" id="recent-orders">
												<thead>
													<tr>
														<th class="border-top-0">ID</th>
														<th class="border-top-0">Trip Name</th>
														<th class="border-top-0">Vehicle</th>
														<th class="border-top-0">Driver</th>
														<th class="border-top-0">Time & Date</th>
														{{--<th class="border-top-0">View</th>--}}
													</tr>
												</thead>

												<tbody>

													<tr>
														@foreach($recentTours as $tour)
														<td class="text-truncate">{!! $tour->id !!}</td>
														<td class="text-truncate">Lorem ipsum</td>
														<td class="text-truncate">{!! !empty($tour->vehicle_id)?$tour->vehicle->name:'' !!}</td>
														<td class="text-truncate">{!! !empty($tour->driver_id)?$tour->driver->driver_name:'' !!}</td>
														<td class="text-truncate">{!! \Carbon\Carbon::parse($tour->from_date) !!}</td>
														{{--<td>
															<button class="btn btn-sm btn-outline-danger round mb-0" type="button" data-toggle="modal"
																data-target="#large">View</button>
														</td>--}}
													</tr>
													@endforeach
												</tbody>

											</table>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-5 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title-wrap bar-warning">
											<h4 class="card-title">Project Stats</h4>
										</div>
									</div>
									<div class="card-body">

										<p class="font-medium-2 text-muted text-center">Project Tasks</p>
										<div id="donut-dashboard-chart" class="height-250 donut donutShadow">
										</div>

										<div class="card-block">
											<div class="row my-3">
												<div class="col">
													<span class="mb-1 text-muted d-block">23% - Drivers</span>
													<div class="progress" style="height: 8px;">
														<div class="progress-bar gradient-blackberry" role="progressbar" style="width: 23%;"
															aria-valuenow="23" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col">
													<span class="mb-1 text-muted d-block">35% - Maintinance</span>
													<div class="progress" style="height: 8px;">
														<div class="progress-bar gradient-pomegranate" role="progressbar" style="width: 35%;"
															aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col">
													<span class="mb-1 text-muted d-block">50% - Vehicles</span>
													<div class="progress" style="height: 8px;">
														<div class="progress-bar gradient-green-tea" role="progressbar" style="width: 50%;"
															aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
@endsection
@section('pagejs')

@endsection