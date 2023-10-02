<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends Admin_Controller {
	function __construct(){
        parent::__construct();
        
		$class_folder=basename(dirname(__DIR__));
        $class=__CLASS__;
	    
    	
		$this->class=$class;
		$this->$class_folder=$class_folder;
		$this->load->helper(array('form', 'url','file'));
    	$this->load->library("parser");
		
	    $this->folder=$class_folder."/";
        $this->module=$this->folder.$class."/";
		
	    $this->http_ref=base_url().$this->module;
       	$this->load->model("admin/dashboard_model");
        //$this->load->model("general_model");
        //$this->model=new general_model("tb_batas_propinsi");
		
		$this->main_layout="admin_lte_layout/main_layout";
		
		$this->module_title="Dashboard";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";
		$this->init_layout();
	}
	
	function index(){

			$data['total_pegawai'] = $this->conn->GetAll("SELECT count(idx) as total_pegawai FROM sppp_data_pegawai");
			$data['total_pns'] = $this->conn->GetAll("SELECT count(idx) as total_pns FROM sppp_data_pegawai where status_pegawai='pns'");
			$data['total_ppns'] = $this->conn->GetAll("SELECT count(idx) as total_ppns FROM sppp_data_pegawai where status_pegawai='ppns'");
			
			$peg = $this->conn->GetAll("SELECT b.nama as skpd,a.status_pegawai,count(a.status_pegawai) as total FROM sppp_data_pegawai a right join m_skpd b on a.skpd = b.nama group by b.nama,a.status_pegawai order by total desc limit 0,7");
			foreach($peg as $kw=>$vw) {
					$zzz[$vw['skpd']][$vw['status_pegawai']]+=(int)$vw['total'];
			}
			$data['tes']=$zzz;
			
			$g_status_pegawai = $this->conn->GetAll("SELECT status_pegawai as status_pegawai FROM status_pegawai");
			$g_wilayah = $this->conn->GetAll("SELECT * FROM m_wilayah where parent = 0");
			$g_peg = $this->conn->GetAll("SELECT a.propinsi as propinsi,a.status_pegawai as status_pegawai,b.nama_wilayah,count(a.status_pegawai) as total FROM sppp_data_pegawai a left join m_wilayah b on TRIM(a.propinsi)=b.kode_dagri GROUP BY a.status_pegawai,b.kode_dagri");
			foreach($g_status_pegawai as $kk=>$vv) {
				foreach($g_wilayah as $k=>$v) {
					$g_wilayah_val[$vv['status_pegawai']][$v['kode_dagri']]=0;
					$r_wilayah_each[$v['nama_wilayah']]=$v['nama_wilayah'];
				}
				$komposisi_status_pegawai[]='{label:"'.strtoupper($vv['status_pegawai']).'"}';
			}
			// pre($r_wilayah_each);exit;
			if (cek_array($g_peg)) {
				foreach($g_peg as $k=>$v) {
					$g_wilayah_val[$v['status_pegawai']][$v['propinsi']]+=(int)$v['total'];
				}
				// pre($g_wilayah_val);exit;
				$i=0;
				foreach($g_wilayah_val as $k=>$val):
					$j=0;
					foreach($val as $kk=>$vv):
						$komposisi_wilayah_val[$i][$j]=$vv;
						$j++;
					endforeach;
					$i++;
				endforeach;
				
				foreach($r_wilayah_each as $kk=>$vv):
					$komposisi_wilayah_each[]=$vv;
				endforeach;
			}
			$data["komposisi_wilayah_each"]=$komposisi_wilayah_each;
			$data["komposisi_status_pegawai"]=$komposisi_status_pegawai;
			$data["komposisi_wilayah_val"]=$komposisi_wilayah_val;

			$this->_render_page($this->module."dashboard_index",$data,true);
	}
	
	function test_bread(){
		
		$this->layout_data["bread_crumb"]=array(
			array("title"=>"Home","url"=>"/","active"=>"active","icon"=>""),
			array("title"=>"Home","url"=>"/","active"=>"active","icon"=>""),
			array("title"=>"Home","url"=>"/","active"=>"active","icon"=>""),
			array("title"=>"Home","url"=>"/","active"=>"active","icon"=>"")
		);
		
	}
	
	function init_layout($page_title="",$page_title_small="",$bread_crumb=array()){
		$this->main_layout="admin_lte_layout/main_layout";
		$this->bread_layout="admin_lte_layout/bread_crumb_template";
		
		$this->layout_data["page_title"]=$page_title!=""?$page_title:$this->module_title;
		$this->layout_data["page_title_small"]=$page_title_small!=""?$page_title_small:$this->module_title_small;
		
		$data["breadcrumb"]=cek_array($bread_crumb)?$bread_crumb:array(
			array("title"=>"Home",
				  "url"=>base_url(),
				  "active"=>"",
				  "icon"=>"<i class='icon-home blue'></i> "
				  )
		);
		$str_bread=$this->parser->parse($this->bread_layout,$data,true);
		
		$this->layout_data["breadcrumb"]=$str_bread;
	}
	
	
	
	function data_rkp_peraturan(){
			$arrData1=$this->conn->GetAll("
			select '1945-2004' as tahun_peraturan,count(*) as jumlah from tb_batas_propinsi where tahun_peraturan<2004
			union all
			select tahun_peraturan,count(*) as jumlah from tb_batas_propinsi where tahun_peraturan>=2004 group by tahun_peraturan
			");
			if(cek_array($arrData1)):
				foreach($arrData1 as $x=>$val):
					$total_propinsi[]=$val["jumlah"];
				endforeach;
			endif;
			$this->jumlah_peraturan_propinsi=cek_array($total_propinsi)?array_sum($total_propinsi):0;
			//pre(count($arrData1));
			
			$arrData2=$this->conn->GetAll("
			select '1945-2004' as tahun_peraturan,count(*) as jumlah from tb_batas_kabupaten where tahun_peraturan<2004
			union all
			select tahun_peraturan,count(*) as jumlah from tb_batas_kabupaten where tahun_peraturan>=2004 group by tahun_peraturan
			");
			if(cek_array($arrData2)):
				foreach($arrData2 as $x=>$val):
					$total_kabupaten[]=$val["jumlah"];
				endforeach;
			endif;
			$this->jumlah_peraturan_kabupaten=cek_array($total_kabupaten)?array_sum($total_kabupaten):0;
			
			$data[]=array("Tahun","Batas Propinsi","Batas Kabupaten");
			foreach($arrData1 as $x=>$val):
				//$data[]=array($val["tahun_peraturan"],(float)$val["jumlah"]);
				$data_prop[$val["tahun_peraturan"]]=(int)$val["jumlah"];
			endforeach;
			foreach($arrData2 as $x=>$val):
				$data_kab[$val["tahun_peraturan"]]=(int)$val["jumlah"];
			endforeach;
			
			for($i=date('Y');$i>=2004;$i--):
				$data_kabx=isset($data_kab[$i])?$data_kab[$i]:0;
				$data_propx=isset($data_prop[$i])?$data_prop[$i]:0;
				$data[]=array($i,$data_propx,$data_kabx);
			endfor;
			$data_kabx=isset($data_kab["1945-2004"])?$data_kab["1945-2004"]:0;
			$data_propx=isset($data_prop["1945-2004"])?$data_prop["1945-2004"]:0;
				
			$data[]=array("1945-2004",$data_propx,$data_kabx);
			
			return $data;
			
	}
	
	
	function data_rkp_segmen(){
		$sql_rkp="select 'propinsi' as batas_wilayah,1 as sort,
				a.tahun_peraturan as tahun,count(b.idx) as total 
				from tb_batas_propinsi a,tb_batas_propinsi_detail b
				where a.idx=b.id_parent and tahun_peraturan>=2004
				group by a.tahun_peraturan
				
				union all
				
				select 'propinsi_old' as batas_wilayah,2 as sort,
				a.tahun_peraturan as tahun,count(b.idx) as total 
				from tb_batas_propinsi a,tb_batas_propinsi_detail b
				where a.idx=b.id_parent and tahun_peraturan<2004
				
				union all
				
				select 'kab_kota' as batas_wilayah,3 as sort,
				a.tahun_peraturan as tahun,count(b.idx) as total 
				from tb_batas_kabupaten a,tb_batas_kabupaten_detail b
				where a.idx=b.id_parent and tahun_peraturan>=2004
				group by a.tahun_peraturan
				
				union all 
				
				select 'kab_kota_old' as batas_wilayah,4 as sort,
				a.tahun_peraturan as tahun,count(b.idx) as total 
				from tb_batas_kabupaten a,tb_batas_kabupaten_detail b
				where a.idx=b.id_parent and tahun_peraturan<2004
				
				";
		
		$sql_group="select sort,batas_wilayah,group_concat(tahun,':',total order by tahun asc separator ',') as data from (".$sql_rkp.") a 
					group by sort,batas_wilayah order by sort";
					
		$arrData=$this->conn->GetAll($sql_group);
		
		
		if(cek_array($arrData)):
			foreach($arrData as $x=>$val):
				$data_tmp=array();
				
				$data_tmp["batas_wilayah"]=strtoupper($val["batas_wilayah"]);
				$data_tmp_data=$this->parse_data($val["data"]);
				$data_all[$val["batas_wilayah"]]=$data_tmp_data;
				
				$arrData[$x]["data_per_tahun"]=$data_tmp_data;
				/* merge to $data_tmp */
				$data_tmp+=$data_tmp_data;
				$arrDataPivot[]=$data_tmp;
			endforeach;
		endif;
		
		//$data[]=array("Tahun","Batas Propinsi","Batas Kabupaten");
		for($i=date('Y');$i>=2004;$i--):
			$prop=cek_var($data_all["propinsi"][$i])?(int)$data_all["propinsi"][$i]:0;
			$kab=cek_var($data_all["kab_kota"][$i])?(int)$data_all["kab_kota"][$i]:0;
			$data[]=array((string)$i,$prop,$kab);	            
        endfor;
		
		
		$prop=cek_var($data_all["propinsi_old"][0])?(int)$data_all["propinsi_old"][0]:0;
		$kab=cek_var($data_all["kab_kota_old"][0])?(int)$data_all["kab_kota_old"][0]:0;
		$data[]=array("1945-2003",$prop,$kab);
		
		$this->jumlah_segmen_propinsi=array_sum($data_all["propinsi"])+array_sum($data_all["propinsi_old"]);
		$this->jumlah_segmen_kabupaten=array_sum($data_all["kab_kota"])+array_sum($data_all["kab_kota_old"]);
		
		return $data;
	}
	
	
	function data_rkp_peraturan_morris(){
			$arrData1=$this->conn->GetAll("
			select '1945-2004' as tahun_peraturan,count(*) as jumlah from tb_batas_propinsi where tahun_peraturan<=2004
			union all
			select tahun_peraturan,count(*) as jumlah from tb_batas_propinsi where tahun_peraturan>=2004 group by tahun_peraturan
			");
			
			$arrData2=$this->conn->GetAll("
			select '1945-2004' as tahun_peraturan,count(*) as jumlah from tb_batas_kabupaten where tahun_peraturan<=2004
			union all
			select tahun_peraturan,count(*) as jumlah from tb_batas_kabupaten where tahun_peraturan>=2004 group by tahun_peraturan
			");
			
			//$data[]=array("Tahun","Propinsi","Kabupaten");
			foreach($arrData1 as $x=>$val):
				//$data[]=array($val["tahun_peraturan"],(float)$val["jumlah"]);
				$data_prop[$val["tahun_peraturan"]]=(int)$val["jumlah"];
			endforeach;
			foreach($arrData2 as $x=>$val):
				$data_kab[$val["tahun_peraturan"]]=(int)$val["jumlah"];
			endforeach;
			$data_kabx=isset($data_kab["1945-2004"])?$data_kab["1945-2004"]:0;
			$data_propx=isset($data_prop["1945-2004"])?$data_prop["1945-2004"]:0;
				
			for($i=date('Y');$i>=2004;$i--):
				$data_kabx=isset($data_kab[$i])?$data_kab[$i]:0;
				$data_propx=isset($data_prop[$i])?$data_prop[$i]:0;
				$data[]=array("tahun"=>$i,"propinsi"=>$data_propx,"kabupaten"=>$data_kabx);
			endfor;
			//$data[]=array("tahun"=>"1945-2004","propinsi"=>$data_propx,"kabupaten"=>$data_kabx);
			
			return $data;
			
	}
	
	
	function parse_data($str,$delim1=",",$delim2=":"){
		$op = array();
		$pairs = explode($delim1, $str);
		foreach ($pairs as $pair) {
			list($k, $v) = array_map("urldecode", explode($delim2, $pair));
			$op[$k] = $v;
		}
		return $op;
	}

}