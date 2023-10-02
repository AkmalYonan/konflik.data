<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BNN &reg;</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <base href="/admin/" />

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/bootstrap/css/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/dist/css/skins/skin-bnn.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/iCheck/all.css">
    <!-- jvectormap -->
   <!-- <link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/jvectormap/jquery-jvectormap-1.2.2.css">-->
    <!-- Date Picker -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/fa/4.7.0/css/font-awesome.min.css">
	
    <!-- jQuery 2.1.4 -->
    <script src="assets/themes/lte2.3.0/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript" src="assets/js/jquery-ui-1.10.3.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.5 -->
    <script src="assets/themes/lte2.3.0/bootstrap/js/bootstrap.min.js"></script>

    <!-- jvectormap -->
    <script src="assets/themes/lte2.3.0/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/themes/lte2.3.0/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <script type="text/javascript" src='assets/js/plugins/fullcalendar/lib/jquery-ui.custom.min.js'></script>
    <script type="text/javascript" src='assets/js/plugins/fullcalendar/fullcalendar.min.js'></script>
    <script type="text/javascript" src="assets/js/jquery.easy-pie-chart.min.js"></script>

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
	}
	</style>			
</head>
<body>    
<div class="alert alert-info" style="font-family:Arial, Helvetica, sans-serif">
    <h4>Generate PDF file...</h4>
</div>
<div id="print_this" style="opacity:0">

<link href="assets/js/plugins/chart/jqplot/jquery.jqplot.css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.enhancedLegendRenderer.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/jquery.jqplottoimage.js"></script>

<script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.highlighter.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.cursor.js"></script>

<link href="assets/js/jvm/jquery-jvectormap.css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/jvm/jquery-jvectormap-2.0.3.min.js"></script>
<script src="assets/js/jvm/id<?=$jsmappath?>/jquery.jvm.<?=$jsmap?>.js"></script>
<style>
.info-top {
	font-size:50px;
	padding:5px 5px 5px 0;
}
</style>
<?php
	$data_propinsi=lookup("m_propinsi2","kode_bps","nama");
	$data_kabupaten=lookup("m_kabupaten_kota2","kode_bps","nama");
	$data_lookup[1]=$data_propinsi;
	$data_lookup[2]=$data_kabupaten;
	$y	=	date("Y");
	
	for($i=0; $i<11; $i++):
		$tahun[$i]	=	$y-$i;
	endfor;
?>

<?	
	$series_status_rehab[] = array("label"=>"Rehabilitasi");
	$series_status_rehab[] = array("label"=>"Pasca Rehabilitasi");
?>
<? if ($jumlah>0):?>
<?
	$_title = "";
	$dec_j=0;
	/*$jumlah=$jumlah*12300;
	if ($jumlah>100000) {
		$jumlah=$jumlah/1000;
		$dec_j=2;
		$suffix_j="k";
	}*/
	$t=number_format($jumlah,$dec_j,".",".");	
	
	$upordown = array_values(array_slice($pasien_per_tahun, -2));
	$y_diff = $t-$upordown[0][1];
	$p_diff =  number_format(($y_diff/$t)*100,2,".",".");

	$n_assesment = number_format($assesment,0,".",".");	
	$p_assesment = number_format(($assesment/$jumlah)*100,2,".",".");	

	$n_rehab = number_format($rehab,0,".",".");	
	$p_rehab = number_format(($rehab/$jumlah)*100,2,".",".");	

	$n_pasca = number_format($pasca,0,".",".");	
	$p_pasca = number_format(($pasca/$jumlah)*100,2,".",".");	

	$n_selesai = number_format($selesai,0,".",".");	
	$p_selesai = number_format(($selesai/$jumlah)*100,2,".",".");	

	$jkl=number_format($laki_laki,0,".",".");		
	$jkp=number_format($perempuan,0,".",".");		
	$rt=number_format($jumlah/12,2,".",".");		
	$rjkl=number_format($laki_laki/12,2,".",".");	
	$rjkp=number_format($perempuan/12,2,".",".");	
	$pjkl=number_format($laki_laki/$jumlah,2,".",".");	
	$pjkp=number_format($perempuan/$jumlah,2,".",".");	
	if ($periode) {
		$_title = "Bulan ".num2roman($periode);
	}
	$col = ($r>=$t)?"green":"red";
