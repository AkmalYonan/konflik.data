<?php

class dashboard_rehab_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	 
	public $tbl_rehab= 't_pasien_assesment_history'; 
	public $status_rehab= 'tgl_mulai_rehab is not null'; 
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
	function GetUmur($where,$filter=false) {
		$where="(".$where.")".$filter;
		$get = $this->conn->GetOne("select count(*) as jumlah from ".$this->tbl_rehab." where ".$this->status_rehab." and ".$filter."");
		return $get;
	}
}
