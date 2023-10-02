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
		
		$this->load->helper(array('form', 'url','file'));
    	$this->folder=$class_folder."/"; //master_data/
        $this->module=$this->folder.$class."/";//master_data/uu_daerah/
        $this->http_ref=base_url().$this->module;///brwa/admin/dashboard/
        
        $this->load->model("general_model");
        $this->model=new general_model("t_pasien");
		$this->model_assesment=new general_model("t_pasien_assesment");
		$this->model_assesment_keluarga=new general_model("t_pasien_assesment_keluarga");
		$this->model_assesment_narkotika=new general_model("t_pasien_assesment_narkotika");
		$this->model_assesment_legal=new general_model("t_pasien_assesment_legal");
		$this->model_assesment_fisik=new general_model("t_pasien_assesment_fisik");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Data";
		$this->module_title="Assesment";
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
            $this->_proses_message($ok,$this->module."listview/",$this->module."add/");
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
		$arrDataAssesment=$this->model_assesment->GetRecordData("idx_pasien=$id");
		$id_assesment=$arrDataAssesment["idx"];
		
		$arrDataAssesmentKeluarga=$this->model_assesment_keluarga->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");
		$arrDataAssesmentNarkotika=$this->model_assesment_narkotika->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");
		$arrDataAssesmentLegal=$this->model_assesment_legal->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");
		$arrDataAssesmentFisik=$this->model_assesment_fisik->GetRecordData("idx_pasien=$id and idx_assesment=$id_assesment");
		
		
		//$arrDataFile=$this->model_file->SearchRecordWhere("id_parent=$id");
		
        $data["data"]=$arrData;
		$data["data_assesment"]=$arrDataAssesment;
		$data["data_assesment_fisik"]=$arrDataAssesmentFisik;
		$data["data_assesment_legal"]=$arrDataAssesmentLegal;
		$data["data_assesment_narkotika"]=$arrDataAssesmentNarkotika;
		$data["data_assesment_keluarga"]=$arrDataAssesmentKeluarga;
		
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
	 
	
	 
	 
	 

}