<?php defined('BASEPATH') OR exit('No direct script access allowed');

class pp extends Public_Controller {

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

        
		$this->model=new general_model("cms_pp");
		$this->model_category=new general_model("cms_pp_category");
		$this->model_file=new general_model("cms_pp_file");
		$this->model_file_upload=new general_model("cms_pp_file_upload");
		
		$this->tbl_idx="idx";
		$this->tbl_sort="created desc";	
		
        $this->active   =   "pustaka";
        $this->breadcrumb = "Pustaka";
		
		$this->category=1;
		
		
    }

	function index(){
		$this->listview();	
	}
	
	function listview(){
		$this->load->library('pagination');  
        
		$req=get_post();
		
		$sql=" select a.*,group_concat(b.realname) as realname,group_concat(b.path) as path,
			group_concat(b.file_size) as file_size from ".$this->model->tbl." a 
                left join ".$this->model->tbl."_file b on a.idx=b.id_pp group by a.idx
        ";
		
		
		//$table=$this->model->tbl;    
        $table="($sql) a";
		$queryString=rebuild_query_string(); 
		$data_type=$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        
        $col_text=$data["text"];
		$field=join(",",$col_text);
        $whereSql=get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
		
		$where[]="(category=".$this->category.")";
        
        if($this->input->get_post("tahun")):
            $where[]	=	" year='".$this->input->get_post("tahun")."'";
		endif;

		if($this->input->get_post("kd_cat_pp")):
            $where[]	=	" kd_cat_pp='".$this->input->get_post("kd_cat_pp")."'";
        endif;
        
        ///$kd_cat_pp=$req["cat"]?$req["cat"]:false;
		//$kd_cat_pp=$kd_cat_pp!=''?$kd_cat_pp:false;
		///if($kd_cat_pp):
		///	$where[]="kd_cat_pp='{$kd_cat_pp}'";
		///endif;
		
		$whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;
       
	    $uriSegment=4;
        
        //$totalRows=$this->model->getTotalRecordWhere($whereSql);
        $totalRows=$this->model->total_rows_where($table,$whereSql);
		
		$offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";
        
		
		
        //$arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        
		/*
		if (is_array($arrData)) {
			foreach($arrData as $k=>$v) {
				$arrData[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,3);
				$arrData[$k]['news_clip2']=substr($v['clip'],0,100)."...";
			}
		}
		*/
		
		$config['base_url'] = $this->module."listview";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
        $data["arrData"]=$arrData;
		$this->_render_page($this->module."index",$data,true);
    }
	
    function indexxx(){
		
        $this->load->library('pagination');

        $queryString=rebuild_query_string();

        $field="name";

        $whereSql=get_where_from_searchbox($field);


        $filter="";

        $where="";

        $key 		=	($this->input->get_post('q'))?$this->input->get_post('q'):false;
		
        if($key) {
            $filter = $where."(title like '%".$key."%' or clip like '%".$key."%' )";
			$filter .= " and ";
            $data["key"]=$key;
            $where=" and ";
        }
		$filter .=" (category='3' and status='1')";
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
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';
        $this->pagination->initialize($config);
		$arrDB=$this->model->SearchRecordLimitWhere($filter,$perPage,$offset,$sortBy);
		$data["acc_active"]="kategori";
      	$data["arrData"]=$arrDB;
      	$data["user_name"]=$this->data['users']['user']['username'];
      	$data["module"]=$this->module;
        $data["breadcrumb"]=$this->breadcrumb;
        $data["active"]=$this->active;
        $data["home"]="Beranda";

        //pre($data);exit;
        $this->_render_page($this->module."index", $data,true);

    }

    function read($idx){

        $filter =   "category='3' and idx='".$idx."'";

        $arrDB  =   $this->model->GetRecordData($filter);
        $data["breadcrumb"]=$this->breadcrumb;
        $data["active"]=$this->active;
        $data["home"]="Beranda";
        $data['data']   =   $arrDB;

        $this->_render_page($this->module."read", $data,true);

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
