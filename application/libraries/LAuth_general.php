<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lauth{

 function __construct()
 {
     $CI =& get_instance();

     //load libraries
     $this->conn=$CI->conn;
	 $CI->load->library("session");
     $this->session=$_SESSION;
 }

 function get_userdata()
 {
     $CI =& get_instance();

     if( ! $this->logged_in())
     {
         return false;
     }
     else
     {
	 	  $userID=$CI->session->userdata("user_id");
          $query = $this->conn->GetRow("select * from t_user where user_id=?",array($userID));
          return $query;
     }
 }

 function logged_in()
 {
     $CI =& get_instance();
     return ($CI->session->userdata("user_id")) ? true : false;
 }

 function login($user_id, $password)
 {
     $CI =& get_instance();
	 /*
     $data = array(
         "email" => $email,
         "password" => sha1($password)
     );
	 */
	 $row=$this->conn->GetRow("select * from t_user where user_id=? and password=?",array($user_id,$password));
	 if(cek_array($row)!=TRUE)
     {
         return FALSE;
     }
     else
     {
         //update the last login time
         $last_login = date("Y-m-d H-i-s");

         $data = array(
             "last_login" => $last_login
         );
		 $userID=$row["user_id"];
         $this->conn->AutoExecute("t_user",$data,"UPDATE","user_id='$userID'");

         //store user id in the session
         $CI->session->set_userdata("user_id", $row["user_id"]);
		 $CI->session->set_userdata("user", $row);
		 $_SESSION["userdata"]["user_id"]=$row["user_id"];
		 $_SESSION["userdata"]["user"]=$row;
		 return true;
     }
 }

 function logout()
 {
     $CI =& get_instance();
     $CI->session->unset_userdata("user_id");
	 $CI->session->unset_userdata("user");
	 $CI->session->unset_userdata();
	 $CI->session->sess_destroy();;
	 unset($_SESSION["userdata"]);
	 session_unset();
	 session_destroy();
 }
 
 	function randomString($length = 50)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';    
			
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}
			
			return $string;
	}
	
	function hashData($data)
    {
		$CI=& get_instance();
		return hash_hmac('sha512', $data, $CI->config->item("site_key"));
	}
	
	function getToken(){
		//First, generate a random string.
		$random = $this->randomString();
        //Build the token
		$token = $_SERVER['HTTP_USER_AGENT'] .$random;
		$token = $this->hashData($token);
		return $token;
	}


 
}
