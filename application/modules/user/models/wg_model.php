<?php

class wg_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	 
	public $tbl= '';

	function __construct(){
		parent::__construct();
		$this->tbl_visitor_counter="cms_visitor_counter";
        $this->tbl_visitor_online="cms_visitor_online";
	}
    
	
}

