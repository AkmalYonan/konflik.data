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
    
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.highlighter.js"></script>
    <script type="text/javascript" src="assets/js/plugins/chart/jqplot1.0/plugins/jqplot.cursor.js"></script>

	<link href="assets/js/jvm/jquery-jvectormap.css" rel="stylesheet" />
    <script type="text/javascript" src="assets/js/jvm/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="assets/js/jvm/id<?=$jsmappath?>/jquery.jvm.<?=$jsmap?>.js"></script>
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
.nav-tabs.nav-justified > li > a {
    color: #ccc;
}
.jvectormap-legend-cnt-h {
    bottom: 20px;
    left: 10px;
	max-width: 180px;
}
.jvectormap-legend-cnt-v {
    top: 10px;
    right: 10px;
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
.info-box-content {
    padding: 5px 10px;
    margin-left: 0px!important;
}
.description-block > .description-header {
    font-size: 30px;
}
.info-box {
	/*margin-bottom:0px;*/
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
.nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:focus, .nav-tabs.nav-justified > .active > a:hover {
    border: 0px solid #ddd;
}
.info-top {
	font-size:40px;
	padding:5px;
}

.progress {
    background-color: #ddd;
	margin-bottom:10px;
}
.progress-group .progress-text {
    font-weight: normal!important;
}

.table > thead > tr > th {
	background:#777!important;
	color:#fff!important;
}
.table > thead:last-child > tr > th {
	background:transparent!important;
	color:#777!important;
	border-top:2px double #ccc
}
.badge-status {
	font-size:14px!important;
}
.table > thead > tr > th:last-child {
	padding-right:20px
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
<!--<section class="content-header">
  <h1 class="hidden-xs">
    <?=$this->module_title?></h1>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo $this->module?>" class="active"><?=$this->module_title?></a></li>
  </ol>
</section>-->
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
                        <label for="tahun">Tahun</label>
                        <select id="tahun" name="tahun" class="form-control">
                            <option value="">Semua</option>
                            <?php foreach($tahun as $k=>$v): ?>
                            <option value="<?=$v?>" <?=($selected_tahun==$v)?"selected":""?>><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="bulan">s/d Bulan</label>
                        <select id="bulan" name="bulan" class="form-control">
                            <option value="">Semua Bulan</option>
                            <?php foreach($listMonth as $k=>$v): ?>
                            <option value="<?=($k+1)?>" <?=($selected_bulan==($k+1))?"selected":""?>><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="tipe_inst">Instansi</label>
                      	<? //form_dropdown("tipe_instansi",$this->lookup_instansi,$tipe_instansi,"id='tipe_instansi' class='form-control select2 required'");?>
                      	<?=form_dropdown("tipe_instansi",$lookup_kd_instansi,$tipe_instansi,"id='tipe_inst' class='form-control select2 required'");?>
                      </div>
                      <div class="form-group">
                        <label for="wil_inst">Wilayah</label>
                        <?=form_dropdown("kd_org",$lookup_wilayah,$kd_org,"id='wil_inst' class='form-control select2 required'");?>
                      </div>
                      <button id="btn_search" type="submit" class="btn btn-white">Tampilkan</button>
                      <button id="btn_reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-remove text-red"></i></button>
                    </form>
                    </div>
                </div>
            </div>
            <!-- : TOOLBAR -->

            <!-- TAB -->
            <? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <ul class="nav nav-tabs nav-justified" id="myTabs" role="tablist" style=" position:relative;margin-bottom:10px;"> 
                <li><a href="admin/dashboard">SUMMARY</a></li>
                <li class="active"><a href="<?=$this->module?>">PROSES REHABILITASI</a></li>
                <li><a href="admin/dashboard_pasca">PASCA REHABILITASI</a></li>
                <li><a href="admin/dashboard_instansi">IPWL dan IP NON IPWL</a></li>
				<li><a href="admin/dashboard_km">KM dan RD </a></li>
            </ul>
            <!-- :TAB -->
            
            <?
				$_title = "";
				$t=number_format($jumlah,0,".",".");	
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
			
            <!-- MAP -->
            <div class="row">
                <div class="col-md-12" style="position:relative">
                	<div style="position:absolute; top:140px; height:100px; right:60px; font-size:150px; line-height:100px; color:rgba(100,100,100,0.1)"><?=$selected_tahun?></div>
                	<div style="position:absolute; top:180px; right:80px; font-size:40px; color:rgba(100,100,100,0.2)"><?=$selected_bulan?$listMonth[$selected_bulan-1]:""?></div>
                        
                	<div class="box-header with-borders" style="background:rgba(255,255,255,.5); margin-top:-8px">
                    	<div class="row">
                        	<div class="col-md-4">
                            	<h3 class="box-title" style="text-transform:uppercase"><strong>DASHBOARD REHABILITASI</strong></h3>
                                <h5>Pasien yang sedang menjalani Proses Rehabilitasi<br />
                                s/d Bulan <?=$listMonth[$selected_bulan-1]?> Tahun <?=$selected_tahun?></h5>
                                <h5 style="text-transform:uppercase"><?=$kd_org?$lookup_wilayah[$kd_org]:"Seluruh Wilayah"?></h5>
                            	<div style="border-top:1px solid #ddd">
                                	<span class="pull-right">v 1.0</span>
                                    <img src="assets/images/sirena-grey-16.png" />
                                </div>
                            </div>
                            <div class="col-md-8">
                            	<div class="row">
                                	<div class="col-md-3">
                                    	<h3 class="box-title">TOTAL</h3>
                                        <div class="info-top"><?=$t;?></div>
                                    </div>
                                    <div class="col-md-3 text-aqua">
                                    	<h3 class="box-title">REHABILITASI</h3>
                                        <div class="info-top"><?=$rehab_proses;?></div>
                                    </div>
                                    <div class="col-md-3 text-red">
                                    	<h3 class="box-title">DROP OUT</h3>
                                        <div class="info-top"><?=$sp_do;?></div>
                                    </div>
                                    <!--<div class="col-md-2 text-orange">
                                    	<h3 class="box-title">KAMBUH</h3>
                                        <div class="info-top"><?=$rehab_kambuh;?></div>
                                    </div>-->
                                    <div class="col-md-3 text-muted">
                                    	<h3 class="box-title">MENINGGAL</h3>
                                        <div class="info-top"><?=$sp_md;?></div>
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
            <? if ($jumlah>0):?>
            <div class="row">
            	<div class="col-md-12">
                    <!-- box -->
                    <div class="box box-widgets" style="background:rgba(255,255,255,.0); border:none;">
                    	<div class="box-header">
                        	<div class="row">
                                <div class="col-md-8">
                                    <h3 class="box-title">SEBARAN LOKASI</h3>
                                </div>
                                <div class="col-md-4">
                                    <!--<h3 class="box-title">PASIEN SELESAI (<em>OUTCOME</em>)</h3>-->
                                </div>
                            </div>
                        </div>
                        <!-- box-body -->
                        <style>
						.tbl-fixed thead tr{
							display:block;
						}
						
						.tbl-fixed th,.tbl-fixed td{
							width:100%;//fixed width
						}
						
						
						.tbl-fixed  tbody{
						  display:block;
						  height:100px;
						  overflow:auto;//set tbody to auto
						}
						</style>
                        <div class="box-body">
                            <div class="row">
                            	<? if (cek_array($top5_wil)): $i=0;?>
                                <div class="col-md-<?=(cek_array($top5_bl))?4:8?>">
                                    <!--5wil-->
                                    
                                    <div class="box-content">
                                        <? if (cek_array($top5_wil)): ?>
                                        <table class="table table-striped table-condensed tbl-fixed">
                                            <thead>
                                                <tr>
                                                    <th>BNNP/BNNK</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        	<? foreach($top5_wil as $k=>$v) : $total_wilayah+=$v['jumlah']; ?>
                                            <tr>
                                                <td><?=$data_lookup[$level][$v['kd']]?></td>
                                                <td><strong><?=$v['jumlah']?></strong></td>
                                            </tr>
                                        	<? endforeach;?>
                                        	</tbody>
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                    <th><?=$total_wilayah?></th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <? endif?>
                                     </div> 
                                     <!--:5wil-->                                 	
                                </div>
                                <? endif?>
                                
                                <? if (cek_array($top5_bl)): $i=0;?>
                                <div class="col-md-<?=(cek_array($top5_wil))?4:8?>">
                                    <!--5loka-->
                                    <div class="box-content">
                                        <table class="table table-striped table-condensed tbl-fixed">
                                        	<thead>
                                                <tr>
                                                    <th>BALAI/LOKA</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        <? foreach($top5_bl as $k=>$v) : $total_blbb+=$v['jumlah'];?>
                                                <tr>
                                                    <td><?=$v['nama']?></td>
                                                    <td><strong><?=$v['jumlah']?></strong></td>
                                                </tr>
                                        <? $i++; endforeach;?>
                                        	</tbody>
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                    <th><?=$total_blbb?></th>
                                                </tr>
                                            </thead>
                                        </table>
                                     </div> 
                                     <!--:5loka-->	
                                </div>
                                <? endif?>
                                <?
									$pp=number_format(($pulih_produktif/$selesai)*100,2,".",".");
									$ptp=number_format(($pulih_tidak_produktif/$selesai)*100,2,".",".");
									$tpp=number_format(($tidak_pulih_produktif/$selesai)*100,2,".",".");
									$tptp=number_format(($tidak_pulih_tidak_produktif/$selesai)*100,2,".",".");
								?>
                                <div class="col-md-4">
                                  <div id="jml_per_bulan" style="height:150px" class="hides"></div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--:box-->
                </div>
                <!--:col-->
            </div>
            <!--:row-->

			<div class="box box-widget">
                <!-- box-body -->
                <div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                	<div class="row">
                        <div class="col-md-8">
                            <h3 class="box-title">TAHAPAN PROSES</h3>
                        </div>
                        <div class="col-md-4">
                            <h3 class="box-title">&nbsp;</h3>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12" style="position:relative">
                            <table class="table table-bordered table-condensed small-font" style="margin-bottom:0">
                                <thead>
                                    <tr>
                                      <td colspan="4" align="center" bgcolor="#eeeeee">RAWAT INAP</td>
                                      <td colspan="3" align="center" bgcolor="#eeeeee">RAWAT JALAN</td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="width:14.2%"><strong>Detoksifikasi</strong></td>
                                        <td align="center" style="width:14.2%"><strong>Entry Unit</strong></td>
                                        <td align="center" style="width:14.2%"><strong>Primary Treatment</strong></td>
                                        <td align="center" style="width:14.2%"><strong>Re-entry</strong></td>
                                        <td align="center" style="width:14.2%"><strong>Konseling</strong></td>
                                        <td align="center" style="width:14.2%"><strong>T.Kelompok</strong></td>
                                        <td align="center"><strong>T.Simptomatik</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:40px;">
                                        <td style="color:#ff8c00" align="center"><?=$dt?></td>
                                        <td style="color:#268dea" align="center"><?=$eu?></td>
                                        <td style="color:#50b576" align="center"><?=$pt?></td>
                                        <td style="color:#A7CEE5" align="center"><?=$re?></td>
                                        <td style="color:#fb3e46" align="center"><?=$kl?></td>
                                        <td style="color:#3366cc" align="center"><?=$tk?></td>
                                        <td style="color:#109618" align="center"><?=$ts?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- :box-body -->
            </div>

            <!-- box -->
            <div class="box box-widget">
            	<div class="box-header with-borders"  style="position:absolutes; z-index:10000">
                	<div class="row">
                        <div class="col-md-8">
                            <h3 class="box-title">PASIEN BERDASARKAN UMUR/JENIS KELAMIN</h3>
                        </div>
                        <div class="col-md-4">
                            <h3 class="box-title">&nbsp;</h3>
                        </div>
                    </div>
                </div>
                <!-- box-body -->
                <div class="box-body">
                	<div class="row">
                        <div class="col-md-8" style="position:relative">
                            <div id="chart-bar-usia" style="height:170px"></div>
                        </div>
                        <div class="col-md-4">
                          <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-6">
                              <div class="bg-blue" style="padding:2px 10px"><b>LAKI-LAKI</b></div>
                              <div class="info-box">
                                <div class="info-box-content">
                                
                                  <div class="pull-right visible-xs">
                                  	<span class="info-box-text2">Persentase</span>
                                    <span class="info-box-number2"><?=$pjkl*100;?><small>%</small></span>
                                  </div>
                                  <span class="info-box-number text-blue"><?=$jkl;?></span>
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
                                  <span class="info-box-number text-maroon"><?=$jkp;?></span>
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
            
            <!-- row 3-->
            <!-- box -->
            <div class="box box-widget">
                <!-- box-body -->
                <div class="box-body">
                	<div class="row">
                    	<div class="col-md-4">
                            <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> SUMBER PASIEN</h3>
                            </div>
                            <div class="box-content">
                                <div id="pie_sp" style="height:160px;width:100%"></div>
                             </div> 	
                          </div><!-- /.box -->
                        </div>
                        <div class="col-md-4">
                            <div class="box box-solid">
                            <div class="box-header with-borders">
                                <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> SUMBER BIAYA</h3>
                            </div>
                            <div class="box-content">
                                <div id="pie_sb" style="height:160px;width:100%"></div>
                             </div> 	
                          </div><!-- /.box -->
                        </div>
                        
                    	<div class="col-md-4">
                            <div class="box box-solid">
                            <div class="box-header with-borders">
                                <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> KELOMPOK UMUR</h3>
                            </div>
                            <div class="box-content">
                                <div id="pie_1" style="height:160px;width:100%"></div>
                                <!--<div style="font-size:14px; color:#0099FF"><center><strong>Jumlah : <?=$TotUmur?> Pasien</strong></center></div>-->
                             </div> 	
                          </div><!-- /.box -->
                            
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                            <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> PEKERJAAN</h3>
                            </div>
                            <div class="box-content">
                                        <div id="pie_2" style="height:160px;width:100%"></div>
                                        <!--<div style="font-size:14px; color:#0099FF"><center><strong>Jumlah : <?=$TotPekerjaan?> Pasien</strong></center></div>-->
                                    </div> 
                          </div><!-- /.box -->
                            
                        </div>
                        
                        
                        <div class="col-md-4">
                            <div class="box box-solid">
                            <div class="box-header with-borders">
                                <h3 class="box-title"><i class="fa fa-fw fa-pie-chart"></i> PENDIDIKAN</h3>
                            </div>
                            <div class="box-content">
                                    <div id="pie_3" style="height:160px;width:100%"></div>
                                    <!--<div style="font-size:14px; color:#0099FF"><center><strong>Jumlah : <?=$TotPendidikan?> Pasien</strong></center></div>-->
                             </div> 
                          </div><!-- /.box -->
                            
                        </div>
                        <div class="col-md-4">
                                    <? if (cek_array($arrDataUmur_legend)): ?>
                                    	<table class="table table-condensed">
                                    	<? foreach($arrDataUmur_legend as $k=>$v):?>
											<tr>
                                            	<td>&nbsp;<strong><?=$k?></strong></td>
                                                <td><?=$v?> tahun</td>
                                            </tr>
										<? endforeach?>
                                        </table>
                                    <? endif?>
                        </div>
                    </div>
                </div>
                <!-- :box-body -->
            </div>

            
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
        </div>
    </div>
</section>	
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
	var data_option1={
			color:["#aaa","#d81b60"],
			ticks:["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
			legend:false
		}
  	//var c3 = [<?=json_encode($pasien_per_bulan["L"])?>,<?=json_encode($pasien_per_bulan["P"])?>];
	//var plot_0 = plot_stack('jml_per_bulan',c3,[{"label":"Laki-laki"},{"label":"Perempuan"}],data_option1);

  	var c3 = [<?=json_encode($pasien_per_bulan["A"])?>];
	var plot_0 = plot_bar('jml_per_bulan',c3,[{"label":"Pasien Perbulan"}],data_option1.ticks,data_option1);
	
	var data_p1=<?=json_encode($arrDataUmur_val)?>;
	var data_p2=<?=json_encode($arrDataPekerjaan_val)?>;
	var data_p3=<?=json_encode($arrDataPendidikan_val)?>;
	var data_p_sp=<?=json_encode($arrSumberPasien_val)?>;
	var data_p_sb=<?=json_encode($arrSumberBiaya_val)?>;
	
	var data_option1={"color":gcColor};
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
	
	$(window).resize(function() {
          plot_0.replot( { resetAxes: true } );
          plot_1.replot( { resetAxes: true } );
          plot_3.replot( { resetAxes: true } );
          plot_pie_1.replot( { resetAxes: true } );
          plot_pie_2.replot( { resetAxes: true } );
          plot_pie_3.replot( { resetAxes: true } );
    });
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
<? endif?>
<script>
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
    });
  </script>