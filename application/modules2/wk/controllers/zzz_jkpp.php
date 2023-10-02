<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class target extends Admin_Controller {
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
		$this->model_konflik=	new	general_model("m_konflik");
		$this->model_kontak	=	new	general_model("t_kontak_konflik");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="DATA KONFLIK";
		$this->module_title="KONFLIK LAHAN";
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
		
        $sql	=	" 
						select 
							a.*,
							b.uraian as sektor,
							c.nm_propinsi as nm_propinsi,
							d.nm_kabupaten as nm_kabupaten
						from 
							".$table." a 
						left join 
							m_sektor b 
						on 
							a.kd_sektor=b.kode
						left join
							m_propinsi c
						on 
							a.kd_propinsi=c.kd_propinsi
						left join
							m_kabupaten d
						on
							a.kd_kabupaten=d.kd_wilayah
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
		
		/* <-- Admin Filter --> */
		
		if($this->user_prop):
			if($this->user_kab):
				$where[]	=	" kd_propinsi='".$this->user_prop."' and kd_kabupaten='".$this->user_prop.$this->user_kab."' "; //Jika Admin Adalah Admin/User Tingkat Kabupaten
			else:
				$where[]	=	" kd_propinsi='".$this->user_prop."' "; //Jika Admin Adalah Admin/User Tingkat Propinsi
			endif;
		else:
			if($this->input->get_post("propinsi") && $this->input->get_post("kabupaten")):
				$where[]	=	" kd_propinsi='".$this->input->get_post("propinsi")."' and kd_kabupaten='".$this->input->get_post("kabupaten")."' ";
			elseif($this->input->get_post("propinsi")):
				$where[]	=	" kd_propinsi='".$this->input->get_post("propinsi")."'";
			endif;
		endif;
		
		/* <-- End Of Admin Filter --> */
		
        if($this->input->get_post("q")):
            $where[]	=	"(".$whereSql.")";
        endif;
        
        if($this->input->get_post("tahun")):
			if($this->input->get_post("tahun")=="All"):
				$where[]	=	"";
			else:
				$where[]	=	" YEAR(tgl_kejadian)='".$this->input->get_post("tahun")."'";
			endif;
		else:
			$where[]	=	" YEAR(tgl_kejadian)='".date('Y')."'";
        endif;
        
        if($this->input->get_post("sektor")):
            $where[]	=	" kd_sektor='".$this->input->get_post("sektor")."'";
        endif;
        
        if($this->input->get_post("konflik")):
            $where[]	=	" kd_konflik like '%".$this->input->get_post("konflik")."%'";
        endif;
		
		if($this->input->get_post("status")):
            $where[]	=	" status_konflik='".$this->input->get_post("status")."'";
        endif;
		
		if($this->input->get_post("sifat")):
            $where[]	=	" sifat='".$this->input->get_post("sifat")."'";
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
		$sortBy=" order by tgl_kejadian desc, idx desc";
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

			//Edit File Test
			$data['kd_konflik'] = 	implode(",", $data['kd_konflik']);
			$data['tahun']		=	date_format(date_create($data['tgl_kejadian']),"Y");
			//$data['investasi']	=	str_replace(",",".",str_replace(".","",$data['investasi']));
			//$data['dampak'] 		=	str_replace(".","",$data['dampak']);
			//$data['luas'] 		=	str_replace(",",".",str_replace(".","",$data['luas']));
			//End Of Edit File
			
			$this->conn->StartTrans();
			
			$this->model->InsertData($data);
			$id_last=$this->model->GetLastID("idx");
			$data['idx_konflik']=$id_last;
			$this->model_kontak->InsertData($data);
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
			$arrDataKontak=$this->model_kontak->GetRecordData("idx_konflik=$id");
			$arr=$this->conn->GetAll("select * from m_konflik where sektor_id='".$arrData['kd_sektor']."'");
			// $arr=explode(",",$arr[0]['konflik']);
			if(cek_array($arr)):
				foreach($arr as $v):
					$arrData["dataKonflik"][$v['uraian']]=$v['uraian'];
				endforeach;
			endif;	
            $arrFile	=	$this->model_file->ListAll("id_parent='".$id."'");
			$data['att1']=$this->jkpp_model->gov($arrData['idx'],1);
			$data['att2']=$this->jkpp_model->pt($arrData['idx'],2);
			$data['att3']=$this->jkpp_model->comm($arrData['idx'],3);
			$data["data"]=$arrData;
			$data["dataKontak"]=$arrDataKontak;
			$data["file"]=$arrFile;
			$this->_render_page($this->module."v_edit",$data,true);
        endif;
		
		if($act=="update"):
			$data=get_post();
			$data=$this->_add_editor($data);
			
			//Edit File Test
			$data['kd_konflik'] = implode(",", $data['kd_konflik']);
			$data['tahun']		=	date_format(date_create($data['tgl_kejadian']),"Y");
			//$data['investasi']	=	str_replace(",",".",str_replace(".","",$data['investasi']));
			//$data['dampak'] 	=	str_replace(".","",$data['dampak']);
			//$data['luas'] 		=	str_replace(",",".",str_replace(".","",$data['luas']));
			//End Of Edit File Test
			$this->conn->StartTrans();
			$this->model->UpdateData($data,"idx=$data[idx]");
			$id_last=$data[idx];
			$exist=$this->model_kontak->GetRecordData("idx_konflik=$data[idx]");  
			if(count($exist)!=0){
				$dataKontak['nama_kontak']=$data['nama_kontak'];
				$dataKontak['email_kontak']=$data['email_kontak'];
				$dataKontak['alamat_kontak']=$data['alamat_kontak'];
				$dataKontak['telpon_kontak']=$data['telpon_kontak'];
				$this->model_kontak->UpdateData($dataKontak,"idx_konflik=$data[idx]");
			}else{
				$dataKontak['idx_konflik']=$data['idx'];
				$dataKontak['nama_kontak']=$data['nama_kontak'];
				$dataKontak['email_kontak']=$data['email_kontak'];
				$dataKontak['alamat_kontak']=$data['alamat_kontak'];
				$dataKontak['telpon_kontak']=$data['telpon_kontak'];
				$this->model_kontak->InsertData($dataKontak);
			}
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
		$this->module_title="Detil TanahKita ";
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData=$this->model->GetRecordData("idx=$id");
		$arrDataKontak=$this->model_kontak->GetRecordData("idx_konflik=$id");
			
		$arrFile	=	$this->model_file->ListAll("id_parent='".$id."'");
		$arrData2=$this->model_involved->GetRecordData("idx_parent=$id");
		$data['prop']=$this->conn->GetOne("select nm_propinsi from m_propinsi where kd_propinsi=".$arrData['kd_propinsi']."");
		$data['kab']=$this->conn->GetOne("select nm_kabupaten from m_kabupaten where kd_wilayah=".$arrData['kd_kabupaten']."");
		$data['sek']=$this->conn->GetOne("select uraian from m_sektor where kode='".$arrData['kd_sektor']."'");
		$data['att1']=$this->jkpp_model->gov($arrData['idx'],1);
		$data['att2']=$this->jkpp_model->pt($arrData['idx'],2);
		$data['att3']=$this->jkpp_model->comm($arrData['idx'],3);
		$data["data2"]=$arrData2;
		$data["data"]=$arrData;
		$data["file"]=$arrFile;
		$data["dataKontak"]=$arrDataKontak;
		// pre($data["dataKontak"]);exit;
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
		$this->model_kontak->DeleteData("idx_konflik=$arrData[idx]");
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
		$sql="select * from m_kabupaten where kd_propinsi=$kd_bps_propinsi and kd_kabupaten!='00' order by kd_wilayah";
		$arrKabKota=$this->conn->GetAll($sql);
		$arrData=array();
		if(cek_array($arrKabKota)):
			foreach($arrKabKota as $x=>$val):
				$arrData[$val["kd_wilayah"]]=$val["nm_kabupaten"];
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
	
	public function getKonflik(){
		
		$var		=	get_post();
		
		$kode_sektor=	$var['kode_sektor'];
		
		$criteria	=	"sektor_id='".$kode_sektor."'";
		
		$data		=	$this->model_konflik->ListAll($criteria);
		
		$data_select=	"<select name='konflik' class='form-control' id='konflik'>";
		
		if($kode_sektor):
			if(cek_array($data)):
				$data_select	.=	"<option value=''>Konflik</option>";
				foreach($data as $k=>$v):
					$data_select	.=	"<option value='".$v['kode']."' class='small-opt'>".$v['uraian']."</option>";
				endforeach;
			else:
				$data_select	.=	"<option value=''></option>";
			endif;
		else:
			$data_select	.=	"<option value=''>Konflik</option>";
			if(cek_array($this->lookup_konflik)):
				foreach($this->lookup_konflik as $k=>$v):
					$data_select	.=	"<option value='".$v."' class='small-opt'>".$v."</option>";
				endforeach;
			endif;
		endif;
		
		$data_select.=	"</select>";
		
		echo $data_select;
		
	}
	
	function get_kabupaten(){
		
		$var	=	$_POST;
		
		$kd_propinsi	=	$var['kd_propinsi'];
		
		$arrKabKota		=	m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$kd_propinsi."' and kd_kabupaten!='00'");
		
		$data_select	=	"<select name='kabupaten' class='form-control' id='kabupaten'>";
		
		if(cek_array($arrKabKota)):
			$data_select	.=	"<option value='' class='small-opt'></option>";
			foreach($arrKabKota as $k=>$v):
				$data_select	.=	"<option value='".$k."' class='small-opt'>".$v."</option>";
			endforeach;
		endif;
		
		$data_select	.=	"</select>";
		
		echo $data_select;
	
	}
	
}
