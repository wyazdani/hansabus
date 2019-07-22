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
								<h4 class="card-title">{{ (!empty($tour->id))?__('tour.heading.edit'):__('tour.heading.add') }}</h4>
							</div>
						</div>
						<div class="col-sm-6 col-md-4 text-right">
							<div class="dataTables_filter"><a href="{{ route('tours.index') }}" class="btn btn-info ml-2 mt-2">{{__('tour.heading.index')}}
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>
					</div>
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

																	<div class="col-md-4">
																		<div class="form-group">
																			<label>{{__('tour.vehicle')}}<span class="{{($errors->has('vehicle_id')) ?'errorStar':''}}">*</span></label>
																			<select name="vehicle_id" class="{{($errors->has('vehicle_id')) ?'form-control error_input':'form-control'}}" onchange="getVehicleSeats(this.value);">
																				<option value="">{{__('tour.select_vehicle')}}</option>
																				@foreach($vehicles as $vehicle)
																					<option value="{{ $vehicle->id  }}"
																					@if(!empty($tour->vehicle_id) && $tour->vehicle_id==$vehicle->id || old('vehicle_id') == $vehicle->id)
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
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="customSelect">{{__('tour.customer')}}<span class="{{($errors->has('customer_id')) ?'errorStar':''}}">*</span></label>

																			<span style="float: right"><a href="javascriot:;" onclick="addCustomer()">{{strtolower(__('customer.heading.add'))}}</a></span>
																			<input type='text' name="customer_search" id="customer_search"
																				   @if(!empty($tour->customer->name))
																				   		value="{{ old('customer_search',$tour->customer->name) }}"
																					@else value="{{ old('customer_search','') }}" @endif
																				   class="{{($errors->has('customer_id')) ?'form-control error_input':'form-control'}}">
																			<input type="hidden" id="customer_id" name="customer_id"
																				   @if(!empty($tour->customer_id))
																				   value="{{ old('customer_id',$tour->customer_id) }}"
																				   @else value="{{ old('customer_id','') }}" @endif
																				   >
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="customSelect">{{__('tour.driver')}}<span class="{{($errors->has('driver_id')) ?'errorStar':''}}">*</span></label>
																			<span style="float: right"><a href="javascriot:;" onclick="addDriver()">{{strtolower(__('driver.heading.add'))}}</a></span>
																			<input type='text' name="driver_search" id="driver_search"
																				   @if(!empty($tour->driver->driver_name))
																				   value="{{ old('driver_search',$tour->driver->driver_name) }}"
																				   @else value="{{ old('driver_search','') }}" @endif
																				   class="{{($errors->has('driver_id')) ?'form-control error_input':'form-control'}}">
																			<input type="hidden" id="driver_id" name="driver_id"
																				   @if(!empty($tour->driver_id))
																				   value="{{ old('driver_id',$tour->driver_id) }}"
																				   @else value="{{ old('driver_id','') }}" @endif
																			>
																		</div>
																	</div>
																	<div class="col-md-2">
																		<div class="form-group">
																			<label for="fromDate">{{__('tour.from')}}<span class="{{($errors->has('from_date')) ?'errorStar':''}}">*</span></label>
																			<div class='input-group date'>
																				<input type='text' name="from_date" autocomplete="off"
																					   class="{{($errors->has('from_date')) ?'form-control error_input':'form-control'}} datetimepicker1"
																					   value="{{ (!empty($tour->from_date))?date('d.m.Y H:i',strtotime($tour->from_date)):old('from_date') }}"
																				/>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-2">
																		<div class="form-group">
																			<label for="toDate">{{__('tour.to')}}<span class="{{($errors->has('to_date')) ?'errorStar':''}}">*</span></label>
																			<div class='input-group date'>
																				<input type='text' name="to_date" autocomplete="off"
																					   class="{{($errors->has('to_date')) ?'form-control error_input':'form-control'}} datetimepicker2"
																					   value="{{ (!empty($tour->to_date))?date('d.m.Y H:i',strtotime($tour->to_date)):old('to_date') }}"
																				/>
																			</div>
																		</div>
																	</div>


																	<div class="col-md-2">
																		<div class="form-group">
																			<label for="projectinput3"># {{__('tour.passengers')}}<span class="{{($errors->has('passengers')) ?'errorStar':''}}">*</span></label>
																			<input type="number" name="passengers" id="passengers"
																				   onkeyup='if(!passengersCheck(this.value)) this.value="";'
																				   onchange='if(!passengersCheck(this.value)) this.value="";'
																				   class="{{($errors->has('passengers')) ?'error_input form-control':'form-control'}}"
																				   value="{{ (!empty($tour->passengers))?$tour->passengers:old('passengers') }}" >
																		</div>
																	</div>



																	<div class="col-md-2">
																		<div class="form-group">
																			<label for="projectinput3">{{__('tour.guide')}}</label>
																			<input type="text" name="guide"
																				   class="{{($errors->has('guide')) ?'form-control error_input':'form-control'}}"
																				   value="{{ (!empty($tour->guide))?$tour->guide:old('guide') }}" >
																		</div>
																	</div>
																	<div class="col-md-2">
																		<div class="form-group">
																			<label for="projectinput3">{{__('tour.price')}}<span class="{{($errors->has('price')) ?'errorStar':''}}">*</span></label>
																			<input type="number" name="price"
																				   class="{{($errors->has('price')) ?'form-control error_input':'form-control'}}"
																				   value="{{ (!empty($tour->price))?$tour->price:old('price') }}" >
																		</div>
																	</div>
																	<div class="col-md-2">
																		<div class="form-group">
																			<label for="projectinput3">Status<span class="{{($errors->has('status')) ?'errorStar':''}}">*</span></label>
																			<select name="status" class="{{($errors->has('status')) ?'form-control error_input':'form-control'}}"

																			>
																				<option value="">{{__('tour.select_status')}}</option>
																				@foreach($tour_statuses as $status)
																					<option value="{{ $status->id  }}"
																					@if(!empty($tour->status) && $tour->status==$status->id || old('status') == $status->id)
																						{{ 'Selected' }}
																							@endif
																					>{{ $status->name }}</option>
																				@endforeach
																			</select>
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
						</form>

						<div class="col-sm-12"><h5>{{__('tour.attachments')}}:</h5></div>
						@if(!empty($attachments))

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


											@if(in_array($ext,['PDF','pdf']))
												<div class="col-md-3 mb-2"><a href="{{ url('/attachments/'.$attachment->file) }}" target="_blank"><i
																class="fa fa-file-pdf-o fa-4x" aria-hidden="true"></i></a></div>
											@else
												<div class="col-md-3 mb-1"><a href="{{ url('/attachments/'.$attachment->file) }}" target="_blank">
														{{ $attachment->file }}</a></div>
											@endif

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
						<a href="{{ route('tours.index')}}" class="btn btn-danger mr-1"><b>
								<i class="fa fa-times"></i></b> {{__('messages.cancel')}}</a>

						@if(!empty($tour->id))
							<button type="button" onclick="$('#tourForm').submit()" class="btn btn-success"><b>
									<i class="icon-note"></i></b> {{__('messages.update')}}</button>
						@else

							<button type="button" onclick="$('#tourForm').submit()" class="btn btn-success"><b>
									<i class="icon-note"></i></b> {{__('messages.save')}}</button>
							<button type="button" onclick="$('#returnFlag').val('0'); $('#tourForm').submit()"  class="btn btn-info">
								<i class="icon-note"></i> {{__('messages.save_add_another')}}
							</button>
						@endif
					</div>
				</div>
			</div>

		</div>
	</div>
	<input type="hidden" id="seatsAllowed" value="{{(!empty($tour->vehicle->seats))?$tour->vehicle->seats:''}}">
	<div class='error' style='display:none'>I did something!</div>
