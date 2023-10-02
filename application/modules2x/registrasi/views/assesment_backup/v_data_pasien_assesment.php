<script src="assets/additional_js/sweetalert/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>
<link href="assets/additional_js/sweetalert/sweetalert/dist/sweetalert.css" rel="stylesheet" />

<?php
	$lookup_empty=array(""=>"--pilih--");
	$lookup_bnnp=lookup("m_org","kd_org","nama",false,"order by idx");
	$lookup_status_nikah=$this->data_lookup["status_kawin"];
	$lookup_balai=$lookup_empty+lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
	$lookup_jns_org=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org",false,"order by idx");
	$lookup_inst=lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
?>

<?php
	$batas_umur_bawah=10;
	$batas_umur_atas=90;
	$tahun_ini=date("Y");
	$tahun_akhir=$tahun_ini-$batas_umur_bawah;
	$tahun_awal=$tahun_ini-$batas_umur_atas;
	for($i=$tahun_akhir;$i>=$tahun_awal;$i--):
		$lookup_tahun[$i]=$i;
	endfor;                          
?>

<div class="row">
	<div class="col-md-12">
    	<table class="table table-bordered table-condensed" style="width:100%">
        	<!--<tr>
            	<td width="200px">BNNP</td>
                <td> <?//=$lookup_bnnp[$data["kd_bnn"]]?></td>
            </tr>-->
			<tr>
				<td align="center"><input type="checkbox" value="1" class="change_data_pasien" /></td>
				<td>Ubah Data Pasien</td>
			</tr>			
			<tr>
				<td colspan="2"><h4 class="heading">Data Pasien</h4></td>
			</tr>
			<tr>
            	<td>NIK</td>
                <td> <?=$data["nik"]?></td>
            </tr>
            <tr>
            	<td width="200px">Nama</td>
                <td class="form"><?=$data["nama"]?></td>
				<td class="form_edit hide"><input type="text" name="nama" class="form-control" value="<?=$data["nama"]?>" style="width:25%" /></td>
            </tr>
			<tr>
            	<td>Alamat</td>
                <td class="form"> <?=$data["alamat"]?></td>
				<td class="form_edit hide"><input type="text" name="alamat" class="form-control" value="<?=$data["alamat"]?>" style="width:25%" /></td>
            </tr>
			<?php $explode	=	explode("-",date("Y-m-d",strtotime($data["tgl_lahir"]))); ?>
			<tr>
            	<td>Tempat, Tanggal Lahir</td>
                <td class="form"> <?=$data["tempat_lahir"]?>,<?=date2indo($data["tgl_lahir"])?></td>
				<td class="form_edit hide">
					<table cellpadding="10" cellspacing="10">
						<tr>
							<td width="257"><input type="text" name="tempat_lahir" class="form-control" value="<?=$data["tempat_lahir"]?>" /></td>
							<td>&nbsp;</td>
							<td width="50">
								<select name="tgl" class="form-control">
									<?php for($i=1; $i<32; $i++): ?>
									<option value="<?=$i?>" <?=($i==$explode[2])?"selected":""?>><?=$i?></option>
									<?php endfor; ?>
								</select>
							</td>
							<td>&nbsp;</td>
							<td width="100">
								<select name="bln" class="form-control">
									<?php foreach($this->list_month as $k=>$v): ?>
									<option value="<?=($k+1)?>" <?=(($k+1)==$explode[1])?"selected":""?>><?=$v?></option>
									<?php endforeach; ?>
								</select>
							</td>
							<td>&nbsp;</td>
							<td>
								<select name="thn" class="form-control">
									<?php foreach($lookup_tahun as $k=>$v): ?>
									<option value="<?=$k?>" <?=($k==$explode[0])?"selected":""?>><?=$v?></option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
					</table>
				</td>
            </tr>
			<tr>
            	<td>Umur</td>
                <td class="form"> <?=$data["umur"]*1?> Tahun</td>
				<td class="form_edit hide"><input type="text" name="umur" class="form-control" value="<?=$data["umur"]?>" style="width:25%" /></td>
            </tr>
            <tr>
            	<td>Tanda Pengenal Lainnya</td>
                <td> <?=$data["jenis_identitas"]?>, <?=$data["no_identitas"]?></td>
            </tr>
            <tr>
            	<td>Nama IBU</td>
                <td> <?=$data["ibu"]?></td>
            </tr>
            <tr>
            	<td>Nama Ayah</td>
                <td> <?=$data["ayah"]?></td>
            </tr>
            <tr>
            	<td>Jenis Kelamin</td>
                <td> <?=$this->data_lookup["jenis_kelamin"][$data["jenis_kelamin"]]?></td>
            </tr>
            <tr>
            	<td>Agama</td>
                <td> <?=$data["agama"]?></td>
            </tr>
            <tr>
            	<td>Suku</td>
                <td> <?=$data["suku"]?></td>
            </tr>
            <tr>
            	<td>Status Menikah</td>
                <td> <?=$lookup_status_nikah[$data["status_nikah"]]?></td>
            </tr>
            <tr>
            	<td>Pekerjaan</td>
				<td> <?=$this->data_lookup["kode_pekerjaan"][$data["pekerjaan"]]?></td>
            </tr>
            <tr>
            	<td>Alamat Rumah</td>
                <td> <?=$data["alamat"]?></td>
            </tr>
            <tr>
            	<td>Kode Pos</td>
                <td> <?=$data["kode_pos"]?></td>
            </tr>
            <tr>
            	<td>Golongan Darah</td>
                <td> <?=$data["golongan_darah"]?></td>
            </tr>
            <tr>
            	<td>No Telepon</td>
                <td> <?=$data["no_telp"]?></td>
            </tr>
            <tr>
            	<td>No HP</td>
                <td> <?=$data["no_hp"]?></td>
            </tr>
            <!--<tr>
            	<td>Dikirim Oleh</td>
                <td> <?=$data["rujukan"]?></td>
            </tr>-->
        </table>
		<? if(($data['inst_rujuk']) || ($data['rujuk_rehab'])):?>
		<h4 class="heading">Rehab</h4>
		<table class="table table-bordered table-condensed" style="width:100%">
			 <tr>
				<td width="200px"><?=$lookup_jns_org[$data['inst_rujuk']]?></td>
				<? if(($data['inst_rujuk']=='BNNP') || ($data['inst_rujuk']=='BNNK')){?>
					<td><?=$lookup_bnnp[$data['rujuk_rehab']]?></td>
				<? }else{?>
					<td><?=$lookup_inst[$data['rujuk_rehab']]?></td>
				<? }?>
				</tr>
		</table>
		<? endif;?>
		<? if(($data['inst_pasca']) || ($data['rujuk_pasca'])):?>
		<?
		//$rest = str_replace("-", "", substr($data['rujuk_lanjut'], 0, 5));	
		?>
		<h4 class="heading">Pasca</h4>
		<table class="table table-bordered table-condensed" style="width:100%">
			 <tr>
            	<td width="200px"><?=$lookup_jns_org[$data['inst_pasca']]?></td>
				<? if(($data['inst_pasca']=='BNNP') || ($data['inst_pasca']=='BNNK')){?>
					<td><?=$lookup_bnnp[$data['rujuk_pasca']]?></td>
				<? }else{?>
					<td><?=$lookup_inst[$data['rujuk_pasca']]?></td>
				<? }?>
				
			</tr>
		</table>
		<? endif;?>
		<? if(($data['inst_lanjut']) || ($data['rujuk_lanjut'])):?>
		<?
		//$rest = str_replace("-", "", substr($data['rujuk_lanjut'], 0, 5));	
		?>
		<h4 class="heading">Pasca / Lanjut</h4>
		<table class="table table-bordered table-condensed" style="width:100%">
			 <tr>
            	<td width="200px"><?=$lookup_jns_org[$data['inst_lanjut']]?></td>
				<? if(($data['inst_lanjut']=='BNNP') || ($data['inst_lanjut']=='BNNK')){?>
					<td><?=$lookup_bnnp[$data['rujuk_lanjut']]?></td>
				<? }else{?>
					<td><?=$lookup_inst[$data['rujuk_lanjut']]?></td>
				<? }?>
				
			</tr>
		</table>
		<? endif;?>
		
    </div>
