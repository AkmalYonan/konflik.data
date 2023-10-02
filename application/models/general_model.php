<?php

class general_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= '';

	function __construct($tbl=""){
		parent::__construct();
		$this->tbl=$tbl;
		$this->db=$this->conn;
	}
	
}
