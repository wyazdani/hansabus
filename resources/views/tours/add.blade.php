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
					{{--<div class="row"><div class="col-12">@include('layouts.errors')</div></div>--}}

				</div>

				<div class="card-content mt-1">


					@if(!empty($tour->id))
						<form class="form" method="POST" action="{{ route('tours.update',$tour->id) }}" id="tourForm" enctype="multipart/form-data" >
						@method('PUT')
							<input type="hidden" id="id" name="id" value="{{ $tour->id }}">
					@else
						<form class="form" method="POST" action="{{ route('tours.store') }}" id="tourForm" enctype="multipart/form-data" >
					@endif


					@csrf
					<input type="hidden" name="temp_key" value="{{ $randomKey }}">
					@if(!empty($attachments))
						@foreach($attachments as $attachment)
							<input type="hidden" name="old_attachments[]" value="{{ $attachment->file }}">
						@endforeach
					@endif


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
															<select name="status" class="{{($errors->has('status')) ?'form-control error_input':'form-control'}}">
																<option>Select Status</option>
																@foreach($tour_statuses as $status)
																	<option value="{{ $status->id  }}"
																	@if(!empty($tour->status) && $tour->status==$status->id)
																		{{ 'Selected' }}
																			@endif
																	>{{ $status->name }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="customSelect">Customer</label>
															<select name="customer_id" class="{{($errors->has('customer_id')) ?'form-control error_input':'form-control'}}">
																<option>Select Customer</option>
																@foreach($customers as $customer)
																	<option value="{{ $customer->id  }}"
																	@if(!empty($tour->customer_id) && $tour->customer_id==$customer->id)
																		{{ 'Selected' }}
																			@endif
																	>{{ $customer->name }}</option>
																@endforeach
															</select>

														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Vehicle</label>
															<select name="vehicle_id" class="{{($errors->has('vehicle_id')) ?'form-control error_input':'form-control'}}">
																<option>Select Vehicle</option>
																@foreach($vehicles as $vehicle)
																	<option value="{{ $vehicle->id  }}"
																	@if(!empty($tour->vehicle_id) && $tour->vehicle_id==$vehicle->id)
																		{{ 'Selected' }}
																			@endif
																	>{{
																	$vehicle->name.' - '.$vehicle->make.' - '.$vehicle->year.' - '.
																	$vehicle->licensePlate.' - '.$vehicle->transmission
																	 }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">


														<label for="issueinput3">From Date</label>
															<input type="datetime-local" name="from_date" id="from_date"
																   class="{{($errors->has('from_date')) ?'form-control error_input':'form-control'}}"
																   data-toggle="tooltip"
																   data-trigger="hover"
																   data-placement="top"
																   data-title="Date Opened"
																   value="{{ (!empty($tour->from_date))?$tour->from_date:old('from_date') }}" >
														</div>
													</div>
													<div class="col-md-3">
														<div id="to_date" class="input-group date" data-date-format="mm-dd-yyyy">
															<label for="issueinput3">To Date</label>
															<input type="datetime-local" name="to_date" id="to_date"
																   class="{{($errors->has('to_date')) ?'form-control error_input':'form-control'}}"
																   data-toggle="tooltip"
																   data-trigger="hover"
																   data-placement="top"
																   data-title="Date Opened"
																   value="{{ (!empty($tour->to_date))?$tour->to_date:old('to_date') }}" >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="customSelect">Driver</label>
															<select name="driver_id" class="{{($errors->has('driver_id')) ?'form-control error_input':'form-control'}}">
																<option>Select Driver</option>
																@foreach($drivers as $driver)
																	<option value="{{ $driver->id  }}"
																	@if(!empty($tour->driver_id) && $tour->driver_id==$driver->id)
																		{{ 'Selected' }}
																			@endif
																	>{{
																	$driver->driver_name
																	 }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3"># of Passengers</label>
															<input type="number" name="passengers" class="{{($errors->has('passengers')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($tour->passengers))?$tour->passengers:old('passengers') }}" >
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3">Guide Name</label>
															<input type="text" name="guide" class="{{($errors->has('passengers')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($tour->guide))?$tour->guide:old('guide') }}" >
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3">Price</label>
															<input type="number" name="price" class="{{($errors->has('price')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($tour->price))?$tour->price:old('price') }}" >
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



					@if(!empty($attachments))
							<div class="col-sm-12"><h5>Attachments:</h5></div>
							<div class="row">
							<div class="col-lg-12">
								<ul class="upload-list">
									@foreach($attachments as $attachment)
										@php $ext = explode('.',$attachment->file); $ext = strtolower($ext[count($ext)-1]); @endphp
										@if(in_array($ext,['png','jpg','jpeg','gif']))
											<li>
												<a href="{{ url('/attachments/'.$attachment->file) }}" target="_blank">
													<img src="{{ url('/attachments/'.$attachment->file) }}" border="0">
												</a>
											</li>
										@endif
									@endforeach
								</ul>
								@foreach($attachments as $attachment)
									@php $ext = explode('.',$attachment->file); $ext = strtolower($ext[count($ext)-1]); @endphp
									@if(!in_array($ext,['png','jpg','jpeg','gif']))
										<div class="col-md-3"><a href="{{ url('/attachments/'.$attachment->file) }}" target="_blank">
												{{ $attachment->file }}
											</a></div>
									@endif
								@endforeach
							</div>
						</div>
					@endif



				</div>
				<div class="row">
					<div class="col-md-12">
						@include('layouts.upload_files')
					</div>
				</div>

				<div class="col-md-12 text-left">
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
        $(function () {
            $("#to_date").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());
        });

	</script>
	<script type="text/css">
		label{margin-left: 20px;}
		#to_date{width:180px; margin: 0 20px 20px 20px;}
		#to_date > span:hover{cursor: pointer;}
	</script>
@endsection