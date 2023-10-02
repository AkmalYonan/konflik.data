<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard_rehab extends Admin_Controller {
	function __construct(){
        parent::__construct();
        
		$class_folder=basename(dirname(__DIR__));
        $class=__CLASS__;
	    
    	$this->load->helper("lookup");
		
		$this->class=$class;
		$this->$class_folder=$class_folder;
		$this->load->helper(array('form', 'url','file'));
    	$this->load->library(array("parser","Utils"));
		
	    $this->folder=$class_folder."/";
        $this->module=$this->folder.$class."/";
		
	    $this->http_ref=base_url().$this->module;
       	$this->load->model("admin/dashboard_rehab_model");
        $this->load->model("general_model");
        $this->model=new general_model("dashboard_rehab_model");
		
		$this->main_layout="admin_lte_layout/main_layout";
		
		$this->module_title="Dashboard Rehabilitasi";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";
		$this->init_layout();
		
		$lookup_umur["U1"]	=	"umur>=11 and umur<21";
		$lookup_umur["U2"]	=	"umur>=21 and umur<31";
		$lookup_umur["U3"]	=	"umur>=31 and umur<41";
		$lookup_umur["U4"]	=	"umur>=41 and umur<51";
		$lookup_umur["U5"]	=	"umur>=51";
		
		$this->lookup_umur	=	$lookup_umur;
		
		$this->lookup_umur	=	$this->config->item("kelompok_umur");
		$this->lookup_tingkat_bnn	=	array("BNN"=>"BNN PUSAT","BNNP"=>"BNN PROPINSI","BNNK"=>"BNN KOTA/KABUPATEN");
		$this->lookup_blbb	=	$this->conn->GetAll("select kd_instansi,nama_instansi,x,y from m_instansi where jenis_instansi='bl' or jenis_instansi='bb'");

		$this->init_lookup();
	}
	
	function index(){
		$listMonth =	$this->utils->listMonth();
		$req 	= get_post();
		$tahun 	= ($req['tahun'])? $req['tahun']:date("Y");;
		
		if ($tahun==date("Y")) {
			$bulan = (!$_GET['bulan'] || $_GET['bulan']>date("m"))? date("m"):$req['bulan'];
		}
		else {
			$bulan = ($_GET['bulan'])? $_GET['bulan']:12;
		}
		
		$kd_inst=($this->user_instansi)?$this->user_instansi:$this->input->get_post('tipe_instansi');	
		$kd_org=($this->user_org)?$this->user_org:$this->input->get_post('kd_org');	
		$kd_propinsi=($this->user_prop)?$this->user_prop:substr($this->input->get_post('kd_org'),0,2);			
		$kd_kab=($this->user_kab)?$this->user_kab:substr($this->input->get_post('kd_org'),2,2);	
		//pre($kd_propinsi."-".$kd_kab);
		$kd_inst_prop = substr($kd_org,0,3);
		$kd_inst_kab = substr($kd_org,0,6);
		$kd_inst_wil = explode("-",$kd_org);
		
		$table_rehab = "t_pasien_assesment_history";
		//debug();
		$sql_bulan = ($_GET['mode']==2)?" (month(tgl_status_proses) = '".$bulan."')":" month(tgl_status_proses) >= '01' AND month(tgl_status_proses) <='".$bulan."'";
		$filter = "(".$sql_bulan." and year(tgl_status_proses)='".$tahun."') and  status_rehab='2'";
		
		$level=1;
		$substr_1=1;
		$substr_2=2;
		$kd="_propinsi";
		$data['jsmap']='00';
		if($kd_propinsi):
			$level=2;
			$substr_1=1;
			$substr_2=4;
			$kd="_wilayah";
			$data['jsmap']=substr($kd_propinsi,-2);
			//$filter .= " and substring(kd_wilayah,".$substr_1.",".$substr_2.") like '" .$kd_propinsi."%'";
			//$filter .= " and (inst_rujuk<>'BL' and inst_rujuk<>'BB')";
			$filter_trend = " where substring(kd_wilayah,".$substr_1.",".$substr_2.") like '" .$kd_propinsi."%' and (inst_rujuk<>'BL' and inst_rujuk<>'BB')";
		endif;
		
		if ($kd_inst) :
			if($kd_inst!="BNNP" && $kd_inst!="BNNK"):
				//$filter.=" and (rujuk_rehab='".$kd_org."' or rujuk_pasca='".$kd_org."' or rujuk_lanjut='".$kd_org."' or kd_bnn='".$kd_org."')";
				if ($kd_org) {
					$filter.=" and (rujuk_rehab = '".$kd_org."')";
					$this->lookup_blbb	=	$this->conn->GetAll("select kd_instansi,nama_instansi,x,y from m_instansi where (jenis_instansi='bl' or jenis_instansi='bb') and kd_instansi='".$kd_org."'");
				}
				else {
					$filter.=" and (rujuk_rehab REGEXP 'bb|bl')";
					$this->lookup_blbb	=	$this->conn->GetAll("select kd_instansi,nama_instansi,x,y from m_instansi where (jenis_instansi='bl' or jenis_instansi='bb')");
				}
				$data['jsmappath']="-normal";
			endif;	
			
			if($kd_inst=="BNNP"):	
				//$filter.=" and (rujuk_rehab like '".$kd_inst_prop."%' or rujuk_pasca like '".$kd_inst_prop."%' or rujuk_lanjut like '".$kd_inst_prop."%' or kd_bnn like '".$kd_inst_prop."%')";
				//$filter.=" and (CASE WHEN rujuk_lanjut THEN rujuk_lanjut WHEN (rujuk_pasca and rujuk_lanjut is null) THEN rujuk_pasca WHEN (rujuk_rehab and rujuk_pasca is null and rujuk_lanjut is null) THEN rujuk_rehab WHEN (rujuk_rehab is null and rujuk_pasca is null and rujuk_lanjut is null) THEN kd_bnn END) like '".$kd_inst_prop."%'";
				if ($kd_org) {
					$substr_1=1;
					$substr_2=4;
					$filter.=" and substr(kd_wilayah,".$substr_1.",".$substr_2.") like '".$kd_inst_wil[0]."%' and (rujuk_rehab REGEXP 'BNNP|BNNK|RD|KM')";	
					$data['jsmap']=$kd_inst_wil[0];
					$level=2;
				}
				else {
					$substr_1=1;
					$substr_2=2;
					//$filter.=" and ((inst_rujuk<>'BL' and inst_rujuk<>'BB') or (inst_pasca<>'BL' and inst_pasca<>'BB') or (inst_lanjut<>'BL' and inst_lanjut<>'BB') or (inst_rujuk is null and inst_pasca is null and inst_lanjut is null))";	
					//$filter.=" and ((inst_rujuk IN ('BNNP','BNNK','RD')) or (inst_pasca IN ('BNNP','BNNK','RD')) or (inst_lanjut IN ('BNNP','BNNK','RD')) or (inst_rujuk is null and inst_pasca is null and inst_lanjut is null))";	

					$filter.=" and (rujuk_rehab REGEXP 'BNNP|BNNK|RD|KM')";	
					$data['jsmap']='00';
					$level=1;
				}
			endif;
			if($kd_inst=="BNNK"):	
				//$filter.=" and (rujuk_rehab like '".$kd_inst_kab."%' or rujuk_pasca like '".$kd_inst_kab."%' or rujuk_lanjut like '".$kd_inst_kab."%' or kd_bnn like '".$kd_inst_kab."%')";
				//$filter.=" and (CASE WHEN rujuk_lanjut THEN rujuk_lanjut WHEN (rujuk_pasca and rujuk_lanjut is null) THEN rujuk_pasca WHEN (rujuk_rehab and rujuk_pasca is null and rujuk_lanjut is null) THEN rujuk_rehab WHEN (rujuk_rehab is null and rujuk_pasca is null and rujuk_lanjut is null) THEN kd_bnn END) like '".$kd_inst_kab."%'";
				$substr_1=1;
				$substr_2=4;
				$filter.=" and substr(kd_wilayah,".$substr_1.",".$substr_2.") like '".$kd_inst_wil[0].$kd_inst_wil[1]."%' and (inst_rujuk<>'BL' and inst_rujuk<>'BB')";	
				$data['jsmap']=$kd_inst_wil[0];
				$data['zoom2']=$kd_inst_wil[0].$kd_inst_wil[1];
				$level=2;
			endif;
		endif;
		$data['level']=$level;
		
		$sql_pasien = "
			select 
				sum(CASE WHEN jenis_kelamin='L' THEN 1 else 0 end) as laki_laki,
				sum(CASE WHEN jenis_kelamin='P' THEN 1 else 0 end) as perempuan,
				sum(CASE WHEN status_rm='PS' THEN 1 else 0 end) as rehab_proses,
				sum(CASE WHEN status_rm='SL' THEN 1 else 0 end) as rehab_selesai,
				sum(CASE WHEN status_program='PS' THEN 1 else 0 end) as jumlah,
				sum(CASE WHEN status_program='DO' THEN 1 else 0 end) as sp_do,
				sum(CASE WHEN status_program='MD' THEN 1 else 0 end) as sp_md,

				sum(CASE WHEN status_program<>'MD' and status_proses='RIRMDT' THEN 1 else 0 end) as dt,
				sum(CASE WHEN status_program<>'MD' and status_proses='RIRMEU' THEN 1 else 0 end) as eu,
				sum(CASE WHEN status_program<>'MD' and status_proses='RIRSPP' THEN 1 else 0 end) as pt,
				sum(CASE WHEN status_program<>'MD' and status_proses='RIRSRE' THEN 1 else 0 end) as re,
				
				sum(CASE WHEN status_program<>'MD' and status_proses='RJKL' THEN 1 else 0 end) as kl,
				sum(CASE WHEN status_program<>'MD' and status_proses='RJTK' THEN 1 else 0 end) as tk,
				sum(CASE WHEN status_program<>'MD' and status_proses='RJTS' THEN 1 else 0 end) as ts,
				sum(CASE WHEN active_pasien=0 and outcome_pasien='PP' THEN 1 else 0 end) as pulih_produktif,
				sum(CASE WHEN active_pasien=0 and outcome_pasien='PTP' THEN 1 else 0 end) as pulih_tidak_produktif,
				sum(CASE WHEN active_pasien=0 and outcome_pasien='TPP' THEN 1 else 0 end) as tidak_pulih_produktif,
				sum(CASE WHEN active_pasien=0 and outcome_pasien='TPTP' THEN 1 else 0 end) as tidak_pulih_tidak_produktif,
				count(idx) as jumlah 
			   from ".$table_rehab." where ".$filter;
		$data_pasien = $this->conn->GetRow($sql_pasien);
		$data = array_merge($data,$data_pasien);
		//pre($data_pasien);
		$as_kd = "substring(kd_wilayah,".$substr_1.",".$substr_2.") as kd,substring(kd_wilayah,1,4) as kd2";
		
		//wil untuk rehab
		$sql_wil_r = "select a.* from (select ".$as_kd.",count(idx) as jumlah from ".$table_rehab." where ".$filter." and (status_rehab='2' and inst_rujuk IN ('BNNP','BNNK','RD')) group by kd,kd2) a order by jumlah desc";
		$arrWilx=$this->conn->GetAll($sql_wil_r);
		
		//debug(false);

		if(cek_array($arrWilx)):
			foreach($arrWilx as $x=>$val):
				$data_jml_wil["id"][$val["kd"]]+=$val["jumlah"]*1;
				$top_5_wil[$val["kd"]]['jumlah']+=$val["jumlah"]*1;
				$top_5_wil[$val["kd"]]['kd']=$val["kd"];
			endforeach;
		endif;
		
		arsort($top_5_wil);
		$data["top5_wil"]=$top_5_wil;//array_slice($arrWil, 0, 5);

		if(!$kd_inst or ($kd_inst!="BNNP" && $kd_inst!="BNNK")):
			$sql_wil2 = "select a.kd,a.*,b.nama_instansi as nama,b.x,b.y from (select (CASE WHEN status_rehab='1' THEN kd_bnn WHEN status_rehab='2' THEN rujuk_rehab WHEN (status_rehab='3' and outcome_pasien is null) THEN rujuk_pasca else rujuk_lanjut end) as kd,count(idx) as jumlah from ".$table_rehab." where ".$filter." group by kd) a left join m_instansi b on a.kd=b.kd_instansi where (kd like '%bb-%' or kd like '%bl-%') order by jumlah desc";
			$arrWil2=$this->conn->GetAssoc($sql_wil2);
			if (cek_array($this->lookup_blbb)) {
				foreach($this->lookup_blbb as $x=>$val) {
					$data_jml_wil["blbb"]["codes"][]=$val['kd_instansi'];
					$data_jml_wil["blbb"]["names"][]=$val["nama_instansi"];
					$data_jml_wil["blbb"]["coords"][$x][]=(float)$val["y"];
					$data_jml_wil["blbb"]["coords"][$x][]=(float)$val["x"];
					$data_jml_wil["blbb"]["value"][]=(int)$arrWil2[$val['kd_instansi']]['jumlah'];
				}
			}
			$data["top5_bl"]=$arrWil2;
		endif;
		$data["jml_wil"]=$data_jml_wil;
		
		//TREN 5 TAHUN TERAKHIR
		$arrTrend=$this->conn->GetAll("select year(tgl_mulai_rehab) as tahun,count(idx) as jumlah from ".$table_rehab.$filter_trend." group by year(tgl_mulai_rehab)");
		if(cek_array($arrTrend)):
			foreach($arrTrend as $x=>$val):
				$data_jml_tahun[$val["tahun"]]=(int)$val["jumlah"];
			endforeach;
		endif;
		$i=0;
		for($thn=$tahun-4;$thn<=$tahun;$thn++) {
			$arr_t[$i][]=date("Y-m-d",strtotime($thn."-1-1"));
			$arr_t[$i][]=(int)$data_jml_tahun[$thn];
			$i++;	
		}
		$data["pasien_per_tahun"] = $arr_t;
		
		//TOTAL PER BULAN
		$arrJml=$this->conn->GetAll("select jenis_kelamin,month(tgl_mulai_rehab) as bulan,year(tgl_mulai_rehab) as tahun,count(idx) as jumlah from ".$table_rehab." where ".$filter." group by month(tgl_mulai_rehab),year(tgl_mulai_rehab),jenis_kelamin");
		if(cek_array($arrJml)):
			foreach($arrJml as $x=>$val):
				$data_jml_month[$val["jenis_kelamin"]][$val["bulan"]]=$val["jumlah"]*1;
				$data_jml_month['A'][$val["bulan"]]+=$val["jumlah"]*1;
			endforeach;
		endif;
		$i=0;
		foreach($listMonth as $k=>$v) {
			$diff = (float)$timeline["realisasi_".$k]-$timeline["target_".$k];
			$arr_["A"][$i]=(int)$data_jml_month["A"][$k+1];
			//$arr_["P"][$i][]=$v;
			$arr_["P"][$i]=(int)$data_jml_month["P"][$k+1];
			$total_pasien_p+=$data_jml_month["P"][$k+1];
	
			//$arr_["L"][$i][]=$v;
			$arr_["L"][$i]=(int)$data_jml_month["L"][$k+1];
			$total_pasien_l+=$data_jml_month["L"][$k+1];
			$i++;	
		}
		$data["pasien_per_bulan"] = $arr_;
		//:TOTAL PERBULAN
		
		//SUMBER PASIEN
		$arrDataSumberPasien=$this->conn->GetAll("select sumber_pasien,count(*) as jumlah from ".$table_rehab." where ".$filter." group by sumber_pasien ");
		if(cek_array($arrDataSumberPasien)):
			foreach($arrDataSumberPasien as $x=>$val):
				$dataSumberPasien[$val["sumber_pasien"]]=$val["jumlah"];
				$arrSumberPasien_val[$x]=array($val["sumber_pasien"]." (".$val["jumlah"].")",(int)$val["jumlah"]);;
			endforeach;
		endif;
		$data["arrSumberPasien_val"] = $arrSumberPasien_val;
		
		//SUMBER BIAYA
		$arrDataSumberBiaya=$this->conn->GetAll("select sumber_biaya,count(*) as jumlah from ".$table_rehab." where ".$filter." group by sumber_biaya ");
		if(cek_array($arrDataSumberBiaya)):
			foreach($arrDataSumberBiaya as $x=>$val):
				$dataSumberBiaya[$val["sumber_biaya"]]=$val["jumlah"];
				$arrSumberBiaya_val[$x]=array($val["sumber_biaya"]." (".$val["jumlah"].")",(int)$val["jumlah"]);;
			endforeach;
		endif;
		$data["arrSumberBiaya_val"] = $arrSumberBiaya_val;
		
		//PENDIDIKAN
		$arrDataPendidikan=$this->conn->GetAll("select pendidikan,count(*) as jumlah from ".$table_rehab." where ".$filter." group by pendidikan");
		if(cek_array($arrDataPendidikan)):
			$arrDataPendidikan_val=array();
			foreach($arrDataPendidikan as $x=>$val):
				$arrDataPendidikan_val[$x]=array($this->data_lookup["jenis_pendidikan"][$val['pendidikan']]." (".$val["jumlah"].")",(int)$val["jumlah"]);;
			endforeach;
		endif;
		$data["arrDataPendidikan_val"] = $arrDataPendidikan_val;
		
		//PEKERJAAN
		$arrDataPekerjaan=$this->conn->GetAll("select pekerjaan,count(*) as jumlah from ".$table_rehab." where ".$filter." group by pekerjaan");
		if(cek_array($arrDataPekerjaan)):
			$arrDataPekerjaan_val=array();
			foreach($arrDataPekerjaan as $x=>$val):
				$arrDataPekerjaan_val[$x]=array($this->data_lookup["kode_pekerjaan"][$val['pekerjaan']]." (".$val["jumlah"].")",(int)$val["jumlah"]);;
			endforeach;
		endif;
		$data["arrDataPekerjaan_val"] = $arrDataPekerjaan_val;
	
		//UMUR "umur>=11 and umur<21";
		/*foreach($this->lookup_umur as $k=>$v) {
			$param = ($v[1])?" umur>=".$v[0]." and umur<=".$v[1]:" umur>".$v[0];
			$arru[]="sum(CASE WHEN ".$param." THEN 1 else 0 end) as ".$k;
			$legend_umur[$k]=($v[1])?$v[0]." - ".$v[1]:">".$v[0];
		}*/
		foreach($this->lookup_umur as $k=>$v) {
			$param = ($v[1])?" umur>=".$v[0]." and umur<=".$v[1]:" umur>".$v[0];
			$param = (!$v[0] && $v[1])?" umur<".$v[1]:$param;
			$arru[]="sum(CASE WHEN ".$param." THEN 1 else 0 end) as ".$k;
			$legend_umur[$k]=($v[1])?$v[0]?$v[0]." - ".$v[1]:"<".$v[1]:">".$v[0];
		}
		
		$sql_umur = "select ".implode(",",$arru)." from ".$table_rehab." where ".$filter;
		$arrUmur=$this->conn->GetAll($sql_umur);
		if(cek_array($arrUmur[0])):
			$arrUmur_val=array();$i=0;
			foreach($arrUmur[0] as $x=>$val):
				$arrUmur_val[$i]=array($x." (".$val.")",(int)$val);;
				$i++;
			endforeach;
		endif;
		$data["arrDataUmur_val"] = $arrUmur_val;
		$data["arrDataUmur_legend"] = $legend_umur;
		
		
		/* data pasien berdasarakan umur */
	
		$arrUmurKelamin=$this->conn->GetAll("select jenis_kelamin,umur,count(*) as jumlah from ".$table_rehab." where ".$filter." group by umur,jenis_kelamin");
		
		//pre($arrUmurKelamin);
		if(cek_array($arrUmur)):
			foreach($arrUmur as $x=>$val):
				$data_umur_all[$val["umur"]]=$val["jumlah"]*1;
			endforeach;
		endif;
		if(cek_array($arrUmurKelamin)):
			foreach($arrUmurKelamin as $x=>$val):
				$key=$val["umur"]<45?$val["umur"]:45;
				if($val["jenis_kelamin"]=="L"):
					$data_umur_laki_laki[$key][]=$val["jumlah"]*1;
				endif;
				if($val["jenis_kelamin"]=="P"):
					$data_umur_perempuan[$key][]=$val["jumlah"]*1;
				endif;
			endforeach;
		endif;
		
		
		
		for($i=11;$i<=45;$i++):
			$data_umur_arr[$i]=$data_umur_all[$i]?$data_umur_all[$i]:0;
			$data_umur_laki_arr[$i]=cek_array($data_umur_laki_laki[$i])?array_sum($data_umur_laki_laki[$i]):0;
			$data_umur_perempuan_arr[$i]=cek_array($data_umur_perempuan[$i])?array_sum($data_umur_perempuan[$i]):0;
		endfor;
		
		$data_umur=array_values($data_umur_arr);
		$data_umur_laki=array_values($data_umur_laki_arr);
		$data_umur_perempuan=array_values($data_umur_perempuan_arr);
		
		//LOOKUP MERGE
		$lookup = $this->lookup_instansi2($this->user_instansi,$kd_propinsi,$kd_kab,$kd_org);
		$data = array_merge($data,$lookup);
		//param
		$data["kd_propinsi"] 		= $kd_propinsi;
		$data["kd_kab"] 			= $kd_kab;
		$data["kd_org"] 			= $kd_org;
		$data["tipe_instansi"] 		= $kd_inst;
		$data["selected_tahun"] 	= $tahun;
		$data["selected_bulan"] 	= $bulan;

		//pasien
		$data["data_umur"] 				= $data_umur;
		$data["data_umur_laki"] 		= $data_umur_laki;
		$data["data_umur_perempuan"] 	= $data_umur_perempuan;
		
		$data["listMonth"] = $listMonth;
		$this->_render_page($this->module."dashboard_index",$data,true);
	}
	
	function index2(){
		$listMonth =	$this->utils->listMonth();
		
		$req = get_post();
		$tahun 		= ($_GET['tahun'])? $_GET['tahun']:date("Y");
		$bulan 		= ($_GET['bulan'])? $_GET['bulan']:false;
		$tingkat 	= ($_GET['tingkat'])? $_GET['tingkat']:false;
		$kd_propinsi 	= ($_GET['kd_propinsi'])? $_GET['kd_propinsi']:false;
		
		$filter 	="";
		
		if($tahun):
			$filter .= "and periode_tahun = " .$tahun;
		endif;
		if($bulan):
			$filter .= " and periode_bulan = " .$bulan;
		endif;
		
		$level=1;
		$substr_1=1;
		$substr_2=2;
		$kd="_propinsi";
		$data['jsmap']='00';
		if($kd_propinsi):
			$level=2;
			$substr_1=1;
			$substr_2=4;
			$kd="_wilayah";
			$data['jsmap']=substr($kd_propinsi,-2);
			$filter .= " and substring(rujuk_rehab,".$substr_1.",".$substr_2.") like '" .$kd_propinsi."%'";
		endif;
		$data['level']=$level;
		
		$pasien		=$this->conn->GetOne("select count(*) as jumlah from t_pasien where status_rehab = '3' ".$filter);
		$pasien_ri	=$this->conn->GetOne("select count(*) as jumlah from t_pasien where status_rehab = '3' and LEFT(status_proses,2) = 'RI' ".$filter);
		$pasien_rj=$this->conn->GetOne("select count(*) as jumlah from t_pasien where status_rehab = '3' and LEFT(status_proses,2) = 'RJ' ".$filter);
		$pasien_psc=$this->conn->GetOne("select count(*) as jumlah from t_pasien where status_rehab = '3' ".$filter);
		
		//TOTAL PER WILAYAH
		//$arrWil=$this->conn->GetAll("select kd_propinsi,count(idx) as jumlah from t_pasien where periode_bulan is not null and status_rehab = '2' ".$filter." group by kd_propinsi");
		//debug();
		//$sql_wil = "select a.*,b.nama,b.x,b.y from (select kd_propinsi,count(idx) as jumlah from t_pasien where periode_bulan is not null and status_rehab = '2' ".$filter." group by kd_propinsi) a left join m_org b on a.kd_propinsi=b.kd_propinsi where b.level='1'";
		$sql_wil = "select a.*,b.nama,b.x,b.y from (select substring(rujuk_rehab,".$substr_1.",".$substr_2.") as kd,count(idx) as jumlah from t_pasien where periode_bulan is not null and status_rehab='3' ".$filter." group by substring(rujuk_rehab,".$substr_1.",".$substr_2.")) a left join m_org b on a.kd=b.kd".$kd." where b.level='".$level."' order by jumlah desc";
		$arrWil=$this->conn->GetAll($sql_wil);
		if(cek_array($arrWil)):
			foreach($arrWil as $x=>$val):
				$data_jml_wil["id"][$val["kd"]]=$val["jumlah"]*1;
				$data_jml_wil["bnnp"]["codes"][]=$val["kd"];
				$data_jml_wil["bnnp"]["names"][]=$val["nama"];
				$data_jml_wil["bnnp"]["coords"][$x][]=(float)$val["y"];
				$data_jml_wil["bnnp"]["coords"][$x][]=(float)$val["x"];
				$data_jml_wil["bnnp"]["value"][]=$val["jumlah"]*1;
			endforeach;
		endif;
		$data["top5_wil"]=array_slice($arrWil, 0, 5);
		$data["jml_wil"]=json_encode($data_jml_wil,true);
		
		//TOTAL PER BULAN
		$arrJml=$this->conn->GetAll("select jenis_kelamin,periode_bulan as bulan,periode_tahun as tahun,count(idx) as jumlah from t_pasien where periode_bulan is not null and status_rehab = '3' ".$filter." group by periode_bulan,periode_tahun,jenis_kelamin");
		if(cek_array($arrJml)):
			foreach($arrJml as $x=>$val):
				$data_jml_month[$val["jenis_kelamin"]][$val["bulan"]]=$val["jumlah"]*1;
			endforeach;
		endif;
		$i=0;
		foreach($listMonth as $k=>$v) {
			$diff = (float)$timeline["realisasi_".$k]-$timeline["target_".$k];
			//$arr_["P"][$i][]=$v;
			$arr_["P"][$i]=$data_jml_month["P"][$k+1];
			$total_pasien_p+=$data_jml_month["P"][$k+1];
	
			//$arr_["L"][$i][]=$v;
			$arr_["L"][$i]=$data_jml_month["L"][$k+1];
			$total_pasien_l+=$data_jml_month["L"][$k+1];
			$i++;	
		}
		//:TOTAL PERBULAN
		
		$arrDataJenisKelamin=$this->conn->GetAll("select jenis_kelamin,count(*) as jumlah from t_pasien where status_rehab = '3' ".$filter." group by jenis_kelamin ");
		$arrDataSumberPasien=$this->conn->GetAll("select sumber_pasien,count(*) as jumlah from t_pasien where status_rehab = '3' ".$filter." group by sumber_pasien ");
		
		if(cek_array($arrDataSumberPasien)):
			foreach($arrDataSumberPasien as $x=>$val):
				$dataSumberPasien[$val["sumber_pasien"]]=$val["jumlah"];
			endforeach;
		endif;
		
		$arrDataSumberBiaya=$this->conn->GetAll("select sumber_biaya,count(*) as jumlah from t_pasien where status_rehab = '3'   ".$filter." group by sumber_biaya ");
		if(cek_array($arrDataSumberBiaya)):
			foreach($arrDataSumberBiaya as $x=>$val):
				$dataSumberBiaya[$val["sumber_biaya"]]=$val["jumlah"];
			endforeach;
		endif;
		
		if(cek_array($arrDataJenisKelamin)):
		$dataJenisKelamin=array();
		foreach($arrDataJenisKelamin as $x=>$val):
				$dataJenisKelamin[$val["jenis_kelamin"]]=$val["jumlah"];
				//pre($val["jenis_kelamin"]);
			endforeach;
		endif;
		
		$arrDataPendidikan=$this->conn->GetAll("select pendidikan,count(*) as jumlah from t_pasien where status_rehab = '3 '".$filter." group by pendidikan");
		
		$TotPendidikan=$this->conn->GetOne("select count(*) as jumlah from t_pasien where status_rehab = '3'".$filter."");
		
		if(cek_array($arrDataPendidikan)):
			$arrDataPendidikan_val=array();
			foreach($arrDataPendidikan as $x=>$val):
				$arrDataPendidikan_val[$x]=array($this->data_lookup["jenis_pendidikan"][$val['pendidikan']]." (".$val["jumlah"].")",(int)$val["jumlah"]);;
			endforeach;
		endif;
		
		$arrDataPekerjaan=$this->conn->GetAll("select pekerjaan,count(*) as jumlah from t_pasien where status_rehab = '3' ".$filter." group by pekerjaan");
		$TotPekerjaan=$this->conn->GetOne("select count(*) as jumlah from t_pasien where status_rehab = '3' ".$filter."");
		if(cek_array($arrDataPekerjaan)):
			$arrDataPekerjaan_val=array();
			foreach($arrDataPekerjaan as $x=>$val):
				$arrDataPekerjaan_val[$x]=array($this->data_lookup["kode_pekerjaan"][$val['pekerjaan']]." (".$val["jumlah"].")",(int)$val["jumlah"]);;
			endforeach;
		endif;
	
		
		$arrUmur=$this->conn->GetAll("select umur,count(*) as jumlah from t_pasien where status_rehab='3' ".$filter." group by umur");
	
		$TotUmur=$this->conn->GetOne("select count(*) as jumlah from t_pasien where status_rehab='3' ".$filter." ");
		
		$y=0;
		foreach($this->lookup_umur as $k=>$val){
				$arrDataUmurx[$y] = array($k." (".$this->dashboard_rehab_model->GetUmur($val,$filter).")",(int)$this->dashboard_rehab_model->GetUmur($val,$filter));
				$y++;
		};
		
		//belum 
		$dataPersenJenisKelamin["L"]=$dataJenisKelamin["L"]*100/($dataJenisKelamin["L"]+$dataJenisKelamin["P"]);
		$dataPersenJenisKelamin["P"]=$dataJenisKelamin["P"]*100/($dataJenisKelamin["L"]+$dataJenisKelamin["P"]);
		
		
		$arrStatusRehab=$this->conn->GetAll("select status_rehab,periode_bulan,count(*) as jumlah from t_pasien where 1=1 ".$filter." group by status_rehab,periode_bulan ");
		
		if(cek_array($arrStatusRehab)):
			foreach($arrStatusRehab as $x=>$val):
				if($val["status_rehab"]=="2"):
					$status_rehab_arr[$val["periode_bulan"]][]=$val["jumlah"]*1;
				endif;
				if(($val["status_rehab"]=="1") || ($val["status_rehab"]=="3")):
					$status_pasca_arr[$val["periode_bulan"]][]=$val["jumlah"]*1;
				endif;
			endforeach;
		endif;
		
		for($i=1;$i<=12;$i++):
			$data_status_rehab_arr[$i]=cek_array($status_rehab_arr[$i])?array_sum($status_rehab_arr[$i]):0;
			$data_status_pasca_arr[$i]=cek_array($status_pasca_arr[$i])?array_sum($status_pasca_arr[$i]):0;
		endfor;
		
		$imp_rehab = implode(",",$data_status_rehab_arr); 
		$imp_pasca = implode(",",$data_status_pasca_arr); 
		
		/* data pasien berdasarakan umur */
	
	$arrUmurKelamin=$this->conn->GetAll("select jenis_kelamin,umur,count(*) as jumlah from t_pasien where status_rehab='3'".$filter." group by umur,jenis_kelamin");
	
	//pre($arrUmurKelamin);
	if(cek_array($arrUmur)):
		foreach($arrUmur as $x=>$val):
			$data_umur_all[$val["umur"]]=$val["jumlah"]*1;
		endforeach;
	endif;
	if(cek_array($arrUmurKelamin)):
		foreach($arrUmurKelamin as $x=>$val):
			if($val["jenis_kelamin"]=="L"):
				$data_umur_laki_laki[$val["umur"]][]=$val["jumlah"]*1;
			endif;
			if($val["jenis_kelamin"]=="P"):
				$data_umur_perempuan[$val["umur"]][]=$val["jumlah"]*1;
			endif;
		endforeach;
	endif;
	
	
	
	for($i=11;$i<=70;$i++):
		$data_umur_arr[$i]=$data_umur_all[$i]?$data_umur_all[$i]:0;
		$data_umur_laki_arr[$i]=cek_array($data_umur_laki_laki[$i])?array_sum($data_umur_laki_laki[$i]):0;
		$data_umur_perempuan_arr[$i]=cek_array($data_umur_perempuan[$i])?array_sum($data_umur_perempuan[$i]):0;
	endfor;
	
	$data_umur=array_values($data_umur_arr);
	$data_umur_laki=array_values($data_umur_laki_arr);
	$data_umur_perempuan=array_values($data_umur_perempuan_arr);
		
		//param
		$data["selected_tahun"] 	= $tahun;
		$data["selected_bulan"] 	= $bulan;

		//pasien
		$data["pasien_per_bulan"] 			= $arr_;
		$data["pasien"] 			= $pasien;
		$data["pasien_ri"] 			= $pasien_ri;
		$data["pasien_rj"] 			= $pasien_rj;
		$data["pasien_psc"] 		= $pasien_psc;
		$data["dataSumberPasien"] 	= $dataSumberPasien;
		$data["dataSumberBiaya"] 	= $dataSumberBiaya;
		$data["dataJenisKelamin"] 	= $dataJenisKelamin;
		$data["arrDataPendidikan_val"] 	= $arrDataPendidikan_val;
		$data["arrDataPekerjaan_val"] 	= $arrDataPekerjaan_val;
		
		$data["status_rehab_arr"] 	= $status_rehab_arr;
		$data["status_pasca_arr"] 	= $status_pasca_arr;
		
		$data["imp_rehab"] 	= $imp_rehab;
		$data["imp_pasca"] 	= $imp_pasca;
		
		$data["arrDataUmurx"] = json_encode($arrDataUmurx);
		
		$data["data_umur"] 				= $data_umur;
		$data["data_umur_laki"] 		= $data_umur_laki;
		$data["data_umur_perempuan"] 	= $data_umur_perempuan;
		
		$data["TotUmur"] 	= $TotUmur;
		$data["TotPendidikan"] 	= $TotPendidikan;
		$data["TotPekerjaan"] 	= $TotPekerjaan;
		$data["listMonth"] = $listMonth;
		$this->_render_page($this->module."dashboard_index2",$data,true);
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
	
	 function init_lookup(){
		$this->model_lookup					=	new general_model("m_lookup");
		$lookup_arr							=	$this->model_lookup->SearchRecordWhere("active=1","order by lookup_category,order_num");

		if(cek_array($lookup_arr)):
			foreach($lookup_arr as $x=>$val):
				$data_lookup[$val["lookup_category"]][$val["kd_lookup"]]=$val["ur_lookup"];
			endforeach;
		endif;
		$this->data_lookup					=	$data_lookup;
	 }	

}