<?php

function m_lookup($tbl,$id_key="",$name="",$where="",$sort=""){
	$tmp_lookup_map=array();
    $tmp_lookup_map["key"]=empty($id_key)?"id_$tbl":$id_key;
    $tmp_lookup_map["value"]=empty($name)?"name":$name;
	$sort=empty($sort)?" order by ".$tmp_lookup_map["key"]:$sort;
    $tmp_arr=data_lookup("m_".$tbl,$where,$sort);
	return get_lookup($tmp_arr,$tmp_lookup_map);
}

function lookup($tbl,$id_key="",$name="",$where="",$sort=""){
	
	$tmp_lookup_map=array();
    $tmp_lookup_map["key"]=empty($id_key)?"id_$tbl":$id_key;
    $tmp_lookup_map["value"]=empty($name)?"name":$name;
	$sort=empty($sort)?" order by ".$tmp_lookup_map["key"]:$sort;
    $tmp_arr=data_lookup($tbl,$where,$sort);
	return get_lookup($tmp_arr,$tmp_lookup_map);
}

function data_lookup($tbl,$where='',$sort=""){
	$ci=& get_instance();
	$data=$ci->adodbx->search_record_where($tbl,$where,$sort);
	return $data;
}

function get_lookup($tmp_arr,$tmp_lookup_map){
	$data=array();
	$arrData=$tmp_arr;
	$key=$tmp_lookup_map["key"];
	$value=$tmp_lookup_map["value"];
	if(cek_array($arrData)):
		$data=array();
		foreach($arrData as $x=>$val):
			$datatmp=array();
			$data[$val[$key]]=$val[$value];
		endforeach;
	endif;
	
	return $data;
}