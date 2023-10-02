<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class error extends Public_Controller {

	function __construct(){
        parent::__construct();
        
        $this->folder="admin/";
		$this->module=$this->folder."error/";
        $this->http_ref=base_url().$this->module;
    }
	
	function index($code='401',$text='Unauthorized') {
		$data['error_code'] = $code;
		$data['error_text'] = $text;
		$this->load->view($this->module."index",$data);
	}
	
}