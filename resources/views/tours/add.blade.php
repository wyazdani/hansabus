@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">

						<div class="col-sm-6 col-md-8">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title">Add Tour Details</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 text-right">
							<div class="dataTables_filter"><a href="{{ route('tours.index') }}" class="btn btn-info ml-2 mt-2">Tours List
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>

				<div class="card-content mt-1">
					<form method="post" action="{{ route('tours.store') }} "  enctype="multipart/form-data">
						@csrf

						<div class="row">

							<div class="col-md-12">
								<div class="card">

									<div class="card-body">
										<div class="px-3">

											<div class="form-body">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput1">Tour Name</label>
															<input type="text" class="form-control" name="tour_name">
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="issueinput3">Time/Date of
																Departure</label>
															<input type="datetime-local" id="date_time"
																   class="form-control"
																   name="departure_date"
																   data-toggle="tooltip"
																   data-trigger="hover"
																   data-placement="top"
																   data-title="Date Opened">
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput1">Tour
																ID</label>
															<input type="text" id="projectinput1"
																   class="form-control" name="tour_id">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3">Price</label>
															<input type="text" id=""
																   class="form-control"
																   name="price">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label>Select Vehicle</label>
															{!!Form::select('vehicle_id[]', $vehicle_name, null, ['class' => 'form-control'])!!}
															{{--{!! input_custom('select','city_id',$vehicle_name,null,[
															'class' =>  'select',
															'placeholder'   =>  'Select Vehicle']) !!}--}}
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label>Vehicle Number</label>
															{!!Form::select('vehicle_reg[]', $vehicle_reg, null, ['class' => 'form-control'])!!}

															{{--{!! input_custom('select','city_id',$vehicle_reg,null,[
															'class' =>  'select',
															'placeholder'   =>  'Select Vehicle']) !!}--}}
														</div>
													</div>
												</div>

												<div class="row">

													<div class="col-md-6">
														<div class="form-group">
															<label for="customSelect">Driver</label>
															{!!Form::select('driver_id', $driver, 'Select', ['class' => 'form-control'])!!}
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label
																	for="customSelect">Customer/Travel
																Company</label>
															<select
																	class="custom-select d-block w-100"
																	id="customSelect">
																<option selected="">Open this select
																	menu</option>
																<option value="1">One</option>
																<option value="2">Two</option>
																<option value="3">Three</option>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput3">Choose
																Location</label>
															<input type="text" id="projectinput3"
																   class="form-control" name="location">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Choose
																Destination</label>
															<input type="text" id="projectinput4"
																   class="form-control" name="destination">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
							<div class="row">
								<div class="col-md-12 text-center">
									<div class="form-actions">
										<a href="{{route('drivers.index')}}" class="btn btn-danger mr-1"><b>
												<i class="icon-trash"></i></b> Cancel</a>
										<button type="submit" class="btn btn-success"><b>
												<i class="icon-note"></i></b> Save</button>
										<button type="button" class="btn btn-info">
											<i class="icon-note"></i> Save & add another
										</button>
									</div>
								</div>
							</div>

					</form>
				</div>

			</div>
		</div>
	</div>
@endsection
