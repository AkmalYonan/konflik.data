<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dokumen extends Public_Controller {
	
    function __construct(){
        parent::__construct();
        
        $this->folder="";
		$this->module=$this->folder."user/";
		$this->page_active="dip";
        $this->http_ref=base_url().$this->module;
        
		$this->load->model("dip/dip_model");
        $this->model=$this->dip_model;
		
		$this->load->model("dip/req_model");
		
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
	function get_lookup_jenis(){
        $arrData=$this->model->jenis_search_record(false," order by id" );
        if(cek_array($arrData)):
            foreach($arrData as $x=>$val):
                $arrCat[$val["id"]]=$val["name"];
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
	function index($mode=false,$forder=0,$limit=10,$page=1){
		$this->list_view($mode,$forder,$limit,$page);
	}
	function request($mode=false,$forder=0,$limit=10,$page=1){
		$this->list_view('request',$forder,$limit,$page);
	}
	
	function list_view($mode=false,$forder,$limit,$page){
		
		$user = $this->ion_auth->user()->row();

		$filter="id_user=".$user->id." and mode='".($mode?$mode:'dokumen')."'";
		$data["mode"]=$mode;
		$data["id_user"]=$user->id;
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter .= " and title like '%".$key."%' or clip like '%".$key."%'";
			$data["key"]=$key;
		}
		$offset 		= ($page-1)*$limit;
		$data_start 	= $offset+1;
		$data_end 		= $offset+$limit;
		
		if ($forder) {
			$spl = preg_split("/:/",$forder);
			$order = 'order by '.$spl[0].' '.$spl[1];
			$data["forder"]=$spl[0];
			$data["dorder"]=$spl[1];
		}
		else {
			$order = 'order by idx desc';
		}
		
		$arrDB=$this->req_model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
		$total_rows=$this->req_model->getTotalRecordWhere($filter);

		$query_url = ($key)?"?q=".$key:"";
		$base_url = $this->module."dokumen/index/".($mode?$mode:"0")."/".$forder."/".$limit;
		$perpage = $this->utils->getPerPage($limit,array(10,15,20,25,30,40,50));
		$paging = $this->utils->getPaginationString2($page, $total_rows, $limit, 1, $base_url, "/",$query_url);
		
		if (is_array($arrDB)) {
			foreach($arrDB as $k=>$v) {
				$detil = $this->req_model->get_permohonan_detil2("id_permohonan=".$v['idx']);
				$arrDB[$k]['detil']=$detil;
				if ($v['status']==3) {
					$reply = $this->req_model->get_permohonan_reply("id_permohonan=".$v['idx']);
					$arrDB[$k]['reply']=$reply;
				}
			}
		}
		$data["acc_active"]="content";
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["total_rows"]=$total_rows;
		$data["data_start"]=$data_start;
		$data["data_end"]=($data_end<$total_rows)?$data_end:$total_rows; 
		$data["perpage"]=$perpage;
		$data["paging"]=$paging;
		$data["module"]=$this->module;
		$data["arrDB"]=$arrDB;
		
		$data['m_jenis']=$this->get_lookup_jenis();
		$data['m_skpa']=$this->get_lookup_skpa();
		
		$this->_render_page('user/dokumen/'.($mode=='request'?'request':'index'), $data, true);
	}
	
	function view($id){
		$arrData=$this->req_model->GetRecordByID($id);
		
		$data['m_jenis']=$this->get_lookup_jenis();
		$data['m_skpa']=$this->get_lookup_skpa();
		$data['arrData']=$arrData;
		$data['status_list']=$this->req_model->get_permohonan_detil2("id_permohonan=".$arrData['idx']." and internal_status='status'");
		$data['reply']=$this->req_model->get_permohonan_reply("id_permohonan=".$arrData['idx']);
		$data['user']=$this->req_model->get_member_record("id=".$arrData['id_user']);
		$this->_render_page('user/dokumen/view', $data, true);
	}
	function view_f($id){
		if ($id) {
			$arrData=$this->req_model->GetRecordByID($id);
			$user = $this->ion_auth->user()->row();
			if ($user->id==$arrData['id_user']) {
				if ($arrData['file_name']) {
					$file_name = $arrData['file_name'];
					$m_skpa=$this->get_lookup_skpa();
					$skpa = ($arrData['skpa'])?$m_skpa[$arrData['skpa']]:'skpa';
					$file_path = $this->config->item('dir_files').str_replace(" ","_",$skpa)."/";
					$tmp_name = $this->config->item('dir_files').$file_name;
					$new_name = $file_path.$file_name;

					if (file_exists($new_name)) {
						$this->__view($file_name,$file_path,$arrData['file_type']);
					}
				}
			}
		}
	}
	
	function bukti_permohonan($id){
		if ($id) {
			$arrData=$this->req_model->GetRecordByID($id);
			$file_path = $this->config->item('file_path');
			$file_name = "BP-".str_replace("/","_",$arrData['nomor_permohonan']).'.pdf';
			//pre($file_name);
			$this->__download($file_name,$file_path,false);
		}
	}
	function bukti_pemberitahuan($id){
		if ($id) {
			$arrData=$this->req_model->GetRecordByID($id);
			$file_path = $this->config->item('file_path');
			$file_name = str_replace("/","_",$arrData['nomor_permohonan']).'.pdf';
			//pre($file_name);
			$this->__download($file_name,$file_path,false);
		}
	}
	function download($id){
		if ($id) {
			$arrData=$this->req_model->getRequestFileById($id);
			$user = $this->ion_auth->user()->row();
			if ($user->id==$arrData['id_user']) {
				if ($arrData['file_name']) {
					$update = $this->model->UpdateData(array("num_download"=>($arrData['num_download']+1)),"idx=".$arrData['file_id']);
					
					$file_name = $arrData['file_name'];
					$m_skpa=$this->get_lookup_skpa();
					$skpa = ($arrData['skpa'])?$m_skpa[$arrData['skpa']]:'skpa';
					$file_path = $this->config->item('dir_files').str_replace(" ","_",$skpa)."/";
					$tmp_name = $this->config->item('dir_files').$file_name;
					$new_name = $file_path.$file_name;

					if (file_exists($new_name)) {
						$this->__download($file_name,$file_path,$arrData['file_type']);
					}
				}
			}
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
	
	function __view($file_name,$file_path,$file_mime) {
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
		header("Content-Disposition: inline; filename=\"$file_name\"");
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