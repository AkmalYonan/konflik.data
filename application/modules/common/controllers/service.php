<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class service extends Admin_Controller {
	var $arr_category=array();
    
    function __construct(){
        parent::__construct();
        
        $this->load->helper(array('form', 'url','file'));
    	$this->load->helper("lookup");
        $class_folder=basename(dirname(__DIR__));
        $class=__CLASS__;
		
		$this->class=$class;
		$this->$class_folder=$class_folder;
		
		$this->load->helper(array('form', 'url','file'));
    	//$this->load->library("Hrms");
        $this->folder=$class_folder."/";
        $this->module=$this->folder.$class."/";
        $this->http_ref=base_url().$this->module;
       
        $this->load->helper("menu_helper");
        
        //$this->load->model("general_model");
        //$this->model=new general_model("m_event_group2");
		$this->main_layout="admin_layout/main_layout";
		$this->module_title="Tanah";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx asc";
		
	 }
	 
	 function lookup_kota($kd_propinsi,$selected=''){
	 	$arr=$this->adodbx->search_record_where("m_kabupaten_kota","kode_prop='".$kd_propinsi."' AND kode_kab LIKE '7%' AND level='1'");
		$tmp=array();
		$tmp[]="<option value=''></option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["kode_kab"]==$selected)?' selected="selected"':'';
				$tmp[]="<option value='".$v["kode_kab"]."'".$s.">".$v["nama"]."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	 }
	 function lookup_kabupaten($kd_propinsi,$selected=''){
	 	$arr=$this->adodbx->search_record_where("m_kabupaten","kd_propinsi='".$kd_propinsi."'");
		$tmp=array();
		$tmp[]="<option value=''></option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["kd_kabupaten"]==$selected)?' selected="selected"':'';
				$tmp[]="<option value='".$v["kd_kabupaten"]."'".$s.">".$v["nm_kabupaten"]."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	 }
	 function lookup_propinsi($selected=''){
	 	$arr=$this->adodbx->search_record_where("m_propinsi",false);
		$tmp=array();
		$tmp[]="<option value=''></option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["kd_propinsi"]==$selected)?' selected="selected"':'';
				$tmp[]="<option value='".$v["kd_propinsi"]."'".$s.">".$v["nm_propinsi"]."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	 }
	 
	 function lookup_wilayah_by_tipe($tipe,$selected='',$k1=false,$only_selected=false){
		if($tipe=="Provinsi"):
			return $this->lookup_propinsi($selected);
		elseif($tipe=="Kabupaten/Kota"):		
			return $this->lookup_kabupaten($k1,$selected);
		endif;
		
	 }
	 
	 /*
	 //Original lookup_org_by_tipe
	 function lookup_org_by_tipe($tipe,$selected=''){
	 	$arr=$this->adodbx->search_record_where("m_org","kd_org LIKE '%".$tipe."' AND active='1'");
		$tmp=array();
		$tmp[]="<option value=''></option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["kd_org"]==$selected)?' selected="selected"':'';
				$a=preg_split("/-/",$v['kd_org']);
				$tmp[]="<option value='".$v["kd_org"]."' data-prop='".$a[0]."' data-kab='".$a[1]."' ".$s.">".$v["nama"]."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	 }
	 */
	 
	 //Edited lookup_org_by_tipe
	 function lookup_org_by_tipe($tipe,$selected='',$only_selected=false){
		if ($only_selected) {
			$sql_kd_inst=" and kd_instansi='".$selected."'";
			$sql_kd_org=" and kd_org='".$selected."'";
		}
		if($tipe=="BL"):
			$filter	=	"(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK')".$sql_kd_inst; //Balai
			$arr=$this->adodbx->search_record_where("m_instansi",$filter);
		elseif($tipe=="KM"):		
			$filter	=	"jenis_tempat_rehab='KM'".$sql_kd_inst; //KM
			$arr=$this->adodbx->search_record_where("m_instansi",$filter);
		elseif($tipe=="RD"):
			$filter	=	"jenis_tempat_rehab='RD'".$sql_kd_inst; //RD
			$arr=$this->adodbx->search_record_where("m_instansi",$filter);
		elseif($tipe=="IPWL"):
			$filter	=	"active=1 and jenis_tempat_rehab='IPWL'".$sql_kd_inst; //RD
			$arr=$this->adodbx->search_record_where("m_instansi",$filter);
		else:
			$arr=$this->adodbx->search_record_where("m_org","kd_org LIKE '%".$tipe."' AND active='1'".$sql_kd_org);
		endif;
		
		if($tipe=="BL" or $tipe=="KM" or $tipe=="RD" or $tipe=="IPWL"):
			$tmp=array();
			//$tmp[]="<option value=''></option>";
			if(cek_array($arr)):
				foreach($arr as $v):
					$s=($v["kd_instansi"]==$selected)?' selected="selected"':'';
					$a=preg_split("/-/",$v['kd_instansi']);
					$tmp[]="<option value='".$v["kd_instansi"]."' data-prop='".$a[0]."' data-kab='".$a[1]."' ".$s.">".$v["nama_instansi"]."</option>";
				endforeach;
			endif;
		else:
			$tmp=array();
			//$tmp[]="<option value=''></option>";
			if(cek_array($arr)):
				foreach($arr as $v):
					$s=($v["kd_org"]==$selected)?' selected="selected"':'';
					$a=preg_split("/-/",$v['kd_org']);
					$tmp[]="<option value='".$v["kd_org"]."' data-prop='".$a[0]."' data-kab='".$a[1]."' ".$s.">".$v["nama"]."</option>";
				endforeach;
			endif;
		endif;
		
		print join("/r/n",$tmp);
		
	 }
	 //End 	  
	 
	 function lookup_org_by_level($level,$selected=''){
	 	$arr=$this->adodbx->search_record_where("m_org","level='".$level."' AND active='1'");
		$tmp=array();
		$tmp[]="<option value=''></option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["kd_org"]==$selected)?' selected="selected"':'';
				$a=preg_split("/-/",$v['kd_org']);
				$tmp[]="<option value='".$v["kd_org"]."' data-prop='".$a[0]."' data-kab='".$a[1]."' ".$s.">".$v["nama"]."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	 }
	 
	 function lookup_bnnp_by_propinsi($kd_propinsi,$selected=''){
	 	$arr=$this->adodbx->search_record_where("m_org","kd_wilayah_propinsi='".$kd_propinsi."' AND tipe_org='BNNP' AND active='1'");

		$tmp=array();
		//$tmp[]="<option value=''></option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["kd_org"]==$selected)?' selected="selected"':'';
				$a=preg_split("/-/",$v['kd_org']);
				$tmp[]="<option value='".$v["kd_org"]."' data-prop='".$a[0]."' data-kab='".$a[1]."' ".$s.">".$v["nama"]."</option>";
			endforeach;
		endif;
		
		print join("/r/n",$tmp);
		
	 }	 
	 
	 /*NOT USE IN THIS APPS*/
	 /*function lookup_kecamatan($kd_propinsi,$kd_kabupaten,$selected=''){
	 	$arr=$this->adodbx->search_record_where("m_kecamatan","KD_PROPINSI='".$kd_propinsi."' AND KD_KABUPATEN='".$kd_kabupaten."'");
		$tmp=array();
		$tmp[]="<option value=''></option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["KD_KECAMATAN"]==$selected)?' selected="selected"':'';
				$tmp[]="<option value='".$v["KD_KECAMATAN"]."'".$s.">".$v["NM_KECAMATAN"]."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	 }
	 function lookup_desa($kd_propinsi,$kd_kabupaten,$kd_kecamatan,$selected=''){
	 	$arr=$this->adodbx->search_record_where("m_desa","KD_PROPINSI='".$kd_propinsi."' AND KD_KABUPATEN='".$kd_kabupaten."' AND KD_KECAMATAN='".$kd_kecamatan."'");
		$tmp=array();
		$tmp[]="<option value=''></option>";
		if(cek_array($arr)):
			foreach($arr as $v):
				$s=($v["KD_DESA"]==$selected)?' selected="selected"':'';
				$tmp[]="<option value='".$v["KD_NM_DESA"]."'".$s.">".$v["NM_DESA"]."</option>";
			endforeach;
		endif;
		print join("/r/n",$tmp);
		
	 }*/
}
