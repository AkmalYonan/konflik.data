<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class keberatan extends Public_Controller {
	
    function __construct(){
        parent::__construct();
        
        $this->folder="";
		$this->module=$this->folder."user/";
		$this->page_active="dip";
        $this->http_ref=base_url().$this->module;
        
		$this->load->model("dip/dip_model");
        $this->model=$this->dip_model;
		
		$this->load->model("dip/req_model");
		$this->load->model("dip/pki_model");
		
		//$this->load->model('ion_auth_model')

		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->lang->load('auth');
		$this->load->helper('language');
		
		$this->admin_layout="layout/main_layout";
		$this->load->library("utils");
		
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}
    }
	function get_lookup_alasan(){
        $arrData=$this->pki_model->alasan_search_record(false," order by id" );
        if(cek_array($arrData)):
            foreach($arrData as $x=>$val):
                $arrCat[$val["description"]]=$val["name"];
            endforeach;
        endif;
        return $arrCat;
    }
	function get_lookup_skpa(){
        $arrData=$this->model->skpa_search_record(false," order by id" );
        if(cek_array($arrData)):
            foreach($arrData as $x=>$val):
                $arrCat[$val["id"]]=$val["name"];
            endforeach;
        endif;
        return $arrCat;
    }
	function get_lookup_jenis(){
        $arrData=$this->model->jenis_search_record(false," order by id" );
        if(cek_array($arrData)):
            foreach($arrData as $x=>$val):
                $arrCat[$val["id"]]=$val["name"];
            endforeach;
        endif;
        return $arrCat;
    }
	function index($idx=false,$fn=false){
		if (!$this->ion_auth->logged_in())
		{
			$this->session->set_flashdata('pending_url', 'dip/keberatan/'.$idx.'/'.$fn);
			redirect('user/login', 'refresh');
		}
		
		$user=(array)$this->ion_auth->user()->row();
		
		$req = $this->req_model->GetRecordByID($idx); 
		if (!cek_array($req)) {
			redirect('user/keberatan/error', 'refresh');
		}
		else { 
			$reply = $this->req_model->get_permohonan_reply("id_permohonan=".$idx);
			if ($reply['file_id']) $dok = $this->model->GetRecordByID($reply['file_id']);
		}
		
		$this->data['idx'] = cek_array($dok)?$idx:false;
		$this->form_validation->set_rules('nomor_permohonan', 'Nomor Pendaftaran Permohonan Informasi', 'required|xss_clean');
		$this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required|xss_clean');
		$this->form_validation->set_rules('alamat_pemohon', 'Alamat Pemohon', 'required|xss_clean');
		$this->form_validation->set_rules('telepon_pemohon', 'telepon Pemohon', 'required|xss_clean');
		$this->form_validation->set_rules('email_pemohon', 'Email Pemohon', 'required|xss_clean');
		$this->form_validation->set_rules('tujuan_penggunaan', 'Tujuan Penggunaan Informasi', 'required|xss_clean');
		$this->form_validation->set_rules('kasus_posisi', 'Kasus Posisi', 'required|xss_clean');
		$this->form_validation->set_rules('alasan', 'Alasan Pengajuan Keberatan', 'required|xss_clean');
		if ($this->form_validation->run() == true)
		{
			$_data = array(
				'id_permohonan' 		=> $this->input->post('id_permohonan'),
				'nomor_permohonan'		=> $this->input->post('nomor_permohonan'),
				'id_dokumen' 			=> $this->input->post('id_dokumen'),
				'kode_dokumen' 			=> $this->input->post('kode_dokumen'),
				'judul_dokumen'   		=> $this->input->post('judul_dokumen'),
				'kandungan_dokumen'		=> $this->input->post('kandungan_dokumen'),
				'tujuan_penggunaan'		=> $this->input->post('tujuan_penggunaan'),
				'jenis'   			   	=> $this->input->post('jenis'),
				'skpa'      			=> $this->input->post('skpa'),
				'created_date'      	=> date("Y-m-d h:i:s"),
				'metode' 		     	=> $this->input->post('metode'),
				'id_user'		      	=> $this->input->post('id_user'),
				'email_user'		    => $this->input->post('email_user'),
				'pengenal_user'		    => $this->input->post('pengenal_user'),
				'nama_pemohon' 			=> $this->input->post('nama_pemohon'),
				'alamat_pemohon' 		=> $this->input->post('alamat_pemohon'),
				'pekerjaan_pemohon'		=> $this->input->post('pekerjaan_pemohon'),
				'email_pemohon'			=> $this->input->post('email_pemohon'),
				'kuasa_nama'			=> $this->input->post('kuasa_nama'),
				'kuasa_alamat'			=> $this->input->post('kuasa_alamat'),
				'kuasa_telepon'			=> $this->input->post('kuasa_telepon'),
				'kuasa_email'			=> $this->input->post('kuasa_email'),
				'telepon_pemohon'		=> $this->input->post('telepon_pemohon'),
				'kasus_posisi'			=> $this->input->post('kasus_posisi'),
				'alasan'				=> implode(";",$this->input->post('alasan')),
				'file_name'      		=> $this->input->post('file_name'),
				'file_type'      		=> $this->input->post('file_type'),
				'file_size'      		=> $this->input->post('file_size'),
				'mode'      			=> $this->input->post('mode'),
				'status'      			=> -1
			);
			$insert = $this->pki_model->InsertData($_data);
			if ($insert) {
				$last_id = $this->pki_model->GetLastID();

				$data_req['id_keberatan']=$last_id;
				$this->req_model->UpdateData($data_req,"idx=".$_data['id_permohonan']);
				
				$tgl = date("dmy");
				$_update['nomor_keberatan']='PK-'.sprintf('%02d/%s-%05s/%s',$_data['skpa'],$tgl,$last_id,$_data['id_permohonan']);
				$update = $this->pki_model->UpdateData($_update,"idx=".$last_id);
				
				if ($update) {
					$_data_detil["status"]=-1;
					$_data_detil["internal_status"]='status';
					$_data_detil["is_new"]=1;
					$_data_detil["message"]='Pengajuan Keberatan Baru';
					$_data_detil["id_keberatan"]=$last_id;
					$_data_detil["id_permohonan"]=$_data['id_permohonan'];
					$_data_detil["skpa"]=$_POST['skpa'];
					$_data_detil["created_date"]=date("Y-m-d h:i:s");
					
					$this->pki_model->insert_keberatan_detil($_data_detil);
					
					$_data['user']=$user;
					$_data['nomor_keberatan']=$_update['nomor_keberatan'];
					$_data['nomor_permohonan']=$_data['nomor_permohonan'];
					$_data['alasan']=$this->input->post('alasan');
					$_data['m_alasan']=$this->get_lookup_alasan();
					
					$this->session->set_flashdata('message', true);
					redirect('user/keberatan/view/'.$last_id);
					//$sent = $this->__sent_mail_notification($_data);
					/*if ($sent) {
						$this->session->set_flashdata('message', true);
						redirect('user/dokumen/view/'.$req_count);
					}*/
				}
				/*if ($_data['file_name']) {
					$file_name = $_data['file_name'];
					$file_path = $this->config->item('dir_files').str_replace(" ","_",$this->input->post('skpa_name'))."/";
					$tmp_name = $this->config->item('dir_files').$file_name;
					$new_name = $file_path.$file_name;
					if (file_exists($new_name)) {
						$this->__download($file_name,$file_path);
					}
				}*/
				//$this->__download('LICENSE.txt',"c:/ms4w/Apache/");
				$data["redirect"]=true;
				//set_message("success","Article Added.");
				//redirect("admin/articles/");
			}
		}
		else
		{
			$this->data['message'] = validation_errors() ? validation_errors():false;
			$tgl = date("dmy",strtotime($dok['created_date']));
			$this->data['user'] = $user;
			$this->data['request'] = $req;
			$this->data['dokumen'] = $dok;

			$this->data['m_skpa']=$this->get_lookup_skpa();
			$this->data['m_alasan']=$this->get_lookup_alasan();
			$this->_render_page('keberatan/index', $this->data,true);
		}
	}
	function view($id){
		$arrData=$this->pki_model->GetRecordByID($id);
		
		$data['m_jenis']=$this->get_lookup_jenis();
		$data['m_skpa']=$this->get_lookup_skpa();
		$data['m_alasan']=$this->get_lookup_alasan();
		$data['arrData']=$arrData;
		$data['status_list']=$this->pki_model->get_keberatan_detil2("id_keberatan=".$arrData['idx']." and internal_status='status'");
		$data['reply']=$this->pki_model->get_keberatan_reply("id_keberatan=".$arrData['idx']);
		$data['user']=$this->req_model->get_member_record("id=".$arrData['id_user']);
		$this->_render_page('user/keberatan/view', $data, true);
	}
	function __sent_mail_notification($data){
		$this->email->clear();
		$this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
		$this->email->to($data['email_user']);
		$this->email->subject($this->config->item('site_title', 'ion_auth') . ' - Bukti Permohonan Informasi');
		
		$data['site_url']=$this->config->item('site_url');
		$message_h = '<html><body><div style="border:1px solid #ccc; padding:20px">';
		$message = $this->load->view($this->config->item('email_templates_pk').$this->config->item('email_request_pk'), $data, false);
		$message_f = '</div></body></html>';
		//$file_name = $this->config->item('file_path')."BP-".str_replace("/","_",$data['nomor_permohonan']).'.pdf';
		
		
		$this->email->message($message_h.$message.$message_f);

		/*if ($this->email->send() == TRUE)
		{
			$data['site_url']='';
			$message = $this->load->view($this->config->item('email_templates').$this->config->item('email_request'), $data, true);
			Export2MPDF($message,$file_name,'F','P');
			return true;
		}*/
    }
	function bukti_pk($id){
		if ($id) {
			$arrData=$this->pki_model->GetRecordByID($id);
			$file_path = $this->config->item('file_path');
			$file_name = str_replace("/","_",$arrData['nomor_keberatan']).'_02.pdf';
			$this->__download($file_name,$file_path,false);
		}
	}
	function bukti_tanggapan_pk($id){
		if ($id) {
			$arrData=$this->pki_model->GetRecordByID($id);
			$file_path = $this->config->item('file_path');
			$file_name = str_replace("/","_",$arrData['nomor_keberatan']).'_03.pdf';
			//pre($file_name);
			$this->__download($file_name,$file_path,false);
		}
	}
	function __mime_type($ext) {
		$mime_ext = array (
		
		  // archives
		  'zip' => 'application/zip',
		
		  // documents
		  'pdf' => 'application/pdf',
		  'doc' => 'application/msword',
		  'xls' => 'application/vnd.ms-excel',
		  'ppt' => 'application/vnd.ms-powerpoint',
		  
		  // executables
		  'exe' => 'application/octet-stream',
		
		  // images
		  'gif' => 'image/gif',
		  'png' => 'image/png',
		  'jpg' => 'image/jpeg',
		  'jpeg' => 'image/jpeg',
		
		  // audio
		  'mp3' => 'audio/mpeg',
		  'wav' => 'audio/x-wav',
		
		  // video
		  'mpeg' => 'video/mpeg',
		  'mpg' => 'video/mpeg',
		  'mpe' => 'video/mpeg',
		  'mov' => 'video/quicktime',
		  'avi' => 'video/x-msvideo'
		);
		return $mime_ext[$ext]?$mime_ext[$ext]:'';
	}
	function __download($file_name,$file_path,$file_mime) {
		$file = $file_path.$file_name;
		// file size in bytes
		$fsize = filesize($file); 
		
		// file extension
		$fext = strtolower(substr(strrchr($file_name,"."),1));
		
		$mtype = '';
		  // mime type is not set, get from server settings
		  if (function_exists('mime_content_type')) {
			$mtype = mime_content_type($file);
		  }
		  else if (function_exists('finfo_file')) {
			$finfo = finfo_open(FILEINFO_MIME); // return mime type
			$mtype = finfo_file($finfo, $file);
			finfo_close($finfo);  
		  }
		  else if ($file_mime) {
		  	$mtype = $file_mime;
		  }
		  else {
		  	$mtype = $this->__mime_type($fext);
		  }
		  if ($mtype == '') {
			$mtype = "application/force-download";
		  }
		//pre($mtype);
		//pre($fsize);
		//exit;
		// set headers
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: $mtype");
		header("Content-Disposition: attachment; filename=\"$file_name\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . $fsize);
		
		// download
		// @readfile($file_path);
		$file = @fopen($file,"rb");
		if ($file) {
		  while(!feof($file)) {
			print(fread($file, 1024*8));
			flush();
			if (connection_status()!=0) {
			  @fclose($file);
			  die();
			}
		  }
		  @fclose($file);
		}
	}
	
	function _render_page($view, $data=null, $render=false)
	{
		$this->viewdata = (empty($data)) ? $this->data: $data;
		$view_html = $this->load->view($view, $this->viewdata, $render);
		if($render):
			$datam["acc_active"]="account_manager";
			$datam["content"]=$view_html;
			$this->load->view($this->admin_layout,$datam);
		endif;
		//if ($render) return $view_html;
	}
}