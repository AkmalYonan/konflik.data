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
</style>

<?
	$total_pasien=$this->conn->GetOne("select count(*) as jumlah from t_pasien");
	//debug();
	$arrDataJenisKelamin=$this->conn->GetAll("select jenis_kelamin,count(*) as jumlah from t_pasien group by jenis_kelamin");
	
	$arrDataSumberPasien=$this->conn->GetAll("select sumber_pasien,count(*) as jumlah from t_pasien group by sumber_pasien");
	if(cek_array($arrDataSumberPasien)):
		foreach($arrDataSumberPasien as $x=>$val):
			$dataSumberPasien[$val["sumber_pasien"]]=$val["jumlah"];
		endforeach;
	endif;
	
	$arrDataSumberBiaya=$this->conn->GetAll("select sumber_biaya,count(*) as jumlah from t_pasien group by sumber_biaya");
	if(cek_array($arrDataSumberBiaya)):
		foreach($arrDataSumberBiaya as $x=>$val):
			$dataSumberBiaya[$val["sumber_biaya"]]=$val["jumlah"];
		endforeach;
	endif;
	
	
	if(cek_array($arrDataJenisKelamin)):
		$dataJenisKelamin=array();
		foreach($arrDataJenisKelamin as $x=>$val):
			$dataJenisKelamin[$val["jenis_kelamin"]]=$val["jumlah"];
			//pre($val["jenis_kelamin"]);
		endforeach;
	endif;
	
	$dataPersenJenisKelamin["L"]=$dataJenisKelamin["L"]*100/($dataJenisKelamin["L"]+$dataJenisKelamin["P"]);
	$dataPersenJenisKelamin["P"]=$dataJenisKelamin["P"]*100/($dataJenisKelamin["L"]+$dataJenisKelamin["P"]);
	
	
	
	$data_pie[]=array("Laki-laki (".$dataJenisKelamin["L"].")",$dataJenisKelamin["L"]);
	$data_pie[]=array("Perempuan (".$dataJenisKelamin["P"].")",$dataJenisKelamin["P"]);
	
	$data_pie2[]=array("Hukum (".$dataSumberPasien["HUKUM"].")",$dataSumberPasien["HUKUM"]);
	$data_pie2[]=array("Napi (".$dataSumberPasien["NAPI"].")",$dataSumberPasien["NAPI"]);
	$data_pie2[]=array("Sukarela (".$dataSumberPasien["SUKARELA"].")",$dataSumberPasien["SUKARELA"]);
	$data_pie2[]=array("Lainnya (".$dataSumberPasien[""].")",$dataSumberPasien[""]);
	
	
	
	$data_pie3[]=array("BNN (".$dataSumberBiaya["BNN"].")",$dataSumberBiaya["BNN"]);
	$data_pie3[]=array("KEMENKES (".$dataSumberBiaya["MENKES"].")",$dataSumberBiaya["MENKES"]);
	$data_pie3[]=array("LAPAS (".$dataSumberBiaya["LAPAS"].")",$dataSumberBiaya["LAPAS"]);
	$data_pie3[]=array("LAINNYA (".$dataSumberBiaya[""].")",$dataSumberBiaya[""]);
	
	
	/* sumber biaya*/
	$lookup_biaya=lookup("m_sumber_biaya","kd_sumber","ur_sumber","","order by order_num");
	if(cek_array($lookup_biaya)):
		foreach($lookup_biaya as $x=>$val):
			$series_label_biaya[]=array("label"=>$val);
		endforeach;
	endif;
	
	$lookup_sumber_pasien=lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='sumber_pasien'","order by order_num");
	if(cek_array($lookup_sumber_pasien)):
		foreach($lookup_sumber_pasien as $x=>$val):
			$series_label_sumber_pasien[]=array("label"=>$val);
		endforeach;
	endif;
	
	//debug();
	/* data pasien berdasarakan umur */
	$arrUmur=$this->conn->GetAll("select umur,count(*) as jumlah from t_pasien group by umur");
	$arrUmurKelamin=$this->conn->GetAll("select jenis_kelamin,umur,count(*) as jumlah from t_pasien group by umur,jenis_kelamin");
	//pre($arrUmurKelamin);
	if(cek_array($arrUmur)):
		foreach($arrUmur as $x=>$val):
			$data_umur_all[$val["umur"]]=$val["jumlah"]*1;
		endforeach;
	endif;
	if(cek_array($arrUmurKelamin)):
		foreach($arrUmurKelamin as $x=>$val):
			if($val["jenis_kelamin"]=="L"):
				$data_umur_laki_laki[$val["umur"]][]=$val["jumlah"]*1;
			endif;
			if($val["jenis_kelamin"]=="P"):
				$data_umur_perempuan[$val["umur"]][]=$val["jumlah"]*1;
			endif;
		endforeach;
	endif;
	//pre($data_umur_perempuan);
	
	
	
	for($i=11;$i<=70;$i++):
		$data_umur_arr[$i]=$data_umur_all[$i]?$data_umur_all[$i]:0;
		$data_umur_laki_arr[$i]=cek_array($data_umur_laki_laki[$i])?array_sum($data_umur_laki_laki[$i]):0;
		$data_umur_perempuan_arr[$i]=cek_array($data_umur_perempuan[$i])?array_sum($data_umur_perempuan[$i]):0;
	endfor;
	//pre($data_umur_perempuan_arr);
	$data_umur=array_values($data_umur_arr);
	$data_umur_laki=array_values($data_umur_laki_arr);
	$data_umur_perempuan=array_values($data_umur_perempuan_arr);
	
	
	//pre(json_encode($data_umur_laki));
	//pre(json_encode($data_umur_perempuan));
