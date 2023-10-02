<script>
var p3857 = new OpenLayers.Projection("EPSG:3857");
var gproj = new OpenLayers.Projection("EPSG:900913");
var proj = new OpenLayers.Projection("EPSG:4326");
function init() {
	map = new OpenLayers.Map({
		div: "maped",
		projection: "EPSG:900913",
		displayProjection:"EPSG:4326",
		controls:[],
		numZoomLevels: 18
	});
	scaleline = new OpenLayers.Control.ScaleLine({'maxWidth':140});
	attribution = new OpenLayers.Control.Attribution();
	//map.addControl(scaleline);
	map.addControl(new OpenLayers.Control.KeyboardDefaults());
	map.addControl(new OpenLayers.Control.Navigation({dragPanOptions: {enableKinetic: true}}));
	map.addControl(attribution);
	map.addControl(new OpenLayers.Control.MousePosition());
	map.addControl(new OpenLayers.Control.LayerSwitcher());
	
	mslayer = new OpenLayers.Layer.MapServer( "MapServer Layer",
	"http://localhost/cgi-bin/mapserv.exe",
	 {map:"../apps/_styles/1/map/world.map", layers:"all"}, 
	 {sphericalMercator:true,numZoomLevels: 19, wrapDateLine: true, singleTile: true, ratio:1} );
	//map.addLayer(mslayer);
	
	try {
			gmap = new OpenLayers.Layer.Google("Google Streets", {numZoomLevels: 22});
			map.addLayer(gmap);
			gphy = new OpenLayers.Layer.Google("Google Physical", {type: google.maps.MapTypeId.TERRAIN, numZoomLevels: 22});
			gphy.id = "g_hybrid";
			map.addLayer(gphy);
		
			
	} catch (e) {
		alert("Can't load GoogleMap");
	}
		
	
	var id_bounds = new OpenLayers.Bounds(95,-11,141,8);
	map.zoomToExtent(id_bounds.transform(proj, gproj));
}

$(document).ready(function () {
	init();
})
</script>
<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel">
  <div class="carousel-inner">
    <div id="maped" class="item active"></div>
  </div>
</div><!-- /.carousel -->

<div class="container box" style="font-size:normal; margin-top:30px;">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="content-box box-default animated fadeInUp animation-delay-10">
            	<a href="">
                    <div class="icon-title"><i class="fa fa-cubes back"></i><i class="fa fa-cubes"></i></div>
                    <h3 class="content-box-title">Layanan Data</h3>
                </a>
                <p>Layanan data, dengan akses publik maupun berbatas, mulai dari dari data demografi sampai dengan detail.</p>
                <a href=""><i class="fa fa-arrow-right" style="font-size:13px"></i> Learn more</a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="content-box box-default animated fadeInUp animation-delay-14">
            	<a href="">
                    <div class="icon-title"><i class="fa fa-globe back"></i><i class="fa fa-globe"></i></div>
                    <h3 class="content-box-title">S I G</h3>
                </a>
                <p>Menganalisis, menafsirkan, dan memahami data secara Visual untuk memetakan hubungan, pola, dan tren dalam bentuk peta</p>
                <a href=""><i class="fa fa-arrow-right" style="font-size:13px"></i> Learn more</a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="content-box box-default animated fadeInUp animation-delay-16">
            	<a href="">
                    <div class="icon-title"><i class="fa fa-line-chart back"></i><i class="fa fa-line-chart"></i></div>
                    <h3 class="content-box-title"><span style="font-weight:bold">Info</span>Grafik</h3>
                </a>
                <p>Mengkomunikasikan data melalui charts, dashboards and Data Infografik.</p>
                <a href=""><i class="fa fa-arrow-right" style="font-size:13px"></i> Learn more</a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="content-box box-default animated fadeInUp animation-delay-12">
                <a href="">
                    <div class="icon-title"><i class="fa fa-magic back"></i><i class="fa fa-magic"></i></div>
                    <h3 class="content-box-title">Showcase</h3>
                </a>
                <p>Consectetur adipisicing elit vritatis dolor rem officia molestiae atque eveniet inventore earum quas voluptates cumque</p>
                <a href=""><i class="fa fa-arrow-right" style="font-size:13px"></i> Learn more</a>
            </div>
        </div>
    </div>
</div>


<div style="background:#eee">
<div class="container" style="font-size:normal">
	<div class="row-fluid">
    	<div  class="span12">
        	<h3 style="text-indent:10px;">GIS solutions for your industry</h3>
        </div>
    </div>
</div>
</div>
<div style="padding-bottom:20px; background:#eee">
<div class="container" style="margin-bottom:0px;">
<div class="row-fluid">
<div class="span8" style="padding:0 10px">
  <div style="width:100%; height:300px; background: url(assets/image/sc2.jpg) no-repeat"></div>
</div>
<div class="span4" style="padding:0 10px">
  <h3>Testimoni</h3>
  <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
</div>
</div>
</div>
</div>


