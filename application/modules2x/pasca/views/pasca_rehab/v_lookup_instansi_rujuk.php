<?
	$lookup_instansi_rujuk=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in ('BNNP','BNNK','BL','RD','KM')","order by idx,order_num");
	// $lookup_proses_berikutnya=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
					
	if($status_proses=='PRRJPG'):
		$lookup_instansi_rujuk=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in ('BNNP','BNNK')","order by idx,order_num");
	endif;
	if($status_proses=='PRRIDA'):
		$lookup_instansi_rujuk=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in ('BL','RD','KM')","order by idx,order_num");
	endif;
	
?>

      <label for="nama">Jenis Instansi</label>
		<?=form_dropdown("inst_pasca",$lookup_instansi_rujuk,
		$data["inst_pasca"],
		"id='inst_pasca' class='form-control select2 required' style='width:100%'");?>
