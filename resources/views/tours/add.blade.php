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
								<h4 class="card-title">Tour Details</h4>
							</div>
						</div>
						<div class="col-sm-6 col-md-4 text-right">
							<div class="dataTables_filter"><a href="{{ route('tours.index') }}" class="btn btn-info ml-2 mt-2">Tours List
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>
					</div>
					<div class="row"><div class="col-12">@include('layouts.errors')</div></div>

				</div>

				<div class="card-content mt-1">
					<form method="post" action="{{ route('tours.store') }} "  enctype="multipart/form-data" id="tourForm">
						@csrf
						<input type="hidden" name="temp_key" value="{{ $randomKey }}">

						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="px-3">
											<div class="form-body">
												<div class="row">
													<div class="col-md-2">
														<div class="form-group">
															<label for="projectinput3">Status</label>
															<select name="status" class="form-control">
																@foreach($tour_statuses as $status)
																	<option value="{{ $status->id  }}">{{ $status->name }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="customSelect">Customer</label>
															{!!Form::select('customer_id', $customers, 'Select', ['class' => 'form-control'])!!}
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Vehicle</label>
															<select name="vehicle_id" class="form-control">
																@foreach($vehicles as $vehicle)
																	<option value="{{ $vehicle->id  }}">{{
																	$vehicle->name.' - '.$vehicle->make.' - '.$vehicle->year.' - '.
																	$vehicle->licensePlate.' - '.$vehicle->transmission
																	 }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="issueinput3">From</label>
															<input type="datetime-local" name="from_date" id="from_date"
																   class="form-control"
																   data-toggle="tooltip"
																   data-trigger="hover"
																   data-placement="top"
																   data-title="Date Opened">
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label for="issueinput3">To</label>
															<input type="datetime-local" name="to_date" id="to_date"
																   class="form-control"
																   data-toggle="tooltip"
																   data-trigger="hover"
																   data-placement="top"
																   data-title="Date Opened">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="customSelect">Driver</label>
															{!!Form::select('driver_id', $drivers, '', ['class' => 'form-control'])!!}
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3"># of Passengers</label>
															<input type="number" name="passengers" class="form-control" value="{{ (!empty($tour->passengers))?$tour->passengers:old('passengers') }}" >
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3">Guide Name</label>
															<input type="text" name="guide" class="form-control" value="{{ (!empty($tour->guide))?$tour->guide:old('guide') }}" >
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3">Price</label>
															<input type="number" name="price" class="form-control" value="{{ (!empty($tour->price))?$tour->price:old('price') }}" >
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
					<div class="col-md-12">
						<div class="col-md-6 text-left">
							<div class="form-actions">
								<a href="{{route('drivers.index')}}" class="btn btn-danger mr-1"><b>
										<i class="icon-trash"></i></b> Cancel</a>
								<button type="button" onclick="$('#tourForm').submit()" class="btn btn-success"><b>
										<i class="icon-note"></i></b> Save</button>
								<button type="button" class="btn btn-info">
									<i class="icon-note"></i> Save & add another
								</button>
							</div>
						</div>
						<div class="col-md-6 text-right">
								@include('layouts.upload_files')
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection
@section('pagejs')
	<script>
		// Start jQuery stuff
		$(function() {
			// Call Dropzone manually
			$(".dropzone").dropzone({
				paramName: "file",
				maxFilesize: 8, // MB
				queuecomplete: function() {
					// Some more jQuery stuff inside Dropzone's callback
					// $("#some_id").somejQueryMethod();

					console.log('++');
				}
			});
		});
	</script>
@endsection