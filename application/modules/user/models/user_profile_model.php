<?php

class user_profile_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'users';
    public $tbl_group="groups";
	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
    
    function group_add($data){
        $ret=$this->adodbx->Insert($this->tbl_group,$data);
        return $ret;
    }
    
    function group_update($data,$where){
        $ret=$this->adodbx->Update($this->tbl_group,$data,$where);
        return $ret;
    }
    
    function group_get($where,$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl_group,$where,$dataColumn);
    }
    
    function group_delete($where){
        return $this->adodbx->Delete($this->tbl_group,$where);
    }
    
    function group_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_group,$data,$sort,$dataColumn);
    }
    
    function group_search_record_where($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->tbl_group,$where,$sort,$dataColumn);
    }
	
	
}

