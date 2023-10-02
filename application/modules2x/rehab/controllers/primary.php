<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class primary extends Admin_Controller {
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
				$this->model_file=new general_model("t_pasien_file");
		// $this->model_currently=new general_model("t_pasien_curently");
		$this->model_pasien_assesment_history=new general_model("t_pasien_assesment_history");
		//$this->model_detox=new general_model("t_pasien_detox");
		//$this->model_eu=new general_model("t_pasien_entry_unit");
		$this->model_primary=new general_model("t_pasien_primary_treatment");
		$this->model_primary_history=new general_model("t_pasien_primary_treatment_history");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");
		$this->model_pasien_history=new general_model("t_pasien_history");
		$this->model_monitoring_rehab=new general_model("t_pasien_monitoring_rehab");

		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="REHABILITASI";
		$this->module_title="Primary Treatment";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";
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
        $sql=" select a.*,b.tgl_kegiatan,b.jangka_waktu,b.jangka_waktu_satuan,b.tgl_mulai,b.tgl_selesai,b.kegiatan,b.jenis_kegiatan,b.lampiran,b.status_pasien from ".$this->model->tbl." a
                left join ".$this->model_primary->tbl." b on a.idx=b.idx_pasien and b.status_data=1 where a.active_pasien=1
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

		if($this->input->get_post("jns_treat")):
            $where[]="(jns_treat='".$this->input->get_post("jns_treat")."')";
        endif;

		if($this->user_prop):
			if($this->user_instansi!=="BNNP" && $this->user_instansi!=="BNNK"):
				if($this->user_instansi=="BL"):
					$where[]	=	"inst_rujuk='BL' and rujuk_rehab='".$this->user_org."'";
				elseif($this->user_instansi=="RD"):
					$where[]	=	"inst_rujuk='RD' and rujuk_rehab='".$this->user_org."'";
				elseif($this->user_instansi=="KM"):
					$where[]	=	"inst_rujuk='KM' and rujuk_rehab='".$this->user_org."'";
				endif;
			endif;
		endif;

		$where[]="(status_rehab=2 and status_proses='RIRSPP')";

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
		$data["lookup_inst"]=lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
		$data["lookup_jns_org"]=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org",false,"order by idx");


		$this->_render_page($this->module."v_list",$data,true);
    }


	function update_proses($id=false){
		/*if(!$id):
			$act="create";
		endif;*/

		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
        // debug();

	    $data=get_post();
		// pre($data);
		$act=$this->input->post("act")?$this->input->post("act"):"";
	   	if($act=="update"):
			//$data["active"]=$data["active"]?1:0;

			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pt");
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

			if($data['pertemuan_ke']==1){
				$data['tgl_kegiatan']=$data['tgl_kegiatan'];
				$tgl_kegiatan=$data['tgl_kegiatan'];
			}else{
				$data['tgl_kegiatan']=$data['tgl_kegiatan'];
				$tgl_kegiatan=$data['tgl_kegiatan'];
			}


			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				$inst_rujuk=$data['status_proses'];
				$rujuk_rehab=$data["kd_wilayah"];
				$kdwil=$kdw;
			elseif(!empty($data["id_kabupaten"])):
				$kdwil=$data["id_kabupaten"];
				$piece = explode("-",$data["id_kabupaten"]);
				$kdwil=$piece[0].$piece[1];
				$inst_rujuk=$data['status_proses'];
				$rujuk_rehab=$data["id_kabupaten"];
			elseif(!empty($data["id_km"])):
				$kdwil=$data["id_km"];
				$piece = explode("-",$data["id_km"]);
				$kdwil=$piece[0].$piece[1];
				$inst_rujuk=$data['status_proses'];
				$rujuk_rehab=$data["id_km"];
			elseif(!empty($data["id_rd"])):
				$kdwil=$data["id_rd"];
				$piece = explode("-",$data["id_rd"]);
				$kdwil=$piece[0].$piece[1];
				$inst_rujuk=$data['status_proses'];
				$rujuk_rehab=$data["id_rd"];
			endif;

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="RIRSRE"; //entry unit
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_update["inst_rujuk"]=$inst_rujuk;
				$data_update["rujuk_rehab"]=$rujuk_rehab;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pt']=1;
				// $days=date('Y-m-d');
			else:
				$data_update["status_proses"]="RIRSPP"; //detok
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_update["inst_rujuk"]=$inst_rujuk;
				$data_update["rujuk_rehab"]=$rujuk_rehab;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pt']=0;
			endif;

			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_primary->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_primary->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_primary->DeleteData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				$this->model_primary->InsertData($data);
			}
			$arrDtxHis=$this->model_primary_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			$data['idx_parent']=$this->model_primary->GetLastId("idx");
			if($arrDtxHis){
				$dataz['idx_parent']=$this->model_primary->GetLastId("idx");
				$this->model_primary_history->UpdateData($dataz, "idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				if($idx !=''){
					$this->model_primary_history->DeleteData("idx=$idx");
				}
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
					$this->model_primary_history->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_primary_history->InsertData($data);
				}
			}

			// $arrDtx=$this->model_primary->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			// if($arrDtx){
				// $dataz['status_data']=0;
				// $this->model_primary->UpdateData($dataz, "idx_pasien=$id");
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_primary->DeleteData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				// $this->model_primary->InsertData($data);
			// }
			// $arrDtxHis=$this->model_primary_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			// $data['idx_parent']=$this->model_primary->GetLastId("idx");
			// if($arrDtxHis){
				// $dataz['idx_parent']=$this->model_primary->GetLastId("idx");
				// $this->model_primary_history->UpdateData($dataz, "idx_pasien=$id");
				////if($idx !=''){
					// $this->model_primary_history->DeleteData("idx=$idx");
				////}
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
					// $this->model_primary_history->InsertData($data);
				// }else{
					// $data['status_data']=1;
					// $this->model_primary_history->InsertData($data);
				// }
			// }


			if($data['status_program']=='DO' || $data['status_program']=='MD'):
				$data_update["status_proses"]="RIRSPP"; //detok
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_update["inst_rujuk"]=$inst_rujuk;
				$data_update["rujuk_rehab"]=$rujuk_rehab;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pt']=1;

				$data_update["active_pasien"]=0;
				// $days=date('Y-m-d');
				$data_update['tgl_selesai_rehab']=$data['tgl_selesai_program'];
				$data_update['status_rm']=$data['status_program'];
				$this->model->UpdateData($data_update,"idx=$id");

				// $data_update['status_program_sebelum']=$data['status_program'];

				$data_update['status_program']=$data['status_program'];
				$data_update['status_rm']=$data['status_program'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				$data_reset['outcome_pasien']=$data['outcome_pasien'];
				$data_reset['status_rm']=$data['status_program'];
				$data_reset['status_program']=$data['status_program'];
				$this->model_assesment_summary->UpdateData($data_reset,"idx_pasien=$id and idx=$data[idx_assesment]");

				update_status_program($id,$data['idx_assesment'],$data['status_program']);
				$dataMonitoring['tgl_selesai_rehab']=$data['tgl_selesai_program'];
			else:
				$data_update["active_pasien"]=1;
				$data_update["outcome_pasien"]=NULL;
				$data_update['status_rm']=$data['status_program'];
				$this->model->UpdateData($data_update,"idx=$id");

				// $data_update['status_program_terakhir']=$data['status_program'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				update_status_program($id,$data['idx_assesment'],$data['status_program']);
			endif;
			// exit;

			$data_update['tgl_kegiatan']=$data['tgl_kegiatan'];
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history($data,$data_update);

			$dataMonitoring['pt']=$data_mtr['pt'];
			if($data['pertemuan_ke']==1){
				$dataMonitoring['tgl_pt']=$data['tgl_kegiatan'];
			}
			$dataMonitoring['tgl_pt_selesai']=$data['tgl_selesai'];
			update_pasien_monitoring($data,$data_update,$dataMonitoring);
			// exit;
            $ok=$this->conn->CompleteTrans();
			if($data['status_pasien']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'){
				$this->_proses_message($ok,$this->module."detail/$id_enc",$this->module."detail/$id_enc");
			}else{
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			}
        endif;

	   if($act=="create"):
			//$data["active"]=$data["active"]?1:0;
			// debug();
			unset($data["idx"]);
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pt");
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
			$this->conn->StartTrans();
			$idx=$data["idx"];
			if($data['pertemuan_ke']==1){
				$data['tgl_kegiatan']=$data['tgl_kegiatan'];
				$tgl_kegiatan=$data['tgl_kegiatan'];
			}else{
				$data['tgl_kegiatan']=$data['tgl_kegiatan'];
				$tgl_kegiatan=$data['tgl_kegiatan'];
			}

			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				$inst_rujuk=$data['status_proses'];
				$rujuk_rehab=$data["kd_wilayah"];
				$kdwil=$kdw;
			elseif(!empty($data["id_kabupaten"])):
				$kdwil=$data["id_kabupaten"];
				$piece = explode("-",$data["id_kabupaten"]);
				$kdwil=$piece[0].$piece[1];
				$inst_rujuk=$data['status_proses'];
				$rujuk_rehab=$data["id_kabupaten"];
			elseif(!empty($data["id_km"])):
				$kdwil=$data["id_km"];
				$piece = explode("-",$data["id_km"]);
				$kdwil=$piece[0].$piece[1];
				$inst_rujuk=$data['status_proses'];
				$rujuk_rehab=$data["id_km"];
			elseif(!empty($data["id_rd"])):
				$kdwil=$data["id_rd"];
				$piece = explode("-",$data["id_rd"]);
				$kdwil=$piece[0].$piece[1];
				$inst_rujuk=$data['status_proses'];
				$rujuk_rehab=$data["id_rd"];
			endif;

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="RIRSRE"; //entry unit
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_update["inst_rujuk"]=$inst_rujuk;
				$data_update["rujuk_rehab"]=$rujuk_rehab;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pt']=1;
				// $days=date('Y-m-d');
			else:
				$data_update["status_proses"]="RIRSPP"; //detok
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_update["inst_rujuk"]=$inst_rujuk;
				$data_update["rujuk_rehab"]=$rujuk_rehab;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pt']=0;
			endif;

			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_primary->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_primary->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$dataz['status_data']=0;
					$this->model_primary->UpdateData($dataz, "idx_pasien=$id");
					$data['status_data']=0;
				}
				$this->model_primary->UpdateData($data, "idx=$idx");
			}else{
				$dataz['status_data']=0;
				$this->model_primary->UpdateData($dataz, "idx_pasien=$id");
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
					$this->model_primary->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_primary->InsertData($data);
				}

			}
			$arrDtxHis=$this->model_primary_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			$data['idx_parent']=$this->model_primary->GetLastId("idx");
			if($arrDtxHis){
				if($idx !=''){
					$this->model_primary_history->DeleteData("idx=$idx");
				}
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
					$this->model_primary_history->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_primary_history->InsertData($data);
				}
			}else{
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_primary_history->InsertData($data);
			}

			// $arrDtx=$this->model_primary->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			// if($arrDtx){
				// $dataz['status_data']=0;
				// $this->model_primary->UpdateData($dataz, "idx_pasien=$id");
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $dataz['status_data']=0;
					// $this->model_primary->UpdateData($dataz, "idx_pasien=$id");
					// $data['status_data']=0;
				// }
				// $this->model_primary->UpdateData($data, "idx=$idx");
			// }else{
				// $data['status_data']=1;
				// $this->model_primary->InsertData($data);
			// }
			// $arrDtxHis=$this->model_primary_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			// $data['idx_parent']=$this->model_primary->GetLastId("idx");
			// if($arrDtxHis){
				// if($idx !=''){
					// $this->model_primary_history->DeleteData("idx=$idx");
				// }
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
					// $this->model_primary_history->InsertData($data);
				// }else{
					// $data['status_data']=1;
					// $this->model_primary_history->InsertData($data);
				// }
			// }else{
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_primary_history->InsertData($data);
			// }

			if($data['status_program']=='DO' || $data['status_program']=='MD'):
				$data_update["status_proses"]="RIRSPP"; //detok
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_update["inst_rujuk"]=$inst_rujuk;
				$data_update["rujuk_rehab"]=$rujuk_rehab;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pt']=1;

				$data_update["active_pasien"]=0;
				// $days=date('Y-m-d');
				$data_update['tgl_selesai_rehab']=$data['tgl_selesai_program'];
				$data_update['status_rm']=$data['status_program'];
				$this->model->UpdateData($data_update,"idx=$id");

				// $data_update['status_program_sebelum']=$data['status_program'];
				$data_update['status_rm']=$data['status_program'];
				$data_update['status_program']=$data['status_program'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				$data_reset['outcome_pasien']=$data['outcome_pasien'];
				$data_reset['status_rm']=$data['status_program'];
				$data_reset['status_program']=$data['status_program'];
				$this->model_assesment_summary->UpdateData($data_reset,"idx_pasien=$id and idx=$data[idx_assesment]");

				update_status_program($id,$data['idx_assesment'],$data['status_program']);
				$dataMonitoring['tgl_selesai_rehab']=$data['tgl_selesai_program'];
			else:
				$data_update["active_pasien"]=1;
				$data_update["outcome_pasien"]=NULL;
				$this->model->UpdateData($data_update,"idx=$id");

				// $data_update['status_program_terakhir']=$data['status_program'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				update_status_program($id,$data['idx_assesment'],$data['status_program']);
			endif;
			// exit;


			$data_update['tgl_kegiatan']=$data['tgl_kegiatan'];
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history($data,$data_update);

			$dataMonitoring['pt']=$data_mtr['pt'];
			if($data['pertemuan_ke']==1){
				$dataMonitoring['tgl_pt']=$data['tgl_kegiatan'];
			}
			$dataMonitoring['tgl_pt_selesai']=$data['tgl_selesai'];
			update_pasien_monitoring($data,$data_update,$dataMonitoring);
			// pre($data);
			// exit;
            $ok=$this->conn->CompleteTrans();
			if($data['status_pasien']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'){
				$this->_proses_message($ok,$this->module."detail/$id_enc",$this->module."detail/$id_enc");
			}else{
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			}
        endif;

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
            $this->model_primary->DeleteData("idx=$idx");
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;
    }

	function edit($id,$idx_pt){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
			$idx_pt=decrypt($idx_pt);
        endif;
		$arrData=$this->model->GetRecordData("idx=$id");
		$data["data"]=$arrData;
		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL");
		$data["data_asm"]=$arrDataAsm;
		//debug();
		//$arrDetox=$this->model_detox->SearchRecordWhere("idx_pasien=$id","order by idx desc");
		$idx_assesment = $arrDataAsm['idx'];
		// $data["data_proses"]=$this->model_primary->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		// debug();
		$data["data_proses"]=$this->model_primary_history->GetRecordData("idx='$idx_pt'");
		// exit;
		$data["pasien_pt_history"]=$this->model_primary_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");


		// rehab
		$data["monitoring_rehab"]=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["rehab_stat"]	=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' order by idx desc");

		//$data["data_file"]=$arrDataFile;
       	$this->_render_page($this->module."v_view_edit",$data,true);

     }

	function view($id){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		$arrData=$this->model->GetRecordData("idx=$id");
		$idx_pasien = $arrData['idx'];
		$arrFile = $this->model_file->SearchRecordWhere("id_parent=$idx_pasien");
		//$data["data_file"]=$arrDataFile;
		$data_doc = array();
		foreach($arrFile as $k=>$val){
			$data_doc[$val['id_jenis_doc']][] =$val;
		}
		$data["data_doc"]=$data_doc;
		$data["data"]=$arrData;
		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL");
		$data["data_asm"]=$arrDataAsm;
		//debug();
		//$arrDetox=$this->model_detox->SearchRecordWhere("idx_pasien=$id","order by idx desc");
		$idx_assesment = $arrDataAsm['idx'];
		$data["data_proses"]=$this->model_primary->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_pt_history"]=$this->model_primary_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_assestment_history"]=$this->model_pasien_assesment_history->GetRecordData("idx_pasien='$id' and idx_assesment='$idx_assesment'");
		// rehab
		$data["monitoring_rehab"]=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["rehab_stat"]	=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' order by idx desc");

		//$data["data_file"]=$arrDataFile;
       	$this->_render_page($this->module."v_view",$data,true);

     }

	function detail($id){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;

		$arrData=$this->model->GetRecordData("idx=$id");
		$data["data"]=$arrData;
		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL");
		$data["data_asm"]=$arrDataAsm;
		//debug();
		//$arrDetox=$this->model_detox->SearchRecordWhere("idx_pasien=$id","order by idx desc");
		$idx_assesment = $arrDataAsm['idx'];
		$data["data_proses"]=$this->model_primary->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");

		// rehab
		$data["monitoring_rehab"]=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["rehab_stat"]	=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' order by idx desc");

		for($i=1; $i<5; $i++):
			$last_idx	=	$this->conn->GetOne("select idx from ".$this->model_primary_history->tbl." where idx_pasien='$id' and idx_assesment='$idx_assesment' and pertemuan_ke='$i'");

			$history[$i]=	$this->model_primary_history->GetRecordData("idx='$last_idx'");
		endfor;

		$data['history']	=	$history;

		$rh_pasien	=	rh_pasien($id);
		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];

       	$this->_render_page($this->module."v_detail",$data,true);

     }

	 //------------------- backup --------------------------------
	 function update_proses_ori($id=false){
		/*if(!$id):
			$act="create";
		endif;*/

		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
        // debug();

	    $data=get_post();
		// pre($data);
		$act=$this->input->post("act")?$this->input->post("act"):"";
	   	if($act=="update"):
			//$data["active"]=$data["active"]?1:0;

			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pt");
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

			//insert history
			$this->model_primary->UpdateData($data, "idx=$idx");
			$data['idx']='';
			$this->model_primary_history->InsertData($data);

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="RIRSRE"; //re
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_mtr['pt']=1;
			else:
				$data_update["status_proses"]="RIRSPP"; //pr
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_mtr['pt']=0;
			endif;

			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				$data_update["kd_wilayah"]=$kdw;
				$data_update["inst_rujuk"]=$data['status_proses'];
				$data_update["rujuk_rehab"]=$data["kd_wilayah"];
			elseif(!empty($data["id_kabupaten"])):
				$data_update["kd_wilayah"]=$data["id_kabupaten"];
				$data_update["inst_rujuk"]=$data['status_proses'];
				$data_update["rujuk_rehab"]=$data["id_kabupaten"];
			elseif(!empty($data["id_km"])):
				$data_update["kd_wilayah"]=$data["id_km"];
				$data_update["inst_rujuk"]=$data['status_proses'];
				$data_update["rujuk_rehab"]=$data["id_km"];
			elseif(!empty($data["id_rd"])):
				$data_update["kd_wilayah"]=$data["id_rd"];
				$data_update["inst_rujuk"]=$data['status_proses'];
				$data_update["rujuk_rehab"]=$data["id_rd"];
			endif;
			$this->model->UpdateData($data_update,"idx=$id");

			$data_update['tgl_kegiatan']=$data['tgl_kegiatan'];
			$data_update['status_pasien']=$data['status_pasien'];
			update_pasien_history($data,$data_update);

			$dataMonitoring['pt']=$data_mtr['pt'];
			$dataMonitoring['tgl_pt']=$data['tgl_kegiatan'];
			update_pasien_monitoring($data,$data_update,$dataMonitoring);
			// exit;
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;

	   if($act=="create"):
			//$data["active"]=$data["active"]?1:0;
			// debug();
			unset($data["idx"]);
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pt");
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
			$this->conn->StartTrans();
			$this->model_primary->InsertData($data);
			$data['idx']='';
			$this->model_primary_history->InsertData($data);

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="RIRSRE"; //re
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_mtr['pt']=1;
			else:
				$data_update["status_proses"]="RIRSPP"; //pr
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
				$data_mtr['pt']=0;
			endif;

			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				$data_update["kd_wilayah"]=$kdw;
				$data_update["inst_rujuk"]=$data['status_proses'];
				$data_update["rujuk_rehab"]=$data["kd_wilayah"];
			elseif(!empty($data["id_kabupaten"])):
				$data_update["kd_wilayah"]=$data["id_kabupaten"];
				$data_update["inst_rujuk"]=$data['status_proses'];
				$data_update["rujuk_rehab"]=$data["id_kabupaten"];
			elseif(!empty($data["id_km"])):
				$data_update["kd_wilayah"]=$data["id_km"];
				$data_update["inst_rujuk"]=$data['status_proses'];
				$data_update["rujuk_rehab"]=$data["id_km"];
			elseif(!empty($data["id_rd"])):
				$data_update["kd_wilayah"]=$data["id_rd"];
				$data_update["inst_rujuk"]=$data['status_proses'];
				$data_update["rujuk_rehab"]=$data["id_rd"];
			endif;
			$this->model->UpdateData($data_update,"idx=$id");

			$data_update['tgl_kegiatan']=$data['tgl_kegiatan'];
			$data_update['status_pasien']=$data['status_pasien'];
			update_pasien_history($data,$data_update);

			$dataMonitoring['pt']=$data_mtr['pt'];
			$dataMonitoring['tgl_pt']=$data['tgl_kegiatan'];
			update_pasien_monitoring($data,$data_update,$dataMonitoring);
			// pre($data);
			// exit;
            $ok=$this->conn->CompleteTrans();

			$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;

	}

	public function delete_ajax(){

		$data			=	get_post();

		$idx			=	$data['idx'];
		$idx_parent		=	$data['idx_parent'];
		$idx_pasien		=	$data['idx_pasien'];
		$idx_assesment	=	$data['idx_assesment'];

		$start		=	$this->conn->StartTrans();

		//Delete Session
		$criteria	=	"idx='".$idx."'";
		$this->model_primary_history->DeleteData($criteria);
		//End


		//Get Biggest Idx From t_pasien_detox_history
		$criteria2	=	" where idx_parent='".$idx_parent."' and idx_pasien='".$idx_pasien."' and idx_assesment='".$idx_assesment."'";
		$lastIdx	=	$this->conn->GetOne("select max(idx) from ".$this->model_primary_history->tbl.$criteria2);

		if($lastIdx):

			//Change status_data to 1
			$update_status_data['status_data']	=	1;
			$this->model_primary_history->UpdateData($update_status_data,"idx='".$lastIdx."'");
			//End

			$arr	=	$this->model_primary_history->GetRecordData("idx='".$lastIdx."'");

			foreach($arr as $k=>$v):
				if($k!=="idx" && $k!=="idx_parent" && $k!=="idx_pasien" && $k!=="idx_assesment"):
					$arrUpdate[$k]	=	$v;
				endif;
			endforeach;

			//End

			//Update to t_pasien_detox
			$criteria3	=	"idx='".$idx_parent."'";
			$this->model_primary->UpdateData($arrUpdate,$criteria3);
			//End

		else:
			$this->model_primary->DeleteData("idx_pasien='".$idx_pasien."'");
		endif;

		$complete	=	$this->conn->CompleteTrans();

		if($complete):
			echo true;
		else:
			echo false;
		endif;

	}

}
