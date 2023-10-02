<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class layanan extends Admin_Controller {
	var $arr_category=array();   
    function __construct(){
        parent::__construct();       
        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
        $class_folder = basename(dirname(__DIR__)); //admin
		$class = __CLASS__; //dashboard
		$this->class=$class;
		$this->$class_folder=$class_folder;
		
		$this->load->library("utils");
		
		$this->load->helper(array('form', 'url','file'));
    	
		$this->folder=$class_folder."/"; //master_data/
        $this->module=$this->folder.$class."/";//master_data/uu_daerah/
        $this->http_ref=base_url().$this->module;///brwa/admin/dashboard/
        
        $this->load->model("general_model");
        $this->model=new general_model("cms_pages");
		$this->model_category=new general_model("cms_pages_category");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Web Content";
		$this->module_title="Layanan JKPP - TanahKita";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		//debug();
		//
		//exit();
		//debug();
		$this->init_lookup();
		$arrIDCategory=$this->conn->Getall("select * from ".$this->model_category->tbl." where category in ('psdbnn')");
		$this->arrIDCategory=$arrIDCategory;
		if(cek_array($arrIDCategory)):
			foreach($arrIDCategory as $x=>$val):
				$this->arrIDCat[]=$val["idx"];
			endforeach;
		endif;
		$this->IDCategory=implode(",",$this->arrIDCat);
		$this->init_category();
	 }
	 
	 function init_category(){
		 	if(cek_array($this->arrIDCategory)):
				foreach($this->arrIDCategory as $x=>$val):
					$id_category=$val["idx"];
					$cek=$this->model->GetRecordData("category={$id_category}");
					
					if(cek_array($cek)!=TRUE):
						$data["category"]=$id_category;
						$data["status"]=1;
						$this->model->InsertData($data);
					endif;
					
					
				endforeach;
			endif;	 
	 }
	 
	 
	 function init_lookup(){
		$this->model_lookup=new general_model("m_lookup");
		$lookup_arr=$this->model_lookup->SearchRecordWhere("active=1","order by lookup_category,order_num");
		//pre($lookup_arr);
		//debug();
		if(cek_array($lookup_arr)):
			foreach($lookup_arr as $x=>$val):
				//pre($data["lookup"]);
				$data_lookup[$val["lookup_category"]][$val["kd_lookup"]]=$val["ur_lookup"];
			endforeach;
		//	pre($data_lookup);
		endif;
		$this->data_lookup=$data_lookup;
	 }
	 
	 function index(){
	 	$this->listview();
		//$this->_render_page($this->module."registrasi_list",$data,true);
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
		
		$where[]="(category in (".$this->IDCategory.") and status='1')";
        
        $whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;
       
	    $uriSegment=4;
        
        $totalRows=$this->model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by category";
        
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
       
		if (is_array($arrData)) {
			foreach($arrData as $k=>$v) {
				$arrData[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,3);
				$arrData[$k]['news_clip2']=substr($v['content'],0,100)."...";
			}
		}
		
		
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
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
            $this->_render_page($this->module."v_add",$data,true);
        endif;
        //debug();
        if($act=="create"):
			//debug();
			$data=get_post();
			//pre($data);
			$data=$this->_add_creator($data);
			$data["author"]=$data["creator"];
			//$data["category"]=1;
			//$data["status"]=$data["status"]?1:0;
			$data["status"]=1;
			
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			if ($_POST['button'] && $_POST['url']) $_data["others"]=$_POST['button']."#".$_POST['url'];
			//$_data["author"]=$_POST['author'];
			//$enc=encrypt($_POST['idx']);
			
			//UPLOAD FILE 
			//pre($_FILES);
			
			check_folder($this->config->item("dir_articles"));
			
			$config['allowed_types']	=	"jpg|jpeg|png|JPEG|JPG";
			$config['upload_path']		=	$this->config->item("dir_articles");
			$config['max_size']			=	"500000";
			$config['overwrite']		=	TRUE;
		
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
		
			if ( ! $this->upload->do_upload('image_name')):
				$error = $this->upload->display_errors();
				//pre($config);
				//pre($error);exit;
			else:
				$file=$this->upload->data();
			endif;
			//$this->upload->do_upload('image_name');
			
			
			//pre($file);exit;
			
			/*
			if($file['file_ext']==".JPG" or $file['file_ext']==".JPEG" or $file['file_ext']==".jpg" or $file['file_ext']==".jpeg" or $file['file_ext']==".gif" or $file['file_ext']==".png"):
				$_data['image']=$file['file_name'];
			endif;
			*/
			if(cek_array($file)):
				$data["image"]=$file["file_name"];
			endif;
			
			$this->conn->StartTrans();
			$this->model->InsertData($data);
			
			$ok=$this->conn->CompleteTrans();
			//pre($ok);exit;
            $this->_proses_message($ok,$this->module."listview/",$this->module."add/");
        endif;
    }
	
    
    function edit($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
       	
		
        $act=$this->input->post("act")?$this->input->post("act"):"";   
		//pre($act); 
        if(empty($act)):
            $arrData=$this->model->GetRecordData("idx=$id");
            $data["data"]=$arrData;
			$this->_render_page($this->module."v_edit",$data,true);
        endif;
		
	
		
		if($act=="update"):
			$data=get_post();
			$data["content"]=$_POST["content"];
			$data["active"]=$data["active"]?1:0;
			$data=$this->_add_editor($data);
			$data["author"]=$data["creator"];
			//$data["category"]=1;
			//$data["status"]=$data["status"]?1:0;
			//$data["created"]=$_POST['news_date'];
			$data["status"]=1;
			
			
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			if ($_POST['button'] && $_POST['url']) $_data["others"]=$_POST['button']."#".$_POST['url'];
			
			
			check_folder($this->config->item("dir_articles"));
			
			$config['allowed_types']	=	"jpg|jpeg|png|JPEG|JPG";
			$config['upload_path']		=	$this->config->item("dir_articles");
			$config['max_size']			=	"500000";
			$config['overwrite']		=	TRUE;
		
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
		
			if ( ! $this->upload->do_upload('image_name')):
				$error = $this->upload->display_errors();
				//pre($config);
				//pre($error);exit;
			else:
				$file=$this->upload->data();
			endif;
			//$this->upload->do_upload('image_name');
			
			
			//pre($file);exit;
			
			/*
			if($file['file_ext']==".JPG" or $file['file_ext']==".JPEG" or $file['file_ext']==".jpg" or $file['file_ext']==".jpeg" or $file['file_ext']==".gif" or $file['file_ext']==".png"):
				$_data['image']=$file['file_name'];
			endif;
			*/
			if(cek_array($file)):
				$data["image"]=$file["file_name"];
			endif;
			//debug();
			$this->conn->StartTrans();
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
        endif;     
    }
	
	function activate($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
       	
		$arrData=$this->model->GetRecordData("idx=$id");
        $activate=$arrData["active"]==1?1:0;
		$data["active"]=$activate==1?0:1;
		
		$this->conn->StartTrans();
		$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
        $ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
		     
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
	 
	 
	 function get_kab_kota($kd_bps_propinsi="",$arr_id=""){
		$sql="select * from m_kabupaten_kota where kode_prop=$kd_bps_propinsi and kode_kab!='00' order by kode_bps";
		
		$arrKabKota=$this->conn->GetAll($sql);
		$arrData=array();
		if(cek_array($arrKabKota)):
			foreach($arrKabKota as $x=>$val):
				$arrData[$val["kode_bps"]]=$val["nama"];
			endforeach;
		endif;
		$data["dataKabupaten"]=$arrData;
		$data["arr_id"]=$arr_id;
		echo $this->load->view($this->module."lookup_kabupaten",$data,true);
	}
	 
	
	 
	 
	 

}
