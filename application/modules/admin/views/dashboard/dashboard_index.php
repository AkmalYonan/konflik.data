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
<script src="assets/js/jvm/id<?=$jsmappath?>/jquery.jvm.<?=$jsmap?>.js?"></script>

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
 .grayscale{
                          	filter: grayscale(100%);
                          	-webkit-filter: grayscale(100%);
                          	-moz-filter: grayscale(100%);
                          	-ms-filter: grayscale(100%);
                          	-o-filter: grayscale(100%);
                          	filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale"); /* Firefox 3.5+ */
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
.not-used{
	 text-decoration:line-through;
}
</style>

<?php
	$data_propinsi=lookup("m_propinsi","kd_propinsi","nm_propinsi");
	$data_kabupaten=lookup("m_kabupaten_kota2","kode_bps","nama");
	$data_lookup[1]=$data_propinsi;
	$data_lookup[2]=$data_kabupaten;
	$y	=	date("Y");

	for($i=0; $i<31; $i++):
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
					  <?php
						$req=get_post();
						$lookup_tipe[1]="Semua Data ";
						$lookup_tipe[2]="Per Tahun";
						
						$tipe=$req["tipe"]?$req["tipe"]:"";
						
					?>
						<?=form_dropdown("tipe",$lookup_tipe,$tipe,"id='tipe' style='width:125px !important' class='form-control select2 required'");?>

                        <label for="tahun">Tahun</label>
                        <select id="tahun" name="tahun" class="form-control">
                            <?php foreach($tahun as $k=>$v): ?>
                            <option value="<?=$v?>" <?=($selected_tahun==$v)?"selected":""?>><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="checkbox">
						<label class="<?=($selected_tahun?"":"not-used")?>">
						<input type="checkbox" id="mmode" value="1" <?=($mmode)? "checked":""?> <?=($selected_tahun?"":" disabled='disabled'")?> >s/d Bulan
						<input type="hidden" name="mmode" value="<?=($mmode)? "1":"0"?>" />
						</label>
					  </div>
					  <div class="form-group">
                        <select id="bulan" name="bulan" class="form-control <?=($selected_tahun?"":"not-used")?> <?=($selected_tahun?"":" disabled='disabled'")?>">
                            <option value="">Semua Bulan</option>
                            <?php foreach($listMonth as $k=>$v): ?>
                            <option value="<?=($k+1)?>" <?=($selected_bulan==($k+1))?"selected":""?>><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
						
                      <button id="btn_search" type="submit" class="btn btn-white">Tampilkan</button>
                      <button id="btn_resetxxxx" class="btn btn-white" data-toggle='tooltip' type='reset' title="Reset"><i class="fa fa-remove text-red"></i></button>
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
                        	 <div class="col-md-12">
                            	<h3 class="box-title" style="text-transform:uppercase"><strong>DASHBOARD TATA KELOLA SEBARAN KONFLIK</strong></h3>
                                <span class="help-block"><?=$tahun_data;?> </span>

                            </div>
                            
                           
                        </div>
                    </div>
                </div>

            </div>





            <div class="row" style="margin-top:2px;">
                <div class="col-md-12" style="position:relative">
                	<div class="box-header with-borders" style="background-color:#ffffff;">
                    
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a style="border-left:none !important;" href="javascript:void(0)">
                                <i class="fa fa-line-chart">&nbsp;</i>Konflik
                            </a>
                        </li>
                        <li class="">
                            <a href="admin/dashboard_wk/">
                                <i class="fa fa-sitemap">&nbsp;</i>Wilayah Kelola
                            </a>
                        </li>
                    </ul>
                    
                    
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
                                  <h5 class="description-header">
                                    <?=str_replace(",",".",number_format($main['jumlah_konflik']))?>
                                     </h5>
                                  <span style="color:green">( Angka )</span><br />
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
                                        <h6> <span style="border-radius: 0px !important;" class="label label-info pull-right">Korban</span></h6>
                                    </div>
                                    <div class="description-block" style="text-align:left !important;border-right:1px solid #d6d6c2">
                                      <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                      <h5 class="description-header">
                                        <?=str_replace(",",".",number_format($main['jumlah_dampak']))?>
                                       </h5>
                                      <span style="color:green">( Jiwa )</span><br />
                                      <span class="description-text">Jumlah Korban Konflik</span>
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
                                      <h5 class="description-header">
                                        <?=str_replace(",",".",number_format($main['jumlah_luas_wil']))?></h5>
                                      <span style="color:green">( Hektar )</span><br />
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
                                      <h5 class="description-header">

                                        <?=str_replace(",",".",number_format($main['jumlah_investasi']))?></h5>
                                      <span style="color:green">( Rupiah )</span><br />
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
                                                <td align="right"><strong><?=$v['jumlah']?></strong></td>
                                            </tr>
                                        	<? endforeach;?>
                                        	</tbody>
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                    <th align="right"><?=$total_wilayah?></th>
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
                                                    <td align="right"><strong><?=$v['jumlah']?></strong></td>
                                                    <td align="right"><strong><?=number_format(ceil($v['tot_luas']))?></strong>Ha</td>
                                                </tr>
                                        <? $i++; endforeach;?>
                                        	</tbody>
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                    <th align="right"><?=$total_blbb?></th>
                                                    <th align="right"><?=number_format(ceil($total_luas))?>Ha</th>
                                                </tr>
                                            </thead>
                                        </table>
                                     </div>
                                     <!--:5loka-->
                                </div>
                                <? endif?>


                            </div>
							<div class="row" style="background-color:#ffffff">
								<div class="col-md-8">
									<div class="row">
										<div class="col-md-12" style="background-color:#ffffff">
										  <h5 class="box-title" style="text-transform:uppercase"><strong>DATA KONFLIK <?=$time_title?></strong></h5>
										 <div style="border-top:1px solid #ddd"></div>	
										  <div class="row">
											<br /><br />	
											  <div class="col-md-12">
												<div id="jml_per_bulan" style="height:180px" class="hides"></div>
											  <br />
											  </div>
											
										  </div>
										</div>
									</div>
								
								 
									<br />
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-12" style="background-color:#ffffff">
										  <h5 class="box-title" style="text-transform:uppercase"><strong>STATUS KONFLIK</strong></h5>
										  <div style="border-top:1px solid #ddd"></div>
										  <div class="row">
											
											  <div class="col-md-12">
												<div id="chart4" style="text-align:'center' !important"></div>
											  <br />
											  </div>
										  </div>
										</div>
									</div>
								</div>	
								
							</div>
							
                        </div>
                    </div>
                    <!--:box-->
                </div>
                <div class="col-md-4" style="position:relative;">
					
							
					<div class="row" style="margin-top:10px;">
					<div class="col-md-12" style="background-color:#ffffff">	
					<h5 class="box-title" style="text-transform:uppercase"><strong>DATA KONFLIK TERBARU</strong></h5>
					 <div style="border-top:1px solid #ddd"></div>
                  	
                    
                     
                      <div class="row">
                      <div class="col-md-12">
                      <ul class="products-list product-list-in-box">
                        <? foreach ($top5_bydate as $k => $v) :?>
                        <li class="item">
						  <div class="row">
							<div class="col-md-3">
								<div class="product-img grayscale">
									<img src="assets/images/indonesia_grey.png" style="width:100px !important" width="90">
								  </div>
							</div>
							<div class="col-md-9">
								<div class="product-info" style="margin-left:0px;">
								<span class="product-title"><?=$v['judul']?></span>
									<br /><span style="font-size:12px;" class="product-description ">
									  <?=date( "jS F, Y  h:i:s A", strtotime($v['tgl_kejadian']) )?></span>
									<span  style="font-size:13px;">
									  Sektor : <?=$sektor[$v['kd_sektor']]?>
									</span><br />
									<span  style="font-size:13px;">
									  Luas : <?=number_format($v['luas'])?> Ha, Dampak : <?=number_format($v['dampak'])?> Jiwa
									</span>
							  </div>
							</div>
						  </div>
                          
                        </li>
                        <div style="border-top:1px solid #ddd"></div>
                      <? endforeach;?>
						
                      </ul>
                    </div>
						</div>
                      <div style="border-top:1px solid #ddd"></div>


                      

                </div>
				</div>
				<br />
				<div class="row" style="background-color:#ffffff">
								<div class="col-md-12">
									<h5 class="box-title" style="text-transform:uppercase"><strong>DATA KONFLIK PERTAHUN</strong></h5>
									<div style="border-top:1px solid #ddd">
								  		<div id="jml_tahun" style="height:100px; margin-top:10px" class="hides"></div>
										<br />
                                    </div>
                                </div>
								
				</div>
							
				</div>
            </div>
          </div>
            <? if ($jumlah>0):?>
            <div class="box box-widget hidden ">
                <!-- box-body -->
                    <div class="box-header with-borders"  style="position:absolutes;">
                        <h3 class="box-title">KONFLIK BERDASARKAN SEKTOR/JENIS LAHAN</h3>
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
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){							
	$("#tahun").change(function(){
		$("#bulan,#mmode").attr("disabled",$(this).val()?false:true);
		if ($(this).val()) {
			$("#bulan,#mmode").removeClass("not-used");
			$("#mmode").parent().removeClass("not-used")
		} else {
			$("#bulan").addClass("not-used");
			$("#mmode").parent().addClass("not-used")
		}
	});
});
</script>

