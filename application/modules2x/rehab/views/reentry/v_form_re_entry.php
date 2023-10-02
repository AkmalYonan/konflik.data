<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	
	$lookup_pertemuan[1]="1";
	$lookup_pertemuan[2]="2";
	$lookup_pertemuan[3]="3";
	$lookup_pertemuan[4]="4";
	
	$lookup_status["PS"]="Proses";
	$lookup_status["SL"]="Selesai";  
	
	$lookup_status_p["PS"]="Proses"; 
	$lookup_status_p["DO"]="DO";
	$lookup_status_p["MD"]="Meninggal Dunia";
	
	//pre($monitoring_rehab);
	$tgl_limit_prev = $monitoring_rehab['tgl_pt_selesai'];
?>
<form id="frm" method="post" enctype="multipart/form-data" action="<?php echo $this->module;?>update_proses/<?php echo $id;?>">
    <? if(cek_array($data_proses)):?>
    	<input type="hidden" name="act" id="act" value="update"/>
    <? else:?>
		<input type="hidden" name="act" id="act" value="create"/>
    <? endif;?>
		<input type="hidden" name="status_rm_sebelumnya" id="status_rm_sebelumnya" value="<?php echo $data["status_rm"];?>"/>
	<input type="hidden" name="status_program_sebelumnya" id="status_program_sebelumnya" value="<?php echo $data["status_program"];?>"/>
	<input type="hidden" name="outcome_pasien_sebelumnya" id="outcome_pasien_sebelumnya" value="<?php echo $data["outcome_pasien"];?>"/>
	
	<input type="hidden" name="idx_assesment" id="idx_assesment" value="<?=$data_asm["idx"]?>"/>
	<input type="hidden" name="no_rekam_medis" id="no_rekam_medis" value="<?=$data["no_rekam_medis"]?>"/>
	
    <input type="hidden" name="idx_pasien" id="idx_pasien" value="<?=$data["idx"]?>"/>
    <input type="hidden" name="idx" id="idx" value="<?=$data_proses["idx"]?>"/>
    <input type="hidden" name="jangka_waktu" id="jangka_waktu" value="4"/>
    <input type="hidden" name="jangka_waktu_satuan" id="jangka_waktu_satuan" value="minggu"/>
    <div class="row">
    <div class="col-md-12">
    	<div class="form-group">
			<div class="row">
				<div class="col-md-6">
            <?php
                $tgl_kegiatan=$data_proses["tgl_kegiatan"]?$data_proses["tgl_kegiatan"]:date("Y-m-d H:i:s");
                                ?>
                <label for="nama">Tgl Kegiatan</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_kegiatan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_kegiatan))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
                     <input type="hidden" id="tgl_kegiatan" name="tgl_kegiatan" value="<?=date("Y-m-d",strtotime($tgl_kegiatan));?>" class="required" />
                </div><!-- end input group -->
        </div></div>                  
        </div><!-- end form group-->
		<div class="form-group">
            <label for="kd_jenis_instansi">Jenis Kegiatan</label>
            <input class="form-control required" name="jenis_kegiatan" id="jenis_kegiatan" type="text" value="<?php echo $data_proses["jenis_kegiatan"];?>" />
        </div>
    	<div class="form-group">
        					<label for="alamat">Keterangan</label>
							<textarea class="input-xs form-control" id="kegiatan" rows="5" name="kegiatan" placeholder=""><?=$data_proses["kegiatan"]?></textarea>
        </div>
		<div class="form-group">
					<label for="nama">Lampiran</label>
					<input type="file" name="lampiran">
					<?php if($data_proses["lampiran"]){?>
						File: <a target="_blank" href="<?=$this->config->item("dir_re").$data_proses["lampiran"]?>">Download</a>
					<?php } ?>
				</div><!-- end form-->
    	<h4 class="heading">Konfirmasi</h4>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label for="nama">Status Kegiatan</label>
					<?=form_dropdown("status_pasien",$lookup_status,
							$data_proses["status_pasien"],
							"id='status_pasien' 
							class='form-control select2 required' style='width:100%'");?>
				</div>
				<div class="col-md-6 tgl_selesai">
					<?php
						$tgl_selesai=date("Y-m-d H:i:s");
					?>
					<label for="nama">Tgl Selesai Kegiatan</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="text" id="tgl_selesai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y")?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
						 <input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date("Y-m-d");?>" class="required" />
					</div><!-- end input group -->
				</div>
			</div>
		</div><!-- end form-->
		
		
		
		<?php
			// $lookup["SS"]="Assesment";
			$lookup_proses_berikutnya=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
			$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
			$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
			$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
			$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
			$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
		?>
		
		<div class="tempat_rujukan hide">
		
			<div class="form-group status_proses ">
				<div class="row">
					<div class="col-md-6">
					<label for="nama">Jenis Instansi</label>
					<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
							$data["inst_rujuk"],
							"id='status_proses' 
							class='form-control select2 required' style='width:100%'");?>
					</div>
				<!--</div>
			</div>--><!-- end form-->
			<div class="col-md-6">
			<div class="form-group bnnp ">
				<div class="row">
					<div class="col-md-12">
					<label for="nama">Tujuan Rujukan</label>
					<?php if($data['status_rawat']=='JALAN'):?>
						<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' class='form-control select2 required' style='width:100%'");?>
					<?php else: ?>
						<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' disabled class='form-control select2 required' style='width:100%'");?>
					<?php endif; ?>
					</div><!-- end form group -->
				</div>
			</div>
			<div class="form-group bnnk">
				<div class="row">
					<div class="col-md-12">
					<label for="nama">Tujuan Rujukan</label>
					<?php if($data['status_rawat']=='JALAN'):?>
						<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' class='form-control select2 required' style='width:100%'");?>
					<?php else: ?>
						<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' disabled class='form-control select2 required' style='width:100%'");?>
					<?php endif; ?>
					</div><!-- end form group -->
				</div>
			</div>
			<div class="form-group balailoka ">
				<div class="row">
					<div class="col-md-12">
					<label for="nama">Tujuan Rujukan</label>
					<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='BL'):?>
						<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' class='form-control select2 required' style='width:100%'");?>
					<?php else: ?>
						<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' disabled class='form-control select2 required' style='width:100%'");?>
					<?php endif; ?>
					</div><!-- end form group -->
				</div>
			</div>
			<div class="form-group km ">
				<div class="row">
					<div class="col-md-12">
					<label for="nama">Tujuan Rujukan</label>
					<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='KM'):?>
						<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' class='form-control select2 required' style='width:100%'");?>
					<?php else: ?>
						<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' disabled class='form-control select2 required' style='width:100%'");?>
					<?php endif; ?>
					</div><!-- end form group -->
				</div>
			</div>
			<div class="form-group rd ">
				<div class="row">
					<div class="col-md-12">
					<label for="nama">Tujuan Rujukan</label>
					<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='RD'):?>
						<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' class='form-control select2 required' style='width:100%'");?>
					<?php else: ?>
						<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' disabled class='form-control select2 required' style='width:100%'");?>
					<?php endif; ?>
					</div><!-- end form group -->
				</div>
			</div>
			
		</div>
		</div>
        
    </div>
    </div>
    </div>
    </div><!-- end row col -->    
