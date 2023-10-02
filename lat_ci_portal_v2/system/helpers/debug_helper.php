<?php 

function pre($str,$array_flag=TRUE){
	echo "<pre>";
	if($array_flag):
		print_r($str);
	else:
		echo $str;
    endif;
	echo "</pre>";
}

function debug($status=TRUE){
	$CI=&get_instance();
	$CI->conn->debug=$status;
}
