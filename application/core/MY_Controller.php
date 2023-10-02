<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
 	function __construct()
 	{
  		parent::__construct();
		$this->msg_ok="Data Saved Successfully!!";
        $this->msg_fail="Unable to save data!!";
		$this->main_layout="main_layout";
		$this->data=array();
		$this->acc_active="";
		$this->arrBread=array();
		
		//AUTHENTICATION LIBRARY
		//$this->load->library('lat_auth');
		$this->appname = $this->lat_auth->appname;
		$this->admin_layout = $this->config->item('admin_theme');
		$this->public_layout = $this->config->item('public_theme');
		
    }
	
	
	public function info(){
		print get_class($this);
		print get_parent_class($this);
        echo $this->db->platform();
	}
		
	/* adding creator and editor  to data */
	function _add_creator($data){
        $data["created"]=date("Y-m-d H:i:s");
        $data["creator"]=$this->userdata["username"];
		//$data["creator"]=$this->data["users"]["user"]["username"];
        $data["edited"]=date("Y-m-d H:i:s");
		$data["editor"]=$this->userdata["username"];
        //$data["editor"]=$this->data["users"]["user"]["username"];
        return $data;
    }
    
    function _add_editor($data){
        $data["edited"]=date("Y-m-d H:i:s");
        //$data["editor"]=$this->data["users"]["user"]["username"];
		$data["editor"]=$this->userdata["username"];
        return $data;
    }
	
	function _add_ip_address($data){
		//$data["ip_client"]=$this->input->ip_address();
		$data["ip_client"]=$this->_prepare_ip($this->input->ip_address());
		$data["ip_address"]=$data["ip_client"];
		return $data;
	}
	
	
	function _prepare_ip($ip_address) {
	    if ($this->conn->databaseType === 'postgre' || $this->conn->databaseType === 'sqlsrv' || $this->conn->databaseType === 'mssql')
        {
            return $ip_address;
        }
        else
        {
            return inet_pton($ip_address);
        }
       
    }
	
	function _proses_message($ok,$url_ok=false,$url_error=false){
        $url_ok=$url_ok?$url_ok:$this->module;
        $url_error=$url_error?$url_error:$this->module;
        if(!$this->input->is_ajax_request()):    
            if($ok):
                    set_message("info", $this->msg_ok);
                    redirect($url_ok);
            else:
                    set_message("error",$this->msg_fail);
                    redirect($url_error);
            endif;  
        else:
            if($ok):
                set_message("info", $this->msg_ok);    
                 print "ok";
            else:
                set_message("error",$this->msg_fail);
                print "failed";
            endif;    
        endif;
    }
	
	function _render_page($view, $data=null, $render=false)
    {
		
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $render);
        if($render):
			$datam["arrBread"]=$this->arrBread;
            $datam["acc_active"]=$this->acc_active;
            $datam["content"]=$view_html;
            $this->load->view($this->main_layout,$datam);
        endif;
    }
    
}
