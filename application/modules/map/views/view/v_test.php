<script src="https://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
<script src="assets/js/ol2/OpenLayers.js"></script>
<script>
	var gproj = new OpenLayers.Projection("EPSG:3857");
  	var proj = new OpenLayers.Projection("EPSG:4326");
    var map;
	
	var selectedFeature = false;
	var ctheme = 'spp';
	var themes = {
		"pddk": {
			themeTitle: "Peta Kota",
			json_url: "form/gis/penduduk_get/point",
			json_url_2: "form/gis/penduduk_get/poly",
			legend:{
				range	: [500000, 300000, 100000],
				size	: [7, 5, 3],
				text	: ['Besar', 'Menengah', 'Kecil'],
				color	: ["#BD0026", "#FC4E2A", "#FEB24C"],
				title	: "Kota"
			}
		}
		,"spp": {
			themeTitle: "SPP Kota",
			json_url: "form/gis/spp_get",
			json_url_2: "form/gis/spp_get/poly",
			legend:{
				range	: [100, 30, 10, 8, 4, 2, 1, 0],
				size	: [30, 20, 15, 10, 8, 5, 3, 2],
				text	: ['100+', '30 - 100', '10 - 30', '8 - 10', '4 - 8', '2 - 4', '1 - 2', '0'],
				color	: ["#2b8786", "#00a14b", "#a2bc3e", "#ffde17", "#faa222", "#f26522", "#f04e37", "#ed1c24"],
				title	: "SPP Kota (%)"
			}
		}
		
	};
	var theme = themes[ctheme];
    function init() {
        map = new OpenLayers.Map({
        div: "map",
        projection: "EPSG:3857",
        displayProjection:"EPSG:4326",
        //paddingForPopups: new OpenLayers.Bounds(450,00,30,50),
        controls: []
    });
    //var scale_holder = document.getElementById("map_attribute");
    scaleline = new OpenLayers.Control.ScaleLine({'maxWidth':200,'geodesic':true});
    attribution = new OpenLayers.Control.Attribution();
    map.addControl(scaleline);
    map.addControl(new OpenLayers.Control.KeyboardDefaults());
    map.addControl(new OpenLayers.Control.Navigation());
    map.addControl(attribution);
    
    map.addControl(new OpenLayers.Control.LayerSwitcher({'position': new OpenLayers.Pixel(10,230)}));
    //map.addControl(new OpenLayers.Control.Scale());
    map.addControl(new OpenLayers.Control.MousePosition());
    
    layer_wi = new OpenLayers.Layer.XYZ(
        "XYZ Lingkar",
        [
            "http://a.tile.openstreetmap.org/${z}/${x}/${y}.png",
            "http://b.tile.openstreetmap.org/${z}/${x}/${y}.png",
            "http://c.tile.openstreetmap.org/${z}/${x}/${y}.png"
        ]
    );		
    layer_wi.id = 'lokal';
    map.addLayer(layer_wi);
    
    
    
    ovControl = new OpenLayers.Control.OverviewMap({maximized:true,autoPan:true,size: new OpenLayers.Size(180,110)});
    ovControl.isSuitableOverview = function() {
        return false;
    };
    map.addControl(ovControl);
    
    
    //changeBaseMap('gmap');	
    
    //if (ext) ext = new OpenLayers.Bounds(ext.split(","));
    //(itheme)?triggerTheme():loadThemes();
    
    var osm = new OpenLayers.Layer.OSM();
        var gmap = new OpenLayers.Layer.Google("Google Streets", {visibility: false});
    
        // note that first layer must be visible
        map.addLayers([osm, gmap]);
        var id_bounds = new OpenLayers.Bounds(94,-8,141,6);
		map.zoomToExtent(id_bounds.transform(proj, map.getProjectionObject()));
    
    //var id_bounds = new OpenLayers.Bounds(94,-8,141,6);
    //map.zoomToExtent(id_bounds.transform(proj, map.getProjectionObject()));
        /*
        map = new OpenLayers.Map({
            div: "map",
            allOverlays: true
        });
    
        var osm = new OpenLayers.Layer.OSM();
        var gmap = new OpenLayers.Layer.Google("Google Streets", {visibility: false});
    
        // note that first layer must be visible
        map.addLayers([osm, gmap]);
    
        map.addControl(new OpenLayers.Control.LayerSwitcher());
        map.zoomToMaxExtent();*/
    	legendTheme();
		getData();
    }
	function legendTheme() {
		var text = theme.legend['text'];
		var colors = theme.legend['color'];
		var num = Math.min(colors.length,text.length);
		
		document.getElementById("map_legend_title").innerHTML=theme.legend.title;
		var ldiv = document.getElementById("map_legend");
		for(var i=0;i<num;i++) {
			var dataLegend = document.createElement("i");
			var dataLabel = document.createTextNode(text[i]);
			var dataSpace = document.createElement("br");
			dataLegend.setAttribute('style', 'background:'+colors[i]);
			ldiv.appendChild(dataLegend);
			ldiv.appendChild(dataLabel);
			ldiv.appendChild(dataSpace);
		}
	}
	<!--end: legend-->
	
	function getData(j,k,s,q) {
		if (selectedFeature!=false) onFeatureUnselect(selectedFeature);
		var j = j?j:0;
		var k = k?k:0;
		var s = s?s:0;
		var q = q?q:0;
		
		/*$("#data-list").load('admin/rumkit/list_rs?jenis='+j+'&kelas='+k+'&rsp='+s+'&q='+q,function(){
			dataShow();
			$("li.media-wa").click(function(){
				var lonlat = new OpenLayers.LonLat($(this).data('lon'),$(this).data('lat'));
				listClick($(this).data('idx'),'over',lonlat.transform(proj, map.getProjectionObject()));
			});
		});
		$("#data-stats").load('admin/dashboard/gis',function(){
			
		});*/
		//alert('/brwa_services/gis/gis/data_'+mod_base+'_point/'+prop+'/'+s+f+q);
		//dataShow();
		var style1 = new OpenLayers.Style({
			pointRadius: "${getSize}",
			fillColor: "${getColor}",
			strokeColor: "#FFF",
			fillOpacity: 0.6,
			strokeWidth: "${stroke}",
			strokeOpacity: 1,
			label: "${getLabel}",
			fontColor:"#FFF",
			fontSize:"${getSize}"
			//graphicName:"triangle"
		}, {
			context: {
				getColor: function(feature) {
					var c = theme.legend['color'];
					var r = theme.legend['range'];
					var d = parseInt((feature.attributes.value));
					d = d > r[0] ? 0 : d > r[1] ?1 : d > r[2] ? 2 : d > r[3]  ? 3 : d > r[4]   ? 4 : d > r[5]   ? 5 : d >= r[6]   ? 6 : 7;
					return c[d]||"#aaa";
				},
				getSize: function(feature) {
					var s = theme.legend['size'];
					var r = theme.legend['range'];
					var d = parseInt((feature.attributes.value));
					d = d > r[0] ? 0 : d > r[1] ?1 : d > r[2] ? 2 : d > r[3]  ? 3 : d > r[4]   ? 4 : d > r[5]   ? 5 : d >= r[6]   ? 6 : 7;
					return s[d];
				},
				getLabel: function(feature) {
					return feature.attributes.label?feature.attributes.label:'';
				}
			}
		});
		
		var render=["SVG","VML"];	
		
		if (map.getLayer("clayer")) {
			clayer.destroyFeatures();
			map.removeLayer(clayer);
		}
		clayer = new OpenLayers.Layer.Vector('CLUSTER', {
			minScale: 900001,
			//maxScale: 867001,
			styleMap: new OpenLayers.StyleMap({
				"default": style1,
				"select": {
					strokeOpacity:1
				},
				"temporary": {
					strokeOpacity:1
				}
			})
		,	renderers: render
		,	rendererOptions: {zIndexing: true}
		,	strategies: [new OpenLayers.Strategy.Fixed()]
		,	protocol: new OpenLayers.Protocol.HTTP({
				url: theme['json_url_2'],
				params:{},
				format: new OpenLayers.Format.GeoJSON({
					ignoreExtraDims: true,
					keepData: true,
					internalProjection: gproj,
					externalProjection: proj
				})
			})
		/*,	eventListeners: {
				"featuresadded": Zoomer//feature_out
			}*/
		});
		clayer.id="clayer";
		map.addLayer(clayer);
		clayer.refresh();
		
		//POINT
		
		
		if (map.getLayer("player")) {
			player.destroyFeatures();
			map.removeLayer(player);
		}
		player = new OpenLayers.Layer.Vector('POINT KOTA', {
			maxScale: 900001,
			styleMap: new OpenLayers.StyleMap({
				"default": style1,
				"select": {
					strokeOpacity:1
				},
				"temporary": {
					strokeOpacity:1
				}
			})
		,	renderers: render
		,	rendererOptions: {zIndexing: true}
		,	strategies: [new OpenLayers.Strategy.Fixed()]
		,	protocol: new OpenLayers.Protocol.HTTP({
				url: theme['json_url'],
				params:{},
				format: new OpenLayers.Format.GeoJSON({
					ignoreExtraDims: true,
					keepData: true,
					internalProjection: gproj,
					externalProjection: proj
				})
			})
		/*,	eventListeners: {
				"featuresadded": Zoomer//feature_out
			}*/
		});
		player.id="player";
		map.addLayer(player);
		player.refresh();
		
		
		
		/*highlightCtrl = new OpenLayers.Control.SelectFeature([clayer], {
				multiple:true, hover: true, highlightOnly: true, renderIntent: "temporary"
		});
		
		popCtrl = new OpenLayers.Control.SelectFeature([clayer], {
				multiple:true, hover: true, highlightOnly: false, renderIntent: "temporary", callbacks:{
				'over':feature_hover, 'out':feature_out
			}
		});
		
		selectCtrl = new OpenLayers.Control.SelectFeature([clayer], {
			onSelect: onFeatureSelect, onUnselect: onFeatureUnselect
		});*/
		/*selectCtrl2 = new OpenLayers.Control.SelectFeature(polylayer, {
			onSelect: feature_hover_pc, onUnselect: feature_out
		});*/
				
		//map.addControl(selectCtrl2);
		//map.addControls([highlightCtrl,selectCtrl,popCtrl/*,selectCtrl2*/]);
//		highlightCtrl.activate();
//		popCtrl.activate();
//		selectCtrl.activate();

	}
	function Zoomer(layer) {
		var layer = layer?layer:clayer;
		var bbox = clayer.getDataExtent();
		
		map.zoomToExtent(bbox,0);
		if (bbox.left) {
			var ll = new OpenLayers.LonLat(bbox.left,bbox.bottom);
			var cp = map.getPixelFromLonLat(ll);
			var dif = 0;
			if (cp.x<400)  dif = 430-cp.x;
			map.pan(-dif,-20,{animate:false});
		}
	}
