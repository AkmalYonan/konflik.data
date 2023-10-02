<?php $id=$this->encrypt_status==TRUE?encrypt($data["idx"]):$data["idx"];?>
<?
	$arrDoc["BRWA-F025"]="Ringkasan Tinjauan Dokumen";
	$arrDoc["BRWA-F026"]="Daftar Hadir Pertemuan";
	$arrDoc["BRWA-F027"]="Surat Tugas";
	$arrDoc["BRWA-F028"]="Jadwal Verifikasi Tahap 1";
	$arrDoc["BRWA-F029"]="Daftar Periksa Penilaian Verifikasi";
	$arrDoc["BRWA-F031"]="Laporan Kesimpulan Hasil Verifikasi";
	$arrDoc["BRWA-F036"]="Rekomendasi Status Hasil Pemeriksaan";
	$arrDoc["BRWA-F035"]="Tinjauan Hasil Pemeriksaan";
	
?>
<div class="row">
	<div class="col-md-12">

<form id="frm" method="post" action="<?=$this->module?>persiapan_update/<?=$id?>" class="control-label-left" role="form">

<input type="hidden" name="act" id="act" value="update"/>
<!--<input type="hidden" name="doc_proses" id="doc_proses" value="2"/>
<input type="hidden" name="doc_status" id="doc_status" value="1"/>


<input type="hidden" name="wa_data_status" id="wa_data_status" value="0"/>-->
<input type="hidden" id="doc_list" name="doc_list" value="<?=join(",",array_keys($arrDoc));?>"/>
    <table class="table table-condensed table-bordered">
    	<thead>
        	<tr><th>No</th><th width="100px">Dokumen</th><th>Deskripsi</th>
            <th width="75px">Ada</th><th width="5px">#</th><th width="100px">File</th></tr>
        </thead>
        <tbody>
        
       <?php $no=1;?>
                                    <?php foreach($arrDoc as $id_doc => $nama_doc):?>
                                    	<tr id="<?=$id_doc?>"><td width="5"><?php echo $no++;?></td><td><?=$id_doc?></td><td><?php echo $nama_doc?></td><td><?=cek_array($data_doc[$id_doc])?"Ada":"Tidak Ada"?></td>
                                        <td><a class="btn browse_doc  btn-xs btn-primary" id="browse_doc_<?=$id_doc?>" data-id_doc="<?=$id_doc?>" href="javascript:;">[+]</a> 
                    <a data-id_doc="<?=$id_doc?>" class="btn browse_doc_upload btn-xs btn-primary hide" href="javascript:;">[Start Upload]</a>    
                    				<ul class="filelist"></ul>
                                    </td>
                                        <td class="file_pendukung <?=$id_doc?>" id="<?="data_".$id_doc?>" style="padding:0">
                                     
                                    
                                    <table id="table_file_<?=$id_doc?>" class="table table-condensed file_list" style="margin-bottom:0px">
                                    <tbody>
                                    <? if(cek_array($data_doc[$id_doc])):?>
                                    	<? foreach($data_doc[$id_doc] as $x=>$file):?>
										<tr class='file_row' id="file_upload_<?=$file["id_file"]?>" data-file_id="<?=$file["id_file"]?>">
        <td style="width:10px"><input type="hidden" name="upload_file_id[]" value="<?=$file["id_file"]?>"/><input type="hidden" name="id_jenis_doc[]" value="<?=$file["id_jenis_doc"]?>"/><a href="./<?=$file["file_path"]?>" class='file_open' target='_blank'><i class="icon-search"></i> </a></td>
        <td>
        <label style='height:auto;'><?=$file["file_name"]?></label></td>
        <td style="width:10px"><a href="" class='upload_file_remove red'><i class="icon-remove"></i> </a></td>
        	</tr>
                                        <? endforeach;?>
									<? endif; ?>
                                    </tbody>
                               </table>
                                    
                                    
                    				</td></tr>
									<?php endforeach;?>
        
        
    	
    	</tbody>
    </table>

   
                                
 
 <div class="formSep"></div>
 <div class="row">
        <div class="col-md-12">
        <div class="form-actions col-md-12">
        	<!--<button class="btn btn-primary save" type="submit"><i class="icon-book icon-white"></i> Simpan </button>
            <button type="reset" class="btn btn-warning "><i class="icon-refresh"></i> Reset </button>-->
            
            <!--<button class="pull-right btn btn-primary btn_registrasi"><i class="icon-book icon-white"></i> Ubah Status Terigistrasi </button>-->
             <button class="pull-right btn btn-primary btn_next" data-doc_proses="1" data-doc_status="1"><i class="icon-book icon-white"></i> Simpan  </button>
            
        </div>
        </div>
        </div>
 
 </form> 
    </div>
