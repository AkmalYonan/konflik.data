<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	//$id=$this->encrypt_status==TRUE?encrypt($datax[$this->tbl_idx]):$datax[$this->tbl_idx]; 
?>

<section class="content-header">
  <h1 class="hidden-xs">
    <?php if($act=="add"): echo "Tambah"; else: echo "Ubah"; endif; ?>
    <small>Pasien Peer Group</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
	<li><a href="<?php echo $this->module?><?=$act?>/<?=$id?>" class="active"><?php if($act=="add"): echo "Tambah Data"; else: echo "Ubah Data"; endif; ?></a></li>
  </ol>
</section>

<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
        	<div class="box box-default">
                <div class="box-header with-border clearfix">
                	<a class="btn btn-white" href="<?php echo $this->module?><?=($act=="add")?"pasien_list":""?>" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?><?=$act?>/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="Reset">
                        <i class="fa fa-circle-o"></i>
                    </a>	  
                </div>
                <!-- /.box-header -->
                <div class="box-body">
				<?php if($act=="add"): ?>
				<ul class="nav nav-tabs" style="margin-bottom:10px">
				  <li><a href="<?=$this->module?>pasien_list"><i class="fa fa-user">&nbsp;</i>Pilih Pasien (Step 1)</a></li>
				  <li class="active"><a href="<?=$this->module?>"><i class="fa fa-file">&nbsp;</i>Form Input (Step 2)</a></li>
				</ul>
				<?php endif; ?>
				
				<div class="row">
					<div class="col-sm-6">
						<h4 class="heading">Data Pasien</h4>
						<?=$this->load->view("common_view/pasien/v_data_pasien");?>
					</div>
					
					<div class="col-sm-6">
						<h4 class="heading">Data Kegiatan Rumah Damping</h4>
						
						<form id="frm" method="post" action="<?php echo $this->module;?><?=$act?>/<?=$id?>" enctype="multipart/form-data">
							<!--Hidden Input-->
						  	<input type="hidden" name="act" id="act" value="<?=$act?>"/>
						  	<input type="hidden" name="idx_pasien" value="<?=$idx_pasien?>" />
						  	<!--End-->
							
							<!--<?//php if($act=="add"): ?>-->
							<!--Tanggal Kegiatan-->
							<?php
								if($datax['tgl_mulai']):
									$tanggal_mulai_selector	=	date_format(date_create($datax['tgl_mulai']),"d-m-Y");
									$tanggal_mulai			=	date_format(date_create($datax['tgl_mulai']),"Y-m-d");
								else:
									$tanggal_mulai_selector	=	date("d-m-Y");
									$tanggal_mulai			=	date("Y-m-d");
								endif;
								
								if($datax['tgl_selesai']):
									$tanggal_selesai_selector	=	date_format(date_create($datax['tgl_selesai']),"d-m-Y");
									$tanggal_selesai			=	date_format(date_create($datax['tgl_selesai']),"Y-m-d");
								else:
									$tanggal_selesai_selector	=	date("d-m-Y");
									$tanggal_selesai			=	date("Y-m-d");
								endif;
							?>
							<!--End-->
							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="tanggal_input" id="id_pertemuan">Tanggal Mulai</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="tgl_mulai_selector" class="form-control input-date required" value="<?=$tanggal_mulai_selector?>" placeholder="dd/mm/yyyy" />
												<input type="hidden" id="tgl_mulai" name="tgl_mulai" value="<?=$tanggal_mulai?>" class="required" />
										</div>	
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label for="tanggal_input" id="id_pertemuan">Tanggal Selesai</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="tgl_selesai_selector" class="form-control input-date required" value="<?=$tanggal_selesai_selector?>" placeholder="dd/mm/yyyy" />
												<input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=$tanggal_selesai?>" class="required" />
										</div>	
									</div>
								</div>
							</div>
							<!--<?//php elseif($act=="edit"): ?>-->
							
							<div class="form-group hidden">
								<label>Pertemuan</label>
								<table class="table table">
									<tr>
										<th>Periode</th>
										<th></th>
										<th>Tanggal Pertemuan</th>
									</tr>
									<?php for($i=1; $i<5; $i++): ?>
									<?php
									$tanggal_selector	=	date_format(date_create($datax['tgl_pertemuan_'.$i]),"d-m-Y");
									$tanggal			=	date_format(date_create($datax['tgl_pertemuan_'.$i]),"Y-m-d");
									?>
									<tr>
										<td align="center"><?=$i?></td>
										<td><input type="checkbox" id="cek<?=$i?>" /></td>
										<td>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="pertemuan_<?=$i?>_selector" class="form-control input-date required" value="<?=$tanggal_selector?>" style="width:50%" />
												<input type="hidden" id="pertemuan_<?=$i?>" name="tgl_pertemuan_<?=$i?>" value="<?=$tanggal?>" class="required" />
											</div>	
										</td>
									</tr>
									<?php endfor; ?>
								</table>
							</div>
							
							<!--<?//php endif; ?>-->
							
							<div class="form-group">
								<label for="pertemuan">Jenis Kegiatan</label>
								<br />
								
								<?php $exp	=	explode(",",$datax['idx_jenis_kegiatan']); ?>
								
								<?php foreach($jenis_kegiatan as $k=>$v): ?>
								<input type="checkbox" name="idx_jns_kegiatan[]" value="<?=$v['idx']?>" <?=(in_array($v['idx'],$exp))?"checked='checked'":""?> />&nbsp;<?=$v['ur_jenis_kegiatan']?><br />
								<?php endforeach; ?>
							</div>
							
							<div class="form-group">
								<label>Keterangan</label>
								<textarea name="keterangan" class="form-control" rows="4"><?=$datax['keterangan']?></textarea>
							</div>
							
							<?php if($datax['file']): ?>
							<div class="form-group file_old">
								<label>Lampiran Sebelumnya</label>
								<input type="hidden" name="lampiran_old" value="<?=$datax['file']?>" />
								<a href="<?=$this->config->item("dir_peer_group")?><?=$datax['file']?>" target="_blank">
									<span class="label label-info"><i class="fa fa-file">&nbsp;</i>Lampiran</span>
								</a>
								<!--
								&nbsp;
								<a class="del_file_href" href="<?//=$this->module?>del_file/<?//=$id?>">
									<span>&times;</span>
								</a>
								-->
							</div>
							<?php endif; ?>
							
							<div class="form-group">
								<label class="file_label"><?=($datax['file'])?"Ubah ":""?>Lampiran</label>
								<input type="hidden" id="lampiran_name" name="lampiran_name" />
								<input type="file" id="lampiran" name="lampiran" />
							</div>
							
							<!--
							<?//=$this->load->view("v_upload_file")?>
							-->
							<div class="row hidden">
								<div class="col-md-6">
									<div class="form-actions">
										<!--<button type="submit" class="btn btn-primary">Save changes</button>-->
										<button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
										<button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>				
                <!-- /.box-body -->
              </div>
        </div>
    </div>
