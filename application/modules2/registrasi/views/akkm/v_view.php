<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
?>
<?php
	// $lookup_status_akkm["RN"]="Registrasi Nasional";
	// $lookup_status_akkm["RI"]="Registrasi Internasional";
	$lookup_status_akkm["Usulan"]="Usulan";


?>
<script type="text/javascript" src="assets/js/maskF/my.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>
<!--<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.openstreetmap.js"></script>-->

<style>
.green{color:#00A65A}
.yellow{color:#F39C12}
.leaflet-top,
.leaflet-bottom {
	z-index: 499;
}
.table_title{
	font-weight:bold;
}
#narasi{
	text-indent:50px;
}
</style>

<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i><a href="<?php echo $this->module?>"><?=$this->parent_module_title?></a></li>
    <li class="active"><?=$this->module_title?></li>
  </ol>
</section>

<section class="content">
<div class="row">
	<div class="col-md-12">
	<div class="box box-default">
    	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
		<div class="box-header with-border clearfix">
			<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
				<i class="fa fa-list"></i>
			</a>
			<a class="btn btn-white" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
				<i class="fa fa-refresh"></i>
			</a>	
			<div class="btn-group pull-right">
				<a href="#" class="print-pdf hidden" data-url=""><i class="fa fa-file-pdf-o"></i> PDF</a>
				<div class="btn-group btn-group-sm pull-right">
					<a href="/print" class="btn btn-white div_id_print_modal" data-div_id="#print_this" data-page_orientation='L' data-page_size='A4' data-toggle='tooltip' data-original-title="Print Preview"><i class="fa fa-print"></i>&nbsp;Print Preview</a>
					<!--<a href="#" class="btn btn-white print-excel" data-url="" data-toggle='tooltip' data-original-title="Export to Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a>-->
				</div>
			</div>			
		</div>
		
		<div class="box-body">
                <div class="row">
                    <div class="col-md-7">
						<div class="row">
                      		<div class="col-md-12">
								<p style="font-size:18px;font-weight:bold;"><?php echo $data["judul"];?></p>
                            	<div id="map" style="height:330px;"></div>
                        	</div>
                        </div><!-- end row -->

						<?php echo form_input('latitude',$data["latitude"],'id="y" data-x="'.$data["latitude"].'" class="form-control hidden required"');?>
						<?php echo form_input('longitude',$data["longitude"],'id="x" data-="'.$data["longitude"].'" class="form-control hidden required"');?>

                    
                    	<div class="row">
								<div class="col-md-12">
									<p style="opacity: 0.6;background-color:red;margin-top:-20px;width:50%"><b style="color:black">&nbsp;<?=strtoupper($prop)?>, <?=strtoupper($kab)?></b></p>
									
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									
								</div>
							</div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
						
						<h4 class="heading">PROFIL DATA AREA KONSERVASI KELOLA MASYARAKAT</h4>
					
			  
                    	<table class="table table-condensed" style="margin-top:-5px;">
							<tr>
								<td class="table_title" colspan='3'><?=strtoupper($data['nama_akkm'])?></td>
							
							</tr>
							<tr>
								<td  width="180">Pengampu AKKM</td>
								<td>:</td>
								<td>&nbsp;<?=$data['pengampu']?></td>
							</tr>
							<tr>
								<td  width="180">Ekosistem</td>
								<td>:</td>
								<td>&nbsp;<?=$data['ekosistem']?></td>
							</tr>
							
							<?php
								$exp_luas	=	explode(".",$data["luas"]);
								$luas		=	number_format($exp_luas[0]);
							?>
							
							<tr>
								<td width="180">Luas&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?php echo str_replace(",",".",$luas); ?>,<?php echo ($exp_luas[1])?$exp_luas[1]:"00"; ?> Ha</td>
							</tr>
							
							<tr>
								<td  width="180">Status</td>
								<td>:</td>
								
								<td>&nbsp;
								<?//=($data["sifat"] == 'Private') ? '<a class="label label-danger">Private</a>' : '<a class="label label-info">Public</a>';?>
								<?=$lookup_status_akkm[$data['status_akkm']]?></td>
							</tr>
							<tr>
								<td  width="180">Jenis Kebijakan</td>
								<td>:</td>
								<td>&nbsp;<?=$data['jenis_kebijakan']?></td>
							</tr>
							<tr>
								<td  width="180">Judul Kebijakan</td>
								<td>:</td>
								<td>&nbsp;<?=$data['judul_kebijakan']?></td>
							</tr>
							<tr>
								<td class="table_title" colspan='3'>ENTRY DATA</td>
								
							</tr>
							
							<tr>
								<td colspan='3'>

									<table border="1" style="border-color:#ccc">
										<tr>
											<td style="padding:5px;">created <?=$data['creator']." on ".$data['created']?> </td>
										</tr>
										
									</table>
								</td>
								
							</tr>

							<!--<?=$data["status_konflik_proses"]?> <?=($data["status_konflik"] == 'SL') ? '<i class="green fa fa-fw fa-check"></i>' : '<i class="yellow fa fa-fw fa-warning"></i>';?>-->
								
								
						
						</table>
                    </div>
                      
					<div class="col-md-12">
						<h4 class="heading">DESKRIPSI</h4>
						<div class="row">
							<div class="col-md-12">
								<table border="1"style=" border-color:#ccc" >
									<tr><td style="padding:20px !important"><?=$data['deskripsi']?></td></tr>
								</table>
							</div>
							
							
						</div>
					</div>
					
					
                </div>
        </div>
		
		<div id="print_this" class="bg-white hidden">
			<style>
					.bordered
					{
						border:thin solid #ccc;
						border-collapse: collapse; 
					}
					 
					.bordered td 
					{
						border-collapse: collapse;
						border: 1px solid #ccc;
					}
			</style>
			  <h4 align="center"><b style="font-size:20px;font-weight:bold;"><?php echo $data["judul"];?></b> <br>&nbsp;<?=strtoupper($prop)?>, <?=strtoupper($kab)?></h4>
			  <div class="col-md-12"> 
				
				<table class="bordered" style="border-color:black;border-collapse:collapse" cellspacing="0" cellpadding="4" width="100%">
				  <tr align="center" style="border-collapse: collapse;">
					<td align="center"><b>No</b></td>
					<td width="268" valign="top"><b>Data</b></td>
					<td valign="top"><b>Uraian</b></td>
				  </tr>
				  <tr>
					<td align="center">1</td>
					<td width="304" valign="top"><p>&nbsp; Nomor Kejadian</p></td>
					<td valign="top"><p>&nbsp; <?=$data["nomor_kejadian"]?></p></td>
				  </tr>
				  <tr>
					<td align="center">2</td>
					<td width="304" valign="top"><p>&nbsp; Tanggal Kejadian</p></td>
					<td valign="top"><p>&nbsp; <?=date_format(date_create($data['tgl_kejadian']),"d-m-Y")?></p></td>
				  </tr>
				  <tr>
					<td align="center">3</td>
					<td width="304" valign="top"><p>&nbsp; Konflik</p></td>
					<td valign="top"><p>&nbsp; <?=$data["kd_konflik"]?></p></td>
				  </tr>
				  <tr>
					<td align="center">4</td>
					<td width="304" valign="top"><p>&nbsp; Status Konflik</p></td>
					<td valign="top"><p>&nbsp; 
						<?=$lookup_status_konflik[$data["status_konflik"]]?>
						<?=$data["status_konflik_proses"]?>
						</p>
					</td>
				  </tr>
				  <tr>
					<td align="center">5</td>
					<td width="304" valign="top"><p>&nbsp; Sektor</p></td>
					<td valign="top"><p>&nbsp; <?=$sek?></p></td>
				  </tr>
				  <tr>
					<td align="center">6</td>
					<td width="304" valign="top"><p>&nbsp; Sektor Lain</p></td>
					<td valign="top"><p>&nbsp; <?=$data["sektor_lain"]?></p></td>
				  </tr>
				    <?php
						$exp_investasi	=	explode(".",$data["investasi"]);
						$investasi		=	number_format($exp_investasi[0]);
					?>
				  <tr>
					<td align="center">7</td>
					<td width="304" valign="top"><p>&nbsp; Investasi</p></td>
					<td valign="top"><p>&nbsp; Rp <?php echo str_replace(",",".",$investasi); ?>,<?php echo ($exp_investasi[1])?$exp_investasi[1]:"00"; ?></p></td>
				  </tr>
				    <?php
						$exp_luas	=	explode(".",$data["luas"]);
						$luas		=	number_format($exp_luas[0]);
					?>
				  <tr>
					<td align="center">8</td>
					<td width="304" valign="top"><p>&nbsp; Luas</p></td>
					<td valign="top"><p>&nbsp; <?php echo str_replace(",",".",$luas); ?>,<?php echo ($exp_luas[1])?$exp_luas[1]:"00"; ?> Ha</p></td>
				  </tr>
				  <tr>
					<td align="center">9</td>
					<td width="304" valign="top"><p>&nbsp; Dampak Masyarakat</p></td>
					<td valign="top"><p>&nbsp; <?php echo str_replace(",",".",number_format($data["dampak"]));?> Jiwa</p></td>
				  </tr>
				  <tr>
					<td align="center">10</td>
					<td width="304" valign="top"><p>&nbsp; Confidentiality</p></td>
					<td valign="top"><p>&nbsp; <?=($data["sifat"] == 'Private') ? 'Private' : 'Public';?></p></td>
				  </tr>
				  <tr>
					<td align="center">11</td>
					<td width="304" colspan="2" valign="top"><p>&nbsp; Keterlibatan</p></td>
				  </tr>
				  <tr>
					<td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>&nbsp; a. Pemerintah</p></td>
					<td valign="top">
					<ol>
					<? foreach($att1 as $k=>$v){?>
						<li><?=$v['uraian']?></li>
					<? }?>
					</ol>
					</td>
				  </tr>
				  <tr>
					<td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>&nbsp; b. Perusahaan</p></td>
					<td valign="top">
						<ol>
						<? foreach($att2 as $k=>$v){?>
							<li>&nbsp; <?=$v['uraian']?></li>
						<? }?>
						</ol>
					</td>
				  </tr>
				  <tr>
					<td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>&nbsp; c. Masyarakat</p></td>
					<td valign="top">
						<ol>
						<? foreach($att3 as $k=>$v){?>
							<li>&nbsp; <?=$v['uraian']?></li>
						<? }?>
						</ol>
					</td>
				  </tr>
				 
				  <tr>
					<td align="center">12</td>
					<td width="304" colspan="2" valign="top"><p>&nbsp; Kontent </p></td>
				  </tr>
				  <tr>
				  <td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>&nbsp; a. Narasi</p></td>
					<td valign="top"><p>&nbsp; <?=$data["narasi"]?> </p></td>
				  </tr>
				  <tr>
					<td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>&nbsp; b. Sumber </p></td>
					<td valign="top">&nbsp; 
					<?=$data["sumber"]?></td>
				  </tr>
				  
				  <!--
				  <tr>
					<td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>d. Kondisi    Fisik Wilayah Adat</p></td>
					<td  valign="top">
					<p>
					<?php 	
						$kfisik=m_lookup("wa_kondisi_fisik","idx","kondisi_fisik",""," order by order_num asc "); 	
						$as = explode(',', $data['kondisi_fisik'] );
						foreach($as as $key => $val){
							foreach($kfisik as $k=>$v) {
								if($val == $k){
									$x[] = $v;
								}
							}	
						}
						echo '&nbsp '.implode(",", $x);
					?>
					</p>
					</td>
				  </tr>-->
				  <tr>
					<td align="center">13</td>
					<td width="304" colspan="2" valign="top"><p>&nbsp; Kontak</p></td>
				  </tr>
				  <tr>
					<td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>&nbsp; a. Nama    </p></td>
					<td  valign="top"><p>&nbsp; <?=$dataKontak["nama_kontak"]?> </p></td>
				  </tr>
				  <tr>
					<td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>&nbsp; b. Email    </p></td>
					<td  valign="top"><p>&nbsp; <?=$dataKontak["email_kontak"]?>  </p></td>
				  </tr>
				  <tr>
					<td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>&nbsp; c. Alamat  </p></td>
					<td  valign="top"><p>&nbsp; <?=$dataKontak["alamat_kontak"]?>  </p></td>
				  </tr>
				  <tr>
					<td width="36" valign="top"><p>&nbsp;</p></td>
					<td width="268" valign="top"><p>&nbsp; d. Telpon/Hp </p></td>
					<td  valign="top"><p>&nbsp; <?=$dataKontak["telpon_kontak"]?></p></td>
				  </tr>
				  
				  
				  
				</table><br>
				<div style="margin-left:40px;">
				</div>
			  </div>
			</div>
		
		<div id="print_thisx" class="bg-white hidden">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12">
							<b style="font-size:20px;font-weight:bold;"><?php echo $data["judul"];?></b> <br>&nbsp;<?=strtoupper($prop)?>, <?=strtoupper($kab)?>
						</div>
					</div><!-- end row -->
				</div>
				<!-- /.col -->
				<div class="col-md-12">
					<br>
					<div class="row">

					<div class="col-md-6">
						<table class="table table-condensed" style="margin-top:-5px;">
							<tr>
								<td class="table_title" width="200">Nomor Kejadian</td>
								<td>:</td>
								<td>&nbsp;<?=$data['nomor_kejadian']?></td>
							</tr>
							<tr>
								<td class="table_title" width="200">Tanggal Kejadian</td>
								<td>:</td>
								<td>&nbsp;<?=date_format(date_create($data['tgl_kejadian']),"d-m-Y")?></td>
							</tr>
							<tr>
								<td class="table_title">Konflik</td>
								<td>:</td>
								<td>&nbsp;<?=$data['kd_konflik']?></td>
							</tr>
							<tr>
								<td class="table_title">Status Konflik</td>
								<td>:</td>
								<td>
									&nbsp;
									<?=$lookup_status_konflik[$data["status_konflik"]]?>
									<?=$data["status_konflik_proses"]?> <?=($data["status_konflik"] == 'SL') ? '<i class="green fa fa-fw fa-check"></i>' : '<i class="yellow fa fa-fw fa-warning"></i>';?>
								</td>
							</tr>
							<tr>
								<td class="table_title">Sektor</td>
								<td>:</td>
								<td>&nbsp;<?=$sek?></td>
							</tr>
							<tr>
								<td class="table_title">Sektor Lain&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?=$data['sektor_lain']?></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">
						<table class="table table-condensed" style="margin-top:-5px;">
							<?php
								$exp_investasi	=	explode(".",$data["investasi"]);
								$investasi		=	number_format($exp_investasi[0]);
							?>
							
							<tr>
								<td class="table_title" width="200">Investasi&nbsp;</td>
								<td>:</td>
								<td>&nbsp;Rp <?php echo str_replace(",",".",$investasi); ?>,<?php echo ($exp_investasi[1])?$exp_investasi[1]:"00"; ?></td>
							</tr>
							
							<?php
								$exp_luas	=	explode(".",$data["luas"]);
								$luas		=	number_format($exp_luas[0]);
							?>
							
							<tr>
								<td class="table_title">Luas&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?php echo str_replace(",",".",$luas); ?>,<?php echo ($exp_luas[1])?$exp_luas[1]:"00"; ?> Ha</td>
							</tr>
							<tr>
								<td class="table_title">Dampak Masyarakat&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?php echo str_replace(",",".",number_format($data["dampak"]));?> Jiwa</td>
							</tr>
							<tr>
								<td class="table_title">Confidentiality&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?=($data["sifat"] == 'Private') ? '<a class="label label-danger">Private</a>' : '<a class="label label-info">Public</a>';?></td>
							</tr>
						</table>
					</div>
					</div>
				</div>
				  
				<div class="col-md-12">
					<h4 class="heading">KETERLIBATAN</h4>
					<div class="row">
						<div class="col-md-4">
							<label for="alamat">Pemerintah</label> 
							<div id="detil_urusan">
							<?php if(cek_array($att1)):?>
							<?php foreach($att1 as $k=>$v): ?>
							 <div class="row">
								<ul><li><?=$v['uraian']?></li></ul>
							 </div>	
							<?php endforeach; ?>
							<?php else:
									echo "<i><strong>--Tidak Ada--</strong></i>";
								  endif;
							?>
							</div>
						</div>
						<div class="col-md-4">
							<label for="alamat">Perusahaan</label> 
							<div id="detil_urusan2">
							<?php if(cek_array($att2)):?>
							<?php foreach($att2 as $k=>$v): ?>
							 <div class="row">
								<ul><li><?=$v['uraian']?></li></ul>
							 </div>	
							<?php endforeach; ?>
							<?php else:
									echo "<i><strong>--Tidak Ada--</strong></i>";
								  endif;
							?>
							</div>
						</div>
						<div class="col-md-4">
							<label for="alamat">Masyarakat</label> 
							<div id="detil_urusan3">
							<?php if(cek_array($att3)):?>
							<?php foreach($att3 as $k=>$v): ?>
							 <div class="row">
								<ul><li><?=$v['uraian']?></li></ul>
							 </div>	
							<?php endforeach; ?>
							<?php else:
									echo "<i><strong>--Tidak Ada--</strong></i>";
								  endif;
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					
					<div class="row">
						<div class="col-md-8">	
						<h4 class="heading">KONTENT</h4>
							<div class="form-group">
								<label for="alamat">Klip</label>
								<p align="justify" id="narasi"><?=$data["clip"]?></p>
							</div>
							<div class="form-group">
								<label for="alamat">Narasi</label>
								<p align="justify" id="narasi"><?=$data["narasi"]?></p>
							</div>
							<hr /> 
							<div class="form-group">
								<label>Sumber</label>
								<p align="justify"><?php echo $data["sumber"];?></p>
							</div>
						</div>
						<div class="col-md-4">	
						<h4 class="heading">KONTAK</h4>
							<div class="form-group">
								<label>Nama</label>
								<p align="justify"><?=$dataKontak["nama_kontak"]?></p>
							</div>
							<div class="form-group">
								<label>Email</label>
								<p align="justify"><?=$dataKontak["email_kontak"]?></p>
							</div>
							<div class="form-group">
								<label>Alamat</label>
								<p align="justify"><?=$dataKontak["alamat_kontak"]?></p>
							</div>
							<div class="form-group">
								<label>Telpon/Hp</label>
								<p align="justify"><?=$dataKontak["telpon_kontak"]?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    		
    </div>
</div>





</section>

<script>
	var cloudmade =L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
				maxZoom: 18
			});
			
		var baseLayers = {
		  "OSM CloudMade": cloudmade,	
		  //"Street Map": mapquestOSM,
		  //"Aerial Imagery": mapquestOAM,
		  //"Imagery with Streets": mapquestHYB
		};	

		var map=null;
		var jsonlayer=null;
		var markers=[];
		var markerFlag=1;
		var info=null;
		var legend=null;
		var mark_location_new=null;
		var mark_location=null;
		var lat=null;
		var lon=null;
		
		var blueMarker = L.AwesomeMarkers.icon({
			prefix:'fa',
			icon: 'home',
			markerColor: 'blue'
		});
		var orangeMarker = L.AwesomeMarkers.icon({
			prefix:'fa',
			icon: 'home',
			markerColor: 'orange'
		});
		
		function loadMap(){
			if(map==null){
				/*
				map = L.map('mapx').setView([1, 114],4);
				 cloudmade = L.tileLayer('http://{s}.tile.cloudmade.com/{key}/{styleId}/256/{z}/{x}/{y}.png', {
					attribution: 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
					key: 'BC9A493B41014CAABB98F0471D759707',
					styleId: 22677
				}).addTo(map);
				*/
				/*
				console.log(cloudmade);
				var map = L.map('mapx', {
					layers: [cloudmade] // only add one!
				}).setView([1, 114],10);
				*/
				
				map = L.map('mapx').setView([1, 114],4);
				map.addLayer(cloudmade);
				
				/*
				L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
					maxZoom: 18
				}).addTo(map);
				*/
				//cloudmade.addTo(map);
				
				L.control.layers(baseLayers).addTo(map);
				
				/* add search control */
				/*
				new L.Control.GeoSearch({
						provider: new L.GeoSearch.Provider.Google(),
						//provider: new L.GeoSearch.Provider.OpenStreetMap(),
						showMarker: false
				}).addTo(map);
				*/
				new L.Control.GeoSearch({
						provider: new L.GeoSearch.Provider.Google({
							bounds: { north: 6, east: 145, south: -11, west: 92 }	
						}),
						showMarker: false
				}).addTo(map);
				
			}	
			
			    var loc=map.getCenter();
				
				var validLon=$("#x").val()>95?true:false;
				var longitude=$("#x").val()||loc.lng;
				var latitude=$("#y").val()||loc.lat;
				var zoom=4;
				if(validLon){
					zoom=10;
				}
				if (!mark_location) {
					mark_location = L.marker([latitude,longitude],{icon:blueMarker}).bindPopup("Lokasi AKKM").addTo(map);
					map.setView([latitude, longitude], zoom);
				}
			
		}
		
		$(function(){
			$("#mapx").remove();
			$("#map").html("<div id='mapx' style='width:100%;height:100%'></div>");
			lon=$("#x").val();
			lat=$("#y").val();
			//alert(lon);
			//alert(lat);
			
			/*
			$("#map").css("max-height", $(window).height() - $(".navbar-static-top").height() -35);
			$("#map").css("height", $(window).height() - $(".navbar-static-top").height()-35);
			
			$(window).resize(function() {
				$("#map").css("max-height", $(window).height() - $(".navbar-static-top").height() -35);
				$("#map").css("height", $(window).height() - $(".navbar-static-top").height() -35);
			});
			*/
			loadMap();	
			
			//map.on('click', addMarker);	
			
			$("#btn_set_point").click(function(e){
				e.preventDefault();
				var latitude=$("#y").val()*1 || map.getCenter().lat;
				var longitude=$("#x").val()*1 || map.getCenter().lng; 
				
				if (!mark_location) {
					mark_location = L.marker([latitude,longitude]).bindPopup("Lokasi Konflik").addTo(map);
				}else{
					mark_location.setOpacity(0.5);
					if (!mark_location_new) {
						mark_location_new = L.marker([latitude,longitude],{icon:orangeMarker}).bindPopup("Lokasi Baru").addTo(map);
					}
					mark_location_new.setLatLng([latitude,longitude]).update();
					//
					var markerArray = [];
					markerArray.push(mark_location);
					markerArray.push(mark_location_new);
					var group = L.featureGroup(markerArray); //add markers array to featureGroup
        			if(mark_location.getLatLng().toString()!=mark_location_new.getLatLng().toString()){
						//console.log("test");
						//console.log(mark_location.getLatLng());
						//console.log(mark_location_new.getLatLng());
						map.fitBounds(group.getBounds());  
					}else{
						console.log("test2");
						map.setView([latitude, longitude], 10);
					}
				}
				
				
			});
			
			/*
			map.on('click', function(e) {
    			//alert("test");
				//alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
				var latitude=e.latlng.lat;
				var longitude=e.latlng.lng;
				
				$("#x").val(e.latlng.lng);
				$("#y").val(e.latlng.lat);
				if (!mark_location) {
					mark_location = L.marker([latitude,longitude]).bindPopup("Lokasi Sekarang").addTo(map);
				}else{
					mark_location.setOpacity(0.5);
					if (!mark_location_new) {
						mark_location_new = L.marker([latitude,longitude],{icon:orangeMarker}).bindPopup("Lokasi Baru").addTo(map);
					}
					mark_location_new.setLatLng([latitude,longitude]).update();
				}
			});
			*/
		});
		
		function search_location(q){
			var limit=10;
				$.getJSON("http://nominatim.openstreetmap.org/search?format=json&limit="+limit+"&q="+q+"&countrycodes=id",function(data){
					latitude=data[0].lat;
					longitude=data[0].lon;
					map.setView([latitude, longitude], 6);
				});	
		}
		
		
		function addMarker(e){
			// Add marker to map at click location; add popup window
			var newMarker = new L.marker(e.latlng).addTo(map);
		}
		
</script>
