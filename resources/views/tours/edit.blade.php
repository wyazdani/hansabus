@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">

						<div class="col-sm-6 col-md-6">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title">Edit Tour</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter"><a href="{{ route('tours.index') }}" class="btn btn-info ml-2 mt-2">Tours List
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>

				<div class="card-content mt-1">
					<form method="post" action="{{ route('tours.update', $tour->id) }}">
						@method('PATCH')
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
															{{--{!! dd($tour) !!}--}}
															<label for="projectinput1">Tour Name</label>
															{{Form::text("tour_name",
  													           old("tour_name") ? old("tour_name") : (!empty($tour->tour_name) ? $tour->tour_name : null),
             													[
												                "class" => "form-control",
                												"placeholder" => "driver_name",
            													 ])
															 }}
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput2">Time/Date of
																Departure</label>
															{{Form::text("departure_date",
  													           old("departure_date") ? old("departure_date") : (!empty($tour->departure_date) ? $tour->departure_date: null),
             													[
												                "class" => "form-control",
                												"placeholder" => "departure_date",
            													 ])
															 }}
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3">Tour ID</label>
															{{Form::text("tour_id",
  													           old("tour_id") ? old("tour_id") : (!empty($tour->id) ? $tour->id: null),
             													[
												                "class" => "form-control",
                												"placeholder" => "driver_license",
            													 ])
															 }}
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput4">Price</label>
															{{Form::text("price",
  													           old("price") ? old("price") : (!empty($tour->price) ? $tour->price: null),
             													[
												                "class" => "form-control",
                												"placeholder" => "Price",
            													 ])
															 }}
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput4">Select Vehicle</label>
															{{Form::text("vehicle_id",
  													           old("vehicle_id") ? old("vehicle_id") : (!empty($tour->vehicle_id) ? $tour->vehicle_id: null),
             													[
												                "class" => "form-control",

            													 ])
															 }}
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput4">Vehicle Registration</label>
															{{Form::text("vehicle_registration",
  													           old("vehicle_registration") ? old("vehicle_registration") : (!empty($tour->vehicle_id) ? $tour->vehicle_id: null),
             													[
												                "class" => "form-control",

            													 ])
															 }}
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Select Driver</label>
															{{Form::text("driver_id",
  													           old("driver") ? old("driver") : (!empty($tour->driver_id) ? $tour->driver_id: null),
             													[
												                "class" => "form-control",
            													 ])
															 }}
														</div>
													</div>

														<div class="col-md-6">
															<div class="form-group">
																<label for="projectinput4">Select Company</label>
																{{Form::text("customer",
																	 old("customer") ? old("customer") : (!empty($tour->customer_id) ? $tour->customer_id: null),
																	 [
																	"class" => "form-control",
																	 ])
																 }}
															</div>
														</div>
													</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Location</label>
															{{Form::text("location",
  													           old("location") ? old("location") : (!empty($tour->location) ? $tour->location: null),
             													[
												                "class" => "form-control",
            													 ])
															 }}
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Destination</label>
															{{Form::text("destination",
																 old("destination") ? old("destination") : (!empty($tour->destination) ? $tour->destination: null),
																 [
																"class" => "form-control",
																 ])
															 }}
														</div>
													</div>
												</div>

													<div class="row">
														<div class="col-md-12 text-center">
															<div class="form-actions">
																<a href="{{route('tours.index')}}" class="btn btn-danger mr-1">
																	<i class="icon-trash"></i> Cancel</a>
																<button type="submit" class=" btn btn-success"><i class="icon-note"> Update</i> </button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection