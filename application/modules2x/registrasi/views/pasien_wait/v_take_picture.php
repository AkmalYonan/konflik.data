                <div class="btn-toolbar">
                	<div class="btn-group">
                    	 <a id="shootButton" href="" class="blueButton btn btn-primary btn-sm">Shoot!</a>
                         <a id="cancelButton" href="" class="blueButton btn btn-sm btn-default">Cancel</a> 
                    </div>
                    <div class="btn-group">
                    	<a id="uploadButton" href="" class="greenButton btn btn-sm btn-danger">Upload!</a>
                    </div>
                	<div class="btn-group pull-right">
                    	<a class="settings btn btn-warning btn-sm"><i class="icon-cog"></i> Setting </a>
                    </div>
                </div>
                
                 <input type="text" name="foto" id="foto" value="" />
        		 <input type="text" name="foto_path" id="foto_path" value="" />
        		 <input type="text" name="foto_tb_path" id="foto_tb_path" value="" />
                
                <div id="camera">
                	<!-- <span class="tooltip"></span>
                    <span class="camTop"></span>-->
                    <div class="row">
                    <div class="col-sm-8">
	                    <div id="screen" style="width:300px;height:300px;margin-left:15px;"></div>
                    </div>
                    <div class="col-sm-4">
                        <div id="photos">
                            Test
                        </div>
                    </div>
                    </div><!-- end row-->
                    
                   <!-- <div id="buttons">
                        <div class="buttonPane">
                            <a id="shootButton" href="" class="blueButton btn btn-info btn-sm">Shoot!</a>
                        </div>
                        <div class="buttonPane">
                            <a id="cancelButton" href="" class="blueButton">Cancel</a> <a id="uploadButton" href="" class="greenButton">Upload!</a>
                        </div>
                    </div>-->
                	<!--<a class="settings btn btn-warning btn-sm"><i class="icon-cog"></i> Setting </a>-->
                    <!--<span class="settings"><i class="icon-cog"></i> Setting</span>-->
                </div>
                
            


<script src="assets/js/plugin/webcam/webcam.js"></script>
<script>
	$(function(){
		var camera = $('#camera'),
        photos = $('#photos'),
        screen =  $('#screen');

		var template = '<a href="uploads/original/{src}" rel="cam" '
			+'style="background-image:url(uploads/thumbs/{src})"><img src="uploads/thumbs/{src}"/></div></a>';
	
		/*----------------------------------
			Setting up the web camera
		----------------------------------*/
	
		webcam.set_swf_url('assets/js/plugin/webcam/webcam.swf');
		webcam.set_api_url('<?=base_url()?>upload/upload_stream/');	// The upload script
		webcam.set_quality(80);				// JPEG Photo Quality
		webcam.set_shutter_sound(true, 'assets/js/plugin/webcam/shutter.mp3');
		
		// Generating the embed code and adding it to the page:
		screen.html(
			webcam.get_html(screen.width(), screen.height())
		);
		
		
		var shootEnabled = false;
		
		$('#cancelButton').click(function(){
			webcam.reset();
			//togglePane();
			return false;
		});
		
		$('#uploadButton').click(function(){
			webcam.upload();
			webcam.reset();
			return false;
		});
		
		$('#shootButton').click(function(e){
			e.preventDefault();
			
			if(!shootEnabled){
				return false;
			}
			
			webcam.freeze();
			//togglePane();
			return false;
		});
		
		
		
		
		$('.settings').click(function(e){
			e.preventDefault();
			if(!shootEnabled){
				return false;
			}
			webcam.configure('camera');
       	 	
			
    	});

		
		camera.find('.settings').click(function(e){
			e.preventDefault();
			if(!shootEnabled){
				return false;
			}
			webcam.configure('camera');
       	 	
			
    	});
		
		 webcam.set_hook('onLoad',function(){
			// When the flash loads, enable
			// the Shoot and settings buttons:
			shootEnabled = true;
		});
		
		webcam.set_hook('onComplete', function(msg){
			//alert(msg);
			// This response is returned by upload.php
			// and it holds the name of the image in a
			// JSON object format:
			msg = $.parseJSON(msg);
			if(msg.error){
				alert(msg.message);
			}
			else {
				// Adding it to the page;
				//photos.append(templateReplace(template,{src:msg.filename}));
				photos.prepend("<li>"+templateReplace(template,{src:msg.filename})+"</li>");
				$("#foto").val(msg.filename);
				$("#foto_path").val(msg.file_path);
				$("#foto_tb_path").val(msg.file_tb_path);
				//initFancyBox();
			}
		});
		
		webcam.set_hook('onError',function(e){
			screen.html(e);
		});
		
		
		
		screen.html(
			webcam.get_html(screen.width(), screen.height())
		);
		
		function templateReplace(template,data){
			return template.replace(/{([^}]+)}/g,function(match,group){
				return data[group.toLowerCase()];
			});
		}
		
		
	});
	
	
</script>