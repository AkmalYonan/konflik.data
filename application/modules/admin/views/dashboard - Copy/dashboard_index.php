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

<link href="assets/js/jvm/jquery-jvectormap.css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/jvm/jquery-jvectormap-2.0.3.min.js"></script>
<script src="assets/js/jvm/id<?=$jsmappath?>/jquery.jvm.<?=$jsmap?>.js"></script> 

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
	padding:5px 5px 5px 0;
}
.info-top small {
	display:block;
	font-size:11px;
	padding:1px 5px;
	border-top:1px solid #ddd;
	color:#777;
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

                      <button id="btn_search" type="submit" class="btn btn-white">Tampilkan</button>
                      <button id="btn_reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-remove text-red"></i></button>
                      <!--<button id="btn_print" class="btn btn-white pull-right" data-toggle='tooltip' title="Save as PDF"><i class="fa fa-file-pdf-o"></i></button>-->
                    </form>
                    </div>
                </div>
            </div>
            <!-- : TOOLBAR -->

            <!-- TAB -->
            <? if (message_box()) :?><?php echo message_box();?><? endif; ?>


            <!-- MAP -->
            <div class="row">
                <div class="col-md-12" style="position:relative">

                	<div class="box-header with-borders" style="background:rgba(255,255,255,.6); margin-top:-8px">
                    	<div class="row">
                        	 <div class="col-md-3">
                            	<h3 class="box-title" style="text-transform:uppercase"><strong>DASHBOARD LAND CONFLICT</strong></h3>
                                <!--<h5>s/d Bulan <?=$listMonth[$selected_bulan-1]?> Tahun <?=$selected_tahun?></h5>
                                <h5 style="text-transform:uppercase"><?=$nama_wilayah?></h5>-->
                            	<div style="border-top:0px solid #ddd">
                                	<!--<span class="pull-right">v 1.0</span>
                                    <img src="assets/images/sirena-grey-16.png" />-->
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6">
                            	  <div class="row">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row" style="margin-top:2px;">
                <div class="col-md-12" style="position:relative">
                	<div class="box-header with-borders" style="background-color:#ffffff;">
                    	<div class="row">
                        <div class="col-md-3">
                          <div>
                            <div class="row">
                              <div class="col-md-12 border-right" >
                                <div class="panel-title">
                                    <h6> <span style="border-radius: 0px !important;" class="label label-danger pull-right">Konfilk</span></h6>
                                </div>
                                <div class="description-block" style="text-align:left !important;border-right:1px solid #d6d6c2">
                                  <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                  <h5 class="description-header"><?=number_format($main['jumlah_konflik']);?> </h5>
                                  <span style="color:green">( number )</span><br />
                                  <span class="description-text">Jumlah Konflik</span>
                                  <br />
                                </div>

                              </div>
                              </div>
                          </div>

                        </div>
                            <div class="col-md-3">
                              <div>
                                <div class="row">
                                  <div class="col-md-12 border-right" >
                                    <div class="panel-title">
                                        <h6> <span style="border-radius: 0px !important;" class="label label-info pull-right">Dampak</span></h6>
                                    </div>
                                    <div class="description-block" style="text-align:left !important;border-right:1px solid #d6d6c2">
                                      <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                      <h5 class="description-header"><?=number_format($main['jumlah_dampak']);?> </h5>
                                      <span style="color:green">( jiwa )</span><br />
                                      <span class="description-text">Jumlah Terkena Dampak Konflik</span>
                                    </div>


                                  </div>
                                  </div>
                              </div>

                            </div>
                            <div class="col-md-3">
                              <div>
                                <div class="row">
                                  <div class="col-md-12 border-right" >
                                    <div class="panel-title">
                                        <h6> <span style="border-radius: 0px !important;" class="label label-warning pull-right">Lahan</span></h6>
                                    </div>
                                    <div class="description-block" style="text-align:left !important; border-right:1px solid #d6d6c2 ">
                                      <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                      <h5 class="description-header"><?=number_format($main['jumlah_luas_wil']);?> </h5>
                                      <span style="color:green">( in Hektar )</span><br />
                                      <span class="description-text">Jumlah Luas Konfilk </span>
                                    </div>


                                  </div>
                                  </div>
                              </div>

                            </div>
                            <div class="col-md-3">
                              <div>
                                <div class="row">
                                  <div class="col-md-12 border-right" >
                                    <div class="panel-title">
                                        <h6> <span style="border-radius: 0px !important;" class="label label-success pull-right">investasi</span></h6>
                                    </div>
                                    <div class="description-block" style="text-align:left !important; ">
                                      <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                      <h5 class="description-header"><?=number_format($main['jumlah_investasi']);?> </h5>
                                      <span style="color:green">( in Rupiah )</span><br />
                                      <span class="description-text">Nilai Investasi </span>
                                    </div>
                                    <!--<div class="text-danger pull-right">53% <i class="fa fa-bolt"></i></div>
                                    <small>Jumlah Konfilk</small>-->
                                    <!-- /.description-block -->
                                  </div>
                                  </div>
                              </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
              <div style="padding:12px;">

                <div class="col-md-8" style="position:relative">
                    <div class="map" style="background: transparent;width: 100%; height: 400px; margin-top:-10px; margin-bottom:-20px"></div>
                    <!--here-->
                    <!-- box -->
                    <div class="box box-widgets" style="background:rgba(255,255,255,.0); border:none;">
                    	<div class="box-header">
                        	<div class="row">
                                <div class="col-md-8">
                                    <h3 class="box-title">SEBARAN LOKASI</h3>
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-<?=(cek_array($top5_bl))?6:12?>">
                                    <!--5wil-->

                                    <div class="box-content">

                                        <? if (cek_array($top5_wil)): ?>
                                        <table class="table table-striped table-condensed tbl-fixed">
                                            <thead>
                                                <tr>
                                                    <th>BERDASARKAN PROPINSI</th>
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
                                <div class="col-md-<?=(cek_array($top5_wil))?6:12?>">
                                    <!--5loka-->
                                    <div class="box-content">
                                        <table class="table table-striped table-condensed tbl-fixed">
                                        	<thead>
                                                <tr>
                                                    <th>BERDASARKAN SEKTOR</th>
                                                    <th>Jumlah</th>
                                                    <th >Luas</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                        <? foreach($top5_bl as $k=>$v) :
                                          $total_blbb+=$v['jumlah'];
                                          $total_luas+=$v['tot_luas'];?>
                                                <tr>
                                                    <td><?=$v['nama']?></td>
                                                    <td><strong><?=$v['jumlah']?></strong></td>
                                                    <td><strong><?=number_format(ceil($v['tot_luas']))?></strong>Ha</td>
                                                </tr>
                                        <? $i++; endforeach;?>
                                        	</tbody>
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                    <th><?=$total_blbb?></th>
                                                    <th><?=number_format(ceil($total_luas))?>Ha</th>
                                                </tr>
                                            </thead>
                                        </table>
                                     </div>
                                     <!--:5loka-->
                                </div>
                                <? endif?>


                            </div>
                        </div>
                    </div>
                    <!--:box-->
                </div>
                <div class="col-md-4" style="position:relative; background-color:#ffffff !important">

                      <h5 class="box-title" style="text-transform:uppercase"><strong>REKAP DATA LAND CONFLICT</strong></h5>
                        <!--<h5>s/d Bulan <?=$listMonth[$selected_bulan-1]?> Tahun <?=$selected_tahun?></h5>
                        <h5 style="text-transform:uppercase"><?=$nama_wilayah?></h5>-->
                      <div style="border-top:1px solid #ddd">
                      </div>
                      <?//pre($main);?>
                      <div class="row hidden">
                      <div class="col-md-5">
                        <div class="info-box">
                          <div class="info-box-content">
                              <span class="info-box-number text-red"><?=$main['jumlah_konflik'];?><small><span class="info-box-text2 hidden-xs">Number Of Konflik</span></small></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-7">
                        <div class="info-box">
                          <div class="info-box-content">
                          <span class="info-box-number text-red"><?=number_format($main['jumlah_dampak']);?><small><span class="info-box-text2 hidden-xs">Number Of People Affected</span></small></span></div>
                        </div>
                      </div>
                    </div>

                      <div class="row hidden">
                      <div class="col-md-12 ">
                        <div class="description-block border-right" style="text-align:left !important">

                          <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 17%</span>
                          <h5 class="description-header">Rp.<?=number_format($main['jumlah_investasi'],2,",",".");?></h5>
                          <span class="description-text">Amount Investment ( in Rupiah )</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </div>
                    <div style="border-top:1px solid #ddd"></div>
                    <div class="row hidden">
                      <div class="col-md-12 ">
                        <div class="description-block border-right" style="text-align:left !important">
                          <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                          <h5 class="description-header"><?=number_format($main['jumlah_luas_wil']);?> Ha</h5>
                          <span class="description-text">Number Of Land Affected  ( in Ha )</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      </div>
                      <h6 class="box-title" style="text-transform:uppercase"><strong>2</strong> KONFLIK TERBARU</h6>
                      <div class="row">
                      <div class="col-md-12">
                      <ul class="products-list product-list-in-box">
                        <style>
                        .grayscale{
                          	filter: grayscale(100%);
                          	-webkit-filter: grayscale(100%);
                          	-moz-filter: grayscale(100%);
                          	-ms-filter: grayscale(100%);
                          	-o-filter: grayscale(100%);
                          	filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale"); /* Firefox 3.5+ */
                          }
                        </style>
                        <? foreach ($top5_bydate as $k => $v) :?>
                        <li class="item">
                          <div class="product-img grayscale">
                            <img src="assets/images/logo.jpg" width="90">
                          </div>
                          <div class="product-info">
                            <span class="product-title"><?=$v['judul']?></span>
                                <br /><span style="font-size:12px;" class="product-description "><?=$v['created']?></span>
                                <span  style="font-size:13px;">
                                  Sektor : <?=$sektor[$v['kd_sektor']]?> , Luas : <?=$v['luas']?> , Dampak : <?=$v['dampak']?> Jiwa
                                </span>
                          </div>
                        </li>
                        <div style="border-top:1px solid #ddd"></div>
                      <? endforeach;?>



                      </ul>
                    </div>
                  </div>
                      <div style="border-top:1px solid #ddd"></div>


                      <br />
                      <h6 class="box-title" style="text-transform:uppercase">GRAFIK DATA KONFLIK PERBULAN</h6>
                      <div id="jml_per_bulan" style="height:150px" class="hides"></div>

                      <br />

                      <h6 class="box-title" style="text-transform:uppercase">GRAFIK DATA KONFLIK PERTAHUN</h6>
                      <div id="jml_tahun" style="height:70px; margin-top:10px" class="hides"></div>

                        <br />

                </div>
            </div>
          </div>
            <? if ($jumlah>0):?>
            <div class="box box-widget">
                <!-- box-body -->
                    <div class="box-header with-borders"  style="position:absolutes;">
                        <h3 class="box-title">LAND CONFLICT BERDASARKAN SEKTOR/JENIS LAHAN</h3>
                    </div>
                    <!-- box-body -->
                    <div class="box-body">
                         <div class="row">
                            <div class="col-md-8">
                                <div id="chart-bar-usia" style="height:170px"></div>
                            </div>
                            <div class="col-md-4">
                              <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                  <div class="" style="padding:2px 10px"><b>PRIBADI-UMUM</b></div>
                                  <div class="info-box">
                                    <div class="info-box-content">

                                      <span class="info-box-number text-blue"><?=$main['PU'];?></span>
                                      <? if (!$periode) : ?>
                                      <span class="info-box-text2 hidden-xs">Persentase</span>
                                      <span class="info-box-number2 hidden-xs"><?=ceil($main['PU']*100/$main['jumlah_konflik']);?><small>%</small></span>
                                      <? endif; ?>
                                    </div>
                                    <!-- /.info-box-content -->

                                  </div>
                                  <!-- /.info-box -->
                                  <div class="text-blue" style="margin-top:-10px; text-align:center; opacity:.7">
                                  <?//for($i=0;$i<floor($pjkl*10);$i++) {?><!--<i class="fa fa-male"></i>&nbsp;--><? //}?>
                                  </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                  <div class="" style="padding:2px 10px"><b>UMUM</b></div>
                                  <div class="info-box">
                                    <div class="info-box-content">
                                      <div class="pull-right visible-xs">
                                        <span class="info-box-text2">Persentase</span>
                                        <span class="info-box-number2"><?=$pjkp*100;?><small>%</small></span>
                                      </div>
                                      <span class="info-box-number text-maroon"><?=$main['U'];?></span>
                                      <? if (!$periode) : ?>
                                      <span class="info-box-text2 hidden-xs">Persentase</span>
                                      <span class="info-box-number2 hidden-xs"><?=ceil($main['U']*100/$main['jumlah_konflik']);?><small>%</small></span>
                                      <? endif;?>
                                    </div>
                                    <!-- /.info-box-content -->
                                  </div>
                                  <!-- /.info-box -->
                                  <div class="text-maroon" style="margin-top:-10px; text-align:center; opacity:.7">
                                  <?//for($i=0;$i<floor($pjkp*10);$i++) {?><!--<i class="fa fa-female"></i>&nbsp;--><? //}?>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                  <style>
                                  .tosca {  background-color: '#339933';}
                                  </style>
                                  <div  style="padding:2px 10px;"><b>PRIBADI</b></div>
                                  <div class="info-box">
                                    <div class="info-box-content">
                                      <div class="pull-right visible-xs">
                                        <span class="info-box-text2">Persentase</span>
                                        <span class="info-box-number2"><?=$pjkp*100;?><small>%</small></span>
                                      </div>
                                      <span class="info-box-number text-green"><?=$main['P'];?></span>
                                      <? if (!$periode) : ?>
                                      <span class="info-box-text2 hidden-xs">Persentase</span>
                                      <span class="info-box-number2 hidden-xs"><?=floor($main['P']*100/$main['jumlah_konflik']);?><small>%</small></span>
                                      <? endif;?>
                                    </div>
                                    <!-- /.info-box-content -->
                                  </div>
                                  <!-- /.info-box -->
                                  <div class="text-maroon" style="margin-top:-10px; text-align:center; opacity:.7">
                                  <?//for($i=0;$i<floor($pjkp*10);$i++) {?><!--<i class="fa fa-female"></i>&nbsp;--><? //}?>
                                  </div>
                                </div>
                                <!-- /.col -->
                              </div>
                            </div>
                         </div>
                    </div>
                    <!-- :box-body -->
            </div>
            <!-- :box -->


            <!-- box -->


            <!-- box -->
            <div class="row">
            	<div class="col-md-6">
                	<div style="padding:10px">
                	<h5 class="box-title">Generated: <?=date("d-m-Y H:i");?></h5>
                    </div>
                </div>
                <div class="col-md-6">
                	<div style="padding:10px">

                  <div class="pull-right grayscale">
                    <img src="assets/images/logo.jpg" width="120">
                  </div>
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
	var ct = [<?=json_encode($pasien_per_tahun)?>];
	var plot_1 = plot_line('jml_tahun',ct,[],{color:["#aaa"],legend:false})

	var data_option1={
			color:["#aaa","#d81b60"],
			ticks:["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
			legend:false
		}
  	//var c3 = [<?=json_encode($pasien_per_bulan["L"])?>,<?=json_encode($pasien_per_bulan["P"])?>];
	//var plot_0 = plot_stack('jml_per_bulan',c3,[{"label":"Laki-laki"},{"label":"Perempuan"}],data_option1);

  var c3 = [<?=json_encode($pasien_per_bulan["A"])?>];

	var plot_0 = plot_bar('jml_per_bulan',c3,[{"label":"Data Konflik Perbulan"}],data_option1.ticks,data_option1);

	var data_p0=[["ASSESMENT",<?=(int)$assesment?>],["REHAB",<?=(int)$rehab?>],["PASCA",<?=(int)$pasca?>],["OUTCOME",<?=(int)$selesai?>]];


	var data_p1=<?=json_encode($arrDataUmur_val)?>;
	var data_p2=<?=json_encode($arrDataPekerjaan_val)?>;
	var data_p3=<?=json_encode($arrDataPendidikan_val)?>;
	var data_p_sp=<?=json_encode($arrSumberPasien_val)?>;
	var data_p_sb=<?=json_encode($arrSumberBiaya_val)?>;

	var data_option1={"color":gcColor,"legend_show":true};


  var data_ticks_usia=["Airport","Pendidikan","Kesehatan","Manufacture","Power Plant","Wilayah Lindung","Tambang Emas","Tambang Besi","Pabrik Besi","Kawasan Wisata"];

	var series_label_usia=[{"label":"Usia"}];
	var data_usia=[<?=json_encode($data_pu)?>,<?=json_encode($data_p)?>,<?=json_encode($data_u)?>];
  var data_option3={
			color:["#0073b7","#d81b60","#339933"],

		}
	var plot_3 = plot_bar2('chart-bar-usia',data_usia,[{"label":"Pribadi dan Umum"},{"label":"Umum"},{"label":"Pribadi"}],data_ticks_usia,data_option3)

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
					barMargin: 5,
					barWidth:15,
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
			renderer:$.jqplot.DonutRenderer,
			shadow: false,
			rendererOptions: { sliceMargin: 1, padding: 5, showDataLabels: true, dataLabelFormatString: "<font style='color:#fff;font-size:9px'>%d%</font>" }
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
			show:data_option.legend_show||false,
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

	//TABS CLICK
	$("#btn_print").click(function(e){
		e.preventDefault();
		var t=$("#tahun option:selected").val()||$("#tahun").val();
		var b=$("#bulan option:selected").val()||$("#bulan").val();
		var i=$("#tipe_inst option:selected").val()||$("#tipe_inst").val();
		var k=$("#wil_inst option:selected").val()||$("#wil_inst").val();

		window.open("admin/dashboard/index/1?tahun="+t+"&bulan="+b+"&tipe_instansi="+i+"&kd_org="+k,'_blank');
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
	var id_map='<?=$jsmap?>';
  var pid_map={<?=$jsmap?>00:"PARENT"};
  var pid_scale={"PARENT":"rgba(0,0,0,0)"};;
  var pid_scale2={"PARENT":2};
	var zoom2=<?=$zoom2?"'".$zoom2."'":"false"?>;

	var data={id:<?=$jml_wil['id']?json_encode($jml_wil['id'],true):'false'?>,id_pop:<?=$jml_wil['id_pop']?json_encode($jml_wil['id_pop'],true):'false'?>,blbb:<?=$jml_wil['blbb']?json_encode($jml_wil['blbb'],true):'false'?>};

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
			  min: vmin,
			  max: vmax<5?5:vmax,
			},{
			  attribute: 'fill',
			  scale: (vmin==0 && vmax==0)?["#999999"]:["#999999", "#ffa500"],
			  values: data.blbb.value,
			  min: vmin,
			  max: vmax<5?5:vmax,
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
			  },
			  markers: {
				render: function(code){
					return data.blbb.names[code];
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
		  markerLabelStyle: {
			  initial: {
				'font-size': '8',
				'fill': '#333',
				'font-weight':'normal',
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
				"fill-opacity": 1,
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
