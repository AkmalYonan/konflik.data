<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class verifikasi extends Admin_Controller {
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
        $this->load->model('pegawai_model');
		$this->load->model('verifikasi_model');
        $this->load->model("general_model");
        $this->model=new general_model("sppp_data_pegawai");
		$this->model_skpd=new general_model("m_skpd");
		$this->model_jenis_berkas=new general_model("m_jenis_berkas");
		$this->model_berkas=new general_model("berkas_sppp_data_pegawai");
		// $this->model_detail=new general_model("tb_batas_propinsi_detail");
		// $this->model_file=new general_model("tb_peraturan_pembentukan_daerah_file");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->module_title="Verifikasi";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
		$this->dagri_service=$this->config->item("dagri_service");	
		$this->ssl_email = $this->config->item("ssl_email");
		$this->ssl_pwd = $this->config->item("ssl_pwd");
		$this->ssl_from = $this->config->item("ssl_from");
	 }
	 
	 function index(){
		$this->listview();
	 }

	 function listview(){		
		$data['username'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["username"];
		$data['nama'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["first_name"];
		$data['level_user'] = $_SESSION[$this->lauth->appname]["groupdata"]["level_user"];
		$data['prov'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_propinsi"];
		$data['kabupaten'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_kabupaten"];
		$data['skpd'] = $_SESSION[$this->lauth->appname]["groupdata"]["skpd"];

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
        
        if($this->input->get_post("provinsi")):
			$where[]="propinsi like '%".$this->input->get_post("provinsi")."%'";
        endif;
		if($this->input->get_post("kabupaten")):
            $where[]="kabupaten like '%".$this->input->get_post("kabupaten")."%'";
        endif;
		if($this->input->get_post("skpd")):
            $where[]="skpd = '".$this->input->get_post("skpd")."'";
        endif;
		if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
        // pre($where);exit;
       if($data['prov'] == '' && $data['kabupaten'] == '' && $data['skpd'] == ''):
			$whereSql="tanggal_pengajuan != '0000-00-00'";
			if(cek_array($where)):
				$whereSql.=" and ".join(" and ",$where);
			endif;
		else:
			$whereSql="tanggal_pengajuan != '0000-00-00' AND propinsi like '%".$data['prov']."%' AND kabupaten like '%".$data['kabupaten']."%' AND skpd = '".$data['skpd']."' ";	
			if(cek_array($where)):
				$whereSql.=" and ".join(" and ",$where);
			endif;
		endif;
		
        // if(cek_array($where)):
            // $whereSql.=join(" and ",$where);
        // endif;

        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"10";
        $data["perPage"]=$perPage;
       
	    $uriSegment=4;
        
        $totalRows=$this->model->getTotalRecordWhere($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by {$this->tbl_sort}";
        
        //$arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        // debug();
		$config['base_url'] = $this->module."listview";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		$data['services_prov']=$this->dagri_service['server'];
		$data['m_skpd']=$this->model_skpd->ListAll($filter=false,$order=false);
		$data['query_brks'] = $this->verifikasi_model->m_berkas2(); 
        $data["arrData"]=$arrData;
		
		$this->_render_page($this->module."v_list",$data,true);
    }
	
	function view($id,$fg){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		// debug();
		$data['level_user'] = $_SESSION[$this->lauth->appname]["groupdata"]["level_user"];
		$data['group_brwa'] = $_SESSION[$this->lauth->appname]["userdata"]["user"]["group_brwa"];
		$data['prov'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_propinsi"];
		$data['kabupaten'] = $_SESSION[$this->lauth->appname]["groupdata"]["id_kabupaten"]; 
		$data['flag']=$fg;
		// pre($data);exit;
		
        $arrData=$this->model->GetRecordData("idx=$id");
		$data['services_prov']=$this->dagri_service['server'];
		$data['query_gol'] = $this->pegawai_model->get_golongan();
		$data['data_berkas']=$this->pegawai_model->getDoc($id);
		$data['getLog']=$this->pegawai_model->getLog($id,$fg);
		$data['m_jns_brks']=$this->model_jenis_berkas->ListAll($filter=false,$order=false);
        $data["data"]=$arrData;
		// pre($arrData['idx']);exit;
		if($data['flag'] == 'b'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($arrData['idx'],$flag='b');
		}elseif($data['flag'] == 'c'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($arrData['idx'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($arrData['idx'],$flag='c');
		}elseif($data['flag'] == 'd'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($arrData['idx'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($arrData['idx'],$flag='c');
			$data['getSTTb4'] = $this->verifikasi_model->getSTTb4($arrData['idx'],$flag='d');
		}elseif($data['flag'] == 'e'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($arrData['idx'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($arrData['idx'],$flag='c');
			$data['getSTTb4'] = $this->verifikasi_model->getSTTb4($arrData['idx'],$flag='d');
			$data['getSTTb5'] = $this->verifikasi_model->getSTTb5($arrData['idx'],$flag='e');
		}elseif($data['flag'] == 'f'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($arrData['idx'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($arrData['idx'],$flag='c');
			$data['getSTTb4'] = $this->verifikasi_model->getSTTb4($arrData['idx'],$flag='d');
			$data['getSTTb5'] = $this->verifikasi_model->getSTTb5($arrData['idx'],$flag='e');
			$data['getSTTb6'] = $this->verifikasi_model->getSTTb6($arrData['idx'],$flag='f');
		}elseif($data['flag'] == 'g'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($arrData['idx'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($arrData['idx'],$flag='c');
			$data['getSTTb4'] = $this->verifikasi_model->getSTTb4($arrData['idx'],$flag='d');
			$data['getSTTb5'] = $this->verifikasi_model->getSTTb5($arrData['idx'],$flag='e');
			$data['getSTTb6'] = $this->verifikasi_model->getSTTb6($arrData['idx'],$flag='f');
			$data['getSTTb7'] = $this->verifikasi_model->getSTTb7($arrData['idx'],$flag='g');
		}
		// pre($arrData);exit;
		$this->_render_page($this->module."side_right_pegawai_view",$data,true);
        
    }
	
	public function insert_dokumen_kumham( )
	{	
		// $data['path'] = $this->config->item('path');
		//pre($data['path']);exit;
		// if(isset($_POST['save']))
		// {
			$id = $this->input->post('id_pegawai');
			$fg = $this->input->post('flag');
			$tgl = $this->input->post('tanggal_sp');
			$tanggal_pecah 	= explode("/",$tgl);
			$tanggal_input 	= $tanggal_pecah[2]."-".$tanggal_pecah[1]."-".$tanggal_pecah[0];
			if($this->encrypt_status==TRUE):
				$id=$id;
				$id_enc=encrypt($id);
			endif;
				// $get = get_auto_increment("dokumen_sppp_data_pegawai","ppns");
				// $direktori = "$data[path]/assets/uploads/dokumen_sppp_data_pegawai/$get/";
				$direktori = "./uploads/dokumen_sppp_data_pegawai/";
				
				$config['upload_path'] = "$direktori";
				$config['allowed_types'] = 'gif|jpg|png|jpeg|doc|docx|xls|xlsx|pdf|rar|zip';
				$config['max_size']  = '1000000';
				$config['file_name']  = url_title($_FILES["file_name"]["name"]);
				
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('file_name'))
				{
					
					$request = array(
									'nip'=>$this->input->post('nip'),
									'dokumen'=>$this->upload->file_name,
									'no_sk_ppns'=>$this->input->post('no_sk_ppns'),
									'no_ktp'=>$this->input->post('no_ktp'),
									'idx_pegawai'=>$this->input->post('id_pegawai'),
									'no_surat'=>$this->input->post('ns'),
									'jenis_berkas'=>$this->input->post('berkas'),
									'flag'=>$this->input->post('flag'),
									'tanggal_sp'=>$tanggal_input
									// 'tanggal_post'=>$this->input->post('tanggal_post')
								);
					$this->conn->StartTrans();		
					$this->verifikasi_model->uploadDoc($request);
					$ok=$this->conn->CompleteTrans();
					$this->_proses_message($ok,$this->module."view/$id_enc/$fg",$this->module."view/$id_enc/$fg");
					// $msg = 'Data berhasil disiimpan.';
					// $this->session->set_flashdata('success', $msg);
					// redirect("verifikasi/berkas/$id/$fg");
				}
				else
				{
					$msg = $this->upload->display_errors();
					$this->session->set_flashdata('error', $msg);
					redirect("verifikasi/berkas/$id/$fg");
				} 
		// }
	}
	
	 public function delete_berkas_($id)
	{
		$fg=$this->uri->segment(5);
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		$direktori = "./uploads/berkas_ppns/";
		// debug();
		$getBerkas = $this->pegawai_model->getBerkas($id);
		foreach($getBerkas as $key){
			$berkas = $key['dokumen'];
			$id_pegawai = $key['idx_pegawai'];
			
			if($berkas != ''){
				unlink($direktori.$berkas);			
			}
		}
		
		if(isset($id)){
			$this->conn->StartTrans();
			$this->pegawai_model->doDelete_berkas($id);
			$ok=$this->conn->CompleteTrans();
			
			
		}
		$idp = encrypt($id_pegawai);
		$this->_proses_message($ok,$this->module."view/$idp/$fg",$this->module."view/$idp/$fg");
		// redirect("admin/pegawai/upload/$id_pegawai");
	}
	
	 public function delete_berkas($id)
	{
		$fg=$this->uri->segment(5);
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		$direktori = "./uploads/dokumen_sppp_data_pegawai/";
		// debug();
		$getBerkas = $this->verifikasi_model->getBerkas($id);
		foreach($getBerkas as $key){
			$berkas = $key['dokumen'];
			$id_pegawai = $key['idx_pegawai'];
			
			if($berkas != ''){
				unlink($direktori.$berkas);			
			}
		}
		
		if(isset($id)){
			$this->conn->StartTrans();
			$this->verifikasi_model->doDelete_berkas($id);
			$ok=$this->conn->CompleteTrans();
			
			
		}
		$idp = encrypt($id_pegawai);
		$this->_proses_message($ok,$this->module."view/$idp/$fg",$this->module."view/$idp/$fg");
		// redirect("admin/pegawai/upload/$id_pegawai");
	}
	
	public function insert_dokumen( )
	{	
		$id = $this->input->post('idx');
		$fg = $this->input->post('fg');
		if($this->encrypt_status==TRUE):
            $id=$id;
            $id_enc=encrypt($id);
        endif;
		
		$nip = $this->input->post('nip');
		// debug();
		$config['upload_path'] = "./uploads/berkas_ppns/";
		$config['allowed_types'] = 'gif|jpg|png|jpeg|dox|docx|xls|xlsx|pdf|rar|zip';
		$config['max_size']  = '1000000';
		$config['file_name']  = url_title($_FILES["file_name"]["name"]);
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_name'))
		{
			$request = array(
							'nip'=>$this->input->post('nip'),
							'dokumen'=>$this->upload->file_name,
							'nm_file'=>$this->input->post('nm_file'),
							'idx_pegawai'=>$this->input->post('idx')
						);
			$this->conn->StartTrans();
			$this->pegawai_model->uploadDoc($request);
			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."view/$id_enc/$fg",$this->module."view/$id_enc/$fg");
		}
		else
		{
			$this->_proses_message($ok,$this->module."view/$id_enc/$fg",$this->module."view/$id_enc/$fg");			
			// echo $this->upload->display_errors();exit;
			// set_message("success",$msg);
			// redirect("admin/pegawai/upload/$id");
		} 
	}
	
	public function berkas($id)
	{
		$data['flag'] = $this->uri->segment(4, 0);
		$sesi = $this->session->all_userdata();
			$data['username'] = $sesi['username'];
			$data['level_user'] = $sesi['level_user'];
			$data['prov'] = $sesi['provinsi'];
			$data['kabupaten'] = $sesi['kabupaten']; 
		$data['query'] = $this->verifikasi_model->doEdit($id);
		foreach($data['query'] as $row){
			$tgl = $row['tanggal_lahir'];
				$explode_tgl = explode("-", $tgl);
  				$thn = $explode_tgl[0]; 
  				$bln = $explode_tgl[1];
  				$Tgl = $explode_tgl[2];
  			$data['tanggal_lahir_selector'] = $Tgl."/".$bln."/".$thn;	
			$data['nip'] = $row['nip'];
			$data['nama'] = $row['nama'];
			$data['foto'] = $row['foto'];
			$data['provinsi'] = $row['propinsi'];
			$data['kabupaten'] = $row['kabupaten'];
			$data['status_pegawai'] = $row['status_pegawai'];
			$data['no_ktp'] = $row['no_ktp'];
			$data['no_sk_ppns'] = $row['no_sk_ppns'];
			$data['id_pegawai'] = $row['id_pegawai'];
		}
		$data['link'] = 'verifikasi_dokumen';	
		$data['query_prov'] = $this->global_model->get_provinsi(); 
		$data['query_kab'] = $this->global_model->get_kabupaten();
		$data['getDoc'] = $this->verifikasi_model->getDoc($data['id_pegawai'],$data['flag']);
		$data['query_cat'] = $this->user_model->m_kategori();
		$data['query_brks'] = $this->verifikasi_model->m_berkas(); 
		$data['countSTTb1'] = $this->verifikasi_model->countSTTb1($data['id_pegawai']);
		$data['countSTTb2'] = $this->verifikasi_model->countSTTb2($data['id_pegawai']);
		$data['countSTTb3'] = $this->verifikasi_model->countSTTb3($data['id_pegawai']);
		$data['countSTTb4'] = $this->verifikasi_model->countSTTb4($data['id_pegawai']);
		$data['countSTTb5'] = $this->verifikasi_model->countSTTb5($data['id_pegawai']);
		$data['countSTTb6'] = $this->verifikasi_model->countSTTb6($data['id_pegawai']);
		$data['countSTTb7'] = $this->verifikasi_model->countSTTb7($data['id_pegawai']);	
		$data['countA'] = $this->verifikasi_model->countFlag($data['id_pegawai'],'a');
			$data['a'] = $data['countA']->RecordCount();
		$data['countB'] = $this->verifikasi_model->countFlag($data['id_pegawai'],'b');
			$data['b'] = $data['countB']->RecordCount();
		$data['countC'] = $this->verifikasi_model->countFlag($data['id_pegawai'],'c');
			$data['c'] = $data['countC']->RecordCount();
		$data['countD'] = $this->verifikasi_model->countFlag($data['id_pegawai'],'d');
			$data['d'] = $data['countD']->RecordCount();
		$data['countE'] = $this->verifikasi_model->countFlag($data['id_pegawai'],'e');
			$data['e'] = $data['countE']->RecordCount();
		$data['countF'] = $this->verifikasi_model->countFlag($data['id_pegawai'],'f');
			$data['f'] = $data['countF']->RecordCount();
		$data['countG'] = $this->verifikasi_model->countFlag($data['id_pegawai'],'g');
			$data['g'] = $data['countG']->RecordCount();
		if($data['flag'] == 'b'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($data['id_pegawai'],$flag='b');
		}elseif($data['flag'] == 'c'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($data['id_pegawai'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($data['id_pegawai'],$flag='c');
		}elseif($data['flag'] == 'd'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($data['id_pegawai'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($data['id_pegawai'],$flag='c');
			$data['getSTTb4'] = $this->verifikasi_model->getSTTb4($data['id_pegawai'],$flag='d');
		}elseif($data['flag'] == 'e'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($data['id_pegawai'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($data['id_pegawai'],$flag='c');
			$data['getSTTb4'] = $this->verifikasi_model->getSTTb4($data['id_pegawai'],$flag='d');
			$data['getSTTb5'] = $this->verifikasi_model->getSTTb5($data['id_pegawai'],$flag='e');
		}elseif($data['flag'] == 'f'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($data['id_pegawai'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($data['id_pegawai'],$flag='c');
			$data['getSTTb4'] = $this->verifikasi_model->getSTTb4($data['id_pegawai'],$flag='d');
			$data['getSTTb5'] = $this->verifikasi_model->getSTTb5($data['id_pegawai'],$flag='e');
			$data['getSTTb6'] = $this->verifikasi_model->getSTTb6($data['id_pegawai'],$flag='f');
		}elseif($data['flag'] == 'g'){
			$data['getSTTb2'] = $this->verifikasi_model->getSTTb2($data['id_pegawai'],$flag='b');
			$data['getSTTb3'] = $this->verifikasi_model->getSTTb3($data['id_pegawai'],$flag='c');
			$data['getSTTb4'] = $this->verifikasi_model->getSTTb4($data['id_pegawai'],$flag='d');
			$data['getSTTb5'] = $this->verifikasi_model->getSTTb5($data['id_pegawai'],$flag='e');
			$data['getSTTb6'] = $this->verifikasi_model->getSTTb6($data['id_pegawai'],$flag='f');
			$data['getSTTb7'] = $this->verifikasi_model->getSTTb7($data['id_pegawai'],$flag='g');
		}	
		$this->load->view('templates/main',$data);
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
            $data['services_prov']=$this->dagri_service['server'];
			$data['query_gol'] = $this->pegawai_model->get_golongan();
            $this->_render_page($this->module."side_right_pegawai_add",$data,true);
        endif;
    }
	
	public function insert( )
	{	
		$this->msg_ok="Add data successfully";
        $this->msg_fail="Unable to add data";
		if($this->input->post('save') == 'Simpan'){
			$tgl = $this->input->post('tanggal_lahir_selector');
				$tanggal_pecah 	= explode("/",$tgl);
				$tanggal_input 	= $tanggal_pecah[2]."-".$tanggal_pecah[1]."-".$tanggal_pecah[0];
			$tgl2 = $this->input->post('tmt_pegawai_masuk_selector');
				$tanggal_pecah2 	= explode("/",$tgl2);
				$tanggal_input2 	= $tanggal_pecah2[2]."-".$tanggal_pecah2[1]."-".$tanggal_pecah2[0];
			$tgl3 = $this->input->post('berlaku_ktp');
				$tanggal_pecah3 	= explode("/",$tgl3);
				$tanggal_input3 	= $tanggal_pecah3[2]."-".$tanggal_pecah3[1]."-".$tanggal_pecah3[0];
			$tgl4 = $this->input->post('berlaku_peg');
				$tanggal_pecah4 	= explode("/",$tgl4);
				$tanggal_input4 	= $tanggal_pecah4[2]."-".$tanggal_pecah4[1]."-".$tanggal_pecah4[0];
			if(empty($_FILES['file_name']['name'])){
				$request = array(
									'nip'=>$this->input->post('nip'),
									'nama'=>$this->input->post('nama'),
									'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
									'gelar_depan'=>$this->input->post('gelar_depan'),
									'gelar_belakang'=>$this->input->post('gelar_belakang'),
									'foto'=>$this->input->post('file_name'),
									'tempat_lahir'=>$this->input->post('tempat_lahir'),
									'tanggal_lahir'=>$tanggal_input,
									'agama'=>$this->input->post('agama'),
									'status_perkawinan'=>$this->input->post('status_perkawinan'),
									'golongan_darah'=>$this->input->post('golongan_darah'),
									'golongan_darah_rhesus'=>$this->input->post('golongan_darah_rhesus'),
									'propinsi'=>$this->input->post('provinsi'),
									'kabupaten'=>$this->input->post('kabupaten'),
									'tmt_pegawai_masuk'=>$tanggal_input2,
									'status_pegawai'=>$this->input->post('status_pegawai'),
									'no_sk_pangkat'=>$this->input->post('no_sk_pangkat'),
									'pendidikan_terakhir'=>$this->input->post('pendidikan_terakhir'),
									'alamat'=>$this->input->post('alamat'),
									'keterangan'=>$this->input->post('keterangan'),
									'pangkat'=>$this->input->post('pangkat'),
									'no_sk_ppns'=>$this->input->post('skppns'),
									'no_ktp'=>$this->input->post('no_ktp'),
									'berlaku_ktp'=>$tanggal_input3,
									'uu_dikawal'=>$this->input->post('uu'),
									'berlaku_pegawai'=>$tanggal_input4,
									'email'=>$this->input->post('email')
								);
				$this->conn->StartTrans();
				$this->pegawai_model->doCreate($request);
				$ok=$this->conn->CompleteTrans();
				$this->_proses_message($ok,$this->module."listview/",$this->module."add/");
			}elseif(!empty($_FILES['file_name']['name'])){
				$config['upload_path'] = "./uploads/sppp_data_pegawai/";
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']  = '200000';
				$config['file_name']  = url_title($_FILES["file_name"]["name"]);
				
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('file_name'))
				{
					$request = array(
									'nip'=>$this->input->post('nip'),
									'nama'=>$this->input->post('nama'),
									'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
									'gelar_depan'=>$this->input->post('gelar_depan'),
									'gelar_belakang'=>$this->input->post('gelar_belakang'),
									'foto'=>$this->upload->file_name,
									'tempat_lahir'=>$this->input->post('tempat_lahir'),
									'tanggal_lahir'=>$tanggal_input,
									'agama'=>$this->input->post('agama'),
									'status_perkawinan'=>$this->input->post('status_perkawinan'),
									'golongan_darah'=>$this->input->post('golongan_darah'),
									'golongan_darah_rhesus'=>$this->input->post('golongan_darah_rhesus'),
									'propinsi'=>$this->input->post('provinsi'),
									'kabupaten'=>$this->input->post('kabupaten'),
									'tmt_pegawai_masuk'=>$tanggal_input2,
									'status_pegawai'=>$this->input->post('status_pegawai'),
									'no_sk_pangkat'=>$this->input->post('no_sk_pangkat'),
									'pendidikan_terakhir'=>$this->input->post('pendidikan_terakhir'),
									'alamat'=>$this->input->post('alamat'),
									'keterangan'=>$this->input->post('keterangan'),
									'pangkat'=>$this->input->post('pangkat'),
									'no_sk_ppns'=>$this->input->post('skppns'),
									'no_ktp'=>$this->input->post('no_ktp'),
									'berlaku_ktp'=>$tanggal_input3,
									'uu_dikawal'=>$this->input->post('uu'),
									'berlaku_pegawai'=>$tanggal_input4,
									'email'=>$this->input->post('email')
								);
					$this->conn->StartTrans();
					$this->pegawai_model->doCreate($request);
					$ok=$this->conn->CompleteTrans();
					$this->_proses_message($ok,$this->module."listview/",$this->module."add/");
				}
				else
				{
					$msg = $this->upload->display_errors();
					$this->session->set_flashdata('error', $msg);
					redirect('pegawai');
				} 
			}
		}	   	
	}
	
	function get_city($kodex) 
	{
		if(!empty($kodex)){
			$kode = $kodex;
		}else{
			$kode = 0;
		}
		$services_prov=$this->dagri_service['server'];
		$jsonData = file_get_contents($services_prov."?kode_dagri=$kode");
		$phpArray = json_decode($jsonData, true);	
		if(!empty($phpArray)){
		  $tmp .= "<option value=''>- Pilih Kabupaten -</option>";
		  foreach($phpArray as $key => $value) {
			$tmp .= "<option value='".$value['kode_dagri']."'>".$value['nama_wilayah']."</option>";	   
		  }
		} else {
		  $tmp .= "<option value=''>- Pilih Kabupaten -</option>";
		}
		die($tmp);
	}
	
    
    function edit($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		// debug();
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
        $data['services_prov']=$this->dagri_service['server'];
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
				$sesi = $this->session->all_userdata();
				$data['username'] = $sesi['username'];
				$data['level_user'] = $sesi['level_user'];
				$data['prov'] = $sesi['provinsi'];
				$data['kabupaten'] = $sesi['kabupaten']; 
				$data['query'] = $this->pegawai_model->doEdit($id);
				// pre($data['query']);exit;
				foreach($data['query'] as $row){
					$tgl = $row['tanggal_lahir'];
						$explode_tgl = explode("-", $tgl);
						$thn = $explode_tgl[0]; 
						$bln = $explode_tgl[1];
						$Tgl = $explode_tgl[2];
					$data['tanggal_lahir_selector'] = $Tgl."/".$bln."/".$thn;
					$tgl2 = $row['tmt_pegawai_masuk'];
						$explode_tgl2 = explode("-", $tgl2);
						$thn2 = $explode_tgl2[0]; 
						$bln2 = $explode_tgl2[1];
						$Tgl2 = $explode_tgl2[2];
					$data['tmt_pegawai_masuk_selector'] = $Tgl2."/".$bln2."/".$thn2; 
					$tgl4 = $row['berlaku_pegawai'];
						$explode_tgl4 = explode("-", $tgl4);
						$thn4 = $explode_tgl4[0]; 
						$bln4 = $explode_tgl4[1];
						$Tgl4 = $explode_tgl4[2];
					$data['berlaku_peg'] = $Tgl4."/".$bln4."/".$thn4; 
					$data['nip'] = $row['nip'];
					$data['nama'] = $row['nama'];
					$data['jenis_kelamin'] = $row['jenis_kelamin'];
					$data['gelar_depan'] = $row['gelar_depan'];
					$data['gelar_belakang'] = $row['gelar_belakang'];
					$data['foto'] = $row['foto'];
					$data['tempat_lahir'] = $row['tempat_lahir'];
					$data['tanggal_lahir'] = $row['tanggal_lahir'];
					$data['agama'] = $row['agama'];
					$data['status_perkawinan'] = $row['status_perkawinan'];
					$data['golongan_darah'] = $row['golongan_darah'];
					$data['golongan_darah_rhesus'] = $row['golongan_darah_rhesus'];
					$data['provinsi'] = $row['propinsi'];
					$data['kab'] = $row['kabupaten'];
					$data['tmt_pegawai_masuk'] = $row['tmt_pegawai_masuk'];
					$data['status_pegawai'] = $row['status_pegawai'];
					$data['no_sk_pangkat'] = $row['no_sk_pangkat'];
					$data['pendidikan_terakhir'] = $row['pendidikan_terakhir'];
					$data['alamat'] = $row['alamat'];
					$data['keterangan'] = $row['keterangan'];
					$data['id_pegawai'] = $row['idx'];
					$tgl3 = $row['berlaku_ktp'];
						$explode_tgl3 = explode("-", $tgl3);
						$thn3 = $explode_tgl3[0]; 
						$bln3 = $explode_tgl3[1];
						$Tgl3 = $explode_tgl3[2];
					$data['berlaku_ktp'] = $Tgl3."/".$bln3."/".$thn3; 
					$data['no_sk_ppns'] = $row['no_sk_ppns'];
					$data['pangkat'] = $row['pangkat'];
					$data['no_ktp'] = $row['no_ktp'];
					$data['uu_dikawal'] = $row['uu_dikawal'];
					$data['email'] = $row['email'];			
				}
				$data['link'] = 'pegawai_edit';	
				$data['getDoc'] = $this->pegawai_model->getDoc($data['id_pegawai']);
				$data['query_gol'] = $this->pegawai_model->get_golongan();
			$this->_render_page($this->module."side_right_pegawai_edit",$data,true);
        endif;    
    }
	
	public function update()
	{			
		$foto = $this->input->post('image_url');
		$id = $this->input->post('id');
		$tgl = $this->input->post('tanggal_lahir_selector');
			$tanggal_pecah 	= explode("/",$tgl);
			$tanggal_input 	= $tanggal_pecah[2]."-".$tanggal_pecah[1]."-".$tanggal_pecah[0];
		$tgl2 = $this->input->post('tmt_pegawai_masuk_selector');
			$tanggal_pecah2 	= explode("/",$tgl2);
			$tanggal_input2 	= $tanggal_pecah2[2]."-".$tanggal_pecah2[1]."-".$tanggal_pecah2[0];
		$tgl3 = $this->input->post('berlaku_ktp');
				$tanggal_pecah3 	= explode("/",$tgl3);
				$tanggal_input3 	= $tanggal_pecah3[2]."-".$tanggal_pecah3[1]."-".$tanggal_pecah3[0];
		$tgl4 = $this->input->post('berlaku_peg');
				$tanggal_pecah4 	= explode("/",$tgl4);
				$tanggal_input4 	= $tanggal_pecah4[2]."-".$tanggal_pecah4[1]."-".$tanggal_pecah4[0];
		$data_filename = $_FILES['file_name']['name'];
		// $direktori = "$data[path]/assets/uploads/sppp_data_pegawai/$id/";			
			
		if((empty($data_filename)) && (empty($foto))){//ks - ks
			$request = array(
									'idx'=>$this->input->post('id'),
									'nip'=>$this->input->post('nip'),
									'nama'=>$this->input->post('nama'),
									'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
									'gelar_depan'=>$this->input->post('gelar_depan'),
									'gelar_belakang'=>$this->input->post('gelar_belakang'),
									'foto'=>$this->input->post('image_url'),
									'tempat_lahir'=>$this->input->post('tempat_lahir'),
									'tanggal_lahir'=>$tanggal_input,
									'agama'=>$this->input->post('agama'),
									'status_perkawinan'=>$this->input->post('status_perkawinan'),
									'golongan_darah'=>$this->input->post('golongan_darah'),
									'golongan_darah_rhesus'=>$this->input->post('golongan_darah_rhesus'),
									'propinsi'=>$this->input->post('provinsi'),
									'kabupaten'=>$this->input->post('kabupaten'),
									'tmt_pegawai_masuk'=>$tanggal_input2,
									'status_pegawai'=>$this->input->post('status_pegawai'),
									'no_sk_pangkat'=>$this->input->post('no_sk_pangkat'),
									'pendidikan_terakhir'=>$this->input->post('pendidikan_terakhir'),
									'alamat'=>$this->input->post('alamat'),
									'keterangan'=>$this->input->post('keterangan'),
									'pangkat'=>$this->input->post('pangkat'),
									'no_sk_ppns'=>$this->input->post('skppns'),
									'no_ktp'=>$this->input->post('no_ktp'),
									'berlaku_ktp'=>$tanggal_input3,
									'uu_dikawal'=>$this->input->post('uu'),
									'berlaku_pegawai'=>$tanggal_input4,
									'email'=>$this->input->post('email')
								);
			$this->conn->StartTrans();
			$this->pegawai_model->doUpdate($request);
			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/",$this->module."listview/");
		}elseif((!empty($data_filename)) && (empty($foto))){//isi - ks			
			$config['upload_path']	= "./uploads/sppp_data_pegawai/";
			$config['allowed_types']= 'jpg|gif|png';		
			$config['max_size']	= '200000';
			$config['file_name'] = url_title($_FILES['file_name']['name']);
			$this->load->library('upload', $config);    
			$field = "file_name"; 
			
			if($this->upload->do_upload($field)){
				$data = $this->upload->data();
				$request = array(
									'idx'=>$this->input->post('id'),
									'nip'=>$this->input->post('nip'),
									'nama'=>$this->input->post('nama'),
									'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
									'gelar_depan'=>$this->input->post('gelar_depan'),
									'gelar_belakang'=>$this->input->post('gelar_belakang'),
									'foto'=>$this->upload->file_name,
									'tempat_lahir'=>$this->input->post('tempat_lahir'),
									'tanggal_lahir'=>$tanggal_input,
									'agama'=>$this->input->post('agama'),
									'status_perkawinan'=>$this->input->post('status_perkawinan'),
									'golongan_darah'=>$this->input->post('golongan_darah'),
									'golongan_darah_rhesus'=>$this->input->post('golongan_darah_rhesus'),
									'propinsi'=>$this->input->post('provinsi'),
									'kabupaten'=>$this->input->post('kabupaten'),
									'tmt_pegawai_masuk'=>$tanggal_input2,
									'status_pegawai'=>$this->input->post('status_pegawai'),
									'no_sk_pangkat'=>$this->input->post('no_sk_pangkat'),
									'pendidikan_terakhir'=>$this->input->post('pendidikan_terakhir'),
									'alamat'=>$this->input->post('alamat'),
									'keterangan'=>$this->input->post('keterangan'),
									'pangkat'=>$this->input->post('pangkat'),
									'no_sk_ppns'=>$this->input->post('skppns'),
									'no_ktp'=>$this->input->post('no_ktp'),
									'berlaku_ktp'=>$tanggal_input3,
									'uu_dikawal'=>$this->input->post('uu'),
									'berlaku_pegawai'=>$tanggal_input4,
									'email'=>$this->input->post('email')
								);
				$this->conn->StartTrans();
				$this->pegawai_model->doUpdate($request);
				$ok=$this->conn->CompleteTrans();
				$this->_proses_message($ok,$this->module."listview/",$this->module."listview/");
			}else{
				$this->conn->StartTrans();
				$this->pegawai_model->doUpdate($request);
				$ok=$this->conn->CompleteTrans();
				$this->_proses_message($ok,$this->module."edit/$id",$this->module."edit/$id");
			}
		}elseif((empty($data_filename)) && (!empty($foto))){//ks - isi
			// echo "aaa";exit;
			$request = array(
									'idx'=>$this->input->post('id'),
									'nip'=>$this->input->post('nip'),
									'nama'=>$this->input->post('nama'),
									'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
									'gelar_depan'=>$this->input->post('gelar_depan'),
									'gelar_belakang'=>$this->input->post('gelar_belakang'),
									'foto'=>$this->input->post('image_url'),
									'tempat_lahir'=>$this->input->post('tempat_lahir'),
									'tanggal_lahir'=>$tanggal_input,
									'agama'=>$this->input->post('agama'),
									'status_perkawinan'=>$this->input->post('status_perkawinan'),
									'golongan_darah'=>$this->input->post('golongan_darah'),
									'golongan_darah_rhesus'=>$this->input->post('golongan_darah_rhesus'),
									'propinsi'=>$this->input->post('provinsi'),
									'kabupaten'=>$this->input->post('kabupaten'),
									'tmt_pegawai_masuk'=>$tanggal_input2,
									'status_pegawai'=>$this->input->post('status_pegawai'),
									'no_sk_pangkat'=>$this->input->post('no_sk_pangkat'),
									'pendidikan_terakhir'=>$this->input->post('pendidikan_terakhir'),
									'alamat'=>$this->input->post('alamat'),
									'keterangan'=>$this->input->post('keterangan'),
									'pangkat'=>$this->input->post('pangkat'),
									'no_sk_ppns'=>$this->input->post('skppns'),
									'no_ktp'=>$this->input->post('no_ktp'),
									'berlaku_ktp'=>$tanggal_input3,
									'uu_dikawal'=>$this->input->post('uu'),
									'berlaku_pegawai'=>$tanggal_input4,
									'email'=>$this->input->post('email')
								);
			$this->conn->StartTrans();
			$this->pegawai_model->doUpdate($request);
			$ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/",$this->module."listview/");
		}elseif((!empty($data_filename)) && (!empty($foto))){//isi - isi
			// echo "aaaa";exit;  
			// debug();
			$config['upload_path']	= "./uploads/sppp_data_pegawai/";
			$config['allowed_types']= 'jpg|gif|png';		
			$config['max_size']	= '20000';
			$config['file_name'] = url_title($_FILES['file_name']['name']);
			$this->load->library('upload', $config);    
			$field = "file_name"; 
			
			if($this->upload->do_upload($field)){
				unlink(FCPATH."uploads/sppp_data_pegawai/".$this->input->post('image_url')); 
				$data = $this->upload->data();
				$request = array(
									'idx'=>$this->input->post('id'),
									'nip'=>$this->input->post('nip'),
									'nama'=>$this->input->post('nama'),
									'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
									'gelar_depan'=>$this->input->post('gelar_depan'),
									'gelar_belakang'=>$this->input->post('gelar_belakang'),
									'foto'=>$this->upload->file_name,
									'tempat_lahir'=>$this->input->post('tempat_lahir'),
									'tanggal_lahir'=>$tanggal_input,
									'agama'=>$this->input->post('agama'),
									'status_perkawinan'=>$this->input->post('status_perkawinan'),
									'golongan_darah'=>$this->input->post('golongan_darah'),
									'golongan_darah_rhesus'=>$this->input->post('golongan_darah_rhesus'),
									'propinsi'=>$this->input->post('provinsi'),
									'kabupaten'=>$this->input->post('kabupaten'),
									'tmt_pegawai_masuk'=>$tanggal_input2,
									'status_pegawai'=>$this->input->post('status_pegawai'),
									'no_sk_pangkat'=>$this->input->post('no_sk_pangkat'),
									'pendidikan_terakhir'=>$this->input->post('pendidikan_terakhir'),
									'alamat'=>$this->input->post('alamat'),
									'keterangan'=>$this->input->post('keterangan'),
									'pangkat'=>$this->input->post('pangkat'),
									'no_sk_ppns'=>$this->input->post('skppns'),
									'no_ktp'=>$this->input->post('no_ktp'),
									'berlaku_ktp'=>$tanggal_input3,
									'uu_dikawal'=>$this->input->post('uu'),
									'berlaku_pegawai'=>$tanggal_input4,
									'email'=>$this->input->post('email')
								);
				$this->conn->StartTrans();
				$this->pegawai_model->doUpdate($request);
				$ok=$this->conn->CompleteTrans();
				$this->_proses_message($ok,$this->module."listview/",$this->module."listview/");
			}else{
				$this->conn->StartTrans();
				$this->pegawai_model->doUpdate($request);
				$ok=$this->conn->CompleteTrans();
				$this->_proses_message($ok,$this->module."edit/$id",$this->module."edit/$id");
			}
		}
	}
	
	public function publishx()
	{
		$this->msg_ok="Update status successfully";
        $this->msg_fail="Update status successfully";
		$id = $this->input->post('a');
		$status = $this->input->post('b');
		$flag = $this->input->post('c');
		$tgl = $this->input->post('tanggal_selector');
		$tanggal_pecah 	= explode("/",$tgl);
		$tanggal_input 	= $tanggal_pecah[2]."-".$tanggal_pecah[1]."-".$tanggal_pecah[0];
		if($this->encrypt_status==TRUE):
            $id=$id;
            $id_enc=decrypt($id);
			$status=$status;
            $status_enc=decrypt($status);
			$flag=$flag;
            $flag_enc=decrypt($flag);
        endif;
		// debug();
		$this->conn->StartTrans();
		if($status_enc == "0"){
			$data['query'] = $this->pegawai_model->doPublish($id_enc,$status_enc,$flag_enc,$status_dok=null,$tanggal_input);
			//email
			// $this->load->library('email');
			// $config['protocol'] = 'smtp';
			// $config['smtp_host'] = 'ssl://smtp.gmail.com';
			// $config['smtp_port'] = '465';
			// $config['smtp_user'] = $this->ssl_email;
			// $config['smtp_pass'] = $this->ssl_pwd;
			// $config['mailtype'] = 'html';
			// $config['charset'] = 'utf-8';
			// $config['newline'] = "\r\n";
			// $this->email->initialize($config);
			// $this->email->from($this->ssl_form, 'Notifikasi Pengajuan Permohonan Baru'); 
			
			// $this->email->to('fadly@dinamof.co.id');
			
			// $this->email->subject('Notifikasi Pengajuan PPNS');
			
			// $pesan="
			// Dear operator, <br><br>
			// Terdapat Pengajuan berkas verifikasi PUM PPNS baru, segera cek kelengkapan berkas yang diajukan:<br><br>

			// <table border='0'>
				// <tr>
					// <td>Nomor Pendaftaran</td>
					// <td>:</td>
					// <td>$nomor_pendaftaran/$kode_pendaftaran/$tahun</td>
				// <tr>
				// <tr>
					// <td>Nama Perizinan</td>
					// <td>:</td>
					// <td>$nama_izin</td>
				// <tr>
				// <tr>
					// <td>Bidang</td>
					// <td>:</td>
					// <td>$jenis_bidang</td>
				// <tr>
			// </table>
			
			
			// <p><b>Terima Kasih</b></p>
			// ";
			// $this->email->message($pesan);	
			// $this->email->attach(FCPATH.'/uploads/berkas_ppns/01.jpg');
			// $this->email->send();
		}else{
			$data['query'] = $this->pegawai_model->doUnpublish($id_enc);	
		}
		$ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."view/$id/$flag_enc",$this->module."view/$id/$flag_enc");
		
	}
	
	
	public function publish($id,$status,$flag)
	{
		$this->msg_ok="Update status successfully";
        $this->msg_fail="Update status successfully";
		if($this->encrypt_status==TRUE):
            $id=$id;
            $id_enc=decrypt($id);
			$status=$status;
            $status_enc=decrypt($status);
			$flag=$flag;
            $flag_enc=decrypt($flag);
        endif;
		// debug();
		$this->conn->StartTrans();
		if($status_enc == "0"){
			$data['query'] = $this->pegawai_model->doPublish($id_enc,$status_enc,$flag_enc,$status_dok=null);
			//email
			// $this->load->library('email');
			// $config['protocol'] = 'smtp';
			// $config['smtp_host'] = 'ssl://smtp.gmail.com';
			// $config['smtp_port'] = '465';
			// $config['smtp_user'] = $this->ssl_email;
			// $config['smtp_pass'] = $this->ssl_pwd;
			// $config['mailtype'] = 'html';
			// $config['charset'] = 'utf-8';
			// $config['newline'] = "\r\n";
			// $this->email->initialize($config);
			// $this->email->from($this->ssl_form, 'Notifikasi Pengajuan Permohonan Baru'); 
			
			// $this->email->to('fadly@dinamof.co.id');
			
			// $this->email->subject('Notifikasi Pengajuan PPNS');
			
			// $pesan="
			// Dear operator, <br><br>
			// Terdapat Pengajuan berkas verifikasi PUM PPNS baru, segera cek kelengkapan berkas yang diajukan:<br><br>

			// <table border='0'>
				// <tr>
					// <td>Nomor Pendaftaran</td>
					// <td>:</td>
					// <td>$nomor_pendaftaran/$kode_pendaftaran/$tahun</td>
				// <tr>
				// <tr>
					// <td>Nama Perizinan</td>
					// <td>:</td>
					// <td>$nama_izin</td>
				// <tr>
				// <tr>
					// <td>Bidang</td>
					// <td>:</td>
					// <td>$jenis_bidang</td>
				// <tr>
			// </table>
			
			
			// <p><b>Terima Kasih</b></p>
			// ";
			// $this->email->message($pesan);	
			// $this->email->attach(FCPATH.'/uploads/berkas_ppns/01.jpg');
			// $this->email->send();
		}else{
			$data['query'] = $this->pegawai_model->doUnpublish($id_enc);	
		}
		$ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."view/$id/$flag_enc",$this->module."view/$id/$flag_enc");
		
	}
	
	public function change_status()
	{
		$this->msg_ok="Update status successfully";
        $this->msg_fail="Update status successfully";
		$datax=get_post();
		if($this->encrypt_status==TRUE):
            $id=$datax['idx_pegawai'];
            $id_enc=decrypt($datax['idx_pegawai']);
			// $status=$status;
            $status_dok=$datax['status_dok'];
			$flag=$datax['flag'];
            $flag_enc=decrypt($datax['flag']);
        endif;
		$ket=$datax['keterangan'];
		$this->conn->StartTrans();

		$data['query'] = $this->verifikasi_model->changeStatus($id_enc,$status_dok,$flag_enc,$ket);

		$ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."view/$id/$flag_enc",$this->module."view/$id/$flag_enc");
		
	}

    function del($id){
       if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
		
		$this->conn->StartTrans();
		$getFoto = $this->pegawai_model->doEdit($id);
		foreach($getFoto as $key){
			$foto = $key['foto'];
			if($foto != ''){
				unlink(FCPATH.'uploads/sppp_data_pegawai/'.$foto);		
			}
		}
		if(isset($id)){
			$this->pegawai_model->doDelete($id);
		}
		$ok=$this->conn->CompleteTrans();
        $this->_proses_message($ok,$this->module."listview",$this->module."listview");
       
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