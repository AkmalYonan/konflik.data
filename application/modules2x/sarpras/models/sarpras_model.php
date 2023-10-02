<?php

class sarpras_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= '';
	public $tbl_kab = '';
	public $tbl_prop = '';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
        
	}
	//ATTR
	function attr_get($name){
		$tbl = "select * from m_".$name." limit 0,13";
		return $this->conn->GetAll($tbl);
    }
	function attr_get2($name){
		$tbl = "select * from m_".$name." limit 14,30";
		return $this->conn->GetAll($tbl);
    }
	function attr_insert($name,$data) {
		$tbl = "attr_".$name;
		$ret=$this->adodbx->Insert($tbl,$data);
		return $ret;
	}
	function attr_update($name,$data,$where) {
		$tbl = "attr_".$name;
		$ret=$this->adodbx->Update($tbl,$data,$where);
		return $ret;
	}
	function attr_delete($name,$where){
		$tbl = "attr_".$name;
        return $this->adodbx->Delete($tbl,$where);
    }
	function attr_idx_by_id($name,$id,$id_txt=false) {
		$idx=$id_txt?$id_txt:"idx";
		$tbl = "attr_".$name;
		$sql = "select ".$idx." as value from ".$tbl." where id_kecamatan='".$id."'";
		return $this->conn->GetOne($sql);	
	}
	function attr_last_idx($name,$id_txt=false) {
		$idx=$id_txt?$id_txt:"idx";
		$tbl = "attr_".$name;
		$sql = "select max($idx) as value from ".$tbl;
		return $this->conn->GetOne($sql);	
	}
	
}
