<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class config extends Admin_Controller {
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
        
        $this->load->model("general_model");
        $this->model=new general_model("cms_config");
		// $this->model_detail=new general_model("tb_batas_propinsi_detail");
		// $this->model_file=new general_model("tb_peraturan_pembentukan_daerah_file");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->module_title="Configurasi";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
	 }
	 
	 function index($id=false){
	 	
	 	$this->listview();
	
	 }

	 function listview(){
	 	$this->load->library('pagination');  
        $table=$this->model->tbl;    
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
        
        $whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;
       
	    $uriSegment=4;
        
        $totalRows=$this->model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";
        
        //$arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        
		$config['base_url'] = $this->module."listview";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
        $data["arrData"]=$arrData;
        
        if(empty($arrData)):
        $this->_render_page($this->module."v_add",$data,true);
         
        elseif ($arrData):
        $arrData=$this->model->ListAll(false,"order by idx");
 		
        $data["data"]=$arrData;
       
        $this->_render_page($this->module."v_edit",$data,true);
        endif;
    }
	
	
	 function get_propinsi_name($id_propinsi){
	 	$arrPropinsi=isset($this->arr_propinsi)?$this->arr_propinsi:m_lookup("propinsi","kode_bps","nama");
		$this->arr_propinsi=$arrPropinsi;
		return $arrPropinsi[$id_propinsi];
	 }
	 
	 function get_map_jenis_peraturan(){
	 	return m_lookup("jenis_peraturan","id_jenis_peraturan","jenis_peraturan");
	 }
	 
	 function add(){
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new comment";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
            $this->_render_page($this->module."v_add",$data,true);
        endif;
   
        if($act=="create"):
			$data=get_post();
			$entitas=$data["title"];
			$entitas1=$data["alamat_kontak"];
			$entitas2=$data["facebook"];
			$entitas3=$data["google"];
			$entitas4=$data["twitter"];
			$entitas5=$data["no_telp"];
			$entitas6=$data["no_fax"];
			
			$data["title"]=$entitas;
			$data["alamat_kontak"]=$entitas1;
			$data["facebook"]=$entitas2;
			$data["google"]=$entitas3;
			$data["twitter"]=$entitas4;
			$data["no_telp"]=$entitas5;
			$data["no_fax"]=$entitas6;
			

			$this->conn->StartTrans();
			$this->model->InsertData($data);
			//$id_last=$this->model->GetLastID("idx");
			$ok=$this->conn->CompleteTrans();
		
            $this->_proses_message($ok,$this->module."listview/",$this->module."add/");
        endif;
    }
	
    
    function edit($id=false){
    	//echo $id;exit;
    	if($this->encrypt_status==TRUE):
    	$id_enc=$id;
    	$id=decrypt($id);
    	endif;
    	
		$this->msg_ok="Data update successfully";
        $this->msg_fail="Unable to update data";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
            $this->_render_page($this->module."v_add",$data,true);
        endif;
   
        if($act=="update"):
			$data=get_post();
			$entitas=$data["title"];
			$entitas1=$data["alamat_kontak"];
			$entitas2=$data["fb"];
			$entitas3=$data["google"];
			$entitas4=$data["twitter"];
			$entitas5=$data["no_telp"];
			$entitas6=$data["no_fax"];
		
			$data["title"]=$entitas;
			$data["alamat_kontak"]=$entitas1;
			$data["fb"]=$entitas2;
			$data["google"]=$entitas3;
			$data["twitter"]=$entitas4;
			$data["no_telp"]=$entitas5;
			$data["no_fax"]=$entitas6;
				

			$this->conn->StartTrans();
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
        
		
        endif;
    }
    
    function del($id){
       if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
      
        $arrData=$this->model->GetRecordData("{$this->tbl_idx}=$id");
        $act="delete";    
        if($act=="delete"):
            $this->conn->StartTrans();
                $this->model->DeleteData("{$this->tbl_idx}=$id");
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."listview",$this->module."view/$id_enc");
        endif;
    }
	
	
	function get_kab_kota($kd_bps_propinsi="",$arr_id=""){
		$sql="select * from m_kabupaten_kota where kode_prop=$kd_bps_propinsi and kode_kab!='00' order by kode_bps";
		$arrKabKota=$this->conn->GetAll($sql);
		$arrData=array();
		if(cek_array($arrKabKota)):
			foreach($arrKabKota as $x=>$val):
				$arrData[$val["kode_bps"]]=$val["nama"];
			endforeach;
		endif;
		$data["dataKabupaten"]=$arrData;
		$data["arr_id"]=$arr_id;
		echo $this->load->view($this->module."lookup_kabupaten",$data,true);
	}
	
	function get_kab_kota_arr($kd_bps_propinsi="",$arr_id=""){
		$sql="select * from m_kabupaten_kota where kode_prop=$kd_bps_propinsi and kode_kab!='00' order by kode_bps";
		$arrKabKota=$this->conn->GetAll($sql);
		$arrData=array();
		if(cek_array($arrKabKota)):
			foreach($arrKabKota as $x=>$val):
				$arrData[$val["kode_bps"]]=$val["nama"];
			endforeach;
		endif;
		return $arrData;
	}
	
	
	function get_data_uu(){
		$sql="select * from tb_peraturan_pembentukan_daerah order by tahun_peraturan,no_peraturan";
		$arrDataAll=$this->conn->GetAll($sql);
		$arrData=array();
		
		if(cek_array($arrDataAll)):
			foreach($arrDataAll as $x=>$val):
				$arrData[$val["idx"]]=$val["no_peraturan"]." tentang ".$val["tentang"];
			endforeach;
		endif;
		
		return $arrData;
	}
	
	
	function update_uu($id_parent){
		$data=get_post();
		if(cek_var($data["dasar_id"])):
			$data_id_arr=preg_split("/\||\,/",$data["dasar_id"]);
			if(cek_array($data_id_arr)):
				$this->model_uu->DeleteData("id_parent=$id_parent");
				foreach($data_id_arr as $id_uu):
					$data_update=array();
					$data_update["id_parent"]=$id_parent;
					$data_update["id_peraturan"]=$id_uu;
					$this->model_uu->InsertData($data_update);
				endforeach;		
			endif;
		endif;
	}
	
	function update_file($id_parent){
        
		$file_arr=$this->input->post("upload_file_id");
		//$file_tipe_arr=$this->input->post("tipe_doc"); //if has tipe like foto , surat pendukung dll
        //$dasar_surat_arr=$this->input->post("dasar_surat"); //if has tipe like foto , surat pendukung dll
        if(!cek_array($file_arr)):
			return true;
		endif;
		
		/*
        foreach($file_arr as $x=>$val):
            $type_doc[$val]=$file_tipe_arr[$x];
            $dasar_surat[$val]=$dasar_surat_arr[$x];
        endforeach;
        */
		
        if(cek_array($file_arr)):
            $whereIn="idx in(".join(",",$file_arr).")";
            
            $arrFile=$this->adodbx->search_record_where("t_file_upload",$whereIn);
            if(cek_array($arrFile)):
                $this->model_file->DeleteData("id_parent=$id_parent");
                foreach($arrFile as $file):
                    $dataInsert=array();
                    $dataInsert["id_file"]=$file["idx"];
                    $dataInsert["tipe_doc"]="file";
					//$dataInsert["tipe_doc"]=$type_doc[$file["idx"]];
                    //$dataInsert["dasar_surat"]=$dasar_surat[$file["idx"]];
                    $dataInsert["id_parent"]=$id_parent;
                    $dataInsert["file_name"]=$file["file_name"];
                    $dataInsert["file_path"]=$file["relative_path"];
                    $dataInsert=$this->_add_creator($dataInsert);
                    $dataInsert["ip_address"]=$file["ip_client"];
                    if(empty($file["ip_client"])):
                        $dataInsert=$this->_add_ip_address($dataInsert);
                    endif;
                    //pre($dataInsert);
                    $this->model_file->InsertData($dataInsert);
                endforeach;
            endif;
        endif; 
        
    }
	
	function update_file_peta($id_parent){
        $file_arr=$this->input->post("peta_file_id");
        if(!cek_array($file_arr)):
			return true;
		endif;
		
        if(cek_array($file_arr)):
            $whereIn="idx in(".join(",",$file_arr).")";
            
            $arrFile=$this->adodbx->search_record_where("t_file_upload",$whereIn);
            if(cek_array($arrFile)):
                $this->model_file_peta->DeleteData("id_parent=$id_parent");
                foreach($arrFile as $file):
                    $dataInsert=array();
                    $dataInsert["id_file"]=$file["idx"];
                    $dataInsert["id_parent"]=$id_parent;
                    $dataInsert["file_name"]=$file["file_name"];
                    $dataInsert["file_path"]=$file["relative_path"];
                    $dataInsert["tipe_doc"]="peta";
                    
					$dataInsert=$this->_add_creator($dataInsert);
                    $dataInsert["ip_address"]=$file["ip_client"];
                    if(empty($file["ip_client"])):
                        $dataInsert=$this->_add_ip_address($dataInsert);
                    endif;
                    //pre($dataInsert);
                    $this->model_file_peta->InsertData($dataInsert);
                endforeach;
            endif;
        endif; 
        
    }
	
	
	function update_data_detail($id_parent){
        $this->model_detail->DeleteData("id_parent=$id_parent");
        //$data=$this->input->post("daerah_penugasan");
        $data=get_post();
		$id_propinsi_1=$data["id_propinsi_1"];
		$id_propinsi_2=$data["id_propinsi_2"];
		$arrPropinsi1_kab=$this->get_kab_kota_arr($id_propinsi_1);
		$arrPropinsi2_kab=$this->get_kab_kota_arr($id_propinsi_2);
		$id_peraturan=$data["id_jenis_peraturan"]."_".$data["no_peraturan"]."_".$data["tahun_peraturan"];
		$no_sk=ucwords($data["id_jenis_peraturan"])." No.".$data["no_peraturan"]." Tahun ".$data["tahun_peraturan"];
		
		if(cek_array($data["id_kabupaten_1"])):
			foreach($data["id_kabupaten_1"] as $x=>$val):
					$data_detail_tmp=array();
					$data_detail_tmp["id_parent"]=$id_parent;
					$data_detail_tmp["id_peraturan"]=$id_peraturan;
					$data_detail_tmp["id_propinsi_1"]=$id_propinsi_1;
					$data_detail_tmp["id_propinsi_2"]=$id_propinsi_2;
					$data_detail_tmp["id_kabupaten_1"]=$val;
					$data_detail_tmp["id_kabupaten_2"]=$data["id_kabupaten_2"][$x];
					$data_detail_tmp["kabupaten_1"]=$arrPropinsi1_kab[$val];
					$data_detail_tmp["kabupaten_2"]=$arrPropinsi2_kab[$data["id_kabupaten_2"][$x]];
					//$data_detail[]=$data_detail_tmp;
					$this->model_detail->InsertData($data_detail_tmp);
			endforeach;
		endif;
		
	}
	
	
	 function view($id){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData=$this->model->GetRecordData("idx=$id");
		//$arrDataFile=$this->model_file->SearchRecordWhere("id_parent=$id");
		
        $data["data"]=$arrData;
		//$data["data_file"]=$arrDataFile;
       	$this->_render_page($this->module."v_view_2",$data,true);
        
     }
	 
	 
	 function list_uu(){
	 	$data["arrData"]=$this->adodbx->search_record("tb_peraturan_pembentukan_daerah");
		$this->load->view($this->module."list_uu",$data);
	 }
	 
	 
	 function lookup_uu(){
	 	 $this->load->library('pagination');  
        $queryString=rebuild_query_string();
       
	    $table="tb_peraturan_pembentukan_daerah";
      
        $data_type=$this->adodbx->GetDataType($table);
		
        foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
		
        $col_text=cek_var($data["text"])?$data["text"]:"";
        $field=join(",",$col_text);
        //$field="jenis_pelanggaran";
        $whereSql=get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"25";
        $data["perPage"]=$perPage;
       
        $uriSegment=4;
        //$table=$this->model->tbl;
       
        $totalRows=count($this->adodbx->search_record_where($table,$whereSql));
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sort=$this->input->get_post("sort")?$this->input->get_post("sort"):"idx";
        if(!empty($sort)):
            $sortBy=" order by {$sort}";
        endif;
        
        $arrData=$this->adodbx->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        
        $config['base_url'] = $this->module."lookup_uu";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        //$config['display_pages'] = FALSE;
        $this->pagination->initialize($config);
        
        $data["arrData"]=$arrData;
        
        $this->load->view($this->module."v_lookup_uu",$data);
    }
	
	function delete_peta_file($id=false){
	 	$this->conn->StartTrans();
		$this->model_file_peta->DeleteData("id_file=$id");
		$ok=$this->conn->CompleteTrans();
		if($ok):
			$this->delete_file($id);
		else:
			print "failed";
		endif;
	 }
	 
	 function delete_upload_file($id=false){
	 	$this->conn->StartTrans();
		$this->model_file->DeleteData("id_file=$id");
		$ok=$this->conn->CompleteTrans();
		if($ok):
			$this->delete_file($id);
		else:
			print "failed";
		endif;
	 }
	 
	 function delete_file($id=false){
	 	if(!$id):
			print "failed";
			exit();
		endif;
	 	$file=$this->conn->GetRow("select * from t_file_upload where idx=$id");
	 	$ok=$this->conn->Execute("delete from t_file_upload where idx=$id");
		if($ok):
			if(is_file('./' . $file["relative_path"]))
			unlink('./' . $file["relative_path"]);
			if(is_file('./' . $file["relative_path_view"]))
			unlink('./' . $file["relative_path_view"]);
			if(is_file('./' . $file["relative_path_thumb"]))
			unlink('./' . $file["relative_path_thumb"]);
			print "ok";
		else:
			print "failed";
		endif;
	 }

}