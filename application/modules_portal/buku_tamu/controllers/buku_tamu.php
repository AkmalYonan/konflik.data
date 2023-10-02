<?php defined('BASEPATH') OR exit('No direct script access allowed');

class buku_tamu extends Public_Controller {

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

        $this->main_layout="main_layout";
        $this->admin_layout="layout/main_layout";

        $this->load->model("general_model");

        $this->model   =   new general_model("cms_guest_book");

        $this->breadcrumb = "Buku Tamu";
        $this->active   =   "buku_tamu";
    }



    function index(){

        $this->load->library('pagination');
        $queryString=rebuild_query_string();
        $field="name";
        $whereSql=get_where_from_searchbox($field);
        $filter="";
        $where="";
        $key = ($this->input->get_post('q'))?$this->input->get_post('q'):false;
        $category   =   "1";
        if($key) {
            $filter = $where."(title like '%".$key."%' or clip like '%".$key."%')";
            $data["key"]=$key;
            $where=" and ";
        }
        if($category){
            $filter =   $where."status='".$category."'";
            $data["category"]=$category;
            $where  =   " and ";
        }
		
		$perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"5";
        $data["perPage"]=$perPage;
        $uriSegment =   4;
        $totalRows=$this->model->getTotalRecordWhere($filter,'idx');
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy = 'order by idx desc';

      	if ($forder) {
                  $spl = preg_split("/:/",$this->input->get_post('forder'));
                  $sortBy = 'order by '.$spl[0].' '.$spl[1];
                  $data["forder"]=$spl[0];
                  $data["dorder"]=$spl[1];
      	}

        $config['base_url'] = $this->module."index";
        $config['per_page'] = $perPage;
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		$arrDB=$this->model->SearchRecordLimitWhere($filter,$perPage,$offset,$sortBy);
        $data["breadcrumb"]=$this->breadcrumb;
        $data["active"]=$this->active;
        $data["home"]="Beranda";
	    $data["acc_active"]="kategori";
	    $data["data"]=$arrDB;
		$data["user_name"]=$this->data['users']['user']['username'];
	    $data["module"]=$this->module;
        $this->_render_page($this->module."read", $data,true);
    }
	
	function add(){
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";

        $act=$this->input->post("act")?$this->input->post("act"):"";

        if(!isset($_POST['name1'])):
            $data=null;
            $this->_render_page($this->module."v_add",$data,true);
        endif;

		if(isset($_POST['name1'])):
			
			$data=get_post();
			$data["name"] = $_POST['name1'];
			$data["email"] = $_POST['email1'];
			$data["subject"] = $_POST['subject1'];
			$data["comments"] = $_POST['comments1'];
			
			$start		=	$this->conn->StartTrans();
			
			$this->model->InsertData($data);
			$complete	=	$this->conn->CompleteTrans();
			
            
        endif;
    }


    function _render_page($view, $data=null, $render=false)
    {
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $render);
        if($render):
            $datam["acc_active"]="account_manager";
            $datam["content"]=$view_html;
            $this->load->view($this->public_layout."/main_layout",$datam);
        endif;
    }

}
