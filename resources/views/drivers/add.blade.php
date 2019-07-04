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
								<h4 class="card-title">{{ (!empty($driver->id))?__('driver.heading.edit'):__('driver.heading.add') }}
								</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter"><a href="{{ route('v-drivers.index') }}" class="btn btn-info ml-2 mt-2">{{__('driver.heading.index')}}
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>

				<div class="card-content mt-1">

					@if(!empty($driver->id))
						<form class="form" method="POST" action="{{ route('v-drivers.update',$driver->id) }}" id="theForm" enctype="multipart/form-data" >
							@method('PUT')
							<input type="hidden" id="id" name="id" value="{{ $driver->id }}">
							<input type="hidden" name="old_profile_pic" value="{{ $driver->profile_pic }}">
					@else
								<form class="form" method="POST" action="{{ route('v-drivers.store') }}" id="theForm" enctype="multipart/form-data" >
					@endif
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
																		<label for="projectinput1">{{__('driver.name') }}</label>
																		<input type="text" name="driver_name"
																			   class="{{($errors->has('driver_name')) ?'form-control error_input':'form-control'}}"
																			   value="{{ (!empty($driver->driver_name))?$driver->driver_name:old('driver_name') }}" >
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="projectinput2">{{__('driver.mobile') }}</label>
																		<input type="number" name="mobile_number"
																			   class="{{($errors->has('mobile_number')) ?'form-control error_input':'form-control'}}"
																			   value="{{ (!empty($driver->mobile_number))?$driver->mobile_number:old('mobile_number') }}" >
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="projectinput3">{{__('driver.license') }}</label>
																		<input type="text" name="driver_license"
																			   class="{{($errors->has('driver_license')) ?'form-control error_input':'form-control'}}"
																			   value="{{ (!empty($driver->driver_license))?$driver->driver_license:old('driver_license') }}">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="projectinput4">{{__('driver.nin') }}</label>
																		<input type="number" name="nic"
																			   class="{{($errors->has('nic')) ?'form-control error_input':'form-control'}}"
																			   value="{{ (!empty($driver->nic))?$driver->nic:old('nic') }}" >
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label
																				for="projectinput3">{{__('driver.address') }}</label>
																		<input type="text" name="address"
																			   class="{{($errors->has('address')) ?'form-control error_input':'form-control'}}"
																			   value="{{ (!empty($driver->address))?$driver->address:old('address') }}" >
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="projectinput4">{{__('driver.phone') }}</label>
																		<input type="number"  name="phone"
																			   class="{{($errors->has('phone')) ?'form-control error_input':'form-control'}}"
																			   value="{{ (!empty($driver->phone))?$driver->phone:old('phone') }}">
																	</div>
																</div>
															</div>

															<div class="form-group">
																<label for="projectinput8">{{__('driver.other_details') }}</label>
																<textarea rows="5" name="other_details"
																		  class="{{($errors->has('other_details')) ?'form-control error_input':'form-control'}}"
																>{{ (!empty($driver->other_details))?$driver->other_details:old('other_details') }}</textarea>
															</div>
														</div>

													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="card">
												<div class="card-body collapse show">
													@if(!empty($driver->profile_pic))
														<img src="{{ url('images/drivers/'.$driver->profile_pic) }}"
															 style="display:block; width: 90%; height:auto;">
														@endif
													<div class="card-block">
														<input type="file" class="form-control" name="profile_pic">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-12 text-left">
										<div class="form-actions">
												<a href="{{route('v-drivers.index')}}" class="btn btn-danger mr-1"><b>
														<i class="fa fa-times"></i></b> {{__('messages.cancel')}}</a>

												@if(!empty($driver->id))
												<button type="submit" class="btn btn-success"><b>
														<i class="icon-note"></i></b> {{__('messages.update')}}</button>
												@else
													<button type="submit" class="btn btn-success"><b>
															<i class="icon-note"></i></b> {{__('messages.save')}}</button>
												@endif
											</div>
										</div>


								</form>
				</div>

			</div>
		</div>
	</div>
@endsection
