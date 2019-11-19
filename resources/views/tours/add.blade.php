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
																	<div class="col-md-3">
																		<div class="form-group">
																			<label>{{__('tour.custom_tour_id')}}<span class="{{($errors->has('custom_tour_id')) ?'errorStar':''}}"></span></label>
																			<input type="text" name="custom_tour_id"
																				   class="{{($errors->has('custom_tour_id')) ?'form-control error_input ':'form-control '}}"
																				   value="{{ (!empty($tour->custom_tour_id))?$tour->custom_tour_id:old('custom_tour_id') }}">
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="form-group">
																			<label>{{__('tour.vehicle')}}<span class="{{($errors->has('vehicle_id')) ?'errorStar':''}}">*</span></label>
																			{{--<select name="vehicle_id" class="{{($errors->has('vehicle_id')) ?'form-control error_input':'form-control'}}" onchange="getVehicleSeats(this.value);">
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
																			</select>--}}
																			<select name="vehicle_id" id="vehicle_id" class="{{($errors->has('vehicle_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control'}}" data-live-search="true" onchange="getVehicleSeats(this.value);">
																				<option value="foo">{{__('tour.select_vehicle')}}</option>
																				@foreach($vehicles as $vehicle)
																					<option value="{!! $vehicle->id !!}" @if(!empty($tour->vehicle_id) && $tour->vehicle_id==$vehicle->id ||
																					old('vehicle_id')==$vehicle->id) selected @endif>{{
																	$vehicle->name.' - '.$vehicle->make.' - '.$vehicle->year.' - '.
																	$vehicle->licensePlate.' - '.$vehicle->transmission
																	 }}</option>
																				@endforeach
																			</select>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="form-group">
																			<label for="customSelect">{{__('tour.customer')}}<span class="{{($errors->has('customer_id')) ?'errorStar':''}}">*</span></label>

																			<span style="float: right"><a href="javascriot:;" onclick="addCustomer()">{{strtolower(__('customer.heading.add'))}}</a></span>
																			<select name="customer_id" id="customer_id" class="{{($errors->has('customer_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control'}}" data-live-search="true" onclick="loadCustomers()">
																					{{--<option value="">{{__('tour.select_customer')}}</option>
																					@foreach($customers as $customer)
																					<option value="{!! $customer->id !!}" @if(!empty($tour->customer_id) && $tour->customer_id==$customer->id ||
																					old('customer_id')==$customer->id) selected @endif>{!! $customer->name !!}</option>
																					@endforeach--}}
																			</select>
																			{{--<input type='text' name="customer_search" id="customer_search"
																				   @if(!empty($tour->customer->name))
																				   		value="{{ old('customer_search',$tour->customer->name) }}"
																					@else value="{{ old('customer_search','') }}" @endif
																				   class="{{($errors->has('customer_id')) ?'form-control error_input':'form-control'}}">
																			<input type="hidden" id="customer_id" name="customer_id"
																				   @if(!empty($tour->customer_id))
																				   value="{{ old('customer_id',$tour->customer_id) }}"
																				   @else value="{{ old('customer_id','') }}" @endif
																				   >--}}
																		</div>
																	</div>
																	<input type="hidden" id="returnFlag" name="returnFlag" value="">
																	<div class="col-md-3">
																		<div class="form-group">
																			<label for="customSelect">{{__('tour.driver')}}<span class="{{($errors->has('driver_id')) ?'errorStar':''}}"></span></label>

																			<span style="float: right"><a href="javascriot:;" onclick="addDriver()">{{strtolower(__('driver.heading.add'))}}</a></span>
																			<select name="driver_id" id="driver_id" class="{{($errors->has('driver_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control'}}" data-live-search="true">
																				{{--<option value="">{{__('tour.select_driver')}}</option>
																				@foreach($drivers as $driver)
																					<option value="{!! $driver->id !!}" @if(!empty($tour->driver_id) && $tour->driver_id==$driver->id ||
																					old('driver_id')==$driver->id) selected @endif>{!! $driver->driver_name !!}</option>
																				@endforeach--}}
																			</select>
																			{{--<input type='text' name="driver_search" id="driver_search"
																				   @if(!empty($tour->driver->driver_name))
																				   value="{{ old('driver_search',$tour->driver->driver_name) }}"
																				   @else value="{{ old('driver_search','') }}" @endif
																				   class="{{($errors->has('driver_id')) ?'form-control error_input':'form-control'}}">
																			<input type="hidden" id="driver_id" name="driver_id"
																				   @if(!empty($tour->driver_id))
																				   value="{{ old('driver_id',$tour->driver_id) }}"
																				   @else value="{{ old('driver_id','') }}" @endif
																			>--}}
																		</div>
																	</div>

																	<div class="col-md-3">
																		<div class="form-group">
																			<label for="projectinput3"># {{__('tour.passengers')}}<span class="{{($errors->has('passengers')) ?'errorStar':''}}"></span></label>
																			<input type="number" name="passengers" id="passengers"
																				   onkeyup='if(!passengersCheck(this.value)) this.value="";'
																				   onchange='if(!passengersCheck(this.value)) this.value="";'
																				   class="{{($errors->has('passengers')) ?'error_input form-control':'form-control'}}"
																				   value="{{ (!empty($tour->passengers))?$tour->passengers:old('passengers') }}" >
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="form-group">
																			<label for="projectinput3">{{__('tour.guide')}}</label>
																			<input type="text" name="guide"
																				   class="{{($errors->has('guide')) ?'form-control error_input':'form-control'}}"
																				   value="{{ (!empty($tour->guide))?$tour->guide:old('guide') }}" >
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="form-group">
																			<label for="projectinput3">{{__('tour.price')}}<span class="{{($errors->has('price')) ?'errorStar':''}}">*</span></label>
																			<input type="text" name="price"
																				   class="{{($errors->has('price')) ?'form-control error_input has_numeric':'form-control has_numeric'}}"
																				   value="{{ (!empty($tour->price))?$tour->price:old('price') }}" maxlength="10">
																		</div>
																	</div>
																	<div class="col-md-3">
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
															<div class="row">
																<div class="col-md-6">
																	<label for="projectinput3">{{__('tour.from_address')}}<span class="{{($errors->has('status')) ?'errorStar':''}}">*</span></label>
																	@if($request->from_address)
																	<input type="text" id="from_address1" name="from_address"
																		   class="{{($errors->has('from_address')) ?'form-control error_input' :'form-control '}}"
																		   value="{{ (!empty($request->from_address))?$request->from_address:old('from_address') }}">
																		@else
																		<input type="text" id="from_address" name="from_address"
																			   class="{{($errors->has('from_address')) ?'form-control error_input' :'form-control '}}"
																			   value="{{ (!empty($tour->from_address))?$tour->from_address:old('from_address') }}">
																		@endif
																</div>
																<div class="col-md-6">
																	<label for="projectinput3">{{__('tour.to_address')}}<span class="{{($errors->has('status')) ?'errorStar':''}}">*</span></label>
																	@if($request->to_address)
																	<input type="text" id="to_address1" name="to_address"
																		   class="{{($errors->has('to_address')) ?'form-control error_input' :'form-control '}}"
																		   value="{{ (!empty($request->to_address))?$request->to_address:old('to_address') }}">
																		@else
																		<input type="text" id="to_address"  name="to_address"
																			   class="{{($errors->has('to_address')) ?'form-control error_input' :'form-control '}}"
																			   value="{{ (!empty($tour->to_address))?$tour->to_address:old('to_address') }}">
																		@endif

																</div>
															</div>
															<input type="hidden" name="offer_id" value="{!! $request->offer_id !!}">
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label>{{__('offer.one_way/two_way')}}</label>
																		<div class="form-group">
																			<div class="display-inline-block">
																				<label class="switch">
																					<input type="checkbox" name="trip_type" id="trip_type" @if($request->time1) checked @elseif(!empty($tour->to_date)) checked @endif>
																					<span class="slider round"></span>
																				</label>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="form-group">
																		<label for="fromDate">{{__('offer.departure_time')}}<span class="{{($errors->has('from_date')) ?'errorStar':''}}">*</span></label>
																		<div class='input-group date'>
																			@if($request->time)
																				<input type='text' id="from_date" name="from_date" autocomplete="off"
																					   class="{{($errors->has('from_date')) ?'form-control error_input':'form-control'}} datetimepicker1"
																					   value="{{ (!empty($request->time))?date('d.m.Y H:i',strtotime($request->time)):old('from_date') }}"
																				>
																			@else
																				<input type='text' id="from_date" name="from_date" autocomplete="off"
																					   class="{{($errors->has('from_date')) ?'form-control error_input':'form-control'}} datetimepicker1"
																					   value="{{ (!empty($tour->from_date))?date('d.m.Y H:i',strtotime($tour->from_date)):old('from_date') }}"
																				>
																			@endif

																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="form-group">
																		<label for="toDate">{{__('offer.arrival_time')}}<span class="{{($errors->has('to_date')) ?'errorStar':''}}">*</span></label>
																		<div class='input-group date'>
																			@if($request->time1)
																				<input type='text' id="to_date" name="to_date" autocomplete="off"
																					   class="{{($errors->has('to_date')) ?'form-control error_input':'form-control'}} datetimepicker2"
																					   value="{{ (!empty($request->time1))?date('d.m.Y H:i',strtotime($request->time1)):old('to_date') }}"
																				>
																			@else
																				<input type='text' id="to_date" name="to_date" autocomplete="off"
																					   class="{{($errors->has('to_date')) ?'form-control error_input':'form-control'}} datetimepicker2"
																					   value="{{ (!empty($tour->to_date))?date('d.m.Y H:i',strtotime($tour->to_date)):old('to_date') }}"
																				>
																			@endif
																		</div>
																	</div>
																</div>
															</div>


