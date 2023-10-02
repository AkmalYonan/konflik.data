<?php defined('BASEPATH') OR exit('No direct script access allowed');

class pasien extends REST_Controller
{       
    function __construct(){
            parent::__construct();
            $this->base_url=GetServerURL().base_url();
            $class_folder=basename(dirname(__DIR__));
        	$class=__CLASS__;
		
			$this->class=$class;
			$this->$class_folder=$class_folder;
		
			$this->load->helper(array('form', 'url','file'));
    		$this->folder=$class_folder."/";
        	$this->module=$this->folder.$class."/";
        	$this->http_ref=base_url().$this->module;
       
        
        	$this->load->model("general_model");
        	$this->model=new general_model("t_pasien");
			$this->model_finger_fmd=new general_model("t_pasien_finger_fmd");
			$this->model_finger_foto=new general_model("t_pasien_finger_foto");
			$this->model_finger_identification=new general_model("t_pasien_finger_identification");
			$this->model_finger_verification=new general_model("t_pasien_finger_verification");
			$this->model_app_finger_print=new general_model("t_app_finger_print");
			
			$this->tbl_idx="idx";
			
	}
	
	
	function index_get(){
		$this->tbl=$this->model->tbl;
		$where=array();
		//$where[]="parent!=0";
		$where=$this->_get_where_default();
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		$this->output($arrData);
	}
	
	
	function all_get(){
		
		$this->tbl=$this->model->tbl;
		$where=array();
		//$where[]="parent!=0";
		$where=$this->_get_where_default();
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		$this->output($arrData);
	}
	
	function search_get(){
		$this->tbl=$this->model->tbl;
		$where=array();
		//$where[]="parent!=0";
		$where=$this->_get_where_default();
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		$this->output($arrData);
       
	}
	
	
	function read_get($id){
		/*if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		*/
        $arrData=$this->model->GetRecordData("idx=$id");
		$this->output($arrData);
	}
	//cek exist pasien
	function is_exist_get($nik=false){
		$this->msg_ok="Ok";
        $this->msg_fail="Failed";
		/*if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		*/
		$req=get_post();
		$nik=$nik?$nik:false;
		if(!$nik):
			$nik=$req["nik"]?$req["nik"]:false;
		endif;
		$idx=$req["idx"]?$req["idx"]:false;
		$no_rekam_medis=$req["no_rekam_medis"]?$req["no_rekam_medis"]:false;
		
		
		$where=array();
		if($idx):
			$where[]="idx=$idx";
		endif;
		if($nik):
			$where[]="nik='".$nik."'";
		endif;
		if($req["no_rekam_medis"]):
			$where[]="no_rekam_medis='".$no_rekam_medis."'";
		endif;
		
		$whereSql="";
        if(cek_array($where)):
            $whereSql.=join(" and ",$where);
        endif;
		
        $arrData=$this->model->GetRecordData($whereSql);
		
		if(cek_array($arrData)):
			$response["status"]=true;
			$response["messages"]=$this->msg_ok;
			$response["data"]=$arrData;
			$this->response($response, 200);
		else:
			$response["status"]=false;
			$response["messages"]=$this->msg_fail;
			$response["data"]=false;
			$this->response($response, 200);
		endif;
		//$this->output($arrData);
		
	}
	
	
	function  edit_post($id){
		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		
		$this->msg_ok="Data Updated successfully";
        $this->msg_fail="Unable to edit data";
		$this->conn->StartTrans();
        $data=get_post();
		$data=$this->_add_editor($data);
		unset($data[$this->tbl_idx]);
		$this->model->UpdateData($data, "idx=$id");
		$ok=$this->conn->CompleteTrans();
        if($ok):
        	$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$this->response($response, 200);
        else:
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
        	$response["messages"]=$this->msg_fail;
	    	$this->response($response, 404);
        endif;
	}
	
	function  add_post(){
		$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new data";
        
		//debug();
       
		$data=get_post();
		unset($data[$this->tbl_idx]);
		$data=$this->_add_creator($data);
		$this->conn->StartTrans();
		$this->model->InsertData($data);
			
		$id_last=$this->model->GetLastID("idx");
			
		$ok=$this->conn->CompleteTrans();
		$response=array();
		if($ok):
        	$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$this->response($response, 200);
        else:
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
        	$response["messages"]=$this->msg_fail;
	    	$this->response($response, 404);
        endif;
       
	}
	
