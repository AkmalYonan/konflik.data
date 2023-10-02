<link href="assets/js/plugins/chart/jqplot/jquery.jqplot.css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.enhancedLegendRenderer.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.logAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.highlighter.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.cursor.js"></script>

    
<style>
h4 {
    color: #999;
    display: inline-block;
    font-family: "Sintony";
    font-size: 22px;
    font-weight: 700;
    letter-spacing: -1px;
    line-height: 40px;
    margin-top: 0;
    text-transform: uppercase;
}
div.dominan{
	font-weight: bold;
	font-family: "BebasNeue","Open Sans";
	font-size: 68px;
	color:#66BC79;
	}
.hijau{
	font-weight: bold;
	font-family: "BebasNeue","Open Sans";
	font-size: 40px;
	color:#66BC79;
	}
.merah{
	font-weight: bold;
	font-family: "BebasNeue","Open Sans";
	font-size: 40px;
	color:#dc3912;
	}
.komposisi-left-ket{
	font-family: "BebasNeue","Open Sans";
	font-size:20px;
	text-align:center
	}
label.komposisi-right-ket{
	font-family: "BebasNeue","Open Sans";
	font-size:20px;
	text-align:center
	}
.box-solid{
	background-color:#f2f2f2;
}
.popover{
    min-width:250px;
}
.jqplot-table-legend-swatch{
	height:7px !important;
}
</style>

<?php
	$series_label_status_rehab	=	array("0"=>"Rehabilitasi","1"=>"Pasca Rehabilitasi");
	
	$y	=	date("Y");
	
	for($i=0; $i<11; $i++):
		$tahun[$i]	=	$y-$i;
	endfor;
