<?php

class pasien_list_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 't_pasien';

	function __construct(){
		parent::__construct();
		$this->tbl=$tbl;
		$this->db=$this->conn;
	}
	
	public function CekNik($nik){
		
		$where_sql		=	" where nik='".$nik."' and active_pasien='1'";
		
		$sql			=	"select nik from t_pasien".$where_sql;
		
		$nik			=	$this->conn->GetOne($sql);
		
		return $nik;
		
	}
}