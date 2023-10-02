<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lookup extends Admin_Controller {
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
        $this->module=$this->folder.$class."/";//master_data/uu_daerah/
        $this->http_ref=base_url().$this->module;///brwa/admin/dashboard/
        
        $this->load->model("general_model");
        $this->model=new general_model("m_lookup");
		$this->model_category=new general_model("m_lookup_category");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Master Data";
		$this->module_title="Lookup";
		$this->tbl_idx="idx";
		$this->tbl_sort="lookup_category,kd_lookup,order_num asc";	
	 }
	 
	 function index(){
	 	$this->listview();
		//$this->_render_page($this->module."registrasi_list",$data,true);
	 }

	 function listview(){
		
		$this->load->library('pagination');  
        //$sql=" select a.*,b.realname,b.path from ".$this->model->tbl." a 
          //      left join ".$this->model->tbl."_file b on a.idx=b.id_parent
        //";
		
		$table=$this->model->tbl;    
        //$table="($sql) a";
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
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"1000";
        $data["perPage"]=$perPage;
       
	    $uriSegment=4;
        
        $totalRows=$this->model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by lookup_category,order_num";
        
		
		
        //$arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
		//$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        $arrData=$this->model->search_record_where($table,$whereSql,$sortBy);
		
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
	
	
	/*
	function up($id,$lookup_category){
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
        $this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
		debug();
		
		$allData=$this->model->SearchRecordWhere("lookup_category='".$lookup_category."'"," order by order_num");
		//$currentData=$this->model->GetRecordData("idx=$id and lookup_category='".$lookup_category."'");
		
		foreach($allData as $x=>$val):
			if($val["idx"]==$id):
				$current_order=$x;
				break;
			endif;
		endforeach;
		$up_order=$current_order-1;
		
		$currentData=$allData[$current_order];
		$upData=$allData[$up_order];
		
		$order_num=$currentData["order_num"];	
		$up_order_num=$upData["order_num"];
		
		$current_idx=$currentData["idx"];
		$up_idx=$upData["idx"];
		
		//pre($order_num);
		//pre($up_order_num);
		
		//debug();
		
		//update current data
		$this->conn->StartTrans();
		
		$data_update["order_num"]=$up_order_num;
		$this->model->UpdateData($data_update,"idx=$current_idx");
		
		$data_update1["order_num"]=$order_num;
		$this->model->UpdateData($data_update1,"idx=$up_idx");
		$ok=$this->conn->CompleteTrans();
       	$this->_proses_message($ok,$this->agent->referrer(),$this->agent->referrer());
		//pre($currentData);
		//$up_num_order=$currentData["order_num"]-1;
		//$up_data=$this->model->GetRecordData("order_num=$up_num_order and lookup_category='".$lookup_category."'");
		//pre($update);
		
	}
	*/
	
	 
	 function up($id,$lookup_category){
		$this->init_order_num($lookup_category);
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
        $this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
		
        $arrData=$this->model->SearchRecordWhere("lookup_category='".$lookup_category."'"," order by order_num");
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
	
    
	function init_order_num($lookup_category){
		//debug();
		$mycount=$this->conn->GetOne("select count(idx) as mycount from ".$this->model->tbl." where lookup_category='".$lookup_category."' group by order_num having count(order_num)>1 ");
		if($mycount>1):
			$this->conn->StartTrans();
			$arrData=$this->model->SearchRecord("lookup_category='".$lookup_category."'"," order by order_num");
			foreach($arrData as $x=>$val):
				$data["order_num"]=$x+1;
				$this->model->UpdateData($data,"idx=".$val["idx"]);
			endforeach;
			$this->conn->CompleteTrans();
		endif;
	}
	
	
    function down($id,$lookup_category){
        $this->init_order_num($lookup_category);
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
        //$arrData=$this->conn->GetAll("select * from "" where  menu_parent_id={$menu_parent_id} order by order_num");
        $arrData=$this->model->SearchRecordWhere("lookup_category='".$lookup_category."'"," order by order_num");
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
	 
	 
	 function add($lookup_category){
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
			$arrData["lookup_category"]=$lookup_category;
            $data["data"]=$arrData;
			$this->_render_page($this->module."v_add",$data,true);
        endif;
        //debug();
        if($act=="create"):
			//debug();
			$data=get_post();
			//$data["order_num"]=$this->model->GetLastID("order_num")+1;
			$data=$this->_add_creator($data);
			$this->conn->StartTrans();
			$this->model->InsertData($data);
			
			$ok=$this->conn->CompleteTrans();
			//pre($ok);exit;
            $this->_proses_message($ok,$this->module."listview/",$this->module."add/");
        endif;
    }
	
	
	function add_category(){
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
			//$arrData["lookup_category"]=$lookup_category;
            //$data["data"]=$arrData;
			$this->_render_page($this->module."v_add_category",$data,true);
        endif;
        //debug();
        if($act=="create"):
			//debug();
			$data=get_post();
			//$data["order_num"]=$this->model->GetLastID("order_num")+1;
			$data=$this->_add_creator($data);
			$this->conn->StartTrans();
			$this->model_category->InsertData($data);
			
			$ok=$this->conn->CompleteTrans();
			//pre($ok);exit;
            $this->_proses_message($ok,$this->module."listview/",$this->module."add_category/");
        endif;
    }
	
	function edit($id,$lookup_category){
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
			//$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
        endif;     
    }
    
    function edit_category($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Link updated successfully";
        $this->msg_fail="Unable to update link";
       
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $arrData=$this->model_category->GetRecordData("idx=$id");
            $data["data"]=$arrData;
			$this->_render_page($this->module."v_edit_category",$data,true);
        endif;
		
		if($act=="update"):
            $data=get_post();
			//$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			$this->model_category->UpdateData($data, "{$this->tbl_idx}=$id");
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/",$this->module."edit_category/$id_enc");
        endif;     
    }
    
	function del_category($id){
       if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
      
        $arrData=$this->model_category->GetRecordData("{$this->tbl_idx}=$id");
        $act="delete";    
        if($act=="delete"):
            $this->conn->StartTrans();
                $this->model_category->DeleteData("{$this->tbl_idx}=$id");
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."listview",$this->module."listview");
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
            $this->conn->StartTrans();
                $this->model->DeleteData("{$this->tbl_idx}=$id");
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."listview",$this->module."view/$id_enc");
        endif;
    }
	
	function view($id){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData=$this->model->GetRecordData("idx=$id");
		//$arrDataFile=$this->model_file->SearchRecordWhere("id_parent=$id");
		
        $data["data"]=$arrData;
		//$data["data_file"]=$arrDataFile;
       	$this->_render_page($this->module."v_view_2",$data,true);
        
     }
	 
	
	 
	 
	 

}