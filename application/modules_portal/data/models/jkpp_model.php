<?php

class jkpp_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 't_daftar_wikera';

	function __construct(){
		parent::__construct();
		$this->tbl=$tbl;
		$this->db=$this->conn;
	}

	public function gov($idx_p,$fg){
		$sql='select uraian,flag from t_involved where idx_parent="'.$idx_p.'" and flag="'.$fg.'"';
		$arr=$this->conn->GetAll($sql);
		return $arr;
	}
	public function pt($idx_p,$fg){
		$sql='select uraian,flag from t_involved where idx_parent="'.$idx_p.'" and flag="'.$fg.'"';
		$arr=$this->conn->GetAll($sql);
		return $arr;
	}
	public function comm($idx_p,$fg){
		$sql='select uraian,flag from t_involved where idx_parent="'.$idx_p.'" and flag="'.$fg.'"';
		$arr=$this->conn->GetAll($sql);
		return $arr;
	}
}