<?php 
if ($_POST['uo'] || $_POST['sort'] || $_POST['q']) {
	$class_toggle=" active";
	$class_content="";
}
else {
	$class_toggle="";
	$class_content="none";
}
?>
<!--MAP-->
<script src="https://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
<script src="assets/js/OL212/OpenLayers.js"></script>
<script>
	var map;
	var ext = false;
	var itheme = false;
	var themeObj = null;
	var themeObjCallback = false;
	var selectedFeature = false;
	var selectedData = false;
	var listLayers = [];
	var layersLoading = 0;
	var popupTooltip = popup = false;
	var size = [60, 45, 35, 30, 25, 20, 12, 7];
	var range = [100, 30, 10, 8, 4, 2, 1, 0];
	var text = ['100+', '30 - 100', '10 - 30', '8 - 10', '4 - 8', '2 - 4', '1 - 2', '0'];
	var colors = ["#800026", "#BD0026", "#E31A1C", "#FC4E2A", "#FD8D3C", "#FEB24C", "#FFD976", "#FFF"];
	var selectCtrl;
	
	var ctheme = 'default';
	var mapbg = false;
	var param = '';
	var gproj = new OpenLayers.Projection("EPSG:900913");
  	var proj = new OpenLayers.Projection("EPSG:4326");
	var themes;
	OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {                
		defaultHandlerOptions: {
			'single': true,
			'double': false,
			'pixelTolerance': 0,
			'stopSingle': false,
			'stopDouble': false
		},
	
		initialize: function(options) {
			this.handlerOptions = OpenLayers.Util.extend(
				{}, this.defaultHandlerOptions
			);
			OpenLayers.Control.prototype.initialize.apply(
				this, arguments
			); 
			this.handler = new OpenLayers.Handler.Click(
				this, {
					'click': this.trigger
				}, this.handlerOptions
			);
		}, 
	
		trigger: function(e) {
			mapEvent(e);
		}
	
	});
	function init() {
		map = new OpenLayers.Map({
			div: "map",
			projection: "EPSG:900913",
			displayProjection:"EPSG:4326",
			paddingForPopups: new OpenLayers.Bounds(450,00,30,50),
			controls:[]
		});
		//var scale_holder = document.getElementById("map_attribute");
		scaleline = new OpenLayers.Control.ScaleLine({'maxWidth':200,'geodesic':true});
		attribution = new OpenLayers.Control.Attribution();
		map.addControl(scaleline);
		map.addControl(new OpenLayers.Control.KeyboardDefaults());
		map.addControl(new OpenLayers.Control.Navigation({dragPanOptions: {enableKinetic: true}}));
		map.addControl(attribution);
		
		//map.addControl(new OpenLayers.Control.LayerSwitcher({'position': new OpenLayers.Pixel(10,230)}));
		map.addControl(new OpenLayers.Control.Scale());
		//map.addControl(new OpenLayers.Control.MousePosition());
		map.events.register('preaddlayer', map, function(evt) { 
         if (evt.layer) { 
				 evt.layer.events.register('loadstart', this, function() { 
					 layersLoading++; 
					 //$("#s1").append("<li id='layer_"+evt.layer.id+"'>"+evt.layer.id+" > "+layersLoading+"</li>");
					 if (layersLoading > 0) { 
						 $('#loader').show(); 
						 //$("#map_loading_box").height($("#map").height());
						 //$("#map_loading_box").show();	
					 } 
				 }); 
				 evt.layer.events.register('loadend', this, function() { 
					 if (layersLoading > 0) { 
					 	
						 layersLoading--; 
						 //$("#e1").append("<li id='layer_"+evt.layer.id+"'>"+evt.layer.id+" > "+layersLoading+"</li>");
					 } 
					 if (layersLoading == 0) { 
					 	//alert(evt.layer.id);
						 $('#loader').hide(); 
						 //$("#map_loading_box").hide();	
						 //$('#throbber').hide(); 
					 } 
				 }); 
			 } 
		 });
		
		
		layer_wi = new OpenLayers.Layer.XYZ(
			"XYZ Lingkar",
			[
				"http://a.tile.openstreetmap.org/${z}/${x}/${y}.png",
				"http://b.tile.openstreetmap.org/${z}/${x}/${y}.png",
				"http://c.tile.openstreetmap.org/${z}/${x}/${y}.png"
			], {
				attribution: "App &copy; <a href='#'>KEMENDAGRI</a>. Powered by <a href='http://dinamof.co.id/'>Dinamof</a> (LAT) | " + 
					"Data &copy; <a href='http://www.openstreetmap.org/'>OpenStreetMap</a> " +
					"and contributors, CC-BY-SA",
				buffer: 2,
				numZoomLevels: 16,
				wrapDateLine:true,
				transitionEffect: 'resize'
			}
		);		
		layer_wi.id = 'lokal';
		map.addLayer(layer_wi);
		
		
		
		ovControl = new OpenLayers.Control.OverviewMap({maximized:true,autoPan:true,size: new OpenLayers.Size(180,110)});
		ovControl.isSuitableOverview = function() {
			return false;
		};
		map.addControl(ovControl);
		
		var click = new OpenLayers.Control.Click();
		map.addControl(click);
		click.activate();
		//changeBaseMap('gmap');	
		
		//if (ext) ext = new OpenLayers.Bounds(ext.split(","));
		//(itheme)?triggerTheme():loadThemes();
		
		var id_bounds = new OpenLayers.Bounds(94,-8,141,6);
		map.zoomToExtent(id_bounds.transform(proj, map.getProjectionObject()));
		
		legendTheme();
		getData();
	}	//POINT
	function legendTheme() {
		var ldiv = document.getElementById("map_legend");
		
		for(var i=0;i<(colors.length-1);i++) {
			var dataLegend = document.createElement("i");
			var dataLabel = document.createTextNode(text[i]);
			var dataSpace = document.createElement("br");
			dataLegend.setAttribute('style', 'background:'+colors[i]);
			ldiv.appendChild(dataLegend);
			ldiv.appendChild(dataLabel);
			ldiv.appendChild(dataSpace);
		}
	}
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
		var render=["SVG","VML"];	
		
		
		var style2 = new OpenLayers.Style({
			pointRadius: "${radius}",
			fillColor: "#3C8DBC",//"${color}",
			strokeColor: "#FFF",
			fillOpacity: 1,
			strokeWidth: "${stroke}",
			strokeOpacity: 0.8,
			//label: "${NAMA}",
			fontColor:"#FFF",
			//graphicName:"triangle"
		}, {
			context: {
				width: function(feature) {
					return 4;
				},
				label: function(feature) {
					return feature.attributes.count>1?feature.attributes.count:'';
				}
			}
		});
		
		if (map.getLayer("clayer")) {
			clayer.destroyFeatures();
			map.removeLayer(clayer);
		}
		clayer = new OpenLayers.Layer.Vector('CLUSTER', {
			//minScale: 7000001,
			//maxScale: 867001,
			styleMap: new OpenLayers.StyleMap({
				"default": style2,
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
				url: 'map/kota',///json?jenis='+j+'&kelas='+k+'&rsp='+s+'&q='+q,//themes[stheme]['listUrl'],
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
		var style1 = new OpenLayers.Style({
			pointRadius: "${radius}",
			fillColor: "${color}",
			strokeColor: "#FFF",
			fillOpacity: 1,
			strokeWidth: "${stroke}",
			strokeOpacity: 0.8,
			//label: "${NAMA}",
			fontColor:"#FFF",
			//graphicName:"triangle"
		}, {
			context: {
				radius: function(feature) {
					return feature.attributes.value<100000?3:feature.attributes.value>=100000 && feature.attributes.value<500000?5:8;
				},
				color: function(feature) {
					var color='#aaa';
					if ( feature.attributes.value>0) {
						color= feature.attributes.value<100000?'green':feature.attributes.value>=100000 && feature.attributes.value<500000?'orange':'red';
					}
					return color;
				}
			}
		});
		
		if (map.getLayer("player")) {
			player.destroyFeatures();
			map.removeLayer(player);
		}
		player = new OpenLayers.Layer.Vector('POINT KOTA', {
			//minScale: 7000001,
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
				url: 'form/gis/penduduk_point_get',///json?jenis='+j+'&kelas='+k+'&rsp='+s+'&q='+q,//themes[stheme]['listUrl'],
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
		
		
		
		highlightCtrl = new OpenLayers.Control.SelectFeature([clayer], {
				multiple:true, hover: true, highlightOnly: true, renderIntent: "temporary"
		});
		
		popCtrl = new OpenLayers.Control.SelectFeature([clayer], {
				multiple:true, hover: true, highlightOnly: false, renderIntent: "temporary", callbacks:{
				'over':feature_hover, 'out':feature_out
			}
		});
		
		selectCtrl = new OpenLayers.Control.SelectFeature([clayer], {
			onSelect: onFeatureSelect, onUnselect: onFeatureUnselect
		});
		/*selectCtrl2 = new OpenLayers.Control.SelectFeature(polylayer, {
			onSelect: feature_hover_pc, onUnselect: feature_out
		});*/
				
		//map.addControl(selectCtrl2);
		map.addControls([highlightCtrl,selectCtrl,popCtrl/*,selectCtrl2*/]);
		highlightCtrl.activate();
		popCtrl.activate();
		selectCtrl.activate();

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
<section class="content-header" style="position:absolute; z-index:1000">
  <h1 class="hidden-xs">
    SIM PERKOTAAN
    <small><?=$nama_wilayah;?></small>
  </h1>
</section>

<div id="top-layouts" style="position:absolute; z-index:1001; top:5px; right:0">
    <div class="floating-button" style="padding:10px">
    <a href="#zoomin" title="Perbesar Tampilan Peta"><span class="fa-stack fa-lg">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
        </span></a>
    <a href="#zoomout" title="Perkecil Tampilan Peta"><span class="fa-stack fa-lg">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-minus fa-stack-1x fa-inverse"></i>
        </span></a>
    <a id="ov-button" href="#" title="On/Off Peta Kecil"><span class="fa-stack fa-lg">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-eye-slash fa-stack-1x fa-inverse"></i>
        </span></a>
    </div>
    <div style="position:absolute; z-index:650; top:200px; right:30px">
    <ul class="nav nav-pills pull-right">
      <!--<li id="loader" class="olControlLoader">Loading...</li>-->
      <li role="presentation" class="dropdown" title="Ganti Peta Dasar">
        <img id="bm" src="assets/images/base-osm.jpg" style="border:3px solid #fff" class="img-roundeds dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false" />
        <ul id="select_map" class="dropdown-menu" role="menu">
            <li title="Peta OSM"><img data-map="osm" src="assets/images/s-base-osm.jpg" style="border:3px solid #fff; display:none" class="img-roundeda"></li>
            <li title="Peta Google"><img data-map="gmap" src="assets/images/s-base-gmap.jpg" style="border:3px solid #fff" class="img-roundeda"></li>
            <li title="Peta Google Hybrid"><img data-map="ghyb" src="assets/images/s-base-ghyb.jpg" style="border:3px solid #fff" class="img-roundeda"></li>
          <!--<li><a href="#" data-map="osm">OSM Map</a></li>
          <li><a href="#" data-map="gmap">Google</a></li>-->
        </ul>
      </li>
    </ul>
    </div>
  <!--<-->
  </div>
      <div id="map_legend"><div style="margin-bottom:5px; border-bottom:1px solid #ccc; padding:2px">Legend</div></div>

</div>
<script>
	$(function(){	
		$(".pagination .active a").click(function(e){
			e.preventDefault();
		});
		
		$("#pp_select").change(function(){
			var pp=parseInt($(this).find("option:selected").val());
			if(pp<0){
				location=document.URL.split("?")[0];
				return false;
			}
			get_query();
		});
		
		$("#frm-search").submit(function(e){
			e.preventDefault();
			get_query();
		});
		$("#filter_toggle").click(function(){
			$(this).toggleClass("active");
			$("#filter_content").slideToggle();
		});
		
		$('a[data-toggle="tab"]').on('click', function (e) {
			$("#t").val($(this).parent().index());
		});
		
		//handle paging click
		$(".page > a").click(function(e){
			e.preventDefault();
			var href = $(this).attr("href");
			var t = $("#t").val();
			location=( href.replace( /t=[0-9]/ ,'t='+t) );
		});
		
		
		
		$("#propinsi").change(function(){
			$("#kabupaten").html('<option>--loading--<option>');
			var kd_prop=$("#propinsi option:selected").val()||$("#propinsi").val();
	
			kd_prop=kd_prop?kd_prop:'x';
			$.get("common/service/lookup_kota/"+kd_prop,function(ret){
				$("#kabupaten").html(ret);
			});
		});
		$("#map").css("height",$("#map").height()-50);
		
		$("[href='#zoomin']").click(function(e){
			map.zoomIn();
			e.preventDefault();
		});
		$("[href='#zoomout']").click(function(e){
			map.zoomOut();
			e.preventDefault();
		});
	});
	
	function get_query(){
			var q =$("#q").val()||"";
			var perPage=$("#pp_select option:selected").val();
			$("#pp").val(perPage);
			var pp =$("#pp").val()||"";
			var t =$("#t").val();
			var data=[];
			if(q){
				data.push("q="+q);
			}
			
			if((pp)){
				data.push("pp="+pp);
			}
			if(t){
				data.push("t="+t);
			}
			var param='';
			if(data){
				param="?"+data.join("&");
			}
			var url=document.URL.split("?")[0];
			location=url+param;
	}
	init();
</script>
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
</style>