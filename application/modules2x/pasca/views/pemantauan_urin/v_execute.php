<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
	$lookup_status["PS"]="Proses";
	$lookup_status["SL"]="Selesai";  
	
	$lookup_status_p["PS"]="Proses"; 
	$lookup_status_p["SL"]="Selesai";
	$lookup_status_p["KB"]="Kambuh"; 
	$lookup_status_p["MD"]="Meninggal Dunia";
	$lookup_status_berikutnya=lookup("m_proses_rehab","kd_status_proses","ur_proses","kd_status_rehab=3 and kd_proses like '3.PR.RL.%' and flag_proses=1","order by kd_status_rehab,order_num");
 	
	//$lookup_status_outcome["Z"]="--Pilih--";
	$lookup_status_outcome["PP"]="Pulih Produktif";
	$lookup_status_outcome["PTP"]="Pulih Tidak Produktif";
	$lookup_status_outcome["TPP"]="Tidak Pulih Produktif"; 
	$lookup_status_outcome["TPTP"]="Tidak Pulih Tidak Produktif";

	if($monitoring_pasca['tgl_dr_selesai']):
		$tgl_limit_prev = $monitoring_pasca['tgl_dr_selesai']; 
	elseif($monitoring_pasca['tgl_dk_selesai']):
		$tgl_limit_prev = $monitoring_pasca['tgl_dk_selesai']; 
	else:
		$tgl_limit_prev = $monitoring_pasca['tgl_mulai_pasca']; 
	endif; 		
 	//$id=$this->encrypt_status==TRUE?encrypt($datax[$this->tbl_idx]):$datax[$this->tbl_idx]; 
?>

<style>
input[type="radio"] {
    -webkit-appearance	: 	checkbox;
    -moz-appearance		: 	checkbox;
    -ms-appearance		: 	checkbox;     /* not currently supported */
    -o-appearance		:	checkbox;      /* not currently supported */
}
</style>

<section class="content-header">
  <h1 class="hidden-xs">
    <?php if($act=="add"): echo "Tambah"; else: echo "Ubah"; endif; ?>
    <small>Pasien Kegiatan Pemantauan Urin</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="pasca/daftar_pasca"><i class="fa fa-child"></i> <?=$this->parent_module_title?></a></li>
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
							 <li role="presentation" class="active"><a href="#homex" aria-controls="homex" role="tab" data-toggle="tab">Data Kegiatan Pemantauan Urin</a></li>
						</ul>
						<div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="homex">
						
						<h4 class="heading">Data Kegiatan <?=$this->module_title;?> <a class="pull-right btn btn-xs btn-primary btn-add add_clean" title="Add Entry Unit"><i class="fa fa-plus"></i></a></h4>
						
						<table class="table table-striped table-condensed data_tbl">
							<?php if(cek_array($pasien_pasca_pu_history)):?>
								<?php foreach($pasien_pasca_pu_history as $x=>$val): ?>
									<tr id="tr_<?=$val['idx']?>">
										<td align="center"><?php echo $x+1?></td>
										<td><?php echo ($val["tgl_tes"])?date2indo($val["tgl_tes"]):"<center>-</center>"?></td>
										<td align="center">Test Urin Ke-<?php echo $val["idx_tes"]?></td>
										<td><?php echo $val["keterangan"]?></td>
										<td align="center">
											<?php if($val['hasil_tes']==1): ?>
												<span class="label label-danger"><i class="fa fa-plus"></i></span>
											<?php elseif($val['hasil_tes']==2): ?>
												<span class="label label-success"><i class="fa fa-minus"></i></span>
											<?php endif; ?>
										</td>
										<td align="center">
											<?php if($val['lampiran']): ?>
												<a href="<?=$this->config->item("dir_hv").$val['lampiran']?>" target="_blank">
													<span class="label label-info"><i class="fa fa-download">&nbsp;</i></span>
												</a>
											<?php else: echo "-"; endif; ?>
										</td>
										<td align="center">
											<?php 
												foreach($val as $k=>$v): 
													$ref[]	=	$k.":'".$v."'";
												endforeach;
												$ref[]	=	"tgl_registrasi:'".date("Y-m-d",strtotime($val["tgl_tes"]))."'";
												$ref[]	=	"tgl_registrasi_selector:'".date("d/m/Y",strtotime($val["tgl_tes"]))."'";
												$data_ref	=	join(',',$ref);
											?>
																
										<div class="btn-group btn-group-xs">
											<a class="btn btn-xs btn-default edit_data" data-toggle='tooltip' data-ref="{<?=$data_ref?>}" title="Edit"><i class="fa fa-pencil green"></i></a> 
											<a class="btn btn-xs btn-default del_ajax" data-ref="{<?=$data_ref?>}">
												<i class="fa fa-remove red"></i>
											</a>
										</div>
										</td>
									</tr>
								<?php endforeach;?>
							<?php else: ?>
								<tr>
									<td align="center"><i>--Tidak Ada Kegiatan--</i></td>
								</tr>
							<?php endif;?>
						</table>	
						