<script>
$(document).ready(function(){
var data = <?=$data_pie?>;
									  
var data_option={
			"color":gcColor
	};
									
var plot4 = $.jqplot('chart4', [data], {
		seriesDefaults: {
			// make this a donut chart.
			renderer:$.jqplot.DonutRenderer,
			rendererOptions:{
			seriesColors: [ "#ff4d4d", "#ffa64d", "#3385ff"],
			// Donut's can be cut into slices like pies.
			sliceMargin: 3,
			// Pies and donuts can start at any arbitrary angle.
			startAngle: -90,
			showDataLabels: true,
			// By default, data labels show the percentage of the donut/pie.
			// You can show the data 'value' or data 'label' instead.
			dataLabels: 'value',
			// "totalLabel=true" uses the centre of the donut for the total amount
			totalLabel: true,
			shadow: true,
			sliceMargin: 1, padding: 8, showDataLabels: true, dataLabelFormatString: "<font style='color:#fff;font-size:11px'>%d%</font>" 
			}
		},
		seriesColors: data_option.color,
		legend:{
		renderer: $.jqplot.EnhancedLegendRenderer,
		show:true,
		background:'transparent',
		border:'1px',
		//placement: 'outside',
		location:'s',
		//rendererOptions: {
		//	numberRows: 1
		//}, 
		marginTop: '5px'
		},
		grid: {
			borderWidth:0,
			shadow:false         
		}
										
		});
		});
						 
