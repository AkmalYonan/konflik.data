<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	
	$lookup_pertemuan[1]="1";
	$lookup_pertemuan[2]="2";
	$lookup_pertemuan[3]="3";
	$lookup_pertemuan[4]="4";
	
	$lookhasil[1] ="TIdak Produktif";
	$lookhasil[2] ="Family Issue";
	$lookhasil[3] ="Social ";
	$lookhasil[4] ="Environment Issue";
	$lookhasil[5] ="Hukum";
	
	$lookup_status["PS"]="Proses";
	$lookup_status["SL"]="Selesai";  
	
	//pre($monitoring_pasca);
	$tgl_limit_prev = $monitoring_pasca['tgl_mulai_pasca'];
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
	<div class="row">
    <div class="col-md-12">
    	<div class="form-group">
				<div class="row">
                    <div class="col-md-6">
						<?php
                        $tgl_penerimaan_pascarehab=$data_proses["tgl_mulai"]?$data_proses["tgl_mulai"]:date("Y-m-d H:i:s");
                        ?>
                        <label for="tgl_rehab">Tanggal Mulai</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" id="tgl_mulai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_penerimaan_pascarehab))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
                             <input type="hidden" id="tgl_mulai" name="tgl_mulai" value="<?=date("Y-m-d",strtotime($tgl_penerimaan_pascarehab));?>" class="required" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for=" 	jenis_kegiatan">Jenis Kegiatan</label>
                        <select name="jenis_kegiatan" class="form-control">
                                <? foreach($jns_kegiatan as $k=>$v){?>
                                    <option  <?=($data_proses["jenis_kegiatan"]==$v["kd_jenis_kegiatan"])? "Selected":""?> value="<?=$v['kd_jenis_kegiatan']?>"><?=$v['ur_jenis_kegiatan']?></option>
                                <? }?>
                        </select>
                    </div>
			</div>
		</div>
		
    	<div class="form-group">
                <label for="keterangan">Keterangan</label>
				<textarea class="input-xs form-control" id="keterangan" rows="3" name="keterangan" placeholder=""><?=$data_proses["keterangan"]?></textarea>							
        </div>
		<div class="form-group">
			<label for="nama">Lampiran</label>
			<input type="file" name="lampiran">
			<?php if($data_proses["lampiran"]){?>
				File: <a target="_blank" href="<?=$this->config->item("dir_da").$data_proses["lampiran"]?>">Download</a>
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
							class='form-control select2 required'");?>
				</div>
				<div class="col-md-6 tgl_selesai">
					<?php
						$tgl_selesai=date("Y-m-d H:i:s");
					?>
					<label for="nama">Tgl Selesai Kegiatan</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="text" id="tgl_selesai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
						 <input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date("Y-m-d",strtotime($tgl_selesai));?>" class="required" />
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
		
    </div>
	</div><!-- end row col -->  