?>
<div style="padding:10px; border-bottom:1px solid #ccc">
<table width="100%" cellspacing="10">
	<tr>
    	<td width="30%" valign="top" style="white-space:nowrap">
        	<p style="font-size:16px;text-transform:uppercase"><strong>DASHBOARD STATUS REHAB</strong></p>
            <br>
            <p style="font-size:16px">s/d Bulan <?=$listMonth[$selected_bulan-1]?> Tahun <?=$selected_tahun?></p>
            <p style="font-size:16px"><?=$kd_org?$lookup_wilayah[$kd_org]:"Seluruh Wilayah"?></p>
            <div style="border-top:1px solid #ddd">
                <img src="<?=$this->base_url?>assets/images/sirena-grey-32.png" />
            </div>
        </td>
        <td valign="top">
        	<p style="font-size:16px;text-transform:uppercase">TREN PERTAHUN</p>
            <div id="jml_tahun" style="height:100px; margin-top:10px"></div>
            <img id="jml_tahun_img" style="height:100px; margin-top:10px" class="hides">
        </td>
        <td width="20%" valign="top">
        	<p style="font-size:16px;text-transform:uppercase">TOTAL</p>
            <div class="info-top"><?=$t;?>
        </td>
        <td width="25%" valign="top">
        	<table style="width:100%">
                <tr class="text-aqua">
                    <td colspan="2" height="20">&nbsp;</td>
                </tr>
                <tr>
                    <td style="color:blue;">REHABILITASI</td><td class="box-title"><span class="badge badge-status bg-purple"><?=$n_rehab;?></span></td><!--<td><small><?=$p_rehab?>%</small></td>-->
                </tr>
                <tr>
                    <td style="color:red">DROP OUT</td><td class="box-title"><span class="badge badge-status bg-red"><?=$sp_do;?></span></td><!--<td><small><?=$p_rehab?>%</small></td>-->
                </tr>
                <tr>
                    <td style="color:orange">PASCA</td><td class="box-title"><span class="badge badge-status bg-orange"><?=$n_pasca;?></span></td><!--<td><small><?=$p_pasca?>%</small></td>-->
                </tr>
                <tr>
                    <td style="color:green">OUTCOME</td><td class="box-title"><span class="badge badge-status bg-green"><?=$n_selesai;?></span></td><!--<td><small><?=$p_selesai?>%</small></td>-->
                </tr>
                <tr>
                    <td style="color:gray">MENINGGAL</td><td class="box-title"><span class="badge badge-status bg-gray"><?=$sp_md;?></span></td><!--<td><small><?=$p_pasca?>%</small></td>-->
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
<!-- MAP -->
<div class="row" style="page-break-after:always">
    <div class="col-md-12">
        <div id="map" class="map" style="background: transparent;width: 1000px; height: 350px; margin-top:-10px; margin-bottom:-20px"></div>
        <canvas id="canvas" width="1000px" height="350px"></canvas> 
        <img id="canvas_img" width="1000px" height="350px">
    </div>
</div>
<!-- TABLE -->
<div style="padding:10px; border-bottom:1px solid #ccc">
    <table width="100%" cellspacing="10">
    	<tr>
        	<td><p style="font-size:16px;text-transform:uppercase">SEBARAN LOKASI PASIEN</p></td>
            <? if (cek_array($top5_wil) && cek_array($top5_bl)):?>
            <td>&nbsp;</td>
            <? endif ?>
            <td><p style="font-size:16px;text-transform:uppercase">PER BULAN</p></td>
        </tr>
        <tr>
            <? if (cek_array($top5_wil)): $i=0;?>
            <td width="<?=(cek_array($top5_bl))?'35%':'70%'?>" valign="top" style="white-space:nowrap">
                <? if (cek_array($top5_wil)): ?>
                <table width="100%">
                    <thead>
                        <tr>
                            <td><strong>BNNP/BNNK</strong></td>
                            <td align="right"><strong>Jumlah</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                    <? foreach($top5_wil as $k=>$v) : $total_wilayah+=$v['jumlah']; ?>
                    <tr>
                        <td><?=$data_lookup[$level][$v['kd']]?></td>
                        <td align="right"><?=$v['jumlah']?></td>
                    </tr>
                    <? endforeach;?>
                    </tbody>
                    <thead>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td align="right"><strong><?=$total_wilayah?></strong></td>
                        </tr>
                    </thead>
                </table>
                <? endif?>
            </td>
            <? endif; ?>
            <? if (cek_array($top5_bl)): $i=0;?>
            <td width="<?=(cek_array($top5_wil))?'35%':'70%'?>" valign="top" style="white-space:nowrap">
                <? if (cek_array($top5_wil)): ?>
                <table width="100%">
                    <thead>
                        <tr>
                            <td><strong>BALAI/LOKA</strong></td>
                            <td align="right"><strong>Jumlah</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                <? foreach($top5_bl as $k=>$v) : $total_blbb+=$v['jumlah'];?>
                        <tr>
                            <td><?=$v['nama']?></td>
                            <td align="right"><?=$v['jumlah']?></td>
                        </tr>
                <? $i++; endforeach;?>
                    </tbody>
                    <thead>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td align="right"><strong><?=$total_blbb?></strong></th>
                        </tr>
                    </thead>
                </table>
                <? endif?>
            </td>
            <? endif; ?>
            <td valign="top">
                <div id="jml_per_bulan" style="height:150px" class="hides"></div>
              	<img id="jml_per_bulan_img" style="height:150px" class="hides">
            </td>
          </tr>
       </table>
