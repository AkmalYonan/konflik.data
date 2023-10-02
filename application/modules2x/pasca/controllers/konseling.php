<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class konseling extends Admin_Controller {
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
		$this->model_pasien=new general_model("t_pasien_pasca_konseling");
		$this->model_kl=new general_model("t_pasien_pasca_konseling");
		$this->model_kl_history=new general_model("t_pasien_pasca_konseling_history");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");
		$this->model_pasien_history=new general_model("t_pasien_history");
		$this->model_monitoring_rehab=new general_model("t_pasien_monitoring_rehab");

		$this->model_pasien_history_pasca=new general_model("t_pasien_history_pasca");
		$this->model_monitoring_pasca=new general_model("t_pasien_monitoring_pasca");

		$this->model_pasien_history_lanjut=new general_model("t_pasien_history_lanjut");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="PASCA REHABILITASI";
		$this->module_title="Konseling";
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
        $sql	=	"
					select
					a.*,
					b.tgl_konseling,
					b.hasil_konseling,
					b.no_telp_pj_keluarga,
					b.nama_pj_keluarga,
					b.nama_petugas,
					b.lampiran

					from ".$this->model->tbl." a

					left join ".$this->model_pasien->tbl." b
					on a.idx=b.idx_pasien and b.status_data=1 where a.active_pasien=1
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
            if($this->user_instansi):
                $where[]	=	"((inst_pasca='".$this->user_instansi."' and rujuk_pasca='".$this->user_org."') or (inst_lanjut='".$this->user_instansi."' and rujuk_lanjut='".$this->user_org."'))";
            endif;
        endif;

        $where[]="(status_rehab=3 and status_proses='PRRLPDKN')";

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

		$act=$this->input->post("act")?$this->input->post("act"):"";

	   	if($act=="update"):
			//$data["active"]=$data["active"]?1:0;
			$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			$idx=$data["idx"];

			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pasca_konseling");
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

			//cek status_proses && update status
			$status_prosesx=$data["status_prosesx"];
			$data_proses=$this->conn->GetRow("select * from m_proses_rehab where kd_status_proses='".$status_prosesx."'");
			$data["status_rehab"]=$data_proses["kd_status_rehab"];//1reg 2rehab 3pasca

			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				$inst_lanjut=$data['status_proses'];
				$rujuk_lanjut=$data["kd_wilayah"];
				$kdwil=$kdw;
			elseif(!empty($data["id_kabupaten"])):
				$kdwil=$data["id_kabupaten"];
				$inst_lanjut=$data['status_proses'];
				$rujuk_lanjut=$data["id_kabupaten"];
				$piece = explode("-",$data["id_kabupaten"]);
				$kdwil=$piece[0].$piece[1];
			elseif(!empty($data["id_km"])):
				$kdwil=$data["id_km"];
				$inst_lanjut=$data['status_proses'];
				$rujuk_lanjut=$data["id_km"];
				$piece = explode("-",$data["id_km"]);
				$kdwil=$piece[0].$piece[1];
			elseif(!empty($data["id_rd"])):
				$kdwil=$data["id_rd"];
				$inst_lanjut=$data['status_proses'];
				$rujuk_lanjut=$data["id_rd"];
				$piece = explode("-",$data["id_rd"]);
				$kdwil=$piece[0].$piece[1];
			endif;

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]=$data_proses["kd_status_proses"];
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["inst_lanjut"]=$inst_lanjut;
				$data_update["rujuk_lanjut"]=$rujuk_lanjut;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdkl']=1;
				// $days=date('Y-m-d');
			else:
				$data_update["status_proses"]="PRRLPDKN"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdkl']=0;
			endif;

			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_kl->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_kl->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}

				$this->model_kl->UpdateData($data, "idx=$idx");
			}
			$arrDtxHis=$this->model_kl_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtxHis){
				$dataz['status_data']=0;
				$this->model_kl_history->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_kl_history->InsertData($data);
			}
			// exit;
			// $this->model_kl->UpdateData($data, "idx=$idx");
			// $this->model_kl_history->InsertData($data);

			// $this->model->UpdateData($data_update,"idx=$id");
			// $this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($data['status_program']=='DO' || $data['status_program']=='MD' || $data['status_program']=='KB' || $data['status_program']=='SL'):
				$data_update["status_proses"]="PRRLPDKN"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdkl']=1;

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
				$dataMonitoring['tgl_selesai_pasca']=$data['tgl_selesai_program'];
			else:
				$data_update["active_pasien"]=1;
				$data_update["outcome_pasien"]=NULL;
				$this->model->UpdateData($data_update,"idx=$id");

				// $data_update['status_program_terakhir']=$data['status_program'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				update_status_program_pasca($id,$data['idx_assesment'],$data['status_program']);
			endif;

			$data_update['tgl_kegiatan']=$data['tgl_konseling'];
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history_lanjut($data,$data_update);

			$dataMonitoring['pdkl']=$data_mtr['pdkl'];
			$dataMonitoring['tgl_pdkl']=$data['tgl_konseling'];
			$dataMonitoring['tgl_pdkl_selesai']=$data['tgl_selesai'];
			$dataMonitoring['status_rawat_pasca']="LANJUT";
			update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);

			$ok=$this->conn->CompleteTrans();
			$ok=$this->conn->CompleteTrans();

			if($data['status_pasien']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'):
				redirect($this->module."view_detail/".$id_enc);
			else:
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			endif;

        endif;

	   if($act=="create"):
			//$data["active"]=$data["active"]?1:0;
			unset($data["idx"]);
			// debug();
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pasca_konseling");
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

			//cek status_proses && update status
			$status_prosesx=$data["status_prosesx"];
			$data_proses=$this->conn->GetRow("select * from m_proses_rehab where kd_status_proses='".$status_prosesx."'");
			$data["status_rehab"]=$data_proses["kd_status_rehab"];//1reg 2rehab 3pasca

			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				$inst_lanjut=$data['status_proses'];
				$rujuk_lanjut=$data["kd_wilayah"];
				$kdwil=$kdw;
			elseif(!empty($data["id_kabupaten"])):
				$kdwil=$data["id_kabupaten"];
				$inst_lanjut=$data['status_proses'];
				$rujuk_lanjut=$data["id_kabupaten"];
				$piece = explode("-",$data["id_kabupaten"]);
				$kdwil=$piece[0].$piece[1];
			elseif(!empty($data["id_km"])):
				$kdwil=$data["id_km"];
				$inst_lanjut=$data['status_proses'];
				$rujuk_lanjut=$data["id_km"];
				$piece = explode("-",$data["id_km"]);
				$kdwil=$piece[0].$piece[1];
			elseif(!empty($data["id_rd"])):
				$kdwil=$data["id_rd"];
				$inst_lanjut=$data['status_proses'];
				$rujuk_lanjut=$data["id_rd"];
				$piece = explode("-",$data["id_rd"]);
				$kdwil=$piece[0].$piece[1];
			endif;

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]=$data_proses["kd_status_proses"];
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["inst_lanjut"]=$inst_lanjut;
				$data_update["rujuk_lanjut"]=$rujuk_lanjut;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdkl']=1;
				// $days=date('Y-m-d');
			else:
				$data_update["status_proses"]="PRRLPDKN"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdkl']=0;
			endif;

			//debug();
			unset($data['idx']);
			$arrDtx=$this->model_kl->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_kl->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_kl->InsertData($data);
			}else{
				$dataz['status_data']=0;
				$this->model_kl->UpdateData($dataz, "idx_pasien=$id");
				if($data['status_pasien']=='SL'){
					$dataz['status_data']=0;
					//$this->model_kl->UpdateData($dataz, "idx_pasien=$id");
                    $this->model_kl->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_kl->InsertData($data);
				}
			}
			$arrDtxHis=$this->model_kl_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtxHis){
				$dataz['status_data']=0;
				$this->model_kl_history->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_kl_history->InsertData($data);
			}else{
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_kl_history->InsertData($data);
			}

            //exit;

            if($data['status_program']=='DO' || $data['status_program']=='MD' || $data['status_program']=='KB' ||   $data['status_program']=='SL'):
				$data_update["status_proses"]="PRRLPDKN"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdkl']=1;

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
				$dataMonitoring['tgl_selesai_pasca']=$data['tgl_selesai_program'];
			else:
				$data_update["active_pasien"]=1;
				$data_update["outcome_pasien"]=NULL;
				$this->model->UpdateData($data_update,"idx=$id");

				// $data_update['status_program_terakhir']=$data['status_program'];
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");

				update_status_program_pasca($id,$data['idx_assesment'],$data['status_program']);
			endif;

			$data_update['tgl_kegiatan']=$data['tgl_konseling'];
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history_lanjut($data,$data_update);

			$dataMonitoring['pdkl']=$data_mtr['pdkl'];
			$dataMonitoring['tgl_pdkl']=$data['tgl_konseling'];
			$dataMonitoring['tgl_pdkl_selesai']=$data['tgl_selesai'];
			$dataMonitoring['status_rawat_pasca']="LANJUT";
			update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);
			// exit;

            $ok=$this->conn->CompleteTrans();

			if($data['status_pasien']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'):
				redirect($this->module."view_detail/".$id_enc);
			else:
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			endif;

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
		// debug();
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
		$data["data"]=$arrData;
		$data["monitoring_rehab"]		=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]			=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
		$data["monitoring_pasca"]		=$this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_pasca"]	=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$data["pasien_history_lanjut"]	=$this->model_pasien_history_lanjut->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$data["pasien_assestment_history"]=$this->model_pasien_assesment_history->GetRecordData("idx_pasien='$id' and idx_assesment='$idx_assesment'");

		$data["rehab_stat"]				=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");
		$data["pasca_stat"]				=$this->model_pasien_history_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");

		//$arrDetox=$this->model_detox->SearchRecordWhere("idx_pasien=$id","order by idx desc");
		$data["data_proses"]=$this->model_kl->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		if($arrData["inst_pasca"] !='' && $arrData["rujuk_pasca"] !=''):
				$datax['inst_pasca']=$arrData["inst_pasca"];
				$datax['rujuk_pasca']=$arrData["rujuk_pasca"];
			elseif($arrData["inst_lanjut"] !='' && $arrData["rujuk_lanjut"] !=''):
				$datax['inst_pasca']=$arrData["inst_lanjut"];
				$datax['rujuk_pasca']=$arrData["rujuk_lanjut"];
			endif;
			$data['kondisi']=$datax;
			// pre($data);exit;
       	$this->_render_page($this->module."v_view",$data,true);

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

		$arrKonseling	=	$this->model_pasien->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$data["monitoring_rehab"]		=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]			=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
		$data["monitoring_pasca"]		=$this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_pasca"]	=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$data["pasien_history_lanjut"]	=$this->model_pasien_history_lanjut->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$data["rehab_stat"]				=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");
		$data["pasca_stat"]				=$this->model_pasien_history_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");

		$data['data']	=	$arrData;
		$data['data_konseling']	=	$arrKonseling;

		$rh_pasien	=	rh_pasien($id);
		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];

		$this->_render_page($this->module."v_detail",$data,true);

	 }


}
