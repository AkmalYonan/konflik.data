<?php
	$lookup_status[0]="Belum diperiksa"; //menunggu verifikasi
	$lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	$lookup_status[2]="Selesai"; //menunggu rekam medik
	$lookup_status[9]="DiTolak";  
	
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	$lookup_diagnosa_kerja=lookup("m_diagnosa_kerja","kode","keterangan","","order by order_num");
	
	$lookup_status_berikutnya=lookup("m_proses_rehab","kd_status_proses","ur_proses","kd_status_rehab=2 and flag_proses=1","order by kd_status_rehab,order_num");
	$lookup_jenis_kegiatan["pt1"]="4 Bulan";
	$lookup_jenis_kegiatan["pt2"]="6 Bulan";
	//pre($data['tgl_registrasi']);
?>	
    
    <div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<?php
					$tgl_kedatangan=$data_assesment["tgl_kedatangan"]?$data_assesment["tgl_kedatangan"]:date("Y-m-d H:i:s");
				?>
				<label for="nama">Tgl Kedatangan</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" id="tgl_kedatangan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_kedatangan))?>" placeholder="dd/mm/yyyy"  data-mindate="<?=date("d/m/Y",strtotime($data['tgl_registrasi']))?>" />
					<input type="hidden" id="tgl_kedatangan" name="tgl_kedatangan" value="<?=date("Y-m-d",strtotime($tgl_kedatangan));?>" class="required" />
				</div><!-- end input group -->				
			</div><!-- end form group-->
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="jenis_pendidikan">Jenis Treatment</label>
				<? echo form_dropdown("jns_treat",$lookup_jenis_kegiatan,$data["jns_treat"],"id='jns_treat' class='form-control required'");?>
			</div><!-- end form group-->
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="jenis_pendidikan">Nama Petugas Assesment</label>
				<input type="text" name="petugas_assesment" class="form-control" value="<?=$data_assesment["petugas_assesment"]?>" required />
			</div><!-- end form group-->
		</div>
	</div><!-- end row col -->    
    
    <h4 class="heading">Kesimpulan Masalah yang dihadapi (isi 1-9)</h4>
	<div class="row">
		<div class="col-md-6">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th colspan="5">Masalah yang dihadapi</th>
					</tr>
					<tr>
						<th>Masalah</th>
						<th>Nilai</th>
						<th>&nbsp;</th>
						<th>Masalah</th>
						<th>Nilai</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="50"><strong>Medis</strong></td>
						<td width="25">
							<input class="form-control required validate_input" name="masalah_medis" id="masalah_medis" type="text" value="<?php echo $data_assesment["masalah_medis"];?>" maxlength="1" min="1" required />
						</td>
						<td width="25">&nbsp;
							
						</td>
						<td width="50"><strong>Legal</strong></td>
						<td width="25">
							<input class="form-control required validate_input" name="masalah_legal" id="masalah_legal" type="text" value="<?php echo $data_assesment["masalah_legal"];?>" maxlength="1" min="1" required />
						</td>
					</tr>
					<tr>
						<td width="50"><strong>Pekerjaan</strong></td>
						<td width="25">
							<input class="form-control required validate_input" name="masalah_pekerjaan" id="masalah_pekerjaan" type="text" value="<?php echo $data_assesment["masalah_pekerjaan"];?>" maxlength="1" min="1" required />
						</td>
						<td width="25">&nbsp;
							
						</td>
						<td width="50"><strong>Keluarga/Sosial</strong></td>
						<td width="25">
							<input class="form-control required validate_input" name="masalah_keluarga" id="masalah_keluarga" type="text" value="<?php echo $data_assesment["masalah_keluarga"];?>" maxlength="1" min="1" required />
						</td>
					</tr>
					<tr>
						<td width="50"><strong>Napza</strong></td>
						<td width="25">
							<input class="form-control required validate_input" name="masalah_napza" id="masalah_napza" type="text" value="<?php echo $data_assesment["masalah_pekerjaan"];?>" maxlength="1" min="1" required />
						</td>
						<td width="25">&nbsp;
							
						</td>
						<td width="50"><strong>Psikiatris</strong></td>
						<td width="25">
							<input class="form-control required validate_input" name="masalah_psikiatris" id="masalah_psikiatris" type="text" value="<?php echo $data_assesment["masalah_keluarga"];?>" maxlength="1" min="1" required />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th colspan="3" class="tmiddle" align="center">Skala Penilaian</th>
					</tr>
					<tr>
						<th width="25">No</th>
						<th>Rentang Nilai</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>0 - 1</td>
						<td>Tidak ada masalah yang berarti, tidak perlu intervensi</td>
					</tr>
					<tr>
						<td>2</td>
						<td>2 - 3</td>
						<td>Ada sedikit masalah, tetapi intervensi/ bantuan tidak terlalu penting</td>
					</tr>
					<tr>
						<td>3</td>
						<td>4 - 5</td>
						<td>Masalah tergolong sedang, tetapi butuh beberapa bantuan / intervensi</td>
					</tr>
					<tr>
						<td>4</td>
						<td>6 - 7</td>
						<td>Masalah serius, dibutuhkan intervensi/ bantuan</td>
					</tr>
					<tr>
						<td>5</td>
						<td>8 - 9</td>
						<td>Masalah sangat serius/ berat, sangat membutuhkan intervensi / bantuan</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div><!-- end row -->
	
    <h4 class="heading">Diagnosa Kerja</h4>
    <div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="nama">Klien memenuhi kriteria diagnosis napza</label>
				<!--
				<input class="form-control required validate_input" name="diagnosis_napza" id="diagnosis_napza" type="text" value="<?//php echo $data_assesment["diagnosis_napza"];?>" maxlength="1" />
				-->
				<select name="diagnosis_napza" class="form-control" id="diagnosis_napza" required>
					<option value="">--Pilih Diagnosis Napza--</option>
					<?php foreach($lookup_diagnosa_kerja as $k=>$v): ?>
					<option value="<?=$k?>" <?=($k==$data_assesment["diagnosis_napza"])?"selected":""?>>[<?=$k?>] - <?=$v?></option>
					<?php endforeach; ?>
				</select>
			</div><!-- end form-->
		</div>
		<div class="col-md-6">	
			<div class="form-group">
				<label for="nama">Diagnosis Lainnya</label>
				<input class="form-control required" name="diagnosis_lain" id="diagnosis_lain" type="text" value="<?php echo $data_assesment["diagnosis_lain"];?>" />
			</div><!-- end form-->
		</div>
	</div><!-- end row -->
    
    
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
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="nama">Keterangan Rencana Terapi</label>
				<input class="form-control required" name="rencana_terapi_ket" id="rencana_terapi_ket" type="text" value="<?php echo $data_assesment["rencana_terapi_ket"];?>" />
			</div><!-- end form-->
		</div>
	</div><!-- end row -->
	
<script>
$(document).ready(function(){
    $('.validate_input').keypress(validateNumber);
});

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;

    if (event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 37 || event.keyCode === 39) {
        return true;
    }
    else if ( key < 48 || key > 57 ) {
        return false;
    }
    else return true;
};
</script>    
    