</div>

<!-- L/P -->
<div style="padding:10px; border-bottom:1px solid #ccc; page-break-after:always">
    <table width="100%" cellspacing="10">
    	<tr>
        	<td><p style="font-size:16px;text-transform:uppercase">PASIEN BERDASARKAN UMUR/JENIS KELAMIN</p></td>
            <td><p style="font-size:16px;text-transform:uppercase">&nbsp;</p></td>
        </tr>
        <tr>
            <td width="70%" valign="top" style="white-space:nowrap">
            	<div id="chart-bar-usia" style="height:170px"></div>
                <img id="chart-bar-usia_img" style="height:170px" class="hides">
            </td>
            <td width="30%" valign="top" style="white-space:nowrap">
            	<table width="100%">
                	<tr>
                    	<td style="background-color:#0073b7;color:#ffffff; padding:5px">LAKI-LAKI</td>
                        <td style="width:10px">&nbsp;</td>
                        <td style="background-color:#d81b60;color:#ffffff; padding:5px">PEREMPUAN</td>
                    </tr>
                    <tr>
                    	<td><p style="font-size:50px; color:#0073b7; padding:5px;"><?=$jkl;?><br>&nbsp;</p></td>
                        <td style="width:10px">&nbsp;</td>
                        <td><p style="font-size:50px;color:#d81b60; padding:5px;"><?=$jkp;?><br>&nbsp;</p></td>
                    </tr>
                    <tr>
                    	<td style="border-top:1px solid #ccc"><p style="font-size:16px;padding:5px;">Persentase: <strong><?=$pjkl*100;?></strong><small>%</small></p></td>
                        <td style="width:10px">&nbsp;</td>
                    	<td style="border-top:1px solid #ccc"><p style="font-size:16px;padding:5px;">Persentase: <strong><?=$pjkp*100;?></strong><small>%</small></p></td>
                    </tr>
                </table>
            </td>
          </tr>
       </table>
</div>

<!-- PIE -->
<div style="padding:10px; border-bottom:1px solid #ccc; page-break-after: ">
    <table width="100%" cellspacing="10">
    	<tr>
        	<td width="33%"><p style="font-size:16px;text-transform:uppercase">SUMBER PASIEN</p></td>
            <td width="33%"><p style="font-size:16px;text-transform:uppercase">SUMBER BIAYA</p></td>
            <td width="33%"><p style="font-size:16px;text-transform:uppercase">KELOMPOK UMUR</p></td>
        </tr>
        <tr>
        	<td>
            	<div id="pie_sp" style="height:160px;width:100%"></div>
                <img id="pie_sp_img" style="height:160px; margin-left:-55px" class="hides">
            </td>
            <td>
            	<div id="pie_sb" style="height:160px;width:100%"></div>
                <img id="pie_sb_img" style="height:160px; margin-left:-55px" class="hides">
            </td>
            <td>
            	<div id="pie_1" style="height:160px;width:100%"></div>
                <img id="pie_1_img" style="height:160px; margin-left:-55px">
            </td>
        </tr>
    </table>
    <br>
    <table width="100%" cellspacing="10">
    	<tr>
        	<td width="33%"><p style="font-size:16px;text-transform:uppercase">PEKERJAAN</p></td>
            <td width="33%"><p style="font-size:16px;text-transform:uppercase">PENDIDIKAN</p></td>
            <td width="33%"><p style="font-size:16px;text-transform:uppercase">&nbsp;</p></td>
        </tr>
        <tr>
        	<td>
            	<div id="pie_2" style="height:160px;width:100%"></div>
                <img id="pie_2_img" style="height:160px; margin-left:-55px" class="hides">
            </td>
            <td>
            	<div id="pie_3" style="height:160px;width:100%"></div>
                <img id="pie_3_img" style="height:160px; margin-left:-55px" class="hides">
            </td>
            <td>
            	<? if (cek_array($arrDataUmur_legend)): ?>
                    <table class="table table-condensed" style="margin:10px">
                    <? foreach($arrDataUmur_legend as $k=>$v):?>
                        <tr>
                            <td>&nbsp;<strong><?=$k?></strong></td>
                            <td><?=$v?> tahun</td>
                        </tr>
                    <? endforeach?>
                    </table>
                <? endif?>
            </td>
        </tr>
    </table>
