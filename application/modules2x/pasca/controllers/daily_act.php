<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class daily_act extends Admin_Controller {
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
				$this->model_file=new general_model("t_pasien_file");
		// $this->model_currently=new general_model("t_pasien_curently");
		$this->model_pasien_assesment_history=new general_model("t_pasien_assesment_history");
		//$this->model_detox=new general_model("t_pasien_detox");
		$this->model_da=new general_model("t_pasca_daily_act");
		$this->model_da_history=new general_model("t_pasca_daily_act_history");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");
		$this->model_pasien_history=new general_model("t_pasien_history");
		$this->model_monitoring_rehab=new general_model("t_pasien_monitoring_rehab");

		$this->model_pasien_history_pasca=new general_model("t_pasien_history_pasca");
		$this->model_monitoring_pasca=new general_model("t_pasien_monitoring_pasca");

		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="PASCA REHABILITASI";
		$this->module_title="Daily Activity";
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
        $sql=" select a.*,b.tgl_mulai,b.tgl_selesai,b.jenis_kegiatan,b.keterangan,b.lampiran from ".$this->model->tbl." a
                left join ".$this->model_da->tbl." b on a.idx=b.idx_pasien and b.status_data=1 where a.active_pasien=1
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

		if($this->user_prop):
			if($this->user_instansi!=="BNNP" && $this->user_instansi!=="BNNK"):
				$where[]	=	"(inst_pasca='".$this->user_instansi."')";
				$where[]	=	"rujuk_pasca='".$this->user_org."'";
			endif;
		endif;

		$where[]="(status_rehab=3 and status_proses='PRRIDA')";

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
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";

	    $data=get_post();
		// debug();
		$act=$this->input->post("act")?$this->input->post("act"):"";
	   	if($act=="update"):
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
			$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			$idx=$data["idx"];
			$data['tgl_kegiatan']=$data['tgl_mulai'];
			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				$inst_pasca=$data['status_proses'];
				$rujuk_pasca=$data["kd_wilayah"];
				$kdwil=$kdw;
				$stt_rawat_pasca="JALAN";
			elseif(!empty($data["id_kabupaten"])):
				$kdwil=$data["id_kabupaten"];
				$inst_pasca=$data['status_proses'];
				$rujuk_pasca=$data["id_kabupaten"];
				$piece = explode("-",$data["id_kabupaten"]);
				$kdwil=$piece[0].$piece[1];
				$stt_rawat_pasca="INAP";
			elseif(!empty($data["id_km"])):
				$kdwil=$data["id_km"];
				$inst_pasca=$data['status_proses'];
				$rujuk_pasca=$data["id_km"];
				$piece = explode("-",$data["id_km"]);
				$kdwil=$piece[0].$piece[1];
				$stt_rawat_pasca="IANP";
			elseif(!empty($data["id_rd"])):
				$kdwil=$data["id_rd"];
				$inst_pasca=$data['status_proses'];
				$rujuk_pasca=$data["id_rd"];
				$piece = explode("-",$data["id_rd"]);
				$kdwil=$piece[0].$piece[1];
				$stt_rawat_pasca="INAP";
			endif;

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="PRRIDR"; //entry unit
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["inst_pasca"]=$inst_pasca;
				$data_update["rujuk_pasca"]=$rujuk_pasca;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['da']=1;
				// $days=date('Y-m-d');
			else:
				$data_update["status_proses"]="PRRIDA"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['da']=0;
			endif;

			unset($data['idx']);
			$arrDtx=$this->model_da->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_da->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_da->UpdateData($data, "idx=$idx");
			}
			$arrDtxHis=$this->model_da_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtxHis){
				$dataz['status_data']=0;
				$this->model_da_history->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_da_history->InsertData($data);
			}
			// exit;
			if($data['status_program']=='DO' || $data['status_program']=='MD' || $data['status_program']=='KB' || $data['status_program']=='SL'):
				$data_update["status_proses"]="PRRIDA"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['da']=1;

				$data_update["active_pasien"]=0;
				// $days=date('Y-m-d');
				$data_update['tgl_selesai_pasca']=$data['tgl_selesai_program'];
				$this->model->UpdateData($data_update,"idx=$id");

				$data_update['status_rm']=$data['status_program'];
				$data_update['status_program']=$data['status_program'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				$data_reset['outcome_pasien']=$data['outcome_pasien'];
				$data_reset['status_rm']=$data['status_program'];
				$data_reset['status_program']=$data['status_program'];
				$this->model_assesment_summary->UpdateData($data_reset,"idx_pasien=$id and idx=$data[idx_assesment]");

				update_status_program_pasca($id,$data['idx_assesment'],$data['status_program']);
				$dataMonitoring['tgl_selesai_pasca']=$data['tgl_selesai_program'];
			else:
				$data_update["active_pasien"]=1;
				$data_update["outcome_pasien"]=NULL;
				$this->model->UpdateData($data_update,"idx=$id");

				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				update_status_program_pasca($id,$data['idx_assesment'],$data['status_program']);
			endif;

			$data_update['tgl_kegiatan']=$data['tgl_mulai'];
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history_pasca($data,$data_update);

			$dataMonitoring['da']=$data_mtr['da'];
			$dataMonitoring['tgl_da']=$data['tgl_mulai'];
			$dataMonitoring['tgl_da_selesai']=$data['tgl_selesai'];
			update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);
			// exit;
			$ok=$this->conn->CompleteTrans();
			if($data['status_pasien']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'){
				$this->_proses_message($ok,$this->module."view_detail/$id_enc",$this->module."view_detail/$id_enc");
			}else{
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			}
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

			$data['tgl_kegiatan']=$data['tgl_mulai'];
			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				$inst_pasca=$data['status_proses'];
				$rujuk_pasca=$data["kd_wilayah"];
				$kdwil=$kdw;
			elseif(!empty($data["id_kabupaten"])):
				$kdwil=$data["id_kabupaten"];
				$inst_pasca=$data['status_proses'];
				$rujuk_pasca=$data["id_kabupaten"];
				$piece = explode("-",$data["id_kabupaten"]);
				$kdwil=$piece[0].$piece[1];
			elseif(!empty($data["id_km"])):
				$kdwil=$data["id_km"];
				$inst_pasca=$data['status_proses'];
				$rujuk_pasca=$data["id_km"];
				$piece = explode("-",$data["id_km"]);
				$kdwil=$piece[0].$piece[1];
			elseif(!empty($data["id_rd"])):
				$kdwil=$data["id_rd"];
				$inst_pasca=$data['status_proses'];
				$rujuk_pasca=$data["id_rd"];
				$piece = explode("-",$data["id_rd"]);
				$kdwil=$piece[0].$piece[1];
			endif;

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="PRRIDR"; //entry unit
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["inst_pasca"]=$inst_pasca;
				$data_update["rujuk_pasca"]=$rujuk_pasca;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['da']=1;
			else:
				$data_update["status_proses"]="PRRIDA"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['da']=0;
			endif;

			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_da->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_da->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_da->InsertData($data);
			}else{
				$dataz['status_data']=0;
				$this->model_da->UpdateData($dataz, "idx_pasien=$id");
				if($data['status_pasien']=='SL'){
					$dataz['status_data']=0;
					//$this->model_da->UpdateData($dataz, "idx_pasien=$id");
                    $this->model_da->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_da->InsertData($data);
				}
			}
			$arrDtxHis=$this->model_da_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtxHis){
				$dataz['status_data']=0;
				$this->model_da_history->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_da_history->InsertData($data);
			}else{
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_da_history->InsertData($data);
			}
			// exit;
			if($data['status_program']=='DO' || $data['status_program']=='MD' || $data['status_program']=='KB' || $data['status_program']=='SL'):
				$data_update["status_proses"]="PRRIDA"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['da']=1;

				$data_update["active_pasien"]=0;
				// $days=date('Y-m-d');
				$data_update['tgl_selesai_pasca']=$data['tgl_selesai_program'];
				$this->model->UpdateData($data_update,"idx=$id");

				// $data_update['status_program_sebelum']=$data['status_program'];
				$data_update['status_rm']=$data['status_program'];
				$data_update['status_program']=$data['status_program'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				$data_reset['outcome_pasien']=$data['outcome_pasien'];
				$data_reset['status_rm']=$data['status_program'];
				$data_reset['status_program']=$data['status_program'];
				$this->model_assesment_summary->UpdateData($data_reset,"idx_pasien=$id and idx=$data[idx_assesment]");

				update_status_program_pasca($id,$data['idx_assesment'],$data['status_program']);
			else:
				$data_update["active_pasien"]=1;
				$data_update["outcome_pasien"]=NULL;
				$this->model->UpdateData($data_update,"idx=$id");

				// $data_update['status_program_terakhir']=$data['status_program'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				update_status_program_pasca($id,$data['idx_assesment'],$data['status_program']);
				$dataMonitoring['tgl_selesai_pasca']=$data['tgl_selesai_program'];
			endif;

			$data_update['tgl_kegiatan']=$data['tgl_mulai'];
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history_pasca($data,$data_update);

			$dataMonitoring['da']=$data_mtr['da'];
			$dataMonitoring['tgl_da']=$data['tgl_mulai'];
			$dataMonitoring['tgl_da_selesai']=$data['tgl_selesai'];
			// $dataMonitoring['tgl_mulai_pasca']=$data['tgl_mulai'];
			update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);
			// exit;

            $ok=$this->conn->CompleteTrans();
			if($data['status_pasien']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'){
				$this->_proses_message($ok,$this->module."view_detail/$id_enc",$this->module."view_detail/$id_enc");
			}else{
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			}
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

		$idx_assesment = $arrDataAsm['idx'];

		$data["monitoring_rehab"]		= $this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]			= $this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
		$data["monitoring_pasca"]		= $this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_pasca"]	= $this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");


		$data["jns_kegiatan"]			= $this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
		$data["data"]					= $arrData;
		$data["data_proses"]			= $this->model_da->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$rh_pasien	=	rh_pasien($id);
		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];

		$this->_render_page($this->module."v_detail",$data,true);
     }
	function update_doc($id_parent){

		$file_arr=$this->input->post("upload_file_id");
        $id_jenis_doc_arr=$this->input->post("id_jenis_doc");
		if(!cek_array($file_arr)):
			return true;
		endif;

        foreach($file_arr as $x=>$val):
            $id_jenis_doc[$val]=$id_jenis_doc_arr[$x];
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
		$idx_pasien = $arrData['idx'];
		$arrFile = $this->model_file->SearchRecordWhere("id_parent=$idx_pasien");
		//$data["data_file"]=$arrDataFile;
		$data_doc = array();
		foreach($arrFile as $k=>$val){
			$data_doc[$val['id_jenis_doc']][] =$val;
		}

		$data["data_doc"]=$data_doc;
		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL");
		$data["data_asm"]=$arrDataAsm;

		$idx_assesment = $arrDataAsm['idx'];
		// rehab
		$data["monitoring_rehab"]		=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]			=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
		$data["monitoring_pasca"]		=$this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_pasca"]	=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["rehab_stat"]				=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");
		$data["pasca_stat"]				=$this->model_pasien_history_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");
		// $data["data_doc"]=$dataDocJenisDoc;

		//status general
		$data["pasien_assestment_history"]=$this->model_pasien_assesment_history->GetRecordData("idx_pasien='$id' and idx_assesment='$idx_assesment'");

		$data["jns_kegiatan"]			=$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
		$data["data"]					=$arrData;
		$data["data_proses"]			=$this->model_da->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
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
		$where[]="(status_rehab=3 and status_proses='PRRIDA')";
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

        $arrData=$this->model->GetRecordData("{$this->tbl_idx}=$id");
		//start
		$act="delete";
        if($act=="delete"):
            $this->conn->StartTrans();
				//Update Status Rehab3 ke 0
				$dataz["status_rehab"] = 0;
				$dataz["status_rawat"] = '';
				$this->model->UpdateData($dataz, "idx='$id'");
				$this->model_da->DeleteData("idx_pasien=$id");

			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview",$this->module."listview/");
        endif;
    }


	  function get_array_idx(){
		$sql			=	"select idx_pasien from ".$this->model_da->tbl;
		$array			=	$this->conn->GetAll($sql);

		foreach($array as $k=>$v):
			$arr[$k]	=	$v['idx_pasien'];
		endforeach;
		$series			=	join(",",$arr);
		return $series;
	 }
	 //----------------------------------- backup ---------------------------------
	 function update_proses_ori($id=false){
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";

	    $data=get_post();
		// debug();
		$act=$this->input->post("act")?$this->input->post("act"):"";
	   	if($act=="update"):
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
			$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			$idx=$data["idx"];
			$data['idx']='';
			$this->model_da_history->InsertData($data);
			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="PRRIDR";
				$data_update["status_rehab"]=3;
				$data_update["status_rawat"]="PASCA";
			else:
				$data_update["status_proses"]="PRRIDA";
				$data_update["status_rehab"]=3;
				$data_update["status_rawat"]="PASCA";
			endif;
			$this->model->UpdateData($data_update,"idx=$id");
			// exit;
			$this->model_da->UpdateData($data, "idx=$idx");
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
			$data['idx']='';
			$this->model_da_history->InsertData($data);
			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="PRRIDR";
				$data_update["status_rehab"]=3;
				$data_update["status_rawat"]="PASCA";
			else:
				$data_update["status_proses"]="PRRIDA";
				$data_update["status_rehab"]=3;
				$data_update["status_rawat"]="PASCA";
			endif;
			$this->model->UpdateData($data_update,"idx=$id");

			$this->model_da->InsertData($data);
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;

	}



}
