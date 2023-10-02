<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
	
?>
<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_jenis_instansi[""]="--Pilih--";
	$lookup_jenis_instansi=$lookup_empty+lookup("m_jenis_instansi","kd_jenis_instansi","ur_jenis_instansi","","order by order_num");
	$lookup_tempat_rehab=$lookup_empty+lookup("m_tempat_rehab","idx","ur_tempat","","order by order_num");
	
	$lookup_jenis_kelamin=$lookup_empty+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_kelamin'"," order by order_num");
	
	$lookup_sumber_biaya=$lookup_empty+lookup("m_sumber_biaya","kd_sumber","ur_sumber",""," order by order_num");
	//debug();
	$lookup_wilayah=$lookup_empty+lookup("m_kabupaten_kota","kode_bps","nama","","order by kode_bps");
	$data_propinsi=lookup("m_propinsi2","kode_bps","nama");
	foreach($data_propinsi as $x=>$val):
		$data_propinsi[$x]=strtoupper($val);
	endforeach;
	
	
?>
<?php
	$lookup_status[0]="Baru/Draft"; //menunggu verifikasi
	$lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	$lookup_status[2]="Selesai"; //menunggu rekam medik
	$lookup_status[9]="Ditolak";  
	
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	$lookup_proses_berikutnya["RG"]="Registrasi";
	//$lookup_proses_berikutnya["SS"]="Assesment";
	
	$lookup_empty=array(""=>"--pilih--");
	$lookup_bnnp=$lookup_empty+lookup("m_org","kd_org","nama","tipe_org='BNNP'","order by idx");
	$lookup_balai=$lookup_empty+lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
	$lookup_keluarga=$lookup_empty+$this->data_lookup["hubungan_keluarga"];
	
	
?>
	
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo $this->module?>"><i class="fa fa-user-plus"></i> <?=$this->parent_module_title?></a></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
    <li class="active">Add</li>
  </ol>
</section>

<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <!-- TOOLBAR -->
        	<div class="content-toolbar">
            		<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="Back">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>reg_baru" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white hidden" href="<?php echo $this->module?>" data-toggle='tooltip' title="Reset">
                        <i class="fa fa-remove"></i>
                    </a>	  
            </div>
            <!-- END: TOOLBAR -->
            
        	<div class="box box-widget">
                <div class="box-body">
				<h4 class="heading">Tambah Data Pasien Baru</h4>
                <form id="frm" method="post" action="<?php echo $this->module;?>add_pasien_baru">
                  <input type="hidden" name="act" id="act" value="create"/>

                  <?=$this->load->view("v_part_form_wilayah_sumber_pasien2")?>
                  <div class="formSep"></div>
				  <?=$this->load->view("v_part_form_data_pasien2")?>
                  
                  <!--<h4 class="heading">Disclaimer</h4>-->
				  
					<div class="row">
                    <div class="col-md-6">
					<input type="hidden" name="status_check_doc" value="2">
					<input type="hidden" name="status_proses" value="RG">
					<!--
                    <div class="form-group">
                        <label for="nama">Status Registrasi?</label>
                        <?//=form_dropdown("status_check_doc",$lookup_status,
                                //$data["status_check_doc"],
                                //"id='status_check_doc' 
                                //class='form-control select2 required'");?>
                    </div>
                    <div class="form-group status_proses">
                        <label for="nama">Proses Berikutnya?</label>
                        <?//=form_dropdown("status_proses",$lookup_proses_berikutnya,
                                //$data["status_proses"],
                                //"id='status_cek_proses' 
                                //class='form-control select2 required'");?>
                    </div>
					-->
					<div class="form-group tgl_asses hide">
                      <label>Tanggal Rencana Assesment<span class="asterix">&nbsp;*</span></label>
						<div class="input-group" >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                      <input type="text" style="width:220px;" id="tgl_assestment_selector" class="form-control input-date required" value="<?=date("d/m/Y",strtotime(date('Y')))?>" placeholder="dd/mm/yyyy"/>
                                      <input type="hidden" id="tgl_assestment" name="tgl_assestment" value="<?=date("Y-m-d",strtotime(date('Y')));?>" class="required" />
                        </div>
					</div><!-- end form-->
					</div>

					
					</div><!-- end row-->
					<!--Lama
					<div class="row">
						<div class="col-md-12">
							<h4 class="heading">DOKUMEN PENDUKUNG</h4>
								<div class="col-md-9">
									<div class="form-group">
										<a id="browse" class="btn btn-xs btn-primary" href="javascript:;">[+] Tambah</a> 
										<a id="start-upload" class="btn btn-xs btn-primary hide" href="javascript:;">[Start Upload]</a>
										<br>
										<ul id="filelist"></ul>
										<div class="table-responsive" style="padding-top:5px;overflow-y:hidden;overflow-x:auto">
											<table id="table_file_peta" class="table table-condensed file_list table-bordered">
												<thead>
													<tr><td width="10px">#</td><td>File</td><td width="10px">#</td></tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
						</div>
					</div><!--End of Row-->
					
					 <h4 class="heading">File Pendukung</h4>
					 <div class="row">
					 <div class="col-md-6">
					 <?=$this->load->view("v_pemeriksaan_dokumen");?> 
					 </div>
					 </div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-info">
								<h4><i class="icon fa fa-info"></i>Info</h4>
								Pengambilan Foto Pasien Dan Rekam Sidik Jari Akan Dilakukan Pada Tahap Berikutnya.
								<!--<br />Harap Membawa Kelengkapan Dokumen - Dokumen Pendukung Pada Tahap Berikutnya.-->
							</div>
						</div>
					</div>
                </form>
                </div>
               
                <!-- /.box-body -->
                <div class="box-footer well well-sm no-shadow">
                     <!--Username digunakan pada saat login.-->
                </div>
                
              </div>
        </div>
    </div>