?>

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          	Dashboard Pasca Rehabilitasi
		  </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content box" style="margin-top:10px">
			<div class="row">
				<div class="col-sm-12" style="margin-bottom:10px">
					<ul class="nav nav-tabs">
						<li><a href="admin/dashboard">Keseluruhan</a></li>
						<li><a href="admin/dashboard_rehab">Rehabilitasi</a></li>
						<li class="active"><a href="<?=$this->module?>">Pasca Rehabilitasi</a></li>
						<li><a href="admin/dashboard_instansi">IPWL dan IP NON IPWL</a></li>
						<li><a href="admin/dashboard_km">KM dan RD </a></li>
					</ul>
				</div>
			</div><!--End Of Row-->
			
			<div class="row">
				<div class="col-sm-12">
				<form action="<?=$this->module?>index" method="get">
					<table cellpadding="10" cellspacing="10">
						<tr>
							<td><strong>Tahun</strong></td>
							<td width="10">&nbsp;</td>
							<td>
								<select name="tahun" class="form-control">
									<option value="">Semua Tahun</option>
									<?php foreach($tahun as $k=>$v): ?>
									<option value="<?=$v?>" <?=($_GET['tahun']==$v)?"selected":""?>><?=$v?></option>
									<?php endforeach; ?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td><strong>Periode Bulan</strong></td>
							<td width="10">&nbsp;</td>
							<td>
								<select name="bulan" class="form-control">
									<option value="">Semua Bulan</option>
									<?php foreach($listMonth as $k=>$v): ?>
									<option value="<?=($k+1)?>" <?=($_GET['bulan']==($k+1))?"selected":""?>><?=$v?></option>
									<?php endforeach; ?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td><strong>Tingkat</strong></td>
							<td width="10">&nbsp;</td>
							<td>
								<select name="tingkat" class="form-control">
									<option value="">Semua Tingkat</option>
									<?php foreach($this->lookup_tingkat_bnn as $k=>$v): ?>
									<option value="<?=$k?>" <?=($_GET['tingkat']==$k)?"selected":""?>><?=$v?></option>
									<?php endforeach; ?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td><button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search">&nbsp;</i>Cari</button></td>
							<td width="10">&nbsp;</td>
							<td>
								<a href="<?=$this->module?>">
									<button type="button" class="btn btn-md btn-warning"><i class="fa fa-refresh">&nbsp;</i>Refresh</button>
								</a>
							</td>
						</tr>
					</table>
					</form>
					<hr />
				</div>
			</div><!--End Of Row-->
			
			<div class="row">
				<div class="col-md-3">
                	<div class="small-box bg-aqua" style="height:180px;">
                        <div class="inner">
                        	<h3><label id="total_pasien"><?=$total_pasien_pasca?></label></h3>
                        	<p>Total Pasien Pasca Rehabilitasi</p>
                        </div>
                        <div class="icon">
                        	<i class="fa fa-user"></i>
                        </div>
					</div>
                </div><!-- end col -->
				
				<div class="col-md-3">
					<div class="box box-solid">
						<div class="box-header with-border" style="height:50px; border-bottom:thin solid #CCCCCC">
							<h5 class="box-title">Berdasarkan Jenis Kelamin</h5>
							<div class="box-tools pull-right hidden">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body with-border" style="display:block;">
							<div class="row">
								<div class="col-md-6 tc">
									<div class="bg-blue tc"><b>Laki-laki</b></div>
									<div class="bg-white info-box" style="padding-top:5px;font-size:30px;min-height:72px;">
										<label id="jumlah_laki_laki"><?=($total_pasien_pasca_klm["L"])?$total_pasien_pasca_klm["L"]:0?></label>
										<div style="font-size:12px">Pasien</div>
									</div>
								</div><!-- end col-->
								<div class="col-md-6 tc">
									<div class="bg-maroon tc"><b>Perempuan</b></div>
									<div class="bg-white info-box" style="padding-top:5px;font-size:30px;min-height:72px;">
										<label id="jumlah_perempuan"><?=($total_pasien_pasca_klm["P"])?$total_pasien_pasca_klm["P"]:0?></label>
										<div style="font-size:12px">Pasien</div>
									</div>	               
								</div> <!-- end col -->
							</div><!-- end row -->
						</div><!--End Of box body-->
					</div>
				</div><!--End Of Col-->
				
				<div class="col-md-6">
					<div class="box box-solid">
						<div class="box-header with-border" style="height:50px; border-bottom:thin solid #CCCCCC">
							<h5 class="box-title">Berdasarkan Layanan</h5>
							<div class="box-tools pull-right hidden">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  	</div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body with-border" style="display:block;">
							<div class="row">
								<div class="col-md-4 tc">
									<div class="bg-red tc"><b>Rawat Inap</b></div>
                                    <div class="bg-white info-box" style="font-size:30px;min-height:72px;">
										<label><?=$total_pasien_pasca_ri?></label>
                                    	<div style="font-size:12px">Pasien</div>
                                    </div>
								</div><!--End Of Col-->
								
								<div class="col-md-4 tc">
									<div class="bg-orange tc"><b>Rawat Jalan</b></div>
                                    <div class="bg-white info-box" style="font-size:30px;min-height:72px;">
										<label><?=$total_pasien_pasca_rj?></label>
                                    	<div style="font-size:12px">Pasien</div>
                                    </div>
								</div><!--End Of Col-->
								
								<div class="col-md-4 tc">
									<div class="bg-green tc"><b>Rawat Lanjut</b></div>
                                    <div class="bg-white info-box" style="font-size:30px;min-height:72px;">
										<label><?=$total_pasien_pasca_rl?></label>
                                    	<div style="font-size:12px">Pasien</div>
                                    </div>
								</div><!--End Of Col-->
							</div>
						</div>
					</div>
				</div><!--End Of Col-->
			</div><!--End Of Row-->
			
			<div class="row">
				<div class="col-md-4">
            		<div class="box box-solid">
						<div class="box-header with-border" style="border-bottom:thin solid #CCCCCC">
							<h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i>Prosentase Berdasarkan Pekerjaan</h3>
						</div><!-- /.box-header -->
						<div class="box-content">
							<div id="pie_1" style="height:200px;width:100%"></div>
							<div style="font-size:14px; color:#0099FF"><center><strong>Jumlah : <?=$total_pasien_pasca?> Pasien</strong></center></div>
						</div> 	
              		</div><!-- /.box -->
           		</div><!--End Of Col-->
            
				<div class="col-md-4">
					<div class="box box-solid">
						<div class="box-header with-border" style="border-bottom:thin solid #CCCCCC">
							<h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i>Prosentase Berdasarkan Pendidikan</h3> 
						</div><!-- /.box-header -->
						<div class="box-content">
							<div id="pie_2" style="height:200px;width:100%"></div>
							<div style="font-size:14px; color:#0099FF"><center><strong>Jumlah : <?=$total_pasien_pasca?> Pasien</strong></center></div>
						</div> 
					</div><!-- /.box -->
				</div><!--End Of Row-->
            
            
				<div class="col-md-4">
					<div class="box box-solid">
						<div class="box-header with-border" style="border-bottom:thin solid #CCCCCC">
							<h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i>Prosentase Berdasarkan Umur</h3> 
							<div class="box-tools pull-right">
								<?php
									$popover_val[]	= "<strong>U1</strong> &raquo; Umur 11 Sampai 20 Tahun";
									$popover_val[]	= "<strong>U2</strong> &raquo; Umur 21 Sampai 30 Tahun";
									$popover_val[]	= "<strong>U3</strong> &raquo; Umur 31 Sampai 40 Tahun";
									$popover_val[]	= "<strong>U4</strong> &raquo; Umur 41 Sampai 50 Tahun";
									$popover_val[]	= "<strong>U5</strong> &raquo; Diatas 50 Tahun";
									
									$list			=	"<ol style='margin-left:-20px'>";
									foreach($popover_val as $k=>$v):
										$list		.=	"<li>".$v."</li>";
									endforeach;
									$list			.=	"</ol>";
								?>
								<a title="<strong>Keterangan</strong>" data-toggle="popover" data-content="<?=$list?>" data-placement="left" data-html="true">
									<button class="btn"><i class="fa fa-info-circle"></i></button>
								</a>
						  	</div><!-- /.box-tools -->  
						</div><!-- /.box-header -->
						<div class="box-content">
							<div id="pie_3" style="height:200px;width:100%"></div>
							<div style="font-size:14px; color:#0099FF"><center><strong>Jumlah : <?=$total_pasien_pasca?> Pasien</strong></center></div>
						</div> 
				  	</div><!-- /.box -->
				</div><!--End Of Col-->
			</div><!--End Of Row-->
			
			<div class="row">
				<div class="col-md-12">
					<div class="box box-solid">
						<div class="box-header with-border" style="border-bottom:thin solid #CCCCCC">
							<h5 class="box-title">Grafik Jumlah Pasien Berdasarkan Status Selesai/Masih Di Rehabilitasi</h5>
							<div class="box-tools pull-right hidden">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  	</div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div style="display: block;" class="box-body">
							<div id="chart-bar-1" style="height:200px"></div>
						</div>
					</div><!--./box-->
            	</div> <!-- end col -->
			</div>
        </section><!-- /.content -->

