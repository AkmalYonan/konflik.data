<?php
	$lookup_empty=array(""=>"--pilih--");
	$lookup_bnnp=lookup("m_org","kd_org","nama","tipe_org='BNNP'","order by idx");
	$lookup_status_nikah=$this->data_lookup["status_kawin"];
	$lookup_balai=$lookup_empty+lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
?>
<div class="row">
	<div class="col-md-12">
    	<table class="table table-bordered table-condensed" style="width:100%">
        	<!--<tr>
            	<td width="200px">BNNP</td>
                <td> <?//=$lookup_bnnp[$data["kd_bnn"]]?></td>
            </tr>-->
            <tr>
            	<td width="200px">Nama</td>
                <td> <?=$data["nama"]?></td>
            </tr>
			<tr>
            	<td>NIK</td>
                <td> <?=$data["nik"]?></td>
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
            	<td>Tempat, Tanggal Lahir</td>
                <td> <?=$data["tempat_lahir"]?>,<?=date2indo($data["tgl_lahir"])?></td>
            </tr>
            <tr>
            	<td>Umur</td>
                <td> <?=$data["umur"]*1?> Tahun</td>
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
                <td> <?=$data["pekerjaan"]?></td>
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
		
		<!--
		<h4 class="heading">Rehab</h4>
		<table class="table table-bordered table-condensed" style="width:100%">
			 <tr>
				<td>Status Rawat</td>
            	<td >
				<?
				if($data['inst_rujuk']=='RIRMDT'){
					echo "Rawat Inap";
				}elseif(($data['inst_rujuk']=='RJKL') || ($data['inst_rujuk']=='KM')){
					echo "Rawat Jalan";
				}
				?></td>
			</tr>
			
			<? if(strlen($data['rujuk_rehab'])==2):?>
			<tr>
            	<td width="200px">BNNP / BNNK</td>
                <td><?=($data['rujuk_rehab'])? $lookup_bnnp[$data['rujuk_rehab']]:"--";?></td>
            </tr>
			<? elseif(((strlen($data['rujuk_rehab']))==4) && ($data['inst_rujuk']!='KM')):?>
			<tr>
            	<td width="200px">Balai / Loka</td>
                <td><?=($data['rujuk_rehab'])? $lookup_balai[$data['rujuk_rehab']]:"--";?></td>
            </tr>
			<? elseif(($data['inst_rujuk']=='KM')):?>
			<tr>
            	<td colspan='2'>Komponen Masyarakat</td>
            </tr>
			<? endif;?>
		</table>
			
		
		<h4 class="heading">Pasca</h4>
		<table class="table table-bordered table-condensed" style="width:100%">
			 <tr>
            	<td>Status Rawat</td>
				<td>
				<?
				if($data['inst_pasca']=='PRRIDA'){
					echo "Rawat Inap";
				}elseif(($data['rujuk_pasca']=='PRRJPG')  || ($data['inst_rujuk']=='KM')){
					echo "Rawat Jalan";
				}else{
					echo "--";
				}
				?>
				</td>
			</tr>
			<? if(((strlen($data['rujuk_pasca']))==2)  && ($data['inst_rujuk']!='KM')):?>
			<tr>
            	<td width="200px">BNNP / BNNK</td>
                <td><?=$lookup_bnnp[$data['rujuk_rehab']]?></td>
            </tr>
			<? elseif(((strlen($data['rujuk_pasca']))==4) && ($data['inst_rujuk']!='KM')):?>
			<tr>
            	<td width="200px" colspan=2>Rumah Damping</td>
            </tr>
			<? elseif(($data['inst_rujuk']=='KM')):?>
			<tr>
            	<td colspan='2'>Komponen Masyarakat</td>
            </tr>
			<? endif;?>
		</table>
		-->
		
		
    </div>
</div>