<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pemantauan_urin extends Admin_Controller {
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
		$this->model_pasien=new general_model("t_pasien_pasca_pu");
		$this->model_pasien_history=new general_model("t_pasien_pasca_pu_history");
		$this->model_jenis_kegiatan=new general_model("m_jenis_kegiatan");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");

		$this->model_pasien_history_main=new general_model("t_pasien_history");
		$this->model_monitoring_rehab=new general_model("t_pasien_monitoring_rehab");

		$this->model_pasien_history_pasca=new general_model("t_pasien_history_pasca");
		$this->model_monitoring_pasca=new general_model("t_pasien_monitoring_pasca");

		$this->model_pasien_history_lanjut=new general_model("t_pasien_history_lanjut");

		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="PASCA REHABILITASI";
		$this->module_title="Kegiatan Pemantauan - Tes Urin";
		$this->tbl_idx="idx";
		$this->tbl_idx_pasien="idx_pasien";
		$this->tbl_sort="idx desc";
		$this->jenis_kegiatan_filter	=	"kategori='pu'";
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
		// debug();
		$this->load->library('pagination');

        $sql	=	"
					select
					a.*,
					b.tgl_tes,
					b.hasil_tes,

					b.nama_pj_keluarga,
					b.nama_petugas_tes,
					b.lampiran

					from ".$this->model->tbl." a

					left join ".$this->model_pasien->tbl." b
					on a.idx=b.idx_pasien and b.status_data=1 where a.outcome_pasien IS NULL

        			";

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

        if($this->user_prop):
            if($this->user_instansi):
                $where[]	=	"((inst_pasca='".$this->user_instansi."' and rujuk_pasca='".$this->user_org."') or (inst_lanjut='".$this->user_instansi."' and rujuk_lanjut='".$this->user_org."'))";
            endif;
        endif;

        $where[]="(status_rehab=3 and status_proses='PRRLPUTU')";
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


		$arrData	=	$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);

		foreach($arrData as $k=>$v):
			for($i=1; $i<5; $i++):
				$last_idx	=	$this->conn->GetOne("select max(idx) from ".$this->model_pasien_history->tbl." where idx_pasien='".$v['idx']."' and idx_tes='$i'");
				$arrData[$k]['tes'.$i]	=	$this->model_pasien_history->GetRecordData("idx='".$last_idx."'");
			endfor;
		endforeach;

		$config['base_url'] = $this->module."listview";
        $config['per_page'] = $perPage;
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
        // exit;
		$data["arrData"]=$arrData;
		$data["lookup_bnnp"]=lookup("m_org","kd_org","nama",false,"order by idx");
		$data["lookup_inst"]=lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
		$data["lookup_jns_org"]=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org",false,"order by idx");
		$this->_render_page($this->module."v_list",$data,true);
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
				$config['upload_path']		=	$this->config->item("dir_pemantauan_urin");
				$config['file_name']		=	time().substr($data['lampiran_name'],strrpos($data['lampiran_name'],"."));
				$config['max_size']			=	"500000";
				$config['overwrite']		=	TRUE;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('lampiran');

				$file						=	$this->upload->data();
				$data['file']				=	$file['file_name'];
			endif;

			$tes							=	$data['idx_tes'];
			$data['tgl_tes_'.$tes]			=	$data['tanggal_tes'];
			$data['hasil_tes_'.$tes]		=	$data['hasil_tes'];

			$data			=	$this->_add_creator($data);

			$start		=	$this->conn->StartTrans();
			$this->model->InsertData($data);
			$complete	=	$this->conn->CompleteTrans();

			$this->_proses_message($complete,$this->module."listview/",$this->module."add/".$id_enc);

        endif;
    }

    function view($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;

		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";

        $act=$this->input->post("act")?$this->input->post("act"):"";

		//pre($act);exit;

        // echo "asd";exit;
		if(empty($act)):
			// debug();
			$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1");
			$data["data_asm"]=$arrDataAsm;
			$idx_assesment = $arrDataAsm['idx'];
			$arrData				=	$this->model->GetRecordData("idx=$id");
			$idx_pasien = $arrData['idx'];
			$arrFile = $this->model_file->SearchRecordWhere("id_parent=$idx_pasien");
			//$data["data_file"]=$arrDataFile;
			$data_doc = array();
			foreach($arrFile as $k=>$val){
				$data_doc[$val['id_jenis_doc']][] =$val;
			}

			$data["data_doc"]=$data_doc;
			$arrPasien				=	$this->model_pasien->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_data=1");
			$arrJenisKegiatan		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
			$data['data']			=	$arrData;
			$data['datax']			=	$arrPasien;
			$data['jenis_kegiatan']	=	$arrJenisKegiatan;
			$data['id']				=	$id_enc;
			$data['idx_pasien']		=	$id;
			$data['act']			=	"view";

			$data["monitoring_rehab"]		=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
			$data["pasien_history"]			=$this->model_pasien_history_main->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
			$data["monitoring_pasca"]		=$this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
			$data["pasien_history_pasca"]	=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
			$data["pasien_history_lanjut"]	=$this->model_pasien_history_lanjut->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

			$data["pasien_assestment_history"]=$this->model_pasien_assesment_history->GetRecordData("idx_pasien='$id' and idx_assesment='$idx_assesment'");

			$data["pasien_pasca_pu_history"] =$this->model_pasien_history->SearchRecordWhere("idx_pasien='$id' and idx_assesment='$idx_assesment'");

			$data["rehab_stat"]				=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");
			$data["pasca_stat"]				=$this->model_pasien_history_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");

			if($arrData["inst_pasca"] !='' && $arrData["rujuk_pasca"] !=''):
				$datax['inst_pasca']=$arrData["inst_pasca"];
				$datax['rujuk_pasca']=$arrData["rujuk_pasca"];
			elseif($arrData["inst_lanjut"] !='' && $arrData["rujuk_lanjut"] !=''):
				$datax['inst_pasca']=$arrData["inst_lanjut"];
				$datax['rujuk_pasca']=$arrData["rujuk_lanjut"];
			endif;
			$data['kondisi']=$datax;

			//pre($data);exit;

			$this->_render_page($this->module."v_execute",$data,true);

        endif;
		// debug();
		if($act=="update"):
			// echo "sda";exit;
			$data=get_post();

			//pre($data);exit;

			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pemantauan_urin");
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
			$start		=	$this->conn->StartTrans();
			$data=$this->_add_editor($data);
			$idx=$data['idx'];

			if($data['idx_tes']==1){
				$data['tgl_kegiatan']=$data['tanggal_tes'];
				$tgl_kegiatan=$data['tanggal_tes'];
			}else{
				$data['tgl_kegiatan']=$data['tanggal_tes'];
				$tgl_kegiatan=$data['tanggal_tes'];
			}
			// debug();
			//cek status_proses && update status
			$status_proses=$data["status_proses"];
			$data_proses=$this->conn->GetRow("select * from m_proses_rehab where kd_status_proses='".$status_proses."'");
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

			if($data['status_program']=='SL'):
				$data_update["active_pasien"]=0;
				$data_update["outcome_pasien"]=$data['outcome_pasien'];
				$data_update["status_rawat"]="PASCA";
				$data_update["inst_lanjut"]=$inst_lanjut;
				$data_update["rujuk_lanjut"]=$rujuk_lanjut;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_update["status_proses"]="PRRLPUTU"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_mtr['putu']=1;
				// $days=date('Y-m-d');
				$data_update['tgl_selesai_pasca']=$data['tgl_selesai_program'];

				$data_update['status_rm']="SL";
				$data_update['status_program']=$data['status_program'];

				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				$this->model->UpdateData($data_update,"idx=$id");

				$data_reset['active_pasien']=0;
				$data_reset['outcome_pasien']=$data['outcome_pasien'];
				$data_reset['status_rm']="SL";
				$data_reset['status_program']=$data['status_program'];
				$this->model_assesment_summary->UpdateData($data_reset,"idx_pasien=$id and idx=$data[idx_assesment]");

				update_status_program_pasca($id,$data['idx_assesment'],$data['status_program'],$data['outcome_pasien']);
			else:
				// $data_update["status_proses"]="PRRLPUTU";
				$data_update["active_pasien"]=1;
				$data_update["outcome_pasien"]=NULL;
				$data_update["status_rawat"]="PASCA";
				$data_mtr['putu']=0;
				$data_update["status_proses"]="PRRLPUTU"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$this->model->UpdateData($data_update,"idx=$id");
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			endif;

			$data['tgl_tes']			=	$data['tanggal_tes'];
			$data['hasil_tes']		=	$data['hasil_tes'];

			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_pasien->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_pasien->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_program']=='SL'){
					$data['status_data']=0;
				}
				$this->model_pasien->DeleteData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				// $this->model_pasien->UpdateData($data, "idx=$idx");
				$this->model_pasien->InsertData($data);
			}
			$arrDtxHis=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			$data['idx_parent']=$this->model_pasien->GetLastId("idx");
			if($arrDtxHis){
				$dataz['idx_parent']=$this->model_pasien->GetLastId("idx");
				$this->model_pasien_history->UpdateData($dataz, "idx_pasien=$id");
				if($idx !=''){
					$this->model_pasien_history->DeleteData("idx=$idx");
				}
				if($data['status_program']=='SL'){
					$data['status_data']=0;
					$this->model_pasien_history->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_pasien_history->InsertData($data);
				}
			}

			// $arrDtx=$this->model_pasien->GetRecordData("idx_pasien=$id");
			// if($arrDtx){
				// $dataz['status_data']=0;
				// $this->model_pasien->UpdateData($dataz, "idx_pasien=$id");
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_pasien->UpdateData($data, "idx=$idx");
			// }
			// $arrDtxHis=$this->model_pasien_history->GetRecordData("idx_pasien=$id");
			// if($arrDtxHis){
				// $dataz['status_data']=0;
				// $this->model_pasien_history->UpdateData($dataz, "idx_pasien=$id");
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_pasien_history->InsertData($data);
			// }
			// exit;

			$data_update['tgl_kegiatan']=$data['tgl_kegiatan'];
			$data_update['status_pasien']=$data['status_program'];
			$data_update['tgl_selesai']=$data['tgl_selesai_program'];
			update_pasien_history_lanjut($data,$data_update);

			$dataMonitoring['putu']=$data_mtr['putu'];
			if($data['idx_tes']==1){
				$dataMonitoring['tgl_putu']=$data['tgl_kegiatan'];
			}
			$dataMonitoring['tgl_putu_selesai']=$data['tgl_selesai_program'];
			$dataMonitoring['tgl_selesai_pasca']=$data['tgl_selesai_program'];
			$dataMonitoring['status_rawat_pasca']="LANJUT";
			update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);
			// exit;
			$complete	=	$this->conn->CompleteTrans();

			if($data['status_program']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'):
				redirect("pasca/outcome/view/$id_enc");
			else:
				$this->_proses_message($complete,$this->module."view/$id_enc",$this->module."view/$id_enc");
			endif;

        endif;

		if($act=="create"):
			$data=get_post();

			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_pemantauan_urin");
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
			$start		=	$this->conn->StartTrans();
			$data=$this->_add_creator($data);
			$idx=$data["idx"];
			if($data['idx_tes']==1){
				$data['tgl_kegiatan']=$data['tanggal_tes'];
				$tgl_kegiatan=$data['tanggal_tes'];
			}else{
				$data['tgl_kegiatan']=$data['tanggal_tes'];
				$tgl_kegiatan=$data['tanggal_tes'];
			}

			//cek status_proses && update status
			$status_proses=$data["status_proses"];
			$data_proses=$this->conn->GetRow("select * from m_proses_rehab where kd_status_proses='".$status_proses."'");
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

			if($data['status_program']=='SL'):
				// $data_update["status_proses"]=$data_proses["kd_status_proses"];
				$data_update["active_pasien"]=0;
				$data_update["outcome_pasien"]=$data['outcome_pasien'];
				$data_update["status_rawat"]="PASCA";
				$data_update["inst_lanjut"]=$inst_lanjut;
				$data_update["rujuk_lanjut"]=$rujuk_lanjut;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data_update["status_proses"]="PRRLPUTU"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_mtr['putu']=1;
				// $days=date('Y-m-d');
				$data_update['tgl_selesai_pasca']=$data['tgl_selesai_program'];

				$data_update['status_rm']="SL";
				$data_update['status_program']=$data['status_program'];

				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				$this->model->UpdateData($data_update,"idx=$id");

				$data_reset['active_pasien']=0;
				$data_reset['outcome_pasien']=$data['outcome_pasien'];
				$data_reset['status_rm']="SL";
				$data_reset['status_program']=$data['status_program'];
				$this->model_assesment_summary->UpdateData($data_reset,"idx_pasien=$id and idx=$data[idx_assesment]");
				update_status_program_pasca($id,$data['idx_assesment'],$data['status_program'],$data['outcome_pasien']);
			else:
				// $data_update["status_proses"]="PRRLPUTU";
				$data_update["active_pasien"]=1;
				$data_update["outcome_pasien"]=NULL;
				$data_update["status_rawat"]="PASCA";
				$data_mtr['putu']=0;
				$data_update["status_proses"]="PRRLPUTU"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$this->model->UpdateData($data_update,"idx=$id");
				$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$data[idx_assesment]");
				update_status_program_pasca($id,$data['idx_assesment'],$data['status_program'],$data['outcome_pasien']);
			endif;
			// $tes							=	$data['idx_tes'];
			$data['tgl_tes']			=	$data['tanggal_tes'];
			$data['hasil_tes']		=	$data['hasil_tes'];

			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_pasien->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_pasien->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_program']=='SL'){
					$dataz['status_data']=0;
					$this->model_pasien->UpdateData($dataz, "idx_pasien=$id");
					$data['status_data']=0;
				}
				$this->model_pasien->UpdateData($data, "idx=$idx");
				// $this->model_tk->InsertData($data);
			}else{
				$dataz['status_data']=0;
				$this->model_pasien->UpdateData($dataz, "idx_pasien=$id");
				if($data['status_program']=='SL'){
					$dataz['status_data']=0;
					$this->model_pasien->UpdateData($dataz, "idx_pasien=$id");
				}else{
					$data['status_data']=1;
					$this->model_pasien->InsertData($data);
				}

				// $data['status_data']=1;
				// $this->model_pasien->InsertData($data);
			}
			// debug();
			$arrDtxHis=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			$data['idx_parent']=$this->model_pasien->GetLastId("idx");
			if($arrDtxHis){
				if($idx !=''){
					$this->model_pasien_history->DeleteData("idx=$idx");
				}
				if($data['status_program']=='SL'){
					$data['status_data']=0;
					$this->model_pasien_history->InsertData($data);
				}else{
					$data['status_data']=1;
					$this->model_pasien_history->InsertData($data);
				}
			}else{
				$data['status_data']=1;
				if($data['status_program']=='SL'){
					$data['status_data']=0;
				}

				$this->model_pasien_history->InsertData($data);
			}

			// $arrDtx=$this->model_pasien->GetRecordData("idx_pasien=$id");
			// if($arrDtx){
				// $dataz['status_data']=0;
				// $this->model_pasien->UpdateData($dataz, "idx_pasien=$id");
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_pasien->InsertData($data);
			// }else{
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_pasien->InsertData($data);
			// }
			// $arrDtxHis=$this->model_pasien_history->GetRecordData("idx_pasien=$id");
			// if($arrDtxHis){
				// $dataz['status_data']=0;
				// $this->model_pasien_history->UpdateData($dataz, "idx_pasien=$id");
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_pasien_history->InsertData($data);
			// }else{
				// $data['status_data']=1;
				// if($data['status_pasien']=='SL'){
					// $data['status_data']=0;
				// }
				// $this->model_pasien_history->InsertData($data);
			// }

			$data_update['tgl_kegiatan']=$data['tgl_kegiatan'];
			$data_update['status_program']=$data['status_program'];
			$data_update['tgl_selesai']=$data['tgl_selesai_program'];
			update_pasien_history_lanjut($data,$data_update);

			$dataMonitoring['putu']=$data_mtr['putu'];
			if($data['idx_tes']==1){
				$dataMonitoring['tgl_putu']=$data['tgl_kegiatan'];
			}
			$dataMonitoring['tgl_putu_selesai']=$data['tgl_selesai_program'];
			$dataMonitoring['tgl_selesai_pasca']=$data['tgl_selesai_program'];
			update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);
			// exit;
			$complete	=	$this->conn->CompleteTrans();

			if($data['status_program']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'):
				redirect("pasca/outcome/view/$id_enc");
			else:
				$this->_proses_message($complete,$this->module."view/$id_enc",$this->module."view/$id_enc");
			endif;

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
			unlink($this->config->item('dir_pemantauan_urin').$arrData['file']);
		endif;

        $act="delete";
        if($act=="delete"):

            $start		=	$this->conn->StartTrans();
                $this->model->DeleteData("{$this->tbl_idx_pasien}=$id");
            $complete	=	$this->conn->CompleteTrans();
            $this->_proses_message($complete,$this->module."listview",$this->module."listview/");
        endif;
    }

	function view_detail($id){

		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;

		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1");

		$data["data_asm"]=$arrDataAsm;
		$idx_assesment = $arrDataAsm['idx'];
		$arrData				=	$this->model->GetRecordData("idx=$id");
        $arrPasien				=	$this->model_pasien->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$arrJenisKegiatan		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
		$data['data']			=	$arrData;
		$data['datax']			=	$arrPasien;
		$data['jenis_kegiatan']	=	$arrJenisKegiatan;
		$data['id']				=	$id_enc;
		$data['idx_pasien']		=	$id;
		$data['act']			=	"view";

		$data["monitoring_rehab"]		=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]			=$this->model_pasien_history_main->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
		$data["monitoring_pasca"]		=$this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_pasca"]	=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_lanjut"]	=$this->model_pasien_history_lanjut->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

		for($i=1; $i<5; $i++):
			$last_idx	=	$this->conn->GetOne("select max(idx) from ".$this->model_pasien_history->tbl." where idx_pasien=$id and idx_assesment='$idx_assesment' and idx_tes='$i'");

			$history[$i]=	$this->model_pasien_history->GetRecordData("idx='$last_idx'");
		endfor;

		$data['history']	=	$history;

		$rh_pasien	=	rh_pasien($id);
		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];

		//pre($data);exit;

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

	public function delete_ajax(){

		$data			=	get_post();

		$idx			=	$data['idx'];
		$idx_parent		=	$data['idx_parent'];
		$idx_pasien		=	$data['idx_pasien'];
		$idx_assesment	=	$data['idx_assesment'];

		$start		=	$this->conn->StartTrans();

		//Delete Session
		$criteria	=	"idx='".$idx."'";
		$this->model_pasien_history->DeleteData($criteria);
		//End


		//Get Biggest Idx From t_pasien_detox_history
		$criteria2	=	" where idx_parent='".$idx_parent."' and idx_pasien='".$idx_pasien."' and idx_assesment='".$idx_assesment."'";
		$lastIdx	=	$this->conn->GetOne("select max(idx) from ".$this->model_pasien_history->tbl.$criteria2);

		if($lastIdx):
			//Change status_data to 1
			$update_status_data['status_data']	=	1;
			$this->model_pasien_history->UpdateData($update_status_data,"idx='".$lastIdx."'");
			//End

			$arr	=	$this->model_pasien_history->GetRecordData("idx='".$lastIdx."'");

			foreach($arr as $k=>$v):
				if($k!=="idx" && $k!=="idx_parent" && $k!=="idx_pasien" && $k!=="idx_assesment"):
					$arrUpdate[$k]	=	$v;
				endif;
			endforeach;

			//End

			//Update to t_pasien_detox
			$criteria3	=	"idx='".$idx_parent."'";
			$this->model_pasien->UpdateData($arrUpdate,$criteria3);
			//End
		else:
			$this->model_pasien->DeleteData("idx_pasien='".$idx_pasien."'");
		endif;

		$complete	=	$this->conn->CompleteTrans();

		if($complete):
			echo true;
		else:
			echo false;
		endif;

	}

}
