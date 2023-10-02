<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('pasien_data_all'))
{
	function pasien_data_all($id_pasien,$data=array())
	{
		$CI=& get_instance();
		
		$data["pasien"]=$CI->adodbx->GetRecord("t_pasien","idx=$id_pasien");
		$pasien_foto=pasien_foto($id_pasien);
		$data["pasien_foto_img"]=$pasien_foto["path"].$pasien_foto["file_name"];
		$data["pasien_foto"]=$pasien_foto;
		$data["pasien_foto_all"]=pasien_foto_all($id_pasien);
		$data["pasien_assesment_summary"]=$CI->adodbx->GetRecord("t_pasien","idx_pasien=$id_pasien");
		$data["pasien_detox"]=pasien_detox($id_pasien);
		$data["pasien_entry_unit"]=pasien_entry_unit($id_pasien);
		$data["pasien_primary_treatment"]=pasien_primary_treatment($id_pasien);
		$data["pasien_re_entry"]=pasien_re_entry($id_pasien);
		return $data;
	}
	
	
}


if ( ! function_exists('pasien_data'))
{
	function pasien_data($id_pasien,$ret=array())
	{
		$CI =& get_instance();
		$ret=$CI->adodbx->GetRecord("t_pasien","idx=$id_pasien");
		return $ret;
	}
}

if ( ! function_exists('pasien_foto_all'))
{
	function pasien_foto_all($id_pasien,$ret=array())
	{
		$CI =& get_instance();
		$ret=$CI->adodbx->search_record_where("t_pasien_foto",""," order by idx desc");
		return $ret;
	}
}

if ( ! function_exists('pasien_foto'))
{
	function pasien_foto($id_pasien,$ret=array())
	{
		$CI =& get_instance();
		$ret=$CI->adodbx->GetRecord("t_pasien_foto","idx_parent={$id_pasien} and flag_default=1");
		return $ret;
	}
}

if ( ! function_exists('pasien_detox'))
{
	function pasien_detox($id_pasien,$ret=array())
	{
		$CI =& get_instance();
		$ret=$CI->adodbx->GetRecord("t_pasien_detox","idx_pasien={$id_pasien}");
		return $ret;
	}
}

if ( ! function_exists('pasien_entry_unit'))
{
	function pasien_entry_unit($id_pasien,$ret=array())
	{
		$CI =& get_instance();
		$ret=$CI->adodbx->GetRecord("t_pasien_entry_unit","idx_pasien={$id_pasien}");
		return $ret;
	}
}



if ( ! function_exists('pasien_primary_treatment'))
{
	function pasien_primary_treatment($id_pasien,$ret=array())
	{
		$CI =& get_instance();
		$ret=$CI->adodbx->GetRecord("t_pasien_primary_treatment","idx_pasien={$id_pasien}");
		return $ret;
	}
}

if ( ! function_exists('pasien_re_entry'))
{
	function pasien_re_entry($id_pasien,$ret=array())
	{
		$CI =& get_instance();
		$ret=$CI->adodbx->GetRecord("t_pasien_re_entry","idx_pasien={$id_pasien}");
		return $ret;
	}
}


function lookup_status_rehab_label($status_rehab=""){
	$lookup_status_rehab[1]="<span class='label label-warning'>Registrasi</label>";
	$lookup_status_rehab[2]="<span class='label label-info'>Rehab</label>";
	$lookup_status_rehab[3]="<span class='label label-primary'>Pasca Rehab</label>";
	if($status_rehab==""):
		return $lookup_status_rehab;
	else:
		return $lookup_status_rehab[$status_rehab];
	endif;	
}

function lookup_status_rehab($status_rehab=""){
	$lookup_status_rehab[1]="Registrasi";
	$lookup_status_rehab[2]="Rehabilitasi";
	$lookup_status_rehab[3]="Pasca Rehabilitasi";
	if($status_rehab==""):
		return $lookup_status_rehab;
	else:
		return $lookup_status_rehab[$status_rehab];
	endif;
	
}


function lookup_status_proses_label($status_proses=""){
	$CI =& get_instance();
	$arrDataProses=$CI->conn->GetAll("select * from m_proses_rehab");
	if(cek_array($arrDataProses)):
		foreach($arrDataProses as $x=>$val):
			$label="";
			if($val["kd_status_rehab"]==1):
				$label="<span class='label label-warning'>".$val["ur_proses"]."</span>";
			endif;
			if($val["kd_status_rehab"]==2):
				$label="<span class='label label-info'>".$val["ur_proses"]."</span>";
			endif;
			if($val["kd_status_rehab"]==3):
				$label="<span class='label label-primary'>".$val["ur_proses"]."</span>";
			endif;
			$lookup_status_proses[$val["kd_status_proses"]]=$label;
		endforeach;
	endif;
	if($status_proses==""):
		return $lookup_status_proses;
	else:
		return $lookup_status_proses[$status_proses];
	endif;
}

