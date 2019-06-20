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
																		<select name="status" class="{{($errors->has('status')) ?'form-control error_input':'form-control'}}"

																		>
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
																		<select name="vehicle_id" class="form-control" onchange="getVehicleSeats(this.value);">
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
																		<label for="fromDate">From Date</label>

																		<div class='input-group date'>
																			<input type='text' name="from_date"
																				   class="{{($errors->has('from_date')) ?'form-control error_input':'form-control'}} datetimepicker1"
																				   value="{{ (!empty($tour->from_date))?$tour->from_date:old('from_date') }}"
																			/>
																		</div>


																	</div>
																</div>
																<div class="col-md-3">
																	<div class="form-group">
																		<label for="toDate">To Date</label>

																		<div class='input-group date'>
																			<input type='text' name="to_date"
																				   class="{{($errors->has('to_date')) ?'form-control error_input':'form-control'}} datetimepicker2"
																				   value="{{ (!empty($tour->to_date))?$tour->to_date:old('to_date') }}"
																			/>
																		</div>


																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="customSelect">Driver</label>
																		<select name="driver_id" class="form-control">
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
																		<input type="number" name="passengers" id="passengers"

																			   onkeyup='if(!passengersCheck(this.value)) this.value="";'
																			   class="form-control"
																			   value="{{ (!empty($tour->passengers))?$tour->passengers:old('passengers') }}" >
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



								@if(!empty($attachments))
									<div class="col-sm-12"><h5>Attachments:</h5></div>
									<div class="row">
										<div class="col-lg-12">
											<ul class="upload-list">
												@foreach($attachments as $attachment)
													@php $ext = explode('.',$attachment->file); $ext = strtolower($ext[count($ext)-1]); @endphp
													@if(in_array($ext,['png','jpg','jpeg','gif']))
														<li>
															<a href="javascript:;" onclick="showImg('{{ url('/attachments/'.$attachment->file) }}')" >
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
	<input type="hidden" id="seatsAllowed" value="">
@endsection
@section('pagejs')
	@include('tours.img_view')

	<script type="text/javascript">
		function passengersCheck(){

			const passengers = $('#passengers').val();
			const seatsAllowed = $('#seatsAllowed').val();

			if(passengers>0 && passengers <= seatsAllowed)
				return true;
			else
				return false;
		}
		function getVehicleSeats(id){

			// console.log(id);
			$.ajax({
				url: "{{ url('/vehicles') }}/" + id,
				cache: false,
				success: function (v) {

					$('#seatsAllowed').val(v.seats);
					console.log(v.seats);
				}
			});
		}
		function showImg(url){

			$('#imgDiv').html('<img src="'+url+'" style="display:block; width: 100%; height:auto;">');
			$('#viewModel').modal('show');
		}
		// Start jQuery stuff
		$(function() {

			/* DateTime Picker */
			$('.datetimepicker1').datetimepicker();
			$('.datetimepicker2').datetimepicker({
				useCurrent: false //Important! See issue #1075
			});
			$(".datetimepicker1").on("dp.change", function (e) {
				$('.datetimepicker2').data("DateTimePicker").minDate(e.date);
			});
			$(".datetimepicker2").on("dp.change", function (e) {
				$('.datetimepicker1').data("DateTimePicker").maxDate(e.date);
			});
		});
	</script>
@endsection