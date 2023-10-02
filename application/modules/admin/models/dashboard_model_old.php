<?php

class dashboard_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	
	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	
	function getTotalRumkitByKelasUO() {
		$get=$this->adodbx->GetAll("SELECT a.c_h as uo,c_e as kelas,b.nama,b.kode,count(c_a) as total FROM tbl_raws_2 a left join mst_rs_kelas b on TRIM(a.c_e)=b.kode where c_e<>'' GROUP BY b.nama,a.c_h");
		return $get;
	}
	function getDistinctKelas() {
		$get=$this->adodbx->GetAll("SELECT * FROM mst_rs_kelas");
		return $get;
	}
	function getDistinctPenyelenggara() {
		$get=$this->adodbx->GetAll("SELECT distinct(c_h) as uo FROM tbl_raws_2  where c_h<>''");
		return $get;
	}
}
