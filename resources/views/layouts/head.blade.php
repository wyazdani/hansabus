<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description"
		  content="">
	<meta name="keywords"
		  content="">
	<meta name="author" content="">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'E-Coach') }} @if(!empty($pageTitle)) {{ ' - '.$pageTitle }} @endif</title>

	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
	<link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon-32.png') }}">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900"
		  rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/feather/style.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/simple-line-icons/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	@toastr_css

	@if(Request::route()->getName() == 'tour-calendar' || Request::route()->getName() == 'hire-driver-calendar' || Request::route()->getName() == 'home')
	{{-- Canlender --}}
{{--	<link href="{{ asset('calendar/core/main.css') }}" rel='stylesheet' />--}}
{{--	<link href="{{ asset('calendar/daygrid/main.css') }}" rel='stylesheet' />--}}
{{--	<link href="{{ asset('calendar/timegrid/main.css') }}" rel='stylesheet' />--}}
{{--	<script src="{{ asset('calendar/core/main.js') }}"></script>--}}
{{--	<script src="{{ asset('calendar/daygrid/main.js') }}"></script>--}}
{{--	<script src="{{ asset('calendar/timegrid/main.js') }}"></script>--}}


		<link href='http://fullcalendar.io/js/fullcalendar-2.7.1/fullcalendar.css' rel='stylesheet' />
		<link href='http://fullcalendar.io/js/fullcalendar-2.7.1/fullcalendar.print.css' rel='stylesheet' media='print' />
		<link href='http://fullcalendar.io/js/fullcalendar-scheduler-1.3.1/scheduler.min.css' rel='stylesheet' />
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



	@endif
</head>