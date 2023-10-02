<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tata Kelola Konflik</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <base href="<?=BASE_URL;?>" />

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/bootstrap/css/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="assets/themes/lte2.3.0/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.pete.css">  
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/dist/css/skins/skin-black.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/iCheck/all.css">
    <!-- jvectormap -->
   <!-- <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/jvectormap/jquery-jvectormap-1.2.2.css">-->
    <!-- Date Picker -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/fa/4.7.0/css/font-awesome.min.css">
	
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
	<?=loadFunction("validate");?>
    <? $this->load->view("admin_lte_layout/header_js")?>
	
	<!--Additional-->
	<script src="assets/additional_js/pnotify/pnotify.custom.min.js" type="text/javascript"></script>
	<link href="assets/additional_js/pnotify/pnotify.custom.min.css" rel="stylesheet" />
	<!--End Of Additional-->
    	
	<style>
	.filter-section {
		background: #fefefe;
		padding:10px;
	}
	.btn-white {
		background-color: #fff;
		color: #444;
		border-color: #ddd;
		/*border-radius:0;*/
	}
	.btn-white:hover {
		background-color: #f4f4f4;
	}
	.btn-transparent {
		background-color: transparent;
		color: #777;
		border-color: transparent;
		border-radius:0;
	}
	.btn-save {
		color:#009900
	}
	.btn-delete {
		color: #C00
	}
	.content-toolbar {
		padding:10px; 
		background-color:#fff; 
		margin-bottom:10px
	}
	.sidebar-menu > li > a {
		padding: 12px 5px 12px 12px;
		display: block;
	}
	.sidebar-menu > li > a > i {
		margin-right:5px
	}
	
	.heading{
		background-color:#ECF0F5;padding:10px 10px !important;border:none !important;	
	}
	.sidebar-spacer {
		border-bottom: 1px solid #555;
		height: 0;
	}
	.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
		background: none;
		color: #ccc;
		cursor: default;
		text-decoration:line-through
	}
	.user-header {
		height:auto!important;
		background:#999!important;
	}
	.user-footer {
		background:#ddd!important;
	}
	.nav-tabs > li > a {
		text-transform: uppercase;
	}
	</style>			
</head>
<script>
  var AdminLTEOptions = {
    //Bootstrap.js tooltip
    enableBSToppltip: true,
	BSTooltipSelector: "[data-toggle='tooltip']"
  };
</script>
<script type="text/javascript">
$(document).ready(function() {
	$("#datepicker,#datepicker2,#datepicker3,#datepicker4,#datepicker8").datepicker({
		format	:"dd/mm/yyyy",
		changeMonth	: true,
		changeYear	: true
	});
	$('input[type="checkbox"].flat-green, input[type="radio"].flat-green').iCheck({
	  checkboxClass: 'icheckbox_flat-green',
	  radioClass: 'iradio_flat-green'
	});
});								
</script>
<body class="sidebar-mini skin-black fixed sidebar-collapse">