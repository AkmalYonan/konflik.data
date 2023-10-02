
<script type="text/javascript" src="assets/js2/OL212/OpenLayers.js"></script>
<script type="text/javascript">
	//var id_wa=<?=($id)?$id:0?>;
	var map;
	var gproj = new OpenLayers.Projection("EPSG:900913");
  	var proj = new OpenLayers.Projection("EPSG:4326");
	var size, icon; 
	var vector, formats;
	var in_options,out_options;
	<?
		if ($data['pos_x'] && $data['pos_y']) {
		?>
		var point_coord = new OpenLayers.LonLat(<?=$data['pos_x']?>,<?=$data['pos_y']?>);
		<?
		}
	?>
	OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {                
		defaultHandlerOptions: {
			'single': true,
			'double': false,
			'pixelTolerance': 0,
			'stopSingle': false,
			'stopDouble': false
		}
	});
	
	function init(){
		map = new OpenLayers.Map({
			div: "map",
			projection: "EPSG:900913",
			displayProjection:"EPSG:4326",
			controls:[]
		});
	
		layer_wi = new OpenLayers.Layer.XYZ(
			"XYZ Lingkar",
			[
				"http://a.tile.openstreetmap.org/${z}/${x}/${y}.png",
				"http://b.tile.openstreetmap.org/${z}/${x}/${y}.png",
				"http://c.tile.openstreetmap.org/${z}/${x}/${y}.png"
			], {
				buffer: 2,
				numZoomLevels: 16,
				wrapDateLine:true,
				transitionEffect: 'resize'
			}
		);		
		layer_wi.id = 'lokal';
		map.addLayer(layer_wi);
		
		ovControl = new OpenLayers.Control.OverviewMap({maximized:true,autoPan:true,size: new OpenLayers.Size(180,110)});
		map.addControl(ovControl);
		map.addControl(new OpenLayers.Control.Zoom());
		nav = new OpenLayers.Control.Navigation({'zoomWheelEnabled': false});
		map.addControl(nav);
		//map.addControl(new OpenLayers.Control.LayerSwitcher());
		// map.setCenter(new OpenLayers.LonLat(0, 0), 0);
		map.zoomToMaxExtent();
		
		var click = new OpenLayers.Control.Click();
		map.addControl(click);
		click.activate();
		
		vectors = new OpenLayers.Layer.Vector("Vector Layer");
        map.addLayer(vectors);
		
		//changeBaseMap('gphy');
		var id_bounds = new OpenLayers.Bounds(94,-8,141,6);
		
		//map.zoomToExtent(id_bounds.transform(proj, map.getProjectionObject()));
		//loadWA();
		
		in_options = {
			'internalProjection': map.baseLayer.projection,
			'externalProjection': new OpenLayers.Projection('EPSG:4326')
		};   
		out_options = {
			'internalProjection': map.baseLayer.projection,
			'externalProjection': new OpenLayers.Projection('EPSG:4326')
		};
		formats = {
		  'in': {
			wkt: new OpenLayers.Format.WKT(in_options),
			geojson: new OpenLayers.Format.GeoJSON(in_options)
		  },
		  'out': {
			wkt: new OpenLayers.Format.WKT(out_options),
			geojson: new OpenLayers.Format.GeoJSON(out_options)
		  }
		};
	}
	
	function serialize(feature) {
		var type = document.getElementById("formatType").value;
		// second argument for pretty printing (geojson only)
		var pretty = document.getElementById("prettyPrint").checked;
		var str = formats['out'][type].write(feature, pretty);
		// not a good idea in general, just for this demo
		str = str.replace(/,/g, ', ');
		document.getElementById('output').value = str;
	}

	function deserialize(d) {
		var element = document.getElementById('text');
		var type = "geojson";//document.getElementById("formatType").value;
		var features = formats['in'][type].read(element.value);
		var bounds;
		if(features) {
			if(features.constructor != Array) {
				features = [features];
			}
			for(var i=0; i<features.length; ++i) {
				if (!bounds) {
					bounds = features[i].geometry.getBounds();
				} else {
					bounds.extend(features[i].geometry.getBounds());
				}

			}
			vectors.addFeatures(features);
			map.zoomToExtent(bounds);
			var plural = (features.length > 1) ? 's' : '';
			element.value = features.length + ' feature' + plural + ' added';
		} else {
			element.value = 'Bad input ' + type;
		}
	}
	function Zoomer(layer) {
		var bbox = layer.getDataExtent();
		
		map.zoomToExtent(bbox,0);
		if (map.getZoom()>12) {
			map.zoomTo(11);
		}
	}
	function changeBaseMap(base) {
		if (base=='gmap') {
				try {
					if (!map.getLayer("g_street")) {
						gmap = new OpenLayers.Layer.Google("Google Streets", {numZoomLevels: 20});
						gmap.id = "g_street";
						map.addLayer(gmap);
					}
					map.setBaseLayer(gmap);
					//layer_anno.setVisibility(false);
					
				} catch (e) {
					alert("Can't load GoogleMap");
				}
		} else if (base=='ghyb') {
				try {
					if (!map.getLayer("g_hybrid")) {
						ghyb = new OpenLayers.Layer.Google("Google Hybrid", {type: google.maps.MapTypeId.HYBRID, numZoomLevels: 20});
						ghyb.id = "g_hybrid";
						map.addLayer(ghyb);
					}
					map.setBaseLayer(ghyb);
					//layer_anno.setVisibility(false);
				} catch (e) {
					alert("Can't load Google Hybrid");
				}
				
		} 
		else if (base=='gphy') {
			try {
				if (!map.getLayer("g_physical")) {
					gphy = new OpenLayers.Layer.Google("Google Physical", {type: google.maps.MapTypeId.TERRAIN, numZoomLevels: 20});
					gphy.id = "g_physical";
					map.addLayer(gphy);
				}
				map.setBaseLayer(gphy);
				//layer_anno.setVisibility(false);
			} catch (e) {
				alert("Can't load Google Physical");
			}
		}
		else if (base=='lokal') {
			map.setBaseLayer(layer_wi);
			//layer_anno.setVisibility(true);
		}
		else {
			map.setBaseLayer(layer_bako_service);
				//if (map.getLayer("g_hybrid")) map.removeLayer(ghyb);
				//if (map.getLayer("g_street")) map.removeLayer(gmap);
		}	
	}
	
	
	var flag_marker=false;
	var icon_marker = 'map-point2.png';
	var icon_w = 29;
	var icon_h = 44;
	var cmarker=null;
	function displayMarker() {
		point_coord.transform(proj, map.getProjectionObject());
		map.moveTo(point_coord,7);
		var size = new OpenLayers.Size(icon_w,icon_h);
		var offset=new OpenLayers.Pixel(-size.w/2,-size.h);
		
		var iconDefault = new OpenLayers.Icon("assets/image/"+icon_marker,size,offset);
		cmarker=new OpenLayers.Marker(point_coord,iconDefault);
		markers.addMarker(cmarker);
	}
	function mapEvent(e) {
		var evt = e.type;
		var ext = map.getExtent();
		var zoom = map.zoom;
		
		if (evt=='click') {
			var point_click = map.getLonLatFromViewPortPx(e.xy);
			var point_new = new OpenLayers.LonLat(point_click.lon,point_click.lat);
			setCoord(point_click,point_new);
		}
	}
	function setCoord(point_click,point_new) {
		if (!flag_marker) {
			var size = new OpenLayers.Size(icon_w,icon_h);
			var offset=new OpenLayers.Pixel(-size.w/2,-size.h);
			
			var iconDefault = new OpenLayers.Icon("assets/image/"+icon_marker,size,offset);
			marker=new OpenLayers.Marker(point_click,iconDefault);
			markers.addMarker(marker);
			flag_marker=true;
		}
		else {
			var point_new_pos=map.getLayerPxFromLonLat(point_new);
			if(marker.map==null){
				markers.addMarker(marker);	
			}
			marker.moveTo(point_new_pos);
		}
		if (cmarker) cmarker.setOpacity(0.5);
		
		point_click.transform(map.getProjectionObject(),proj);
		$("#koordinat_bujur").val(Math.round(point_click.lat * 1000000.)/1000000);
		$("#koordinat_lintang").val(Math.round(point_click.lon * 1000000.)/1000000);
		$("#koordinat_div").html(point_click.lon+','+point_click.lat);
		//$("#new_koord").html("(New)");
		//displayCoordinate(lonlat);
	}
