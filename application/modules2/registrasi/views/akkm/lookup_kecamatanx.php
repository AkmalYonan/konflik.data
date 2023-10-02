<?
	$dataArr[""]="--Pilih--";
	echo form_dropdown("kd_kecamatan",$dataArr,"","id='id_kecamatan".($row+1)."' data-placeholder='--Pilih--' class='form-control inputx".($row+1)."'");
?>