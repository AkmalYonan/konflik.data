<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?php
	$lookup_tipe_org[""]="--Pilih--";
	$lookup_tipe_org=$lookup_tipe_org+lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","","order by order_num");
	
?>
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>
<!--<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.openstreetmap.js"></script>
-->
<style>
	/*
	.content{padding:0!important;}
	#map{
		position:relative;
		box-shadow: 0 0 10px rgba(0,0,0,0.5);
		height: 100%;
		width:auto;
	}*/
</style>

<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
    <li class="active">Edit</li>
  </ol>
</section>
<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
        	<div class="content-toolbar">
                	<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>edit/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white btn-delete" href="<?php echo $this->module?>" data-toggle='tooltip' title="Cancel/Back To List">
                        <i class="fa fa-remove"></i>
                    </a>	  
            </div>
        	<div class="box box-widget">
            	<!--<div class="box-header with-border">
                  <h3 class="box-title">Data User</h3>
                </div>-->
                <div class="box-body">
                <form id="frm" method="post" action="<?php echo $this->module;?>edit/<?php echo $id;?>">
                  <input type="hidden" name="act" id="act" value="update"/>
                  <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
                  <div class="row">
                    <div class="col-md-6">
                    	<div class="row">
                            <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="category">BNN/BNNP/BNNK</label>
                                    <? echo form_dropdown("tipe_org",$lookup_tipe_org,$data["tipe_org"],"id='tipe_org' class='form-control select2'");?>
                                </div><!-- /control-group category-->
                            </div><!-- end col -->
                            <?php
                                $arrPropinsi=m_lookup("propinsi2","kode_bps","nama");
                                $arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
                                $arrWilKab=array(""=>"--Pilih--");
                                if($data["kd_wilayah_propinsi"]):
                                    $arrWilKab=$arrWilKab+m_lookup("kabupaten_kota","kode_bps","nama","kode_prop={$data["kd_wilayah_propinsi"]} and kode_kab!='00'");
                                endif;
                                
                                $level=$data["level_wilayah"];
                                            
                            ?>
                                        
                            <div class="<?=$level==1?"col-md-8":"col-md-4"?>" id="div_wilayah_propinsi">
                                <div class="form-group">
                                    <label>Wilayah Propinsi</label>
                                    <?=form_dropdown("kd_wilayah_propinsi",$arrPropinsi1,$data["kd_wilayah_propinsi"],"id='kd_wilayah_propinsi' class='form-control required' style='width:100% !important;'");?>
                                                
                                </div>
                            </div><!-- end col -->
                            
                            <div class="col-md-4 <?=$level==1?"hide":""?>" id="div_wilayah_kabupaten">
                                <div class="form-group">
                                    <label>Wilayah Kabupaten</label>
                                    <div id="id_wilayah_kabupaten_holder">
                                    <?=form_dropdown("kd_wilayah_kabupaten",$arrWilKab,$data["kd_wilayah_kabupaten"],"id='kd_wilayah_kabupaten' class='form-control required'");?>
                                    </div>
                                                
                                </div>
                            </div><!-- end col -->
                    	</div><!-- end row-->
                    
                    	<div class="formSep"></div>
                    	<div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label for="kd_jenis_instansi">Nama</label>
                                  <label class="pull-right">
                                      <input type="checkbox" name="active" class="flat-red" <?php echo $data['active']?"checked='checked'":'';?> value="1">
                                      Active
                                  </label>	
                                  <input class="form-control required" name="nama" type="text" id="nama" value="<?php echo $data["nama"];?>" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="formSep"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="input-xs form-control required" id="alamat" rows="5" name="alamat" placeholder=""><?=$data["alamat"]?></textarea>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    $arrKab=array(""=>"--Pilih--");
                                    if($data["kd_propinsi"]):
                                    $arrKab=$arrKab+m_lookup("kabupaten_kota","kode_bps","nama","kode_prop={$data["kd_propinsi"]} and kode_kab!='00'");
                                    endif;
                                    
                                ?>
                                <div class="form-group">
                                <label>Propinsi</label>
                                <?=form_dropdown("kd_propinsi",$arrPropinsi1,$data["kd_propinsi"],"id='kd_propinsi' class='form-control required'");?>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Kabupaten</label>
                                <div id="id_kabupaten_holder">
                                <?=form_dropdown("kd_kabupaten",$arrKab,$data["kd_kabupaten"],"id='kd_kabupaten' class='form-control select2'");?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Kecamatan</label>
                                <?php echo form_input('kecamatan',$data["kecamatan"],'class="form-control required"');?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Desa</label>
                                <?php echo form_input('desa',$data["desa"],'class="form-control required"');?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    	<div class="row">
                      		<div class="col-md-12">
                            	<div id="map" style="height:300px;"></div>
                        	</div>
                        </div><!-- end row -->
                        <br>
                        <div class="row">
                        	<div class="col-md-6">
                            	<div class="form-group">
									<label>X (Longitude)</label>
									<?php echo form_input('x',$data["x"],'id="x" data-x="'.$data["x"].'" class="form-control required"');?>
								</div>
                            </div>
                            <div class="col-md-6">
                            	<div class="form-group">
									<label>Y (Latitude)</label>
									<?php echo form_input('y',$data["y"],'id="y" data-y="'.$data["y"].'" class="form-control required"');?>
								</div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                <!-- /.box-body -->
                <div class="box-footer well well-sm no-shadow">
                     <!--Username digunakan pada saat login.-->
                     &nbsp;
                </div>
             </form>
        	</div>
        </div>
        <!-- /.box -->
      </div>
    </div>