</script>
<div id="map" style="position:relative; border:0px solid red; height:100vh">
  <div id="map_legend"><div id="map_legend_title" style="margin-bottom:5px; border-bottom:1px solid #ccc; padding:2px">Legend</div></div>
</div>

<style>
.bg-pv {
	background-color:#dff0d8!important
}
a.save {
	display: none;
	width: 60px;
	height: 60px;
	position: fixed;
	z-index: 999;
	right:120px;
	bottom: 20px;
	background: #27AE61;
	-webkit-border-radius: 30px;
	-moz-border-radius: 30px;
	border-radius: 30px;
	color:#fff;
	text-align:center;
	line-height:70px
}
a:hover.save {
	background-color: #063;
}

.olControlOverviewMapContainer {
    position: absolute;
    top: 60px;
    right: 10px;
	height: 124px;
	z-index:1;
}
.olControlOverviewMapElement {
	margin-top:0px;
    padding: 1px/* 0 8px 8px*/;
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

.floating-button a {
	color:#555;
	outline:none;
}
.floating-button a:hover,.floating-button a.active {
	color:#333;
}
.floating-button i.fa-stack-1x {
	font-size:.9em
}
.floating-button i.fa-stack-1x:hover {
	font-size:1.2em
}
#map_legend {
    position: absolute;
    left: 20px;
    bottom: 60px;
    z-index: 900;
	background:#fff;
	opacity:0.7;
	max-width:380px;
}
#map_legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.9;
	border-radius:50%;
	border:2px solid #fff
}
#map_legend {
	font-size:.95em;
    background: none repeat scroll 0% 0% rgba(255, 255, 255, 0.8);
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
    /*border-radius: 5px;*/
    line-height: 18px;
    color: #555;
    padding: 8px;
}
.nav-tabs > li > a {
    background-color: rgba(100,100,100,0.1);
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
    background-color: #f5f5f5;
}
.nav i {
	font-size:16px;
	line-height:20px;
}
#top-layouts .nav-pills > li + li {
    margin-left: 0px;
	border-collapse:collapse;
}
#top-layouts .nav-pills > li > a {
	color:#eee;
	border-radius:0!important;
}
#top-layouts .nav-pills > li > a:hover,#top-layouts .nav-pills > li > a:focus {
	background:#555;
}
.nav a {
	font-size: 14px;
	font-weight: 400;
	color:#fff;
}
.nav a:focus {
    outline: none;
}
.nav-tabs {
    border-bottom: 0px solid #DDD;
}
.panel-group {
    margin-bottom: 0px;
}
.panel-bodyx {
    padding: 10px;
}
.panel-group .panel {
    border-radius: 0px!important;
	border:none;
	box-shadow:none;
	/*box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.2);*/
}
.panel-group .panel + .panel {
    margin-top: 0px;
	border-top:1px solid #ddd;
}
.panel-heading {
    padding: 5px 17px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 0px!important;
    border-top-right-radius: 0px!important;
}
#search_key {
	background:transparent; padding:2px; border:1px solid transparent; width:100%
}
#search_key:focus {
	border-bottom-color:#ccc!important;
	box-shadow:none
}
/*detil*/
#detil-container{
	position:relative;
	background:#fff;
	margin-top:5px;
	box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.2);
}
#data-detil{
	background:#fff;
	max-height:350px;
	overflow: auto;
}
#data-detil-stats{
	background:#fff;
	border-top:1px solid #ccc;
	margin-top:0px;
	padding: 10px 15px;
}
#data-container{
	position:relative;
	background:#fff;
	margin-top:5px;
	box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.2);
}
#data-list{
	background:#fff;
	max-height:350px;
	overflow: auto;
}
#data-list-small{
	position:relative;
	z-index:900;
	background:#fff;
	display:none;
	margin-top:-5px;
	padding: 10px 15px 3px;
	cursor:pointer;
}
#data-stats{
	background:#fff;
	border-top:1px solid #ccc;
	margin-top:0px;
	padding: 10px 25px 10px 15px;
	font-size:.9em;
}
#select_map {
    min-width: inherit !important;
    padding: 0px;
    margin: 2px 2px 2px 0;
}
</style>
<script>init()</script>
