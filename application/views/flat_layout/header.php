<!DOCTYPE html>
<html class=" js csstransforms csstransforms3d csstransitions" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Tata Kelola Konflik</title>
		<link rel="icon" href="assets/images/tk.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <base href="<?=BASE_URL;?>" />

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="assets/themes/flat/bootstrap/css/bootstrap.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/fa/4.7.0/css/font-awesome.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="assets/themes/flat/dist/css/style.css">
    <link rel="stylesheet" href="assets/themes/flat/dist/css/responsive.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="assets/themes/flat/plugins/iCheck/all.css">
    <!-- jvectormap replaced with jqvm -->
    <link rel="stylesheet" href="assets/themes/flat/plugins/jqvm/jqvmap.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="assets/themes/flat/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker 2.1.24 -->
    <link rel="stylesheet" href="assets/themes/flat/plugins/daterangepicker/daterangepicker-2.1.24/daterangepicker.css">

    <!-- jQuery 2.1.4 -->
    <script src="assets/themes/flat/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript" src="assets/js/jquery-ui-1.10.3.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="assets/themes/flat/bootstrap/js/bootstrap.js"></script>

    <!--Additional CSS And JS-->
    <link href='assets/js/additional_js/fancybox/source/jquery.fancybox.css' rel='stylesheet' media="screen" />
    <script type="text/javascript" src="assets/js/additional_js/fancybox/source/jquery.fancybox.js"></script>
    <script type="text/javascript" src="assets/js/additional_js/fancybox/source/jquery.fancybox.pack.js"></script>
    <!--End Of Additional-->
		<style>
		body {
			padding-top:110px!important;
			background-color:#f4f4f4;
		}
		
		.sub-head{
			position:fixed;
			top:55px;
			z-index:999;
			width:100%;
			border-width:0
		}
		.shadow {
			-webkit-box-shadow: 0px 3px 6px 3px rgba(0,0,0,0.1);
			-moz-box-shadow: 0px 3px 6px 3px rgba(0,0,0,0.1);
			box-shadow: 0px 3px 6px 3px rgba(0,0,0,0.1);
		}
		.right-side .fa {
				margin-top: 0px;
				margin-right: 15px;
				margin-bottom:10px;
				width: 45px;
				height: 45px;
				line-height: 45px;
				text-align: center;
				font-size: 24px;
				color: #fff;
				float:left;
				border-radius:50%;
				background:#ccc;
				clear:both
		}
		.right-side small{
				display:block;
				font-size:small;
				color:#999;
				line-height:18px;
		}
		.bg-aqua {
			background:#6CF!important;
		}
		.bg-orange {
			background: #F93!important;
		}
		.bg-red {
			background: #F66!important;
		}
		.bg-green {
			background: #6C9!important;
		}
		.pagination > li > a, .pagination > li > span {
			padding-left: 13px;
		}
		.main-menu .navbar-nav > li.active > a::before {
			position: absolute;
			top: 50px;
			left: 50%;
			margin-left:-8px;
			border: solid transparent;
			border-top-color: #d0d0d0;
			content: ' ';
			height: 0;
			width: 0;
			pointer-events: none;
			border-width:8px;
			z-index:100
		}
		.main-menu .navbar-nav > li.active > a::after {
			position: absolute;
			top: 49px;
			left: 50%;
			margin-left:-8px;
			border: solid transparent;
			border-top-color: #ffffff;
			content: ' ';
			height: 0;
			width: 0;
			pointer-events: none;
			border-width:8px;
			z-index:100
		}
		</style>
	</head>
	<body style="padding-top:60px">
