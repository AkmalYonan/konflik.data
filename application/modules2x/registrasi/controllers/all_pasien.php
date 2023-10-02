<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class all_pasien extends Admin_Controller {
	var $arr_category=array();
    function __construct(){
        parent::__construct();

		$this->base_url=GetServerURL().base_url();

        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
		$this->load->library("Utils");
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
		$this->model_pasien_list=new general_model("t_pasien_list");
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

		$this->model_pasien_list2=$this->load->model("registrasi/pasien_list_model");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="DATA PASIEN";
		$this->module_title="Pasien Terdaftar";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";
		//$this->load->library("dbautochecker");
		$this->init_lookup();
	 }

	 function init_lookup(){
		$this->model_lookup=new general_model("m_lookup");
		$lookup_arr=$this->model_lookup->SearchRecordWhere("active=1","order by lookup_category,order_num");
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

	 function index_pasien_list(){
	 	$this->listview_pasien_list();
	 }

	 function listview(){

		$this->load->library('pagination');
        //$sql=" select a.*,b.realname,b.path from ".$this->model->tbl." a
          //      left join ".$this->model->tbl."_file b on a.idx=b.id_parent
        //";

		// debug();
		$table=$this->model->tbl;
        //$table="($sql) a";
		$queryString=rebuild_query_string();
		$data_type=$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        //debug();
        $col_text=$data["text"];
		$field=join(",",$col_text);
        $whereSql=get_where_from_searchbox($field);
		//pre($this->user_data);
		if($this->user_prop):
			if($this->user_instansi):
				/*if($this->user_instansi=="BL"):
					$where[]	=	"jns_org='2'";
				elseif($this->user_instansi=="KM"):
					$where[]	=	"jns_org='4'";
				elseif($this->user_instansi=="RD"):
					$where[]	=	"jns_org='5'";
				endif;*/
				//$where[]	=	"(inst_rehab='".$this->user_instansi."' or inst_pasca='".$this->user_instansi."' or inst_lanjut='".$this->user_instansi."' or kd_bnn='".$this->user_instansi."')";
			else:
				//$where[]	=	"(inst_rehab<>'".$this->user_instansi."' and inst_pasca='".$this->user_instansi."' or inst_lanjut='".$this->user_instansi."' or kd_bnn='".$this->user_instansi."')";
			endif;
			//$where[]	=	"substr(kd_bnn,1,5)='".$this->user_prop."-".$this->user_kab."'";

			/*
			if($this->user_instansi!="BNNP" && $this->user_instansi!="BNNK"):
				$where[]="(rujuk_rehab='".$this->user_org."' or rujuk_pasca='".$this->user_org."' or rujuk_lanjut='".$this->user_org."' or kd_bnn='".$this->user_org."')";
			endif;
			*/
			/*
			if($this->user_instansi=="BNNP"):
				$where[]="substr(kd_wilayah,1,4) like '".$this->user_prop."%' and ((inst_rujuk<>'BL' and inst_rujuk<>'BB') or (inst_pasca<>'BL' and inst_pasca<>'BB') or (inst_lanjut<>'BL' and inst_lanjut<>'BB') or (inst_rujuk is null and inst_pasca is null and inst_lanjut is null))";
			endif;
			if($this->user_instansi=="BNNK"):
				$where[]="substr(kd_wilayah,1,4) like '".$this->user_prop.$this->user_kab."%' and ((inst_rujuk<>'BL' and inst_rujuk<>'BB') or (inst_pasca<>'BL' and inst_pasca<>'BB') or (inst_lanjut<>'BL' and inst_lanjut<>'BB') or (inst_rujuk is null and inst_pasca is null and inst_lanjut is null))";
			endif;
			*/

		endif;
		/*
		if($this->user_prop):
			if($this->user_instansi):
				//$where[]	=	"(inst_pasca='".$this->user_instansi."')";
				$where[]	="kd_bnn='".$this->user_org."'"." or "."rujuk_rehab='".$this->user_org."'"." or ".	"rujuk_pasca='".$this->user_org."'";
			endif;
		endif;
		*/


		if($this->user_instansi):
				$where[]="(rujuk_rehab='".$this->user_org."' or rujuk_pasca='".$this->user_org."' or rujuk_lanjut='".$this->user_org."'  or kd_bnn='".$this->user_org."')";
		endif;

		$req=get_post();
		// pre($req);exit;
		$active=$req["active"]!=""?$req["active"]:false;
		$status_rehab=$req["status_rehab"]!=""?$req["status_rehab"]:false;
		//debug();
		if($active!==false):
			$where[]="active_pasien=".$active;
		endif;
		if($status_rehab!==false):
			$where[]="status_rehab=".$status_rehab;
		endif;

		//$where[]	=	"status_rehab='1'";

        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;

        $whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
		// pre($this->input->get_post("pp"));exit;
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;

		$uriSegment=4;

        $totalRows=$this->model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by status_rehab";

		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		// debug(false);
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

	 function listview_pasien_list(){


		$this->load->library('pagination');
        //$sql=" select a.*,b.realname,b.path from ".$this->model->tbl." a
          //      left join ".$this->model->tbl."_file b on a.idx=b.id_parent
        //";

		$table=$this->model_pasien_list->tbl;
        //$table="($sql) a";
		$queryString=rebuild_query_string();
		$data_type=$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;

        $col_text=$data["text"];
		$field=join(",",$col_text);
        $whereSql=get_where_from_searchbox($field);

		if(!$this->user_instansi):
			if($this->user_prop):
				$where[]	=	"kd_wilayah_propinsi='".$this->user_prop."'";
			endif;

			if(($this->user_kab) && ($this->user_kab!=='00')):
				$where[]	=	"substr(kd_wilayah,3)='".$this->user_kab."'";
			endif;
		else:
			if($this->user_instansi=="BL"):
				$where[]	=	"jns_org='2'";
			endif;
		endif;

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

        $totalRows=$this->model_pasien_list->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";



        //$arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
		$arrData=$this->model_pasien_list->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);

		$config['base_url'] = $this->module."listview_pasien_list";
        $config['per_page'] = $perPage;
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		$this->parent_module_title="Pilih";
		$this->module_title="Pasien";
        $data["arrData"]=$arrData;

		$this->_render_page($this->module."v_list_pasien",$data,true);
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
			$data=$this->_add_creator($data);
			$this->conn->StartTrans();
			$this->model->InsertData($data);
			$id_last=$this->model->GetLastID("idx");
			if($data["status_rehab"]):
				$this->update_status($id_last,$data,"RG"); //current status registrasi
			endif;

			$ok=$this->conn->CompleteTrans();
			//pre($ok);exit;
            $this->_proses_message($ok,$this->module."listview/",$this->module."add/");
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
			$data["action"]="edit";
			$this->_render_page($this->module."v_execute",$data,true);
        endif;

		if($act=="update"):
			$data=get_post();

			$data["active"]=$data["active"]?1:0;
			$data=$this->_add_editor($data);

			$this->conn->StartTrans();

			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
			//update status
			if($data["status_proses"]):
				$this->update_status($id,$data,"RG"); //current status registrasi
			endif;

            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
        endif;
    }

    function execute($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;

		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";

        $act=$this->input->post("act")?$this->input->post("act"):"";
        if(empty($act)):
            $arrData=$this->model_pasien_list->GetRecordData("idx=$id");
            $data["data"]=$arrData;
			$data["action"]="execute";
			$this->_render_page($this->module."v_execute",$data,true);
        endif;

		if($act=="add"):
			$data=get_post();

			$cek_nik	=	$this->model_pasien_list2->CekNik($data['nik']);

			if($cek_nik):

				$ok	=	0;

				$this->msg_fail="Pasien Sudah Ada, Tidak Dapat Menambahkan Data";

				$this->_proses_message($ok,$this->module."listview_pasien_list/",$this->module."execute/$id_enc");

			else:

				//$data=get_post();
				$data['active_pasien']=1;
				$data=$this->_add_creator($data);
				$this->conn->StartTrans();
				$this->model->InsertData($data);

				$id_last=$this->model->GetLastID("idx");
				if($data["status_rehab"]):
					$this->update_status($id_last,$data,"SS"); //current status registrasi
				endif;
				$ok=$this->conn->CompleteTrans();
				$this->_proses_message($ok,$this->module."listview/",$this->module."execute/$id_enc");

			endif;

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
		$this->module_title="Detil Pasien";
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData=$this->model->GetRecordData("idx=$id");
		//$arrDataFile=$this->model_file->SearchRecordWhere("id_parent=$id");
		$arrDataAsm=$this->model_assesment_summary->GetRecordData("idx_pasien=$id");
		$idx_pasien = $arrData['idx'];
		$arrFile = $this->model_file->SearchRecordWhere("id_parent=$idx_pasien");

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

		$rh_pasien	=	rh_pasien($id);

		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];

		$data_doc = array();
		foreach($arrFile as $k=>$val){
			$data_doc[$val['id_jenis_doc']][] =$val;
		}

		$data["data_doc"]=$data_doc;
		//$data["data_file"]=$arrDataFile;
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


	function update_status($id,$data,$current_status_rehab){
			$status_proses=$data["status_proses"];
			debug();
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

			$this->model->UpdateData($data_update,"idx=$id");

	}


	function upload_foto(){
		$this->msg_ok="File upload successfully";
        $this->msg_fail="Unable to upload_file";
		$path_pasien_img=$this->config->item("path_pasien_img");

		check_folder($path_pasien_img);
		check_folder($path_pasien_img."ori");
		check_folder($path_pasien_img."resize");
		check_folder($path_pasien_img."thumb");

		$config['upload_path'] = $path_pasien_img."ori";

		$config['allowed_types'] = 'gif|jpg|png';

		//$config['allowed_types'] = '*';
		//$config['max_size'] = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$filename="foto_".date("Ymd-His")."-".rand(383,1000).rand(0,1000);
		$config["file_name"]=$filename;


		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload("webcam") )
		{
			//print_r($this->upload->display_errors('', ''));
			//print_r($this->upload->data());
			$response["status"]=false;
			$response["error"]=strip_tags($this->upload->display_errors());
			$response["message"]=$this->msg_fail;
			$response["data"]=false;
			print_r(json_encode($response));
			//$this->response($response, 404);
		}else{

			$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
			$data = $this->upload->data();
			$filename=$data["file_name"];
			//$data["relative_path"]=str_replace(str_replace("\\","/",FCPATH),"",$data["full_path"]);
			$data["relative_path"]=$path_pasien_img."ori/".$filename;
			if($data["is_image"]==TRUE):
                $this->createThumbnail($data);
				$this->createThumbnail($data,"resize",$this->config->item("pic_resize_width"),$this->config->item("pic_resize_height"));
				$data["file_path_view"]=$path_pasien_img."resize/".$filename;
				$data["file_path_thumb"]=$path_pasien_img."thumb/".$filename;
				copy($data["file_path_view"],$path_pasien_img.$filename);
			endif;
			$data["file_temp"]=$tmpName;

			$id=$this->save_uploaded_file($data);

			$data_req=get_post();
			$data_foto["path"]=$path_pasien_img;
			$data_foto["file_name"]=$filename;
			$data_foto["idx_parent"]=$data_req["idx"];
			$data_foto["idx_file"]=$id;

			$this->model_foto->InsertData($data_foto);
			$id_last=$this->model_foto->GetLastID("idx");
			$data_foto["idx"]=$id_last;

			$data_update["flag_default"]=0;
			$this->model_foto->UpdateData($data_update,"idx_parent=".$data_req["idx"]."");

			$data_update["flag_default"]=1;
			$this->model_foto->UpdateData($data_update,"idx=".$id_last);

			$response["data"]=$data+$data_foto;
			print_r(json_encode($response));
        	//$this->response($response, 200);
		}

		//move_uploaded_file($_FILES['webcam']['tmp_name'], 'uploads/original/'.md5(time()).rand(383,1000).'.jpg');
	 }


	 function save_uploaded_file($data){
		$data["upload_time"]=time();

		$stamp = date("Ymdhis");
		$ip = get_client_ip(); //from conf php
		$id_file = basename($data["file_temp"],".tmp")."-"."$stamp-".inet_aton($ip);
		$data["id_file_str"]=$id_file;

		//$this->conn->debug=true;
		$this->conn->StartTrans();
		$data["ip_client"]=get_ip_address();
		$this->conn->AutoExecute("t_pasien_foto_file_upload",$data,"INSERT");
		$ID=$this->conn->GetOne("select max(idx) from t_pasien_foto_file_upload");
		$ok=$this->conn->CompleteTrans();
		//$ID=FALSE;
		//if($ok):
		//endif;
		if($ok):
			return $ID;
		else:
			return FALSE;
		endif;
	}


	function createThumbnail($data,$subpath="thumb",$width=50,$height=50,$subpath_ori="ori"){
		// clear config array
		$config = array();
		// create resized image
		$config['image_library'] = 'GD2';
		$config['source_image'] = $data['full_path'];
		$config['new_image'] =str_replace("/".$subpath_ori."/","/".$subpath."/",$data["full_path"]);
		$config['create_thumb'] = false;
		$config['maintain_ratio'] = true;
		$config['width'] = $width;
		$config['height'] =$height;
		if(!isset($this->image_lib)):
			$this->load->library('image_lib', $config);
		else:
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
		endif;
		$this->image_lib->resize();
	}


	function del_foto($idx){
		$this->conn->StartTrans();
		//data foto
		$data_foto=$this->model_foto->GetRecordData("idx=$idx");
		if(cek_array($data_foto)):
			$file=$this->model_foto_upload->GetRecordData("idx=".$data_foto["idx_file"]);
			$this->model_foto->DeleteData("idx=$idx");
			//data foto file upload
			$this->model_foto_upload->DeleteData("idx=".$data_foto["idx_file"]);
			$ok=$this->conn->CompleteTrans();
			if($ok):
				if(is_file('./' . $data_foto["path"].$data_foto["file_name"]))
				unlink('./' . $data_foto["path"].$data_foto["file_name"]);

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
		else:
			print "ok";
		endif;


	}

	function get_foto_default($id){
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		$data_all=$this->model_foto->SearchRecordWhere("idx_parent=$id","order by idx desc");
		$data=$this->model_foto->GetRecordData("idx_parent=$id and flag_default=1");
		if(cek_array($data)):
			print json_encode($data,true);
		else:
			if(cek_array($data_all)):
				$data_update["flag_default"]=1;
				$idx=$data_all[0]["idx"];
				$ok=$this->model_foto->UpdateData($data_update,"idx=$idx");
				$data=$data_all[0];
				print json_encode($data,true);
			endif;
		endif;
	}

	function activate_foto($idx){
			//debug();
			$data_foto=$this->model_foto->GetRecordData("idx=$idx");
			$idx_parent=$data_foto["idx_parent"];

			$data_update["flag_default"]=0;

			$this->conn->StartTrans();

			$this->model_foto->UpdateData($data_update,"idx_parent=".$idx_parent."");
			$data_update["flag_default"]=1;
			$this->model_foto->UpdateData($data_update,"idx=".$idx);
			//$data_foto=$this->model_foto->GetRecordData("idx=$idx");
			$ok=$this->conn->CompleteTrans();
			if($ok):
				print "ok";
			else:
				print "failed";
			endif;
	}


	function get_identify($id_pasien){
		/*
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif*;*/

		//debug();

		$data=$this->model_finger_identification->GetRecordData("idx_pasien=$id_pasien and flag_status_identification=1");
		if(cek_array($data)):
			print json_encode($data,true);
		else:
			print false;
		endif;
	}




	function get_fmd($id_pasien,$id_jari){
		//print $id_pasien;
		//print $id_jari;
		/*
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif*;*/
		/*debug();
		$tbl=$this->model_finger_foto->tbl;
		$mycount$this->conn->GetOne("select count(*) from $tbl where idx_pasien=$id_pasien and id_jari=$id_jari");
		if(mycount>4):
		$arrData=$this->model_finger_foto->SearchRecordWhere("idx_pasien=$id_pasien and id_jari=$id_jari","order by idx_pasien desc limit 4");
		pre($arrData);*/
		$data=$this->model_finger_foto->GetRecordData("idx_pasien=$id_pasien and id_jari=$id_jari and flag_default=1 order by created desc");
		if(cek_array($data)):
			print json_encode($data,true);
		else:
			print false;
		endif;
	}


	//rh pasien
	function rh($id){
		$this->module_title="Detil Pasien";
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData=$this->model->GetRecordData("idx=$id");
		//debug();
		$data_assesment=$this->model_assesment_summary->SearchRecordWhere("idx_pasien=$id");
		if(cek_array($data_assesment)):
			foreach($data_assesment as $x=>$val):
				$arr_idx_assesment[]=$idx;
				$arrData["data_assesment"][$val["idx"]]=$val;
			endforeach;
		endif;

		$arr_pasien_history=$this->model_pasien_history->SearchRecordWhere("idx_pasien=$id and status_pasien = 'SL' order by idx desc");
		$arr_pasien_history_pasca=$this->model_pasien_history_pasca->SearchRecordWhere("idx_pasien=$id and status_pasien = 'SL' order by idx desc");
		$arr_pasien_history_lanjut=$this->model_pasien_history_lanjut->SearchRecordWhere("idx_pasien=$id and status_pasien = 'SL' order by idx desc");

		$data_monitoring_rehab =$this->model_monitoring_rehab->SearchRecordWhere("idx_pasien=".$id);
		if(cek_array($data_monitoring_rehab)):
			foreach($data_monitoring_rehab as $x=>$val):
				$arrData["data_monitoring_rehab"][$val["idx_assesment"]]=$val;
			endforeach;
		endif;

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

		$rh_pasien	=	rh_pasien($id);
		$data["history_rh"]=$rh_pasien['history_rh'];
		$data["total_rh"]=$rh_pasien['total_rh'];

		//$data["data_file"]=$arrDataFile;
       	$this->_render_page($this->module."v_pasien_rh",$data,true);

     }




}
