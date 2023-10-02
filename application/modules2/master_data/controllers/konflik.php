<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class konflik extends Admin_Controller {
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
        $this->model=new general_model("m_konflik");
		$this->model_sektor=new general_model("m_sektor");	
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Master Data";
		$this->module_title="Konflik";
		$this->tbl_idx="idx";
		$this->tbl_sort="order_num asc";
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
		
		$sektor = $_GET['sektor'];
		
		if($sektor):
            $where[]="( sektor_id = '".$sektor."')";
        endif;
		
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
		$data["sektor"] = lookup("m_sektor","kode","uraian"," status=1"," order by order_num asc");
		$data["arrData"]=$arrData;
		$this->_render_page($this->module."v_list",$data,true);
    }

	 function add(){
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";

        $act=$this->input->post("act")?$this->input->post("act"):"";

        if(empty($act)):
            $data=null;
			$data["sektor"] = $this->model_sektor->SearchRecordWhere("status=1");
			$this->_render_page($this->module."v_add",$data,true);
        endif;

        if($act=="create"):
			$data=get_post();
			$kode = $this->model->GetLastID();
			$data['kode'] = "K".$kode;
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
			$data["sektor"] = $this->model_sektor->SearchRecordWhere("status=1");
            $data["data"]=$arrData;
			$this->_render_page($this->module."v_edit",$data,true);
        endif;

		if($act=="update"):
            $data=get_post();
			
			if(!$data['kode']):
				$kode = $this->model->GetLastID();
				$data['kode'] = "K".$kode;
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
	
	/* ORDER NUMBER */
	 function up($id){
		$this->init_order_num();
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
        $this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
        $arrData=$this->model->SearchRecordWhere(false," order by order_num");
        foreach($arrData as $x=>$value):
            $updownData[]=$value["idx"];
            if($value["idx"]==$id):
                $current=$x;
            endif;
        endforeach;
        
        $idCurrent=$updownData[$current];
        $idBefore=$updownData[$current-1];
        
        $this->conn->StartTrans();
        $data["order_num"]=$current+1;
        $this->conn->AutoExecute($this->model->tbl,$data,"UPDATE","idx=".$idBefore);
        $data["order_num"]=$current;
        $this->conn->AutoExecute($this->model->tbl,$data,"UPDATE","idx=".$idCurrent);
        $ok=$this->conn->CompleteTrans();
       	$this->_proses_message($ok,$this->agent->referrer(),$this->agent->referrer());
    }
    
	function init_order_num(){
		//debug();
		$mycount=$this->conn->GetOne("select count(idx) as mycount from ".$this->model->tbl." group by order_num having count(order_num)>1 ");
		if($mycount>1):
			$this->conn->StartTrans();
			$arrData=$this->model->SearchRecord(false," order by order_num");
			foreach($arrData as $x=>$val):
				$data["order_num"]=$x+1;
				$this->model->UpdateData($data,"idx=".$val["idx"]);
			endforeach;
			$this->conn->CompleteTrans();
		endif;
	}
	
    function down($id){
        $this->init_order_num();
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
        //$arrData=$this->conn->GetAll("select * from "" where  menu_parent_id={$menu_parent_id} order by order_num");
        $arrData=$this->model->SearchRecordWhere(false," order by order_num");
		foreach($arrData as $x=>$value):
            $updownData[]=$value["idx"];
            if($value["idx"]==$id):
                $current=$x;
            endif;
        endforeach;
		
        
        $idCurrent=$updownData[$current];
        $idNext=$updownData[$current+1];
        
        $this->conn->StartTrans();
        $data["order_num"]=$current+1;
        $this->conn->AutoExecute($this->model->tbl,$data,"UPDATE","idx=".$idNext);
        $data["order_num"]=$current+2;
        $this->conn->AutoExecute($this->model->tbl,$data,"UPDATE","idx=".$idCurrent);
        $ok=$this->conn->CompleteTrans();
        $this->_proses_message($ok,$this->agent->referrer(),$this->agent->referrer());
    }
	/* END ORDER NUMBER */
}
