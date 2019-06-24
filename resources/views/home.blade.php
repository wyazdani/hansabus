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
								<span>{{ __('messages.vehicle') }}</span>
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
								<span>{{ __('messages.drivers') }}</span>
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
								<span>{{ __('messages.companies') }}</span>
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
						<h4 class="card-title">{{ __('messages.recent_trips') }}</h4>
					</div>
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				</div>

				<div class="card-content mt-1">
					<div class="table-responsive">
						<table class="table table-hover table-xl mb-0" id="recent-orders">
							<thead>
							<tr>
								<th class="border-top-0" width="5%">ID</th>
								<th class="border-top-0" width="15%">{{__('messages.customers')}}</th>
								<th class="border-top-0" width="15%">{{__('messages.vehicle')}}</th>
								<th class="border-top-0" width="12%">{{__('messages.from_date')}}</th>
								<th class="border-top-0" width="12%">{{__('messages.to_date')}}</th>
								<th class="border-top-0" width="15%">{{__('messages.drivers')}}</th>
								<th class="border-top-0" width="8%">{{__('messages.passengers')}}</th>
								<th class="border-top-0" width="8%">{{__('messages.price')}}</th>
								<th class="border-top-0" width="8%">Status</th>
							</tr>
							</thead>
							<tbody>
							@foreach($recentTours as $tour)
								<tr>
									<td class="text-truncate">{!! $tour->id !!}</td>
									<td class="text-truncate">{!! !empty($tour->customer_id)?$tour->customer->name:'' !!}</td>
									<td class="text-truncate">{!! !empty($tour->vehicle_id)?$tour->vehicle->name:'' !!}</td>
									<td class="text-truncate">{!! $tour->from_date !!}</td>
									<td class="text-truncate">{!! $tour->to_date !!}</td>
									<td class="text-truncate">{!! !empty($tour->driver_id)?$tour->driver->driver_name:'' !!}</td>
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
						<h4 class="card-title">{{ __('messages.calendars') }}</h4>
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
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
				height: 'parent',
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
				},
				defaultView: 'dayGridMonth',
				defaultDate: '2019-06-12',
				navLinks: true, // can click day/week names to navigate views
				editable: true,
				eventLimit: true, // allow "more" link when too many events
				events: {!! json_encode($calendarTours) !!}
			});

			calendar.render();
		});
	</script>
@endsection