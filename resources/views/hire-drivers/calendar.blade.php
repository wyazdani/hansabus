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
								<h4 class="card-title">{{__('hire.heading.calendar')}}</h4>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 text-right">

						</div>

					</div>
					<div class="row"><div class="col-12">@include('layouts.errors')</div></div>
				</div>
				<div class="card-content mt-1">
					<div class="card-body">
						<div class="px-3 mb-4">
							<div class="table-responsive">
								<div id='calendar-container'>
									<div id='calendar'></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('pagejs')
	<script>
		const drivers = {!! json_encode($drivers) !!};
		$(function() { // document ready

			$('#calendar').fullCalendar({
				schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
				now: '{{ date('Y-m-d') }}',
				aspectRatio: 1.8,
				scrollTime: '00:00', // undo default 6am scrollTime
				header: {
					left: 'title',
					center: '',
					right: 'prev,next'
				},
				defaultView: 'month', // timeGridWeek, month, agendaDay
				views: { },
				resourceLabelText: 'Rooms',
				resourceText: function(driver) {
					//return ('' + resource.driver_name).toUpperCase();
					return driver.driver_name;
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
				events: {!! json_encode($events) !!},
				timeFormat: 'h(:mm) A'

			});

			function resourcesFunc(callback)
			{
				callback(drivers);
			}

		});
	</script>
@endsection