@endsection
@section('pagejs')
	@include('tours.img_view')
	@include('customer.add_popup')
	@include('drivers.add_popup')
	<script type="text/javascript">
		function passengersCheck(){

			const passengers = parseInt($('#passengers').val());
			const seatsAllowed = parseInt($('#seatsAllowed').val());
			if(passengers !='' && passengers>0 && passengers <= seatsAllowed){

				// console.log('passengers count is fine.');
				$('#passengers').removeClass('error_input');
				return true;
			}else{
				// console.log('vehicle overloaded.');
				// $('.error').stop().fadeIn(400).delay(3000).fadeOut(400);

				if($('#seatsAllowed').val() !=''){

					$('#passengers').addClass('error_input');
					toastr.info( parseInt($('#seatsAllowed').val())+'{{__('tour.passengers_allowed')}}');
				}

				return false;
			}
		}
		function getVehicleSeats(id){

			// console.log(id);
			$.ajax({
				url: "{{ url('/vehicles') }}/" + id,
				cache: false,
				success: function (v) {

					$('#seatsAllowed').val(parseInt(v.seats));
					passengersCheck();
					// console.log('seats allowed: '+v.seats);
				}
			});
		}
		function showImg(url){

			$('#imgDiv').html('<img src="'+url+'" style="display:block; width: 100%; height:auto;">');
			$('#viewModel').modal('show');
		}
		// Start jQuery stuff
		$(function() {

			@if(!empty($tour->id))
			getVehicleSeats('{{ $tour->vehicle_id }}');
			@endif

			passengersCheck();
			/* DateTime Picker */
			$('.datetimepicker1').datetimepicker(
					{format:'DD.MM.YYYY HH:mm'}
			);
			$('.datetimepicker2').datetimepicker({
				format:'DD.MM.YYYY HH:mm',
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