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
															@if(count($customers) >= 1 && count($vehicles) >= 1 && count($drivers) >= 1)
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="projectinput3">Status</label>
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
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="customSelect">{{__('tour.customer')}}</label>
																		<select name="customer_id" class="{{($errors->has('customer_id')) ?'form-control error_input':'form-control'}}">
																			<option value="">{{__('tour.select_customer')}}</option>
																			@foreach($customers as $customer)
																				<option value="{{ $customer->id  }}"
																				@if(!empty($tour->customer_id) && $tour->customer_id==$customer->id || old('customer_id') == $customer->id)
																					{{ 'Selected' }}
																						@endif
																				>{{ $customer->name }}</option>
																			@endforeach
																		</select>

																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label>{{__('tour.vehicle')}}</label>
																		<select name="vehicle_id" class="form-control" onchange="getVehicleSeats(this.value);">
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
																		<label for="fromDate">{{__('tour.from')}}</label>
																		<div class='input-group date'>
																			<input type='text' name="from_date" autocomplete="off"
																				   class="{{($errors->has('from_date')) ?'form-control error_input':'form-control'}} datetimepicker1"
																				   value="{{ (!empty($tour->from_date))?date('m/d/Y h:i A',strtotime($tour->from_date)):old('from_date') }}"
																			/>
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="toDate">{{__('tour.to')}}</label>
																		<div class='input-group date'>
																			<input type='text' name="to_date" autocomplete="off"
																				   class="{{($errors->has('to_date')) ?'form-control error_input':'form-control'}} datetimepicker2"
																				   value="{{ (!empty($tour->to_date))?date('m/d/Y h:i A',strtotime($tour->to_date)):old('to_date') }}"
																			/>
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="customSelect">{{__('tour.driver')}}</label>
																		<select name="driver_id" class="{{($errors->has('driver_id')) ?'form-control error_input':'form-control'}}">
																			<option value="">{{__('tour.select_one')}}</option>
																			@foreach($drivers as $driver)
																				<option value="{{ $driver->id  }}"
																				@if(!empty($tour->driver_id) && $tour->driver_id==$driver->id || old('driver_id') == $driver->id)
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
																		<label for="projectinput3"># {{__('tour.passengers')}}</label>
																		<input type="number" name="passengers" id="passengers"

																			   onkeyup='if(!passengersCheck(this.value)) this.value="";'
																			   class="form-control"
																			   value="{{ (!empty($tour->passengers))?$tour->passengers:old('passengers') }}" >
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="projectinput3">{{__('tour.guide')}}</label>
																		<input type="text" name="guide"
																			   class="{{($errors->has('guide')) ?'form-control error_input':'form-control'}}"
																			   value="{{ (!empty($tour->guide))?$tour->guide:old('guide') }}" >
																	</div>
																</div>

																<div class="col-md-4">
																	<div class="form-group">
																		<label for="projectinput3">{{__('tour.price')}}</label>
																		<input type="number" name="price"
																			   class="{{($errors->has('price')) ?'form-control error_input':'form-control'}}"
																			   value="{{ (!empty($tour->price))?$tour->price:old('price') }}" >
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


								@if(!empty($attachments))
									<div class="col-sm-12"><h5>{{__('tour.attachments')}}:</h5></div>
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

			@else
				<div class="row">
					<div class="col-lg-12">
						<div class="alert alert-danger" style="color: #454545 !important">
							{{__('messages.add_tour_msg')}}
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
	<input type="hidden" id="seatsAllowed" value="">
@endsection
@section('pagejs')
	@include('tours.img_view')

	<script type="text/javascript">
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