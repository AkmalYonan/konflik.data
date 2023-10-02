//HPIK
themeObjInc=new Object();
themeObjInc.init = function(param,ctx) {
	if  (param) themeObjInc.setUrlParam(param.split("/"));
	$("#data_search").empty();

	if (map.getLayer("ppplayer")) {
		ppplayer.destroyFeatures();
		map.removeLayer(ppplayer);
	}
	var render=(ctx)?["Canvas", "SVG", "VML"]:["SVG"];
	ppplayer = new OpenLayers.Layer.Vector('ESIRS INCIDENT', {
		styleMap: styleCircle
	,	renderers: ["Canvas","SVG", "VML"]
	,	rendererOptions: {zIndexing: false}
	,	strategies: [new OpenLayers.Strategy.Fixed()]
	,	protocol: new OpenLayers.Protocol.HTTP({
			url: '/portal/gis/map_json',
			params:{},
			format: new OpenLayers.Format.GeoJSON({
				ignoreExtraDims: true,
				keepData: true,
				internalProjection: map.baseLayer.projection,
				externalProjection: proj
			})
		})
	,	eventListeners: {
			"featuresadded": themeObjInc.Zoomer
		}
	,	attribution: "All Thematic Layers are Simplified"
	});
	ppplayer.id="ppplayer";
	map.addLayer(ppplayer);
	map.setLayerIndex(ppplayer,0);
	
	highlightCtrl = new OpenLayers.Control.SelectFeature([ppplayer], {
		hover: true,highlightOnly: true, renderIntent: "temporary", callbacks:{
			'over':feature_hover, 'out':feature_out
		}
	});
	selectCtrl = new OpenLayers.Control.SelectFeature([ppplayer],
		{clickout: true, toggle:false}
	);
	ppplayer.events.on({
		"featureselected": function(e) {
			onFeatureSelect(e.feature);
		},
		"featureunselected": function(e) {
			onFeatureUnselect(e.feature);
		}
	});
	
	map.addControls([highlightCtrl,selectCtrl]);
	highlightCtrl.activate();
	selectCtrl.activate();
	
	//listLayers.push("ppplayer");
	themeObjInc.searchData();
}
themeObjInc.resetData=function() {
	//alert('F1');
	$(".org").each(function(){
		if ($(this).is(":checked")) $(this).attr("checked",false);
	})
	$("#kat_select").val(0);
	$("#gol_select").val(0);
	$("#thn_select").val(0);
	$("#search_text").val("");
}
themeObjInc.varData=function() {
	//alert('F1');
	var typ = new Array();
	$(".pny").each(function(){
		if ($(this).is(":checked")) typ.push($(this).val());
	})
	
	var data = {
		'ext': map.getExtent(),
		'daterange':($("#incdate").val())?encodeURIComponent($("#incdate").val()):'0',
		'airport': encodeURIComponent($("#airport_list").val()),
		'incident': encodeURIComponent($("#incident_type").val()),
		'aircraft': encodeURIComponent($("#aircraft_list").val())
	}
	return data;
}
themeObjInc.searchData=function() {
	var data = this.varData();
	var kdw = data['prop'];
	var url = '/portal/gis/map_data/'+data['daterange']+'/'+data['airport']+'/'+'/'+data['incident']+'/'+data['aircraft'];
	//alert(url);
	$("#data_search").load(url,function(){
		themeObjInc.updateData();	
		ckey=data['key'];
		$('.xtooltip').tooltip()
		//clearAllPopups();
	});
	var url = '/portal/gis/stat_data/'+data['daterange']+'/'+data['airport']+'/'+'/'+data['incident']+'/'+data['aircraft'];
	$("#data_stat").load(url);
}
themeObjInc.getUrlParam=function() {
	var data = this.varData();
	var param_url = data['kat']+'/'+data['gol']+'/'+data['org']+'/'+data['thn']+'/'+data['key']+'/'+data['pny']+'/'+data['typ']+'//'+map.getZoom()+'/'+data['prop']+'/'+data['kab']+'/';

	return param_url;
}	
themeObjInc.setUrlParam=function(p) {
	var ft = p[6].split(",");
	$(".formtype").each(function(){
		if ($.inArray($(this).val(), ft)>=0) {
			$(this).attr("disabled",false);
		}
		else {
			$(this).attr("disabled","disabled");
		}
	})
	$("#kat_select").val(p[0]);
	$("#gol_select").val(p[1]);
	var org = p[2].split(",");
	$(".org").each(function(){
		if ($.inArray($(this).val(), org)>=0) $(this).attr("checked","checked");
	})
	$("#thn_select").val(p[3]);
	$("#search_text").val(p[4]);
	$(".pny").each(function(){
		if ($(this).val()==p[5]) $(this).attr("checked","checked");
	});
	$("#propinsi_list").val(p[9]);
	$("#kabupaten_list").val(p[10]);
}		
themeObjInc.updateData=function(val) {
	//if (selectedFeature) onFeatureUnselect(selectedFeature);
	var zoom = map.getZoom();
	var data = this.varData();
	var kdw = data['prop'];
	var update_url = '/portal/gis/map_json/'+data['daterange']+'/'+data['airport']+'/'+data['incident']+'/'+data['aircraft'];
	//alert(update_url);
	ppplayer.protocol= new OpenLayers.Protocol.HTTP({
		url:update_url,
		format: new OpenLayers.Format.GeoJSON({
			ignoreExtraDims: true,
			internalProjection: map.baseLayer.projection,
			externalProjection: proj
		})
	})
	ppplayer.refresh();
	map.setLayerIndex(ppplayer,0);
	//alert(ppplayer.drawn);
	themeObjInc.updateLegend();
	
}
themeObjInc.updateLegend=function(val) {
	//if (selectedFeature) onFeatureUnselect(selectedFeature);
	var zoom = map.getZoom();
	var data = this.varData();
	var kdw = data['prop'];
	var update_url = '/portal/gis/map_legend/'+data['daterange']+'/'+data['airport']+'/'+data['incident']+'/'+data['aircraft'];
	//alert(update_url);

	$("#map_legend").load(update_url);
	
}
themeObjInc.hoverData=function(gid,mod) {
	for(var i = 0; i<ppplayer.features.length;++i) {
		var data_gid= ppplayer.features[i].attributes.gid;
		if (data_gid == gid)
		{     
			f = ppplayer.features[i];
			//fc=f.clone();
			if (f.geometry.getBounds()) {
			var lonlat = f.geometry.getBounds().getCenterLonLat();
			//prasarana.removeFeatures(f);
			//prasarana.addFeatures(fc);
			//alert(f.style);
			(mod=='over')?feature_hover(f):feature_out(f);
			break;             
			}
		}
	}
	
}
themeObjInc.zoomData=function(gid) {
	for(var i = 0; i<ppplayer.features.length;++i) {
		var data_gid= ppplayer.features[i].attributes.gid;
		if (data_gid == gid)
		{     
			f = ppplayer.features[i];
			var f_bounds = f.geometry.getBounds();
			map.zoomToExtent(f_bounds);
			if (map.getZoomForExtent(f_bounds)>14) map.zoomTo(12);
			break;             
		}
	}
}
themeObjInc.Zoomer=function() {
	if (ppplayer.getDataExtent()) {
		map.zoomToExtent((ext)?ext:ppplayer.getDataExtent(),(ext)?1:0);
		if (map.getZoomForExtent(ppplayer.getDataExtent())>14) map.zoomTo(12);
	}
}
