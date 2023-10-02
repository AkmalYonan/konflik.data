<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fas_ruang extends Admin_Controller {
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
        $this->load->model("sarpras_model");
        $this->load->model("general_model");
        $this->model=new general_model("m_fas_ruang");
		$this->model_dokter=new general_model("m_dokter");
		$this->model_perbid=new general_model("m_perbid");
		$this->model_tensos=new general_model("m_tensos");
		$this->model_penunjang=new general_model("m_penunjang_medis");
		$this->model_adm_umum=new general_model("m_adm_umum");
		$this->model_alat=new general_model("m_peralatan");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Data";
		$this->module_title="Fasilitas Ruangan";
		$this->tbl_idx="idx";
		$this->tbl_idx_pasien="idx_pasien";
		$this->tbl_sort="idx desc";	
		$this->jenis_kegiatan_filter	=	"kategori='pg'";
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
	 
	 function index(){
	 	$this->listview();
	 } 
	 


	 function listview(){
		
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
		$data['act']="add";
		$arrData=$this->conn->GetAll("select * from m_fas_ruang limit 0,15");
		$arrData2=$this->conn->GetAll("select * from m_fas_ruang limit 16,30");
		$data["arrData"]=$arrData;		
		$data["arrData2"]=$arrData2;		
		$this->_render_page($this->module."v_list",$data,true);
		// debug();			
		$datax=get_post();
		
		//pre($datax);exit;
		
		$start=$this->conn->StartTrans();
        if($datax['act']=="add"):	
			if($datax['attr']=='dokter'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_dokter->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='fasruang'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='perbid'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_perbid->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='tensos'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_tensos->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='penunjang'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_penunjang->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='adm_umum'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_adm_umum->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='alat'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['status1']=$datax['status1'][$i];
					$data_update['status2']=$datax['status2'][$i];
					$this->model_alat->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}
			
			// exit;
		$this->_proses_message($complete,$this->module."listview/",$this->module."listview/");	
        endif;	
		
    }
	
	function attr($kode) {
		if($kode=='peralatan'):
			$data["data2"] = $this->sarpras_model->attr_get2($kode);
		endif;
		$data["attr"]=$kode;
		$data["data"] = $this->sarpras_model->attr_get($kode);
		$this->load->view("sarpras/fas_ruang/data/v_".$kode,$data,false);
	}
	
	function pasien_list(){
		
		$this->load->library('pagination'); 
		  
        $table			=	$this->model_pasien->tbl;
		$queryString	=	rebuild_query_string(); 
		$data_type		=	$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        
        $col_text		=	$data["text"];
		$field			=	join(",",$col_text);
        $whereSql		=	get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;		
		
		if($this->get_array_idx()):
			$where[]	=	" (idx not in (".$this->get_array_idx().") )";
		endif;
		
        $whereSql		=	"";
        if(cek_array($where)):
            $whereSql	.=	join(" and ",$where);
        endif;
        
		$perPage		=	$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        
		$data["perPage"]=	$perPage;
       
	    $uriSegment		=	4;
        
        $totalRows		=	$this->model_pasien->getTotalRecordWhere($whereSql);
        $offset			=	$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy			=	" order by {$this->tbl_sort}";
		
		$arrData		=	$this->model_pasien->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		
		$config['base_url'] 	=	$this->module."pasien_list";  
        $config['per_page'] 	=	$perPage;  
        $config['total_rows'] 	=	$totalRows;
        $config['uri_segment']	=	$uriSegment;
        $config["suffix"]		=	$queryString;
        $config["first_url"]	=	$config["base_url"].$queryString;
        
		$this->pagination->initialize($config);
        
		$data["arrData"]=$arrData;
	
		$this->_render_page($this->module."v_list_pasien",$data,true);
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
			
			$arrData				=	$this->model->GetRecordData("idx_pasien=$id");
            $arrPasien				=	$this->model_pasien->GetRecordData("idx=$id");
			$arrJenisKegiatan		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
			$data['datax']			=	$arrData;
			$data['data']			=	$arrPasien;
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
				$config['upload_path']		=	$this->config->item("dir_peer_group");
				$config['file_name']		=	time().substr($data['lampiran_name'],strrpos($data['lampiran_name'],"."));
				$config['max_size']			=	"500000";
				$config['overwrite']		=	TRUE;
			
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('lampiran');
				
				$file						=	$this->upload->data();
				
				unlink($this->config->item('dir_peer_group').$data['lampiran_old']);
				$data['file']				=	$file['file_name'];
			endif;		
			
			/*
			$pertemuan		=	$data['idx_pertemuan'];
			if($pertemuan):
				$data['tgl_pertemuan_'.$pertemuan]	=	$data['tanggal'];
			endif;
			*/
			
			$start		=	$this->conn->StartTrans();
			$this->model->UpdateData($data, "{$this->tbl_idx_pasien}=$id");
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
	
	function view($id){
        
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		
		$arrData		=	$this->model->GetRecordData("idx_pasien=$id");
		$jenis_kegiatan	=	$this->model_jenis_kegiatan->GetRecordData("idx='".$arrData['idx_jenis_kegiatan']."' and ".$this->jenis_kegiatan_filter);
		$arrData['jenis_kegiatan']	=	$jenis_kegiatan['ur_jenis_kegiatan'];
		$arrPasien		=	$this->model_pasien->GetRecordData("idx=$id");
		
		$data["data"]	=	$arrPasien;
		$data["datax"]	=	$arrData;
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