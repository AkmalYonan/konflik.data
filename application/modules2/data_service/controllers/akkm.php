 <?php defined('BASEPATH') OR exit('No direct script access allowed');
class akkm extends REST_Controller
{       
    function __construct(){
		parent::__construct();
		$this->base_url=GetServerURL().base_url();
		$class_folder=basename(dirname(__DIR__));
		$class=__CLASS__;

		$this->class=$class;
		$this->$class_folder=$class_folder;

		$this->load->helper(array('form', 'url','file','number'));
		$this->folder=$class_folder."/";
		$this->module=$this->folder.$class."/";
		$this->http_ref=base_url().$this->module;

		$this->load->model("general_model");
		$this->model=new general_model("t_akkm");
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
	
	function akkm_get(){
		$format=$this->response->format;
		
		$this->tbl=$this->model->tbl;
		$where=array();

		$where=$this->_get_where_default();
		$where=$this->_get_where($where);
		
		//$whereSql	=	$this->_where_sql($where);
		
		$whereSql	=	"";
		
		$and		=	"";
		$var		=	get_post();
		
		//pre($var);
		//pre($var);
		//pre($var["konflik"]);
		
		if($var):
			$kd_prop		=	$var['kd_prop']?$var['kd_prop']:false;
			
			$kd_prop		=	$kd_prop=="false"?false:$kd_prop;
			$id_kabupaten	=	$var['kd_kab']?$var['kd_kab']:false;
			$id_kabupaten	=	$id_kabupaten=="false"?false:$id_kabupaten;
			$kd_sektor		=	$var['sektor']?$var['sektor']:false;
			$kd_sektor		=	$kd_sektor=="false"?false:$kd_sektor;
			
			$tahun			=	$var['tahun']?$var['tahun']:0;//date('Y');
			
			$kd_kategori	=	$var['kategori']?$var['kategori']:'K1';
			$zoom			=	$var['z']?$var['z']:1;
			//$kd_kategori	=	$kategori==false?false:$kd_kategori;
			//$kd_konflik=false;
			//$kd_sektor="K17,K18";
			if($kd_prop):
				$whereSql	.=	$and." kd_propinsi='".$kd_prop."'";
				$and		=	" and ";
			
			endif;
			
			if($id_kabupaten):
				$whereSql	.=	$and." kd_kabupaten='".$kd_prop.$id_kabupaten."'";
				$and		=	" and ";
			
			endif;
			
			if($kd_kategori && $format!='html'):
				if ($kd_kategori=='K1') {
					$whereSql	.=	$and." status_akkm='Realisasi'";
				}
				else if ($kd_kategori=='K2') {
					$whereSql	.=	$and." (status_akkm='Usulan' or status_akkm is null)";
				}
				else if ($kd_kategori=='K3') {
					$whereSql	.=	$and." (status_akkm='Potensi' or status_akkm is null)";
				}
				$and		=	" and ";
			
			endif;
			
			if($kd_ekosistem):
				//$whereSql	.=	$and." kd_sektor='".$kd_sektor."'";
				$arr_sektor=explode(",",$kd_ekosistem);
				$txt_sektor="";
				if(cek_array($arr_sektor)):
					$tmp=array();
					foreach($arr_sektor as $x=>$val):
						$tmp[]=" ekosistem like '%".$val."%'";
					endforeach;
					$txt_sektor="(".join(" || ",$tmp).")";
				
				endif;
				$whereSql	.=	$and. $txt_sektor;
				
				$and		=	" and ";
		
			endif;
			
			if($tahun):
				$whereSql	.=	$and." tahun='".$tahun."'";
				$and		=	" and ";
			endif;
		endif;

		$data_table	=$this->tbl;
						
		//pre($whereSql);
		//debug();
		$arrData=$this->adodbx->search_record_by_limit_where($data_table,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		//pre($arrData);
		//exit;
		foreach($arrData as $x=>$val):
			$arrData[$x]["status_akkm"]			=	$val["status_akkm"];
			$arrData[$x]["x"]				=	(float)$val["longitude"];
			$arrData[$x]["y"]				=	(float)$val["latitude"];
			$arrData[$x]["id_enc"]			=	encrypt($val['idx']);
			$clip							= "<b>Deskripsi:</b><br>".$val["deskripsi"];
			$arrData[$x]["short_narasi"]	=	(strlen($clip)>250)?substr($clip,0,250)."...":$clip;
			//$arrData[$x]["short_narasi"]	=	(strlen($clip)>250)?substr($clip,0,250)."...":$clip;
			//$arrData[$x]["judul"]	=	(strlen($val['judul'])>250)?substr($val['judul'],0,250)."...":$val['judul'];
			//$arrData[$x]["short_narasi"]	=	(strlen($val['narasi'])>250)?substr($val['narasi'],0,250)."...":$val['narasi'];
		endforeach;
		
		if($whereSql):
			$filter	=	" where ".$whereSql;
		else:
			$filter	=	"";
		endif;
		
		//$attribute	=	$this->conn->GetRow("select count(idx) as total_konflik, sum(dampak) as total_dampak, sum(luas) as total_luas, sum(investasi) as total_investasi from ".$this->tbl.$filter);
		
		if($this->_limit()):
			$filter	.=	" limit ".$this->_limit();
		else:
			$filter	.=	"";
		endif;
		
		if($this->_offset()):
			$filter	.=	" offset ".$this->_offset();
		else:
			$filter	.=	"";
		endif;
		
		$total_rows	=	$this->conn->GetOne("select count(idx) from ".$this->tbl.$filter);
		
		if($format!='geojson'):
			$data['data']	=	$arrData;
			$data['limit']	=	$this->_limit();
			$data['total']	=	$total_rows;
			echo $this->load->view($this->module."list_data",$data,true);
		else:
			$this->__render($this->akkm_geojson($arrData,$attribute,$zoom));
		endif;
		
	}
	
	function tora_piaps_get(){

		$format=$this->response->format;
		$this->tbl=$this->model->tbl;
		$where=array();

		$where=$this->_get_where_default();
		$where=$this->_get_where($where);
		
		//$whereSql	=	$this->_where_sql($where);
		
		$var		=	get_post();
		
		$val_tora		=	$var['tora'];
		$val_piaps		=	$var['piaps'];
		$val_hutan_adat	=	$var['hutan_adat'];
		
		$whereSql	=	"(the_geom IS NOT NULL and status_validas_peta=1)";
		
		$and		=	" and ";
		
		if($val_tora==1 or $val_piaps==1 or $val_hutan_adat==1):
			$whereSql	.=	$and." (";
			$and		=	"";
			
			if($val_tora==1):
				$whereSql	.=	$and." kode_jns_wikera='TORA' ";
				$and		=	" or ";
			endif;
			if($val_piaps==1):
				$whereSql	.=	$and." kode_jns_wikera='PIAPS' ";
				$and		=	" or ";
			endif;
			if($val_hutan_adat==1):
				$whereSql	.=	$and." kode_jns_wikera='HA' ";
				$and		=	" or ";
			endif;
			
			$whereSql	.=	" )";
		else:
			$whereSql	.=	$and." kode_jns_wikera='FALSE' ";
			$and		=	" and ";
		endif;
		
		
		$data_table	=	"
						(select
							idx,
							file_peta,
							kode_jns_wikera,
							nama_wikera,
							deskripsi,
							clip,
							the_geom,
							status_validas_peta
						from
							t_daftar_wikera
						) x
						";
		
		$arrData=$this->adodbx->search_record_by_limit_where($data_table,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["kode"]			=	$val["kode_jns_wikera"];
			$arrData[$x]["nama_wikera"]		=	$val["nama_wikera"];
			$arrData[$x]["file_peta"]		=	$val["file_peta"];
			$arrData[$x]["id_enc"]			=	encrypt($val['idx']);
			$arrData[$x]["short_narasi"]	=	(strlen($val['clip'])>250)?substr($val['clip'],0,250)."...":$val['clip'];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->tora_piaps_geojson($arrData));
		endif;
		
	}
	
	
	function tora_piaps_usulan_get(){
        //debug();
		$format=$this->response->format;
		$this->tbl=$this->model->tbl;
		$where=array();

		$where=$this->_get_where_default();
		$where=$this->_get_where($where);
		
		//$whereSql	=	$this->_where_sql($where);
		
		$var		=	get_post();
		
		$val_tora		=	$var['tora'];
		$val_piaps		=	$var['piaps'];
		$val_hutan_adat	=	$var['hutan_adat'];
		
		$whereDefault	=	"kode_tahapan not in('T7','T8')";
		$whereSql	=	"(the_geom IS NOT NULL and status_validas_peta=1)";
		
		$and		=	" and ";
		$whereSql=$whereDefault.$and.$whereSql;
		
		if($val_tora==1 or $val_piaps==1 or $val_hutan_adat==1):
			$whereSql	.=	$and." (";
			$and		=	"";
			
			if($val_tora==1):
				$whereSql	.=	$and." kode_jns_wikera='TORA' ";
				$and		=	" or ";
			endif;
			if($val_piaps==1):
				$whereSql	.=	$and." kode_jns_wikera='PIAPS' ";
				$and		=	" or ";
			endif;
			if($val_hutan_adat==1):
				$whereSql	.=	$and." kode_jns_wikera='HA' ";
				$and		=	" or ";
			endif;
			
			$whereSql	.=	" )";
		else:
			$whereSql	.=	$and." kode_jns_wikera='FALSE' ";
			$and		=	" and ";
		endif;
		
		
		$data_table	=	"
						(select
							idx,
							file_peta,
							kode_jns_wikera,
							nama_wikera,
							deskripsi,
							clip,
							kode_tahapan,
							the_geom,
							status_validas_peta
						from
							t_daftar_wikera
						) x
						";
		
		$arrData=$this->adodbx->search_record_by_limit_where($data_table,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["kode"]			=	$val["kode_jns_wikera"];
			$arrData[$x]["nama_wikera"]		=	$val["nama_wikera"];
			$arrData[$x]["file_peta"]		=	$val["file_peta"];
			$arrData[$x]["id_enc"]			=	encrypt($val['idx']);
			$arrData[$x]["short_narasi"]	=	(strlen($val['clip'])>250)?substr($val['clip'],0,250)."...":$val['clip'];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->tora_piaps_geojson($arrData));
		endif;
		
	}
	
	function tora_piaps_realisasi_get(){

		$format=$this->response->format;
		$this->tbl=$this->model->tbl;
		$where=array();

		$where=$this->_get_where_default();
		$where=$this->_get_where($where);
		
		//$whereSql	=	$this->_where_sql($where);
		
		$var		=	get_post();
		
		$val_tora		=	$var['tora'];
		$val_piaps		=	$var['piaps'];
		$val_hutan_adat	=	$var['hutan_adat'];
		
		$whereDefault	=	"kode_tahapan in('T7','T8')";
		$whereSql	=	"(the_geom IS NOT NULL and status_validas_peta=1)";
		
		$and		=	" and ";
		$whereSql=$whereDefault.$and.$whereSql;
		
		if($val_tora==1 or $val_piaps==1 or $val_hutan_adat==1):
			$whereSql	.=	$and." (";
			$and		=	"";
			
			if($val_tora==1):
				$whereSql	.=	$and." kode_jns_wikera='TORA' ";
				$and		=	" or ";
			endif;
			if($val_piaps==1):
				$whereSql	.=	$and." kode_jns_wikera='PIAPS' ";
				$and		=	" or ";
			endif;
			if($val_hutan_adat==1):
				$whereSql	.=	$and." kode_jns_wikera='HA' ";
				$and		=	" or ";
			endif;
			
			$whereSql	.=	" )";
		else:
			$whereSql	.=	$and." kode_jns_wikera='FALSE' ";
			$and		=	" and ";
		endif;
		
		
		$data_table	=	"
						(select
							idx,
							file_peta,
							kode_jns_wikera,
							nama_wikera,
							deskripsi,
							clip,
							kode_tahapan,
							the_geom,
							status_validas_peta
						from
							t_daftar_wikera
						) x
						";
		
		$arrData=$this->adodbx->search_record_by_limit_where($data_table,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["kode"]			=	$val["kode_jns_wikera"];
			$arrData[$x]["nama_wikera"]		=	$val["nama_wikera"];
			$arrData[$x]["file_peta"]		=	$val["file_peta"];
			$arrData[$x]["id_enc"]			=	encrypt($val['idx']);
			$arrData[$x]["short_narasi"]	=	(strlen($val['clip'])>250)?substr($val['clip'],0,250)."...":$val['clip'];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->tora_piaps_geojson($arrData));
		endif;
		
	}
	
	
	function tora_piaps_target_get(){

		$format=$this->response->format;
		$this->tbl=$this->model->tbl;
		$where=array();

		$where=$this->_get_where_default();
		$where=$this->_get_where($where);
		
		//$whereSql	=	$this->_where_sql($where);
		
		$var		=	get_post();
		
		$val_tora		=	$var['tora'];
		$val_piaps		=	$var['piaps'];
		$val_hutan_adat	=	$var['hutan_adat'];
		
		$whereDefault	=	"(kd_group in ('TORA','PIAPS','HA'))";
		$whereSql	=	"(the_geom IS NOT NULL and status_validas_peta=1)";
		
		$and		=	" and ";
		$whereSql=$whereDefault.$and.$whereSql;
		
		if($val_tora==1 or $val_piaps==1 or $val_hutan_adat==1):
			$whereSql	.=	$and." (";
			$and		=	"";
			
			if($val_tora==1):
				$whereSql	.=	$and." kode_group='TORA' ";
				$and		=	" or ";
			endif;
			if($val_piaps==1):
				$whereSql	.=	$and." kode_group='PIAPS' ";
				$and		=	" or ";
			endif;
			if($val_hutan_adat==1):
				$whereSql	.=	$and." kode_group='HA' ";
				$and		=	" or ";
			endif;
			
			$whereSql	.=	" )";
		else:
			$whereSql	.=	$and." kode_group='FALSE' ";
			$and		=	" and ";
		endif;
		
		
		$data_table	=	"
						(select
							idx,
							file_peta,
							kode_jns_wikera,
							nama_wikera,
							deskripsi,
							clip,
							kode_tahapan,
							the_geom,
							status_validas_peta
						from
							t_daftar_wikera
						) x
						";
		
		$arrData=$this->adodbx->search_record_by_limit_where($data_table,$whereSql,$this->_limit(),$this->_offset(),$this->_sort(),$this->_col_select());
		
		foreach($arrData as $x=>$val):
			$arrData[$x]["kode"]			=	$val["kode_jns_wikera"];
			$arrData[$x]["nama_wikera"]		=	$val["nama_wikera"];
			$arrData[$x]["file_peta"]		=	$val["file_peta"];
			$arrData[$x]["id_enc"]			=	encrypt($val['idx']);
			$arrData[$x]["short_narasi"]	=	(strlen($val['clip'])>250)?substr($val['clip'],0,250)."...":$val['clip'];
		endforeach;
		
		if($format!='geojson'):
			$this->output($arrData);
		else:
			$this->__render($this->tora_piaps_geojson($arrData));
		endif;
		
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
	
	function akkm_geojson($arrData,$attribute,$zoom=1){
		$geojson = array(
			'type'		=>	'FeatureCollection',
			'features'	=>	array()
		);
		foreach($arrData as $x=>$row):
			$properties = $row;
			$geom = $row['the_geom'];
			unset($properties['the_geom']);
			if ($geom && $zoom>7) {
				$arr_geom	=	(array)json_decode($geom,TRUE);
				if (count($arr_geom['features'])>1) {
					$geometry  = $arr_geom['features'][0]['geometry'];
					$geometry['coordinates']=false;
					foreach($arr_geom['features'] as $k=>$v) {
						$geometry['coordinates'][$k]=$v['geometry']['coordinates'][0];
					}
					//$geometry = $arr;
				}
				else {
					$geometry	=	$arr_geom['features'][0]['geometry'];
				}
				
				$feature = array(
					'type' => 'Feature',
					'properties' => $properties,
					'geometry'	=>	$geometry
				);
			}
			else {
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
			}
			array_push($geojson['features'], $feature);
		endforeach;
		
		return $geojson;
	}
	
	function tora_piaps_geojson($arrData){
		$geojson = array(
			'type'		=>	'FeatureCollection',
			'features'	=>	array()
		);
		foreach($arrData as $x=>$row):
			$properties = $row;
			
			$geom		=	$row['the_geom'];//read_file($this->config->item("dir_geojson").$row['file_peta']);
		
			$arr_geom	=	(array)json_decode($geom,TRUE);
		    //pre($arr_geom);
			//$geometry	=	$arr_geom['features'][0]['geometry'];
			if (count($arr_geom['features'])>1) {
			    $geometry  = $arr_geom['features'][0]['geometry'];
			    $geometry['coordinates']=false;
			    foreach($arr_geom['features'] as $k=>$v) {
			        $geometry['coordinates'][$k]=$v['geometry']['coordinates'][0];
			    }
			    //$geometry = $arr;
			}
			else {
			    $geometry	=	$arr_geom['features'][0]['geometry'];
			}
			
			$feature = array(
				'type' => 'Feature',
				'properties' => $properties,
				'geometry'	=>	$geometry
			);
			array_push($geojson['features'], $feature);
		endforeach;
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
