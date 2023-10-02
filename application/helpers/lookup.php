<?php

function m_lookup($tbl,$id_key="",$name="",$where=""){
	$tmp_arr=data_lookup("m_".$tbl,$where);
    $tmp_lookup_map=array();
    $tmp_lookup_map["key"]=empty($id_key)?"id_$tbl":$id_key;
    $tmp_lookup_map["value"]=empty($name)?"name":$name;
    return get_lookup($tmp_arr,$tmp_lookup_map);
}

function data_lookup($tbl,$where=''){
	$ci=& get_instance();
	$data=$ci->adodbx->search_record_where($tbl,$where);
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