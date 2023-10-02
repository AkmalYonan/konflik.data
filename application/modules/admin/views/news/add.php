<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<!--<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>-->
<script type="text/javascript" src="assets/js/plugin/ckeditor4.4.2/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<!-- Place inside the <head> of your HTML -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$this->module_title?>
    <small>Input Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin/dashboard"><i class="fa fa-desktop"></i> Home</a></li>
    <li><a href="news"> <?=$this->module_title?></a></li>
    <li class="active">Input Berita</li>
  </ol>
</section>


<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">

            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>">
                <i class="fa fa-bars"></i> Daftar Berita
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>add">
                <i class="fa fa-plus"></i> Input Berita
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>" id="refresh">
                <i class="fa fa-refresh"></i> Refresh
            </a>


            <?php 
                if ($message) {
                    echo '<div class="alert alert-warning alert-dismissible" >
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <h4><i class="icon fa fa-warning"></i> Alert!</h4>'.$message.'
                      </div>';
                }
            ?>
            <form id="fdata" action="<?=$module;?>add" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="author" value="<?=$user_name;?>" />
                <div class="box box-default">
                    <div class="box-header with-border">
                      <h3 class="box-title">Tambah Data</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label>News Title</label>
                                        <input type="text" id="title" name="title" class="form-control input-xs required" placeholder="title" value="<?=$data['title'];?>" />
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Type</label>
                                        <select class="form-control" name="category">
                                            <option value="3">News</option>
                                            <!--<option value="2">Announcement</option>-->
                                        </select>
                                    </div>
                                </div>
                                <div class="formSep">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <label>News clip </label>
                                            <textarea name="news_clip" id="news_clip" class="form-control required" rows="3" placeholder="Enter ..."><?=$data['news_clip'];?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <label>News Content</label>
                                        <textarea name="news_content" id="news_content" cols="10" rows="3" class="ckeditor span11 required"><?=$data['news_content'];?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!--<h3 class="heading">Options</h3>-->
                                <div class="formSep">
                                    <div class="row">
                                        <div class="span12">
                                            <div id="imgcontainer">
                                                <label>Image <span class="help-block" style="display:inline">(Max filesize: 500kb)</span></label>
                                                <!--<div id="runtime">No runtime found.</div>-->
                                                <div id="preview" style=" border: 1px solid grey; width:200px; height:200px;" class="img-polaroid"></div>
                                                [ <a href id="pickfiles">Browse</a> ]
                                                <div id="image_data" style="display:none">
                                                <label>Image Title</label>
                                                <input id="image_title" class="form-control" type="text" name="news_image_title" style="width:200px;" />
                                                <label>Image Source</label>
                                                <input id="image_src" type="text" class="form-control" name="news_image_src" style="width:200px;" />
                                                </div>
                                            </div>
                                            <input id="image_name" type="hidden" name="image_name" />
                                        </div>
                                    </div>
                                </div><!-- form separator 
                                <div class="formSep">
                                    <div class="row">
                                        <div class="span12">
                                            <label><span class="error_placement">Headline</span> <span class="f_req">*</span></label><br>
                                                <input name="is_headline" id="optionsRadios1" value="1" type="radio">
                                                Ya &nbsp;&nbsp;
                                                <input name="is_headline" id="optionsRadios2" value="0" type="radio">
                                                Tidak
                                        </div>
                                    </div>
                                </div>--> <!-- form separator -->
                                <div class="formSep">
                                    <div class="row">
                                         <div class="span12">
                                            <? $checked=($data['status'])?" checked":""; ?>
                                            <label>
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
	/*var config = {
		toolbar:
		  [
			 ['Undo', 'Redo', '-', 'SelectAll'],
			 ['Styles','Format', 'Bold', 'Italic', 'Underline','NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
			 ['Image','Table'],
			 ['Link', 'Unlink'], 
			 ['Source'],
		  ]
	};
	$('textarea#news_content' ).ckeditor(config);*/
	$('#news-tab a:first').tab('show');
	$('#news-tab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$("#title-view").html($("#title").val());
		$("#news_clip-view").html($("#news_clip").val());
		$("#news_content-view").html("").html($("textarea#news_content").val());
	});
});

$(function(){
	var ufile=false;
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
				$('#canvas_view').css({margin:"2px 10px 10px 2px",width:200,height:200}).addClass("img-polaroid");
				$('#image_data').show();
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
		if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
			x=true;
			$('#fdata').submit();
		}
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
