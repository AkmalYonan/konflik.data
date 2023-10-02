<?php defined('BASEPATH') OR exit('No direct script access allowed');

class map extends REST_Controller
{       

    function __construct(){
            parent::__construct();
            $class_folder=basename(dirname(__DIR__));
			$class=__CLASS__;
			
			$this->class=$class;
			$this->$class_folder=$class_folder;
			
			$this->folder=$class_folder."/";
			$this->module=$this->folder.$class."/";
			
            //$this->base_url=GetServerURL().base_url();
            $this->load->helper("file");
			$this->map_file_path="basemap/";  
			$this->load->library("geophp");
			
			phpFastCache::$storage = "files";
			phpFastCache::$path = "cache/";
			phpFastCache::$debugging=true;
			  
    }
	
	function reset_cache_get(){
		$this->__reset_cache();
	}
	
	
	function index_get(){
		//print "map wilayah";
		//$data=$this->__list_wilayah();
		//$this->output($data);
	}
	
	function kota_get($kd_provinsi='00'){
		if($this->input->get("reset")=="true"):
			$ret=null;
		else:
			$ret = phpFastCache::get("provinsi-".$kd_provinsi);
		endif;
		
		if($ret==null):
			$kd_provinsi=substr($kd_provinsi,0,2);
			$kd_provinsi=!empty($kd_provinsi)?$kd_provinsi:"00";
			$str=file_get_contents("basemap/kota.geojson");
			$arr=json_decode($str,true);
			$newArr=$arr;
			$newArr["features"]=array();
			foreach($arr["features"] as $x=>$val):
				$properties=array();
				$properties=$val["properties"];
				$properties=array_change_key_case($properties, CASE_LOWER);
					
				$properties["kode_bps"]=$properties["id_kabkota"];
				$properties["kode_wilayah"]=$properties["id_kabkota"];
				$properties["provinsi"]=$properties["provinsi"];
				$arr["features"][$x]["properties"]=$properties;
				$arr["features"][$x]["crs"]=array(
					'type' => 'EPSG',
					'properties' => array('code' => 4326)
				);
				if($kd_provinsi=='00'):
					array_push($newArr["features"],$arr["features"][$x]);
				else:
					if($kd_provinsi==$properties["id_provins"]):
						array_push($newArr["features"],$arr["features"][$x]);
					endif;
				endif;
			endforeach;
			phpFastCache::set("kota-".$kd_kabupaten,$newArr,3000);
			//$json=json_encode($newArr);
			//$this->__render_json($json);
			$this->output($newArr);
		else:
			$json=$ret;
			$this->__render_json($json);
		endif;
		
	}
	
	function kota_point_get($kd_provinsi='00'){
		$this->load->helper("geophp");
		if($this->input->get("reset")=="true"):
			$ret=null;
		else:
			$ret = phpFastCache::get("provinsi-".$kd_provinsi);
		endif;
		
		if($ret==null):
			$kd_provinsi=substr($kd_provinsi,0,2);
			$kd_provinsi=!empty($kd_provinsi)?$kd_provinsi:"00";
			$str=file_get_contents("basemap/kota.geojson");
			$arr=json_decode($str,true);
			$newArr=$arr;
			$newArr["features"]=array();
			foreach($arr["features"] as $x=>$val):
				$ct = json_encode($val);
				$ctr  = json_to_centroid($ct);
				
				$properties=array();
				$properties=$val["properties"];
				$properties=array_change_key_case($properties, CASE_LOWER);
					
				$properties["kode_bps"]=$properties["id_kabkota"];
				$properties["kode_wilayah"]=$properties["id_kabkota"];
				$properties["provinsi"]=$properties["provinsi"];
				
				$arr["features"][$x]["properties"]=$properties;
				$arr["features"][$x]["properties"]["radius"]=3;
				$arr["features"][$x]["crs"]=array(
					'type' => 'EPSG',
					'properties' => array('code' => 4326)
				);
				
				$koord = '{"type":"Point","coordinates":['.$ctr->getX().','.$ctr->getY().']}';			
				$arr['features'][$x]['geometry'] =  json_decode($koord, true);
			
				if($kd_provinsi=='00'):
					array_push($newArr["features"],$arr["features"][$x]);
				else:
					if($kd_provinsi==$properties["id_provins"]):
						array_push($newArr["features"],$arr["features"][$x]);
					endif;
				endif;
			endforeach;
			phpFastCache::set("kota-".$kd_kabupaten,$newArr,3000);
			//$json=json_encode($newArr);
			//$this->__render_json($json);
			$this->output($newArr);
		else:
			$json=$ret;
			$this->__render_json($json);
		endif;
		
	}
	
	function __reset_cache(){
		phpFastCache::cleanup();
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
	

}