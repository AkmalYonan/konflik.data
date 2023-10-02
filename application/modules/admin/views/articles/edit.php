<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<!-- Place inside the <head> of your HTML -->
<?php $id=$this->encrypt_status==TRUE?encrypt($data['idx']):$data['idx']; ?>


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$this->module_title?>
    <small>Edit Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin/dashboard"><i class="fa fa-file-text"></i> Home</a></li>
    <li><a href="wilayah/wilayah"> <?=$this->module_title?></a></li>
    <li class="active">Edit Artikel</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
		<div class="col-xs-12">

			<a class="btn btn-app bg-purple" href="<?php echo $this->module?>">
                <i class="fa fa-bars"></i> Daftar Artikel
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>add" id="addData">
                <i class="fa fa-plus"></i> Input Artikel
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>" id="refresh">
                <i class="fa fa-refresh"></i> Refresh
            </a>


			<?php echo message_box();?>
			<form id="fdata" action="<?=$module;?>edit" method="post" enctype="multipart/form-data" >
			    <input type="hidden" name="author" value="<?=$user_name;?>" />
			    <input type="hidden" name="idx" value="<?=$data['idx'];?>" />
			<input type="hidden" name="id" value="<?=$idd;?>" />

				<div class="box box-default">
					<div class="box-header with-border">
		              <h3 class="box-title">Edit Data</h3>
		              <div class="box-tools pull-right">
		                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
		              </div>
		            </div><!-- /.box-header -->
		            <div class="box-body">

		            	<?php
							$others = preg_split("/#/",$data['others']);
							$author = str_replace("Author: ","",$others[0]);
							$ref = str_replace("Reference/Source : ","",$others[1]);
							if ($data['image']) {
								//$image_image = '<img src="assets/image/news/'.$data['news_image'].'" style="float:left; margin:2px 10px 10px 2px" />';
								$image_image = '<span id="canvas_view" style="float:left;margin:2px 10px 10px 2px; " class="img-polaroid"><canvas width="200" height="200" style="background-image:url('.$this->config->item('dir_ppid').'assets/image/pages/'.$data['image'].')"></canvas></span>';
								$image_canvas = '<canvas id="myCanvas" width="200" height="200" style="background-image:url(../assets/image/pages/'.$data['image'].');background-size: 100% 100%;"></canvas>';
								$input_image = '<input id="image_name_old" type="hidden" name="image_name_old" value="'.$data['image'].'" />';
								$image_data = "block";
							}
							else {
								$image_image = '<span id="canvas_view" style="float:left;margin:0; " class="img-polaroid"><canvas width=0 height=0></canvas></span>';			
								$image_data = "none";
							}
						?>

						<div class="row">
						    <div class="col-md-9">
					            <div class="row">
					                <div class="col-md-12">
					                    <label>Author</label>
					                    <input type="text" id="authorx" name="author2" class="form-control" value="<?=$author;?>" />
					                </div>
					            </div>
					            <div class="row">
					                <div class="col-md-12">
					                    <label>Title</label>
					                    <input type="text" id="title" name="title" class="form-control required" value="<?=$data['title'];?>" />
					                </div>
					            </div>
					            <div class="formSep">
					                <div class="row">
					                    <div class="col-md-12">
					                        <label>Clip</label>
					                        <textarea name="clip" id="clip" cols="10" rows="3" class="form-control required"><?=$data['clip'];?></textarea>
					                    </div>
					                </div>
					            </div>
					            <div class="row">
					                <div class="col-md-12">
					                    <label>Content</label>
					                    <textarea name="content" id="news_content" cols="10" rows="3" class="ckeditor span11 required"><?=$data['content'];?></textarea>
					                </div>
					            </div>
					            
					            <div class="row">
					                <div class="col-md-12">
					                    <label>Reference/Source</label>
					                    <input type="text" id="title" name="ref" class="form-control" value="<?=$ref;?>" />
					                </div>
					            </div>
					        </div>
						    <div class="col-md-3">
					        	<div class="formSep">
					                <div class="row">
					                    <div class="span12">
					                        <div id="imgcontainer">
					                        	<label>Image <span class="help-block" style="display:inline">(Max filesize: 500kb)</span></label>
					                            <!--<div id="runtime">No runtime found.</div>-->
					                            <div id="preview" style="border:1px solid grey; width:200px; height:200px;" class="img-polaroid"><?php echo $image_canvas;?></div>
					                            [ <a href id="pickfiles">Browse</a> ]
					                            <div id="image_data" style="display:<?=$image_data;?>">
					                                <label>Image Title</label>
					                                <input class="form-control" id="image_title" type="text" name="news_image_title" value="<?=$data['image_title'];?>" style="width:200px;" />
					                                <label>Source</label>
					                                <input  class="form-control"id="image_src" type="text" name="news_image_src" value="<?=$data['image_src'];?>" style="width:200px;" />
					                            </div>
					                        </div>
					                        <input id="image_name" type="hidden" name="image_name" />
					                        <?=$input_image;?>
					                	</div>
					                </div>
					            </div><!-- form separator -->
					        	<!-- <div class="formSep">
					                <div class="row">
										<div>
											<label><span class="error_placement">Headline</span> <span class="f_req">*</span></label><br>
												<input name="is_headline" id="optionsRadios1" value="1" type="radio">
												Ya &nbsp;&nbsp;
												<input name="is_headline" id="optionsRadios2" value="0" type="radio">
												Tidak
										</div>
					                </div>
					            </div> form separator -->
					            <div class="formSep">
					                <div class="row">
					                     <div class="span12">
					                        <? $checked=($data['status'])?" checked":""; ?>
					                        <label class="">
					                            <input type="checkbox" value="1" name="status"<?=$checked;?> />
					                            Publish
					                        </label>
					                    </div>
					                </div>
					            </div> <!-- form separator -->
					        </div> 
					    </div>

		            </div>
		            <div class="box-footer">
		             	<div class="form-actions">
							<button type="submit" class="btn btn-success">Simpan</button>
							<button type="reset" class="btn">Batal</button>
						</div>
	             	</div>
		        </div>

			</form>

		</div>
	</div>

