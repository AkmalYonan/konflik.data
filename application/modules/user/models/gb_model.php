<?php

class gb_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'cms_guest_book';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
}
