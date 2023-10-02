<?php

class msg_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'cms_message';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
}
