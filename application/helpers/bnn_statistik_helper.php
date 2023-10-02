<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_status_proses_by_pasien')):
function get_status_proses_by_pasien($idx_pasien=false,$tahun=false,$bulan=12,$bulan_mulai=1){
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$bulan=$bulan?$bulan:date("m");
	if($idx_pasien):
		$where[]="idx_pasien=$idx_pasien";
	endif;
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
endif;

function get_status_proses_by_assesment($idx_pasien=false,$idx_assesment=false,$tahun=false,$bulan=12,$bulan_mulai=1){
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$bulan=$bulan?$bulan:date("m");
	if($idx_pasien):
		$where[]="idx_pasien=$idx_pasien";
	endif;
	if($idx_assesment):
		$where[]="idx_assesment=$idx_assesment";
	endif;
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

function get_status_proses_with_outcome_by_pasien($idx_pasien=false,
	$tahun=false,$bulan=12,$bulan_mulai=1){
	
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$bulan=$bulan?$bulan:date("m");
	if($idx_pasien):
		$where[]="idx_pasien=$idx_pasien";
	endif;
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
 where $whereSql  group by idx_pasien,idx_assesment)
 group by idx_pasien";
	$arrData=$CI->conn->GetAll($sql);
	
	return $arrData;
}


function get_rekap_status_proses_per_bulan($tahun=false,$bulan=12,$bulan_mulai=1){
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$bulan=$bulan?$bulan:date("m");
	/*
	if($idx_pasien):
		$where[]="idx_pasien=$idx_pasien";
	endif;
	*/
	
	$where[]="YEAR(tgl_status_proses)={$tahun}
			and (MONTH(tgl_status_proses)<={$bulan} and MONTH(tgl_status_proses)>={$bulan_mulai})";
	
	$userdata=$CI->user_data;
	$tipe_instansi=$userdata["tipe_instansi"]?$userdata["tipe_instansi"]:false;
	$kd_org=$userdata["kd_org"]?$userdata["kd_org"]:false;
	
	$req=get_post();
	if(!$tipe_instansi):
		$tipe_instansi=$req["tipe_instansi"]?$req["tipe_instansi"]:false;
	endif;
	
	if(!$kd_org):
		$kd_org=$req["kd_org"]?$req["kd_org"]:false;
	endif;
	
	if($tipe_instansi):
		if($tipe_instansi=="BNNP"):
			$where[]="inst_rujuk in ('BNNP','BNNK')";
		else:
			$where[]="inst_rujuk='".$tipe_instansi."'";
		endif;
	endif;
	
	if($kd_org):
		$whereOrg="rujuk_rehab='".$kd_org."'";
		if($tipe_instansi=="BNNP"):
			$org=explode("-",$kd_org);
			$myorg=$org[0]."-";
			$whereOrg="(rujuk_rehab like '".$myorg."%')";
		endif;
		$where[]=$whereOrg;
	endif;
	
	
	$whereSql=" ";
	if(cek_array($where)):
		$whereSql=join(" and ",$where);
	endif;
	
	$sql="select year(tgl_status_proses) tahun, MONTH(tgl_status_proses) as bulan ,
 sum(CASE WHEN status_rehab=1 THEN 1 else 0 end) as registrasi,
 sum(CASE WHEN status_rehab=2 THEN 1 else 0 end) as rehab,
 sum(CASE WHEN (status_rehab=3 and status_program='PS') THEN 1 else 0 end) as pasca, 
 sum(CASE WHEN (status_rehab=3 and status_program='SL') THEN 1 else 0 end) as selesai, 
 sum(CASE WHEN (status_program='DO') THEN 1 else 0 end) as do, 
 sum(CASE WHEN (status_program='MD') THEN 1 else 0 end) as md, 
 sum(CASE WHEN (status_program='KB') THEN 1 else 0 end) as kb, 
 
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
 where $whereSql
   group by idx_pasien,idx_assesment)
 group by year(tgl_status_proses), MONTH(tgl_status_proses)";
	
	$arrData=$CI->conn->GetAll($sql);
	
	return $arrData;
}


