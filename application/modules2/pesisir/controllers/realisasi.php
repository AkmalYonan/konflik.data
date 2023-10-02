<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class realisasi extends Admin_Controller {
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
		$this->load->model("wikera_model");
        $this->model=new general_model("t_daftar_pppbm");
		$this->model_involved=new general_model("t_involved_pppbm");
		$this->model_file	=	new	general_model("t_file_pppbm");
		$this->model_sektor	=	new	general_model("m_sektor");
		$this->model_perda	=	new	general_model("t_perda_pppbm");
		$this->model_aturan	=	new	general_model("t_aturan_pppbm");
		$this->model_mitra	=	new	general_model("t_daftar_mitra_pppbm");
		
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Realisasi";
		$this->module_title="";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		
		//add
		$this->lookup_bnnp		=	lookup("m_org","kd_org","nama",false,"order by idx");
		$this->lookup_inst		=	lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
		$this->lookup_sektor	=	lookup("m_sektor","kode","uraian",false,"order by idx");
		$this->lookup_konflik	=	lookup("m_konflik	","kode","uraian",false,"order by idx");
		$this->lookup_kategori_perhutanan	=	lookup("m_kategori_perhutanan","kode","uraian",false,"order by idx");
		$this->init_lookup();
		//add
		$this->lookup_map_group	=	lookup("map_data_group","kd_group","ur_group",false,"order by order_num");
		$this->lookup_map_layer	=	lookup("map_data","kd_layer","ur_layer",false,"order by order_num");		
		
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
		
        if($this->input->get_post("q")):
            $where[]	=	"(".$whereSql.")";
        endif;
		
		$where[]="kode_tahapan in('T7','T8')";
		
		
		/*if($this->input->get_post("tahun")):
			if($this->input->get_post("tahun")=="All"):
				$where[]	=	" YEAR(tgl_kejadian)<='".date('Y')."'";
			else:
				$where[]	=	" YEAR(tgl_kejadian)='".$this->input->get_post("tahun")."'";
			endif;
		else:
			$where[]	=	" YEAR(tgl_kejadian)='".date('Y')."'";
		endif;*/
		
		if($this->input->get_post("tahun")):
			if($this->input->get_post("tahun")!="All"):
				$where[]	=	" YEAR(tgl_kejadian)='".$this->input->get_post("tahun")."'";
			endif;
        endif;
		
		if($this->input->get_post("jenis_wikera")):
			$where[]	=	" kode_jns_wikera='".$this->input->get_post("jenis_wikera")."'";
        endif;
		
		if($this->input->get_post("status_validasi")):
			$where[]	=	" status_validas_peta='".$this->input->get_post("status_validasi")."'";
        endif;
		
		/* <-- Admin Filter --> */
		
		if($this->user_prop):
			if($this->user_kab):
				$where[]	=	" kd_propinsi='".$this->user_prop."' and kd_kabupaten='".$this->user_prop.$this->user_kab."' "; //Jika Admin Adalah Admin/User Tingkat Kabupaten
			else:
				$where[]	=	" kd_propinsi='".$this->user_prop."' "; //Jika Admin Adalah Admin/User Tingkat Propinsi
			endif;
		else:
			if($this->input->get_post("propinsi")):
				if($this->input->get_post("kabupaten")):
					$where[]	=	" kd_propinsi='".$this->input->get_post("propinsi")."' and kd_kabupaten='".$this->input->get_post("kabupaten")."' ";
				else:
					$where[]	=	" kd_propinsi='".$this->input->get_post("propinsi")."'";
				endif;
			endif;
		endif;
		
		/* <-- End Of Admin Filter --> */
        
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

		$this->_render_page($this->module."v_list",$data,true);
	 }
	 public function get_export_template(){
	 	// debug();
		$var				=	get_post();
		// $tahun				=	$var['tahun']?$var['tahun']:date('Y');
		$key				=	$var['q']?$var['q']:false;
		
		$filter				=	array();

		$table="t_daftar_pppbm";   
		
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
		
		// if($tahun):
		// 	if($tahun=="All"):
		// 		$filter_table[]	=	"tahun <= '".date('Y')."'";
		// 	else:
		// 		$filter_table[]	=	"tahun = '".$tahun."'";
		// 	endif;
		$sorting=" order by {$this->tbl_sort}";
		// endif;
		$filter_table[]	=	"( kode_tahapan in('T7','T8'))";
		if(cek_array($filter_table)):
			$filter			=	join(" and ",$filter_table);
		endif;
		
		$arrData			=	$this->adodbx->search_record_where($table,$filter,$sorting);
	
		// $header['tahun']	=	$tahun;
		//$header['bidang']	=	'GARDA BANGSA';
		//$header['propinsi']	=	$this->data_propinsi[$kd_propinsi];
		
		$data['header']		=	$header;
		$data['data']		=	$arrData;
		
		
		echo $this->load->view($this->module."v_export_template_xls",$data,true);
		
	}
	 
	 function add(){
	
	 	$this->msg_ok	=	"Data Telah Tesimpan.";
        $this->msg_fail	=	"Penambahan Data Gagal!";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $this->_render_page($this->module."v_add",$data,true);
        endif;
		
        if($act=="create"):
			
			$data=get_post();
			$data=$this->_add_creator($data);
			$data['tgl_kejadian']	=	$data['tgl_input'];
			
			$id_last = $this->model->GetLastID()+1;
			
			$data['idx']	=	$id_last;
			$checkbox=$_POST['aturan_pengelolaan'];
			$chk="";  
			foreach($checkbox as $chk1)  
			{  
				$chk .= $chk1.", ";  
			}
			$data['aturan_pengelolaan']=$chk;
			
			//$data['luas'] 		=	str_replace(",",".",str_replace(".","",$data['luas']));
			
			$this->conn->StartTrans();
			$this->model->InsertData($data);
			
			if($_FILES['file_peta']['name']!=''){
				//start geojson
				$this->load->helper(array('geophp','file'));
				check_folder($this->config->item("dir_geojson"));
				$datafile_peta=$_FILES['file_peta']['name'];
				$config['allowed_types']="*";
				$config['upload_path']=$this->config->item("dir_geojson");
				$config['max_size']="500000";
				$config['overwrite']=TRUE;
				//$config["file_name"]=$data["category"]."_".date("Ymd_His");
			
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('file_peta')):
					$error = $this->upload->display_errors();
					$this->msg_ok.=	"<p style='color:#ff0000'><i class='fa fa-warning'></i>Periksa Ukuran file atau tipe file!</p>";
				else:
					$uploaded_file=$this->upload->data();
				endif;
				$json=file_get_contents($uploaded_file['full_path']);
				
				$id_last = $this->model->GetLastID();
				if ($id_last) {
					$sql = "UPDATE t_daftar_pppbm SET the_geom='".$json."', file_peta='".$datafile_peta."' WHERE idx='".$id_last."'";
					
					$result = $this->conn->query($sql);
				}
			}
			//end geojson
			
			for ($i=0; $i<count($data['no_sk']); $i++){
				$maxSize="5000000";
				$target_path = $this->config->item("dir_lampiran_wikera"); //Declaring Path for uploaded images
				$validextensions = array("jpeg", "jpg", "JPEG", "JPG","doc","docx","xls","xlsx","pdf","PDF"); 
				$ext = explode('.', basename($_FILES['lampiran']['name'][$i]));
				$file_extension = end($ext);
				$fix_path = $target_path . date('s').time().str_replace(' ', '', $_FILES['lampiran']['name'][$i]) . "." . $ext[count($ext) - 1];//set the target path with a new name of image
				if (($_FILES["lampiran"]["size"][$i] < $maxSize) && in_array($file_extension, $validextensions)){
					if (move_uploaded_file($_FILES['lampiran']['tmp_name'][$i], $fix_path)) {//if file moved to uploads folder
						unset($dataInsert);
						$dataInsert["idx_parent"]	=	$id_last;
						$dataInsert["nomor"]		=	$data['no_sk'][$i];
						$dataInsert["tentang"]		=	$data['tentang'][$i];
						$dataInsert["tahun"]		=	$data['tahun'][$i];
						if($_FILES['lampiran']['name'][$i]){
							$dataInsert['lampiran']	=	date('s').time().str_replace(' ', '', $_FILES['lampiran']['name'][$i]) . "." . $ext[count($ext) - 1];
						}
						$this->model_perda->InsertData($dataInsert);
					} else {//if file was not moved.
						$dataInsert["idx_parent"]	=	$id_last;
						$dataInsert["nomor"]		=	$data['no_sk'][$i];
						$dataInsert["tentang"]		=	$data['tentang'][$i];
						$dataInsert["tahun"]		=	$data['tahun'][$i];
						$this->model_perda->InsertData($dataInsert);
						//$this->msg_ok				.=	"<p style='color:#ff0000'><i class='fa fa-warning'></i>Upload File Gagal Untuk Surat Keputusan ".$data['no_sk'][$i]."</p>";
					}
				} else {//if file size and file type was incorrect.
					$dataInsert["idx_parent"]	=	$id_last;
					$dataInsert["nomor"]		=	$data['no_sk'][$i];
					$dataInsert["tentang"]		=	$data['tentang'][$i];
					$dataInsert["tahun"]		=	$data['tahun'][$i];
					$this->model_perda->InsertData($dataInsert);
					//$this->msg_ok				.=	"<p style='color:#ff0000'><i class='fa fa-warning'></i>Upload File Gagal Untuk Surat Keputusan ".$data['no_sk'][$i]."</p>";
				}
			}
			
			/* <-- Insert Data Mitra --> */
			$this->insert_mitra($data,$id_last);
			/* <!-- End Of Insert Data Mitra --> */
			
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
            $arrData		=	$this->model->GetRecordData("idx=$id");          
            $arrFile		=	$this->model_file->ListAll("id_parent='".$id."'");
			$arrPerda		=	$this->model_perda->ListAll("idx_parent='".$id."'");
			$arrMitra		=	$this->model_mitra->GetRecordData("idx_parent='".$id."'");
			
			$arrData['geo']	=	$arrData['the_geom'];//file_get_contents($this->config->item("dir_geojson").$arrData['file_peta']);

			$data["data"]	=	$arrData;
			$data["file"]	=	$arrFile;
			$data["perda"]	=	$arrPerda;
			$data["mitra"]	=	$arrMitra;
			
			$this->_render_page($this->module."v_edit",$data,true);
        endif;
		
		if($act=="update"):
			$data=get_post();
			// debug();
			$data=$this->_add_editor($data);
			$data['tgl_kejadian']	=	$data['tgl_kejadian'];
			//$data['luas'] 			=	str_replace(",",".",str_replace(".","",$data['luas']));
			$this->conn->StartTrans();
			$this->model->UpdateData($data,"idx=$data[idx]");
			
			
			if($_FILES['file_peta']['name']!=''):
				//start geojson
				$this->load->helper(array('geophp','file'));
				check_folder($this->config->item("dir_geojson"));
				$datafile_peta=$_FILES['file_peta']['name'];
				$config['allowed_types']="*";
				$config['upload_path']=$this->config->item("dir_geojson");
				$config['max_size']="500000";
				$config['overwrite']=TRUE;
			
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('file_peta')):
					$error = $this->upload->display_errors();
				else:
					$uploaded_file=$this->upload->data();
				endif;
				$json=file_get_contents($uploaded_file['full_path']);
				$id_last=$data['idx'];
				if ($id_last):
					//$sql = "UPDATE t_daftar_pppbm SET the_geom=ST_GeomFromGeoJSON('".$json."',3), file_peta='".$datafile_peta."' WHERE idx='".$id_last."'";
					$sql = "UPDATE t_daftar_pppbm SET the_geom='".$json."', file_peta='".$datafile_peta."' WHERE idx='".$id_last."'";
					
					$result = $this->conn->query($sql);
				endif;
			endif;
			//end geojson

			// $id_last=$data[idx];
			
			$id_last	=	$data['idx'];
			
			for ($i=0; $i<count($data['no_sk']); $i++){
				
				$maxSize="5000000";
				$target_path = $this->config->item("dir_lampiran_wikera"); //Declaring Path for uploaded images
				$validextensions = array("jpeg", "jpg", "JPEG", "JPG","doc","docx","xls","xlsx","pdf","PDF"); 
				$ext = explode('.', basename($_FILES['lampiran']['name'][$i]));
				$file_extension = end($ext);
				$fix_path = $target_path . date('s').time().str_replace(' ', '', $_FILES['lampiran']['name'][$i]) . "." . $ext[count($ext) - 1];//set the target path with a new name of image
				if (($_FILES["lampiran"]["size"][$i] < $maxSize) && in_array($file_extension, $validextensions)){
					if (move_uploaded_file($_FILES['lampiran']['tmp_name'][$i], $fix_path)) {//if file moved to uploads folder
						
						unset($dataInsert);
						
						$dataInsert["idx_parent"]	=	$id_last;
						$dataInsert["nomor"]		=	$data['no_sk'][$i];
						$dataInsert["tentang"]		=	$data['tentang'][$i];
						$dataInsert["tahun"]		=	$data['tahun'][$i];
						
						if($_FILES['lampiran']['name'][$i]){
							$dataInsert['lampiran']	=	date('s').time().str_replace(' ', '', $_FILES['lampiran']['name'][$i]) . "." . $ext[count($ext) - 1];
						}
						
						$this->model_perda->InsertData($dataInsert);
						
					} else {//if file was not moved.
						
						$dataInsert["idx_parent"]	=	$id_last;
						$dataInsert["nomor"]		=	$data['no_sk'][$i];
						$dataInsert["tentang"]		=	$data['tentang'][$i];
						$dataInsert["tahun"]		=	$data['tahun'][$i];
						
						$this->model_perda->InsertData($dataInsert);
						
						//$this->msg_ok				.=	"<p style='color:#ff0000'><i class='fa fa-warning'></i>Upload File Gagal Untuk Surat Keputusan ".$data['no_sk'][$i]."</p>";
						
					}
				} else {//if file size and file type was incorrect.
					$dataInsert["idx_parent"]	=	$id_last;
					$dataInsert["nomor"]		=	$data['no_sk'][$i];
					$dataInsert["tentang"]		=	$data['tentang'][$i];
					$dataInsert["tahun"]		=	$data['tahun'][$i];
						
					$this->model_perda->InsertData($dataInsert);
					
					//$this->msg_ok				.=	"<p style='color:#ff0000'><i class='fa fa-warning'></i>Upload File Gagal Untuk Surat Keputusan ".$data['no_sk'][$i]."</p>";
				}
			}
			
			/* <-- Insert Data Mitra --> */
			$this->insert_mitra($data,$id_last);
			/* <!-- End Of Insert Data Mitra --> */
			
			/* <--File Upload Addition--> */
			$this->update_doc($id_last);
			/* <--End Of File Upload Addition--> */

			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module,$this->module);
        endif;     
	}
	
	function insert_mitra($arr_data,$id_parent){
		
		$criteria		=	"idx_parent='$id_parent'";
		
		$cek_data_mitra	=	$this->model_mitra->GetRecordData($criteria);
		
		/* Delete Data */
		if(cek_array($cek_data_mitra)):
			$this->model_mitra->DeleteData($criteria);
		endif;
		/* End Of Delete Data */
		
		$data_mitra['idx_parent']	=	$id_parent;
		$data_mitra['nama']			=	$arr_data['nama_mitra'];
		$data_mitra['email']		=	$arr_data['email_mitra'];
		$data_mitra['no_telepon']	=	$arr_data['no_telepon_mitra'];
		$data_mitra['alamat']		=	$arr_data['alamat_mitra'];
		
		$this->model_mitra->InsertData($data_mitra);
		
		
	}
	
	function spasial_view($id){
	 	if($this->encrypt_status==TRUE):
         	$id_enc=$id;
            $id=decrypt($id);
        endif;
	 	$data['id']=$id;
		
		$this->load->view($this->module."v_view_spasial",$data);
	}
	
	function view($id){
		$this->module_title="Detil TanahKita";
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData		=	$this->model->GetRecordData("idx=$id");
		
		$arrFile		=	$this->model_file->ListAll("id_parent='".$id."'");
		$arrPerda		=	$this->model_perda->ListAll("idx_parent='".$id."'");
		$arrMitra		=	$this->model_mitra->GetRecordData("idx_parent='".$id."'");
		
		$data['prop']	=	$this->conn->GetOne("select nm_propinsi from m_propinsi where kd_propinsi=".$arrData['kd_propinsi']."");
		$data['kab']	=	$this->conn->GetOne("select nm_kabupaten from m_kabupaten where kd_wilayah=".$arrData['kd_kabupaten']."");
		$data['kec']	=	$this->conn->GetOne("select nm_kecamatan as nama from m_kecamatan where kd_propinsi=".$arrData['kd_propinsi']." and kd_kabupaten=".substr($arrData['kd_kabupaten'],2,2)." and kd_kecamatan=".$arrData['kd_kecamatan']."");
		
		$data['sek']	=	$this->conn->GetOne("select uraian from m_sektor where kode='".$arrData['kd_sektor']."'");
		$arrData['geo']	=	$arrData['the_geom'];
		$data["data"]	=	$arrData;
		$data["file"]	=	$arrFile;
		$data["perda"]	=	$arrPerda;
		$data["mitra"]	=	$arrMitra;
		$data["tipe"]	=	"view";
		
       	$this->_render_page($this->module."v_view",$data,true); 
     }	
	
	function del($id){
  		//debug();
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
		
		$arrPerda	=	$this->model_perda->ListAll("idx_parent='$arrData[idx]'");
		
		if(cek_array($arrPerda)):
			foreach($arrPerda as $k=>$v):
				if($v['lampiran']):
					unlink($this->config->item("dir_lampiran_wikera").$v['lampiran']);
				endif;
			endforeach;
			$this->model_perda->DeleteData("idx_parent='$arrData[idx]'");
		endif;
		//exit;
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

	function get_kab_kota($kd_propinsi="",$arr_id=""){
		$sql="select * from m_kabupaten where kd_propinsi=$kd_propinsi and kd_kabupaten!='00'";
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
	
	function get_kabupaten(){
		
		$var	=	$_POST;
		
		$kd_propinsi	=	$var['kd_propinsi'];
		
		$arrKabKota		=	m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$kd_propinsi."' and kd_kabupaten!='00'");
		
		$data["dataKabupaten"]	=	$arrKabKota;
		
		echo $this->load->view($this->module."lookup_kabupaten",$data,true);
	
	}
	
	function get_kecamatan($kode="",$arr_id=""){
		
		$kode_propinsi	=	substr($kode,0,2);
		$kode_kabupaten	=	substr($kode,2,2);
		
		$sql	=	"select kd_kecamatan as kode_kecamatan, nm_kecamatan as nama_kecamatan from m_kecamatan where kd_propinsi=$kode_propinsi and kd_kabupaten=$kode_kabupaten order by kd_kecamatan";
		
		$arrKecamatan	=	$this->conn->GetAll($sql);
		
		$arrData=array();
		
		if(cek_array($arrKecamatan)):
			foreach($arrKecamatan as $x=>$val):
				$arrData[$val["kode_kecamatan"]]=$val["nama_kecamatan"];
			endforeach;
		endif;
		
		$data["dataKecamatan"]=$arrData;
		$data["arr_id"]=$arr_id;
		echo $this->load->view($this->module."lookup_kecamatan",$data,true);

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
	
	public function delete_sk(){
		
		$var		=	get_post();
		
		$idx		=	$var['idx'];

		$arrData	=	$this->model_perda->GetRecordData("idx='".$idx."'");
		
		if(cek_array($arrData['lampiran'])):
			unlink($this->config->item("dir_lampiran_wikera").$arrData['lampiran']);
		endif;
		
		$delete		=	$this->model_perda->DeleteData("idx='".$idx."'");
		
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
	
	public function data_sk(){
	
		$var		=	get_post();
		
		$idx		=	$var['idx'];
		
		$arrData	=	$this->model_perda->GetRecordData("idx='".$idx."'");
		
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
	
	public function ubah_sk(){
	
		$var		=	get_post();
		
		$idx		=	$var['idx'];
		
		$data		=	$var;
		
		$criteria	=	"idx='".$idx."'";
		
		$start		=	$this->conn->StartTrans();
			
			$this->model_perda->UpdateData($data,$criteria);
			
		$complete	=	$this->conn->CompleteTrans();
		
		if($complete):
			echo	1;
		else:
			echo	2;
		endif;
	
	}
	
	public function ubah_lampiran_sk(){
	
		$var		=	get_post();
		
		$idx		=	$var['idx'];
		
		$data		=	$var;
		
		$criteria	=	"idx='".$idx."'";
		
		$maxSize="5000000";
		$target_path = $this->config->item("dir_lampiran_wikera"); //Declaring Path for uploaded images
		$validextensions = array("jpeg", "jpg", "JPEG", "JPG","doc","docx","xls","xlsx","pdf","PDF"); 
		$ext = explode('.', basename($_FILES['file']['name']));
		$file_extension = end($ext);
		$fix_path = $target_path . date('s').time().str_replace(' ', '', $_FILES['file']['name']) . "." . $ext[count($ext) - 1];//set the target path with a new name of image
		if (($_FILES["file"]["size"] < $maxSize) && in_array($file_extension, $validextensions)){
			if (move_uploaded_file($_FILES['file']['tmp_name'], $fix_path)) {//if file moved to uploads folder
						
				if($_FILES['file']['name']){
					$dataUpdate['lampiran']	=	date('s').time().str_replace(' ', '', $_FILES['file']['name']) . "." . $ext[count($ext) - 1];
				}
						
				$this->model_perda->UpdateData($dataUpdate,$criteria);
				
				$data_lampiran	=	"<a href='".$this->config->item("dir_lampiran_wikera").$dataUpdate['lampiran']."' class='btn btn-warning btn-xs' target='_blank'>";
				$data_lampiran	.=	"<i class='fa fa-cloud-download'>&nbsp;</i>Lampiran</a>";
				
				$result['hasil']	=	1;
				$result['data']		=	$data_lampiran;
				
				echo json_encode($result);
				
			}else {//if file was not moved.
				
				$result['hasil']	=	2;
				$result['data']		=	"Error";
			
				echo json_encode($result);
				
			}
		}else{//if file size and file type was incorrect.
			
			$result['hasil']	=	2;
			$result['data']		=	"Error";
			
			echo json_encode($result);
			
		}
	
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
	
	function ExportCSV(){
		
		$var	=	get_post();
		
		$limit	=	$var['limit'];
		$offset	=	$var['offset'];
		
		$filter	=	"YEAR(tgl_kejadian)='".$var['tahun']."'";
		
		$and	=	" and ";
		
		if($var['key']):
			$table	=	"t_daftar_pppbm";
		
			$data_type=$this->adodbx->GetDataType($table);
			
			foreach($data_type as $x=>$val):
				if(($val=="C")||($val=="X")) $data["text"][]	=	$x." like '%".$var['key']."%'";
			endforeach;
        
			$arr_key	=	$data["text"];
		
			$key_query	=	join(" or ",$arr_key);

            $filter		.=	$and."(".$key_query.")";
		endif;
		
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
		
		$time			=	date("YmdHis");
		
        $delimiter		=	",";
        $newline		=	"\r\n";
        $filename		=	"data_usulan_".$time.".csv";
		
		$result			=	$this->wikera_model->export_csv($filter,$limit,$offset);
		
        $data 			=	$this->dbutil->csv_from_result($result, $delimiter, $newline);
		
        force_download($filename, $data);

	}
	
}
