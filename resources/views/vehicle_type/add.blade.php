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
								<h4 class="card-title">{{ (!empty($vehicleType->id))?__('vehicle_type.heading.edit'):__('vehicle_type.heading.add') }}</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter"><a href="{{ route('vehicle-type.index') }}"
															  class="btn btn-info ml-2 mt-2">{{__('vehicle_type.heading.index')}} <i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>

				<div class="card-content mt-1">

					@if(!empty($vehicleType->id))
						<form class="form" method="POST" action="{{ route('vehicle-type.update',$vehicleType->id) }}"
							  id="theForm">
							@method('PUT')
							<input type="hidden" id="id" name="id" value="{{ $vehicleType->id }}">
							@else
								<form class="form" method="POST" action="{{ route('vehicle-type.store') }}" id="theForm">
									@endif


									@csrf
									<input type="hidden" id="returnFlag" name="returnFlag" value="">

									<div class="uper">
										@if(session()->get('success'))
											<div class="alert alert-success">
												{{ session()->get('success') }}
											</div><br />
										@endif
										<div class="row">

											<div class="col-md-8">
												<div class="card">

													<div class="card-body">
														<div class="px-3">

															<div class="form-body">
																<div class="row">

																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="projectinput1">{{__('vehicle_type.name')}}
																				<span class="{{($errors->has('name')) ?'errorStar':''}}">*</span>
																			</label>

																			<input type="text" name="name"
																				   class="{{($errors->has('name')) ?'form-control error_input':'form-control'}}"
																				   value="{{ (!empty($vehicleType->name))?$vehicleType->name:old('name') }}">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12 text-left">
											<div class="form-actions">
												<a href="{{ route('vehicle-type.index') }}" class="btn btn-danger mr-1">
													<i class="fa fa-times"></i> {{__('messages.cancel')}}
												</a>

												@if(!empty($vehicleType->id))
													<button  type="submit" class="btn btn-success">
														<i class="icon-note"></i> {{__('messages.update')}}
													</button>
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
