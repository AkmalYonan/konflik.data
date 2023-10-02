<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report_rawat_jalan extends Admin_Controller {
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
        $this->model=new general_model("t_pasien");
		$this->model_pasien=new general_model("t_pasien_pasca_rd");
		$this->model_jenis_kegiatan=new general_model("m_jenis_kegiatan");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Laporan";

		$this->tbl_idx="idx";
		$this->tbl_idx_pasien="idx_pasien";
		$this->tbl_sort="idx desc";	
		//$this->jenis_kegiatan_filter	=	"kategori='rd'";
		$this->init_lookup();
		
	 }
	 
	 function init_lookup(){
		$this->model_lookup=new general_model("m_lookup");
		$lookup_arr=$this->model_lookup->SearchRecordWhere("active=1","order by lookup_category,order_num");

		if(cek_array($lookup_arr)):
			foreach($lookup_arr as $x=>$val):
				$data_lookup[$val["lookup_category"]][$val["kd_lookup"]]=$val["ur_lookup"];
			endforeach;
		endif;
		$this->data_lookup=$data_lookup;
	 }
	 
	 
	 function index_rujukan(){
	 	$this->listview_rujukan();
	 } 
	 
	 function index_outcome(){
	 	$this->listview_outcome();
	 } 	 
	
	 function listview_rujukan(){
		// debug();
		$this->load->library('pagination'); 
        $sql		=	"select * from t_pasien";
		  
        $table		=	"($sql) a";
		$queryString=	rebuild_query_string(); 
		$data_type	=	$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        
        $col_text	=	$data["text"];
		$field		=	join(",",$col_text);
        $whereSql	=	get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]=	"(".$whereSql.")";
        endif;
        
		$where[]="(status_rehab='2')";
        
		$whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        $perPage	=	$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;
       
	    $uriSegment	=	4;
        
        $totalRows	=	$this->model->getTotalRecordWhere($whereSql);
        $offset		=	$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy		=	" order by {$this->tbl_sort}";
		
		//debug();
		$arrData	=	$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		//pre($arrData);exit;
		
		$config['base_url'] = $this->module."listview";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		$this->module_title="Rujukan Pasien";
		// exit;
		$data["arrData"]=$arrData;		
		$this->_render_page($this->module."v_laporan_rujukan",$data,true);
    }
	
	
	 function listview_outcome(){
		
		$this->load->library('pagination'); 
        $sql		=	"select * from t_pasien";
		$table		=	"($sql) a";
		$queryString=	rebuild_query_string(); 
		$data_type	=	$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        
        $col_text	=	$data["text"];
		$field		=	join(",",$col_text);
        $whereSql	=	get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]=	"(".$whereSql.")";
        endif;
        
		$where[]="(status_rehab='3')";
        
		$whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        $perPage	=	$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;
       
	    $uriSegment	=	4;
        
        $totalRows	=	$this->model->getTotalRecordWhere($whereSql);
        $offset		=	$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy		=	" order by {$this->tbl_sort}";
		
		//debug();
		$arrData	=	$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		//pre($arrData);exit;
		
		$config['base_url'] = $this->module."listview";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		$this->module_title="Outcome Pasien Pasca Rehabilitasi";
		// exit;
		$data["arrData"]=$arrData;		
		$this->_render_page($this->module."v_laporan_outcome",$data,true);
    }		
	
	function add($id){
		
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";
        
        $act=$this->input->post("act")?$this->input->post("act"):""; 
		   
        if(empty($act)):
			
			$arrData				=	$this->model->GetRecordData("idx_pasien=$id");
			$arrPasien				=	$this->model_pasien->GetRecordData("idx=$id");
			$arrJenisKegiatan		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
			$data['datax']			=	$arrData;
			$data['data']			=	$arrPasien;
			$data['jenis_kegiatan']	=	$arrJenisKegiatan;
			$data['id']				=	$id_enc;
			$data['idx_pasien']		=	$id;
			$data['act']			=	"add";
			
            $this->_render_page($this->module."v_execute",$data,true);
			
        endif;
        //debug();
        if($act=="add"):
			
			$data						=	get_post();
			
			if($data['lampiran_name']):
				$config['allowed_types']	=	"doc|docx|pdf|xls|xlsx|jpg|jpeg";
				$config['upload_path']		=	$this->config->item("dir_peer_group");
				$config['file_name']		=	time().substr($data['lampiran_name'],strrpos($data['lampiran_name'],"."));
				$config['max_size']			=	"500000";
				$config['overwrite']		=	TRUE;
			
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('lampiran');
				
				$file						=	$this->upload->data();
				$data['file']				=	$file['file_name'];
			endif;
			
			$data			=	$this->_add_creator($data);
			$pertemuan		=	$data['idx_pertemuan'];
			
			if($pertemuan):
				$data['tgl_pertemuan_'.$pertemuan]	=	$data['tanggal'];
			endif;
			
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
		
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
       
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        
		if(empty($act)):
			
			$arrData				=	$this->model->GetRecordData("idx=$id");
            $arrPasien				=	$this->model_pasien->GetRecordData("idx_pasien=$id");
			$arrJenisKegiatan		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
			$data['data']			=	$arrData;
			$data['datax']			=	$arrPasien;
			$data['jenis_kegiatan']	=	$arrJenisKegiatan;
			$data['id']				=	$id_enc;
			$data['idx_pasien']		=	$id;
			$data['act']			=	"edit";
						
            $this->_render_page($this->module."v_execute",$data,true);
			
        endif;
		
		if($act=="edit"):
			
			$data=get_post();
			
			if($data['lampiran_name']):
				$config['allowed_types']	=	"doc|docx|pdf|xls|xlsx|jpg|jpeg";
				$config['upload_path']		=	$this->config->item("dir_rumah_damping");
				$config['file_name']		=	time().substr($data['lampiran_name'],strrpos($data['lampiran_name'],"."));
				$config['max_size']			=	"500000";
				$config['overwrite']		=	TRUE;
			
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('lampiran');
				
				$file						=	$this->upload->data();
				
				unlink($this->config->item('dir_rumah_damping').$data['lampiran_old']);
				$data['file']				=	$file['file_name'];
			endif;		
			
			$data['idx_jenis_kegiatan']		=	join(",",$data['idx_jns_kegiatan']);
			
			$start		=	$this->conn->StartTrans();
			$this->model_pasien->UpdateData($data, "{$this->tbl_idx_pasien}=$id");
			
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
      
        $arrData=$this->model->GetRecordData("{$this->tbl_idx_pasien}=$id");
		
		if($arrData['file']):
			unlink($this->config->item('dir_peer_group').$arrData['file']);
		endif;
		
        $act="delete";    
        if($act=="delete"):
			
            $start		=	$this->conn->StartTrans();
                $this->model->DeleteData("{$this->tbl_idx_pasien}=$id");
            $complete	=	$this->conn->CompleteTrans();
            $this->_proses_message($complete,$this->module."listview",$this->module."listview/");
        endif;
    }
	
	function del_file($id){
		
		if($this->encrypt_status==TRUE):
            $id_enc	=	$id;
            $id		=	decrypt($id);
        endif;
		
		$arr		=	$this->model->GetRecordData("idx_pasien='".$id."'");
		
		$old_file	=	$arr['file'];
		
		$path		=	$this->config->item("dir_peer_group");
		
		if($old_file):
			unlink($path.$old_file);
		endif;
		
		$data['file']	=	"";
		
		$criteria		=	"idx_pasien='".$id."'";
		$update			=	$this->model->UpdateData($data,$criteria);
		
		return $update;
	
	}
	
	function view($id){
        
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		
		$arrData		=	$this->model->GetRecordData("idx=$id");
		$jenis_kegiatan	=	$this->model_jenis_kegiatan->GetRecordData("idx='".$arrData['idx_jenis_kegiatan']."' and ".$this->jenis_kegiatan_filter);
		$arrData['jenis_kegiatan']	=	$jenis_kegiatan['ur_jenis_kegiatan'];
		$arrPasien		=	$this->model_pasien->GetRecordData("idx_pasien=$id");
		
		$data["datax"]	=	$arrPasien;
		$data["data"]	=	$arrData;
		$data['id']		=	$id_enc;
       	
		$this->_render_page($this->module."v_view",$data,true);       
     }
	 
	 function get_array_idx(){
	 
	 	$sql			=	"select idx_pasien from ".$this->model->tbl;		
		$array			=	$this->conn->GetAll($sql);		
		foreach($array as $k=>$v):
			$arr[$k]	=	$v['idx_pasien'];
		endforeach;		
		$series			=	join(",",$arr);		
		return $series;
	 
	 }
}