</div>

<div style="padding:10px; border-bottom:1px solid #ccc; page-break-after: ">
    <table width="100%" cellspacing="10">
    	<tr>
        	<td width="50%"><p style="font-size:12px;">Generated: <?=date("d-m-Y H:i");?></p></td>
            <td width="50%" align="right"><img class="pull-right" src="<?=$this->base_url?>assets/images/sirena-grey-32.png" /></td>
        </tr>
    </table>
</div>
</div>
<a href="#" class="print-pdf" data-url=""><i class="fa fa-file-pdf-o"></i> PDF</a>
<script>
	var gcColor = ["#ff8c00","#268dea","#50b576","#A7CEE5","#fb3e46","#3366cc","#109618","#dc3912","#ff9900","#990099","#0099c6","#dd4477","#66aa00","#b82e2e","#316395","#dddddd"];
	var chartPadding = {top:15,bottom:25,right:15};
	var chartPadding = {top:0,bottom:25,right:15};
	var chartGrid = {
		background: 'rgba(200,200,200,0.1)',
		drawBorder: false,
		shadow: false,
		gridLineColor: '#ddd',
		gridLineWidth: 1
	};
	var chartLegend	= {
		renderer: $.jqplot.EnhancedLegendRenderer,
		show: true,
		location:'ne',
		rendererOptions: {
			numberRows:1
		}
	};
	
	var chartAxesDefault = {
		pad:0,
		drawMajorGridlines: true,
		rendererOptions: {
			baselineWidth: 0.5,
			baselineColor: '#000',
			drawBaseline: false
		}
	}
	var chartHighlighter = {
		show:false,
		showTooltip: false,
		showMarker:false,
		tooltipAxes:'xly',
		useAxesFormatters :true,
		formatString:'%s<br><strong>%s</strong>: %s',// formatString order = tooltipAxes order
		tooltipLocation:'auto'
	}
	var chartCursor = {
		show:true,
		showTooltip:true,
		tooltipLocation:'auto',
		followMouse:true,
		showVerticalLine:true,
		showCursorLegend:false,
		intersectionThreshold:10,
		showTooltipDataPosition:true,
		useAxesFormatters:true,
		tooltipAxes:'ly',
		tooltipFormatString:'<span style="color:#fff;">%s: <strong>%s</strong></span>',// formatString order = tooltipAxes order
		tooltipSeparator:',',
		tooltipOffset:15,
		showHighlight:true,
		snapToData:true
	}
	var chartSeriesDefault = {
		renderer:$.jqplot.BarRenderer,
		fill: false,
		fillAndStroke: false,
		breakOnNull:true,
		fillAlpha:0.1,
		lineWidth: 1.5,
		showMarker: true,
		shadow:false,
		rendererOptions: {
			smooth: true,
			animation: {
				show: true
			}
		},
		markerOptions:{
			shadow:false
		},
		pointLabels: {
			show: true,
			hideZeros: true,
			fontSize:11
		}
	}
	var chartSeriesLine = {
		fill: false,
		fillAndStroke: false,
		breakOnNull:true,
		fillAlpha:0.1,
		lineWidth: 1.5,
		showMarker: true,
		shadow:false,
		rendererOptions: {
			smooth: true,
			animation: {
				show: true
			}
		},
		markerOptions:{
			shadow:false
		},
		pointLabels: {
			show: true,
			hideZeros: true,
			fontSize:11
		}
	}

