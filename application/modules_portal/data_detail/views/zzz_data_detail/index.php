<!--
<section class="main-banner text-center-xs">
    <div class="container text-lite-color" style="background-image:url('assets/images/banner.jpg'); height:100%">
        <h2 class="text-medium">Blog Single Page</h2>
    </div>
</section>
-->


<script type="text/javascript" src="assets/js/maskF/my.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>

<link rel="stylesheet" href="assets/css/rrss.css">
<script src="assets/js/jquery-rrss.js"></script>

<style>
.leaflet-top,
.leaflet-bottom {
	z-index: 499;
}
h4.heading{
	font-size:16px;
	font-weight:bold;
	background-color:#E5E5E5;
	padding:10px;
}
p{
	font-size:14px;
}
.keterlibatan{
	font-size:14px;
}
.mailbox-attachment-info{
	font-size:13px;
}
.mailbox-attachments{
	list-style:none;
}
.table_title{
	font-weight:bold;
}
#narasi{
	text-indent:50px;
}
</style>

<style>
.green{color:#00A65A}
.yellow{color:#F39C12}
.mailbox-messages > .table {
    margin: 0;
}
.mailbox-controls {
    padding: 5px;
}
.mailbox-controls.with-border {
    border-bottom: 1px solid #f4f4f4;
}
.mailbox-read-info {
    border-bottom: 1px solid #f4f4f4;
    padding: 10px;
}
.mailbox-read-info h3 {
    font-size: 20px;
    margin: 0;
}
.mailbox-read-info h5 {
    margin: 0;
    padding: 5px 0 0;
}
.mailbox-read-time {
    color: #999;
    font-size: 13px;
}
.mailbox-read-message {
    padding: 10px;
}
.mailbox-attachments li {
    border: 1px solid #eee;
    float: left;
    margin-bottom: 10px;
    margin-right: 10px;
    width: 200px;
}
.mailbox-attachment-name {
    color: #666;
    font-weight: bold;
}
.mailbox-attachment-icon, .mailbox-attachment-info, .mailbox-attachment-size {
    display: block;
}
.mailbox-attachment-info {
    background: #f4f4f4 none repeat scroll 0 0;
    padding: 10px;
}
.mailbox-attachment-size {
    color: #999;
    font-size: 12px;
}
.mailbox-attachment-icon {
    color: #666;
    font-size: 65px;
    padding: 20px 10px;
    text-align: center;
}
.mailbox-attachment-icon.has-img {
    padding: 0;
}
.mailbox-attachment-icon.has-img > img {
    height: auto;
    max-width: 100%;
}
</style>

<?php
	$lookup_status_konflik["BD"]="Belum Ditangani";
	$lookup_status_konflik["PS"]="Dalam Proses";
	$lookup_status_konflik["SL"]="Selesai";
?>
<!--header-->
<div class="well well-sm sub-head" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-6">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>DATA DETIL</strong></h6>
                    </div>
					
                </div>
            </div>
        </div>
    </div>
</div>
<!--end header-->
<div class="main-container container">
    <div class="row">
    	<div class="col-sm-12 col-xs-12">
            <div class="content">
                <div class="row">
                  <!--<div class="container text-center-xs">
                    <ol class="breadcrumb flat">
                      <li><a href="home">Beranda</a></li>
                      <li><a href="<?=$this->module?>list_data">List Data</a></li>
                      <li class="active">Detail</li>
                    </ol>
                  </div>-->
                  <div class="col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-sm-6">
								<div class="text-uppercase block-2">
									<h6 style=" border:none !important; margin-top:10px" class="sub-heading-1 text-center-xs text-spl-color"><strong><?php echo $data["judul"];?></strong></h6>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="pull-right">
									<? modules::load('filler/filler')->social_share('Tanah Kita - Detail Konflik : '.$data['judul']);?>
								</div>
							</div>
						</div>
						
						<div class="media ">
							<div class="row">
                                <div class="col-sm-12">
									<h6 class="media-heading">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<div id="map" style="height:300px;"></div>
													<?php echo form_input('longitude',$data["longitude"],'id="x" data-x="'.$data["longitude"].'" class="form-control hidden required"');?>
													<?php echo form_input('latitude',$data["latitude"],'id="y" data-y="'.$data["latitude"].'" class="form-control hidden required"');?>
													<p style="opacity: 0.6;background-color:red;margin-top:-25px;width:50%;font-size:13px;padding:5px 10px;"><b style="color:black">&nbsp;<?=strtoupper($prop)?>, <?=strtoupper($kab)?></b></p>
												</div>
											</div><!-- end row -->
										</div>
										
										<div class="col-md-6">
											<table class="table table-condensed" style="font-size:13px;">
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
													<td>&nbsp;<?=$lookup_status_konflik[$data["status_konflik"]]?><?=$data["status_konflik_proses"]?> <?=($data["status_konflik"] == 'SL') ? '<i class="green fa fa-fw fa-check"></i>' : '<i class="yellow fa fa-fw fa-warning"></i>';?>
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
												<!--
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
												-->
												<?php
													$exp_investasi	=	explode(".",$data["investasi"]);
													$investasi		=	number_format($exp_investasi[0]);
												?>
												
												<tr>
													<td class="table_title">Investasi&nbsp;</td>
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
									
									<div class="row">
										<div class="col-md-12">
											<h4 class="heading">KETERLIBATAN</h4>
											<div class="row keterlibatan">
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
									</div>
									
									<div class="row">
										<div class="col-md-12">
											<h4 class="heading">KONTEN</h4>
											<div class="row">
												<div class="col-md-12">	
													<div class="form-group">
														<label for="alamat">Narasi</label>
														<p align="justify" id="narasi"><?=nl2br($data["narasi"])?></p>
													</div>
													<hr /> 
													<div class="form-group">
														<label>Sumber</label>
														<p align="justify"><?php echo $data["sumber"];?></p>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-12">
											<h4 class="heading">LAMPIRAN</h4>
											<div class="row">
												<div class="col-sm-12">
													<?php if(cek_array($file)): ?>
														<ul class="mailbox-attachments clearfix" style="padding-left:0">
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
																			<a href="<?=$vf['file_path']?>" class="btn btn-default btn-xs pull-right" target="_blank"><i class="fa fa-cloud-download"></i></a>
																		</span>
																	</div>
																</li>
															<?php endforeach; ?>
														</ul>
													<?php else: ?>
														<table class="table" style="font-size:13px;">
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
                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>

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

<!--
<script>
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
		
        reader.onload = function (e) {
            $('#attachment').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
	
	if(this.files[0].size>500000){
		alert("Ukuran Foto Melebihi 500 kb");
	}else{
		readURL(this);
	}
	
});
</script>
-->

<script>
<?php for($i=1; $i<4; $i++): ?>
document.getElementById("imgInp<?=$i?>").onchange = function () {
    var reader = new FileReader();

    reader.onload = function (e) {
        // get loaded data and render thumbnail.
        document.getElementById("attachment<?=$i?>").src = e.target.result;
    };

    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
};
<?php endfor; ?>
</script>
