<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class articles extends Admin_Controller {

    function __construct(){
        parent::__construct();
        
        $this->folder="";
		$this->module=$this->folder="";
		$this->module=$this->folder."admin/articles/";
        $this->http_ref=base_url().$this->module;   
        $this->load->model("pg_model");
        $this->model=new pg_model();
        $this->tbl_idx="idx";
        $this->listText="CMS / Articles";
		$this->load->library("utils");
		$this->module_title="Articles";
		$this->layout="layout_pages/";
        $this->pages_category=1; //articles
        //check_folder($this->config->item('dir_pages_image'));
		$this->admin_layout="admin_lte_layout/main_layout";
    }
	
	function test($key=0,$forder=0,$limit=5,$page=1){
		$filter=false;
		if ($key) {
			$filter = "title like '%".$key."%' or clip like '%".$key."%'";
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
		$arrDB=$this->model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
		$total_rows=$this->model->getTotalRecordWhere($filter);
    	
				
		$base_url = $this->module."index/".$key."/".$forder."/".$limit;
		$perpage = $this->utils->getPerPage($limit,array(5,15,20,25,30,40,50));
		$paging = $this->utils->getPaginationString2($page, $total_rows, $limit, 1, $base_url, "/");
		
		if (is_array($arrDB)) {
			foreach($arrDB as $k=>$v) {
				$arrDB[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,5);
			}
		}
		$data["arrDB"]=$arrDB;
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["total_rows"]=$total_rows;
		$data["data_start"]=$data_start;
		$data["data_end"]=($data_end<$total_rows)?$data_end:$total_rows; 
		$data["perpage"]=$perpage;
		$data["paging"]=$paging;
		$data["module"]=$this->module;
		
		$data_layout["content"]=$this->load->view("articles/test",$data,true); 
		$this->load->view($this->layout."main_layout",$data_layout);
	}
	function index($forder=0,$limit=5,$page=1){
		//if (!$this->cms->has_view($this->module)) redirect ("admin/error");

		$filter=" category=1 ";
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter = "category=1 AND (title like '%".$key."%' or clip like '%".$key."%')";
			$data["key"]=$key;
		}
		$offset 		= ($page-1)*$limit;
		$data_start 	= $offset+1;
		$data_end 		= $offset+$limit;
		//$where[]=" category=1 ";
		
        // if($filter):
            // $where[]=$filter;
        // endif;
        // $whereSql=join(" and ",$where);
		// $offset 		= ($page-1)*$limit;
		// $data_start 	= $offset+1;
		// $data_end 		= $offset+$limit;
		
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
		// pre($filter);exit;
		//$arrDB=$this->model->SearchRecord(false,'order by id desc');
		$arrDB=$this->model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
		$total_rows=$this->model->getTotalRecordWhere($filter);
    	
		$query_url = ($key)?"?q=".$key:"";
		$base_url = $this->module."index/".$forder."/".$limit;
		$perpage = $this->utils->getPerPage($limit,array(5,15,20,25,30,40,50));
		
		$paging = $this->utils->getPaginationString2($page, $total_rows, $limit, 1, $base_url, "/",$query_url);
		// pre($perpage);exit;
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
		$data_layout["content"]=$this->load->view("articles/list",$data,true); 
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
			$_data["category"]=1;
			$_data["title"]=$_POST['title'];
			$_data["clip"]=$_POST['clip'];
			$_data["content"]=$_POST['content'];
            $_data["category"]=$this->input->post("category");
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			$_data["author"]=$_POST['author'];
			if ($_POST['author2']) $_others="Author: ".$_POST['author2'];
			if ($_POST['ref']) $_others.="#".$_POST['ref'];
			if ($_others) $_data["others"]=$_others;
			
			
			$insert = $this->model->InsertData($_data);
			if ($insert) {
				$data["redirect"]=true;
				set_message("success","Article Added.");
				redirect("admin/articles/");
			}
		}
		else {
			$data["process"]=false;
		}
		$data["acc_active"]="content";
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["process"]=$process;
		$data_layout["content"]=$this->load->view("articles/add",$data,true); 
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
                $tmp_name = $this->config->item('dir_tmp_pages_image').$_POST['image_name'];
				$new_name = $ppid_folder.$this->config->item('dir_pages_image').$fix_name;
				
				if (file_exists($tmp_name)) {
					if (copy($tmp_name,$new_name)) {
						$headline_img=$fix_name;
						unlink($tmp_name);
						if ($_POST['image_name_old']) unlink($this->config->item('dir_pages_image').$_POST['image_name_old']);
					}
				}
			}
			$_data["created"]=date("Y-m-d",time());
			$_data["title"]=$_POST['title'];
			$_data["clip"]=$_POST['clip'];
			$_data["content"]=$_POST['content'];
			if ($_POST['news_image_src']) $_data["image_src"]=$_POST['news_image_src'];
			if ($headline_img) $_data["image"]=$headline_img;
			if ($_POST['news_image_title']) $_data["image_title"]=$_POST['news_image_title'];
			$_data["status"]=($_POST['status'])?$_POST['status']:0;
			$_data["author"]=$_POST['author'];
			if ($_POST['author2']) $_others="Author: ".$_POST['author2'];
			if ($_POST['ref']) $_others.="#".$_POST['ref'];
			if ($_others) $_data["others"]=$_others;
			$enc=encrypt($_POST['idx']);
			$update = $this->model->UpdateData($_data,"idx='".$_POST['idx']."'");
			//echo $update;
			if ($update) {
				$data["edited"]=true;
				$arrDB=$this->model->GetRecordData("idx='".$_POST['idx']."'");
				//print_r($arrDB);
				$data["data"]=$arrDB;
				set_message("success","Article Edited.");
				redirect("admin/articles/edit/".$enc);

			}
		}
		else {
			$arrDB=$this->model->GetRecordData("idx='{$idx}'");
			$arrDB['content']=$this->utils->closetags($arrDB['content']);
			$data["data"]=$arrDB;
		}
		$data["acc_active"]="content";
		$data["module"]=$this->module;
		$data_layout["content"]=$this->load->view("articles/edit",$data,true); 
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
			redirect("admin/articles/");
		}

  }
  
  function add_save(){
      $data=$_POST;
      debug();
      //$this->model->InsertData($data);
      //redirect($this->module);
  }
  
  function edit_save(){
      $data=$_POST;
      $idx=$data["idx"];
      unset($data["idx"]);
      $this->model->UpdateData($data,"idx=$idx");
      redirect($this->module);
   }
   
   /* comments */
   function comments_add($post_id=false,$category=1){
       if(!$post_id):
           $post_id=$this->input->get_post("post_id");
       endif;
       $data_comment["category"]=$category;
       $data_comment["post_id"]=$post_id;
       
       $data["data_comment"]=$data_comment;    
       $this->load->view("comments/add",$data);
   }
   
   function comments_add_save($post_id=false,$category=1){
       if(!$post_id):
           $post_id=$this->input->get_post("post_id");
       endif;
       $data=$this->input->post();
       $this->conn->StartTrans();
       $data["category"]=$category;
       $this->adodbx->Insert("cms_comments", $data);
       $ok=$this->conn->CompleteTrans();
       if($ok):
          print "ok";
       else:
          print "failed";
       endif;
   }
   
   function comments_list($post_id=false,$category=1){
       if(!$post_id):
           $this->input->get_post("post_id");
       endif;
       $where[]="category=$category";
       $where[]="post_id=$post_id";
       $whereSql=join(" and ",$where);
       $arrData=$this->adodbx->search_record_where("cms_comments",$whereSql," order by created desc ");
       $data["comment_list"]=$this->_build_comments($arrData);
       $data["arrData"]=$arrData;
       $this->load->view("comments/list",$data);
   }
   
   function comments_reply($idx){
       $row=$this->adodbx->GetRecord("cms_comments","idx=$idx");
       $data["parent"]=$row;
       $data_comment["category"]=$row["category"];
       $data_comment["post_id"]=$row["post_id"];
       $data_comment["parent_id"]=$idx;

       $data["data_comment"]=$data_comment;    
       $this->load->view("comments/reply",$data);
   }
   
   function comments_reply_save(){
       //debug();    
       $data=$this->input->post();
       $this->conn->StartTrans();
       $this->adodbx->Insert("cms_comments", $data);
       $ok=$this->conn->CompleteTrans();
       if($ok):
           print "ok";
       else:
           print "failed";
       endif;
   }
   
   function test_comment(){
       $this->load->view("header");
       $data=$this->adodbx->search_record_where("cms_comments",null,"order by idx");
       echo "<div class='comment'>";
       echo $this->_build_comments($data);
       echo "</div>";
   }
   
   function _build_comments($rows,$parent=0){  
      $result="";
      foreach ($rows as $x=> $row):
        if ($row['parent_id'] == $parent):
            $result .= "<div class='media'>";
            $result.=' <a href="#" class="pull-left">
                    '.image_asset("user.png",'',array("class"=>"avatar media-object","alt"=>"Image","style"=>"width:30px;height:30px;")).'
                </a>';    
            $result.="<div class='media-body'><h4 class='media-heading'>".$row["name"]." <span>17 hours ago / 
            <a href='#' class='comments_reply' rel='".$this->module."comments_reply/".$row["idx"]."'>Reply</a>
             </span></h4>
                {$row['body']}<hr>";
                   
            if ($this->_has_children($rows,$row['idx'])):
                $result.= $this->_build_comments($rows,$row['idx']);
            endif;
            $result.= "</div></div>";
        endif;
      //$result="</div></div>";
      endforeach;
      //$result.= "</div>";
      return $result;
    }
    
    function _has_children($rows,$id) {
      foreach ($rows as $row) {
        if ($row['parent_id'] == $id)
          return true;
      }
      return false;
    }
   
   
   
}