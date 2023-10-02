<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Secure_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        /*$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
        if($this->data['user']['group'] !== 'admin')
        {
            show_error('Shove off, this is for admins.');
        }*/
		
	}
	
	
}