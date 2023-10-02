<base href="<?=BASE_URL;?>" />
<link href="assets/js/plugins/chart/jqplot/jquery.jqplot.css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.enhancedLegendRenderer.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pointLabels.min.js"></script>

<script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.highlighter.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.cursor.js"></script>

<style>
#title {
	font-weight:bold;
	text-transform:uppercase;
}
</style>


<?php

	$data_lookup[1]=$data_propinsi;
	$data_lookup[2]=$data_kabupaten;
	$y	=	date("Y");

	for($i=0; $i<11; $i++):
		$tahun[$i]	=	$y-$i;
	endfor;


?>
<div class="row">
	<div class="col-md-12">
		<span id="title">GRAFIK JUMLAH KONFLIK PERTAHUN</span>
		<div>
			<div id="jml_tahun" style="margin-top:5px;"></div>
			<h6 class="box-title" style="text-transform:uppercase; text-align:center"><small>JUMLAH KONFLIK PERTAHUN</small></h6>
		</div>
	</div>
</div>

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
	var ct 		=	[<?=json_encode($pasien_per_tahun)?>];
	var plot_1	=	plot_line('jml_tahun',ct,[],{color:["#aaa"],legend:false})
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
				  renderer:$.jqplot.DateAxisRenderer,
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
</script>