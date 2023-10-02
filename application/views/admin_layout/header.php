<!DOCTYPE html>
<html lang="en">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>SISFO G3</title>
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
	<link href="assets/css/style.new.infobox.css" rel="stylesheet">
	<link href="assets/css/style.new.statsbox.css" rel="stylesheet">
	<link href="assets/css/style.new.badges.css" rel="stylesheet">
	<link href="assets/css/style.new.task.css" rel="stylesheet">
     
    <link href="assets/js/plugins/chart/jqplot/jquery.jqplot.css" rel="stylesheet" />
	<link href="assets/css/retina.min.css" rel="stylesheet">
    <link href='assets/js/plugins/fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href='assets/js/plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href='assets/js/plugins/daterange/daterangepicker-bs3.css' rel='stylesheet' />
	<!-- end: CSS -->
	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="assets/js/respond.min.js"></script>
		
	<![endif]-->
	
    <!-- start: JavaScript-->
	<!--[if !IE]>-->

	<script src="assets/js/jquery-1.10.2.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    

    <!--<script type="text/javascript" src="assets/js/plugins/chart/jqplot/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.enhancedLegendRenderer.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.logAxisRenderer.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.CanvasTextRenderer.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.CanvasAxisLabelRenderer.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.CanvasAxisTickRenderer.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.barRenderer.min.js"></script>
    
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.highlighter.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.cursor.js"></script>-->
    <script type="text/javascript" src="assets/js/jquery.sparkline.min.js"></script>
    
    <script type="text/javascript" src='assets/js/plugins/fullcalendar/lib/jquery-ui.custom.min.js'></script>
    <script type="text/javascript" src='assets/js/plugins/fullcalendar/fullcalendar.min.js'></script>
    
    <script type="text/javascript" src="assets/js/plugins/daterange/moment.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/daterange/daterangepicker.js"></script>
    <script type="text/javascript" src="assets/js/jquery.easy-pie-chart.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui-1.10.3.js"></script>
	<!--<![endif]-->

	<!--[if IE]>
		<script src="assets/js/jquery-1.10.2.min.js"></script>
	<![endif]-->

	<!--[if !IE]>-->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
	<!--<![endif]-->

	<!--[if IE]>
		<script type="text/javascript">
	 	window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
		</script>
	<![endif]-->
	<script type="text/javascript" src="assets/3.0/js/bootstrap.min.js"></script>
    
    <?=loadFunction("validate");?>
    <? $this->load->view("admin_layout/header_js")?>
    
</head>

<body>