<!--
<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />   
<link rel="stylesheet" href="assets/themes/lte2.3.0/dist/css/AdminLTE.min.css">
-->
<?php 
if ($_POST['uo'] || $_POST['sort'] || $_POST['q']) {
	$class_toggle=" active";
	$class_content="";
}
else {
	$class_toggle="";
	$class_content="none";
}
$lookup_pilih['']="Semua";
$data_propinsi=lookup("m_propinsi","kd_propinsi","nm_propinsi");
$y	=	date("Y");
for($i=0; $i<31; $i++):
	$tahun[$i]	=	$y-$i;
endfor;
//pre($this->wms_data);
//pre($this->wms2_data);
?>
<!--MAP-->
<link rel="stylesheet" href="assets/themes/lte2.3.0/plugins/select2/select2.min.css">
<link rel="stylesheet" href="assets/js/leaflet-1.3.1/leaflet.css" />
<link rel="stylesheet" href="assets/js/leaflet-1.3.1/plugins/basemap/basemap.css" />
<!--<script src="https://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>-->
<script type="text/javascript" src="assets/themes/lte2.3.0/plugins/select2/select2.full.min.js"></script>
<script src="assets/js/leaflet-1.3.1/leaflet.js"></script>
<script src="assets/js/leaflet-1.3.1/plugins/leaflet.ajax.min.js"></script>
<script src="assets/js/leaflet-1.3.1/plugins/basemap/basemap.js"></script>
<script src="assets/js/leaflet-1.3.1/plugins/groupedLayer/leaflet.groupedlayercontrol.js"></script>
<script src="assets/js/leaflet-1.3.1/plugins/wms/leaflet.wms.js"></script>

<style>
	/*.container{width:100%!important}*/
	.pop-tipe{
		border-bottom:1px solid #aaa;
		font-size: 13px; 
		font-weight:bold; 
		color:#3434E8;
		padding-bottom: 10px;
	}
	.leaflet-control-layers-selector {
		margin-left: 15px !important;
	}
	label>span.leaflet-control-layers-group-name{
		font-weight:700;	
	}
	label>span {
		font-weight:normal;
	}
	.table-stats {
		white-space:nowrap;
		font-size:.8em;
	}
	body {
		padding-top:57px!important;
		background-color:#f4f4f4;
	}
	input[name=leaflet-exclusive-group-layer-0], input[name=leaflet-exclusive-group-layer-0] + span {
		display:none;
	}
	.leaflet-control-layers {
		box-shadow: none;
		border-radius: 5px;
		border:none!important;
	}
	.leaflet-touch .leaflet-control-layers, .leaflet-touch .leaflet-bar {
		border:none!important;
	}
	.leaflet-control-layers-expanded .leaflet-control-layers-toggle,
	.leaflet-control-layers-expanded .leaflet-control-layers-toggle .fa{
		display: block!important;
		padding: 0;
		height: 24px !important;
		line-height: 24px;
	}
	.leaflet-control-layers-expanded {
		background: #fff;
	}
	
	.leaflet-control-layers-toggle {
		width:auto!important;
		background-image: none !important;
		height: 28px !important;
		font-weight: bold;
		color: #333 !important;
		line-height: 28px;
		padding: 0 5px;
		white-space: nowrap;
	
	}
	.leaflet-control-layers-toggle .fa {
		float:right;
		margin-left:10px;
		line-height: 28px;
		border-radius:50%;
		color:#777;
	}
	.leaflet-control-layers-list {
		overflow:auto!important;
		/*padding: 0 10px;*/
		min-height:inherit;
		min-width:200px!important;
		max-height:400px!important;
	}
	.leaflet-control-layers-expanded{
		min-height: 150px;
	}
	.leaflet-control-layers-list input[type="checkbox"], input[type="radio"] {
		margin: 4px 5px 0 0;
	}
</style>


