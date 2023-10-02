<?php
	$lookup_status[0]="Belum diperiksa"; //menunggu verifikasi
	$lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	$lookup_status[2]="Selesai"; //menunggu rekam medik
	$lookup_status[9]="DiTolak";  
	
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	$lookup_status_berikutnya=lookup("m_proses_rehab","kd_status_proses","ur_proses","kd_status_rehab=2 and flag_proses=1","order by kd_status_rehab,order_num");
	//pre($lookup_status_proses_next);
	/*
	[RIRMDT] => Detox / MPA
    [RIRMEU] => Entry Unit
    [RIRS] => Rehabilitasi Sosial
    [RIRSRP] => Layanan Primary Program (4-6 Bulan)
    [RIRSRE] => Layanan Re-Entry (4-6 Bulan)
    [RJ] => Rawat Jalan
	*/
?>	
    
    <div class="row">
    <div class="col-md-6">
    	<div class="form-group">
            <?php
                $tgl_kedatangan=$data_assesment["tgl_kedatangan"]?$data_assesment["tgl_kedatangan"]:date("Y-m-d H:i:s");
                                ?>
                <label for="nama">Tgl Kedatangan</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_kedatangan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_kedatangan))?>" placeholder="dd/mm/yyyy"/>
                     <input type="hidden" id="tgl_kedatangan" name="tgl_kedatangan" value="<?=date("Y-m-d",strtotime($tgl_kedatangan));?>" class="required" />
                </div><!-- end input group -->
                            
        </div><!-- end form group-->
    </div></div><!-- end row col -->    
    
    <h4 class="heading">Kesimpulan Masalah yang dihadapi (isi 0-9)</h4>
	<div class="row">
    <div class="col-md-6">
    <div class="form-group">
    	<label for="nama">Medis</label>
		<input class="form-control required" name="masalah_medis" id="masalah_medis" type="text" value="<?php echo $data_assesment["masalah_medis"];?>" />
	</div><!-- end form-->
    
    
    <div class="form-group">
    	<label for="nama">Pekerjaan</label>
		<input class="form-control required" name="masalah_pekerjaan" id="masalah_pekerjaan" type="text" value="<?php echo $data_assesment["masalah_pekerjaan"];?>" />
	</div><!-- end form-->
	
    <div class="form-group">
    	<label for="nama">Napza</label>
		<input class="form-control required" name="masalah_napza" id="masalah_napza" type="text" value="<?php echo $data_assesment["masalah_napza"];?>" />
	</div><!-- end form-->
	
    <div class="form-group">
    	<label for="nama">Legal</label>
		<input class="form-control required" name="masalah_legal" id="masalah_legal" type="text" value="<?php echo $data_assesment["masalah_legal"];?>" />
	</div><!-- end form-->
	
    <div class="form-group">
    	<label for="nama">Keluarga/Sosial</label>
		<input class="form-control required" name="masalah_keluarga" id="masalah_keluarga" type="text" value="<?php echo $data_assesment["masalah_keluarga"];?>" />
	</div><!-- end form-->
    
    <div class="form-group">
    	<label for="nama">Psikiatris</label>
		<input class="form-control required" name="masalah_psikiatris" id="masalah_psikiatris" type="text" value="<?php echo $data_assesment["masalah_psikiatris"];?>" />
	</div><!-- end form-->
	
    </div></div><!-- end row -->
    
    
    <h4 class="heading">Diagnosa Kerja</h4>
    
    <div class="form-group">
    	<label for="nama">Klien memenuhi kriteria diagnosis napza</label>
		<input class="form-control required" name="diagnosis_napza" id="diagnosis_napza" type="text" value="<?php echo $data_assesment["diagnosis_napza"];?>" />
	</div><!-- end form-->
    
    <div class="form-group">
    	<label for="nama">Diagnosis Lainnya</label>
		<input class="form-control required" name="diagnosis_lain" id="diagnosis_lain" type="text" value="<?php echo $data_assesment["diagnosis_lain"];?>" />
	</div><!-- end form-->
    
    
    
    <h4 class="heading">Resume Masalah/Rencana Terapi</h4>
    <div class="row">
    <div class="col-md-6">
    <div class="form-group">
    	<label for="nama">Resume Masalah</label>
		<input class="form-control required" name="rencana_terapi_resume" id="rencana_terapi_resume" type="text" value="<?php echo $data_assesment["rencana_terapi_resume"];?>" />
	</div><!-- end form-->
    
    <div class="form-group">
    	<label for="nama">Rencana Terapi</label>
		<input class="form-control required" name="rencana_terapi" id="rencana_terapi" type="text" value="<?php echo $data_assesment["rencana_terapi"];?>" />
	</div><!-- end form-->
    
    
    <div class="form-group">
    	<label for="nama">Keterangan Rencana Terapi</label>
		<input class="form-control required" name="rencana_terapi_ket" id="rencana_terapi_ket" type="text" value="<?php echo $data_assesment["rencana_terapi_ket"];?>" />
	</div><!-- end form-->
    
    
    </div></div><!-- end row -->
    
    