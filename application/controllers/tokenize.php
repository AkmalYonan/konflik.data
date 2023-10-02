<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tokenize extends CI_Controller {
    
	
	public function index()
	{
		//test token
	}
	
	
	function get_token(){
		//$token=Token::createToken();
		//$cek=Token::checkToken($token);
		//echo $cek;
		$test=generate_key();
		//echo $test;
		echo GetIPAddress();
		//echo encrypt($test."-".time());
		
		
		
		//$token=generate_token("test");
		//pre(parse_token($token));
	}
	
	function cek_token($test){
		if(validate_key($test)):
			echo "true";
		else:
			echo "false";
		endif;	
	}
	
	function test_token(){
		echo bin2hex(openssl_random_pseudo_bytes(16));	
	}
	
	
    
    
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */