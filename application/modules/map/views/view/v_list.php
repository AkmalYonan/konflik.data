<?php 
if ($_POST['uo'] || $_POST['sort'] || $_POST['q']) {
	$class_toggle=" active";
	$class_content="";
}
else {
	$class_toggle="";
	$class_content="none";
}

$lookup_r['org']="BNNP/BNNK";
$lookup_r['balai']="Balai/Loka";
$lookup_r['ipwl']="IPWL & IP NON IPWL";
$lookup_r['kp']="Klinik Pratama";
$lookup_r['kmrd']="Komp. Masyarakat & RD";

$data_propinsi=lookup("m_propinsi2","kode_bps","nama");
?>
<!--MAP-->
<link rel="stylesheet" href="assets/js/leaflet/leaflet.css" />
<link rel="stylesheet" href="assets/js/leaflet/plugins/basemap/basemap.css" />
<style>
 .pop-tipe {border-bottom:1px solid #aaa; font-weight:bold}
</style>
<script src="https://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/plugins/leaflet.ajax.min.js"></script>
<script src="assets/js/leaflet/plugins/basemap/basemap.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js//leaflet-google.js"></script>

<script>
	var base_url = '<?=$this->base_url?>';
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
	
	var ctheme = 'ipwl';
	var themes = {
		"org": {
			themeTitle: "BNN",
			json_url: base_url+"data_service/map/bnn.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			json_url_2: "form/gis/penduduk_get/poly/",
			col_tipe:"tipe_org",
			legend:{
				range	: ['BNNP', 'BNNK'],
				size	: [8, 5],
				text	: ['BNNP', 'BNNK'],
				color	: ["#BD0026", "#2b8786"],
				title	: "TIPE"
			}
		},
		"balai": {
			themeTitle: "Balai/Loka",
			json_url: base_url+"data_service/map/balai.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			json_url_2: "form/gis/penduduk_get/poly/",
			col_tipe:"jenis_tempat_rehab",
			legend:{
				range	: ['BB', 'BLK'],
				size	: [8, 5],
				text	: ['Balai Besar', 'Balai Loka'],
				color	: ["#BD0026", "#2b8786"],
				title	: "TIPE"
			}
		},
		"ipwl": {
			themeTitle: "INSTANSI",
			json_url: base_url+"data_service/map/ipwl.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			json_url_2: "form/gis/penduduk_get/poly/",
			col_tipe:"jenis_instansi",
			legend:{
				range	: ['pd','polri','pr','ps', 'rsj', 'rsk','rss','rsu','rsup'],
				size	: [5,5,5,5,5,5,5,5,5,5],
				text	: ['Praktek Dokter', 'Polri', 'Panti Rehabilitasi','Puskesmas','RSJ','RSK','RS Swasta','RS Umum','RSUP'],
				color	: ["#ff8c00","#268dea","#50b576","#A7CEE5","#fb3e46","#3366cc","#109618","#dc3912","#ff9900"],
				title	: "IPWL & IP NON IPWL"
			}
		},
		"kp": {
			themeTitle: "Klinik Pratama",
			json_url: base_url+"data_service/map/kp.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			json_url_2: "form/gis/penduduk_get/poly/",
			col_tipe:"jenis_instansi",
			legend:{
				range	: ['kp'],
				size	: [5,5],
				text	: ['Klinik Pratama'],
				color	: ["#109618","#dc3912","#ff9900"],
				title	: "Klinik Pratama"
			}
		},
		"kmrd": {
			themeTitle: "KM & RD",
			json_url: base_url+"data_service/map/kmrd.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			json_url_2: "form/gis/penduduk_get/poly/",
			col_tipe:"jenis_instansi",
			legend:{
				range	: ['km','rd'],
				size	: [5,5],
				text	: ['Komponen Masyarakat','Rumah Damping'],
				color	: ["#109618","#dc3912","#ff9900"],
				title	: "KM & RD"
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
		L.control.zoom({position:'topright'}).addTo(map);
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
	
	function fDetail(c) {
		var text = themes[c].legend['text'];
		var range = themes[c].legend['range'];
		var num = Math.min(range.length,text.length);
		
		$("#fd").html("");
		
		$('#fd').append($('<option>', {value:0, text:""}));
		for(var i=0;i<num;i++) {
			$('#fd').append($('<option>', {value:range[i], text:text[i]}));
		}
	}
	
	function getData(p,c,d) {
		var p = p?p:0;
		var c = c?c:'org';
		var d = d?d:0;
		
		theme = themes[c];
		legendTheme();
		
		dataShow();
		
		var q = "&kd_prop="+p+"&id_propinsi="+p+"&kd_propinsi="+p+"&"+theme.col_tipe+"="+d;
		//Poly Layer
		/*if (map.hasLayer(polyLayer)) {
			map.removeLayer(polyLayer);
		}
		polyLayer = new L.GeoJSON.AJAX(theme['json_url_2']+q, 
		{
			minZoom: 7,
			style: style,
			onEachFeature: onEachFeature
		});    */   
		//alert(theme['json_url']+q);
		//Point Layer
		if (map.hasLayer(pointLayer)) {
			map.removeLayer(pointLayer);
		}
		/*pointLayer = new L.GeoJSON.AJAX(theme['json_url'], 
		{
			style: style,
			pointToLayer: function (feature, latlng) {
				return L.circleMarker(latlng, style);
			},
			onEachFeature: onEachFeaturePoint
		});  */
		//polyLayer.addTo(map);
		$.getJSON(theme['json_url']+q,function(data){
			pointLayer=L.geoJson(data,{
				style: style,
				onEachFeature: onEachFeaturePoint,
				pointToLayer: function (feature, latlng) {
					return L.circleMarker(latlng, style);
				}
			}).addTo(map);
			map.fitBounds(pointLayer.getBounds());
		});
		
		map.on('zoomend', function() {
			var currentZoom = map.getZoom();
			var myRadius = currentZoom; //or whatever ratio you prefer
				pointLayer.setStyle({radius: myRadius});
		});
		//pointLayer.addTo(map);
		
		/*pointLayer.on('data:loaded', function () {
			 map.fitBounds(pointLayer.getBounds());
		})*/
	}
	
	function resetStyle(t_layer) {
		t_layer.eachLayer(function (layer) {  
			t_layer.resetStyle(layer);
		});
	}

	function style(feature) {
		return {
			fillColor: getColor(feature.properties.tipe),
			radius: map.getZoom(),//getSize(feature.properties.tipe),
			weight: 1,
			opacity: 1,
			color: 'white',
			fillOpacity: 0.7
		};
	}
	function getColor(v) {
		var c = theme.legend['color'];
		var r = theme.legend['range'];
		var i = r.indexOf(v);
		return c[i]||'#000';
	}
	function getSize(v) {
		var c = theme.legend['size'];
		var r = theme.legend['range'];
		var i = r.indexOf(v);
		return c[i]||4;
	}
	function getText(v) {
		var c = theme.legend['text'];
		var r = theme.legend['range'];
		var i = r.indexOf(v);
		return c[i]||"";
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
		pointLayer.resetStyle(e.target);
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
		/*layer.bindPopup("<div class='pop-tipe'>"+getText(feature.properties.tipe)+"</div>"+feature.properties.nama);
		layer.on({
			mouseover: highlightFeature,
			mouseout: resetHighlight
		});*/
		if (feature.properties) {
                    
                        if(feature.properties.tipe!=="BNNP" && feature.properties.tipe!=="BNNK"){
                            var additional_data    =   "<div class='row'><div class='col-sm-12'>Pejabat : "+feature.properties.nama_pejabat+" - Jabatan : "+feature.properties.jabatan+"</div></div>";
                            additional_data     +=  "<div class='row'><div class='col-sm-3'>Layanan: </div><div class='col-sm-9'>";
                            if(feature.properties.rawat_jalan==1){
                                additional_data +=  " Rawat Jalan <br />";
                            }
                            if(feature.properties.rawat_inap==1){
                                additional_data +=  " Rawat Inap <br />";
                            }
                            if(feature.properties.rawat_pasca==1){
                                additional_data +=  " Rawat Pasca";
                            }
                            additional_data     +=  "</div></div>";
                        }else{
                            var additional_data    =   "";
                        }
                        
			layer.bindPopup("<div class='pop-tipe'>"+getText(feature.properties.tipe)+"</div><div class='row'><div class='col-sm-12'>"+feature.properties.nama+"</div></div><div class='row'><div class='col-sm-12'>"+feature.properties.alamat+"</div></div>"+additional_data, {closeButton: false, offset: L.point(0, -10)});
			layer.on('mouseover', function(e) { /*layer.openPopup();*/highlightFeature(e) });
			layer.on('mouseout', function(e) { /*layer.closePopup();*/resetHighlight(e) });
		}
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
  <div id="map_legend"><div id="map_legend_title" style="margin-bottom:5px; border-bottom:1px solid #ccc; padding:2px">Legend</div></div>
</div>

<div id="box-data" class="box-data" style="position:absolute; z-index:101; top:60px; left:20px; width:400px; height: auto; background:transparent">
    <ul class="nav nav-tabs" id="myTab" style="margin:0; background:transparent; margin-top:-42px">
        <li><a href="#brwa"><i class="fa fa-remove"></i></a></li>
        <li class="active"><a href="#nav"><i class="fa fa-search"></i></a></li>
        <li><a href="#data_search"><i class="fa fa-question"></i></a></li>
    </ul>
    
    <div class="tab-content" id="data_box" style=" background:transparent;margin:0; margin-top:-15px; padding:0px">
    	<div class="tab-pane" id="brwa">
             <div class="copyright">SIM REHABILITASI - BNN v.1</div>
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
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne" style="position:relative; padding-top:10px">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" data-title="TEMA:" href="#acc_fk" aria-expanded="true" aria-controls="acc_administratif">
                      TEMA: <span class="acctext">-</span>
                    </a>
                  </h4>
                </div>
                <div id="acc_fk" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                        <!-- Select Basic -->
                            <? echo form_dropdown("fk",$lookup_r,$key,"id='fk' class='form-control'");?>
                        
                        	<? echo form_dropdown("fd",$this->lookup_year,$tahun,"id='fd' class='form-control'");?>
                        <!-- Select Basic -->
                            <!--<span id="id_kabupaten_holder">
                            <?=form_dropdown("id_kabupaten",false,0,"id='id_kabupaten' class='form-control'");?>
                            </span>-->
                  </div>
                </div>
              </div>
              <div class="panel panel-default" style="z-index:10000">
                <div class="panel-heading" role="tab" id="headingOne" style="position:relative; padding-top:10px">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" data-title="WILAYAH:" href="#acc_administratif" aria-expanded="true" aria-controls="acc_administratif">
                      WILAYAH: <span class="acctext">-</span>
                    </a>
                  </h4>
                </div>
                <div id="acc_administratif" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingZero">
                  <div class="panel-body">
                        <!-- Select Basic -->
                        <select id="kd_prop" class="form-control">
                            <option value="">Semua </option>
                            <?php foreach($data_propinsi as $k=>$v): ?>
                            <option value="<?=$k?>" <?=($kd_propinsi==$k)?"selected":""?>><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
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
					heading.html("WILAYAH: <BR>- "+"<span class='acctext'>"+text+"</span>");
				}
				else if (openid=='acc_fk') {
					var param = $("#"+openid).find('.form-control :checked');
					param.each(function(){
						if ($(this).val()!="" || $(this).text()=='Semua') text.push($(this).text());
					});
					text = text.join(" <BR>- ");
					heading.html("TEMA: <br>- "+"<span class='acctext'>"+text+"</span>");
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
					text = "WILAYAH: ";
					break;
				case 'acc_fk':
					text = "TEMA: <br>";
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
		
		$("#fk").change(function(){
			fDetail($(this).val());
		}).change();
		
		//CARI
		$('#myButton').on('click', function () {
			$("#button-block").hide();
			$("#fdata").submit();
		  });
		  $("#fdata").submit(function(e){
			var $btn = $('#myButton').button('loading');
			$('#accordion .in').collapse('hide');
			
			var prop = $("#kd_prop").val();
			var code  = $("#fk").val();
			var fd  = $("#fd").val();

			getData(prop,code,fd);
			
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
.leaflet-right {
    right: 10px;
}
.leaflet-top {
    top: 10px;
}
.leaflet-bottom {
    bottom: 10px;
}

.leaflet-bar  {
	box-shadow:none!important
}
.leaflet-bar a {
    background-position: 50% 50%;
    background-repeat: no-repeat;
    display: inline-block!important;
	border-radius:50%!important;
	margin-right:2px
}
.leaflet-bar a {
    background-color: #555;
    border-bottom: 1px solid #ccc;
    width: 26px;
    height: 26px;
    line-height: 23px;
    text-align: center;
    text-decoration: none;
    color: #ddd!important;
}
.leaflet-bar a:hover {
    background-color: #333;
    border-bottom: 1px solid #ccc;
    width: 26px;
    height: 26px;
    line-height: 23px;
    text-align: center;
    text-decoration: none;
    color: #fff!important;
}
.leaflet-container a {
    color: #0078A8;
}
.leaflet-control-zoom-in, .leaflet-control-zoom-out {
    font: bold 18px 'Lucida Console', Monaco, monospace;
    text-indent: 1px;
}

.leaflet-control-scale-line {
	font-size: 9px!important;
	border: 1px solid #777;
	border-top: none;
	line-height: .9;
	background:transparent!important;
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
