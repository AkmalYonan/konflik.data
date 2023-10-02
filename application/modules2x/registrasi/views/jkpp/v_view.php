<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
?>
<?php
	$lookup_jns_pulau[""]="--Pilih--";
	$lookup_jns_pulau["P"]="Pribadi";
	$lookup_jns_pulau["U"]="Umum";
	$lookup_jns_pulau["PU"]="Pribadi & Umum";

	$lookup_konflik=lookup("m_konflik","uraian","uraian","","order by uraian");
	$lookup_strip[""]="--Pilih--";
	$lookup_sektor=$lookup_strip+lookup("m_sektor","kode","uraian","","order by uraian");	
	$arx=explode(",",$data['kd_konflik']);
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
.leaflet-top,
.leaflet-bottom {
	z-index: 499;
}
.table_title{
	font-weight:bold;
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
		</div>
		
		<div class="box-body">
                <div class="row">
                    <div class="col-md-6">
						<div class="row">
                      		<div class="col-md-12">
								<p style="font-size:18px;font-weight:bold;"><?php echo $data["judul"];?></p>
                            	<div id="map" style="height:280px;"></div>
                        	</div>
                        </div><!-- end row -->

						<?php echo form_input('longitude',$data["longitude"],'id="x" data-x="'.$data["longitude"].'" class="form-control hidden required"');?>
						<?php echo form_input('latitude',$data["latitude"],'id="y" data-y="'.$data["latitude"].'" class="form-control hidden required"');?>

                    
                    	<div class="row">
								<div class="col-md-12">
									<p style="opacity: 0.6;background-color:red;margin-top:-20px;width:50%"><b style="color:black">&nbsp;<?=strtoupper($prop)?>, <?=strtoupper($kab)?></b></p>
									<p align="justify"><b>Klip:</b> <?=$data["clip"]?></p>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									
								</div>
							</div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
						
                    	<!--
                    	<table style="font-size:16px;margin-top:30px;" border="0" cellspacing="10" cellpadding="10" >\
                    	-->
                    	<br /><br />
                    	<table class="table table-condensed" style="margin-top:-5px;">
							<tr>
								<td class="table_title" width="200">Tahun</td>
								<td>:</td>
								<td>&nbsp;<?=$data['tahun']?></td>
							</tr>
							<tr>
								<td class="table_title">Konflik</td>
								<td>:</td>
								<td>&nbsp;<?=$data['kd_konflik']?></td>
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
							<tr>
								<td class="table_title">Jenis Tanah&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?php $var = (($data["jns_pulau"] == 'U') ? 'Umum' : ($data["jns_pulau"] == 'Pribadi') ? 'Pribadi' : 'Pribadi & Umum');echo $var;?></td>
							</tr>
							<tr>
								<td class="table_title">Jenis Tanah Umum&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?=$data['pulau_umum']?></td>
							</tr>
							<tr>
								<td class="table_title">Investasi&nbsp;</td>
								<td>:</td>
								<td>&nbsp;Rp <?=str_replace(",",".",number_format($data['investasi']))?></td>
							</tr>
							<tr>
								<td class="table_title">Luas&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?php echo $data["luas"];?> Ha</td>
							</tr> 
							<tr>
								<td class="table_title">Dampak Masyarakat&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?php echo $data["dampak"];?> Jiwa</td>
							</tr>
						</table>
                    </div>
                      
					<div class="col-md-12">
						<h4 class="heading">KETERLIBATAN</h4>
						<div class="row">
							<div class="col-md-4">
								<label for="alamat">Pemerintah</label> 
								<div id="detil_urusan">
								<?php foreach($att1 as $k=>$v): ?>
								 <div class="row">
									<ul><li><?=$v['uraian']?></li></ul>
								 </div>	
								<?php endforeach; ?>
								</div>
							</div>
							<div class="col-md-4">
								<label for="alamat">Perusahaan</label> 
								<div id="detil_urusan2">
								<?php foreach($att2 as $k=>$v): ?>
								 <div class="row">
									<ul><li><?=$v['uraian']?></li></ul>
								 </div>	
								<?php endforeach; ?>
								</div>
							</div>
							<div class="col-md-4">
								<label for="alamat">Masyarakat</label> 
								<div id="detil_urusan3">
								<?php foreach($att3 as $k=>$v): ?>
								 <div class="row">
									<ul><li><?=$v['uraian']?></li></ul>
								 </div>	
								<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<h4 class="heading">KONTENT</h4>
						<div class="row">
							<div class="col-md-12">	
								<div class="form-group">
									<label for="alamat">Narasi</label>
									<p align="justify"><?=$data["narasi"]?></p>
								</div>
								<hr /> 
								<div class="form-group">
									<label>Sumber</label>
									<p align="justify"><?php echo $data["sumber"];?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<h4 class="heading">Lampiran</h4>
						<div class="row">
							<div class="col-sm-12">
								<!--</?=pre($file)?>-->
								<?php if(cek_array($file)): ?>
									<ul class="mailbox-attachments clearfix">
										<?php foreach($file as $kf=>$vf): ?>
											<?php
												if($vf['is_image']):
													$icon		=	"fa-file-image-o";
												else:
													if($vf['file_ext']==".pdf"):
														$icon	=	"fa-file-pdf-o";
													elseif($vf['file_ext']==".docx" or $vf['file_ext']==".doc"):
														$icon	=	"fa-file-word-o";
													elseif($vf['file_ext']==".rar" or $vf['file_ext']==".zip"):
														$icon	=	"fa-file-zip-o";
													else:
														$icon	=	"fa-file-o";
													endif;
												endif;
											?>
											<li>
												<span class="mailbox-attachment-icon"><i class="fa <?=$icon?>"></i></span>

												<div class="mailbox-attachment-info">
													<a href="<?=$vf['file_path']?>" class="mailbox-attachment-name" target="_blank" title="<?=$vf['lampiran_name']?>">
														<i class="fa fa-paperclip"></i>
														<?php
															if(strlen($vf['lampiran_name'])>20):
																echo substr($vf['lampiran_name'],0,20)."...";
															else:
																echo $vf['lampiran_name'];
															endif;
														?>
													</a>
													<span class="mailbox-attachment-size">
														<?=$vf['file_size']?> KB
														(<i><?=($vf['lampiran_type']==1)?"Private":"Public"?></i>)
														<a href="<?=$vf['file_path']?>" class="btn btn-default btn-xs pull-right" target="_blank"><i class="fa fa-cloud-download"></i></a>
													</span>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php else: ?>
									<table class="table">
										<tr>
											<td align="center"><i><strong>--Tidak Ada Lampiran--</strong></i></td>
										</tr>
									</table>
								<?php endif; ?>
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
					mark_location = L.marker([latitude,longitude],{icon:blueMarker}).bindPopup("Lokasi Konflik").addTo(map);
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
