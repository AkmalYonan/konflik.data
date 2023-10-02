<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class target extends Admin_Controller {
	var $arr_category=array();   
    function __construct(){
        parent::__construct();       
        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
        $class_folder = basename(dirname(__DIR__)); //admin
		$class = __CLASS__; //dashboard
		$this->class=$class;
		$this->$class_folder=$class_folder;
		
		$this->load->library("utils");
		
		$this->load->helper(array('form', 'url','file'));
    	
		$this->folder=$class_folder."/"; //master_data/
        $this->module=$this->folder.$class."/";//master_data/uu_daerah/
        $this->http_ref=base_url().$this->module;///brwa/admin/dashboard/

        $this->module_data=$this->folder."data/";//master_data/uu_daerah/
        
        $this->load->model("general_model");
        $this->model=new general_model("map_layers");
		$this->model_category=new general_model("cms_pages_category");
		$this->main_layout="admin_lte_layout/main_layout";
		$this->parent_module_title="Target/Program Pemerintah";
		$this->module_title="";
		$this->tbl_idx="idx";
		$this->tbl_sort="order_num asc";	
		/*
		$this->lookup_map_group	=	lookup("map_layer_group","kd_group","ur_group","kd_group in ('TORA','PIAPS','HA')","order by order_num");
		*/
		$this->lookup_map_group	=	lookup("map_data_group","kd_group","ur_group",false,"order by order_num");
		//debug();
		//
		//exit();
		//debug();
		//$this->init_lookup();
		
	 }
	 
	 //TODO: place this method in library
	 function echo_dbf($dbfname) {
		$fdbf = fopen($dbfname,'r');
		$fields = array();
		$buf = fread($fdbf,32);
		$goon = true;
		$unpackString='';
		while ($goon && !feof($fdbf)) { // read fields:
			$buf = fread($fdbf,32);
			if (substr($buf,0,1)==chr(13)) {$goon=false;} // end of field list
			else {
				$field=unpack( "a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf,0,18));
				$arr[]=preg_replace('/[^A-Za-z0-9_\-]/', '', $field['fieldname']);
			}
		}
		fclose($fdbf); 
		return $arr;
	 } 
	 
	 function index(){
	 	$this->listview();
		//$this->_render_page($this->module."registrasi_list",$data,true);
	 }

	 function listview(){
		
		$this->load->library('pagination');  
		
		$table=$this->model->tbl;    
        //$table="($sql) a";
		$req=get_post();
		$kd_group=$req["kd_group"]?$req["kd_group"]:false;
		
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
		
		//$where[]="(category=1)";
		$where[]="(kd_group in ('TORA','PIAPS','HA'))";
        
		if($kd_group):
			$where[]=" kd_group='".$kd_group."'";
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
        $sortBy=" order by {$this->tbl_sort}";
        
		
		
        //$arrData=$this->model->SearchRecordLimitWhere($whereSql,$perPage,$offset,$sortBy);
		$arrData=$this->model->search_record_by_limit_where($table,$whereSql,$perPage,$offset,$sortBy);
        
		if (is_array($arrData)) {
			foreach($arrData as $k=>$v) {
				$arrData[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,3);
				$arrData[$k]['news_clip2']=substr($v['clip'],0,100)."...";
			}
		}
		
		
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
	
	function wmslayer() {
		$arrData=$this->conn->GetAll("select a.ur_group,b.* from map_layers b left join map_layer_group a on a.kd_group=b.kd_group order by b.order_num");
		if(cek_array($arrData)):
			foreach($arrData as $k=>$v) :
				$xx[]="var w".$k." = L.tileLayer.wms(wikera_url, {layers: '".$v['kd_layer']."', FORMAT:'image/png', TRANSPARENT:true,opacity:0.5});\n";
				$arr[strtoupper($v['ur_group'])][$v['kd_layer']]='w'.$k;
			endforeach;
		endif;
		pre(implode(",",$xx));
		pre(json_encode($arr));
	}
	function mapfile() {debug();
		$arrData=$this->model->SearchRecord(false,"order by order_num asc");
		if (!cek_array($arrData)) return false;
		
		$tplx='<!-- MapServer Template -->
				<!DOCTYPE html>
				<html class=" js csstransforms csstransforms3d csstransitions" lang="en"><head>
					<!-- Bootstrap 3.3.7 -->
					<link rel="stylesheet" href="/bootstrap.css">
					<style>
						blockquote {
							margin:0 0 5px!important;
							font-size:14px;
						}
						blockquote p {
							margin:0!important
						}
					</style>
				</head>
				<body>
				<div style="max-height:160px; overflow:auto">
				';
				$tpl='<!-- MapServer Template -->
				<div style="max-height:160px; overflow-y:auto; overflow-x:hidden">
				';
				
		$map='MAP
				NAME "sample"
				STATUS ON
				SIZE 600 400
				SYMBOLSET "etc/symbols.txt"
				EXTENT -180 -90 180 90
				UNITS DD
				IMAGECOLOR 255 255 255
				FONTSET "etc/fonts.txt"

				DEBUG 5
				SHAPEPATH "raw/"
				#
				# Start of web interface definition
				#
				WEB
					IMAGEPATH "/tmp/"
        			IMAGEURL "/tmp/"
					METADATA
					"wms_title"           "WMS Demo Server"
					"wms_onlineresource"  "http://flat.dinamof.co.id:5222/cgi-bin/mapserv?map=/opt/mapserver/map/jkpp.map&"
					"wms_srs"       "EPSG:3857 EPSG:4326"  ##recommended
					"wms_enable_request" "*"   ##necessary
					"WMS_FEATURE_INFO_MIME_TYPE" "text/html"
					END
				END # WEB
				
				OUTPUTFORMAT
				  NAME "html"
				  DRIVER "TEMPLATE"
				  FORMATOPTION "FILE=tmp.html"
				END
				
				PROJECTION
					"init=epsg:4326"
				  END
				  ';
				
				foreach($arrData as $k=>$v) :
				$map.='#
				# Start of layer '.($k+1).' definitions
				#
				LAYER
				  NAME "'.$v['kd_layer'].'"
				  TYPE '.$v['layer_type'].'
				  STATUS ON
				  METADATA
					"wms_title" "'.$v['kd_layer'].'"
					"wms_srs" 	"EPSG:3857 EPSG:4326"  ##recommended
					"wfs_getfeature_formatlist" "gml,geojson,html"
				  END
				  PROJECTION
					"init=epsg:4326"
				  END
				  DATA "'.$v['layer_data'].'"
				  TEMPLATE "dummy"
				  
				  COMPOSITE
					OPACITY 50
				  END # COMPOSITE
				  CLASS
					STYLE
					  COLOR "'.$v['layer_color'].'"
					  OUTLINECOLOR "'.$v['layer_outline_color'].'"
					END
					LABEL
					 COLOR  0 0 0
					 FONT sans
					 TYPE truetype
					 SIZE 8
					 POSITION AUTO
					 PARTIALS FALSE
					 OUTLINECOLOR 255 255 255
					END
				  END
				END # layer
				';
				
				$dbf=$v['layer_fields']?explode(",",$v['layer_fields']):false;
				$fields=false;
				if (cek_array($dbf)):
					foreach($dbf as $dv) :
						$fields.='<tr><td>'.$dv."</td><td width='5'>:</td><td>[".$dv."]</td></tr>";
					endforeach;
				endif;
				$tpl.='
				[resultset layer='.$v['kd_layer'].']
				<h5 style="white-space:nowrap">'.$v['ur_layer'].'</h5>
				<table class="table table-condensed">
				  [feature]'.$fields.'[/feature]
				</table>
				[/resultset]
				';
			endforeach;
			$map.='END # MAP';
			
			$tpl.='</div>';
			$tplx.='</div></body>
				</html>';
			
			$mapfile = $this->config->item("dir_mapfile").'jkpp.map';
			
			if ( ! write_file($mapfile, $map,'w'))
			{
					echo 'Unable to write the file';
			}
			else
			{
					echo 'Map File written!';
			}
			
			$tplfile = $this->config->item("dir_mapfile").'tmp.html';
			
			if ( ! write_file($tplfile, $tpl,'w'))
			{
					echo 'Unable to write the file';
			}
			else
			{
					echo 'Template File written!';
			}
	}
	 
	 function get_layer_data($archive) {
	 	for ($i = 0; $i < $archive->numFiles; $i++) {
			 if(strstr($archive->getNameIndex($i),".shp")) return  $archive->getNameIndex($i);
		 }
	 }	
	 
	 function get_layer_dbf($archive,$array=false) {
	 	for ($i = 0; $i < $archive->numFiles; $i++) {
			 //pre($archive->getNameIndex($i));
			 if(strstr($archive->getNameIndex($i),".dbf")):
			  	$dbf_name=$archive->getNameIndex($i);
				return $dbf_name;
		 	 endif;
		 }
		 /*
		 if ($dbf) {
			return ($array)?$this->echo_dbf($dbf_name):implode(",",$this->echo_dbf($dbf_name)); 
		 }*/
	 }		
	 
	 function add() {
	 	$this->msg_ok="Data created successfully";
        $this->msg_fail="Unable to add new Data";
        
        $act=$this->input->post("act")?$this->input->post("act"):"";    
        if(empty($act)):
            $data=null;
            $this->_render_page($this->module."v_add",$data,true);
        endif;
		if($act=="create"):
			$data=get_post();
			if ($_POST['filename']) {
				$tmp_name = $this->config->item('dir_tmp').$_POST['filename'];
				$path=$this->config->item('dir_shapefile');
				$new_name = $path.$_POST['filename'];
				//pre($tmp_name);pre(file_exists($tmp_name));pre($new_name);//exit;
				// echo $new_name;exit; 
				if (file_exists($tmp_name)) {
					$zip = new ZipArchive;
					
					if ($zip->open($tmp_name) === TRUE) {
						$test=$zip->extractTo($path);
						$layer = $this->get_layer_data($zip);//get layer_name (shp file in zip) used for MAPFILE LAYER DATA
						
						$dbf_name = $this->get_layer_dbf($zip);//get layer_name (dbf file in zip) used for MAPFILE LAYER TEMPLATE
						//pre($layer_dbf);
						$zip->close();
						
						$layer_dbf=$this->echo_dbf($path.$dbf_name);
						
						//unlink($tmp_name);
						if ($layer) {
							$data["layer_data"]=$layer ;
							$data["layer_fields"]=$layer_dbf ;
							$archive=true;
						}
					}else{
						print("not ok");
					}
					
					if ($archive) {
						//exit;
						$data=$this->_add_creator($data);
						$data["author"]=$data["creator"];
						$data["kd_layer"]=str_replace(array(" ","(",")","/","-"),array("_","","","_","_"),$data['ur_layer']);
						$data["status"]=$data["status"]?1:0;
						//pre($data);
						$this->conn->StartTrans();
						$this->model->InsertData($data);
						
						$ok=$this->conn->CompleteTrans();
						if ($ok) $this->mapfile();
		
					} else {
						$ok=false;
						
					}
				}else{
					$ok=false;	
				}
				$this->_proses_message($ok,$this->module."listview/",$this->module."add/");
			}
		endif;
	 }
	 
	 function edit($id){
  		if($this->encrypt_status==TRUE):
			$id_enc=$id;
			$id=decrypt($id);
		endif;
		$this->msg_ok="Data updated successfully";
        $this->msg_fail="Unable to update data";
       	
		
        $act=$this->input->post("act")?$this->input->post("act"):"";   
		//pre($act); 
        if(empty($act)):
            $arrData=$this->model->GetRecordData("idx=$id");
            $data["data"]=$arrData;
            
			$file_name = str_replace("shp","dbf",$arrData["layer_data"]);
			$data["all_fields"]=$this->echo_dbf($this->config->item("dir_shapefile").$file_name);
			$data["layer_fields"]=$arrData["layer_fields"]?explode(",",$arrData["layer_fields"]):$data["all_fields"];
			$this->_render_page($this->module."v_edit",$data,true);
        endif;
		
		if($act=="update"):
			$data=get_post();
			if($this->encrypt_status==TRUE):
				$id_enc=$data['id'];
				$id=decrypt($data['id']);
			endif;
			
			if ($_POST['layer_fields']) $data['layer_fields']=implode(",",$_POST['layer_fields']);
			if ($_POST['filename']) {
				$tmp_name = $this->config->item('tmp_full_path').$_POST['filename'];
				$new_name = $this->config->item('dir_shapefile').$_POST['filename'];
				//pre($tmp_name);pre(file_exists($tmp_name));pre($new_name);//exit;
				// echo $new_name;exit; 
				if (file_exists($tmp_name)) {
					$zip = new ZipArchive;
					if ($zip->open($tmp_name) === TRUE) {
						$zip->extractTo($this->config->item("dir_shapefile"));pre($zip);
						$layer = $this->get_layer_data($zip);//get layer_name (shp file in zip) used for MAPFILE LAYER DATA
						$zip->close();
						//unlink($tmp_name);
						if ($layer) {
							$data["layer_data"]=$layer ;
							$archive=true;
						}
					}
				}
			}
			//exit;
			$data=$this->_add_creator($data);
			$data["author"]=$data["creator"];
			$data["kd_layer"]=str_replace(array(" ","(",")","/","-"),array("_","","","_","_"),$data['ur_layer']);
			$data["status"]=$data["status"]?1:0;
			
			$this->conn->StartTrans();
			$this->model->UpdateData($data, "{$this->tbl_idx}=$id");
			$ok=$this->conn->CompleteTrans();
			if ($ok) $this->mapfile();
			//debug();
			
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
	
	function reorder($order,$prefix=false){
  		//if (!$this->cms->has_write($this->module)) redirect ("admin/error");
		if ($_SERVER['REQUEST_METHOD']=='GET') {
			debug();
			$process=true;
			$_data=get_post();
			$order = $_data['order'];
			$prefix = $_data['prefix']?$_data['prefix']:'';
			if ($order) {
				$order = explode(",",$order);	
				$this->conn->StartTrans();
				foreach($order as $k=>$v) {
					if ($prefix) {
						$nval=str_replace($prefix,"",$v);
					}
					//pre("update m_lookup set sort='".$k."' where idx='".$nval."'");
					$update = $this->model->UpdateData(array("order_num"=>$k),"idx='".$nval."'");
				}
				$ok=$this->conn->CompleteTrans();
				if ($ok) {
					$this->mapfile();
					set_message("success","Data Re-ordered.");
				}
			}
			
			if ($update) {
				
			}
		}
		
  	}
	
	 
	 
	 

}