<script>
	var gcColor = ["#ff8c00","#268dea","#50b576","#A7CEE5","#fb3e46","#3366cc","#109618","#dc3912","#ff9900","#990099","#0099c6","#dd4477","#66aa00","#b82e2e","#316395","#dddddd"];
	var chartPadding = {top:15,bottom:25,right:15};
	var chartGrid = {
		background: '#FFF',
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

$(function(){
	var data_p1=<?=$json_pekerjaan?>;
	var data_p2=<?=$json_pendidikan?>;
	var data_p3=<?=$json_umur?>;
		
	var data_option1={"color":gcColor};
		
	plot_pie("pie_1",data_p1,data_option1);
	plot_pie("pie_2",data_p2,data_option1);
	plot_pie("pie_3",data_p3,data_option1);
		
	var data_option2={"color":["#0073B7","#D81B60"]};
		
	var s1 = <?=$json_total_rehab?>;
  	var s2 = <?=$json_total_pasca?>;
	
	var data1=[s1,s2];
	var series_label	=	[{label:"Rehabilitasi"},{label:"Pasca Rehabilitasi"}];
	var data_ticks		=	["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember"];
	plot_bar('chart-bar-1',data1,series_label,data_ticks,data_option1);
		
	});

	function plot_bar(div_id,data1,series_name,data_ticks,option_data){
		var plot1=$.jqplot(div_id,data1, {
				seriesColors:option_data.color,
				series:series_name,
				/*legend: chartLegend,*/
				gridPadding:chartPadding,
				grid: chartGrid,
				stackSeries: false,
				seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			rendererOptions: {
						barPadding:1,
						barMargin: 20,
						barWidth:25,
						//varyBarColor: true,
						offsetBars: true
					},
					shadow:false,
			},axesDefaults: chartAxesDefault,
					axes: {
						xaxis: {
							renderer: $.jqplot.CategoryAxisRenderer,
							ticks: data_ticks						},
						yaxis: {
							padMin: 0,
							/*tickOptions: {formatString: '%d'},*/
							/*renderer:$.jqplot.LogAxisRenderer,*/
							min: 0
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
					},
					legend: {
				  		renderer: $.jqplot.EnhancedLegendRenderer,
						show: true,
				  		location: 'n',
				  		/*placement: 'outside',*/
						rendererOptions: {
							numberRows:1
						}
					}  
				});
	
		}

	function plot_pie(div_id,data_p,data_option){
  		var plotpie2 = $.jqplot(div_id, [data_p], {
				seriesColors: data_option.color,
				gridPadding:{top:0,left:2,right:2,bottom:0},
				seriesDefaults:{
					renderer:$.jqplot.DonutRenderer,
					shadow: false,
					rendererOptions: { sliceMargin: 1, padding: 8, showDataLabels: true, dataLabelFormatString: "<font style='color:#fff;font-size:9px'>%d%</font>" }
				},
				grid: {
					background: 'rgba(57,57,57,0.0)',
					drawBorder: false,
					shadow: false,
					gridLineColor: '#999',
					gridLineWidth: 1
				},
				legend:{
					renderer: $.jqplot.EnhancedLegendRenderer,
					show:true,
					background:'transparent',
					border:'1px',
					//placement: 'outside',
					location:'s',
					rendererOptions: {
						numberRows: 1
					}, 
					marginTop: '15px'
				},
				/*
				legend:{
					show:true,
					background:'transparent',
					border:'0px',
					location:'e',
					rendererOptions: {
						numberRows: 8
					}, 
					marginTop: '15px'
				},*/
				highlighter: {
					show: true,
					formatString: "%s",
					tooltipLocation: 'auto',
					useAxesFormatters: false
				}
			});
			
  }
</script>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>
