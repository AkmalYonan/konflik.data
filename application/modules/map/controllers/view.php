<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class view extends Admin_Controller {

    function __construct(){

        parent::__construct();
        $this->load->helper(array('form', 'url','file','language','lookup','bootstrap_helper'));
        $class_folder=basename(dirname(__DIR__));
        $class=__CLASS__;
		
		$this->class=$class;
		$this->$class_folder=$class_folder;
		
        $this->folder=$class_folder."/";
        $this->module=$this->folder.$class."/";
        $this->http_ref=base_url().$this->module;
		$this->lang->load('auth');

        $this->load->model("general_model");
        //$this->model=new general_model("t_jp_spp");
        //$this->load->model("stok_model");
        //$this->load->model("spp_model");

		$this->tbl_idx="id";
		$this->auth_error_page="admin/error_page";
        $this->module_title="stok";
		
		$empty[]="Semua";
		//$this->lookup_ec=m_lookup("lookup","uniqid","nama","kode='ec_kat'","order by sort");
//		$this->lookup_ec_color=m_lookup("lookup","uniqid","varchar_1","kode='ec_kat'","order by sort");
//		$this->lookup_fk=$empty+m_lookup("jp_spp","code","name","depth='1'","order by code");
//		$this->lookup_year=$this->list_tahun();
    }
	
   	function index(){
		//if (!$this->cms->has_view($this->module)) redirect ("admin/error");
   		//debug();
            
		//Administratif hierarchy
		$kd_prop=($this->user_prop)?$this->user_prop:$this->input->get_post('kd_prop');			
		$kd_kab=($this->user_kab)?$this->user_kab:$this->input->get_post('kd_kab');			

		if ($this->adwil_level>0) {
			$kd_prop=$this->kd_prop;//$_GET['propinsi'];
		}
		if ($this->adwil_level>1) {
			$kd_kab=$this->kd_kabkot;//$_GET['kab_kota'];
		}

		$filter="";$op="";
		$key = ($this->input->get_post('fk'))?$this->input->get_post('fk'):false;
		$tahun = ($this->input->get_post('tahun'))?$this->input->get_post('tahun'):date("Y");
		if ($key) {
			$where[] = "(code like '".$key."%')";
		}
		if ($tahun) {
			$where[] = "(tahun='".$tahun."')";
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
		
		if(cek_array($where)):
            $filter=join(" and ",$where);
        endif;
		$data["key"]=$key;
		$data["tahun"]=$tahun;
		$data["kd_prop"]=$kd_prop;
		$data["kd_kab"]=$kd_kab;
		$data["nm_wilayah"]=$nm;
		$data["tab_active"]=$this->input->get_post('t');

		$sortBy = 'order by code';
		//get data
		//$arrDB = $this->spp_model->getData($kd_prop,$kd_kab,$tahun,$key);
		//pre($arrDB);
		$lookup = $this->lookup_adwil($kd_prop,$kd_kab,$kd_kec,$kd_desa);
		$data = array_merge($data,$lookup);
		
		//META WILAYAH
		$meta_wilayah = $this->meta_wilayah($kd_prop,$kd_kab,$kd_kec,$kd_desa);
		$data["nama_wilayah"]=$meta_wilayah['prefix']." ".($lookup[$meta_wilayah['key']][$meta_wilayah['kd']]);

		$data["query_str"]=$queryString;
		
		$data["content"]=$this->load->view($this->module."v_list",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
		
		//$this->load->view($this->module."v_test",$data);
	}
	
	function leaf(){
		//if (!$this->cms->has_view($this->module)) redirect ("admin/error");
   		//debug();
            
		//Administratif hierarchy
		$kd_prop=($this->user_prop)?$this->user_prop:$this->input->get_post('kd_prop');			
		$kd_kab=($this->user_kab)?$this->user_kab:$this->input->get_post('kd_kab');			

		if ($this->adwil_level>0) {
			$kd_prop=$this->kd_prop;//$_GET['propinsi'];
		}
		if ($this->adwil_level>1) {
			$kd_kab=$this->kd_kabkot;//$_GET['kab_kota'];
		}

		$filter="";$op="";
		$key = ($this->input->get_post('fk'))?$this->input->get_post('fk'):false;
		$tahun = ($this->input->get_post('tahun'))?$this->input->get_post('tahun'):date("Y");
		if ($key) {
			$where[] = "(code like '".$key."%')";
		}
		if ($tahun) {
			$where[] = "(tahun='".$tahun."')";
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
		
		if(cek_array($where)):
            $filter=join(" and ",$where);
        endif;
		$data["key"]=$key;
		$data["tahun"]=$tahun;
		$data["kd_prop"]=$kd_prop;
		$data["kd_kab"]=$kd_kab;
		$data["nm_wilayah"]=$nm;
		$data["tab_active"]=$this->input->get_post('t');
		
		$sortBy = 'order by code';
		//get data
		$arrDB = $this->spp_model->getData($kd_prop,$kd_kab,$tahun,$key);
		//pre($arrDB);
		$lookup = $this->lookup_adwil($kd_prop,$kd_kab,$kd_kec,$kd_desa);
		$data = array_merge($data,$lookup);
		
		//META WILAYAH
		$meta_wilayah = $this->meta_wilayah($kd_prop,$kd_kab,$kd_kec,$kd_desa);
		$data["nama_wilayah"]=$meta_wilayah['prefix']." ".($lookup[$meta_wilayah['key']][$meta_wilayah['kd']]);

		$data["query_str"]=$queryString;
		
		$data["content"]=$this->load->view($this->module."v_leaf",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
		
		//$this->load->view($this->module."v_test",$data);
	}
	
	
	function add(){
        //if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);

        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=get_post();
			$data["propinsi"]=$this->kd_prop;
			$data["kab_kota"]=$this->kd_kabkot;
			$data["kd_kec"]=$this->kd_kec;

			$lookup = $this->lookup_adwil($this->kd_prop,$this->kd_kabkot);

			$data = array_merge($data,$lookup);

			$data["prop_name"]=$lookup["lookup_propinsi"][$this->kd_prop];
			$data["kabkot_name"]=$lookup["lookup_kabupaten"][$this->kd_kabkot];
			$data["kec_name"]=$lookup["lookup_kecamatan"][$this->kd_kec];
        endif;
        if($act=="create"):
            $data=get_post();

			$this->conn->StartTrans();
			if (cek_array($data['spp'])) {
				$in=false;
				foreach($data['spp'] as $k=>$v) {
					if ($v['target'] || $v['kebutuhan_standar'] || $v['eksisting'] || $v['spp']) {
						$in=$v;
						$in['KD_PROPINSI']=$data['KD_PROPINSI'];
						$in['KD_KABUPATEN']=$data['KD_KABUPATEN'];
						$in['tahun']=$data['tahun'];
						$in['bidx']?$this->model->UpdateData($in,"idx='".$in['bidx']."'"):$this->model->InsertData($in);
					}
				}
			}
			$ok=$this->conn->CompleteTrans();
			
			if ($ok):
				redirect($this->module."?kd_prop=".$data['KD_PROPINSI']."&kd_kab=".$data['KD_KABUPATEN']."&tahun=".$data['tahun']);
			else:
				$data['data']=$data;
			endif;
        endif;
		$data["content"]=$this->load->view($this->module."v_add",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
	function pop($kd){
        //if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);
		if($this->encrypt_status==TRUE):
			$kd_enc=$kd;
			$kd=decrypt($kd);
		endif;
		
		$arrDB=$this->model->GetRecordData("idx='".$kd."'");
		$data["data"]=$arrDB;
		$data["id"]=$kd_enc;
		
		$this->load->view($this->module."v_pop",$data);
    }
    
     function edit($kd){
        //if (!$this->cms->has_write($this->module)) redirect ($this->auth_error_page);
        $data=get_post();

        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
			if($this->encrypt_status==TRUE):
				$kd_enc=$kd;
				$kd=decrypt($kd);
			endif;
			
			$arrDB=$this->model->GetRecordData("idx='".$kd."'");
			$data["data"]=$arrDB;
			$data["id"]=$kd_enc;
        endif;
        if($act=="update"):
            $data=get_post();
			if($this->encrypt_status==TRUE):
				$kd_enc=$data['id'];
				$kd=decrypt($data['id']);
			endif;
			
			$config['allowed_types']	= "jpg|jpeg|png|pdf|xls|xlsx|doc|docx";
			$config['upload_path']		= $this->config->item("full_dir_app").$this->config->item("dir_lampiran_media");
			$config['max_size']			= "1000000";
			$config['overwrite']		= TRUE;
		
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('image_name');
			
			$file						=	$this->upload->data();
			//pre($file);exit;
			
			if($file['file_ext']):
				$data['lampiran']=$file['file_name'];
			endif;
			
			$this->conn->StartTrans();
			$this->model->UpdateData($data,"idx='".$kd."'");
			$ok=$this->conn->CompleteTrans();
			
			if ($ok):
				redirect($this->module."edit/".$kd_enc);
			else:
				$data['data']=$data;
			endif;
        endif;
		$data["content"]=$this->load->view($this->module."v_edit",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }
    
    function delete($id){
        if (!$this->cms->has_admin($this->module)) redirect ($this->auth_error_page);

        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
			if($this->encrypt_status==TRUE):
				$kd_enc=$kd;
				$kd=decrypt($kd);
			endif;
			$kd = preg_split("/\./",$kd);
			
			$arrDB=$this->model->GetRecordData("KD_PROPINSI='".$kd[0]."' AND KD_KABUPATEN='".$kd[1]."' AND KD_KECAMATAN='".$kd[2]."' AND KD_DESA='".$kd[3]."'");
			$data["data"]=$arrDB;
			$data["id"]=$kd_enc;
			$data["propinsi"]=$arrDB['KD_PROPINSI'];
			$data["kab_kota"]=$arrDB['KD_KABUPATEN'];
			$data["kd_kec"]=$arrDB['KD_PROPINSI'];
			$data["kd_desa"]=$arrDB['KD_DESA'];

			$lookup = $this->lookup_adwil($arrDB['KD_PROPINSI'],$arrDB['KD_KABUPATEN']);

			$data = array_merge($data,$lookup);

			$data["prop_name"]=$lookup["lookup_propinsi"][$arrDB['KD_PROPINSI']];
			$data["kabkot_name"]=$lookup["lookup_kabupaten"][$arrDB['KD_KABUPATEN']];
			$data["kec_name"]=$lookup["lookup_kecamatan"][$arrDB['KD_KABUPATEN']];

        endif;
        if($act=="delete"):
            $data=get_post();
			if ($this->lat_auth->delete_user($data['id'],$data)):
				redirect($this->module);
			else:
				$data['data']=$data;
			endif;
        endif;
		$data["content"]=$this->load->view($this->module."user_delete2",$data,true);
		$this->load->view($this->admin_layout."/main_layout",$data);
    }

  function view($idx=false){
  	
  	$arrDB=$this->model->GetRecordData("idx='{$idx}'");
  	//$arrDB['news_content']=$this->utils->closetags($arrDB['news_content']);
  	$data["data"]=$arrDB;
  	
  	//print_r($data);exit;
  	$data["user_name"]=$this->data['users']['user']['username'];
  	$data["acc_active"]="content";
  	$data["module"]=$this->module;
  	$data_layout["content"]=$this->load->view("modul_rumkit/view",$data,true);
  	$this->load->view($this->admin_layout,$data_layout);
  }
  
  
  
  
	function read_import(){
	$c1 = ($this->user_prop) ? $this->user_prop.".":($_POST['c_prop'])?$_POST['c_prop'].".":false;
	$c2 = ($this->user_kab)  ? $this->user_kab.".":($_POST['c_kabkot'])?$_POST['c_kabkot'].".":false;
	$c3 = ($this->user_kec)  ? $this->user_kec:($_POST['c_kec'])?$_POST['c_kec']:false;
	
	$kd_user = $c1.$c2.$c3;// pre($kd_user);exit;
  	if ($_SERVER['REQUEST_METHOD']=='POST'){
  		$fileName = $_FILES['import']['name'];
  		 
  		$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_import');
  		$config['file_name'] = $fileName;
  		$config['allowed_types'] = 'xls|xlsx|csv';
  		$config['max_size']        = 10000;
  		$this->load->library('upload');
  		$this->upload->initialize($config);
  		 
  		if(!$this->upload->do_upload('import'))
  			$this->upload->display_errors();
  		 
  		$media = $this->upload->data('import');
  		$inputFileName = $_SERVER['DOCUMENT_ROOT'].$this->config->item('dir_import').$media['file_name'];
  	
  		//  Read your Excel workbook
  		try {
  			$inputFileType = IOFactory::identify($inputFileName);
  			$objReader = IOFactory::createReader($inputFileType);
  			$objPHPExcel = $objReader->load($inputFileName);
  		} catch(Exception $e) {
  			die('Error loading file"'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
  		}
  		//  Get worksheet dimensions
		$numSheets = $objPHPExcel->getSheetCount();
		//pre($numSheets);exit;
		
		for ($i=0; $i<$numSheets; $i++) {
			//$sheet = $objPHPExcel->getSheet($i);
			$sheet =  $objPHPExcel->setActiveSheetIndex($i);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			
			//Sheet title
			$title[$i]=$sheet->getTitle();
			// put this at beginning of your script
			$saveTimeZone = date_default_timezone_get();
			date_default_timezone_set('UTC'); // PHP's date function uses this value!
			
			//$xlsFile = 'sample.xlsx';
		
			//  Loop through each row of the worksheet in turn
			for ($row = 0; $row <= $highestRow; $row++){                  
  				//  Read a row of data into an array
  				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
  					NULL,
  					TRUE,
  					FALSE);
  	
  				//get only the Cell Collection
  			
  				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
  				//extract to a PHP readable array format
  		
  				foreach ($cell_collection as $cell) {
  				
					$column 	= $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
					$row 		= $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
					$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					
					
					if($row>4){
						if ($column=='A') {
							$spl = preg_split("/\./",$data_value);

							if (preg_match("/".$kd_user."/i", $data_value)) {
								$has_right = true;
							} else {
								$has_right = false;
							}
							$row_id[$row] = $this->model->get_id_by_kdkec($spl[0],$spl[1],$spl[2]);
						}
						if($has_right):
							$arr_data[$i][$row][$column] = $data_value;
						else:
							set_message("success","Import Data Denied.");
							redirect("admin/kecamatan");
						endif;
							
					}
  				
  				}
				//pre ($arr_data);exit;
			}
  			
  		}
			//pre ($arr_data);exit;
  			//send the data in an array format
			//if (!$has_right) {
			//	pre("You Have No Right");
			//}
			//else {
				//pre($row_id);exit;
				$data['row_id'] = $row_id;
				$data['cols'] = $this->config->item('map');
				$data['values'] = $arr_data;
				$data['title'] = $title;
		
				
				$data["module"]=$this->module;
				$data["user_name"]=$this->data['users']['user']['username'];
				$data["acc_active"]="content";
				$data["process"]=$process;
	
				$data_layout["content"]=$this->load->view("kecamatan/re_import_view",$data,true);
				$this->load->view($this->admin_layout,$data_layout);
			//}
  	
  	}
  }
  function _list_kode() {
	  $arrDB=$this->model->_list_kode();
	  if (cek_array($arrDB)) {
		foreach ($arrDB as $k=>$v) {
			$arr[$v['idx']]=$v['c_a'];	
		}
		return $arr;
	  }
  }
  function add_(){
  	//$list_kode = $this->_list_kode();
	//debug();
  	//$data["module"]=$this->module;
  	if ($_SERVER['REQUEST_METHOD']=='POST') {
	//pre($_POST['data']);exit;
	
  		if (cek_array($_POST['data'])) :
			$this->conn->StartTrans();
			$c_du=false;$c_dp=false;$c_dk=false;
			foreach($_POST['data'] as $k=>$v) :
				if ($v['id_kecamatan']):
					//data_umum
					//$c_du = $this->model->cek_data("data_umum",$v['id_kecamatan'],$v['tahun']);
					$data['id_kecamatan']					=	$v['id_kecamatan'];
					$data['tahun']							=	$v['1'];
					$data['luas']							=	$v['2'];
					$data['batas_utara']					=	$v['3'];
					$data['batas_selatan']					=	$v['4'];
					$data['batas_barat']					=	$v['5'];
					$data['batas_timur']					=	$v['6'];
					$data['orbitrasi_kabkot']				=	$v['7'];
					$data['orbitrasi_provinsi']				=	$v['8'];
					$data['jml_tanah_bersertifikat_buah']	=	$v['9'];
					$data['jml_tanah_bersertifikat_ha']		=	$v['10'];
					$data['jml_penduduk_jiwa']				=	$v['11'];
					$data['jml_penduduk_kk']				=	$v['12'];
					$data['jml_penduduk_l']					=	$v['13'];
					$data['jml_penduduk_p']					=	$v['14'];
					$data['jml_penduduk_0_15']				=	$v['15'];
					$data['jml_penduduk_15_65']				=	$v['16'];
					$data['jml_penduduk_65']				=	$v['17'];
					$data['mp_pns']							=	$v['18'];
					$data['mp_tni_polri']					=	$v['19'];
					$data['mp_swasta']						=	$v['20'];
					$data['mp_wiraswasta']					=	$v['21'];
					$data['mp_tani']						=	$v['22'];
					$data['mp_pertukangan']					=	$v['23'];
					$data['mp_buruh_tani']					=	$v['24'];
					$data['mp_pensiunan']					=	$v['25'];
					$data['mp_nelayan']						=	$v['26'];
					$data['mp_peternak']					=	$v['27'];
					$data['mp_jasa']						=	$v['28'];
					$data['mp_pengarajin']					=	$v['29'];
					$data['mp_seni']						=	$v['30'];
					
					$data['mp_lainnya']						=	$v['31'];
					$data['mp_pengangguran']				=	$v['32'];
					$data['tpm_umum_tk']					=	$v['33'];
					$data['tpm_umum_sd']					=	$v['34'];
					$data['tpm_umum_smp']					=	$v['35'];
					$data['tpm_umum_sma']					=	$v['36'];
					$data['tpm_umum_akademi']				=	$v['37'];
					$data['tpm_umum_s1']					=	$v['38'];
					$data['tpm_umum_s2']					=	$v['39'];
					$data['tpm_umum_s3']					=	$v['40'];
					
					$data['tpm_khusus_pesantren']			=	$v['41'];
					$data['tpm_khusus_keagamaan']			=	$v['42'];
					$data['tpm_khusus_slb']					=	$v['43'];
					$data['tpm_khusus_keterampilan']		=	$v['44'];
					$data['jml_penduduk_miskin_jiwa']		=	$v['45'];
					$data['jml_penduduk_miskin_kk']			=	$v['46'];
					$data['umk']							=	$v['47'];
					$data['sarpras_kantor']					=	$v['48'];
					$data['sarpras_puskesmas']				=	$v['49'];
					$data['sarpras_posyandu']				=	$v['50'];
					
					$data['sarpras_poliklinik']				=	$v['51'];
					$data['sarpras_paud']					=	$v['52'];
					$data['sarpras_tk']						=	$v['53'];
					$data['sarpras_sd']						=	$v['54'];
					$data['sarpras_smp']					=	$v['55'];
					$data['sarpras_sma']					=	$v['56'];
					$data['sarpras_pt']						=	$v['57'];
					$data['sarpras_masjid']					=	$v['58'];
					$data['sarpras_mushola']				=	$v['59'];
					$data['sarpras_gereja']					=	$v['60'];
					
					$data['sarpras_pura']					=	$v['61'];
					$data['sarpras_vihara']					=	$v['62'];
					$data['sarpras_klenteng']				=	$v['63'];
					$data['sarpras_olahraga']				=	$v['64'];
					$data['sarpras_kesenian']				=	$v['65'];
					$data['sarpras_balai']					=	$v['66'];
					$data['sarpras_lain']					=	$v['67'];
					
					
					$_pers['id_kecamatan']	=	$v['id_kecamatan'];
					$_pers['tahun']	=	$v['1'];
					$_pers['nama']		=	$v['68'];
					
					$_pers['pangkat_golongan']		=	$v['69'];
					$_pers['nip']		=	$v['70'];
					
					
					
					$_pers['pendidikan']		=	$v['71'];
					$_pers['tmt_jabatan']		=	$v['72'];
					//$data['']		=	$v['73'];
					if($v['74']="L" or $v['74']="l"):
					$_pers['jenis_kelamin']		=	"1";
					else:
					$_pers['jenis_kelamin']		=	"0";
					endif;
					
					$_pers['jml_golongan_1']		=	$v['75'];
					$_pers['jml_golongan_1']		=	$v['76'];
					$_pers['jml_golongan_1']		=	$v['77'];
					$_pers['jml_golongan_1']		=	$v['78'];
					
					
					$_data['id_kecamatan']					=	$v['id_kecamatan'];
					$_data['tahun']							=	$v['1'];
					$_data['anggaran_kecamatan']			=	$v['79'];
					
					$c_du = $this->model->cek_data("data_umum",$v['id_kecamatan'],$v['1']);
					
					//pre($c_du);exit;
					//pre($this->model->attr_insert("data_umum",$data));exit;
					

					if ($c_du) {
						//$this->model->attr_update("data_umum",$v,"id_data_umum='".$c_du."'");
						$this->model->attr_update("data_umum",$data,"id_data_umum='".$c_du."'");
					}
					else {
						//$this->model->attr_insert("data_umum",$v);
						$this->model->attr_insert("data_umum",$data);
					}
					
					
					//data_personil
					
					//pre($this->model->attr_insert("data_personil",$_pers));exit;
					
					$c_dp = $this->model->cek_data("data_personil",$v['id_kecamatan'],$v['1']);
					if ($c_dp) {
						$this->model->attr_update("data_personil",$_pers,"id_data_personil='".$c_dp."'");
					}
					else {
						$this->model->attr_insert("data_personil",$_pers);
					}
					
					//data_keuangan
					
					$c_dk = $this->model->cek_data("data_keuangan",$v['id_kecamatan'],$v['1']);
					if ($c_dk) {
						$this->model->attr_update("data_keuangan",$_data,"id_data_keuangan='".$c_dk."'");
					}
					else {
						$this->model->attr_insert("data_keuangan",$_data);
					}
				endif;
			endforeach;
			$ok=$this->conn->CompleteTrans();
			
			//pre($ok);exit;
			if ($ok) {
				set_message("success","Process Data Success.");
				$data["redirect"]=true;
				redirect("admin/kecamatan/");
			}
		endif;
  	}
  	else{
  		$data["process"]=false;
  	}
  }
  
  function download_(){
  	
  	$this->load->helper('download');
  	
  	$nama ='testmono_copy.xlsx';
  	$data = file_get_contents("assets/file/lengkap.xlsx");
  	
  	force_download($nama,$data);
  	
  }
  
  function attr_update($kode=false){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			debug();
			$_data=get_post();
			$_data["created"]=date("Y-m-d h:i:s",time());
			if($this->encrypt_status==TRUE):
				$id_enc=$_data['idx'];
				$id=decrypt($_data['idx']);
				$_data['id_kecamatan']=$id;
			endif;
			pre($_data);
			if ($_FILES['image_name']['name']) {
				$app_path = $this->config->item('full_dir_app');
				$img_path = $this->config->item('dir_kecamatan_image');
				$fix_name = "logo_".$id.substr($_FILES['image_name']['name'],strrpos($_FILES['image_name']['name'],"."));
				$tmp_name = $_FILES['image_name']['tmp_name'];
				$new_name = $app_path.$img_path.$fix_name;
				
				move_uploaded_file($tmp_name,$new_name);
				
				$_data["filename"]=$fix_name;
			}
			

			$this->conn->StartTrans();
			$check = $this->model->attr_get($_data['attr'],"id_kecamatan='".$id."' and tahun='".$_data['tahun']."'");
			if ($check) {
				$proses = $this->model->attr_update($_data['attr'],$_data,"id_kecamatan='".$id."'");
				$id_parent = $this->model->attr_idx_by_id($_data['attr'],$id,'id_'.$_data['attr']);
			}
			else {
				$proses = $this->model->attr_insert($_data['attr'],$_data);
				$id_parent = $this->model->attr_last_idx($_data['attr'],'id_'.$_data['attr']);
			};

			if ($_data['tb_detil']) {
				//delete content detail
				$this->model->attr_delete($_data['attr']."_detil","id_parent='".$id_parent."'");
				foreach($_POST['tb_detil'] as $k=>$v) :
					$v["id_parent"]=$id_parent;
					pre($_detil);
					$this->model->attr_insert($_data['attr']."_detil",$v);
				endforeach;
			}
			$ok=$this->conn->CompleteTrans();
			
			
			pre($_data);exit;
			if ($update) {
				$data["edited"]=true;
				//$arrDB=$this->model->GetRecordData("c_a='".$_POST['c_a']."'");
				//$data["data"]=$arrDB;
				set_message("success","Data Updated.");
				//redirect("admin/rumkit");
			}
		}
		else {
			$kd_prop = substr($kode,0,2);
			$kd_kab = substr($kode,2,2);
			$kd_kec = substr($kode,-3);
			$arrDB=$this->model->GetRecordData("KD_PROPINSI='{$kd_prop}' AND KD_KABUPATEN='{$kd_kab}' AND KD_KECAMATAN='{$kd_kec}'");
			$data["data"]=$arrDB;
		}
		
		$data["user_name"]=$this->data['users']['user']['username'];
		$data["acc_active"]="content";
		$data["module"]=$this->module;
		$data_layout["toolbar"]=$this->load->view("kecamatan/tb_edit",$data,true); 
		$data_layout["content"]=$this->load->view("kecamatan/v_edit",$data,true); 
		$this->load->view($this->admin_layout,$data_layout);
  }
  function attr($kode,$idx,$tahun) {
	  	if($this->encrypt_status==TRUE):
			$idx_enc=$idx;
			$idx=decrypt($idx);
		endif;
		$data["idx"]=$idx_enc;
		$data["years"]=$this->_list_year();
		$data["data"] = $this->model->attr_get($kode,"id_kecamatan='".$idx."' and tahun='".$tahun."'");
		$this->load->view("kecamatan/data/v_".$kode,$data,false);
  }
  
  function detil($idx) {
	  	if($this->encrypt_status==TRUE):
			$idx_enc=$idx;
			$idx=decrypt($idx);
		endif;
		$arrDB=$this->model->GetRecordData("idx='{$idx}'");
		$data["mst"]=$arrDB;
		
		$data["idx"]=$idx_enc;
		$data["data"] = $this->model->attr_get("detil","id_kecamatan='".$idx."'");
		$this->load->view("kecamatan/data/v_detil",$data,false);
  }
  function _list_year($s=10,$e=0,$sort='desc') {
	  $start=date("Y")-$s;
	  $end=date("Y")+$e;
	  
	  if($sort=='desc') {
		 for($i=$end;$i>=$start;$i--) {
			$arr[$i]=$i;
		  }
	  }
	  else {
		 for($i=$start;$i<$end;$i++) {
			$arr[$i]=$i;
		  }
	  }
	  
	  return $arr;
  }
}