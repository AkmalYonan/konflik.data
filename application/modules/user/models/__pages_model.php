<?php

class pages_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'cms_pages';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
        
	}
}
