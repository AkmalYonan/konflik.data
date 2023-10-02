<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<!-- Place inside the <head> of your HTML -->
<div class="subheader">
    <div class="container subheader-inner">
    	<h1>Pendaftaran</h1>
    </div>
</div>
<div class="container" style="margin-bottom:20px">
<ul class="breadcrumb" style="margin-left:0; margin-top:-10px">
        <li><a href="#">Home</a> <span class="divider">/</span></li>
        <li><a href="#">News</a> <span class="divider">/</span></li>
        <li class="active">Index</li>
    </ul>
<div class="row-fluid">
<!--tab content-->
  <?php echo form_open("user/auth/register");?>
    <input type="hidden" name="idx" value="<?=$data['id'];?>" />
<div class="tab-content" style="padding:5px">
<div id="tab-edit" class="tab-pane active">    
	<div class="row-fluid">
	    <div class="span12">
            <div class="row-fluid">
                <div class="span7">
                	<h3 class="sub span11" style="border-bottom:2px solid #aaa">User Data</h3>
                    <div class="row-fluid">
                        <div class="span11">
                            <label><?php echo lang('create_user_fname_label', 'first_name');?></label>
                            <?php echo form_input($first_name,false,'class="span12 required"');?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span11">
                            <label><?php echo lang('create_user_lname_label', 'last_name');?></label>
                            <?php echo form_input($last_name,false,'class="span12 required"');?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span11">
                            <label><?php echo lang('create_user_name_label', 'username');?></label>
                            <?php echo form_input($username,false,'class="span12 required"');?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span11">
                            <label><?php echo lang('create_user_email_label', 'email');?></label>
                            <?php echo form_input($email,false,'class="span12 required"');?>
                        </div>
                    </div>
                    
                    <div class="row-fluid">
                        <div class="span11">
                            <label><?php echo lang('create_user_phone_label', 'phone');?></label>
                            <?php echo form_input($phone,false,'class="span12"');?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span11">
                            <label>Alamat</label>
                            <textarea class="span12" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span11">
                            <label><?php echo lang('create_user_password_label', 'password');?></label>
                            <?php echo form_input($password,false,'class="span12 required"');?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span11">
                            <label><?php echo lang('create_user_password_confirm_label', 'password_confirm');?></label>
                            <?php echo form_input($password_confirm,false,'class="span12 required"');?>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <h3 class="sub" style="border-bottom:2px solid #aaa">Lampiran KTP</h3>
                	<div class="row-fluid">
                            <div class="span12">
                                <label>Nomor KTP</label>
                                <?php echo form_input('ktp',false,'class="span12 "');?>
                            </div>
                        </div>
                    	
                        <div class="row-fluid">
                            <div class="span12">
                                <label><span class="help-block" style="display:inline">Lampiran KTP (Max filesize: 200kb)</span></label>
                                <div id="imgcontainer">
                                    <div id="preview" style="width:200px; height:150px;" class="img-polaroid"><?php echo $image_canvas;?></div>
                                    <div id="btn-change" class="img-btn-change"><span><i class="icon-pencil"></i> &nbsp;Attachment</span></div>
                                </div>
                                <input id="image_name" type="hidden" name="image_name" />
                                
                            </div>
                        </div>
                        
                </div> <!-- span6 -->
            </div>
    	</div> <!-- span12 -->
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
    <br />
    <br />
</div>
</div>
<?php echo form_close();?>



</div>
</div>
<script>
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
