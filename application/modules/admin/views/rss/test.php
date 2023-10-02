<?
$result = ($key)?"Keywords: <strong>".$key."</strong>":"&nbsp;"; 
?>
<div id="breadcrumbs">
    <ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider"><i class="icon-angle-right"></i></span></li>
    <li><a href="#">News</a> <span class="divider"><i class="icon-angle-right"></i></span></li>
    <li class="active">List</li>
    </ul>
</div>
<div class="navbar" style="padding:0; margin:0;">
      <div class="navbar-inner" style="padding-left:15px; border-bottom:1px solid #ccc">
        <div class="container">
          <div class="nav-collapse collapse navbar-responsive-collapse">
            <ul class="nav subnav">
            <li>
                <button class="btn" href="admin/news/add"><i class="icon-file-alt"></i></button>
                <button class="btn" href="apa2/"><i class="icon-refresh"></i>&nbsp;Refresh</button>
            </li>
            </ul>
            <form id="fsearch" class="navbar-search pull-left" action="">
              <div class="input-append">
                <input id="key_list" class="span2" id="appendedInput" type="text">
                <span class="add-on" id="button_list">&nbsp;<i class="icon-search"></i>&nbsp;</span>
            </div>
            </form>
          </div><!-- /.nav-collapse -->
        </div>
      </div><!-- /navbar-inner -->
    </div><!-- /navbar -->
<div style="padding:10px;">
<div class="row-fluid" style="border-bottom:5px solid #ccc">
    <div class="span8" style="padding-left:5px"><?=$result;?></div>
    <div class="span4"><div class="pull-right">Data <?=$data_start;?> - <?=$data_end;?>, Total: <?=$total_rows;?></div></div>
</div>
<div id="tabs-0" style="border-bottom:1px solid #ddd; margin-bottom:10px">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
        <th width="50">&nbsp;</th>
        <th width="20">No.</th>
        <th width="20">&nbsp;</th>
        <th class="forder" width="100" rel="date">Date</th>
        <th class="forder" width="300" rel="title">Title/Judul</th>
        <th >News Clip</th>
        <!--<td class="tbldata_header forder">Alamat</td>-->
        <th width="100">Publish</th>
        </tr>
        </thead>
        <tbody>
  <? if (is_array($arrDB)) { foreach($arrDB as $k=>$v) {
  		$tr_color=($k%2)?"#fff":"#fafafa";
		
		$url_edit = $module."edit/".$v['idx'];
		$url_delete = $module."delete/".$v['idx'];
		
		$status_badges = ($v['status'])?'<span class="label label-info">Published</span>':'<span class="label label-warning">Draft</span>';
		
   ?>
            	<tr>
					<td>
                    	<div class="btn-groups">
                        <a class="btn btn-small btn-primary" href="<?=$url_edit;?>"><i class="icon-edit icon-white"></i></a>
                        <a class="btn btn-small btn-danger" href="<?=$url_delete;?>"><i class="icon-trash icon-white"></i></a>
                        </div>
                            
                    </td>               
                    <td><?=($data_start+$k);?></td> 	
                    <td></td> 	
                    <td rel="date_col"><?=$v['date_formatted'];?></td>
                    <td rel="title_col"><a href="<?=$url_edit;?>"><?=$v['title'];?></a></td>
                    <td><?=$v['news_clip'];?></td>
                    <td><?=$status_badges;?></td>
            	</tr>
        <? } }?>
        </tbody>
        </table>

        </td>
      </tr>
    </table>
    </div>

<div class="row-fluid">
    <div class="span10" style="padding-left:5px"><?=$perpage.$paging;?></div>
    <div class="span2"><div class="pull-right">Data <?=$data_start;?> - <?=$data_end;?>, Total: <?=$total_rows;?></div></div>
</div>
<br />
<br />
</div>
<script>  
	var forder='<?=$forder;?>';
	var dorder='<?=$dorder;?>';
    $(document).ready(function () {
		$("li[rel~='cms1']").addClass("mmenuactive");
		
		$("#button_list").click(function(){
			var key=($("#key_list").val())?$("#key_list").val():'0';
			var prc=$("#page_record").val();
			var order=(forder!='' && dorder!='')?forder+':'+dorder:0;
			window.location.href='<?=$module;?>index/'+key+'/'+order+'/'+prc+'/1';
		});
		
		$("#page_record").live("change",function(){
			$("#button_list").trigger("click");
		});
		
		$(".forder[rel~='<?=$forder;?>']").append('<span style="margin-right:5px; float:right"><img src="assets/image/app/<?=$dorder;?>.gif" align="absmiddle"></span>');
		$("td[rel~='<?=$forder;?>_col']:odd").css('background-color',"#fafafa");
		$("td[rel~='<?=$forder;?>_col']:even").css('background-color',"#f4f4f4");
		//$("td[rel~='<?=$forder;?>_col']").css('font-weight',"bold");
		$(".forder").click(function(){
			if (forder==$(this).attr("rel")) {
				dorder=(dorder=='desc')?'asc':'desc';
			}
			else {
				dorder='asc';
			}
			forder=$(this).attr("rel");
			$("#button_list").trigger("click");
		});
    })
</script>
<?php
// function upload_my_photo() {
	// header('Content-type: text/plain; charset=UTF-8');
	// header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	// header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	// header("Cache-Control: no-store, no-cache, must-revalidate");
	// header("Cache-Control: post-check=0, pre-check=0", false);
	// header("Pragma: no-cache");

	//Settings
	// $targetDir = "./uploads/gallery/";
	// $cleanupTargetDir = false;
	// $maxFileAge = 60 * 60;
	// @set_time_limit(5 * 60);

	//Get parameters
	// $chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
	// $chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
	// $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

	//Clean the fileName for security reasons
	// $fileName = preg_replace('/[^\w\._]+/', '', $fileName);

	//Create target dir
	// if (!file_exists($targetDir))
	// @mkdir($targetDir);

	// if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
	// while (($file = readdir($dir)) !== false) {
	// $filePath = $targetDir . DIRECTORY_SEPARATOR . $file;

	//Remove temp files if they are older than the max age
	// if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
	// @unlink($filePath);
	// }

	// closedir($dir);
	// } else
	// die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');

	// if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
		// $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

	// if (isset($_SERVER["CONTENT_TYPE"]))
	// $contentType = $_SERVER["CONTENT_TYPE"];

		// if (strpos($contentType, "multipart") !== false) {
			// if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
			// $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			// if ($out) {
			// $in = fopen($_FILES['file']['tmp_name'], "rb");
			// if ($in) {
			// while ($buff = fread($in, 4096))
			// fwrite($out, $buff);
			// } else
			// die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

			// fclose($out);
			// unlink($_FILES['file']['tmp_name']);
			// } else
			// die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			// } else
			// die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		// } else {
			// $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			// if ($out) {
			// $in = fopen("php://input", "rb");
			// if ($in) {
			// while ($buff = fread($in, 4096))
			// fwrite($out, $buff);
			// } else
			// die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

			// fclose($out);
			// } else
			// die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		// }
	// }
?>