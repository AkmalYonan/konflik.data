<?php defined('BASEPATH') OR exit('No direct script access allowed');

class brwa extends Public_Controller {

    function __construct()
    {
        parent::__construct();

        $class_folder=basename(dirname(__DIR__));
        $class=__CLASS__;

        $this->class=$class;
        $this->$class_folder=$class_folder;

        $this->folder=$class_folder."/";
        $this->module=$this->folder.$class."/";
        $this->http_ref=base_url().$this->module;

        $this->load->helper(array('form', 'url','file','lookup'));
		$this->load->library(array("parser","Utils"));

        $this->main_layout="main_layout";
        $this->admin_layout="layout/main_layout";
		
		$this->load->model("data_detail/jkpp_model");
		
        $this->load->model("general_model");

        $this->model    	=   new general_model("t_daftar_jkpp");
		$this->model_involved=new general_model("t_involved");
		$this->model_file	=	new	general_model("t_file_jkpp");		
		$this->model_sektor	=	new	general_model("m_sektor");
		
        $this->active   =   "Detail";
        $this->breadcrumb = "Data";
		
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		
    }

    function detil($id){
		
		$id_enc			=	$id;
		$idx			=	decrypt($id);
		
		$arrData=$this->model->GetRecordData("idx=$idx");
		$arrFile	=	$this->model_file->ListAll("id_parent='".$idx."' and lampiran_type='2'");
		$arrData2=$this->model_involved->GetRecordData("idx_parent=$idx");
		$data['prop']=$this->conn->GetOne("select nm_propinsi from m_propinsi where kd_propinsi=".$arrData['kd_propinsi']."");
		$data['kab']=$this->conn->GetOne("select nm_kabupaten from m_kabupaten where kd_wilayah=".$arrData['kd_kabupaten']."");
		$data['sek']=$this->conn->GetOne("select uraian from m_sektor where kode='".$arrData['kd_sektor']."'");
		$data['att1']=$this->jkpp_model->gov($arrData['idx'],1);
		$data['att2']=$this->jkpp_model->pt($arrData['idx'],2);
		$data['att3']=$this->jkpp_model->comm($arrData['idx'],3);
		$data["data2"]=$arrData2;
		$data["data"]=$arrData;
		$data["file"]=$arrFile;
		
        $this->_render_page($this->module."index", $data,true);

    }

	function index(){
	}
	function wa(){
		// ini_set('display_errors', 1); error_reporting(E_ALL);
		// debug();
		$content = file_get_contents('https://brwa.or.id/brwa_services/gis_pengakuan/gis/data_wa_propinsi_poly');
		echo $content;
	}
}
