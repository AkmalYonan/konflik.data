<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class balai extends Admin_Controller {
	var $arr_category=array();   
    function __construct(){
        parent::__construct();       
		$this->base_url=GetServerURL().base_url();
		
        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
        $class_folder = basename(dirname(__DIR__)); //admin
		$class = __CLASS__; //dashboard
		$this->class=$class;
		$this->$class_folder=$class_folder;
		
		$this->load->helper(array('form', 'url','file'));
    	$this->folder=$class_folder."/"; //master_data/
        $this->module=$this->folder.$class."/";//master_data/uu_daerah/
        $this->http_ref=base_url().$this->module;///brwa/admin/dashboard/
        
        $this->load->model("general_model");
        $this->model=new general_model("m_instansi");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Organisasi";
		$this->module_title="Balai Besar/Balai/Loka";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";	
	 }
	 
	 function index(){
	 	$this->listview();
		//$this->_render_page($this->module."registrasi_list",$data,true);
	 }

	 function listview(){
		
		$this->load->library('pagination');  
        //$sql=" select a.*,b.realname,b.path from ".$this->model->tbl." a 
          //      left join ".$this->model->tbl."_file b on a.idx=b.id_parent
        //";
		
		$table=$this->model->tbl;    
        //$table="($sql) a";
		$queryString=rebuild_query_string(); 
		$data_type=$this->adodbx->GetDataType($table);
		foreach($data_type as $x=>$val):
            if(($val=="C")||($val=="X")) $data["text"][]=$x;
        endforeach;
        
        $col_text=$data["text"];
		$field=join(",",$col_text);
        $whereSql=get_where_from_searchbox($field);
        
        if($this->input->get_post("q")):
            $where[]="(".$whereSql.")";
        endif;
		$where[]="(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK')";
		
        
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
        
		
		
        //$arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        
		$config['base_url'] = $this->module."listview";  
        $config['per_page'] = $perPage;  
        $config['total_rows'] = $totalRows;
        $config['uri_segment'] = $uriSegment;
        $config["suffix"]=$queryString;
        $config["first_url"]=$config["base_url"].$queryString;
        $this->pagination->initialize($config);
        $data["arrData"]=$arrData;
		$this->_render_page($this->module."v_list",$data,true);
    }
	
	
	 function up($id){
		$this->init_order_num();
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
        $this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
        $arrData=$this->model->SearchRecordWhere(false," order by order_num");
        foreach($arrData as $x=>$value):
            $updownData[]=$value["idx"];
            if($value["idx"]==$id):
                $current=$x;
            endif;
        endforeach;
        
        $idCurrent=$updownData[$current];
        $idBefore=$updownData[$current-1];
        
        $this->conn->StartTrans();
        $data["order_num"]=$current+1;
        $this->conn->AutoExecute($this->model->tbl,$data,"UPDATE","idx=".$idBefore);
        $data["order_num"]=$current;
        $this->conn->AutoExecute($this->model->tbl,$data,"UPDATE","idx=".$idCurrent);
        $ok=$this->conn->CompleteTrans();
       	$this->_proses_message($ok,$this->agent->referrer(),$this->agent->referrer());
    }
    
	function init_order_num(){
		//debug();
		$mycount=$this->conn->GetOne("select count(idx) as mycount from ".$this->model->tbl." group by order_num having count(order_num)>1 ");
		if($mycount>1):
			$this->conn->StartTrans();
			$arrData=$this->model->SearchRecord(false," order by order_num");
			foreach($arrData as $x=>$val):
				$data["order_num"]=$x+1;
				$this->model->UpdateData($data,"idx=".$val["idx"]);
			endforeach;
			$this->conn->CompleteTrans();
		endif;
	}
	
    function down($id){
        $this->init_order_num();
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_fail="Update Order Failed";
        $this->msg_ok="Update Order OK";
        
        $current=0;
        //$arrData=$this->conn->GetAll("select * from "" where  menu_parent_id={$menu_parent_id} order by order_num");
        $arrData=$this->model->SearchRecordWhere(false," order by order_num");
		foreach($arrData as $x=>$value):
            $updownData[]=$value["idx"];
            if($value["idx"]==$id):
                $current=$x;
            endif;
        endforeach;
		
        
        $idCurrent=$updownData[$current];
        $idNext=$updownData[$current+1];
        
        $this->conn->StartTrans();
        $data["order_num"]=$current+1;
        $this->conn->AutoExecute($this->model->tbl,$data,"UPDATE","idx=".$idNext);
        $data["order_num"]=$current+2;
        $this->conn->AutoExecute($this->model->tbl,$data,"UPDATE","idx=".$idCurrent);
        $ok=$this->conn->CompleteTrans();
        $this->_proses_message($ok,$this->agent->referrer(),$this->agent->referrer());
    }
	 
	 function add(){
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
            $this->_render_page($this->module."v_add",$data,true);
        endif;
        //debug();
        if($act=="create"):
			//debug();
			$data=get_post();
			
			if($data['foto1'] or $data['foto2'] or $data['foto3']):
				
				
				$config['allowed_types']	=	"gif|png|jpg|jpeg";
				$config['upload_path']		=	$this->config->item("dir_balai_loka");
				$config['max_size']			=	"500000";
				$config['overwrite']		=	TRUE;
				
				if($data['foto1']):
					$config['file_name']		=	"1".time().substr($data['foto1'],strrpos($data['foto1'],"."));
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->do_upload('foto_pejabat');
					
					$file1						=	$this->upload->data();
					
					$data['foto_pejabat']		=	$file1['file_name'];
				endif;
				
				if($data['foto2']):
					$config['file_name']		=	"2".time().substr($data['foto2'],strrpos($data['foto2'],"."));
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->do_upload('fasilitas1');
					
					$file2						=	$this->upload->data();
					
					$data['fasilitas1']			=	$file2['file_name'];
				endif;
				
				if($data['foto3']):
					$config['file_name']		=	"3".time().substr($data['foto2'],strrpos($data['foto2'],"."));
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->do_upload('fasilitas2');
					
					$file3						=	$this->upload->data();
					
					$data['fasilitas2']			=	$file3['file_name'];
				endif;
				
			endif;
			
			$data["order_num"]=$this->model->GetLastID("order_num")+1;
			$max	=	$this->model->GetLastID();			
			$data['kd_instansi']	=	$data['id_propinsi']."-".substr($data['id_kabupaten'],2,2)."-".$data['jenis_instansi']."-".($max+1);
			$data=$this->_add_creator($data);
			$data["rawat_jalan"]=$data["rawat_jalan"]?1:0;
			$data["rawat_inap"]=$data["rawat_inap"]?1:0;
			$data["rawat_pasca"]=$data["rawat_pasca"]?1:0;
			$this->conn->StartTrans();
			$this->model->InsertData($data);
			
			$ok=$this->conn->CompleteTrans();
			//pre($ok);exit;
            $this->_proses_message($ok,$this->module."listview/",$this->module."add/");
        endif;
    }
	
    function attr_get_edit($name,$kode){
		
		//$tbl = "select * from t_sarpras_".$name." where kd_org='$kode' limit 0,13";
		$sql	=	"
					select
					a.uraian,
					b.*
					
					from m_".$name." a
					
					left join t_sarpras_".$name." b
					on a.kode=b.kode
					
					where b.kd_org='$kode' limit 0,13					
					";
		
		return $this->conn->GetAll($sql);
    }
	
    function edit($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
       
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            
			$arrData=$this->model->GetRecordData("idx=$id");
            $data["data"]=$arrData;
			
			$kode = $arrData[kd_instansi];
			
			//ATTR
			$arrFasRuang1				=	$this->conn->GetAll("select a.uraian,b.* from m_fas_ruang a left join t_sarpras_fas_ruang b on a.kode=b.kode where b.kd_org='$kode' limit 0,15");
			$arrFasRuang2				=	$this->conn->GetAll("select a.uraian,b.* from m_fas_ruang a left join t_sarpras_fas_ruang b on a.kode=b.kode where b.kd_org='$kode' limit 15,30");			
			$data_fas_ruang['arrData']	=	$arrFasRuang1;
			$data_fas_ruang['arrData2']	=	$arrFasRuang2;
			$data['v_fas_ruang']		=	$this->load->view($this->module."execute/v_fas_ruang",$data_fas_ruang,true);
			$dokter						=	$this->attr_get_edit("dokter",$kode);					
			
			$data_dokter['dokter']		=	$dokter;
			$data['v_dokter']			=	$this->load->view($this->module."execute/v_dokter",$data_dokter,true);
			
			$perbid						=	$this->attr_get_edit("perbid",$kode);			
			$data_perbid['perbid']		=	$perbid;
			$data['v_perbid']			=	$this->load->view($this->module."execute/v_perbid",$data_perbid,true);
			
			$tensos						=	$this->attr_get_edit("tensos",$kode);			
			$data_tensos['tensos']		=	$tensos;
			$data['v_tensos']			=	$this->load->view($this->module."execute/v_tensos",$data_tensos,true);
			
			$penunjang_medis			=	$this->attr_get_edit("penunjang_medis",$kode);			
			$data_penunjang_medis['penunjang_medis']=	$penunjang_medis;
			$data['v_penunjang_medis']	=	$this->load->view($this->module."execute/v_penunjang_medis",$data_penunjang_medis,true);
			
			$adm_umum					=	$this->attr_get_edit("adm_umum",$kode);			
			$data_adm_umum['adm_umum']	=	$adm_umum;
			$data['v_adm_umum']			=	$this->load->view($this->module."execute/v_adm_umum",$data_adm_umum,true);
			
			$peralatan					=	$this->attr_get_edit("peralatan",$kode);			
			$data_peralatan['peralatan']=	$peralatan;
			$data['v_peralatan']		=	$this->load->view($this->module."execute/v_peralatan",$data_peralatan,true);

			//$data['kd_org_list']		=	$this->get_kd_org_list();
			
			//$data['act']				=	"add";
			
			
			$this->_render_page($this->module."v_edit",$data,true);
        endif;
		
		if($act=="update"):
			$data=get_post();
			
			if($data['foto1'] or $data['foto2'] or $data['foto3']):
				
				
				$config['allowed_types']	=	"gif|png|jpg|jpeg";
				$config['upload_path']		=	$this->config->item("dir_balai_loka");
				$config['max_size']			=	"500000";
				$config['overwrite']		=	TRUE;
				
				if($data['foto1']):
					$config['file_name']		=	"1".time().substr($data['foto1'],strrpos($data['foto1'],"."));
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->do_upload('foto_pejabat');
					
					$file1						=	$this->upload->data();
					
					$data['foto_pejabat']		=	$file1['file_name'];
				endif;
				
				if($data['foto2']):
					$config['file_name']		=	"2".time().substr($data['foto2'],strrpos($data['foto2'],"."));
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->do_upload('fasilitas1');
					
					$file2						=	$this->upload->data();
					
					$data['fasilitas1']			=	$file2['file_name'];
				endif;
				
				if($data['foto3']):
					$config['file_name']		=	"3".time().substr($data['foto2'],strrpos($data['foto2'],"."));
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->do_upload('fasilitas2');
					
					$file3						=	$this->upload->data();
					
					$data['fasilitas2']			=	$file3['file_name'];
				endif;
				
			endif;		
			
			//$max	=	$this->model->GetLastID();			
			//$data['kd_instansi']	=	$data['id_propinsi']."-".substr($data['id_kabupaten'],2,2)."-".$data['jenis_instansi']."-".($max+1);
			$data["active"]=$data["active"]?1:0;
			$data["rawat_jalan"]=$data["rawat_jalan"]?1:0;
			$data["rawat_inap"]=$data["rawat_inap"]?1:0;
			$data["rawat_pasca"]=$data["rawat_pasca"]?1:0;
				
			
			//$data=$this->_add_editor($data);
			$this->conn->StartTrans();
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
            $ok=$this->conn->CompleteTrans();
			$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
        endif;     
    }
	
	function activate($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
       	
		$arrData=$this->model->GetRecordData("idx=$id");
        $activate=$arrData["active"]==1?1:0;
		$data["active"]=$activate==1?0:1;
		
		$this->conn->StartTrans();
		$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
        $ok=$this->conn->CompleteTrans();
		$this->_proses_message($ok,$this->module."listview/",$this->module."edit/$id_enc");
		     
    }
    
    function del($id){
       if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
      
        $arrData=$this->model->GetRecordData("{$this->tbl_idx}=$id");
        $act="delete";    
        if($act=="delete"):
            $this->conn->StartTrans();
                $this->model->DeleteData("{$this->tbl_idx}=$id");
            $ok=$this->conn->CompleteTrans();
            $this->_proses_message($ok,$this->module."listview",$this->module."view/$id_enc");
        endif;
    }
	
	function view($id){
        if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData=$this->model->GetRecordData("idx=$id");
		//$arrDataFile=$this->model_file->SearchRecordWhere("id_parent=$id");
		
        $data["data"]=$arrData;
		//$data["data_file"]=$arrDataFile;
       	$this->_render_page($this->module."v_view_2",$data,true);
        
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
	
	function peta(){
		// print "test";
		 
		$this->_render_page($this->module."v_peta",$data,true);
	 }
	 
	
	 
	 
	 

}