</script>
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
	var time_ticks=<?=$time_tick;?>;
	var data_option1={
		color:[ "#ff4d4d", "#ffa64d", "#3385ff"],
		ticks:time_ticks||["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
		legend:false
	}

  	//var c3 = [<?=json_encode($pasien_per_bulan["L"])?>,<?=json_encode($pasien_per_bulan["P"])?>];
	//var plot_0 = plot_stack('jml_per_bulan',c3,[{"label":"Laki-laki"},{"label":"Perempuan"}],data_option1);

  	var c3 = [<?=json_encode($pasien_per_bulan["BD"])?>,<?=json_encode($pasien_per_bulan["PS"])?>,<?=json_encode($pasien_per_bulan["SL"])?>];

  	var plot_0 = plot_bar('jml_per_bulan',c3,[{"label":"Belum Ditangani"},{"label":"Proses"},{"label":"Selesai"}],data_option1.ticks,data_option1);

	var data_p0=[["ASSESMENT",<?=(int)$assesment?>],["REHAB",<?=(int)$rehab?>],["PASCA",<?=(int)$pasca?>],["OUTCOME",<?=(int)$selesai?>]];
	$(window).resize(function() {
          plot_0.replot( { resetAxes: true } );
          plot_pie_1.replot( { resetAxes: true } );
    });
});

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
	$("#mmode").click(function(){
		$("[name='mmode']").val($(this).is(":checked")?"1":"0");
	});
	
	$("#tipe").change(function(){
		$("#bulan,#mmode").attr("disabled",$(this).val()==2?false:true);
		if ($(this).val()==2) {
			$("#bulan,#mmode").removeClass("not-used");
			$("#mmode").parent().removeClass("not-used")
		} else {
			$("#bulan").addClass("not-used");
			$("#mmode").parent().addClass("not-used")
			$("#mmode").attr("checked",true);
			$("#bulan,#mmode").attr("disabled",true);
			
		}
	});

	$("#tipe").change();
	
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

});
</script>

<script>
	var id_map='<?=$jsmap?>';
  var pid_map={<?=$jsmap?>00:"PARENT"};
  var pid_scale={"PARENT":"rgba(0,0,0,0)"};;
  var pid_scale2={"PARENT":2};
	var zoom2=<?=$this->user_prop?"'".$this->user_prop."'":"false"?>;

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
				//map.setFocus({region:code});
				map.setFocus({region:code});
				var t=$("#tahun option:selected").val()||$("#tahun").val();
				var b=$("#bulan option:selected").val()||$("#bulan").val();
				var i=$("#tipe option:selected").val()||$("#tipe").val();
				var k=$("#mmode").val();
		
				window.open("registrasi/jkpp/?propinsi="+code+"&tahun=All",'_blank');
				
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