</script>
<style>
.smallmap {
    width: 100%;
    height: 360px;
}
.olControlOverviewMapContainer {
    position: absolute;
    top: 20px;
    right: 10px;
	height: 124px;
	z-index:1;
}
div.olControlZoom {
    position: absolute;
    top: 20px;
    left: 30px;
    background: rgba(255,255,255,0.3);
    border-radius: 4px;
    padding: 1px;
}
div.olControlZoom a {
	background: #ccc; /* fallback for IE - IE6 requires background shorthand*/
    background: rgba(120,120,120, 0.5);
}
div.olControlZoom a:hover {
	background: #aaa; /* fallback for IE - IE6 requires background shorthand*/
    background: rgba(60,60,60, 0.5);
}
.olControlOverviewMapElement {
	margin-top:0px;
    padding: 4px/* 0 8px 8px*/;
    background-color: #fff;
	z-index:1
}
.olControlOverviewMapMinimizeButton {
    left: -2px;
    bottom: 14px;
    cursor: pointer;
}    
.olControlOverviewMapMaximizeButton {
    right: 2px;
    top: 2px;
    cursor: pointer;
}
.olControlOverviewMapExtentRectangle {
    overflow: hidden;
    background-image: url("img/blank.gif");
    cursor: move;
    border: 1px solid red;
}
</style>
<div id="map" class="smallmap"></div>
<input id="zoomscroll" type="checkbox" class="hidden">
<span class="help-block" style="display:inline"><?=$tooltip['11_a']?></span>
<span class="help-block" style="display:inline; float:right; margin:0; cursor:pointer" id="zoommouse"><i class="fa fa-square"></i> Perbesaran dengan <em>Mousescroll</em></span>
<script>
var pekerjaan_change = <?=$pekerjaan_select['value']?'true':'false'?>;
$(document).ready(function () {
	//init();
   $("#zoommouse").on("click",function(){
   		 $("#zoomscroll").trigger("click");
   });
   $("#zoomscroll").on("click",function(){
   		if ($(this).is(":checked")) {
			$("#zoommouse").find("i").removeClass("fa-square").addClass("fa-check-square");
			nav.enableZoomWheel();
		}
		else {
			$("#zoommouse").find("i").removeClass("fa-check-square").addClass("fa-square");
			nav.disableZoomWheel();
		}
   });
   
});
</script>
