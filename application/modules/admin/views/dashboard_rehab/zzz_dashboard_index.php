<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pyramidAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pyramidGridRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pyramidRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pointLabels.min.js"></script>
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
</style>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>PPNS</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <!--<div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
			  
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></i></span>
                <div >
                  <div style="padding-top:-20px;padding-left:20px;">
					<center><span class="info-box-text">Total Pegawai</span>
					<span class="info-box-number"><h1><?//=$total_pegawai[0]['total_pegawai']?></h1></span></center>
				  </div>
                </div>
              </div>
            </div>-->
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-files-o"></i></span>
                <div >
                  <div style="padding-top:-20px;padding-left:20px;">
					<center><span class="info-box-text">TOTAL PNS</span>
					<span class="info-box-number"><h1><?=$total_pegawai[0]['total_pegawai']?></h1></span></center>
				  </div>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                <div>
                  <div style="padding-top:-20px;padding-left:20px;">
					<center><span class="info-box-text">TOTAL PPNS</span>
					<span class="info-box-number"><h1><?=$total_ppns[0]['total_ppns']?></h1></span></center>
				  </div>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            
          </div><!-- /.row -->

		  
		  
          <div class="row">
            <div class="col-md-12">
              <div class="box">

                <div class="box-footer">
                  <div class="row">
				  <p class="box-title"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-sort-numeric-desc"></i> PERBANDINGAN PNS DAN PPNS PER SKPD</p>
				  <? foreach($tes as $e => $f): ?>
                    <div class="col-md-2 col-sm-2 col-xs-4">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"></i> PNS : PPNS</span>
                        <h5 class="description-header"><?=($f['pns'] == '' ? '0' : $f['pns']);?> : <?=($f['ppns'] == '' ? '0' : $f['ppns']);?></h5>
                        <span class="description-text"><?=$e;?></span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                   <? endforeach; ?>
                  </div><!-- /.row -->
                </div><!-- /.box-footer -->
				
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
              <!-- MAP & BOX PANE -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-fw fa-bar-chart-o"></i> PERBANDINGAN PNS DAN PPNS PER PROPINSI</h3>
                       <div class="box-content">
                    		<div id="chart3"></div>
                    	</div> 
                </div><!-- /.box-header -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->

<script>
var kls_ticks = <?=json_encode($komposisi_wilayah_each)?>;
var kls_values = <?=json_encode($komposisi_wilayah_val)?>;
var kls_label = [<?=implode(",",$komposisi_status_pegawai)?>];


$(document).ready(function(){
  	var gcColor = ["#ff8c00","#268dea","#50b576","#A7CEE5","#fb3e46","#3366cc","#109618","#dc3912","#ff9900","#990099","#0099c6","#dd4477","#66aa00","#b82e2e","#316395","#dddddd"];
	var chartPadding = {top:20,bottom:125,right:15};
	var chartGrid = {
		background: '#f5f5f5',
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
	
	 //BAR
	var plot5 = $.jqplot('chart3', kls_values, {
		stackSeries: false,
		seriesColors: gcColor,
		gridPadding:chartPadding,
		grid: chartGrid,
		legend: chartLegend,
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			rendererOptions: {
				barPadding:1,
                barMargin: 20,
				//varyBarColor: true,
                offsetBars: true
            },
			shadow:false,
		},
		series:kls_label,
		axesDefaults: chartAxesDefault,
		axes: {
		  xaxis: {
			renderer: $.jqplot.CategoryAxisRenderer,
			tickRenderer:$.jqplot.CanvasAxisTickRenderer,
			tickOptions:{ 
				angle: -45
			},
			ticks: kls_ticks
		  },
		  yaxis: {
			padMax:1  
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
			intersectionThreshold:0,
			showTooltipDataPosition:true,
			useAxesFormatters:true,
			tooltipAxes:'ly',
			tooltipFormatString:'<span style="color:#fff;">%s: <strong>%s</strong></span>',// formatString order = tooltipAxes order
			tooltipSeparator:',',
			tooltipOffset:15,
			showHighlight:true,
			snapToData:true
		}
	  });

});
</script>