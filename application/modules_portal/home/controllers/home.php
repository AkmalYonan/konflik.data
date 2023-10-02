<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends Public_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url','file','language','lookup','bootstrap_helper','news_subscriber'));
        $class_folder=basename(dirname(__DIR__));
        $class=__CLASS__;

		$this->class=$class;
		$this->$class_folder=$class_folder;

        $this->folder=$class_folder."/";
        $this->module=$this->folder.$class."/";
        $this->http_ref=base_url().$this->module;
		$this->lang->load('auth');

        $this->load->model("general_model");
        $this->model=new general_model("cms_pages");
        $this->subscriber_model =   new general_model("news_subscriber");
		$this->sektor_model		=	new	general_model("m_sektor");
		$this->lookup_cat=m_lookup("news_category","kode","nama_kategori",false,"order by idx");
        $this->active="home";
    }
	
	function wmslayer2() {
		//$arrData=$this->conn->GetAll("select UPPER(a.ur_group) as ur_group,b.kd_layer,b.ur_layer from map_layers b left join map_layer_group a on a.kd_group=b.kd_group where b.status=1 order by b.order_num");
		$arrData=$this->conn->GetAll("select a.ur_group,a.kd_group as kd_group2,a.ur_group as ur_group2,b.kd_layer,b.ur_layer from map_layers b left join map_layer_group a on a.kd_group=b.kd_group where a.kd_group not in ('TORA','PIAPS','HA') and b.status=1 and a.kd_group='PP' order by b.order_num");
		if(cek_array($arrData)):
			foreach($arrData as $k=>$v) :
				//echo "var w".$k."=L.tileLayer.wms(wikera_url, {layers: 'PrioritasRestorasi', FORMAT:'image/png', TRANSPARENT:true,opacity:0.5});";
				$arr[$v['ur_group']][$v['ur_layer']]=false;
				$tmp[$v['ur_group']][$v["kd_group"]][$v["kd_layer"]]=$v;
			endforeach;
		endif;
		
		//pre($arr);
		//pre($arrData);
		
		$this->wms_data=$arrData;
		
		$ret .= "layerControlWms = L.control.groupedLayers(null, null,{label:'PETA PARTISIPATIF',fa:'hand-o-up fa-lg',groupCheckboxes: true});\n";
		$ret .= "wmsLayers=".(json_encode($arrData)).";\n";
		$ret .= "for(i=0;i<wmsLayers.length;i++) {\n";
		$ret .= "	var ovl = source.getLayer(wmsLayers[i].kd_layer);\n";
		$ret .= "	layerControlWms.addOverlay(ovl, wmsLayers[i].ur_layer,wmsLayers[i].ur_group);\n";
		$ret .= "	ovl.addTo(map);\n";
		$ret .= "}\n";
		$ret .= "layerControlWms.addTo(map);\n";
		
		return $ret;
	}
	
	function wmslayer_ref() {
		//$arrData=$this->conn->GetAll("select UPPER(a.ur_group) as ur_group,b.kd_layer,b.ur_layer from map_layers b left join map_layer_group a on a.kd_group=b.kd_group where b.status=1 order by b.order_num");
		$arrData=$this->conn->GetAll("select a.ur_group,a.kd_group as kd_group2,a.ur_group as ur_group2,b.kd_layer,b.ur_layer from map_layers b left join map_layer_group a on a.kd_group=b.kd_group where a.kd_group not in ('TORA','PIAPS','HA') and b.status=1 and a.kd_group<>'PP' order by b.order_num");
		if(cek_array($arrData)):
			foreach($arrData as $k=>$v) :
				//echo "var w".$k."=L.tileLayer.wms(wikera_url, {layers: 'PrioritasRestorasi', FORMAT:'image/png', TRANSPARENT:true,opacity:0.5});";
				$arr[$v['ur_group']][$v['ur_layer']]=false;
				$tmp[$v['ur_group']][$v["kd_group"]][$v["kd_layer"]]=$v;
			endforeach;
		endif;
		
		//pre($arr);
		//pre($arrData);
		
		$this->wms_data=$arrData;
		
		$ret .= "layerControlWms2 = L.control.groupedLayers(null, null,{label:'LAYER/PETA LAIN',fa:'map-o fa-lg',groupCheckboxes: true,});\n";
		$ret .= "wmsLayers2=".(json_encode($arrData)).";\n";
		$ret .= "for(i=0;i<wmsLayers2.length;i++) {\n";
		$ret .= "	var ovl2 = source.getLayer(wmsLayers2[i].kd_layer);\n";
		$ret .= "	layerControlWms2.addOverlay(ovl2, wmsLayers2[i].ur_layer,wmsLayers2[i].ur_group);\n";
		//$ret .= "	ovl2.addTo(map);\n";
		$ret .= "}\n";
		$ret .= "layerControlWms2.addTo(map);\n";
		
		return $ret;
	}
	
	
	function wmslayer_wilayah_kelola() {
		//$arrData=$this->conn->GetAll("select UPPER(a.ur_group) as ur_group,b.kd_layer,b.ur_layer from map_layers b left join map_layer_group a on a.kd_group=b.kd_group where b.status=1 order by b.order_num");
		$arrData=$this->conn->GetAll("select 'Target/Program Pemerintah' as ur_group,a.kd_group as kd_group2,a.ur_group as ur_group2,b.kd_layer,b.ur_layer from map_layers b left join map_layer_group a on a.kd_group=b.kd_group where a.kd_group in ('TORA','PIAPS','HA') and b.status=1 order by b.order_num");
		if(cek_array($arrData)):
			foreach($arrData as $k=>$v) :
				//echo "var w".$k."=L.tileLayer.wms(wikera_url, {layers: 'PrioritasRestorasi', FORMAT:'image/png', TRANSPARENT:true,opacity:0.5});";
				$arr[$v['ur_group']][$v['ur_layer']]=false;
			endforeach;
		endif;
		//pre($arr);
		$this->wms2_data=$arrData;
		$ret .= "groupedOverlays1=".json_encode($arr).";\n";
		$ret .= "layer=".(json_encode($arrData)).";\n";
		$ret .= "for(i=0;i<layer.length;i++) {\n";
		$ret .= "	groupedOverlays1[layer[0].ur_group][layer[i].ur_layer]=source.getLayer(layer[i].kd_layer);\n";
		$ret .= "}\n";
		return $ret;
	}
	
	function wmslayer2_backup() {
		$arrData=$this->conn->GetAll("select UPPER(a.ur_group) as ur_group,b.kd_layer,b.ur_layer from map_layers b left join map_layer_group a on a.kd_group=b.kd_group where b.status=1 order by b.order_num");
		if(cek_array($arrData)):
			foreach($arrData as $k=>$v) :
				//echo "var w".$k."=L.tileLayer.wms(wikera_url, {layers: 'PrioritasRestorasi', FORMAT:'image/png', TRANSPARENT:true,opacity:0.5});";
				$arr[$v['ur_group']][$v['ur_layer']]=false;
			endforeach;
		endif;
		$ret .= "groupedOverlays=".json_encode($arr).";\n";
		$ret .= "layer=".(json_encode($arrData)).";\n";
		$ret .= "for(i=0;i<layer.length;i++) {\n";
		$ret .= "	groupedOverlays[layer[i].ur_group][layer[i].ur_layer]=source.getLayer(layer[i].kd_layer);\n";
		$ret .= "}\n";
		return $ret;
	}
	function index2(){
		$data["datax"]=$this->conn->GetAll("
		select count(idx) as total_konflik, sum(dampak) as total_dampak, sum(luas) as total_luas, sum(investasi) as total_investasi from t_daftar_jkpp
		");
		$data["wmsmap"]			=	$this->wmslayer2();
		$data["data_sektor"]	=	$this->sektor_model->ListAll();
		$data["content"]=$this->load->view($this->module."index2",$data,true);
		$this->load->view($this->public_layout."/main_layout",$data);
	}
	
	function wmslayer() {
		$arrData=$this->conn->GetAll("select UPPER(a.ur_group) as ur_group,b.kd_layer,b.ur_layer from map_layers b left join map_layer_group a on a.kd_group=b.kd_group where b.status=1 order by b.order_num");
		if(cek_array($arrData)):
			foreach($arrData as $k=>$v) :
				//echo "var w".$k."=L.tileLayer.wms(wikera_url, {layers: 'PrioritasRestorasi', FORMAT:'image/png', TRANSPARENT:true,opacity:0.5});";
				$arr[$v['ur_group']][$v['ur_layer']]=false;
			endforeach;
		endif;
		$ret .= "groupedOverlays=".json_encode($arr).";\n";
		$ret .= "layer=".(json_encode($arrData)).";\n";
		$ret .= "for(i=0;i<layer.length;i++) {\n";
		$ret .= "	groupedOverlays[layer[i].ur_group][layer[i].ur_layer]=L.tileLayer.wms(wikera_url, {layers: layer[i].kd_layer, FORMAT:'image/png', TRANSPARENT:true,opacity:0.5});\n";
		$ret .= "}\n";
		return $ret;
	}
	function getjumlahwk($s) {
		$req=get_post();
		$sql_tahun = $req["tahun"]?" where year(tgl_kejadian)<='{$req["tahun"]}'":"";
		$jml=$this->conn->GetRow("
			SELECT 
				sum(case when kode_tahapan not in ('T7','T8') then 1 else 0 end) usulan,
				sum(case when kode_tahapan in ('T7','T8') then 1 else 0 end) realisasi 
			FROM `t_daftar_wikera`".$sql_tahun);
		echo cek_array($jml)?$jml[$s]:"0";
	}
	function index_old(){
		$req=get_post();
		$data["datax"]=$this->conn->GetAll("
		select count(idx) as total_konflik, sum(dampak) as total_dampak, sum(luas) as total_luas, sum(investasi) as total_investasi from t_daftar_jkpp
		");
		//$data["wmsmap"]	=	$this->wmslayer();
		$data["wmsmap"]	=	$this->wmslayer2();
		$data["wms_wilayah_kelola"]=$this->wmslayer_wilayah_kelola();
		$data["data_sektor"]	=	$this->sektor_model->ListAll();
		//$data["selected_tahun"] = $_GET["tahun"]?$_GET["tahun"]:date("Y");
		$max_tahun=$this->conn->GetOne("select max(tahun) as tahun from t_daftar_jkpp");
		$max_tahun=$max_tahun?$max_tahun:date("Y");
		$selected_tahun=$req["tahun"]?$req["tahun"]:false;//$max_tahun;
		$data["selected_tahun"]=$selected_tahun;
		
		$sql_tahun = $req["tahun"]?" where year(tgl_kejadian)='{$req["tahun"]}'":"";
		$data["data_wk"]=$this->conn->GetRow("
			SELECT 
				sum(case when kode_tahapan not in ('T7','T8') then 1 else 0 end) usulan,
				sum(case when kode_tahapan in ('T7','T8') then 1 else 0 end) realisasi 
			FROM `t_daftar_wikera`".$sql_tahun);
		
		//pre($data["data_wk"]);
		//exit();
		//$data["selected_tahun"] = $tahun?$tahun:$data["selected_tahun"];
		$data["content"]=$this->load->view($this->module."index",$data,true);
		$this->load->view($this->public_layout."/main_layout",$data);
	}
	function index(){
		$req=get_post();
		$data["datax"]=$this->conn->GetAll("
		select count(idx) as total_konflik, sum(dampak) as total_dampak, sum(luas) as total_luas, sum(investasi) as total_investasi from t_daftar_jkpp
		");
		//$data["wmsmap"]	=	$this->wmslayer();
		$data["wmsmap"]	=	$this->wmslayer2();
		$data["wmsmap_2"]	=	$this->wmslayer_ref();
		$data["wms_wilayah_kelola"]=$this->wmslayer_wilayah_kelola();
		$data["data_sektor"]	=	$this->sektor_model->ListAll();
		//$data["selected_tahun"] = $_GET["tahun"]?$_GET["tahun"]:date("Y");
		$max_tahun=$this->conn->GetOne("select max(tahun) as tahun from t_daftar_jkpp");
		$max_tahun=$max_tahun?$max_tahun:date("Y");
		$selected_tahun=$req["tahun"]?$req["tahun"]:false;//$max_tahun;
		$data["selected_tahun"]=$selected_tahun;
		
		$sql_tahun = $req["tahun"]?" where year(tgl_kejadian)='{$req["tahun"]}'":"";
		$data["data_wk"]=$this->conn->GetRow("
			SELECT 
				sum(case when kode_tahapan not in ('T7','T8') then 1 else 0 end) usulan,
				sum(case when kode_tahapan in ('T7','T8') then 1 else 0 end) realisasi 
			FROM `t_daftar_wikera`".$sql_tahun);
		
		//pre($data["data_wk"]);
		//exit();
		//$data["selected_tahun"] = $tahun?$tahun:$data["selected_tahun"];
		$data["content"]=$this->load->view($this->module."index-new",$data,true);
		$this->load->view($this->public_layout."/main_layout",$data);
	}
	function index_test(){
		$req=get_post();
		$data["datax"]=$this->conn->GetAll("
		select count(idx) as total_konflik, sum(dampak) as total_dampak, sum(luas) as total_luas, sum(investasi) as total_investasi from t_daftar_jkpp
		");
		//$data["wmsmap"]	=	$this->wmslayer();
		$data["wmsmap"]	=	$this->wmslayer2();
		$data["wmsmap_2"]	=	$this->wmslayer_ref();
		$data["wms_wilayah_kelola"]=$this->wmslayer_wilayah_kelola();
		$data["data_sektor"]	=	$this->sektor_model->ListAll();
		//$data["selected_tahun"] = $_GET["tahun"]?$_GET["tahun"]:date("Y");
		$max_tahun=$this->conn->GetOne("select max(tahun) as tahun from t_daftar_jkpp");
		$max_tahun=$max_tahun?$max_tahun:date("Y");
		$selected_tahun=$req["tahun"]?$req["tahun"]:false;//$max_tahun;
		$data["selected_tahun"]=$selected_tahun;
		
		$sql_tahun = $req["tahun"]?" where year(tgl_kejadian)='{$req["tahun"]}'":"";
		$data["data_wk"]=$this->conn->GetRow("
			SELECT 
				sum(case when kode_tahapan not in ('T7','T8') then 1 else 0 end) usulan,
				sum(case when kode_tahapan in ('T7','T8') then 1 else 0 end) realisasi 
			FROM `t_daftar_wikera`".$sql_tahun);
		
		//pre($data["data_wk"]);
		//exit();
		//$data["selected_tahun"] = $tahun?$tahun:$data["selected_tahun"];
		$data["content"]=$this->load->view($this->module."index-test",$data,true);
		$this->load->view($this->public_layout."/main_layout",$data);
	}
	function lookup_kota($kd_propinsi,$selected=''){
	 	$arr=$this->adodbx->search_record_where("m_kabupaten","kd_propinsi='".$kd_propinsi."' AND kd_kabupaten !='00'");
		$tmp=array();
		$tmp[]="<option value=''>Semua</option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["kd_kabupaten"]==$selected)?' selected="selected"':'';
				$tmp[]="<option value='".$v["kd_kabupaten"]."'".$s.">".$v["nm_kabupaten"]."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
	}
	
	function lookup_konflik($kd,$selected=''){
		$arr=$this->adodbx->search_record_where("m_konflik","parent_sektor_id='".$kd."'");
		$tmp=array();
		$tmp[]="<option value=''>--Pilih--</option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["idx"]==$selected)?' selected="selected"':'';
				$tmp[]="<option value='".$v["idx"]."'".$s.">".$v["uraian"]."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	}
	function lookup_konflik_admin($kd,$selected=''){
		$arr=$this->conn->GetAll("select * from m_konflik where sektor_id='".$kd."'");
		// $arr=explode(",",$arr[0]['konflik']);
		if(cek_array($arr)):
			foreach($arr as $v):
				$tmp[]="<option value='".$v['uraian']."'>".$v['uraian']."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	 }
	function lookup_konflik_admin_old($kd,$selected=''){
		$arr=$this->conn->GetAll("select * from m_sektor where kode='".$kd."'");
		$arr=explode(",",$arr[0]['konflik']);
		if(cek_array($arr)):
			foreach($arr as $v):
				$tmp[]="<option value='".$v."'".$s.">".$v."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	 }
        
	function scroller_text() {

		$sql = "SELECT count(idx) as total, propinsi,id_propinsi,(
				CASE
					WHEN (wa_status=0)
					THEN 'In Progress'
					WHEN (wa_status=1)
					THEN 'Teregistrasi'
					WHEN (wa_status=2)
					THEN 'Terverifikasi'
					WHEN (doc_proses=3 and doc_status=2 and wa_data_status!=99)
					THEN 'Tersertifikasi'
					WHEN (doc_proses=4 and wa_data_status!=99)
					THEN 'Pengakuan'
				END
				) AS wa_status
				FROM
					v_wa_data
				GROUP BY
					propinsi,wa_status";
		$arrData = $this->conn->GetAll($sql);

		if (cek_array($arrData)) {
			$arr['Indonesia']['Teregistrasi']=0;
			$arr['Indonesia']['Terverifikasi']=0;
			//$arr['Indonesia']['Pengakuan']=0;
			foreach($arrData as $k=>$v) {
				$arr['Indonesia'][$v['wa_status']]+=$v['total'];
				$arr['Indonesia']['Total']+=$v['total'];

				$arr[$v['propinsi']]['Teregistrasi']+=0;
				$arr[$v['propinsi']]['Terverifikasi']+=0;
				$arr[$v['propinsi']]['Tersertifikasi']+=0;
				$arr[$v['propinsi']]['Pengakuan']+=0;
				$arr[$v['propinsi']][$v['wa_status']]+=$v['total'];
				$arr[$v['propinsi']]['Total']+=$v['total'];
			}
			return $arr;
		}
	}

	function footer_links($cat=1,$limit=10,$offset=0,$order='order by idx desc'){
   		// debug();
		// $filter="category=".$cat." and active=1 and publish=1";
		$filter="active=1 and publish=1";
		$arrDB=$this->link_model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
   		return $arrDB;
   }
}
