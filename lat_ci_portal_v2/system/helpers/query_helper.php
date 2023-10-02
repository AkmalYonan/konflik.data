<?php
function andWhere($wil,&$where){
	foreach($wil as $key=>$value):
		  if (($value != '')&&($value!=FALSE)):
				$whereArr[] = "$key = '$value'";
		  endif;
		endforeach;
		if (cek_array($whereArr)==TRUE):
		 	$where .= " " . implode(" AND ", $whereArr);
		endif;
	return $where;

}

function wrapKurung(&$str){
	$str= "( ".$str." )";
	return $str;
}

function orWhere($wil,&$where){
	foreach($wil as $key=>$value):
		  if (($value != '')&&($value!=FALSE)):
				$whereArr[] = "$key = '$value'";
		  endif;
		endforeach;
		if (cek_array($whereArr)==TRUE):
		 	$where .= " " . implode(" OR ", $whereArr);
		endif;
	return $where;

}

function orderBy($orderBy,&$where){
	$where.=$orderBy;
}

function having($having,&$where){
	$where.=$having;
}