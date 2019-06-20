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

	<title>{{ config('app.name', 'E-Coach Managment') }}</title>
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
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" rel="stylesheet">


{{--
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>--}}





	@if(Request::route()->getName() == 'tour-calendar')
	{{-- Canlender --}}
	<link href="{{ asset('calendar/core/main.css') }}" rel='stylesheet' />
	<link href="{{ asset('calendar/daygrid/main.css') }}" rel='stylesheet' />
	<link href="{{ asset('calendar/timegrid/main.css') }}" rel='stylesheet' />
	<script src="{{ asset('calendar/core/main.js') }}"></script>
	<script src="{{ asset('calendar/daygrid/main.js') }}"></script>
	<script src="{{ asset('calendar/timegrid/main.js') }}"></script>
	@endif
</head>