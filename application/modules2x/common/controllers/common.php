<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class common extends Admin_Controller {
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
        $this->main_layout="admin_lte_layout/main_layout";
		
		//$this->parent_module_title="Laporan";
		//$this->module_title="Klinik";
	 }
	 
	 function print_html(){
		$req=get_post();
		$data=$req;
		$tbl=rawurldecode($_POST["tbl"]);
		$data["template"]=$_POST["tbl"];
		$data["tbl"]=$tbl;
		
		$data["data"]=$data;
		//pre(get_post());
		$data["print_url"]="print_html";
		$datam["content"]=$this->load->view("print_preview/direct_print_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}
	
	function pdf_setting(){
		$postData=get_post();
		
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
		$datam["content"]=$this->load->view("print_preview/pdf_setting_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}
	
	
	function pdf(){
		$postData=get_post();
		
		$post=rawurldecode($_POST["tbl"]);
		$print_url=rawurldecode($_POST["print_url"]);
		//$file_name=$this->input->post("filename",true);
		$file_name=$_POST["filename"];
		$postData["tbl"]=$post;
		$postData["filename"]=$file_name;
		$postData["print_url"]=$print_url;
		$id_mst=$this->input->post("id_mst",true);
        $id_mst=$id_mst?decrypt($id_mst):"";
        $postData["id_mst"]=$id_mst;
        $data["data"]=$postData;
		$datam["content"]=$this->load->view("print_preview/pdf_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}
	
	function print_pdf_setting(){
		$postData=get_post();
		$post=rawurldecode($_POST["tbl"]);
		$print_url=rawurldecode($_POST["print_url"]);
		
		//$file_name=$this->input->post("filename",true);
		$file_name=$_POST["filename"];
		$postData["tbl"]=$post;
		$postData["filename"]=$file_name;
		$postData["print_url"]=$print_url;
		$id_mst=$this->input->post("id_mst",true);
        $id_mst=$id_mst?decrypt($id_mst):"";
        $postData["id_mst"]=$id_mst;
        $data["data"]=$postData;
		$datam["content"]=$this->load->view("print_preview/direct_pdf_setting_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}
	
	
	function print_pdf(){
		$postData=get_post();
		$post=rawurldecode($_POST["tbl"]);
		$print_url=rawurldecode($_POST["print_url"]);
		//$file_name=$this->input->post("filename",true);
		$file_name=$_POST["filename"];
		
		$postData["tbl"]=$post;
		$postData["filename"]=$file_name;
		$postData["print_url"]=$print_url;
		$id_mst=$this->input->post("id_mst",true);
        $id_mst=$id_mst?decrypt($id_mst):"";
        $postData["id_mst"]=$id_mst;
        $data["data"]=$postData;
		$datam["content"]=$this->load->view("print_preview/direct_pdf_in_dialog",$data,true);
		$this->load->view("admin_lte_layout/print_layout",$datam);
		//$this->_render_page($this->module."pdf/pdf_setting",$data,true);
	}
	 
	 
	function uc_page(){
		
		$this->_render_page("v_under_construction",$data,true);	
	}
	
	 
	 
	 

}