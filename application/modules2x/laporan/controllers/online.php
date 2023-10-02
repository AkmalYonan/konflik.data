<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class online extends Admin_Controller {
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
        $this->model=new general_model("t_pasien_registrasi_online");
		$this->model_pasien=new general_model("t_pasien");
		$this->model_pendaftar=new general_model("t_user_online");
		$this->model_file=new general_model("t_pasien_registrasi_online_file");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Data";
		$this->module_title="Registrasi Online";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		//debug();
		//
		//exit();
		//debug();
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
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
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
        if(empty($act)):
            $arrData=$this->model->GetRecordData("idx=$id");
            $data["data"]=$arrData;
			$this->_render_page($this->module."v_edit",$data,true);
        endif;
		
		if($act=="update"):
			$data=get_post();
			$data["active"]=$data["active"]?1:0;
			//$data=$this->_add_editor($data);
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
		$idx_pendaftar=$arrData["idx_pendaftar"];
		
		$arrPendaftar=$this->model_pendaftar->GetRecordData("idx=$idx_pendaftar");
		//$arrDataFile=$this->model_file->SearchRecordWhere("id_parent=$id");
		
        $data["data"]=$arrData;
		$data["pasien"]=$arrData;
		$data["pendaftar"]=$arrPendaftar;
		
		//$data["data_file"]=$arrDataFile;
       	$this->_render_page($this->module."v_view",$data,true);
        
     }
	 
	 
	 function verifikasi($id){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
       
        $act=$this->input->post("act")?$this->input->post("act"):"";  
		//$act="verifikasi";  
        if(empty($act)):
			$arrData=$this->model->GetRecordData("idx=$id");
			$idx_pendaftar=$arrData["idx_pendaftar"];
			
			$arrPendaftar=$this->model_pendaftar->GetRecordData("idx=$idx_pendaftar");
			//$arrDataFile=$this->model_file->SearchRecordWhere("id_parent=$id");
			
			$data["data"]=$arrData;
			$data["pasien"]=$arrData;
			$data["pendaftar"]=$arrPendaftar;
			
			$dataDoc=$this->model_file->SearchRecordWhere("id_parent=$id");
		
			$dataDocJenisDoc=array();
			if(cek_array($dataDoc)):
					foreach($dataDoc as $file):
						$dataDocJenisDoc[$file["id_jenis_doc"]][]=$file;
					endforeach;
			endif;
			
			$data["data_doc"]=$dataDocJenisDoc;
			//$data["data_file"]=$arrDataFile;
			$this->_render_page($this->module."v_verifikasi",$data,true);
        endif;
		
		if($act=="verifikasi"):
			$data=get_post();
			//debug();
			//pre($data);
			$data["flag_konfirmasi"]=$data["flag_konfirmasi"]?1:0;
			//$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			
			$data["status"]=1;
			$data["flag_verifikasi"]=0;
			if($data["status_check_doc"]==2):
				$data["flag_verifikasi"]=1;
				$data["tgl_verifikasi"]=date("Y-m-d H:i:s");
			endif;
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
            
			
			//$this->update_doc($id);
			
			//debug();
			//if verifikasi ok insert into t_pasien
			/*
			$status=$data["status"];
			$data_request=$data;
			if($status==2): //ok
				$data=array();
				$data=$this->model->GetRecordData("idx=$id");
				pre($data);
				unset($data["idx"]);
				unset($data["created"]);
				unset($data["deleted"]);
				unset($data["creator"]);
				unset($data["editor"]);
				$data["periode_bulan"]=$data["bulan"];
				$data["periode_tahun"]=$data["tahun"];
				$data["status_proses"]=1; //registrasi
				$data["status_rehab"]=1; //registrasi
				
				$data=$this->_add_creator($data);
				$idx_pasien=$data["idx_pasien"];
				if($idx_pasien>0):
					$this->model_pasien->DeleteData("idx=$idx_pasien");
				endif;
				$this->model_pasien->InsertData($data);
				$id_last=$this->model_pasien->GetLastID("idx");
				
				$pasien=$this->model_pasien->GetRecordData("idx=$id_last");
				
				//update idx_pasien 
				$dataUpdate["idx_pasien"]=$id_last;
				$this->model->UpdateData($dataUpdate,"idx=$id");
				
			endif; //end ok
			*/
			
			
			
			$ok=$this->conn->CompleteTrans();
			
			$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."verifikasi/$id_enc");
        endif;
		
        
        
     }
	 
	 function rekam_medis($id){
		 if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
       
        $act=$this->input->post("act")?$this->input->post("act"):"";  
		//$act="verifikasi";  
        if(empty($act)):
			$arrData=$this->model->GetRecordData("idx=$id");
			$idx_pendaftar=$arrData["idx_pendaftar"];
			
			$arrPendaftar=$this->model_pendaftar->GetRecordData("idx=$idx_pendaftar");
			//$arrDataFile=$this->model_file->SearchRecordWhere("id_parent=$id");
			
			$data["data"]=$arrData;
			$data["pasien"]=$arrData;
			$data["pendaftar"]=$arrPendaftar;
			
			$dataDoc=$this->model_file->SearchRecordWhere("id_parent=$id");
		
			$dataDocJenisDoc=array();
			if(cek_array($dataDoc)):
					foreach($dataDoc as $file):
						$dataDocJenisDoc[$file["id_jenis_doc"]][]=$file;
					endforeach;
			endif;
			
			$data["data_doc"]=$dataDocJenisDoc;
			//$data["data_file"]=$arrDataFile;
			$this->_render_page($this->module."v_rekam_medis",$data,true);
        endif;
		
		if($act=="update"):
			$data=get_post();
			//debug();
			//pre($data);
			
			$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			
			$data["flag_rekam_medis"]=$data["flag_rekam_medis"]?1:0;
			if($data["flag_rekam_medis"]==1):
				$data["status"]=2;
				$data["status_check_doc"]=2;
			endif;
			
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
            
			$this->update_doc($id);
			
			//if verifikasi ok insert into t_pasien
			
			$status=$data["status"];
			$data_request=$data;
			if($status==2): //ok
				$data=array();
				$data=$this->model->GetRecordData("idx=$id");
				//pre($data);
				unset($data["idx"]);
				unset($data["created"]);
				unset($data["deleted"]);
				unset($data["creator"]);
				unset($data["editor"]);
				//$data["periode_bulan"]=$data["bulan"];
				//$data["periode_tahun"]=$data["tahun"];
				$data["status_rehab"]=1; //registrasi
				$data["status_proses"]='RG'; //assesment
				$data["status_check_doc"]=2; //menunggu assesment
				
				$data=$this->_add_creator($data);
				$idx_pasien=$data["idx_pasien"];
				if($idx_pasien>0):
					$this->model_pasien->DeleteData("idx=$idx_pasien");
				endif;
				$this->model_pasien->InsertData($data);
				$id_last=$this->model_pasien->GetLastID("idx");
				
				$pasien=$this->model_pasien->GetRecordData("idx=$id_last");
				
				//update idx_pasien 
				$dataUpdate["idx_pasien"]=$id_last;
				$this->model->UpdateData($dataUpdate,"idx=$id");
				
			endif; //end ok
			
			
			
			
			$ok=$this->conn->CompleteTrans();
			
			$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."rekam_medis/$id_enc");
        endif;
	 }
	 
	
	function update_doc($id_parent){
        
		$file_arr=$this->input->post("upload_file_id");
		//$file_tipe_arr=$this->input->post("tipe_doc"); //if has tipe like foto , surat pendukung dll
        //$dasar_surat_arr=$this->input->post("dasar_surat"); //if has tipe like foto , surat pendukung dll
        $id_jenis_doc_arr=$this->input->post("id_jenis_doc");
		if(!cek_array($file_arr)):
			return true;
		endif;
		
		
        foreach($file_arr as $x=>$val):
            $id_jenis_doc[$val]=$id_jenis_doc_arr[$x];
            //$dasar_surat[$val]=$dasar_surat_arr[$x];
        endforeach;
        
		
        if(cek_array($file_arr)):
            $whereIn="idx in(".join(",",$file_arr).")";
            
            $arrFile=$this->adodbx->search_record_where("t_file_upload",$whereIn);
            if(cek_array($arrFile)):
				$doc_list=$this->input->post("doc_list");
				$doc_list_arr=preg_split("/\,/",$doc_list);
				$doc_list_in="'".join("','",$doc_list_arr)."'";
                $this->model_file->DeleteData("id_parent=$id_parent and id_jenis_doc in (".$doc_list_in.")");
                foreach($arrFile as $file):
                    $dataInsert=array();
					$dataInsert=$file;
					unset($dataInsert["idx"]);
                    $dataInsert["id_file"]=$file["idx"];
                    $dataInsert["tipe_doc"]="file";
					//$dataInsert["tipe_doc"]=$type_doc[$file["idx"]];
                    //$dataInsert["dasar_surat"]=$dasar_surat[$file["idx"]];
					$dataInsert["id_jenis_doc"]=$id_jenis_doc[$file["idx"]];
                    $dataInsert["id_parent"]=$id_parent;
                    $dataInsert["file_name"]=$file["file_name"];
                    $dataInsert["file_path"]=$file["relative_path"];
                    $dataInsert=$this->_add_creator($dataInsert);
                    $dataInsert["ip_address"]=$file["ip_client"];
                    if(empty($file["ip_client"])):
                        $dataInsert=$this->_add_ip_address($dataInsert);
                    endif;
                    //pre($dataInsert);
                    $this->model_file->InsertData($dataInsert);
                endforeach;
            endif;
        endif; 
        
    }
	
	
	 function delete_upload_file($id=false){
	 	$this->conn->StartTrans();
		$this->model_file->DeleteData("id_file=$id");
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
	 	$file=$this->conn->GetRow("select * from t_file_upload where idx=$id");
	 	$ok=$this->conn->Execute("delete from t_file_upload where idx=$id");
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
	 
	 
	 

}