?>

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Dashboard</h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="row">
            	<div class="col-md-3">
                	<div class="small-box bg-olive" style="height:170px;">
                        <div class="inner">
                          <h3><label id="total_pasien"><?=$total_pasien?></label></h3>
                          <p>Total Pasien Rehabilitasi</p>
                        </div>
                        <div class="icon">
                          <i class="fa fa-user"></i>
                        </div>
                        <!--<a class="small-box-footer" href="#">
                          More info <i class="fa fa-arrow-circle-right"></i>
                        </a>-->
                      </div>
                </div><!-- end col -->
               
                <div class="col-md-3">
                	<div class="row hidden">
                    	<div class="col-md-12">
                        	<div class="bg-navy">
                        		<p style="text-align:center;font-size:15px;font-weight:bold;">Jenis Kelamin</p>
                        	</div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                    
                    <div class="box box-solid">
                <div class="box-header with-border">
                  <h5 class="box-title">Jenis Kelamin</h5>
                  <div class="box-tools pull-right hidden">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div style="display: block;" class="box-body"><div class="row">
                    	<div class="col-md-6 tc">
                        	    <div class="bg-blue tc"><b>Laki-laki</b></div>
                                <div class="bg-white info-box" style="padding-top:5px;font-size:40px;min-height:72px;">
                                	<label id="jumlah_laki_laki"><?=$dataJenisKelamin["L"]?></label>
                                	
                                </div>
                                
                            
                        </div><!-- end col-->
                        <div class="col-md-6 tc">
                        	    <div class="bg-maroon tc"><b>Perempuan</b></div>
                                <div class="bg-white info-box" style="padding-top:5px;font-size:40px;min-height:72px;">
                                <label id="jumlah_perempuan"><?=$dataJenisKelamin["P"]?></label>
                                	
                                </div>
                                
                               		               
                        </div> <!-- end col -->
                    </div><!-- end row --></div></div><!--./box-->
               
                </div><!-- end col -->
                
               
                
                <div class="col-md-3 hidden">
                	<div class="row">
                    	<div class="col-md-12">
                        	<div class="bg-navy">
                        		<p style="text-align:center;font-size:15px;font-weight:bold;">Jenis Perawatan</p>
                        	</div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                    
                    <div class="box box-solid">
                <div class="box-header with-border">
                  <h5 class="box-title">History Surat</h5>
                  <div class="box-tools pull-right hidden">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div style="display: block;" class="box-body"><div class="row">
                    	<div class="col-md-4 tc">
                        	<div class="bg-red tc"><b>R.Inap</b></div>
                        	<div class="bg-white info-box" style="font-size:30px;min-height:72px;"><label id="jumlah_rawat_inap">100</label>
                            	<div style="font-size:12px">10%</div>
                            </div>
                            
                        </div>
                        <div class="col-md-4 tc">
                        	<div class="bg-orange tc"><b>R.Jalan</b></div>
                        	<div class="bg-white info-box" style="font-size:30px;min-height:72px;">
                            	<label id="jumlah_rawat_jalan">500</label>
                            	<div id="persen_rawat_jalan" style="font-size:12px">50%</div>
                            </div>
                            
                        </div>
                        <div class="col-md-4 tc">
                        	<div class="bg-green tc"><b>Pasca</b></div>
                            <div class="bg-white info-box" style="font-size:30px;min-height:72px;"><label id="jumlah_pasca">100</label>
                            	<div id="persen_pasca" style="font-size:12px">30%</div>
                            </div>
                            
                        </div>
                        
                    </div></div></div><!--./box-->
                    
                    
                </div><!-- end col -->
                
               
                
                <div class="col-md-6">
                	<div class="row hidden">
                    	<div class="col-md-12">
                        	<div class="bg-navy hidden">
                        		<p style="text-align:center;font-size:15px;font-weight:bold;">Sumber Pasien</p>
                        	</div>
                        </div>
                    </div>
                
                	<div class="box box-solid">
                <div class="box-header with-border">
                  <h5 class="box-title">Sumber Pasien</h5>
                  <div class="box-tools pull-right hidden">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div style="display: block;" class="box-body"><div class="row">
                                            <div class="col-md-4 tc">
                                                
                                                <div class="bg-red tc"><b>Hukum</b></div>
                                                <div class="bg-white info-box" style="font-size:30px;min-height:72px;"><label id="jumlah_sukarela"><?=$dataSumberPasien["HUKUM"];?></label>
                                                    <div id="persen_sukarela" style="font-size:12px"><?=$dataSumberPasien["HUKUM"]*100/$total_pasien;?> %</div>
                                                </div>
                                                
                                            </div>
                        
                                            <div class="col-md-4 tc">
                                                <div class="bg-orange tc"><b>Napi</b></div>
                                                <div class="bg-white info-box" style="font-size:30px;min-height:72px;"><label id="jumlah_napi"><?=$dataSumberPasien["NAPI"];?></label>
                                                    <div id="persen_napi" style="font-size:12px"><?=$dataSumberPasien["NAPI"]*100/$total_pasien;?> %</div>
                                                </div>
                                                
                                            </div>
                        
                                            <div class="col-md-4 tc">
                                                <div class="bg-green tc"><b>Sukarela</b></div>
                                                <div class="bg-white info-box" style="font-size:30px;min-height:72px;">
                                                    <label id="jumlah_sukarela"><?=$dataSumberPasien["SUKARELA"];?></label>
                                                    <div id="persen_sukarela" style="font-size:12px"><?=$dataSumberPasien["SUKARELA"]*100/$total_pasien;?> %</div>
                                                </div>
                                                
                                            </div>
                        
                    		
                				</div><!-- end row-->
                           </div> <!-- end col --></div></div><!--./box-->
                           
                    
            </div>
        
        	
		<div class="row">
        	<div class="col-md-4">
            	<div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> Jenis Kelamin</h3>
                       
                </div><!-- /.box-header -->
                <div class="box-content">
                    <div id="pie_1" style="height:200px;width:100%"></div>
                 </div> 	
              </div><!-- /.box -->
            	
            </div>
            
            <div class="col-md-4">
            	<div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> Sumber Pasien</h3>
                       
                </div><!-- /.box-header -->
                <div class="box-content">
                    		<div id="pie_2" style="height:200px;width:100%"></div>
                    	</div> 
              </div><!-- /.box -->
            	
            </div>
            
            
            <div class="col-md-4">
            	<div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> Sumber Biaya</h3>
                       
                </div><!-- /.box-header -->
                <div class="box-content">
                    	<div id="pie_3" style="height:200px;width:100%"></div>
                 </div> 
              </div><!-- /.box -->
            	
            </div>
            
        </div>
		  
          
          <!-- Start MIDDLE CHART -->
          <div class="row">
          	<div class="col-md-6">
            	<div class="box box-solid">
                <div class="box-header with-border">
                  <h5 class="box-title">Sumber Biaya Per Tahun</h5>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div style="display: block;" class="box-body"><div id="chart-bar-1" style="height:200px"></div></div></div><!--./box-->
            </div> <!-- end col -->
            <div class="col-md-6">
            	<div class="box box-solid">
                <div class="box-header with-border">
                  <h5 class="box-title">Sumber Pasien Per Bulan</h5>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div style="display: block;" class="box-body"><div id="chart-bar-2" style="height:200px;width:100%"></div></div></div><!--./box-->
            
            </div><!-- end col -->
          </div>
          <!-- END MIDDLE CHART -->
          
          <div class="row">
          	<div class="col-md-12">
            	<div class="box box-solid">
                <div class="box-header with-border">
                  <h5 class="box-title">Pasien berdasarkan umur dan jenis kelamin</h5>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div style="display: block;" class="box-body"><div id="chart-bar-usia"></div></div></div><!--./box-->
            </div><!-- end col -->
          </div><!-- end row -->
		  
          <!-- Main row -->
          <div class="row hidden">
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
//var kls_ticks = <?=json_encode($komposisi_wilayah_each)?>;
//var kls_values = <?=json_encode($komposisi_wilayah_val)?>;
//var kls_label = [<?=implode(",",$komposisi_status_pegawai)?>];
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
	


