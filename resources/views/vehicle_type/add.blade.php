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
								<h4 class="card-title">{{__('messages.add_vehicle_type')}}</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter"><a href="{{ route('vehicle-type.index') }}" class="btn btn-info ml-2 mt-2">{{__('messages.vehicle_type_list')}}
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>

				<div class="card-content mt-1">
						<form method="post" action="{{ route('vehicle-type.store') }}">
						@csrf
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
															<label for="projectinput1">{{__('messages.vehicle_type_name')}}</label>

															<input type="text" name="name"  class="{{($errors->has('name')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle_types->name))?$vehicle_types->name:old('name') }}">
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
								<a href="{{route('vehicle-type.index')}}" class="btn btn-danger mr-1"><b>
										<i class="icon-trash"></i></b> {{__('messages.cancel')}}</a>
							<button type="submit" class="btn btn-success"><b>
									<i class="icon-note"></i></b> {{__('messages.save')}}</button>
						</div>
							</div>
						</div>

					</form>
				</div>

			</div>
		</div>
	</div>
@endsection
