<!DOCTYPE html>
<html lang="en">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>HRMS</title>
	<meta name="description" content="Human Resource Management System.">
	<meta name="author" content="DNFLINK">
	<meta name="keyword" content="">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
    <base href="<?=BASE_URL;?>" />
    
	<!-- start: CSS -->
	<link href="assets/3.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/fa/css/font-awesome.min.css" rel="stylesheet">
	<link href="assets/css/style.lat.css" rel="stylesheet">
	<link href="assets/css/style.new.buttons.css" rel="stylesheet">
	<link href="assets/css/style.new.infobox.css" rel="stylesheet">
	<link href="assets/css/style.new.statsbox.css" rel="stylesheet">
	<link href="assets/css/style.new.badges.css" rel="stylesheet">
	<link href="assets/css/style.new.task.css" rel="stylesheet">
    <link href="assets/css/retina.min.css" rel="stylesheet">
	<link href='assets/js/plugins/daterange/daterangepicker-bs3.css' rel='stylesheet' />
	<!-- end: CSS -->
	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="assets/js/respond.min.js"></script>
		
	<![endif]-->
	
	<!-- start: Favicon and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="assets/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="assets/ico/favicon.png">
	<!-- end: Favicon and Touch Icons -->	
	
    <script src="assets/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="assets/3.0/js/bootstrap.min.js"></script>
    <?=loadFunction("validate");?>
    <? $this->load->view("admin_lte_layout/header_js")?>
</head>

<body>
<div id="content">