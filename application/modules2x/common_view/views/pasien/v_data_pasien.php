<?php
	$lookup_empty=array(""=>"--pilih--");
	$lookup_bnnp=lookup("m_org","kd_org","nama",false,"order by idx");
	$lookup_status_nikah=$this->data_lookup["status_kawin"];
	$lookup_balai=$lookup_empty+lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
	$lookup_jns_org=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org",false,"order by idx");
	$lookup_inst=lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
?>
<?
	//$inst_rujuk = ($rehab_stat['inst_rujuk'])? $rehab_stat['inst_rujuk']:$data['inst_rujuk'];
	//$rujuk_rehab = ($rehab_stat['rujuk_rehab'])? $rehab_stat['rujuk_rehab']:$data['rujuk_rehab'];

	//$inst_pasca = ($pasca_stat['inst_pasca'])? $pasca_stat['inst_pasca']:$data['inst_pasca'];
	//$rujuk_pasca = ($pasca_stat['rujuk_pasca'])? $pasca_stat['rujuk_pasca']:$data['rujuk_pasca'];

	$inst_rujuk = $rehab_stat['inst_rujuk'];
	$rujuk_rehab = $rehab_stat['rujuk_rehab'];

	$inst_pasca = $pasca_stat['inst_pasca'];
	$rujuk_pasca = $pasca_stat['rujuk_pasca'];

	$inst_lanjut = $lanjut_stat['inst_lanjut'];
	$rujuk_lanjut = $lanjut_stat['rujuk_lanjut'];

?>

<style>
.data-toggle{
	position:absolute;
	top:-53px;
	right:5px;
	padding:5px;
	border:1px solid #ccc;
}
</style>
<div style="position:relative">
    <div class="data-toggle btn btn-default btn-xs">
        <i class="fa fa-arrow-down"></i> &nbsp; <span class="text-muted">Data Lengkap </span>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
    	<table class="table table-bordered table-condensed" style="width:100%">
        	<!--<tr>
            	<td width="200px">BNNP</td>
                <td> <?//=$lookup_bnnp[$data["kd_bnn"]]?></td>
            </tr>-->
            <tr>
            	<th width="200px">Nama</th>
                <th> <?=$data["nama"]?></th>
            </tr>
            <tr>
            	<th>No. Rekam Medis</th>
                <th> <?=$data["no_rekam_medis"]?></th>
            </tr>
			<tr>
            	<th>Tgl Registrasi</th>
                <th><?=date("d/m/Y",strtotime($data["tgl_registrasi"]))?></th>
            </tr>

            <tr>
            	<td width="200px">Tanda Pengenal</td>
                <td>KTP, <?=$data["nik"]?></td>
            </tr>

            <tr class="data-sekunder">
            	<td>Tempat, Tanggal Lahir</td>
                <td> <?=$data["tempat_lahir"]?>, <?=date2indo($data["tgl_lahir"])?></td>
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
            	<td>Golongan Darah</td>
                <td> <?=$data["golongan_darah"]?></td>
            </tr>

            <tr>
            	<td>Alamat Rumah</td>
                <td> <?=$data["alamat"]?></td>
            </tr>
            <tr class="data-sekunder">
            	<td>Kode Pos</td>
                <td> <?=$data["kode_pos"]?></td>
            </tr>

            <tr>
            	<td>No Telepon</td>
                <td> <?=$data["no_telp"]?></td>
            </tr>
            <tr>
            	<td>No HP</td>
                <td> <?=$data["no_hp"]?></td>
            </tr>

            <tr class="data-sekunder">
            	<td>Agama</td>
                <td> <?=$data["agama"]?></td>
            </tr>
            <tr class="data-sekunder">
            	<td>Suku</td>
                <td> <?=$data["suku"]?></td>
            </tr>
            <tr class="data-sekunder">
            	<td>Status Menikah</td>
                <td> <?=$lookup_status_nikah[$data["status_nikah"]]?></td>
            </tr>
            <tr class="data-sekunder">
            	<td>Pekerjaan</td>
                <td> <?=$this->data_lookup["kode_pekerjaan"][$data["pekerjaan"]]?></td>
            </tr>



            <tr class="data-sekunder">
            	<td>Nama Ibu</td>
                <td> <?=$data["ibu"]?></td>
            </tr>
            <tr class="data-sekunder">
            	<td>Nama Ayah</td>
                <td> <?=$data["ayah"]?></td>
            </tr>
            <!--<tr>
            	<td>Dikirim Oleh</td>
                <td> <?=$data["rujukan"]?></td>
            </tr>-->

        </table>
				<h4 class="heading">File Pendukung</h4>
				<?=$this->load->view("common_view/pasien/v_view_pemeriksaan_dokumen");?>
				
		<? if(($inst_rujuk) || ($rujuk_rehab)):?>
		<h4 class="heading">Rehab</h4>
		<table class="table table-bordered table-condensed" style="width:100%">
			 <tr>
				<td width="200px"><?=$lookup_jns_org[$inst_rujuk]?></td>
				<? if(($inst_rujuk=='BNNP') || ($inst_rujuk=='BNNK')){?>
					<td><?=$lookup_bnnp[$rujuk_rehab]?></td>
				<? }else{?>
					<td><?=$lookup_inst[$rujuk_rehab]?></td>
				<? }?>
				</tr>
		</table>
		<? endif;?>
		<? if(($inst_pasca) || ($rujuk_pasca)):?>
		<?
		//$rest = str_replace("-", "", substr($data['rujuk_lanjut'], 0, 5));
		?>
		<h4 class="heading">Pasca</h4>
		<table class="table table-bordered table-condensed" style="width:100%">
			 <tr>
            	<td width="200px"><?=$lookup_jns_org[$inst_pasca]?></td>
				<? if(($inst_pasca=='BNNP') || ($inst_pasca=='BNNK')){?>
					<td><?=$lookup_bnnp[$rujuk_pasca]?></td>
				<? }else{?>
					<td><?=$lookup_inst[$rujuk_pasca]?></td>
				<? }?>

			</tr>
		</table>
		<? endif;?>
		<? if(($inst_lanjut) || ($rujuk_lanjut)):?>
		<h4 class="heading">Pasca / Lanjut</h4>
		<table class="table table-bordered table-condensed" style="width:100%">
			 <tr>
            	<td width="200px"><?=$lookup_jns_org[$inst_lanjut]?></td>
				<? if(($inst_lanjut=='BNNP') || ($inst_lanjut=='BNNK')){?>
					<td><?=$lookup_bnnp[$rujuk_lanjut]?></td>
				<? }else{?>
					<td><?=$lookup_inst[$rujuk_lanjut]?></td>
				<? }?>

			</tr>
		</table>
		<? endif;?>

    </div>
</div>

<script>
	$(function() {
		$(".data-sekunder").addClass("hide");
		$(".data-toggle").click(function(){
			if ($(".data-sekunder").hasClass("hide")) {
				$(".data-sekunder").removeClass("hide");
				$(".data-toggle").find("i").removeClass("fa-arrow-down").addClass("fa-arrow-up");
				$(".data-toggle").find("span").html("Data Ringkas");
			}
			else {
				$(".data-sekunder").addClass("hide");
				$(".data-toggle").find("i").addClass("fa-arrow-down").removeClass("fa-arrow-up");
				$(".data-toggle").find("span").html("Data Lengkap");
			}
		});
	});
</script>
