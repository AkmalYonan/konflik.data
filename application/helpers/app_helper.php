<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_pegawai_all($param=""){
		//if(!isset($_SESSION["data_pegawai"])):
    	$CI=& get_instance();
		$CI->load->library("rest");
    	$CI->rest->initialize($CI->config->item("hrms_service"));
		
		$arr = $CI->rest->get("pegawai/all.json?$param");
    	$arr=json_decode(json_encode($arr),true);
    	//$arr=rest_get("pegawai/all.json");
		
		//$_SESSION["data_unit_all"]=$arr;
		//else:
		//$arr=$_SESSION["data_unit_all"];
		//endif;
    	return $arr;
}


function rest_get($service_url){
	$CI=& get_instance();
	$settingUrl=$CI->config->item("hrms_service");
	$server=$settingUrl["server"];
	$ctn=file_get_contents("{$server}{$service_url}");
	$arr=json_decode($ctn,true);
	return $arr;
}

function get_server(){
	$CI=& get_instance();
	$settingUrl=$CI->config->item("hrms_service");
	$server=$settingUrl["server"];
	return $server;
}

