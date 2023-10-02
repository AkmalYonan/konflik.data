<?
	$lookup_instansi_rujuk=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in ('BNNP','BNNK','BL','RD','KM')","order by idx,order_num");
	
	if($status_proses=='RJKL'):
		$lookup_instansi_rujuk=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in ('BNNP','BNNK')","order by idx,order_num");
	endif;
	if($status_proses=='RIRMDT'):
		$lookup_instansi_rujuk=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in ('BL','RD','KM')","order by idx,order_num");
	endif;
	
?>

      <label for="nama">Jenis Instansi</label>
		<?=form_dropdown("inst_rujuk",$lookup_instansi_rujuk,
		$data["inst_rujuk"],
		"id='inst_rujuk' class='form-control select2 required' style='width:100%'");?>