$(document).ready(function(){
	var ct = [<?=json_encode($pasien_per_tahun2)?>];
	var plot_1 = plot_line('jml_tahun',ct,[],{color:["#aaa"],legend:false})
	
	var data_option1={
			color:["#aaa"],
			ticks:["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"]
		}
  	//var c3 = [<?=json_encode($pasien_per_bulan["L"])?>,<?=json_encode($pasien_per_bulan["P"])?>];
	//var plot_0 = plot_stack('jml_per_bulan',c3,[{"label":"Laki-laki"},{"label":"Perempuan"}],data_option1);
	

	var data_p1=<?=json_encode($arrDataUmur_val)?>;
	var data_p2=<?=json_encode($arrDataPekerjaan_val)?>;
	var data_p3=<?=json_encode($arrDataPendidikan_val)?>;
	var data_p_sp=<?=json_encode($arrSumberPasien_val)?>;
	var data_p_sb=<?=json_encode($arrSumberBiaya_val)?>;
	
	var data_option1={"color":gcColor,"legend_show":true};
	var plot_pie_1 = plot_pie("pie_1",data_p1,data_option1);
	var plot_pie_2 = plot_pie("pie_2",data_p2,data_option1);
	var plot_pie_3 = plot_pie("pie_3",data_p3,data_option1);
	var plot_pie_4 = plot_pie("pie_sp",data_p_sp,data_option1);
	var plot_pie_5 = plot_pie("pie_sb",data_p_sb,data_option1);
	
	var data_ticks_usia=[];
	for(i=11;i<=45;i++){
		data_ticks_usia.push(i==45?">45":i);
	}
	var series_label_usia=[{"label":"Usia"}];
	var data_usia=[<?=json_encode($data_umur_laki)?>,<?=json_encode($data_umur_perempuan)?>];
	
	var data_option3={
			color:["#0073b7","#d81b60"],
			
		}
	var plot_3 = plot_bar2('chart-bar-usia',data_usia,[{"label":"Laki-laki"},{"label":"Perempuan"}],data_ticks_usia,data_option3)

	var data_option1={
			color:["#aaa"],
			ticks:[1,2,3,4,5,6,7,8,9,10,11,12]
		}
	var tick_test = [1,2,3,4,5,6,7,8,9,10,11,12]
  	var c3 = [<?=json_encode($pasien_per_bulan["A"])?>];
	var plot_0 = plot_bar('jml_per_bulan',c3,[{"label":"Laki-laki"}],tick_test,data_option1);
	
	$(window).resize(function() {
          plot_0.replot( { resetAxes: true } );
          plot_1.replot( { resetAxes: true } );
          plot_3.replot( { resetAxes: true } );
          plot_pie_1.replot( { resetAxes: true } );
          plot_pie_2.replot( { resetAxes: true } );
          plot_pie_3.replot( { resetAxes: true } );
          plot_pie_4.replot( { resetAxes: true } );
          plot_pie_5.replot( { resetAxes: true } );
    });
	
	function toImg(id,keep) {
		//var imgData = $(id).jqplotToImageStr({});

		var imgelem = $(id).jqplotToImageElem();
		var url=imgelem.getAttribute('src');
		
		//$(id+"_img").removeClass("hide");
		//$(id+"_img").empty(); // remove the old graph
		$(id+"_img").attr("src",url);
		if (!keep) $(id).remove();
	}
	function toImg2(id,keep) {
		//var imgData = $(id).jqplotToImageStr({});

		var imgelem = $(id).jqplotToImageElem();
		$(id+"_img").append(imgelem);
		if (!keep) $(id).remove();
	}
	toImg('#jml_tahun');
	toImg('#jml_per_bulan');
	toImg('#chart-bar-usia');
	toImg('#pie_sp');
	toImg('#pie_sb');
	toImg('#pie_1');
	toImg('#pie_2');
	toImg('#pie_3');
});

