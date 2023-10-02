<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
	$lookup_status["PS"]="Proses";
	$lookup_status["SL"]="Selesai";  
	
	$lookup_status_p["PS"]="Proses"; 
	$lookup_status_p["SL"]="Selesai";
	$lookup_status_p["KB"]="Kambuh"; 
	$lookup_status_p["MD"]="Meninggal Dunia";
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
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#homex" aria-controls="homex" role="tab" data-toggle="tab">Data Kegiatan Peer Group</a></li>
                                    </ul>
						<div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="homex">
						<h4 class="heading">Data Kegiatan Peer Group</h4>
						
						<form id="frm" method="post" action="<?php echo $this->module;?><?=$act?>/<?=$id?>" enctype="multipart/form-data">
							<!--Hidden Input-->
						  	<? if(cek_array($datax)):?>
								<input type="hidden" name="act" id="act" value="update"/>
							<? else:?>
								<input type="hidden" name="act" id="act" value="create"/>
							<? endif;?>
								<input type="hidden" name="status_rm_sebelumnya" id="status_rm_sebelumnya" value="<?php echo $data["status_rm"];?>"/>
	<input type="hidden" name="status_program_sebelumnya" id="status_program_sebelumnya" value="<?php echo $data["status_program"];?>"/>
	<input type="hidden" name="outcome_pasien_sebelumnya" id="outcome_pasien_sebelumnya" value="<?php echo $data["outcome_pasien"];?>"/>
							<input type="hidden" name="idx" id="idx" value="<?=$datax["idx"]?>"/>
							<input type="hidden" name="idx_assesment" id="idx_assesment" value="<?=$data_asm["idx"]?>"/>
							<input type="hidden" name="no_rekam_medis" id="no_rekam_medis" value="<?=$data["no_rekam_medis"]?>"/>
							<!--<input type="hidden" name="act" id="act" value="<?//=$act?>"/>-->
						  	<input type="hidden" name="idx_pasien" value="<?=$idx_pasien?>" />
						  	<!--End-->
							
							<!--<?//php if($act=="add"): ?>-->
							<!--Tanggal Kegiatan-->
							<?php
								// if($datax['idx_pertemuan']==1):
									$tanggal_selector	=	date_format(date_create($datax['tanggal']),"d-m-Y");
									$tanggal			=	date_format(date_create($datax['tanggal']),"Y-m-d");
								// elseif($datax['idx_pertemuan']==2):
									// $tanggal_selector	=	date_format(date_create($datax['tgl_pertemuan_2']),"d-m-Y");
									// $tanggal			=	date_format(date_create($datax['tgl_pertemuan_2']),"Y-m-d");
								// elseif($datax['idx_pertemuan']==3):
									// $tanggal_selector	=	date_format(date_create($datax['tgl_pertemuan_3']),"d-m-Y");	
									// $tanggal			=	date_format(date_create($datax['tgl_pertemuan_3']),"Y-m-d");
								// elseif($datax['idx_pertemuan']==4):
									// $tanggal_selector	=	date_format(date_create($datax['tgl_pertemuan_4']),"d-m-Y");
									// $tanggal			=	date_format(date_create($datax['tgl_pertemuan_4']),"Y-m-d");
								// else:
									// $tanggal_selector	=	date("d-m-Y");
									// $tanggal			=	date("Y-m-d");
								// endif;
							?>
							<!--End-->
							<!--
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<?php
											//$tgl_kegiatan=$datax["tgl_kegiatan"]?$datax["tgl_kegiatan"]:date("Y-m-d H:i:s");
										?>
											<label for="nama">Tgl Kegiatan</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="tgl_kegiatan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_kegiatan))?>" placeholder="dd/mm/yyyy"/>
												 <input type="hidden" id="tgl_kegiatan" name="tgl_kegiatan" value="<?=date("Y-m-d",strtotime($tgl_kegiatan));?>" class="required" />
											</div>			
									</div>
								</div>
							</div>
							-->
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="pertemuan">Pertemuan Ke</label>
										<select name="idx_pertemuan" class="form-control" id="pertemuan">
											<option value="1" <?=($datax['idx_pertemuan']==1)?"selected":""?>>Pertemuan Ke - 1</option>
											<option value="2" <?=($datax['idx_pertemuan']==2)?"selected":""?>>Pertemuan Ke - 2</option>
											<option value="3" <?=($datax['idx_pertemuan']==3)?"selected":""?>>Pertemuan Ke - 3</option>
											<option value="4" <?=($datax['idx_pertemuan']==4)?"selected":""?>>Pertemuan Ke - 4</option>
										</select>
									</div>
								</div><!--End Of Col 6-->
								
								<div class="col-sm-6">
									<div class="form-group">
										<label for="tanggal_input" id="id_pertemuan">Tanggal Pertemuan <?=$datax['idx_pertemuan']?"Ke - ".$datax['idx_pertemuan']:"Ke - 1"?></label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="tgl_registrasi_selector" class="form-control input-date required" value="<?=$tanggal_selector?>" placeholder="dd/mm/yyyy" />
												<input type="hidden" id="tgl_registrasi" name="tanggal" value="<?=$tanggal?>" class="required" />
										</div>	
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="pertemuan">Jenis Kegiatan</label>
								<select name="idx_jenis_kegiatan" class="form-control">
									<?php foreach($jenis_kegiatan as $k=>$v): ?>
									<option value="<?=$v['idx']?>" <?=($v['idx']==$datax['idx_jenis_kegiatan'])?"selected":""?>><?=$v['ur_jenis_kegiatan']?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="form-group">
								<label>Keterangan</label>
								<textarea name="keterangan" class="form-control" rows="3"><?=$datax['keterangan']?></textarea>
							</div>
							<div class="form-group">
									<label for="nm_petugas">Lampiran</label>
									<input type="file" name="lampiran" id="lampiran"  />
									<?php if($datax["lampiran"]){?>
									File: <a target="_blank" href="<?=$this->config->item("dir_peer_group").$datax["lampiran"]?>">Download</a>
								<?php } ?>
							</div>
							<div class="form-group">
										<label for="nama">Status Kegiatan</label>
										<?=form_dropdown("status_pasien",$lookup_status,
												$datax["status_pasien"],
												"id='status_pasien' 
												class='form-control select2 required'");?>
							</div><!-- end form-->
							<div class="form-group">
										<label for="nama">Status Program</label>
										<?=form_dropdown("status_program",$lookup_status_p,
												$datax["status_program"],
												"id='status_program' 
												class='form-control select2 required'");?>
							</div><!-- end form-->
							<!--<div class="form-group">
								<div class="row">
									<div class="col-md-4">
									<label for="nama">Status Pasien</label>
									<?//=form_dropdown("status_pasien",$lookup_status,
											//$datax["status_pasien"],
											//"id='status_pasien' 
											//class='form-control select2 required'");?>
									</div>
								</div>
							</div>-->
							<?php
								// $lookup["SS"]="Assesment";
								$lookup_proses_berikutnya=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
								$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
								$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
								$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
								$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
								$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
							?>
							<div class="form-group status_proses hidden ">
								<label for="nama">Proses Berikutnya?</label>
								<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
										$data["inst_pasca"],
										"id='status_proses' 
										class='form-control select2 required'");?>
							</div><!-- end form-->
							<div class="form-group bnnp hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='JALAN'):?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_pasca"],"id='bnnp' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_pasca"],"id='bnnp' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group bnnk hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='JALAN'):?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_pasca"],"id='bnnk' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_pasca"],"id='bnnk' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group balailoka hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $data['inst_pasca']=='BL'):?>
									<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_pasca"],"id='balailoka' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_pasca"],"id='balailoka' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group km hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $data['inst_pasca']=='KM'):?>
									<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_pasca"],"id='km' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_pasca"],"id='km' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group rd hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $data['inst_pasca']=='RD'):?>
									<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_pasca"],"id='rd' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_pasca"],"id='rd' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
						</form>
						</div>
                      </div>
					</div>
					
					<div class="col-sm-6">
						
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Pasien</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rehabilitasi</a></li>
                                         <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Pasca Rehab</a></li>
											<!--	<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Pasca / Lanjut</a></li>-->
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home" style=" backgorund-color:grey">
											<h4 class="heading">Pasien</h4>
											<?=$this->load->view("common_view/pasien/v_data_pasien");?>
										</div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
											<h4 class="heading">History Rehab</h4>
											<?=$this->load->view("common_view/pasien/v_hstry_rehab");?>
											<h4 class="heading">Monitoring Rehab</h4>
											<? $data['rawat_inap']='rawat_inap'?>
											<? $data['rawat_jalan']='rawat_jalan'?>
											<?=$this->load->view("common_view/pasien/v_mntr_rehab",$data);?>
											
										
										</div>
										  <div role="tabpanel" class="tab-pane" id="messages">
											<h4 class="heading">History Pasca</h4>
											<?=$this->load->view("common_view/pasien/v_hstry_pasca");?>
											<h4 class="heading">Monitoring Pasca</h4>
											<? $data['rawat_jalan_pasca']='rawat_jalan_pasca'?>
											<?=$this->load->view("common_view/pasien/v_mntr_pasca",$data);?>
										
										</div>
										<!---<div role="tabpanel" class="tab-pane" id="settings">4</div>-->
                                    </div>
							
					</div>
					
				</div>				
                <!-- /.box-body -->
              </div>
        </div>
    </div>
