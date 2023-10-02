<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class data extends Admin_Controller {
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
        $this->model=new general_model("map_data_detail");
		$this->model_category=new general_model("cms_pages_category");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Wilayah Kelola Rakyat";
		$this->module_title="";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		
		$this->lookup_map_group	=	lookup("map_data_group","kd_group","ur_group",false,"order by order_num");
		$this->lookup_map_layer	=	lookup("map_data","kd_layer","ur_layer",false,"order by order_num");
		//debug();
		//
		//exit();
		//debug();
		//$this->init_lookup();
		
	 }
	 
	 
	 function index($kd_layer=false){
	 	$this->listview($kd_layer);
		//$this->_render_page($this->module."registrasi_list",$data,true);
	 }

	 function listview($kd_layer){
		
		$this->load->library('pagination');  
		
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
		
		if ($kd_layer) $where[]="(kd_layer='".$kd_layer."')";
        
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
			$this->load->helper(array('geophp','file'));
			debug();
			$data=get_post();
			
			
			check_folder($this->config->item("dir_geojson"));
			
			$config['allowed_types']	=	"*";
			$config['upload_path']		=	$this->config->item("dir_geojson");
			$config['max_size']			=	"500000";
			$config['overwrite']		=	TRUE;
			//$config["file_name"]		= 	$data["category"]."_".date("Ymd_His");
		
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
		
			if ( ! $this->upload->do_upload('up_file')):
				$error = $this->upload->display_errors();
				//pre($config);
				//pre($error);exit;
			else:
				$uploaded_file=$this->upload->data();
			endif;
			pre($uploaded_file);
			
			
			
			$data=$this->_add_creator($data);
			$data["author"]=$data["creator"];
			$data["kd_layer"]=str_replace(array(" ","(",")"),array("_","",""),$data['ur_layer']);
			$data["status"]=$data["status"]?1:0;

			
			$json=file_get_contents($uploaded_file['full_path']);
			$wkt  = json_to_wkt($json);pre($wkt);
			
			$wa   = json_decode($json,true);
			$ctr  = json_to_centroid($json);

			$data['x'] = $ctr->getX();
			$data['y'] = $ctr->getY();
			
			$this->conn->StartTrans();
			$this->model->InsertData($data);
			$idx = $this->model->GetLastID();
			if ($idx) {
				$sql = "UPDATE map_layer_data SET the_geom=ST_GeomFromGeoJSON('".$json."') WHERE idx='".$idx."'";
				$result = $this->conn->query($sql);
			}
			$ok=$this->conn->CompleteTrans();
			//pre($ok);exit;
            //$this->_proses_message($ok,$this->module."listview/",$this->module."add/");
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
			$data["category"]=1;
			$data["status"]=$data["status"]?1:0;
			//$data["created"]=$_POST['news_date'];
			
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			if ($_POST['button'] && $_POST['url']) $_data["others"]=$_POST['button']."#".$_POST['url'];
			
			
			check_folder($this->config->item("dir_articles"));
			
			$config['allowed_types']	=	"jpg|jpeg|png|JPEG|JPG|bmp|BMP|pdf";
			$config['upload_path']		=	$this->config->item("dir_articles");
			$config['max_size']			=	"500000";
			$config['overwrite']		=	TRUE;
			$config["file_name"]		= 	$data["category"]."_".date("Ymd_His");
		
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
	 
	 
	 /* upload geojson */
	 function spasial_update($id){ 
	 	$this->load->helper(array('geophp','file'));
	 	//debug();
		if($this->encrypt_status==TRUE):
         	$id_enc=$id;
            $id=decrypt($id);
        endif;
	 	$data=get_post(true);

		//move uploaded file from /tmp
		if ($_POST['file_peta']) {
			$adm_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_geojson');
			
			$fix_name = $_POST['file_peta'];
			$tmp_name = $this->config->item('dir_tmp').$_POST['file_peta'];
			$new_name = $adm_folder.$this->config->item('dir_spasial').$fix_name;
			if (file_exists($tmp_name)) {
				$this->conn->StartTrans();
				if (copy($tmp_name,$new_name)) {
					
					$file_info=get_file_info($new_name);
					$file_peta['id_parent']=$id;
					$file_peta['id_user']=$_POST['id_user'];
					$file_peta['id_jenis_doc']='peta';
					$file_peta['tipe_doc']='spasial';
					$file_peta['file_name']=$fix_name;
					$file_peta['file_path']=$this->config->item('dir_spasial').$fix_name;
					$file_peta['file_type']=get_mime_by_extension($new_name);
					$file_peta['file_ext']=substr($fix_name,strrpos($fix_name,"."));
					$file_peta['file_size']=$file_info['size'];
					$file_peta['upload_time']=date("Y-m-d h:i:s",(int)$file_info['date']);
					$file_peta['created']=date("Y-m-d h:i:s");
					
					$this->model_t_file_peta=new general_model("wa_spasial_file_upload");
					$this->model_t_file_peta->InsertData($file_peta);
					$img_idx_peta=$this->model_t_file_peta->GetLastID("idx");
					
					$file_peta['id_file']=$img_idx_peta;
					$this->model_file_peta2->InsertData($file_peta);
					unlink($tmp_name);
				}
				
				$file = $this->config->item('dir_spasial').$fix_name;
				$json=file_get_contents($file);
				
				
				$wa   = json_decode($json,true);
				$ctr  = json_to_centroid($json);
				if ($wa['features'][0]['properties']['Hectares']) $wa_data['luas'] = $wa['features'][0]['properties']['Hectares'];
				$wa_data['pos_x'] = $ctr->getX();
				$wa_data['pos_y'] = $ctr->getY();
				
				$wkt  = json_to_wkt($json);
				
				$data['id_parent']=$id;
				$data['created']=date("Y-m-d");
				$data['geom']=$wkt;
				if ($data['act']=='insert') {
					$sql = "INSERT wa_spasial (id_parent,created,geom) VALUES (".$data['id_parent'].",'".$data['created']."',GeomFromText('".$data['geom']."'));";
				}
				$this->model->UpdateData($wa_data, "idx=".$data['id_parent']);
				$result = $this->conn->query($sql);
				$ok=$this->conn->CompleteTrans();
			}
		}
		else {
			$this->conn->StartTrans();
			$sql = "DELETE FROM wa_spasial WHERE id_parent=".$id;
			$result = $this->conn->query($sql);
			$sql = "DELETE FROM wa_spasial_file WHERE id_parent=".$id;
			$result = $this->conn->query($sql);
			$ok=$this->conn->CompleteTrans();
		}
		$res['act']=$data['act'];
		if ($ok) $this->load->view($this->module."v_spasial_upload_ok",$res);
	 }
	 
	 function spasial_view($id){
	 	if($this->encrypt_status==TRUE):
         	$id_enc=$id;
            $id=decrypt($id);
        endif;
	 	$data['id']=$id;
		
		$this->load->view($this->module."map/v_view_spasial",$data);
	 }
}