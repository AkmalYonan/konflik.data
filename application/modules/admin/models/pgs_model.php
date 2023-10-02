<?php

class pgs_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'cms_layanan';
	public $tbl_cat= 'cms_pages_category';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
        
	}
	function get_pages_record($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl_cat,$where,$dataColumn);
    }
}
