<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lat_auth extends CI_Controller {

 public function __construct()
 {
	 
	 $this->load->config('lat_auth', TRUE);
     $this->load->model('lat_auth_model');
	 
	 $this->appname=$this->config->item("appname","lat_auth");
	 $this->multiple_groups=$this->config->item("multiple_groups","lat_auth");
	 $this->timeout=$this->config->item("timeout","lat_auth");
	 
	 
	 if ($this->logged_in() && !get_cookie('identity') && !get_cookie('remember_code')) {
		 if (isset($_SESSION[$this->appname]['LAST_ACTIVITY']) && (time() - $_SESSION[$this->appname]['LAST_ACTIVITY'] > $this->timeout)) {
			 $this->timeout();
		 }
	 }
	 $_SESSION[$this->appname]['LAST_ACTIVITY'] = time(); // update last activity time stamp

	 if (!$this->logged_in() && get_cookie('identity') && get_cookie('remember_code')) {
		$this->lat_auth_model->login_remembered_user();
	 }
 }
 
 public function __call($method, $arguments)
	{
		if (!method_exists( $this->lat_auth_model, $method) )
		{
			throw new Exception('Undefined method Lat_auth::' . $method . '() called');
		}

		return call_user_func_array( array($this->lat_auth_model, $method), $arguments);
	}
 public function __get($var)
	{
		return get_instance()->$var;
	}	
	
 function get_appname(){
 	return $this->appname;
 }

 function get_userdata()
 {
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
 
 
 //MAIN FUNCTIONAL
 function logged_in()
 {
	 return (isset($_SESSION[$this->appname]["userdata"]["user_id"])) ? true : false;
 }


 function logout()
 {
     //$CI =& get_instance();
     //$CI->session->unset_userdata("user_id");
	 //$CI->session->unset_userdata("user");
	 //$CI->session->unset_userdata();
	 //$CI->session->sess_destroy();;
	 if (get_cookie('identity')) {
		delete_cookie('identity');
	 }
	 if (get_cookie('remember_code')) {
		delete_cookie('remember_code');
	 }

	 if(isset($_SESSION[$this->appname])):
	 	unset($_SESSION[$this->appname]);
	 endif;
	 //session_unset();
	 //session_destroy();
 }
 
 function timeout() {
	 set_message("error","<i class='fa fa-exclamation-circle'></i> No Activity in ".$this->timeout." seconds!!");
	 set_flash("LAST_URL",$_SERVER['PATH_INFO']);
	 $this->logout();
 }
}
