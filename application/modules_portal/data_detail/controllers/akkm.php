<?php defined('BASEPATH') OR exit('No direct script access allowed');

class akkm extends Public_Controller {

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

        $this->model    	=   new general_model("t_akkm");
		
        $this->active   =   "Detail";
        $this->breadcrumb = "Data";
		
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		
		//$this->sektor_color		=	$this->sektor_color();
    }

    function index($id){
		
		$id_enc			=	$id;
		$idx			=	decrypt($id);
		//debug();
		$arrData=$this->model->GetRecordData("idx=$idx");
		$data['prop']=$this->conn->GetOne("select nm_propinsi from m_propinsi where kd_propinsi=".$arrData['kd_propinsi']."");
		$data['kab']=$this->conn->GetOne("select nm_kabupaten from m_kabupaten where kd_wilayah=".$arrData['kd_kabupaten']."");
		$data['kec']=$this->conn->GetOne("select nm_kecamatan from m_kecamatan where kd_wilayah=".$arrData['kd_kecamatan']."");
		$data["data"]=$arrData;
		
        $this->_render_page($this->module."index", $data,true);

    }

	function list_data(){
		
		$this->load->library('pagination');  
		
		$table	=	"t_daftar_jkpp";   
        
		$sql	=	"
					select 
						a.*,
						b.uraian as sektor 
					from ".$table." a 
					left join 
						m_sektor b 
					on a.kd_sektor=b.kode
					";
		
        $table	=	"($sql) a";
		
		$queryString=rebuild_query_string(); 
		$data_type=$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        
        $col_text=$data["text"];
		$field=join(",",$col_text);
        $whereSql=get_where_from_searchbox($field);
		
		
        if($_GET['q']):
            $where[]	=	"( judul like '%".$_GET['q']."%' or clip like '%".$_GET['q']."%')";
        endif;
        
        if($_GET['tahun']):
			$where[]	=	" tahun='".$_GET['tahun']."'";
		else:
			$where[]	=	" tahun='".date('Y')."'";
        endif;
        
        if($_GET['sektor']):
            $where[]	=	" kd_sektor='".$_GET['sektor']."'";
        endif;
        
        if($_GET['konflik']):
            $where[]	=	" kd_konflik like '%".$_GET['konflik']."%'";
        endif;
        
        $whereSql="";
		
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
		
        $perPage=$_GET['pp']?$_GET['pp']:"10";
		
        $data["perPage"]=$perPage;
       	
		$uriSegment=4;	
		
        $totalRows=$this->model->getTotalRecordWhere($whereSql);
		
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";
		
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		
		$config['base_url'] = $this->module."list_data";
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
		$config['next_link'] = '&raquo;';
		$config['prev_link'] = '&laquo;';
        $this->pagination->initialize($config);
        $data["arrData"]=$arrData;
		
		$this->_render_page($this->module."list_data",$data,true);
		
	}
	
	public function sektor_color(){
	
		$criteria	=	"";
		$data		=	$this->model_sektor->ListAll($criteria);
		
		if(cek_array($data)):
			foreach($data as $k=>$v):
				$sektor_color[$v['kode']]	=	$v['color'];
			endforeach;
		endif;
		
		return $sektor_color;
	
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
