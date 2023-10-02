<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<!-- Place inside the <head> of your HTML -->

<div class="subheader">
    <div class="container subheader-inner">
    	<h1>My Profile</h1>
    </div>
</div>
<div class="container" style="margin-bottom:20px">

<div class="row-fluid">
<ul class="nav nav-tabs" id="news-tab">
   <li><a href="#tab-view" class="a_view"><i class="icon-user"></i> View</a></li>
   <li class="active"><a href="#tab-edit" class="a_view"><i class="icon-pencil"></i> Edit</a></li>
   <!--<li><a href="#tab-comments" class="a_view"><i class="icon-comments-alt"></i> Comments</a></li>-->
</ul>
<!--tab content-->
  <form id="fdata" action="<?=$module;?>edit/<?=$data['id'];?>" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="idx" value="<?=$data['id'];?>" />
<div class="tab-content" style="padding:5px">
<?php echo message_box();?>
		<?php
			$others = preg_split("/#/",$data['others']);
			$author = str_replace("Author: ","",$others[0]);
			$ref = str_replace("Reference/Source : ","",$others[1]);
			if ($data['image']) {
				//$image_image = '<img src="assets/image/news/'.$data['news_image'].'" style="float:left; margin:2px 10px 10px 2px" />';
				$image_image = '<span id="canvas_view" style="float:left;margin:2px 10px 10px 2px; " class="img-polaroid"><canvas width="150" height="150" style="background-image:url(assets/image/pages/'.$data['image'].')"></canvas></span>';
				$image_canvas = '<canvas id="myCanvas" width="150" height="150" style="background-image:url(assets/image/pages/'.$data['image'].')"></canvas>';
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
	    <div class="span12">
            <div class="row-fluid">
                <div class="span9">
                	<h5 class="heading">Edit Data</h5>	
                    <div class="row-fluid">
                        <div class="span6">
                            <label>First Name</label>
                            <input type="text" id="first_name" name="first_name" class="span12 required" value="<?=$data['first_name'];?>" />
                        </div>
                        <div class="span6">
                            <label>Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="span12" value="<?=$data['last_name'];?>" />
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <label>Email</label>
                            <input type="text" id="user_email" name="email" class="span12 required" value="<?=$data['email'];?>" />
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <label>Phone</label>
                            <input type="text" id="user_phone" name="phone" class="span12" value="<?=$data['phone'];?>" />
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="formSep">
                        <div class="row-fluid">
                            <div class="span12">
                            	<h5 class="heading">Photo</h5>
                                <label><span class="help-block" style="display:inline">(Max filesize: 200kb)</span></label>
                                <div id="imgcontainer">
                                    <div id="preview" style="width:150px; height:150px;" class="img-polaroid"><?php echo $image_canvas;?></div>
                                    <div id="btn-change" class="img-btn-change"><span><i class="icon-pencil"></i> &nbsp;Change</span></div>
                                </div>
                                <input id="image_name" type="hidden" name="image_name" />
                                <?=$input_image;?>
                            </div>
                        </div>
                    </div><!-- form separator -->
                </div> <!-- span6 -->
            </div>
    	</div> <!-- span12 -->
    </div>
    <div class="row-fluid">
	    <div class="span12">
            <div class="row-fluid">
                <div class="span9">
        			<h5 class="heading">Change Password</h5>	
                    <div class="row-fluid">
                        <div class="span12">
                            <label>New Password</label>
                            <input type="password" id="password" name="password" class="span12" value="" />
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <label>Re-type Password</label>
                            <input type="password" id="confirm_password" equalto="#password" name="confirm_password" class="span12" value="" />
                        </div>
                    </div>
                </div>
            </div>
    	</div> <!-- span12 -->
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
    <br />
    <br />
</div>



<div id="tab-view" class="tab-pane user-profile">    
    <div class="row-fluid">
	    <div class="span6">
           	<h5 class="heading">Edit Data</h5>	
            <div class="row-fluid">
                <div class="span3 tb-field"><label>First Name</label></div>
                <div class="span8 tb-val"><?=$data['first_name'];?>&nbsp;</div>
            </div>
            <div class="row-fluid">
                <div class="span3 tb-field"><label>Last Name</label></div>
                <div class="span8 tb-val"><?=$data['last_name'];?>&nbsp;</div>
            </div>
            <div class="row-fluid">
                <div class="span3 tb-field"><label>Email</label></div>
                <div class="span8 tb-val"><?=$data['email'];?>&nbsp;</div>
            </div>
            <div class="row-fluid">
                <div class="span3 tb-field"><label>Phone</label></div>
                <div class="span8 tb-val"><?=$data['phonr'];?>&nbsp;</div>
            </div>
            <div class="row-fluid">
                <div class="span4">&nbsp;</div>
            </div>
            <div class="row-fluid">
                <div class="span3 tb-field"><label>Last Login</label></div>
                <div class="span8 tb-val"><?=date('F j, Y, g:i a', $data['last_login']);?>&nbsp;</div>
            </div>
            <div class="row-fluid">
                <div class="span3 tb-field"><label>Registered</label></div>
                <div class="span8 tb-val"><?=date('F j, Y', $data['created_on']);?>&nbsp;</div>
            </div>
        </div>
	    <div class="span3">
        	<div class="formSep">
                <div class="row-fluid">
                    <div class="span12">
           				<h5 class="heading">Photo</h5>	
                             <label><span class="help-block" style="display:inline">(Max filesize: 200kb)</span></label>
                            <!--<div id="runtime">No runtime found.</div>-->
                            <div id="preview_view" style="width:150px; height:150px;" class="img-polaroid"><?php echo $image_canvas;?></div>
                	</div>
                </div>
            </div><!-- form separator -->
        </div> <!-- span6 -->
    </div>
    <br />
    <br />
</div>
<div id="tab-comments" class="tab-pane">    
    <div class="row-fluid">
	    <div class="span9">
            <div class="row-fluid">
                <div class="span12">
	<? modules::load('wg/comments')->comments_list2($data["idx"],1);?>
				</div>
            </div>
       </div>
    </div>
</div>
</div>
</form>



</div>
</div>
<script>

</script>
<script>  
$(document).ready(function () {
	var act_link="<?=$this->module?>";	
	var tab_active = <?=($_GET['tab'])?$_GET['tab']:0;?>;
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
	$('textarea#content' ).ckeditor(config);
	$('#news-tab a').eq(tab_active).tab('show');
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
		browse_button : 'btn-change',
		container: 'imgcontainer',
		multi_selection: false,
		url: "<?=base_url()?>test.php",
		max_file_size : '200kb',
		resize: {
			width: 150,
			height: 150,
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
					width: 150,
					height: 150,
					crop: true
				});
				$('#canvas_view').css({margin:"2px 10px 10px 2px"});
				$('#canvas_view').css({width:150,height:150});
				this.embed($('#canvas_view').get(0), {
					width: 150,
					height: 150,
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



