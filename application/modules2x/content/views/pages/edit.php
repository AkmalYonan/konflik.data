<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<!--<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>-->
<script type="text/javascript" src="assets/js/plugin/ckeditor4.4.2/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<!-- Place inside the <head> of your HTML -->

<!--<div id="breadcrumbs" class="breadcrumbs-fixed">
    <ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider">\</span></li>
    <li><a href="#">Content</a> <span class="divider">\</span></li>
    <li class="active"><?//=$page['description']?></li>
    </ul>
</div>-->
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <!-- start: page header -->
        <div class="page-header">
            <div class="row"> 
                <div class="col-md-12">
                    <h1><?=$page['description']?><small> </small></h1>
                </div><!-- col -->
              </div><!-- row-->
        </div><!-- end: page-header -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li><a href="<?=base_url()."admin/pages/index/damkar/"?>">Content</a> <span class="divider"></span></li>
            <li class="active"><?=$page['description']?></li>
         </ul>
        <!-- end: breadcrumbs -->
   </div><!-- cols -->
</div> <!-- row -->
             
<div style="padding:0px;">
<div class="page-header">
	<h1>Pages <small>&bull; <?=($data['idx'])?"Edit":"Write"?> </small></h1>
</div>
<!--
<div class="toolbar">
    <div class="pull-left">
        <div class="btn-group">
            <a href="javascript:history.back()" class="btn"><i class="icon-arrow-left bc-icon"></i></a>
        </div>
    </div>
    <div class="clearfix" style="height:30px"></div>
</div>
-->
<br>
<div class="row-fluid">
<!--<ul class="nav nav-tabs" id="news-tab">
   <li class="active"><a href="#tab-edit" class="a_view"><i class="icon-edit"></i> <?=($data['idx'])?"Edit":"Write"?> </a></li>
</ul>-->
<!--tab content-->
  <form id="fdata" action="<?=$this->module;?><?=($data['idx'])?"edit":"add"?>" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="editor" value="<?=$user_name;?>" />
    <input type="hidden" name="author" value="<?=$data['author'];?>" />
    <input type="hidden" name="idx" value="<?=$data['idx'];?>" />
    <input type="hidden" name="name" value="<?=$page['category'];?>" />
    <input type="hidden" name="category" value="<?=$page['idx'];?>" />
    <input type="hidden" name="others" value="<?=$page['idx'];?>" />
<div class="tab-content">
<?php echo message_box();?>
<div id="tab-edit" class="tab-pane active">    
    <div class="row-fluid">
	    <div class="span11">
            <label><?=($data['idx'])?"Edit":"Write"?> Page: <strong><?=$page['description']?></strong></label>
            <textarea name="content" id="news_content" style="width:968px" class="ckeditor required"><?=$data['content'];?></textarea>
        </div>
    </div> 
</div><br>
    <div class="row-fluid">
	    <div class="span11">
            <div class="formSep">
                <div class="row-fluid">
                     <div class="span12">
                        <? $checked=($data['status'])?" checked":""; ?>
                        <label  class="checkbox inline">
                            <input style="margin-left:5px;" type="checkbox" value="1" name="status"<?=$checked;?> />
                            &nbsp; Publish
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
    <br />
</div>

</div>
</form>
<!-- en tab-content-->
</div>
</div>
<script>

</script>
<script>  
$(document).ready(function () {
	var act_link="<?=$this->module?>index/<?=$page['category'];?>";		
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
			 ['Undo', 'Redo', '-', 'SelectAll'],[],
			 ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'],
			 ['Styles','Format', 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote'],['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
			 ['Image','Table'],
			 ['Link', 'Unlink'], 
			 ['Source'],
		  ],
		height:'500px'
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
		max_file_size : '200kb',
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
