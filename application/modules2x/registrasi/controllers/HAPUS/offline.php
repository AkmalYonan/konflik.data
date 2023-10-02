<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class offline extends Admin_Controller {
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
		$this->model_file=new general_model("t_pasien_file");
		$this->offline_model=$this->load->model("registrasi/offline_model");
		
		$this->model_file_offline=new general_model("t_pasien_registrasi_offline_file");
		
		$this->model_foto=new general_model("t_pasien_foto");
		$this->model_foto_upload=new general_model("t_pasien_foto_file_upload");
		
		$this->model_finger_fmd=new general_model("t_pasien_finger_fmd");
		$this->model_finger_foto=new general_model("t_pasien_finger_foto");
		$this->model_finger_identification=new general_model("t_pasien_finger_identification");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");
		
		$this->model_pasien_history=new general_model("t_pasien_history");
		$this->model_pasien_history_pasca=new general_model("t_pasien_history_pasca");
		$this->model_pasien_history_lanjut=new general_model("t_pasien_history_lanjut");
		
		$this->model_monitoring_rehab=new general_model("t_pasien_monitoring_rehab");		
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="PENDAFTARAN REHABILITASI";
		$this->module_title="Offline";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		
		//add
		$this->lookup_bnnp=lookup("m_org","kd_org","nama",false,"order by idx");
		$this->lookup_inst=lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
		
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
	 	//$this->listview();
		$this->_render_page($this->module."v_add",$data,true);
	 }
	 function reg_baru(){
	 	
		$data['daftar_no_rekam_medis']	=	$this->offline_model->GetDaftarNoRekamMedis();
		$data['daftar_nik']				=	$this->offline_model->GetDaftarNik();
		
		$this->_render_page($this->module."v_add_baru",$data,true);	
	 }
	 function reg_lama($id){
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$arrData = $this->model_pasien->GetRecordData("idx='".$id."'");
		if (cek_array($arrData) && $arrData['active_pasien']!='1') {
			$data['data'] = $arrData;	
			$this->_render_page($this->module."v_add_lama",$data,true);	
		}
		else {
			redirect($this->module."pasien_lama"); 
		}
	 }

	 function pasien_lama(){
		
		$this->load->library('pagination');  
        //$sql=" select a.*,b.realname,b.path from ".$this->model->tbl." a 
          //      left join ".$this->model->tbl."_file b on a.idx=b.id_parent
        //";
		
		$table=$this->model_pasien->tbl;    
        //$table="($sql) a";
		$queryString=rebuild_query_string(); 
		$data_type=$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        
        $col_text=$data["text"];
		$field=join(",",$col_text);
        $whereSql=get_where_from_searchbox($field);
		
		
		if($this->user_prop):			
			if($this->user_instansi):
				if($this->user_instansi=="BL"):
					$where[]	=	"jns_org='2'";
				elseif($this->user_instansi=="KM"):
					$where[]	=	"jns_org='4'";
				elseif($this->user_instansi=="RD"):
					$where[]	=	"jns_org='5'";
				endif;
			endif;			
			$where[]	=	"substr(kd_bnn,1,5)='".$this->user_prop."-".$this->user_kab."'";	
		endif;
		
		$where[]	=	"active_pasien<>'1'";
		
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
        
        $totalRows=$this->model_pasien->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";

		$arrData=$this->model_pasien->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		$config['base_url'] = $this->module."listview";
		 
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		
        $data["arrData"]=$arrData;
		$data["lookup_bnnp"]=lookup("m_org","kd_org","nama",false,"order by idx");
		$data["lookup_inst"]=lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");	
		$data["lookup_jns_org"]=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org",false,"order by idx");		
		
		$this->_render_page($this->module."v_list",$data,true);
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
	
	function add_pasien_baru(){
	 	$this->msg_ok="Data Telah Tesimpan, Mohon Periksa Pada Daftar Tunggu Pasien";
        $this->msg_fail="Penambahan Data Gagal";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $arr['nik']			=	$nik;
			$arr['no_rekam_medis']	=	$no_rekam_medis;
			
			$data['data']		=	$arr;
			
            $this->_render_page($this->module."v_add_pasien_baru",$data,true);
        endif;
		
        if($act=="create"):
			$data	=	get_post();
				
			$data=$this->_add_creator($data);
			$data['active_pasien']=1;
							
			$exp	=	explode("-",$data['kd_bnn']);					
			$data['kd_wilayah']				=	$exp[0].$exp[1];
			$data['kd_wilayah_propinsi']	=	$exp[0];		
				// pre($data);exit;
			$this->conn->StartTrans();
			$this->model_pasien->InsertData($data);
				
			$id_last=$this->model_pasien->GetLastID("idx");
			$this->update_file_peta($id_last);
			
			$this->update_doc($id_last);
			if($data["status_rehab"]):
				$this->update_status($id_last,$data,"RG"); //current status registrasi
			endif;

			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module,$this->module);
			
        endif;
    }	
	
	function edit($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data Telah Tesimpan, Mohon Periksa Pada Daftar Tunggu Pasien";
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
			$data=$this->_add_editor($data);
			
			$exp	=	explode("-",$data['kd_bnn']);
			
			$data['kd_wilayah']	=	$exp[0].$exp[1];
			$data['kd_wilayah_propinsi']	=	$exp[0];
			$data['active_pasien']	=	1;
			
			$this->conn->StartTrans();
			$this->model_pasien->UpdateData($data, "{$this->tbl_idx}=$id");
			
			if($data["status_proses"]):
				$this->update_status($id,$data,"RG"); //current status registrasi
			endif;
			
			$ok=$this->conn->CompleteTrans();
			
			$this->_proses_message($ok,$this->module,$this->module);
			
        endif;     
	}

	function update_status($id,$data,$current_status_rehab){
			
			$status_proses=$data["status_proses"];
			
			if($data["status_check_doc"]==2):
				$data_proses=$this->conn->GetRow("select * from m_proses_rehab where kd_status_proses='".$status_proses."'");
				$data["status_rehab"]=$data_proses["kd_status_rehab"];
				if($status_proses!=$current_status_rehab):
					$data["status_check_doc"]=0;
				endif;
			else:
				$data["status_proses"]=$current_status_rehab; //registrasi
				$data["status_rehab"]=1; //registrasi
			endif;
			$status_rawat=substr($status_proses,0,2);
			$status_rawat_inap=substr($status_proses,0,4);
			$data["status_rawat_inap"]="";
			$data["status_rawat"]="";
			if($status_rawat=='RI'):
				$data["status_rawat"]='INAP';
				$data["status_rawat_inap"]=$status_rawat_inap;
			endif;
			if($status_rawat=='RJ'):
				$data["status_rawat"]='JALAN';
			endif;
			if($status_rawat=='PR'):
				$data["status_rawat"]='PASCA';
			endif;
			
			$data_update["status_rehab"]=$data["status_rehab"];
			$data_update["status_proses"]=$data["status_proses"];
			$data_update["status_check_doc"]=$data["status_check_doc"];
			$data_update["status_rawat_inap"]=$data["status_rawat_inap"];
			$data_update["status_rawat"]=$data["status_rawat"];
			
			$this->model_pasien->UpdateData($data_update,"idx=$id");	
		
	}
	
	function view($id){
		$this->module_title="Detil Pasien";
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData=$this->model_pasien->GetRecordData("idx=$id");
		//$arrDataFile=$this->model_file->SearchRecordWhere("id_parent=$id");
		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id");
		$idx_assesment = $arrDataAsm['idx'];
			
		$data["rehab_stat"]	=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");
		$data["pasca_stat"]	=$this->model_pasien_history_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");	
		$data["lanjut_stat"]=$this->model_pasien_history_lanjut->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");	
		//History Add
		$allDataAsm=$this->model_assesment_summary->SearchRecordWhere("idx_pasien=$id");
		foreach($allDataAsm as $k=>$v){
			$allDataAsm[$k]["monitoring_rehab"] =$this->model_monitoring_rehab->GetRecordData("idx_pasien=".$id." and idx_assesment='".$v['idx']."'");
		}
		
		$data["assestment"]=$allDataAsm;
		$data["data"]=$arrData;
		
		//debug();
		$rh_pasien	=	rh_pasien($id);
		//pre($rh_pasien);exit;
		
		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];
		
		//pre($data);exit;
		
		//$data["data_file"]=$arrDataFile;
       	$this->_render_page($this->module."v_view",$data,true);
        
     }		
	 
	 function delete_file($id=false){
	 	$this->conn->StartTrans();
		$this->model_file_offline->DeleteData("id_file=$id");
		$ok=$this->conn->CompleteTrans();
		if($ok):
			$this->delete_file_proses($id);
		else:
			print "failed";
		endif;
	}
	
	function delete_file_proses($id=false){
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
	
	function update_file_peta($id_parent){
		// debug();
		$file_arr=$this->input->post("peta_file_id");
        if(!cek_array($file_arr)):
			return true;
		endif;
		
        if(cek_array($file_arr)):
            $whereIn="idx in(".join(",",$file_arr).")";
            
            $arrFile=$this->adodbx->search_record_where("t_file_upload",$whereIn);
			// pre($arrFile);exit;
            if(cek_array($arrFile)):
                $this->model_file_offline->DeleteData("id_parent=$id_parent");
                foreach($arrFile as $file):
                    $dataInsert=array();
					$dataInsert=$file;
					unset($dataInsert["idx"]);
                    $dataInsert["id_file"]=$file["idx"];
                    $dataInsert["id_parent"]=$id_parent;
                    $dataInsert["file_name"]=$file["file_name"];
                    $dataInsert["file_path"]=$file["relative_path"];
                    
					// $dataInsert=$this->_add_creator($dataInsert);
                    $dataInsert["ip_address"]=$file["ip_client"];
                    if(empty($file["ip_client"])):
                        $dataInsert=$this->_add_ip_address($dataInsert);
                    endif;
                    //pre($dataInsert);
                    $this->model_file_offline->InsertData($dataInsert);
                endforeach;
            endif;
        endif; 
        
    }
	
}