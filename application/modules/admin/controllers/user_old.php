<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends Admin_Controller {

    function __construct(){
        parent::__construct();
        
        $this->load->helper(array('form', 'url','file','language','lookup','bootstrap_helper'));
    	$this->folder="admin/";
		$this->module=$this->folder."user/";
        $this->http_ref=base_url().$this->module;
		$this->module_title="User";
		$this->lang->load('auth');
       // $this->load->model("user_model");
       // $this->model=$this->user_model;
		$this->tbl_idx="id";
		$this->auth_error_page="admin/error_page";
    }
	
	function index(){
        if (!$this->cms->has_view($this->module)) redirect ($this->auth_error_page);
	   	$this->load->library('pagination');  
            
        $queryString=rebuild_query_string();
        
        $field="first_name,last_name,username";
        $whereSql=get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
        
        $whereSql="";
        
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        // debug();
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"10";
        $data["perPage"]=$perPage;

        $uriSegment=4;
        $totalRows=$this->lat_auth->total_users($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by id";
        

        $config['base_url'] = $this->module."index";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        //$config['display_pages'] = FALSE;
        $this->pagination->initialize($config);
        // pre($arrData);exit;
		
		$data["arrData"]=$this->lat_auth->users($whereSql,$perPage,$offset,$sortBy);

		$data["acc_active"]=$this->acc_active;
        $data["content"]=$this->load->view($this->module."user_list2",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
    function add(){
        if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);

        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
			$empty[]="";
        endif;
        //debug();
        if($act=="create"):
            $data=get_post();

			if ($this->lat_auth->register($data)) :
				redirect($this->module);
			else:
				$data['data']=$data;
			endif;
        endif;
		$data["content"]=$this->load->view($this->module."user_add2",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
    
     function edit($id){
        if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);
		
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
           	$data["data"]=$this->lat_auth->user($id);
        endif;
        if($act=="update"):
            $data=get_post();
			if ($this->lat_auth->update_user($data['id'],$data)):
				redirect($this->module."edit/".$id);
			else:
				$data['data']=$data;
			endif;
        endif;
		$data["content"]=$this->load->view($this->module."user_edit2",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
    function delete($id){
        if (!$this->cms->has_admin($this->module)) redirect ($this->auth_error_page);

        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):debug();
           	$data["data"]=$this->lat_auth->user($id);
        endif;
        if($act=="delete"):
            $data=get_post();
			if ($this->lat_auth->delete_user($data['id'],$data)):
				redirect($this->module);
			else:
				$data['data']=$data;
			endif;
        endif;
		$data["content"]=$this->load->view($this->module."user_delete2",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
    
    function _proses_message($ok,$url_ok=false,$url_error=false){
        $url_ok=$url_ok?$url_ok:$this->module;
        $url_error=$url_error?$url_error:$this->module;
        if(!$this->input->is_ajax_request()):    
            if($ok):
                    set_message("success", $this->msg_ok);
                    redirect($url_ok);
            else:
                    set_message("error",$this->msg_fail);
                    redirect($url_error);
            endif;  
        else:
            if($ok):
                 print "ok";
            else:
                print "failed";
            endif;    
        endif;
    }
    
    function _render_page($view, $data=null, $render=false)
    {
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $render);
        if($render):
            $datam["acc_active"]=$this->acc_active;
            $datam["content"]=$view_html;
            $this->load->view("admin_layout/main_layout",$datam);
        endif;
        //if (!$render) return $view_html;
    }
	
	function activate($id){
		$this->msg_ok="Activate successfully";
        $this->msg_fail="Unable to activate user";
		$id=$this->encrypt_status==TRUE?decrypt($id):$id;
		
		$dataUpdate["active"]=1;
		$this->conn->StartTrans();
		$this->model->UpdateData($dataUpdate,"id=$id");
		$ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."",$this->module."");
	}
	
	function deactivate($id){
		$this->msg_ok="Deactivate successfully";
        $this->msg_fail="Unable to deactivate user";
		$id=$this->encrypt_status==TRUE?decrypt($id):$id;
		
		$dataUpdate["active"]=0;
		$this->conn->StartTrans();
		$this->model->UpdateData($dataUpdate,"id=$id");
		$ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."",$this->module."");
	}
	
	
}
