	<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary btn-webcam" href="#">Webcam</a>
        <div id="div_webcam" style="display:none">	
        <div class="formSep"></div>
        <div class="row">
        <div class="col-md-5">
        	<div id="my_camera" style="border: 1px solid #ddd;border-radius: 2px;width:240px;height:240px;">
            </div>
            <!--<input type="button" class="btn btn-success" value="Shoot" onClick="take_snapshot()"/>-->
        	<button style="margin-top:-30px;left:20px;position:absolute;display:none;" class="btn btn-xs bg-green btn-snap"><i class="fa fa-camera"></i> Shoot</button>
        </div><!-- end col -->
        <div class="col-md-5" >
        	<span class="label label-warning label-upload" style="position:absolute;top:10px;left:20px;display:none;">Uploading...</span>
        	<div id="my_snap" style="border: 1px solid #ddd;border-radius: 2px;width:240px;height:240px;"><img align="right" src="assets/images/pic.jpg" width="100%" height="100%" />
            </div>
            <button class="btn btn-xs bg-blue btn-upload" style="margin-top:-30px;left:20px;position:absolute;display:none;"><i class="fa fa-upload"></i> Simpan</button>
            
         </div><!-- end col -->
        
        </div><!-- end row -->
        
        
        <!-- A button for taking snaps -->
    	<!--
        <form>
            <input type=button class="btn btn-success" value="Take Snapshot" onClick="take_snapshot()">
        </form>
        -->
        
        <!--<div id="results" class="well">Your captured image will appear here...</div> -->
		
        </div><!-- end webcam -->
    
    </div></div><!-- end row-->
    
    
<script src="assets/js/plugin/webcam2/webcam.min.js"></script>

<!-- Configure a few settings and attach camera -->
	
	<script language="JavaScript">
		$(function(){
			$(".btn-webcam").click(function(e){
				e.preventDefault();
				var flag_hide= $("#div_webcam").is(":hidden");
				
				if(flag_hide==1){
					$("#div_webcam").slideDown(1000,function(){
						Webcam.attach( '#my_camera' );
						$(".btn-snap").show();
					});
				}else{
					$("#div_webcam").slideUp();
					Webcam.reset();
					$(".btn-snap").hide();
				} 
			});
		
			$(".btn-snap").click(function(e){
				e.preventDefault();
				take_snapshot();	
			});
			
			$(".btn-upload").click(function(e){
				e.preventDefault();
				 upload();	
			});	
		});
		
		/*
		Webcam.set({
			// live preview size
			width: 300,
			height: 240,
			
			// device capture size
			dest_width: 640,
			dest_height: 480,
			
			// final cropped size
			crop_width: 480,
			crop_height: 480,
			
			// format and quality
			image_format: 'jpeg',
			jpeg_quality: 90
		});
		
		*/
		/*
		Webcam.set({
			// live preview size
			width: 320,
			height: 240,
			
			// device capture size
			dest_width: 1280,
			dest_height: 720,
			
			// final cropped size
			crop_width: 720,
			crop_height: 720,
			
			// format and quality
			image_format: 'jpeg',
			jpeg_quality: 90
		});*/
		
		
		Webcam.set({
			// live preview size
			width: 320,
			height: 240,
			
			// device capture size
			dest_width: 960,
			dest_height: 720,
			
			// final cropped size
			crop_width: 720,
			crop_height: 720,
			
			// format and quality
			image_format: 'jpeg',
			jpeg_quality: 90
		});
		
		var g_data_uri=null;
		
		//Webcam.attach( '#my_camera' );
		function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				$("#my_snap").html("<img src='"+data_uri+"' width='100%' height:100%/>");
				/*document.getElementById('results').innerHTML = '<h2>Here is your image:</h2>' + '<img src="'+data_uri+'" style="width:320px;height:320px"/>';*/
        		g_data_uri=data_uri;
				$(".btn-upload").show();
			});
			
			
			//upload();
		}
		
		function upload(){
			$(".label-upload").show();
			Webcam.upload( g_data_uri, '<?=$this->module?>upload_foto/?idx=<?=$data["idx"]?>', function(code, text) {
					$(".label-upload").hide();
				
					var data_all=JSON.parse(text);
					var data=data_all.data;
					var tr="<tr>"+
						"<td>"+data.path+data.file_name+"</td>"+
						"<td><img src='"+data.path+data.file_name+"' style='width:50px'/></td>"+
						"<td class='tc'><input type='radio' name='flag_default' data-id='"+data.idx+"' class='flag_default' id='flag_default_"+data.idx+"' value='1'/></td>"+
						"<td class='tc'><a class='btn btn-xs btn-delete-foto' data-toggle='tooltip' data-id='"+data.idx+"' href='javascript:void()' title='Hapus Foto'><i class='fa fa-remove red'></i></a></td>"+
						"</tr>";					
					
					$(".table-foto").find("tbody").prepend(tr);
					set_foto_default();	
					
					console.log(data);
					//console.log(code);
					//console.log(text);
					// Upload complete!
					// 'code' will be the HTTP response code from the server, e.g. 200
					// 'text' will be the raw response content
				$(".btn-upload").hide();
			});
		}
		
		function set_foto_default(){
			$.getJSON("<?=$this->module?>get_foto_default/<?=$id?>",function(data){
				var idx=data.idx;
				$(".table-foto").find("#flag_default_"+idx).prop("checked",true);
				$("#foto_pasien,.foto-pasien").prop("src",data.path+data.file_name);				
			});	
		}
		
	</script>