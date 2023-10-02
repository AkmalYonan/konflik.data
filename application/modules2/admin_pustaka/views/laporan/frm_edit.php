<script type="text/javascript" src="assets/js/plugin/ckeditor4.4.2/ckeditor.js"></script>


<?php
	$lookup_empty[]="--Pilih--";
	
	$lookup_cat_pp=$lookup_empty+lookup("cms_pp_category","kd_cat_pp","ur_cat_pp","parent_id=4","order by order_num");
	$tahun=$data["tahun"]?$data["tahun"]:date("Y");
	$tahun_awal=date("Y")-80;
    $tahun_akhir=date("Y");
    for($i=$tahun_akhir;$i>=$tahun_awal;$i--):
             $lookup_tahun[$i]=$i;
    endfor;
    $lookup_tahun=$lookup_empty+$lookup_tahun;
	
?>

<input type="hidden" name="author" value="<?=$user_name;?>" />
    <div class="row">
	    <div class="col-md-9">
        	<div class="row">
            	<div class="col-md-3">
                	<div class="form-group">
                        <label for="tahun">Jenis Peraturan</label>
                        <?=form_dropdown("kd_cat_pp",$lookup_cat_pp,$data["kd_cat_pp"],"id='kd_cat_pp' class='form-control select2 required'");?>
                    </div><!-- end form group-->
                    
                </div>
                <div class="col-md-3">
                	<div class="form-group">
                       <label for="tahun">Tahun</label>
                       <?=form_dropdown("year",$lookup_tahun,$tahun,"id='year' class='form-control select2 required'");?>
                    </div><!-- end form group-->
                </div>
                <div class="col-md-6">
                		<div class="form-group">
                        	<label>No Peraturan</label>
                    		<input type="text" id="no_pp" name="no_pp" class="form-control input-xs required" value="<?=$data['no_pp'];?>" />
                        </div>
                	
                		
                </div><!-- end of file col-->
                
            </div><!-- end row -->
            
            <div class="row">
                    <div class="col-md-6">
                    	<div class="form-group">
                        <label>Tentang</label>
                        <textarea name="about" id="about" class="form-control required" rows="5" placeholder="Enter ..."><?=$data['about'];?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                    	<br>
                        
                        <br>
                        <div class="table-responsive" style="overflow-y:hidden;overflow-x:auto">
                       <table id="table_file_upload" class="table table-condensed file_list table-bordered">
                            <thead>
                                <tr><td width="10px">#</td><td>File&nbsp;<span class="pull-right"><a id="uploadFile" name="uploadFile" class="btn btn-xs btn-primary" href="javascript:;">Select file</a>
                        <a id="upload" href="javascript:;" class="btn btn-xs btn-danger">Upload files</a></span>
                        </td><td width="10px">#</td></tr>
                            	<tr id="file_list_tr" style="display:none"><td colspan="3"><div id="filelist">Your browser doesn't have Flashs, Silverlight or HTML5 support.</div></td></tr>
                            </thead>
                            <tbody>
                            	<? if(cek_array($data_file)):?>
                                	<? foreach($data_file as $file):?>
                                    	<tr class='file_row' id="file_upload_<?=$file["id_file_upload"]?>" data-file_id="<?=$file["id_file_upload"]?>">
	<td><input type="hidden" name="upload_file_id[]" value="<?=$file["id_file_upload"]?>"/>
	<a href="../<?=$file["path"]?><?=$file["realname"]?>" class='link_viewer' data-file_name="<?=$file["realname"]?>" target='_blank'><i class="fa fa-search"></i></a></td><td>
	<label style='height:auto;'><?=$file["realname"]?></label></td><td><a href="" class="upload_file_remove red"><i class="fa fa-remove"></i> </a></td>
	</tr>
									<? endforeach;?>
								<? endif;?>
                            </tbody>
                       </table>
                        </div><!-- end file -->
                    
                    </div><!-- end col 6-->
                    
             </div><!-- end row-->
            
            
            <div class="row">
            	<div class="col-md-6">
                	    
                        
                </div><!-- end col -->
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-4 form-group hidden">
                    <label>Type</label>
                    <select class="form-control" name="category">
                    	<option value="3"<?=($data['category']==3)?" selected":"";?>>News</option>
                        <!--<option value="2"<?//=($data['category']==2)?" selected":"";?>>Announcement</option>-->
                    </select>
                </div>
            </div><!-- end row-->
            
            <div class="row hidden">
            	<div class="col-md-4">
                	<div class="form-group">
                        	<?php
                            	$tgl_penetapan=$data["tgl_penetapan"]?$data["tgl_penetapan"]:date("Y-m-d H:i:s");
							?>
                        	<label for="nama">Tgl Penetapan</label>
                        	<div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" id="tgl_penetapan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_penetapan))?>" placeholder="dd/mm/yyyy"/>
                                  <input type="hidden" id="tgl_penetapan" name="tgl_penetapan" value="<?=date("Y-m-d",strtotime($tgl_penetapan));?>" class="required" />
                            </div>
                        
                        </div>
                        
                        
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                        	<?php
                            	$tgl_berlaku=$data["tgl_berlaku"]?$data["tgl_berlaku"]:date("Y-m-d H:i:s");
							?>
                        	<label for="nama">Berlaku</label>
                        	<div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" id="tgl_berlaku_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_berlaku))?>" placeholder="dd/mm/yyyy"/>
                                  <input type="hidden" id="tgl_berlaku" name="tgl_berlaku" value="<?=date("Y-m-d",strtotime($tgl_berlaku));?>" class="required" />
                            </div>
                        
                        </div><!-- end form group-->
                        
                        
                </div> <!-- end col 4-->
                
                <div class="col-md-4">
                	<!-- empty-->
                </div><!-- end col 4-->
                
                
            </div>
            
            
            <div class="row hidden">
                <div class="col-md-12">
                    <label>Deskripsi</label>
                    <textarea name="description" id="description" cols="10" rows="3" class="col-md-11 ckeditor"><?=$data['description'];?></textarea>
                </div>
            </div>
        </div>
	    <div class="col-md-3">
        	<!--<div class="formSep">-->
                <div class="row">
                    <div class="col-md-12">
                        <div id="imgcontainer">
                        	<label>Cover Image <span class="help-block" style="display:inline">(Max filesize: 500kb)</span></label>
                            <!--<div id="runtime">No runtime found.</div>-->
							<!--
                            <div id="preview" style=" border: 1px solid grey;width:200px; height:200px;" class="img-polaroid"><?php echo $image_canvas;?></div>
                            [ <a href id="pickfiles">Browse</a> ]
							-->
							<?php $gambar=$data['image']!=''?$this->config->item("dir_pp").$data['image']:"assets/images/noimg.jpg"; ?>
                            <img src="<?=$gambar?>" id="previewplay" width="300px" class="img-thumbnail" style="height:150px; max-height:150px">
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
            	<div class="row hidden">
                	<div class="col-md-12" id="container">
                    	<input type="text" id="file_ext" name="file_ext" value="<?=substr( md5( rand(10,100) ) , 0 ,10 )?>">
                        <textarea id="files" name="files" rows="3" and cols="10">
                        </textarea>
                        
                        
						<div id="console"></div>
                        <div id="file_uploaded"></div>
                    </div>
                </div>
            
            
                <div class="row">
                     <div class="col-md-12">
                        <? $checked=($data['publish'])?" checked":""; ?>
                        <label>
                            <input type="checkbox" value="1" name="publish" <?=$checked;?> />
                            Publish
                        </label>
                    </div>
                </div>
            <!--</div>--> <!-- form separator -->
        </div> 
    </div>
    <div class="progress sm">
    <div class="progress-bar progress-bar-primary" id="pg-bar" style="width: 0%"></div>
    </div>
	<div class="form-actions hidden">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
    <br />
   </div>
   
   
   <?php echo js_asset("jquery.tmpl.min.js");?>
   <?php echo js_asset("jquery.tmplPlus.min.js");?>
   
   <script id="tmp_file_upload" type="text/x-jquery-tmpl">
	<tr class='file_row' id="file_upload_${idx}" data-file_id="${idx}">
	<td><input type="hidden" name="upload_file_id[]" value="${idx}"/>
	<a href="./${relative_path}" class='file_open' target='_blank'><i class="fa fa-search"></i> </a></td><td>
	<label style='height:auto;'>${file_name}</label></td><td><a href="" class="upload_file_remove red"><i class="fa fa-remove"></i> </a></td>
	</tr>
	</script>

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