</section>

<script language="javascript">
$(function(){
	$("#kd_propinsi").select2({'placeholder':"--Pilih Propinsi--"});
	$("#kd_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	$("#kd_wilayah_propinsi").select2({'placeholder':"--Pilih Propinsi--"});
	$("#kd_wilayah_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
	$("#tipe_org").change(function(){
			var tipe_org=$("#tipe_org :selected").val();
			if(tipe_org=='BNNP'){
				//$("#kd_wilayah_kabupaten").closest("#div_wilayah_kabupaten").hide();
				$("#div_wilayah_kabupaten").hide();
				$("#div_wilayah_propinsi").removeClass("col-md-4").addClass("col-md-8");	
			}
			if(tipe_org=='BNNK'){
				$("#div_wilayah_kabupaten").show();
				//$("#kd_wilayah_kabupaten").closest("#div_wilayah_kabupaten").show();
				$("#div_wilayah_propinsi").removeClass("col-md-8").addClass("col-md-4");	
			}
	});
	
	$(document).on("change","#kd_kabupaten",function(){
		var kabupaten=$("#kd_kabupaten :selected").text();
		var propinsi=$("#kd_propinsi :selected").text();
		
		//search_location(kabupaten+","+propinsi);
	});
	
	$("#kd_propinsi").change(function(){
   		var id_propinsi = $(this).val();
		var propinsi=$(this).find(":selected").text();
		//console.log(propinsi);
		//search_location(propinsi);
		
		//var nm_propinsi = $("#id_propinsi option:selected").text();
		$("#id_kabupaten_holder").load("<?=base_url()?>lookup/wilayah/get_kab_kota2/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#kd_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
			//getgeoCode(nm_propinsi);
			/*
			$("#id_kabupaten").change(function(){
				var nm_address = nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				getgeoCode(nm_address);
		   });*/
		   
		});
		
   });
   
   $("#kd_wilayah_propinsi").change(function(){
   		var id_propinsi = $(this).val();
		var propinsi=$(this).find(":selected").text();
		//console.log(propinsi);
		//search_location(propinsi);
		
		//var nm_propinsi = $("#id_propinsi option:selected").text();
		$("#id_wilayah_kabupaten_holder").load("<?=base_url()?>lookup/wilayah/get_wilayah_kab_kota/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#kd_wilayah_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
		});
		
   });
   
   
   
});

$(document).ready(function(){      
	/*$('#prov').change(function(){
		$.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
			$('#kab').html(obj);
		});
    });*/
	$("#previewplay").click(function(){
		$("#imgInpPlay").trigger("click");
	});
});
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '180px');
                //$('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>
<script>
	$(function(){
		$("#frm").validate();
		
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
		
		$(".group").click(function(){
			//$("#company").prop("disabled",$(this).data('org')==1 ? false: true);
			var use_org = $(this).data('org');
			$("#company").val(use_org);
			$("#company option").show();
			$("#company option").each(function(){
				if (!use_org) {
					$(this).val()!=0?$(this).hide():$(this).show();
				}
				else {
					$(this).val()!=0?$(this).show():$(this).hide();
				}
			});
		});
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		  checkboxClass: 'icheckbox_flat-green',
		  radioClass: 'iradio_flat-green'
		});
	})
</script>


<script>
	var cloudmade =L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
				maxZoom: 18
			});
			
		var mapquestOSM = L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
		  maxZoom: 19,
		  subdomains: ["otile1", "otile2", "otile3", "otile4"],
		  attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
		});
		var mapquestOAM = L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
		  maxZoom: 18,
		  subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"],
		  attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>. Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency'
		});
		var mapquestHYB = L.layerGroup([L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
		  maxZoom: 18,
		  subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"]
		}), L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/hyb/{z}/{x}/{y}.png", {
		  maxZoom: 19,
		  subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"],
		  attribution: 'Labels courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA. Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency'
		})]);
		
		var baseLayers = {
		  "OSM CloudMade": cloudmade,	
		  "Street Map": mapquestOSM,
		  "Aerial Imagery": mapquestOAM,
		  "Imagery with Streets": mapquestHYB
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
					mark_location = L.marker([latitude,longitude],{icon:blueMarker}).bindPopup("Data").addTo(map);
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
			
			
			map.on('click', function(e) {
    			//alert("test");
				//alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
				var latitude=e.latlng.lat;
				var longitude=e.latlng.lng;
				
				$("#x").val(e.latlng.lng);
				$("#y").val(e.latlng.lat);
				if (!mark_location) {
					mark_location = L.marker([latitude,longitude]).bindPopup("Data").addTo(map);
				}else{
					mark_location.setOpacity(0.5);
					if (!mark_location_new) {
						mark_location_new = L.marker([latitude,longitude],{icon:orangeMarker}).bindPopup("Data").addTo(map);
					}
					mark_location_new.setLatLng([latitude,longitude]).update();
				}
			});
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