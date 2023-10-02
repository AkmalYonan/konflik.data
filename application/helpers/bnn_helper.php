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
		$data["pasien_assesment_summary"]=$CI->adodbx->GetRecord("t_pasien","idx=$id_pasien");
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

if ( ! function_exists('pasien_assesment_history_data'))
{
	function pasien_assesment_history_data($id_pasien,$idx_assesment=false,$ret=array())
	{
		$CI =& get_instance();
		if(!$idx_assesment):
			$ret=$CI->conn->GetRow("select * from t_pasien_assesment_history where idx_pasien=$id_pasien order by idx desc");
		else:
			$ret=$CI->conn->GetRow("select * from t_pasien_assesment_history where idx_pasien=$id_pasien and idx_assesment=$idx_assesment order by idx desc");
		
		endif;
		
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


if ( ! function_exists('pasien_all_history'))
{
	function pasien_all_history($idx_pasien,$idx_assesment="",$ret=array())
	{
		
		$CI =& get_instance();
		$where[]="idx_pasien=$idx_pasien";
		if($idx_assesment!=""):
			$where[]="idx_assesment=$idx_assesment";
		endif;
		$whereSql="";
		if(cek_array($where)):
			$whereSql=join(" and ",$where);
		endif;
		$ret=$CI->adodbx->search_record_where("t_pasien_all_history",$whereSql," order by idx");
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
	  $dataUpdate["tgl_selesai"]=$dataStatus["tgl_selesai"];
	  $dataUpdate["status_rehab"]=$dataStatus["status_rehab"];
	  $dataUpdate["status_proses"]=$dataStatus["status_proses"];
	  $dataUpdate["status_rawat"]=$dataStatus["status_rawat"];
	  $dataUpdate["status_pasien"]=$dataStatus["status_pasien"];
	  $dataUpdate["inst_rujuk"]=$dataStatus["inst_rujuk"];
	  $dataUpdate["rujuk_rehab"]=$dataStatus["rujuk_rehab"]; 
	  
	$dataUpdate=$CI->_add_creator($dataUpdate);
	$CI->conn->StartTrans();
	$CI->conn->AutoExecute("t_pasien_history",$dataUpdate,"INSERT");
	update_pasien_all_history($dataPasien,$dataStatus);
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}

function update_pasien_history_pasca($dataPasien,$dataStatus){
	$CI =& get_instance();
	  
	  $dataUpdate["idx_pasien"]=$dataPasien["idx_pasien"];
	  $dataUpdate["idx_assesment"]=$dataPasien["idx_assesment"];
	  $dataUpdate["no_rekam_medis"]=$dataPasien["no_rekam_medis"];
	  $dataUpdate["tgl_kegiatan"]=$dataStatus["tgl_kegiatan"];
	  $dataUpdate["tgl_selesai"]=$dataStatus["tgl_selesai"];
	  $dataUpdate["status_rehab"]=$dataStatus["status_rehab"];
	  $dataUpdate["status_proses"]=$dataStatus["status_proses"];
	  $dataUpdate["status_rawat"]=$dataStatus["status_rawat"];
	  $dataUpdate["status_pasien"]=$dataStatus["status_pasien"];
	  $dataUpdate["inst_pasca"]=$dataStatus["inst_pasca"];
	  $dataUpdate["rujuk_pasca"]=$dataStatus["rujuk_pasca"]; 
	  
	$dataUpdate=$CI->_add_creator($dataUpdate);
	$CI->conn->StartTrans();
	$CI->conn->AutoExecute("t_pasien_history_pasca",$dataUpdate,"INSERT");
	update_pasien_all_history($dataPasien,$dataStatus);
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}

function update_pasien_history_lanjut($dataPasien,$dataStatus){
	$CI =& get_instance();
	  
	  $dataUpdate["idx_pasien"]=$dataPasien["idx_pasien"];
	  $dataUpdate["idx_assesment"]=$dataPasien["idx_assesment"];
	  $dataUpdate["no_rekam_medis"]=$dataPasien["no_rekam_medis"];
	  $dataUpdate["tgl_kegiatan"]=$dataStatus["tgl_kegiatan"];
	  $dataUpdate["tgl_selesai"]=$dataStatus["tgl_selesai"];
	  $dataUpdate["status_rehab"]=$dataStatus["status_rehab"];
	  $dataUpdate["status_proses"]=$dataStatus["status_proses"];
	  $dataUpdate["status_rawat"]=$dataStatus["status_rawat"];
	  $dataUpdate["status_pasien"]=$dataStatus["status_pasien"];
	  $dataUpdate["inst_lanjut"]=$dataStatus["inst_lanjut"];
	  $dataUpdate["rujuk_lanjut"]=$dataStatus["rujuk_lanjut"]; 
	  
	$dataUpdate=$CI->_add_creator($dataUpdate);
	$CI->conn->StartTrans();
	$CI->conn->AutoExecute("t_pasien_history_lanjut",$dataUpdate,"INSERT");
	update_pasien_all_history($dataPasien,$dataStatus);
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}



function update_pasien_all_history($dataPasien,$dataStatus){
	$CI =& get_instance();
	  
	  $idx_pasien=$dataPasien["idx_pasien"];
	  $idx_assesment=$dataPasien["idx_assesment"];
	  $status_rehab=$dataStatus["status_rehab"];
	  $status_proses=$dataStatus["status_proses"];
	  
	  $pasien=pasien_data($idx_pasien);
	  //pre($pasien);
	  $dataUpdate["nik"]=$pasien["nik"];
	  $dataUpdate["idx_pasien"]=$dataPasien["idx_pasien"];
	  $dataUpdate["idx_assesment"]=$dataPasien["idx_assesment"];
	  $dataUpdate["no_rekam_medis"]=$dataPasien["no_rekam_medis"];
	  
	  $dataUpdate["tgl_kegiatan"]=$dataStatus["tgl_kegiatan"];
	  $dataUpdate["tgl_selesai"]=$dataStatus["tgl_selesai"];
	  $tgl_status_proses=$dataStatus["tgl_kegiatan"];
	  if($dataStatus["tgl_selesai"]):
	  	$tgl_status_proses=$dataStatus["tgl_selesai"];
	  endif;
	  $dataUpdate["tgl_status_proses"]=$tgl_status_proses;
	  $dataUpdate["status_rehab"]=$dataStatus["status_rehab"];
	  $dataUpdate["status_proses"]=$dataStatus["status_proses"];
	  $dataUpdate["status_rawat"]=get_status_rawat($status_proses);
	  
	  
	  
	  //$dataUpdate["status_program"]=$dataStatus["status_pasien"];
	  /*
	  $dataUpdate["created"]=$dataStatus["created"];
	  $dataUpdate["creator"]=$dataStatus["creator"];
	  $dataUpdate["edited"]=$dataStatus["edited"];
	  $dataUpdate["editor"]=$dataStatus["editor"];
	  */
	  
	  
	  $dataUpdate["tahun"]=date("Y",strtotime($dataUpdate["tgl_status_proses"]));
	  $dataUpdate["bulan"]=date("m",strtotime($dataUpdate["tgl_status_proses"]));
	  
	  $dataSummary=$CI->conn->GetRow("select * from t_pasien_assesment_history where idx_pasien=$idx_pasien order by idx desc");
	  $idx_assesment=$dataSummary["idx_assesment"];
	  $dataUpdate["idx_assesment"]=$idx_assesment;
	  
	  //debug();
	  /*
	  if($dataStatus["inst_rujuk"]):
	  	$dataUpdate["inst_rujuk"]=$dataStatus["inst_rujuk"];
	  endif;
	  if($dataStatus["rujuk_rehab"]):
	  	$dataUpdate["rujuk_rehab"]=$dataStatus["rujuk_rehab"];
	  endif;
	  
	  if($dataStatus["inst_pasca"]):
	  	$dataUpdate["inst_rujuk"]=$dataStatus["inst_pasca"];
	  endif;
	  
	  if($dataStatus["rujuk_pasca"]):
	  	$dataUpdate["rujuk_rehab"]=$dataStatus["rujuk_pasca"];
	  endif;
	  
	  if($dataStatus["inst_lanjut"]):
	  	$dataUpdate["inst_rujuk"]=$dataStatus["inst_lanjut"];
	  endif;
	  if($dataStatus["rujuk_lanjut"]):
	  	$dataUpdate["rujuk_rehab"]=$dataStatus["rujuk_lanjut"];
	  endif; 
	  */
	  $dataUpdate["outcome_pasien"]=$pasien["outcome_pasien"];
	  $dataUpdate["status_program"]=$pasien["status_program"];
	  $dataUpdate["kd_bnn"]=$pasien["kd_bnn"];
	  $dataUpdate["periode_bulan"]=$pasien["periode_bulan"];
	  $dataUpdate["periode_tahun"]=$pasien["periode_tahun"];
	  $dataUpdate["sumber_pasien"]=$pasien["sumber_pasien"];
	  $dataUpdate["sumber_biaya"]=$pasien["sumber_biaya"];
	  $dataUpdate["kd_wilayah"]=$pasien["kd_wilayah"];
	  $dataUpdate["kd_wilayah_propinsi"]=$pasien["kd_wilayah_propinsi"];
	  $dataUpdate["kd_balai"]=$pasien["kd_balai"];
	  $dataUpdate["status_rm"]=$pasien["status_rm"];
	  
	  if($pasien["inst_rujuk"]):
	  	$dataUpdate["inst_rujuk"]=$pasien["inst_rujuk"];
	  endif;
	  if($pasien["rujuk_rehab"]):
	  	$dataUpdate["rujuk_rehab"]=$pasien["rujuk_rehab"];
	  endif;
	  
	  if($pasien["inst_pasca"]):
	  	$dataUpdate["inst_rujuk"]=$pasien["inst_pasca"];
	  endif;
	  
	  if($pasien["rujuk_pasca"]):
	  	$dataUpdate["rujuk_rehab"]=$pasien["rujuk_pasca"];
	  endif;
	  
	  if($pasien["inst_lanjut"]):
	  	$dataUpdate["inst_rujuk"]=$pasien["inst_lanjut"];
	  endif;
	  if($pasien["rujuk_lanjut"]):
	  	$dataUpdate["rujuk_rehab"]=$pasien["rujuk_lanjut"];
	  endif; 
	  
	  
	$dataUpdate=$CI->_add_creator($dataUpdate);
	//pre($dataUpdate);
	$CI->conn->StartTrans();
	/* update all flag default to 0 */
	//debug();
	$dataUpdateFlag["flag_default"]=0;
	$CI->conn->AutoExecute("t_pasien_all_history",$dataUpdateFlag,"UPDATE","idx_pasien=$idx_pasien and idx_assesment=$idx_assesment");
	
	//delete current same proses 
	$CI->conn->Execute("delete from t_pasien_all_history where idx_pasien=$idx_pasien and idx_assesment=$idx_assesment and status_rehab=$status_rehab and status_proses='{$status_proses}'");
	
	$CI->conn->AutoExecute("t_pasien_all_history",$dataUpdate,"INSERT");
	
	update_pasien_all_history2($idx_pasien,$idx_assesment,$tgl_status_proses);
	
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}


function update_pasien_all_history2($idx_pasien,$idx_assesment=NULL,$tgl_status_proses=false){
	$CI =& get_instance();
	  //$idx_pasien=$dataPasien["idx_pasien"];
	  //$idx_assesment=$dataPasien["idx_assesment"];
	  $pasien=pasien_data($idx_pasien);
	  
	  $status_rehab=$pasien["status_rehab"];
	  $status_proses=$pasien["status_proses"];
	  //pre($pasien);
	  $pasien["idx_assesment"]=$idx_assesment;
	  
	  $dataUpdate["nik"]=$pasien["nik"];
	  $dataUpdate["idx_pasien"]=$idx_pasien;
	  $dataUpdate["idx_assesment"]=$idx_assesment;
	  $dataUpdate["no_rekam_medis"]=$pasien["no_rekam_medis"];
	  
	  if(!$tgl_status_proses):
	  		$dataUpdate["tgl_status_proses"]=date("Y-m-d",strtotime($pasien["edited"]));
	  else:
	  		$dataUpdate["tgl_status_proses"]=$tgl_status_proses;
	  endif;
	  $dataUpdate["status_rehab"]=$status_rehab;
	  $dataUpdate["status_proses"]=$status_proses;
	  $dataUpdate["outcome_pasien"]=$pasien["outcome_pasien"];
	  $dataUpdate["status_program"]=$pasien["status_program"];
	  $dataUpdate["status_rawat"]=get_status_rawat($status_proses);
	  $dataUpdate["kd_bnn"]=$pasien["kd_bnn"];
	  $dataUpdate["periode_bulan"]=$pasien["periode_bulan"];
	  $dataUpdate["periode_tahun"]=$pasien["periode_tahun"];
	  $dataUpdate["sumber_pasien"]=$pasien["sumber_pasien"];
	  $dataUpdate["sumber_biaya"]=$pasien["sumber_biaya"];
	  $dataUpdate["kd_wilayah"]=$pasien["kd_wilayah"];
	  
	  $dataUpdate["kd_wilayah_propinsi"]=$pasien["kd_wilayah_propinsi"];
	  $dataUpdate["kd_balai"]=$pasien["kd_balai"];
	  $dataUpdate["status_rm"]=$pasien["status_rm"];
	  //$dataUpdate["status_program"]=$dataStatus["status_pasien"];
	  /*
	  $dataUpdate["created"]=$dataStatus["created"];
	  $dataUpdate["creator"]=$dataStatus["creator"];
	  $dataUpdate["edited"]=$dataStatus["edited"];
	  $dataUpdate["editor"]=$dataStatus["editor"];
	  */
	  
	  $dataUpdate["tahun"]=date("Y",strtotime($dataUpdate["tgl_status_proses"]));
	  $dataUpdate["bulan"]=date("m",strtotime($dataUpdate["tgl_status_proses"]));
	  
	  //debug();
	  if($pasien["inst_rujuk"]):
	  	$dataUpdate["inst_rujuk"]=$pasien["inst_rujuk"];
	  endif;
	  if($pasien["rujuk_rehab"]):
	  	$dataUpdate["rujuk_rehab"]=$pasien["rujuk_rehab"];
	  endif;
	  
	  if($pasien["inst_pasca"]):
	  	$dataUpdate["inst_rujuk"]=$pasien["inst_pasca"];
	  endif;
	  
	  if($pasien["rujuk_pasca"]):
	  	$dataUpdate["rujuk_rehab"]=$pasien["rujuk_pasca"];
	  endif;
	  
	  if($pasien["inst_lanjut"]):
	  	$dataUpdate["inst_rujuk"]=$pasien["inst_lanjut"];
	  endif;
	  if($pasien["rujuk_lanjut"]):
	  	$dataUpdate["rujuk_rehab"]=$pasien["rujuk_lanjut"];
	  endif; 
	  
	$dataUpdate=$CI->_add_creator($dataUpdate);
	//pre($dataUpdate);
	$CI->conn->StartTrans();
	/* update all flag default to 0 */
	//debug();
	$dataUpdateFlag["flag_default"]=0;
	$CI->conn->AutoExecute("t_pasien_all_history2",$dataUpdateFlag,"UPDATE","idx_pasien=$idx_pasien and idx_assesment=$idx_assesment");
	
	//delete current same proses 
	$CI->conn->Execute("delete from t_pasien_all_history2 where idx_pasien=$idx_pasien and idx_assesment=$idx_assesment and status_rehab=$status_rehab and status_proses='{$status_proses}'");
	
	$CI->conn->AutoExecute("t_pasien_all_history2",$dataUpdate,"INSERT");
	
	$data_update["tgl_status_proses"]=$tgl_status_proses;
	$CI->conn->AutoExecute("t_pasien_assesment_history",$data_update,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	
	if($status_rehab<=2):
	$CI->conn->AutoExecute("t_pasien_monitoring_rehab",$data_update,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	endif;
	if($status_rehab==3):
		$CI->conn->AutoExecute("t_pasien_monitoring_pasca",$data_update,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	endif;
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}


function update_pasien_all_history_registrasi($idx_pasien,$idx_assesment=false){
	
	$CI =& get_instance();
	pre($idx_pasien);
	pre($idx_assesment);
	debug();
	$summary=pasien_assesment_history_data($idx_pasien,$idx_assesment);
	unset($summary["idx"]);
	pre($summary);
	/*
	debug();
	$idx_assesment=$summary["idx_assesment"];
	echo "test1";
	$idx_pasien=$summary["idx_pasien"];
	echo "test2";
	$data1=$CI->adodbx>GetRecord("t_pasien_all_history","idx_pasien=$idx_pasien and 
		idx_assesment=$idx_assesment and status_rehab=1 and status_proses='RG'");
	pre($data1);
	$data2=$CI->adodbx>GetRecord("t_pasien_all_history","idx_pasien=$idx_pasien and 
		idx_assesment=$idx_assesment and status_rehab=1 and status_proses='SS'");
		
	//$data1=$CI->adodbx>GetRecord("t_pasien_all_history2","idx_pasien=$idx_pasien and 
		//idx_assesment=$idx_assesment and status_rehab=1 and status_proses='RG'");
		
	if(!cek_array($data1)):
		$dataPasien["idx_pasien"]=$idx_pasien;
		$dataPasien["idx_assesment"]=$idx_assesment;
		$dataPasien["no_rekam_medis"]=$pasien["no_rekam_medis"];
		$dataStatus=$summary;
		$dataStatus["tgl_kegiatan"]=$summary["tgl_registrasi"];
		$dataStatus["tgl_status_proses"]=$summary["tgl_registrasi"];
		$dataStatus["edited"]=$summary["tgl_registrasi"];
		$dataStatus["created"]=$summary["tgl_registrasi"];
		
		$dataStatus["status_rehab"]=1;
		$dataStatus["status_proses"]='RG';
		$dataStatus["inst_rujuk"]="BNNP";
		$dataStatus["rujuk_rehab"]=$summary["kd_bnn"]; 
		$dataStatus["tahun"]=date("Y",strtotime($dataStatus["tgl_status_proses"]));
	 	 $dataStatus["bulan"]=date("m",strtotime($dataStatus["tgl_status_proses"]));
		$CI->conn->AutoExecute("t_pasien_all_history",$dataStatus,"INSERT");
		$CI->conn->AutoExecute("t_pasien_all_history2",$dataStatus,"INSERT");
		
	endif;	
	
	if(!cek_array($data2)):
		$dataPasien["idx_pasien"]=$idx_pasien;
		$dataPasien["idx_assesment"]=$idx_assesment;
		$dataPasien["no_rekam_medis"]=$pasien["no_rekam_medis"];
		$dataStatus=$summary;
		$dataStatus["tgl_kegiatan"]=$summary["tgl_assestment"];
		$dataStatus["tgl_status_proses"]=$summary["tgl_assestment"];
		$dataStatus["edited"]=$summary["tgl_assestment"];
		$dataStatus["created"]=$summary["tgl_assestment"];
		$dataStatus["status_rehab"]=1;
		$dataStatus["status_proses"]='SS';
		$dataStatus["inst_rujuk"]="BNNP";
		$dataStatus["rujuk_rehab"]=$summary["kd_bnn"]; 
		$dataStatus["tahun"]=date("Y",strtotime($dataStatus["tgl_status_proses"]));
	 	 $dataStatus["bulan"]=date("m",strtotime($dataStatus["tgl_status_proses"]));
		$CI->conn->AutoExecute("t_pasien_all_history",$dataStatus,"INSERT");
		$CI->conn->AutoExecute("t_pasien_all_history2",$dataStatus,"INSERT");
	endif;	
	*/
}


function get_status_rawat($status_proses){
	$status["PR"]="PASCA";
	$status["RI"]="INAP";
	$status["RJ"]="JALAN";
	  
	$status["PRRI"]="INAP";
	$status["PRRI"]="JALAN";
	$status["PRRL"]="LANJUT";
		 
	$rawat1=substr($status_proses,0,2);
	$rawat2=substr($status_proses,0,4);
		  
	$status_rawat=isset($status[$rawat2])?$status[$rawat2]:$status[$rawat1];
	$status_rawat=$status_rawat?$status_rawat:"";
	return $status_rawat;
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

function update_pasien_monitoring_pasca($dataPasien,$dataStatus,$dataMonitoring){
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
	$arrData=$CI->adodbx->GetRecord("t_pasien_monitoring_pasca","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	if(cek_array($arrData)):
		$dataUpdate=$CI->_add_editor($dataUpdate);
		$CI->conn->AutoExecute("t_pasien_monitoring_pasca",$dataUpdate,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	else:
		$dataUpdate["idx_pasien"]=$dataPasien["idx_pasien"];
	  	$dataUpdate["idx_assesment"]=$dataPasien["idx_assesment"];
	  	$dataUpdate["no_rekam_medis"]=$dataPasien["no_rekam_medis"];
		$dataUpdate=$CI->_add_creator($dataUpdate);
		 
		$CI->conn->AutoExecute("t_pasien_monitoring_pasca",$dataUpdate,"INSERT");
	endif;
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}

if ( ! function_exists('rentang_waktu')):
	function rentang_waktu($tgl_akhir,$tgl_skrg){
		$CI =& get_instance();
		$query ="SELECT DATEDIFF('$tgl_akhir','$tgl_skrg') AS hasil";
			
		$result = $CI->conn->Execute($query);
		foreach($result as $row){
			$hasil=$row["hasil"];
		}
		
		return $hasil;
	}
endif;


if ( ! function_exists('update_status_program')):
function update_status_program($idx_pasien,$idx_assesment,$status_program='PS',$status_outcome=NULL){
	$CI =& get_instance();
	$data["status_program"]=$status_program;
	$data["outcome_pasien"]=$status_outcome;
	$data=$CI->_add_editor($data);
	$CI->conn->StartTrans();
	// $CI->conn->AutoExecute("t_pasien_monitoring_pasca",$data,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	$CI->conn->AutoExecute("t_pasien_monitoring_rehab",$data,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	$CI->conn->AutoExecute("t_pasien_assesment_summary",$data,"UPDATE","idx_pasien={$idx_pasien} and idx={$idx_assesment}");
	$CI->conn->AutoExecute("t_pasien_assesment_history",$data,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	
	$CI->conn->AutoExecute("t_pasien",$data,"UPDATE","idx={$idx_pasien}");
	
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}
endif;

if ( ! function_exists('update_status_program_pasca')):
function update_status_program_pasca($idx_pasien,$idx_assesment,$status_program='PS',$status_outcome=NULL){
	$CI =& get_instance();
	$data["status_program"]=$status_program;
	$data["outcome_pasien"]=$status_outcome;
	$data=$CI->_add_editor($data);
	$CI->conn->StartTrans();
	$CI->conn->AutoExecute("t_pasien_monitoring_pasca",$data,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	// $CI->conn->AutoExecute("t_pasien_monitoring_rehab",$data,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	$CI->conn->AutoExecute("t_pasien_assesment_summary",$data,"UPDATE","idx_pasien={$idx_pasien} and idx={$idx_assesment}");
	$CI->conn->AutoExecute("t_pasien_assesment_history",$data,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	$CI->conn->AutoExecute("t_pasien",$data,"UPDATE","idx={$idx_pasien}");
	$ok=$CI->conn->CompleteTrans();
	return $ok;
}
endif;





/* data statistik or dashboard */

if ( ! function_exists('summary_status_rehab_per_bulan')):
function summary_status_rehab_per_bulan($tahun=false,$bulan=12,$bulan_mulai=1){
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$bulan=$bulan?$bulan:date("m");
	
	$sql="
		select sum(CASE WHEN jenis_kelamin='L' THEN 1 else 0 end) as laki_laki, 
			sum(CASE WHEN jenis_kelamin='P' THEN 1 else 0 end) as perempuan,
			sum(CASE WHEN (a.status_rehab=1) THEN 1 else 0 end) as assesment, 
			sum(CASE WHEN (a.status_rehab=2) THEN 1 else 0 end) as rehab, 
			sum(CASE WHEN (a.status_rehab=3 and a.status_program='PS') THEN 1 else 0 end) as pasca, 
			sum(CASE WHEN (a.status_rehab=3 and a.status_program='SL') THEN 1 else 0 end) as selesai, 
			sum(CASE WHEN (a.status_rehab=3 and a.outcome_pasien='PP') THEN 1 else 0 end) as pulih_produktif, 
			sum(CASE WHEN (a.status_rehab=3 and a.outcome_pasien='PTP') THEN 1 else 0 end) as pulih_tidak_produktif, 
			sum(CASE WHEN (a.status_rehab=3 and a.outcome_pasien='TPP') THEN 1 else 0 end) as tidak_pulih_produktif, 
			sum(CASE WHEN (a.status_rehab=3 and a.outcome_pasien='TPTP') THEN 1 else 0 end) as tidak_pulih_tidak_produktif,
			count(idx_pasien) as jumlah 
			from (
			select idx_pasien,status_rehab,status_program,outcome_pasien,max(tgl_assestment) as edited 
			from t_pasien_assesment_history where status_rehab=1 and YEAR(tgl_assestment)={$tahun}
			and (MONTH(tgl_assestment)<={$bulan} and MONTH(tgl_assestment)>={$bulan_mulai})
			group by idx_pasien,status_rehab,status_program,outcome_pasien
			union
			select idx_pasien,status_rehab,status_program,outcome_pasien,max(tgl_status_proses) as edited 
			from t_pasien_all_history2 
				where 
				status_program='PS' 
				and edited IN (SELECT max(edited) FROM t_pasien_all_history2 
				where YEAR(tgl_status_proses)={$tahun}
			and (MONTH(tgl_status_proses)<={$bulan} and MONTH(tgl_status_proses)>={$bulan_mulai})
				group by idx_pasien)
			and YEAR(tgl_status_proses)={$tahun}
			and (MONTH(tgl_status_proses)<={$bulan} and MONTH(tgl_status_proses)>={$bulan_mulai})
			group by idx_pasien,status_rehab,status_program,outcome_pasien
			union
			select idx_pasien,status_rehab,status_program,outcome_pasien,max(tgl_status_proses) as edited 
			from t_pasien_all_history2 where status_rehab=3 and status_program='SL'
			and YEAR(tgl_status_proses)={$tahun}
			and (MONTH(tgl_status_proses)<={$bulan} and MONTH(tgl_status_proses)>={$bulan_mulai})
			group by idx_pasien,status_rehab,status_program,outcome_pasien
			) a left join t_pasien b on a.idx_pasien=b.idx  
	";
	
			$arrData=$CI->conn->GetRow($sql);
			
			return $arrData;

}
endif;


function get_status_proses_by_bulan($tahun=false,$bulan=12,$bulan_mulai=1){
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$bulan=$bulan?$bulan:date("m");
	
	$sql="select 
 sum(CASE WHEN status_rehab=1 THEN 1 else 0 end) as registrasi,
 sum(CASE WHEN status_rehab=2 THEN 1 else 0 end) as rehab,
 sum(CASE WHEN (status_rehab=3 and status_program='PS') THEN 1 else 0 end) as pasca, 
 sum(CASE WHEN (status_rehab=3 and status_program='SL') THEN 1 else 0 end) as selesai, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='PP') THEN 1 else 0 end) as pp, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='PTP') THEN 1 else 0 end) as ptp, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='TPP') THEN 1 else 0 end) as tpp, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='TPTP') THEN 1 else 0 end) as tptp,
 sum(CASE WHEN substr(status_proses,1,2)='RI' THEN 1 else 0 end) as inap,
 sum(CASE WHEN substr(status_proses,1,2)='RJ' THEN 1 else 0 end) as jalan,
 sum(CASE WHEN substr(status_proses,1,4)='PRRI' THEN 1 else 0 end) as prri,
 sum(CASE WHEN substr(status_proses,1,4)='PRRJ' THEN 1 else 0 end) as prrj,
 sum(CASE WHEN substr(status_proses,1,4)='PRRL' THEN 1 else 0 end) as prrl,
 sum(CASE WHEN status_proses='SS' THEN 1 else 0 end) as ss,
 sum(CASE WHEN status_proses='RIRMDT' THEN 1 else 0 end) as rirmdt,
 sum(CASE WHEN status_proses='RIRMEU' THEN 1 else 0 end) as rirmeu,
 sum(CASE WHEN status_proses='RIRSPP' THEN 1 else 0 end) as rirspp,
 sum(CASE WHEN status_proses='RIRSRE' THEN 1 else 0 end) as rirsre,
 sum(CASE WHEN status_proses='RJKL' THEN 1 else 0 end) as rjkl,
 sum(CASE WHEN status_proses='RJTS' THEN 1 else 0 end) as rjts,
 sum(CASE WHEN status_proses='RJTK' THEN 1 else 0 end) as rjtk,
 sum(CASE WHEN status_proses='PRAP' THEN 1 else 0 end) as prap,
 sum(CASE WHEN status_proses='PRRIDA' THEN 1 else 0 end) as prrida,
 sum(CASE WHEN status_proses='PRRIDR' THEN 1 else 0 end) as prridr,
 sum(CASE WHEN status_proses='PRRIDK' THEN 1 else 0 end) as prridk,
 sum(CASE WHEN status_proses='PRRIPD' THEN 1 else 0 end) as prripd,
 sum(CASE WHEN status_proses='PRRJPG' THEN 1 else 0 end) as prrjpg,
 sum(CASE WHEN status_proses='PRRLPUKP' THEN 1 else 0 end) as prrlpukp,
 sum(CASE WHEN status_proses='PRRLPUEP' THEN 1 else 0 end) as prrlpuep,
 sum(CASE WHEN status_proses='PRRLPUTU' THEN 1 else 0 end) as prrlputu,
 sum(CASE WHEN status_proses='PRRLPDHV' THEN 1 else 0 end) as prrlpdhv,
 sum(CASE WHEN status_proses='PRRLPDPK' THEN 1 else 0 end) as prrlpdpk,
 sum(CASE WHEN status_proses='PRRLPDTU' THEN 1 else 0 end) as prrlpdtu,
 sum(CASE WHEN status_proses='PRRLPDKN' THEN 1 else 0 end) as prrlpdkn,
 count(idx_pasien) as jumlah
 from
 t_pasien_all_history2
 where YEAR(tgl_status_proses)={$tahun}
			and (MONTH(tgl_status_proses)<={$bulan} and MONTH(tgl_status_proses)>={$bulan_mulai}) and edited IN (SELECT max(edited) FROM t_pasien_all_history2 
 where YEAR(tgl_status_proses)={$tahun}
			and (MONTH(tgl_status_proses)<={$bulan} and MONTH(tgl_status_proses)>={$bulan_mulai})  group by idx_pasien,idx_assesment)";
	$arrData=$CI->conn->GetRow($sql);
	
	return $arrData;
}


//current status per pasien
function get_status_proses_group_by_pasien($tahun=false,$bulan=12,$bulan_mulai=1){
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$bulan=$bulan?$bulan:date("m");
	
	$where[]="YEAR(tgl_status_proses)={$tahun}
			and (MONTH(tgl_status_proses)<={$bulan} and MONTH(tgl_status_proses)>={$bulan_mulai})";
	
	$whereSql=" ";
	if(cek_array($where)):
		$whereSql=join(" and ",$where);
	endif;
	
	$sql="select idx_pasien,
 sum(CASE WHEN status_rehab=1 THEN 1 else 0 end) as registrasi,
 sum(CASE WHEN status_rehab=2 THEN 1 else 0 end) as rehab,
 sum(CASE WHEN (status_rehab=3 and status_program='PS') THEN 1 else 0 end) as pasca, 
 sum(CASE WHEN (status_rehab=3 and status_program='SL') THEN 1 else 0 end) as selesai, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='PP') THEN 1 else 0 end) as pp, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='PTP') THEN 1 else 0 end) as ptp, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='TPP') THEN 1 else 0 end) as tpp, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='TPTP') THEN 1 else 0 end) as tptp,
 sum(CASE WHEN substr(status_proses,1,2)='RI' THEN 1 else 0 end) as inap,
 sum(CASE WHEN substr(status_proses,1,2)='RJ' THEN 1 else 0 end) as jalan,
 sum(CASE WHEN substr(status_proses,1,4)='PRRI' THEN 1 else 0 end) as prri,
 sum(CASE WHEN substr(status_proses,1,4)='PRRJ' THEN 1 else 0 end) as prrj,
 sum(CASE WHEN substr(status_proses,1,4)='PRRL' THEN 1 else 0 end) as prrl,
 sum(CASE WHEN status_proses='SS' THEN 1 else 0 end) as ss,
 sum(CASE WHEN status_proses='RIRMDT' THEN 1 else 0 end) as rirmdt,
 sum(CASE WHEN status_proses='RIRMEU' THEN 1 else 0 end) as rirmeu,
 sum(CASE WHEN status_proses='RIRSPP' THEN 1 else 0 end) as rirspp,
 sum(CASE WHEN status_proses='RIRSRE' THEN 1 else 0 end) as rirsre,
 sum(CASE WHEN status_proses='RJKL' THEN 1 else 0 end) as rjkl,
 sum(CASE WHEN status_proses='RJTS' THEN 1 else 0 end) as rjts,
 sum(CASE WHEN status_proses='RJTK' THEN 1 else 0 end) as rjtk,
 sum(CASE WHEN status_proses='PRAP' THEN 1 else 0 end) as prap,
 sum(CASE WHEN status_proses='PRRIDA' THEN 1 else 0 end) as prrida,
 sum(CASE WHEN status_proses='PRRIDR' THEN 1 else 0 end) as prridr,
 sum(CASE WHEN status_proses='PRRIDK' THEN 1 else 0 end) as prridk,
 sum(CASE WHEN status_proses='PRRIPD' THEN 1 else 0 end) as prripd,
 sum(CASE WHEN status_proses='PRRJPG' THEN 1 else 0 end) as prrjpg,
 sum(CASE WHEN status_proses='PRRLPUKP' THEN 1 else 0 end) as prrlpukp,
 sum(CASE WHEN status_proses='PRRLPUEP' THEN 1 else 0 end) as prrlpuep,
 sum(CASE WHEN status_proses='PRRLPUTU' THEN 1 else 0 end) as prrlputu,
 sum(CASE WHEN status_proses='PRRLPDHV' THEN 1 else 0 end) as prrlpdhv,
 sum(CASE WHEN status_proses='PRRLPDPK' THEN 1 else 0 end) as prrlpdpk,
 sum(CASE WHEN status_proses='PRRLPDTU' THEN 1 else 0 end) as prrlpdtu,
 sum(CASE WHEN status_proses='PRRLPDKN' THEN 1 else 0 end) as prrlpdkn,
 count(idx_pasien) as jumlah
 from
 t_pasien_all_history2
 where $whereSql and edited IN (SELECT max(edited) FROM t_pasien_all_history2 
 where $whereSql  group by idx_pasien)
 group by idx_pasien";
	$arrData=$CI->conn->GetAll($sql);
	
	return $arrData;
}


