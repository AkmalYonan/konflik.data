<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class laporan extends Admin_Controller {
	var $arr_category=array();   
    function __construct(){
        parent::__construct();       
		$this->base_url=GetServerURL().base_url();
		
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
		
		$this->load->library("Utils");
        
        $this->load->model("general_model");
        $this->model=new general_model("m_instansi");
		$this->pasien_model=new general_model("t_pasien");
		
		$this->laporan_model	=	$this->load->model("laporan_model");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Laporan";
		$this->module_title="Klinik";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		$this->init_lookup();
		
		$this->load->helper("bnn_statistik");
		
	 }
	 
	 function index(){
	 	//$this->listview();
		$this->pasien_baru_per_klinik();
	 }
	 
	 function pasien_baru_per_klinik(){
			$req=get_post();
			
			$tahun=$req["tahun"]?$req["tahun"]:false;
			$bulan=$req["bulan"]?$req["bulan"]:false;
			$tipe_instansi=$req["tipe_instansi"]?$req["tipe_instansi"]:false;
			$kd_org=$req["kd_org"]?$req["kd_org"]:false;
			
			$userdata=$this->user_data;
			$tipe_instansi=$userdata["tipe_instansi"]?$userdata["tipe_instansi"]:"";
			$kd_org=$userdata["kd_org"]?$userdata["kd_org"]:"";
			if($kd_org==""):
				$kd_org=$req["kd_org"]?$req["kd_org"]:"";
			endif;
			if($tipe_instansi==""):
				$tipe_instansi=$req["tipe_instansi"]?$req["tipe_instansi"]:"";
			endif;
			
			
			/*
			$tahun				=	($_GET['tahun'])?$_GET['tahun']:date("Y");
			$bulan				=	($_GET['bulan'])?$_GET['bulan']:false;
			$tingkat			=	($_GET['tingkat'])?$_GET['tingkat']:false;
			$organisasi			=	($_GET['organisasi'])?$_GET['organisasi']:false;
			*/
			$where[]="(active_pasien='1' and flag_pasien='0')";
			if($tahun):
				$where[]="year(tgl_registrasi)=".$tahun;
			endif;
			if($bulan):
				$where[]="month(tgl_registrasi)=".$bulan;
			endif;
			if($tipe_instansi):
				if($tipe_instansi=="BNNP"):
					$where[]="jns_org=1";
				elseif($tipe_instansi=="BL"):
					$where[]="jns_org=2";
				elseif($tipe_instansi=="BNNK"):
					$where[]="jns_org=3";
				endif;
			endif;
			if($kd_org):
				$where[]=" kd_bnn='".$kd_org."'";
			endif;
			
			$whereSql="";
			if(cek_array($where)):
				$whereSql=join("  and ",$where);
			endif;
			//pre($whereSql);
			/*
			$filter				=	"active_pasien='1' and flag_pasien='0'";
			$and				=	" and ";
			
			if($tahun):
				$filter			.=	$and." year(tgl_registrasi)='".$tahun."'";
				$and			=	" and ";
			endif;
			
			if($bulan):
				$filter			.=	$and." month(tgl_registrasi)<='".$bulan."'";
				$and			=	" and ";
			endif;
			
			if($tingkat):
				if($tingkat=="BNNP"):
					$filter		.=	$and." jns_org='1'";
				elseif($tingkat=="BL"):
					$filter		.=	$and." jns_org='2'";
				elseif($tingkat=="BNNK"):
					$filter		.=	$and." jns_org='3'";	
				endif;
				$and			=	" and ";
			endif;
			
			if($organisasi):
				$filter			.=	$and." kd_bnn='".$organisasi."'";
				$and			=	" and ";
			endif;
			*/
			
			$filter=$whereSql;
			
			$this->module_title	=	"Pasien Baru";
			
			$arrData			=	$this->laporan_model->GetDataPasienBaru($filter);
			
			if($tipe_instansi or $kd_org):
				if(($tipe_instansi=="BNNP")&&($kd_org=="")):
					$data['nama_instansi']		=	"BNN PUSAT";
					$data['alamat_instansi']	=	"GEDUNG BNN, Jl. M.T. Haryono No. 11 Cawang, Jakarta Timur";
				else:
				//debug();
					$title_report	=	$this->laporan_model->GetTitleReport($tipe_instansi,$kd_org);
					$data['nama_instansi']		=	$title_report['nama_instansi'];
					$data['alamat_instansi']	=	$title_report['alamat'];
				endif;
			endif;
			
			$listMonth			=	$this->utils->listMonth(1);
			$data["arrData"]	=	$arrData;
			$data["listMonth"]	=	$listMonth;
			$this->_render_page($this->module."v_laporan_pasien_baru_per_klinik",$data,true);
	  }
	  
	  function pasien_lama_per_klinik(){
		 	$req=get_post();
			
			$tahun=$req["tahun"]?$req["tahun"]:false;
			$bulan=$req["bulan"]?$req["bulan"]:false;
			$tipe_instansi=$req["tipe_instansi"]?$req["tipe_instansi"]:false;
			$kd_org=$req["kd_org"]?$req["kd_org"]:false;
			
			$userdata=$this->user_data;
			$tipe_instansi=$userdata["tipe_instansi"]?$userdata["tipe_instansi"]:"";
			$kd_org=$userdata["kd_org"]?$userdata["kd_org"]:"";
			if($kd_org==""):
				$kd_org=$req["kd_org"]?$req["kd_org"]:"";
			endif;
			if($tipe_instansi==""):
				$tipe_instansi=$req["tipe_instansi"]?$req["tipe_instansi"]:"";
			endif;
			
			$where[]="(active_pasien=1 and flag_pasien=1)";
			if($tahun):
				$where[]="year(tgl_registrasi)=".$tahun;
			endif;
			if($bulan):
				$where[]="month(tgl_registrasi)=".$bulan;
			endif;
			if($tipe_instansi):
				if($tipe_instansi=="BNNP"):
					$where[]="jns_org=1";
				elseif($tipe_instansi=="BL"):
					$where[]="jns_org=2";
				elseif($tipe_instansi=="BNNK"):
					$where[]="jns_org=3";
				endif;
			endif;
			if($kd_org):
				$where[]=" kd_bnn='".$kd_org."'";
			endif;
			
			$whereSql="";
			if(cek_array($where)):
				$whereSql=join("  and ",$where);
			endif;
			
			$filter=$whereSql;
			
			$this->module_title	=	"Pasien Lama";
			
			$arrData			=	$this->laporan_model->GetDataPasienLama($filter);
			
			if($tipe_instansi or $kd_org):
				if(($tipe_instansi=="BNNP")&&($kd_org=="")):
					$data['nama_instansi']		=	"BNN PUSAT";
					$data['alamat_instansi']	=	"GEDUNG BNN, Jl. M.T. Haryono No. 11 Cawang, Jakarta Timur";
				else:
					//debug();
					$title_report	=	$this->laporan_model->GetTitleReport($tipe_instansi,$kd_org);
					//pre($title_report);
					$data['nama_instansi']		=	$title_report['nama_instansi'];
					$data['alamat_instansi']	=	$title_report['alamat'];
				endif;
			endif;	
			
			$data["arrData"]=$arrData;
			//$data["tahun"]=$tahun;
			//$data["bulan"]=$bulan;
			//$data["tingkat"]=$tingkat;
			$this->_render_page($this->module."v_laporan_pasien_lama_per_klinik",$data,true);
	  }
	  
	   /*
	   function pasien_lama_per_klinik(){
		 	$tahun				=	($_GET['tahun'])?$_GET['tahun']:date("Y");
			$bulan				=	($_GET['bulan'])?$_GET['bulan']:false;
			$tingkat			=	($_GET['tingkat'])?$_GET['tingkat']:false;
			$organisasi			=	($_GET['organisasi'])?$_GET['organisasi']:false;
			
			$filter				=	"active_pasien='1' and flag_pasien='1'";
			$and				=	" and ";
			
			if($tahun):
				$filter			.=	$and." year(tgl_registrasi)='".$tahun."'";
				$and			=	" and ";
			endif;
			
			if($bulan):
				$filter			.=	$and." month(tgl_registrasi)='".$bulan."'";
				$and			=	" and ";
			endif;
			
			if($tingkat):
				if($tingkat=="BNNP"):
					$filter		.=	$and." jns_org='1'";
				elseif($tingkat=="BL"):
					$filter		.=	$and." jns_org='2'";
				elseif($tingkat=="BNNK"):
					$filter		.=	$and." jns_org='3'";	
				endif;
				$and			=	" and ";
			endif;
			
			$this->module_title	=	"Pasien Lama";
			
			$arrData			=	$this->laporan_model->GetDataPasienLama($filter);
			
			if($tingkat or $organisasi):
				if($tingkat=="BNN"):
					$data['nama_instansi']		=	"BNN PUSAT";
					$data['alamat_instansi']	=	"GEDUNG BNN, Jl. M.T. Haryono No. 11 Cawang, Jakarta Timur";
				else:
					$title_report	=	$this->laporan_model->GetTitleReport($tingkat,$organisasi);
					$data['nama_instansi']		=	$title_report['nama_instansi'];
					$data['alamat_instansi']	=	$title_report['alamat'];
				endif;
			endif;	
			
			$data["arrData"]=$arrData;
			$data["tahun"]=$tahun;
			$data["bulan"]=$bulan;
			$data["tingkat"]=$tingkat;
			$this->_render_page($this->module."v_laporan_pasien_lama_per_klinik",$data,true);
	  }
	  */
	  
	  
	  function zzz_rekap_bulanan(){
		 	$this->module_title="Rekap Bulanan";
			
			$tbl="(
				select * from t_pasien_assesment_summary
				
			) a";
			$arrData=$this->adodbx->search_record_where($tbl);
			$data["arrData"]=$arrData;
			$this->_render_page($this->module."v_rekap_laporan_bulanan",$data,true);
	  }
	  
	  function rekap_bulanan($tahun=false,$bulan=12,$bulan_mulai=1){
	      $req=get_post();
		 
		  $tahun=$tahun?$tahun:false;
		  $bulan=$bulan?$bulan:$bulan;
		  if(!$tahun):
		  	$tahun=$req["tahun"]?$req["tahun"]:date("Y");
		  endif;
		  
		  $bulan=$req["bulan"]?$req["bulan"]:date("m");
		  
		  
		  $bulan_mulai=$bulan_mulai?$bulan_mulai:1;
		  $bulan_mulai=$req["bulan_mulai"]?$req["bulan_mulai"]:1;
		  
		  $arrData=get_rekap_status_proses_per_bulan($tahun,$bulan,$bulan_mulai);
		  
		  $data["arrData"]=$arrData;
		  $this->_render_page($this->module."v_rekap_layanan_per_bulan",$data,true);
	  }
	  
	  
	  function rekap_tahunan($tahun=false,$tahun_mulai=false){
	      $req=get_post();
		 
		  $tahun=$tahun?$tahun:false;
		  $tahun_mulai=$tahun_mulai?$tahun_mulai:false;
		  
		  if(!$tahun):
		  	$tahun=$req["tahun"]?$req["tahun"]:date("Y");
		  endif;
		  if(!$tahun_mulai):
		  	$tahun_mulai=$req["tahun_mulai"]?$req["tahun_mulai"]:false;
		  endif;
		  
		  $arrData=get_rekap_status_proses_per_tahun($tahun,$tahun_mulai);
		  
		  $data["arrData"]=$arrData;
		  $this->_render_page($this->module."v_rekap_layanan_per_tahun",$data,true);
	  }
	  
	  function monitoring_pasien($tahun=false,$tahun_mulai=false){
	  	   $req=get_post();
		 
		  $tahun=$tahun?$tahun:false;
		  $tahun_mulai=$tahun_mulai?$tahun_mulai:false;
		  
		  if(!$tahun):
		  	$tahun=$req["tahun"]?$req["tahun"]:date("Y");
		  endif;
		  if(!$tahun_mulai):
		  	$tahun_mulai=$req["tahun_mulai"]?$req["tahun_mulai"]:false;
		  endif;
		  $this->module_title="Monitoring Pasien";
	      $arrData=get_monitoring_pasien($tahun,$tahun_mulai);		
	  	  $data["arrData"]=$arrData;
		  $this->_render_page($this->module."v_monitoring_pasien",$data,true);
	  }
	  
	  
	  
	  function zzz_rekap_tahunan(){
		 	$this->module_title="Rekap Tahunan";
			$arrData=$this->conn->GetAll("select * from t_pasien");
			$data["arrData"]=$arrData;
			$this->_render_page($this->module."v_rekap_laporan_tahunan",$data,true);
	  }
	  
	  function rekap_status_rawat(){
	  
			$tahun					=	($_GET['tahun'])?$_GET['tahun']:date("Y");
			$bulan					=	($_GET['bulan'])?$_GET['bulan']:false;
			$tingkat				=	($_GET['tingkat'])?$_GET['tingkat']:false;
			
			$filter					=	"active_pasien='1'";
			$and					=	" and ";
			
			if($tahun):
				$filter				.=	$and." year(a.tgl_registrasi)='".$tahun."'";
				$and				=	" and ";
			endif;
			
			if($bulan):
				$filter				.=	$and." month(a.tgl_registrasi)='".$bulan."'";
				$and				=	" and ";
			endif;
			
			if($tingkat):
				$filter				.=	$and." substring(a.kd_bnn,7)='".$tingkat."'";
				$and				=	" and ";
			endif;
				  
		 	$this->module_title		=	"Rekap Status Rawat";
			
			$listMonth				=	$this->utils->listMonth(1);
			
			$arrData				=	$this->laporan_model->GetRekapPropinsiStatusRawat($filter,$listMonth);
			
			for($i=1; $i<13; $i++):
				$total[$i]	=	0;
				foreach($arrData as $k=>$v):
					$total[$i]	=	$total[$i]+$arrData[$k]['inap_'.$i]+$arrData[$k]['jalan_'.$i]+$arrData[$k]['pasca_'.$i];
				endforeach;
				$jumlah	=	$jumlah+$total[$i];
			endfor;			
			
			$data["arrData"]		=	$arrData;
			$data["total"]			=	$total;
			$data["jumlah"]			=	$jumlah;
			$data['listMonth']		=	$listMonth;
			$this->_render_page($this->module."v_rekap_laporan_status_rawat",$data,true);
	 }	
	 
	  function rekap_sumber_pasien(){
	  
			$tahun					=	($_GET['tahun'])?$_GET['tahun']:date("Y");
			$bulan					=	($_GET['bulan'])?$_GET['bulan']:false;
			$tingkat				=	($_GET['tingkat'])?$_GET['tingkat']:false;
			
			$filter					=	"active_pasien='1'";
			$and					=	" and ";
			
			if($tahun):
				$filter				.=	$and." year(a.tgl_registrasi)='".$tahun."'";
				$and				=	" and ";
			endif;
			
			if($bulan):
				$filter				.=	$and." month(a.tgl_registrasi)='".$bulan."'";
				$and				=	" and ";
			endif;
			
			if($tingkat):
				$filter				.=	$and." substring(a.kd_bnn,7)='".$tingkat."'";
				$and				=	" and ";
			endif;
				  
		 	$this->module_title		=	"Rekap Sumber Pasien";
			
			$listMonth				=	$this->utils->listMonth(1);
			
			$arrData				=	$this->laporan_model->GetRekapPropinsiSumberPasien($filter,$listMonth);
			
			for($i=1; $i<13; $i++):
				$total[$i]	=	0;
				foreach($arrData as $k=>$v):
					$total[$i]	=	$total[$i]+$arrData[$k]['sukarela_'.$i]+$arrData[$k]['hukum_'.$i]+$arrData[$k]['wbp_'.$i];
				endforeach;
				$jumlah	=	$jumlah+$total[$i];
			endfor;
			
			$data["arrData"]		=	$arrData;
			$data["total"]			=	$total;
			$data["jumlah"]			=	$jumlah;
			$data['listMonth']		=	$listMonth;
			
			$this->_render_page($this->module."v_rekap_laporan_sumber_pasien",$data,true);
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
	 
}