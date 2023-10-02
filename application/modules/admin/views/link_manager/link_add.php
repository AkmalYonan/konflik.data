<?php
	$category=isset($category)?$category:"";
?>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$this->module_title?>
    <small>Input Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin/dashboard"><i class="fa fa-chain"></i> Home</a></li>
    <li><a href="admin/link_manager/link_list"> <?=$this->module_title?></a></li>
    <li class="active">Input Link</li>
  </ol>
</section>


<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">

            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>link_list">
                <i class="fa fa-bars"></i> Daftar Link
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>link_add" id="addData">
                <i class="fa fa-plus"></i> Input Link
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>link_list" id="refresh">
                <i class="fa fa-refresh"></i> Refresh
            </a>

            <?php echo message_box();?>
            <form id="frm" method="post" action="<?php echo $this->module;?>link_add" enctype="multipart/form-data" class="form-horizontal">
    			<input type="hidden" name="act" id="act" value="create"/>

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

	                        	<div class="control-group">
						        	<label for="category" class="control-label">Category/Group</label>
						            <div class="controls">
						            	<?=form_dropdown("category",$this->arr_category,$category,"id='category' class='form-control input-xlarge required'");?>
						            </div>
						        </div><!-- /control-group category-->
						    	<!-- control-group category-->
						         <div class="control-group">
						        	<label for="category" class="control-label">Name</label>
						            <div class="controls">
						            	<input type="text" id="name" name="name" class="form-control input-xlarge required" value="" />
						            </div>
						        </div><!-- /control-group category-->
						     
						     	<div class="control-group">
						        	<label for="description" class="control-label">URL</label>
						            <div class="controls">
						            	<input type="text" id="link_url" name="link_url" class="form-control input-xxlarge required url" value="" />
						            </div>
						        </div>
						       
						        <div class="control-group">
						        	<label for="description" class="control-label">Description</label>
						            <div class="controls">
						            	<textarea class="form-control input-xxlarge" id="description" name="description"></textarea>
						            </div>
						        </div>
						        
						        <div class="control-group">
						        	<label for="description" class="control-label">Image</label>
						            <div class="controls">
						            	<div id="imgcontainer">
						            	<div id="preview" style="border:1px solid grey;width:80px; height:80px;" class="img-polaroid"></div>
						                            [ <a href id="pickfiles">Browse</a> ]
						            	<input id="image_name" type="hidden" name="image" />
						                </div>
						            </div>
						        </div>
						        
						        <div class="control-group">
									<label>
                                      <input type="checkbox" name="publish" checked="checked" id="publish" class="minimal" value="1">
                                        Publish
                                    </label>
						        </div>

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
		$(function(){
			$("#frm").validate();
			
			$(".btn.save").click(function(e){
				e.preventDefault();
				$("#frm").submit();
			});
		});
</script>

<script>
	$(function(){
		var act_link="<?=$this->module?>link";	
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>

<script>
$(function(){
	var ufile=false;
	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash',
		browse_button : 'pickfiles',
		container: 'imgcontainer',
		multi_selection: false,
		url: "<?=base_url()?>test.php",
		max_file_size : '100kb',
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
					width: 80,
					height: 80,
					crop: true
				});
				$('#canvas_view').css({margin:"2px 10px 10px 2px",width:80,height:80}).addClass("img-polaroid");
				$('#image_data').show();
				this.embed($('#canvas_view').get(0), {
					width: 80,
					height: 80,
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
			$('#frm').submit();
		//}
	});
	$('#frm').submit(function(e) {
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