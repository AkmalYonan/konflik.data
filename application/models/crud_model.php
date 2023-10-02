<?php

class crud_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'tb_test';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
}