</section>
<? loadFunction("json");?>
<?php echo js_asset("jquery.tmpl.min.js");?>
<?php echo js_asset("jquery.tmplPlus.min.js");?>
<script id="tmp_file_peta" type="text/x-jquery-tmpl">
	<tr class='file_row' id="file_peta_${idx}" data-file_id="${idx}">
	<td><input type="hidden" name="peta_file_id[]" value="${idx}"/><a href="./${relative_path}" class='file_open' target='_blank'><i class="fa fa-search icon-white"></i> </a></td><td>
	<label style='height:auto;'>${file_name}</label></td><td><a href="" class='peta_file_remove red'><i class="fa fa-remove icon-danger"></i> </a></td></tr>
</script>

<script type="text/javascript" src="assets/js/plugins/pluploader/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script>
	$(function(){
	var uploader = new plupload.Uploader({
		  
		  browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
		  url: '<?=base_url()?>upload/all/',
		  flash_swf_url : 'http://rawgithub.com/moxiecode/moxie/master/bin/flash/Moxie.cdn.swf',
		  max_file_size : '3250kb',//10mb
		  file_data_name:'userfile'
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
		  // alert(JSON.stringify(up));
		  // alert(JSON.stringify(files));
		  
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
			alert("Error: File yang anda masukkan lebih dari batas maksimal 3MB ");
			up.refresh();
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
			$.post("<?=base_url()?><?=$this->module?>delete_file/"+id,function(ret){
				if(ret=="ok"){
					that.closest("tr").slideUp().remove();
				}
			}); //end ajax
			
		});
	
	})
	
</script>

<script language="javascript">

$(function(){
	$("#status_check_doc").change(function(){
		if($(this).find(":selected").val()==2){
			$("div.status_proses").show();
			$("div.tgl_asses").show();
		}else{
			$("div.status_proses").hide();
			$("div.tgl_asses").hide();
		}
	}).change();	
});

