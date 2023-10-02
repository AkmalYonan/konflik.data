<?php

class dokumen_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'ppid_dokumen';
	public $tbl_jenis= 'm_jenis';
	public $tbl_kategori= 'm_kategori';
	public $tbl_skpa= 'm_skpa';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	function jenis_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_jenis,$data,$sort,$dataColumn);
    }
	function kategori_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_kategori,$data,$sort,$dataColumn);
    }
	function skpa_search_record($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->tbl_skpa,$where,$sort,$dataColumn);
    }
}
