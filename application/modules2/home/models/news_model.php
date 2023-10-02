<?php

class news_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'cms_news';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
}
