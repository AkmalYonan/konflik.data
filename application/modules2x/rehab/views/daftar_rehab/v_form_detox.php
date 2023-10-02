<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?php
	$lookup_status["PS"]="Proses";
	$lookup_status["DO"]="DO";
	$lookup_status["KB"]="Kambuh"; 
	$lookup_status["SL"]="Selesai";  
	
	// $lookup_status[0]="Belum diperiksa"; //menunggu verifikasi
	// $lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	// $lookup_status[2]="Selesai"; //menunggu rekam medik
	// $lookup_status[9]="DiTolak";  
	
	// $lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	// $lookup_proses_current["SS"]="Assesment";
	// $lookup_proses_berikutnya=$lookup_proses_current+lookup("m_proses_rehab","kd_status_proses","ur_proses","kd_status_rehab=2 and flag_proses=1","order by kd_status_rehab,order_num");
?>	
<form id="frm" method="post" enctype="multipart/form-data" action="<?php echo $this->module;?>update_detox/<?php echo $id;?>">
    <? if(cek_array($data_detox)):?>
    	<input type="hidden" name="act" id="act" value="update"/>
    <? else:?>
		<input type="hidden" name="act" id="act" value="create"/>
    <? endif;?>
    <input type="hidden" name="idx_pasien" id="idx_pasien" value="<?=$data["idx"]?>"/>
    <input type="hidden" name="idx" id="idx" value="<?=$data_detox["idx"]?>"/>
    <div class="row">
    <div class="col-md-12">
    	<div class="form-group">
            <?php
                $tgl_kegiatan=$data_detox["tgl_kegiatan"]?$data_detox["tgl_kegiatan"]:date("Y-m-d H:i:s");
                                ?>
                <label for="nama">Tgl Kegiatan</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_kegiatan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_kegiatan))?>" placeholder="dd/mm/yyyy"/>
                     <input type="hidden" id="tgl_kegiatan" name="tgl_kegiatan" value="<?=date("Y-m-d",strtotime($tgl_kegiatan));?>" class="required" />
                </div><!-- end input group -->
                            
        </div><!-- end form group-->
    
    	<div class="form-group">
                          <label for="kd_jenis_instansi">Lama Detoksifikasi</label>
                          <input class="form-control required" name="lama_detox" id="lama_detox" type="text" value="<?php echo $data_detox["lama_detox"];?>" />
                        </div>
		<div class="form-group">
                          <label for="jenis_kegiatan">Jenis Kegiatan</label>
                          <input class="form-control required" name="jenis_kegiatan" id="jenis_kegiatan" type="text" value="<?php echo $data_detox["jenis_kegiatan"];?>" />
                        </div>
    	<div class="form-group">
        					<label for="alamat">Keterangan</label>
							<textarea class="input-xs form-control" id="keterangan" rows="3" name="keterangan" placeholder=""><?=$data_detox["keterangan"]?></textarea>
        </div>
    
    	<div class="form-group">
            <?php
                $tgl_mulai=$data_detox["tgl_mulai"]?$data_detox["tgl_mulai"]:date("Y-m-d H:i:s");
                                ?>
                <label for="nama">Tgl Mulai</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_mulai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_mulai))?>" placeholder="dd/mm/yyyy"/>
                     <input type="hidden" id="tgl_mulai" name="tgl_mulai" value="<?=date("Y-m-d",strtotime($tgl_kegiatan));?>" class="required" />
                </div><!-- end input group -->
                            
        </div><!-- end form group-->
        
        <div class="form-group">
            <?php
                $tgl_selesai=$data_detox["tgl_selesai"]?$data_detox["tgl_selesai"]:date("Y-m-d H:i:s");
                                ?>
                <label for="nama">Tgl Selesai</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_selesai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai))?>" placeholder="dd/mm/yyyy"/>
                     <input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date("Y-m-d",strtotime($tgl_selesai));?>" class="required" />
                </div><!-- end input group -->
                            
        </div><!-- end form group-->
		<div class="form-group">
					<label for="nama">Lampiran</label>
					<input type="file" name="lampiran">
					<?php if($data_detox["lampiran"]){?>
						File: <a target="_blank" href="<?=$this->config->item("dir_detok").$data_detox["lampiran"]?>">Download</a>
					<?php } ?>
				</div><!-- end form-->
		<div class="form-group">
					<label for="nama">Status Pasien</label>
					<?=form_dropdown("status_pasien",$lookup_status,
							$data_detox["status_pasien"],
							"id='status_pasien' 
							class='form-control select2 required'");?>
				</div><!-- end form-->
		<!--
		<h4 class="heading">Disclaimer</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nama">Status Detox?</label>
					<?//=form_dropdown("status_check_doc",$lookup_status,
							//$data["status_check_doc"],
							//"id='status_check_doc' 
							//class='form-control select2 required'");?>
				</div>
				<div class="form-group status_proses">
					<label for="nama">Proses Berikutnya?</label>
					<?//=form_dropdown("status_proses",$lookup_proses_berikutnya,
							//$data["status_proses"],
							//"id='status_proses' 
							//class='form-control select2 required'");?>
				</div>
			</div>
		</div>
		-->
		<!--
    	<div class="row">
			<div class="col-md-6">
				<div class="form-actions">
					<button type="submit" class="btn btn-primary">Save changes</button>
					<button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
				</div>
			</div>
		</div>
		-->
    
    </div></div><!-- end row col -->  
    
    
      
</form>