$(function(){
		$("#status_cek_proses").change(function(){
			if($(this).val()=='SS'){
				$("div.tgl_asses").hide();
			}else{
				$("div.tgl_asses").show();
			}
		}).change();
		
	});
$(function(){
	//$(".select2").select2();
	$("#kd_propinsi").select2({'placeholder':"--Pilih Propinsi--"});
	$("#kd_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
	$("#kd_wilayah").change(function(){
		var data_propinsi=<?=json_encode($data_propinsi)?>||"";
		var kd_propinsi=$(this).find(":selected").val();
		var id_propinsi=kd_propinsi.substr(0,2);
		$("#kd_wilayah_propinsi").val(id_propinsi);
		$("#kd_wilayah_propinsi_txt").val(data_propinsi[id_propinsi]);
	}).change();
	
	$("#kd_propinsi").change(function(){
   		var id_propinsi = $(this).val();
		var propinsi=$(this).find(":selected").text();
		console.log(propinsi);
		//search_location(propinsi);
		
		//var nm_propinsi = $("#id_propinsi option:selected").text();
		$("#id_kabupaten_holder").load("<?=base_url()?>lookup/wilayah/get_kab_kota2/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#kd_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
			//getgeoCode(nm_propinsi);
			/*
			$("#id_kabupaten").change(function(){
				var nm_address = nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				getgeoCode(nm_address);
		   });*/
		   
		});
		
   });
   
   
   
});


</script>
</script>

<?php if(!$this->user_instansi): ?>
<script>
$(document).ready(function(){
	
	var jns_org	=	'<?=$data['jns_org']?>';
	
	if(jns_org){
		if(jns_org==1){
			$(".bnnp").removeClass("hide");
			$(".bnnk").addClass("hide");
			$(".balai").addClass("hide");
			
			
			$("#kd_bnnp").prop("disabled",false);
			$("#kd_bnnk").prop("disabled",true);
			$("#kd_balai").prop("disabled",true);
		}else if(jns_org==2){
			$(".bnnp").addClass("hide");
			$(".bnnk").addClass("hide");
			$(".balai").removeClass("hide");
			
			$("#kd_bnnp").prop("disabled",true);
			$("#kd_bnnk").prop("disabled",true);
			$("#kd_balai").prop("disabled",false);
		}else if(jns_org==3){
			$(".bnnp").addClass("hide");
			$(".bnnk").removeClass("hide");
			$(".balai").addClass("hide");
			
			$("#kd_bnnp").prop("disabled",true);
			$("#kd_bnnk").prop("disabled",false);
			$("#kd_balai").prop("disabled",true);
		}
	}else{
		
		$(".bnnp").removeClass("hide");
		$(".bnnk").addClass("hide");
		$(".balai").addClass("hide");
			
			
		$("#kd_bnnp").prop("disabled",false);
		$("#kd_bnnk").prop("disabled",true);
		$("#kd_balai").prop("disabled",true);
		
	}
	
	$(".cek_radio").on("change",function(){
	
		var val	=	$(this).val();
		
		if(val==1){
			$(".bnnp").removeClass("hide");
			$(".bnnk").addClass("hide");
			$(".balai").addClass("hide");
			
			
			$("#kd_bnnp").prop("disabled",false);
			$("#kd_bnnk").prop("disabled",true);
			$("#kd_balai").prop("disabled",true);
		}else if(val==2){
			$(".bnnp").addClass("hide");
			$(".bnnk").addClass("hide");
			$(".balai").removeClass("hide");
			
			$("#kd_bnnp").prop("disabled",true);
			$("#kd_bnnk").prop("disabled",true);
			$("#kd_balai").prop("disabled",false);
		}else if(val==3){
			$(".bnnp").addClass("hide");
			$(".bnnk").removeClass("hide");
			$(".balai").addClass("hide");
			
			$("#kd_bnnp").prop("disabled",true);
			$("#kd_bnnk").prop("disabled",false);
			$("#kd_balai").prop("disabled",true);
		}
	
	});

});
</script>
<?php endif; ?>