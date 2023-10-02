<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fas_ruang extends Admin_Controller {
	var $arr_category=array();   
    function __construct(){
        parent::__construct();       
        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
        $class_folder = basename(dirname(__DIR__)); //admin
		$class = __CLASS__; //dashboard
		$this->class=$class;
		$this->$class_folder=$class_folder;
		
		$this->load->helper(array('form', 'url','file'));
    	$this->folder=$class_folder."/"; //master_data/
        $this->module=$this->folder.$class."/";//master_data/uu_daerah/
        $this->http_ref=base_url().$this->module;///brwa/admin/dashboard/
        $this->load->model("sarpras_model_devel");
        $this->load->model("general_model");
		
		//Master Model
        $this->model=new general_model("m_fas_ruang");
		$this->model_dokter=new general_model("m_dokter");
		$this->model_perbid=new general_model("m_perbid");
		$this->model_tensos=new general_model("m_tensos");
		$this->model_penunjang=new general_model("m_penunjang_medis");
		$this->model_adm_umum=new general_model("m_adm_umum");
		$this->model_alat=new general_model("m_peralatan");
		//End
		
		//Transaction Model	
		$this->instansi_model=new general_model("t_sarpras_instansi");
		$this->fas_ruang_model=new general_model("t_sarpras_fas_ruang");
		$this->dokter_model=new general_model("t_sarpras_dokter");
		$this->perbid_model=new general_model("t_sarpras_perbid");
		$this->tensos_model=new general_model("t_sarpras_instansi");
		$this->penunjang_medis_model=new general_model("t_sarpras_penunjang_medis");
		$this->adm_umum_model=new general_model("t_sarpras_adm_umum");
		$this->peralatan_model=new general_model("t_sarpras_peralatan");
		//End
		
		//Additional Model
		$this->m_instansi_model=new general_model("m_instansi");
		//End
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Data";
		$this->module_title="Fasilitas Ruangan";
		$this->tbl_idx="idx";
		$this->tbl_idx_pasien="idx_pasien";
		$this->tbl_sort="idx desc";	
		$this->jenis_kegiatan_filter	=	"kategori='pg'";
		$this->init_lookup();
		
	 }
	 
	 function init_lookup(){
		$this->model_lookup=new general_model("m_lookup");
		$lookup_arr=$this->model_lookup->SearchRecordWhere("active=1","order by lookup_category,order_num");

		if(cek_array($lookup_arr)):
			foreach($lookup_arr as $x=>$val):
				$data_lookup[$val["lookup_category"]][$val["kd_lookup"]]=$val["ur_lookup"];
			endforeach;
		endif;
		$this->data_lookup=$data_lookup;
	 }
	 
	function index(){
	 	$this->list_instansi();
	 } 
	 
	 function list_instansi(){
	 
		$this->load->library('pagination');  

		$sql	=	"
					select
					a.*,
					b.nama_instansi,
					b.alamat,
					b.jenis_instansi			
					
					from ".$this->instansi_model->tbl." a
					
					left join ".$this->m_instansi_model->tbl." b
					on a.kd_org=b.kd_instansi
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
        
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
        
        if($this->user_prop):			
			if($this->user_instansi):
                $where[]    =   "jns_org='".$this->user_instansi."' and kd_org='".$this->user_org."'";
			endif;			
		endif;
		
        $whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;
       
	    $uriSegment=4;
        
        $totalRows=$this->instansi_model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";
		
		//debug();
		$arrData=$this->instansi_model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        //pre($arrData);exit;
		
		$config['base_url'] = $this->module."list_instansi";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
        $data["arrData"]=$arrData;
		$this->_render_page($this->module."v_list_instansi",$data,true);	  
	 
	 }
	 


	 function listview(){
		
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
		$data['act']="add";
		$arrData=$this->conn->GetAll("select * from m_fas_ruang limit 0,14");
		$arrData2=$this->conn->GetAll("select * from m_fas_ruang limit 15,30");
		$data["arrData"]=$arrData;		
		$data["arrData2"]=$arrData2;
		
		//pre($data);exit;
				
		$this->_render_page($this->module."v_list",$data,true);
		// debug();			
		$datax=get_post();
		
		//pre($datax);exit;
		
		$start=$this->conn->StartTrans();
        if($datax['act']=="add"):	
			if($datax['attr']=='dokter'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_dokter->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='fasruang'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='perbid'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_perbid->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='tensos'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_tensos->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='penunjang'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_penunjang->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='adm_umum'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['jumlah']=$datax['jumlah'][$i];
					$this->model_adm_umum->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}elseif($datax['attr']=='alat'){
				for($i=0;$i<=count($datax['idx']);$i++){
					$idx=$datax['idx'][$i];
					$data_update['status1']=$datax['status1'][$i];
					$data_update['status2']=$datax['status2'][$i];
					$this->model_alat->UpdateData($data_update,"idx=$idx");
					$complete=$this->conn->CompleteTrans();		
				}
			}
			
			// exit;
		$this->_proses_message($complete,$this->module."listview/",$this->module."listview/");	
        endif;	
		
    }
	
	function pasien_list(){
		
		$this->load->library('pagination'); 
		  
        $table			=	$this->model_pasien->tbl;
		$queryString	=	rebuild_query_string(); 
		$data_type		=	$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        
        $col_text		=	$data["text"];
		$field			=	join(",",$col_text);
        $whereSql		=	get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;		
		
		if($this->get_array_idx()):
			$where[]	=	" (idx not in (".$this->get_array_idx().") )";
		endif;
		
        $whereSql		=	"";
        if(cek_array($where)):
            $whereSql	.=	join(" and ",$where);
        endif;
        
		$perPage		=	$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        
		$data["perPage"]=	$perPage;
       
	    $uriSegment		=	4;
        
        $totalRows		=	$this->model_pasien->getTotalRecordWhere($whereSql);
        $offset			=	$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy			=	" order by {$this->tbl_sort}";
		
		$arrData		=	$this->model_pasien->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		
		$config['base_url'] 	=	$this->module."pasien_list";  
        $config['per_page'] 	=	$perPage;  
        $config['total_rows'] 	=	$totalRows;
        $config['uri_segment']	=	$uriSegment;
        $config["suffix"]		=	$queryString;
        $config["first_url"]	=	$config["base_url"].$queryString;
        
		$this->pagination->initialize($config);
        
		$data["arrData"]=$arrData;
	
		$this->_render_page($this->module."v_list_pasien",$data,true);
	}
	
	function attr($kode) {
		if($kode=='peralatan'):
			$data["data2"] = $this->sarpras_model_devel->attr_get2($kode);
		endif;
		$data["attr"]=$kode;
		$data["data"] = $this->sarpras_model_devel->attr_get($kode);
		$this->load->view("sarpras/fas_ruang/data/v_".$kode,$data,false);
	}	
	
	function add(){
		
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";
        
        $act=$this->input->post("act")?$this->input->post("act"):""; 
		   
        if(empty($act)):
			
			$arrFasRuang1				=	$this->conn->GetAll("select * from m_fas_ruang limit 0,15");
			$arrFasRuang2				=	$this->conn->GetAll("select * from m_fas_ruang limit 15,30");			
			$data_fas_ruang['arrData']	=	$arrFasRuang1;
			$data_fas_ruang['arrData2']	=	$arrFasRuang2;
			
			$data['v_fas_ruang']		=	$this->load->view($this->module."execute/v_fas_ruang",$data_fas_ruang,true);
			
			
			$dokter						=	$this->sarpras_model_devel->attr_get("dokter");			
			$data_dokter['dokter']		=	$dokter;
			$data['v_dokter']			=	$this->load->view($this->module."execute/v_dokter",$data_dokter,true);
			
			$perbid						=	$this->sarpras_model_devel->attr_get("perbid");			
			$data_perbid['perbid']		=	$perbid;
			$data['v_perbid']			=	$this->load->view($this->module."execute/v_perbid",$data_perbid,true);
			
			$tensos						=	$this->sarpras_model_devel->attr_get("tensos");			
			$data_tensos['tensos']		=	$tensos;
			$data['v_tensos']			=	$this->load->view($this->module."execute/v_tensos",$data_tensos,true);
			
			$penunjang_medis			=	$this->sarpras_model_devel->attr_get("penunjang_medis");			
			$data_penunjang_medis['penunjang_medis']=	$penunjang_medis;
			$data['v_penunjang_medis']	=	$this->load->view($this->module."execute/v_penunjang_medis",$data_penunjang_medis,true);
			
			$adm_umum					=	$this->sarpras_model_devel->attr_get("adm_umum");			
			$data_adm_umum['adm_umum']	=	$adm_umum;
			$data['v_adm_umum']			=	$this->load->view($this->module."execute/v_adm_umum",$data_adm_umum,true);
			
			$peralatan					=	$this->sarpras_model_devel->attr_get("peralatan");			
			$data_peralatan['peralatan']=	$peralatan;
			$data['v_peralatan']		=	$this->load->view($this->module."execute/v_peralatan",$data_peralatan,true);

			$data['kd_org_list']		=	$this->sarpras_model_devel->get_kd_org_list();
			
			$data['act']				=	"add";
			
			$this->parent_module_title	=	"Tambah";
			
            $this->_render_page($this->module."execute/v_main",$data,true);
			
        endif;
        //debug();
        if($act=="add"):
			
			$data						=	get_post();
			
			$list		=	array("fas_ruang","dokter","perbid","tensos","penunjang_medis","adm_umum","peralatan");
			
			$start		=	$this->conn->StartTrans();
			
			$data["jns_org"]	=	"BL";
			$this->instansi_model->InsertData($data);	
			
			foreach($list as $k=>$v):
				$total	=	count($data[$v."_kode"]);			
				for($i=0; $i<$total; $i++):
					$datax["kd_org"]	=	$data["kd_org"];
					$datax["jns_org"]	=	$data["jns_org"];
					$datax["kode"]		=	$data[$v."_kode"][$i];
					$datax["jumlah"]	=	$data[$v."_jumlah"][$i];
					
					if($v['peralatan']):
						$datax["status1"]	=	$data[$v."_status1"][$i];
						$datax["status2"]	=	$data[$v."_status2"][$i];
					endif;
					
					$this->sarpras_model_devel->attr_insert2($v,$datax);
					unset($datax);
				endfor;		
			endforeach;
			
			$complete	=	$this->conn->CompleteTrans();

			$this->_proses_message($complete,$this->module."list_instansi/",$this->module."add/");

        endif;
    }	
    
    function edit($kode){
  		
		if($this->encrypt_status==TRUE):
			$kode_enc=$kode;
			$kode=decrypt($kode);
		endif;
		
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
       
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        
		if(empty($act)):
			
			//debug();
			
			$arrFasRuang1				=	$this->conn->GetAll("select a.uraian,b.* from m_fas_ruang a left join t_sarpras_fas_ruang b on a.kode=b.kode where b.kd_org='$kode' limit 0,15");
			$arrFasRuang2				=	$this->conn->GetAll("select a.uraian,b.* from m_fas_ruang a left join t_sarpras_fas_ruang b on a.kode=b.kode where b.kd_org='$kode' limit 15,30");			
			$data_fas_ruang['arrData']	=	$arrFasRuang1;
			$data_fas_ruang['arrData2']	=	$arrFasRuang2;
			
			$data['v_fas_ruang']		=	$this->load->view($this->module."execute/v_fas_ruang",$data_fas_ruang,true);
			
			
			$dokter						=	$this->sarpras_model_devel->attr_get_edit("dokter",$kode);			
			$data_dokter['dokter']		=	$dokter;
			$data['v_dokter']			=	$this->load->view($this->module."execute/v_dokter",$data_dokter,true);
			
			$perbid						=	$this->sarpras_model_devel->attr_get_edit("perbid",$kode);			
			$data_perbid['perbid']		=	$perbid;
			$data['v_perbid']			=	$this->load->view($this->module."execute/v_perbid",$data_perbid,true);
			
			$tensos						=	$this->sarpras_model_devel->attr_get_edit("tensos",$kode);			
			$data_tensos['tensos']		=	$tensos;
			$data['v_tensos']			=	$this->load->view($this->module."execute/v_tensos",$data_tensos,true);
			
			$penunjang_medis			=	$this->sarpras_model_devel->attr_get_edit("penunjang_medis",$kode);			
			$data_penunjang_medis['penunjang_medis']=	$penunjang_medis;
			$data['v_penunjang_medis']	=	$this->load->view($this->module."execute/v_penunjang_medis",$data_penunjang_medis,true);
			
			$adm_umum					=	$this->sarpras_model_devel->attr_get_edit("adm_umum",$kode);			
			$data_adm_umum['adm_umum']	=	$adm_umum;
			$data['v_adm_umum']			=	$this->load->view($this->module."execute/v_adm_umum",$data_adm_umum,true);
			
			$peralatan					=	$this->sarpras_model_devel->attr_get_edit("peralatan",$kode);			
			$data_peralatan['peralatan']=	$peralatan;
			$data['v_peralatan']		=	$this->load->view($this->module."execute/v_peralatan",$data_peralatan,true);
			
			$data['act']				=	"edit";
			$data['kode_enc']			=	$kode_enc;
			$data['data']				=	$this->instansi_model->GetRecordData("kd_org='$kode'");
			
			$this->parent_module_title	=	"Ubah";
			//pre($data);exit;
			
            $this->_render_page($this->module."execute/v_main",$data,true);
			
        endif;
		
		if($act=="edit"):
			
			$data						=	get_post();
			
			$list		=	array("fas_ruang","dokter","perbid","tensos","penunjang_medis","adm_umum","peralatan");
			
			$start		=	$this->conn->StartTrans();
			
			$data["jns_org"]	=	"BL";
			
			$criteria	=	"kd_org='$kode'";
			$this->instansi_model->UpdateData($data,$criteria);	
			
			foreach($list as $k=>$v):
				$total	=	count($data[$v."_kode"]);			
				for($i=0; $i<$total; $i++):
					//$datax["kd_org"]	=	$data["kd_org"];
					//$datax["jns_org"]	=	$data["jns_org"];
					$datax["kode"]		=	$data[$v."_kode"][$i];
					$datax["jumlah"]	=	$data[$v."_jumlah"][$i];
					
					if($v['peralatan']):
						$datax["status1"]	=	$data[$v."_status1"][$i];
						$datax["status2"]	=	$data[$v."_status2"][$i];
					endif;
					
					$criteria_update	=	"kode='".$data[$v."_kode"][$i]."' and kd_org='$kode'";
					$this->sarpras_model_devel->attr_update2($v,$datax,$criteria_update);
					unset($datax);
					unset($criteria_update);
				endfor;		
			endforeach;	
			
			$complete	=	$this->conn->CompleteTrans();		
			
			$this->_proses_message($complete,$this->module."edit/".$kode_enc,$this->module."edit/".$kode_enc);
        endif;     
    }
    
    function del($kode){

		if($this->encrypt_status==TRUE):
			$kode_enc=$kode;
			$kode=decrypt($kode);
		endif;
        
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";   	
		
		$start		=	$this->conn->StartTrans();
		
		$criteria	=	"kd_org='$kode'";
		$this->instansi_model->DeleteData($criteria);	
		
		$list		=	array("fas_ruang","dokter","perbid","tensos","penunjang_medis","adm_umum","peralatan");
			
		foreach($list as $k=>$v):
			$this->sarpras_model_devel->attr_delete2($v,$criteria);	
		endforeach;	
		
		$complete	=	$this->conn->CompleteTrans();
		
		$this->_proses_message($complete,$this->module."list_instansi/",$this->module."list_instansi/");	  
    }
	
	function view($kode){
        
		if($this->encrypt_status==TRUE):
			$kode_enc=$kode;
			$kode=decrypt($kode);
		endif;
		
		$arrFasRuang1				=	$this->conn->GetAll("select a.uraian,b.* from m_fas_ruang a left join t_sarpras_fas_ruang b on a.kode=b.kode where b.kd_org='$kode' limit 0,15");
		$arrFasRuang2				=	$this->conn->GetAll("select a.uraian,b.* from m_fas_ruang a left join t_sarpras_fas_ruang b on a.kode=b.kode where b.kd_org='$kode' limit 15,30");			
		$data_fas_ruang['arrData']	=	$arrFasRuang1;
		$data_fas_ruang['arrData2']	=	$arrFasRuang2;
			
		$data['v_fas_ruang']		=	$this->load->view($this->module."execute/v_fas_ruang",$data_fas_ruang,true);
			
			
		$dokter						=	$this->sarpras_model_devel->attr_get_edit("dokter",$kode);			
		$data_dokter['dokter']		=	$dokter;
		$data['v_dokter']			=	$this->load->view($this->module."execute/v_dokter",$data_dokter,true);
			
		$perbid						=	$this->sarpras_model_devel->attr_get_edit("perbid",$kode);			
		$data_perbid['perbid']		=	$perbid;
		$data['v_perbid']			=	$this->load->view($this->module."execute/v_perbid",$data_perbid,true);
			
		$tensos						=	$this->sarpras_model_devel->attr_get_edit("tensos",$kode);			
		$data_tensos['tensos']		=	$tensos;
		$data['v_tensos']			=	$this->load->view($this->module."execute/v_tensos",$data_tensos,true);
			
		$penunjang_medis			=	$this->sarpras_model_devel->attr_get_edit("penunjang_medis",$kode);			
		$data_penunjang_medis['penunjang_medis']=	$penunjang_medis;
		$data['v_penunjang_medis']	=	$this->load->view($this->module."execute/v_penunjang_medis",$data_penunjang_medis,true);
			
		$adm_umum					=	$this->sarpras_model_devel->attr_get_edit("adm_umum",$kode);			
		$data_adm_umum['adm_umum']	=	$adm_umum;
		$data['v_adm_umum']			=	$this->load->view($this->module."execute/v_adm_umum",$data_adm_umum,true);
			
		$peralatan					=	$this->sarpras_model_devel->attr_get_edit("peralatan",$kode);			
		$data_peralatan['peralatan']=	$peralatan;
		$data['v_peralatan']		=	$this->load->view($this->module."execute/v_peralatan",$data_peralatan,true);
			
		$data['act']				=	"view";
		$data['kode_enc']			=	$kode_enc;
		$data['data']				=	$this->instansi_model->GetRecordData("kd_org='$kode'");
		
		$this->parent_module_title	=	"Detail";	
		//pre($data);exit;
			
        $this->_render_page($this->module."execute/v_main",$data,true);      
     }
	 
	 function get_array_idx(){
	 
	 	$sql			=	"select idx_pasien from ".$this->model->tbl;		
		$array			=	$this->conn->GetAll($sql);		
		foreach($array as $k=>$v):
			$arr[$k]	=	$v['idx_pasien'];
		endforeach;		
		$series			=	join(",",$arr);		
		return $series;
	 
	 }
}