<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends MY_Controller {
	function __construct(){
		parent::__construct();

	}
	public function index()
	{
		if(!$this->lat_auth->logged_in()):
			$this->load->view($this->admin_layout.'/login/index');
		else:
			redirect("admin/dashboard");
		endif;
	}
	public function login(){
		$user=$this->input->post("uid",true);
		$pass=$this->input->post("pwd",true);
		$user=$user?$user:"";
		$pass=$pass?$pass:"";
		set_flash("uid",$user);
		set_flash("pass",$pass);

		$remember=$this->input->post("remember",true);

		if(empty($user)):
			set_message("error","User Name tidak boleh kosong!!");
			redirect("admin");
		endif;
		if(empty($pass)):
			set_message("error","Password tidak boleh kosong!!");
			redirect("admin");
		endif;
		/*
		if(empty($cap)):
			set_message("error","Isi captcha sesuai dengan gambar!!");
			redirect("login");
		endif;
		*/
		/*
		$code=$_SESSION["captcha"]["code"];
		if(strtolower($code)!=strtolower($cap)):
			set_message("error","Isi captcha sesuai dengan gambar!!");
			redirect("login");
		endif;
		*/
		//$password = $this->ion_auth_model->hash_password($this->input->post('pwd'));
		if ($this->lat_auth->login($user,$pass,$remember)):

			// debug();
			//$_SESSION[$this->lat_auth->appname]["userdata"]["user"];
			//$_SESSION[$this->lat_auth->appname]["groupdata"]=$this->conn->GetRow("select * from adm_groups where id=".$_SESSION[$this->lat_auth->appname]["userdata"]["user"]["group_brwa"]);
			// pre($_SESSION[$this->lat_auth->appname]["userdata"]["user"]);exit;
			//$_SESSION[$this->lat_auth->appname]["leveldata"]=$this->conn->GetRow("select * from tb_user_level where kd_level=".$userSess["user_level_id"]);
		endif;

		if(!$this->lat_auth->logged_in()):
			redirect("admin");
		else:
			redirect("admin/dashboard");
		endif;
	}

	function logout()
	{
		/*
	    $this->session->sess_destroy();
		session_unset();
		session_destroy();
		redirect('login');
		*/
		$this->lat_auth->logout();
		redirect('admin');
	}

	function error_page($code='401',$text='Unauthorized') {
		$data['error_code'] = $code;
		$data['error_text'] = $text;
		$this->load->view($this->module."/error",$data);
	}

}
