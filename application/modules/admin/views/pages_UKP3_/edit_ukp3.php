<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<!--<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>-->
<script type="text/javascript" src="assets/js/plugin/ckeditor4.4.2/ckeditor.js"></script>
<script type="text/javascript" src="assets/js/plugin/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<!-- Place inside the <head> of your HTML -->

<div class="row">
    <div class="col-sm-12 col-lg-12">
        <!-- start: page header -->
        <div class="page-header">
            <div class="row"> 
                <div class="col-md-12">
                    <h1><?=$this->module_title2?><small> Edit </small></h1>
                </div><!-- col -->
              </div><!-- row-->
        </div><!-- end: page-header -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
            <li><a href="<?=base_url()?>admin/"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li><a href="<?=$this->module?>">Layanan</a> <span class="divider"></span></li>
			<li><a href="<?=$this->module?>"><?=$this->module_title?></a> <span class="divider"></span></li>
            <li class="active">Edit</li>
         </ul>
        <!-- end: breadcrumbs -->
        
   </div><!-- cols -->
</div> <!-- row -->
             
<div style="padding:0px">
<div class="row topbar box_shadow">
    <div class="col-md-12">
            <ul class="tab-bar grey-tab">
                <li>
                    <a href="<?php echo $this->module?>">
                        <span class="block text-center">
                            <i class="icon-list"></i> 
                        </span>
                        Daftar <?=$this->module_title2?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $this->module?>add">
                        <span class="block text-center">
                            <i class="icon-plus"></i> 
                        </span>
                        Add <?=$this->module_title?>
                    </a>
                </li>
				<li class="active">
                    <a href="javascript:void(0)">
                        <span class="block text-center">
                            <i class="icon-pencil"></i> 
                        </span>
                        Edit <?=$this->module_title?>            
					</a>
                </li>
				<li class="pull-right">
                    <a class="red" onclick="return confirm('Anda yakin akan menghapus data ini?');" href="admin/rss/delete/<?=$data['idx'];?>">
                        <span class="block text-center">
                            <i class="icon-remove red"></i> 
                        </span>
                        Delete <?=$this->module_title?>                    
					</a>
                </li>
            </ul>
    	<!--<form class="search_form col-md-3 pull-right" action="<?//=$this->module?>listview" method="get">
        	<?php //$this->load->view("widget/search_box_db"); ?>
        </form>-->
    </div>
</div>
<?php echo message_box();?>
<div class="row-fluid">
	<ul class="nav nav-tabs" id="news-tab">
	   <li class="active"><a href="#tab-edit" class="a_view"><i class="icon-edit"></i> Edit</a></li>
	   <!--<li><a href="#tab-view" class="a_view"><i class="icon-eye-open"></i> View</a></li>
	   <li><a href="#tab-comments" class="a_view"><i class="icon-comments-alt"></i> Comments</a></li>-->
	</ul>
	<!--tab content-->
	<form id="fdata" action="<?=$module;?>edit_ukp3" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="editor" value="<?=$user_name;?>" />
		<input type="hidden" name="author" value="<?=$data['author'];?>" />
		<input type="hidden" name="idx" value="<?=$data['idx'];?>" />
<div class="tab-content">
		<?php
			// if ($data['image']) {
				//$image_image = '<img src="assets/image/news/'.$data['image'].'" style="float:left; margin:2px 10px 10px 2px" />';
				// $image_image = '<span id="canvas_view" style="float:left;margin:2px 10px 10px 2px; " class="img-polaroid"><canvas width="200" height="200" style="background-image:url('.$this->config->item('dir_ppid').'assets/image/news/'.$data['image'].')"></canvas></span>';
				// $image_canvas = '<canvas id="myCanvas" width="200" height="200" style="background-image:url('.$this->config->item('dir_ppid').'assets/image/news/'.$data['image'].')"></canvas>';
				// $input_image = '<input id="image_name_old" type="hidden" name="image_name_old" value="'.$data['image'].'" />';
				// $image_data = "block";
			// }
			// else {
				// $image_image = '<span id="canvas_view" style="float:left;margin:0; " class="img-polaroid"><canvas width=0 height=0></canvas></span>';			
				// $image_data = "none";
			// }
		?>
<div id="tab-edit" class="tab-pane active">    
    <div class="row">
	    <div class="col-md-9">
            <div class="row">
                <div class="col-md-8">
                    <label>Wilayah</label>
                    <input type="text" id="wilayah" name="wilayah" class="form-control input-xs required" value="<?=$data['wilayah'];?>" />
                </div>
                <div class="col-md-8">
                    <label>Nama</label>
                    <input type="text" name="nama" id="nama" cols="10" rows="3" class="form-control required" value="<?=$data['nama'];?>" />
                </div>
                 <?
						if ($data['tanggal']) {
							$date = preg_split("/ /",$data['tanggal']);
						}
					?>
                <div class="col-md-8">
                     <label>Date(Y-M-D)</label>
                     <div class="input-group">
						<input name="date" id="dp3" class="form-control timepicker" data-date-format="yyyy-mm-dd" type="text" size="10" value="<?=$date[0];?>">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
					</div>  
                     
                </div>
                <div class="col-md-8">
                    <label>Kontak Email</label>
                    <input type="text" name="kontak_fasilitator" id="kontak_fasilitator" class="form-control required" value="<?=$data['kontak_fasilitator'];?>" />
                </div>
                <div class="col-md-8">
                    <label>Kontak HP</label>
                    <input type="text" name="kontak_fasilitator_2" id="kontak_fasilitator_2" class="form-control " value="<?=$data['kontak_fasilitator_2'];?>" />
                </div>
                <div class="col-md-8">
                    <label>Alamat BRWA</label>
                    <textarea name="alamat_brwa" id="alamat_brwa"  class="form-control" ><?=$data['alamat_brwa'];?></textarea>
                </div>
				<div class="row">
                     <div class="col-md-8">
						<br>
                        <? $checked=($data['status'])?" checked":""; ?>
                        <label>
                            <input type="checkbox" value="1" name="status"<?=$checked;?> />
                            Publish
                        </label>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
    <br />
</div>
<div id="tab-comments" class="tab-pane">    
    <div class="row-fluid">
	    <div class="span9">
            <div class="row-fluid">
                <div class="span12">
					<? //modules::load('wg/comments')->comments_list2($data["idx"],4);?>
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
