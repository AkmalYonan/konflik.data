<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<!-- Place inside the <head> of your HTML -->
<style>
@import url(https://fonts.googleapis.com/css?family=Monda:400,700);
@import url(https://fonts.googleapis.com/css?family=Open+Sans);
.carousel-caption {
  background-color: transparent;
  position: absolute;
  top:0;
  left:0;
  max-width: 350px;
  padding: 0 5px;
  margin-top: 50px;
  margin-left:20px;
}
.carousel-caption h1,
.carousel-caption h2,
.carousel-caption h3,
.carousel-caption .lead {
  font-family:"Monda";
  margin: 0px;
  line-height: 1.25;
  color: #fff;
  text-shadow: 0 1px 1px rgba(0,0,0,.4);
}
.carousel-caption .btn {
  margin-top: 10px;
}
</style>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <!-- start: page header -->
        <div class="page-header">
            <div class="row"> 
                <div class="col-md-12">
                    <h1>Tambah<small> Carausel</small></h1>
                </div><!-- col -->
            </div><!-- row-->
        </div><!-- end: page-header -->
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
            <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li><a href="<?=base_url()?>admin/slider">Content</a> <span class="divider"></span></li>
			<li><a href="<?=base_url()?>admin/slider"><?=$this->module_title?></a> <span class="divider"></span></li>
            <li class="active">Add</li>
         </ul>
        <!-- end: breadcrumbs -->
   </div><!-- cols -->
</div> <!-- row -->
                        
<div style="padding:0px;">
<div class="row topbar box_shadow">
    <div class="col-md-12">
            <ul class="tab-bar grey-tab">
                <li>
                    <a href="<?php echo $this->module?>">
                        <span class="block text-center">
                            <i class="icon-list"></i> 
                        </span>
                        Daftar <?=$this->module_title?>
                    </a>
                </li>
                <li class="active">
                    <a href="<?php echo $this->module?>add">
                        <span class="block text-center">
                            <i class="icon-plus"></i> 
                        </span>
                        Tambah <?=$this->module_title?>
                    </a>
                </li>
            </ul>
    </div>
</div>
<br>
<div class="row-fluid">
<!--tab content-->
<div class="tab-content">
    
<div id="tab-edit" class="tab-pane active">    
  <form id="fdata" action="<?=$module;?>add" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="author" value="<?=$user_name;?>" />
    <div class="row">
	    <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div id="imgcontainer">
                        <label>Image <span class="help-block" style="display:inline">(Max filesize: 500kb)</span></label>
                        <div style="position:relative"> 
                            <!--<div id="preview" style="border:1px solid grey; width:968px; height:360px; margin:1px" class="img-polaroid"></div>-->
							<img src="<?= base_url();?>assets/images/noimg.jpg" id="previewplay" width="968px" style="height:360px; max-height:360px" class="img-thumbnail">
                            <div style="text-align:left;" class="carousel-caption" style="max-width:600px">
                              <h2 style="text-align:left;" id="s_title">Title</h2>
                              <p style="text-align:left;" id="s_lead" class="lead">Lead..lead..lead</p>
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
                        <textarea name="news_clip" id="news_clip" cols="10" rows="3" class="form-control"><?=$data['news_clip'];?></textarea>
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
	<div class="form-actions">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
    <br />
   </div>

  </form>
</div>

</div>
<!-- en tab-content-->
</div>
</div>

<script>
function readURLplay(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
                $('#previewplay').attr('width', '968px');
                $('#previewplay').attr('height', '360px');
            }
             reader.readAsDataURL(input.files[0]);
        }
    }
   
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>

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
	$("#title").keyup(function(){
		$("#s_title").html($(this).val())
	});
	$("#news_clip").keyup(function(){
		$("#s_lead").html($(this).val())
	});
	$("#buttontext").keyup(function(){
		$("#s_button").html($(this).val())
	});
	$("#buttonurl").keyup(function(){
		$("#s_button").attr("href",$(this).val())
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
			width: 968,
			height: 360,
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
					width: 968,
					height: 360,
					crop: true
				});
				$('#canvas_view').css({margin:"2px 10px 10px 2px",width:968,height:360}).addClass("img-polaroid");
				$('#image_data').show();
				this.embed($('#canvas_view').get(0), {
					width: 968,
					height: 360,
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
