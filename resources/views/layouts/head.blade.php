<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description"
		  content="">
	<meta name="keywords"
		  content="">
	<meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>HB @if(!empty($pageTitle)) {{ ' - '.$pageTitle }} @endif</title>
{{--	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/hb-fav.ico') }}">--}}
	<link rel="shortcut icon" type="image/png" href="{{ asset('images/hb-fav.png') }}">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/feather/style.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/simple-line-icons/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('calendar/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

	<link href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' rel="stylesheet">

	<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.css' rel='stylesheet' />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/basic.css" rel="stylesheet">
{{--	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.4/css/bootstrap.css">--}}

	@toastr_css
</head>