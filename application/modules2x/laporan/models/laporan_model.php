<?php

class laporan_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= '';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
        
	}
	
	public function GetDataPasienBaru($filter){
		if($filter):
			$where_sql	=	" where ".$filter;
		else:
			$where_sql	=	"";
		endif;
		
		$sql			=	"
							select *
							
							from
							
							(select
							a.*,
							b.diagnosis_napza,
							b.diagnosis_lain,
							b.rencana_terapi_resume,
							c.dt,
							c.kl
							
							from t_pasien_assesment_history a
							left join t_pasien_assesment_summary b
							on a.idx=b.idx_pasien  
							left join t_pasien_monitoring_rehab c on
							b.idx=c.idx_assesment
							where b.flag_pasien=0
							
							) x
							";
		$sql			.=	$where_sql;
		
		$arr			=	$this->conn->GetAll($sql);
		
		return $arr;
	}
	
	public function GetDataPasienLama($filter){
		
		if($filter):
			$where_sql	=	" where ".$filter;
		else:
			$where_sql	=	"";
		endif;
		
		$sql			=	"
							select *
							
							from
							
							(select
							a.*,
							b.diagnosis_napza,
							b.diagnosis_lain,
							b.rencana_terapi_resume
							from t_pasien a
							left join t_pasien_assesment_summary b
							on a.idx=b.idx_pasien where b.flag_pasien=1
							) x
							";
		$sql			.=	$where_sql;
		
		$arr			=	$this->conn->GetAll($sql);
		
		return $arr;
	}	
	
	public function GetRekapPropinsiStatusRawat($filter,$listMonth){
		
		if($filter):
			$where_sql	=	" where ".$filter;
		else:
			$where_sql	=	"";
		endif;
		
		$sql			=	"
							select 
							a.kd_propinsi,
							b.namaProvinsi,
							sum(case when a.status_rehab='2' and substr(a.status_proses,1,2)='RI' then 1 else 0 end) as total_inap,	
							sum(case when a.status_rehab='2' and substr(a.status_proses,1,2)='RJ' then 1 else 0 end) as total_jalan,
							sum(case when a.status_rehab='3' then 1 else 0 end) as total_pasca,			
							";	
										
		foreach($listMonth as $k=>$v):
		
			$join_sql[]	=	" sum(case
									when a.status_rehab='2' and substr(a.status_proses,1,2)='RI' and month(a.tgl_registrasi)='".($k+1)."' then 1 
									else 0 end) as inap_".($k+1);
			$join_sql[]	=	" sum(case
									when a.status_rehab='2' and substr(a.status_proses,1,2)='RJ' and month(a.tgl_registrasi)='".($k+1)."' then 1 
									else 0 end) as jalan_".($k+1);
			$join_sql[]	=	" sum(case
									when a.status_rehab='3' and month(a.tgl_registrasi)='".($k+1)."' then 1 
									else 0 end) as pasca_".($k+1);		
				
		endforeach;
		
		$sql			.= join(",",$join_sql);	

		$sql			.=	" 
							from t_pasien a
							
							left join m_provinsi b
							on a.kd_propinsi=b.kodeProp
							
							".$where_sql;
							
		$sql			.=	" group by a.kd_propinsi,b.namaProvinsi";
		$arr			=	$this->conn->GetAll($sql);
		return $arr;
		
	}
	
	public function GetRekapPropinsiSumberPasien($filter,$listMonth){
		
		if($filter):
			$where_sql	=	" where ".$filter;
		else:
			$where_sql	=	"";
		endif;
		
		$sql			=	"
							select 
							a.kd_propinsi,
							b.namaProvinsi,
							sum(case when sumber_pasien='SUKARELA' then 1 else 0 end) as total_sukarela,	
							sum(case when sumber_pasien='HUKUM' then 1 else 0 end) as total_hukum,
							sum(case when sumber_pasien='WBP' then 1 else 0 end) as total_wbp,
							sum(case when sumber_pasien='VH' then 1 else 0 end) as total_vh,			
							";	
										
		foreach($listMonth as $k=>$v):
		
			$join_sql[]	=	" sum(case
									when sumber_pasien='SUKARELA' and month(a.tgl_registrasi)='".($k+1)."' then 1 
									else 0 end) as sukarela_".($k+1);
			$join_sql[]	=	" sum(case
									when sumber_pasien='HUKUM' and month(a.tgl_registrasi)='".($k+1)."' then 1 
									else 0 end) as hukum_".($k+1);
			$join_sql[]	=	" sum(case
									when sumber_pasien='WBP' and month(a.tgl_registrasi)='".($k+1)."' then 1 
									else 0 end) as wbp_".($k+1);	
			$join_sql[]	=	" sum(case
									when sumber_pasien='VH' and month(a.tgl_registrasi)='".($k+1)."' then 1 
									else 0 end) as vh_".($k+1);								
				
		endforeach;
		
		$sql			.= join(",",$join_sql);	

		$sql			.=	" 
							from t_pasien a
							
							left join m_provinsi b
							on a.kd_propinsi=b.kodeProp
							
							".$where_sql;
							
		$sql			.=	" group by a.kd_propinsi,b.namaProvinsi";
		$arr			=	$this->conn->GetAll($sql);
		return $arr;
		
	}
	
	public function GetTitleReport($tingkat,$organisasi){
		
		if($tingkat=='BL'):
			$arr	=	$this->conn->GetRow("select nama_instansi,alamat from m_instansi where kd_instansi='".$organisasi."'");
		else:
			$arr	=	$this->conn->GetRow("select nama as nama_instansi,alamat from m_org where kd_org='".$organisasi."'");
		endif;
		
		return $arr;
		
	}	
	
}