function plot_line(div_id,data1,series_name,option_data){
	return $.jqplot(div_id,data1, {
		seriesColors:option_data.color,
		series:series_name,
		legend: option_data.legend,
		gridPadding:chartPadding,
		grid: chartGrid,
		seriesDefaults:chartSeriesLine,
		axesDefaults: chartAxesDefault,
			axes: {
				xaxis:{
				  renderer:$.jqplot.CategoryAxisRenderer,
				  padMin: 0,
				  tickOptions:{
					formatString:'%Y'
				  } 
				},
				yaxis: {
					padMin: 0,
					//tickOptions: {formatString: '%d'},
					/*renderer:$.jqplot.LogAxisRenderer,*/
					//min: 0
				}
			},
			  highlighter: {
				show: true,
				sizeAdjust: 7.5,
				useAxesFormatters: true,
				tooltipAxes:'xy',
				tooltipFormatString: '%s'
			  },
			  cursor: {
				show: false
			  }
		});

}
function plot_stack(div_id,data1,series_name,option_data){
	return $.jqplot(div_id,data1, {
		seriesColors:option_data.color,
		series:series_name,
		legend: option_data.legend,
		gridPadding:chartPadding,
		grid: chartGrid,
		stackSeries: true,
		seriesDefaults:chartSeriesDefault,
		axesDefaults: chartAxesDefault,
			axes: {
				xaxis: {
					renderer: $.jqplot.CategoryAxisRenderer,
					ticks:option_data.ticks
				},
				yaxis: {
					padMin: 0,
					//tickOptions: {formatString: '%d'},
					/*renderer:$.jqplot.LogAxisRenderer,*/
					//min: 0
				}
			},
			highlighter: chartHighlighter,
			cursor: chartCursor
		});

}

function plot_bar(div_id,data1,series_name,data_ticks,option_data){
	return $.jqplot(div_id,data1, {
		seriesColors:option_data.color,
		series:series_name,
		legend: chartLegend,
		gridPadding:chartPadding,
		grid: chartGrid,
		stackSeries: false,
		seriesDefaults:{
		renderer:$.jqplot.BarRenderer,
		rendererOptions: {
				barPadding:0,
				barMargin: 2
			},
			shadow:false,
		},
		axesDefaults: chartAxesDefault,
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: data_ticks						},
			yaxis: {
				padMin: 0,
				min: 0
			}
		},
		highlighter: chartHighlighter,
		cursor: chartCursor
	});
}
	
function plot_bar2(div_id,data1,series_name,data_ticks,option_data){
	return $.jqplot(div_id,data1, {
		seriesColors:option_data.color,
		series:series_name,
		legend: chartLegend,
		gridPadding:chartPadding,
		grid: chartGrid,
		stackSeries: false,
		seriesDefaults:{
		renderer:$.jqplot.BarRenderer,
		rendererOptions: {
					barPadding:1,
					barMargin: 20,
					barWidth:5,
					//varyBarColor: true,
					offsetBars: true
				},
				shadow:false,
		},axesDefaults: chartAxesDefault,
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: data_ticks
			},
			yaxis: {
				padMin: 0,
				/*tickOptions: {formatString: '%d'},*/
				/*renderer:$.jqplot.LogAxisRenderer,*/
				//min: 0
			}
		},
		highlighter: chartHighlighter,
		cursor: {
			show:true,
			showTooltip:true,
			tooltipLocation:'auto',
			followMouse:true,
			showVerticalLine:true,
			showCursorLegend:false,
			intersectionThreshold:5,
			showTooltipDataPosition:true,
			useAxesFormatters:true,
			tooltipAxes:'ly',
			tooltipFormatString:'<span style="color:#fff;">%s: <strong>%s</strong></span>',// formatString order = tooltipAxes order
			/*tooltipSeparator:',',*/
			tooltipOffset:0,
			showHighlight:true,
			snapToData:false
		}/*,
		legend: {
			renderer: $.jqplot.EnhancedLegendRenderer,
			show: true,
			location: 'n',
			rendererOptions: {
				numberRows:1
			}
		}  */
	});

}

