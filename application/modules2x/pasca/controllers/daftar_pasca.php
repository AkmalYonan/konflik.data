<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class daftar_pasca extends Admin_Controller {
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
		$this->model_assesment_history=new general_model("t_pasien_assesment_history");
		$this->model_detox=new general_model("t_pasien_detox");
		$this->model_detox_history=new general_model("t_pasien_detox_history");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");
		$this->model_pasien_history=new general_model("t_pasien_history");
		$this->model_monitoring_rehab=new general_model("t_pasien_monitoring_rehab");

		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="PASCA REHABILITASI";
		$this->module_title="Daftar Pasien";
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
	 }

	function listview(){
		$this->load->library('pagination');

        // $sql=" select a.idx,a.nama,a.jenis_kelamin,a.golongan_darah,a.tempat_lahir,a.tgl_lahir,a.agama,a.status_nikah,a.no_identitas,a.jenis_identitas,a.nik,a.alamat,a.no_telp,a.no_hp,a.usia,a.pendidikan,a.pendidikan_terakhir,a.pekerjaan,a.no_rekam_medis,a.no_registrasi,a.tgl_registrasi,a.created,a.creator,a.edited,a.editor,a.warga_negara,a.negara,a.kd_propinsi,a.kd_kabupaten,a.kecamatan,a.desa,a.umur,a.kd_pos,a.periode_bulan,a.periode_tahun,a.sumber_biaya,a.sumber_pasien,a.kd_wilayah,a.kd_wilayah_propinsi,a.tempat_rehab,a.kd_tempat_rehab,a.kode_pos,a.rt_rw,a.suku,a.ayah,a.ibu,a.status_rehab,a.status_proses,a.status_check_doc,a.status_rawat,a.status_rawat_inap,a.kd_bnn,a.klg_nama,a.klg_hubungan,a.klg_alamat,a.klg_telp,a.dikirim_oleh,a.dikirim_oleh_txt,a.tgl_rekam_medis from ".$this->model->tbl." a ";
		/*
		$sql=" select
				a.idx,b.tgl_selesai_assesment,a.jns_treat,a.nama,a.jenis_kelamin,a.golongan_darah,a.tempat_lahir,a.tgl_lahir,a.agama,a.status_nikah,a.no_identitas,a.jenis_identitas,a.nik,a.alamat,a.no_telp,a.no_hp,a.usia,a.pendidikan,a.pendidikan_terakhir,a.pekerjaan,a.no_rekam_medis,a.no_registrasi,a.tgl_registrasi,a.created,a.creator,a.edited,a.editor,a.warga_negara,a.negara,a.kd_propinsi,a.kd_kabupaten,a.kecamatan,a.desa,a.umur,a.kd_pos,a.periode_bulan,a.periode_tahun,a.sumber_biaya,a.sumber_pasien,a.kd_wilayah,a.kd_wilayah_propinsi,a.tempat_rehab,a.kd_tempat_rehab,a.kode_pos,a.rt_rw,a.suku,a.ayah,a.ibu,a.status_rehab,a.status_proses,a.status_check_doc,a.status_rawat,a.status_rawat_inap,a.kd_bnn,a.klg_nama,a.klg_hubungan,a.klg_alamat,a.klg_telp,a.dikirim_oleh,a.dikirim_oleh_txt,a.tgl_rekam_medis,a.inst_rujuk,a.rujuk_rehab,a.inst_pasca,a.rujuk_pasca,a.outcome_pasien
			   from ".$this->model->tbl." a
			   left join t_pasien_assesment_history b
			   on a.idx=b.idx_pasien where b.active_pasien=1

        ";
		*/

		/* by pete */
		$sql=" select
				a.idx,a.idx_pasien,a.jns_treat,a.nama,a.jenis_kelamin,a.golongan_darah,a.tempat_lahir,a.tgl_lahir,a.agama,a.status_nikah,a.no_identitas,a.jenis_identitas,a.nik,a.alamat,a.no_telp,a.no_hp,a.usia,a.pendidikan,a.pendidikan_terakhir,a.pekerjaan,a.no_rekam_medis,a.no_registrasi,a.tgl_registrasi,a.created,a.creator,a.edited,a.editor,a.warga_negara,a.negara,a.kd_propinsi,a.kd_kabupaten,a.kecamatan,a.desa,a.umur,a.kd_pos,a.periode_bulan,a.periode_tahun,a.sumber_biaya,a.sumber_pasien,a.kd_wilayah,a.kd_wilayah_propinsi,a.tempat_rehab,a.kd_tempat_rehab,a.kode_pos,a.rt_rw,a.suku,a.ayah,a.ibu,a.status_rehab,a.status_proses,a.status_check_doc,a.status_rawat,a.status_rawat_inap,a.kd_bnn,a.klg_nama,a.klg_hubungan,a.klg_alamat,a.klg_telp,a.dikirim_oleh,a.dikirim_oleh_txt,a.tgl_rekam_medis,a.inst_rujuk,a.rujuk_rehab,a.inst_pasca,a.rujuk_pasca,a.outcome_pasien,a.inst_lanjut,a.rujuk_lanjut
			   from ".$this->model_assesment_history->tbl." a where a.status_program='PS'

        ";
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

		$data=get_post();
		// pre($data);exit;
		$instansi=$data["instansi"]!=""?$data["instansi"]:false;
		if(!empty($data["kd_wilayah"])):
			$pieces = explode("-",$data["kd_wilayah"]);
			$kdw=$pieces[0].$pieces[1];
			$data['kode']=$data["kd_wilayah"];
			$kdwil=$kdw;
		elseif(!empty($data["id_kabupaten"])):
			$data['kode']=$data["id_kabupaten"];
			$piece = explode("-",$data["id_kabupaten"]);
			$kdwil=$piece[0].$piece[1];
		elseif(!empty($data["id_km"])):
			$data['kode']=$data["id_km"];
			$piece = explode("-",$data["id_km"]);
			$kdwil=$piece[0].$piece[1];
		elseif(!empty($data["id_rd"])):
			$data['kode']=$data["id_rd"];
			$piece = explode("-",$data["id_rd"]);
			$kdwil=$piece[0].$piece[1];
		endif;

		$kdwil=$kdwil!=""?$kdwil:false;
		if($instansi!=false):
			$where[]=" inst_pasca='".$instansi."' or inst_lanjut='".$instansi."'";
		endif;
		if($kdwil!=false):
			$where[]=" kd_wilayah=".$kdwil;
		endif;
        // pre($where);exit;
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;

		/*
		if($this->user_prop):
			if($this->user_instansi!=="BNNP" && $this->user_instansi!=="BNNK"):
				$where[]	=	"(inst_pasca='".$this->user_instansi."')";
				$where[]	=	"rujuk_pasca='".$this->user_org."'";
			endif;
		endif;
		*/
		/*
		if($this->user_prop):
			if($this->user_instansi):
				$where[]	=	"(inst_pasca='".$this->user_instansi."')";
				$where[]	=	"substr(rujuk_pasca,1,5)='".$this->user_prop."-".$this->user_kab."'";
			else:
				$where[]	=	"substr(rujuk_pasca,1,5)='".$this->user_prop."-".$this->user_kab."'";
			endif;
		endif;
		*/
		//debug();

		$CI =& get_instance();
		$user_org=$CI->user_org;
		$user_prop=$CI->user_prop;
		$user_kab=$CI->user_kab;
		$user_instansi=$CI->user_instansi;

		if($user_prop):
			if($user_instansi=="BL" || $user_instansi=="BB"):
				$where[]="rujuk_lanjut='".$user_org."' or rujuk_pasca='".$user_org."'";
			endif;
			if($user_instansi=="BNNP"):
				$where[]="rujuk_lanjut ='".$user_org."' or rujuk_pasca='".$user_org."'";
			endif;
			if($user_instansi=="BNNK"):
				$where[]="rujuk_lanjut='".$user_org."' or rujuk_pasca='".$user_org."'";
			endif;
		endif;

		/*
		if($this->user_prop):
			if($this->user_instansi):
				$where[]	=	"(inst_pasca='".$this->user_instansi."')";
				$where[]	=	"rujuk_pasca='".$this->user_org."'";
			endif;
		endif;*/

		$where[]="(status_rehab='3' and status_proses!='PRAP' and outcome_pasien IS NULL)";

        $whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;

	    $uriSegment=4;
        // debug();
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

		// pre($arrData);
		// exit;t;
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
            //$this->_proses_message($ok,$this->module."listview/",$this->module."add/");
        endif;
    }


	function update_detox($id=false){

		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";

	    $data=get_post();
		$act=$this->input->post("act")?$this->input->post("act"):"";
	   	if($act=="update"):
			// debug();
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_detok");
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
			$data_history['idx_pasien']=$id;
			$data_history['status']=$data['status_pasien'];
			$this->model_detox->UpdateData($data, "idx=$idx");
			$this->model_detox_history->InsertData($data_history);

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="RIRMEU"; //entry unit
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
			else:
				$data_update["status_proses"]="RIRMDT"; //detok
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
			endif;
			$this->model->UpdateData($data_update,"idx=$id");

            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;

	   if($act=="create"):
			unset($data["idx"]);
			// debug();
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_detok");
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

			//insert history
			$data_history['idx_pasien']=$id;
			$data_history['status']=$data['status_pasien'];
			$this->model_detox_history->InsertData($data_history);

			$data=$this->_add_creator($data);
			$this->conn->StartTrans();
			$this->model_detox->InsertData($data);

			//cek status_proses && update status
			if($data['status_pasien']=='SL'):
				$data_update["status_proses"]="RIRMEU"; //entry unit
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
			else:
				$data_update["status_proses"]="RIRMDT"; //detok
				$data_update["status_rehab"]=2; //rehab
				$data_update["status_rawat"]="INAP"; //inap
			endif;
			$this->model->UpdateData($data_update,"idx=$id");
			// exit;
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
        endif;

	}

	function del_detox($id,$idx){
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
            $this->model_detox->DeleteData("idx=$idx");
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
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

		$data["monitoring_rehab"]		= $this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]			= $this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
		$data["data"]	=	$arrData;

		$rh_pasien	=	rh_pasien($id);
		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];

       	$this->_render_page($this->module."v_view",$data,true);

     }


	 function get_kab_kota($kd_bps_propinsi="",$arr_id=""){
		$sql="select * from m_kabupaten_kota where kode_prop=$kd_bps_propinsi and kode_kab!='00' order by kode_bps";

		$arrKabKota=$this->conn->GetAll($sql);
		$arrData=array();
		if(cek_array($arrKabKota)):
			foreach($arrKabKota as $x=>$val):
				$arrData[$val["kode_bps"]]=$val["nama"];
			endforeach;
		endif;
		$data["dataKabupaten"]=$arrData;
		$data["arr_id"]=$arr_id;
		echo $this->load->view($this->module."lookup_kabupaten",$data,true);
	}

	//------------------------------------- OPREK ----------------------------------------------------------
	function listview_backup(){
		$this->load->library('pagination');
        $sql=" select a.idx,a.nama,a.jenis_kelamin,a.golongan_darah,a.tempat_lahir,a.tgl_lahir,a.agama,a.status_nikah,a.no_identitas,a.jenis_identitas,a.nik,a.alamat,a.no_telp,a.no_hp,a.usia,a.pendidikan,a.pendidikan_terakhir,a.pekerjaan,a.no_rekam_medis,a.no_registrasi,a.tgl_registrasi,a.created,a.creator,a.edited,a.editor,a.warga_negara,a.negara,a.kd_propinsi,a.kd_kabupaten,a.kecamatan,a.desa,a.umur,a.kd_pos,a.periode_bulan,a.periode_tahun,a.sumber_biaya,a.sumber_pasien,a.kd_wilayah,a.kd_wilayah_propinsi,a.tempat_rehab,a.kd_tempat_rehab,a.kode_pos,a.rt_rw,a.suku,a.ayah,a.ibu,a.status_rehab,a.status_proses,a.status_check_doc,a.status_rawat,a.status_rawat_inap,a.kd_bnn,a.klg_nama,a.klg_hubungan,a.klg_alamat,a.klg_telp,a.dikirim_oleh,a.dikirim_oleh_txt,a.tgl_rekam_medis,b.tgl_kegiatan,b.lama_detox,b.tgl_mulai,b.tgl_selesai,b.keterangan from ".$this->model->tbl." a
                left join ".$this->model_detox->tbl." b on a.idx=b.idx_pasien where status_pasien <> 'SL'
        ";
		$fild="a.idx,a.nama,a.jenis_kelamin,a.golongan_darah,a.tempat_lahir,a.tgl_lahir,a.agama,a.status_nikah,a.no_identitas,a.jenis_identitas,a.nik,a.alamat,a.no_telp,a.no_hp,a.usia,a.pendidikan,a.pendidikan_terakhir,a.pekerjaan,a.no_rekam_medis,a.no_registrasi,a.tgl_registrasi,a.created,a.creator,a.edited,a.editor,a.warga_negara,a.negara,a.kd_propinsi,a.kd_kabupaten,a.kecamatan,a.desa,a.umur,a.kd_pos,a.periode_bulan,a.periode_tahun,a.sumber_biaya,a.sumber_pasien,a.kd_wilayah,a.kd_wilayah_propinsi,a.tempat_rehab,a.kd_tempat_rehab,a.kode_pos,a.rt_rw,a.suku,a.ayah,a.ibu,a.status_rehab,a.status_proses,a.status_check_doc,a.status_rawat,a.status_rawat_inap,a.kd_bnn,a.klg_nama,a.klg_hubungan,a.klg_alamat,a.klg_telp,a.dikirim_oleh,a.dikirim_oleh_txt,a.tgl_rekam_medis";
		// $fild="a.idx,a.nama,a.jenis_kelamin,a.golongan_darah,a.tempat_lahir,a.tgl_lahir,a.agama,a.status_nikah,a.no_identitas,a.jenis_identitas,a.nik,a.alamat,a.no_telp,a.no_hp,a.usia,a.pendidikan,a.pendidikan_terakhir,a.pekerjaan,a.no_rekam_medis,a.no_registrasi,a.tgl_registrasi,a.created,a.creator,a.edited,a.editor,a.warga_negara,a.negara,a.kd_propinsi,a.kd_kabupaten,a.kecamatan,a.desa,a.umur,a.kd_pos,a.periode_bulan,a.periode_tahun,a.sumber_biaya,a.sumber_pasien,a.kd_wilayah,a.kd_wilayah_propinsi,a.tempat_rehab,a.kd_tempat_rehab,a.kode_pos,a.rt_rw,a.suku,a.ayah,a.ibu,a.status_rehab,a.status_proses,a.status_check_doc,a.status_rawat,a.status_rawat_inap,a.kd_bnn,a.klg_nama,a.klg_hubungan,a.klg_alamat,a.klg_telp,a.dikirim_oleh,a.dikirim_oleh_txt,a.tgl_rekam_medis,a.tgl_kegiatan,a.lama_detox,a.tgl_mulai,a.tgl_selesai,a.keterangan";
		// $sql=" select a.*,b.tgl_kegiatan,b.lama_detox,b.tgl_mulai,b.tgl_selesai,b.keterangan from ".$this->model->tbl." a
                // left join ".$this->model_detox->tbl." b on a.idx=b.idx_pasien where status_pasien <> 'SL'
        // ";
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

		$where[]="(status_rehab=2 and status_proses='RIRMDT')";

        $whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;

	    $uriSegment=4;

        $totalRows=$this->model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" group by a.idx order by {$this->tbl_sort}";

		// $arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        $arrData=$this->conn->GetAll("select $fild from $table WHERE $whereSql $sortBy LIMIT $offset,$perPage");
		// pre($arrData);exit;
		$config['base_url'] = $this->module."listview";
        $config['per_page'] = $perPage;
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
        $data["arrData"]=$arrData;
		// exit;
		$this->_render_page($this->module."v_list",$data,true);
    }




}
