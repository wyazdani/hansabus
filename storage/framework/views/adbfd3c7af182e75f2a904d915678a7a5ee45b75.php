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
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

	<title><?php echo e(config('app.name', 'E-Coach Managment')); ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('images/favicon.ico')); ?>">
	<link rel="shortcut icon" type="image/png" href="<?php echo e(asset('images/favicon-32.png')); ?>">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900"
		  rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/feather/style.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/simple-line-icons/style.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/font-awesome/css/font-awesome.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/app.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap-datetimepicker.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">








	<?php if(Request::route()->getName() == 'tour-calendar'): ?>
	
	<link href="<?php echo e(asset('calendar/core/main.css')); ?>" rel='stylesheet' />
	<link href="<?php echo e(asset('calendar/daygrid/main.css')); ?>" rel='stylesheet' />
	<link href="<?php echo e(asset('calendar/timegrid/main.css')); ?>" rel='stylesheet' />
	<script src="<?php echo e(asset('calendar/core/main.js')); ?>"></script>
	<script src="<?php echo e(asset('calendar/daygrid/main.js')); ?>"></script>
	<script src="<?php echo e(asset('calendar/timegrid/main.js')); ?>"></script>
	<?php endif; ?>
</head><?php /**PATH D:\laragon\www\new_ecoach\ecoach\resources\views/layouts/head.blade.php ENDPATH**/ ?>