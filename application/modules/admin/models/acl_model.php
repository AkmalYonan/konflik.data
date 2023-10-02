<?php

class acl_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	 
	public $tbl= '';

	function __construct(){
		parent::__construct();
		$this->tbl_groups="adm_groups";
        $this->tbl_rights="cms_rights";
		$this->tbl_modules="cms_module";
		$this->tbl_group_to_modules="groups_2_cms_module";
		
	}
    
    function get_rights(){
        $arrRights=$this->adodbx->search_record($this->model->tbl_rights);
        return $arrRights;
    }
    
    function get_groups(){
        $arrGroups=$this->adodbx->search_record($this->model->tbl_groups);
        return $arrGroups;
    }
    
    function get_modules(){
        $find["active"]=1;
        $arrModules=$this->adodbx->search_record($this->model->tbl_modules,$find);
        return $arrModules;
    }
    
    function get_groups_to_modules(){
        $arrGroup2Modules=$this->adodbx->search_record($this->model->tbl_group_to_modules);
        return $arrGroup2Modules;
    }
	
}

