<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dukungan_keluarga extends Admin_Controller {
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
		$this->model_pasien=new general_model("t_pasien_pasca_dk");
		$this->model_pasien_history=new general_model("t_pasien_pasca_dk_history");
		$this->model_jenis_kegiatan=new general_model("m_jenis_kegiatan");
		$this->model_keluarga=new general_model("m_dukungan_keluarga");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");

		$this->model_pasien_history_main=new general_model("t_pasien_history");
		$this->model_monitoring_rehab=new general_model("t_pasien_monitoring_rehab");

		$this->model_pasien_history_pasca=new general_model("t_pasien_history_pasca");
		$this->model_monitoring_pasca=new general_model("t_pasien_monitoring_pasca");

		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="PASCA REHABILITASI";
		$this->module_title="Dukungan Keluarga";
		$this->tbl_idx="idx";
		$this->tbl_idx_pasien="idx_pasien";
		$this->tbl_sort="idx desc";
		$this->jenis_kegiatan_filter	=	"kategori='dk'";
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
					b.tgl_kegiatan,
					b.keluarga,
					b.keterangan,
					b.lampiran,
					c.ur_jenis_kegiatan

					from ".$this->model->tbl." a

					left join ".$this->model_pasien->tbl." b
					on a.idx=b.idx_pasien and b.status_data=1

					left join ".$this->model_jenis_kegiatan->tbl." c
					on b.idx_jenis_kegiatan=c.idx and c.".$this->jenis_kegiatan_filter."
					where a.active_pasien=1
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
			if($this->user_instansi!=="BL" && $this->user_instansi!=="RD" && $this->user_instansi!=="KM"):
				$where[]	=	"(inst_pasca='".$this->user_instansi."')";
				$where[]	=	"rujuk_pasca='".$this->user_org."'";
			endif;
		endif;

		$where[]="(status_rehab=3 and status_proses='PRRIDK')";

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
			$explode=	explode(",",$v['keluarga']);
			foreach($explode as $kk=>$vk):
				$arr_kel=	$this->model_keluarga->GetRecordData("idx='".$vk."'");
				$kel[$k][]	=	$arr_kel['ur_keluarga'];
			endforeach;
			$arrData[$k]['keluarga_terlibat']	=	implode(", ",$kel[$k]);
		endforeach;

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
			$arrKeluarga			=	$this->model_keluarga->ListAll();
			$data['datax']			=	$arrData;
			$data['data']			=	$arrPasien;
			$data['jenis_kegiatan']	=	$arrJenisKegiatan;
			$data['keluarga']		=	$arrKeluarga;
			$data['id']				=	$id_enc;
			$data['idx_pasien']		=	$id;
			$data['act']			=	"add";

            $this->_render_page($this->module."v_execute",$data,true);

        endif;

        if($act=="add"):

			$data		=	get_post();

			if($data['lampiran_name']):
				$config['allowed_types']	=	"doc|docx|pdf|xls|xlsx|jpg|jpeg";
				$config['upload_path']		=	$this->config->item("dir_dukungan_keluarga");
				$config['file_name']		=	time().substr($data['lampiran_name'],strrpos($data['lampiran_name'],"."));
				$config['max_size']			=	"500000";
				$config['overwrite']		=	TRUE;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('lampiran');

				$file						=	$this->upload->data();
				$data['file']				=	$file['file_name'];
			endif;

			$data			=	$this->_add_creator($data);

			if($data['arr_keluarga']):
				foreach($data['arr_keluarga'] as $kk=>$vk):
					$keluarga[$kk]	=	$vk;
				endforeach;
				$data['keluarga']	=	join(",",$keluarga);
			endif;

			$start		=	$this->conn->StartTrans();
			$this->model->InsertData($data);
			$complete	=	$this->conn->CompleteTrans();

			$this->_proses_message($complete,$this->module."listview/",$this->module."add/");

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

		if(empty($act)):
			$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL");
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
			$arrPasien				=	$this->model_pasien->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
			$arrJenisKegiatan		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
			$arrKeluarga			=	$this->model_keluarga->ListAll();

			$data["monitoring_rehab"]		=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
			$data["pasien_history"]			=$this->model_pasien_history_main->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
			$data["monitoring_pasca"]		=$this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
			$data["pasien_history_pasca"]	=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

			$data["pasien_assestment_history"]=$this->model_pasien_assesment_history->GetRecordData("idx_pasien='$id' and idx_assesment='$idx_assesment'");

			$data["rehab_stat"]				=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");
			$data["pasca_stat"]				=$this->model_pasien_history_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");

			$data['data']			=	$arrData;
			$data['datax']			=	$arrPasien;
			$data['jenis_kegiatan']	=	$arrJenisKegiatan;
			$data['keluarga']		=	$arrKeluarga;
			$data['id']				=	$id_enc;
			$data['idx_pasien']		=	$id;
			$data['act']			=	"view";

            $this->_render_page($this->module."v_execute",$data,true);

        endif;

        //debug();
		if($act=="update"):

			$data=get_post();
			$idx=$data["idx"];
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_dukungan_keluarga");
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
			// $data['idx']='';

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
				$stt_rawat_pasca="INAP";
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
				$data_update["status_proses"]="PRRLPUKP"; //entry unit
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["inst_pasca"]=$inst_pasca;
				$data_update["rujuk_pasca"]=$rujuk_pasca;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=$kdwil;
				$data_mtr['dk']=1;
				// $days=date('Y-m-d');
			else:
				$data_update["status_proses"]="PRRIDK"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=$kdwil;
				$data_mtr['dk']=0;
			endif;

			if($data['arr_keluarga']):
				foreach($data['arr_keluarga'] as $kk=>$vk):
					$keluarga[$kk]	=	$vk;
				endforeach;
				$data['keluarga']	=	join(",",$keluarga);
			endif;


			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_pasien->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_pasien->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_pasien->UpdateData($data, "idx=$idx");
			}
			$arrDtxHis=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtxHis){
				$dataz['status_data']=0;
				$this->model_pasien_history->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_pasien_history->InsertData($data);
			}
			// exit;
			if($data['status_program']=='DO' || $data['status_program']=='MD' || $data['status_program']=='KB' || $data['status_program']=='SL'):
				$data_update["status_proses"]="PRRIDK"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=$kdwil;
				$data_mtr['dk']=1;

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

			$data_update['tgl_kegiatan']=$data['tgl_kegiatan'];
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history_pasca($data,$data_update);

			$dataMonitoring['dk']=$data_mtr['dk'];
			$dataMonitoring['tgl_dk']=$data['tgl_kegiatan'];
			$dataMonitoring['tgl_dk_selesai']=$data['tgl_selesai'];
			$dataMonitoring['status_rawat_pasca']=$stt_rawat_pasca;
			update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);
			// exit;
			$complete	=	$this->conn->CompleteTrans();

			if($data['status_pasien']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'):
				redirect($this->module."view_detail/".$id_enc);
			else:
				$this->_proses_message($complete,$this->module."view/$id_enc",$this->module."view/$id_enc");
			endif;

        endif;

		if($act=="create"):

            //debug();

            $data						=	get_post();
			$config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
			$config['upload_path']		=	$this->config->item("dir_dukungan_keluarga");
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
			// $data['idx']='';

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
				$stt_rawat_pasca="INAP";
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
				$data_update["status_proses"]="PRRLPUKP"; //entry unit
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["inst_pasca"]=$inst_pasca;
				$data_update["rujuk_pasca"]=$rujuk_pasca;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=$kdwil;
				$data_mtr['dk']=1;
				// $days=date('Y-m-d');
			else:
				$data_update["status_proses"]="PRRIDK"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=$kdwil;
				$data_mtr['dk']=0;
			endif;

			if($data['arr_keluarga']):
				foreach($data['arr_keluarga'] as $kk=>$vk):
					$keluarga[$kk]	=	$vk;
				endforeach;
				$data['keluarga']	=	join(",",$keluarga);
			endif;
			$data			=	$this->_add_creator($data);

			// debug();
			unset($data['idx']);
			$arrDtx=$this->model_pasien->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtx){
				$dataz['status_data']=0;
				$this->model_pasien->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_pasien->InsertData($data);
			}else{
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_pasien->InsertData($data);
			}
			$arrDtxHis=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment=$data[idx_assesment]");
			if($arrDtxHis){
				$dataz['status_data']=0;
				$this->model_pasien_history->UpdateData($dataz, "idx_pasien=$id");
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_pasien_history->InsertData($data);
			}else{
				$data['status_data']=1;
				if($data['status_pasien']=='SL'){
					$data['status_data']=0;
				}
				$this->model_pasien_history->InsertData($data);
			}
			// exit;
			if($data['status_program']=='DO' || $data['status_program']=='MD' || $data['status_program']=='KB' || $data['status_program']=='SL'):
				$data_update["status_proses"]="PRRIDK"; //detok
				$data_update["status_rehab"]=3; //rehab
				$data_update["status_rawat"]="PASCA"; //inap
				$data_update["kd_wilayah_propinsi"]=$kdwil;
				$data_mtr['dk']=1;

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

			$data_update['tgl_kegiatan']=$data['tgl_kegiatan'];
			$data_update['status_pasien']=$data['status_pasien'];
			$data_update['tgl_selesai']=$data['tgl_selesai'];
			update_pasien_history_pasca($data,$data_update);

			$dataMonitoring['dk']=$data_mtr['dk'];
			$dataMonitoring['tgl_dk']=$data['tgl_kegiatan'];
			$dataMonitoring['tgl_dk_selesai']=$data['tgl_selesai'];
			$dataMonitoring['status_rawat_pasca']=$stt_rawat_pasca;
			update_pasien_monitoring_pasca($data,$data_update,$dataMonitoring);

            //exit;

            $complete	=	$this->conn->CompleteTrans();

			if($data['status_pasien']=='SL' || $data['status_program']=='MD' || $data['status_program']=='DO'):
				redirect($this->module."view_detail/".$id_enc);
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
			unlink($this->config->item('dir_dukungan_keluarga').$arrData['file']);
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

		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL");
		$data["data_asm"]=$arrDataAsm;
		$idx_assesment = $arrDataAsm['idx'];
		$arrData				=	$this->model->GetRecordData("idx=$id");
        $arrPasien				=	$this->model_pasien->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$arrJenisKegiatan		=	$this->model_jenis_kegiatan->ListAll($this->jenis_kegiatan_filter);
		$arrKeluarga			=	$this->model_keluarga->ListAll();

		$data["monitoring_rehab"]		=$this->model_monitoring_rehab->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history"]			=$this->model_pasien_history_main->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment' and status_rehab<='3'");
		$data["monitoring_pasca"]		=$this->model_monitoring_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment'");
		$data["pasien_history_pasca"]	=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and idx_assesment='$idx_assesment'");

		$data["rehab_stat"]				=$this->model_pasien_history->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");
		$data["pasca_stat"]				=$this->model_pasien_history_pasca->GetRecordData("idx_pasien=$id and idx_assesment='$idx_assesment' and status_pasien = 'SL' order by idx desc");

		$jenis_kegiatan	=	$this->model_jenis_kegiatan->GetRecordData("idx='".$arrPasien['idx_jenis_kegiatan']."' and ".$this->jenis_kegiatan_filter);

		$arrPasien['jenis_kegiatan']	=	$jenis_kegiatan['ur_jenis_kegiatan'];

		$explode=	explode(",",$arrPasien['keluarga']);

                if($arrPasien['keluarga']):
                    $list			=	"<ol style='padding-left:15px'>";
                    foreach($explode as $kk=>$vk):
                            $arr_kel	=	$this->model_keluarga->GetRecordData("idx='".$vk."'");
                            $list		.=	"<li>".$arr_kel['ur_keluarga']."</li>";
                    endforeach;
                    $list			.=	"</ol>";
                else:
                    $list   =   "";
                endif;

		$arrPasien['keluarga_terlibat']	=	$list;

		$data["data"]	=	$arrData;
		$data["datax"]	=	$arrPasien;
		$data['id']		=	$id_enc;

		$rh_pasien	=	rh_pasien($id);
		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];

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
}
