<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pasca_rehab extends Admin_Controller {
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
		// $this->model_currently=new general_model("t_pasien_curently");
		$this->model_pasien_assesment_history=new general_model("t_pasien_assesment_history");
		//$this->model_detox=new general_model("t_pasien_detox");
		$this->model_pr=new general_model("t_pasca_rehab");
		$this->model_file=new general_model("t_pasca_rehab_file");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");
		
		$this->model_pasien_history=new general_model("t_pasien_history");
		$this->model_monitoring_rehab=new general_model("t_pasien_monitoring_rehab");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="PASCA REHABILITASI";
		$this->module_title="Form Penerimaan";
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
	 }

	 function listview(){
		$this->load->library('pagination');  
        $sql=" select a.*,b.hasil_assesment,b.ketrampilan,b.resume_rehab,b.keterangan,b.tgl_penerimaan_pascarehab,b.lampiran,b.tinjauan_rencana_terapi from ".$this->model->tbl." a 
                left join ".$this->model_pr->tbl." b on a.idx=b.idx_pasien and b.active_pasien=1
        ";
		//$table=$this->model->tbl;  
		// debug();
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
		
		if($this->user_prop):			
			if($this->user_instansi):
				$where[]	=	"(inst_pasca='".$this->user_instansi."')";
				$where[]	=	"rujuk_pasca='".$this->user_org."'";	
			endif;
		endif;
		
		$where[]="(status_rehab='3' and status_proses='PRAP')";
		
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
		$data["lookup_bnnp"]=lookup("m_org","kd_org","nama",false,"order by idx");
		$data["lookup_inst"]=lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");	
		$data["lookup_jns_org"]=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org",false,"order by idx");
		
		// pre($arrData);
		// exit;
		$this->_render_page($this->module."v_list",$data,true);
    }
	
	
	function update_proses($id=false){

		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
        
	   	
	    $data=get_post();
		// debug();
		// pre($data);exit;
		$act=$this->input->post("act")?$this->input->post("act"):"";   
	   	if($act=="update"):
			//$data["active"]=$data["active"]?1:0;
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_penerimaan_pasca");
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
			
			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				// $data_update["kd_wilayah"]=$kdw;
				$kdwil=$kdw;
				$rujuk_pasca=$data["kd_wilayah"];
				$data_update["status_rawat"]='JALAN';
				$data["rujuk_pasca"]=$rujuk_pasca;	
			elseif(!empty($data["id_kabupaten"])):
				// $data_update["kd_wilayah"]=$data["id_kabupaten"];
				$kdwil=$data["id_kabupaten"];
				$rujuk_pasca=$data["id_kabupaten"];
				$data_update["status_rawat"]=$data["status_rawat"];
				$data_update["status_rawat"]='INAP';
				$data["rujuk_pasca"]=$rujuk_pasca;
				$piece = explode("-",$data["id_kabupaten"]);
				$kdwil_ori=$piece[0].$piece[1];
			elseif(!empty($data["id_km"])):
				// $data_update["kd_wilayah"]=$data["id_km"];
				$kdwil=$data["id_km"];
				$rujuk_pasca=$data["id_km"];
				$data_update["status_rawat"]='INAP';
				$data["rujuk_pasca"]=$rujuk_pasca;
				$piece = explode("-",$data["id_km"]);
				$kdwil_ori=$piece[0].$piece[1];
			elseif(!empty($data["id_rd"])):
				// $data_update["kd_wilayah"]=$data["id_rd"];
				$kdwil=$data["id_rd"];
				$rujuk_pasca=$data["id_rd"];
				$data_update["status_rawat"]='INAP';
				$data["rujuk_pasca"]=$rujuk_pasca;
				$piece = explode("-",$data["id_rd"]);
				$kdwil_ori=$piece[0].$piece[1];
			endif;
			$status_proses=$data["status_proses"];
			$status_rawat=substr($status_proses,0,2);
			$status_rawat_inap=substr($status_proses,0,4);
			$cek_dok=$data["status_check_doc"];
			if($data["status_check_doc"]==2):
				$data["active_pasien"]=0;
				if($data["rawat"]=='1'): //inap
					if($status_proses=='BL' || $status_proses=='RD' || $status_proses=='KM'):
						// $data_update["inst_lanjut"]=$status_proses;
						$data["status_proses"]="PRRIDA"; //inap daily activity
						$data_update["rujuk_pasca"]=$kdwil;
						$data["rujuk_pasca"]=$kdwil;
						$data_update["kd_wilayah"]=$kdwil_ori;
						$stt_rawat_pasca="INAP";
					elseif($status_proses=='BNNP' || $status_proses=='BNNK'):
						// $data_update["inst_lanjut"]=$status_proses;
						$data["status_proses"]="PRRJPG"; //jalan peer group
						$data_update["rujuk_pasca"]=$data["kd_wilayah"];
						$data["rujuk_pasca"]=$data["kd_wilayah"];
						$data_update["kd_wilayah"]=$kdwil;
						$stt_rawat_pasca="JALAN";
					endif;
					$data["status_check_doc"]=0; //0belum 1proses 2ok/valid/selesai 9tolak
					$data_update["inst_lanjut"]=NULL;
					$data_update["rujuk_lanjut"]=NULL;
					$data_update["inst_pasca"]=$status_proses; 
					
					$data_update["status_rehab"]=3;
					
					$data["inst_pasca"]=$status_proses; 
					$data["inst_lanjut"]=NULL;
					$data["rujuk_lanjut"]=NULL;
					
				elseif($data["rawat"]=='2'): //jalan
					if($status_proses=='BL' || $status_proses=='RD' || $status_proses=='KM'):
						// $data_update["inst_lanjut"]=$status_proses;
						$data["status_proses"]="PRRIDA"; //inap daily activity
						$data_update["rujuk_pasca"]=$kdwil;
						$data["rujuk_pasca"]=$kdwil;
						$data_update["kd_wilayah"]=$kdwil_ori;
						$stt_rawat_pasca="INAP";
					elseif($status_proses=='BNNP' || $status_proses=='BNNK'):
						// $data_update["inst_lanjut"]=$status_proses;
						$data["status_proses"]="PRRJPG"; //jalan peer group
						$data_update["rujuk_pasca"]=$data["kd_wilayah"];
						$data["rujuk_pasca"]=$data["kd_wilayah"];
						$data_update["kd_wilayah"]=$kdwil;
						$stt_rawat_pasca="JALAN";
					endif;
					$data["status_check_doc"]=0; //0belum 1proses 2ok/valid/selesai 9tolak
					$data_update["inst_lanjut"]=NULL;
					$data_update["rujuk_lanjut"]=NULL;
					$data_update["inst_pasca"]=$status_proses; 
					
					$data_update["status_rehab"]=3;
					
					$data["inst_pasca"]=$status_proses; 
					$data["inst_lanjut"]=NULL;
					$data["rujuk_lanjut"]=NULL;	
					
				elseif($data["rawat"]=='3'): //lanjut
					if($status_proses=='BL' || $status_proses=='RD' || $status_proses=='KM'):
						$data["status_proses"]="PRRLPUKP"; //inap daily activity
						$data_update["rujuk_lanjut"]=$kdwil;
						$data["rujuk_lanjut"]=$kdwil;
						$data_update["kd_wilayah"]=$kdwil_ori;
					elseif($status_proses=='BNNP' || $status_proses=='BNNK'):
						$data["status_proses"]="PRRLPUKP"; //jalan peer group
						$data_update["rujuk_lanjut"]=$data["kd_wilayah"];
						$data["rujuk_lanjut"]=$data["kd_wilayah"];
						$data_update["kd_wilayah"]=$kdwil;
					endif;
					$data["status_check_doc"]=0; //0belum 1proses 2ok/valid/selesai 9tolak
					$data_update["inst_pasca"]=NULL;
					$data_update["rujuk_pasca"]=NULL;
					$data_update["inst_lanjut"]=$status_proses; 
					$stt_rawat_pasca="LANJUT";
					// $data_update["kd_wilayah"]=$kdwil;
					
					$data["inst_lanjut"]=$status_proses; 
					$data["inst_pasca"]=NULL;
					$data["rujuk_pasca"]=NULL;
				endif;	
			else:
				$data["active_pasien"]=1;
				$data["status_proses"]="PRAP"; //pasca penerimaan dulu assesmen pra
				$data["status_rehab"]=3; //rehab
				$stt_rawat_pasca="";
				
				$data["inst_pasca"]=$status_proses; 
				$data["inst_lanjut"]=NULL;
				$data["rujuk_lanjut"]=NULL;
			endif;
			$data["status_rawat_inap"]="";
			$data_update["status_rawat"]='PASCA';
			$data_update["status_rehab"]=3;

			$data_update["status_proses"]=$data["status_proses"];
			$data_update["status_check_doc"]=$data["status_check_doc"];
			$data_update["status_rawat_inap"]=$data["status_rawat_inap"];
			
			$this->model->UpdateData($data_update,"idx=$id");
			$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			// debug();
			if($cek_dok==2):
				$data_update['tgl_mulai_pasca']=$data['tgl_selesai'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				$dataMonitoring['tgl_mulai_pasca']=$data['tgl_selesai'];
				$dataMonitoring['status_rawat_pasca']=$stt_rawat_pasca;
				update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);
				// debug();
				update_status_program_pasca($id,$data['idx_assesment']);
				// exit;
			endif;
			// exit;
			
			$idx=$data["idx"];
			$hasil_asses = implode(",",$data["hasil_assesmentx"]);
			$data["hasil_assesment"] = $hasil_asses;
			$this->model_pr->UpdateData($data, "idx=$idx");
			// pre($data);
			// pre($data_update);
			// exit;
			$ok=$this->conn->CompleteTrans();
			
			if($cek_dok != 2):
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			else:
				redirect($this->module."view_detail/".$id_enc);
			endif;
			
			//$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;
	   // debug();
	   if($act=="create"):

			unset($data["idx"]);
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_penerimaan_pasca");
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
			$data=$this->_add_creator($data);
			// $this->update_doc($id);
			
			$id_pasien = $data['idx_pasien'];
			$this->conn->StartTrans();
			$cek_dok=$data["status_check_doc"];
			//cek status_proses && update status
			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				// $data_update["kd_wilayah"]=$kdw;
				$kdwil=$kdw;
				$rujuk_pasca=$data["kd_wilayah"];
				$data_update["status_rawat"]='JALAN';
				$data["rujuk_pasca"]=$rujuk_pasca;	
			elseif(!empty($data["id_kabupaten"])):
				// $data_update["kd_wilayah"]=$data["id_kabupaten"];
				$kdwil=$data["id_kabupaten"];
				$rujuk_pasca=$data["id_kabupaten"];
				$data_update["status_rawat"]=$data["status_rawat"];
				$data_update["status_rawat"]='INAP';
				$data["rujuk_pasca"]=$rujuk_pasca;
				$piece = explode("-",$data["id_kabupaten"]);
				$kdwil_ori=$piece[0].$piece[1];
			elseif(!empty($data["id_km"])):
				// $data_update["kd_wilayah"]=$data["id_km"];
				$kdwil=$data["id_km"];
				$rujuk_pasca=$data["id_km"];
				$data_update["status_rawat"]='INAP';
				$data["rujuk_pasca"]=$rujuk_pasca;
				$piece = explode("-",$data["id_km"]);
				$kdwil_ori=$piece[0].$piece[1];
			elseif(!empty($data["id_rd"])):
				// $data_update["kd_wilayah"]=$data["id_rd"];
				$kdwil=$data["id_rd"];
				$rujuk_pasca=$data["id_rd"];
				$data_update["status_rawat"]='INAP';
				$data["rujuk_pasca"]=$rujuk_pasca;
				$piece = explode("-",$data["id_rd"]);
				$kdwil_ori=$piece[0].$piece[1];
			endif;
			$status_proses=$data["status_proses"];
			$status_rawat=substr($status_proses,0,2);
			$status_rawat_inap=substr($status_proses,0,4);
			if($data["status_check_doc"]==2):
				$data["active_pasien"]=0;
				if($data["rawat"]=='1'): //inap
					if($status_proses=='BL' || $status_proses=='RD' || $status_proses=='KM'):
						// $data_update["inst_lanjut"]=$status_proses;
						$data["status_proses"]="PRRIDA"; //inap daily activity
						$data_update["rujuk_pasca"]=$kdwil;
						$data["rujuk_pasca"]=$kdwil;
						$data_update["kd_wilayah"]=$kdwil_ori;
						$stt_rawat_pasca="INAP";
					elseif($status_proses=='BNNP' || $status_proses=='BNNK'):
						// $data_update["inst_lanjut"]=$status_proses;
						$data["status_proses"]="PRRJPG"; //jalan peer group
						$data_update["rujuk_pasca"]=$data["kd_wilayah"];
						$data["rujuk_pasca"]=$data["kd_wilayah"];
						$data_update["kd_wilayah"]=$kdwil;
						$stt_rawat_pasca="JALAN";
					endif;
					$data["status_check_doc"]=0; //0belum 1proses 2ok/valid/selesai 9tolak
					$data_update["inst_lanjut"]=NULL;
					$data_update["rujuk_lanjut"]=NULL;
					$data_update["inst_pasca"]=$status_proses; 
					
					$data_update["status_rehab"]=3;
					
					$data["inst_pasca"]=$status_proses; 
					$data["inst_lanjut"]=NULL;
					$data["rujuk_lanjut"]=NULL;
					
				elseif($data["rawat"]=='2'): //jalan
					if($status_proses=='BL' || $status_proses=='RD' || $status_proses=='KM'):
						// $data_update["inst_lanjut"]=$status_proses;
						$data["status_proses"]="PRRIDA"; //inap daily activity
						$data_update["rujuk_pasca"]=$kdwil;
						$data["rujuk_pasca"]=$kdwil;
						$data_update["kd_wilayah"]=$kdwil_ori;
						$stt_rawat_pasca="INAP";
					elseif($status_proses=='BNNP' || $status_proses=='BNNK'):
						// $data_update["inst_lanjut"]=$status_proses;
						$data["status_proses"]="PRRJPG"; //jalan peer group
						$data_update["rujuk_pasca"]=$data["kd_wilayah"];
						$data["rujuk_pasca"]=$data["kd_wilayah"];
						$data_update["kd_wilayah"]=$kdwil;
						$stt_rawat_pasca="JALAN";
					endif;
					$data["status_check_doc"]=0; //0belum 1proses 2ok/valid/selesai 9tolak
					$data_update["inst_lanjut"]=NULL;
					$data_update["rujuk_lanjut"]=NULL;
					$data_update["inst_pasca"]=$status_proses; 
					
					$data_update["status_rehab"]=3;
					
					$data["inst_pasca"]=$status_proses; 
					$data["inst_lanjut"]=NULL;
					$data["rujuk_lanjut"]=NULL;	
					
				elseif($data["rawat"]=='3'): //lanjut
					if($status_proses=='BL' || $status_proses=='RD' || $status_proses=='KM'):
						$data["status_proses"]="PRRLPUKP"; //inap daily activity
						$data_update["rujuk_lanjut"]=$kdwil;
						$data["rujuk_lanjut"]=$kdwil;
						$data_update["kd_wilayah"]=$kdwil_ori;
					elseif($status_proses=='BNNP' || $status_proses=='BNNK'):
						$data["status_proses"]="PRRLPUKP"; //jalan peer group
						$data_update["rujuk_lanjut"]=$data["kd_wilayah"];
						$data["rujuk_lanjut"]=$data["kd_wilayah"];
						$data_update["kd_wilayah"]=$kdwil;
					endif;
					$data["status_check_doc"]=0; //0belum 1proses 2ok/valid/selesai 9tolak
					$data_update["inst_pasca"]=NULL;
					$data_update["rujuk_pasca"]=NULL;
					$data_update["inst_lanjut"]=$status_proses; 
					$stt_rawat_pasca="LANJUT";
					// $data_update["kd_wilayah"]=$kdwil;
					
					$data["inst_lanjut"]=$status_proses; 
					$data["inst_pasca"]=NULL;
					$data["rujuk_pasca"]=NULL;
				endif;	
			else:
				$data["active_pasien"]=1;
				$data["status_proses"]="PRAP"; //pasca penerimaan dulu assesmen pra
				$data["status_rehab"]=3; //rehab
				$stt_rawat_pasca="";
				
				$data["inst_pasca"]=$status_proses; 
				$data["inst_lanjut"]=NULL;
				$data["rujuk_lanjut"]=NULL;
			endif;
			$data["status_rawat_inap"]="";
			$data["status_rawat"]='PASCA';

			$data_update["status_proses"]=$data["status_proses"];
			$data_update["status_check_doc"]=$data["status_check_doc"];
			$data_update["status_rawat_inap"]=$data["status_rawat_inap"];
			
			$this->model->UpdateData($data_update,"idx=$id");
			$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($cek_dok==2):
				$data_update['tgl_mulai_pasca']=$data['tgl_selesai'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				$dataMonitoring['tgl_mulai_pasca']=$data['tgl_selesai'];
				$dataMonitoring['status_rawat_pasca']=$stt_rawat_pasca;
				// debug();
				update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);
				
				// debug();
				update_status_program_pasca($id,$data['idx_assesment']);
				// exit;
			endif;
			
			$idx=$data["idx"];
			$hasil_asses = implode(",",$data["hasil_assesmentx"]);
			$data["hasil_assesment"] = $hasil_asses;
			$this->model_pr->InsertData($data);
			// pre($data);
			// pre($data_update);
			// exit;
            $ok=$this->conn->CompleteTrans();
			
			if($cek_dok != 2):
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			else:
				redirect($this->module."view_detail/".$id_enc);
			endif;
			
			//$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;
		
	}
	function view_detail($id){
        
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		
		$arrData=$this->model->GetRecordData("idx=$id");
		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL");
		$data["data_asm"]=$arrDataAsm;
		$arrPasca=$this->model_pr->GetRecordData("idx_pasien=$id and idx_assesment='$arrDataAsm[idx]'" );
		$data["arrPasca"]=$arrPasca;
		$data["data"]=$arrData;
		$data["data_proses"]=$this->model_pr->GetRecordData("idx_pasien=$id and idx_assesment='$arrDataAsm[idx]'");
		$data["id"]=$id_enc;
		
		$rh_pasien	=	rh_pasien($id);
		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];		
		
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
		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL");
		$data["data_asm"]=$arrDataAsm;
		$arrDataAssesmentHis=$this->model_pasien_assesment_history->GetRecordData("idx_pasien=$id and idx_assesment=$arrDataAsm[idx]");
		$data["data_asmHis"]=$arrDataAssesmentHis;
		$idx_assesment = $arrDataAsm['idx'];	
		$arrPasca=$this->model_pr->GetRecordData("idx_pasien=$id and idx_assesment='$arrDataAsm[idx]'" );
		$data["monitoring_rehab"]	=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]		=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["rehab_stat"]			=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' order by idx desc");
		$data["arrPasca"]=$arrPasca;
		$data["data"]=$arrData;
		$data["data_proses"]=$this->model_pr->GetRecordData("idx_pasien=$id and idx_assesment='$arrDataAsm[idx]'");
		
		$this->_render_page($this->module."v_view",$data,true);
        
     }
	
	function pasien_list(){
		// debug();
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
		$where[]="(status_rehab=3 and status_proses='PRAP')";
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
        // exit;
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
		// debug();
        // $arrData=$this->model->GetRecordData("{$this->tbl_idx}=$id");
		//start
		$act="delete";    
        if($act=="delete"):
            $this->conn->StartTrans();
			$data_update["status_check_doc"]=0; 
			$data_update["inst_rujuk"]=NULL; 
			$data_update["rujuk_rehab"]=NULL;
			$data_update["status_proses"]="PRAP"; //re
			$data_update["status_rehab"]=3; //rehab
			$data_update["status_rawat"]="PASCA"; //inap

			$this->model->UpdateData($data_update, "idx='$id'");
			$this->model_pr->DeleteData("idx_pasien=$id");	
			// exit;
			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview",$this->module."listview/");
        endif;
    }
	
	
	  function get_array_idx(){
		$sql			=	"select idx_pasien from ".$this->model_pr->tbl;		
		$array			=	$this->conn->GetAll($sql);		
		
		foreach($array as $k=>$v):
			$arr[$k]	=	$v['idx_pasien'];
		endforeach;		
		$series			=	join(",",$arr);		
		return $series;
	 }
	 
	 
	 
	 

}