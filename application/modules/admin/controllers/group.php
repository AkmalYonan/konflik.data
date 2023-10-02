<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class group extends Admin_Controller {

    function __construct(){
        parent::__construct();
        
        $this->load->helper(array('form', 'url','file','language','lookup','bootstrap_helper'));
    	$this->folder="admin/";
		$this->module=$this->folder."group/";
        $this->http_ref=base_url().$this->module;

		$this->parent_module_title="Account Manager";
		$this->module_title="Group";
		$this->lang->load('auth');
       // $this->load->model("user_model");
       // $this->model=$this->user_model;
		$this->tbl_idx="id";
		$this->auth_error_page="admin/error_page";

		$empty[]="";
		$this->lookup_tipe_org=$empty+lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","","order by order_num");
		$this->lookup_tipe_wil=$empty+lookup("m_group_wilayah","ur_tipe_wil","ur_tipe_wil","","order by order_num");
    }
	
	function index(){
		//if (!$this->cms->has_view($this->module)) redirect ("admin/error");
   		//debug();
		$this->load->library('pagination');  
            
        $queryString=rebuild_query_string();
        
        $field="name,description";
        $whereSql=get_where_from_searchbox($field);

		
		$filter="";$op="";
		$key = ($this->input->get_post('q'))?$this->input->get_post('q'):false;
		if ($key) {
			//$filter = "(nik like '%".$key."%' or nama like '%".$key."%')";
			$where[]="(".$whereSql.")";
			$data["key"]=$key;
		}
		if(cek_array($where)):
            $filter=join(" and ",$where);
        endif;
		$data["tab_active"]=$this->input->get_post('t');
		
		//$data['sumData']=$this->pv_summary_model->sum_wilayah($kd_prop,$kd_kab,$kd_kec,$kd_desa);
		//$data['sumPv']=$this->pv_summary_model->jumlah_target_pv($filter);
		
		
		$perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"50";
        $data["perPage"]=$perPage;

        $uriSegment=4;
        $totalRows=$this->lat_auth->total_groups($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
		$sortBy = 'order by id';
		if ($forder) {
			$spl = preg_split("/:/",$this->input->get_post('forder'));
			$sortBy = 'order by '.$spl[0].' '.$spl[1];
			$data["forder"]=$spl[0];
			$data["dorder"]=$spl[1];
		}
        $config['base_url'] = $this->module."index";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=str_replace("t=0","t=".$this->input->get_post('t'),$queryString);
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		
		//get data
		//$arrDB=$this->model->SearchRecordLimitWhere($filter,$perPage,$offset,$sortBy);
		$arrDB=$this->lat_auth->list_groups($filter,$perPage,$offset,$sortBy);
				
		$data["query_str"]=$queryString;
		$data["arrData"]=$arrDB;
		
		
		$data["content"]=$this->load->view($this->module."v_list",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
	}
		
		function check() {
			
		}
    
    function add(){
        //if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);
				$data=get_post();
        $act=$this->input->post("act")?$this->input->post("act"):"";  
				  
        if(empty($act)):
            $data=array();
        endif;
        //debug();
        if($act=="create"):
            
				if ($data['tipe_wilayah']) $data['name']=$data['name']." ".$data['tipe_wilayah'];
					if (!$this->lat_auth->group_check($data['name'])) {
						$this->lat_auth->add_group($data);
						redirect($this->module);
					}
        endif;
				$data["content"]=$this->load->view($this->module."v_add",$data,true);
				$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
    
     function edit($id){
        //if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);
		//debug();
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
           	$data["data"]=$this->lat_auth->group($id);
        endif;
        if($act=="update"):
            $data=get_post();
						if ($data['tipe_wilayah']) $data['name']=$data['name']." ".$data['tipe_wilayah'];
						if (!$this->lat_auth->group_check($data['name'],$data['id']) && $this->lat_auth->update_group($data['id'],$data)):
							redirect($this->module."edit/".$id);
						else:
				$data['data']=$data;
			endif;
        endif;
		$data["content"]=$this->load->view($this->module."v_edit",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
	//Lat Auth udah mendeteksi $this->encrypt_status, jadi masukkan id apa adanya
	function del($id=false){
  		//if (!$this->cms->has_admin($this->module)) redirect ("admin/error");
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
      	
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data["data"]=$this->lat_auth->group($id);
        endif;
        if($act=="delete"):
			$data=get_post();
			$id=$data['id'];
			
			$data=$this->lat_auth->group($id);
            $ok=$this->lat_auth->delete_group($id,$data);
            $this->_proses_message($ok,$this->module,$this->module."del/$id_enc");
        endif;
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
