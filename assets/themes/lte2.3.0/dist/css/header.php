<?
	$appname=$this->lauth->get_appname();
	$userdata=isset($_SESSION[$appname]["userdata"])?$_SESSION[$appname]["userdata"]:FALSE;
	if(!$userdata):
		redirect("login/");
	endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Penyidik Pegawai Negeri Sipil</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <base href="<?=BASE_URL;?>" />

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/fa-4.2.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/iCheck/all.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!--Morris.js [ OPTIONAL ]-->
	<link href="assets/themes/admin_lte/css/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href='assets/js/plugins/fullcalendar/fullcalendar.css' rel='stylesheet' />
	
	<link href="assets/js/plugins/chart/jqplot/jquery.jqplot.css" rel="stylesheet" />
	
    <!-- jQuery 2.1.4 -->
    <script src="assets/themes/lte2.3.0/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
   <script type="text/javascript" src="assets/js/jquery-ui-1.10.3.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="assets/themes/lte2.3.0/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="assets/themes/admin_lte/js/plugins/morris/morris.min.js"></script>
    <script type="text/javascript" src="assets/themes/admin_lte/js/plugins/morris/raphael-js/raphael.min.js"></script>
    
	<script src="assets/js/jquery-1.11.0.min.js"></script>

    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/jquery.jqplot.min.js"></script>
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
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
    
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.highlighter.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.cursor.js"></script>
    <script type="text/javascript" src="assets/js/jquery.sparkline.min.js"></script>

    <script type="text/javascript" src="assets/js/jquery.easy-pie-chart.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui-1.10.3.js"></script>

    <?=loadFunction("validate");?>
    <? $this->load->view("admin_lte_layout/header_js")?>
    	
	<style>
	.well {
		background-color:#d2d6de;	
		border-radius:none!important
	}
	</style>			
</head>
<script type="text/javascript">
$(document).ready(function() {
	$("#datepicker,#datepicker2,#datepicker3,#datepicker4,#datepicker8").datepicker({
		format	:"dd/mm/yyyy",
		changeMonth	: true,
		changeYear	: true
	});
});								
</script>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">