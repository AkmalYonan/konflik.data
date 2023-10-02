<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_db_config($config_group=""){
	$ci=& get_instance();
	$serverID=$config_group!=""?$config_group:"default";
	$ci->connf[$serverID]=isset($ci->connf[$serverID])?$ci->connf[$serverID]:false;
	if(!$ci->connf[$serverID]):
		$ci->load->library("adodb_factory_config");
		$ret=adodb_factory_config::factory($config_group);
		return $ret;
	endif;
	return $ci->connf[$serverID];
	
}

function get_dbfactory_config($config_group=""){
		$ci=& get_instance();
		$serverID=$config_group!=""?$config_group:"default";
		$ci->dbfactory[$serverID]=isset($ci->dbfactory[$serverID])?$ci->dbfactory[$serverID]:false;
		if(!$ci->dbfactory[$serverID]):
			$ci->load->library("adodb_factory_config");
			$ret=adodb_factory_config::factory($config_group);
			if($ret!=false):
				$ret=$ci->dbfactory[$config_group];
			endif;
			return $ret;
		endif;
		return $ci->dbfactory[$serverID];
	}