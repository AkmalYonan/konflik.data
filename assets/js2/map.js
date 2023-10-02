var ext,map,gmap,getClick;
var size, icon, currentPopup,popupid,popupdata; 
var w_status=0;
var c_status=0;
var selectControl, selectedFeature,layer_prop_id,layer_kab_id,layer_kec_id;
var layersLoading = 0;
var max_bounds = new OpenLayers.Bounds(94, -11, 141, 8);
var min_bounds = new OpenLayers.Bounds(94, -11, 141, 8);
var gproj = new OpenLayers.Projection("EPSG:900913");
var proj = new OpenLayers.Projection("EPSG:4326");

var stylePrasarana=new OpenLayers.StyleMap(
{
	"default": {
		cursor: "pointer",
		externalGraphic: "${extimage}",
		graphicWidth: "${gW}",
		graphicHeight: "${gH}",
		graphicXOffset: "${xOffset}",
		graphicYOffset: "${yOffset}",
		/*backgroundGraphic:"public/images/map_icon/marker_shadow.png",*/
		backgroundXOffset: 0,
		backgroundYOffset: -7,
		backgroundGraphicZIndex:0,
		graphicZIndex: 1
	}
	,"select": {
		cursor: "pointer",
		graphicZIndex: 2
	}
	,"temporary": {
		cursor: "pointer",
		label: "${label_hover}"
	}

});
//POLYGON
var stylePoly=new OpenLayers.StyleMap(
{
	"default": {
		cursor: "pointer",
		fillColor:"${color}",
		strokeColor:"#ffffff",
		strokeWidth:0.5,
		fillOpacity: 0.6,
		//label:"${kode_wilayah}",
		labelAlign: "cc",
		fontColor: "${strokecolor}",
		fontFamily: "Arial",
		fontSize: 11,
		labelOutlineColor: "${color}",
		labelOutlineWidth: 3,
		labelSelect:true
	}
	,"select": {
		cursor: "pointer",
		fillOpacity: 0.8
	}
	,"temporary": {
		cursor: "pointer",
		label: "${label_hover}",
		fillColor:"${hlcolor}"
	}

});
	
var styleCircle=new OpenLayers.StyleMap(
{
	"default": {
		cursor: "pointer",
		fillColor:"${color}",
		strokeColor:"#ffffff",
		strokeWidth:1,
		fillOpacity: 0.75,
		pointRadius:"${radius}",
		labelAlign: "cc",
		fontColor: "${strokecolor}",
		fontFamily: "Arial",
		fontSize: 11,
		labelOutlineColor: "${color}",
		labelOutlineWidth: 3,
		labelSelect:true
	}
	,"select": {
		cursor: "pointer",
		fillOpacity: 0.8
	}
	,"temporary": {
		cursor: "pointer",
		label: "${label_hover}",
		fillColor:"${hlcolor}"
	}

});	
function init() {
	map = new OpenLayers.Map({
		div: "maped",
		projection: "EPSG:900913",
		displayProjection:"EPSG:4326",
		paddingForPopups: new OpenLayers.Bounds(40,60,40,60),
		controls:[]
	});
	attribution = new OpenLayers.Control.Attribution();
	map.addControl(new OpenLayers.Control.Navigation({zoomWheelEnabled: false,dragPanOptions: {enableKinetic: true}}));
	map.addControl(new OpenLayers.Control.Zoom({
            zoomInId: "customZoomIn",
            zoomOutId: "customZoomOut"
        }))
	/*scaleline = new OpenLayers.Control.ScaleLine({'maxWidth':140});
	attribution = new OpenLayers.Control.Attribution();
	map.addControl(scaleline);
	map.addControl(new OpenLayers.Control.KeyboardDefaults());
	map.addControl(new OpenLayers.Control.Navigation({dragPanOptions: {enableKinetic: true}}));
	map.addControl(attribution);
	map.addControl(new OpenLayers.Control.Scale());
	map.addControl(new OpenLayers.Control.MousePosition());*/
	//map.addControl(new OpenLayers.Control.LayerSwitcher({'ascending':false,'position': new OpenLayers.Pixel(10,30)}));
	
	map.events.register('preaddlayer', map, function(evt) { 
	 if (evt.layer) { 
			 evt.layer.events.register('loadstart', this, function() { 
				 layersLoading++; 
				 if (layersLoading > 0) { 
					 $('.loader').show(); 
					// $('#throbber').show(); 
				 } 
			 }); 
			 evt.layer.events.register('loadend', this, function() { 
				 if (layersLoading > 0) { 
					 layersLoading--; 
				 } 
				 if (layersLoading == 0) { 
					 $('.loader').hide(); 
				 } 
			 }); 
		 } 
	 });
	
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
	
	ovControl = new OpenLayers.Control.OverviewMap({minRatio: 7, maxRatio: 8,maximized:false,autoPan:true,size: new OpenLayers.Size(153,120)});
	ovControl.isSuitableOverview = function() {
		return false;
	};
	
		
	flag_marker=false;
	scaleline = new OpenLayers.Control.ScaleLine({
		div: document.getElementById("scaleline-id")
	});
	map.addControl(scaleline);
	
	if (ext) ext = new OpenLayers.Bounds(ext.split(","));
	
	var id_bounds = new OpenLayers.Bounds(94,-8,141,6);
	map.zoomToExtent(id_bounds.transform(proj, map.getProjectionObject()));
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
			
	} else if (base=='local') {
		map.setBaseLayer(layer_wi);
		//layer_anno.setVisibility(true);
	}
	else {
		//map.setBaseLayer(layer_bako_service);
			//if (map.getLayer("g_hybrid")) map.removeLayer(ghyb);
			//if (map.getLayer("g_street")) map.removeLayer(gmap);
	}	
	mapbg=base;
}