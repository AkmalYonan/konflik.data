<?php
class LAT_Model extends CI_Model {
	/**
	 * Set Table Name Here
	 */
	public $tbl= '';
	public $table='';
	
    
	function __construct($tbl=false){
		parent::__construct();
		$this->db=$this->conn;
		if($tbl):
			$this->tbl=$tbl;
		endif;
		$this->table=$this->tbl;
	}
	
	function SetTable($tbl){
		$this->tbl=$tbl;
		$this->table=$tbl;
	}
	    
    /**
     * GetRecord by id
     * @param int $id
     * @return array record
     */ 
    function GetRecordByID($id,$key=false){
		$key=$key?$key:"idx";
        return $this->GetRecord("$key={$id}");
    }
    
    /**
     * List All Data
	 * @param string $where
	 * @param string $sort
     * @return array record
     */ 
    function ListAll($where=false,$sort=false){
        return $this->SearchRecordWhere($where,$sort);
    }
    
    /**
     * Delete By ID
     * @param int $id
     * @return int affected rows
     */ 
    function DeleteByID($id,$key=false){
		$key=$key?$key:"idx";
        return $this->DeleteData("$key={$id}");
    }
    
    /**
     * Update By ID
     * @param int $id
     * @return int affectedrows
     */ 
    function UpdateByID($data,$id,$key=false){
		$key=$key?$key:"idx";
        return $this->UpdateData($data, "$key={$id}");
    }
    
    /*
     * Add data
     */
	function InsertData($data){
		return $this->adobx->Insert($this->tbl, $data);
	}
    
    
	/*
     * Update Data
     */
	function UpdateData($data,$where){
		return $this->adodbx->Update($this->tbl,$data,$where);
	}
    
	
	/*
     * Delete Data
     */
	function DeleteData($where){
		return $this->adodbx->Delete($this->tbl,$where);
	}
	    
    /*
     * Get Record List
     */
	function GetRecordData($where=false,$dataColumn=false){
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
	
	/*
	function GetLastID(){
		return $this->adobx->LastIDPostgresql($this->tbl);
	}
	*/
	
	function GetLastID($id_txt=false) {
		$idx=$id_txt?$id_txt:"idx";
		$sql = "select max($idx) as value from ".$this->tbl;
		return $this->conn->GetOne($sql);	
	}
	
	function SearchRecordLimit($data=false,$rows=false,$offset=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_by_limit($this->tbl,$data,$rows,$offset,$sort,$dataColumn);
        
    }
    
    function SearchRecordLimitWhere($where=false,$rows=false,$offset=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_by_limit_where($this->tbl,$where,$rows,$offset,$sort,$dataColumn);
    }
	
	public function __call($function, $args){
		if(method_exists($this->adodbx, $function)){
			return call_user_func_array(array($this->adodbx, $function), $args);
		}
		trigger_error("Unknown Error: $function()\n", E_USER_ERROR);
	}
	
	/* komeng added */
	function getTotalRecord($data=false){
		return $this->adodbx->total_rows($this->tbl,$data);
	}
	function getTotalRecordWhere($where=false,$selected_column='idx'){
		if ($where) $where=" where ".$where;
		$sql = "select count($selected_column) as total from ".$this->tbl.$where;
		return $this->conn->GetOne($sql);	
	}
	
	//tabel dengan field 'id'
	function getTotalRecordWhere2($where=false,$selected_column='id'){
		if ($where) $where=" where ".$where;
		$sql = "select count($selected_column) as total from ".$this->tbl.$where;
		return $this->conn->GetOne($sql);	
	}
	function total_rows_where($tbl,$where=false,$selected_column='idx'){
		if ($where): 
			$where=" where ".$where;
		endif;
		$sql = "select count($selected_column) as total from ".$tbl.$where;
		return $this->conn->GetOne($sql);	
	}
	/* end komeng added */

	//nambahin
	function category_add($data){
        $ret=$this->adodbx->Insert($this->tbl,$data);
        return $ret;
    }
    
    function category_update($data,$where){
        $ret=$this->adodbx->Update($this->tbl,$data,$where);
        return $ret;
    }
    
    function category_get($where,$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl,$where,$dataColumn);
    }
    
    function category_delete($where){
        return $this->adodbx->Delete($this->tbl,$where);
    }
    
    function category_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl,$data,$sort,$dataColumn);
    }
    
    function category_search_record_where($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->tbl,$where,$sort,$dataColumn);
    } 

	
}