	function delete_post($id){
		 if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        
        $this->msg_ok="Data deleted successfully";
        $this->msg_fail="Unable to delete data";
      
        $arrData=$this->model->GetRecordData("idx=$id");
        $this->conn->StartTrans();
           $this->model->DeleteData("idx=$id");
        $ok=$this->conn->CompleteTrans();
        $response=array();
        if($ok):
        	$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$this->response($response, 200);
        else:
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
        	$response["messages"]=$this->msg_fail;
	    	$this->response($response, 404);
        endif;
        
    }
	
	function upload_file_post()
	{
		$this->msg_ok="File upload successfully";
        $this->msg_fail="Unable to upload_file";
		
		$config['upload_path'] = './uploads/';
		//$config['allowed_types'] = 'gif|jpg|png';
		$config['allowed_types'] = '*';
		//$config['max_size'] = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload() )
		{
			print_r($this->upload->display_errors('', ''));
			print_r($this->upload->data());
		}else{
			$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$this->response($response, 200);
		}
	}
	
	function upload_file2_post()
	{
		$this->msg_ok="File upload successfully";
        $this->msg_fail="Unable to upload_file";
		
		$config['upload_path'] = './uploads/';
		//$config['allowed_types'] = 'gif|jpg|png';
		$config['allowed_types'] = '*';
		//$config['max_size'] = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload("file") )
		{
			//print_r($this->upload->display_errors('', ''));
			//print_r($this->upload->data());
			$response["status"]=false;
			$response["error"]=strip_tags($this->upload->display_errors());
			$response["message"]=$this->msg_fail;
			$response["data"]=false;
			$this->response($response, 404);
		}else{
			$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
			$upload = $this->upload->data();
			$response["data"]=$upload; 
        	$this->response($response, 200);
		}
	}
	
	
	/* finger print */
	function update_fmd_post($idx_pasien,$id_jari){
		$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new data";
        
		//debug();
       
		$data=get_post();
		unset($data["idx"]);
		$data=$this->_add_creator($data);
		$this->conn->StartTrans();
		$this->model_finger_fmd->DeleteData("idx_pasien=$idx_pasien and id_jari=$id_jari");
		$this->model_finger_fmd->InsertData($data);
		
		
			
		$id_last=$this->model->GetLastID("idx");
			
		$ok=$this->conn->CompleteTrans();
		$response=array();
		if($ok):
        	$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$this->response($response, 200);
        else:
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
        	$response["messages"]=$this->msg_fail;
	    	$this->response($response, 404);
        endif;
	}
	
	function upload_finger_post($idx_pasien,$id_jari)
	{
		$this->msg_ok="File upload successfully";
        $this->msg_fail="Unable to upload_file";
		
		$data=get_post();
		unset($data["idx"]);
		$data=$this->_add_creator($data);
		$this->model_finger_foto->DeleteData("idx_pasien=$idx_pasien and id_jari=$id_jari");
		$this->model_finger_foto->InsertData($data);
		
		
		$path='pasien_files/scan_finger';
		check_folder($path);
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['allowed_types'] = '*';
		//$config['max_size'] = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload("file") )
		{
			//print_r($this->upload->display_errors('', ''));
			//print_r($this->upload->data());
			$response["status"]=false;
			$response["error"]=strip_tags($this->upload->display_errors());
			$response["message"]=$this->msg_fail;
			$response["data"]=false;
			$this->response($response, 404);
		}else{
			$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
			$upload = $this->upload->data();
			$response["data"]=$upload; 
        	$this->response($response, 200);
		}
	}
	
	function _add_creator($data){
        $data["created"]=date("Y-m-d H:i:s");
        $data["creator"]=$this->data["users"]["user"]["username"];
        $data["edited"]=date("Y-m-d H:i:s");
        $data["editor"]=$this->data["users"]["user"]["username"];
        return $data;
    }
    
    function _add_editor($data){
        $data["edited"]=date("Y-m-d H:i:s");
        $data["editor"]=$this->data["users"]["user"]["username"];
        return $data;
    }
	
	function _add_ip_address($data){
		//$data["ip_client"]=$this->input->ip_address();
		$data["ip_client"]=$this->_prepare_ip($this->input->ip_address());
		$data["ip_address"]=$data["ip_client"];
		return $data;
	}
	
	
	
	function _offset(){
		$offset=$this->get("offset");
		$offset=$offset?$offset:0;
		return $offset;
	}
	
	function _limit(){
		$limit=$this->get("limit");
		$limit=$limit?$limit:$this->get("per_page");
		$limit=$limit?$limit:$this->get("pp");
		$limit=$limit?$limit:20;
		return $limit;
	}
	
