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
								<h4 class="card-title">Edit Vehicle Type</h4>
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
					<form method="post" action="{{ route('vehicle-type.update', $vehicleType->id) }}">
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
															<label for="projectinput1">Vehicle Type Name</label>
															{{Form::text("name",
  													           old("name") ? old("name") : (!empty($vehicleType->name) ? $vehicleType->name : null),
             													[
												                "class" => "form-control",
                												"placeholder" => "name",
            													 ])
															 }}
														</div>
													</div>

												</div>

												<div class="row">
													<div class="col-md-12 text-center">
														<div class="form-actions">
															<a href="{{route('vehicle-type.index')}}" class="btn btn-danger mr-1">
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