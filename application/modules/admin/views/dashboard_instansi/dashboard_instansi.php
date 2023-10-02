<?php
	$data_propinsi=lookup("m_propinsi2","kode_bps","nama");
?>
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

<link href="assets/js/jvm/jquery-jvectormap.css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/jvm/jquery-jvectormap-2.0.3.min.js"></script>
<script src="assets/js/jvm/id/jquery.jvm.<?=$jsmap?>.js"></script>

    
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
.jvectormap-zoomin {
    top: 20px;
}
.jvectormap-zoomout {
    top: 45px;
}
.jvectormap-zoomin, .jvectormap-zoomout {
    width: 15px;
    height: 15px;
	line-height:15px;
	background-color:#555
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

.nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:focus, .nav-tabs.nav-justified > .active > a:hover {
    border: 0px solid #ddd;
}
.info-top {
	font-size:40px;
	padding:5px;
}
.table > thead > tr > th {
	background:#777!important;
	color:#fff!important;
}
</style>
<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<!-- TOOLBAR -->
        	<div class="content-toolbar">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                    <form class="form-inline" action="<?=$this->module?>" method="get">
                      <div class="form-group col-xs-inline-block">
                        <label for="kabupaten">Jenis Instansi</label>
                        <select name="kji" class="form-control">
                            <option value="">Semua </option>
                            <?php foreach($dropdown_jenis_instansi as $k=>$v): ?>
                            <option value="<?=$v['kd_jenis_instansi']?>" <?=($selected_kji==$v['kd_jenis_instansi'])?"selected":""?>><?=$v['ur_jenis_instansi']?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="kabupaten">Wilayah</label>
                        <select name="kd_propinsi" class="form-control">
                            <option value="">Semua </option>
                            <?php foreach($data_propinsi as $k=>$v): ?>
                            <option value="<?=$k?>" <?=($kd_propinsi==$k)?"selected":""?>><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                      <button id="btn_search" type="submit" class="btn btn-white">Tampilkan</button>
                      <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                    </form>
                    </div>
                </div>
            </div>
            <!-- : TOOLBAR -->
            <!-- TAB -->
            <? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <ul class="nav nav-tabs nav-justified" id="myTabs" role="tablist" style=" position:relative;margin-bottom:10px;"> 
                <li><a href="admin/dashboard">SUMMARY</a></li>
                <li><a href="admin/dashboard_rehab">PROSES REHABILITASI</a></li>
                <li><a href="admin/dashboard_pasca">PASCA REHABILITASI</a></li>
                <li class="active"><a href="<?=$this->module?>">IPWL dan IP NON IPWL</a></li>
				<li><a href="admin/dashboard_km">KM dan RD </a></li>
            </ul>
            <!-- :TAB -->
         </div>
         <!--:col-->
     </div>
     <!--:row-->
     
     <!-- MAP -->
    <div class="row">
        <div class="col-md-12" style="position:relative">
            <div style="position:absolute; top:-60px; right:40px; font-size:150px; color:rgba(100,100,100,0.1)"><?=$selected_tahun?></div>
            <div style="position:absolute; top:60px; right:40px; font-size:40px; color:rgba(100,100,100,0.2)"><?=$selected_bulan?$listMonth[$selected_bulan-1]:""?></div>
                
            <div class="box-header with-borders" style="background:rgba(255,255,255,.5); margin-top:-8px">
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="box-title" style="text-transform:uppercase">Dashboard IPWL Dan IP NON IPWL</h3>
                        <h5 style="text-transform:uppercase"><?=$kd_propinsi?$data_propinsi[$kd_propinsi]:"Seluruh Wilayah"?></h5>
                        <div style="border-top:1px solid #ddd">
                            <span class="pull-right">v 1.0</span>
                            <img src="assets/images/sirena-grey-16.png" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="box-title">TOTAL</h3>
                                <div class="info-top"><?=$total?></div>
                            </div>
                            <div class="col-md-2 text-aqua">
                                <h3 class="box-title">IPWL</h3>
                                <div class="info-top"><?=$ipwl;?></div>
                            </div>
                            <div class="col-md-2 text-green">
                                <h3 class="box-title">IP NON IPWL</h3>
                                <div class="info-top"><?=$ipnwl?></div>
                            </div>
                            <div class="col-md-4 text-orange">
                                <div id="pie_1" style="height:100px;width:100%"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12" style="position:relative">
            <div class="map" style="background: transparent;width: 100%; height: 400px; margin-top:-10px"></div>
        </div>
    </div>
    <!--:MAP-->
    <!-- box -->
    <div class="box box-widget">
        <!-- box-body -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12" style="position:relative">
                    <table class="table table-bordered table-condensed small-font">
                        <thead>
                            <tr>
                                <?php foreach($lookup_jenis_instansi as $k=>$v): ?>
                                <td align="center"><strong><?=$v['ur_jenis_instansi']?></strong></td>
                                <?php endforeach; ?>
                                <td align="center"><strong>Jml. Rawat Inap</strong></td>
                                <td align="center"><strong>Jml. Rawat Jalan</strong></td>
                                <td align="center"><strong>Jml. Rawat Inap dan Jalan</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="font-size:40px;">
                                <?php foreach($lookup_jenis_instansi as $k=>$v): ?>
                                <td align="center" style="color:<?=$lgd_wil[$v['kd_jenis_instansi']]?>"><?=number_format($v['jumlah'])?></td>
                                <?php endforeach; ?>
                                <td align="center"><?=$ri?></td>
                                <td align="center"><?=$rj?></td>
                                <td align="center"><?=$rirj?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- :box-body -->
    </div>
    <!-- :box -->
	<!-- box -->
    <div class="row">
        <div class="col-md-6">
            <div style="padding:10px">
            <h5 class="box-title">Generated: <?=date("d-m-Y H:i");?></h5>
            </div>
        </div>
        <div class="col-md-6">
            <div style="padding:10px">
            <img class="pull-right" src="assets/images/sirena-grey-32.png" />
            </div>
        </div>
    </div>
</section>


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
	var data_p1=<?=$json_total?$json_total:'false'?>;
	var data_option1={"color":["#00c0ef","#00a65a"]};
		
	plot_pie("pie_1",data_p1,data_option1);
		
});
function plot_pie(div_id,data_p,data_option){
	return $.jqplot(div_id, [data_p], {
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
			location:'e',
			rendererOptions: {
				numberRows: 100
			}, 
			marginTop: '15px'
		},
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
<script>
	var id_map='<?=$jsmap?>';
	
	var data={id:<?=$jml_wil['id']?json_encode($jml_wil['id'],true):'false'?>,blbb:<?=$jml_wil['blbb']?json_encode($jml_wil['blbb'],true):'false'?>};
	var data_lgd = <?=json_encode($lgd_wil,true)?>;
    $(function(){
	  var dregion = data.id||false;
	  var dmarker = data.blbb||false;
	  
	  if (dregion) {
	  	propValues = jvm.values.apply({}, jvm.values(data));
		var data_region = []
	  }
	  if (dmarker) {
	  	blbbValues = Array.prototype.concat.apply([], jvm.values(data.blbb.value));
		var data_marker = [
			{
			  attribute: 'fill',
			  scale: data_lgd,
			  values: data.blbb.value
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
				'font-size': '24',
				'font-family':'Arial',
				'font-weight':'normal',
				'fill': '#ccc',
				'stroke':'#eee',
				'stroke-width':0
			  },
			  hover: {
				fill: 'black'
			  }
		  },
		  onMarkerTipShow: function(event, label, index){
				label.html(
				  '<b>'+data.blbb.names[index]+'</b> ('+data.blbb.jtr[index]+')<br/>'+
				  '<b>JENIS: </b>'+data.blbb.jenis[index]
				);
			  },
		  markerStyle:{
			  initial: {
				r:4,
				fill: 'orange',
				"fill-opacity": 0.8,
				stroke: '#fff',
				"stroke-width": 1,
				"stroke-opacity": 1
			  },
		  hover: {
			"fill-opacity": 1,
			stroke: '#555',
			"stroke-width": 0.5,
			"stroke-opacity": 1,
			cursor: 'pointer'
		  }
		  },
		regionStyle:{
		  initial: {
			fill: '#aaa',
			"fill-opacity": 0.8,
			stroke: 'none',
			"stroke-width": 0,
			"stroke-opacity": 1
		  },
		  hover: {
			"fill-opacity": 1,
			stroke: '#ccc',
			"stroke-width": 0.5,
			"stroke-opacity": 1,
			cursor: 'pointer'
		  }
		}
	  });
    });
  </script>