function plot_pie(div_id,data_p,data_option){
	return $.jqplot(div_id, [data_p], {
		seriesColors: data_option.color,
		gridPadding:{top:0,left:2,right:2,bottom:5},
		seriesDefaults:{
			renderer:$.jqplot.PieRenderer,
			shadow: false,
			rendererOptions: { sliceMargin: 1, padding: 5, showDataLabels: true, dataLabelFormatString: "<font style='color:#000;font-size:9px'>%d%</font>" }
		},
		grid: {
			background: 'rgba(57,57,57,0.0)',
			drawBorder: false,
			shadow: false,
			gridLineColor: '#999',
			gridLineWidth: 1
		},
		legend:{
			//renderer: $.jqplot.EnhancedLegendRenderer,
			show:data_option.legend_show||false,
			background:'transparent',
			border:'1px',
			//placement: 'outside',
			location:'e',
		}
	});
}
</script>
<? endif?>
<script type="text/javascript" src="assets/js/plugins/canvg/rgbcolor.js"></script> 
<script type="text/javascript" src="assets/js/plugins/canvg/StackBlur.js"></script>
<script type="text/javascript" src="assets/js/plugins/canvg/canvg.js"></script> 
<script>
function jvmImage() {
    var oSerializer = new XMLSerializer();
    var sXML = oSerializer.serializeToString(document.querySelector(".map svg"));

    canvg(document.getElementById('canvas'), sXML,{ ignoreMouse: true, ignoreAnimation: true })
    var imgData = canvas.toDataURL("image/png");
	document.getElementById('canvas_img').src = imgData;
    $("#canvas").remove();
    $(".map").remove();
}
function checkReady() {
    var svg = $("#map").html();
    if (svg == null) {
        setTimeout("checkReady()", 300);
    } else {
        jvmImage();
		pdfOpen();
    }
}
function pdfOpen(){
	var base_url="<?=base_url()?>";
	var html=$("div#print_this").html();
	var file="test<?="_".date("YmdHis").".pdf";?>";
	UrlSubmit(base_url+"export/proxy_pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:10,p:'A4',o:'L'});
}
function UrlSubmit(url, params) {
		params["target"]=params["target"]||'';
		var target=('target="'+params["target"])+'"'||'';
		var form = [ '<form id="flyfrm" name="flyfrm" method="POST" ',target,' action="', url, '">' ];
	
		for(var key in params) 
			form.push('<input type="hidden" name="', key, '" value="', params[key], '"/>');
	
		form.push('</form>');
	
		jQuery(form.join('')).appendTo('body')[0].submit();
	}
var selected="<?=$kd_org?>";
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
	
	//TABS CLICK
	$("#myTabs>li>a").click(function(e){
		e.preventDefault();
		var t=$("#tahun option:selected").val()||$("#tahun").val();
		var b=$("#bulan option:selected").val()||$("#bulan").val();
		var i=$("#tipe_inst option:selected").val()||$("#tipe_inst").val();
		var k=$("#wil_inst option:selected").val()||$("#wil_inst").val();
		location.href=$(this).attr("href")+"?tahun="+t+"&bulan="+b+"&tipe_instansi="+i+"&kd_org="+k;
	});
	
	//RESET BUTTON
	$("#btn_reset").click(function(e){
		$("#tahun option:eq(1)").attr("selected","selected");
		$("#bulan option:eq(0)").attr("selected","selected");
		$("#tipe_inst option:eq(0)").attr("selected","selected");
		$("#wil_inst").val(0);
		$("#btn_search").trigger("click");
	});
	
	//PARAM INSTANSI
	$("#tipe_inst").change(function(){
		var tipe=$("#tipe_inst option:selected").val()||$("#tipe_inst").val();
		
		$("#wil_inst").val([]);
		$("#wil_inst option[value!='']").hide();
		tipe=(tipe=='BL')?"-b":tipe;
		if (tipe) {
			$("#wil_inst option[value*='"+tipe+"']").show();
		}
		$("#wil_inst").val("");
		
	}).change();
	$("#wil_inst").val(selected);
	
	
		
		$("a.toImg").click(function(e){
			e.preventDefault();
				jvmImage();
		});
});
</script>
<script>
	var id_map='<?=$jsmap?>';var pid_map={<?=$jsmap?>00:"PARENT"};var pid_scale={"PARENT":"rgba(0,0,0,0)"};;var pid_scale2={"PARENT":2};
	var zoom2=<?=$zoom2?"'".$zoom2."'":"false"?>;
	
	var data={id:<?=$jml_wil['id']?json_encode($jml_wil['id'],true):'false'?>,id_pop:<?=$jml_wil['id_pop']?json_encode($jml_wil['id_pop'],true):'false'?>,blbb:<?=$jml_wil['blbb']?json_encode($jml_wil['blbb'],true):'false'?>};
	//var data = <?=$jml_wil?$jml_wil:'false'?>;
    $(function(){
	  var dregion = data.id||false;
	  var dmarker = data.blbb||false;
	  
	  if (dregion) {
	  	propValues = jvm.values.apply({}, jvm.values(data));
		//alert(JSON.stringify(dregion));
		var vmin = jvm.min(propValues);
		var vmax = jvm.max(propValues);
		var data_region = [{
			  scale: ['#e6aca5', '#A50F15'],
			  normalizeFunction: 'polynomial',
			  attribute: 'fill',
			  values: dregion,
			  min: vmin,
			  max: vmax<5?5:vmax,
			  legend: {
				  vertical: true
			  }
			},{
			  attribute: 'stroke',
			  normalizeFunction: 'polynomial',
			  scale: ['#e6aca5', '#A50F15'],
			  values: dregion,
			  min: vmin,
			  max: vmax<5?5:vmax
			},{
			  attribute: 'fill',
			  values: pid_map,
			  scale:pid_scale
			},{
			  attribute: 'stroke-width',
			  values: pid_map,
			  scale:pid_scale2
			}]
	  }
	  if (dmarker) {
	  	blbbValues = Array.prototype.concat.apply([], jvm.values(data.blbb.value));
		var vmin = 0;
		var vmax = jvm.max(blbbValues);
		var data_marker = [{
			  attribute: 'r',
			  scale: (vmin==0 && vmax==0)?[4]:[4, 6],
			  values: data.blbb.value,
			  min: vmin,
			  max: vmax<5?5:vmax,
			  legend: {
				  vertical: false
			  }
			},{
			  attribute: 'stroke-width',
			  scale: [.5, 2],
			  values: data.blbb.value,
			  min: jvm.min(blbbValues),
			  max: jvm.max(blbbValues)
			}]
	  }
      var map = new jvm.Map({
        container: $('.map'),
        map: 'id-'+id_map+'_merc',
		zoomButtons : true,
		zoomOnScroll: false,
		backgroundColor:'rgba(0,0,0,0)',
		markers: data.blbb.coords,
		series: {
			markers: data_marker,
			regions: data_region
		  },
		  labels: {
			  regions: {
				render: function(code){
					return data.id[code];
				}
			  }
		  },
		  
		  regionLabelStyle: {
			  initial: {
				'font-size': '14',
				'fill': '#333',
				'stroke':'#eee',
				'stroke-width':0.5
			  },
			  hover: {
				fill: 'black'
			  }
		  },
		  onMarkerTipShow: function(event, label, index){
				label.html(
				  '<b>'+data.blbb.names[index]+'</b><br/>'+
				  '<b>Total: </b>'+data.blbb.value[index]
				);
			  },
		  onRegionTipShow: function(event, label, code){
			  var jml = data.id[code] || 0;
			  var p = "";
			  if (data.id_pop[code]) {
				  p = data.id_pop[code].a?"Assesment :"+data.id_pop[code].a+"<BR>":"";
				  p+= data.id_pop[code].r?"Rehabilitasi :"+data.id_pop[code].r+"<br>":"";
				  p+= data.id_pop[code].p?"Pasca :"+data.id_pop[code].p+"<br>":"";
				  p+= data.id_pop[code].s?"Outcome :"+data.id_pop[code].s:"";
			  }
        	  label.html('<b>'+label.html()+'</b><div style="border-bottom:1px solid #fff">'+p+'</div><b>Total:'+jml+'</b>');
        	  //label.html('<b>'+label.html()+'</b><br>Total: '+jml);
		  },
		  onRegionClick: function(event, code){
				map.setFocus({region:code});
		  },
		  markerStyle:{
			  initial: {
				fill: 'orange',
				"fill-opacity": 0.8,
				"stroke-width": 1,
				"stroke-opacity": 1
			  }
		  },
		regionStyle:{
		  initial: {
			fill: '#aaa',
			"fill-opacity": 0.8,
			stroke: 'none',
			"stroke-width": 0.5,
			"stroke-opacity": 0.8
		  },
		  hover: {
			"fill-opacity": 1,
			"stroke-opacity": 1,
			cursor: 'pointer'
		  }
		}
	  });
	  
	  if (zoom2) map.setFocus({region:zoom2});
		
	  checkReady();
    });
	
  </script>
  
  </body>
