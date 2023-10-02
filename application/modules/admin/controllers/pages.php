<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pages extends Admin_Controller {

    function __construct(){
        parent::__construct();
        
        $this->folder="";
		$this->module=$this->folder="";
		$this->module=$this->folder."admin/pages/";
        $this->http_ref=base_url().$this->module;
        
        $this->load->model("pg_model");
        $this->model=$this->pg_model;
		$this->listText="CMS / News";
		$this->load->library("utils");
        
		$this->load->model("account_manager_model");
        $this->ammmodel=$this->account_manager_model;
		$this->admin_layout="admin_lte_layout/main_layout";
		//pre($this->session);
    }
	function about(){
		$this->index('about');
	}
	function index($category){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		$filter="category='".$category."'";
		$pages=$this->model->get_pages_record($filter);
		
		if (!$pages['idx'])  redirect ("admin/error");
		
		$filter="category='".$pages['idx']."'";
		$arrDB=$this->model->GetRecordData($filter);
		
		$data["acc_active"]="pages";
		$data["page"]=$pages;
		$data["data"]=$arrDB;
		
		$data_layout["content"]=$this->load->view("pages/edit",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
	}
	function add(){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		$data["module"]=$this->module;
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$data["process"]=true;
			$_data["created"]=date("Y-m-d h:i:s",time());
			$_data["category"]=$_POST['category'];
			$_data["content"]=$_POST['content'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			$_data["author"]=$_POST['author'];
			
			$insert = $this->model->InsertData($_data);
			if ($insert) {
				$data["redirect"]=true;
				set_message("success","Initial Page Created.");
				redirect("admin/pages/index/".$_POST['name']);
			}
		}
		else {
			redirect ("admin/error");
		}
	}
  
  function edit($idx=false){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$process=true;
			$_data["edited"]=date("Y-m-d h:i:s",time());
			$_data["category"]=$_POST['category'];
			$_data["content"]=$_POST['content'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			$_data["author"]=$_POST['author'];
			
			$update = $this->model->UpdateData($_data,"idx='".$_POST['idx']."'");
			//echo $update;
			if ($update) {
				$data["edited"]=true;
				$arrDB=$this->model->GetRecordData("idx='".$_POST['idx']."'");
				//print_r($arrDB);
				$data["data"]=$arrDB;
				set_message("success","Page Edited.");
				redirect("admin/pages/index/".$_POST['name']);
			}
		}
		else {
			redirect ("admin/error");
		}
  }
  
  function delete($idx=false){
  		//if (!$this->cms->has_admin($this->module)) redirect ("admin/error");
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$delete = $this->model->DeleteData("idx='".$_POST['idx']."'");
			//echo $update;
			if ($delete) {
				$data["delete"]=true;
				set_message("error","News Deleted.");
				redirect("admin/news/");
			}
		}
		else {
			$arrDB=$this->model->GetRecordData("idx='{$idx}'");
			$data["data"]=$arrDB;
		}
		$data["acc_active"]="content";
		$data["module"]=$this->module;
		$data_layout["content"]=$this->load->view("news/delete",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
  }
  
  function add_save(){
      $data=$_POST;
      $this->model->InsertData($data);
      redirect($this->module);
  }
  
  function edit_save(){
      $data=$_POST;
      $idx=$data["idx"];
      unset($data["idx"]);
      $this->model->UpdateData($data,"idx=$idx");
      redirect($this->module);
   }
   
}