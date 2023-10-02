<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifikasi extends MX_Controller {
 
	function __construct()
    {
        parent::__construct();    
        $this->load->library('image_lib');
        $this->load->model('global_model');
		$this->load->model('user/user_model');
		$this->load->model('verifikasi_model');
		$this->load->library('table');
        $this->load->database();
    }
	
	
	public function index( )
	{
		$data['link'] = 'verifikasi';
		$sesi = $this->session->all_userdata();
			$data['username'] = $sesi['username'];
			$data['nama'] = $sesi['nama'];
			$data['level_user'] = $sesi['level_user'];
			$data['prov'] = $sesi['provinsi'];
			$data['kabupaten'] = $sesi['kabupaten'];
		$jml = $this->conn->Execute("SELECT id_pegawai,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,id_org_unit,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan FROM sppp_data_pegawai");  
		$this->load->library('pagination');
		$offset = $this->uri->segment(3, 0);
		$config['base_url'] = base_url().'verifikasi/index/';
		$config['total_rows'] = $jml->RecordCount();
		$config['per_page'] = 10;
		$config['first_link'] = 'Awal';
		$config['last_link'] = 'Akhir';
		$config['next_link'] = '&raquo;';
		$config['prev_link'] = '&laquo;';    
		$num = $config['per_page'];
		$this->pagination->initialize($config);
		$data['halaman'] = $this->pagination->create_links();
		$data['query_prov'] = $this->global_model->get_provinsi(); 
		$data['query_kab'] = $this->global_model->get_kabupaten();
		$data['query'] = $this->verifikasi_model->doSelect($num,$offset);
		$data['query_cat'] = $this->user_model->m_kategori(); 
		$data['query_brks'] = $this->verifikasi_model->m_berkas2(); 
		
		// foreach($data['query'] as $row){	
			// $data['countA'] = $this->verifikasi_model->countFlag($row['id_pegawai'],'a');
				// $data['a'] = $data['countA']->RecordCount();
			// $data['countB'] = $this->verifikasi_model->countFlag($row['id_pegawai'],'b');
				// $data['b'] = $data['countB']->RecordCount();
			// $data['countC'] = $this->verifikasi_model->countFlag($row['id_pegawai'],'c');
				// $data['c'] = $data['countC']->RecordCount();
			// $data['countD'] = $this->verifikasi_model->countFlag($row['id_pegawai'],'d');
				// $data['d'] = $data['countD']->RecordCount();
			// $data['countE'] = $this->verifikasi_model->countFlag($row['id_pegawai'],'e');
				// $data['e'] = $data['countE']->RecordCount();
			// $data['countF'] = $this->verifikasi_model->countFlag($row['id_pegawai'],'f');
				// $data['f'] = $data['countF']->RecordCount();
		// }
        $this->load->view('templates/main',$data);
	}
	
	public function search()
	{			 
		$data['link'] = 'verifikasi';
		$sesi = $this->session->all_userdata();
			$data['username'] = $sesi['username'];
			$data['nama'] = $sesi['nama'];
			$data['level_user'] = $sesi['level_user'];
			$data['prov'] = $sesi['provinsi'];
			$data['kabupaten'] = $sesi['kabupaten'];
		if(isset($_POST['search']))
		{
			$provinsi_scr = $this->input->post('provinsi');
			$data['scr_prov'] = $provinsi_scr;
			if($provinsi_scr ==''){
				$provinsi_scr = $this->session->userdata('provinsi');
			}
			
			$kabupaten_scr = $this->input->post('kabupaten');
			$data['scr_kab'] = $kabupaten_scr;
			if($kabupaten_scr ==''){
				$kabupaten_scr = $this->session->userdata('kabupaten');
			}
			
			$nip_scr = $this->input->post('q');
			$data['scr'] = $nip_scr;
			if($nip_scr ==''){
				$nip_scr = $this->session->userdata('q');
			}
			
			$this->session->set_userdata('sess_ringkasan', $provinsi_scr);
			$this->session->set_userdata('sess_ringkasan2', $kabupaten_scr);
			$this->session->set_userdata('sess_ringkasan3', $nip_scr);
		} else {
			$provinsi_scr = $this->session->userdata('sess_ringkasan');
			$data['scr_prov'] = $provinsi_scr;
			$kabupaten_scr = $this->session->userdata('sess_ringkasan2');
			$data['scr_kab'] = $kabupaten_scr;
			$nip_scr = $this->session->userdata('sess_ringkasan3');
			$data['scr'] = $nip_scr;
		}
		
		$total_segment = $this->uri->total_segments();
		if($total_segment == 1){        

			$provinsi_scr = $this->session->userdata('sess_ringkasan');
			$data['scr_prov'] = $this->session->set_userdata('sess_kd_prov', $provinsi_scr);
			
			$kabupaten_scr = $this->session->userdata('sess_ringkasan2');
			$data['scr_kab'] = $this->session->set_userdata('sess_kd_kab', $kabupaten_scr);

			$nip_scr = $this->session->userdata('sess_ringkasan3');
			$data['scr'] = $this->session->set_userdata('ses_nip', $nip_scr);
        }
		
		$jml = $this->conn->Execute("SELECT id_pegawai,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,
									foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,
									golongan_darah_rhesus,id_org_unit,tmt_pegawai_masuk,status_pegawai,
									no_sk_pangkat,pendidikan_terakhir,alamat,keterangan,propinsi,kabupaten FROM sppp_data_pegawai
									WHERE propinsi like '%".$provinsi_scr."%' AND kabupaten like '%".$kabupaten_scr."%' AND (nip like '%".$nip_scr."%' OR nama like '%".$nip_scr."%')
									");  
		$this->load->library('pagination');
		$offset = $this->uri->segment(3, 0);
		$config['base_url'] = base_url().'verifikasi/search/';
		$config['total_rows'] = $jml->RecordCount();
		$config['per_page'] = 10;
		$config['first_link'] = 'Awal';
		$config['last_link'] = 'Akhir';
		$config['next_link'] = '&raquo;';
		$config['prev_link'] = '&laquo;';    
		$num = $config['per_page'];
		$this->pagination->initialize($config);
		$data['halaman'] = $this->pagination->create_links();
		$data['query_prov'] = $this->global_model->get_provinsi(); 
		$data['query_kab'] = $this->global_model->get_kabupaten();
		$data['query_cat'] = $this->user_model->m_kategori(); 
		$data['query_brks'] = $this->verifikasi_model->m_berkas2(); 
		$data['query'] = $this->verifikasi_model->doSelectSeacrh($num,$offset,$provinsi_scr,$kabupaten_scr,$nip_scr);
        $this->load->view('templates/main',$data);
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
	
	public function insert_dokumen( )
	{	
		$data['path'] = $this->config->item('path');
		
			$id = $this->input->post('id_pegawai');
			$fg = $this->input->post('flag');
			
			$count = $this->conn->Execute("SELECT COUNT(id) as count FROM dokumen_sppp_data_pegawai WHERE id_pegawai = '".$id."' AND flag = '".$fg."' AND jenis_berkas = '".$this->input->post('berkas')."'");
			foreach($count as $row){
				$c = $row['count'];
			}
			if($c){
				$msg = 'Duplicate Entry File';
				$this->session->set_flashdata('error', $msg);
				redirect("verifikasi/berkas/$id/$fg");
			}else{
				$get = get_auto_increment("dokumen_sppp_data_pegawai","ppns");
				$direktori = "$data[path]/assets/uploads/dokumen_sppp_data_pegawai/$get/";
				mkdir($direktori,0777);
				
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
									'id_pegawai'=>$this->input->post('id_pegawai'),
									'no_surat'=>$this->input->post('ns'),
									'jenis_berkas'=>$this->input->post('berkas'),
									'flag'=>$this->input->post('flag')
								);
					$this->verifikasi_model->uploadDoc($request);
					$msg = 'Data berhasil disiimpan.';
					$this->session->set_flashdata('success', $msg);
					redirect("verifikasi/berkas/$id/$fg");
				}
				else
				{
					$msg = $this->upload->display_errors();
					$this->session->set_flashdata('error', $msg);
					redirect("verifikasi/berkas/$id/$fg");
				} 
			}
	}
	
	public function update_dokumen( )
	{	
		if(isset($_POST['save2'])){
			$id = $this->input->post('id_pegawai');
			$fg = $this->input->post('flag');
			$tgl = $this->input->post('tanggal_sp');
				$tanggal_pecah 	= explode("/",$tgl);
				$tanggal_input 	= $tanggal_pecah[2]."-".$tanggal_pecah[1]."-".$tanggal_pecah[0];
			$request = array(
							'id_pegawai'=>$this->input->post('id_pegawai'),
							'no_surat'=>$this->input->post('ns'),
							'flag'=>$this->input->post('flag'),
							'tanggal_sp'=>$tanggal_input,
							'tanggal_post'=>$this->input->post('tanggal_post')
						);
			$this->verifikasi_model->updateDoc($request);
			$msg = 'Data berhasil disiimpan.';
			$this->session->set_flashdata('success', $msg);
			redirect("verifikasi/berkas/$id/$fg");
		}
	}
	
	public function update_dokumens( )
	{	
		$data['path'] = $this->config->item('path');
		//pre($data['path']);exit;
		$id = $this->input->post('id_pegawai');
		$fg = $this->input->post('flag');
		$jb = $this->input->post('jenis_berkas');
		$getdoc = $this->verifikasi_model->getOneDoc($id,$fg,$jb);
		foreach($getdoc as $key){
			$dok = $key['dokumen'];
			$idd = $key['id'];
		}
		$file_name = $this->input->post('file_name');
		$direktori = "$data[path]/assets/uploads/dokumen_sppp_data_pegawai/$idd/";	
		$config['upload_path']	= "$direktori";
		$config['allowed_types']= 'gif|jpg|png|jpeg|doc|docx|xls|xlsx|pdf|rar|zip';
		$config['max_size']	= '1000000';
		$config['file_name'] = url_title($_FILES['file_name']['name']);
		$this->load->library('upload', $config);    
		$field = "file_name"; 
		
		if($this->upload->do_upload($field)){
			unlink($direktori.$dok); 
			$data = $this->upload->data();
			$request = array(
							'id'=>$idd,
							'no_surat'=>$this->input->post('ns'),
							'flag'=>$this->input->post('flag'),
							'dokumen'=>$this->upload->file_name,
							'jenis_berkas'=>$jb
							);
			$this->verifikasi_model->updateDok($request);
			$msg = 'Data berhasil disiimpan.';
			$this->session->set_flashdata('success', $msg);
			redirect("verifikasi/berkas/$id/$fg");
		}else{
			$msg = $this->upload->display_errors();
			$this->session->set_flashdata('error', $msg);
			redirect("verifikasi/berkas/$id/$fg");
		}
	}
	
	public function insert_dokumen2( )
	{	
		$data['path'] = $this->config->item('path');
		//pre($data['path']);exit;
		// if(isset($_POST['save']))
		// {
			$id = $this->input->post('id_pegawai');
			$fg = $this->input->post('flag');
			
				$get = get_auto_increment("dokumen_sppp_data_pegawai","ppns");
				$direktori = "$data[path]/assets/uploads/dokumen_sppp_data_pegawai/$get/";
				mkdir($direktori,0777);
				
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
									'id_pegawai'=>$this->input->post('id_pegawai'),
									'no_surat'=>$this->input->post('ns'),
									'jenis_berkas'=>$this->input->post('berkas'),
									'flag'=>$this->input->post('flag')
								);
					$this->verifikasi_model->uploadDoc($request);
					$msg = 'Data berhasil disiimpan.';
					$this->session->set_flashdata('success', $msg);
					redirect("verifikasi/berkas/$id/$fg");
				}
				else
				{
					$msg = $this->upload->display_errors();
					$this->session->set_flashdata('error', $msg);
					redirect("verifikasi/berkas/$id/$fg");
				} 
		// }
	}
	
	public function delete_berkas($id)
	{
		$data['path'] = $this->config->item('path');
	    $direktori = "$data[path]/assets/uploads/dokumen_sppp_data_pegawai/$id/";

		$getBerkas = $this->verifikasi_model->getBerkas($id);
		foreach($getBerkas as $key){
			$berkas = $key['dokumen'];
			$fg = $key['flag'];
			$id_pegawai = $key['id_pegawai'];
			if($berkas != ''){
				unlink($direktori.$berkas);
				rmdir($direktori);				
			}
		}
		if(isset($id)){
			$this->verifikasi_model->doDelete_berkas($id);
		}

		redirect("verifikasi/berkas/$id_pegawai/$fg");
	}
}
 
?>