	function _col_select(){
		$col_select=$this->get("select");
		$colData=array();
		if(cek_var($col_select)):
			$colData=preg_split("/\.\,\|\:\;/",$col_select);
		endif;
		return $colData;
	}
	
	function column_get(){
        $arr=$this->adodbx->TableColumns($this->tbl);
		return $arr;
    }
    
    function column_type($tb_name){
        $data_type=$this->adodbx->GetDataType($tb_name);
        //pre($data_type);
        return $arr;
    }
	
	function _sort(){
		$sort=$this->get("sort")?" order by ".$this->get("sort"):"";
		return $sort;
	}
	
	function _get_where_default($where=array()){
		$q=$this->get("q");
		
		$data_type=$this->adodbx->GetDataType($this->tbl);
		foreach($data_type as $x=>$val):
			if(($val=="C")||($val=="X")) $data["text"][]=$x;
			endforeach;
		$col_text=$data["text"];
		$field=join(",",$col_text);
		
		//$field="nama,nrp,nama_depan,nama_belakang";
		
		if(cek_var($q)):
			$where[]="(".get_where_from_searchbox($field).")";
		endif;
		return $where;
	}
	
	function _get_where($where=array()){
	    $data_type=$this->adodbx->GetDataType($this->tbl);
		foreach($data_type as $x=>$val):
			if($val=="C") $data["text"][]=$x;
			if($val=="T") $data["date"][]=$x;
			if($val=="I") $data["val"][]=$x;
		endforeach;
		
		$col_text=$data["text"];
		$col_val=$data["val"];
		$col_date=$data["date"];
		
		if(cek_array($col_text)):
			foreach($col_text as $colt):
				if($this->get($colt)):
					$where[]=" $colt like '%".$this->get($colt)."%'";
				endif;
			endforeach;
		endif;
               
		
		if(cek_array($col_val)):		
			foreach($col_val as $colv):
				if($this->get($colv."_gt")):
					$where[]=" $colv >".$this->get($colv."_gt")."";
				endif;
				if($this->get($colv."_lt")):
					$where[]=" $colv <".$this->get($colv."_lt")."";
				endif;
				if($this->get($colv."_gte")):
					$where[]=" $colv >=".$this->get($colv."_gte")."";
				endif;
				if($this->get($colv."_lte")):
					$where[]=" $colv <=".$this->get($colv."_lte")."";
				endif;
				if($this->get($colv)):
					$where[]=" $colv =".$this->get($colv)."";
				endif;
			endforeach;
		endif;
		
		if(cek_array($col_date)):		
			foreach($col_date as $colv):
				if($this->get($colv."_gt")):
					$where[]=" $colv >'".$this->get($colv."_gt")."'";
				endif;
				if($this->get($colv."_lt")):
					$where[]=" $colv <'".$this->get($colv."_lt")."'";
				endif;
				if($this->get($colv."_gte")):
					$where[]=" $colv >='".$this->get($colv."_gte")."'";
				endif;
				if($this->get($colv."_lte")):
					$where[]=" $colv <='".$this->get($colv."_lte")."'";
				endif;
				if($this->get($colv)):
					$where[]=" $colv ='".$this->get($colv)."'";
				endif;
			endforeach;
		endif;
		return $where;
	}
	
	
	function _where_sql($where,$operator="and",$whereSql=""){
		if(cek_array($where)):
			$whereSql=join(" $operator ",$where);
		endif;
		
		return $whereSql;
	}
	
	
	function output($data){
        if(cek_array($data))
        {
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(array('error' => 'Data Not Found'), 404);
        }
    }
	
	
	/* FINGER PRINT */
	
	function add_finger_foto_post(){
		$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new data";
        
		
		// cek data 
		//debug();
       	$data=get_post();
		
		$idx_pasien=$data["idx_pasien"];
		$id_jari=$data["id_jari"];
		$data["created"]=$data["created_date"];
		$data["edited"]=$data["edited_date"];
		unset($data[$this->tbl_idx]);
		$tbl=$this->model_finger_foto->tbl;
		//cek data
		
		$this->conn->StartTrans();
		
		$whereSql="idx_pasien=$idx_pasien and id_jari=$id_jari";
		$mycount=$this->conn->GetOne("select count(idx_pasien) from $tbl where $whereSql");
		if($mycount>=4):
			$this->conn->Execute("Delete from $tbl where $whereSql");
		endif;
		
		//$data=$this->_add_creator($data);
		$this->model_finger_foto->InsertData($data);
			
		//$id_last=$this->model->GetLastID("idx");
			
		$ok=$this->conn->CompleteTrans();
		$response=array();
		if($ok):
		
        	$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$response["success"] = 1;
			$this->response($response, 200);
        else:
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
        	$response["messages"]=$this->msg_fail;
			$response["success"] = 0;
	    	$this->response($response, 404);
        endif;
		
	}
	
