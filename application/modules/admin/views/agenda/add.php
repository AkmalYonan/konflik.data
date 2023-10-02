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
    <li><a href="agenda"> <?=$this->module_title?></a></li>
    <li class="active">Input Agenda</li>
  </ol>
</section>


<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">

            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>">
                <i class="fa fa-bars"></i> Daftar Agenda
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>add" id="addData">
                <i class="fa fa-plus"></i> Input Agenda
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>" id="refresh">
                <i class="fa fa-refresh"></i> Refresh
            </a>


            <form id="fdata" action="<?=$module;?>add" method="post" >
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
                                         <input type="hidden" id="category" name="category" class="" placeholder="" value="5" />
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Tanggal</label>
                                            <input type="hidden" id="tgl" name="tgl" value="<?php echo date("Y-m-d");?>" />
                                            <input type="text" id="tgl_" name="tgl_" class="dp1 form-control" value="<?php echo date("d/m/Y");?>" />
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
                                        <textarea name="news_content" id="news_content" cols="10" rows="3" class="ckeditor span11 "><?=$data['news_content'];?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!--<h3 class="heading">Options</h3>-->
                                 <!-- form separator -->
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
	tgl_lahir = $('.dp1').datepicker({
		format:"dd/mm/yyyy"
	}).on('changeDate', function(ev){
		var newDate = new Date(ev.date);
		$("#tgl").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
		$('.dp1').datepicker('hide');
	}).data('datepicker');

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

</script>
