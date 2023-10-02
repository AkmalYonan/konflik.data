<?php

class dashboard_instansi_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	
	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	
	public function GetJenisInstansi($criteria,$filter){
		
		if($filter):
			$where_sql	=	" where ".$criteria." and ".$filter;
		else:
			$where_sql	=	" where ".$criteria;
		endif;
		
		$sql			=	"
							select
							a.jenis_instansi
							from m_instansi a
							";
		$sql			.=	$where_sql;
		$sql			.=	" group by a.jenis_instansi";
		
		$arr			=	$this->conn->GetAll($sql);
		
		return $arr;
		
	}
	
	public function GetNamaJenisInstansi($kd_jenis_instansi){
	
		$sql			=	"select ur_jenis_instansi from m_jenis_instansi where kd_jenis_instansi='".$kd_jenis_instansi."'";
		
		$nama			=	$this->conn->GetOne($sql);
		
		return $nama;
	
	}
	
	public function GetTotalJenisInstansi($jenis_instansi,$criteria,$filter){
		
		if($filter):
			$where_sql	=	" where jenis_instansi='".$jenis_instansi."' and ".$criteria." and ".$filter;
		else:
			$where_sql	=	" where jenis_instansi='".$jenis_instansi."' and ".$criteria;
		endif;
		
		$sql			=	"select count(idx) as total from m_instansi ".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;
		
	}
	
	public function GetTotalInstansi($criteria,$filter){
		
		if($filter):
			$where_sql	=	" where ".$criteria." and ".$filter;
		else:
			$where_sql	=	" where ".$criteria;
		endif;
		
		$sql			=	"select count(idx) as total from m_instansi ".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;
		
	}	
	
	public function GetTotalRawatJalan($criteria,$filter){
		
		if($filter):
			$where_sql	=	" where rawat_jalan is not null and ".$criteria." and ".$filter;
		else:
			$where_sql	=	" where rawat_jalan is not null and ".$criteria;
		endif;
		
		$sql				=	"select count(idx) as total from m_instansi ".$where_sql;
		
		$total				=	$this->conn->GetOne($sql);
		
		return $total;
		
	}	
	
	public function GetTotalRawatInapJalan($criteria,$filter){
		
		if($filter):
			$where_sql	=	" where (rawat_inap is not null or rawat_jalan is not null) and ".$criteria." and ".$filter;
		else:
			$where_sql	=	" where (rawat_inap is not null or rawat_jalan is not null) and ".$criteria;
		endif;
		
		$sql				=	"select count(idx) as total from m_instansi ".$where_sql;
		
		$total				=	$this->conn->GetOne($sql);
		
		return $total;
		
	}			
	
	public function GetTotalPasienPasca($filter){
		
		if($filter):
			$where_sql	=	" where status_rehab='3' and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3'";
		endif;
		
		$sql			=	"select count(idx) as total from t_pasien".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;
		
	}
	
	public function GetTotalJenisKelamin($filter){
		
		if($filter):
			$where_sql	=	" where status_rehab='3' and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3'";
		endif;
		
		$sql			=	"select count(idx) as total,jenis_kelamin from t_pasien".$where_sql." group by jenis_kelamin";
		
		$arr			=	$this->conn->GetAll($sql);
		
		return $arr;
	}
	
	public function GetTotalPasienRawatInap($filter){
	
		if($filter):
			$where_sql	=	" where status_rehab='3' and (status_proses like '%PRRI%') and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3' and (status_proses like '%PRRI%')";
		endif;
		
		$sql			=	"select count(idx) as total from t_pasien".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;
	
	}
	
	public function GetTotalPasienRawatJalan($filter){

		if($filter):
			$where_sql	=	" where status_rehab='3' and (status_proses like '%PRRJ%') and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3' and (status_proses like '%PRRJ%')";
		endif;
		
		$sql			=	"select count(idx) as total from t_pasien".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;
	
	}
	
	public function GetTotalPasienRawatLanjut($filter){

		if($filter):
			$where_sql	=	" where status_rehab='3' and (status_proses like '%PRRL%') and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3' and (status_proses like '%PRRL%')";
		endif;
		
		$sql			=	"select count(idx) as total from t_pasien".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;
	
	}
	
	public function GetDataPekerjaan($filter){
		
		if($filter):
			$where_sql	=	" where status_rehab='3' and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3'";
		endif;
		
		$sql			=	"select pekerjaan from t_pasien ".$where_sql." group by pekerjaan";
		
		$arr			=	$this->conn->GetAll($sql);
		
		return $arr;
		
	}
	
	public function GetTotalPekerjaanPasien($kd_pekerjaan,$filter){
	
		if($filter):
			$where_sql	=	" where status_rehab='3' and pekerjaan='".$kd_pekerjaan."' and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3' and pekerjaan='".$kd_pekerjaan."'";
		endif;
		
		$sql			=	"select count(idx) from t_pasien ".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;
	
	}	
	
	public function GetDataPendidikan($filter){
		
		if($filter):
			$where_sql	=	" where status_rehab='3' and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3'";
		endif;
		
		$sql			=	"select pendidikan from t_pasien ".$where_sql." group by pendidikan";
		
		$arr			=	$this->conn->GetAll($sql);
		
		return $arr;
		
	}	
	
	public function GetTotalPendidikanPasien($kd_pendidikan,$filter){
	
		if($filter):
			$where_sql	=	" where status_rehab='3' and pendidikan='".$kd_pendidikan."' and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3' and pendidikan='".$kd_pendidikan."'";
		endif;
		
		$sql			=	"select count(idx) from t_pasien ".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;
	
	}
	
	public function GetTotalUmurPasien($rentang_umur,$filter){
	
		if($filter):
			$where_sql	=	" where status_rehab='3' and (".$rentang_umur.") and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3' and (".$rentang_umur.")";
		endif;
		
		$sql			=	"select count(idx) from t_pasien ".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;
	
	}
	
	public function GetTotalRehab($periode_bulan,$filter){
		
		if($filter):
			$where_sql	=	" where status_rehab='2' and periode_bulan='".$periode_bulan."' and ".$filter;
		else:
			$where_sql	=	" where status_rehab='2' and periode_bulan='".$periode_bulan."'";
		endif;
		
		$sql			=	"select count(idx) from t_pasien ".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;		
		
	}
	
	public function GetTotalPasca($periode_bulan,$filter){
		
		if($filter):
			$where_sql	=	" where status_rehab='3' and periode_bulan='".$periode_bulan."' and ".$filter;
		else:
			$where_sql	=	" where status_rehab='3' and periode_bulan='".$periode_bulan."'";
		endif;
		
		$sql			=	"select count(idx) from t_pasien ".$where_sql;
		
		$total			=	$this->conn->GetOne($sql);
		
		return $total;		
		
	}				

}