function get_status_proses_group_by_assesment($tahun=false,$bulan=12,$bulan_mulai=1){
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$bulan=$bulan?$bulan:date("m");
	
	$where[]="YEAR(tgl_status_proses)={$tahun}
			and (MONTH(tgl_status_proses)<={$bulan} and MONTH(tgl_status_proses)>={$bulan_mulai})";
	
	$whereSql=" ";
	if(cek_array($where)):
		$whereSql=join(" and ",$where);
	endif;
	
	$sql="select idx_pasien,idx_assesment,
 sum(CASE WHEN status_rehab=1 THEN 1 else 0 end) as registrasi,
 sum(CASE WHEN status_rehab=2 THEN 1 else 0 end) as rehab,
 sum(CASE WHEN (status_rehab=3 and status_program='PS') THEN 1 else 0 end) as pasca, 
 sum(CASE WHEN (status_rehab=3 and status_program='SL') THEN 1 else 0 end) as selesai, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='PP') THEN 1 else 0 end) as pp, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='PTP') THEN 1 else 0 end) as ptp, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='TPP') THEN 1 else 0 end) as tpp, 
 sum(CASE WHEN (status_rehab=3 and outcome_pasien='TPTP') THEN 1 else 0 end) as tptp,
 sum(CASE WHEN substr(status_proses,1,2)='RI' THEN 1 else 0 end) as inap,
 sum(CASE WHEN substr(status_proses,1,2)='RJ' THEN 1 else 0 end) as jalan,
 sum(CASE WHEN substr(status_proses,1,4)='PRRI' THEN 1 else 0 end) as prri,
 sum(CASE WHEN substr(status_proses,1,4)='PRRJ' THEN 1 else 0 end) as prrj,
 sum(CASE WHEN substr(status_proses,1,4)='PRRL' THEN 1 else 0 end) as prrl,
 sum(CASE WHEN status_proses='SS' THEN 1 else 0 end) as ss,
 sum(CASE WHEN status_proses='RIRMDT' THEN 1 else 0 end) as rirmdt,
 sum(CASE WHEN status_proses='RIRMEU' THEN 1 else 0 end) as rirmeu,
 sum(CASE WHEN status_proses='RIRSPP' THEN 1 else 0 end) as rirspp,
 sum(CASE WHEN status_proses='RIRSRE' THEN 1 else 0 end) as rirsre,
 sum(CASE WHEN status_proses='RJKL' THEN 1 else 0 end) as rjkl,
 sum(CASE WHEN status_proses='RJTS' THEN 1 else 0 end) as rjts,
 sum(CASE WHEN status_proses='RJTK' THEN 1 else 0 end) as rjtk,
 sum(CASE WHEN status_proses='PRAP' THEN 1 else 0 end) as prap,
 sum(CASE WHEN status_proses='PRRIDA' THEN 1 else 0 end) as prrida,
 sum(CASE WHEN status_proses='PRRIDR' THEN 1 else 0 end) as prridr,
 sum(CASE WHEN status_proses='PRRIDK' THEN 1 else 0 end) as prridk,
 sum(CASE WHEN status_proses='PRRIPD' THEN 1 else 0 end) as prripd,
 sum(CASE WHEN status_proses='PRRJPG' THEN 1 else 0 end) as prrjpg,
 sum(CASE WHEN status_proses='PRRLPUKP' THEN 1 else 0 end) as prrlpukp,
 sum(CASE WHEN status_proses='PRRLPUEP' THEN 1 else 0 end) as prrlpuep,
 sum(CASE WHEN status_proses='PRRLPUTU' THEN 1 else 0 end) as prrlputu,
 sum(CASE WHEN status_proses='PRRLPDHV' THEN 1 else 0 end) as prrlpdhv,
 sum(CASE WHEN status_proses='PRRLPDPK' THEN 1 else 0 end) as prrlpdpk,
 sum(CASE WHEN status_proses='PRRLPDTU' THEN 1 else 0 end) as prrlpdtu,
 sum(CASE WHEN status_proses='PRRLPDKN' THEN 1 else 0 end) as prrlpdkn,
 count(idx_pasien) as jumlah
 from
 t_pasien_all_history2
 where $whereSql and edited IN (SELECT max(edited) FROM t_pasien_all_history2 
 where $whereSql  group by idx_pasien,idx_assesment)
 group by idx_pasien,idx_assesment";
	$arrData=$CI->conn->GetAll($sql);
	
	return $arrData;
}

