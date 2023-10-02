<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_profile extends User_Controller {

    function __construct(){
        parent::__construct();
        
        $this->folder="user/";
		$this->module=$this->folder."user_profile/";
        $this->http_ref=base_url().$this->module;
        
        $this->load->model("user_profile_model","model");
		$this->load->library("utils");
		
		$this->layout="layout_pages/";
		
		$this->my_logged_data = $this->data['users']['user'];	
		$this->admin_layout="layout/main_layout";
    }
  	function edit($idx=false){
  		if ($idx!=$this->my_logged_data['id']) redirect ("admin/error");
		
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			//ion
			$user = $this->ion_auth->user($idx)->row();
			if ($_POST['image_name']) {
				$fix_name = "up_".$idx."_".time().substr($_POST['image_name'],strrpos($_POST['image_name'],"."));
				$tmp_name = $this->config->item('dir_tmp_pages_image').$_POST['image_name'];
				$new_name = $this->config->item('dir_pages_image').$fix_name;
				$avt_name = $this->config->item('dir_pages_image')."avatar_".$fix_name;
				if (file_exists($tmp_name)) {
					if (copy($tmp_name,$new_name)) {
						$headline_img=$fix_name;
						$this->utils->imgThumbnail($this->config->item('dir_pages_image'),$fix_name,74,74,'avatar_','resize');
						unlink($tmp_name);
						if ($_POST['image_name_old']) {
							unlink($this->config->item('dir_pages_image').$_POST['image_name_old']);
							unlink($this->config->item('dir_pages_image')."avatar_".$_POST['image_name_old']);
						}
						
					}
				}
			}
			$_data["first_name"]=$_POST['first_name'];
			$_data["last_name"]=$_POST['last_name'];
			$_data["email"]=$_POST['email'];
			$_data["phone"]=$_POST['phone'];
			
			if ($_POST['password']) {
				$_data["password"]=$_POST['password'];
				$pass_change_msg = " Password changed..  (affected in next login)";
			}
			
			$ion_update=$this->ion_auth->update($user->id, $_data);
			//print_r($_data);
			//exit;
			//debug();
			
			//echo $update;
			if ($ion_update) {
				if ($headline_img) {
					$avatar["image"]=$headline_img;
					$update = $this->model->UpdateData($avatar,"id='".$_POST['idx']."'");
				}
				set_message("success","Profile Saved.".$pass_change_msg);
				redirect("admin/user_profile/edit/".$_POST['idx']."?tab=1");

			}
		}
		else {
			$arrDB=$this->model->GetRecordData("id='{$idx}'");
			$data["data"]=$arrDB;
		}
		$data["acc_active"]="content";
		$data["module"]=$this->module;
		$data_layout["content"]=$this->load->view("user_profile/edit",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
  }
}