</section>
<script language="javascript">
$(document).ready(function(){      
	$('#prov').change(function(){
		$.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
			$('#kab').html(obj);
		});
    });
	$("#previewplay").click(function(){
		$("#imgInpPlay").trigger("click");
	});
});
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '180px');
                //$('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>
<script>
	$(function(){
		$("#frm").validate();
		
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
		
		$(".group").click(function(){
			//$("#company").prop("disabled",$(this).data('org')==1 ? false: true);
			var use_org = $(this).data('org');
			$("#company").val(use_org);
			$("#company option").show();
			$("#company option").each(function(){
				if (!use_org) {
					$(this).val()!=0?$(this).hide():$(this).show();
				}
				else {
					$(this).val()!=0?$(this).show():$(this).hide();
				}
			});
		});
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		  checkboxClass: 'icheckbox_flat-green',
		  radioClass: 'iradio_flat-green'
		});
	})
</script>

<script>
$(document).ready(function(){
	$("#lampiran").on("change",function(){
		var lampiran_name	=	$("#lampiran").val();
		$("#lampiran_name").val(lampiran_name);
	});
});
</script>

<script>
$(document).ready(function(){
	$("#pertemuan").on("change",function(){
		var val_pertemuan	=	$("#pertemuan").val();
		$("#id_pertemuan").text("Tanggal Pertemuan Ke - "+val_pertemuan);
		
		<?php if($act=="edit"): ?>
		if(val_pertemuan==1){
			var	tgl_pertemuan_s	=	'<?=$datax['tgl_pertemuan_1']?date_format(date_create($datax['tgl_pertemuan_1']),"d-m-Y"):date("d-m-Y")?>';
			var	tgl_pertemuan	=	'<?=$datax['tgl_pertemuan_1']?date_format(date_create($datax['tgl_pertemuan_1']),"Y-m-d"):date("Y-m-d")?>';
		}else if(val_pertemuan==2){
			var	tgl_pertemuan_s	=	'<?=$datax['tgl_pertemuan_2']?date_format(date_create($datax['tgl_pertemuan_2']),"d-m-Y"):date("d-m-Y")?>';
			var	tgl_pertemuan	=	'<?=$datax['tgl_pertemuan_2']?date_format(date_create($datax['tgl_pertemuan_2']),"Y-m-d"):date("Y-m-d")?>';
		}else if(val_pertemuan==3){
			var	tgl_pertemuan_s	=	'<?=$datax['tgl_pertemuan_3']?date_format(date_create($datax['tgl_pertemuan_3']),"d-m-Y"):date("d-m-Y")?>';
			var	tgl_pertemuan	=	'<?=$datax['tgl_pertemuan_3']?date_format(date_create($datax['tgl_pertemuan_3']),"Y-m-d"):date("Y-m-d")?>';
		}else if(val_pertemuan==4){
			var	tgl_pertemuan_s	=	'<?=$datax['tgl_pertemuan_4']?date_format(date_create($datax['tgl_pertemuan_4']),"d-m-Y"):date("d-m-Y")?>';
			var	tgl_pertemuan	=	'<?=$datax['tgl_pertemuan_4']?date_format(date_create($datax['tgl_pertemuan_4']),"Y-m-d"):date("Y-m-d")?>';
		}
		$("#tgl_registrasi_selector").val(tgl_pertemuan_s);
		$("#tgl_registrasi").val(tgl_pertemuan);
		<?php endif; ?>
	});
});
</script>