	function add_finger_fmd_post(){
		$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new data";
        
		
		// cek data 
		//debug();
       	$data=get_post();
		$data["fmd"]=$_POST["fmd"];
		
		$idx_pasien=$data["idx_pasien"];
		$id_jari=$data["id_jari"];
		$data["created"]=$data["created_date"];
		$data["edited"]=$data["edited_date"];
		unset($data[$this->tbl_idx]);
		$tbl=$this->model_finger_fmd->tbl;
		//cek data
		$whereSql="idx_pasien=$idx_pasien and id_jari=$id_jari";
		$mycount=$this->conn->GetOne("select count(idx_pasien) from $tbl where $whereSql");
		if($mycount>=1):
			$this->conn->Execute("Delete from $tbl where $whereSql");
		endif;
		
		//$data=$this->_add_creator($data);
		$this->conn->StartTrans();
		$this->model_finger_fmd->InsertData($data);
			
		//$id_last=$this->model->GetLastID("idx");
			
		$ok=$this->conn->CompleteTrans();
		$response=array();
		if($ok):
		
        	$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$response["success"] = 1;
			$this->response($response, 200);
        else:
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
        	$response["messages"]=$this->msg_fail;
			$response["success"] = 0;
	    	$this->response($response, 404);
        endif;
		
	}
	
	
	function all_fmd_post($idx_pasien=false,$id_jari=false){
		
		$data=get_post();
		$idx_pasien=$idx_pasien?$idx_pasien:$data["idx_pasien"];
		$id_jari=$id_jari?$idx_jari:false;
		if(!$id_jari):
			$id_jari=$data["id_jari"]?$data["id_jari"]:false;
		endif;
		
		$where=array();
		
		$where[]="idx_pasien=$idx_pasien";
		if($id_jari):
			$where[]="id_jari=$id_jari";
		endif;
		
		$whereSql="";
		if(cek_array($where)):
			$whereSql.=join(" and ",$where);
		endif;
		
		$arrData=$this->model_finger_fmd->SearchRecordWhere($whereSql);
		
		$response=array();
		if(cek_array($arrData)):
			$response["status"]=true;
			$response["array_data_pffmd"]=$arrData;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$response["success"] = 1;
			$this->response($response, 200);
        else:
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
        	$response["messages"]=$this->msg_fail;
			$response["success"] = 0;
			$response["array_data_pffmd"]=false;
	    	$this->response($response, 404);
        endif;
		
	
	}
	
	function  close_finger_identification_post($idx_pasien=false,$id_pfi=false){
		//debug();
		$this->msg_ok="Data Updated successfully";
        $this->msg_fail="Unable to edit data";
		$this->conn->StartTrans();
        $data=get_post();
		$id_pfi=$id_pfi?$id_pfi:$data["id_pfi"];
		$idx_pasien=$idx_pasien?$idx_pasien:$data["idx_pasien"];
		
		$data=$this->_add_editor($data);
		unset($data[$this->tbl_idx]);
		$data['flag_status_identification']=0;
		$data['flag_status_process_identification']=0;
		$data['message']="identification success";
		$where=array();
		
		$where[]="idx_pasien=$idx_pasien";
		if($id_pfi):
			$where[]="id_pfi=$id_pfi";
		endif;
		
		$whereSql="";
		if(cek_array($where)):
			$whereSql.=join(" and ",$where);
		endif;
		
		$this->model_finger_identification->UpdateData($data, "$whereSql");
		$ok=$this->conn->CompleteTrans();
        if($ok):
        	$response["status"]=true;
        	$response["error"]=false;
			$response["success"] = 1;
        	$response["messages"]=$this->msg_ok;
        	$this->response($response, 200);
        else:
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
			$response["success"] = 0;
        	$response["messages"]=$this->msg_fail;
	    	$this->response($response, 404);
        endif;
	}
	
	
	function  open_finger_identification_post($idx_pasien=false){
		$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new data";
       //debug();
       $data=get_post();
		
		
		unset($data[$this->tbl_idx]);
		
		$idx_pasien=$idx_pasien?$idx_pasien:$data["idx_pasien"];
		
		
		$data=$this->_add_creator($data);
		$this->conn->StartTrans();
		$data["idx_pasien"]=$idx_pasien;
		$data['flag_status_identification']=0;
		$data['flag_status_process_identification']=1;
		$data['message']="waiting identification";
		$data=$this->_add_creator($data);
		
		$this->model_finger_identification->InsertData($data);
		$id_last=$this->model_finger_identification->GetLastID("id_pfi");
		//pre($id_last);
		$data_row=$this->model_finger_identification->GetRecordData("id_pfi=$id_last");
		
			
		$ok=$this->conn->CompleteTrans();
		$response=array();
		if($ok):
        	$response["idx_pfi"]=$id_last;
			$response["data"]=$data_row;
			
			$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$this->response($response, 200);
        else:
			$response["idx_pfi"]=false;
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
        	$response["messages"]=$this->msg_fail;
	    	$this->response($response, 404);
        endif;
       
	}
	
	
	function finger_identification_process_get($idx_pasien){
	//debug();
		$data_row=$this->model_finger_identification->GetRecordData("idx_pasien=$idx_pasien and flag_status_process_identification=1");
		$this->output($data_row);
	}
	
	
	/* t_app _finger print_*/
	
