<?php

class account_manager_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'adm_users';
    public $tbl_group="adm_groups";
	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	
	function masterGroup_get(){
		$ret=$this->adodbx->GetAll("select * from adm_groups");
		return $ret;
    }
	
	function users_add($data){
		// pre($data);exit;
        $ret=$this->adodbx->Insert("adm_users",$data);
        return $ret;
    }
	
	function users_update($data){
		$id = $data['id'];
		return $this->conn->AutoExecute('adm_users',$data,'UPDATE',"id='$id'");
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

