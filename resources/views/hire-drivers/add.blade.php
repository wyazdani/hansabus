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
								<h4 class="card-title">{{ (!empty($hire->id))?__('hire.heading.edit'):__('hire.heading.add') }}</h4>
							</div>
						</div>
						<div class="col-sm-6 col-md-4 text-right">
							<div class="dataTables_filter"><a href="{{ route('hire-drivers.index') }}" class="btn btn-info ml-2 mt-2">{{__('hire.heading.index')}}
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-content mt-1">
					@if(!empty($hire->id))
						<form class="form" method="POST" action="{{ route('hire-drivers.update',$hire->id) }}" id="tourForm" enctype="multipart/form-data" >
							@method('PUT')
							<input type="hidden" id="id" name="id" value="{{ $hire->id }}">
							@else
								<form class="form" method="POST" action="{{ route('hire-drivers.store') }}" id="tourForm" enctype="multipart/form-data" >
									@endif


									@csrf
									<input type="hidden" name="temp_key" value="{{ $randomKey }}">
									@if(!empty($attachments))
										@foreach($attachments as $attachment)
											<input type="hidden" name="old_attachments[]" value="{{ $attachment->file }}">
										@endforeach
									@endif

									<input type="hidden" id="returnFlag" name="returnFlag" value="">

									<div class="row">
										<div class="col-md-12">
											<div class="card">
												<div class="card-body">
													<div class="px-3">
														<div class="form-body">
															<div class="row">
																<div class="col-md-3">
																	<div class="form-group">
																		<label for="projectinput3">Status <span class="{{($errors->has('status')) ?'errorStar':''}}">*</span></label>
																		<select name="status" class="{{($errors->has('status')) ?'form-control error_input':'form-control'}}"

																		>
																			<option value="">{{__('hire.select_status')}}</option>
																			@foreach($tour_statuses as $status)
																				<option value="{{ $status->id  }}"
																				@if(!empty($hire->status) && $hire->status==$status->id || old('status') == $status->id)
																					{{ 'Selected' }}
																						@endif
																				>{{ $status->name }}</option>
																			@endforeach
																		</select>
																	</div>
																</div>

																<div class="col-md-3">
																	<div class="form-group">
																		<label for="fromDate">{{__('tour.from')}} <span class="{{($errors->has('from_date')) ?'errorStar':''}}">*</span></label>
																		<div class='input-group date'>
																			<input type='text' name="from_date" autocomplete="off"
																				   class="{{($errors->has('from_date')) ?'form-control error_input':'form-control'}} datetimepicker1"
																				   value="{{ (!empty($hire->from_date))?date('d.m.Y H:i',strtotime($hire->from_date)):old('from_date') }}"
																			/>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="form-group">
																		<label for="toDate">{{__('tour.to')}} <span class="{{($errors->has('to_date')) ?'errorStar':''}}">*</span></label>
																		<div class='input-group date'>
																			<input type='text' name="to_date" autocomplete="off"
																				   class="{{($errors->has('to_date')) ?'form-control error_input':'form-control'}} datetimepicker2"
																				   value="{{ (!empty($hire->to_date))?date('d.m.Y H:i',strtotime($hire->to_date)):old('to_date') }}"
																			/>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="form-group">
																		<label for="projectinput3">{{__('tour.price')}} <span class="{{($errors->has('price')) ?'errorStar':''}}">*</span></label>
																		<input type="text" name="price"
																			   class="{{($errors->has('price')) ?'form-control error_input has_numeric':'form-control has_numeric'}}"
																			   value="{{ (!empty($hire->price))?$hire->price:old('price') }}" >
																	</div>
																</div>


																<div class="col-md-4">
																	<div class="form-group">
																		<label for="customSelect">{{__('tour.customer')}}<span class="{{($errors->has('customer_id')) ?'errorStar':''}}">*</span></label>

																		<span style="float: right"><a href="javascriot:;" onclick="addCustomer()">{{strtolower(__('customer.heading.add'))}}</a></span>
																		<select name="customer_id" id="customer_id" class="{{($errors->has('customer_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control'}}" data-live-search="true">
																			{{--<option value="">{{__('tour.select_customer')}}</option>
																			@foreach($customers as $customer)
																				<option value="{!! $customer->id !!}" @if(!empty($hire->customer_id) && $hire->customer_id==$customer->id ||
																					old('customer_id')==$customer->id) selected @endif>{!! $customer->name !!}</option>
																			@endforeach--}}
																		</select>
																		{{--<input type='text' name="customer_search" id="customer_search"
																			   @if(!empty($hire->customer->name))
																			   value="{{ old('customer_search',$hire->customer->name) }}"
																			   @else value="{{ old('customer_search','') }}" @endif
																			   class="{{($errors->has('customer_id')) ?'form-control error_input':'form-control'}}">
																		<input type="hidden" id="customer_id" name="customer_id"
																			   @if(!empty($hire->customer_id))
																			   value="{{ old('customer_id',$hire->customer_id) }}"
																			   @else value="{{ old('customer_id','') }}" @endif
																		>--}}

																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="customSelect">{{__('tour.driver')}}<span class="{{($errors->has('driver_id')) ?'errorStar':''}}">*</span></label>
																		<span style="float: right"><a href="javascriot:;" onclick="addDriver()">{{strtolower(__('driver.heading.add'))}}</a></span>
																		<select name="driver_id" id="driver_id" class="{{($errors->has('driver_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control'}}" data-live-search="true">
																			{{--<option value="">{{__('tour.select_driver')}}</option>
																			@foreach($drivers as $driver)
																				<option value="{!! $driver->id !!}" @if(!empty($hire->driver_id) && $hire->driver_id==$driver->id ||
																					old('driver_id')==$driver->id) selected @endif>{!! $driver->driver_name !!}</option>
																			@endforeach--}}
																		</select>
																		{{--<input type='text' name="driver_search" id="driver_search"
																			   @if(!empty($hire->driver->driver_name))
																			   value="{{ old('driver_search',$hire->driver->driver_name) }}"
																			   @else value="{{ old('driver_search','') }}" @endif
																			   class="{{($errors->has('driver_id')) ?'form-control error_input':'form-control'}}">
																		<input type="hidden" id="driver_id" name="driver_id"
																			   @if(!empty($hire->driver_id))
																			   value="{{ old('driver_id',$hire->driver_id) }}"
																			   @else value="{{ old('driver_id','') }}" @endif
																		>--}}
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="projectinput3">{{__('tour.select_color')}}<span class="{{($errors->has('color')) ?'errorStar':''}}">*</span></label>
																		<select name="color" class="{{($errors->has('color')) ?'form-control error_input':'form-control'}}">
																			<option value="">{{__('tour.select_color')}}</option>
																			<option value="#04b1cc" @if(!empty($hire) && $hire->color=="#04b1cc" || old('color') == "#04b1cc") selected @endif>{{__('tour.colors.blue')}}</option>
																			<option value="#00731f" @if(!empty($hire) && $hire->color=="#00731f" || old('color') == "#00731f") selected @endif>{{__('tour.colors.dark_green')}}</option>
																			<option value="#d6c809" @if(!empty($hire) && $hire->color=="#d6c809" || old('color') == "#d6c809") selected @endif>{{__('tour.colors.yellow')}}</option>
																			<option value="#db7107" @if(!empty($hire) && $hire->color=="#db7107" || old('color') == "#db7107") selected @endif>{{__('tour.colors.orange')}}</option>
																			<option value="#ff1408" @if(!empty($hire) && $hire->color=="#ff1408" || old('color') == "#ff1408") selected @endif>{{__('tour.colors.red')}}</option>
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
								<div class="col-sm-12"><h5>{{__('tour.attachments')}}:</h5></div>
								@if(!empty($attachments))
									<div class="row">
										<div class="col-lg-12">
											<ul class="upload-list">
												@foreach($attachments as $attachment)
													@php $ext = explode('.',$attachment->file); $ext = strtolower($ext[count($ext)-1]); @endphp
													@if(in_array($ext,['png','jpg','jpeg','gif']))
														<li><a href="javascript:;" onclick="showImg('{{ url('/attachments/'.$attachment->file) }}')" ><img
																		src="{{ url('/attachments/'.$attachment->file) }}" border="0">
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
						<a href="{{route('hire-drivers.index')}}" class="btn btn-danger mr-1"><b>
								<i class="fa fa-times"></i></b> {{__('messages.cancel')}}</a>

						@if(!empty($hire->id))
							<button type="button" onclick="$('#tourForm').submit()" class="btn btn-success"><b>
									<i class="icon-note"></i></b> {{__('messages.update')}}</button>
						@else

							<button type="button" onclick="$('#tourForm').submit()" class="btn btn-success"><b>
									<i class="icon-note"></i></b> {{__('messages.save')}}</button>
{{--							<button type="button" onclick="$('#returnFlag').val('1'); $('#tourForm').submit()"  class="btn btn-info">--}}
{{--								<i class="icon-note"></i> {{__('messages.save_add_another')}}--}}
{{--							</button>--}}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="seatsAllowed" value="">
@endsection
@section('pagejs')
	@include('tours.img_view')
	@include('customer.add_popup')
	@include('drivers.add_popup')
	<script type="text/javascript">
		$(document).ready(function () {
			loadCustomers();
			loadDrivers();
		});
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
					@if(!empty($hire))
							customer_id = '{!! $hire->customer_id !!}';

					@elseif(old('customer_id') &&  old('customer_id')!="foo")
							customer_id = '{!! old('customer_id') !!}';
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
					@if(!empty($hire))
							driver_id = '{!! $hire->driver_id !!}';

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
		function passengersCheck(){

			const passengers = parseInt($('#passengers').val());
			const seatsAllowed = parseInt($('#seatsAllowed').val());
			if(passengers !='' && passengers>0 && passengers <= seatsAllowed){

				console.log('passengers count is fine.');
				return true;
			}else{
				console.log('vehicle overloaded.');
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
					console.log('seats allowed: '+v.seats);
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