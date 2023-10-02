<?php
	$lookup_empty=array(""=>"--pilih--");
	//$lookup_bnnp=lookup("m_org","kd_org","nama","tipe_org='BNNP' and active='1'","order by idx");
	//$lookup_bnnk=lookup("m_org","kd_org","nama","tipe_org='BNNK' and active='1'","order by idx");
	$//lookup_balai=lookup("m_instansi","id_kabupaten","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK')","order by idx");
	$lookup_status_nikah=$this->data_lookup["status_kawin"];
?>

<div class="row">
	<div class="col-md-8">
    	<table class="table table-condensed table-bordered">
        	<tr>
            	<td width="200px">
					<?php if($pasien['jns_org']==1): ?>
					BNNP 
					<?php elseif($pasien['jns_org']==2): ?>
					Balai/Loka
					<?php else: ?>
					BNNK
					<?php endif; ?>
				</td>
                <td>
					<? if($data['jns_org']==1): ?>
					<?=($this->lookup_bnnp[$pasien['kd_bnn']]);?>	
					<? else: ?>
						<?=($this->lookup_inst[$pasien['kd_bnn']]);?>
					<? endif; ?>
					
				</td>
            </tr>
            <tr>
            	<td width="200px">Nama</td>
                <td> <?=$pasien["nama"]?></td>
            </tr>
            <tr>
            	<td>NIK</td>
                <td> <?=$pasien["nik"]?></td>
            </tr>
			<tr>
            	<td>Tanda Pengenal Lainnya</td>
                <td> <?=$pasien["jenis_identitas"]?>, <?=$pasien["no_identitas"]?></td>
            </tr>
            <tr>
            	<td>Nama IBU</td>
                <td> <?=$pasien["ibu"]?></td>
            </tr>
            <tr>
            	<td>Nama Ayah</td>
                <td> <?=$pasien["ayah"]?></td>
            </tr>
            <tr>
            	<td>Tempat, Tanggal Lahir</td>
                <td> <?=$pasien["tempat_lahir"]?>,<?=date2indo($pasien["tgl_lahir"])?></td>
            </tr>
            <tr>
            	<td>Umur</td>
                <td> <?=$pasien["umur"]*1?></td>
            </tr>
            <tr>
            	<td>Jenis Kelamin</td>
                <td> <?=$this->data_lookup["jenis_kelamin"][$pasien["jenis_kelamin"]]?></td>
            </tr>
            <tr>
            	<td>Agama</td>
                <td> <?=$pasien["agama"]?></td>
            </tr>
            <tr>
            	<td>Suku</td>
                <td> <?=$pasien["suku"]?></td>
            </tr>
            <tr>
            	<td>Status Menikah</td>
                <td> <?=$lookup_status_nikah[$pasien["status_nikah"]]?></td>
            </tr>
            <tr>
            	<td>Pekerjaan</td>
                <td> <?=$this->data_lookup["kode_pekerjaan"][$data["pekerjaan"]]?></td>
            </tr>
            <tr>
            	<td>Alamat Rumah</td>
                <td> <?=$pasien["alamat"]?></td>
            </tr>
            <tr>
            	<td>Kode Pos</td>
                <td> <?=$pasien["kode_pos"]?></td>
            </tr>
            <tr>
            	<td>Golongan Darah</td>
                <td> <?=$pasien["golongan_darah"]?></td>
            </tr>
            <tr>
            	<td>No Telepon</td>
                <td> <?=$pasien["no_telp"]?></td>
            </tr>
            <tr>
            	<td>No HP</td>
                <td> <?=$pasien["no_hp"]?></td>
            </tr>
            <!--<tr>
            	<td>Dikirim Oleh</td>
                <td> <?=$pasien["rujukan"]?></td>
            </tr>-->
        </table>
    </div>
</div>