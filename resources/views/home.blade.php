@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')

	<!--Statistics cards Starts-->

	<div class="row">
		<div class="col-xl-3 col-lg-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="px-3 py-3">
						<div class="media">
							<div class="media-body text-left align-self-center">
								<i class="fa fa-car info font-large-2 float-left"></i>

							</div>
							<div class="media-body text-right">
								<h3>{{ $totalVehicles }}</h3>
								<span><a href="{{ route('vehicles.index') }}" style="color: gray">{{ __('messages.vehicles') }}</a></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="px-3 py-3">
						<div class="media">
							<div class="media-body text-left align-self-center">
								<i class="icon-users warning font-large-2 float-left"></i>
							</div>
							<div class="media-body text-right">
								<h3>{{ $totalDrivers  }}</h3>
								<span><a href="{{ route('v-drivers.index') }}" style="color: gray">{{ __('messages.drivers') }}</a></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="px-3 py-3">
						<div class="media">
							<div class="media-body text-left align-self-center">
								<i class="fa fa-university success font-large-2 float-left"></i>
							</div>
							<div class="media-body text-right">
								<h3>{{ $totalCustomers  }}</h3>
								<span><a href="{{ route('customers.index') }}" style="color: gray">{{ __('messages.customers') }}</a></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="px-3 py-3">
						<div class="media">
							<div class="media-body text-left align-self-center">
								<i class="icon-settings danger font-large-2 float-left"></i>
							</div>
							<div class="media-body text-right">
								<h3>423</h3>
								<span>{{ __('messages.vehicle_maintenance') }}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Statistics cards Ends-->

	<div class="row match-height">

		<div class="col-sm-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="card-title-wrap bar-primary">
						<h4 class="card-title">{{ __('tour.recent_trips') }}</h4>
					</div>
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				</div>

				<div class="card-content mt-1">
					<div class="table-responsive">
						<table class="table table-hover table-xl mb-0" id="recent-orders">
							<thead>
							<tr>
								<th class="border-top-0" width="5%">Tour ID</th>
								<th class="border-top-0" width="15%">{{__('tour.customer')}}</th>
								<th class="border-top-0" width="15%">{{__('tour.vehicle')}}</th>
								<th class="border-top-0" width="12%">{{__('tour.from')}}</th>
								<th class="border-top-0" width="12%">{{__('tour.to')}}</th>
								<th class="border-top-0" width="15%">{{__('tour.driver')}}</th>
								<th class="border-top-0" width="8%">{{__('tour.passengers')}}</th>
								<th class="border-top-0" width="8%">{{__('tour.price')}}</th>
								<th class="border-top-0" width="8%">Status</th>
							</tr>
							</thead>
							<tbody>
							@foreach($recentTours as $tour)

								<tr>
									<td class="text-truncate"><a href="{{ route('tour-detail',$tour->id) }}">{!! $tour->id !!}</a></td>
									<td class="text-truncate">{!! !empty($tour->customer->name)?$tour->customer->name:'' !!}</td>
									<td class="text-truncate">{!! !empty($tour->vehicle->name)?$tour->vehicle->name:'' !!}</td>
									<td class="text-truncate">{!! $tour->from_date !!}</td>
									<td class="text-truncate">{!! $tour->to_date !!}</td>
									<td class="text-truncate">{!! !empty($tour->driver->driver_name)?$tour->driver->driver_name:'' !!}</td>
									<td class="text-truncate">{!! $tour->passengers !!}</td>
									<td class="text-truncate">{!! $tour->price !!}</td>
									<td class="text-truncate">
											@if($tour->status == 1) {{ 'Draft' }}
										@elseif($tour->status == 2) {{ 'Confirmed' }}
										@elseif($tour->status == 3) {{ 'Invoiced' }}
										@elseif($tour->status == 3) {{ 'Paid' }}
										@elseif($tour->status == 3) {{ 'Canceled' }}
										@endif
									</td>
								</tr>
							@endforeach
							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>


		<div class="col-sm-12">
			<div class="card">


				<div class="card-header">
					<div class="card-title-wrap bar-primary">
						<h4 class="card-title">{{ __('tour.heading.calendar') }}</h4>
					</div>
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				</div>

				<div class="card-content mt-1">
					<div class="table-responsive pr-2 pl-2">

						<div id='calendar-container'>
							<div id='calendar'></div>
						</div>
					</div>
					<p>&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('pagejs')
	<script>
		const vehicles = {!! json_encode($vehicles) !!};
		$(function() { // document ready

			$('#calendar').fullCalendar({

				schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
				now: '{{ date('Y-m-d') }}',
				aspectRatio: 1.8,
				scrollTime: '00:00', // undo default 6am scrollTime
				header: {
					left: 'title',
					center: '',
					right: 'today agendaDay,month prev,next'
				},
				defaultView: 'agendaDay', // month, agendaDay
				views: { },
				resourceLabelText: 'Rooms',
				resourceText: function(vehicle) {

					return ('' + vehicle.licensePlate+' - '+vehicle.make+' '+vehicle.name).toUpperCase();
				},
				resourceOrder: 'sortOrder',
				resources: resourcesFunc,
				plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list',
					'dayGridMonth','timeGridWeek','timeGridDay' ],
				// plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin ],
				height: 'parent',
				buttonText: {
					today: '{{__("tour.today")}}',
					month: '{{__("tour.month")}}',
					week: '{{__("tour.week")}}',
					day: '{{__("tour.day")}}'
				},
				events:{!! json_encode($events) !!},
				timeFormat: 'h(:mm) A'

			});

			function resourcesFunc(callback)
			{
				callback(vehicles);
			}
		});
	</script>
@endsection