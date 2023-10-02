<?php
class db_server_model extends CI_Model {
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'm_server';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	
    
    /**
     * GetRecord by id
     * @param int $id
     * @return array record
     */ 
    function GetRecordByID($id){
        return $this->GetRecord("idx={$id}");
    }
    
    /**
     * List All Data
     * @return array record
     */ 
    function ListAll(){
        return $this->SearchRecord();
    }
	
	/**
     * Delete By ID
     * @param int $id
     * @return int affected rows
     */ 
    function DeleteByID($id){
        return $this->Delete("idx={$id}");
    }
    
    /**
     * Update By ID
     * @param int $id
     * @return int affectedrows
     */ 
    function UpdateByID($data,$id){
        return $this->Update($data, "idx={$id}");
    }
    
    /*
     * Add data
     */
	function Insert($data){
		return $this->adobx->Insert($this->tbl, $data);
	}
    
    
	/*
     * Update Data
     */
	function Update($data,$where){
		return $this->adodbx->Update($this->tbl,$data,$where);
	}
    
	
	/*
     * Delete Data
     */
	function Delete($where){
		return $this->adodbx->Delete($this->tbl,$where);
	}
	    
    /*
     * Get Record List
     */
	function GetRecord($where=false,$dataColumn=false){
		return $this->adodbx->GetRecord($this->tbl,$where,$dataColumn);
	}
        
	/*
     * Search Record
     */
	function SearchRecord($data=false,$sort='',$dataColumn=false){
		return $this->adodbx->search_record($this->tbl,$data,$sort,$dataColumn);
	}
	
	function SearchRecordWhere($where=false,$sort='',$dataColumn=false){
		return $this->adodbx->search_record_where($this->tbl,$where,$sort,$dataColumn);
	}
	
	function GetLastID(){
		return $this->adobx->LastIDPostgresql($this->tbl);
	}
	
	function SearchRecordLimit($data=false,$rows=false,$offset=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_by_limit($this->tbl,$data,$rows,$offset,$sort,$dataColumn);
        
    }
    
    function SearchRecordLimitWhere($where=false,$rows=false,$offset=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_by_limit_where($this->tbl,$where,$rows,$offset,$sort,$dataColumn);
    }
	
	
	function listDBDriver(){
		return $this->conn->GetAll("select db_driver as id,db_driver as name from m_db_driver order by num_order");
	}
	
	function setActiveFlag($idx,$flag=1){
		 $data["active"]=$flag;
		 return $this->Update($data,"idx=$idx");
	}
	
	
	function setDefaultFlag($idx,$flag=1){
		 $data["default_flag"]=$flag;
		 return $this->Update($data,"idx=$idx");
	}
	    
	
}