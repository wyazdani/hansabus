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
								<h4 class="card-title">Edit Driver</h4>
							</div>
						</div>

						{{--<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter"><a href="{{ route('drivers.index') }}" class="btn btn-info ml-2 mt-2">Drivers List
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>--}}

					</div>

				</div>

				<div class="card-content mt-1">
					<form method="post" action="{{ route('drivers.update', $driver->id) }}">
						@method('PATCH')
						@csrf
						<div class="row">

							<div class="col-md-8">
								<div class="card">

									<div class="card-body">
										<div class="px-3">

											<div class="form-body">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															{{--{!! dd($driver) !!}--}}
															<label for="projectinput1">Driver Name</label>
															{{Form::text("driver_name",
  													           old("driver_name") ? old("driver_name") : (!empty($driver->driver_name) ? $driver->driver_name : null),
             													[
												                "class" => "form-control",
                												"placeholder" => "driver_name",
            													 ])
															 }}
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput2">Mobile No.</label>
															{{Form::text("mobile_number",
  													           old("mobile_number") ? old("mobile_number") : (!empty($driver->mobile_number) ? $driver->mobile_number: null),
             													[
												                "class" => "form-control",
                												"placeholder" => "mobile_number",
            													 ])
															 }}
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput3">Driver
																License</label>
															{{Form::text("driver_license",
  													           old("driver_license") ? old("driver_license") : (!empty($driver->driver_license) ? $driver->driver_license: null),
             													[
												                "class" => "form-control",
                												"placeholder" => "driver_license",
            													 ])
															 }}
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Nic
																No.</label>
															{{Form::text("nic",
  													           old("nic") ? old("nic") : (!empty($driver->nic) ? $driver->nic: null),
             													[
												                "class" => "form-control",
                												"placeholder" => "nic",
            													 ])
															 }}
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label
																	for="projectinput3">Address</label>
															{{Form::text("address",
  													           old("address") ? old("address") : (!empty($driver->address) ? $driver->address: null),
             													[
												                "class" => "form-control",
                												"placeholder" => "address",
            													 ])
															 }}
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Phone
																Number</label>
															{{Form::text("phone",
  													           old("phone") ? old("phone") : (!empty($driver->phone) ? $driver->phone: null),
             													[
												                "class" => "form-control",
                												"placeholder" => "phone",
            													 ])
															 }}
														</div>
													</div>
												</div>

												<div class="form-group">
													<label for="projectinput8">Other Details</label>
													{{Form::textarea("other_details",
  													           old("other_details") ? old("other_details") : (!empty($driver->other_details) ? $driver->other_details: null),
             													[
												                "class" => "form-control",
                												"placeholder" => "other_details",
            													 ])
															 }}
													{{--<textarea id="projectinput8" rows="5"
															  class="form-control"
															  name="other_details" value="{{$driver->other_details}}"></textarea>--}}
												</div>

												<div class="row">
													<div class="col-md-12 text-center">
														<div class="form-actions">
															<a href="{{route('drivers.index')}}" class="btn btn-danger mr-1">
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