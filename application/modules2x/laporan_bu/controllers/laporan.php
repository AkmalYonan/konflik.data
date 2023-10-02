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
        
        $this->load->model("general_model");
        $this->model=new general_model("m_instansi");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Laporan";
		$this->module_title="Klinik";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
	 }
	 
	 function index(){
	 	//$this->listview();
		$this->pasien_baru_per_klinik();
	 }
	 
	 function pasien_baru_per_klinik(){
		 $this->module_title="Pasien Baru";
			$arrData=$this->conn->GetAll("select * from t_pasien");
			$data["arrData"]=$arrData;
			$this->_render_page($this->module."v_laporan_pasien_baru_per_klinik",$data,true);
	  }
	  
	  function pasien_lama_per_klinik(){
		  
		  	$tahun 		=	($_GET['tahun'])?$_GET['tahun']:false;
			$bulan		=	($_GET['bulan'])?$_GET['bulan']:false;
			$tingkat	=	($_GET['tingkat'])?$_GET['tingkat']:false;
		
			$where =" where 1=1";
			if($tahun) :
			$where  .= " AND YEAR(tgl_registrasi) = '".$tahun."'";
			endif;
			if($bulan) :
			$where  .= " AND MONTH(tgl_registrasi) = '".$bulan."'";
			endif;
			
			$this->module_title="Pasien Lama";
			$arrData=$this->conn->GetAll("select * from t_pasien ".$where);
			$data["arrData"]=$arrData;
			$data["tahun"]=$tahun;
			$data["bulan"]=$bulan;
			$data["tingkat"]=$tingkat;
			$this->_render_page($this->module."v_laporan_pasien_lama_per_klinik",$data,true);
	  }
	  
	  
	  function rekap_bulanan(){
		 	$this->module_title="Rekap Bulanan";
			$arrData=$this->conn->GetAll("select * from t_pasien");
			$data["arrData"]=$arrData;
			$this->_render_page($this->module."v_rekap_laporan_bulanan",$data,true);
	  }
	  
	  function rekap_tahunan(){
		 	$this->module_title="Rekap Tahunan";
			$arrData=$this->conn->GetAll("select * from t_pasien");
			$data["arrData"]=$arrData;
			$this->_render_page($this->module."v_rekap_laporan_tahunan",$data,true);
	  }
	  function rekap_pasien_berdasarkan_hukum(){
		 	$this->module_title="Rekap Pasien Berdasarkan Hukum";
			$arrData=$this->conn->GetAll("select * from t_pasien");
			$data["arrData"]=$arrData;
			$this->_render_page($this->module."v_rekap_pasien_berdasarkan_hukum",$data,true);
	  }
	  
	 
}