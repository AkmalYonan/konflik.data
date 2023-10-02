<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jkpp extends Admin_Controller {
	var $arr_category=array();   
    function __construct(){
        parent::__construct();       
        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
        $class_folder = basename(dirname(__DIR__)); 
		$class = __CLASS__; 
		$this->class=$class;
		$this->$class_folder=$class_folder;
		
		$this->load->helper(array('form', 'url','file'));
    	$this->folder=$class_folder."/"; 
        $this->module=$this->folder.$class."/";
        $this->http_ref=base_url().$this->module;
        
        $this->load->model("general_model");
		$this->load->model("jkpp_model");
        $this->model=new general_model("t_daftar_jkpp");
		$this->model_involved=new general_model("t_involved");
		$this->model_file	=	new	general_model("t_file_jkpp");
		$this->model_sektor	=	new	general_model("m_sektor");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="REGISTRASI";
		$this->module_title="DAFTAR JKPP";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		
		//add
		$this->lookup_bnnp		=	lookup("m_org","kd_org","nama",false,"order by idx");
		$this->lookup_inst		=	lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
		$this->lookup_sektor	=	lookup("m_sektor","kode","uraian",false,"order by idx");
		$this->lookup_konflik	=	lookup("m_konflik	","kode","uraian",false,"order by idx");
		$this->init_lookup();
		
		$this->sektor_color		=	$this->sektor_color();
		
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
		// debug();
	 	$this->load->library('pagination');  
		$table="t_daftar_jkpp";   
        $sql=" select a.*,b.uraian as sektor from ".$table." a 
               left join m_sektor b on a.kd_sektor=b.kode
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
		
		// if($this->user_prop):			
			// if($this->user_instansi):
				// if($this->user_instansi=="BL"):
					// $where[]	=	"jns_org='2'";
				// elseif($this->user_instansi=="KM"):
					// $where[]	=	"jns_org='4'";
				// elseif($this->user_instansi=="RD"):
					// $where[]	=	"jns_org='5'";
				// endif;
			// endif;			
			// $where[]	=	"substr(kd_bnn,1,5)='".$this->user_prop."-".$this->user_kab."'";	
		// endif;
		// $where[]	=	"active_pasien<>'1'";
		
        if($this->input->get_post("q")):
            $where[]	=	"(".$whereSql.")";
        endif;
        
        if($this->input->get_post("tahun")):
			$where[]	=	" tahun='".$this->input->get_post("tahun")."'";
		else:
			$where[]	=	" tahun='".date('Y')."'";
        endif;
        
        if($this->input->get_post("sektor")):
            $where[]	=	" kd_sektor='".$this->input->get_post("sektor")."'";
        endif;
        
        if($this->input->get_post("konflik")):
            $where[]	=	" kd_konflik like '%".$this->input->get_post("konflik")."%'";
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
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
		$config['base_url'] = $this->module."index";
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
        $data["arrData"]=$arrData;
		// exit;
		
		// $data["lookup_bnnp"]=lookup("m_org","kd_org","nama",false,"order by idx");	
		$this->_render_page($this->module."v_list",$data,true);
	 }
	 
	 function add(){
	 	$this->msg_ok="Data Telah Tesimpan.";
        $this->msg_fail="Penambahan Data Gagal!";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $this->_render_page($this->module."v_add",$data,true);
        endif;
		
        if($act=="create"):
			$data=get_post();
			
			$data=$this->_add_creator($data);	
			$data['kd_konflik'] = 	implode(",", $data['kd_konflik']);
			$investasi			=	explode(",",$data['investasi']);
			$data['investasi']	=	str_replace(".","",$investasi[0]);
			$data['dampak'] 	=	str_replace(".","",$data['dampak']);
			$data['luas'] 		=	str_replace(",",".",$data['luas']);
			
			$this->conn->StartTrans();
			
			$this->model->InsertData($data);
			$id_last=$this->model->GetLastID("idx");

			for ($i = 0; $i < count($data['keterangan']); $i++) {
				$dataInsert["idx_parent"]=$id_last;
				$dataInsert["uraian"]=$data['keterangan'][$i];
				$dataInsert["flag"]=1;
				$this->model_involved->InsertData($dataInsert);
			}
			for ($ii = 0; $ii < count($data['keterangan2']); $ii++) {
				$dataInsert["idx_parent"]=$id_last;
				$dataInsert["uraian"]=$data['keterangan2'][$ii];
				$dataInsert["flag"]=2;
				$this->model_involved->InsertData($dataInsert);
			}
			for ($iii = 0; $iii < count($data['keterangan3']); $iii++) {
				$dataInsert["idx_parent"]=$id_last;
				$dataInsert["uraian"]=$data['keterangan3'][$iii];
				$dataInsert["flag"]=3;
				$this->model_involved->InsertData($dataInsert);
			}
			
			/* <--File Upload Addition--> */
			$this->update_doc($id_last);
			/* <--End Of File Upload Addition--> */
			
			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module,$this->module);
        endif;
    }	
	
	function edit($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data Telah Tesimpan.";
        $this->msg_fail="Perubahan Data Gagal!";
       
        $act=$this->input->post("act")?$this->input->post("act"):"";    
		
        if(empty($act)):
            $arrData=$this->model->GetRecordData("idx=$id");          
            $arrFile	=	$this->model_file->ListAll("id_parent='".$id."'");
			$data['att1']=$this->jkpp_model->gov($arrData['idx'],1);
			$data['att2']=$this->jkpp_model->pt($arrData['idx'],2);
			$data['att3']=$this->jkpp_model->comm($arrData['idx'],3);
			$data["data"]=$arrData;
			$data["file"]=$arrFile;
			$this->_render_page($this->module."v_edit",$data,true);
        endif;
		
		if($act=="update"):
			$data=get_post();
			$data=$this->_add_editor($data);
			
			$data['kd_konflik'] = implode(",", $data['kd_konflik']);
			$investasi			=	explode(",",$data['investasi']);
			$data['investasi']	=	str_replace(".","",$investasi[0]);
			$data['dampak'] 	=	str_replace(".","",$data['dampak']);
			$data['luas'] 		=	str_replace(",",".",$data['luas']);

			$this->conn->StartTrans();
			$this->model->UpdateData($data,"idx=$data[idx]");
			$id_last=$data[idx];
			$this->model_involved->DeleteData("idx_parent=$data[idx]");
			
			for ($i = 0; $i < count($data['keterangan']); $i++) {
				$dataInsert["idx_parent"]=$id_last;
				$dataInsert["uraian"]=$data['keterangan'][$i];
				$dataInsert["flag"]=1;
				$this->model_involved->InsertData($dataInsert);
			}
			for ($ii = 0; $ii < count($data['keterangan2']); $ii++) {
				$dataInsert["idx_parent"]=$id_last;
				$dataInsert["uraian"]=$data['keterangan2'][$ii];
				$dataInsert["flag"]=2;
				$this->model_involved->InsertData($dataInsert);
			}
			for ($iii = 0; $iii < count($data['keterangan3']); $iii++) {
				$dataInsert["idx_parent"]=$id_last;
				$dataInsert["uraian"]=$data['keterangan3'][$iii];
				$dataInsert["flag"]=3;
				$this->model_involved->InsertData($dataInsert);
			}
			
			/* <--File Upload Addition--> */
			$this->update_doc($id_last);
			/* <--End Of File Upload Addition--> */
			
			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module,$this->module);
        endif;     
	}
	
	function view($id){
		$this->module_title="Detil JKPP";
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData=$this->model->GetRecordData("idx=$id");
		$arrFile	=	$this->model_file->ListAll("id_parent='".$id."'");
		$arrData2=$this->model_involved->GetRecordData("idx_parent=$id");
		$data['prop']=$this->conn->GetOne("select nama from m_propinsi2 where kode_bps=".$arrData['kd_propinsi']."");
		$data['kab']=$this->conn->GetOne("select nama from m_kabupaten_kota where kode_bps=".$arrData['kd_kabupaten']."");
		$data['sek']=$this->conn->GetOne("select uraian from m_sektor where kode='".$arrData['kd_sektor']."'");
		$data['att1']=$this->jkpp_model->gov($arrData['idx'],1);
		$data['att2']=$this->jkpp_model->pt($arrData['idx'],2);
		$data['att3']=$this->jkpp_model->comm($arrData['idx'],3);
		$data["data2"]=$arrData2;
		$data["data"]=$arrData;
		$data["file"]=$arrFile;
       	$this->_render_page($this->module."v_view",$data,true); 
     }	
	
	function del($id){
  		// debug();
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data Telah Berhasil Dihapus.";
        $this->msg_fail="Penghapusan Data Gagal!";

		$this->conn->StartTrans();
		$arrData=$this->model->GetRecordData("idx=$id");
		$this->model_involved->DeleteData("idx_parent=$arrData[idx]");
		$this->model->DeleteData("idx=$arrData[idx]");
		// exit;
		$ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module,$this->module);
	}
	
	
	function update_doc($id_parent){
        
		$file_arr			=	$this->input->post("upload_file_id");
        $id_jenis_doc_arr	=	$this->input->post("id_jenis_doc");
        $lampiran_name_arr	=	$this->input->post("lampiran_name");
        $lampiran_type_arr	=	$this->input->post("lampiran_type");
        
		if(!cek_array($file_arr)):
			return true;
		endif;
		
        foreach($file_arr as $x=>$val):
            $id_jenis_doc[$val]	=	$id_jenis_doc_arr[$x];
            $lampiran_name[$val]=	$lampiran_name_arr[$x];
            $lampiran_type[$val]=	$lampiran_type_arr[$x];
        endforeach;
        
        if(cek_array($file_arr)):
            $whereIn	=	"idx in(".join(",",$file_arr).")";
            $arrFile	=	$this->adodbx->search_record_where("t_file_upload",$whereIn);
            
            if(cek_array($arrFile)):
				$doc_list		=	$this->input->post("doc_list");
				$doc_list_arr	=	preg_split("/\,/",$doc_list);
				$doc_list_in	=	"'".join("','",$doc_list_arr)."'";
				
                //$this->model_file->DeleteData("id_parent=$id_parent and id_jenis_doc in (".$doc_list_in.")");
                
                foreach($arrFile as $file):
                    
                    $dataInsert	=	array();
					$dataInsert	=	$file;
					unset($dataInsert["idx"]);
					
                    $dataInsert["id_file"]			=	$file["idx"];
                    $dataInsert["tipe_doc"]			=	"file";
					$dataInsert["id_jenis_doc"]		=	$id_jenis_doc[$file["idx"]];
                    $dataInsert["id_parent"]		=	$id_parent;
                    $dataInsert["file_name"]		=	$file["file_name"];
                    $dataInsert["lampiran_name"]	=	$lampiran_name[$file["idx"]];
                    $dataInsert["lampiran_type"]	=	$lampiran_type[$file["idx"]];
                    $dataInsert["file_path"]		=	$file["relative_path"];
                    $dataInsert						=	$this->_add_creator($dataInsert);
                    $dataInsert["ip_address"]		=	$file["ip_client"];
                    
                    if(empty($file["ip_client"])):
                        $dataInsert				=	$this->_add_ip_address($dataInsert);
                    endif;
                    $this->model_file->InsertData($dataInsert);
                endforeach;
            endif;
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

		
	 
	function delete_file($id=false){
	 	$this->conn->StartTrans();
		$this->model_file_offline->DeleteData("id_file=$id");
		$ok=$this->conn->CompleteTrans();
		if($ok):
			$this->delete_file_proses($id);
		else:
			print "failed";
		endif;
	}
	
	function delete_file_proses($id=false){
	 	
	 	if(!$id):
			print "failed";
			exit();
		endif;
	 	
	 	$file	=	$this->conn->GetRow("select * from t_file_upload where idx=$id");
	 	$ok		=	$this->conn->Execute("delete from t_file_upload where idx=$id");
	 	
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
    
    public function delete_lampiran(){
		
		$var		=	get_post();
		
		$id			=	$var['idx'];

		$arrData	=	$this->model_file->GetRecordData("id='".$id."'");
		
		if(cek_array($arrData)):
			unlink($arrData['file_path']);
		endif;
		
		$delete		=	$this->model_file->DeleteData("id='".$id."'");
		
		if($delete):
			echo 1;
		else:
			echo 0;
		endif;
		
	}
	
	public function data_lampiran(){
	
		$var		=	get_post();
		
		$id			=	$var['id'];
		
		$arrData	=	$this->model_file->GetRecordData("id='".$id."'");
		
		echo json_encode($arrData);
	
	}
	
	public function ubah_lampiran(){
	
		$var		=	get_post();
		
		$id			=	$var['id'];
		
		$data		=	$var;
		
		$criteria	=	"id='".$id."'";
		
		$start		=	$this->conn->StartTrans();
			
			$this->model_file->UpdateData($data,$criteria);
			
		$complete	=	$this->conn->CompleteTrans();
		
		if($complete):
			echo	1;
		else:
			echo	2;
		endif;
	
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
	
}