</section>
<script>
	$(function() {
		var non = $('#status_proses').val();
		// alert(non);
		$("select").select2();
		if(non=='SS'){
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide(); 
			$('.km').hide(); 
			$('.rd').hide(); 
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
		}else if(non=='KM'){
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", false );
			$('#rd').prop( "disabled", true );
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide();	
			$('.km').show();	
			$('.rd').hide();
		}else if(non=='RD'){
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", false );
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide();	
			$('.km').hide();
			$('.rd').show();
		}else if(non=='BNNK'){
			$('#bnnk').prop( "disabled", false );
			$('#bnnp').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
			$('.bnnk').show(); 
			$('.bnnp').hide(); 
			$('.balailoka').hide();
			$('.km').hide();	
			$('.rd').hide();		
		}else if(non=='BNNP'){
			$('#bnnp').prop( "disabled", false );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
			$('.bnnp').show(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide();
			$('.km').hide();	
			$('.rd').hide();		
		}else if(non=='BL'){
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", false );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').show();
			$('.km').hide();	
			$('.rd').hide();		
		}
		$('#status_proses').change(function(){
			// alert($('#status_proses').val());
			if($('#status_proses').val() == 'BL') {
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", false );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('.balailoka').show(); 
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.km').hide();
				$('.rd').hide();		
			} else if($('#status_proses').val() == 'BNNP'){
				$('#bnnp').prop( "disabled", false );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('.bnnp').show(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide();
				$('.km').hide();	
				$('.rd').hide();		
			} else if($('#status_proses').val() == 'BNNK'){
				$('#bnnk').prop( "disabled", false );
				$('#bnnp').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('.bnnk').show(); 
				$('.bnnp').hide(); 
				$('.balailoka').hide();
				$('.km').hide();	
				$('.rd').hide();		

			} else if($('#status_proses').val() == 'KM'){//JALAN=BALAI/LOKA
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", false );
				$('#rd').prop( "disabled", true );
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide();	
				$('.km').show();	
				$('.rd').hide();		
			} else if($('#status_proses').val() == 'RD'){
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", false );
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide();	
				$('.km').hide();
				$('.rd').show();				
			} else {
				$('#bnnp').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('.balailoka').hide(); 
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.km').hide();	
				$('.rd').hide();					
			}
		});
	});
	// $("#balailoka").select2();
		// $("#km").select2({'placeholder':"--Pilih--"});
		// <?php if($data['status_rawat']=='JALAN' && $data['inst_rujuk']=='BNNP'):?>
			// $('.km').hide(); 
			// $('.bnnp').show(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']=='JALAN' && $data['inst_rujuk']=='BNNK'): ?>
			// $('.km').hide(); 
			// $('.bnnp').hide(); 
			// $('.bnnk').show(); 
			// $('.balailoka').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']==NULL): ?>
			// $('.bnnp').hide(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
		// <?php endif; ?>
		// <?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='BL'):?>
			// $('.balailoka').show(); 
			// $('.bnnp').hide();
			// $('.bnnk').hide(); 			
			// $('.km').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']==NULL): ?>
			// $('.bnnp').hide(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
			// $('.km').hide(); 
		// <?php endif; ?>
</script> 
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