<script type="text/javascript" src="assets/js/plugins/plupload/plupload.full.min.js"></script>

<script type="text/javascript">
	BASE_URL = "<?php echo base_url();?>"
</script>


<script>
	var config_path="dir_pp";
	var relative_path="<?=$this->config->item("dir_pp");?>";
	
	var act=$("#act").val();
	var id=$("#id").val();
	
	var files=[];
	var files_queue=[];
	var datafile = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'uploadFile', // you can pass in id...
	container: document.getElementById('container'), // ... or DOM Element itself
	chunk_size: '1mb', 
	url : BASE_URL + 'upload/chunk/'+config_path,
	max_file_count: 3,

	//ADD FILE FILTERS HERE
	filters : {
		/* mime_types: [
				{title : "XML files", extensions : "xml"},
			]
		*/
	}, 

	// Flash settings
	flash_swf_url : BASE_URL + 'assets/js/plugins/plupload/Moxie.swf',

	// Silverlight settings
	//silverlight_xap_url : BASE_URL + 'assets/js/plugins/pluploader/Moxie.xap',
	 

	init: {
		PostInit: function() {
			document.getElementById('filelist').innerHTML = '';	 
			document.getElementById('upload').onclick = function() {
				datafile.start();
				return false;
			};
		},

		FilesAdded: function(up, files) {
			$("#file_list_tr").show();	
			
			plupload.each(files, function(file) {
				files_queue.push(file);
				document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b><a href="#" class="a_file_remove red"><i class="fa fa-remove"></i></a></div>';
				
			});
		},
		FilesRemoved: function(up, files) {
                // Called when files are removed from queue
                plupload.each(files, function(file) {
                	files_queue.pop(file);
					//log('  File:', file);
                });
				if(files_queue.length==0){
					$("#file_list_tr").hide();
				}
            },
		
		FileUploaded: function(up, file, info) {
                // Called when file has finished uploading
                //log('[FileUploaded] File:', file, "Info:", info);
			

			files.push(file);
			$("div#"+file.id).hide().remove();
        	$("#console").html(JSON.stringify(files));   
			$("#files").text($("#console").html()); 
			
			$.post("<?=base_url()?><?=$this->module?>file_upload_save?id="+id+"&file="+encodeURIComponent(JSON.stringify(file)),function(ret){
				//console.log(ret);
				myret=JSON.parse(ret);
				//console.log(myret.status);
				if(myret.status=="ok"){
					//alert("ok")
					var tmpFile="tmp_file_upload";
					myret.file["relative_path"]=relative_path+myret.file.file_name;
					$('#table_file_upload tbody').append($("#"+tmpFile).tmpl(myret.file));
				}else{
						//alert("not ok");
					}
			});
			 
			  
		},
 			/*
            ChunkUploaded: function(up, file, info) {
                // Called when file chunk has finished uploading
                log('[ChunkUploaded] File:', file, "Info:", info);
            },
			*/
			UploadComplete: function(up, files) {
				// Called when all files are either uploaded or failed
                //log('[UploadComplete]');
				$("#file_list_tr").hide();
			},
		
		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			$("#pg-bar").css("width",file.percent+"%");
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

	
	
	
	$(function(){
		$("#filelist").on("click",".a_file_remove",function(e){
			e.preventDefault();
			var that=$(this);
			var div=that.closest("div");
			var file_id=div.attr("id");
			datafile.removeFile(datafile.getFile(file_id));
			div.remove();
		});
	
		$(document).on("click","a.upload_file_remove",function(e){
			e.preventDefault();
			var that=$(this);
			var id=that.closest("tr").data("file_id");
			$.post("<?=base_url()?><?=$this->module?>delete_upload_file/"+id,function(ret){
				if(ret=="ok"){
					that.closest("tr").slideUp().remove();
				}
			}); //end ajax
			
		});
	});

function log() {
        var str = "";
 
        plupload.each(arguments, function(arg) {
            var row = "";
 
            if (typeof(arg) != "string") {
                plupload.each(arg, function(value, key) {
                    // Convert items in File objects to human readable form
                    if (arg instanceof plupload.File) {
                        // Convert status to human readable
                        switch (value) {
                            case plupload.QUEUED:
                                value = 'QUEUED';
                                break;
 
                            case plupload.UPLOADING:
                                value = 'UPLOADING';
                                break;
 
                            case plupload.FAILED:
                                value = 'FAILED';
                                break;
 
                            case plupload.DONE:
                                value = 'DONE';
                                break;
                        }
                    }
 
                    if (typeof(value) != "function") {
                        row += (row ? ', ' : '') + key + '=' + value;
                    }
                });
 
                str += row + " ";
            } else {
                str += arg + " ";
            }
        });
 
        var log = document.getElementById('console');
        log.innerHTML += str + "\n";
    }

datafile.init();
</script>
