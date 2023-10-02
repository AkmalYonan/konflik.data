<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>
<script src="https://maps.google.com/maps/api/js?v=3.2&sensor=false"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js//leaflet-google.js"></script>

<style>
	#map{
		position:relative;
		/*box-shadow: 0 0 10px rgba(0,0,0,0.5);*/
		height: 100%;
		/*min-height:400px;*/
		width:auto;
	}
	.leaflet-google-layer{
    	z-index: 0 !important;
	}
	.leaflet-map-pane{
		z-index: 100;
	}
	
	.leaflet-top,
	.leaflet-bottom {
		z-index: 499 !important;
	}
	
	#loader_leaflet {
		position:absolute; top:0; bottom:0; width:100%;
		background:rgba(255, 255, 255, 0.5);
		transition:background 1s ease-out;
		-webkit-transition:background 1s ease-out;
		z-index:10000;
	}
	
	#loader_leaflet.done {
		background:rgba(255, 255, 255, 0);
	}
	
	#loader_leaflet.hide {
		display:none;
	}
	
	#loader_leaflet .message {
		position:absolute;
		left:50%;
		top:50%;
		-webkit-transform: translate(-50%, -50%);
	  	transform: translate(-50%, -50%);
		border-top-left-radius: 0;
    	border-top-right-radius: 0;
		/*background-color: #F9EDBE;*/
		background-color: #FFF;
    	border: #F0C36D 1px solid;
		color: #222222;
		border-radius: 2px 2px 2px 2px;
    	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    	padding: 3px 10px;
	}
	
	.info {
		padding: 6px 8px;
		/*font: 14px/16px Arial, Helvetica, sans-serif;*/
		background: white;
		background: rgba(255,255,255,0.8);
		box-shadow: 0 0 15px rgba(0,0,0,0.2);
		border-radius: 5px;
	}
	
</style>

<section class="content-header">
  <h1 class="hidden-xs">
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>" class="active"><?=$this->module_title?></a></li>
  </ol>
</section>

<section class="content">
	<div class="row">
    <div class="col-md-12">
		<div id="map" style="width:100%;height:400px"></div>
         <div id='loader_leaflet' style="display:none"><span class='message'>loading <img src="assets/images/loader2.gif" /></span></div>
         
          <div class="info hidden" style="position:absolute;z-index:100;width:218px;top:12px;margin-left:10px;float:left">Status Dominan : <?php echo form_dropdown("status_dominan",$arr_type_dominan,"","id='status_dominan' class='form-control' style='height:28px;width:100%;font-size:0.9em;margin-top:6px' data-total='".json_encode($data_footer)."'");?>
           </div>
         
    </div></div>
</section>

<script>
	var cloudmade =L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
				maxZoom: 18
			});
			
			var Esri_WorldImagery = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
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
		
		var Esri_WorldStreetMap = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
	attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
});
		
		var googleLayer = new L.Google('ROADMAP');
		
		var baseLayers = {
		  "OSM CloudMade": cloudmade,	
		  "Google Street":googleLayer,
		  //"Street Map": mapquestOSM,
		  //"Aerial Imagery": mapquestOAM,
		  "Imagery with Streets": Esri_WorldStreetMap,
		  "Satellite View":Esri_WorldImagery
		};	

	//var map = L.map('map');
	var map=null;
	
	$(function(){
		$("#mapx").remove();
		$("#map").html("<div id='mapx' style='width:100%;height:100%'></div>");
	
		$("#map").css("max-height", $(window).height() - $(".navbar-static-top").height() -70);
		$("#map").css("height", $(window).height() - $(".navbar-static-top").height()-70);
		
		$(window).resize(function() {
			$("#map").css("max-height", $(window).height() - $(".navbar-static-top").height() -70);
			$("#map").css("height", $(window).height() - $(".navbar-static-top").height() -70);
		});
		
		loadMap();
	});
	
	var blueMarker = L.AwesomeMarkers.icon({
			prefix:'fa',
			icon: 'home',
			markerColor: 'red'
		});
		
	
	function loadMap(){
		if(map==null){
			map = L.map('mapx').setView([-1, 118],5);
			map.addLayer(cloudmade);
			
      		//map.addLayer(googleLayer);
		}
		if(map.jsonlayer!=null){
			map.removeLayer(jsonlayer);
			jsonlayer=null;
		}
		L.control.layers(baseLayers).addTo(map);
		var url="<?=$this->base_url?>data_service/map/ipnwl.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11";
		$("#loader_leaflet").show();
		$.getJSON(url,function(data){
			    $("#loader_leaflet").fadeOut();
				jsonlayer=L.geoJson(data,{
    				pointToLayer: function(feature,latlng){
						var marker=L.marker(latlng,{icon: blueMarker});
						//marker.bindPopup(feature.properties.nama + '<br/>' + feature.properties.alamat);
      					return marker;
					},onEachFeature: function(feature, layer){
						//alert(feature.properties.nama);	
						layer.bindPopup(feature.properties.nama + '<br/>' + feature.properties.alamat);
					}
    			}).addTo(map);
				
				
		});
		//map.addLayer(jsonlayer);
			
	}
</script>