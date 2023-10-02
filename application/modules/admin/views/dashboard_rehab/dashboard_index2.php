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
    
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.highlighter.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.cursor.js"></script>

	<link href="assets/js/jvm/jquery-jvectormap.css" rel="stylesheet" />
    <script type="text/javascript" src="assets/js/jvm/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="assets/js/jvm/id/jquery.jvm.<?=$jsmap?>.js"></script>
<!--

<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pyramidAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pyramidGridRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pyramidRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/chart/jqplot/plugins/jqplot.pointLabels.min.js"></script>
-->
    
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
<style>
.jvectormap-legend-cnt-h {
    bottom: 10px;
    left: 10px;
}
.jvectormap-legend-cnt-v {
    top: 100px;
    right: 20px;
	max-width:100px
}
.jvectormap-legend {
    background: transparent;
    color: #777;
    border-radius: 0px;
}
.jvectormap-legend-cnt-h .jvectormap-legend-tick {
    width: 20px;
}
.jvectormap-legend-tick-sample {
    height: 20px;
    width: 20px;
    display: inline-block;
    vertical-align: middle;
	border-radius:50%
}
.info-box-content {
    padding: 5px 10px;
    margin-left: 0px!important;
}
.description-block > .description-header {
    font-size: 30px;
}
.info-box {
}
.info-box-text {
    font-size: 1.1em !important;
    color: #777;
}
.info-box-number {
    font-size: 3em !important;
}
.info-box-text2 {
	display:block;
	text-decoration:none;
    font-size: 1em !important;
    color: #999;
}
.info-box-number2 {
    font-size: 1.5em !important;
}
.rank>tbody th,.rank>tbody td{
	text-align:center;
}
.rank>tbody th:first-child,.rank>tbody td:first-child{
	text-align: left;
}
td.jqplot-table-legend-label,td.jqplot-table-legend {
	white-space:nowrap!important;
}
.rtop {
	background:#339900;
	color:#fff;
}
.label {
	font-size:.9em;
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
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1 class="hidden-xs">
    <?=$this->module_title?></h1>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo $this->module?>" class="active"><?=$this->module_title?></a></li>
  </ol>
</section>
<!-- Section Content -->
<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<!-- TOOLBAR -->
        	<div class="content-toolbar">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                    <form class="form-inline" action="<?=$this->module?>" method="get">
                      <div class="form-group col-xs-inline-block">
                        <label for="kabupaten">Tahun</label>
                        <select name="tahun" class="form-control">
                            <option value="">Semua Tahun</option>
                            <?php foreach($tahun as $k=>$v): ?>
                            <option value="<?=$v?>" <?=($selected_tahun==$v)?"selected":""?>><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="kabupaten">Periode Bulan</label>
                        <select name="bulan" class="form-control">
                            <option value="">Semua Bulan</option>
                            <?php foreach($listMonth as $k=>$v): ?>
                            <option value="<?=($k+1)?>" <?=($_GET['bulan']==($k+1))?"selected":""?>><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                      
                      <!--<div class="form-group">
                        <label for="kabupaten">Tingkat</label>
                        <select name="tingkat" class="form-control">
                            <option value="">Semua Tingkat</option>
                            <?php foreach($this->lookup_tingkat_bnn as $k=>$v): ?>
                            <option value="<?=$k?>" <?=($_GET['tingkat']==$k)?"selected":""?>><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>-->
                      
                      <div class="form-group">
                        <label for="kabupaten">Wilayah</label>
                        <select name="kd_propinsi" class="form-control">
                            <option value="">Semua </option>
                            <?php foreach($data_propinsi as $k=>$v): ?>
                            <option value="<?=$k?>" <?=($_GET['kd_propinsi']==$k)?"selected":""?>><?=$v?></option>
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
            <ul class="nav nav-tabs" id="myTabs" role="tablist" style="background:#eee"> 
                <li class="hidden"><a href="admin/dashboard">Keseluruhan</a></li>
                <li class="active"><a href="<?=$this->module?>">Rehabilitasi</a></li>
                <li><a href="admin/dashboard_pasca">Pasca Rehabilitasi</a></li>
                <li><a href="admin/dashboard_instansi">IPWL dan IP NON IPWL</a></li>
				<li><a href="admin/dashboard_km">KM dan RD </a></li>
            </ul>
            <!-- :TAB -->
            <!-- box -->
            <div class="box box-widget">
            	<div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                	<h3 class="box-title">PASIEN REHABILITASI</h3>
                </div>
                <!-- box-body -->
                <div class="box-body">
                	
                	<div class="row">
                        <div class="col-md-6" style="position:relative">
                            <div id="jml_tahun" style="height:170px"></div>
                        </div>
                        
                        <?
							$_title = "";
							$t=number_format($pasien,0,".",".");	
							$jkl=number_format($dataJenisKelamin["L"],0,".",".");		
							$jkp=number_format($dataJenisKelamin["P"],0,".",".");		
							$rt=number_format($pasien/12,2,".",".");		
							$rjkl=number_format($dataJenisKelamin["L"]/12,2,".",".");	
							$rjkp=number_format($dataJenisKelamin["P"]/12,2,".",".");	
							$pjkl=number_format($dataJenisKelamin["L"]/$pasien,2,".",".");	
							$pjkp=number_format($dataJenisKelamin["P"]/$pasien,2,".",".");	
							if ($periode) {
								$_title = "Bulan ".num2roman($periode);
							}
							$col = ($r>=$t)?"green":"red";
						?>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <div class="bg-black" style="padding:2px 10px"><b>TOTAL</b></div>
                              <div class="info-box">
                                <div class="info-box-content">
                                  <div class="pull-right visible-xs">
                                  	<span class="info-box-text2">Rata-rata/Bulan</span>
                                    <span class="info-box-number2"><?=$rt;?><small</small></span>
                                  </div>
                                  <span class="info-box-number"><?=$t;?><small>Pasien</small></span>
                                  <? if (!$periode) : ?>
                                  <span class="info-box-text2 hidden-xs">Rata-rata/Bulan</span>
                                  <span class="info-box-number2 hidden-xs"><?=$rt;?><small></small></span>
                                  <? endif; ?>
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                              <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4 col-sm-4 col-xs-6">
                              <div class="bg-blue" style="padding:2px 10px"><b>LAKI-LAKI</b></div>
                              <div class="info-box">
                                <div class="info-box-content">
                                
                                  <div class="pull-right visible-xs">
                                  	<span class="info-box-text2">Persentase</span>
                                    <span class="info-box-number2"><?=$pjkl*100;?><small>%</small></span>
                                  </div>
                                  <span class="info-box-number text-blue"><?=$jkl;?><small>Pasien</small></span>
                                  <? if (!$periode) : ?>
                                  <span class="info-box-text2 hidden-xs">Persentase</span>
                                  <span class="info-box-number2 hidden-xs"><?=$pjkl*100;?><small>%</small></span>
                                  <? endif; ?>
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                              <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4 col-sm-4 col-xs-6">
                              <div class="bg-maroon" style="padding:2px 10px"><b>PEREMPUAN</b></div>
                              <div class="info-box">
                                <div class="info-box-content">
                                  <div class="pull-right visible-xs">
                                  	<span class="info-box-text2">Persentase</span>
                                    <span class="info-box-number2"><?=$pjkp*100;?><small>%</small></span>
                                  </div>
                                  <span class="info-box-number text-maroon"><?=$jkp;?><small>Pasien</small></span>
                                  <? if (!$periode) : ?>
                                  <span class="info-box-text2 hidden-xs">Persentase</span>
                                  <span class="info-box-number2 hidden-xs"><?=$pjkp*100;?><small>%</small></span>
                                  <? endif;?>
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                              <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                          </div>
                        </div>
                    </div>
                </div>
                <!-- :box-body -->
            </div>
            <!-- :box -->
            
            <!-- MAP -->
            <div class="row">
                <div class="col-md-12" style="position:relative">
                	<div style="position:absolute; top:-40px; right:40px; font-size:150px; color:rgba(100,100,100,0.1)"><?=$selected_tahun?></div>
                	<div style="position:absolute; top:80px; right:40px; font-size:40px; color:rgba(100,100,100,0.2)"><?=$selected_bulan?$listMonth[$selected_bulan]:""?></div>
                	<div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                        <h3 class="box-title">SEBARAN PASIEN REHABILITASI</h3>
                        <h5><?=$data_propinsi[$_GET['kd_propinsi']]?></h5>
                    </div>
                    <div class="map" style="background: transparent;width: 100%; height: 400px"></div>
                </div>
            </div>
            
            <!-- row 2-->
            <!-- box -->
                	<div class="row">
                        <div class="col-md-6">
                        	<div class="box box-widget transparent">
                            <div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                                <h3 class="box-title">TOP 5 WILAYAH REHABILITASI</h3>
                            </div>
                            <div class="box-body">
                                <? if (cek_array($top5_wil)): ?>
                                <table class="table">
                                    <tr>
                                    <th>No.</th>
                                    <th>Wilayah</th>
                                    <th>Jumlah</th>
                                    </tr>
                                <? foreach($top5_wil as $k=>$v) : ?>
                                    <tr>
                                        <td style="width:30px"><?=($k+1)?>.</td>
                                        <td><?=$data_lookup[$level][$v['kd']]?></td>
                                        <td><strong><?=$v['jumlah']?></strong></td>
                                    </tr>
                                <? endforeach;?>
                                </table>
                                <? endif?>
                             </div>
                        	</div>
                        </div><!-- end col -->
                        
                        <div class="col-md-6">
                        	<div class="box box-widget transparent">
                            <div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                                <h3 class="box-title">SUMBER PASIEN REHABILITASI</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3 col-xs-6 tc">
                                        <div class="bg-red tc"><b>Proses Hukum</b></div>
                                        <div class="bg-white info-box" style="font-size:30px;min-height:72px;"><label id="jumlah_sukarela"><?=$dataSumberPasien["HUKUM"];?></label>
                                            <div id="persen_sukarela" style="font-size:12px"><?=number_format($dataSumberPasien["HUKUM"]*100/$pasien,2,".",".");?> %</div>
                                        </div>
                                    </div>
                
                                    <div class="col-md-3 col-xs-6 tc">
                                        <div class="bg-orange tc"><b>Vonis Hakim</b></div>
                                        <div class="bg-white info-box" style="font-size:30px;min-height:72px;"><label id="jumlah_napi"><?=$dataSumberPasien["VH"];?></label>
                                            <div id="persen_napi" style="font-size:12px"><?=number_format($dataSumberPasien["VH"]*100/$pasien,2,".",".");?> %</div>
                                        </div>
                                    </div>
                
                                    <div class="col-md-3 col-xs-6 tc">
                                        <div class="bg-green tc"><b>Sukarela</b></div>
                                        <div class="bg-white info-box" style="font-size:30px;min-height:72px;">
                                            <label id="jumlah_sukarela"><?=$dataSumberPasien["SUKARELA"];?></label>
                                            <div id="persen_sukarela" style="font-size:12px"><?=number_format($dataSumberPasien["SUKARELA"]*100/$pasien,2,".",".");?> %</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 col-xs-6 tc">
                                        <div class="bg-green tc"><b>WBP</b></div>
                                        <div class="bg-white info-box" style="font-size:30px;min-height:72px;">
                                            <label id="jumlah_sukarela"><?=$dataSumberPasien["WBP"];?></label>
                                            <div id="persen_sukarela" style="font-size:12px"><?=number_format($dataSumberPasien["WBP"]*100/$pasien,2,".",".");?> %</div>
                                        </div>
                                    </div>
                        
                    		
                				</div><!-- end row-->
                             </div>
                        	</div>
                        </div><!-- end col -->
                       
               	
                
                
            		</div>
            <!-- :row2 -->
            
            <!-- row 3-->
            <!-- box -->
            <div class="box box-widget">
                <!-- box-body -->
                <div class="box-body">
                	<div class="row">
                    	<div class="col-md-4">
                            <div class="box box-solid">
                            <div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                                <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> % KELOMPOK UMUR</h3>
                            </div>
                            <div class="box-content">
                                <div id="pie_1" style="height:200px;width:100%"></div>
                                <!--<div style="font-size:14px; color:#0099FF"><center><strong>Jumlah : <?=$TotUmur?> Pasien</strong></center></div>-->
                             </div> 	
                          </div><!-- /.box -->
                            
                        </div>
                        
                        <div class="col-md-4">
                            <div class="box box-solid">
                            <div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                                <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> % PEKERJAAN</h3>
                            </div>
                            <div class="box-content">
                                        <div id="pie_2" style="height:200px;width:100%"></div>
                                        <!--<div style="font-size:14px; color:#0099FF"><center><strong>Jumlah : <?=$TotPekerjaan?> Pasien</strong></center></div>-->
                                    </div> 
                          </div><!-- /.box -->
                            
                        </div>
                        
                        
                        <div class="col-md-4">
                            <div class="box box-solid">
                            <div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                                <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> % PENDIDIKAN</h3>
                            </div>
                            <div class="box-content">
                                    <div id="pie_3" style="height:200px;width:100%"></div>
                                    <!--<div style="font-size:14px; color:#0099FF"><center><strong>Jumlah : <?=$TotPendidikan?> Pasien</strong></center></div>-->
                             </div> 
                          </div><!-- /.box -->
                            
                        </div>
                    </div>
                </div>
                <!-- :box-body -->
                
            	<div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                	<h3 class="box-title">PASIEN BERDASARKAN UMUR/JENIS KELAMIN</h3>
                </div>
                <!-- box-body -->
                <div class="box-body">
                     <div class="row">
                    	<div class="col-md-12">
                        	<div id="chart-bar-usia" style="height:200px"></div>
                        </div>
                     </div>
                </div>
                <!-- :box-body -->
            </div>
            <!-- :box -->
            <!-- :row3 -->
            
            <!-- box -->
            <div class="row">
            	<div class="col-md-12">
                	<div style="padding:10px">
                	<h5 class="box-title">Generated: <?=date("d-m-Y H:i");?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>	
<div id="chart-bar-1" class="hidden" style="height:200px"></div>
<script>
	var gcColor = ["#ff8c00","#268dea","#50b576","#A7CEE5","#fb3e46","#3366cc","#109618","#dc3912","#ff9900","#990099","#0099c6","#dd4477","#66aa00","#b82e2e","#316395","#dddddd"];
	var chartPadding = {top:15,bottom:25,right:15};
	var chartPadding = {top:0,bottom:25,right:15};
	var chartGrid = {
		background: 'rgba(0,0,0,0)',
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


$(document).ready(function(){
	var data_option1={
			color:["#0073b7","#d81b60"],
			ticks:["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"]
		}
  	var c3 = [<?=json_encode($pasien_per_bulan["L"])?>,<?=json_encode($pasien_per_bulan["P"])?>];
	var plot_1 = plot_stack('jml_tahun',c3,[{"label":"Laki-laki"},{"label":"Perempuan"}],data_option1)
	
	var data_p1=<?=$arrDataUmurx?>;
	var data_p2=<?=json_encode($arrDataPekerjaan_val)?>;
	var data_p3=<?=json_encode($arrDataPendidikan_val)?>;
	
	var data_option1={
				"color":gcColor
			};
	var plot_pie_1 = plot_pie("pie_1",data_p1,data_option1);
	var plot_pie_2 = plot_pie("pie_2",data_p2,data_option1);
	var plot_pie_3 = plot_pie("pie_3",data_p3,data_option1);
	
	var data_option2={
			"color":["#0073B7","#D81B60"]
		}
		
	var data_status_rehab=[<?=$imp_rehab?>];
	var data_status_pasca=[<?=$imp_pasca?>];
	var data2=[data_status_rehab,data_status_pasca];
	var series_status_rehab=<?=json_encode($series_status_rehab);?>;
	var data_ticks=["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];
	
	var plot_2 = plot_bar('chart-bar-1',data2,series_status_rehab,data_ticks,data_option1);
	
	var data_ticks_usia=[];
	for(i=11;i<70;i++){
		data_ticks_usia.push(i);
	}
	var series_label_usia=[{"label":"Usia"}];
	//var series_label_usia=<?=json_encode($series_label_sumber_pasien)?>;
	var data_umur_laki=<?=json_encode($data_umur_laki)?>;
	var data_umur_perempuan=<?=json_encode($data_umur_perempuan)?>;
	var data_usia=[data_umur_laki,data_umur_perempuan];
	var series_label_usia=[{"label":"Laki-laki"},{"label":"Perempuan"}];
	
	var plot_3 = plot_bar2("chart-bar-usia",data_usia,series_label_usia,data_ticks_usia,data_option2);
	
	$(window).resize(function() {
          plot_1.replot( { resetAxes: true } );
          plot_3.replot( { resetAxes: true } );
          plot_pie_1.replot( { resetAxes: true } );
          plot_pie_2.replot( { resetAxes: true } );
          plot_pie_3.replot( { resetAxes: true } );
    });
});

function plot_stack(div_id,data1,series_name,option_data){
	return $.jqplot(div_id,data1, {
		seriesColors:option_data.color,
		series:series_name,
		legend: chartLegend,
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
					/*tickOptions: {formatString: '%d'},*/
					/*renderer:$.jqplot.LogAxisRenderer,*/
					min: 0
				}
			},
			highlighter: chartHighlighter
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
				barPadding:1,
				barMargin: 20,
				barWidth:30,
				offsetBars: true
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
			}
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
	var data = <?=$jml_wil?$jml_wil:'false'?>;
    $(function(){
	  propValues = jvm.values.apply({}, jvm.values(data));
	  bnnpValues = Array.prototype.concat.apply([], jvm.values(data.bnnp.value));
      var map = new jvm.Map({
        container: $('.map'),
        map: 'id-'+id_map+'_merc',
		zoomButtons : false,
		zoomOnScroll: false,
		backgroundColor:'rgba(0,0,0,0)',
		//markers: data.bnnp.coords,
		series: {
			/*markers: [{
			  attribute: 'fill',
			  scale: ['#e6aca5', '#A50F15'],
			  values: data.bnnp.value,
			  min: jvm.min(bnnpValues),
			  max: jvm.max(bnnpValues),
			  normalizeFunction: 'polynomial',
			  legend: {
				  vertical: true
			}},{
			  attribute: 'r',
			  scale: [10, 20],
			  values: data.bnnp.value,
			  min: jvm.min(bnnpValues),
			  max: jvm.max(bnnpValues)
			}],*/
			
			regions: [{
			  scale: ['#e6aca5', '#A50F15'],
			  normalizeFunction: 'polynomial',
			  attribute: 'fill',
			  values: data.id,
			  min: jvm.min(propValues),
			  max: jvm.max(propValues),
			  legend: {
				  vertical: true
			  }
			}]
		  },
		  labels: {
			  regions: {
				render: function(code){
				  var doNotShow = ['US-RI', 'US-DC', 'US-DE', 'US-MD'];
		
				  if (doNotShow.indexOf(code) === -1) {
					return data.id[code];
				  }
				}
			  }
		  },
		  
			regionLabelStyle: {
			  initial: {
				'font-size': '18',
				'fill': '#333',
				'stroke':'white'
			  },
			  hover: {
				fill: 'black'
			  }
			},
		  onMarkerTipShow: function(event, label, index){
				label.html(
				  '<b>'+data.bnnp.names[index]+'</b><br/>'+
				  '<b>Pasien Rehabilitasi: </b>'+data.bnnp.value[index]
				);
			  },
		  onRegionTipShow: function(event, label, code){
			  var jml = data.id[code] || false;
        		label.html(
			  '<b>'+label.html()+'</b></br>'+
			  '<b>Pasien rehabilitasi: </b>'+(data.id[code] || 0)
			);
		  },
		  markerStyle:{
			  initial: {
				"fill-opacity": 0.8,
				"stroke-width": 0.5,
				"stroke-opacity": 1
			  }
		  },
		regionStyle:{
		  initial: {
			fill: '#ccc',
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