<script>
	$(document).ready(function(){
		$(".edit_data").on("click",function(){
			$(".title_form").text("Edit Data Kegiatan Pemantauan - Tes Urin");
				
			var string = $(this).data("ref");
			eval('var object='+string);
			
			<?php foreach($pasien_pasca_pu_history[0] as $k=>$v): ?>
			<?php if(($k!=="lampiran") && ($k!=="tgl_selesai")): ?>
			$("#<?=$k?>").val(object.<?=$k?>);		
			<?php endif; ?>
			<?php endforeach; ?>
			
			$("#id_tes").val(object.idx_tes).change();
			$("#tgl_registrasi").val(object.tgl_registrasi);
			$("#tgl_registrasi_selector").val(object.tgl_registrasi_selector);
			
			var hasil_tes		=	object.hasil_tes;
			
			if(hasil_tes==1){
				$("#radio_plus").prop("checked",true);
				$("#radio_minus").prop("checked",false);
			}else{
				$("#radio_plus").prop("checked",false);
				$("#radio_minus").prop("checked",true);
			}
			var lampiran	=	object.lampiran;
			
			if(lampiran){
				var href	=	'<a href="<?=$this->config->item("dir_pemantauan_urin")?>'+lampiran+'" target="_blank">Unduh Lampiran</a>';
				$(".label_lampiran").html(href);
			}else{
				$(".label_lampiran").text('');
			}	
		});
		
		$(".add_clean").on("click",function(){
			$(".title_form").text("Tambah Data Kegiatan Pemantauan - Tes Urin");
			
			$("#idx").val('');
			$("#tgl_hm").val('<?=date("Y-m-d")?>');
			$("#tgl_hm_selector").val('<?=date("d/m/Y")?>');
			$("#id_hm").val("1").change();
			$("#radio_plus").prop("checked",true);
			$("#radio_minus").prop("checked",false);
			$("#keterangan").val("");			
			$("#notlp_keluarga").val("");
			$("#nm_keluarga").val("");
			$("#alamat").val("");
			$("#nm_petugas").val("");			
			$(".label_lampiran").text("");
			
		});		
	});