</div>

<script>
$(document).ready(function(){
				
	$(".change_data_pasien").on("change",function(){

		var masalah_medis		=	$("#masalah_medis").val();
		var masalah_legal		=	$("#masalah_legal").val();
		var masalah_pekerjaan	=	$("#masalah_pekerjaan").val();
		var masalah_keluarga	=	$("#masalah_keluarga").val();
		var masalah_napza		=	$("#masalah_napza").val();
		var masalah_psikiatris	=	$("#masalah_psikiatris").val();
		var diagnosis_napza		=	$("#diagnosis_napza").val();
		var diagnosis_lain		=	$("#diagnosis_lain").val();
		var rencana_terapi_resume=	$("#rencana_terapi_resume").val();
		var rencana_terapi		=	$("#rencana_terapi").val();	
		var rencana_terapi_ket	=	$("#rencana_terapi_ket").val();		
						
		if($(this).prop("checked")){
							
			if(masalah_medis=='' || masalah_legal=='' || masalah_pekerjaan=='' || masalah_keluarga=='' || masalah_napza=='' || masalah_psikiatris=='' || diagnosis_napza=='' || diagnosis_lain=='' || rencana_terapi_resume=='' || rencana_terapi=='' || rencana_terapi_ket==''){					
				sweetAlert("Maaf!", "Mohon Isi Data Resume Assesment Terlebih Dahulu", "error");			
				$(this).prop("checked",false);
				$(".form").removeClass('hide');
				$(".form_edit").addClass('hide');			
			}else{		
				if($(this).prop("checked")){
					$(".form").addClass('hide');
					$(".form_edit").removeClass('hide');
				}else{
					$(".form").removeClass('hide');
					$(".form_edit").addClass('hide');
				}
			}
		}
	});
				
});
</script>

<!--
<script>
$(document).ready(function(){
	$(".change_data_pasien").on("click",function(){
	
		
		if($(this).prop("checked")){
			$(".form").addClass('hide');
			$(".form_edit").removeClass('hide');
		}else{
			$(".form").removeClass('hide');
			$(".form_edit").addClass('hide');
		}
		
	});
});
</script>
-->