	function read_app_post($id=false){
		/*if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
		*/
		if($id):
			$where[]="idx=$id";
		endif;
		
		$req=get_post();
		$unique_id=$req["unique_id"];
		if($unique_id):
			$where[]="unique_id='".$unique_id."'";
		endif;
		
		$whereSql="";
		
		if(cek_array($where)):
			$whereSql=join(" and ",$where);
		endif;
		$arrData=$this->model_app_finger_print->GetRecordData($whereSql);
		$this->output($arrData);
	}
	
	function  update_app_post(){
		$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new data";
        
		//debug();
		//pre($this->post());
		//pre($this->request->body);
        //pre($_POST);
		
		$data=get_post();
		$ip_address_data=json_decode($data["ip_address"]);
		$data["ip_address"]=join(";",$ip_address_data);
		//pre($data);
		$unique_id=$data["unique_id"];
		if($unique_id):
			$where[]="unique_id='".$unique_id."'";
		endif;
		
		$whereSql="";
		//debug();
		if(cek_array($where)):
			$whereSql=join(" and ",$where);
		endif;
		$arrData=$this->model_app_finger_print->GetRecordData($whereSql);
		$flag="insert";
		if(cek_array($arrData)):
			$idx=$arrData["idx"];
			$flag="update";
		endif;
		
		$this->conn->StartTrans();
		unset($data["idx"]);
		if($flag=="insert"):
			$data=$this->_add_creator($data);
			$this->model_app_finger_print->InsertData($data);
		else:
			$data=$this->_add_editor($data);
			$this->model_app_finger_print->UpdateData($data,"idx=$idx");
		endif;
		$ok=$this->conn->CompleteTrans();
		
		$response=array();
		if($ok):
        	$response["status"]=true;
			$response["data"]=$data;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
        	$this->response($response, 200);
        else:
        	$response["status"]=false;
        	$response["error"]=$this->msg_fail;
        	$response["messages"]=$this->msg_fail;
	    	$this->response($response, 404);
        endif;
       
	}
	
	function upload_finger_image_post()
	{
		$this->msg_ok="File upload successfully";
        $this->msg_fail="Unable to upload_file";
		
		/*$data=get_post();
		unset($data["idx"]);
		$data=$this->_add_creator($data);
		$this->model_finger_foto->DeleteData("idx_pasien=$idx_pasien and id_jari=$id_jari");
		$this->model_finger_foto->InsertData($data);*/
		
		
		$path='pasien_files/finger_scan';
		check_folder($path);
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|bmp|BMP';
		//$config['allowed_types'] = '*';
		//$config['max_size'] = '100';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload("fingerscan_image") )
		{
			//print_r($this->upload->display_errors('', ''));
			//print_r($this->upload->data());
			$response["status"]=false;
			$response["error"]=strip_tags($this->upload->display_errors());
			$response["message"]=$this->msg_fail;
			$response["data"]=false;
			$this->response($response, 404);
		}else{
			$response["status"]=true;
        	$response["error"]=false;
        	$response["messages"]=$this->msg_ok;
			$upload = $this->upload->data();
			$response["data"]=$upload; 
        	$this->response($response, 200);
		}
	}
	
}