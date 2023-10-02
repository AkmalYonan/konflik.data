<div class="row">
<div class="col-md-12">
<a id="browse" class="btn btn-xs btn-primary" href="javascript:;">[+] Peta</a> 
<a id="start-upload" class="btn btn-xs btn-primary hide" href="javascript:;">[Start Upload]</a>
<br>
<ul id="filelist"></ul>
<div class="table-responsive" style="overflow-y:hidden;overflow-x:auto">
<table id="table_file_peta" class="table table-condensed file_list table-bordered">
<thead>
<tr><td width="10px">#</td><td>File</td><td width="10px">#</td></tr>
</thead>
<tbody>
	<? if(cek_array($data_file_peta2)):?>
                                <? foreach($data_file_peta2 as $xfilep=>$filep):?>
                                    <tr class='file_row' id="file_peta_<?=$filep["id_file"]?>" data-file_id="<?=$filep["id_file"]?>">
        <td><input type="hidden" name="peta_file_id[]" value="<?=$filep["id_file"]?>"/><a href="./<?=$filep["file_path"]?>" class='file_open' target='_blank'><i class="icon-search"></i> </a></td><td>
        <label style='height:auto;'><?=$filep["file_name"]?></label></td><td><a href="" class='peta_file_remove red'><i class="icon-remove"></i> </a></td></tr>
                                <? endforeach;?>
                            <? endif;?>
</tbody>
</table>
</div>
</div></div>
<script id="tmp_file_peta" type="text/x-jquery-tmpl">
	<tr class='file_row' id="file_peta_${idx}" data-file_id="${idx}">
	<td><input type="hidden" name="peta_file_id[]" value="${idx}"/><a href="./${relative_path}" class='file_open' target='_blank'><i class="icon-search"></i> </a></td><td>
	<label style='height:auto;'>${file_name}</label></td><td><a href="" class='peta_file_remove red'><i class="icon-remove"></i> </a></td></tr>
</script>

<script>
	//test plupload
	$(function(){
	var uploader = new plupload.Uploader({
		  browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
		  url: '<?=base_url()?><?=$this->module?>upload_peta',
		  flash_swf_url : 'http://rawgithub.com/moxiecode/moxie/master/bin/flash/Moxie.cdn.swf',
		  file_data_name:'userfile',
		  multipart : true,
		  multipart_params : {id_wa : '<?=$data["idx"]?>'},
		});
		 
		uploader.init();
		
		uploader.bind("FileUploaded",function(up,file,info){
			var response=JSON.parse(info.response);
			console.log(response);
			if(response.status=='ok'){
				$("#"+file.id).hide().remove();
				var data=response.data_file;
				console.log(data);
				//data["data_str"]=JSON.stringify(data);
				var tmpFile="tmp_file_peta";
				//$("#"+tmpFile).tmpl(data).appendTo('#table_file_peta tbody');
				$('#table_file_peta tbody').append($("#"+tmpFile).tmpl(data));
				//console.log(data);
			}
		}); 
		 
		uploader.bind('FilesAdded', function(up, files) {
		  //alert(JSON.stringify(up));
		  //alert(JSON.stringify(files));
		  
		  var html = '';
		  plupload.each(files, function(file) {
			html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b><a href="#" class="a_file_remove red"><i class="icon-remove"></i></a></li>';
		  });
		  document.getElementById('filelist').innerHTML += html;
		  uploader.start();
		});
		 
		uploader.bind('UploadProgress', function(up, file) {
		  document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
		});
		 
		uploader.bind('Error', function(up, err) {
		  document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		});
		 
		 $("#start-upload").click(function(){
		 	uploader.start();
		 });
		
		
		$("#filelist").on("click",".a_file_remove",function(e){
			e.preventDefault();
			var that=$(this);
			var li=that.closest("li");
			var file_id=li.attr("id");
			uploader.removeFile(uploader.getFile(file_id));
			li.remove();
		});
	})
	
	$(function(){
		$(document).on("click","a.peta_file_remove",function(e){
			e.preventDefault();
			var that=$(this);
			var id=that.closest("tr").data("file_id");
			$.post("<?=base_url()?><?=$this->module?>delete_peta_file/"+id,function(ret){
				if(ret=="ok"){
					that.closest("tr").slideUp().remove();
				}
			}); //end ajax
			
		});
	
	})
	
</script>