<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tahapan extends Admin_Controller {
	var $arr_category=array();
    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
        $class_folder = basename(dirname(__DIR__)); //admin
		$class = __CLASS__; //dashboard
		$this->class=$class;
		$this->$class_folder=$class_folder;

		$this->load->helper(array('form', 'url','file'));
    	$this->folder=$class_folder."/"; //master_data/
        $this->module=$this->folder.$class."/";
        $this->http_ref=base_url().$this->module;

        $this->load->model("general_model");
        $this->model=new general_model("m_tahapan");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Master Data";
		$this->module_title="Tahapan Usulan";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx asc";
	 }

	 function index(){
	 	$this->listview();
	 }

	 function listview(){

		$this->load->library('pagination');

		$table=$this->model->tbl;

		$queryString=rebuild_query_string();

		$data_type=$this->adodbx->GetDataType($table);	
		
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;

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
		
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;

	    $uriSegment=4;

        $totalRows=$this->model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";
		
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		
		$config['base_url'] = $this->module."listview";
        $config['per_page'] = $perPage;
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		$data["sektor"] = lookup("m_sektor","kode","uraian","");
		$data["arrData"]=$arrData;
		$this->_render_page($this->module."v_list",$data,true);
    }

	 function add(){
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";

        $act=$this->input->post("act")?$this->input->post("act"):"";

        if(empty($act)):
            $data=null;
			$this->_render_page($this->module."v_add",$data,true);
        endif;

        if($act=="create"):
			$data=get_post();
			$kode = $this->model->GetLastID()+1;
			$data['kode'] = "T".$kode;
			$start		=	$this->conn->StartTrans();
			$this->model->InsertData($data);
			$complete	=	$this->conn->CompleteTrans();

            $this->_proses_message($complete,$this->module."listview/",$this->module."add/");
        endif;
    }


    function edit($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Link updated successfully";
        $this->msg_fail="Unable to update link";

        $act=$this->input->post("act")?$this->input->post("act"):"";
        if(empty($act)):
            $arrData=$this->model->GetRecordData("idx=$id");
            $data["data"]=$arrData;
			$this->_render_page($this->module."v_edit",$data,true);
        endif;

		if($act=="update"):
            $data=get_post();
			
			if(!$data['kode']):
				$kode = $this->model->GetLastID()+1;
				$data['kode'] = "T".$kode;
			endif;
			
			$start		=	$this->conn->StartTrans();
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
			$complete	=	$this->conn->CompleteTrans();

			$this->_proses_message($complete,$this->module."listview/",$this->module."edit/$id_enc");
        endif;
    }

    function del($id){

		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;

        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";

        $arrData=$this->model->GetRecordData("{$this->tbl_idx}=$id");

        $act="delete";

        if($act=="delete"):

            $start		=	$this->conn->StartTrans();

                $this->model->DeleteData("{$this->tbl_idx}=$id");

            $complete	=	$this->conn->CompleteTrans();

            $this->_proses_message($complete,$this->module."listview",$this->module."view/$id_enc");
        endif;
    }
}
