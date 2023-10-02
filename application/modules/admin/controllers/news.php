<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news extends Admin_Controller {

    function __construct(){
        parent::__construct();
        
        $this->folder="";
		$this->module=$this->folder="";
		$this->module=$this->folder."admin/news/";
		$this->http_ref=base_url().$this->module;///brwa_admin/admin/news/
        $this->tbl_idx="idx";
        $this->load->model("pg_model");
        $this->model=$this->pg_model;
		$this->listText="CMS / News";
		$this->load->library("utils");
        $this->module_title="News";
		$this->load->model("account_manager_model");
        $this->ammmodel=$this->account_manager_model;
		$this->admin_layout="admin_lte_layout/main_layout";
		//pre($this->session);
    }
	function user_list(){
       	$queryString=rebuild_query_string();
		//debug();
        $q=$this->input->get_post("q");
        $field="username,first_name,last_name,email";
		$whereSql=get_where_from_searchbox($field);
		$arrBread[]=array("text"=>"".$this->listText."","url"=>"");
        $this->load->library('pagination');  
		$perPage=20;
        $uriSegment=4;
        $totalRows=count($this->ammmodel->SearchRecordWhere($whereSql));
		$offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
		$sortBy=" order by username";
		$arrData=$this->ammmodel->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
        if(cek_array($arrData)):
			foreach($arrData as $x=>$val):
				$arrData[$x]["groups"]=(array) $this->ion_auth->get_users_groups($val["id"])->result_array();
			endforeach;
		endif;
		
		$config['base_url'] = $this->http_ref."/index/";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
		$config["suffix"]=$queryString;
        //$config['display_pages'] = FALSE;
		$this->pagination->initialize($config);
		
		$data["arrData"]=$arrData;
        $datam["arrBread"]=$arrBread;
		$datam["acc_active"]=$this->acc_active;
        $datam["content"]=$this->load->view("news/user_list",$data,true);
        $this->load->view($this->admin_layout,$datam);
    }
	function index($forder=0,$limit=5,$page=1){
		//if (!$this->cms->has_view($this->module)) redirect ("admin/error");
		
		$filter="category=3 or category=2";
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter = "(category=3 or category=2) AND (title like '%".$key."%' or clip like '%".$key."%')";
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
		//$arrDB=$this->model->SearchRecord(false,'order by id desc');
		// pre($whereSql);exit;
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
		
		$data_layout["content"]=$this->load->view("news/list",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
	}
	function add(){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");

		$data["module"]=$this->module;
		if ($_SERVER['REQUEST_METHOD']=='POST') {
		//print_r($_POST);
		//exit;
			$data["process"]=true;
			//echo $_POST['image_name'];exit;
			if ($_POST['image_name']) {
				$ppid_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_ppid');			
				$fix_name = time().substr($_POST['image_name'],strrpos($_POST['image_name'],"."));
				$tmp_name = $this->config->item('dir_tmp_news_image').$_POST['image_name'];
				$new_name = $ppid_folder.$this->config->item('dir_news_image').$fix_name;
				// echo $new_name;exit; 
				if (file_exists($tmp_name)) {
					if (copy($tmp_name,$new_name)) {
						$headline_img=$fix_name;
						unlink($tmp_name);
					}
				}
			}
			$_data["created"]=date("Y-m-d h:i:s",time());
			$_data["category"]=$_POST['category'];
			$_data["title"]=$_POST['title'];
			$_data["clip"]=$_POST['news_clip'];
			$_data["content"]=$_POST['news_content'];
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			$_data["author"]=$_POST['author'];
			//print_r($_data);
			//exit;
			
			$insert = $this->model->InsertData($_data);
			if ($insert) {
				$data["redirect"]=true;
				set_message("success","News Added.");
				redirect("admin/news/");
			}
		}
		else {
			$data["process"]=false;
		}
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["acc_active"]="content";
		$data["process"]=$process;
		$data_layout["content"]=$this->load->view("news/add",$data,true); 
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
			if ($_POST['image_name']) {
				$ppid_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_ppid');
				
				$fix_name = time().substr($_POST['image_name'],strrpos($_POST['image_name'],"."));
				$tmp_name = $this->config->item('dir_tmp_news_image').$_POST['image_name'];
				$new_name = $ppid_folder.$this->config->item('dir_news_image').$fix_name;
				if (file_exists($tmp_name)) {
					if (copy($tmp_name,$new_name)) {
						$headline_img=$fix_name;
						unlink($tmp_name);
						if ($_POST['image_name_old']) unlink($this->config->item('dir_news_image').$_POST['image_name_old']);
					}
				}
			}
			$_data["created"]=($_POST['news_date'])?$_POST['news_date']:date("Y-m-d",time());
			$_data["category"]=$_POST['category'];
			$_data["title"]=$_POST['title'];
			$_data["clip"]=$_POST['news_clip'];
			$_data["content"]=$_POST['news_content'];
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
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
				set_message("success","News Edited.");
				redirect("admin/news/edit/".$enc);
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
		$data_layout["content"]=$this->load->view("news/edit",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
  }
  
  function delete($idx=false){
  		//if (!$this->cms->has_admin($this->module)) redirect ("admin/error");
		if($this->encrypt_status==TRUE):
			$id_enc=$idx;
			$idx=decrypt($idx);
		endif;
		$delete = $this->model->DeleteData("idx=$idx");		  
		if ($delete) {
			$data["delete"]=true;

			redirect("admin/news/");
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