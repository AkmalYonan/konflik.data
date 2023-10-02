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
.jvectormap-legend-title {
	white-space:nowrap;
}
.jvectormap-legend-cnt-h {
    bottom: 20px;
    left: 10px;
	max-width: 180px;
}
.jvectormap-legend-cnt-v {
	top:auto!important;
    bottom: 30px!important;
    left: 0px;
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
.notif-box {
	position:relative;
	border-radius:0px!important;
	cursor:pointer;
}
.notif-box::before {
    position: absolute;
    right: 100%;
    top: 0px;
    border: solid transparent;
    border-right-color: #d2d6de;
    content: ' ';
    height: 0;
    width: 0;
    pointer-events: none;
	border-width:12px
}
.products-list > .item::after {
    clear: both;
}
.products-list > .item::before, .products-list > .item::after {
    content: " ";
    display: table;
}
*::after, *::before {
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
    box-sizing: border-box;
}
elemen {
}
.product-list-in-box > .item {
	-webkit-box-shadow: none;
		box-shadow: none;
        border-radius: 0;
        border-bottom: 1px solid #f4f4f4;
}
.products-list > .item {
	border-radius: 3px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    padding: 10px 0;
    background: #fff;
}
* {
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
    box-sizing: border-box;
}
.products-list {
	list-style: none;
	list-style-type: none;
    list-style-image: none;
    list-style-position: outside;
    padding-left: 2px !important;
    float: left;
}
.products-list .product-img {
	float: left;
}
.tbl-fixed thead tr{
	display:block;
}


.tbl-fixed th,.tbl-fixed td{
	width:100%;
	vertical-align:middle !important;
}

.tbl-fixed  tbody{
	display:block;
	height:120px;
	overflow:auto;//set tbody to auto
}

.not-used{
	 text-decoration:line-through;
}

</style>


<?php
	$data_propinsi=lookup("m_propinsi","kd_propinsi","nm_propinsi");
	$data_kabupaten=lookup("m_kabupaten","kd_wilayah","kd_kabupaten");
	$data_lookup[1]=$data_propinsi;
	$data_lookup[2]=$data_kabupaten;
	
	$y	=	date("Y");

	for($i=0; $i<31; $i++):
		$tahun[$i]	=	$y-$i;
	endfor;


?>

		

<!--header-->
<div class="well well-sm sub-head" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-6">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>DASHBOARD SEBARAN KONFLIK & WILAYAH KELOLA</strong></h6>
                    </div>
    
                    <div class="col-md-6 col-xs-9">
                      <form class="form-inline" action="<?=$this->module?>" method="get" style="float:right !important">
    
					<div class="form-group">
					<?php
								$req=get_post();
								$lookup_tipe[1]="Semua Data ";
								$lookup_tipe[2]="Per Tahun";
								$tipe=$req["tipe"]?$req["tipe"]:"";
							?>
							<?=form_dropdown("tipe",$lookup_tipe,$tipe,"id='tipe' style='width:125px !important' class='form-control select2 required'");?>

					</div>
					  <input type='hidden' id='jenis_wikera'  name='jenis_wikera' value=''>
                      <div class="form-group col-xs-inline-block">
                          <select id="tahun" name="tahun"   style="width:78px !important" class="form-control">
                              <option value="">Semua</option>
                              <?php foreach($tahun as $k=>$v): ?>
                              <option value="<?=$v?>" <?=($selected_tahun==$v)?"selected":""?>><?=$v?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="checkbox">
                            <label class="<?=($selected_tahun?"":"not-used")?>">
                              <input id="mmode" name="mmode" type="checkbox" value="1"<?=$mmode?" checked":""?><?=($selected_tahun?"":" disabled='disabled'")?>> s/d Bulan
                              <!--<input type="hidden" name="mmode" value="<?=$mmode?"1":"0"?>" />-->
                            </label>
                          </div>
                        <div class="form-group">
                          <!--<label for="bulan">s/d Bulan</label>-->
                          <select id="bulan" name="bulan" style="width:115px !important;" class="form-control <?=($selected_tahun?"":"not-used")?>"<?=($selected_tahun?"":" disabled='disabled'")?>>
                              <option value="">Semua Bulan</option>
                              <?php foreach($listMonth as $k=>$v): ?>
                              <option value="<?=($k+1)?>" <?=($selected_bulan==($k+1))?"selected":""?>><?=$v?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
    
                        <button id="btn_search" type="submit" style="width:80px;padding-left:5px !important;" class="btn btn-white">Tampilkan</button>
                        <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-remove text-red"></i></button>
                        <!--<button id="btn_print" class="btn btn-white pull-right" data-toggle='tooltip' title="Save as PDF"><i class="fa fa-file-pdf-o"></i></button>-->
                      </form>
                    </div>
                </div>
            </div>
        </div><!-- end row -->
        
        
        
        
        
        
    </div>
</div>
<!--end header-->
<div class="main-container container text-center-xs" >
<div class="row">
<div class="col-sm-12 col-xs-12">

<!--<div class="row" >
    <div class="col-md-12" style="position:relative">
        <div class="well well-sm" style="margin-top:10px">
        <div class="box-header with-borders">
            <div class="row">
                <div class="col-md-6">
                 <p>
                  <h6 class="box-title" style="padding-left:5px;ext-transform:uppercase"><strong>DASHBOARD SEBARAN KONFLIK & WILAYAH KELOLA</strong></h6>
                  </p>
                </div>

                <div class="col-md-6 col-xs-9">
                  <form class="form-inline" action="<?=$this->module?>" method="get" style="float:right !important">

                  <div class="form-group col-xs-inline-block">
                      <label for="tahun">Tahun</label>
                      <select id="tahun" name="tahun" class="form-control">
                          <option value="">Semua</option>
                          <?php foreach($tahun as $k=>$v): ?>
                          <option value="<?=$v?>" <?=($selected_tahun==$v)?"selected":""?>><?=$v?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="checkbox">
                        <label>
                          <input id="mmode" type="checkbox" value="1"<?=$mmode?" checked":""?>> s/d Bulan
                          <input type="hidden" name="mmode" value="<?=$mmode?"1":"0"?>" />
                        </label>
                      </div>
                    <div class="form-group">
                      <select id="bulan" name="bulan" class="form-control">
                          <option value="">Semua Bulan</option>
                          <?php foreach($listMonth as $k=>$v): ?>
                          <option value="<?=($k+1)?>" <?=($selected_bulan==($k+1))?"selected":""?>><?=$v?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>

                    <button id="btn_search" type="submit" class="btn btn-white">Tampilkan</button>
                    <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-remove text-red"></i></button>
                  </form>
                </div>
            </div>
        </div></div>
    </div>
    
</div>-->

	<div class="row">
						<div class="col-md-12">
							

<ul class="nav nav-tabs">
	<li class="">
		<a href="<?=base_url('dashboard_portal')?>">
			<i class="fa fa-line-chart">&nbsp;</i>Konflik
		</a>
	</li>
	<li class="active">
		<a href="javascript:void(0)">
			<i class="fa fa-sitemap">&nbsp;</i>Wilayah Kelola
		</a>
	</li>
</ul>

						</div>
					</div><!--end row-->

<section class="content" >
	<div class="row">
    	<div class="col-md-12">
        	<!-- TAB -->
            <? if (message_box()) :?><?php echo message_box();?><?endif;?>
			<div class="row" style="margin-top:2px;">
            	<div class="col-md-12" style="border-bottom:1px solid #ddd; padding-bottom:15px">
                	<a href="<?=$this->module?>" class="btn btn-default <?=!$wstatus?'active':''?>">Semua</a> 
                	<a href="<?=$this->module?>potensi" class="btn btn-default <?=$wstatus=='potensi'?'active':''?>">Potensi</a> 
                	<a href="<?=$this->module?>usulan" class="btn btn-default <?=$wstatus=='usulan'?'active':''?>">Usulan</a> 
                    <a href="<?=$this->module?>realisasi" class="btn btn-default <?=$wstatus=='realisasi'?'active':''?>">Realisasi</a>
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
                                    <h6> <span cstyle="border-radius: 0px !important;" class="label label-danger pull-right notif-box" data-display="konflik" title="Lihat Sebaran Wilayah Kelola">Wilayah Kelola <i class='fa fa-check-circle'></i></span></h6>
                                </div>
                                <div class="description-block" style="text-align:left !important;border-right:1px solid #d6d6c2">
                                  <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                  <h5 class="description-header">
                                  	<?=curr_format((float)$main['jumlah'],0)?>
                                    <?//=str_replace(",",".",number_format($main['jumlah_konflik']))?>
                                     </h5>
                                  <!--<span style="color:green">( number )</span><br />-->
                                  <span class="description-text">Jumlah Wilayah Kelola</span>
                                  <br />
                                </div>

                              </div>
                              </div>
                          </div>

                        </div>
                            <div class="col-md-2">
                              <div>
                                <div class="row">
                                  <div class="col-md-12 border-right" >
                                    <div class="panel-title">
                                        <h6> <span style="border-radius: 0px !important;" class="label label-info pull-right notif-box" data-display="tora" title="Sebaran Wilayah TORA">TORA</span></h6>
                                    </div>
                                    <div class="description-block" style="text-align:left !important;border-right:1px solid #d6d6c2">
                                      <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                      <h5 class="description-header">
                                      	<?=curr_format((float)$main['tora'],0)?>
                                        <?//=str_replace(",",".",number_format($main['jumlah_dampak']))?>
                                       </h5>
                                      <span class="description-text">Jumlah TORA</span>
                                    </div>


                                  </div>
                                  </div>
                              </div>

                            </div>
                            
                            <div class="col-md-2">
                              <div>
                                <div class="row">
                                  <div class="col-md-12 border-right" >
                                    <div class="panel-title">
                                        <h6> <span style="border-radius: 0px !important;" class="label label-info pull-right notif-box" data-display="ps" title="Sebaran Wilayah PS">PS</span></h6>
                                    </div>
                                    <div class="description-block" style="text-align:left !important;border-right:1px solid #d6d6c2">
                                      <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                      <h5 class="description-header">
                                      	<?=curr_format((float)$main['piaps'],0)?>
                                        <?//=str_replace(",",".",number_format($main['jumlah_dampak']))?>
                                       </h5>
                                      <span class="description-text">Jumlah PS</span>
                                    </div>


                                  </div>
                                  </div>
                              </div>

                            </div>
                            
                            <div class="col-md-2">
                              <div>
                                <div class="row">
                                  <div class="col-md-12 border-right" >
                                    <div class="panel-title">
                                        <h6> <span style="border-radius: 0px !important;" class="label label-info pull-right notif-box" data-display="ha" title="Sebaran Wilayah HA">HA</span></h6>
                                    </div>
                                    <div class="description-block" style="text-align:left !important;border-right:1px solid #d6d6c2">
                                      <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                      <h5 class="description-header">
                                      	<?=curr_format((float)$main['ha'],0)?>
                                        <?//=str_replace(",",".",number_format($main['jumlah_dampak']))?>
                                       </h5>
                                      <span class="description-text">Jumlah HA</span>
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
                                        <h6> <span style="border-radius: 0px !important;" class="label label-warning pull-right notif-box" data-display="lahan" title="Lihat Sebaran Luasan Lahan">LUAS</span></h6>
                                    </div>
                                    <div class="description-block" style="text-align:left !important; border-right:1px solid #d6d6c2 ">
                                      <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                      <h5 class="description-header"><?=curr_format((float)$main['jumlah_luas_wil'])?>
                                        <?//str_replace(",",".",number_format($main['jumlah_luas_wil']))?></h5>
                                      <!--<span style="color:green">( in Hektar )</span><br />-->
                                      <span class="description-text" title="Hektar (Ha)">Luas Wilayah (Ha)</span>
                                    </div>


                                  </div>
                                  </div>
                              </div>

                            </div>
                            <div class="col-md-3 hidden">
                              <div>
                                <div class="row">
                                  <div class="col-md-12 border-right" >
                                    <div class="panel-title">
                                        <h6> <span style="border-radius: 0px !important;" class="label label-success pull-right notif-box" data-display="investasi" title="Lihat Sebaran Nilai Investasi ">investasi</span></h6>
                                    </div>
                                    <div class="description-block" style="text-align:left !important; ">
                                      <span class="description-percentage text-green hidden"><i class="fa fa-caret-up"></i> 0%</span>
                                      <h5 class="description-header"><?=curr_format((float)$main['jumlah_investasi'])?></h5>
                                      	
                                      <!--<span style="color:green">( in Rupiah )</span><br />-->
                                      <span class="description-text" title="Rupiah">Nilai Investasi (Rp.)</span>
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
        </div>
    </div>
</section>
<section class="content" >
	<div class="row">
    	<div class="col-md-12">
            <div class="row">
                <div class="col-md-12" style="position:relative">
                	<div style=" position:absolute;top:50px; right:20px; z-index:998">
                	<div id="jml_tahun" style="height:80px; width:220px;" class="hides"></div>
                	<h6 class="box-title" style="text-transform:uppercase; text-align:center"><small>DATA WIL.KELOLA PERTAHUN</small></h6>
                    </div>
                    <div class="map" style="background: transparent;width: 100%; height: 400px; margin-top:20px; margin-bottom:-20px"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8" style="position:relative">
                    <!--here-->
                    <div class="row">
                    <div class="col-md-12">
                    <!-- box -->
                    <div class="box box-widgets" style="background:rgba(255,255,255,.0); border:none;">
                    	<div class="box-header">
                        	<div class="row">
                                <div class="col-md-8">
                                    <h6 class="box-title"><small>SEBARAN LOKASI</small></h6>
									
                                </div>
								
                                <div class="col-md-4">
                                </div>
							</div>
                        </div>
                        <!-- box-body -->
                        <div style="border-top:1px solid #ddd"></div>
                         
                        <div class="box-body" style="margin-top:7px;">
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
                                                <td style="text-align:right"><strong><?=$v['jumlah']?></strong></td>
                                            </tr>
                                        	<? endforeach;?>
                                        	</tbody>
                                            <thead>
                                                <tr>
                                                    <td>Total</td>
                                                    <td style="text-align:right"><?=$total_wilayah?></td>
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
                                                    <th>BERDASARKAN JENIS</th>
                                                    <th>Jumlah</th>
                                                    <th>Luas</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                        <? foreach($top5_bl as $k=>$v) :
                                          $total_blbb+=$v['jumlah'];
                                          $total_luas+=$v['tot_luas'];?>
                                                <tr>
                                                    <td><?=$jenis_wikera[$v['nama']]?></td>
                                                    <td style="text-align:right"><strong><?=curr_format($v['jumlah'],0)?></strong></td>
                                                    <td style="text-align:right"><strong><?=curr_format(ceil($v['tot_luas']),0)?></strong></td>
                                                </tr>
                                        <? $i++; endforeach;?>
                                        	</tbody>
                                            <thead>
                                                <tr>
                                                    <td>Total</td>
                                                    <td><?=$total_blbb?></td>
                                                    <td style="text-align:right !mportant;"><?=curr_format(ceil($total_luas),0)?></td>
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
                    </div>
                    <div class="row">
                    	<div class="col-md-8">
                             <h6 class="box-title" style="text-transform:uppercase"><small>GRAFIK DATA WILAYAH KELOLA PERBULAN</small></h6>
							  <div style="border-top:1px solid #ddd"></div>
							  <br /><br />
                             <div id="jml_per_bulan" style="height:150px" class="hides"></div>
                        </div>
						<div class="col-md-4">
                             <h6 class="box-title" style="text-transform:uppercase"><small>STATUS TAHAPAN</small></h6>
							 <div style="border-top:1px solid #ddd"></div>
                             <div id="chart4" style="height:400px;text-align:'center' !important"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="position:relative; background-color:#ffffff !important">
					  <div class="row" style="margin-top:0px;">
						<div class="col-md-12" style="background-color:#ffffff">
                      <h6 class="box-title" style="text-transform:uppercase"><small>DATA TERBARU</small></h6>
                      <div style="border-top:1px solid #ddd"></div>
                    
                      <div class="row">
                      <div class="col-md-12">
                      <ul class="products-list product-list-in-box">
                        <? foreach ($top5_bydate as $k => $v) :?>
                        <li class="item" >
                          <div class="row">
                            <div class="col-md-3 col-xs-4">
                              <div class="product-img" style="text-align:center">
                                <img src="assets/images/indonesia_grey.png" width="80">
                                <span style="font-size:12px;" class="product-description "><?=date( "d-m-Y", strtotime($v['tgl_kejadian']) )?></span>
                              </div>
                            </div>
                            <div class="col-md-9 col-xs-8">
                              <div class="product-info" style="text-align:left !important">
                                <span class="product-title"><strong><?=$v['judul']?></strong></span>
                                    <br />
                                    <span  style="font-size:11px;">
                                      Jenis : <?=$v['kode_jns_wikera']?>
                                    </span><br />
									<span  style="font-size:11px;">
										Luas : <?=$v['luas']?number_format($v['luas'])." Ha,":"-"?> Tahapan : <?=$tahapan[$v["kode_tahapan"]]?>
                                    </span>
                              </div>
                            </div>
                          </div>

                        </li>
                      <? endforeach;?>



                      </ul>
                    </div>
                  </div>
				  </div>
				  </div>
                </div>
          </div>
          <br />
        
            <!-- box -->
            <div class="row">
            	<div class="col-md-6">
                	<div style="padding:10px">
                	<!--<h5 class="box-title">Generated: <?=date("d-m-Y H:i");?></h5>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>
</div>
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
			// rendererOptions: {
			// numberRows: 1
			// }, 
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
	/*
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
	*/

	var ct = [<?=json_encode($trend_per_tahun)?>];
	var plot_1 = plot_line('jml_tahun',ct,[],{color:["#aaa"],legend:false})

	var data_option1={
			color:[ "#ff4d4d", "#ffa64d", "#3385ff"],
			ticks:["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
			legend:false
		}
  	//var c3 = [<?=json_encode($pasien_per_bulan["L"])?>,<?=json_encode($pasien_per_bulan["P"])?>];
	//var plot_0 = plot_stack('jml_per_bulan',c3,[{"label":"Laki-laki"},{"label":"Perempuan"}],data_option1);

	var c3=<?=json_encode($data_per_bulan);?>;
	var c3_ticks=<?=json_encode($data_per_bulan_ticks);?>;
	
	var plot_0 = plot_bar('jml_per_bulan',c3,c3_ticks,data_option1.ticks,data_option1);
	
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
	//var plot_3 = plot_bar2('chart-bar-usia',data_usia,[{"label":"Pribadi dan Umum"},{"label":"Umum"},{"label":"Pribadi"}],data_ticks_usia,data_option3)

	$(window).resize(function() {
          /*
		  plot_0.replot( { resetAxes: true } );
          plot_1.replot( { resetAxes: true } );
          plot_3.replot( { resetAxes: true } );
          plot_pie_1.replot( { resetAxes: true } );
          plot_pie_2.replot( { resetAxes: true } );
          plot_pie_3.replot( { resetAxes: true } );
          plot_pie_4.replot( { resetAxes: true } );
          plot_pie_5.replot( { resetAxes: true } );
		  */
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

<? //endif?>
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
	
	var map;
	var dregion = false;
	var vmin = 0;
	var vmax = 0;
	var data_region;

	var data_konflik={id:<?=$jml_wil['id']?json_encode($jml_wil['id'],true):'false'?>,id_pop:<?=$jml_wil['id_pop']?json_encode($jml_wil['id_pop'],true):'false'?>,blbb:<?=$jml_wil['blbb']?json_encode($jml_wil['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil['colors'])?>};
	var data_dampak={id:<?=$jml_wil_dampak['id']?json_encode($jml_wil_dampak['id'],true):'false'?>,id_pop:<?=$jml_wil_dampak['id_pop']?json_encode($jml_wil_dampak['id_pop'],true):'false'?>,blbb:<?=$jml_wil_dampak['blbb']?json_encode($jml_wil_dampak['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil_dampak['colors'])?>};
	var data_lahan={id:<?=$jml_wil_lahan['id']?json_encode($jml_wil_lahan['id'],true):'false'?>,id_pop:<?=$jml_wil_lahan['id_pop']?json_encode($jml_wil_lahan['id_pop'],true):'false'?>,blbb:<?=$jml_wil_lahan['blbb']?json_encode($jml_wil_lahan['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil_lahan['colors'])?>};
	var data_investasi={id:<?=$jml_wil_investasi['id']?json_encode($jml_wil_investasi['id'],true):'false'?>,id_pop:<?=$jml_wil_investasi['id_pop']?json_encode($jml_wil_investasi['id_pop'],true):'false'?>,blbb:<?=$jml_wil_investasi['blbb']?json_encode($jml_wil_investasi['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil_investasi['colors'])?>};
	
	var data_tora={id:<?=$jml_wil_tora['id']?json_encode($jml_wil_tora['id'],true):'false'?>,id_pop:<?=$jml_wil_tora['id_pop']?json_encode($jml_wil_tora['id_pop'],true):'false'?>,blbb:<?=$jml_wil_tora['blbb']?json_encode($jml_wil_tora['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil_tora['colors'])?>};
	var data_ps={id:<?=$jml_wil_ps['id']?json_encode($jml_wil_ps['id'],true):'false'?>,id_pop:<?=$jml_wil_ps['id_pop']?json_encode($jml_wil_ps['id_pop'],true):'false'?>,blbb:<?=$jml_wil_ps['blbb']?json_encode($jml_wil_ps['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil_ps['colors'])?>};
	var data_ha={id:<?=$jml_wil_ha['id']?json_encode($jml_wil_ha['id'],true):'false'?>,id_pop:<?=$jml_wil_ha['id_pop']?json_encode($jml_wil_ha['id_pop'],true):'false'?>,blbb:<?=$jml_wil_ha['blbb']?json_encode($jml_wil_ha['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil_ha['colors'])?>};
	
	function setData(d,f,t) {
		dregion = d.id.values||false;
		var dmarker = d.blbb||false;
		if (dregion) {
			$('.map').html("");
			map=false;
			propValues = jvm.values.apply({}, jvm.values(d.id));
			
			//alert(propValues);
			//alert(JSON.stringify(dregion));
			vmin = jvm.min(propValues);
			vmax = jvm.max(propValues);
			data_region = [{
			  scale: d.colors,
			  //normalizeFunction: 'polynomial',
			  attribute: 'fill',
			  values: dregion,
			  min: vmin,
			  max: vmax<5?5:vmax,
			  legend: {
				  title: t||"Wilayah Kelola",
				  vertical: true,
				  labelRender: function(v){
					  	if (v >= 1000000000000) {
							v = v / 1000000000000;
							u = "T";
						}
						else if (v >= 1000000000) {
							v = v / 1000000000;
							u = "M";
						}
						else if (v >= 1000000) {
							v = v / 1000000;
							u = "Jt";
						}						
						else {
							u = "";
						}
					return v.toFixed(f||0)+' '+u;
				  }
			  }
			},{
			  attribute: 'stroke',
			  normalizeFunction: 'polynomial',
			  scale: d.colors,
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
			}];
			map = new jvm.Map({
				container: $('.map'),
				map: 'id-'+id_map+'_merc',
				zoomButtons : true,
				zoomOnScroll: false,
				backgroundColor:'rgba(0,0,0,0)',
				markers: d.blbb.coords,
				series: {
					regions: data_region
				  },
				  labels: {
					  regions: {
						render: function(code){
							return d.id.fvalues[code];
						}
					  },
					  markers: {
						render: function(code){
							return d.blbb.names[code];
						}
					  }
				  },
		
				  regionLabelStyle: {
					  initial: {
						'font-family': 'Helvetica',
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
						  '<b>'+d.blbb.names[index]+'</b><br/>'+
						  '<b>Total: </b>'+d.blbb.value[index]
						);
					  },
				  onRegionTipShow: function(event, label, code){
					  var jml = d.id.fvalues[code] || 0;
					  var p = "";
					  if (d.id_pop[code]) {
						  p = d.id_pop[code].a?"Assesment :"+d.id_pop[code].a+"<BR>":"";
						  p+= d.id_pop[code].r?"Rehabilitasi :"+d.id_pop[code].r+"<br>":"";
						  p+= d.id_pop[code].p?"Pasca :"+d.id_pop[code].p+"<br>":"";
						  p+= d.id_pop[code].s?"Outcome :"+d.id_pop[code].s:"";
					  }
					  label.html('<b>'+label.html()+'</b><div style="border-bottom:1px solid #fff">'+p+'</div><b>Total:'+jml+'</b>');
					  //label.html('<b>'+label.html()+'</b><br>Total: '+jml);
				  },
				  onRegionClick: function(event, code){
						///map.setFocus({region:code});
						map.setFocus({region:code});
						var t=$("#tahun option:selected").val()||$("#tahun").val();
						var b=$("#bulan option:selected").val()||$("#bulan").val();
						var i=$("#tipe option:selected").val()||$("#tipe").val();
						var k=$("#mmode").val();
						var wilayah_kelola=$("#jenis_wikera").val();
				
						window.open("data/wilayah_kelola?kd_prop="+code+"&tahun="+t+"&bulan="+b+"&tipe="+i+"&mmode="+k+"&jenis_wikera="+wilayah_kelola,'_blank');
				
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
	  	}else {

	  	blbbValues = Array.prototype.concat.apply([], jvm.values(d.blbb.value));
		
		var vmind = 0;
		var vmaxd = jvm.max(blbbValues);
		
		var data_marker = [{
			  attribute: 'r',
			  scale: (vmind==0 && vmaxd==0)?[4]:[4, 6],
			  values: d.blbb.value,
			  min: vmind,
			  max: vmaxd<5?5:vmaxd,
			  legend: {
				  vertical: false
			  }
			},{
			  attribute: 'stroke-width',
			  scale: [.5, 2],
			  values: d.blbb.value,
			  min: vmind,
			  max: vmaxd<5?5:vmaxd,
			},{
			  attribute: 'fill',
			  scale: (vmind==0 && vmaxd==0)?["#999999"]:["#999999", "#ffa500"],
			  values: d.blbb.value,
			  min: vmind,
			  max: vmaxd<5?5:vmaxd,
			}];
			var map = new jvm.Map({
        container: $('.map'),
        map: 'id-'+id_map+'_merc',
		zoomButtons : true,
		zoomOnScroll: false,
		backgroundColor:'rgba(0,0,0,0)',
		markers: d.blbb.coords,
		series: {
			markers: data_marker,
			regions: data_region
		  },
		  labels: {
			  regions: {
				render: function(code){
					return d.id[code];
				}
			  },
			  markers: {
				render: function(code){
					return d.blbb.names[code];
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
				  '<b>'+d.blbb.names[index]+'</b><br/>'+
				  '<b>Total: </b>'+d.blbb.value[index]
				);
			  },
		  onRegionTipShow: function(event, label, code){
			  var jml = d.id[code] || 0;
			  var p = "";
			  if (d.id_pop[code]) {
				  p = d.id_pop[code].a?"Assesment :"+d.id_pop[code].a+"<BR>":"";
				  p+= d.id_pop[code].r?"Rehabilitasi :"+d.id_pop[code].r+"<br>":"";
				  p+= d.id_pop[code].p?"Pasca :"+d.id_pop[code].p+"<br>":"";
				  p+= d.id_pop[code].s?"Outcome :"+d.id_pop[code].s:"";
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
	  }

	}
	
    $(function(){
	  
		$(".notif-box").click(function(){
		
			var d=data_konflik;
			var p=0;
			var t="Wilayah Kelola";
			var wilayah_kelola = "";
			$("[name='d']").val($(this).data("display"));
			//$("#btn_search").trigger("click");
			switch($(this).data("display")) {
				case 'tora':
					wilayah_kelola = "tora";
					d=data_tora;
					t="Wilayah Kelola";
					break;
				case 'ps':
					wilayah_kelola = "ps";
					d=data_ps;
					t="Wilayah Kelala";
					break;
				case 'ha':
					wilayah_kelola = "ha";
					d=data_ha;
					t="Wilayah Kelola";
					break;
				case 'dampak':
					
					d=data_dampak;
					t="Dampak (jiwa)";
					break;
				case 'lahan':
					d=data_lahan;
					t="Luas (Ha)";
					break;
				case 'investasi':
					d=data_investasi;
					t="Investasi (Rp)";
					p=2;
					break;
			}
			document.getElementById('jenis_wikera').value=wilayah_kelola ;
			setData(d,p,t);
			$(".notif-box").find(".fa-check-circle").remove();
			$(this).append(" <i class='fa fa-check-circle'></i>");
		});
      
	  setData(data_konflik);
	  if (zoom2) map.setFocus({region:zoom2});
    });
  </script>
