<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pertemuan_kelompok extends Admin_Controller {
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
		$this->model_pk=new general_model("t_pasca_pertemuan_kelompok");
		$this->model_pk_history=new general_model("t_pasca_pertemuan_kelompok_history");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");

		$this->model_pasien_history=new general_model("t_pasien_history");
		$this->model_monitoring_rehab=new general_model("t_pasien_monitoring_rehab");

		$this->model_pasien_history_pasca=new general_model("t_pasien_history_pasca");
		$this->model_monitoring_pasca=new general_model("t_pasien_monitoring_pasca");

		$this->model_pasien_history_lanjut=new general_model("t_pasien_history_lanjut");

		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="PASCA REHABILITASI";
		$this->module_title="Pertemuan Kelompok
		";
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
        $sql=" select a.*,b.tgl_hm,b.hsl_hm,b.keterangan,b.lokasi_kegiatan,b.nm_keluarga,b.nm_petugas,b.alamat as alamat_survey,b.jml_anggota from ".$this->model->tbl." a
                left join ".$this->model_pk->tbl." b on a.idx=b.idx_pasien and b.status_data=1 where a.active_pasien=1
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
		
        $where[]="(status_rehab=3 and status_proses='PRRLPDPK')";

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
		foreach($arrData as $k=>$v):
			for($i=1; $i<5; $i++):
				$last_idx	=	$this->conn->GetOne("select max(idx) from ".$this->model_pk_history->tbl." where idx_pasien='".$v['idx']."' and id_hm='$i'");
				$arrData[$k]['pk'.$i]	=	$this->model_pk_history->GetRecordData("idx='".$last_idx."'");
			endfor;
		endforeach;
		// pre($arrData);exit;


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


	function update_proses($id=false){
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
        // debug();

	    $data=get_post();
		// pre($data);exit;
		$act=$this->input->post("act")?$this->input->post("act"):"";
	   	if($act=="update"):
			//$data["active"]=$data["active"]?1:0;
			// unset($data["idx"]);
			$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			$idx=$data["idx"];

			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pk");
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
			// $data['idx']='';
			$data["tgl_hm"] = $data["tgl_hm"];
			$data["hsl_hm"] = $data["hsl"];

			if($data['id_hm']==1){
				$data['tgl_kegiatan']=$data['tgl_hm'];
				$tgl_kegiatan=$data['tgl_hm'];
			}else{
				$data['tgl_kegiatan']=$data['tgl_hm'];
				$tgl_kegiatan=$data['tgl_hm'];
			}

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
				$data_mtr['pdpk']=1;
				// $days=date('Y-m-d');
			else:
				$data_update["status_proses"]="PRRLPDPK"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdpk']=0;
			endif;

			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_pk->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_pk->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_pk->DeleteData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				$this->model_pk->InsertData($data);
			}
			$arrDtxHis=$this->model_pk_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			$data['idx_parent']=$this->model_pk->GetLastId("idx");
			if($arrDtxHis){
				$dataz['idx_parent']=$this->model_pk->GetLastId("idx");
				$this->model_pk_history->UpdateData($dataz, "idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				if($idx !=''){
					$this->model_pk_history->DeleteData("idx=$idx");
				}
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
					$this->model_pk_history->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_pk_history->InsertData($data);
				}
			}

			// $arrDtx=$this->model_pk->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			// if($arrDtx){
				// $dataz['status_data']=0;
				// $this->model_pk->UpdateData($dataz, "idx_pasien=$id");
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_pk->DeleteData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				// $this->model_pk->InsertData($data);
			// }
			// $arrDtxHis=$this->model_pk_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			// $data['idx_parent']=$this->model_pk->GetLastId("idx");
			// if($arrDtxHis){
				// $dataz['idx_parent']=$this->model_pk->GetLastId("idx");
				// $this->model_pk_history->UpdateData($dataz, "idx_pasien=$id");
				////if($idx !=''){
					// $this->model_pk_history->DeleteData("idx=$idx");
				////}
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
					// $this->model_pk_history->InsertData($data);
				// }else{
					// $data['status_data']=1;
					// $this->model_pk_history->InsertData($data);
				// }
			// }

			if($data['status_program']=='DO' || $data['status_program']=='MD' || $data['status_program']=='KB' || $data['status_program']=='SL'):
				$data_update["status_proses"]="PRRLPDPK"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdpk']=1;

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

			$data_update['tgl_kegiatan']=$tgl_kegiatan;
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history_lanjut($data,$data_update);

			$dataMonitoring['pdpk']=$data_mtr['pdpk'];
			if($data['id_hm']==1){
				$dataMonitoring['tgl_pdpk']=$tgl_kegiatan;
			}
			$dataMonitoring['tgl_pdpk_selesai']=$data['tgl_selesai'];
			$dataMonitoring['status_rawat_pasca']="LANJUT";
			update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);
			// exit;
			// pre($data_update);pre($data);exit;
			$ok=$this->conn->CompleteTrans();

			if($data['status_pasien']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'):
				redirect($this->module."view_detail/".$id_enc);
			else:
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			endif;

        endif;

	   if($act=="create"):
			$data=$this->_add_creator($data);
			$id_pasien = $data['idx_pasien'];
			$this->conn->StartTrans();

			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pk");
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
			$idx=$data["idx"];
			unset($data['idx']);
			$data["tgl_hm"] = $data["tgl_hm"];
			$data["hsl_hm"] = $data["hsl"];

			if($data['id_hm']==1){
				$data['tgl_kegiatan']=$data['tgl_hm'];
				$tgl_kegiatan=$data['tgl_hm'];
			}else{
				$data['tgl_kegiatan']=$data['tgl_hm'];
				$tgl_kegiatan=$data['tgl_hm'];
			}
			// pre($data);
			// pre($tgl_kegiatan);
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
				$data_mtr['pdpk']=1;
				// $days=date('Y-m-d');
			else:
				$data_update["status_proses"]="PRRLPDPK"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdpk']=0;
			endif;

			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_pk->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_pk->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$dataz['status_data']=0;
					$this->model_pk->UpdateData($dataz, "idx_pasien=$id");
					$data['status_data']=0;
				}
				$this->model_pk->UpdateData($data, "idx=$idx");
			}else{
				$dataz['status_data']=0;
				$this->model_pk->UpdateData($dataz, "idx_pasien=$id");
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
					$this->model_pk->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_pk->InsertData($data);
				}

			}
			$arrDtxHis=$this->model_pk_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			$data['idx_parent']=$this->model_pk->GetLastId("idx");
			if($arrDtxHis){
				if($idx !=''){
					$this->model_pk_history->DeleteData("idx=$idx");
				}
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
					$this->model_pk_history->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_pk_history->InsertData($data);
				}
			}else{
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_pk_history->InsertData($data);
			}

			// $arrDtx=$this->model_pk->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			// if($arrDtx){
				// $dataz['status_data']=0;
				// $this->model_pk->UpdateData($dataz, "idx_pasien=$id");
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $dataz['status_data']=0;
					// $this->model_pk->UpdateData($dataz, "idx_pasien=$id");
					// $data['status_data']=0;
				// }
				// $this->model_pk->UpdateData($data, "idx=$idx");
			// }else{
				// $data['status_data']=1;
				// $this->model_pk->InsertData($data);
			// }
			// $arrDtxHis=$this->model_pk_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			// $data['idx_parent']=$this->model_pk->GetLastId("idx");
			// if($arrDtxHis){
				// if($idx !=''){
					// $this->model_pk_history->DeleteData("idx=$idx");
				// }
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
					// $this->model_pk_history->InsertData($data);
				// }else{
					// $data['status_data']=1;
					// $this->model_pk_history->InsertData($data);
				// }
			// }else{
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_pk_history->InsertData($data);
			// }

			if($data['status_program']=='DO' || $data['status_program']=='MD' || $data['status_program']=='KB' || $data['status_program']=='SL'):
				$data_update["status_proses"]="PRRLPDPK"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_mtr['pdpk']=1;

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

			$data_update['tgl_kegiatan']=$tgl_kegiatan;
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history_lanjut($data,$data_update);

			$dataMonitoring['pdpk']=$data_mtr['pdpk'];
			if($data['id_hm']==1){
				$dataMonitoring['tgl_pdpk']=$tgl_kegiatan;
			}
			$dataMonitoring['tgl_pdpk_selesai']=$data['tgl_selesai'];
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
	function view_detail($id){

		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;

		$arrData=$this->model->GetRecordData("idx=$id");
		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL");
		$data["data_asm"]=$arrDataAsm;
		$idx_assesment = $arrDataAsm['idx'];

		$data["monitoring_rehab"]		=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]			=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
		$data["monitoring_pasca"]		=$this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_pasca"]	=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$data["pasien_history_lanjut"]	=$this->model_pasien_history_lanjut->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["jns_kegiatan"]		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
		$data["data"]=$arrData;
		//$data["history"]=$this->model_hm_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");

		for($i=1; $i<3; $i++):
			$last_idx	=	$this->conn->GetOne("select max(idx) from ".$this->model_pk_history->tbl." where idx_pasien=$id and idx_assesment='$idx_assesment' and id_hm='$i'");
			$history[$i]	=	$this->model_pk_history->GetRecordData("idx='".$last_idx."'");
		endfor;

		$data['history']	=	$history;
		$data['id']			=	$id_enc;

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
		// debug();
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
		$data["jns_kegiatan"]		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
		$data["data"]=$arrData;

		$data["monitoring_rehab"]		=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]			=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
		$data["monitoring_pasca"]		=$this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_pasca"]	=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_lanjut"]	=$this->model_pasien_history_lanjut->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$data["pasien_assestment_history"]=$this->model_pasien_assesment_history->GetRecordData("idx_pasien='$id' and idx_assesment='$idx_assesment'");

		$data["rehab_stat"]				=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");
		$data["pasca_stat"]				=$this->model_pasien_history_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");

		$data["pasien_pk_history"]=$this->model_pk_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$data["data_proses"]=$this->model_pk->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
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
				$this->model_pk->DeleteData("idx_pasien=$id");

			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview",$this->module."listview/");
        endif;
    }


	  function get_array_idx(){
		$sql			=	"select idx_pasien from ".$this->model_pk->tbl;
		$array			=	$this->conn->GetAll($sql);

		foreach($array as $k=>$v):
			$arr[$k]	=	$v['idx_pasien'];
		endforeach;
		$series			=	join(",",$arr);
		return $series;
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
		$this->model_pk_history->DeleteData($criteria);
		//End


		//Get Biggest Idx From t_pasien_detox_history
		$criteria2	=	" where idx_parent='".$idx_parent."' and idx_pasien='".$idx_pasien."' and idx_assesment='".$idx_assesment."'";
		$lastIdx	=	$this->conn->GetOne("select max(idx) from ".$this->model_pk_history->tbl.$criteria2);

		if($lastIdx):
			//Change status_data to 1
			$update_status_data['status_data']	=	1;
			$this->model_pk_history->UpdateData($update_status_data,"idx='".$lastIdx."'");
			//End

			$arr	=	$this->model_pk_history->GetRecordData("idx='".$lastIdx."'");

			foreach($arr as $k=>$v):
				if($k!=="idx" && $k!=="idx_parent" && $k!=="idx_pasien" && $k!=="idx_assesment"):
					$arrUpdate[$k]	=	$v;
				endif;
			endforeach;

			//End

			//Update to t_pasien_detox
			$criteria3	=	"idx='".$idx_parent."'";
			$this->model_pk->UpdateData($arrUpdate,$criteria3);
			//End
		else:
			$this->model_pk->DeleteData("idx_pasien='".$idx_pasien."'");
		endif;

		$complete	=	$this->conn->CompleteTrans();

		if($complete):
			echo true;
		else:
			echo false;
		endif;

	}


}
