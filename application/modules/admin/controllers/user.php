<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends Admin_Controller {

    function __construct(){
        parent::__construct();
        
        $this->load->helper(array('form', 'url','file','language','lookup','bootstrap_helper'));
    	$this->folder="admin/";
		$this->module=$this->folder."user/";
        $this->http_ref=base_url().$this->module;


		$this->parent_module_title="Account Manager";
		$this->module_title="User";
		$this->lang->load('auth');
		$this->load->model("user_model");
		$this->model=$this->user_model;
		$this->tbl_idx="id";
		$this->auth_error_page="admin/error_page";
		
		$empty[]="";
		$this->lookup_tipe_org=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","","order by order_num");
		$this->lookup_org=lookup("m_org","kd_org","nama");
		$this->lookup_instansi=lookup("m_instansi","kd_instansi","nama_instansi");
		$this->lookup_tipe_wil=$empty+lookup("m_group_wilayah","ur_tipe_wil","ur_tipe_wil","","order by order_num");
    }
	
	function index(){
		//if (!$this->cms->has_view($this->module)) redirect ("admin/error");
   		//debug();
		$this->load->library('pagination');  
            
        $queryString=rebuild_query_string();
        
        $field="first_name,last_name,username";
        $whereSql=get_where_from_searchbox($field);

		//Administratif hierarchy
		$kd_prop=($this->user_prop)?$this->user_prop:$this->input->get_post('kd_prop');			
		$kd_kab=($this->user_kab)?$this->user_kab:$this->input->get_post('kd_kab');			
		$kd_kec = ($this->user_kec)?$this->user_kec:$this->input->get_post('kd_kec');
		$kd_desa = ($this->user_desa)?$this->user_desa:$this->input->get_post('kd_desa');
		if ($this->adwil_level>0) {
			$kd_prop=$this->kd_prop;//$_GET['propinsi'];
		}
		if ($this->adwil_level>1) {
			$kd_kab=$this->kd_kabkot;//$_GET['kab_kota'];
		}
		if ($this->adwil_level>2) {
			$kd_kec = $this->kd_kec;
		}
		if ($this->adwil_level>3) {
			$kd_desa = $this->kd_desa;
		}
		
		$filter="";$op="";
		$key = ($this->input->get_post('q'))?$this->input->get_post('q'):false;
		if ($key) {
			//$filter = "(nik like '%".$key."%' or nama like '%".$key."%')";
			$where[]="(".$whereSql.")";
			$data["key"]=$key;
		}
		if ($kd_prop) {
			$where[] = "(KD_PROPINSI='".$kd_prop."')";
			$nm = "KABUPATEN";
			$kd = "KD_KABUPATEN";
			$level=1;
		}
		if ($kd_kab) {
			$where[] = "(KD_KABUPATEN='".$kd_kab."')";
			$nm = "KECAMATAN";
			$kd = "KD_KECAMATAN";
			$level=2;
		}
		if ($kd_kec) {
			$where[] = "(KD_KECAMATAN='".$kd_kec."')";
			$nm = "Desa/Kelurahan";
			$kd = "KD_DESA";
			$level=3;
		}
		if ($kd_desa) {
			$where[] = "(KD_DESA='".$kd_desa."')";
			$nm = "TPS";
			$level=4;
		}
		
		if(cek_array($where)):
            $filter=join(" and ",$where);
        endif;
		$data["kd_prop"]=$kd_prop;
		$data["kd_kab"]=$kd_kab;
		$data["kd_kec"]=$kd_kec;
		$data["kd_desa"]=$kd_desa;
		$data["nm_wilayah"]=$nm;
		$data["tab_active"]=$this->input->get_post('t');
		
		//$data['sumData']=$this->pv_summary_model->sum_wilayah($kd_prop,$kd_kab,$kd_kec,$kd_desa);
		//$data['sumPv']=$this->pv_summary_model->jumlah_target_pv($filter);
		
		
		$perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"50";
        $data["perPage"]=$perPage;

        $uriSegment=4;
        $totalRows=$this->lat_auth->total_users($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
		$sortBy = 'order by id';
		if ($forder) {
			$spl = preg_split("/:/",$this->input->get_post('forder'));
			$sortBy = 'order by '.$spl[0].' '.$spl[1];
			$data["forder"]=$spl[0];
			$data["dorder"]=$spl[1];
		}
        $config['base_url'] = $this->module."index";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=str_replace("t=0","t=".$this->input->get_post('t'),$queryString);
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
		
		//get data
		//$arrDB=$this->model->SearchRecordLimitWhere($filter,$perPage,$offset,$sortBy);
		$arrDB=$this->lat_auth->users($filter,$perPage,$offset,$sortBy);
				
		$lookup = $this->lookup_adwil($kd_prop,$kd_kab,$kd_kec,$kd_desa);
		$data = array_merge($data,$lookup);
		
		//META WILAYAH
		$meta_wilayah = $this->meta_wilayah($kd_prop,$kd_kab,$kd_kec,$kd_desa);
		$data["nama_wilayah"]=$meta_wilayah['prefix']." ".($lookup[$meta_wilayah['key']][$meta_wilayah['kd']]);

		$data["query_str"]=$queryString;
		$data["arrData"]=$arrDB;
		
		
		$data["content"]=$this->load->view($this->module."v_list",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
	}
	
	function indexx(){
        if (!$this->cms->has_view($this->module)) redirect ($this->auth_error_page);
	   	$this->load->library('pagination');  
            
        $queryString=rebuild_query_string();
        
        $field="first_name,last_name,username";
        $whereSql=get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
        
        $whereSql="";
        
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
        // debug();
        $perPage=$this->input->get_post("pp")?$this->input->get_post("pp"):"10";
        $data["perPage"]=$perPage;

        $uriSegment=4;
        $totalRows=$this->lat_auth->total_users($whereSql);
        $offset=$totalRows>$perPage?(int)$this->uri->segment($uriSegment):0;
        $sortBy=" order by id";
        

        $config['base_url'] = $this->module."index";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        //$config['display_pages'] = FALSE;
        $this->pagination->initialize($config);
        // pre($arrData);exit;
		
		$data["arrData"]=$this->lat_auth->users($whereSql,$perPage,$offset,$sortBy);

		$data["acc_active"]=$this->acc_active;
        $data["content"]=$this->load->view($this->module."v_list",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
    function add(){
        //if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);

        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=array();
			
			//Administratif hierarchy
			$kd_prop=($this->user_prop)?$this->user_prop:$this->input->get_post('kd_prop');			
			$kd_kab=($this->user_kab)?$this->user_kab:$this->input->get_post('kd_kab');			
			$kd_kec = ($this->user_kec)?$this->user_kec:$this->input->get_post('kd_kec');
			$kd_desa = ($this->user_desa)?$this->user_desa:$this->input->get_post('kd_desa');
			if ($this->adwil_level>0) {
				$kd_prop=$this->kd_prop;//$_GET['propinsi'];
			}
			if ($this->adwil_level>1) {
				$kd_kab=$this->kd_kabkot;//$_GET['kab_kota'];
			}
			if ($this->adwil_level>2) {
				$kd_kec = $this->kd_kec;
			}
			if ($this->adwil_level>3) {
				$kd_desa = $this->kd_desa;
			}
			
			$data["kd_prop"]=$kd_prop;
			$data["kd_kab"]=$kd_kab;
			$data["kd_kec"]=$kd_kec;
			$data["kd_desa"]=$kd_desa;
			$lookup = $this->lookup_adwil($kd_prop,$kd_kab,$kd_kec,$kd_desa);

			$data = array_merge($data,$lookup);
        endif;
        //debug();
        if($act=="create"):
			
			//debug();
			
            $data=get_post();
			
			//pre($data);
			
			if ($this->lat_auth->register($data)) :
				redirect($this->module);
			else:
				redirect($this->module."/add");
			endif;
			
			
			
        endif;
		
		$data["content"]=$this->load->view($this->module."v_add",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
    
     function edit($id){
        //if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);
		
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
           	$data["data"]=$this->lat_auth->user($id);
			//Administratif hierarchy
			$kd_prop=($this->user_prop)?$this->user_prop:$data["data"]['KD_PROPINSI'];			
			$kd_kab=($this->user_kab)?$this->user_kab:$data["data"]['KD_KABUPATEN'];	
			//Kecamatan & desa tidak dipakai		

			if ($this->adwil_level>0) {
				$kd_prop=$this->kd_prop;//$_GET['propinsi'];
			}
			if ($this->adwil_level>1) {
				$kd_kab=$this->kd_kabkot;//$_GET['kab_kota'];
			}
			
			$data["kd_prop"]=$kd_prop;
			$data["kd_kab"]=$kd_kab;
			$lookup = $this->lookup_adwil($kd_prop,$kd_kab);

			$data = array_merge($data,$lookup);
        endif;
        if($act=="update"):
			
            $data=get_post();
			
			if ($this->lat_auth->update_user($data['id'],$data)):
				redirect($this->module."edit/".$id);
			else:
				$data['data']=$data;
			endif;
        endif;
		$data["content"]=$this->load->view($this->module."v_edit",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
	//Lat Auth udah mendeteksi $this->encrypt_status, jadi masukkan id apa adanya
	function del($id=false){
  		//if (!$this->cms->has_admin($this->module)) redirect ("admin/error");
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
      
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data["data"]=$this->lat_auth->user($id);
        endif;
        if($act=="delete"):debug();
			$data=get_post();
			$id=$data['id'];
			$data=$this->lat_auth->user($id);
            $ok=$this->lat_auth->delete_user($id,$data);
            $this->_proses_message($ok,$this->module,$this->module."del/$id_enc");
        endif;
    }
    
	//MY PROFILE
	function profil(){
        //if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
           	$data["data"]=$this->lat_auth->user();
        endif;
        if($act=="update"):
            $data=get_post();
			if ($this->lat_auth->update_user($data['id'],$data)):
				redirect($this->module."profil/");
			else:
				$data['data']=$data;
			endif;
        endif;
		$data["content"]=$this->load->view($this->module."v_profil",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
	
    function _proses_message($ok,$url_ok=false,$url_error=false){
        $url_ok=$url_ok?$url_ok:$this->module;
        $url_error=$url_error?$url_error:$this->module;
        if(!$this->input->is_ajax_request()):    
            if($ok):
                    set_message("success", $this->msg_ok);
                    redirect($url_ok);
            else:
                    set_message("error",$this->msg_fail);
                    redirect($url_error);
            endif;  
        else:
            if($ok):
                 print "ok";
            else:
                print "failed";
            endif;    
        endif;
    }
    
    function _render_page($view, $data=null, $render=false)
    {
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $render);
        if($render):
            $datam["acc_active"]=$this->acc_active;
            $datam["content"]=$view_html;
            $this->load->view("admin_layout/main_layout",$datam);
        endif;
        //if (!$render) return $view_html;
    }
	
	function activate($id){
		$this->msg_ok="Activate successfully";
        $this->msg_fail="Unable to activate user";
		$id=$this->encrypt_status==TRUE?decrypt($id):$id;
		
		$dataUpdate["active"]=1;
		$this->conn->StartTrans();
		$this->model->UpdateData($dataUpdate,"id=$id");
		$ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."",$this->module."");
	}
	
	function deactivate($id){
		$this->msg_ok="Deactivate successfully";
        $this->msg_fail="Unable to deactivate user";
		$id=$this->encrypt_status==TRUE?decrypt($id):$id;
		
		$dataUpdate["active"]=0;
		
		$this->conn->StartTrans();
		$this->model->UpdateData($dataUpdate,"id=$id");
		$ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."",$this->module."");
	}
	
	
}