</div>


<? loadFunction("json");?>
<?php echo js_asset("jquery.tmpl.min.js");?>
<?php echo js_asset("jquery.tmplPlus.min.js");?>

<script id="tmp_file_upload" type="text/x-jquery-tmpl">
	<tr class='file_row' id="file_upload_${idx}" data-file_id="${idx}">
	<td><input type="hidden" name="upload_file_id[]" value="${idx}"/><a href="./${relative_path}" class='file_open' target='_blank'><i class="icon-search"></i> </a></td><td>
	<input type="hidden" name="id_jenis_doc[]" value="${id_jenis_doc}"/>
	<label style='height:auto;'>${file_name}</label></td><td><a href="" class='upload_file_remove red'><i class="icon-remove"></i> </a></td></tr>
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
		//var id=$(".browse_doc").eq(0).attr("id");
		//var id=$(".browse_doc").eq(0).data("id_doc")
		$(".browse_doc").each(function(){
			var id=$(this).data("id_doc");
			initUploader(id);
		});
		
		
		function initUploader(id){
		
		//var first_id=
		//alert(first_id);
		var uploader3 = new plupload.Uploader({
		  browse_button: "browse_doc_"+id, // this can be an id of a DOM element or the DOM element itself
		  url: '<?=base_url()?>upload/all/',
		  flash_swf_url : 'http://rawgithub.com/moxiecode/moxie/master/bin/flash/Moxie.cdn.swf',
		  file_data_name:'userfile'
		});
		
		uploader3.init();
		
		//$('#browse_doc_'+id).click(function()
		//{
			//alert("test");
			//alert($(this).data("id_doc"));
			//uploader3.settings.browse_button = $(this).attr('id'); //Assign the ID of the pickfiles button to pluploads browse_button
			//id= $(this).data("id_doc");
			//uploader3.refresh();
			
		//});
		
		
		uploader3.bind("FileUploaded",function(up,file,info){
			var response=JSON.parse(info.response);
			//console.log(response);
			if(response.status=='ok'){
				$("#f_"+file.id).hide().remove();
				var data=response.data_file;
				data.id_jenis_doc=id;
				console.log(data);
				//data["data_str"]=JSON.stringify(data);
				var tmpFile="tmp_file_upload";
				//$("#"+tmpFile).tmpl(data).appendTo('#table_file_peta tbody');
				//$('#table_file_'+id+' tbody').append($("#"+tmpFile).tmpl(data));
				
				$("tr#"+id).find("#table_file_"+id+" tbody").append($("#"+tmpFile).tmpl(data));
				console.log(data);
			}
		}); 
		 
		uploader3.bind('FilesAdded', function(up, files) {
		  //alert(JSON.stringify(up));
		  //alert(JSON.stringify(files));
		  
		  var html = '';
		  plupload.each(files, function(file) {
			html += '<li id="f_' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b><a href="#" class="a_file_remove red"><i class="icon-remove"></i></a></li>';
		  });
		  
		  	$("tr#"+id).find(".filelist").append(html);
		  
		  	//document.getElementById('filelist2').innerHTML += html;
			//alert(html);
				//$("#data_"+id).find(".filelist").append(html);
				//$("#data_"+id).html(html);
				uploader3.start();
			});
		 
			uploader3.bind('UploadProgress', function(up, file) {
			
		  		/*document.getElementById("f_"+file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";*/
				$("#f_"+file.id).find("b").html("<span>" + file.percent + "%</span>");
			});
		 
			uploader3.bind('Error', function(up, err) {
		  		document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			});
		 
			 /*
			document.getElementById('start-upload2').onclick = function() {
			  uploader3.start();
			};
			*/
			$("#browse_doc_upload_"+id).click(function(e){
				e.preventDefault();
				uploader3.start();
			});
		
		}
		
	})
</script>