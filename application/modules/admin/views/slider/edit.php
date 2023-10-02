<? if ($redirect) { ?>
	<div style="padding:40px 25px">
        <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        News Added.
        </div>
    </div>
    <script>window.location.href='/portal/admin/slider';</script>
<? } else { ?>
<?php $id=$this->encrypt_status==TRUE?encrypt($data['idx']):$data['idx']; ?>
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

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$this->module_title?>
    <small>Edit Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin/dashboard"><i class="fa fa-desktop"></i> Home</a></li>
    <li><a href="wilayah/wilayah"> <?=$this->module_title?></a></li>
    <li class="active">Edit Data Carousel</li>
  </ol>
</section>


<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">

            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>">
                <i class="fa fa-bars"></i> Daftar Carousel
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>add" id="addData">
                <i class="fa fa-plus"></i> Input Carousel
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>" id="refresh">
                <i class="fa fa-refresh"></i> Refresh
            </a>
            <?php echo message_box();?> 
            <?
                if ($data['image']) {
                    $bg_image = 'background-image:url(../assets/image/pages/'.$data['image'].')';
                    $image_data = "block";
                }
                else {
                    $bg_image = '';         
                    $image_data = "none";
                }
                if ($data['others']) {
                    $split = preg_split("/#/",$data['others']);
                }
            ?>


            <form id="fdata" action="<?=$module;?>edit" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="author" value="<?=$user_name;?>" />
                <input type="hidden" name="idx" value="<?=$data['idx'];?>" />

                <div class="box box-default">
                    <div class="box-header with-border">
                      <h3 class="box-title">Edit Data</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="imgcontainer">
                                            <label>Image <span class="help-block" style="display:inline">(Max filesize: 500kb)</span></label>
                                            <!--<div id="runtime">No runtime found.</div>-->
                                            <div style="position:relative"> 
                                                <div id="preview" style="width:968px; height:360px; margin:1px;<?=$bg_image;?>;background-size: 100% 100%;" class="img-polaroid"></div>
                                                <div style="text-align:left;" class="carousel-caption" style="max-width:600px">
                                                  <h2 id="s_title"><?=$data['title'];?></h2>
                                                  <p id="s_lead" class="lead"><?=$data['clip'];?></p>
                                                  <a id="s_button" class="btn btn-large btn-warning <?=$split[1]?'':'hidden';?>" href="<?=$split[1];?>" target="_blank"><?=$split[0];?></a>
                                                </div>
                                            </div>
                                            <a class="btn btn-default" href id="pickfiles">Browse </a>
                                            
                                        </div>
                                            <input id="image_name" type="hidden" name="image_name" />
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
                                            <textarea name="news_clip" id="news_clip" cols="10" rows="3" class="form-control"><?=$data['clip'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Button Text</label>
                                            <input type="text" id="buttontext" name="button" class="form-control" value="<?=$split[0];?>" />
                                        </div>
                                        <div class="col-md-8">
                                            <label>URL</label>
                                            <input type="text" id="buttonurl" name="url" class="form-control" value="<?=$split[1];?>" <?=$split[1]?'':'disabled="disabled"';?> />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="formSep">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="image_data" style="display:<?=$image_data;?>">
                                                <label>Image Source</label>
                                                <input id="image_src" class="form-control" type="text" name="news_image_src" style="width:200px;" value="<?=$data['image_src'];?>" />
                                                </div>
                                         </div>
                                    </div>
                                </div> <!-- form separator -->
                                <div class="formSep">
                                    <div class="row">
                                         <div class="col-md-12">
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
	$("#title").on('keyup blur', function(){
		$("#s_title").html($(this).val())
	});
	$("#news_clip").on('keyup blur', function(){
		$("#s_lead").html($(this).val())
	});
	$("#buttontext").on('keyup blur', function(){
		if ($(this).val()) {
			$("#s_button").html($(this).val());
			$("#s_button").removeClass("hidden");
			$("#buttonurl").attr("disabled",false);
		}
		else {
			$("#s_button").addClass("hidden");
			$("#buttonurl").attr("disabled",true);
		}
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
<? }  ?>