function get_rekap_status_proses_per_tahun($tahun=false,$tahun_mulai=false){
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$tahun_mulai=$tahun_mulai?$tahun_mulai:false;
	/*
	if($idx_pasien):
		$where[]="idx_pasien=$idx_pasien";
	endif;
	*/
	
	$where[]="YEAR(tgl_status_proses)<={$tahun}"; 
	if($tahun_mulai):
		$where[]="YEAR(tgl_status_proses)>={$tahun_mulai}"; 
	endif;
	
	$userdata=$CI->user_data;
	$tipe_instansi=$userdata["tipe_instansi"]?$userdata["tipe_instansi"]:false;
	$kd_org=$userdata["kd_org"]?$userdata["kd_org"]:false;
	
	$req=get_post();
	if(!$tipe_instansi):
		$tipe_instansi=$req["tipe_instansi"]?$req["tipe_instansi"]:false;
	endif;
	
	if(!$kd_org):
		$kd_org=$req["kd_org"]?$req["kd_org"]:false;
	endif;
	
	if($tipe_instansi):
		if($tipe_instansi=="BNNP"):
			$where[]="inst_rujuk in ('BNNP','BNNK')";
		else:
			$where[]="inst_rujuk='".$tipe_instansi."'";
		endif;
	endif;
	
	if($kd_org):
		$whereOrg="rujuk_rehab='".$kd_org."'";
		if($tipe_instansi=="BNNP"):
			$org=explode("-",$kd_org);
			$myorg=$org[0]."-";
			$whereOrg="(rujuk_rehab like '".$myorg."%')";
		endif;
		$where[]=$whereOrg;
	endif;
	
	$whereSql=" ";
	if(cek_array($where)):
		$whereSql=join(" and ",$where);
	endif;
	
	
	$sql="select year(tgl_status_proses) as tahun,
 sum(CASE WHEN status_rehab=1 THEN 1 else 0 end) as registrasi,
 sum(CASE WHEN status_rehab=2 THEN 1 else 0 end) as rehab,
 sum(CASE WHEN (status_rehab=3 and status_program='PS') THEN 1 else 0 end) as pasca, 
 sum(CASE WHEN (status_rehab=3 and status_program='SL') THEN 1 else 0 end) as selesai, 
 sum(CASE WHEN (status_program='DO') THEN 1 else 0 end) as do, 
 sum(CASE WHEN (status_program='MD') THEN 1 else 0 end) as md, 
 sum(CASE WHEN (status_program='KB') THEN 1 else 0 end) as kb, 
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
 where $whereSql group by idx_pasien,idx_assesment)
  
 group by year(tgl_status_proses)";
	$arrData=$CI->conn->GetAll($sql);
	
	return $arrData;
}




function get_monitoring_pasien($tahun=false,$tahun_mulai=false){
	$CI =& get_instance();
	
	$tahun=$tahun?$tahun:date("Y");
	$tahun_mulai=$tahun_mulai?$tahun_mulai:false;
	/*
	if($idx_pasien):
		$where[]="idx_pasien=$idx_pasien";
	endif;
	*/
	
	$where[]="YEAR(tgl_status_proses)<={$tahun}"; 
	if($tahun_mulai):
		$where[]="YEAR(tgl_status_proses)>={$tahun_mulai}"; 
	endif;
	
	$userdata=$CI->user_data;
	$tipe_instansi=$userdata["tipe_instansi"]?$userdata["tipe_instansi"]:false;
	$kd_org=$userdata["kd_org"]?$userdata["kd_org"]:false;
	
	$req=get_post();
	if(!$tipe_instansi):
		$tipe_instansi=$req["tipe_instansi"]?$req["tipe_instansi"]:false;
	endif;
	
	if(!$kd_org):
		$kd_org=$req["kd_org"]?$req["kd_org"]:false;
	endif;
	
	if($tipe_instansi):
		if($tipe_instansi=="BNNP"):
			$where[]="inst_rujuk in ('BNNP','BNNK')";
		else:
			$where[]="inst_rujuk='".$tipe_instansi."'";
		endif;
	endif;
	
	if($kd_org):
		$whereOrg="rujuk_rehab='".$kd_org."'";
		if($tipe_instansi=="BNNP"):
			$org=explode("-",$kd_org);
			$myorg=$org[0]."-";
			$whereOrg="(rujuk_rehab like '".$myorg."%')";
		endif;
		$where[]=$whereOrg;
	endif;
	
	$whereSql=" ";
	if(cek_array($where)):
		$whereSql=join(" and ",$where);
	endif;
	
	
	$sql="select idx_pasien,idx_assesment,nama,
 sum(CASE WHEN status_rehab=1 THEN 1 else 0 end) as registrasi,
 sum(CASE WHEN status_rehab=2 THEN 1 else 0 end) as rehab,
 sum(CASE WHEN (status_rehab=3 and status_program='PS') THEN 1 else 0 end) as pasca, 
 sum(CASE WHEN (status_rehab=3 and status_program='SL') THEN 1 else 0 end) as selesai, 
 sum(CASE WHEN (status_program='DO') THEN 1 else 0 end) as do, 
 sum(CASE WHEN (status_program='MD') THEN 1 else 0 end) as md, 
 sum(CASE WHEN (status_program='KB') THEN 1 else 0 end) as kb, 
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
 count(idx_assesment) as jumlah
 from
 t_pasien_all_history2 a left join (select idx,nama from t_pasien) b on a.idx_pasien=b.idx 
 where $whereSql
 group by idx_pasien,idx_assesment,nama";
	$arrData=$CI->conn->GetAll($sql);
	
	return $arrData;
}
