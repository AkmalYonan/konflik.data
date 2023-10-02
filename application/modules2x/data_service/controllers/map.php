<?php defined('BASEPATH') OR exit('No direct script access allowed');
class map extends REST_Controller
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
		$this->model=new general_model("t_daftar_jkpp");
		$this->model_ipwl=new general_model("m_instansi");
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
	
	function jkpp_get(){

		$format=$this->response->format;
		$this->tbl=$this->model->tbl;
		$where=array();
		
		$where=$this->_get_where_default();
		$where=$this->_get_where($where);
		
		$whereSql	=	$this->_where_sql($where);
		
		
		$and		=	"";
		$var		=	get_post();
		
		if($var):
			$kd_sektor	=	$var['sektor']?$var['sektor']:false;
			$kd_konflik	=	$var['konflik']?$var['konflik']:false;
			
			if($kd_sektor!=='false'):
				$whereSql	.=	$and." kd_sektor='".$kd_sektor."'";
				$and		=	" and ";
			else:
				$whereSql	.=	"";
				$and		=	"";
			endif;
			
			if($kd_konflik!=='false'):
				$whereSql	.=	$and." kd_konflik like '%".$kd_konflik."%'";
				$and		=	" and ";
			else:
				$whereSql	.=	"";
				$and		=	"";
			endif;
		endif;
		
		$data_table	=	"
					(select
						a.*,
						b.uraian as nama_sektor,
						b.color as warna_sektor
					from
						".$this->tbl." a
					left join
						m_sektor b
					on
						a.kd_sektor=b.kode) x
					";
					
		
		$arrData=$this->adodbx->search_record_by_limit_where($data_table,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["tipe"]			=	$val["tipe_org"];
			$arrData[$x]["x"]				=	(float)$val["longitude"];
			$arrData[$x]["y"]				=	(float)$val["latitude"];
			$arrData[$x]["id_enc"]			=	encrypt($val['idx']);
			$arrData[$x]["short_narasi"]	=	(strlen($val['narasi'])>250)?substr($val['narasi'],0,250)."...":$val['narasi'];
		endforeach;
		
		if($whereSql):
			$filter	=	" where ".$whereSql;
		else:
			$filter	=	"";
		endif;
		
		$attribute	=	$this->conn->GetRow("select count(idx) as total_konflik, sum(dampak) as total_dampak, sum(luas) as total_luas, sum(investasi) as total_investasi from ".$this->tbl.$filter);
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->geojson($arrData));
		endif;
		
	}
	
	function bnn_get(){
		//debug();
		$format=$this->response->format;
		$this->tbl=$this->model->tbl;
		$where=array();
		
		$where=$this->_get_where_default();
		//$where[]="tipe_org='BNNP'";
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		foreach($arrData as $x=>$val):
			$arrData[$x]["tipe"]=$val["tipe_org"];
			$arrData[$x]["x"]=(float)$val["longitude"];
			$arrData[$x]["y"]=(float)$val["latitude"];
		endforeach;
		// pre($arrData);
		// exit;
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->geojson($arrData));
		endif;
		//pre($arrData);
		
	}
	
	function ipwl_get(){
		//debug();
		
		$format=$this->response->format;
		$this->tbl=$this->model_ipwl->tbl;
		$where=array();
		
		$where=$this->_get_where_default();
		$where[]="(jenis_tempat_rehab='IPWL' or jenis_tempat_rehab='IPNWL')";
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		//pre($whereSql);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["nama"]=$val["nama_instansi"];
			$arrData[$x]["tipe"]=$val["jenis_instansi"];
			$arrData[$x]["x"]=(float)$val["x"];
			$arrData[$x]["y"]=(float)$val["y"];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->geojson($arrData));
		endif;
		//pre($arrData);
		
	}
	
	function kmrd_get(){
		//debug();
		
		$format=$this->response->format;
		$this->tbl=$this->model_ipwl->tbl;
		$where=array();
		
		$where=$this->_get_where_default();
		//$where[]="tipe_org='BNNP'";
		$where[]="(jenis_tempat_rehab='RD' or jenis_tempat_rehab='KM')";
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		//pre($whereSql);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["nama"]=$val["nama_instansi"];
			$arrData[$x]["tipe"]=$val["jenis_instansi"];
			$arrData[$x]["x"]=(float)$val["x"];
			$arrData[$x]["y"]=(float)$val["y"];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->geojson($arrData));
		endif;
		//pre($arrData);
		
	}
	
	function rd_get(){
		//debug();
		
		$format=$this->response->format;
		$this->tbl=$this->model_ipwl->tbl;
		$where=array();
		
		$where=$this->_get_where_default();
		//$where[]="tipe_org='BNNP'";
		$where[]="jenis_tempat_rehab='RD'";
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		//pre($whereSql);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["nama"]=$val["nama_instansi"];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->geojson($arrData));
		endif;
		//pre($arrData);
		
	}
	
	function kp_get(){
		//debug();
		
		$format=$this->response->format;
		$this->tbl=$this->model_ipwl->tbl;
		$where=array();
		
		$where=$this->_get_where_default();
		//$where[]="tipe_org='BNNP'";
		$where[]="jenis_tempat_rehab='KP'";
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		//pre($whereSql);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["nama"]=$val["nama_instansi"];
			$arrData[$x]["tipe"]=$val["jenis_instansi"];
			$arrData[$x]["x"]=(float)$val["x"];
			$arrData[$x]["y"]=(float)$val["y"];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->geojson($arrData));
		endif;
		//pre($arrData);
		
	}
	
	function km_get(){
		//debug();
		
		$format=$this->response->format;
		$this->tbl=$this->model_ipwl->tbl;
		$where=array();
		
		$where=$this->_get_where_default();
		//$where[]="tipe_org='BNNP'";
		$where[]="jenis_tempat_rehab='KM'";
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		//pre($whereSql);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["nama"]=$val["nama_instansi"];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->geojson($arrData));
		endif;
		//pre($arrData);
		
	}
	
	function ipnwl_get(){
		//debug();
		
		$format=$this->response->format;
		$this->tbl=$this->model_ipwl->tbl;
		$where=array();
		
		$where=$this->_get_where_default();
		//$where[]="tipe_org='BNNP'";
		$where[]="jenis_tempat_rehab='IPNWL'";
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		//pre($whereSql);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["nama"]=$val["nama_instansi"];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->geojson($arrData));
		endif;
		//pre($arrData);
		
	}
	
	
	function balai_get(){
		//debug();
		
		$format=$this->response->format;
		$this->tbl=$this->model_ipwl->tbl;
		$where=array();
		
		$where=$this->_get_where_default();
		//$where[]="tipe_org='BNNP'";
		$where[]="jenis_tempat_rehab in ('BB','BLK') ";
		$where=$this->_get_where($where);
		$whereSql=$this->_where_sql($where);
		//pre($whereSql);
		
		//$arrData=$this->adodbx->search_record_by_limit_where($this->tbl_master,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		$arrData=$this->adodbx->search_record_by_limit_where($this->tbl,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["nama"]=$val["nama_instansi"];
			$arrData[$x]["tipe"]=$val["jenis_tempat_rehab"];
			$arrData[$x]["x"]=(float)$val["x"];
			$arrData[$x]["y"]=(float)$val["y"];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->geojson($arrData));
		endif;
		//pre($arrData);
		
	}
	
	function geojson($arrData){
		# Build GeoJSON feature collection array
		$geojson = array(
			'type'      => 'FeatureCollection',
			'features'  => array()
		);
		# Loop through rows to build feature arrays
		//while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
		foreach($arrData as $x=>$row):
			$properties = $row;
			# Remove x and y fields from properties (optional)
			unset($properties['x']);
			unset($properties['y']);
			$feature = array(
				'type' => 'Feature',
				'geometry' => array(
					'type' => 'Point',
					'coordinates' => array(
						$row['x'],
						$row['y']
					)
				),
				'properties' => $properties
			);
			# Add feature arrays to feature collection array
			array_push($geojson['features'], $feature);
		//}
		endforeach;
		//header('Content-type: application/json');
		//return json_encode($geojson, JSON_NUMERIC_CHECK);	
		return $geojson;
	}
	
	function geojson2($arrData,$attribute){
		# Build GeoJSON feature collection array
		$geojson = array(
			'konflik'	=>	$attribute['total_konflik'],
			'type'      =>	'FeatureCollection',
			'features'  =>	array()
		);
		# Loop through rows to build feature arrays
		//while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
		foreach($arrData as $x=>$row):
			$properties = $row;
			# Remove x and y fields from properties (optional)
			unset($properties['x']);
			unset($properties['y']);
			$feature = array(
				'type' => 'Feature',
				'geometry' => array(
					'type' => 'Point',
					'coordinates' => array(
						$row['x'],
						$row['y']
					)
				),
				'properties' => $properties
			);
			# Add feature arrays to feature collection array
			array_push($geojson['features'], $feature);
		//}
		endforeach;
		//header('Content-type: application/json');
		//return json_encode($geojson, JSON_NUMERIC_CHECK);	
		return $geojson;
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
		if($this->encrypt_status==TRUE):
            $id_enc=$id;
            $id=decrypt($id);
        endif;
        $arrData=$this->model->GetRecordData("idx=$id");
		$this->output($arrData);
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
        
		debug();
       
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
			if($val=="N") $data["val"][]=$x;
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
	
	function __render_json($json){
		header('content-type: application/json; charset=utf-8');
		echo isset($_GET['callback'])? "{$_GET['callback']}($json)": $json;
		
	}
	
	function __render($arr){
		header('content-type: application/json; charset=utf-8');
		$json=json_encode($arr);
		echo isset($_GET['callback'])? "{$_GET['callback']}($json)": $json;
		
	}
	
}