/*
	
	`idx` int(11) NOT NULL AUTO_INCREMENT,
  `idx_pasien` int(11) DEFAULT NULL,
  `idx_assesment` int(11) DEFAULT NULL,
  `no_rekam_medis` varchar(100) DEFAULT NULL,
  `tgl_kegiatan` date DEFAULT NULL,
  `status_rehab` int(1) DEFAULT NULL COMMENT '1 reg 2 rehab 3 pasca',
  `status_proses` varchar(10) DEFAULT NULL COMMENT 'lihat m_proses_rehab',
  `status_rawat` varchar(5) DEFAULT NULL COMMENT 'INAP JALAN LANJUT',
  `status_pasien` varchar(2) DEFAULT NULL COMMENT 'PS proses DO dropout KB Kambuh SL selesai',
  `inst_rujuk` varchar(10) DEFAULT NULL,
  `rujuk_rehab` varchar(10) DEFAULT NULL,
  
   
*/
function update_pasien_history($dataPasien,$dataStatus){
	$CI =& get_instance();
	  
	  $dataUpdate["idx_pasien"]=$dataPasien["idx_pasien"];
	  $dataUpdate["idx_assesment"]=$dataPasien["idx_assesment"];
	  $dataUpdate["no_rekam_medis"]=$dataPasien["no_rekam_medis"];
	  $dataUpdate["tgl_kegiatan"]=$dataStatus["tgl_kegiatan"];
	  $dataUpdate["status_rehab"]=$dataStatus["status_rehab"];
	  $dataUpdate["status_proses"]=$dataStatus["status_proses"];
	  $dataUpdate["status_rawat"]=$dataStatus["status_rawat"];
	  $dataUpdate["status_pasien"]=$dataStatus["status_pasien"];
	  $dataUpdate["inst_rujuk"]=$dataStatus["inst_rujuk"];
	  $dataUpdate["rujuk_rehab"]=$dataStatus["rujuk_rehab"]; 
	  
	$data=$CI->_add_creator($dataUpdate);
	$CI->conn->StartTrans();
	$CI->conn->AutoExecute("t_pasien_history",$dataUpdate,"INSERT");
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}


/* 
	Misal:
	$dataMonitoring["tgl_dt"]=$tanggal;
	$dataMonitoring["dt"]=$status;
*/
function update_pasien_monitoring($dataPasien,$dataStatus,$dataMonitoring){
	$CI =& get_instance();
	  //$dataUpdate["tgl_kegiatan"]=$dataStatus["tgl_kegiatan"];
	  $dataUpdate["status_rehab"]=$dataStatus["status_rehab"];
	  $dataUpdate["status_proses"]=$dataStatus["status_proses"];
	  $dataUpdate["status_rawat"]=$dataStatus["status_rawat"];
	  $dataUpdate["status_pasien"]=$dataStatus["status_pasien"];
	  //$dataUpdate["inst_rujuk"]=$dataStatus["inst_rujuk"];
	  //$dataUpdate["rujuk_rehab"]=$dataStatus["rujuk_rehab"]; 
	  $dataUpdate=$dataUpdate+$dataMonitoring;
	  
	  $idx_pasien=$dataPasien["idx_pasien"];
	  $idx_assesment=$dataPasien["idx_assesment"];
	  
	$CI->conn->StartTrans();
	$arrData=$CI->adodbx->GetRecord("t_pasien_monitoring_rehab","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	if(cek_array($arrData)):
		$dataUpdate=$CI->_add_editor($dataUpdate);
		$CI->conn->AutoExecute("t_pasien_monitoring_rehab",$dataUpdate,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	else:
		$dataUpdate["idx_pasien"]=$dataPasien["idx_pasien"];
	  	$dataUpdate["idx_assesment"]=$dataPasien["idx_assesment"];
	  	$dataUpdate["no_rekam_medis"]=$dataPasien["no_rekam_medis"];
		$dataUpdate=$CI->_add_creator($dataUpdate);
		 
		$CI->conn->AutoExecute("t_pasien_monitoring_rehab",$dataUpdate,"INSERT");
	endif;
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}


//test helper bnn
if ( ! function_exists('test_helper'))
{
	function test_helper_bnn()
	{
		$CI =& get_instance();
		print "kacang";
	}
}