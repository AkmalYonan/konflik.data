<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class assesment extends Admin_Controller {
	var $arr_category=array();
    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
        $class_folder = basename(dirname(__DIR__)); //admin
		$class = __CLASS__; //dashboard
		$this->class=$class;
		$this->$class_folder=$class_folder;

		$this->load->library("Utils");
    	$this->folder=$class_folder."/"; //master_data/
        $this->module=$this->folder.$class."/";//master_data/uu_daerah/
        $this->http_ref=base_url().$this->module;///brwa/admin/dashboard/

        $this->load->model("general_model");
        $this->model=new general_model("t_pasien");
				$this->model_file=new general_model("t_pasien_file");
		// $this->model_currently=new general_model("t_pasien_curently");
		$this->model_pasien_assesment_history=new general_model("t_pasien_assesment_history");
		$this->model_assesment=new general_model("t_pasien_assesment");
		$this->model_assesment_summary=new general_model("t_pasien_assesment_summary");

		$this->model_assesment_keluarga=new general_model("t_pasien_assesment_keluarga");
		$this->model_assesment_narkotika=new general_model("t_pasien_assesment_narkotika");
		$this->model_assesment_legal=new general_model("t_pasien_assesment_legal");
		$this->model_assesment_fisik=new general_model("t_pasien_assesment_fisik");

		//file pendukung
		//$this->model_file=new general_model("t_pasien_registrasi_online_file");

		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="ASSESMENT";
		$this->module_title="Resume ";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";

		$this->init_lookup();
		$this->list_month	=	$this->utils->listMonth();

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
        //$sql=" select a.*,b.realname,b.path from ".$this->model->tbl." a
          //      left join ".$this->model->tbl."_file b on a.idx=b.id_parent
        //";

		$table=$this->model->tbl;
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

        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
		// $where[]="(status_rehab=1 and status_proses='RG' and status_check_doc=2) or
					// (status_rehab=1 and status_proses='SS' and status_check_doc<=1)";
		//$where[]="((status_rehab=1 and status_proses='RG' and status_check_doc=2) or
		//			(status_rehab=1 and status_proses='SS' and status_check_doc<=1))";
		// $where[]="((status_rehab=1 and status_proses='RG' and status_check_doc=2) or
					// (status_rehab=1 and status_proses='SS' and status_check_doc<=2))";
		$where[]="((status_rehab=1 and status_proses='SS' and status_check_doc<=2))";
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
		$this->_render_page($this->module."v_list",$data,true);
    }

	 function index_waiting_list(){
	 	$this->listview_waiting_list();
	 }

	 function listview_waiting_list(){

		$this->load->library('pagination');
        //$sql=" select a.*,b.realname,b.path from ".$this->model->tbl." a
          //      left join ".$this->model->tbl."_file b on a.idx=b.id_parent
        //";

		$table=$this->model->tbl;
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

		$where[]	=	"status_rehab='1'";

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

		$this->_render_page($this->module."v_waiting_list",$data,true);
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
            $this->_proses_message($ok,$this->module."listview/",$this->module."add/");
        endif;
    }


	function summary($id){
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;

		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";

		$act=$this->input->post("act")?$this->input->post("act"):"";


        if(empty($act)):
            $arrData=$this->model->GetRecordData("idx=$id");
			$arrFile = $this->model_file->SearchRecordWhere("id_parent=$id");
			$arrDataAssesment=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and outcome_pasien IS NULL ");

			$id_assesment=$arrDataAssesment["idx"];
			$data_doc = array();
			foreach($arrFile as $k=>$val){
				$data_doc[$val['id_jenis_doc']][] =$val;
			}
			$data["data_doc"]=$data_doc;
			// $arrDataAssesmentHis=$this->model_pasien_assesment_history->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");

			$arrDataAssesmentHis=$this->model_pasien_assesment_history->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");
			$data["data_asmHis"]=$arrDataAssesmentHis;
			$data["data"]=$arrData;
			$data["data_assesment"]=$arrDataAssesment;
			$this->_render_page($this->module."v_form_summary",$data,true);
        endif;
		// exit;

		if($act=="update"):

			//debug();

			$this->conn->StartTrans();
			$arrData=$this->model->GetRecordData("idx=$id");
			$arrDataAssesment=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_pasien=1 and outcome_pasien IS NULL ");
			$id_assesment=$arrDataAssesment["idx"];
			$data=get_post();
			$data["tgl_lahir"]	=	$data['thn']."-".$data['bln']."-".$data['tgl'];

			//pre($data);exit;

            $config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
            $config['upload_path']		=	$this->config->item("dir_assesment_summary");
            $config['max_size']			=	"5000000000";
            $config['overwrite']		=	TRUE;
            $new_name                   =   time()."_".$_FILES["file"]['name'];
            $config['file_name']        =   $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('file');
            $file						=	$this->upload->data();

            $ext						=	$file['file_ext'];

            if(($ext==".doc") || ($ext==".docx") || ($ext==".xls") || ($ext==".xlsx") || ($ext==".txt") || ($ext==".zip") || ($ext==".rar") || ($ext==".jpg") || ($ext==".jpeg") || ($ext==".pdf") || ($ext==".png")):
                $data["lampiran"]			=	$new_name;
            endif;

			//add
			if(!empty($data["kd_wilayah"])):
				$pieces = explode("-",$data["kd_wilayah"]);
				$kdw=$pieces[0].$pieces[1];
				// $data_update["kd_wilayah"]=$kdw;
				$kdwil=$kdw;
				$rujuk_rehab=$data["kd_wilayah"];
				$data_update["status_rawat_inap"]=$data["status_rawat_inap"];
				$data_update["status_rawat"]='JALAN';
				$data["rujuk_rehab"]=$rujuk_rehab;

			elseif(!empty($data["id_kabupaten"])):
				// $data_update["kd_wilayah"]=$data["id_kabupaten"];
				$kdwil=$data["id_kabupaten"];
				$rujuk_rehab=$data["id_kabupaten"];
				$data_update["status_rawat_inap"]=$data["status_rawat_inap"];
				$data_update["status_rawat"]=$data["status_rawat"];
				$data_update["status_rawat"]='INAP';
				$data["rujuk_rehab"]=$rujuk_rehab;
				$piece = explode("-",$data["id_kabupaten"]);
				$kdwil=$piece[0].$piece[1];
			elseif(!empty($data["id_km"])):
				// $data_update["kd_wilayah"]=$data["id_km"];
				$kdwil=$data["id_km"];
				$rujuk_rehab=$data["id_km"];
				$data_update["status_rawat_inap"]='RIRM';
				$data_update["status_rawat"]='INAP';
				$data["rujuk_rehab"]=$rujuk_rehab;
				$piece = explode("-",$data["id_km"]);
				$kdwil=$piece[0].$piece[1];
			elseif(!empty($data["id_rd"])):
				// $data_update["kd_wilayah"]=$data["id_rd"];
				$kdwil=$data["id_rd"];
				$rujuk_rehab=$data["id_rd"];
				$data_update["status_rawat_inap"]='RIRM';
				$data_update["status_rawat"]='INAP';
				$data["rujuk_rehab"]=$rujuk_rehab;
				$piece = explode("-",$data["id_rd"]);
				$kdwil=$piece[0].$piece[1];
			endif;
			// pre($kdwil);exit;
			//cek status_proses && update status
			$status_proses=$data["status_proses"];//SS/RIRMDT/RIRMEU/RIRSPP/RIRSRE/RJ
			$inst_rujuk=$data["inst_rujuk"];
			$cek_dok=$data["status_check_doc"];
			if($data["status_check_doc"]==2):
				/* comment by pete */
				/*
				if($status_proses=='BL' or $status_proses=='RD' or $status_proses=='KM'){
					$data["status_rehab"]=2;//1reg 2rehab 3pasca
					$data["status_proses"]="RIRMDT"; //inap detox
					$data_update["status_proses"]="RIRMDT"; //inap detox
				}elseif($status_proses=='BNNP' or $status_proses=='BNNK'){
					// $data_proses=$this->conn->GetRow("select * from m_proses_rehab where kd_status_proses='".$status_proses."'");
					$data["status_rehab"]=2;//1reg 2rehab 3pasca
					$data["status_proses"]="RJKL"; //jalan konseling
					$data_update["status_proses"]="RJKL"; //jalan konseling
				}

				if($status_proses!='SS'):
					$data["status_check_doc"]=0; //0belum 1proses 2ok/valid/selesai 99tolak
				endif;
				$data_update["inst_rujuk"]=$status_proses;
				$data_update["rujuk_rehab"]=$rujuk_rehab;
				$data_update["kd_wilayah"]=$kdwil;
				$data["inst_rujuk"]=$status_proses;
				*/
				/* adding by pete */
				$data["status_rehab"]=2;//1reg 2rehab 3pasca
				$data["status_program"]='PS';
				$data_update["status_program"]='PS';
				$data["status_proses"]=$status_proses;
				$data_update["status_proses"]=$status_proses;

				if($status_proses!='SS'):
					$data["status_check_doc"]=0; //0belum 1proses 2ok/valid/selesai 99tolak
				endif;

				$data_update["inst_rujuk"]=$inst_rujuk;
				$data_update["rujuk_rehab"]=$rujuk_rehab;
				$data_update["kd_wilayah"]=$kdwil;
				$data_update["kd_wilayah_propinsi"]=substr($kdwil, 0, 2);
				$data["inst_rujuk"]=$data["inst_rujuk"];
				/* end adding by pete */

                //My Addition
                $data_update["flag_notification"]=1;
				//End

			else:
				$data["status_proses"]="SS"; //assesment
				$data["status_rehab"]=1; //registrasi
				//$data["status_program"]='PS'; //registrasi
				$data_update["inst_rujuk"]=NULL;
				$data_update["rujuk_rehab"]=NULL;
				//$data_update["kd_wilayah"]=NULL;
			endif;
			// pre($data_update);exit;

			$status_rawat=substr($status_proses,0,2);
			$status_rawat_inap=substr($status_proses,0,4);

			$data["status_rawat_inap"]="";
			$data["status_rawat"]="";

			if($status_rawat=='RI'):
				$data_update["inst_rujuk"]=$inst_rujuk;
				$data["status_rawat"]='INAP';
				$data["status_rawat_inap"]=$status_rawat_inap;
			endif;
			if($status_rawat=='RJ'):
				$data_update["inst_rujuk"]=$inst_rujuk;
				$data["status_rawat"]='JALAN';
			endif;
			if($status_rawat=='PR'):
				$data_update["inst_rujuk"]=$inst_rujuk;
				$data["status_rawat"]='PASCA';
			endif;

			$data_update["jns_treat"]=$data["jns_treat"];
			$data_update["status_rehab"]=$data["status_rehab"];
			$data_update["status_check_doc"]=$data["status_check_doc"];

			$data_update['tgl_kegiatan']=$data['tgl_kedatangan'];

			//Tambahan Jika Data Pasien Pada Saat Di Resume Summary Diubah
			$data_update['nama']=$data['nama'];
			$data_update['alamat']=$data['alamat'];
			$data_update['tempat_lahir']=$data['tempat_lahir'];
			$data_update['tgl_lahir']=$data['tgl_lahir'];
			$data_update['umur']=$data['umur'];
			$data_update['active_pasien']=1;
			//End
			//debug();

			if(cek_array($arrDataAssesment)):
				$flag_assesment="update";
			else:
				$flag_assesment="insert";
			endif;
			if($flag_assesment=="update"):
				$data['status_rm']="PS";
				$data['status_program']="PS";
				$data=$this->_add_editor($data);
				$this->model_assesment_summary->UpdateData($data, "idx_pasien=$id and idx=".$arrDataAssesment["idx"]);

				$data_update['status_rm']="PS";
				$data_update['status_program']="PS";
				$data_update['inst_pasca']=NULL;
				$data_update['rujuk_pasca']=NULL;
				$data_update['inst_lanjut']=NULL;
				$data_update['rujuk_lanjut']=NULL;
				$data_update['outcome_pasien']=NULL;
				$this->model->UpdateData($data_update,"idx=$id");


				$arrUpdate=$this->model->GetRecordData("idx=$id");
				$arrUpdate['idx_assesment']=$arrDataAssesment["idx"];
				//$arrUpdate['inst_rujuk']=NULL;
				//$arrUpdate['rujuk_rehab']=NULL;
				$arrUpdate['inst_pasca']=NULL;
				$arrUpdate['rujuk_pasca']=NULL;
				$arrUpdate['inst_lanjut']=NULL;
				$arrUpdate['rujuk_lanjut']=NULL;
				$arrUpdate['outcome_pasien']=NULL;
				$arrUpdate['status_rehab']=$data["status_rehab"];
				$arrUpdate['status_proses']=$data["status_proses"];
				$arrUpdate['status_check_doc']=0;
				$arrUpdate['status_rawat']=$data["status_rawat"];

				$arrUpdate['status_rm']="PS";
				$arrUpdate['status_program']="PS";
				// debug();
				if($cek_dok==2):
					$arrCount=$this->conn->GetAll("Select count(idx_pasien) as jumlah from t_pasien_assesment_history where idx_pasien=$id");
					$data_update["tgl_selesai_assesment"]=$data["tgl_selesai_assesment"];
					if($arrCount[0]['jumlah']>1):
						$data_update['flag_pasien']=1;
						$this->model->UpdateData($data_update,"idx=$id");
						$this->model_assesment_summary->UpdateData($data_update,"idx_pasien=$id and idx=$arrUpdate[idx_assesment]");
						$this->model_pasien_assesment_history->UpdateData($data_update,"idx_pasien=$id and idx_assesment=$arrUpdate[idx_assesment]");

					endif;
				// exit;
					$arrUpdate["tgl_selesai_assesment"]=$data["tgl_selesai_assesment"];
					$arrUpdate['tgl_mulai_rehab']=$data['tgl_selesai_assesment'];
					$arrUpdate['idx_assesment']=$arrDataAssesment["idx"];
					$arrUpdate['idx_pasien']=$id;
					// pre($arrUpdate);exit;
					// $this->model_pasien_assesment_history->UpdateData($data,"idx_pasien=$id and idx_assesment=$arrUpdate[idx_assesment]");
					$dataMonitoring['tgl_mulai_rehab']=$data['tgl_selesai_assesment'];
					$dataMonitoring['tgl_assesment']=$data['tgl_selesai_assesment'];
					$dataMonitoring['status_assesment']=1;
					$dataMonitoring['tgl_registrasi']=$data['tgl_registrasi'];
					$dataMonitoring['status_registrasi']=1;
					// debug();

					update_pasien_monitoring($arrUpdate,$data_update,$dataMonitoring);


					update_status_program($id,$arrUpdate['idx_assesment'],"PS");

					/* add by pete */
					$pasien=pasien_data($id);
					$dataPasien["idx_pasien"]=$id;
					$dataPasien["idx_assesment"]=$arrUpdate['idx_assesment'];
					$dataPasien["no_rekam_medis"]=$pasien["no_rekam_medis"];
					$dataStatus=$data_update;
					$dataStatus["tgl_kegiatan"]=$data["tgl_selesai_assesment"];
					$dataStatus["status_rehab"]=$pasien["status_rehab"];
					$dataStatus["status_proses"]=$pasien["status_proses"];
					$dataStatus["status_rawat"]=$pasien["status_rawat"];
					$dataStatus["status_pasien"]=$pasien["status_pasien"];
					$dataStatus["inst_rujuk"]=$pasien["inst_rujuk"];
					$dataStatus["rujuk_rehab"]=$pasien["rujuk_rehab"];

					update_pasien_history($dataPasien,$dataStatus);

					// exit;
				endif;
				unset($arrUpdate["idx"]);
				$idx_assesment=$arrDataAssesment["idx"];

				$this->model_pasien_assesment_history->UpdateData($arrUpdate,"idx_pasien=$id and idx_assesment=".$idx_assesment);
				// exit;
			endif;

			if($flag_assesment=="insert"):

                $config['allowed_types']	=	"doc|docx|xls|xlsx|txt|zip|rar|jpg|jpeg|pdf|png";
                $config['upload_path']		=	$this->config->item("dir_assesment_summary");
                $config['max_size']			=	"5000000000";
                $config['overwrite']		=	TRUE;
                $new_name                   =   time()."_".$_FILES["file"]['name'];
                $config['file_name']        =   $new_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload('file');
                $file						=	$this->upload->data();

                $ext						=	$file['file_ext'];

                if(($ext==".doc") || ($ext==".docx") || ($ext==".xls") || ($ext==".xlsx") || ($ext==".txt") || ($ext==".zip") || ($ext==".rar") || ($ext==".jpg") || ($ext==".jpeg") || ($ext==".pdf") || ($ext==".png")):
                    $data["lampiran"]			=	$new_name;
                endif;

				$data['status_rm']="PS";
				$data['status_program']="PS";
				$data=$this->_add_creator($data);
				$this->model_assesment_summary->InsertData($data);

				$data_update['status_rm']="PS";
				$data_update['status_program']="PS";
				$data_update['inst_pasca']=NULL;
				$data_update['rujuk_pasca']=NULL;
				$data_update['inst_lanjut']=NULL;
				$data_update['rujuk_lanjut']=NULL;
				$data_update['outcome_pasien']=NULL;
				// debug();
				$this->model->UpdateData($data_update,"idx=$id");

				$idassesment=$this->model_assesment_summary->GetLastId("idx");
				$arrUpdate=$this->model->GetRecordData("idx=$id");

				$arrUpdate['idx']=NULL;
				$arrUpdate['idx_pasien']=$id;
				$arrUpdate['idx_assesment']=$idassesment;

				//$arrUpdate['inst_rujuk']=NULL;
				//$arrUpdate['rujuk_rehab']=NULL;
				$arrUpdate['inst_pasca']=NULL;
				$arrUpdate['rujuk_pasca']=NULL;
				$arrUpdate['inst_lanjut']=NULL;
				$arrUpdate['rujuk_lanjut']=NULL;
				$arrUpdate['outcome_pasien']=NULL;
				$arrUpdate['status_rehab']=$data["status_rehab"];
				$arrUpdate['status_proses']=$data["status_proses"];
				$arrUpdate['status_check_doc']=0;
				$arrUpdate['status_rawat']=$data["status_rawat"];

				$arrUpdate['status_rm']="PS";
				$arrUpdate['status_program']="PS";
				$this->model_pasien_assesment_history->InsertData($arrUpdate);

				if($cek_dok==2):
					// debug();
					$arrCount=$this->conn->GetAll("Select count(idx_pasien) as jumlah from t_pasien_assesment_history where idx_pasien=$id");

					if($arrCount[0]['jumlah']>1):
						$data_updates['flag_pasien']=1;
						$data_updates["tgl_selesai_assesment"]=$data["tgl_selesai_assesment"];

                        //My Addition
                        $data_updates["flag_notification"]=1;
                        //End

						$this->model->UpdateData($data_updates,"idx=$id");
						$this->model_assesment_summary->UpdateData($data_updates,"idx_pasien=$id and idx=$arrUpdate[idx_assesment]");
						$this->model_pasien_assesment_history->UpdateData($data_updates,"idx_pasien=$id and idx_assesment=$arrUpdate[idx_assesment]");

					endif;
					// exit;
					$data['tgl_mulai_rehab']=$data['tgl_selesai_assesment'];
					$data['idx_assesment']=$idassesment;
					$data['kd_wilayah']=$kdwil;
					$this->model_pasien_assesment_history->UpdateData($data,"idx_pasien=$id and idx_assesment=$arrUpdate[idx_assesment]");
					// exit;
					$dataMonitoring['tgl_mulai_rehab']=$data['tgl_selesai_assesment'];
					$dataMonitoring['tgl_assesment']=$data['tgl_selesai_assesment'];
					$dataMonitoring['status_assesment']=1;
					$dataMonitoring['tgl_registrasi']=$data['tgl_registrasi'];
					$dataMonitoring['status_registrasi']=1;
					update_pasien_monitoring($data,$data_update,$dataMonitoring);

					update_status_program($id,$arrUpdate['idx_assesment']);

					/* add by pete */
					$pasien=pasien_data($id);
					// pre($data_update);exit;
					$dataPasien["idx_pasien"]=$id;
					$dataPasien["idx_assesment"]=$arrUpdate['idx_assesment'];
					$dataPasien["no_rekam_medis"]=$pasien["no_rekam_medis"];
					$dataStatus=$data_update;
					$dataStatus["tgl_kegiatan"]=$data["tgl_selesai_assesment"];
					$dataStatus["status_rehab"]=$pasien["status_rehab"];
					$dataStatus["status_proses"]=$pasien["status_proses"];
					$dataStatus["status_rawat"]=$pasien["status_rawat"];
					$dataStatus["status_pasien"]=$pasien["status_pasien"];
					$dataStatus["inst_rujuk"]=$pasien["inst_rujuk"];
					$dataStatus["rujuk_rehab"]=$pasien["rujuk_rehab"];

					update_pasien_history($dataPasien,$dataStatus);
					 // pre($data_update);exit;
				endif;
			endif;

            //exit;

			$ok=$this->conn->CompleteTrans();
		//exit;
			// pre()
			if($cek_dok==2):
				// redirect($this->module."view/".$id_enc);
				$this->_proses_message($ok,$this->module."view/$id_enc",$this->module."view/$id_enc");
			else:
				$this->_proses_message($ok,$this->module."summary/$id_enc",$this->module."summary/$id_enc");
			endif;

		endif;

	}


	function form($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";

	    $arrData=$this->model->GetRecordData("idx=$id");
		$arrDataAssesment=$this->model_assesment->GetRecordData("idx_pasien=$id");
		$id_assesment=$arrDataAssesment["idx"];
		$arrDataAssesmentKeluarga=$this->model_assesment_keluarga->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");

		$arrDataAssesmentNarkotika=$this->model_assesment_narkotika->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");

		$arrDataAssesmentLegal=$this->model_assesment_legal->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");

		$arrDataAssesmentFisik=$this->model_assesment_fisik->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");

	   	if(cek_array($arrDataAssesmentKeluarga)):
			$flag_keluarga="update";
		else:
			$flag_keluarga="insert";
		endif;

		if(cek_array($arrDataAssesmentNarkotika)):
			$flag_narkotika="update";
		else:
			$flag_narkotika="insert";
		endif;

		if(cek_array($arrDataAssesmentLegal)):
			$flag_legal="update";
		else:
			$flag_legal="insert";
		endif;

		if(cek_array($arrDataAssesmentFisik)):
			$flag_fisik="update";
		else:
			$flag_fisik="insert";
		endif;

        $act=$this->input->post("act")?$this->input->post("act"):"";
        if(empty($act)):
            $data["data"]=$arrData;
			$data["data_assesment"]=$arrDataAssesment;
			$data["data_assesment_keluarga"]=$arrDataAssesmentKeluarga;
			$data["data_assesment_narkotika"]=$arrDataAssesmentNarkotika;
			$data["data_assesment_legal"]=$arrDataAssesmentLegal;
			$data["data_assesment_fisik"]=$arrDataAssesmentFisik;
			$this->_render_page($this->module."v_form_index",$data,true);
        endif;

		if($act=="update"):
			$arrDataAssesment=$this->model_assesment->GetRecordData("idx_pasien=$id");
            if(cek_array($arrDataAssesment)):
				$flag="update";
			else:
				$flag="insert";
			endif;
			//debug();
			$this->conn->StartTrans();

			if($flag=="update"):
				//debug();
				$data=get_post();
				$data["active"]=$data["active"]?1:0;
				$data["riwayat_penyakit_kronis"]=$data["riwayat_penyakit_kronis"]?1:0;
				//pre($data);
				//$data=$this->_add_editor($data);
				//$this->conn->StartTrans();
				$this->model_assesment->UpdateData($data, "idx_pasien=$id and idx=".$arrDataAssesment["idx"]);
				//$ok=$this->conn->CompleteTrans();
				//$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
        	endif;

			if($flag=="insert"):
				//debug();
				$data=get_post();
				$data["riwayat_penyakit_kronis"]=$data["riwayat_penyakit_kronis"]?1:0;
				//pre($data);
				//$data=$this->_add_editor($data);
				//$this->conn->StartTrans();
				$this->model_assesment->InsertData($data);
				//$ok=$this->conn->CompleteTrans();
				//$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
        	endif;


			if($flag_keluarga=="update"):
				//debug();
				$data=get_post();
				$data["active"]=$data["active"]?1:0;
				$data["idx_pasien"]=$id;
				$data["idx_assesment"]=$arrDataAssesment["idx"];
				$data["pasangan"]=$data["pasangan"]?1:0;
				$data["anak"]=$data["anak"]?1:0;
				$data["pasangan_anak"]=$data["pasangan_anak"]?1:0;
				$data["keluarga"]=$data["keluarga"]?1:0;
				$data["teman"]=$data["teman"]?1:0;
				$data["orang_tua"]=$data["orang_tua"]?1:0;
				$data["sendiri"]=$data["orang_tua"]?1:0;
				$data["lingkungan_terkontrol"]=$data["lingkungan_terkontrol"]?1:0;
				$data["kondisi_tidak_stabil"]=$data["kondisi_tidak_stabil"]?1:0;

				$data["residen_saudara"]=$data["residen_saudara"]?1:0;
				$data["residen_ayah_ibu"]=$data["residen_ayah_ibu"]?1:0;
				$data["residen_om_tante"]=$data["residen_om_tante"]?1:0;
				$data["residen_pasangan"]=$data["residen_pasangan"]?1:0;
				$data["residen_teman"]=$data["residen_teman"]?1:0;
				$data["residen_lain"]=$data["residen_lain"]?1:0;

				$data["ibu_30"]=$data["ibu_30"]?1:0;
				$data["ibu_sh"]=$data["ibu_sh"]?1:0;
				$data["ayah_30"]=$data["ayah_30"]?1:0;
				$data["ayah_sh"]=$data["ayah_sh"]?1:0;
				$data["adik_kakak_30"]=$data["adik_kakak_30"]?1:0;
				$data["adik_kakak_sh"]=$data["adik_kakak_sh"]?1:0;
				$data["pasangan_30"]=$data["pasangan_30"]?1:0;
				$data["pasangan_sh"]=$data["pasangan_sh"]?1:0;
				$data["anak_anak_30"]=$data["anak_anak_30"]?1:0;
				$data["anak_anak_sh"]=$data["anak_anak_sh"]?1:0;
				$data["keluarga_lain_30"]=$data["keluarga_lain_30"]?1:0;
				$data["keluarga_lain_sh"]=$data["keluarga_lain_sh"]?1:0;
				$data["teman_akrab_30"]=$data["teman_akrab_30"]?1:0;
				$data["teman_akrab_sh"]=$data["teman_akrab_sh"]?1:0;
				$data["tetangga_30"]=$data["tetangga_30"]?1:0;
				$data["tetangga_sh"]=$data["tetangga_sh"]?1:0;
				$data["teman_kerja_30"]=$data["teman_kerja_30"]?1:0;
				$data["teman_kerja_sh"]=$data["teman_kerja_sh"]?1:0;

				$data["depresi_30"]=$data["depresi_30"]?1:0;
				$data["depresi_sh"]=$data["depresi_sh"]?1:0;
				$data["cemas_30"]=$data["cemas_30"]?1:0;
				$data["cemas_sh"]=$data["cemas_sh"]?1:0;
				$data["halusinasi_30"]=$data["halusinasi_30"]?1:0;
				$data["halusinasi_sh"]=$data["halusinasi_sh"]?1:0;
				$data["kontrol_perilaku_30"]=$data["kontrol_perilaku_30"]?1:0;
				$data["kontrol_perilaku_sh"]=$data["kontrol_perilaku_sh"]?1:0;
				$data["pikiran_bunuh_diri_30"]=$data["pikiran_bunuh_diri_30"]?1:0;
				$data["pikiran_bunuh_diri_sh"]=$data["pikiran_bunuh_diri_sh"]?1:0;
				$data["usaha_bunuh_diri_30"]=$data["usaha_bunuh_diri_30"]?1:0;
				$data["usaha_bunuh_diri_sh"]=$data["usaha_bunuh_diri_sh"]?1:0;
				$data["psikiater_30"]=$data["psikiater_30"]?1:0;
				$data["psikiater_sh"]=$data["psikiater_sh"]?1:0;
				$data["kesulitan_mengingat_30"]=$data["kesulitan_mengingat_30"]?1:0;
				$data["kesulitan_mengingat_sh"]=$data["kesulitan_mengingat_sh"]?1:0;


				//pre($data);
				//$data=$this->_add_editor($data);
				//$this->conn->StartTrans();
				$this->model_assesment_keluarga->UpdateData($data, "idx_pasien=$id and idx_assesment=".$arrDataAssesment["idx"]);
				//$ok=$this->conn->CompleteTrans();
				//$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
        	endif;

			if($flag_keluarga=="insert"):
				//debug();
				$data=get_post();
				$data["active"]=$data["active"]?1:0;
				$data["idx_pasien"]=$id;
				$data["idx_assesment"]=$arrDataAssesment["idx"];
				$data["pasangan"]=$data["pasangan"]?1:0;
				$data["anak"]=$data["anak"]?1:0;
				$data["pasangan_anak"]=$data["pasangan_anak"]?1:0;
				$data["keluarga"]=$data["keluarga"]?1:0;
				$data["teman"]=$data["teman"]?1:0;
				$data["orang_tua"]=$data["orang_tua"]?1:0;
				$data["sendiri"]=$data["orang_tua"]?1:0;
				$data["lingkungan_terkontrol"]=$data["lingkungan_terkontrol"]?1:0;
				$data["kondisi_tidak_stabil"]=$data["kondisi_tidak_stabil"]?1:0;

				$data["residen_saudara"]=$data["residen_saudara"]?1:0;
				$data["residen_ayah_ibu"]=$data["residen_ayah_ibu"]?1:0;
				$data["residen_om_tante"]=$data["residen_om_tante"]?1:0;
				$data["residen_pasangan"]=$data["residen_pasangan"]?1:0;
				$data["residen_teman"]=$data["residen_teman"]?1:0;
				$data["residen_lain"]=$data["residen_lain"]?1:0;

				$data["ibu_30"]=$data["ibu_30"]?1:0;
				$data["ibu_sh"]=$data["ibu_sh"]?1:0;
				$data["ayah_30"]=$data["ayah_30"]?1:0;
				$data["ayah_sh"]=$data["ayah_sh"]?1:0;
				$data["adik_kakak_30"]=$data["adik_kakak_30"]?1:0;
				$data["adik_kakak_sh"]=$data["adik_kakak_sh"]?1:0;
				$data["pasangan_30"]=$data["pasangan_30"]?1:0;
				$data["pasangan_sh"]=$data["pasangan_sh"]?1:0;
				$data["anak_anak_30"]=$data["anak_anak_30"]?1:0;
				$data["anak_anak_sh"]=$data["anak_anak_sh"]?1:0;
				$data["keluarga_lain_30"]=$data["keluarga_lain_30"]?1:0;
				$data["keluarga_lain_sh"]=$data["keluarga_lain_sh"]?1:0;
				$data["teman_akrab_30"]=$data["teman_akrab_30"]?1:0;
				$data["teman_akrab_sh"]=$data["teman_akrab_sh"]?1:0;
				$data["tetangga_30"]=$data["tetangga_30"]?1:0;
				$data["tetangga_sh"]=$data["tetangga_sh"]?1:0;
				$data["teman_kerja_30"]=$data["teman_kerja_30"]?1:0;
				$data["teman_kerja_sh"]=$data["teman_kerja_sh"]?1:0;


				//pre($data);
				//$data=$this->_add_editor($data);

				$this->model_assesment_keluarga->InsertData($data);

        	endif;



			if($flag_narkotika=="update"):
				//debug();
				$data=get_post();
				$data["idx_pasien"]=$id;
				$data["idx_assesment"]=$arrDataAssesment["idx"];
				$data["alkohol_30"]=$data["alkohol_30"]?1:0;
				$data["alkohol_sh"]=$data["alkohol_30"]?1:0;
				$data["heroin_30"]=$data["heroin_30"]?1:0;
				$data["heroin_sh"]=$data["heroin_sh"]?1:0;
				$data["metadon_30"]=$data["metadon_30"]?1:0;
				$data["metadon_sh"]=$data["metadon_sh"]?1:0;
				$data["opiat_30"]=$data["opiat_30"]?1:0;
				$data["opiat_sh"]=$data["opiat_sh"]?1:0;
				$data["metadon_30"]=$data["metadon_30"]?1:0;
				$data["metadon_sh"]=$data["metadon_sh"]?1:0;
				$data["opiat_30"]=$data["opiat_30"]?1:0;
				$data["opiat_sh"]=$data["opiat_sh"]?1:0;
				$data["metadon_30"]=$data["metadon_30"]?1:0;
				$data["metadon_sh"]=$data["metadon_sh"]?1:0;
				$data["opiat_30"]=$data["opiat_30"]?1:0;
				$data["opiat_sh"]=$data["opiat_sh"]?1:0;
				$data["barbiturat_30"]=$data["barbiturat_30"]?1:0;
				$data["barbiturat_sh"]=$data["barbiturat_sh"]?1:0;
				$data["sediatif_30"]=$data["sediatif_30"]?1:0;
				$data["sediatif_sh"]=$data["sediatif_sh"]?1:0;
				$data["kokain_30"]=$data["kokain_30"]?1:0;
				$data["kokain_sh"]=$data["kokain_sh"]?1:0;
				$data["ampetamin_30"]=$data["ampetamin_30"]?1:0;
				$data["ampetamin_sh"]=$data["ampetamin_sh"]?1:0;
				$data["kanabis_30"]=$data["kanabis_30"]?1:0;
				$data["kanabis_sh"]=$data["kanabis_sh"]?1:0;
				$data["halusinogen_30"]=$data["halusinogen_30"]?1:0;
				$data["halusinogen_sh"]=$data["halusinogen_sh"]?1:0;
				$data["inhalan_30"]=$data["inhalan_30"]?1:0;
				$data["inhalan_sh"]=$data["inhalan_sh"]?1:0;
				$data["lebih_30"]=$data["lebih_30"]?1:0;
				$data["lebih_sh"]=$data["lebih_sh"]?1:0;

				$this->model_assesment_narkotika->UpdateData($data, "idx_pasien=$id and idx_assesment=".$arrDataAssesment["idx"]);

			endif;

			if($flag_narkotika=="insert"):

				//debug();
				$data=get_post();
				$data["idx_pasien"]=$id;
				$data["idx_assesment"]=$arrDataAssesment["idx"];
				$data["alkohol_30"]=$data["alkohol_30"]?1:0;
				$data["alkohol_sh"]=$data["alkohol_30"]?1:0;
				$data["heroin_30"]=$data["heroin_30"]?1:0;
				$data["heroin_sh"]=$data["heroin_sh"]?1:0;
				$data["metadon_30"]=$data["metadon_30"]?1:0;
				$data["metadon_sh"]=$data["metadon_sh"]?1:0;
				$data["opiat_30"]=$data["opiat_30"]?1:0;
				$data["opiat_sh"]=$data["opiat_sh"]?1:0;
				$data["metadon_30"]=$data["metadon_30"]?1:0;
				$data["metadon_sh"]=$data["metadon_sh"]?1:0;
				$data["opiat_30"]=$data["opiat_30"]?1:0;
				$data["opiat_sh"]=$data["opiat_sh"]?1:0;
				$data["metadon_30"]=$data["metadon_30"]?1:0;
				$data["metadon_sh"]=$data["metadon_sh"]?1:0;
				$data["opiat_30"]=$data["opiat_30"]?1:0;
				$data["opiat_sh"]=$data["opiat_sh"]?1:0;
				$data["barbiturat_30"]=$data["barbiturat_30"]?1:0;
				$data["barbiturat_sh"]=$data["barbiturat_sh"]?1:0;
				$data["sediatif_30"]=$data["sediatif_30"]?1:0;
				$data["sediatif_sh"]=$data["sediatif_sh"]?1:0;
				$data["kokain_30"]=$data["kokain_30"]?1:0;
				$data["kokain_sh"]=$data["kokain_sh"]?1:0;
				$data["ampetamin_30"]=$data["ampetamin_30"]?1:0;
				$data["ampetamin_sh"]=$data["ampetamin_sh"]?1:0;
				$data["kanabis_30"]=$data["kanabis_30"]?1:0;
				$data["kanabis_sh"]=$data["kanabis_sh"]?1:0;
				$data["halusinogen_30"]=$data["halusinogen_30"]?1:0;
				$data["halusinogen_sh"]=$data["halusinogen_sh"]?1:0;
				$data["inhalan_30"]=$data["inhalan_30"]?1:0;
				$data["inhalan_sh"]=$data["inhalan_sh"]?1:0;
				$data["lebih_30"]=$data["lebih_30"]?1:0;
				$data["lebih_sh"]=$data["lebih_sh"]?1:0;

				$this->model_assesment_narkotika->InsertData($data);
			endif;



			if($flag_legal=="update"):
				//debug();
				$data=get_post();
				$data["idx_pasien"]=$id;
				$data["idx_assesment"]=$arrDataAssesment["idx"];
				$data["mencuri"]=$data["mencuri"]?1:0;
				$data["bebas_bersyarat"]=$data["bebas_bersyarat"]?1:0;
				$data["narkoba"]=$data["narkoba"]?1:0;
				$data["pemalsuan"]=$data["pemalsuan"]?1:0;
				$data["penyerangan_bersenjata"]=$data["penyerangan_bersenjata"]?1:0;
				$data["pencurian"]=$data["pencurian"]?1:0;
				$data["perampokan"]=$data["perampokan"]?1:0;
				$data["penyerangan"]=$data["penyerangan"]?1:0;
				$data["pembakaran"]=$data["pembakaran"]?1:0;
				$data["perkosaan"]=$data["perkosaan"]?1:0;
				$data["pembunuhan"]=$data["pembunuhan"]?1:0;
				$data["pelacuran"]=$data["pelacuran"]?1:0;
				$data["pelecehan_pengadilan"]=$data["pelecehan_pengadilan"]?1:0;
				$data["lain_lain"]=$data["lain_lain"]?1:0;
				$data["vonis"]=$data["vonis"]?1:0;


				$this->model_assesment_legal->UpdateData($data, "idx_pasien=$id and idx_assesment=".$arrDataAssesment["idx"]);

			endif;

			if($flag_legal=="insert"):
				//debug();
				$data=get_post();
				$data["idx_pasien"]=$id;
				$data["idx_assesment"]=$arrDataAssesment["idx"];
				$data["mencuri"]=$data["mencuri"]?1:0;
				$data["bebas_bersyarat"]=$data["bebas_bersyarat"]?1:0;
				$data["narkoba"]=$data["narkoba"]?1:0;
				$data["pemalsuan"]=$data["pemalsuan"]?1:0;
				$data["penyerangan_bersenjata"]=$data["penyerangan_bersenjata"]?1:0;
				$data["pencurian"]=$data["pencurian"]?1:0;
				$data["perampokan"]=$data["perampokan"]?1:0;
				$data["penyerangan"]=$data["penyerangan"]?1:0;
				$data["pembakaran"]=$data["pembakaran"]?1:0;
				$data["perkosaan"]=$data["perkosaan"]?1:0;
				$data["pembunuhan"]=$data["pembunuhan"]?1:0;
				$data["pelacuran"]=$data["pelacuran"]?1:0;
				$data["pelecehan_pengadilan"]=$data["pelecehan_pengadilan"]?1:0;
				$data["lain_lain"]=$data["lain_lain"]?1:0;
				$data["vonis"]=$data["vonis"]?1:0;

				$this->model_assesment_legal->InsertData($data);
			endif;


			if($flag_fisik=="update"):
				//debug();
				$data=get_post();
				$data["idx_pasien"]=$id;
				$data["idx_assesment"]=$arrDataAssesment["idx"];
				$data["benzodiazepin_u"]=$data["benzodiazepin_u"]?1:0;
				$data["kanabis_u"]=$data["kanabis_u"]?1:0;
				$data["opiat_u"]=$data["opiat_u"]?1:0;
				$data["ampetamin_u"]=$data["ampetamin_u"]?1:0;
				$data["kokain_u"]=$data["kokain_u"]?1:0;
				$data["barbiturat_u"]=$data["barbiturat_u"]?1:0;
				$data["alkohol_u"]=$data["alkohol_u"]?1:0;

				$this->model_assesment_fisik->UpdateData($data, "idx_pasien=$id and idx_assesment=".$arrDataAssesment["idx"]);
			endif;

			if($flag_fisik=="insert"):
				$data=get_post();
				$data["idx_pasien"]=$id;
				$data["idx_assesment"]=$arrDataAssesment["idx"];
				$data["benzodiazepin_u"]=$data["benzodiazepin_u"]?1:0;
				$data["kanabis_u"]=$data["kanabis_u"]?1:0;
				$data["opiat_u"]=$data["opiat_u"]?1:0;
				$data["ampetamin_u"]=$data["ampetamin_u"]?1:0;
				$data["kokain_u"]=$data["kokain_u"]?1:0;
				$data["barbiturat_u"]=$data["barbiturat_u"]?1:0;
				$data["alkohol_u"]=$data["alkohol_u"]?1:0;

				$this->model_assesment_fisik->InsertData($data);
			endif;


			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
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

		$arrDataAssesment=$this->model_assesment_summary->GetRecordData("idx_pasien=$id and active_Pasien=1 and outcome_pasien IS NULL ");
		$id_assesment=$arrDataAssesmentSummary["idx"];

		$data["data"]=$arrData;
		$data["summary"]=$arrDataAssesment;

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



	function print_html(){
		$req=get_post();

		$tbl=rawurldecode($_POST["tbl"]);
		$data["template"]=$_POST["tbl"];
		$data["tbl"]=$tbl;

		$data["data"]=$data;
		//pre(get_post());
		$data["print_url"]="print_html";
		$datam["content"]=$this->load->view("common/print_preview/direct_print_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}

	function pdf_setting(){
		$post=rawurldecode($_POST["tbl"]);
		$print_url=rawurldecode($_POST["print_url"]);

		$file_name=$this->input->post("filename",true);

		$postData["tbl"]=$post;
		$postData["filename"]=$file_name;
		$postData["print_url"]=$print_url;
		$id_mst=$this->input->post("id_mst",true);
        $id_mst=$id_mst?decrypt($id_mst):"";
        $postData["id_mst"]=$id_mst;
        $data["data"]=$postData;
		$datam["content"]=$this->load->view("common/print_preview/pdf_setting_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}


	function pdf(){
		$post=rawurldecode($_POST["tbl"]);
		$print_url=rawurldecode($_POST["print_url"]);
		$file_name=$this->input->post("filename",true);
		$postData["tbl"]=$post;
		$postData["filename"]=$file_name;
		$postData["print_url"]=$print_url;
		$id_mst=$this->input->post("id_mst",true);
        $id_mst=$id_mst?decrypt($id_mst):"";
        $postData["id_mst"]=$id_mst;
        $data["data"]=$postData;
		$datam["content"]=$this->load->view("common/print_preview/pdf_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}

	function print_pdf_setting(){
		$post=rawurldecode($_POST["tbl"]);
		$print_url=rawurldecode($_POST["print_url"]);

		$file_name=$this->input->post("filename",true);

		$postData["tbl"]=$post;
		$postData["filename"]=$file_name;
		$postData["print_url"]=$print_url;
		$id_mst=$this->input->post("id_mst",true);
        $id_mst=$id_mst?decrypt($id_mst):"";
        $postData["id_mst"]=$id_mst;
        $data["data"]=$postData;
		$datam["content"]=$this->load->view("common/print_preview/direct_pdf_setting_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}


	function print_pdf(){
		$post=rawurldecode($_POST["tbl"]);
		$print_url=rawurldecode($_POST["print_url"]);
		$file_name=$this->input->post("filename",true);
		$postData["tbl"]=$post;
		$postData["filename"]=$file_name;
		$postData["print_url"]=$print_url;
		$id_mst=$this->input->post("id_mst",true);
        $id_mst=$id_mst?decrypt($id_mst):"";
        $postData["id_mst"]=$id_mst;
        $data["data"]=$postData;
		$datam["content"]=$this->load->view("common/print_preview/direct_pdf_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}


	 function lookup_instansi_rujuk($status_proses){
	 	$data["status_proses"]=$status_proses;
		$this->load->view($this->module."v_lookup_instansi_rujuk",$data);
	 }






}
