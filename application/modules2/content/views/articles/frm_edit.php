<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<!--<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>-->
<script type="text/javascript" src="assets/js/plugin/ckeditor4.4.2/ckeditor.js"></script>
<script type="text/javascript" src="assets/js/plugin/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>


<input type="hidden" name="author" value="<?=$user_name;?>" />
    <div class="row">
	    <div class="col-md-9">
            <div class="row">
                <div class="col-md-8">
                    <label>Judul Artikel</label>
                    <input type="text" id="title" name="title" class="form-control input-xs required" value="<?=$data['title'];?>" />
                </div>
				<div class="col-md-4">
					<div class="form-group">
                        <?php
                            $tgl_Artikel=$data["created"]?$data["created"]:date("Y-m-d H:i:s");
						?>
                        <label for="nama">Tanggal</label>
                        <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input type="text" id="created_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_Artikel))?>" placeholder="dd/mm/yyyy"/>
							<input type="hidden" id="created" name="created" value="<?=date("Y-m-d",strtotime($tgl_Artikel));?>" class="required" />
						</div>
                    </div>
				</div>
            </div>
            <div class="row">
				<div class="col-md-12">
					<label>Klip Artikel</label>
					<textarea name="clip" id="clip" class="form-control required" rows="3" placeholder="Enter ..."><?=$data['clip'];?></textarea>
				</div>
				<!--
                <div class="col-md-4 form-group hidden">
					<label>Type</label>
					<select class="form-control" name="category">
						<option value="1"<?=($data['category']==1)?" selected":"";?>>Articles</option>
					</select>
				</div>
				-->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Isi Artikel</label>
                    <textarea name="content" id="content" cols="10" rows="3" class="col-md-11 ckeditor"><?=$data['content'];?></textarea>
                </div>
            </div>
        </div>
	    <div class="col-md-3">
        	<!--<div class="formSep">-->
                <div class="row">
                    <div class="col-md-12">
                        <div id="imgcontainer">
                        	<label>Image <span class="help-block" style="display:inline">(Max filesize: 500kb)</span></label>
                            <!--<div id="runtime">No runtime found.</div>-->
							<!--
                            <div id="preview" style=" border: 1px solid grey;width:200px; height:200px;" class="img-polaroid"><?php echo $image_canvas;?></div>
                            [ <a href id="pickfiles">Browse</a> ]
							-->
							<?php $gambar=$data['image']!=''?$data['image']:"noimg.jpg"; ?>
						 	<img src="<?=$this->config->item("dir_articles").$gambar?>" id="previewplay" width="300px" class="img-thumbnail" style="height:150px; max-height:150px">
						 	<input id="imgInpPlay" type="file" name="image_name" />
							<p style="font-size:10px;" class="help-block">File : *.jpg, *.png, *.gif</p>
							<!--
                            <div id="image_data" style="display:<?=$image_data;?>">
                                <label>Image Title</label>
                                <input class="form-control" id="image_title" type="text" name="news_image_title" value="<?=$data['image_title'];?>" style="width:200px;" />
                                <label>Source</label>
                                <input class="form-control" id="image_src" type="text" name="news_image_src" value="<?=$data['image_src'];?>" style="width:200px;" />
                            </div>
							-->
                        </div>
						<!--
                        <input id="image_name" type="hidden" name="image_name" />
                        <?=$input_image;?>
						-->
                	</div>
                </div>
            <!--</div>--><!-- form separator 
        	<!--<div class="formSep">
                <div class="row">
					<div>
						<label><span class="error_placement">Headline</span> <span class="f_req">*</span></label><br>
							<input name="is_headline" id="optionsRadios1" value="1" type="radio">
							Ya &nbsp;&nbsp;
							<input name="is_headline" id="optionsRadios2" value="0" type="radio">
							Tidak
					</div>
                </div>
            </div>--> <!-- form separator -->
            <!--<div class="formSep">-->
                <div class="row">
                     <div class="col-md-12">
                        <? $checked=($data['status'])?" checked":""; ?>
                        <label>
                            <input type="checkbox" value="1" name="status"<?=$checked;?> />
                            Publish
                        </label>
                    </div>
                </div>
            <!--</div>--> <!-- form separator -->
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
   
   
   <script>
function readURLplay(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
                $('#previewplay').attr('width', '300px');
                $('#previewplay').attr('height', '200px');
            }
             reader.readAsDataURL(input.files[0]);
        }
    }
   
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>