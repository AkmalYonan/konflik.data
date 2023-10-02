<? if ($delete) { ?>
    <div style="padding:40px 25px">
        <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        News Deleted !
        </div>
    </div>
    <script>window.location.href='admin/news';</script>
<? } else { ?>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<!-- Place inside the <head> of your HTML -->

<div id="breadcrumbs" class="breadcrumbs-fixed">
    <ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider">\</span></li>
    <li><a href="#">Content</a> <span class="divider">\</span></li>
    <li><a href="admin/news">News</a> <span class="divider">\</span></li>
    <li class="active">Delete</li>
    </ul>
</div>
             
<div style="padding:40px 25px">
<div class="page-header">
	<h1>News <small>&bull; Delete </small></h1>
</div>
<div class="toolbar">
    <div class="pull-left">
        <div class="btn-group">
            <a href="javascript:history.back()" class="btn"><i class="icon-arrow-left bc-icon"></i></a>
            <a href="admin/news/" class="btn"><i class="icon-list bc-icon"></i> List</a>
            <a href="admin/news/add" class="btn"><i class="icon-plus bc-icon"></i> Add</a>
        </div>
        <div class="btn-group">
            <a href="admin/news/edit/<?=$data['idx'];?>" class="btn"><i class="icon-edit bc-icon"></i> <i class="icon-eye-open bc-icon"></i> Edit/View</a>
        </div>
    </div>
    <div class="clearfix" style="height:30px"></div>
</div>
<br>
<div class="row-fluid">
<ul class="nav nav-tabs" id="news-tab">
  <form id="fdata" action="<?=$module;?>delete" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="reg_id" value="<?=$_SESSION['s_regid'];?>" />
    <input type="hidden" name="idx" value="<?=$data['idx'];?>" />
<div class="tab-content">
<div id="tab-edit" class="tab-pane active">    
    <div class="row-fluid">
	    <div class="span9">
            <div class="row-fluid">
                <div class="span12">
                   <div class="alert alert-error">
                    <h4>Warning!</h4>
                    Delete News with title <strong>"<?=$data['title'];?>"</strong> ??...<br /><br />
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a href="javascript:history.back();" type="reset" class="btn">Cancel</a>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <br />
    <br />
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
	var act_link="<?=$this->module?>";		
	$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	
	$("#button_submit").click(function(e){
		$("#fdata").submit();
		e.preventDefault();
	});
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
<? }  ?>