<script>
	var wms_url = '<?=$this->config->item("wms_url")?>';
	var sektor;
	var konflik;
	var val_tora;
	var val_piaps;
	
	
	$(document).ready(function(){
		
		$("#myButton").on("click",function(){
			$("#accordion").find("[data-parent='#accordion'][aria-expanded='true']").trigger('click');
			kd_prop	=	$("#kd_prop").val();
			id_kabupaten	=	$("#id_kabupaten").val();
			sektor	=	$("#sektor").val() || new Array();
			$("#txt_sektor").val(sektor);
			
			arr_split = $("#txt_sektor").val().split(",");
			
			konflik	=	$("#konflik").val();
			tahun	=	$("#tahun").val();
			
			//var arr_sektor=sektor.split(",");
			//alert(arr_sektor);
			set_sektor();
			
			
			//$("#button-blockx").hide();
			//$("#button-blockx").slideDown('slow');
			getData(kd_prop,id_kabupaten,sektor,konflik,tahun);
			$(".sektor_check").removeClass("fa-check");
		});
		
		$("#myReset").on("click",function(){
			$("#kd_prop").val("");
			$("#sektor").val("").trigger('change');
			//add it to reset
			$(".ck_sektor").prop('checked',false);
			$("#txt_sektor").val("");
			
			$("#konflik").val("");
			$("#tahun").val("<?=date('Y')?>");
			$("#button-blockx").slideUp('slow');
			
			$(".panel-title").find("a").each(function(){
				$(this).html($(this).data("title"));
			});
			
			set_sektor();
			
			getData(false,false,false,false,'<?=date("Y")?>');
			$(".sektor_check").removeClass("fa-check");
		});
		
		$("#btn_search").on("click",function(){
			$("#accordion").find("[data-parent='#accordion'][aria-expanded='true']").trigger('click');
			kd_prop	=	$("#kd_prop").val();
			id_kabupaten	=	$("#id_kabupaten").val();
			sektor	=	$("#sektor").val();
			konflik	=	$("#konflik").val();
			tahun	=	$("#tahun").val();
			//$("#button-blockx").hide();
			//$("#button-blockx").slideDown('slow');
			set_sektor();
			getData(kd_prop,id_kabupaten,sektor,konflik,tahun);
			$(".sektor_check").removeClass("fa-check");
		});
		
		$("#btn_reset").on("click",function(){
			$("#kd_prop").val("");
			$("#sektor").val("");
			$("#konflik").val("");
			$("#tahun").val("");
			$("#button-blockx").slideUp('slow');
			set_sektor();
			$(".panel-title").find("a").each(function(){
				$(this).html($(this).data("title"));
			});
			
			getData(false,false,false,false,false);
			$(".sektor_check").removeClass("fa-check");
		});
		
		$(".sektor_badge").on("click",function(e){
			e.preventDefault();
			/*
			$('#acc_fk').addClass('in');
			sektor	=	$(this).data("sektor");
			$("#sektor").val(sektor);
			
			$(".sektor_check").removeClass("fa-check");
			$("#checking"+sektor).addClass("fa-check");
			
			kd_prop	=	$("#kd_prop").val();
			id_kabupaten	=	$("#id_kabupaten").val();
			sektor	=	$("#sektor").val();
			konflik	=	$("#konflik").val();
			tahun	=	$("#tahun").val();
			
			getData(kd_prop,id_kabupaten,sektor,konflik,tahun);
			*/
			$(this).closest('tr').find(".ck_sektor").trigger('click');
		});
		
		
		/* ADD BY PETE */
		$(".ck_sektor").click(function(){
			get_ck_sektor();	
			kd_prop	=	$("#kd_prop").val();
			id_kabupaten	=	$("#id_kabupaten").val();
			sektor	=	$("#sektor").val();
			//sektor	=	$(this).val();
			konflik	=	$("#konflik").val();
			tahun	=	$("#tahun").val();
			
			getData(kd_prop,id_kabupaten,sektor,konflik,tahun);
			//getLayerKonflik(kd_prop,id_kabupaten,sektor,konflik,tahun);
			//alert(sektor);
			//console.log(pointLayer);
			/*
			if($(this).is(":checked")){
				getLayerKonflik(kd_prop,id_kabupaten,sektor,konflik,tahun);
			}else{
				map.removeLayer(pointLayer[sektor]);
			}
			*/
			
			
		});
		
		function get_ck_sektor(){
			var arr=new Array();
			$(".ck_sektor:checked").each(function(){
				arr.push($(this).val());
			});
			$("#sektor").select2('val',arr);
			$("#txt_sektor").val(arr.join("|"));
			
			var heading = $("#acc_fk").prev().find("h4>a");
			var param = $("#acc_fk").find('.form-control :checked');
			var text = new Array();
			
			param.each(function(){
				if ($(this).val()!="" || $(this).text()=='Semua') text.push($(this).text());
			});
			text = text.join(" <BR>- ");
			heading.html("KONFLIK: <br>- "+"<span class='acctext'>"+text+"</span>");
			
		}
		/* ADD BY PETE */
		
		$("#check_tora1").on("change",function(){
			var tora_val	=	check_tora();
			var	piaps_val	=	check_piaps();
			var	ha_val		=	check_hutan_adat();
			
			initial_tora_piaps(tora_val,piaps_val,ha_val);
			
		});
		
		$("#check_tora2").on("change",function(){
			var tora_val	=	check_tora();
			var	piaps_val	=	check_piaps();
			var	ha_val		=	check_hutan_adat();
			
			initial_tora_piaps(tora_val,piaps_val,ha_val);
			
		});
		
		$("#check_tora3").on("change",function(){
			var tora_val	=	check_tora();
			var	piaps_val	=	check_piaps();
			var	ha_val		=	check_hutan_adat();
			
			initial_tora_piaps(tora_val,piaps_val,ha_val);
			
		});
		
	});
	
	function check_tora(){
		
		if($("#check_tora1").is(":checked")){
			val_tora	=	1;
		}else{
			val_tora	=	0;
		}
		
		return val_tora;
	}
	
	function check_piaps(){
		
		if($("#check_tora2").is(":checked")){
			val_piaps	=	1;
		}else{
			val_piaps	=	0;
		}
		
		return val_piaps;
	}
	
	function check_hutan_adat(){
		
		if($("#check_tora3").is(":checked")){
			val_hutan_adat	=	1;
		}else{
			val_hutan_adat	=	0;
		}
		
		return val_hutan_adat;
	}

	var base_url = '<?=$this->base_url?>';
	var basemaps = [
		L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {id: 'OSM Basemap'}),
		L.tileLayer.wms('http://palapa.big.go.id:8080/geoserver/gwc/service/wms', {
			layers: 'basemap_rbi:basemap', VERSION: '1.1.1',
			iconURL: 'http://palapa.big.go.id:8080/geoserver/gwc/service/wms?service=WMS&request=GetMap&layers=basemap_rbi%3Abasemap&styles=&format=image%2Fjpeg&transparent=false&version=1.1.1&VERSION=1.1.1&width=256&height=256&srs=EPSG%3A3857&bbox=10018754.171394622,0,15028131.257091936,5009377.085697314'
		}),
		/*L.tileLayer('//{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: '&copy; <a href="//www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}),*/
		L.tileLayer('//stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}.png', {
			attribution: 'Map tiles by <a href="//stamen.com">Stamen Design</a>, <a href="//creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="//openstreetmap.org">OpenStreetMap</a> contributors, <a href="//creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
			subdomains: 'abcd',
			maxZoom: 20,
			minZoom: 0,
			label: 'Toner Lite'
		})
	];
	// var themes = 'org';
	var ctheme = 'org';
	var thmlyr=[];
	var themes2 = {
		"konflik": {
			themeTitle	: 	"TanahKita",
			layers		:	[{
								ur_group:'Masyarakat Adat',
								ur_layer:'Konflik Masyarakat Adat',
								url_json:base_url+"data_service/map/jkpp.geojson?kategori=K1&limit=-1&x_gte=95&y_gte=-11&y_lte=11",
								style:style_kma
							},
							{
								ur_group:'Masyarakat Adat',
								ur_layer:'Konflik Non Masyarakat Adat',
								url_json:base_url+"data_service/map/jkpp.geojson?kategori=&limit=-1&x_gte=95&y_gte=-11&y_lte=11",
								style:style
							}]

		}
	};
	var ctheme2 = 'konflik';
	var themes = {
		"org": {
			themeTitle	: 	"TanahKita",
			json_url	: 	base_url+"data_service/map/jkpp.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			json_url2	: 	base_url+"data_service/map/jkpp.html?tipe=list_data&limit=10&x_gte=95&y_gte=-11&y_lte=11",
			//json_url_2	: 	"form/gis/penduduk_get/poly/",
			col_tipe	:	"tipe_org",
			legend:{
				range	:	['BNNP', 'BNNK'],
				size	: 	[8, 5],
				text	: 	['AIRPORT', 'MANUFACTURE','KESEHATAN','PENDIDIKAN','POWER PLANT'],
				color	: 	["red", "blue","yellow","green","orange"],//"#BD0026", "#2b8786"
				title	: 	"TIPE"
			}
		}
	};
	
	var mapbg = false;
	var polyLayer,pointLayer;
	var layer_konflik;
	var param = '';
	var theme = themes[ctheme];
	var theme2 = themes2[ctheme2];
	
	var map;
	var layerControl,layerControlWa;
	var wikera_url = wms_url+'cgi-bin/mapserv?map=../map/jkpp.map&';
	var source,layerControlWms,layerControlWms2;
	
	var wk = {
		"wk_group":[
		{
			'id':'potensi',
			'title':'Potensi',
			'url':	base_url+"data_service/map/tora_piaps_potensi.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			'style':styleTora,
		},
		{
			'id':'usulan',
			'title':'Usulan Masyarakat',
			'url':	base_url+"data_service/map/tora_piaps_usulan.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			'style':styleTora,
		},
		{
			'id':'realisasi',
			'title':'Realisasi',
			'url':	base_url+"data_service/map/tora_piaps_realisasi.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			'style':styleTora,
		}
		],
		"wk_legend":base_url+"data_service/map/tora_piaps_legend.html"
	};
	var akkm_group = [
		{
			'id':'usulan',
			'title':'Usulan Masyarakat',
			'url':	base_url+"data_service/akkm/akkm.geojson?kategori=K2&limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			'style':styleAkkm
		},
		{
			'id':'realisasi',
			'title':'Realisasi',
			'url':	base_url+"data_service/akkm/akkm.geojson?kategori=K1&limit=-1&x_gte=95&y_gte=-11&y_lte=11",
			'style':styleAkkm
		}
	];
	
	var Wa_Pengakuan = L.featureGroup([new L.GeoJSON.AJAX("data/brwa/wa", 
		{
			minZoom: 7,
			style: style4line,
			onEachFeature: onEachFeatureWa,
			pointToLayer: function (feature, latlng) {
				return L.circleMarker(latlng, style);
			}
		})]);
	/*var Akkm = L.featureGroup([new L.GeoJSON.AJAX(base_url+"data_service/akkm/akkm.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11", 
		{
			minZoom: 7,
			style: style4line,
			onEachFeature: onEachFeatureAkkm,
			pointToLayer: function (feature, latlng) {
				return L.circleMarker(latlng, style);
			}
		})]);*/
		
	function init(){
		
		map	=	L.map('map', {zoomControl:true});
		
		map.zoomControl.setPosition('topright');
		
		map.addControl(L.control.basemaps({
			basemaps	:	basemaps,
			tileX		:	0,
			tileY		:	0,
			tileZ		:	1
        }));
		
		map.fitBounds([
			[-8,94],
			[6,141]
		]);

		var options = {'transparent': true,'format': 'image/png','info_format':'text/html','tiled':true};
		source = L.WMS.source(wikera_url, options);
		
		set_wk_layer();

		layerControlWa = L.control.groupedLayers(null, null,{label:'MASYARAKAT & WIL. ADAT',fa:'vcard-o fa-lg',groupCheckboxes: false});
		layerControlWa.addOverlay(Wa_Pengakuan,'Wil. Adat Sudah ada Perda', 'Pengakuan Wil. Adat');
		layerControlWa.addTo(map);
		
		Wa_Pengakuan.on('add', function () {
			 Wa_Pengakuan.bringToBack();
		});
		
		/*layerControlAkkm = L.control.groupedLayers(null, null,{label:'AKKM',fa:'leaf fa-lg',groupCheckboxes: false});
		layerControlAkkm.addOverlay(Akkm,'AKKM', 'Wilayah AKKM');
		layerControlAkkm.addTo(map);
		
		Akkm.on('add', function () {
			 Akkm.bringToBack();
		});*/
		
		<?=$wmsmap;?>
		<?=$wmsmap_2;?>
		map.on('click',function(e) {
			dataHide();
		});
		
		Wa_Pengakuan.addTo(map);
		
		
		//set default null layer 
		// update by pete
		set_sektor();
		
		getData(false,false,false,false,'<?=$selected_tahun?>');
		
		//initial_tora_piaps(false,false,false);
		
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
	function onEachFeatureWa(feature, layer) {

		layer.bindPopup(feature.properties.nama_kewilayahan);
		layer.bindTooltip("<strong>WILAYAH ADAT</strong><BR>"+feature.properties.nama_kewilayahan||'',{permanent: false});
		layer.on({
			//mouseover: highlightFeature,
			//mouseout: resetHighlight,
			click: zoomToFeature
		});
	}
	function onEachFeatureAkkm(feature, layer) {

		layer.bindPopup(feature.properties.nama_kewilayahan);
		layer.bindTooltip("<strong>WILAYAH AKKM</strong><BR>"+feature.properties.nama_akkm||'',{permanent: false});
		if (feature.properties){
			var arr_data			=	feature.properties;			
			layer.bindPopup("<div class='pop-tipe'>"+arr_data.nama_akkm+"</div><div class='row'><div class='col-sm-12' style='margin-top:5px;'>"+arr_data.status_akkm+"</div></div><div class='row'><div class='col-sm-12'><p align='justify'>"+arr_data.short_narasi+"</p></div></div><div class='row'><div class='col-sm-12'><a href='data_detail/akkm/index/"+feature.properties.id_enc+"'><button class='btn btn-primary btn-block btn-sm'>View Detail</button></a></div></div>")
		}

		layer.on({
			//mouseover: highlightFeature,
			//mouseout: resetHighlight,
			click: zoomToFeature
		});
	}
	function set_sektor(){
			sektor	=	$("#sektor").val() || new Array();
			
			if(sektor=='Semua' || sektor=="" || sektor==""){
				//$(".ck_sektor").prop('checked',true);
				$(".ck_sektor").prop('checked',false);
			}else{
				$(".ck_sektor").prop('checked',false);
				if(sektor.length>0){
					//var arr_sektor=sektor.split(",");
					$.each(sektor,function(i,val){
						//alert("#ck_sektor_"+val);
						$("#ck_sektor_"+val).prop("checked",true);
					});
				}
		}	
	}
	
	
	function set_wk_layer(){
		var layer=[];var layer2=[];
		var wk_group = wk.wk_group;
		var wk_legend = wk.wk_legend;
		for(var i=0;i<wk_group.length;i++) {
			layer.push({"ur_group":wk_group[i].title+" <span id='"+wk_group[i].id+"'></span>","json_url":wk_group[i].url+"&tora=1","ur_layer":"TORA","style":wk_group[i].style});
			layer.push({"ur_group":wk_group[i].title+" <span id='"+wk_group[i].id+"'></span>","json_url":wk_group[i].url+"&piaps=1","ur_layer":"PERHUTANAN SOSIAL","style":wk_group[i].style});
			layer.push({"ur_group":wk_group[i].title+" <span id='"+wk_group[i].id+"'></span>","json_url":wk_group[i].url+"&hutan_adat=1","ur_layer":"HUTAN ADAT","style":wk_group[i].style});
			layer2.push({"ur_layer":"dummy"});
			layer2.push({"ur_layer":"dummy"});
			layer2.push({"ur_layer":"dummy"});
		}
		for(var i=0;i<akkm_group.length;i++) {
			layer.push({"ur_group":akkm_group[i].title+" <span id='"+akkm_group[i].id+"'></span>","json_url":akkm_group[i].url+"&z=11","ur_layer":"AKKM","style":akkm_group[i].style});
		}
				
		wkOverlays={"WILAYAH KELOLA":{"a":false}};
		wkOverlays={
			"WILAYAH KELOLA":{"x":false}
		};
		var options = {
		  label:'WILAYAH KELOLA',
		  fa:'object-ungroup fa-lg',
		  exclusiveGroups: ["WILAYAH KELOLA"],
		  groupCheckboxes: true
		};
		layerControl = L.control.groupedLayers(null, null, options);
		layerControl.addTo(map);
		
		$(".a-layer-group").each(function(i,val){
			//$(this).data('layer');
			var layer_id=$(this).data("layer");
			var layer_detail=JSON.parse(decodeURIComponent($(this).data("layer-detail")));
			var test=new L.LayerGroup();
			$.each(layer_detail,function(i,val){
				//layer_dtl[i]=source.getLayer(val);
				test.addLayer(source.getLayer(val));
			});
			layer_wms_group[layer_id]=test;
			layerControl.addOverlay(layer_wms_group[layer_id], layer_id,"Program Pemerintah");
		});

		for(var i=0;i<layer.length;i++) {
			(function(i) {
				var lyr;var lyr2;
				//var lyrx=new Array();
				$.getJSON(layer[i].json_url,function(data,status){
					lyr = L.geoJson(data,{style :layer[i].style,onEachFeature : onEachFeatureTora,pointToLayer: function (feature, latlng) {
						return L.circleMarker(latlng, layer[i].style);
					}});
					//wkOverlays['WILAYAH KELOLA'][layer[i].ur_layer] = 
					//lyrx[layer[i].ur_group][]=lyr;
					layerControl.addOverlay(lyr, layer[i].ur_layer,layer[i].ur_group);
					//$(data.features).each(function(key, data) {
					//	wkOverlays['WILAYAH KELOLA'][ur_layer].addData(data);
					//});
					map.addLayer( lyr );
				}); 
			})(i);
		}
		if (wk_legend) {
			$.ajax({
				url: wk_legend,
				type: 'GET',
				dataType: 'html',
				cache: false,
				//async: false,
				success: function(data){
				  $("#wk_legend").html(data);
				}
			  });
		}
	}
	function addNewFeatureToGeoJsonLayerGroup(lyr,newGeoJsonData) {
		lyr.addData(newGeoJsonData);
	}
	
	function updateFeature(lyr,updatedGeoJsonData) {
		deleteFeature(lyr,updatedGeoJsonData); // Remove the previously created layer.
		addNewFeatureToGeoJsonLayerGroup(lyr,updatedGeoJsonData); // Replace it by the new data.
	}
	
	function deleteFeature(lyr,deletedGeoJsonData) {
		var deletedFeature = myFeaturesMap[deletedGeoJsonData.properties.objectID];
		lyr.removeLayer(deletedFeature);
	}
	function dataHide(){
		$("#data-container").slideUp("fast",function(){
		$("#data-list-small").slideDown("fast")}
	)}
	function dataShow(){
		$("#data-container").slideDown();
		$("#data-list-small").slideUp();
		$("#detil-container").slideUp()
	}
	function legendTheme() {
		var text = theme.legend['text'];
		var colors = theme.legend['color'];
		var num = Math.min(colors.length,text.length);
		
		/*
		document.getElementById("map_legend_title").innerHTML=theme.legend.title;
		var ldiv = document.getElementById("map_legend");
		
		while (ldiv.hasChildNodes() && ldiv.childNodes.length > 1) {  
			ldiv.removeChild(ldiv.lastChild);
		}

		for(var i=0;i<num;i++) {
			var dataLegend	=	document.createElement("i");
			var dataLabel 	=	document.createTextNode(text[i]);
			var dataSpace 	=	document.createElement("br");
			dataLegend.setAttribute('style', 'background:'+colors[i]);
			ldiv.appendChild(dataLegend);
			ldiv.appendChild(dataLabel);
			ldiv.appendChild(dataSpace);
		}
		*/
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
	
	function getLayerKonflik(kd_prop,id_kabupaten,sektor,konflik,tahun){
		var kd_prop_val			=	kd_prop?kd_prop:false;
		var id_kabupaten_val	=	id_kabupaten?id_kabupaten:false;
		var sektor_val			=	sektor?sektor:false;
		var	konflik_val			=	konflik?konflik:false;
		var	tahun_val			=	tahun?tahun:0;
		legendTheme();
		
		dataShow();
		//console.log(pointLayer);
		pointLayer=pointLayer || new Array();
		//console.log(pointLayer);
		if (map.hasLayer(pointLayer[sektor])) {
			map.removeLayer(pointLayer[sektor]);
			//return;
		}
		
		var q	=	"&kd_prop="+kd_prop_val+"&kd_kab="+id_kabupaten_val+"&sektor="+sektor_val+"&konflik="+konflik_val+"&tahun="+tahun_val;
		
		$.getJSON(theme['json_url']+q,function(data){
			
			$("#konflik_val").text(data.konflik+" Konflik");
			$("#dampak_val").text(data.dampak+" Jiwa");
			$("#luas_val").text(data.luas+" Ha");
			$("#investasi_val").text(data.investasi);
			
			pointLayer[sektor]=L.geoJson(data,{
				style: style,
				onEachFeature: onEachFeaturePoint,
				pointToLayer: function (feature, latlng) {
					return L.circleMarker(latlng, style);
				}
			}).addTo(map);
			
			//map.fitBounds(pointLayer[sektor].getBounds());
			
		});
		
		
		$.get(theme['json_url2']+q,function(data_html,status){
			if(status=="success"){
				$("#ter").html("Loading...");
				$("#ter").html(data_html);
			}
		});
		
		/*map.on('zoomend', function() {
			var currentZoom = map.getZoom();
			var myRadius = currentZoom; //or whatever ratio you prefer
			pointLayer.setStyle({radius: myRadius});
		});*/
	}
	
	
	function getData(kd_prop,id_kabupaten,sektor,konflik,tahun){
		$("#loader").removeClass("hide");
		var kd_prop_val			=	kd_prop?kd_prop:false;
		var id_kabupaten_val	=	id_kabupaten?id_kabupaten:false;
		var sektor_val			=	sektor?sektor:false;
		var	konflik_val			=	konflik?konflik:false;
		var	tahun_val			=	tahun?tahun:0;
		legendTheme();
		
		dataShow();
		
		/*if (map.hasLayer(pointLayer)) {
			map.removeLayer(pointLayer);
		}*/
		
		var q	=	"&kd_prop="+kd_prop_val+"&kd_kab="+id_kabupaten_val+"&sektor="+sektor_val+"&konflik="+konflik_val+"&tahun="+tahun_val;
		
		/*$.getJSON(theme['json_url']+q,function(data){
			
			$("#konflik_val").text(data.konflik+" Konflik");
			$("#dampak_val").text(data.dampak+" Jiwa");
			$("#luas_val").text(data.luas+" Ha");
			$("#investasi_val").text(data.investasi);
			
			pointLayer=L.geoJson(data,{
				style: style,
				onEachFeature: onEachFeaturePoint,
				pointToLayer: function (feature, latlng) {
					return L.circleMarker(latlng, style);
				}
			});//.addTo(map);
			
			map.fitBounds(pointLayer.getBounds());
			
		});*/
		
		
		$.get(theme['json_url2']+q,function(data_html,status){
			if(status=="success"){
				$("#ter").html("Loading...");
				$("#ter").html(data_html);
			}
		});
		
		var loader=0;
		var total={'konflik_val':0,'dampak_val':0,'luas_val':0,'investasi_val':0};
		for(var i=0;i<theme2['layers'].length;i++) {
			(function(i) {
				$.getJSON(theme2['layers'][i].url_json+q, function (data) {
					loader++;
 					if (map.hasLayer(theme2['layers'][i].lyr)) {
						theme2['layers'][i].lyr.clearLayers();
						theme2['layers'][i].lyr.addData(data);
						
						zoomToFeature(theme2['layers'][i].lyr);
						//var bounds = theme2['layers'][i].lyr.getBounds(); 
						///if (bounds.isValid()) map.fitBounds(bounds,{maxZoom:10});
					}
					else {
						theme2['layers'][i].lyr = L.geoJson(data,{
							style: theme2['layers'][i].style,
							onEachFeature: onEachFeaturePoint,
							pointToLayer: function (feature, latlng) {
								return L.circleMarker(latlng, style);
							}
						});
						layerControlWa.addOverlay(theme2['layers'][i].lyr, theme2['layers'][i].ur_layer,theme2['layers'][i].ur_group);				
						
						
					}
					/*theme2['layers'][i].lyr.on('add', function () {
						var bounds = theme2['layers'][i].lyr.getBounds(); 
						if (bounds.isValid()) map.fitBounds(bounds,{maxZoom:10});
					});*/
					theme2['layers'][i].lyr.addTo(map);
					total.konflik_val+=parseInt(data.konflik);
					total.dampak_val+=parseFloat(data.dampak);
					total.luas_val+=parseFloat(data.luas);
					total.investasi_val+=parseFloat(data.investasi);
					$("#konflik_val").text(total.konflik_val+" Konflik");
					$("#dampak_val").text(new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 12 }).format(total.dampak_val)+" Jiwa");
					$("#luas_val").text(new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 12 }).format(total.luas_val)+" Ha");
					$("#investasi_val").text(total.investasi_val);
					
					//theme2['layers'][i].lyr.addTo(map);
					if (loader==theme2['layers'].length) $("#loader").addClass("hide");
				});
			})(i);
		}
		
		for(var i=0;i<wk_group.length;i++) {
			(function(i) {
				var wk_id=wk_group[i].id;//alert(base_url+"home/getjumlahwk/"+wk_id+"?d="+q);
				$.get(base_url+"home/getjumlahwk/"+wk_id+"?d="+q,function(data_html,status){
					$("#"+wk_id).text("...");
					if(status=="success"){
						$("#"+wk_id).text("("+data_html+")");
					}
				});
			})(i);
		}
		
		/*map.on('zoomend', function() {
			var currentZoom = map.getZoom();
			var myRadius = currentZoom; //or whatever ratio you prefer
			pointLayer.setStyle({radius: myRadius-2});
		});*/
	}
	
	L.Map.prototype.panToOffset = function (latlng, offset, options) {
		var x = this.latLngToContainerPoint(latlng).x - offset[0]
		var y = this.latLngToContainerPoint(latlng).y - offset[1]
		var point = this.containerPointToLatLng([x, y])
		return this.setView(point, this._zoom, { pan: options })
	}
	
	var tora_piaps_layer;
	
	function initial_tora_piaps(val_tora,val_piaps,val_hutan_adat){
		
		var value_tora		=	val_tora==1?val_tora:false;
		var value_piaps		=	val_piaps==1?val_piaps:false;
		var value_hutan_adat=	val_hutan_adat==1?val_hutan_adat:false;
		
		var url_key	=	"&tora="+value_tora+"&piaps="+value_piaps+"&hutan_adat="+value_hutan_adat;
		
		var tora_piaps_url	=	base_url+"data_service/map/tora_piaps.geojson?limit=-1&x_gte=95&y_gte=-11&y_lte=11"+url_key;
		
		$.getJSON(tora_piaps_url,function(data_tora,status){
			
			if (tora_piaps_layer) {
				map.removeLayer(tora_piaps_layer);
			}
			
			tora_piaps_layer	=	L.geoJson(data_tora,{
										style			:	styleTora,
										onEachFeature	:	onEachFeatureTora
									}).addTo(map);
			
			tora_piaps_layer.bringToBack();
			
			map.fitBounds(tora_piaps_layer.getBounds());
			
		}); 
		
	}
	
	function resetStyle(t_layer) {
		t_layer.eachLayer(function (layer) {  
			t_layer.resetStyle(layer);
		});
	}
	
	function styleAkkm(feature) {
		return {
			fillColor: 'orange',
			radius: 7,//map.getZoom()-2,//getSize(feature.properties.tipe),
			weight: 1,
			opacity: 1,
			color: '#777',
			fillOpacity: 0.7
		};
	}
	
	function style(feature) {
		return {
			fillColor: feature.properties.warna_sektor,
			radius: 4,//map.getZoom()-2,//getSize(feature.properties.tipe),
			weight: .5,
			opacity: 1,
			color: '#777',
			fillOpacity: 0.7
		};
	}
	function style_kma(feature) {
		return {
			fillColor: feature.properties.warna_sektor,
			radius: 6,//map.getZoom(),//getSize(feature.properties.tipe),
			weight: 1,
			opacity: 1,
			color: 'red',
			fillOpacity: 1
		};
	}
	
	function styleTora(feature) {
		return {
			fillColor	: 	getToraColor(feature.properties.kode),
			radius		:   4,
			weight		: 	2,
			opacity		: 	1,
			color		: 	getToraColor(feature.properties.kode),
			dashArray	: 	'3',
			fillOpacity	:	0.5
		};
	}
	
	function getToraColor(kode_tora){
		
		var tora_color;
		
		if(kode_tora=="TORA"){
			tora_color	=	"#ff0000";
		}else if(kode_tora=="PIAPS"){
			tora_color	=	"#0000ff";
		}else{
			tora_color	=	"#009900";
		}
		
		return tora_color;
	}
	
	
	function onEachFeatureTora(feature, layer) {
		if (feature.properties){
			
			var arr_data			=	feature.properties;
			
			var jenis_wilayah		=	arr_data.kode_jns_wikera;
			
			var nama_jenis_wilayah;
			
			if (jenis_wilayah) {
				if(jenis_wilayah=="TORA"){
					nama_jenis_wilayah	=	"Tanah Objek Reforma Agraria";
				}else if(jenis_wilayah=="PIAPS"){
					nama_jenis_wilayah	=	"Perhutanan Sosial";
				}else{
					nama_jenis_wilayah	=	"Hutan Adat";
				}
				layer.bindTooltip("<strong>"+nama_jenis_wilayah+"</strong><BR>Nama Wilayah Kelola: "+arr_data.nama_wikera,{permanent: false});
				layer.bindPopup("<div class='pop-tipe'>"+arr_data.nama_wikera+"</div><div class='row'><div class='col-sm-12' style='margin-top:5px;'>"+nama_jenis_wilayah+"</div></div><div class='row'><div class='col-sm-12'><p align='justify'>"+arr_data.short_narasi+"</p></div></div><div class='row'><div class='col-sm-12'><a href='data_detail_usulan/index/"+feature.properties.id_enc+"'><button class='btn btn-primary btn-block btn-sm'>View Detail</button></a></div></div>")
			}
			else {
				layer.bindTooltip("<strong>AKKM</strong><BR>Nama Wilayah: "+arr_data.nama_akkm,{permanent: false});
				layer.bindPopup("<div class='pop-tipe'>"+arr_data.nama_akkm+"</div><div class='row'><div class='col-sm-12' style='margin-top:5px;'>"+arr_data.status_akkm+"</div></div><div class='row'><div class='col-sm-12'><p align='justify'>"+arr_data.short_narasi+"</p></div></div><div class='row'><div class='col-sm-12'><a href='data_detail/akkm/index/"+feature.properties.id_enc+"'><button class='btn btn-primary btn-block btn-sm'>View Detail</button></a></div></div>")
	
			}
		}
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
		//pointLayer.resetStyle(e.target);
		for(var i=0;i<theme2['layers'].length;i++) {
			theme2['layers'][i].lyr.resetStyle(e.target);
		}
	}
	
	function zoomToFeature(e) {
		var bounds = e.target?e.target.getBounds():e.getBounds();
		if (bounds.isValid()) map.fitBounds(bounds);
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
		if (feature.properties) {  
			var kat = feature.properties.kategori;
			var text_kat='-';
			switch(kat) {
				case 'K1':
					text_kat='Masyarakat Adat';
					break;
				case 'K2':
					text_kat='Non Masyarakat Adat';
					break;
			}
			layer.bindTooltip("<strong>KONFLIK</strong><BR>Sektor: "+feature.properties.nama_sektor+"<BR>"+feature.properties.judul+"<BR>"+text_kat||'',{permanent: false});
			layer.bindPopup("<div class='pop-tipe'>"+feature.properties.judul+"</div><div class='row' style='margin-top:10px;'><div class='col-sm-12'><center><span class='badge' style='background-color:"+feature.properties.warna_sektor+"'>Sektor "+feature.properties.nama_sektor+"</span></center></div></div><div class='row'><div class='col-sm-12'><p align='justify'>"+feature.properties.short_narasi+"<br /></p><table class='table table-condensed'><tr><td width='50'>Konflik</td><td style='color:#5B5BF4;'>"+feature.properties.kd_konflik+"</td></tr><tr><td width='50'>Kategori</td><td style='color:#5B5BF4;'>"+text_kat+"</td></tr><tr><td>Tahun</td><td style='color:#5B5BF4;'>"+feature.properties.tahun+"</td></tr></table></div></div><div class='row'><div class='col-sm-12'><a href='data_detail/index/"+feature.properties.id_enc+"' target='_blank'><button class='btn btn-primary btn-block btn-sm'>View Detail</button></a></div></div>", {closeButton: false, offset: L.point(0, 0)});
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

<link rel="stylesheet" href="assets/js/additional_js/pnotify/pnotify.custom.min.css">
<script src="assets/js/additional_js/pnotify/pnotify.custom.min.js"></script>

<style>
	#map{
		border:thin solid #CCCCCC;
	}
    .right-side .isi_layanan{
        margin-top:10px;
        margin-bottom:5px;
				border-bottom:1px solid #eee
    }
		.right-side .row:last-child .isi_layanan{
				border-bottom:0px solid #ddd
    }
    .isi_layanan a{
        font-weight: bolder;
        font-size: 18px;
        color:dimgray;
    }
    .isi_layanan a img{
        width: 50px;
        height: 50px;
    }
    .isi_layanan p{
        color:grey;
    }
    .box-3{
		background:#E5E5E5;
		padding-top:15px;
		padding-bottom:15px;
		border-radius:3px;
	}
	p.caption_title{
		margin-top:-15px;
		padding:2px 3px;
		background-color:#817E7E;
		opacity:0.55;
		color:#ffffff;
		font-size:14px;
		font-weight:bolder;
	}
	h4.news_title{
		font-size:14px;
		color:#5656EA;
		font-weight:bold;
	}
	.news_content{
		background-color:#F0F0F1;
		padding:10px;
		border-radius:2px;
		margin-left:5px;
		margin-right:5px;
	}
	.news_separator{
		border-bottom:thin solid #CCC;
		margin-bottom:5px;
	}
	.total{
		font-size:24px;font-weight:bold;font-family:;
	}
</style>
    <div class="well well-sm xhead" style="margin-top:-4px;margin-bottom:-10px;">
        <div class="container">
    		<div class="row">
        		<div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="box-title" style="padding-left:15px;ext-transform:uppercase"><strong>PETA SEBARAN KONFLIK & WILAYAH KELOLA</strong></h6>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-inline" style="float:right !important">
                                <div class="form-group col-xs-inline-block">
                                    <label for="tahun">Tahun</label>
                                    <select id="tahun" name="tahun" class="form-control">
                                        <option value="">Semua</option>
                                        <?php foreach($tahun as $k=>$v): ?>
                                        <option value="<?=$v?>" <?=($selected_tahun==$v)?"selected":""?>><?=$v?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button id="btn_search" class="btn btn-white"><i class="fa fa-search"></i></button>
                                <button id="btn_reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-refresh"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="rows" style="position:absolute; width:100%">
        <div class="col-sm-12" style="position:relative">
                <div class="container">
                <div id="box-data" class="box-data" style="position:absolute; z-index:1011; margin-left:10px; top:60px; width:300px; height: auto; background:transparent">
                    <ul class="nav nav-tabs" id="myTab" style="margin:0; background:transparent; margin-top:-42px">
                        <li class="active"><a href="#jkpp"><i class="fa fa-list-ul"></i></a></li>
                        <li><a href="#data_konflik"><i class="fa fa-search"></i></a></li>
                        <li><a href="#data_tora" class="hidden"><i class="fa fa-globe"></i></a></li>
                        <li><a href="#data_sektor"><i class="fa fa-circle"></i> &nbsp;Konflik</a></li>
                    </ul>
                    
                    <div class="tab-content" id="data_box" style=" background:transparent;margin:0; margin-top:-5px; padding:0px">
                        <div class="tab-pane active" id="jkpp">
                            <div class="panel-group " role="tablist" aria-multiselectable="true">
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="position:relative; padding-top:10px">
                                        <p class="panel-title" align="justify">
                                            Data Konflik
                                        </p>
                                        <div style="padding-bottom:10px">
                                        <table class="table table-condensed table-striped table-stats" style="margin-bottom:0">
											 <tr>
												 <th>Total Konflik</th>
												 <th>Korban</th>
												 <th>Total Luas</th>
											 </tr>
											 <tr>
												 <td style="align:center" id="konflik_val"></td>
												 <td style="align:center" id="dampak_val"></td>
												 <td style="align:center" id="luas_val"></td>
											 </tr>
										 </table>
										 </div>
										 <p class="panel-title" align="justify">
                                            Wilayah Kelola
                                        </p>
										 <div id="wk_legend">
                            
                    					 </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="tab-pane" id="data_konflik">
                            <form id="fdata" class="form-horizontal">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                
                                  <div class="panel panel-default">
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
                                                <option value="<?=$k?>" <?=($kd_propinsi==$k)?"selected":""?>><?=strtoupper($v)?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?=form_dropdown("id_kabupaten",$lookup_pilih,0,"id='id_kabupaten' class='form-control'");?>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne" style="position:relative; padding-top:10px">
                                      <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" data-title="KONFLIK:" href="#acc_fk" aria-expanded="true" aria-controls="acc_fk">
                                          KONFLIK: <span class="acctext"></span>
                                        </a>
                                      </h4>
                                    </div>
                                    <div id="acc_fk" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                      <div class="panel-body">
                                        <?php
                                            //$lookup_strip[""]="Semua";
                                            $lookup_konflik=lookup("m_konflik","uraian","uraian","","order by order_num");
                                            //$lookup_sektor=$lookup_strip+lookup("m_sektor","kode","uraian","","order by order_num");								
											$lookup_sektor=lookup("m_sektor","kode","uraian","","order by order_num");
                                        ?>
                                        <? echo form_dropdown("sektor[]",$lookup_sektor,$key,"id='sektor' style='width:100%;' multiple class='form-control'");?>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="panel panel-default hidden">
                                    <div class="panel-heading" role="tab" id="headingOne" style="position:relative; padding-top:10px">
                                      <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" data-title="KONFLIK:" href="#acc_konflik" aria-expanded="true" aria-controls="acc_konflik">
                                          KONFLIK: <span class="acctext"></span>
                                        </a>
                                      </h4>
                                    </div>
                                    <div id="acc_konflik" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingZero">
                                      <div class="panel-body">
                                        <? //echo form_dropdown("konflik",$lookup_konflik,$key,"id='konflik' class='form-control'");?>
                                        <? //echo form_dropdown("konflik",$lookup_pilih,$key,"id='konflik' class='form-control'");?>
                                        <?=form_dropdown("kd_konflik[]",$lookup_konflik,$key,"id='konflik' style='width:100%' multiple='multiple'  class='form-control '");?>
                            
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="panel panel-default hidden">
                                    <div class="panel-heading" role="tab" id="headingOne" style="position:relative; padding-top:10px">
                                      <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" data-title="TAHUN:" href="#acc_tahun" aria-expanded="true" aria-controls="acc_tahun">
                                          TAHUN: <span class="acctext"></span>
                                        </a>
                                      </h4>
                                    </div>
                                    <div id="acc_tahun" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingZero">
                                      <div class="panel-body">
                                      
                                        <select id="tahun" name="tahun" class="form-control">
                                            <?php foreach($tahun as $k=>$v): ?>
                                            <option value="<?=$v?>"><?=$v?></option>
                                            <?php endforeach; ?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div id="button-block" style="background:#fff;margin-top:-5px; border-top:1px solid #ccc; position:absolute; width:100%; z-index:1001; display:none">
                                    <div class="btn-group btn-group-justifieds" role="group" aria-label="...">
                                      <div class="btn-group" role="group">
                                        <button id="myButton" type="button" class="btn" style="background:#fff"><i class="fa fa-search"></i> &nbsp;CARI </button>
                                      </div>
                                      <div class="btn-group" role="group">
                                        <button id="myReset" type="button" class="btn" style="background:#fff"><i class="fa fa-remove"></i> &nbsp;RESET </button>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div id="button-blockx" style="max-height:130px;overflow:auto;padding-top:10px;margin-top:40px;background:#fff; width:100%; z-index:10000; display:none">
                                    <div class="btn-group btn-group-justifieds" role="group" aria-label="...">
                                      <div class="tex btn-group" role="group">
                                        <b>&nbsp;&nbsp;&nbsp;Hasil Pencarian:</b>
                                      </div>
                                    </div>
                                  </div>
                                
                                </div>

                                <div id="all-container" class="hiddens">
                                    <div id="data-list-small"><a><i class="fa fa-list-ul"></i> &nbsp; Lihat Hasil Pencarian</a></div>
                                    <div id="data-container">
                                        <div id="data-list" style="max-height:150px">
                                            <ul id="ter" class="list-group" style="margin-left:0px;">	
                                                <li class="lop">Loading...</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="detil-container">
                                        <div id="data-detil"></div>
                                        <div id="data-detil-stats">
                                                <a href="" class="btns open_detil" style="background:#fff"><i class="fa fa-search"></i> &nbsp;Report Lengkap Kota</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="data_tora" class="hidden">
                            <div class="panel-group" role="tablist" aria-multiselectable="true">
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="position:relative; padding-top:10px">
                                        <h5 class="panel-title">
                                           Wilayah Kelola
                                        </h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="hidden">Jenis Wilayah Kelola</label>
                                                    <div id="check_jenis_wilayah">
                                                        <input type="checkbox" id="check_tora1" />&nbsp;TORA<br />
                                                        <input type="checkbox" id="check_tora2" />&nbsp;Perhutanan Sosial<br />
														<input type="checkbox" id="check_tora3" />&nbsp;Hutan Adat
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="data_sektor">
                            <div class="panel-group" role="tablist" aria-multiselectable="true">
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="position:relative; padding-top:10px">
                                        <h5 class="panel-title">
                                            Konflik
                                        </h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="data-list-sektor" style="max-height:130px">
                                                    <table class="table table-condensed">	
                                                        <!--<li>Loading...</li>-->
                                                        <input type="hidden" id="txt_sektor" name="txt_sektor" value="" />	
                                                        <?php if(cek_array($data_sektor)): ?>
                                                            <?php foreach($data_sektor as $k=>$v): ?>
                                                                <tr>
                                                                	<td> <input type="checkbox" id="<?="ck_sektor_".$v["kode"]?>" class="ck_sektor" value="<?=$v['kode']?>" /></td>
                                                                    <td>
                                                                        <a href="#" class="sektor_badge" data-sektor="<?=$v['kode']?>">
                                                                            <span class="badge" style="background-color:<?=$v['color']?>">
                                                                                &nbsp;
                                                                            </span>
                                                                            &nbsp;<?=$v['uraian']?>
                                                                        </a>
                                                                    </td>
                                                                    <td align="right">
                                                                        <i id="checking<?=$v['kode']?>" class="sektor_check fa"></i>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                        
                                                    </table>
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


    <div class="row" style="margin-left:0; margin-right:0">
        <div class="col-sm-12 col-xs-12" style="padding-left:0; padding-right:0">
            <div id="map-wrapper" style="padding-top:10px">
                <div id="map" style="height:85.2vh; position:relative">
                    <div id="loader" class="hide" style="position:absolute; z-index:10000; opacity:.6; width:100%; height: 100vh; background:#eee; text-align:center">Loading</div>
                </div>
            </div>
        </div>				
    </div>
    <!-- LAYER OVERLAY USING DIV ADD BY PETE BUT HIDDEN--> 
    <div class="row hidden">
    	<div class="col-md-6">
        	<? 
				$arrData=$this->wms_data;
			 ?>
             <table>
             <? foreach($arrData as $x=>$val):?>
             	<tr>
                	<td><input type="checkbox" class="ck_wms" value="<?=$val["kd_layer"]?>" /> <a href="javascript:void(0)" class="a-layer" data-group='<?=$val['kd_group']?>' data-layer='<?=$val["kd_layer"]?>'><?=$val["ur_layer"]?></a></td>
                </tr>
			 <? endforeach;?>
             </table>
             
        </div>
        
        <div class="col-md-6">
        	<? 
				$arrData=$this->wms2_data;
			 	foreach($arrData as $x=>$val):
					$groupData[$val["kd_group2"]][]=$val["kd_layer"];
					$groupDataName[$val["kd_group2"]]=$val["ur_group2"];
				endforeach;
				
			 ?>
             <table>
             <? foreach($groupData as $x=>$val):?>
             	<tr>
                	<td><input type="checkbox" class="ck_wms_group" value="<?=$x?>" /> <a href="javascript:void(0)" class="a-layer-group" id="a-group-<?=$x?>" data-layer-detail="<?=rawurlencode(json_encode($val))?>" data-layer='<?=$x?>'><?=$groupDataName[$x]?></a></td>
                </tr>
			 <? endforeach;?>
             </table>
             
        </div>
    </div>
<script>
	var layer_wms=new Array();
	$(function(){
		$(".a-layer").click(function(e){
			e.preventDefault();
			
			//alert($(this).data('group'));
			
			var ckbox=$(this).closest("tr").find(".ck_wms")
			var layer_id=$(this).data("layer");
			if(map.hasLayer(layer_wms[layer_id])){
				map.removeLayer(layer_wms[layer_id]);
				ckbox.prop('checked',false);
			}else{
				layer_wms[layer_id]=source.getLayer(layer_id);
				map.addLayer(layer_wms[layer_id]);
				ckbox.prop('checked',true);
			}	
		});
		
		$(".ck_wms").click(function(e){
			//e.preventDefault();
			$(this).closest("tr").find(".a-layer").click();
		});
	});
	
	
	
	var layer_wms_group=new Array();
	var layer_dtl=new Array();
	$(function(){
		$(".a-layer-group").click(function(e){
			e.preventDefault();
			
			var ckbox=$(this).closest("tr").find(".ck_wms_group")
			var layer_id=$(this).data("layer");
			var layer_detail=JSON.parse(decodeURIComponent($(this).data("layer-detail")));
			console.log(layer_detail);
			
			var layer_obj=layer_wms_group[layer_id];
			
			if(map.hasLayer(layer_obj)){
				map.removeLayer(layer_obj);
				ckbox.prop('checked',false);
			}else{
				
				var test=new L.LayerGroup();
				$.each(layer_detail,function(i,val){
					layer_dtl[i]=source.getLayer(val);
					test.addLayer(source.getLayer(val));
				});
				layer_wms_group[layer_id]=test;
				map.addLayer(layer_wms_group[layer_id]);
				ckbox.prop('checked',true);
			}	
		});
		
		$(".ck_wms_group").click(function(e){
			//e.preventDefault();
			$(this).closest("tr").find(".a-layer-group").click();
		});
	});
</script>
    
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
	
	
	$("#kd_prop").change(function(){
		$("#id_kabupaten").html('<option>--loading--<option>');
		var kd_prop=$("#kd_prop option:selected").val()||$("#kd_prop").val();
		kd_prop=kd_prop?kd_prop:'x';
		$.get("home/lookup_kota/"+kd_prop,function(ret){
			$("#id_kabupaten").html(ret);
		});
	});
	$("#konflik").select2();
	$("#sektor").select2();
	// $("#sektor").change(function(){
		// $("#konflik").select2("val", "");
		// var sektor=$("#sektor option:selected").val()||$("#sektor").val();
		// sektor=sektor?sektor:'x';
		// $.get("home/lookup_konflik_admin/"+sektor,function(rets){
			// $("#konflik").html(rets);
		// });
	// });
	
	
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
					if ($(this).val()!="" || $(this).text()!='Semua') text.push($(this).text());
				});
				heading.html("WILAYAH: <BR>- "+"<span class='acctext'>"+text+"</span>");
			}
			else if (openid=='acc_fk') {
				var param = $("#"+openid).find('.form-control :checked');
				param.each(function(){
					if ($(this).val()!="" || $(this).text()!='Semua') text.push($(this).text());
				});
				text = text.join(" <BR>- ");
				heading.html("KONFLIK: <br>- "+"<span class='acctext'>"+text+"</span>");
			}
			else if (openid=='acc_tahun') {
				var param = $("#"+openid).find('.form-control :checked');
				param.each(function(){
					if ($(this).val()!="" || $(this).text()!='Semua') text.push($(this).text());
				});
				text = text.join(" <BR>- ");
				heading.html("TAHUN: <br>- "+"<span class='acctext'>"+text+"</span>");
			}
			else{
				var param = $("#"+openid).find('.form-control :checked');
				param.each(function(){
					if ($(this).val()!="" || $(this).text()!='Semua') text.push($(this).text());
				});
				text = text.join(" <BR>- ");
				heading.html("KONFLIK: <br>- "+"<span class='acctext'>"+text+"</span>");
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
				text = "KONFLIK: <br>";
				break;
			case 'acc_konflik':
				text = "KONFLIK ";
				break;
			case 'acc_tahun':
				text = "TAHUN ";
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
	  $("#fdata").submit(function(e){
		e.preventDefault();
		//alert("test");
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
   /* top: 10px;*/
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
/*
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
*/
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
    left: 0px;
    bottom: -7px;
    z-index: 900;
    background:#fff;
    opacity:0.7;
    //min-width:500px;
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
#data-list-sektor{
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
    max-height:135px;
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


