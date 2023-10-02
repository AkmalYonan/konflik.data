<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class slider extends Admin_Controller {

    function __construct(){
        parent::__construct();
        
        $this->folder="";
		$this->module=$this->folder="";
		$this->module=$this->folder."admin/slider/";
        $this->http_ref=base_url().$this->module;
        
        $this->load->model("pg_model");
        $this->model=$this->pg_model;
		$this->load->library("utils");
        $this->module_title="Carausel";
		$this->tbl_idx="idx";
		$this->admin_layout="admin_lte_layout/main_layout";
    }
	function index($forder=0,$limit=5,$page=1){
  		//if (!$this->cms->has_view($this->module)) redirect ("admin/error");
		
		$filter="category=4";
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter = "category=4 AND (title like '%".$key."%' or clip like '%".$key."%')";
			$data["key"]=$key;
		}
		$offset 		= ($page-1)*$limit;
		$data_start 	= $offset+1;
		$data_end 		= $offset+$limit;
		
		if ($forder) {
			$spl = preg_split("/:/",$forder);
			$order = 'order by '.$spl[0].' '.$spl[1];
			$data["forder"]=$spl[0];
			$data["dorder"]=$spl[1];
		}
		else {
			$order = 'order by idx desc';
		}
		// pre($limit);exit;
		//debug();
		//$arrDB=$this->model->SearchRecord(false,'order by id desc');
		$arrDB=$this->model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
		$total_rows=$this->model->getTotalRecordWhere($filter);
    	
		$query_url = ($key)?"?q=".$key:"";
		$base_url = $this->module."index/".$forder."/".$limit;
		$perpage = $this->utils->getPerPage($limit,array(5,15,20,25,30,40,50));
		
		$paging = $this->utils->getPaginationString2($page, $total_rows, $limit, 1, $base_url, "/",$query_url);
		
		if (is_array($arrDB)) {
			foreach($arrDB as $k=>$v) {
				$arrDB[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,5);
				$arrDB[$k]['news_clip2']=substr($v['clip'],0,100)."...";
			}
		}
		$data["acc_active"]="content";
		$data["arrDB"]=$arrDB;
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["total_rows"]=$total_rows;
		$data["data_start"]=$data_start;
		$data["data_end"]=($data_end<$total_rows)?$data_end:$total_rows; 
		$data["perpage"]=$perpage;
		$data["paging"]=$paging;
		$data["module"]=$this->module;
		
		
		$data_layout["content"]=$this->load->view("slider/list",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
	}
	function add(){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		$data["module"]=$this->module;
		if ($_SERVER['REQUEST_METHOD']=='POST') {
		
			$data["process"]=true;
			if ($_POST['image_name']) {
				$ppid_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_ppid');
				
				$fix_name = time().substr($_POST['image_name'],strrpos($_POST['image_name'],"."));
				$tmp_name = $this->config->item('dir_tmp_pages_image').$_POST['image_name'];
				$new_name = $ppid_folder.$this->config->item('dir_pages_image').$fix_name;
				if (file_exists($tmp_name)) {
					if (copy($tmp_name,$new_name)) {
						$headline_img=$fix_name;
						unlink($tmp_name);
					}
				}
			}
			$_data["created"]=date("Y-m-d h:i:s",time());
			$_data["category"]=4;
			$_data["title"]=$_POST['title'];
			$_data["clip"]=$_POST['news_clip'];
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			if ($_POST['button'] && $_POST['url']) $_data["others"]=$_POST['button']."#".$_POST['url'];
			$_data["author"]=$_POST['author'];
			//print_r($_data);
			//exit;
			
			$insert = $this->model->InsertData($_data);
			if ($insert) {
				$data["redirect"]=true;
				set_message("success","Image Added.");
				redirect("admin/slider/");

			}
		}
		else {
			$data["process"]=false;
		}
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["acc_active"]="content";
		$data["process"]=$process;
		$data_layout["content"]=$this->load->view("slider/add",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
	}
  
  function edit($idx=false){
  		// echo $idx;exit;
		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		if($this->encrypt_status==TRUE):
			$id_enc=$idx;
			$id=decrypt($idx);
		endif;
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$process=true;
			if ($_POST['image_name']) {
				$ppid_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_ppid');
				
				$fix_name = time().substr($_POST['image_name'],strrpos($_POST['image_name'],"."));
				$tmp_name = $this->config->item('dir_tmp_pages_image').$_POST['image_name'];
				$new_name = $ppid_folder.$this->config->item('dir_pages_image').$fix_name;
				if (file_exists($tmp_name)) {
					if (copy($tmp_name,$new_name)) {
						$headline_img=$fix_name;
						unlink($tmp_name);
						unlink($this->config->item('dir_pages_image').$_POST['image_name_old']);
					}
				}
			}
			$_data["created"]=date("Y-m-d h:i:s",time());
			$_data["category"]=4;
			$_data["title"]=$_POST['title'];
			$_data["clip"]=$_POST['news_clip'];
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			if ($_POST['button'] && $_POST['url']) $_data["others"]=$_POST['button']."#".$_POST['url'];
			$_data["author"]=$_POST['author'];
			$enc=encrypt($_POST['idx']);
			//print_r($_data);
			//exit;
			//debug();
			$update = $this->model->UpdateData($_data,"idx='".$_POST['idx']."'");
			//echo $update;
			if ($update) {
				$data["edited"]=true;
				$arrDB=$this->model->GetRecordData("idx='".$_POST['idx']."'");
				//print_r($arrDB);
				$data["data"]=$arrDB;
				set_message("success","Image Slider Edited.");
				redirect("admin/slider/edit/".$enc);
			}
		}
		else {
			$arrDB=$this->model->GetRecordData("idx='{$id}'");
			$data["data"]=$arrDB;
		}
		
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["acc_active"]="content";
		$data["module"]=$this->module;
		$data_layout["content"]=$this->load->view("slider/edit",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
  }
  
	function delete($idx=false){
  		//if (!$this->cms->has_admin($this->module)) redirect ("admin/error");
		if($this->encrypt_status==TRUE):
			$id_enc=$idx;
			$idx=decrypt($idx);
		endif;
		$delete = $this->model->DeleteData("idx='".$idx."'");
		if ($delete) {
			$data["delete"]=true;
			redirect("admin/slider/");
		}
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