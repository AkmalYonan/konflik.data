<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class discharge extends Admin_Controller {
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
		
		$this->model_jenis_kegiatan=new general_model("m_jenis_kegiatan");
		$this->jenis_kegiatan_filter = "kategori = 'da'";
		
        $this->model=new general_model("t_pasien");
		//$this->model_detox=new general_model("t_pasien_detox");
		$this->model_dsc=new general_model("t_pasca_discharge");
		$this->model_file=new general_model("t_pasca_discharge_file");
		//$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Data";
		$this->module_title="Discharge / Rujukan";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	

		$this->init_lookup();
		$lookhasil[1] ="TIdak Produktif";
		$lookhasil[2] ="Family Issue";
		$lookhasil[3] ="Social ";
		$lookhasil[4] ="Environment Issue";
		$lookhasil[5] ="Hukum";
		foreach($lookhasil as $k=>$v):
				$this->hsl_asses[$k]=$v;
		endforeach;
		
		$jnskegiatan = $this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
		foreach($jnskegiatan as $k=>$v){
			$this->lookjns_kgt[$v["kd_jenis_kegiatan"]] = $v["ur_jenis_kegiatan"]; 
		}
		
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
		$this->load->library('pagination');  
        $sql=" select a.*,b.tgl_p1,b.tgl_p2,b.hasilp1,b.hasilp2,b.lokasi,b.jml_anggota,b.keterangan,b.nm_petugas from ".$this->model->tbl." a 
                left join ".$this->model_dsc->tbl." b on a.idx=b.idx_pasien
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

		// $where[]="(status_rehab=3 and status_rawat='PASCARJ')";
		$where[]="(status_rehab=3 and status_proses='PRRIDR')";
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
	
	
	function update_proses($id=false){		
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
        //debug();
	   	
	    $data=get_post();
		
		$act=$this->input->post("act")?$this->input->post("act"):"";   
	   	if($act=="update"):
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_dr");
			$config['max_size']			=	"5000000000";
			$config['overwrite']		=	TRUE;
			$new_name = time()."_".$_FILES["lampiran"]['name'];
			$config['file_name'] = $new_name;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('lampiran');
			$file						=	$this->upload->data();
			$ext						=	$file['file_ext'];
			if(($ext==".doc") || ($ext==".docx") || ($ext==".xls") || ($ext==".xlsx") || ($ext==".txt") || ($ext==".zip") || ($ext==".rar") || ($ext==".jpg") || ($ext==".jpeg") || ($ext==".pdf") || ($ext==".png")):
				$data["lampiran"]			=	$new_name;
			endif;
			
			$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			$idx=$data["idx"];
			
			// $this->update_doc($id);
			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="PRRIDR"; 
				$data_update["status_rehab"]=3;
				$data_update["status_rawat"]="PASCA";
			else:
				$data_update["status_proses"]="PRRIDR";
				$data_update["status_rehab"]=3;
				$data_update["status_rawat"]="PASCA";
			endif;
			$this->model->UpdateData($data_update,"idx=$id");
			
			$this->model_dsc->UpdateData($data, "idx=$idx");
			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;
	   
	   if($act=="create"):
			
			unset($data["idx"]);
			$data=$this->_add_creator($data);
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_da");
			$config['max_size']			=	"5000000000";
			$config['overwrite']		=	TRUE;
			$new_name = time()."_".$_FILES["lampiran"]['name'];
			$config['file_name'] = $new_name;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('lampiran');
			$file						=	$this->upload->data();
			$ext						=	$file['file_ext'];
			if(($ext==".doc") || ($ext==".docx") || ($ext==".xls") || ($ext==".xlsx") || ($ext==".txt") || ($ext==".zip") || ($ext==".rar") || ($ext==".jpg") || ($ext==".jpeg") || ($ext==".pdf") || ($ext==".png")):
				$data["lampiran"]			=	$new_name;
			endif;
			
			$id_pasien = $data['idx_pasien'];
			$this->conn->StartTrans();
			
			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="PRRIDR"; 
				$data_update["status_rehab"]=3;
				$data_update["status_rawat"]="PASCA";
			else:
				$data_update["status_proses"]="PRRIDR";
				$data_update["status_rehab"]=3;
				$data_update["status_rawat"]="PASCA";
			endif;
			$this->model->UpdateData($data_update,"idx=$id");
			
			// $dataz["status_rehab"] = 3;
			// $dataz["status_rawat"] = 'PASCARJ';
			// $this->model->UpdateData($dataz, "idx='$id_pasien'");
			
			$this->model_dsc->InsertData($data);
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;
		
	}
	function view_detail($id){
        
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		
		$arrData		=	$this->model_dsc->GetRecordData("idx_pasien=$id");
		$arrPasien		=	$this->model->GetRecordData("idx=$id");
		
		$data["data"]	=	$arrData;
		$data["pasien"]	=	$arrPasien;
		$data['id']		=	$id_enc;
       	
		$this->_render_page($this->module."v_detail",$data,true);       
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
	function view($id){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		$arrData=$this->model->GetRecordData("idx=$id");
		$dataDoc=$this->model_file->SearchRecordWhere("id_parent=$id");
		
		$dataDocJenisDoc=array();
			if(cek_array($dataDoc)):
					foreach($dataDoc as $file):
						$dataDocJenisDoc[$file["id_jenis_doc"]][]=$file;
					endforeach;
		endif;
			
		$data["data_doc"]=$dataDocJenisDoc;
		$data["jns_kegiatan"]		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
		$data["data"]=$arrData;
		$data["data_proses"]=$this->model_dsc->GetRecordData("idx_pasien=$id");
		$this->_render_page($this->module."v_view",$data,true);
        
     }
	
	function pasien_list(){
		
		$this->load->library('pagination'); 
		
        $table			=	$this->model->tbl;
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
		$where[]="(status_rehab=3 and status_proses='PRRIDR')";
        $whereSql		=	"";
        if(cek_array($where)):
            $whereSql	.=	join(" and ",$where);
        endif;
       
		$perPage		=	$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=	$perPage;
		$uriSegment		=	4;
        
        $totalRows			=	$this->model->getTotalRecordWhere($whereSql);
        $offset				=	$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        
		$sortBy				=	" order by {$this->tbl_sort}";
		$arrData			=	$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		
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

	
	
	function del_proses($id,$idx){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        
		
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
      
        //$arrData=$this->model->GetRecordData("{$this->tbl_idx}=$idx");
        $act="delete";    
        if($act=="delete"):
            $this->conn->StartTrans();
            $this->model_eu->DeleteData("idx=$idx");
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
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
		//start
		$act="delete";    
        if($act=="delete"):
            $this->conn->StartTrans();
				//Update Status Rehab3 ke 0
				$dataz["status_rehab"] = 0;
				$dataz["status_rawat"] = '';
				$this->model->UpdateData($dataz, "idx='$id'");
				$this->model_dsc->DeleteData("idx_pasien=$id");
				
			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview",$this->module."listview/");
        endif;
    }
	
	
	  function get_array_idx(){
		$sql			=	"select idx_pasien from ".$this->model_dsc->tbl;		
		$array			=	$this->conn->GetAll($sql);		
		
		foreach($array as $k=>$v):
			$arr[$k]	=	$v['idx_pasien'];
		endforeach;		
		$series			=	join(",",$arr);		
		return $series;
	 }
	 
	 
	 
	 

}