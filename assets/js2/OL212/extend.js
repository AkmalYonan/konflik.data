	function extendFormatGeoJson(src) {
		OpenLayers.Util.extend(src, {
			write: function(obj, pretty) {
			 var geojson = {
				 "type": null
			 };
			 if(obj instanceof Array) {
				 geojson.type = "FeatureCollection";
				 var numFeatures = obj.length;
				 geojson.features = new Array(numFeatures);
	
				 //if(obj[0].layer && obj[0].layer.projection) {
				   geojson.crs = this.createCRSObject(obj[0]);
				 //}
	
				 for(var i=0; i<numFeatures; ++i) {
					 var element = obj[i];
					 console.log(element)
					 if(!element instanceof OpenLayers.Feature.Vector) {
						 var msg = "FeatureCollection only supports collections " +
								   "of features: " + element;
						 throw msg;
					 }
					 geojson.features[i] = this.extract.feature.apply(
						 this, [element]
					 );
				 }
			 } else if (obj.CLASS_NAME.indexOf("OpenLayers.Geometry") == 0) {
				 geojson = this.extract.geometry.apply(this, [obj]);
			 } else if (obj instanceof OpenLayers.Feature.Vector) {
				 geojson = this.extract.feature.apply(this, [obj]);
				 if(obj.layer && obj.layer.projection) {
					 geojson.crs = this.createCRSObject(obj);
				 }
			 }
			 return OpenLayers.Format.JSON.prototype.write.apply(this,[geojson,pretty]);
			},
			createCRSObject: function(object) {
			   var proj = object.layer.projection.toString();
			   var crs = {};
			   if (this.internalProjection && this.externalProjection) {
					proj = this.externalProjection.toString();
			   }
			   if (proj.match(/epsg:/i)) {
				   var code = parseInt(proj.substring(proj.indexOf(":") + 1));
				   if (code == 4326) {
					   crs = {
						   "type": "name",
						   "properties": {
							   "name": "urn:ogc:def:crs:OGC:1.3:CRS84"
						   }
					   };
				   } else {    
					   crs = {
						   "type": "name",
						   "properties": {
							   "name": "EPSG:" + code
						   }
					   };
				   }    
			   }
			   return crs;
			}
		});
		return src;
	}
