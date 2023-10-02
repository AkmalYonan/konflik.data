<?php

class comments_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'cms_comments';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	
}

