<?php

class group_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'groups';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
    }
    
}

