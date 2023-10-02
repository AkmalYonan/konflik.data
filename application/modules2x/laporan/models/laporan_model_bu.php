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
							sum(case when a.status_rehab='2' and a.status_proses='RI' then 1 else 0 end) as total_inap,	
							sum(case when a.status_rehab='2' and a.status_proses='RJ' then 1 else 0 end) as total_jalan,
							sum(case when a.status_rehab='3' then 1 else 0 end) as total_pasca,			
							";	
										
		foreach($listMonth as $k=>$v):
		
			$join_sql[]	=	" sum(case
									when a.status_rehab='2' and a.status_proses='RI' and a.periode_bulan='".$k."' then 1 
									else 0 end) as inap_".$v;
			$join_sql[]	=	" sum(case
									when a.status_rehab='2' and a.status_proses='RJ' and a.periode_bulan='".$k."' then 1 
									else 0 end) as jalan_".$v;
			$join_sql[]	=	" sum(case
									when a.status_rehab='3' and a.periode_bulan='".$k."' then 1 
									else 0 end) as pasca_".$v;		
																						
		endforeach;
		
		$sql			.= join(",",$join_sql);	

		$sql			.=	" 
							from t_pasien a
							
							left join m_provinsi b
							on a.kd_propinsi=b.kodeProp
							
							".$where_sql;
							
		$sql			.=	" group by a.kd_propinsi ";
		
		$arr			=	$this->conn->GetAll($sql);
		
		return $arr;
		
	}
}