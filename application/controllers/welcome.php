<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function main_layout(){
		$this->load->view("main_layout");
	}
    
    public function wg_test(){
       pre(modules::load('wg/wg')->get_visitor_counter(FALSE));
    }
	
	public function wg_test3(){
       modules::load('wg/wg')->get_visitor_counter(TRUE);
    }
	
	public function wg_test2(){
        echo modules::run('wg/wg/get_visitor_counter',TRUE,TRUE);
    }
    
    public function visitor_online(){
        //echo modules::run('wg/wg/get_visitor_online',TRUE);
        pre(modules::load('wg/wg')->get_visitor_online(TRUE));
    }
	
	
	public function test_db(){
		//$conn=$this->conn;
		$conn=get_db_config("esirs");
		$conn->debug=true;
		$sql="select * from airport";
		$arr=$conn->GetAll($sql);
		pre($arr);
	}


	public function test_db2(){
		//$conn=$this->conn;
		debug();
		get_db_config("esirs")->search_record("air_port");
		//$this->connf["esirs"]->search_record("airport"));
	}
    
    
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */