<!--Add-->
<style>
input[type="radio"] {
    -webkit-appearance: checkbox;
    -moz-appearance: checkbox;
    -ms-appearance: checkbox;     /* not currently supported */
    -o-appearance: checkbox;      /* not currently supported */
}
</style>
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
	
	
?>
<form id="frm" method="post" enctype="multipart/form-data" action="<?php echo $this->module;?>update_proses/<?php echo $id;?>">
	<? if(cek_array($data_proses)):?>
		
    	<input type="hidden" name="act" id="act" value="update"/>
    <? else:?>
		<input type="hidden" name="act" id="act" value="create"/>
    <? endif;?>
    <input type="hidden" name="idx_pasien" id="idx_pasien" value="<?=$data["idx"]?>"/>
    <input type="hidden" name="idx" id="idx" value="<?=$data_proses["idx"]?>"/>
    <div class="row">
    <div class="col-md-12">
    	<!-- <div class="form-group">
            <?php
                $tgl_kegiatan=$data_proses["tgl_kegiatan"]?$data_proses["tgl_kegiatan"]:date("Y-m-d H:i:s");
                                ?>
                <label for="nama">Tgl Kegiatan</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_kegiatan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_kegiatan))?>" placeholder="dd/mm/yyyy"/>
                     <input type="hidden" id="tgl_kegiatan" name="tgl_kegiatan" value="<?=date("Y-m-d",strtotime($tgl_kegiatan));?>" class="required" />
                </div>
                            
        </div>end form group-->
		
    	<div class="form-group">
                <label for="lokasi">Lokasi Kegiatan</label>
				<textarea class="input-xs form-control" id="lokasi" rows="3" name="lokasi" placeholder=""><?=$data_proses["lokasi"]?></textarea>							
        </div>
		<div class="form-group">
                <label for="jml_anggota">Jumlah Anggota Kelompok Hadir</label>
				<input type="number" class="form-control" name="jml_anggota" value="<?=$data_proses["jml_anggota"]?>" style="width:250px" />
		</div>
		
		
    	<div class="form-group">
				<div class="row">
				
				<div class="col-md-12">
					<label for="tgl_rehab">Pertemuan Ke 1</label>
					<p style="border-bottom:1px solid;"></p>
				</div>
				<div class="col-md-6">
				
				<?php
                $tgl_p1=$data_proses["tgl_p1"]?$data_proses["tgl_p1"]:date("Y-m-d H:i:s");
                                ?>
                <label for="tgl_rehab">Tanggal</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_p1_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_p1))?>" placeholder="dd/mm/yyyy"/>
                     <input type="hidden" id="tgl_p1" name="tgl_p1" value="<?=date("Y-m-d",strtotime($tgl_p1));?>" class="required" />
                </div>
				</div>
				<div class="col-md-6">
				<?php
                $tgl_penerimaan_pascarehab=$data_proses["tgl_penerimaan_pascarehab"]?$data_proses["tgl_penerimaan_pascarehab"]:date("Y-m-d H:i:s");
                                ?>
                <label for="hasilp1">Hasil</label>
                <table style="margin-bottom:10px">
					<tr>
					<td><label>Positif [ <span style="color:green;font-size:16px;"><b>+</b></span> ]  </label></td><td width="10"></td><td><input type="radio" <?=($data_proses["hasilp1"]==1)? "checked" : ""?> name="hasilp1" value="1"></td><td width="30">
					<td><label>Negatif [ <span style="color:red;font-size:16px;"><b>-</b></span> ]</label></td> <td width="10"></td><td><input type="radio" name="hasilp1" <?=($data_proses["hasilp1"]==2)? "checked" : ""?> value="2"></td><td width="30">
					</tr>
				</table>
				</div>
				</div>
				        
        </div>
		<div class="form-group">
				<div class="row">
				
				<div class="col-md-12">
					<label for="Pertemuan">Pertemuan Ke 2</label>
					<p style="border-bottom:1px solid;"></p>
				</div>
				<div class="col-md-6">
				
				<?php
                $tgl_p2=$data_proses["tgl_p2"]?$data_proses["tgl_p2"]:date("Y-m-d H:i:s");
                                ?>
                <label for="tgl_p2">Tanggal</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_p2_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_p2))?>" placeholder="dd/mm/yyyy"/>
                     <input type="hidden" id="tgl_p2" name="tgl_p2" value="<?=date("Y-m-d",strtotime($tgl_p2));?>" class="required" />
                </div>
				</div>
				<div class="col-md-6">
				<?php
                $tgl_penerimaan_pascarehab=$data_proses["tgl_penerimaan_pascarehab"]?$data_proses["tgl_penerimaan_pascarehab"]:date("Y-m-d H:i:s");
                                ?>
                <label for="hasilp2">Hasil</label>
                <table style="margin-bottom:10px">
					<tr>
					<td><label>Positif [ <span style="color:green;font-size:16px;"><b>+</b></span> ]  </label></td><td width="10"></td><td><input type="radio" <?=($data_proses["hasilp2"]==1)? "checked" : ""?> name="hasilp2" value="1"></td><td width="30">
					<td><label>Negatif [ <span style="color:red;font-size:16px;"><b>-</b></span> ]</label></td> <td width="10"></td><td><input type="radio" name="hasilp2"<?=($data_proses["hasilp2"]==2)? "checked" : ""?> value="2"></td><td width="30">
					</tr>
				</table>
				</div>
				</div>
				        
        </div>
    	
		
		
    	<div class="form-group">
                <label for="keterangan">Keterangan Pertemuan Kelompok</label>
				<textarea class="input-xs form-control" id="keterangan" rows="3" name="keterangan" placeholder=""><?=$data_proses["keterangan"]?></textarea>							
        </div>
		<div class="form-group">
                <label for="nm_petugas">Nama Petugas</label>
				<input type="text" class="form-control" name="nm_petugas" id="nm_petugas" value="<?=$data_proses["nm_petugas"]?>" />
		</div>
		<div class="form-group">
			<label for="nama">Lampiran</label>
			<input type="file" name="lampiran">
			<?php if($data_proses["lampiran"]){?>
				File: <a target="_blank" href="<?=$this->config->item("dir_dr").$data_proses["lampiran"]?>">Download</a>
			<?php } ?>
		</div><!-- end form-->
		<div class="form-group">
			<label for="nama">Status Pasien</label>
			<?=form_dropdown("status_pasien",$lookup_status,
					$data_proses["status_pasien"],
					"id='status_pasien' 
					class='form-control select2 required'");?>
		</div><!-- end form-->
		<!--<div class="formSep"></div>-->
        <?//=$this->load->view("v_pemeriksaan_dokumen");?>
    
    	<div class="row" hidden>
                    <div class="col-md-6">
                    	<div class="form-actions">
                            <!--<button type="submit" class="btn btn-primary">Save changes</button>-->
                            <button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
                        </div>
                    </div>
                  </div>
    
    
    </div></div><!-- end row col -->  
    
    
      
</form>