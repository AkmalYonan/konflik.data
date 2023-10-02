<?php defined('BASEPATH') OR exit('No direct script access allowed');

class pesisir extends Public_Controller {

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
		$this->load->library(array("parser","Utils"));

        $this->main_layout="main_layout";
        $this->admin_layout="layout/main_layout";
		
		$this->load->model("data/jkpp_model");
		
        $this->load->model("general_model");

        $this->model    	=   new general_model("t_daftar_pppbm");
		$this->model_involved=new general_model("t_involved_pppbm");
		
		$this->model_file	=	new	general_model("t_file_pppbm");
		$this->model_sektor	=	new	general_model("m_sektor");
		$this->model_perda	=	new	general_model("t_perda_pppbm");
		$this->model_mitra	=	new	general_model("t_daftar_mitra_pppbm");
		
        $this->active   =   "Detail";
        $this->breadcrumb = "Data";
		
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		
		$this->lookup_inst		=	lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
		$this->lookup_sektor	=	lookup("m_sektor","kode","uraian",false,"order by idx");
		$this->lookup_konflik	=	lookup("m_konflik	","kode","uraian",false,"order by idx");
		
		$this->lookup_map_group	=	lookup("map_data_group","kd_group","ur_group",false,"order by order_num");
		$this->sektor_color		=	$this->sektor_color();
		
		$this->lookup_kategori_perhutanan	=	lookup("m_kategori_perhutanan","kode","uraian",false,"order by idx");
			$this->lookup_tahapan = lookup("m_tahapan","kode","uraian","status='1'"," order by idx");
    }

    function detil($id){
		
		$id_enc			=	$id;
		$idx			=	decrypt($id);
		//debug();
		$arrData=$this->model->GetRecordData("idx=$idx");
		//pre($arrData);
		
		$arrFile		=	$this->model_file->ListAll("id_parent='".$idx."'");
		$arrPerda		=	$this->model_perda->ListAll("idx_parent='".$idx."'");
		$arrMitra		=	$this->model_mitra->GetRecordData("idx_parent='".$idx."'");
		//pre($arrPerda);pre($arrMitra);
		$data['prop']=$this->conn->GetOne("select nm_propinsi from m_propinsi where kd_propinsi=".$arrData['kd_propinsi']."");
		$data['kab']=$this->conn->GetOne("select nm_kabupaten from m_kabupaten where kd_wilayah=".$arrData['kd_kabupaten']."");
		$data['kec']	=	$this->conn->GetOne("select nm_kecamatan as nama from m_kecamatan where kd_propinsi=".$arrData['kd_propinsi']." and kd_kabupaten=".substr($arrData['kd_kabupaten'],2,2)." and kd_kecamatan=".$arrData['kd_kecamatan']."");
		$data['sek']=$this->conn->GetOne("select uraian from m_sektor where kode='".$arrData['kd_sektor']."'");
		//$data['att1']=$this->jkpp_model->gov($arrData['idx'],1);
		//$data['att2']=$this->jkpp_model->pt($arrData['idx'],2);
		//$data['att3']=$this->jkpp_model->comm($arrData['idx'],3);
		$data["data"]=$arrData;
		$data["file"]=$arrFile;
		$data["perda"]=$arrPerda;
		$data["mitra"]=$arrMitra;
        $this->_render_page($this->module."index", $data,true);

    }
    


	function index(){
		$listMonth =	$this->utils->listMonth();
		$this->load->library('pagination');  
		
		$table	=	"t_daftar_pppbm";   
        
		$sql	=	"
				select 
					a.*,
					b.nm_propinsi,
					c.nm_kabupaten
				from 
					".$table." a 
				left join
					m_propinsi b
				on 
					a.kd_propinsi=b.kd_propinsi
				left join
					m_kabupaten c
				on
					a.kd_kabupaten=c.kd_wilayah
				";

		$table="($sql) a";
		
		$queryString=rebuild_query_string(); 
		$data_type=$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        
        $col_text=$data["text"];
		$field=join(",",$col_text);
        $whereSql=get_where_from_searchbox($field);
		
		$req 	= get_post();
		
        if($_GET['q']):
			//$where[]	=	"( judul like '%".$_GET['q']."%' or clip like '%".$_GET['q']."%')";
			$where[]	=	"(".$whereSql.")";
        endif;
        
		//Mode bulan=> 1: s/d bulan, 0 : pada bulan
		$mmode 	= ($req['mmode'])? $req['mmode']:(!isset($req['mmode'])?1:false);

		//$tahun 	= ($req['tahun'])? $req['tahun']:(isset($req['tahun'])?0:date("Y"));
		$tahun 	= ($req['tahun'])? $req['tahun']:date("Y");
		$tahun_awal = 1988;
		$tahun_akhir=($req['tahun'])? $req['tahun']:date("Y");
		$bulan=$req["bulan"]?$req["bulan"]:12;
		$tipe=$req["tipe"]?$req["tipe"]:1;
		if($tipe==1):
			$mmode=1;
		endif;
		
		if($bulan):
			$where[]= " month(tgl_kejadian) ".(($mmode)?"<=":"=")."'".$bulan."'";
		endif;
		
		if($tahun):
			if($tipe==1):
				$where[]=" year(tgl_kejadian)<=".$tahun;
				$tahun_data="Tahun ".$tahun_awal." - ".$tahun_akhir;	
			else:
				$where[]=" year(tgl_kejadian)=".$tahun;
				$tahun_data="Tahun ".$tahun_akhir;	
				if($mmode==1):
					$tahun_data="Tahun ".$tahun." s/d Bulan ".$strBulan;
				else:
					$tahun_data="Bulan ".$strBulan." Tahun ".$tahun;
				endif;
			endif;
		endif;
		
        /*if($_GET['tahun']):
			$where[]	=	" tahun='".$_GET['tahun']."'";
		else:
			$where[]	=	" tahun='".date('Y')."'";
        endif;*/
        
        ////if($req['sektor']):
        ////    $where[]	=	" kd_sektor='".$req['sektor']."'";
        ////endif;
        
        ////if($req['konflik']):
        ////    $where[]	=	" kd_konflik like '%".$req['konflik']."%'";
        ////endif;
		
		if($req['kd_prop']):
            $where[]	=	" kd_propinsi='".$req['kd_prop']."'";
		endif;
		
		if($this->input->get_post("jenis_wikera")):
			$where[]	=	" kode_jns_wikera='".$this->input->get_post("jenis_wikera")."'";
        endif;
		
		if($this->input->get_post("status_validasi")):
			$where[]	=	" status_validas_peta='".$this->input->get_post("status_validasi")."'";
		endif;
		
		if($this->input->get_post("kode_tahapan")):
			$where[]	=	" kode_tahapan='".$this->input->get_post("kode_tahapan")."'";
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
		
		$config['base_url'] = $this->module."index";
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
		//$config['next_link'] = '&raquo;';
		//$config['prev_link'] = '&laquo;';
        $this->pagination->initialize($config);
		
		//param
		$data["listMonth"] = $listMonth;
		$data["kd_propinsi"] 			= $kd_propinsi;
		$data["kd_kab"] 					= $kd_kab;
		$data["kd_org"] 					= $kd_org;
		$data["tipe_instansi"] 		= $kd_inst;
		$data["selected_tahun"] 	= $tahun;
		$data["selected_bulan"] 	= $bulan;
		$data['level']						= $level;
		
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
