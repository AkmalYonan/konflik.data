<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rujukan extends Admin_Controller {

    function __construct(){
        parent::__construct();
        
		$this->page_active="rujukan/";
        $this->folder="";
		$this->module=$this->folder="";
		$this->module=$this->folder."admin/rujukan/";
		$this->http_ref=base_url().$this->module;///brwa_admin/admin/news/
        $this->tbl_idx="idx";
        $this->load->model("pg_model");
        $this->model=$this->pg_model;
		$this->listText="CMS / rujukan";
		$this->load->library("utils");
		$this->load->helper("url");
        $this->module_title="rujukan";
		$this->load->model("account_manager_model");
        $this->ammmodel=$this->account_manager_model;
		$this->admin_layout="admin_lte_layout/main_layout";
    }

	function index($forder=0,$limit=5,$page=1){
		// if (!$this->cms->has_view($this->module)) redirect ("admin/error");
		
		$filter="category=1018";
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter = "(category=1018) AND (title like '%".$key."%' or clip like '%".$key."%')";
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
		//debug();
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
		// pre($data);exit;
		
		$data_layout["content"]=$this->load->view("rujukan/list",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
	}
	function add(){
  		// if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		$data["module"]=$this->module;
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$data["process"]=true;
			if ($_FILES['image_name']['name']) {
				$ppid_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_ppid');
				
				$fix_name = time().substr($_FILES['image_name']['name'],strrpos($_FILES['image_name']['name'],"."));
				$new_name = $ppid_folder.$this->config->item('dir_rujukan').$fix_name;
					move_uploaded_file($_FILES['image_name']['tmp_name'], $new_name);
					$headline_img=$fix_name;
			}
			$_data["created"]=date("Y-m-d h:i:s",time());
			$_data["category"]=$_POST['category'];
			$_data["title"]=$_POST['title'];
			$_data["others"]=$_POST['keterangan'];
			if ($headline_img) $_data["image"]=$headline_img;
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			$_data["author"]=$_POST['author'];
			
			$insert = $this->model->InsertData($_data);
			if ($insert) {
				$data["redirect"]=true;
				set_message("success","rujukan Added.");
				redirect("admin/rujukan/");
			}
		}
		else {
			$data["process"]=false;
		}
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["acc_active"]="content";
		$data["process"]=$process;
		$data_layout["content"]=$this->load->view("rujukan/add",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
	}
  
  function edit($idx=false){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		if($this->encrypt_status==TRUE):
			$id_enc=$idx;
			$idx=decrypt($idx);
		endif;
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$process=true;
			if ($_FILES['image_name']['name']) {
				$ppid_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_ppid');
				
				$fix_name = time().substr($_FILES['image_name']['name'],strrpos($_FILES['image_name']['name'],"."));
				$new_name = $ppid_folder.$this->config->item('dir_rujukan').$fix_name;

					move_uploaded_file($_FILES['image_name']['tmp_name'], $new_name);
					$headline_img=$fix_name;
					unlink($fix_name);
					if ($_POST['image_name_old']) unlink($ppid_folder.$this->config->item('dir_rujukan').$_POST['image_name_old']);


			}
			
			$_data["created"]=($_POST['news_date'])?$_POST['news_date']:date("Y-m-d",time());
			$_data["category"]=$_POST['category'];
			$_data["title"]=$_POST['title'];
			$_data["others"]=$_POST['keterangan'];
			if ($headline_img) $_data["image"]=$headline_img;
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			$_data["author"]=$_POST['author'];
			$enc=encrypt($_POST['idx']);
			$update = $this->model->UpdateData($_data,"idx='".$_POST['idx']."'");
			//echo $update;
			if ($update) {
				$data["edited"]=true;
				$arrDB=$this->model->GetRecordData("idx='".$_POST['idx']."'");
				//print_r($arrDB);
				$data["data"]=$arrDB;
				set_message("success","rujukan Edited.");
				redirect("admin/rujukan/edit/".$enc);
			}
		}
		else {
			$arrDB=$this->model->GetRecordData("idx='{$idx}'");
			$arrDB['news_content']=$this->utils->closetags($arrDB['news_content']);
			$data["data"]=$arrDB;
		}
		
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["acc_active"]="content";
		$data["module"]=$this->module;
		$data_layout["content"]=$this->load->view("rujukan/edit",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
  }
  
  function delete($idx=false){
  		//if (!$this->cms->has_admin($this->module)) redirect ("admin/error");
		if($this->encrypt_status==TRUE):
			$id_enc=$idx;
			$idx=decrypt($idx);
		endif;
		
		$reg=$this->model->GetRecordData("idx='{$idx}'");
		$ppid_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_ppid');
		$data["process"]=true;
		$new_name = $ppid_folder.$this->config->item('dir_rujukan').$reg['image'];
		$files = $new_name;
		unlink($files);
		$delete = $this->model->DeleteData("idx=$idx");		
		$data["delete"]=true;
		redirect("admin/rujukan/");
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