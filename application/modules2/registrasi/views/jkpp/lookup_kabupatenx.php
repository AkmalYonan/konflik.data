<?
	$dataKabupaten[""]="--Pilih--";
	echo form_dropdown("kd_kabupaten",$dataKabupaten,"","id='id_kabupaten".($row+1)."' data-placeholder='--Pilih--' class='form-control inputx".($row+1)."'");
?>