$(document).ready(function(){
  	
	 //BAR
	/*
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
	  */

});

	$(function(){
		/*var data_p1 = [
    		['U1', 50],
			['U2', 50],
			['U3', 50],
			['U4', 50],
			['U5', 50],
			['U6', 50]
  		];*/
		var data_p1=<?=json_encode($data_pie)?>;
		var data_p2=<?=json_encode($data_pie2)?>;
		var data_p3=<?=json_encode($data_pie3)?>;
		
		var data_option1={
					"color":gcColor
				};
		plot_pie("pie_1",data_p1,data_option1);
		plot_pie("pie_2",data_p2,data_option1);
		plot_pie("pie_3",data_p3,data_option1);
		
		var data_option2={
				"color":["#0073B7","#D81B60"]
			}
		
	var s1 = [2,3,10];
  	var s2 = [7,5,10];
  	var s3 = [14,15,10];
	
	var data1=[s1,s2,s3];
	var series_label_biaya=<?=json_encode($series_label_biaya);?>;
	var data_ticks=["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];
	plot_bar('chart-bar-1',data1,series_label_biaya,data_ticks,data_option1);
	
	var series_label_sumber_pasien=<?=json_encode($series_label_sumber_pasien)?>;
	plot_bar('chart-bar-2',data1,series_label_sumber_pasien,data_ticks,data_option1);
	
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
	plot_bar2("chart-bar-usia",data_usia,series_label_usia,data_ticks_usia,data_option2);
		
	});

	function plot_stack(div_id,data1,series_name,option_data){
		var plot1=$.jqplot(div_id,data1, {
				seriesColors:option_data.color,
				series:series_name,
				legend: chartLegend,
				/*gridPadding:chartPadding,*/
				grid: chartGrid,
				stackSeries: true,
				seriesDefaults:{
					renderer:$.jqplot.BarRenderer,
					rendererOptions: {
						barMargin: 30,
						barWidth:10
					},
					shadow:true,
				},axesDefaults: chartAxesDefault,
					axes: {
						xaxis: {
							renderer: $.jqplot.CategoryAxisRenderer,
							ticks: ["Bermasalah","Tak Bermasalah","test"]						},
						yaxis: {
							padMin: 0,
							/*tickOptions: {formatString: '%d'},*/
							/*renderer:$.jqplot.LogAxisRenderer,*/
							min: 0
						}
					},
					highlighter: chartHighlighter,
					/*cursor: chartCursor,*/
					legend: {
				  		renderer: $.jqplot.EnhancedLegendRenderer,
						show: true,
				  		location: 'nw',
				  		placement: 'outside',
						rendererOptions: {
							numberRows:1
						}
					}  
				});
	
	}

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
						barWidth:10,
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
		
		function plot_bar2(div_id,data1,series_name,data_ticks,option_data){
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