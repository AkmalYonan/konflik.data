<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lauth{

 function __construct()
 {
     $CI =& get_instance();

     //load libraries
     $this->conn=$CI->conn;
	 //$CI->load->library("session");
     //$this->session=$_SESSION;
	 $this->appname=$CI->config->item("appname");

	 $this->identity=$CI->config->item("identity");
	 $this->user_id=$CI->config->item("user_id");
	 $this->password=$CI->config->item("password");
	 $this->user_table=$CI->config->item("user_table");
	 $this->group_table=$CI->config->item("group_table");
	 $this->user_groups=$CI->config->item("user_groups");
 }
 
 function get_appname(){
 	return $this->appname;
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
	 	  //$userID=$CI->session->userdata("user_id");
		  // $userID=$_SESSION[$this->appname]["userdata"]["user_id"];
          // $query = $this->conn->GetRow("select * from t_user where user_id=?",array($userID));
          // return $query;
		  $userID=$_SESSION[$this->appname]["userdata"]["user_id"];
          $query = $this->conn->GetRow("select * from ".$this->table_user." where ".$this->user_id."=?",array($userID));
          return $query;
     }
 }
 
 function get_groupdata(){
 	 $CI =& get_instance();
     if( ! $this->logged_in())
     {
         return false;
     }
     else
     {
	 	 $idUser=$_SESSION[$this->appname]["userdata"]["id"];
         $arrDB=$this->conn->GetAll("select * from ".$this->user_groups." a left join ".$this->group_table." b on a.group_id=b.id where a.user_id=".$idUser); 
		 return $arrDB;
	 }
 }
 
 function get_users_groups($user_id) {
	 $arrDB=$this->conn->GetAll("select * from ".$this->user_groups." a left join ".$this->group_table." b on a.group_id=b.id where a.user_id=".$user_id); 
	 return $arrDB;
 }
 
 function groups($key=false,$val=false) {
	 $arrDB=$this->conn->GetAll("select * from ".$this->group_table); 
	 
	 if (!$key && !$val) {
		 return $arrDB;
	 }
	 else {
		 if (cek_array($arrDB)) {
			foreach($arrDB as $k=>$v) {
				$arr[$v[$key]]=	$v[$val];
			}
			return $arr;
		 }
	 }
 }
 
 
 //CHECKER
 function username_check($username = '')
 {
	if (empty($username))
	{
		return FALSE;
	}
	
	$row=$this->conn->GetOne("select ".$this->user_id." from ".$this->user_table." where ".$this->user_id."=?",array($username));
	if(!$row) {
	 	return FALSE;
	} else {
		return $row;
	}

  }
 
 
 //MAIN FUNCTIONAL
 function logged_in()
 {
     $CI =& get_instance();
     //return ($CI->session->userdata("user_id")) ? true : false;
	 return (isset($_SESSION[$this->appname]["userdata"]["user_id"])) ? true : false;
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
	 //$row=$this->conn->GetRow("select * from t_user where user_id=? and password=?",array($user_id,$password));
	 //echo $user_id.b64encode($password);exit;
	 $row=$this->conn->GetRow("select * from ".$this->user_table." where ".$this->user_id."=? and ".$this->password."=?",array($user_id,$password));
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
         $this->conn->AutoExecute($this->user_table,$data,"UPDATE","user_id='$userID'");

         //store user id in the session
         //$CI->session->set_userdata("user_id", $row["user_id"]);
		 //$CI->session->set_userdata("user", $row);
		 //$_SESSION["userdata"]["user_id"]=$row["user_id"];
		 //$_SESSION["userdata"]["user"]=$row;
		 $_SESSION[$this->appname]["userdata"]=$row;
		 $_SESSION[$this->appname]["userdata"]["user_id"]=$row[$this->user_id];
		 //$_SESSION[$this->appname]["userdata"]["user"]=$row;
		 $_SESSION[$this->appname]["groupdata"]=$this->get_users_groups($row["id"]);
		 return true;
     }
 }
 
 function register($data=array())
 {
     $CI =& get_instance();
	 if ($this->user_id=='username' && $this->username_check($data['username'])) {
		 return false;
	 }
	 
	 if ($this->user_id=='email' && $this->email_check($data['email'])) {
		 return false;
	 }
	 
	 $data['confirm_password'] = b64encode($data['password']);
	 $data['confirm_password'] = b64encode($data['confirm_password']);
	 $data['active'] = $data['active']?1:0;
	
	 $this->conn->AutoExecute($this->user_table,$data,"INSERT");
 }

 function logout()
 {
     $CI =& get_instance();
     //$CI->session->unset_userdata("user_id");
	 //$CI->session->unset_userdata("user");
	 //$CI->session->unset_userdata();
	 //$CI->session->sess_destroy();;
	 if(isset($_SESSION[$this->appname])):
	 	unset($_SESSION[$this->appname]);
	 endif;
	 //session_unset();
	 //session_destroy();
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

	function next_login() {
		$this->load->library('bcrypt');
		
		$password="admin";
		$hashed_bcrypt = $this->bcrypt->hash($password);
		pre($hashed_bcrypt);
		$salt_length=-10;
		CRYPT_BLOWFISH or die ('No Blowfish found.');
		$Blowfish_Pre = '$2a$05$';
		$Blowfish_End = '$';
		// PHP code you need to register a user
		// Blowfish accepts these characters for salts.
		$Allowed_Chars =
		'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
		$Chars_Len = 63;
		// 18 would be secure as well.
		$Salt_Length = 18;
		$mysql_date = date( 'Y-m-d' );
		$salt = "";
		
		for($i=0; $i<$Salt_Length; $i++)
		{
			$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
		}
		$salt = substr(md5(uniqid(rand(), true)), 0, $salt_length);
		pre($salt);
		$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
		$hashed_password = crypt($password, $bcrypt_salt);
		pre($hashed_password);
		
		$password2="admin";
		$saltdb=$salt;
		$passdb = $hashed_password;
		$hashed_pass2 = crypt($password2, $Blowfish_Pre . $saltdb . $Blowfish_End);
		pre($hashed_pass2);
		if ($hashed_pass2 == $passdb) {
			echo 'Password verified!';
		} else {
			echo 'There was a problem with your user name or password.';
		}
		
		if ($this->bcrypt->verify($password2,$hashed_bcrypt))
		{
			echo 'Verified';
		}	
	}
 
}
