
<input type="hidden" name="author" value="<?=$user_name;?>" />
    <div class="row">
	    <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div id="imgcontainer">
                        <label>Image <span class="help-block" style="display:inline">(Max filesize: 500kb)</span></label>
                        <div style="position:relative"> 
                            <!--<div id="preview" style="border:1px solid grey; width:968px; height:360px; margin:1px" class="img-polaroid"></div>-->
                            <?php $gambar	=	$data['image']!=''?$data['image']:"noimg.jpg"; ?>
							<img src="<?=$this->config->item('dir_slider')?><?=$gambar?>" id="previewplay" width="968px" style="height:360px; max-height:360px;width:968px" class="img-thumbnail">
                            <div style="text-align:left;" class="carousel-caption" style="max-width:600px">
                              <h2 style="text-align:left;" id="s_title"><?=$data["title"]?$data["title"]:"Title";?></h2>
                              <p style="text-align:left;" id="s_lead" class="lead"><?=$data["clip"]?$data["clip"]:"Lead...Lead..Lead"?></p>
                              <a style="text-align:left;" id="s_button" class="btn btn-large btn-warning" href="#" target="_blank">...</a>
                            </div>
                        </div>
                        <!--[ <a href id="pickfiles">Browse</a> ]-->
						<input id="imgInpPlay" type="file" name="image_name" size="20" />
                        
                    </div>
                       <!-- <input id="image_name" type="hidden" name="image_name" />-->
                </div>
            </div>
       </div>
    </div>
    <div class="row">
	    <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <label>Title</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?=$data['title'];?>" />
                </div>
            </div>
            <div class="formSep">
                <div class="row">
                    <div class="col-md-12">
                        <label>Clip </label>
                        <textarea name="clip" id="clip" cols="10" rows="3" class="form-control"><?=$data['clip'];?></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <label>Button Text</label>
                        <input type="text" id="buttontext" name="button" class="form-control" />
                    </div>
                    <div class="col-md-8">
                        <label>URL</label>
                        <input type="text" id="buttonurl" name="url" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
			<!--
        	<div class="">
                <div class="row">
                    <div class="col-md-12">
                        <div id="image_data" style="display:none">
                            <label>Image Source</label>
                            <input id="image_src" class="form-control" type="text" name="news_image_src" style="width:200px;" />
                            </div>
                     </div>
                </div>
            </div>
			-->
			<br />
            <div class="">
                <div class="row" style="padding-left:20px;">
                     <div class="col-md-12">
                        <? $checked=($data['status'])?" checked":""; ?>
                        <label class="checkbox inline">
                            <input type="checkbox" value="1" name="status"<?=$checked;?> />
                            Publish
                        </label>
                    </div>
                </div>
            </div> <!-- form separator -->
        </div> 
    </div>
	<div class="form-actions hidden">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
    <br />
   </div>
   
   <script>
   	$(function(){
		$("#title").blur(function(){
				$("#s_title").text($(this).val());
		});	
		
		$("#news_clip").blur(function(){
				$("#s_lead").text($(this).val());
		});	
		
		$("#buttontext").blur(function(){
				$("#s_button").text($(this).val());
		});	
		
	});
   </script>