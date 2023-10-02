<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class wilayah extends Public_Controller {
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
		$this->model_propinsi=new general_model("m_propinsi2");
        $this->model_kabupaten=new general_model("m_kabupaten_kota");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Master Data";
		$this->module_title="";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
	 }
	 
	 function get_kab_kota($kd_bps_propinsi="",$arr_id=""){
		$sql="select * from ".$this->model_kabupaten->tbl." where kode_prop=$kd_bps_propinsi and kode_kab!='00' order by kode_bps";
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
	
	function get_kab_kota2($kd_bps_propinsi="",$arr_id=""){
		$sql="select * from ".$this->model_kabupaten->tbl." where kode_prop=$kd_bps_propinsi and kode_kab!='00' order by kode_bps";
		$arrKabKota=$this->conn->GetAll($sql);
		$arrData=array();
		if(cek_array($arrKabKota)):
			foreach($arrKabKota as $x=>$val):
				$arrData[$val["kode_bps"]]=$val["nama"];
			endforeach;
		endif;
		$data["dataKabupaten"]=$arrData;
		$data["arr_id"]=$arr_id;
		echo $this->load->view($this->module."lookup_kabupaten2",$data,true);
	}
	
	function get_wilayah_kab_kota($kd_bps_propinsi="",$arr_id=""){
		$sql="select * from ".$this->model_kabupaten->tbl." where kode_prop=$kd_bps_propinsi and kode_kab!='00' order by kode_bps";
		$arrKabKota=$this->conn->GetAll($sql);
		$arrData=array();
		if(cek_array($arrKabKota)):
			foreach($arrKabKota as $x=>$val):
				$arrData[$val["kode_bps"]]=$val["nama"];
			endforeach;
		endif;
		$data["dataKabupaten"]=$arrData;
		$data["arr_id"]=$arr_id;
		echo $this->load->view($this->module."lookup_wilayah_kabupaten",$data,true);
	}
	 
	
	 
	 
	 

}