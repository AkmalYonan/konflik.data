<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="assets/js/plugin/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<!-- Place inside the <head> of your HTML -->

<div id="breadcrumbs" class="breadcrumbs-fixed">
    <ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider">\</span></li>
    <li><a href="#">Content</a> <span class="divider">\</span></li>
    <li><a href="admin/news">News</a> <span class="divider">\</span></li>
    <li class="active">Edit</li>
    </ul>
</div>
             
<div style="padding:40px 25px">
<div class="page-header">
	<h1>News <small>&bull; Edit </small></h1>
</div>
<div class="toolbar">
    <div class="pull-left">
        <div class="btn-group">
            <a href="javascript:history.back()" class="btn"><i class="icon-arrow-left bc-icon"></i></a>
            <a href="admin/news/" class="btn"><i class="icon-list bc-icon"></i> List</a>
            <a href="admin/news/add" class="btn"><i class="icon-plus bc-icon"></i> Add</a>
        </div>
        <a href="admin/news/delete/<?=$data['idx'];?>" class="btn btn-danger"><i class="icon-remove bc-icon"></i> Delete</a>
    </div>
    <div class="clearfix" style="height:30px"></div>
</div>
<br>
<div class="row-fluid">
<ul class="nav nav-tabs" id="news-tab">
   <li class="active"><a href="#tab-edit" class="a_view"><i class="icon-edit"></i> Edit</a></li>
   <li><a href="#tab-view" class="a_view"><i class="icon-eye-open"></i> View</a></li>
   <li><a href="#tab-comments" class="a_view"><i class="icon-comments-alt"></i> Comments</a></li>
</ul>
<!--tab content-->
  <form id="fdata" action="<?=$module;?>edit" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="editor" value="<?=$user_name;?>" />
    <input type="hidden" name="author" value="<?=$data['author'];?>" />
    <input type="hidden" name="idx" value="<?=$data['idx'];?>" />
<div class="tab-content">
<?php echo message_box();?>
		<?php
			
			if ($data['image']) {
				//$image_image = '<img src="assets/image/news/'.$data['image'].'" style="float:left; margin:2px 10px 10px 2px" />';
				$image_image = '<span id="canvas_view" style="float:left;margin:2px 10px 10px 2px; " class="img-polaroid"><canvas width="200" height="200" style="background-image:url(assets/image/news/'.$data['image'].')"></canvas></span>';
				$image_canvas = '<canvas id="myCanvas" width="200" height="200" style="background-image:url(assets/image/news/'.$data['image'].')"></canvas>';
				$input_image = '<input id="image_name_old" type="hidden" name="image_name_old" value="'.$data['image'].'" />';
				$image_data = "block";
			}
			else {
				$image_image = '<span id="canvas_view" style="float:left;margin:0; " class="img-polaroid"><canvas width=0 height=0></canvas></span>';			
				$image_data = "none";
			}
		?>
<div id="tab-edit" class="tab-pane active">    
    <div class="row-fluid">
	    <div class="span9">
            <div class="row-fluid">
                <div class="span8">
                    <label>News Title</label>
                    <input type="text" id="title" name="title" class="span12 required" value="<?=$data['title'];?>" />
                </div>
                <div class="span4">
                    <label>Type</label>
                    <select name="category">
                    	<option value="3"<?=($data['category']==3)?" selected":"";?>>News</option>
                        <option value="2"<?=($data['category']==2)?" selected":"";?>>Announcement</option>
                    </select>
                </div>
            </div>
            <div class="formSep">
                <div class="row-fluid">
                    <div class="span8">
                        <label>News clip</label>
                        <textarea name="news_clip" id="news_clip" cols="10" rows="3" class="span12 required"><?=$data['clip'];?></textarea>
                    </div>
                    <?
						if ($data['created']) {
							$date = preg_split("/ /",$data['created']);
						}
					?>
                    <div class="span4">
                    <label>Date (Y-m-d)</label>
                        <div class="input-append date" id="dp3" data-date="<?=$date[0];?>" data-date-format="yyyy-mm-dd">
                        <input name="news_date" class="span11" type="text" value="<?=$date[0];?>">
                        <span class="add-on"><i class="icon-calendar-empty"></i></span>
                        </div>
                </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <label>News Content</label>
                    <textarea name="news_content" id="news_content" cols="10" rows="3" class="span11 required"><?=$data['content'];?></textarea>
                </div>
            </div>
        </div>
	    <div class="span3">
        	<div class="formSep">
                <div class="row-fluid">
                    <div class="span12">
                        <div id="imgcontainer">
                        	<label>Image <span class="help-block" style="display:inline">(Max filesize: 200kb)</span></label>
                            <!--<div id="runtime">No runtime found.</div>-->
                            <div id="preview" style="width:200px; height:200px;" class="img-polaroid"><?php echo $image_canvas;?></div>
                            [ <a href id="pickfiles">Browse</a> ]
                            <div id="image_data" style="display:<?=$image_data;?>">
                                <label>Image Title</label>
                                <input id="image_title" type="text" name="news_image_title" value="<?=$data['image_title'];?>" style="width:200px;" />
                                <label>Source</label>
                                <input id="image_src" type="text" name="news_image_src" value="<?=$data['image_src'];?>" style="width:200px;" />
                            </div>
                        </div>
                        <input id="image_name" type="hidden" name="image_name" />
                        <?=$input_image;?>
                	</div>
                </div>
            </div><!-- form separator -->
        	<div class="formSep">
                <div class="row-fluid">
                    <div class="span12">
                        <label><span class="error_placement">Headline</span> <span class="f_req">*</span></label>
                        <label class="radio inline">
                            <input type="radio" value="1" name="is_headline" />
                            Ya
                        </label>
                        <label class="radio inline">
                            <input type="radio" value="0" name="is_headline" />
                            Tidak
                        </label>
                     </div>
                </div>
            </div> <!-- form separator -->
            <div class="formSep">
                <div class="row-fluid">
                     <div class="span12">
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
    <br />
</div>



<div id="tab-view" class="tab-pane">    
    <div class="row-fluid">
	    <div class="span9">
            <div class="row-fluid">
                <div class="span12">
                    <h1 id="title-view"><?=$data['title'];?></h1>
                    <p>
                    <blockquote id="news_clip-view">
                    <?=$data['clip'];?>
                    </blockquote>
                    </p>
                    <?=$image_image;?>
                    <p id="news_content-view">
                    </p>
                </div>
            </div>
        </div> 
    </div>
    <br />
    <br />
</div>
<div id="tab-comments" class="tab-pane">    
    <div class="row-fluid">
	    <div class="span9">
            <div class="row-fluid">
                <div class="span12">
	<? modules::load('wg/comments')->comments_list2($data["idx"],4);?>
				</div>
            </div>
       </div>
    </div>
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
	$('#dp3').datepicker().on('changeDate', function(ev){
		$('#dp3').datepicker('hide');
	});
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
	$('textarea#news_content' ).ckeditor(config);
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
