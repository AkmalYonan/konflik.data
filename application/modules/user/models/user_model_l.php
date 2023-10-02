<?php

class user_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'users';
	public $tbl_m_tanda_pengenal= 'm_tanda_pengenal';
	public $tbl_m_propinsi= 'm_propinsi';
	public $tbl_m_pekerjaan= 'm_pekerjaan';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	function m_tanda_pengenal($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_m_tanda_pengenal,$data,$sort,$dataColumn);
    }
	function m_propinsi($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_m_propinsi,$data,$sort,$dataColumn);
    }
	function m_pekerjaan($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_m_pekerjaan,$data,$sort,$dataColumn);
    }
}

