<link rel="stylesheet" type="text/css" href="assets/js/leaflet-1.3.1/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet-1.3.1/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet-1.3.1/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet-1.3.1/leaflet.js"></script>
<script src="assets/js/leaflet-1.3.1/plugins/leaflet.ajax.min.js"></script>
<script src="assets/js/leaflet-1.3.1/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet-1.3.1/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet-1.3.1/leaflet-l-geosearch/js/l.geosearch.provider.openstreetmap.js"></script>
<script src="assets/js/leaflet-1.3.1/plugins/googleMutant/Leaflet.GoogleMutant.js"></script>

<? if ($icon):?>
<script>
	var LeafIcon = L.Icon.extend({
		options: {
			iconSize:     [64, 53]
		}
	});
	var defaultMarker = new LeafIcon({iconUrl: '<?=$icon?>'});
	var defaultLabelMarker = '<?=$label;?>';
	var defaultLabelPosition = '<?=$label_pos;?>';
	var defaultlabelOffset = [0,0];
	switch(defaultLabelPosition) {
		case 'center':
			defaultlabelOffset=[0,-5];
			break;
		default:
			defaultlabelOffset=[25,5];
			break;
	}
</script>
<? endif;?>
<script>
	var cloudmade =L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
		maxZoom: 18
	});
	/*var roadsMutant = L.gridLayer.googleMutant({
		type: 'roadmap'
	});
	var terrainMutant = L.gridLayer.googleMutant({
		maxZoom: 24,
		type:'terrain'
	});

	var hybridMutant = L.gridLayer.googleMutant({
		maxZoom: 24,
		type:'hybrid'
	});*/
	var Esri_DeLorme = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Specialty/DeLorme_World_Base_Map/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Copyright: &copy;2012 DeLorme',
		minZoom: 1,
		maxZoom: 11
	});
	var Stamen = L.tileLayer('//stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}.png', {
		attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
		subdomains: 'abcd',
		maxZoom: 20,
		minZoom: 0,
		label: 'Toner Lite'
	});
	var Wa_Pengakuan = L.featureGroup([new L.GeoJSON.AJAX("data/brwa/wa?time="+new Date().getTime(), 
		{
		minZoom: 7,
		style: style4line,
		onEachFeature: onEachFeature,
		pointToLayer: function (feature, latlng) {
			return L.circleMarker(latlng, style);
		}
	})]);

	var bigwms = L.tileLayer.wms('http://palapa.big.go.id:8080/geoserver/gwc/service/wms', {
		layers: 'basemap_rbi:basemap', VERSION: '1.1.1'
	});
	var baseLayers = {
	  "BIG: RBI": bigwms,
	  //"PETA 1": Kodam,
	  "PETA 2": cloudmade,	
	  //"Google Road": roadsMutant,
	  //"Google Terrain": terrainMutant,
	  //"Google Hybrid": hybridMutant,
	  "PETA 3": Esri_DeLorme,
	  "PETA 4": Stamen,
	};	
	var overlayMaps = {
		"Peta Pengakuan Wil Adat": Wa_Pengakuan,	
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
	var longitude,latitude;
	var isnew;
	
	//var defaultMarker = new LeafIcon({iconUrl: 'assets/images/map/korem.gif'});
	if (!defaultMarker) {
		var defaultMarker = L.AwesomeMarkers.icon({
			prefix:'fa',
			icon: 'circle',
			markerColor: 'blue'
		});
	}
	var changedMarker = L.AwesomeMarkers.icon({
		prefix:'fa',
		icon: 'circle',
		markerColor: 'orange'
	});
	
	function loadMap(){
		if(map==null){
			map = L.map('map').setView([1, 114],4);
			
			map.addLayer(cloudmade);
			map.addLayer(Wa_Pengakuan);
			L.control.layers(baseLayers,overlayMaps).addTo(map);
			
			Wa_Pengakuan.on('add', function () {
				 Wa_Pengakuan.bringToBack();
			});
			
			/* add search control */
			new L.Control.GeoSearch({
					provider: new L.GeoSearch.Provider.OpenStreetMap({
						bounds: { north: 6, east: 145, south: -11, west: 92 }	
					}),
					showMarker: false
			}).addTo(map);
			
		}	
		
		var loc=map.getCenter();
		
		var validLon=$("#x").val()>95?true:false;
		var zoom=4;
		longitude=$("#x").val()||loc.lng;
		latitude=$("#y").val()||loc.lat;
		if(validLon){
			zoom=10;
		}
		if (!mark_location && validLon) {
			mark_location = L.marker([latitude,longitude],{icon:defaultMarker}).bindPopup(longitude+", "+latitude).addTo(map);;//.bindTooltip(defaultLabelMarker||'x', { permanent: true,direction: defaultLabelPosition||'bottom',offset:defaultlabelOffset||[0,0] }).bindPopup("Data").addTo(map);//.bindPopup("Data").addTo(map);
			map.setView([latitude, longitude], zoom);
		}
	
	}
	function style(feature) {
		return {
			fillColor: feature.properties.warna_sektor,
			radius: map.getZoom()-2,//getSize(feature.properties.tipe),
			weight: .5,
			opacity: 1,
			color: '#777',
			fillOpacity: 0.7
		};
	}
	function style4line(feature) {
		return {
			fillColor: 'blue',//getColor(feature.properties.value),
			radius:5,//getSize(feature.properties.value),
			weight: 1,
			opacity: 1,
			color: '#777',//'#ff851b',
			//dashArray: '2 4',
			fillOpacity: 0.2
		};
	}
	function zoomToFeature(e) {
		map.fitBounds(e.target.getBounds());
	}
	function onEachFeature(feature, layer) {

		layer.bindPopup(feature.properties.nama_kewilayahan);
		layer.bindTooltip("<strong>WILAYAH ADAT</strong><BR>"+feature.properties.nama_kewilayahan||'',{permanent: false});
		layer.on({
			//mouseover: highlightFeature,
			//mouseout: resetHighlight,
			click: zoomToFeature
		});
	}
	
	$(function(){
		$("#mapx").remove();
		$("#map_picker").html("<div id='mapx' style='width:100%;height:100%'></div>");
		lon=$("#x").val();
		lat=$("#y").val();

		loadMap();	
		
		map.on('click', function(e) {
			var latitude=e.latlng.lat;
			var longitude=e.latlng.lng;
			
			$("#x").val(e.latlng.lng);
			$("#y").val(e.latlng.lat);
			if (!mark_location) {
				mark_location = L.marker([latitude,longitude]).bindPopup("Data").addTo(map);
				isnew=true;
			}else{
				mark_location.setOpacity(0.5);
				if (!mark_location_new) {
					mark_location_new = L.marker([latitude,longitude],{icon:changedMarker}).bindPopup("Data").addTo(map);
				}
				mark_location_new.setLatLng([latitude,longitude]).update();
				if (!isnew) {
					mark_location_new.setOpacity(1);
					$("#marker-reset").removeClass("hidden");
				}
			}
		});
		$("#marker-reset").click(function(e){
			$("#x").val(longitude);
			$("#y").val(latitude);
			mark_location.setOpacity(1);
			mark_location_new.setOpacity(0);
			map.setView([latitude, longitude]);
			$("#marker-reset").addClass("hidden");
			e.preventDefault();
		});
	});
	
	function search_location(q){
		var limit=10;
		$.getJSON("http://nominatim.openstreetmap.org/search?format=json&limit="+limit+"&q="+q+"&countrycodes=id",function(data){
			alert(JSON.stringify(data));latitude=data[0].lat;
			longitude=data[0].lon;
			map.setView([latitude, longitude], 6);
		});	
	}
	
	
	function addMarker(e){
		// Add marker to map at click location; add popup window
		var newMarker = new L.marker(e.latlng).addTo(map);
	}
</script>