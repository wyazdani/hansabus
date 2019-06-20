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
								<h4 class="card-title">Add Driver</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter"><a href="{{ route('drivers.index') }}" class="btn btn-info ml-2 mt-2">Drivers List
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>

				<div class="card-content mt-1">
					<form method="post" action="{{ route('drivers.store') }} "  enctype="multipart/form-data">
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
															<label for="projectinput1">Driver Name</label>
															<input type="text" class="{{($errors->has('driver_name')) ?'form-control error_input':'form-control'}}" name="driver_name"
																   value="{{ (!empty($driver->driver_name))?$driver->driver_name:old('driver_name') }}" >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput2">Mobile
																No.</label>
															<input type="text" id=""
																   class="{{($errors->has('mobile_number')) ?'form-control error_input':'form-control'}}" maxlength="11" placeholder="Only Numbers"
																   value="{{ (!empty($driver->mobile_number))?$driver->mobile_number:old('mobile_number') }}" name="mobile_number">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput3">Driver
																License</label>
															<input type="text" id=""
																   class="{{($errors->has('driver_license')) ?'form-control error_input':'form-control'}}"
																   name="driver_license" value="{{ (!empty($driver->driver_license))?$driver->driver_license:old('driver_license') }}">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">NIN
																No.</label>
															<input type="text" id=""
																   class="{{($errors->has('nic')) ?'form-control error_input':'form-control'}}" name="nic" maxlength="11"
																   value="{{ (!empty($driver->nic))?$driver->nic:old('nic') }}" placeholder="Only Numbers">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label
																	for="projectinput3">Address</label>
															<input type="text" id=""
																   class="{{($errors->has('address')) ?'form-control error_input':'form-control'}}"
																   value="{{ (!empty($driver->address))?$driver->address:old('address') }}" name="address" >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Phone
																Number</label>
															<input type="text" id=""
																   class="{{($errors->has('phone')) ?'form-control error_input':'form-control'}}"
																   value="{{ (!empty($driver->phone))?$driver->phone:old('phone') }}" name="phone" maxlength="11" placeholder="Only Numbers">
														</div>
													</div>
												</div>

												<div class="form-group">
													<label for="projectinput8">Other Details</label>
													<textarea id="projectinput8" rows="5"
															  class="{{($errors->has('other_details')) ?'form-control error_input':'form-control'}}"
															  name="other_details" value="{{ (!empty($driver->other_details))?$driver->other_details:old('other_details') }}"

													></textarea>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card">
									<div class="card-body collapse show">
										<div class="card-block">
											{{--<div action="/" class="dropzone dropzone-area"
												 id="dpz-single-file"></div>--}}
											<input type="file" class="dropzone dropzone-area" name="avatar" id="avatar">
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
								</div>
							</div>
						</div>

					</form>
				</div>

			</div>
		</div>
	</div>
@endsection
