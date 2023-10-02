<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function page_redirect()
	{
		if( ! isset($_POST['redirect']))
		{
			redirect(current_url(), "location");
			return;
		}
	
		if($_POST['redirect'] === current_url())
		{
			redirect(current_url(), "location");
			return;
		}
	
		redirect($_POST['redirect'], "location");
	}