</script>						
						
						
						<h4 class="heading title_form">Tambah Data Kegiatan Pemantauan - Tes Urin</h4>
						
						<form id="frm" method="post" action="<?php echo $this->module;?><?=$act?>/<?=$id?>" enctype="multipart/form-data">
							<!--Hidden Input-->
						  	<? if(cek_array($datax)):?>
								<input type="hidden" name="act" id="act" value="update"/>
							<? else:?>
								<input type="hidden" name="act" id="act" value="create"/>
							<? endif;?>
						  	<input type="hidden" name="idx_pasien" value="<?=$idx_pasien?>" />
							<input type="hidden" name="idx"  />
						  	<!--End-->
							<input type="hidden" name="idx_assesment" id="idx_assesment" value="<?=$data_asm["idx"]?>"/>
							<input type="hidden" name="no_rekam_medis" id="no_rekam_medis" value="<?=$data["no_rekam_medis"]?>"/>
						  	
							<!--Tanggal Kegiatan-->
							<?php
								if($datax['idx_tes']):
									$tes_selector	=	date_format(date_create($datax['tgl_tes']),"d-m-Y");
									$tes			=	date_format(date_create($datax['tgl_tes']),"Y-m-d");
								else:
									$tes_selector	=	date("d-m-Y");
									$tes			=	date("Y-m-d");
								endif;
								if($datax['tgl_kegiatan']):
									$kegiatan_selector	=	date_format(date_create($datax['tgl_kegiatan']),"d-m-Y");
									$kegiatan			=	date_format(date_create($datax['tgl_kegiatan']),"Y-m-d");
								else:
									$kegiatan_selector	=	date("d-m-Y");
									$kegiatan			=	date("Y-m-d");
								endif;
							?>
							<div class="row">
								<div class="col-sm-6">
								
									<div class="form-group">
										<label for="tanggal_input">Tes Urin Ke</label>
										<select name="idx_tes" class="form-control" id="id_tes">
											<option value="1" <?=($datax['idx_tes']==1)?"selected":""?>>Tes Urin Ke-1</option>
											<option value="2" <?=($datax['idx_tes']==2)?"selected":""?>>Tes Urin Ke-2</option>
											<option value="3" <?=($datax['idx_tes']==3)?"selected":""?>>Tes Urin Ke-3</option>
											<option value="4" <?=($datax['idx_tes']==4)?"selected":""?>>Tes Urin Ke-4</option>
										</select>
									</div>
								
								</div><!--End Of Col 6-->
								
								<div class="col-sm-6">
								
									<div class="form-group">
										<label for="tanggal_input" id="tgl_tes">Tanggal Tes</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="tgl_registrasi_selector" class="form-control input-date required" value="<?=$tes_selector?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
												<input type="hidden" id="tgl_registrasi" name="tanggal_tes" value="<?=$tes?>" class="required" />
										</div>	
									</div>								
								
								</div><!--End Of Col 6-->
								
							</div>
							
							<?php
								if($datax['idx_tes']):
									if($datax['hasil_tes_'.$datax['idx_tes']]==1){
										$positive_checked	=	"checked='checked'";
										$negative_checked	=	"";
									}else{
										$positive_checked	=	"";
										$negative_checked	=	"checked='checked'";
									}
								else:
									$positive_checked	=	"checked='checked'";
									$negative_checked	=	"";
								endif;
							?>
							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label id="hasil_tes_label">Hasil Tes</label>
										<table cellpadding="5" cellspacing="5">
											<tr>
												<td width="50"><strong>Positif</strong></td>
												<td>[ <i class="fa fa-plus red"></i> ]</td>
												<td width="25">&nbsp;</td>
												<td align="center"><input type="radio" id="radio_plus" name="hasil_tes" <?=$positive_checked?> value="1" /></td>
											</tr>
											<tr>
												<td><strong>Negatif</strong></td>
												<td>[ <i class="fa fa-minus green"></i> ]</td>
												<td></td>
												<td align="center"><input type="radio" id="radio_minus" name="hasil_tes" <?=$negative_checked?> value="2" /></td>
											</tr>
										</table>
									</div>						
								</div>
								
								<div class="col-sm-6">
									<div class="well well-sm">
										**) Keterangan:<br /> [ <i class="fa fa-plus red"></i> ] Menunjukkan Hasil Evaluasi Tidak Baik <br />[ <i class="fa fa-minus green"></i> ] Menunjukkan Hasil Evaluasi Baik. 
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label>Keterangan Tes Urin</label>
								<textarea name="keterangan" class="form-control" rows="3" id="keterangan"><?=$datax['keterangan']?></textarea>
							</div>
							
							<div class="form-group">
								<label>Nama PJ/Keluarga</label>
								<input type="text" name="nama_pj_keluarga" class="form-control" value="<?=$datax['nama_pj_keluarga']?>" id="nm_keluarga" />
							</div>
							
							<div class="form-group">
								<label>No Telepon PJ/Keluarga</label>
								<input type="text" name="no_telp_pj_keluarga" class="form-control" value="<?=$datax['no_telp_pj_keluarga']?>" id="notlp_keluarga" />
							</div>
							
							<div class="form-group">
								<label>Alamat PJ/Keluarga</label>
								<textarea name="alamat_pj_keluarga" class="form-control" rows="3" id="alamat"><?=$datax['alamat_pj_keluarga']?></textarea>
							</div>
							
							<div class="form-group">
								<label>Nama Pemantau</label>
								<input type="text" name="nama_petugas_tes" class="form-control" value="<?=$datax['nama_petugas_tes']?>" id="nm_petugas" />
							</div>
							
							<div class="form-group">
									<label for="nm_petugas">Lampiran</label>
									<input type="file" name="lampiran" id="lampiran"  />
									<div class="label_lampiran">
									<?php if($datax["lampiran"]){?>
										File: <a target="_blank" href="<?=$this->config->item("dir_pemantauan_urin").$datax["lampiran"]?>">Download</a>
									<?php } ?>
									</div>
							</div><!--
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
									<label for="nama">Status Kegiatan</label>
									<?//=form_dropdown("status_pasien",$lookup_status,
										//	$datax["status_pasien"],
										//	"id='status_pasien' 
										//	class='form-control select2 required'");?>
									</div>
									<div class="col-md-6 tgl_selesai">
										<?php
											//$tgl_selesai=date("Y-m-d H:i:s");
										?>
										<label for="nama">Tgl Selesai Kegiatan</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											<input type="text" id="tgl_selesai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai))?>" placeholder="dd/mm/yyyy"/>
											 <input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?//=date("Y-m-d",strtotime($tgl_selesai));?>" class="required" />
										</div
									</div>
								</div>
							</div>
							-->
							<?php
								// $lookup["SS"]="Assesment";
								$lookup_proses_berikutnya=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
								$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
								$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
								$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
								$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
								$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
							?>
							<div class="form-group status_proses hidden">
								<label for="nama">Penempatan Berikutnya?</label>
								<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
										$kondisi["inst_pasca"],
										"id='status_proses' 
										class='form-control select2 required'");?>
							</div><!-- end form-->
							<div class="form-group bnnp hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='JALAN'):?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayah,$kondisi["rujuk_pasca"],"id='bnnp' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayah,$kondisi["rujuk_pasca"],"id='bnnp' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group bnnk hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='JALAN'):?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$kondisi["rujuk_pasca"],"id='bnnk' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$kondisi["rujuk_pasca"],"id='bnnk' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group balailoka hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $kondisi['inst_pasca']=='BL'):?>
									<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$kondisi["rujuk_pasca"],"id='balailoka' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$kondisi["rujuk_pasca"],"id='balailoka' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group km hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $kondisi['inst_pasca']=='KM'):?>
									<?=form_dropdown("id_km",$lookup_wilayah3,$kondisi["rujuk_pasca"],"id='km' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_km",$lookup_wilayah3,$kondisi["rujuk_pasca"],"id='km' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group rd hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $kondisi['inst_pasca']=='RD'):?>
									<?=form_dropdown("id_rd",$lookup_wilayah4,$kondisi["rujuk_pasca"],"id='rd' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_rd",$lookup_wilayah4,$kondisi["rujuk_pasca"],"id='rd' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							
							<!--
							<div class="form-group status_proses">
								<div class="row">
									<div class="col-md-6">
									<label for="nama">Proses Berikutnya?</label>
									<?//=form_dropdown("status_proses",$lookup_status_berikutnya,
										//	$data["status_proses"],
										//	"id='status_proses' 
										//	class='form-control select2 required'");?>
									</div>
								</div>
							</div>
							-->
						<!--</form>-->
						</div>
                      </div>
					</div>
					<div class="col-sm-6">
						
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Pasien</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rehabilitasi</a></li>
                                         <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Pasca Rehab</a></li>
										<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Pasca / Lanjut</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home" style=" backgorund-color:grey">
											<h4 class="heading" style="margin-top:10px;">Status Pasien</h4>									
											<?=$this->load->view("common_view/pasien/progress_v");?>
											<h4 class="heading">Pasien</h4>
											<?=$this->load->view("common_view/pasien/v_data_pasien");?>
										</div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
											<!--
											<h4 class="heading">History Rehab</h4>
											<?//=$this->load->view("common_view/pasien/v_hstry_rehab");?>
											-->
											<h4 class="heading">Monitoring Rehab</h4>
											<? $data['rawat_inap']='rawat_inap'?>
											<? $data['rawat_jalan']='rawat_jalan'?>
											<?=$this->load->view("common_view/pasien/v_mntr_rehab",$data);?>
											
										
										</div>
                                      
                                      
										
										 <div role="tabpanel" class="tab-pane" id="messages">
										 	<!--
											<h4 class="heading">History Pasca</h4>
											<?//=$this->load->view("common_view/pasien/v_hstry_pasca");?>
											-->
											<h4 class="heading">Monitoring Pasca</h4>
											<? $data['rawat_inap_pasca']='rawat_inap_pasca'?>
											<? $data['rawat_jalan_pasca']='rawat_jalan_pasca'?>
											<?=$this->load->view("common_view/pasien/v_mntr_pasca",$data);?>
										
										</div>
										<div role="tabpanel" class="tab-pane" id="settings">
											<!--
											<h4 class="heading">History Lanjut</h4>
											<?//=$this->load->view("common_view/pasien/v_hstry_lanjut");?>
											-->
											<h4 class="heading">Monitoring Lanjut</h4>
											<? $data['rawat_lanjut_pemantauan']='rawat_lanjut_pemantauan'?>
											<?=$this->load->view("common_view/pasien/v_mntr_lanjut",$data);?>
										</div>
                                    </div>
							
					</div>
				</div>				
                <!-- /.box-body -->
              </div>
        </div>
		
		<div class="box box-widget">
			<div class="box-body">
				<div class="row">
					<div class="col-sm-12">
						<h4 class="heading">Program</h4>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
								<label for="nama">Status Program</label>
								<?=form_dropdown("status_program",$lookup_status_p,
												$data_proses["status_program"],
												"id='status_program' 
												class='form-control select2 required'");?>
								</div>
								<div class="col-md-3 tgl_selesai_program">
									<?php
										$tgl_selesai_program=date("Y-m-d H:i:s");
									?>
									<label for="nama">Tgl Selesai Program</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" id="tgl_selesai_program_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai_program))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
										 <input type="hidden" id="tgl_selesai_program" name="tgl_selesai_program" value="<?=date("Y-m-d",strtotime($tgl_selesai_program));?>" class="required" />
									</div><!-- end input group -->
								</div>
							</div>
						</div>
						<div class="form-group outcome">
							<div class="row">
								<div class="col-md-3">
								<label for="nama">Outcome Pasien Pascarehabilitasi</label>
								<?=form_dropdown("outcome_pasien",$lookup_status_outcome,
											$data["outcome_pasien"],
											"id='outcome_pasien' 
											style='width:100%' class='form-control select2' disabled ");?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
		
    </div>
</section>

<script>
$(document).ready(function(){
	$("#status_program").on("change",function(){
		var val	=	$(this).val();
		if(val=="DO" || val=="MD"){
			$(".form-control").removeClass("required");
		}else{
			$(".form-control").addClass("required");
		}
	});
});
</script>

<script>
	$(document).ready(function(){
		$(".del_ajax").click(function(e){
			
			var konfirmasi	=	confirm("Apakah Anda Yakin Akan Menghapus Data Ini?");
			
			if(konfirmasi==true){
				var del_url		=	'<?=$this->module?>delete_ajax';
				
				var string = $(this).data("ref");
				eval('var object='+string);
				var idx		=	object.idx;

				$.ajax({
					type		:	"POST",
					url			:	del_url,
					cache		:	false,
					data		:	object,
					success		:	function(result) {
						if (result){
							$("#tr_"+idx).remove();
							new PNotify({
								title	:	'Info',
								text	:	'Hapus Data Berhasil!',
								type	:	'success'
							});
							var length	=	$(".data_tbl tr").length;							
							if(length==0){
								$("#act").val("create");
							}
						}
					}
				});
			}else{
				e.preventDefault(); 
			}
		});
	});
</script>		

<script>
	$(function() {
		$(".tgl_selesai").hide();
		$('#tgl_selesai').prop( "disabled", true );
		$('#tgl_selesai_selector').prop( "disabled", true );
		
		$(".tgl_selesai_program").hide();
		$('#tgl_selesai_program').prop( "disabled", true );
		$('#tgl_selesai_program_selector').prop( "disabled", true );
		
		$(".status_prosesx").hide();
		$('#status_prosesx').prop( "disabled", true );
		
		$('#outcome_pasien').prop( "disabled", true );
		$('.outcome').hide(); 
		$("#status_pasien").on("change",function(){
			if($(this).find("option:selected").val()=='PS'){
				$(".tgl_selesai").hide();
				$('#tgl_selesai').prop( "disabled", true );
				$('#tgl_selesai_selector').prop( "disabled", true );
				
				$(".status_prosesx").hide();
				$('#status_prosesx').prop( "disabled", true );
				
				$('#outcome_pasien').prop( "disabled", true );
				$('.outcome').hide(); 
			}else{
				$(".tgl_selesai").show();
				$('#tgl_selesai').prop( "disabled", false );
				$('#tgl_selesai_selector').prop( "disabled", false );
				
				$(".status_prosesx").show();
				$('#status_prosesx').prop( "disabled", false );
				
				$('#outcome_pasien').prop( "disabled", false );
				$('.outcome').show(); 
				
			}
		});
		$("#status_program").on("change",function(){
			// alert($(this).find("option:selected").val());
			if($(this).find("option:selected").val()=='PS'){
				$(".tgl_selesai_program").hide();
				$('#tgl_selesai_program').prop( "disabled", true );
				$('#tgl_selesai_program_selector').prop( "disabled", true );
				$('#outcome_pasien').prop( "disabled", true );
				$('.outcome').hide(); 
			}else if($(this).find("option:selected").val()=='KB' || $(this).find("option:selected").val()=='MD'){
				$(".tgl_selesai_program").show();
				$('#tgl_selesai_program').prop( "disabled", false );
				$('#tgl_selesai_program_selector').prop( "disabled", false );
				$('#outcome_pasien').prop( "disabled", true );
				$('.outcome').hide(); 
			}else{
				$(".tgl_selesai_program").show();
				$('#tgl_selesai_program').prop( "disabled", false );
				$('#tgl_selesai_program_selector').prop( "disabled", false );
				$('#outcome_pasien').prop( "disabled", false );
				$('.outcome').show(); 
			}
		});

	});
	
</script>
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
<script>
	$(function() {
		// var non = $('#outcome_pasien').val();
		// $("#bnnpk").select2({'placeholder':"--Pilih--"});
		<?php if($data['outcome_pasien']==''):?>
			// $('.outcome').hide(); 
		<?php else: ?>
			// $('.outcome').show(); 
			// $('#outcome_pasien').prop( "disabled", false );
		<?php endif; ?>
		// <?php if($data['status_rawat']=='PASCA' && $data['inst_rujuk']=='PRRIDA'):?>
			// $('.bnnpk').hide(); 
		// <?php elseif($data['status_rawat']==NULL): ?>
			// $('.bnnpk').hide(); 
		// <?php endif; ?>
		// alert(non);
		// if(non == ''){
			// $('.outcome').hide(); 
		// }
		
		$('#status_pasien').change(function(){
			if($('#status_pasien').val() == 'SL'){
				$('#outcome_pasien').prop( "disabled", false );
				// $('#outcome_pasien').val();
				$('.outcome').show(); 
						
			} else {
				$('#outcome_pasien').prop( "disabled", true );
				// $('#outcome_pasien').val();
				$('.outcome').hide(); 
							
			}
		});
	});
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