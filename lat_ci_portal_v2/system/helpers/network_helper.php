<?php
// Function to get the client ip address
function get_client_ip_env() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = "UNKNOWN";

	return $ipaddress;
}

// Function to get the client ip address
function get_client_ip() {
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';

	return $ipaddress;
}

function get_ip_address(){
	$CI=& get_instance();
	$ip=$CI->input->ip_address();
	if($CI->input->valid_ip($ip)):
		$ret= $CI->input->ip_address();
	else:
		$ret=get_client_ip();
	endif;
	return $ret;
}


//SELECT INET_ATON('10.0.5.9');
//SELECT INET_NTOA(167773449);
function inet_ntoa($i)
{
        $long = 4294967295 - ($i - 1);
        return long2ip(-$long);
}


function inet_aton($ip)
{
    return sprintf("%u", ip2long($ip));
}


function set_editor_ip(&$data){
	$ip=get_client_ip();
	//$data["editor_ip"]=inet_aton($ip);
	$data["editor_ip"]=$ip;
}

function set_creator_ip(&$data){
	$ip=get_client_ip();
	//$data["creator_ip"]=inet_aton($ip);
	$data["creator_ip"]=$ip;
}


/* Using IT 
	$ip=get_client_ip();
	print $ip."<br>";
	print inet_aton($ip)."<br>";
	print inet_ntoa(inet_aton($ip))."<br>";
	
*/


//get ip2long and long2ip for restore


?>