function filter_by_user_org($where=false){
	$CI =& get_instance();
	/*
	if($CI->user_prop):			
			if($CI->user_instansi!="BNNP" && $CI->user_instansi!="BNNK"):
				$where[]="(rujuk_rehab='".$CI->user_org."' or rujuk_pasca='".$CI->user_org."' or rujuk_lanjut='".$CI->user_org."' or kd_bnn='".$CI->user_org."')";
			endif;	
			
			if($CI->user_instansi=="BNNP"):	
				$where[]="substr(kd_wilayah,1,4) like '".$CI->user_prop."%' and ((inst_rujuk<>'BL' and inst_rujuk<>'BB') or (inst_pasca<>'BL' and inst_pasca<>'BB') or (inst_lanjut<>'BL' and inst_lanjut<>'BB') or (inst_rujuk is null and inst_pasca is null and inst_lanjut is null))";	
			endif;
			if($CI->user_instansi=="BNNK"):	
				$where[]="substr(kd_wilayah,1,4) like '".$CI->user_prop.$CI->user_kab."%' and ((inst_rujuk<>'BL' and inst_rujuk<>'BB') or (inst_pasca<>'BL' and inst_pasca<>'BB') or (inst_lanjut<>'BL' and inst_lanjut<>'BB') or (inst_rujuk is null and inst_pasca is null and inst_lanjut is null))";	
			endif;
		endif;
		*/
		return $where;
}


function map_all_org(){
	$bnnpk=lookup("m_org","kd_org","nama","active=1","order by idx");
	$balai=lookup("m_instansi","kd_instansi","nama_instansi","jenis_tempat_rehab in ('BB','BLK','RD','KM')","order by idx");	
	if(cek_array($bnnpk)):
		foreach($bnnpk as $x=>$val):
			$nama=str_replace("BNN PROPINSI","BNNP",$val);
			$nama=str_replace("BNN KABUPATEN","BNNK",$nama);
			$nama=str_replace("BNN KOTA","BNNK KOTA",$nama);
			$bnnpk[$x]=$nama;
		endforeach;
	endif;
	if(cek_array($balai)):
		foreach($balai as $x=>$val):
			$nama=str_replace("REHABILITASI","REHAB.",strtoupper($val));
			$bnnpk[$x]=$nama;
		endforeach;
	endif;
	$map_all_org=$bnnpk+$balai;
	return $map_all_org;
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