<input type="hidden" value="{!! $request->is_offer !!}" name="is_offer">
															<div class="form-group">
																<label for="projectinput8">{{__('tour.description')}}<span class="{{($errors->has('description')) ?'errorStar':''}}"></span></label>
																@if($request->description)
																<textarea name="description" rows="3"  class="{{($errors->has('description')) ?'form-control error_input':'form-control'}}" >{!! !empty($request->description)?$request->description:old('description') !!}
																			</textarea>
																	@else
																	<textarea name="description" rows="3"  class="{{($errors->has('description')) ?'form-control error_input':'form-control'}}" >{!! !empty($tour->description)?$tour->description:old('description') !!}
																			</textarea>
																	@endif
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
							<button type="button" onclick="$('#returnFlag').val('1'); $('#tourForm').submit()"  class="btn btn-info">
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
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrPi8W87YGBfBsNwR6KytqCD_y5N3r5Zs&libraries=places&callback=initAutocomplete" async defer></script>
	<script type="text/javascript">
		function initAutocomplete() {
			var data_input  =   ['from_address','to_address','from_address1','to_address1'];
			for (var i=0;i<data_input.length;i++){
				var input_place     =   document.getElementById(data_input[i]);
				var autocomplete = new google.maps.places.Autocomplete(input_place);
				autocomplete.setFields([
					'address_components', 'geometry', 'icon', 'name'
				]);
			}
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function () {
			loadCustomers();
			loadDrivers();
			@if($request->time1)
			$("#to_date").prop('disabled', false);
			@elseif(!empty($tour->to_date))
			$("#to_date").prop('disabled', false);
			@else
			$("#to_date").prop('disabled', true);
			@endif
			$('body').on('change', '#trip_type', function () {
				if (this.checked){
					$("#to_date").prop('disabled', false);
				}else{
					$("#to_date").prop('disabled', true);
				}
			});
		});
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

					/*$('#passengers').addClass('error_input');*/
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
		function loadCustomers(){

			var customer_id		=	'';
			$.ajax({
				type: "get",
				url: "{{route('tour-get-fields')}}",
				success: function(result)
				{
					$('#customer_id').html("");

					if(result.customers.length > 0)
					{
						var option_selected	=	new Option("{{__('tour.select_customer')}}",'foo',true,true);

						$('#customer_id').append(option_selected);
						for(i=0 ; i<result.customers.length ; i++){
							var newOption = new Option(result.customers[i].name, result.customers[i].id, i==0, i==0);
							$('#customer_id').append(newOption);
						}

					}else
					{
						$('#customer_id').html("");
					}
					@if(!empty($tour))
							customer_id = '{!! $tour->customer_id !!}';

					@elseif(old('customer_id') &&  old('customer_id')!="foo")
							customer_id = '{!! old('customer_id') !!}';
                    @elseif($request->customer_id)
                        customer_id = '{!! $request->customer_id !!}';
					@else
							customer_id	=	'foo';
					@endif

					$('#customer_id').val(customer_id).trigger('change');


					$('.selectpicker').selectpicker('refresh');

				}
			});
		}
		function loadDrivers(){
			var driver_id		=	'';
			$.ajax({
				type: "get",
				url: "{{route('tour-get-fields')}}",
				success: function(result)
				{
					$('#driver_id').html("{{__('tour.select_driver')}}");

					if(result.drivers.length > 0)
					{
						var option_selected	=	new Option("{{__('tour.select_driver')}}",'foo',true,true);
						$('#driver_id').append(option_selected);
						for(i=0 ; i<result.drivers.length ; i++){
							var newOption = new Option(result.drivers[i].driver_name, result.drivers[i].id, i==0, i==0);
							$('#driver_id').append(newOption);
						}
					}else
					{
						$('#driver_id').html("{{__('tour.select_driver')}}");
					}
					@if(!empty($tour))
							driver_id = '{!! $tour->driver_id !!}';

					@elseif(old('driver_id') &&  old('driver_id')!="foo")
							driver_id = '{!! old('driver_id') !!}';
					@else
							driver_id	=	'foo';
					@endif
					$('#driver_id').val(driver_id).trigger('change');
					$('.selectpicker').selectpicker('refresh');

				}
			});
		}

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