<script>
$(document).ready(function(){
	<?php for($i=1; $i<5; $i++): ?>
		<?php if($datax['tgl_pertemuan_'.$i]): ?>
			$("#cek<?=$i?>").prop("checked",true);
			
			$("#cek<?=$i?>").on("change",function(){
				if($(this).prop("checked")){
					$("#pertemuan_<?=$i?>_selector").prop("disabled",false).val("<?=date_format(date_create($datax['tgl_pertemuan_'.$i]),"d-m-Y")?>");
					$("#pertemuan_<?=$i?>").val("<?=date_format(date_create($datax['tgl_pertemuan_'.$i]),"Y-m-d")?>");
					
				}else{
					$("#pertemuan_<?=$i?>_selector").prop("disabled",true).val("");
					$("#pertemuan_<?=$i?>").val('');
				}
			});
		<?php else: ?>
			$("#pertemuan_<?=$i?>_selector").prop("disabled",true).val('');
			$("#pertemuan_<?=$i?>").prop("disabled",true);
			
			$("#cek<?=$i?>").on("change",function(){
				if($(this).prop('checked')){
					$("#pertemuan_<?=$i?>_selector").prop("disabled",false).val('<?=date("d-m-Y")?>');
					$("#pertemuan_<?=$i?>").prop("disabled",false).val('<?=date("Y-m-d")?>');
				}else{
					$("#pertemuan_<?=$i?>_selector").prop("disabled",true).val('');
					$("#pertemuan_<?=$i?>").prop("disabled",true);
				}
			});		
		<?php endif;?>
	<?php endfor; ?>
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
	$(".del_file_href").click(function(){
		//alert("tes");
		e.preventDefault(); 
        var href 	=	$(this).attr("href");
		
		$.ajax({
        	type	:	"POST",
        	url		:	href,
        	success	:	function(res){
            	if(res=="Success"){
                	alert('Success');
           		}else{
                	alert("Error");
             	}
             	return false;
			}
       });
		
	});
		/*
        
        var btn 	=	this;

        $.ajax({
        	type	:	"POST",
        	url		:	href,
        	success	:	function(res){
            	if(res=="Success"){
                	alert('Success');
           		}else{
                	alert("Error");
             	}
             	return false;
			}
       }
   });
   return false;
   });
   */
});
</script>