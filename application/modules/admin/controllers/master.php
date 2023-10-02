<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class master extends Admin_Controller {
	var $arr_category=array();   
    function __construct(){
        parent::__construct();       
        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
        $class_folder = basename(dirname(__DIR__)); 
		$class = __CLASS__;
		$this->class=$class;
		$this->$class_folder=$class_folder;
		
		$this->load->helper(array('form', 'url','file'));
    	$this->folder=$class_folder."/"; 
        $this->module=$this->folder.$class."/";
        $this->http_ref=base_url().$this->module;
        $this->load->model('master_model');
		$this->load->model("general_model");
		$this->model=new general_model("m_skpd");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->module_title="Pegawai";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
	 }
	 
	 function index(){
		$this->listview();
	 }

	 function listview(){
		$data['username'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["username"];
		$data['nama'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["first_name"];
		$data['level_user'] = $_SESSION[$this->lauth->appname]["groupdata"]["level_user"];
		$data['prov'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_propinsi"];
		$data['kabupaten'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_kabupaten"]; 
		$data['skpd'] = $_SESSION[$this->lauth->appname]["groupdata"]["skpd"];
		$data['group_brwa'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["group_brwa"];
		// pre($data);exit;
	 	$this->load->library('pagination');  
        $table=$this->model->tbl;    
        $queryString=rebuild_query_string(); 
		$data_type=$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        // debug();
        $col_text=$data["text"];
		$field=join(",",$col_text);
        $whereSql=get_where_from_searchbox($field);
        
        
		if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
		
		$whereSql="";	
		if(cek_array($where)):
			$whereSql.=join(" and ",$where);
		endif;
		
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"10";
        $data["perPage"]=$perPage;
       
	    $uriSegment=4;
        
        $totalRows=$this->model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";
        
        //$arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        $config['base_url'] = $this->module."listview";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		$data["arrData"]=$arrData;
		$this->_render_page($this->module."v_list",$data,true);
    }
	
	function add(){
	 	$data['username'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["username"];
		$data['nama'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["first_name"];
		$data['level_user'] = $_SESSION[$this->lauth->appname]["groupdata"]["level_user"];
		$data['prov'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_propinsi"];
		$data['kabupaten'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_kabupaten"]; 
		$data['skpd'] = $_SESSION[$this->lauth->appname]["groupdata"]["skpd"];
		
		$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new comment";
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data['services_prov']=$this->dagri_service['server'];
			$this->_render_page($this->module."add",$data,true);
        endif;
    }
	
	public function insert( )
	{	
		$this->msg_ok="Add data successfully";
        $this->msg_fail="Unable to add data";
		if($this->input->post('save') == 'Simpan'){
				$request = array('nama'=>$this->input->post('nama'));
				$this->conn->StartTrans();
				$this->master_model->doCreate($request);
				$ok=$this->conn->CompleteTrans();
				$this->_proses_message($ok,$this->module."listview/",$this->module."add/");
		}   	
	}
	
    function edit($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$data['username'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["username"];
		$data['nama'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["first_name"];
		$data['level_user'] = $_SESSION[$this->lauth->appname]["groupdata"]["level_user"];
		$data['prov'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_propinsi"];
		$data['kabupaten'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_kabupaten"]; 
		$data['skpd'] = $_SESSION[$this->lauth->appname]["groupdata"]["skpd"];
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
        $data['services_prov']=$this->dagri_service['server'];
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
				$data['query'] = $this->master_model->doEdit($id);
				foreach($data['query'] as $row){
					$data['ids'] = $row['idx'];			
					$data['nama'] = $row['nama'];								
				}
				$data['link'] = 'pegawai_edit';	
			$this->_render_page($this->module."edit",$data,true);
        endif;    
    }
	
	public function update()
	{			
		$request = array('idx'=>$this->input->post('id'),'nama'=>$this->input->post('nama'));
		$this->conn->StartTrans();
		$this->master_model->doUpdate($request);
		$ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."listview/",$this->module."listview/");
	}

    function del($id){
       if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
		
		$this->conn->StartTrans();
		if(isset($id)){
			$this->master_model->doDelete($id);
		}
		$ok=$this->conn->CompleteTrans();
        $this->_proses_message($ok,$this->module."listview",$this->module."listview");
       
    }

}