<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function check_db_server($name='all',$json=true){
		if(ENVIRONMENT!='production'):
			error_reporting(0);
		endif;
		$obj =& get_instance();
		
		$obj->load->library("adodb_factory");
		$obj->load->model("db_server_model","model");
		if($name!='all'):
			$arrDB=$obj->model->SearchRecordWhere("db_server_id = '{$name}' and active=1");
		else:
			$arrDB=$obj->model->SearchRecordWhere("active=1");
		endif;
		
		
		$data=array();
		if(cek_array($arrDB)==true):
			
			foreach($arrDB as $x=>$val):
				$serverName=$val["db_server_id"];
				adodb_factory::factory($val);
				
				//get status
				$status=$obj->dbstatus[$serverName];
				$val["status"]=$status;
				
				if($status==true):
					$ret["status"]="ok";
					$ret["message"]="Server OK";
					
				else:
					$ret["status"]="not ok";
					$ret["message"]="nama server tidak ada";
				endif;	
				$data[]=$val;
			endforeach;
			$ret["data"]=$data;
		else:
			
			$ret["status"]="not ok";
			$ret["message"]="nama server tidak ada";
		endif;
		
		if(ENVIRONMENT!='production'):
			error_reporting(E_ALL);
		endif;
		
		if($json==true):	
			print json_encode($ret);
		else:
			return $data;
		endif;
	}
	
	
	function get_db($serverID,$conf=false){
		$ci=& get_instance();
		$ci->connf[$serverID]=isset($ci->connf[$serverID])?$ci->connf[$serverID]:false;
		if(!$ci->connf[$serverID]):
			$ci->load->library("adodb_factory");
			if(!$conf):
				$ci->load->model("db_server_model","server_model");
				$conf=$ci->server_model->GetRecord("db_server_id = '{$serverID}' and active=1");
			endif;
			$ret=adodb_factory::factory($conf);
			return $ret;
		endif;
		return $ci->connf[$serverID];
	}
	
	//same as above but familier syntax
	function get_conn($serverID,$conf=false){
		$ci=& get_instance();
		
		$ci->connf[$serverID]=isset($ci->connf[$serverID])?$ci->connf[$serverID]:false;
		if(!$ci->connf[$serverID]):
				$ci->load->library("adodb_factory");
			if(!$conf):
				$ci->load->model("db_server_model","server_model");
				$conf=$ci->server_model->GetRecord("db_server_id = '{$serverID}' and active=1");
			endif;
			$ret=adodb_factory::factory($conf);
			return $ret;
		endif;
		return $ci->connf[$serverID];
	}
	
	function set_dbconf($dbserverid,$dbhost,$dbport,$dbuser,$dbpassword,$dbdriver,$dbname){
		$conf["db_server_id"]=$dbserverid;
		$conf["db_host"]=$dbhost;
		$conf["db_port"]=$dbport;
		$conf["db_user"]=$dbuser;
		$conf["db_password"]=$dbpassword;
		$conf["db_driver"]=$dbdriver;
		$conf["db_name"]=$dbname;
		return $conf;
	}
	
	function get_dbfactory($serverID=false,$conf=false){
		$ci=& get_instance();
		$ci->dbfactory[$serverID]=isset($ci->dbfactory[$serverID])?$ci->dbfactory[$serverID]:false;
		if(!$ci->dbfactory[$serverID]):
			$ci->load->library("adodb_factory");
			if(!$conf):
				$ci->load->model("db_server_model","server_model");
				$conf=$ci->server_model->GetRecord("db_server_id = '{$serverID}' and active=1");
			endif;
			
			$ret=adodb_factory::factory($conf);
			if($ret!=false):
				$ret=$ci->dbfactory[$serverID];
			endif;
			return $ret;
		endif;
		return $ci->dbfactory[$serverID];
	}

