<?php
class ADODBX_Model extends CI_Model {
	/**
	 * Set Table Name Here
	 */
	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	
	public function __call($function, $args){
		if(method_exists($this->adodbx, $function)){
			return call_user_func_array(array($this->adodbx, $function), $args);
		}
		trigger_error("Unknown Error: $function()\n", E_USER_ERROR);
	}
	
	function total_rows_where($tbl,$where=false,$selected_column='idx'){
		if ($where): 
			$where=" where ".$where;
		endif;
		$sql = "select count($selected_column) as total from ".$tbl.$where;
		return $this->conn->GetOne($sql);	
	}
	/* end komeng added */

	


	    
	
}