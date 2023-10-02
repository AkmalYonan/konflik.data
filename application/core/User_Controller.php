<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class User_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		
		$this->load->library('ion_auth');
    	if (!$this->ion_auth->logged_in())
		{
			//$this->session->set_flashdata('message', 'You must be an admin to view this page');
			//redirect them to the login page
			//redirect('user/auth/login', 'refresh');
		}/*elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		{
			//$this->session->set_flashdata('message', 'You must be an admin to view this page');
			$this->ion_auth->set_message("You must be an admin to view this page");
			redirect('admin/auth/login', 'refresh');
			//show_error('Shove off, this is for admins.');
		}*/
		else{
			$obj=$this->ion_auth->user()->result_array();
			$arr=(array)$obj;
			$this->data['users']["user"] =$arr[0]; 
			$this->data['users']["groups"]=$this->ion_auth->get_users_groups($arr["id"])->result_array();
		}
		
		//$this->load->library("cms");
		//$this->cms->init();
		
		/*
        if($this->ion_auth !== 'admin')
        {
            show_error('Shove off, this is for admins.');
        }*/
		$this->load->model("user/messaging_model");
        $this->model=$this->messaging_model;
		
		$this->get_unread_message();
	}
	
	function get_unread_message($forder=0,$limit=5,$page=1){
		//debug();
		$myname = $this->data['users']['user']['username'];
		$filter = "message_user='".$myname."' and status=1";
		$order = "ORDER BY waktu DESC";
		$this->list_unread_message=$this->model->new_list($filter);
		
		$filter = "message_user='".$myname."' and status=1";
		$new_message = false;
		$new_message = $this->model->user_new_message($filter);
		$this->num_unread_message = count($new_message);
		//$this->get_unread_message=$this->link_model->search_by_category(9,5,0);
	}
	function text_unread_message($forder=0,$limit=5,$page=1){
		$this->get_unread_message();
		echo $this->num_unread_message;
	}
	
}