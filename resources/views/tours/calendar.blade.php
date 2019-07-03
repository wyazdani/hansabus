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
								<h4 class="card-title">{{__('tour.heading.calendar')}}</h4>
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
				buttonText: {
					today: '{{__("tour.today")}}',
					month: '{{__("tour.month")}}',
					week: '{{__("tour.week")}}',
					day: '{{__("tour.day")}}'
				},
				defaultView: 'dayGridMonth',
				defaultDate: '{{ date('Y-m-d')  }}',
				navLinks: true, // can click day/week names to navigate views
				editable: true,
				eventLimit: true, // allow "more" link when too many events
				events: {!! json_encode($data) !!}
			});

			calendar.render();
		});
	</script>
@endsection