<base href="<?=BASE_URL;?>" />
<!-- jQuery 2.1.4 -->
    <script src="assets/themes/flat/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<link href="assets/js/jvm/jquery-jvectormap.css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/jvm/jquery-jvectormap-2.0.3.min.js"></script>
<script src="assets/js/jvm/id<?=$jsmappath?>/jquery.jvm.<?=$jsmap?>.js"></script>

<style>
.nav-tabs.nav-justified > li > a {
    color: #ccc;
}
.jvectormap-legend-title {
	white-space:nowrap;
}
.jvectormap-legend-cnt-h {
    bottom: 20px;
    left: 10px;
	max-width: 180px;
}
.jvectormap-legend-cnt-v {
	top:auto!important;
    bottom: 30px!important;
    left: 0px;
	max-width:100px
}
.jvectormap-legend {
    background: transparent;
    color: #777;
    border-radius: 0px;
}
.jvectormap-legend-cnt-h .jvectormap-legend-tick {
    width: 20px;
}
.jvectormap-legend-tick-sample {
    height: 20px;
    width: 20px;
    display: inline-block;
    vertical-align: middle;
}
.jvectormap-zoomin {
    top: 20px;
}
.jvectormap-zoomout {
    top: 45px;
}
.jvectormap-zoomin, .jvectormap-zoomout {
    width: 15px;
    height: 15px;
	line-height:15px;
	background-color:#555
}
.map {
	border:1px solid #ddd;
	background-color:#eee
}
#title {
	font-weight:bold;
	text-transform:uppercase
}
#nilai {
	position:absolute; 
	z-index:998; 
	left:10px;
	bottom:10px;
	font-size:x-large;
	color:#ccc;
	font-weight:bold;
}
</style>

<div><span id="title"></span> <span class="pull-right">s/d <?=$selected_bulan?>-<?=$selected_tahun?></span></div>
<div style="position:relative;width: 100%; height: 100%">
    <div class="map" style="width: inherit; height: inherit"></div>
    <div id="nilai">Text</div>
