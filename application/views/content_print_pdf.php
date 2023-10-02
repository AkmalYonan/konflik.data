<!DOCTYPE html>
<html>
<head>
	<base href="<?=BASE_URL;?>" />
    <!--<link href="assets/themes/admin_lte/css/bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.pete.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.report.css" />
	<style>
	
		html,*,body{
			font-family:Arial, Helvetica, sans-serif;
			font-size:11px;
		}
		table.table-bordered
		{
			border-left: 1px solid #ccc;
			border-top: 1px solid #ccc;
			
			border-spacing:0;
			border-collapse: collapse; 
			
		}
		
		table.table-bordered td,table.table-bordered th 
		{
			border-right: 1px solid #ccc;
			border-bottom: 1px solid #ccc;
			font-size:0.9em;
			vertical-align:top;
		}
	</style>
</head>
<body>
<?php /*
<div style="height:<?=isset($header_height)?$header_height:"50"?>">&nbsp;</div>*/?>
<!--
<htmlpageheader name="myheader">
 <table width="100%"><tr>
 <td width="50%" style="color:#0000BB;"><span style="font-weight: bold; font-size:14pt;">Acme Trading Co.</span><br />123 Anystreet<br />Your City<br />GD12 4LP<br /><span style="font-size: 15pt;">&#9742;</span> 01777 123 567</td>
 <td width="50%" style="text-align: right;">Invoice No.<br /><span style="font-weight: bold; font-size: 12pt;">0012345</span></td>
 </tr></table>
 </htmlpageheader>
 -->
<!--<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center;   padding-top: 3mm; ">
	<table style="width:100%">
		<tr><td>&nbsp;</td><td style="text-align:right;">Halaman {PAGENO} dari {nb}</td></tr>
	</table>
</div>
</htmlpagefooter>
<sethtmlpagefooter name="myfooter" value="on" />-->
<!--<sethtmlpageheader name="myheader" value="on" show-this-page="1" />-->

<?=$data?>
<!--<sethtmlpagefooter name="myfooter" value="on" />-->
<!--<sethtmlpagefooter name="footer" value="on" />-->
<!--<sethtmlpageheader name="myheader" value="on" show-this-page="1" />-->
<!--<sethtmlpagefooter name="footer" value="on" />-->
<!--</div>-->
</body>
</html>