</section>



<script>  
$(document).ready(function () {
	var act_link="<?=$this->module?>";		
	$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	
	$("#fdata").validate({ignore:[]});
	$(".f_req").remove();
	$(".required").each(function(i){
		$(this).parent().find("label:first-child").append(" <span class='f_req'>*</span>");
	});
	$("#button_submit").click(function(e){
		$("#fdata").submit();
		e.preventDefault();
	});
	
	var config = {
		toolbar:
		  [
			 ['Undo', 'Redo', '-', 'SelectAll'],
			 ['Styles','Format', 'Bold', 'Italic', 'Underline','NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
			 ['Image','Table'],
			 ['Link', 'Unlink'], 
			 ['Source'],
		  ]
	};
	//$('textarea#content' ).ckeditor(config);
	$('#news-tab a:first').tab('show');
	$('#news-tab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$("#title-view").html($("#title").val());
		$("#author-view").html("Author: "+$("#authorx").val());
		$("#clip-view").html($("#clip").val());
		$("#content-view").html("").html($("textarea#content").val());
	});
});

//Uploader
$(function(){
	var ufile=false;
	var dfile=<?=($data['image'])?"true":"false";?>;
	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash',
		browse_button : 'pickfiles',
		container: 'imgcontainer',
		multi_selection: false,
		url: "<?=base_url()?>test.php",
		max_file_size : '500kb',
		resize: {
			width: 200,
			height: 200,
			crop: true
		},
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"}
		],
		flash_swf_url : 'http://rawgithub.com/moxiecode/moxie/master/bin/flash/Moxie.cdn.swf'
	});
	
	uploader.bind('Init', function(up, params) {
		$('#runtime').html("Current runtime: " + params.runtime);
	});

	uploader.init();

	uploader.bind('FilesAdded', function(up, files) {
		if (dfile) {
			$('#preview').html("");
			$('#canvas_view').html("");
		}
		if (ufile) {
			uploader.removeFile(ufile);
			$('#preview').html("");
			$('#canvas_view').html("");
		}
		$.each(files, function(i,file){
			ufile = file.id;
			$("#image_name").val(file.name);
			var img = new mOxie.Image();
	
			img.onload = function() {
				this.embed($('#preview').get(0), {
					width: 200,
					height: 200,
					crop: true
				});
				$('#canvas_view').css({margin:"2px 10px 10px 2px"});
				$('#canvas_view').css({width:200,height:200});
				this.embed($('#canvas_view').get(0), {
					width: 200,
					height: 200,
					crop: true
				});
			};
	
			img.onembedded = function() {
				this.destroy();
			};
	
			img.onerror = function() {
				this.destroy();
			};
	
			img.load(this.getSource());        
			
		});
	});
	uploader.bind('Error', function(up, err) {
		alert("Error: " + err.code + " -" + err.message/* +  (err.file ? ", File: " + err.file.name : "")*/);
		up.refresh(); // Reposition Flash/Silverlight
	});
	var x = false;
	uploader.bind('FileUploaded', function() {
		//if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
			x=true;
			$('#fdata').submit();
		//}
	});
	$('#fdata').submit(function(e) {
		// Files in queue upload them first
		if (uploader.files.length > 0) {
			
			uploader.start();
		} else {
			x = true;
		}
		//	alert('You must at least upload one file.');
	
		if (!x) return false;
	});    
    
});
</script>


<script>
	$(function(){
		$("#comment_list").load("<?=$this->module?>comments_list/<?=$data["id"]?>/<?=$data["category"];?>");
		$(".comments_add").click(function(e){
			e.preventDefault();
			$("#add_comments").load("<?=$this->module?>comments_add/<?=$data["id"]?>/<?=$data["category"];?>");
		});
		
		$("#com_add_save").live("click",function(e){
			e.preventDefault();
			var url="<?=$this->module?>comments_add_save/";
			var data=$("#frm_comment").serialize();
			$.post(url,data,function(ret){
				if(ret=="ok"){
					$("#comment_list").load("<?=$this->module?>comments_list/<?=$data["id"]?>/<?=$data["category"];?>");
					Alert("Message","OK");
				}else{
					Alert("Message","not OK");
				}
			})
		});
		
		$(".comments_reply").live("click",function(e){
			e.preventDefault();
			var url=$(this).attr("rel");
			$("#add_comments").load(url);
		});
		
		$("#com_reply_save").live("click",function(e){
			e.preventDefault();
			var url="<?=$this->module?>comments_reply_save/";
			var data=$("#frm_comment_reply").serialize();
			$.post(url,data,function(ret){
				if(ret=="ok"){
					$("#comment_list").load("<?=$this->module?>comments_list/<?=$data["id"]?>/<?=$data["category"];?>");
					Alert("Message","OK");
				}else{
					Alert("Message","not OK");
				}
			})
		});
		
	});
</script>



