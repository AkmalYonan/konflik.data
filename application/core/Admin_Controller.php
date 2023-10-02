<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Admin_Controller extends MY_Controller
{
    function __construct()
    {
		parent::__construct();
		/*
		$this->load->library('ion_auth');
    	if (!$this->ion_auth->logged_in())
		{
			//$this->session->set_flashdata('message', 'You must be an admin to view this page');
			//redirect them to the login page
			redirect('admin/auth/login', 'refresh');
		}
		else{
			$obj=$this->ion_auth->user()->result_array();
			$arr=(array)$obj;
			$this->data['users']["user"] =$arr[0]; 
			$this->data['users']["groups"]=$this->ion_auth->get_users_groups($arr["id"])->result_array();
		}
		*/
	    $this->load->helper("lookup");
	
		if(!$this->lat_auth->logged_in()):
			redirect("admin/");
		else:
			//add compatibility 
			$this->data["users"]["user"]=$_SESSION[$this->appname]["userdata"];
			$this->data["users"]["groups"]=$_SESSION[$this->appname]["groupdata"];
			$this->userdata=$_SESSION[$this->appname]["userdata"];
			$this->groupdata=$_SESSION[$this->appname]["groupdata"];
			$this->user_data=$this->userdata;
			$this->group_data=$this->groupdata;
			
			//pre($this->data);
			//pre($_SESSION[$this->appname]);
			//exit();
			//pre($_SESSION);
			//pre($_SESSION[$this->appname]["userdata"]["user"]);
			//exit();
			//debug();
			//$this->data["users"]["user"]=$this->lat_auth->get_userdata();
			//$this->data["users"]["groups"]=$this->lat_auth->groups();
			//$arrGroup=$this->lat_auth->groups();
			//$this->data["users"]["groups"]=$arrGroup;
			//exit();
			
			//USE THIS FOR GLOBAL SESSION
			//$this->user_data=$_SESSION[$this->appname]["userdata"]["user"];
			//$this->user_group=$_SESSION[$this->appname]["groupdata"]=$this->conn->GetRow("select * from groups where id='".$this->user_data['groups']."'");			

			//$this->user_prop=(!empty($this->user_data['KD_PROPINSI']))?$this->user_data['KD_PROPINSI']:0;
			//$this->user_kab=(!empty($this->user_data['KD_KABUPATEN']))?$this->user_data['KD_KABUPATEN']:0;
			//$this->user_kec=(!empty($this->user_data['KD_KECAMATAN']))?$this->user_data['KD_KECAMATAN']:0;
			//$this->id_kec=$this->user_data['id'];
			
			$this->user_data=$this->lat_auth->get_userdata();
			$this->user_prop=(!empty($this->user_data['kd_prop']))?$this->user_data['kd_prop']:0;
			$this->user_kab=(!empty($this->user_data['kd_kab']))?$this->user_data['kd_kab']:0;
			$this->user_org=(!empty($this->user_data['kd_org']))?$this->user_data['kd_org']:0;
			$this->user_instansi=(!empty($this->user_data['tipe_instansi']))?$this->user_data['tipe_instansi']:0;

			$this->adwil_level = $this->config->item('adwil_level');
			$this->kd_prop = $this->config->item('kd_prop');
			//$this->kd_kabkot = $this->config->item('kd_kabkot');
			//$this->kd_kec = $this->config->item('kd_kec');
			
			$this->adwil=$this->config->item('adwil');
			$this->lookup_all_wilayah=$this->lookup_instansi2();
			//$this->user_prop=0;
			//$this->user_kab=0;
			//$this->user_kec=0;
			//$this->user_desa=0;
			//$this->user_level=$this->get_user_level();
		endif;
		$this->load->library("cms");
		$this->cms->init();
		
		$this->admin_layout = $this->config->item('admin_theme');
		//$this->load->model("admin/messaging_model");
        //$this->model=$this->messaging_model;
		
		//$this->get_unread_message();
		
		$this->encrypt_status=FALSE;
		if($this->config->item("encrypt_id_enable")):
			$this->encrypt_status=TRUE;
		endif;
		
		$this->main_layout="admin_lte_layout/main_layout";
		 //$this->load->library("Hrms");
		
	}
	
	function lookup_instansi2($tipe=false,$kd_prop=false,$kd_kab=false,$kd_instansi=false,$merge=true) {
		$empty[""]="Semua";
		$kd="'BL','BNNP','BNNK'";
		
		$data["lookup_bl"]=$empty+m_lookup("instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK')","order by kd_instansi");
		$data["lookup_bnnp"]=$empty+m_lookup("org","kd_org","nama","active=1 and level=1","order by kd_org");
		$data["lookup_bnnk"]=$empty+m_lookup("org","kd_org","nama","active=1 and level=2","order by kd_org");
		
		if ($tipe) :
			if($tipe=="BL"):
				$empty=array();
				$kd="'BL'";
				$data["lookup_bl"]=m_lookup("instansi","kd_instansi","nama_instansi","kd_instansi='".$kd_instansi."'","order by kd_instansi");
				$data["lookup_bnnp"]=array();
				$data["lookup_bnnk"]=array();
			endif;
	
			if($tipe=="BNNP"):
				$empty=array();
				$kd="'BNNP'";
				$data["lookup_bl"]=array();
				$data["lookup_bnnp"]=m_lookup("org","kd_org","nama","kd_org='".$kd_instansi."' and active=1 and level=1","order by kd_org");
				$data["lookup_bnnk"]=array();//$empty+m_lookup("org","kd_org","nama","kd_org like '".$kd_prop."-%' and active=1 and level=2","order by kd_org");
			endif;
	
			if($tipe=="BNNK"):
				$empty=array();
				$kd="'BNNK'";
				$data["lookup_bl"]=array();
				$data["lookup_bnnp"]=array();
				$data["lookup_bnnk"]=m_lookup("org","kd_org","nama","kd_org='".$kd_instansi."' and active=1 and level=2","order by kd_org");
			endif;
		endif;

		$data["lookup_kd_instansi"]= $empty+lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in (".$kd.")","order by idx,order_num");
		if ($merge) $data["lookup_wilayah"]= $data["lookup_bl"]+$data["lookup_bnnp"]+$data["lookup_bnnk"];
		//pre($data);
		return $data;
	}
	
	function get_user_level() {
		if ($this->user_desa) {
			$level = 4;
		}
		if ($this->user_kec && !$this->user_desa) {
			$level = 3;
		}
		if ($this->user_kab && !$this->user_kec && !$this->user_desa) {
			$level = 2;
		}
		if ($this->user_prop && !$this->user_kab && !$this->user_kec && !$this->user_desa) {
			$level = 1;
		}
		return $level;
	}
	
	function lookup_adwil($propinsi=false,$kab_kota=false,$kd_kec=false) {
		$empty[]="INDONESIA";
		$data["lookup_propinsi"]=$empty+m_lookup("propinsi","KD_PROPINSI","NM_PROPINSI",false,"order by KD_PROPINSI");
		$empty[]="Semua";
		if ($propinsi) {
			$data["lookup_kabupaten"]=$empty+m_lookup("kabupaten","KD_KABUPATEN","NM_KABUPATEN","KD_PROPINSI='".$propinsi."' AND KD_KABUPATEN LIKE '7%'","order by KD_KABUPATEN");
			/*if ($kab_kota) {
				$data["lookup_kecamatan"]=$empty+m_lookup("kecamatan","KD_KECAMATAN","NM_KECAMATAN","KD_PROPINSI='".$propinsi."' AND KD_KABUPATEN='".$kab_kota."'","order by KD_KECAMATAN");
				if ($kd_kec) {
					$data["lookup_desa"]=$empty+m_lookup("desa","KD_NM_DESA","NM_DESA","KD_PROPINSI='".$propinsi."' AND KD_KABUPATEN='".$kab_kota."' AND KD_KECAMATAN='".$kd_kec."'","order by KD_KECAMATAN");
				}
			}*/
		}
		if ($this->user_prop) {
			$data["lookup_propinsi"]=m_lookup("propinsi","KD_PROPINSI","NM_PROPINSI","KD_PROPINSI='".$this->user_prop."'","order by KD_PROPINSI");
			if ($this->user_kab) {
				$data["lookup_kabupaten"]=m_lookup("kabupaten","KD_KABUPATEN","NM_KABUPATEN","KD_PROPINSI='".$this->user_prop."' AND KD_KABUPATEN='".$this->user_kab."' AND KD_KABUPATEN LIKE '7%'","order by KD_KABUPATEN");
				/*if ($this->user_kec) {
					$data["lookup_kecamatan"]=m_lookup("kecamatan","KD_KECAMATAN","NM_KECAMATAN","KD_PROPINSI='".$this->user_prop."' AND KD_KABUPATEN='".$this->user_kab."' AND KD_KECAMATAN='".$this->user_kec."'","order by KD_KECAMATAN");
					if ($this->user_desa) {
						$data["lookup_desa"]=m_lookup("desa","KD_NM_DESA","NM_DESA","KD_PROPINSI='".$this->user_prop."' AND KD_KABUPATEN='".$this->user_kab."' AND KD_KECAMATAN='".$this->user_kec."' AND KD_NM_DESA='".$this->user_desa."'","order by KD_KECAMATAN");
					}
					else {
						$data["lookup_desa"]=$empty+m_lookup("desa","KD_NM_DESA","NM_DESA","KD_PROPINSI='".$this->user_prop."' AND KD_KABUPATEN='".$this->user_kab."' AND KD_KECAMATAN='".$this->user_kec."'","order by KD_KECAMATAN");
					}
				}
				else {
					$data["lookup_kecamatan"]=$empty+m_lookup("kecamatan","KD_KECAMATAN","NM_KECAMATAN","KD_PROPINSI='".$this->user_prop."' AND KD_KABUPATEN='".$this->user_kab."'","order by KD_KECAMATAN");
				}*/
			}
			else {
				$data["lookup_kabupaten"]=$empty+m_lookup("kabupaten","KD_KABUPATEN","NM_KABUPATEN","KD_PROPINSI='".$this->user_prop."' AND KD_KABUPATEN LIKE '7%'","order by KD_KABUPATEN");
			}
		}
		//pre($data);
		return $data;
	}
	function meta_wilayah($kd_prop=false,$kd_kab=false,$kd_kec=false,$kd_desa=false) {
		if ($kd_prop && !$kd_kab && !$kd_kec && !$kd_desa) {
			$meta['key']='lookup_propinsi';
			$meta['kd']=$kd_prop;
			$meta['prefix']='Propinsi';
			$meta['tbl']='m_propinsi';
		}
		if ($kd_prop && $kd_kab && !$kd_kec && !$kd_desa) {
			$meta['key']='lookup_kabupaten';
			$meta['kd']=$kd_kab;
			$meta['prefix']='';
			$meta['tbl']='m_kabupaten';
		}
		if ($kd_prop && $kd_kab && $kd_kec && !$kd_desa){
			$meta['key']='lookup_kecamatan';
			$meta['kd']=$kd_kec;
			$meta['prefix']='Kecamatan';
			$meta['tbl']='m_kecamatan';
		}
		if ($kd_desa){
			$meta['key']='lookup_desa';
			$meta['kd']=$kd_desa;
			$meta['prefix']='Desa/Kelurahan';
			$meta['tbl']='m_desa';
		}
		return $meta;
	}
}