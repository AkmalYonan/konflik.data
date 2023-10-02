<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class link_manager extends Admin_Controller {


    var $arr_category=array();
    
    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url','file'));
        $this->folder="admin/";
        $this->module=$this->folder."link_manager/";
        $this->http_ref=base_url().$this->module;
        $this->load->helper("menu_helper");
        
        $this->load->model("link_manager_model");
        $this->model=$this->link_manager_model;
        $this->model=new link_manager_model();
        //$this->listText="Nama Pejabat";
        $this->tbl_idx="idx";
        $this->acc_active="link_manager";
		$this->admin_layout="admin_lte_layout/main_layout";
        $this->module_title = "Links";
		$this->module_title2 = "Category";
        $this->get_lookup_category();        
    }
    
    function get_lookup_category(){
        $arrData=$this->model->category_search_record(false," order by order_num" );
        $arrCat=array(""=>"--Choose--");
        if(cek_array($arrData)):
            foreach($arrData as $x=>$val):
                $arrCat[$val["idx"]]=$val["category"];
            endforeach;
        endif;
        $this->arr_category=$arrCat;
        return $arrCat;
    }
    
    function get_filter_q($whereSql="",$field='idx'){
        $req=get_post();
       
        //debug();
        if($req["q"]):
            $field=$field;
            $search=get_where_from_searchbox($field);
            $where[]="(".$search.")";
        endif;
        
        if($req["cat_id"]):
            $where[]="(category=".$req["cat_id"].")";
        endif;
        
        //get category
        if(!empty($whereSql)):
           $where[]="(".$whereSql.")";
           $whereSql="";
        endif;
        
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        return $whereSql;
    }
    
    function index(){
       $whereCat=false;
       $arrCategory=$this->model->category_search_record_where($whereCat,"order by order_num");
       $sort=$this->input->post("sort")?$this->input->post("sort"):" category asc";
       $orderBy="";
       if($sort):
           $orderBy="order by ".$sort;
       endif;
       $sql="select * from cms_link ".$orderBy;
       
       $arrData=$this->conn->GetAll($sql);
       $data["arrCategory"]=$arrCategory;
       $data["arrData"]=$arrData;
	   
       $this->_render_page($this->module."index",$data,true);
    }
    
    /*
    function pejabat_list(){
       $queryString=rebuild_query_string();
        
        $field="nama,nip,atas,jabatan";
        $whereSql=get_where_from_searchbox($field);
        $arrBread[]=array("text"=>"".$this->listText."","url"=>"");
        $this->load->library('pagination');  
        $perPage=20;
        $uriSegment=4;
        $totalRows=count($this->model->SearchRecordWhere($whereSql));
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by status desc,id_pejabat desc";
        $arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
        
        $config['base_url'] = $this->http_ref."/index/";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        //$config['display_pages'] = FALSE;
        $this->pagination->initialize($config);
        
        $data["arrData"]=$arrData;
        $datam["arrBread"]=$arrBread;
        $datam["content"]=$this->load->view($this->module."pejabat_list",$data,true);
        $this->load->view("main_layout",$datam);
        
    }*/

    /* LINK */
    /*===============================================================================================*/
    function link_list(){
  		//if (!$this->cms->has_view($this->module)) redirect ("admin/error");

        $this->load->library('pagination');  
            
        $queryString=rebuild_query_string();
        
        $field="category_name,name,link_url,description";
        $whereSql=get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
        
        if($this->input->get_post("cat_id")):
            $where[]=" category=".$this->input->get_post("cat_id");
        endif;
        $whereSql="";
        
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        
        $sql=" select a.*,b.category as category_name from ".$this->model->tbl." a 
                left join ".$this->model->tbl_link_category." b on a.category=b.idx
        ";
        
        //$arrData=$this->model->SearchRecordWhere(false," order by category,name");
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;
       
        $uriSegment=4;
        
        $table="($sql) a";
        $totalRows=count($this->adodbx->search_record_where($table,$whereSql));
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by idx desc";
        
        $arrData=$this->adodbx->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        
        $config['base_url'] = $this->module."link_list";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        //$config['display_pages'] = FALSE;
        $this->pagination->initialize($config);
        
        $data["arrData"]=$arrData;
		$this->_render_page($this->module."link_list",$data,true);
    }
    
    function link_add(){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");

        $this->msg_ok="Link created successfully";
        $this->msg_fail="Unable to create new link";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
            $this->_render_page($this->module."link_add",$data,true);
        endif;
        //debug();
        if($act=="create"):
            $this->conn->StartTrans();
            $data=get_post();
            $data=array_map("trim",$data);
			/* Komeng add */
			if ($data['image']) {
				$ppid_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_ppid');
				$fix_name = "link-".time().substr($_POST['image'],strrpos($_POST['image'],"."));
				$tmp_name = $this->config->item('dir_tmp_pages_image').$_POST['image'];
				$new_name = $ppid_folder.$this->config->item('dir_pages_image').$fix_name;
				
				if (file_exists($tmp_name)) {
					if (copy($tmp_name,$new_name)) {
						$link_img=$fix_name;
						unlink($tmp_name);
					}
				}
			}
            
            $data["publish"]=$data["publish"]?$data["publish"]:0;
            //$data["active"]=$data["active"]?$data["active"]:0;
            $data["edited"]=date("Y-m-d H:i:s");
            $data["editor"]=$this->data["users"]["user"]["username"];
			
			//image 
			if ($link_img) $data["image"]=$link_img;
            $this->model->InsertData($data);
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."link_list/",$this->module."link_add/");
        endif;
    }
    
    function link_edit($id){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
        $this->msg_ok="Link updated successfully";
        $this->msg_fail="Unable to update link";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $arrData=$this->model->GetRecordData("idx=$id");
            $data["data"]=$arrData;
			// pre($arrData);exit;
            $this->_render_page($this->module."link_edit",$data,true);
        endif;
        if($act=="update"):
            $this->conn->StartTrans();
            $data=get_post();
            $data=array_map("trim",$data);
            
			/* Komeng add */
			if ($data['image']) {
				$ppid_folder = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_ppid');
				$fix_name = "link-".time().substr($_POST['image'],strrpos($_POST['image'],"."));
				$tmp_name = $this->config->item('dir_tmp_pages_image').$_POST['image'];
				$new_name = $ppid_folder.$this->config->item('dir_pages_image').$fix_name;
				
				if (file_exists($tmp_name)) {
					if (copy($tmp_name,$new_name)) {
						$link_img=$fix_name;
						unlink($tmp_name);
						if ($_POST['image_name_old']) unlink($this->config->item('dir_link_image').$_POST['image_name_old']);
					}
				}
			}
            $data["publish"]=$data["publish"]?$data["publish"]:0;
            //$data["active"]=$data["active"]?$data["active"]:0;
            $data["edited"]=date("Y-m-d H:i:s");
            $data["editor"]=$this->data["users"]["user"]["username"];
			if ($link_img) $data["image"]=$link_img;
            
            unset($data["idx"]);
            $this->model->UpdateData($data, "idx=$id_enc");
            $ok=$this->conn->CompleteTrans();
           $this->_proses_message($ok,$this->module."link_list",$this->module."link_edit/$id");
        endif;
            
    }
    
    function link_delete($id){
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->conn->StartTrans();
		$this->model->DeleteData("idx=$id");
		$ok=$this->conn->CompleteTrans();
		redirect("admin/link_manager/link_list");
    }
    /* end link */
    /*===============================================================================================*/
    
    
    /*===============================================================================================*/
    /* link category */
    function category_list(){
  		//if (!$this->cms->has_view($this->module)) redirect ("admin/error");

        $arrData=$this->model->category_search_record_where(false," order by order_num ");
        $data["arrData"]=$arrData;
        $this->_render_page($this->module."cat_list",$data,true);
    }
    
    function category_add(){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/admin/error_page");

        $this->msg_ok="Category created successfully";
        $this->msg_fail="Unable to create new category";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
            $this->_render_page($this->module."cat_add",$data,true);
        endif;
        //debug();
        if($act=="create"):
            $this->conn->StartTrans();
            $data=get_post();
            $data=array_map("trim",$data);
            $data["publish"]=$data["publish"]?$data["publish"]:0;
            $data["order_num"]=$data["order_num"]?$data["order_num"]:$this->conn->GetOne("select max(order_num)+1 from ".$this->model->tbl_link_category);
            $data=$this->_add_creator($data);
            
            $this->model->category_add($data);
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."category_list/",$this->module."category_add/");
        endif;
    }
    
    function category_edit($id){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/admin/error_page");
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
        $this->msg_ok="Category updated successfully";
        $this->msg_fail="Unable to update category";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $arrData=$this->model->category_get("idx=$id");
            $data["data"]=$arrData;
            $this->_render_page($this->module."cat_edit",$data,true);
        endif;
        if($act=="update"):
            $this->conn->StartTrans();
            $data=get_post();
            $data=array_map("trim",$data);
            unset($data["idx"]);
            $data["publish"]=$data["publish"]?$data["publish"]:0;
            $data=$this->_add_editor($data);
            
            $this->model->category_update($data, "idx=$id_enc");
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."category_list",$this->module."category_edit/$id");
        endif;
            
    }
    
    function category_delete($id){
  		// if (!$this->cms->has_admin($this->module)) redirect ("admin/admin/error_page");

		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->conn->StartTrans();
		$this->model->category_delete("idx=$id");
		$ok=$this->conn->CompleteTrans();
		redirect("admin/link_manager/category_list");
    }
     /* end category list */   
     /*===============================================================================================*/
    
    
    function _proses_message($ok,$url_ok=false,$url_error=false){
        $url_ok=$url_ok?$url_ok:$this->module;
        $url_error=$url_error?$url_error:$this->module;
        if(!$this->input->is_ajax_request()):    
            if($ok):
                    set_message("success", $this->msg_ok);
                    redirect($url_ok);
            else:
                    set_message("error",$this->msg_fail);
                    redirect($url_error);
            endif;  
        else:
            if($ok):
                 print "ok";
            else:
                print "failed";
            endif;    
        endif;
    }
    
    function _render_page($view, $data=null, $render=false)
    {
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $render);
        if($render):
            $datam["acc_active"]=$this->acc_active;
            $datam["content"]=$view_html;
            //$this->load->view("admin_layout/main_layout",$datam);
			$this->load->view($this->admin_layout,$datam);
        endif;
        //if (!$render) return $view_html;
    }
    
    function _prepare_ip($ip_address) {
        if ($this->db->platform() === 'postgre' || $this->db->platform() === 'sqlsrv' || $this->db->platform() === 'mssql')
        {
            return $ip_address;
        }
        else
        {
            return inet_pton($ip_address);
        }
    }
    
    function up($id){
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
        $this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
        $arrData=$this->model->category_search_record_where(false," order by order_num");
        foreach($arrData as $x=>$value):
            $updownData[]=$value["idx"];
            if($value["idx"]==$id):
                $current=$x;
            endif;
        endforeach;
        
        $idCurrent=$updownData[$current];
        $idBefore=$updownData[$current-1];
        
        $this->conn->StartTrans();
        $data["order_num"]=$current+1;
        $this->conn->AutoExecute($this->model->tbl_link_category,$data,"UPDATE","idx=".$idBefore);
        $data["order_num"]=$current;
        $this->conn->AutoExecute($this->model->tbl_link_category,$data,"UPDATE","idx=".$idCurrent);
        $ok=$this->conn->CompleteTrans();
        $this->_proses_message($ok,$this->agent->referrer(),$this->agent->referrer());
    }
    
    function down($id){
        if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
        //$arrData=$this->conn->GetAll("select * from "" where  menu_parent_id={$menu_parent_id} order by order_num");
        $arrData=$this->model->category_search_record_where(false," order by order_num");
        foreach($arrData as $x=>$value):
            $updownData[]=$value["idx"];
            if($value["idx"]==$id):
                $current=$x;
            endif;
        endforeach;
        
        $idCurrent=$updownData[$current];
        $idNext=$updownData[$current+1];
        
        $this->conn->StartTrans();
        $data["order_num"]=$current+1;
        $this->conn->AutoExecute($this->model->tbl_link_category,$data,"UPDATE","idx=".$idNext);
        $data["order_num"]=$current+2;
        $this->conn->AutoExecute($this->model->tbl_link_category,$data,"UPDATE","idx=".$idCurrent);
        $ok=$this->conn->CompleteTrans();
       $this->_proses_message($ok,$this->agent->referrer(),$this->agent->referrer());
    }
     
    function _add_creator($data){
        $data["created"]=date("Y-m-d H:i:s");
        $data["creator"]=$this->data["users"]["user"]["username"];
        $data["edited"]=date("Y-m-d H:i:s");
        $data["editor"]=$this->data["users"]["user"]["username"];
    
        return $data;
    }
    
    function _add_editor($data){
        $data["edited"]=date("Y-m-d H:i:s");
        $data["editor"]=$this->data["users"]["user"]["username"];
        return $data;
    }
    
}

/* End of file pejabat.php */
/* Location: ./application/controllers/master//pejabat.php*/