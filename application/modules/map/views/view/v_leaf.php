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
<link rel="stylesheet" href="assets/js/leaflet/leaflet.css" />
<link rel="stylesheet" href="assets/js/leaflet/plugins/basemap/basemap.css" />
<script src="https://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/plugins/leaflet.ajax.min.js"></script>
<script src="assets/js/leaflet/plugins/basemap/basemap.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js//leaflet-google.js"></script>
<script>
	var basemaps = [
		L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {id: 'OSM Basemap'}),
		L.tileLayer('http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}),
		L.tileLayer('//stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}.png', {
			attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
			subdomains: 'abcd',
			maxZoom: 20,
			minZoom: 0,
			label: 'Toner Lite'
		})
	];
	
	var ctheme = 'spp';
	var themes = {
		"pddk": {
			themeTitle: "Peta Kota",
			json_url: "form/gis/penduduk_get/point/",
			json_url_2: "form/gis/penduduk_get/poly/",
			legend:{
				range	: [500000, 300000, 100000],
				size	: [10, 8, 5],
				text	: ['Besar', 'Menengah', 'Kecil'],
				color	: ["#BD0026", "#2b8786", "#a2bc3e"],
				title	: "Kota"
			}
		}
		,"spp": {
			themeTitle: "SPP Kota",
			json_url: "form/gis/spp_get/point/",
			json_url_2: "form/gis/spp_get/poly/",
			legend:{
				range	: [100, 30, 10, 8, 4, 2, 1, 0],
				size	: [30, 20, 17, 15, 12, 10, 8, 5],
				text	: ['100+', '30 - 100', '10 - 30', '8 - 10', '4 - 8', '2 - 4', '1 - 2', '0'],
				color	: ["#2b8786", "#00a14b", "#a2bc3e", "#ffde17", "#faa222", "#f26522", "#f04e37", "#ed1c24"],
				title	: "SPP Kota (%)"
			}
		}
		
	};
	var mapbg = false;
	var polyLayer,pointLayer;
	var param = '';
	var theme = themes[ctheme];
	
	var map;
	function init() {
		map = L.map('map', { zoomControl:false });
		
		//L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {id: 'OSM Basemap'}).addTo(map);
		//baseCtrl = L.control.iconLayers(layers,{position: 'topright'}).addTo(map);
		
		map.addControl(L.control.basemaps({
            basemaps: basemaps,
            tileX: 0,
            tileY: 0,
            tileZ: 1
        }));
		
		map.fitBounds([
			[-8,94],
			[6,141]
		]);
		
		L.control.scale().addTo(map);
		getData();
	}
	
	function legendTheme() {
		var text = theme.legend['text'];
		var colors = theme.legend['color'];
		var num = Math.min(colors.length,text.length);
		
		document.getElementById("map_legend_title").innerHTML=theme.legend.title;
		var ldiv = document.getElementById("map_legend");
		
		while (ldiv.hasChildNodes() && ldiv.childNodes.length > 1) {  
			ldiv.removeChild(ldiv.lastChild);
		}

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
	
	function getData(p,k,c,t) {
		legendTheme();
		dataShow();

		var p = p?p:0;
		var k = k?k:0;
		var c = c?c:0;
		var t = t?t:0;
		
		var q = c+"/"+p+"/"+k+"?tahun="+t;
		
		//Poly Layer
		if (map.hasLayer(polyLayer)) {
			map.removeLayer(polyLayer);
		}
		polyLayer = new L.GeoJSON.AJAX(theme['json_url_2']+q, 
		{
			minZoom: 7,
			style: style,
			onEachFeature: onEachFeature
		});       
		//alert(theme['json_url']+q);
		//Point Layer
		if (map.hasLayer(pointLayer)) {
			map.removeLayer(pointLayer);
		}
		pointLayer = new L.GeoJSON.AJAX(theme['json_url']+q, 
		{
			maxZoom: 1,
			style: style,
			pointToLayer: function (feature, latlng) {
				return L.circleMarker(latlng, style);
			},
			onEachFeature: onEachFeaturePoint
		});  
		polyLayer.addTo(map);
		pointLayer.addTo(map);
		
		polyLayer.on('data:loaded', function () {
			 map.fitBounds(polyLayer.getBounds());
		})
	}
	
	function resetStyle(t_layer) {
		t_layer.eachLayer(function (layer) {  
			t_layer.resetStyle(layer);
		});
	}

	function style(feature) {
		return {
			fillColor: getColor(feature.properties.value),
			radius:getSize(feature.properties.value),
			weight: 1,
			opacity: 1,
			color: 'white',
			dashArray: '2',
			fillOpacity: 0.7
		};
	}
	function getColor(v) {
		var c = theme.legend['color'];
		var r = theme.legend['range'];
		var l = r.length;
		var d = l-1;
		if (v==0) return "#999";
		//range	: [500000, 300000, 100000],
		for (var i=0;i<l;i++) {
			if (i==0) {
				if (v>r[i]) d=0;
			}
			else if (i==l-1) {
				if (v<r[i]) d=l-1;
			}
			else {
				if (v>r[i] && v<r[i-1]) d=i;
			}
		}
		
		//d = d > r[0] ? 0 : d > r[1] ?1 : d > r[2] ? 2 : d > r[3]  ? 3 : d > r[4]   ? 4 : d > r[5]   ? 5 : d >= r[6]   ? 6 : 7;
		return c[d];
	}
	function getSize(v) {
		var s = theme.legend['size'];
		var r = theme.legend['range'];
		var l = r.length;
		var d = l-1;
		for (var i=0;i<l;i++) {
			if (i==0) {
				if (v>r[i]) d=0;
			}
			else if (i==l-1) {
				if (v<r[i]) d=l-1;
			}
			else {
				if (v>r[i] && v<r[i-1]) d=i;
			}
		}
		//d = d > r[0] ? 0 : d > r[1] ?1 : d > r[2] ? 2 : d > r[3]  ? 3 : d > r[4]   ? 4 : d > r[5]   ? 5 : d >= r[6]   ? 6 : 7;
		return s[d];
	}
	function highlightFeature(e) {
		var layer = e.target;
		layer.setStyle({
			weight: 3,
			color: 'orange',
			dashArray: '',
			fillOpacity: 0.5
		});
	
		/*if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
			layer.bringToFront();
		}*/
	}
	function resetHighlight(e) {
		polyLayer.resetStyle(e.target);
	}
	function zoomToFeature(e) {
		map.fitBounds(e.target.getBounds());
	}
	function onEachFeature(feature, layer) {
		layer.bindPopup(feature.properties.nm_kabkota);
		layer.on({
			mouseover: highlightFeature,
			mouseout: resetHighlight,
			click: zoomToFeature
		});
	}
	function onEachFeaturePoint(feature, layer) {
		layer.bindPopup(feature.properties.nm_kabkota);
		layer.on({
			mouseover: highlightFeature,
			mouseout: resetHighlight
		});
	}
	//INTERACTION
	function dataHide() {
		$("#data-container").slideUp('fast',function(){
			$("#data-list-small").slideDown('fast');
		});
	}
	function dataShow() {
		$("#data-container").slideDown();
		$("#data-list-small").slideUp();
		$("#detil-container").slideUp();
		//onPopupClose();
	}
	function detilHide() {
		$("#detil-container").slideUp('fast');
	}
	function detilShow(url) {
		dataHide();
		if (url) {
			$("#detil-container").removeClass("hide");
			$("#data-detil").load(url,function() {
				$("#detil-container").slideDown('fast');
			});
		}
		else {
			$("#detil-container").slideDown('fast');
		}
		$('#myTab li:eq(1) a').tab('show');
	}
</script>
<div id="map-wrapper" style="position:relative">
<div id="map" style="height:100vh">
<!--<section class="content-header" style="position:absolute; z-index:1000">
  <h1 class="hidden-xs">
    SIM PERKOTAAN
    <small><?=$nama_wilayah;?></small>
  </h1>
</section>
-->
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
  
  
  <div id="map_legend"><div id="map_legend_title" style="margin-bottom:5px; border-bottom:1px solid #ccc; padding:2px">Legend</div></div>
</div>

<div id="box-data" class="box-data" style="position:absolute; z-index:11001; top:60px; left:20px; width:400px; height: auto; background:transparent">
    <ul class="nav nav-tabs" id="myTab" style="margin:0; background:transparent; margin-top:-42px">
        <li><a href="#brwa"><i class="fa fa-remove"></i></a></li>
        <li class="active"><a href="#nav"><i class="fa fa-search"></i></a></li>
        <li><a href="#data_search"><i class="fa fa-question"></i></a></li>
    </ul>
    
    <div class="tab-content" id="data_box" style=" background:transparent;margin:0; padding:0px">
    	<div class="tab-pane" id="brwa">
             <div class="copyright">SIM PERKOTAAN v.1</div>
        </div>
        <div class="tab-pane active" id="nav">
            <form id="fdata" class="form-horizontal">
            
        	<!--panel collapse: start-->
        	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <!--<div class="panel panel-default">
                <div class="panel-heading" style="position:relative; padding-top:10px">
                      <span style="position:absolute; right:20px; top:15px">&times;</span>
                      <input id="search_key" class="form-controls" placeholder="Search" type="text">
                </div>
              </div>-->
              <div class="panel panel-default" style="z-index:10000">
                <div class="panel-heading" role="tab" id="headingOne" style="position:relative; padding-top:10px">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" data-title="Provinsi:" href="#acc_administratif" aria-expanded="true" aria-controls="acc_administratif">
                      Provinsi: <span class="acctext">-</span>
                    </a>
                  </h4>
                </div>
                <div id="acc_administratif" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingZero">
                  <div class="panel-body">
                        <!-- Select Basic -->
                            <? echo form_dropdown("kd_prop",$lookup_propinsi,$kd_prop,"id='kd_prop' class='form-control'");?>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne" style="position:relative; padding-top:10px">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" data-title="Fungsi Kawasan/jenis Pelayanan::" href="#acc_fk" aria-expanded="true" aria-controls="acc_administratif">
                      Fungsi Kawasan/jenis Pelayanan: <span class="acctext">-</span>
                    </a>
                  </h4>
                </div>
                <div id="acc_fk" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                        <!-- Select Basic -->
                            <? echo form_dropdown("fk",$this->lookup_fk,$key,"id='fk' class='form-control'");?>
                        
                        	<? echo form_dropdown("tahun",$this->lookup_year,$tahun,"id='tahun' class='form-control'");?>
                        <!-- Select Basic -->
                            <!--<span id="id_kabupaten_holder">
                            <?=form_dropdown("id_kabupaten",false,0,"id='id_kabupaten' class='form-control'");?>
                            </span>-->
                  </div>
                </div>
              </div>
              <div id="button-block" style="background:#fff; position:absolute; width:100%; z-index:1001; display:none">
              	<div class="btn-group btn-group-justifieds" role="group" aria-label="...">
                  <div class="btn-group" role="group">
                    <button id="myButton" type="button" class="btn" style="background:#fff"><i class="fa fa-search"></i> &nbsp;CARI </button>
                  </div>
                  <div class="btn-group" role="group">
                    <button id="myReset" type="button" class="btn" style="background:#fff"><i class="fa fa-remove"></i> &nbsp;RESET </button>
                  </div>
                </div>
              </div>
			
            </div>
			
            <!--container-->
            <div id="all-container">
                <div id="data-list-small"><a><i class="fa fa-list-ul"></i> &nbsp; Lihat Hasil Pencarian</a></div>
                <div id="data-container">
                    <div id="data-list"></div>
                    <div id="data-stats"></div>
                </div>
                <div id="detil-container">
                    <div id="data-detil"></div>
                    <div id="data-detil-stats">
                            <a href="" class="btns open_detil" style="background:#fff"><i class="fa fa-search"></i> &nbsp;Report Lengkap Kota</a>
                    </div>
                </div>
            </div>
            <!--container: end-->
            <!--panel collapse: end-->
            </form>
        </div>
        <div class="tab-pane" id="data_search">
            <div style="overflow:hidden; background:#fff; padding:15px">
             About & Help
             </div> 
        </div>
    </div>
  </div>
  </div>
<script>
	$(function(){	
		$('#myTab a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
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
		init();
		
		$("[href='#zoomin']").click(function(e){
			map.zoomIn();
			e.preventDefault();
		});
		$("[href='#zoomout']").click(function(e){
			map.zoomOut();
			e.preventDefault();
		});
		
		var timer;
		$('#accordion').bind('mouseenter',
		function() { //hover
			clearTimeout(timer);
			$("#button-block").slideDown('fast');
			$("#all-container").css('opacity',0.5);
		}).bind('mouseleave', function(){
			clearTimeout(timer);
			timer = setTimeout(function(){
			$("#button-block").slideUp('fast');
			$("#all-container").css('opacity',1);
			}, 1000);
		});	
		
		$('#all-container').bind('mouseenter', function(){
			$(this).css('opacity',1);
			$("#button-block").slideUp('fast');
		});
		
		
		$("#select_map li>img").click(function(e){
			var src = $(this).attr("src");
			$("#select_map li>img").show();
			$("#bm").attr('src',src.replace('s-',''));
			$(this).hide();
			changeBaseMap($(this).data("map"));
			e.preventDefault();
		});
		
		$('#accordion').on('hidden.bs.collapse', function () {
			var collapse = $(this).find(".collapse");
			collapse.each(function(){
				var openid = $(this).attr('id');
				var heading = $("#"+openid).prev().find("h4>a");
				var text = new Array();
				
				if (openid=='acc_administratif') {
					var param = $("#"+openid).find('.form-control :checked');
					param.each(function(){
						if ($(this).val()!="" || $(this).text()=='Semua') text.push($(this).text());
					});
					heading.html("Provinsi: <BR>- "+"<span class='acctext'>"+text+"</span>");
				}
				else if (openid=='acc_fk') {
					var param = $("#"+openid).find('.form-control :checked');
					param.each(function(){
						if ($(this).val()!="" || $(this).text()=='Semua') text.push($(this).text());
					});
					text = text.join(" <BR>- ");
					heading.html("Fungsi Kawasan/jenis Pelayanan: <br>- "+"<span class='acctext'>"+text+"</span>");
				}
				else{
					var param = $("#"+openid).find('.form-control :checked');
					param.each(function(){
						if ($(this).val()!="" || $(this).text()=='Semua') text.push($(this).text());
					});
					heading.html("Tahun: "+"<span class='acctext'>"+text+"</span>");
				}
			});
		});
		$('#accordion').on('shown.bs.collapse', function () {
			var openid = $(this).find(".collapse.in").attr('id');
			var heading = $("#"+openid).prev().find("h4>a");
			var text = "";
			switch(openid) {
				case 'acc_administratif':
					text = "Provinsi: ";
					break;
				case 'acc_fk':
					text = "Fungsi Kawasan/jenis Pelayanan: <br>";
					break;
				case 'acc_status':
					text = "Tahun ";
					break;	
			}
			heading.html(text);
		});
		$("#data-list-small").click(function(e){
			dataShow();
			e.preventDefault();
		});
		
		//CARI
		$('#myButton').on('click', function () {
			$("#button-block").hide();
			$("#fdata").submit();
		  });
		  $("#fdata").submit(function(e){
			var $btn = $('#myButton').button('loading');
			$('#accordion .in').collapse('hide');
			
			var prop = $("#kd_prop").val();
			var kab  = $("#kd_kab").val();
			var code  = $("#fk").val();
			var tahun  = $("#tahun").val();

			theme = (code=='1.1')?themes['pddk']:themes['spp'];
			getData(prop,kab,code,tahun);
			
			$btn.button('reset');
			return false;
		  });
		  
		  $('#accordion').trigger('hidden.bs.collapse');
		  //$('#myButton').trigger("click");
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
</script>
<style>
.leaflet-left {
    left: 20px;
}
.leaflet-bottom {
    bottom: 10px;
}
.leaflet-control-scale-line {
	font-size: 9px!important;
	border: 1px solid #777;
	border-top: none;
	line-height: .9;
}
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
	border-radius:0;
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
.acctext {
	font-weight:bold;
}
#accordion .panel-title {
	font-size:.9em!important;
}
</style>