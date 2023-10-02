<?php
if (!function_exists('GetServerURL')):
function GetServerURL(){
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol."://".$_SERVER['SERVER_NAME'].$port;   
}
endif;
if (!function_exists('strleft')):
function strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}
endif;
error_reporting(E_ALL);
$config=& get_config();
$base_url=$config["base_url"];
$url=GetServerURL().$base_url."error/error_404";
echo file_get_contents($url);