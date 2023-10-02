
<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?
	$arrDoc["ID_LAM"]="File Lampiran";
	
?>

<input type="hidden" id="doc_list" name="doc_list" value="<?=join(",",array_keys($arrDoc));?>"/>
<div class="row">
	<div class="col-md-12">
    <table class="table table-condensed table-bordered">
    	<thead>
        	<tr>
				<th>No</th>
				<th>Deskripsi</th>
            	<th width="75px">Ada</th>
				<th width="5px">#</th>
				<th width="100px">File</th>
			</tr>
        </thead>
        <tbody>
        <?php $no=1;?>
        	<?php foreach($arrDoc as $id_doc => $nama_doc):?>
            <tr id="<?=$id_doc?>">
				<td width="5"><?php echo $no++;?></td>
                <td><?php echo $nama_doc?></td>
				<td class='status'><?=cek_array($data_doc[$id_doc])?"Ada":"Tidak Ada"?></td>
                <td>
					<a class="btn browse_doc  btn-xs btn-primary" id="browse_doc_<?=$id_doc?>" data-id_doc="<?=$id_doc?>" href="javascript:;">[+]</a> 
                    <a data-id_doc="<?=$id_doc?>" class="btn browse_doc_upload btn-xs btn-primary hide" href="javascript:;">[Start Upload]</a>    
                    <ul class="filelist"></ul>
                </td>
                <td class="file_pendukung <?=$id_doc?>" id="<?="data_".$id_doc?>" style="padding:0">
                	<table id="table_file_<?=$id_doc?>" class="table table-condensed file_list" style="margin-bottom:0px">
                    	<tbody>
                        	<? if(cek_array($data_doc[$id_doc])):?>
                            <? foreach($data_doc[$id_doc] as $x=>$file):?>
							<tr class='file_row' id="file_upload_<?=$file["id_file"]?>" data-file_id="<?=$file["id_file"]?>">
        						<td style="width:10px">
									<input type="hidden" name="upload_file_id[]" value="<?=$file["id_file"]?>"/>
									<input type="hidden" name="id_jenis_doc[]" value="<?=$file["id_jenis_doc"]?>"/>
									<a href="./<?=$file["file_path"]?>" class='file_open' target='_blank'><i class="fa fa-search"></i></a>
								</td>
								<td>
									<label style='height:auto;'><?=$file["file_name"]?></label></td>
								<td style="width:10px"><a href="" class='upload_file_remove red'><i class="fa fa-remove"></i> </a></td>
        					</tr>
                            <? endforeach;?>
							<? endif; ?>
                    	</tbody>
                    </table>
                </td>
			</tr>
			<?php endforeach;?>
        </tbody>
    </table>
    
    </div>
</div>


<? loadFunction("json");?>
<?php echo js_asset("jquery.tmpl.min.js");?>
<?php echo js_asset("jquery.tmplPlus.min.js");?>

<script id="tmp_file_upload" type="text/x-jquery-tmpl">
	<tr class='file_row' id="file_upload_${idx}" data-file_id="${idx}">
		<td>
			<input type="hidden" name="upload_file_id[]" value="${idx}"/>
				<a href="./${relative_path}" class='file_open' target='_blank'>
					<i class="fa fa-search"></i>
				</a>
		</td>
		<td>
			<input type="hidden" name="id_jenis_doc[]" value="${id_jenis_doc}"/>
			<label style='height:auto;'>${file_name}</label>
		</td>
		<td>
			<a href="" class='upload_file_remove red'>
				<i class="fa fa-remove"></i>
			</a>
		</td>
	</tr>
</script>

<script type="text/javascript" src="assets/js/plugins/pluploader/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>



<script>
$(function(){
		$(".btn_next").click(function(e){
			e.preventDefault();
			$("#doc_status").val($(this).data("doc_status"));
			$("#frm").submit();
		});
		$(".browse_doc").each(function(){
			var id=$(this).data("id_doc");
			initUploader(id);
		});
		
		function initUploader(id){

		var uploader3 = new plupload.Uploader({
		  browse_button: "browse_doc_"+id, // this can be an id of a DOM element or the DOM element itself
		  url: '<?=base_url()?>upload/all/',
		  flash_swf_url : 'http://rawgithub.com/moxiecode/moxie/master/bin/flash/Moxie.cdn.swf',
		  file_data_name:'userfile'
		});
		
		uploader3.init();		
		
		uploader3.bind("FileUploaded",function(up,file,info){
			var response=JSON.parse(info.response);

			if(response.status=='ok'){
				$("#f_"+file.id).hide().remove();
				var data=response.data_file;
				data.id_jenis_doc=id;
				console.log(data);
				
				var tmpFile="tmp_file_upload";
				
				$("tr#"+id).find("#table_file_"+id+" tbody").append($("#"+tmpFile).tmpl(data));
				cek_file_pendukung();
			}
		}); 
		 
		uploader3.bind('FilesAdded', function(up, files) {
		  
		  var html = '';
		  plupload.each(files, function(file) {
			html += '<li id="f_' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b><a href="#" class="a_file_remove red"><i class="icon-remove"></i></a></li>';
		  });
		  
		  	$("tr#"+id).find(".filelist").append(html);
				uploader3.start();
			});
		 
			uploader3.bind('UploadProgress', function(up, file) {
			
				$("#f_"+file.id).find("b").html("<span>" + file.percent + "%</span>");
			});
		 
			uploader3.bind('Error', function(up, err) {
		  		document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			});
		 
			$("#browse_doc_upload_"+id).click(function(e){
				e.preventDefault();
				uploader3.start();
			});
		
		}
		
	})
	
	$(function(){
		cek_file_pendukung();	
		$(document).on("click","a.upload_file_remove",function(e){
			e.preventDefault();
			var that=$(this);
			var id=that.closest("tr").data("file_id");
			$.post("<?=base_url()?><?=$this->module?>delete_upload_file/"+id,function(ret){
				if(ret=="ok"){
					that.closest("tr").slideUp().remove();
					cek_file_pendukung();
				}
			}); //end ajax
			
		});
	});
	
	
	function cek_file_pendukung(){
		var test=[];
		$(".file_pendukung").each(function(i,data){
				var leng=$(this).find("table tbody tr").length;
				if(leng==0){
					$(this).closest("tr").find("td.status").html("Tidak Ada");
				}else{
					$(this).closest("tr").find("td.status").html("Ada");
				}
		})	
	}
</script>