</div>
<script>
	var id_map='<?=$jsmap?>';
  	var pid_map={<?=$jsmap?>00:"PARENT"};
  	var pid_scale={"PARENT":"rgba(0,0,0,0)"};;
  	var pid_scale2={"PARENT":2};
	var zoom2=<?=$zoom2?"'".$zoom2."'":"false"?>;
	
	var map;
	var dregion = false;
	var vmin = 0;
	var vmax = 0;
	var data_region;

	var data_konflik={id:<?=$jml_wil['id']?json_encode($jml_wil['id'],true):'false'?>,id_pop:<?=$jml_wil['id_pop']?json_encode($jml_wil['id_pop'],true):'false'?>,blbb:<?=$jml_wil['blbb']?json_encode($jml_wil['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil['colors'])?>};
	var data_dampak={id:<?=$jml_wil_dampak['id']?json_encode($jml_wil_dampak['id'],true):'false'?>,id_pop:<?=$jml_wil_dampak['id_pop']?json_encode($jml_wil_dampak['id_pop'],true):'false'?>,blbb:<?=$jml_wil_dampak['blbb']?json_encode($jml_wil_dampak['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil_dampak['colors'])?>};
	var data_lahan={id:<?=$jml_wil_lahan['id']?json_encode($jml_wil_lahan['id'],true):'false'?>,id_pop:<?=$jml_wil_lahan['id_pop']?json_encode($jml_wil_lahan['id_pop'],true):'false'?>,blbb:<?=$jml_wil_lahan['blbb']?json_encode($jml_wil_lahan['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil_lahan['colors'])?>};
	var data_investasi={id:<?=$jml_wil_investasi['id']?json_encode($jml_wil_investasi['id'],true):'false'?>,id_pop:<?=$jml_wil_investasi['id_pop']?json_encode($jml_wil_investasi['id_pop'],true):'false'?>,blbb:<?=$jml_wil_investasi['blbb']?json_encode($jml_wil_investasi['blbb'],true):'false'?>,colors:<?=json_encode($jml_wil_investasi['colors'])?>};
	var display = '<?=$selected_theme?>';
	var nilai = <?=$nilai?$nilai:'"false"'?>;
	function setData(k,d,f,t) {
		dregion = d.id.values||false;
		$("#title").html(t);
		$("#nilai").html(nilai[k]);
		if (dregion) {
			$('.map').html("");
			map=false;
			propValues = jvm.values.apply({}, jvm.values(d.id));
			
			//alert(propValues);
			//alert(JSON.stringify(dregion));
			vmin = jvm.min(propValues);
			vmax = jvm.max(propValues);
			data_region = [{
			  scale: d.colors,
			  //normalizeFunction: 'polynomial',
			  attribute: 'fill',
			  values: dregion,
			  min: vmin,
			  max: vmax<5?5:vmax,
			  /*legend: {
				  title: t||"Konflik",
				  vertical: true,
				  labelRender: function(v){
					  	if (v >= 1000000000000) {
							v = v / 1000000000000;
							u = "T";
						}
						else if (v >= 1000000000) {
							v = v / 1000000000;
							u = "M";
						}
						else if (v >= 1000000) {
							v = v / 1000000;
							u = "Jt";
						}						
						else {
							u = "";
						}
					return v.toFixed(f||0)+' '+u;
				  }
			  }*/
			},{
			  attribute: 'stroke',
			  normalizeFunction: 'polynomial',
			  scale: d.colors,
			  values: dregion,
			  min: vmin,
			  max: vmax<5?5:vmax
			},{
			  attribute: 'fill',
			  values: pid_map,
			  scale:pid_scale
			},{
			  attribute: 'stroke-width',
			  values: pid_map,
			  scale:pid_scale2
			}];
			map = new jvm.Map({
				container: $('.map'),
				map: 'id-'+id_map+'_merc',
				zoomButtons : false,
				zoomOnScroll: true,
				backgroundColor:'rgba(0,0,0,0)',
				markers: d.blbb.coords,
				series: {
					regions: data_region
				  },
				  labels: {
					  /*regions: {
						render: function(code){
							return d.id.fvalues[code];
						}
					  },*/
					  markers: {
						render: function(code){
							return d.blbb.names[code];
						}
					  }
				  },
		
				  regionLabelStyle: {
					  initial: {
						'font-family': 'Helvetica',
						'font-size': '8',
						'fill': '#333',
						'stroke':'#eee',
						'stroke-width':0.5
					  },
					  hover: {
						fill: 'black'
					  }
				  },
				  markerLabelStyle: {
					  initial: {
						'font-size': '8',
						'fill': '#333',
						'font-weight':'normal',
						'stroke-width':0.5
					  },
					  hover: {
						fill: 'black'
					  }
				  },
				  onMarkerTipShow: function(event, label, index){
						label.html(
						  '<b>'+d.blbb.names[index]+'</b><br/>'+
						  '<b>Total: </b>'+d.blbb.value[index]
						);
					  },
				  onRegionTipShow: function(event, label, code){
					  var jml = d.id.fvalues[code] || 0;
					  var p = "";
					  if (d.id_pop[code]) {
						  p = d.id_pop[code].a?"Assesment :"+d.id_pop[code].a+"<BR>":"";
						  p+= d.id_pop[code].r?"Rehabilitasi :"+d.id_pop[code].r+"<br>":"";
						  p+= d.id_pop[code].p?"Pasca :"+d.id_pop[code].p+"<br>":"";
						  p+= d.id_pop[code].s?"Outcome :"+d.id_pop[code].s:"";
					  }
					  label.html('<b>'+label.html()+'</b><div style="border-bottom:1px solid #fff">'+p+'</div><b>Total:'+jml+'</b>');
					  //label.html('<b>'+label.html()+'</b><br>Total: '+jml);
				  },
				  onRegionClick: function(event, code){
						map.setFocus({region:code});
				  },
				  markerStyle:{
					  initial: {
						fill: 'orange',
						"fill-opacity": 1,
						"stroke-width": 1,
						"stroke-opacity": 1
					  }
				  },
				regionStyle:{
				  initial: {
					fill: '#aaa',
					"fill-opacity": 0.8,
					stroke: 'none',
					"stroke-width": 0.5,
					"stroke-opacity": 0.8
				  },
				  hover: {
					"fill-opacity": 1,
					"stroke-opacity": 1,
					cursor: 'pointer'
				  }
				}
			  });
	  	}
	}
	
    $(function(){
		var d=data_konflik;
		var p=0;
		var t="Jumlah Konflik / Provinsi";
		switch(display) {
			case 'dampak':
				d=data_dampak;
				t="Dampak Konflik (jiwa)";
				break;
			case 'luas':
				d=data_lahan;
				t="Luas Konflik (Ha)";
				break;
			case 'investasi':
				d=data_investasi;
				t="Investasi (Rp)";
				p=2;
				break;
		}
		setData(display,d,p,t);
	  if (zoom2) map.setFocus({region:zoom2});
    });
  </script>
