<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hp extends Admin_Controller {
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
        $this->model=new general_model("cms_pp");
		$this->model_category=new general_model("cms_pp_category");
		$this->model_file=new general_model("cms_pp_file");
		$this->model_file_upload=new general_model("cms_pp_file_upload");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Pustaka";
		$this->module_title="Hasil Penelitan dan Analisis";
		$this->tbl_idx="idx";
		$this->tbl_sort="edited desc";	
		//debug();
		//
		//exit();
		//debug();
		$this->category=2; //hasil penelitian
		$this->init_lookup();
		
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
		//debug();
		
		$this->load->library('pagination');  
        /*
		$sql=" select a.*,group_cocat(b.realname,b.path,b.file_size from ".$this->model->tbl." a 
                left join ".$this->model->tbl."_file b on a.idx=b.id_pp group by a.idx
        ";
		*/
		$sql=" select a.*,group_concat(b.realname) as realname,group_concat(b.path) as path,group_concat(b.file_size) as file_size from ".$this->model->tbl." a 
                left join ".$this->model->tbl."_file b on a.idx=b.id_pp group by a.idx
        ";
		
		//$table=$this->model->tbl;    
        $table="($sql) a";
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
		
		$where[]="(category=".$this->category.")";

		if($this->input->get_post("tahun")):
            $where[]	=	" year='".$this->input->get_post("tahun")."'";
		endif;

		if($this->input->get_post("kd_cat_pp")):
            $where[]	=	" kd_cat_pp='".$this->input->get_post("kd_cat_pp")."'";
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
		

		if($this->input->get_post("sorter")):
            $this->tbl_sort	=	" edited ".$this->input->get_post("sorter");
		endif;

        $sortBy=" order by {$this->tbl_sort}";
        
		
		
        //$arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
       
		if (is_array($arrData)) {
			foreach($arrData as $k=>$v) {
				$arrData[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,3);
				$arrData[$k]['news_clip2']=substr($v['clip'],0,100)."...";
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
			debug();
			$data=get_post();
			
			$data=$this->_add_creator($data);
			$data["author"]=$data["creator"];
			$data["category"]=$this->category;
			$data["status"]=$data["status"]?1:0;
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			if ($_POST['button'] && $_POST['url']) $_data["others"]=$_POST['button']."#".$_POST['url'];
			//$_data["author"]=$_POST['author'];
			//$enc=encrypt($_POST['idx']);
			
			//UPLOAD FILE 
			//pre($_FILES);
			
			check_folder($this->config->item("dir_pp"));
			
			
			//pre($_FILES);
			
			
			//$this->upload->do_upload('image_name');
			
			
			//pre($file);exit;
			
			/*
			if($file['file_ext']==".JPG" or $file['file_ext']==".JPEG" or $file['file_ext']==".jpg" or $file['file_ext']==".jpeg" or $file['file_ext']==".gif" or $file['file_ext']==".png"):
				$_data['image']=$file['file_name'];
			endif;
			*/
			
			//debug();
			/*
			$arrFiles=json_decode($data["files"],true);
			$files=array();
			foreach($arrFiles as $x=>$val):
				$file_tmp=array();
				$filename=$val["name"];
				$pi=pathinfo($filename);
				$file_tmp["file_name"]=$val["name"];
				$file_tmp["file_type"]=$val["type"];
				$file_tmp["file_path"]=realpath($this->config->item("dir_pp"))."/";
				$file_tmp["full_path"]=realpath($this->config->item("dir_pp"))."/".$file_tmp["file_name"];
				$file_tmp["raw_name"]=$pi["filename"];
				$file_tmp["orig_name"]=$val["name"];
				$file_tmp["client_name"]=$val["name"];
				$file_tmp["file_ext"]=".".$pi["extension"];
				$file_tmp["file_size"]=round($val["size"]*1/1024,2);
				$file_tmp=$this->is_image($file_tmp["full_path"],$file_tmp);
				//$file_tmp["is_image"]=getimagesize()
				$files[]=$file_tmp;
			endforeach;
			*/
			//pre($files);
			
			
			
			//$is_image=$this->is_image($this->config->item("dir_news")."3_20161013_151008.jpg");
			//pre($is_image);
			
			//$file_pp=$this->_upload_pp();
			//pre($file_pp);
			
			//debug();
			//exit();
			$this->conn->StartTrans();
			
			$file=$this->_upload_image();
			//$file_pp=$this->_upload_pp();
			if(cek_array($file)):
				$data["image"]=$file["file_name"];
			endif;
			
			$this->model->InsertData($data);
			$pp_id=$this->model->GetLastID("idx");
			
			//pre($data);
			//pre($file_pp);
			 //get file upload id
			//pre($pp_id);
            $arr_file_id=$data["upload_file_id"];
			if(cek_array($arr_file_id)):
				$id_join=join(",",$arr_file_id);
				$files=$this->model_file_upload->SearchRecordWhere("idx in ($id_join)");
			endif;
			
			if(cek_array($files)):
				foreach($files as $x=>$file_pp):
					//$file_id=$this->_save_uploaded_file($file_pp);
            		//add to pp file upload
					$file_id=$file_pp["idx"];
					unset($file_pp["idx"]);
            		$this->_save_upload_to_pp_file($pp_id, $file_id,$file_pp); 
				endforeach;
			endif;
			
			$ok=$this->conn->CompleteTrans();
			//pre($ok);exit;
            $this->_proses_message($ok,$this->module."listview/",$this->module."add/");
        endif;
    }
	
	function _upload_image(){
			$data=get_post();
			check_folder($this->config->item("dir_pp"));
			
			$config['allowed_types']	=	"jpg|jpeg|png|JPEG|JPG|BMP|bmp";
			$config['upload_path']		=	$this->config->item("dir_pp");
			//$config['max_size']			=	"5000000";
			$config['overwrite']		=	TRUE;
			$config["file_name"]		= 	$data["kd_cat_pp"]."_cover_".date("Ymd_His");
			$this->load->library('upload', $config);
			
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('image_name')):
				$error = $this->upload->display_errors();
				//pre($config);
				//pre($error);exit;
			else:
				$file=$this->upload->data();
			endif;
			return $file;	
	}
	
	
	
	
	function _upload_pp(){
			$data=get_post();
			
			check_folder($this->config->item("dir_pp"));
			$config['allowed_types']	=	"pdf|doc|docx|jpg|png|bmp|jpeg";
			$config['upload_path']		=	$this->config->item("dir_pp");
			$config['max_size']			=	"5000000";
			$config['overwrite']		=	TRUE;
			$config["file_name"]		= 	$data["kd_cat_pp"]."_file_".date("Ymd_His");
			$this->load->library('upload', $config);
			
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('userfile')):
				$error = $this->upload->display_errors();
				//pre($config);
				pre($error);exit;
			else:
				$file=$this->upload->data();
			endif;
			return $file;	
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
			$arrDataFile=$this->model_file->SearchRecordWhere("id_pp=$id");
			
            $data["data"]=$arrData;
			$data["data_file"]=$arrDataFile;
			$this->_render_page($this->module."v_edit",$data,true);
        endif;
		
	
		
		if($act=="update"):
			//debug();
		
			$data=get_post();
			
			$data["publish"]=$data["publish"]?1:0;
			$data["content"]=$_POST["content"];
			$data["active"]=$data["active"]?1:0;
			$data=$this->_add_editor($data);
			$data["author"]=$data["creator"];
			$data["category"]=$this->category;
			$data["status"]=$data["status"]?1:0;
			$data["created"]=$_POST['news_date'];
			
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			if ($_POST['button'] && $_POST['url']) $_data["others"]=$_POST['button']."#".$_POST['url'];
			
			check_folder($this->config->item("dir_pp"));
			
			$pp_id=$id;
			
			
			
			$file=$this->_upload_image();
			//$file_pp=$this->_upload_pp();
			
			/*
			if(cek_array($file_pp)):
				$arrDataOld=$this->model_file->SearchRecordWhere("id_pp=$pp_id");
				if(cek_array($arrDataOld)):
					foreach($arrDataOld as $x=>$val):
						$tmp_id_file=$val["id_file_upload"];
						$this->delete_upload_file($tmp_id_file);
					endforeach;
				endif;
			endif;
			*/
			
			if(cek_array($file)):
				$data["image"]=$file["file_name"];
			endif;
			//debug();
			$this->conn->StartTrans();
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
			
			/*
			if(cek_array($file_pp)):
				$file_id=$this->_save_uploaded_file($file_pp);
            	$this->_save_upload_to_pp_file($pp_id, $file_id,$file_pp); 
			endif;
			*/
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
	 
	 
	 /* upload fie */
	 function _save_uploaded_file($data){
        $data["upload_time"]=time();
        $data["creator"]=$this->data["users"]['user']['username'];
        
        $stamp = date("Ymdhis");
        $ip = get_client_ip(); //from conf php
        $id_file = basename($data["file_temp"],".tmp")."-"."$stamp-".inet_aton($ip);
        $data["id_file_str"]=$id_file;
        $data["ip_client"]=$this->_prepare_ip($this->input->ip_address());
        //$this->conn->debug=true;
        $this->conn->StartTrans();
        $this->conn->AutoExecute("cms_pp_file_upload",$data,"INSERT");
        $ok=$this->conn->CompleteTrans();
        $ID=FALSE;
        if($ok):
            $ID=$this->conn->GetOne("select max(idx) from cms_pp_file_upload");
        endif;
        return $ID;
    }
	
	function _save_upload_to_pp_file($pp_id,$file_id,$data_file){
        $data["id_file_upload"]=$file_id;
        $data["id_pp"]=$pp_id;
       
        $path=str_replace(str_replace("\\","/",FCPATH),"",$data_file["file_path"]);
		$path_dest=str_replace("raw","file",$path);
        check_folder($path_dest);
        $fileOri=$data_file["orig_name"];
        $fileName=$data_file["file_name"];
        //cek is filename exist remove to backup
        /*
		if(is_file($path_dest.$fileOri)):
            unlink($path_dest.$fileOri);
            copy($path.$fileName,$path_dest.$fileOri);
        else:
            copy($path.$fileName,$path_dest.$fileOri);
        endif;
        */
		
        $title=$this->input->post("no_pp");
            
		$relative_path=str_replace("../","",$this->config->item("dir_pp"));	
			
        $data["title"]=$title;
        $data["realname"]=$data_file["orig_name"];
        //$data["path"]=$path_dest;
		$data["path"]=$relative_path;
        $data["file_ext"]=$data_file["file_ext"];
        $data["file_size"]=$data_file["file_size"];
        $data["created"]=date("Y-m-d H:i:s");
        $data["creator"]=$this->data["users"]["user"]["username"];
        $this->adodbx->Insert("cms_pp_file",$data);
    }
	
	
	function delete_upload_file($id=false){
	 	$this->conn->StartTrans();
		$this->model_file->DeleteData("id_file_upload=$id");
		$ok=$this->conn->CompleteTrans();
		if($ok):
			$this->delete_file($id);
		else:
			print "failed";
		endif;
	 }
	 
	 function delete_file($id=false){
	 	if(!$id):
			print "failed";
			exit();
		endif;
	 	$file=$this->conn->GetRow("select * from ".$this->model_file_upload->tbl." where idx=$id");
	 	$ok=$this->conn->Execute("delete from ".$this->model_file_upload->tbl." where idx=$id");
		if($ok):
			if(is_file('./' . $file["relative_path"]))
			unlink('./' . $file["relative_path"]);
			if(is_file('./' . $file["relative_path_view"]))
			unlink('./' . $file["relative_path_view"]);
			if(is_file('./' . $file["relative_path_thumb"]))
			unlink('./' . $file["relative_path_thumb"]);
			print "ok";
		else:
			print "failed";
		endif;
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
	 
	
	/* CEK IMAGE */
	function is_image($path,$data=array())
	{
		$a = getimagesize($path);
		//pre($a);
		$image_type = $a[2];
		
		$data["is_image"]="";
		$data["image_width"]="";
		$data["image_height"]="";
		$data["image_type"]="";
		$data["image_size_str"]="";
		
		if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
		{
			$data["is_image"]=1;
			$data["image_width"]=$a[0];
			$data["image_height"]=$a[1];
			$data["image_type"]=str_replace("image/","",$a["mime"]);
			$data["image_size_str"]=$a[3];
			
			//return true;
		}
		return $data;
		//return false;
	}
	
	
	function file_upload_save(){
		$data=get_post();
		$id=$data["id"]?$data["id"]:false;
		if($id):
			if($this->encrypt_status==TRUE):
				$id_enc=$id;
				$id=decrypt($id);
			endif;
		endif;
		
		//pre($data);
		$file_upload=json_decode($data["file"],true);
		$file=$this->file_upload_map($file_upload);
		$id_file=$this->_save_uploaded_file($file);
		$data_file=$this->model_file_upload->GetRecordData("idx=$id_file");
		
		//if edit
		if($id):
			$this->_save_upload_to_pp_file($id,$id_file,$data_file);
		endif;
		
		//$id_file=85;
		
		//pre($data_file);
		if(cek_array($data_file)):
			$ret["status"]="ok";
			$ret["file"]=$data_file;
		else:
			$ret["status"]="";
			$ret["file"]="";
		endif;
		print json_encode($ret,true);
			
	}
	
	function file_upload_map($file){
		$val=$file;
		$file_tmp=array();
		$filename=$val["name"];
		$pi=pathinfo($filename);
		$file_tmp["file_name"]=$val["name"];
		$file_tmp["file_type"]=$val["type"];
		$file_tmp["file_path"]=realpath($this->config->item("dir_pp"))."/";
		$file_tmp["full_path"]=realpath($this->config->item("dir_pp"))."/".$file_tmp["file_name"];
		$file_tmp["raw_name"]=$pi["filename"];
		$file_tmp["orig_name"]=$val["name"];
		$file_tmp["client_name"]=$val["name"];
		$file_tmp["file_ext"]=".".$pi["extension"];
		$file_tmp["file_size"]=round($val["size"]*1/1024,2);
		$file_tmp=$this->is_image($file_tmp["full_path"],$file_tmp);	
		return $file_tmp;
	}
	 
	 
	 

}