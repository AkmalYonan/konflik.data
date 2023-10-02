<?php

class skpa_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'm_skpa';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	function search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl,$data,$sort,$dataColumn);
    }
	function get_record($where,$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl,$where,$dataColumn);
    }
	function get_skpa_name($id=false){
		$sql = "select name from ".$this->tbl." where id=".$id;
		$arrDB = $this->conn->GetOne($sql);	
		return $arrDB;
	}
}
