<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Public_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		
		/** Adding Comment
		sanitizeAllRequestData();
		**/
		
		$this->load->library('ion_auth');
        if($this->config->item('site_open') === FALSE)
        {
            show_error('Sorry the site is shut for now.');
        }
    	if ($this->ion_auth->logged_in())
		{
		
			$obj=$this->ion_auth->user()->result_array();
			$arr=(array)$obj;
			$this->data['users']["user"] =$arr[0]; 
			$this->data['users']["groups"]=$this->ion_auth->get_users_groups($arr["id"])->result_array();
			$this->user_data=$arr[0];
		}
		$this->load->model("user/link_manager_model");
        $this->link_model=$this->link_manager_model;
		
		//$this->load->model("admin/pp_model");
       // $this->pp_model=$this->pp_model;
		$this->public_layout = $this->config->item('public_theme');
		$this->render_footer();
    }
	
	
	function cleanInput($input) {
 
	  $search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	  );
 
		$output = preg_replace($search, '', $input);
		return $output;
	}
	
	function render_footer() {
		$this->footer_link_list();
		//$this->footer_pp_list();
	}
	function footer_link_list($forder=0,$limit=5,$page=1){
		$this->footer_link_list=$this->link_model->search_by_category(false,5,0);
	}
	function footer_pp_list($forder=0,$limit=5,$page=1){
		$this->footer_pp_list=$this->pp_model->category_search_record();
	}
}