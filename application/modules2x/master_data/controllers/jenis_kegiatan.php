<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jenis_kegiatan extends Admin_Controller {
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
        $this->model=new general_model("m_jenis_kegiatan");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->tbl_idx="idx";
		$this->tbl_sort="order_num asc";
		
		$this->parent_module_title		=	"Master Data";
		
		$this->arr_module_title['pg']	=	"Jenis Kegiatan - Peer Group";
		$this->arr_module_title['ep']	=	"Jenis Kegiatan - Evaluasi Perkembangan";
		$this->arr_module_title['pd']	=	"Jenis Kegiatan - Perkembangan Diri";
		$this->arr_module_title['dk']	=	"Jenis Kegiatan - Dukungan Keluarga";
		$this->arr_module_title['da']	=	"Jenis Kegiatan - Daily Activity";
		
		$this->filter['pg']	=	"kategori='pg'";
		$this->filter['ep']	=	"kategori='ep'";
		$this->filter['pd']	=	"kategori='pd'";
		$this->filter['dk']	=	"kategori='dk'";
		$this->filter['da']	=	"kategori='da'";	
	 }
	 
	 function index($kategori){
	 	$this->listview($kategori);
	 }

	 function listview($kategori=false){
		
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
		
		$where[]	=	$this->filter[$kategori];
        
        $whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;
       
	    $uriSegment=5;
        
        $totalRows=$this->model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";

		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);

		$config['base_url'] = $this->module."listview/".$kategori;  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		
		$this->module_title = $this->arr_module_title[$kategori];
		
        $data["arrData"]=$arrData;
		$data["kategori"]	=	$kategori;
		$this->_render_page($this->module."v_list",$data,true);
    }
	
	
	 function up($kategori,$id){
		$this->init_order_num();
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
        $this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
        $arrData=$this->model->SearchRecordWhere($this->filter[$kategori]," order by order_num");
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
	
    function down($kategori,$id){
        $this->init_order_num();
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
        //$arrData=$this->conn->GetAll("select * from "" where  menu_parent_id={$menu_parent_id} order by order_num");
        $arrData=$this->model->SearchRecordWhere($this->filter[$kategori]," order by order_num");
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
	 
	 function add($kategori){
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
			$this->module_title = $this->arr_module_title[$kategori];
            $data['kategori']	=	$kategori;
            $this->_render_page($this->module."v_add",$data,true);
        endif;
        //debug();
        if($act=="create"):

			$data=get_post();
			$data["order_num"]=$this->model->GetLastID("order_num")+1;
			$data=$this->_add_creator($data);
			$this->conn->StartTrans();
			$this->model->InsertData($data);
			$ok=$this->conn->CompleteTrans();

            $this->_proses_message($ok,$this->module."listview/".$kategori,$this->module."add/".$kategori);
        endif;
    }
	
    
    function edit($kategori,$id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Link updated successfully";
        $this->msg_fail="Unable to update link";
       
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
			$this->module_title = $this->arr_module_title[$kategori];
			
            $arrData=$this->model->GetRecordData("idx=$id and ".$this->filter[$kategori]);
            $data["data"]		=	$arrData;
			$data["kategori"]	=	$kategori;

			$this->_render_page($this->module."v_edit",$data,true);
        endif;
		
		if($act=="update"):
            $data=get_post();
			$this->conn->StartTrans();
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id and ".$this->filter[$kategori]);
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/".$kategori,$this->module."edit/$kategori/$id_enc");
        endif;     
    }
    
    function del($kategori,$id){
       if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
      
        $arrData=$this->model->GetRecordData("{$this->tbl_idx}=$id and ".$this->filter[$kategori]);
        $act="delete";    
        if($act=="delete"):
            $this->conn->StartTrans();
                $this->model->DeleteData("{$this->tbl_idx}=$id and ".$this->filter[$kategori]);
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."listview/".$kategori,$this->module."view/$kategori/$id_enc");
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