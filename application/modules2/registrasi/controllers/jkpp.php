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

		//import excel
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		
		$arrAttr=$this->build_attr=$this->build_attr();
		
		$this->build_attr=$arrAttr;
		if(cek_array($arrAttr)):
			$no = 1;
			foreach($arrAttr as $x=>$val):
			 	$tmp_tipe=trim(str_replace("via_","",$x));
				$this->lookup_media[$tmp_tipe]="({$no}) ".$val["title"];
				$this->lookup_modulname[$tmp_tipe] = $val['module_title'];
			$no++;
			endforeach;
			
		endif;
		
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

	 function build_attr($md=""){
		//===============================================================================================================================================================
		//WEBSITE
		$attr['via_website']['module_title'] = "WEBSITE";
		$attr['via_website']['title'] = "Laporan Diterima Melalui Website";
		
		$attr['via_website']['date_col'][1] 	= "F";
		$attr['via_website']['date_col'][2] 	= "J";
		$attr['via_website']['field_db'] 	= array('no','nama','email','domisili','tanggal_pelaporan','perihal','instansi_terlapor','media','tanggal_respon','deskripsi');
		
		$attr['via_website']['column'] = "a.idx,a.nama,a.email,a.domisili,a.tanggal_pelaporan,a.perihal,a.instansi_terlapor,a.tone,a.tanggal_respon,a.deskripsi,a.media,a.edited"; 
		
		$attr['via_website']['headere_column'][1] = "Nama Pelapor";
		$attr['via_website']['headere_column'][2] = "Alamat Email";
		$attr['via_website']['headere_column'][3] = "Domisili Pelapor";
		$attr['via_website']['headere_column'][4] = "Tanggal Pelaporan";
		$attr['via_website']['headere_column'][5] = "Perihal yang Dilaporkan";
		$attr['via_website']['headere_column'][6] = "Instansi yang Dilaporkan";
		$attr['via_website']['headere_column'][7] = "Tone";
		$attr['via_website']['headere_column'][8] = "Tanggal Direspon";
		//$attr['via_website']['headere_column'][9] = "Keterangan";
		$attr['via_website']['headere_column'][10] = "Media";
		
		//$attr['via_website']['field'] = array('nama','email','domisili','tanggal_pelaporan','perihal','instansi_terlapor','tone','tanggal_respon','deskripsi','media');
		$attr['via_website']['field'] = array('nama','email','domisili','tanggal_pelaporan','perihal','instansi_terlapor','tone','tanggal_respon','media');
		
		
		$attr['via_website']['st_row'] = 3;
		
		//===============================================================================================================================================================
		//WHATSAPP
		$attr['via_whatsapp']['module_title'] = "WHATSAPP";
		$attr['via_whatsapp']['title'] = "Laporan Diterima Melalui Whatsapp";
		$attr['via_whatsapp']['date_col'] = "F";
		
		$attr['via_whatsapp']['field_db'] = array('no','recognized_id','nama','domisili','tanggal_pelaporan','perihal','balasan','tone','kategori','deskripsi');
		
		$attr['via_whatsapp']['column'] = "a.idx,a.recognized_id,a.nama,a.domisili,a.tanggal_pelaporan,a.perihal,a.balasan,a.kategori,a.tone,a.deskripsi,a.media,a.edited"; 
		$attr['via_whatsapp']['condition'] 	= " recognized_id IS NOT NULL AND tanggal_pelaporan != '1899-12-30'"; 
		$attr['via_whatsapp']['headere_column'][1] = "Nomor Whatsapp";
		$attr['via_whatsapp']['headere_column'][2] = "Nama";
		$attr['via_whatsapp']['headere_column'][3] = "Daerah";
		$attr['via_whatsapp']['headere_column'][4] = "Tanggal Pelaporan";
		$attr['via_whatsapp']['headere_column'][5] = "Chat";
		$attr['via_whatsapp']['headere_column'][6] = "Our Reply";
		$attr['via_whatsapp']['headere_column'][7] = "Chat About";
		$attr['via_whatsapp']['headere_column'][8] = "Tone";
		$attr['via_whatsapp']['headere_column'][9] = "Penjelasan";
		$attr['via_whatsapp']['headere_column'][10] = "Media";
		
		$attr['via_whatsapp']['field'] = array('recognized_id','nama','domisili','tanggal_pelaporan','perihal','balasan','kategori','tone','deskripsi','media');
		$attr['via_whatsapp']['title'] = "Laporan Diterima Melalui Whatsapp";
		$attr['via_whatsapp']['st_row'] = 0;
		
		//===============================================================================================================================================================
		//LINE
		$attr['via_line']['module_title'] = "LINE";
		$attr['via_line']['title'] = "Laporan Diterima Melalui Line";
		$attr['via_line']['date_col'] = "D";
		
		
		$attr['via_line']['field_db'] = array('no','recognized_id','tanggal_pelaporan','perihal','balasan','tone','kategori','deskripsi');
		
		$attr['via_line']['column'] = "a.idx,a.recognized_id,a.tanggal_pelaporan,a.perihal,a.balasan,a.tone,a.kategori,a.deskripsi,a.media,a.edited"; 
		$attr['via_line']['condition'] = " recognized_id IS NOT NULL AND tanggal_pelaporan != '1899-12-30'"; 
		$attr['via_line']['headere_column'][1] = "Nama Line";
		$attr['via_line']['headere_column'][2] = "Tanggal";
		$attr['via_line']['headere_column'][3] = "Chat";
		$attr['via_line']['headere_column'][4] = "Our Reply";
		$attr['via_line']['headere_column'][5] = "Tone";
		$attr['via_line']['headere_column'][6] = "Chat About";
		$attr['via_line']['headere_column'][7] = "Penjelasan";
		$attr['via_line']['headere_column'][8] = "Media";
		
		$attr['via_line']['field'] = array('recognized_id','tanggal_pelaporan','perihal','balasan','tone','kategori','deskripsi','media');
		$attr['via_line']['st_row'] = 0;
		
		//===============================================================================================================================================================
		//TELEGRAM
		$attr['via_telegram']['module_title'] = "TELEGRAM";
		
		$attr['via_telegram']['date_col'] 	= "F";
		$attr['via_telegram']['title'] 		= "Laporan Diterima Melalui Telegram";
		
		$attr['via_telegram']['field_db'] 	= array('no','recognized_id','nama','domisili','tanggal_pelaporan','perihal','balasan','tone','kategori','deskripsi');
		
		$attr['via_telegram']['column'] = "a.idx,a.recognized_id,nama,a.domisili,a.tanggal_pelaporan,a.perihal,a.balasan,a.kategori,a.tone,a.deskripsi,a.media,a.edited"; 
		$attr['via_telegram']['condition'] 	= " recognized_id IS NOT NULL AND tanggal_pelaporan != '1899-12-30'"; 
		$attr['via_telegram']['headere_column'][1] 	= "Nomor Telegram";
		$attr['via_telegram']['headere_column'][2] 	= "Nama";
		$attr['via_telegram']['headere_column'][3] 	= "Daerah";
		$attr['via_telegram']['headere_column'][4] 	= "Tanggal";
		$attr['via_telegram']['headere_column'][5] 	= "Chat";
		$attr['via_telegram']['headere_column'][6] 	= "Our Reply";
		$attr['via_telegram']['headere_column'][7] 	= "Tone";
		$attr['via_telegram']['headere_column'][8] 	= "Chats About";
		$attr['via_telegram']['headere_column'][9] 	= "Penjelasan";
		$attr['via_telegram']['headere_column'][10] = "Media";
		
		$attr['via_telegram']['field'] 		= array('recognized_id','nama','domisili','tanggal_pelaporan','perihal','balasan','tone','kategori','deskripsi','media');
		$attr['via_telegram']['st_row'] = 0;
		
		
		
		//===============================================================================================================================================================
		//SMS
		$attr['via_sms']['module_title'] = "SMS";
		$attr['via_sms']['date_col'] 	 = "F";
		$attr['via_sms']['title'] 		 = "Laporan Diterima Melalui SMS";
		
		$attr['via_sms']['field_db'] 	= array('no','recognized_id','nama','domisili','tanggal_pelaporan','perihal','balasan','tone','kategori','deskripsi');
		
		
		$attr['via_sms']['column'] 		= "a.idx,a.recognized_id,nama,a.domisili,a.tanggal_pelaporan,a.perihal,a.balasan,a.kategori,a.tone,a.deskripsi,a.media,a.edited"; 
		$attr['via_sms']['condition'] 	= " recognized_id IS NOT NULL AND tanggal_pelaporan != '1899-12-30'"; 
		$attr['via_sms']['headere_column'][1] 	= "Nomor Telepon";
		$attr['via_sms']['headere_column'][2] 	= "Nama";
		$attr['via_sms']['headere_column'][3] 	= "Daerah";
		$attr['via_sms']['headere_column'][4] 	= "Tanggal";
		$attr['via_sms']['headere_column'][5] 	= "Chat";
		$attr['via_sms']['headere_column'][6] 	= "Our Reply";
		$attr['via_sms']['headere_column'][7] 	= "Tone";
		$attr['via_sms']['headere_column'][8] 	= "Chats About";
		$attr['via_sms']['headere_column'][9] 	= "Penjelasan";
		$attr['via_sms']['headere_column'][10] = "Media";
		
		$attr['via_sms']['field'] 		= array('recognized_id','nama','domisili','tanggal_pelaporan','perihal','balasan','tone','kategori','deskripsi','media');
		
		$attr['via_sms']['st_row'] = 0;
		
		if($md!=""):
			return $attr["via_".$md];
		else:
			return $attr;
		endif;
	}
	function import(){
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";   
        if(empty($act)):
            $data=null;
			$data["category"]=$cat;		 
            $this->_render_page($this->module."v_import",$data,true);
        endif;
    }	
	
	function read_import(){
		if ($_SERVER['REQUEST_METHOD']=='POST'){
			$fileName = $_FILES['import']['name'];
			$uploadPath=$this->config->item('dir_import');
			$config['upload_path'] = $uploadPath;
			$config['file_name'] = $fileName;
			$config['allowed_types'] = '*';
			$config['max_size']        = 10000;
			$this->load->library('upload');
			$this->upload->initialize($config);
			check_folder($uploadPath);
			
			 
			if(!$this->upload->do_upload('import'))
				$this->upload->display_errors();
			 
			$media = $this->upload->data('import');
			
			$inputFileName = $this->config->item('dir_import').$media['file_name'];
			
			//$readfilename = $this->define_media($inputFileName);
			//$attr_readxls = $this->build_attr($readfilename);
			
			$startrow = 7;
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
			
			// for ($i=0; $i<$numSheets; $i++) {
				//$sheet = $objPHPExcel->getSheet($i);
				$sheet =  $objPHPExcel->setActiveSheetIndex();
				$highestRow = $sheet->getHighestRow();
				$highestColumn = $sheet->getHighestColumn();
				
			
				//Sheet title
				$title[$i]=$sheet->getTitle();
				// put this at beginning of your script
				$saveTimeZone = date_default_timezone_get();
				date_default_timezone_set('UTC'); // PHP's date function uses this value!
				
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
						
						if($row>$startrow){
							$arr_data[$row][$column] = $data_value;
						}
					}
					
					
				}
				
				foreach($arr_data as $k=>$v):
					if($v['C']=='' && $v['D']=='' && $v['E']=='' && $v['G']=='' && $v['H']=='' && $v['K']=='' && $v['L']==''  && $v['M']=='') {
						 continue;
					}
					$datax[] = $v;
				endforeach;
				
				
				if(cek_array($datax)):
					foreach($datax as $k=>$val):
						$parse[] = $val;
						//date 
						$parse[$k]['D'] =$this->datefrom_excl($val['D']);
						$parse[$k]['F'] =substr($val['F'],0,2);
						$parse[$k]['I'] =substr($val['I'],0,2);
						$parse[$k]['J'] =substr($val['J'],0,1);
					endforeach;
				
				endif;

				
			
			$data['values'] = $parse;
			$data['title']  = $title;
			$data['media']  = $mediax;
			$data['header_attr'] = $header_attr;
			
			$data["module"]=$this->module;
			$data["user_name"]=$this->data['users']['user']['username'];
			$data["acc_active"]="content";
			$this->_render_page($this->module."re_import_view",$data,true);
			
		}
	}

	function add_xls(){
		if($_SERVER['REQUEST_METHOD']=="POST"):
			$var=get_post();
		
			$postx = $var["data"];
			
			$define_col_txt[0] 	="nomor_kejadian";
			$define_col_txt[1] 	="tgl_kejadian";
			$define_col_txt[2] 	="judul";
			$define_col_txt[3] 	="kd_sektor";
			$define_col_txt[4] 	="status_konflik";
			$define_col_txt[5] 	="ktgr_konflik";
			$define_col_txt[6] 	="investasi";
			$define_col_txt[7] 	="luas";
			$define_col_txt[8] 	="dampak";
			$define_col_txt[9] 	="sifat";
			$define_col_txt[10] ="longitude";
			$define_col_txt[11] ="latitude";
			$define_col_txt[12] ="kd_propinsi";
			$define_col_txt[13] ="kd_kabupaten";
			$define_col_txt[14] ="kd_kecamatan";
			$define_col_txt[15] ="kd_desa";
			$define_col_txt[16] ="pemerintah";
			$define_col_txt[17] ="perusahaan";
			$define_col_txt[18] ="masyarakat";
			$define_col_txt[19] ="clip";
			$define_col_txt[20] ="narasi";
			$define_col_txt[21] ="sumber";
			$define_col_txt[22] ="nama";
			$define_col_txt[23] ="email";
			$define_col_txt[24] ="alamat";
			$define_col_txt[25] ="telepon";
			
			if($define_col_txt):
				$col_txt = implode("|",$define_col_txt);
			endif;
			
			if(cek_array($postx)):
				$data_tmp=array();
				$col_txtx=$col_txt;
				
				$col_map=explode("|",$col_txtx);
				$data_import=array();
				foreach($postx as $x=>$val):
					$data_tmp=explode("|",$val);
					//delete last column
					$data_map=array_combine($col_map,$data_tmp);
					$data_import[]=$data_map;
				endforeach;
			endif;
			
			
			if(cek_array($data_import)):
			
				$this->conn->StartTrans();
			foreach($data_import as $x=>$val):
				$data_trans=$val;
				$this->model->InsertData($data_trans);
				
				/*if($x>=1):
					$data_trans=$val;
					$data_trans['media'] = $media;
					if($val['recognized_id']=='' && $val['tanggal_pelaporan']=='1899-12-30' ):
						$parentold = $data_import[$x-1]['recognized_id'];
						$data_trans['parent']=($parentold? $parentold:$parent);
					endif;
					$parent=$data_trans['parent'];
					$this->model->InsertData($data_trans);
				endif;*/
				
			endforeach;
			
		
			$complete=$this->conn->CompleteTrans();
				
			$this->_proses_message($complete,$this->module."index/".$media,$this->module."index/".$media);	
			
			endif;
			
			endif;
    }
	
	function parse_data($datax,$media){
		$get_attr = $this->build_attr($media);
		
		//date_col
		
		if($media=='website'):
			if(cek_array($datax)):
			foreach($datax as $k=>$val):
				$parse[] = $val;
				$parse[$k][$get_attr['date_col'][1]] =$this->datefrom_excl($val[$get_attr['date_col'][1]]);
				$parse[$k][$get_attr['date_col'][2]] =$this->datefrom_excl($val[$get_attr['date_col'][2]]);
				
			endforeach;
		
			endif;
		else:
			if(cek_array($datax)):
				foreach($datax as $k=>$val):
					$parse[] = $val;
					$parse[$k][$get_attr['date_col']] =$this->datefrom_excl($val[$get_attr['date_col']]);
					
				endforeach;
			
			endif;
		endif;
		
		return $parse;
		
	}
	
	
	function datefrom_excl($n){
		//define start date in excel
		$date_start = date_create('30-12-1899');
		date_add($date_start, date_interval_create_from_date_string($n.' days'));
		
		return date_format($date_start, 'Y-m-d');
		
	}
	
	function define_media($kolomheader){
		
		if(is_array($kolomheader)):
			$implode_first = implode(" ",$kolomheader);
			$mixedStr = strtolower($implode_first);
		else:
			$mixedStr = strtolower($kolomheader);
		endif;
		
		$website 	= "mail";
		$line 		= "line";
		$sms 		= "telepon";
		$sms_ 		= "sms";
		$telegram 	= "telegram";
		$wa 		= "whats";
		
		$throwx = "";
		if(strpos($mixedStr,$website)) {
			$throwx = "website";
		}else if(strpos($mixedStr,$line)){
			$throwx = "line";
		}else if(strpos($mixedStr,$sms)){
			$throwx = "sms";
		}else if(strpos($mixedStr,$telegram)){
			$throwx = "telegram";
		}else if(strpos($mixedStr,$wa)){
			$throwx = "whatsapp";
		}else if(strpos($mixedStr,$sms_)){
			$throwx = "sms";
		}
		else {
		  echo "String not here";
		}
		
		return $throwx;
	}
	
	public function get_export_template(){
		$var				=	get_post();
		$tahun				=	$var['tahun']?$var['tahun']:date('Y');
		$key				=	$var['q']?$var['q']:false;
		
		$filter				=	array();

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
		
		if($tahun):
			if($tahun=="All"):
				$filter_table[]	=	"tahun <= '".date('Y')."'";
			else:
				$filter_table[]	=	"tahun = '".$tahun."'";
			endif;
		endif;
		
		if(cek_array($filter_table)):
			$filter			=	join(" and ",$filter_table);
		endif;
		
		$sorting			=	"order by idx";
		
		$arrData			=	$this->adodbx->search_record_where($table,$filter,$sorting);
	
		$header['tahun']	=	$tahun;
		//$header['bidang']	=	'GARDA BANGSA';
		//$header['propinsi']	=	$this->data_propinsi[$kd_propinsi];
		
		$data['header']		=	$header;
		$data['data']		=	$arrData;
		
		
		echo $this->load->view($this->module."v_export_template_xls",$data,true);
		
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
				$where[]	=	" YEAR(tgl_kejadian)<='".date('Y')."'";
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
		
		if($this->input->get_post("kategori")):
            $where[]	=	" kategori='".$this->input->get_post("kategori")."'";
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
			$data['luas'] 		=	str_replace(",",".",$data['luas']);
			
			
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

	function get_kab_kotax($kd_bps_propinsi="",$arr_id=""){
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
		echo $this->load->view($this->module."lookup_kabupatenx",$data,true);
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
	
	function get_kecamatan($kd_kabupaten,$selected=false){
		
		$sql="select * from m_kecamatan where kd_wilayah like '".$kd_kabupaten."%' order by kd_wilayah";
		$arrKecamatan=$this->conn->GetAll($sql);
		$arrData=array();
		if(cek_array($arrKecamatan)):
			foreach($arrKecamatan as $x=>$val):
				$arrData[$val["KD_WILAYAH"]]=$val["NM_KECAMATAN"];
			endforeach;
		endif;
		$data["dataArr"]=$arrData;
		$data["arr_id"]=$selected;
		echo $this->load->view($this->module."lookup_kecamatan",$data,true);
	
	}

	function get_kecamatanx($kd_kabupaten,$selected=false){
		
		$sql="select * from m_kecamatan where kd_wilayah like '".$kd_kabupaten."%' order by kd_wilayah";
		$arrKecamatan=$this->conn->GetAll($sql);
		$arrData=array();
		if(cek_array($arrKecamatan)):
			foreach($arrKecamatan as $x=>$val):
				$arrData[$val["KD_WILAYAH"]]=$val["NM_KECAMATAN"];
			endforeach;
		endif;
		$data["dataArr"]=$arrData;
		$data["arr_id"]=$arr_id;
		echo $this->load->view($this->module."lookup_kecamatanx",$data,true);
	
	}
	
}
