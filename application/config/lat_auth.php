<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config["site_key"]					="WhogetOyHacRoon1i93k3";
$config["appname"]					="lingkar_frame";
$config['app_timeout']    			= false;            // true kalo pengen make build-in timeout aplikasi
$config['timeout']    			   	= 60*100;            	// session expired
	
$config["identity"]					="username";		// A database column which is used to login with
$config["password"]					="password";

$config["tables"]["user"]			="adm_users";
$config["tables"]["group"]			="adm_groups";
$config["tables"]["user_groups"]	="adm_users_groups";


$config['hash_method']    			= 'bcrypt';			// IMPORTANT: Make sure this is set to either sha1 or bcrypt
$config['default_rounds'] 			= 8;				// This does not apply if random_rounds is set to true
$config['salt_length'] 	  			= 10;
$config['store_salt'] 	  			= false;
	
$config['multiple_groups'] 			= false;

$config['remember_me']            	= true;             // Allow users to be remembered and enable auto-login
$config['remember_expire']          = 86500;            // How long to remember the user (seconds). Set to zero for no expiration
$config['remember_extend']       	= false;            // Extend the users cookies everytime they auto-login
