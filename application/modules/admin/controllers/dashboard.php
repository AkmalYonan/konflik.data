<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends Admin_Controller {
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
		//sementara
    $this->load->model("admin/dashboard_rehab_model");
    $this->load->model("general_model");
    $this->model=new general_model("dashboard_rehab_model");

		$this->main_layout="admin_lte_layout/main_layout";

		$this->module_title="Dashboard Konflik";
		$this->tbl_idx="idx";
		$this->tbl_sort="idx desc";
		$this->init_layout();

		$empty[""]="Semua";
		$this->init_lookup();
		$this->base_url=GetServerURL().base_url();
	}

	function index($print=false){

		$listMonth =	$this->utils->listMonth();
		$req 	= get_post();

		//Mode bulan=> 1: s/d bulan, 0 : pada bulan
		$mmode 	= ($req['mmode'])? $req['mmode']:(!isset($req['mmode'])?1:false);

		//$tahun 	= ($req['tahun'])? $req['tahun']:(isset($req['tahun'])?0:date("Y"));
		$tahun 	= ($req['tahun'])? $req['tahun']:date("Y");
		$tahun_awal = 1988;
		$tahun_akhir=($req['tahun'])? $req['tahun']:date("Y");
		$bulan=$req["bulan"]?$req["bulan"]:12;
		$tipe=$req["tipe"]?$req["tipe"]:1;
		if($tipe==1):
			$mmode=1;
		endif;
		
		$strBulan=ucwords(GetBulan($bulan));
		$filter=" 1=1";
		
		/*
		if ($tahun==date("Y")) {
			//$bulan = (!$_GET['bulan'])? date("m"):$req['bulan'];
			$tahun_data="Tahun ".$tahun;
		}
		if($tahun<date("Y")) {
			$bulan = ($_GET['bulan'])? $_GET['bulan']:"";
			if($mmode==1):
				if(!$req["bulan"]):
					$tahun_data="Tahun ".$tahun;
				else:
					$tahun_data="Tahun ".$tahun." s/d Bulan ".$strBulan;	
				endif;
			else:
				$tahun_data="Per Bulan ".$strBulan." Tahun ".$tahun;	
			endif;
			
		}
		*/


		if($bulan):
			$filter  .= " and month(tgl_kejadian) ".(($mmode)?"<=":"=")."'".$bulan."'";
		endif;
		
		if($tahun):
		if($tipe==1):
			$filter.=" and year(tgl_kejadian)<=".$tahun;
			$tahun_data="Tahun ".$tahun_awal." - ".$tahun_akhir;	
		else:
			$filter.=" and year(tgl_kejadian)=".$tahun;
			$tahun_data="Tahun ".$tahun_akhir;	
			if($mmode==1):
				$tahun_data="Tahun ".$tahun." s/d Bulan ".$strBulan;
			else:
				$tahun_data="Bulan ".$strBulan." Tahun ".$tahun;
			endif;
		endif;
		endif;
		
		$data["tahun_data"]=$tahun_data;
		
		if (!$tahun) $bulan=false;
		//AddNew
		$maintable = "t_daftar_jkpp";
		/*if($bulan):
			$filter  = "month(tgl_kejadian) ".(($mmode)?"<=":"=")."'".$bulan."' and year(tgl_kejadian)='".$tahun."'";
			//$filter  = "month(created) = '".$bulan."' and year(created)='".$tahun."'";
		else:
			$filter  = " 1=1";
		endif;*/
		
		$and		=	" and ";
		
		if($this->user_prop):
			if($this->user_kab):
				$filter	.=	$and." kd_propinsi='".$this->user_prop."' and kd_kabupaten='".$this->user_prop.$this->user_kab."' "; //Jika Admin Adalah Admin/User Tingkat Kabupaten
			else:
				$filter	.=	$and." kd_propinsi='".$this->user_prop."' "; //Jika Admin Adalah Admin/User Tingkat Propinsi
			endif;
			//$jsmap	=	$this->user_prop;
		else:
			//$jsmap	=	"00";
		endif;
		
		
		$sektor=lookup("m_sektor","kode","uraian");

		//general
		$getNumber = "
		select
		sum(CASE WHEN jns_pulau='PU' THEN 1 else 0 end) as PU,
		sum(CASE WHEN jns_pulau='P' THEN 1 else 0 end) as P,
		sum(CASE WHEN jns_pulau='U' THEN 1 else 0 end) as U,
		sum(dampak) as jumlah_dampak,
		sum(luas) as jumlah_luas_wil,
		sum(investasi) as jumlah_investasi,
		count(idx) as jumlah_konflik from ".$maintable." where ".$filter;

		$general = $this->conn->GetRow($getNumber);
		$data["main"] = $general;


		$as_kd1 = "kd_propinsi as kd,kd_kabupaten as kd2";

		//debug();
		$level=1;
		$substr_1=1;
		$substr_2=2;
		$kd="_propinsi";
		$data['jsmap']='00';

		$sql_konflik = "
			select
			count(idx) as jumlah
			from ".$maintable." where ".$filter;

		$data_konfilk = $this->conn->GetRow($sql_konflik);
		$data = array_merge($data, $data_konfilk);


		$sql_wil_all = "select a.* from (select ".$as_kd1.","."count(idx) as jumlah from ".$maintable." where ".$filter."  group by kd,kd2) a order by jumlah desc";
		$arrWilx=$this->conn->GetAll($sql_wil_all);

		if(cek_array($arrWilx)):
			foreach($arrWilx as $x=>$val):
				$data_jml_wil["id"][$val["kd"]]+=$val["jumlah"]*1;
				$top_5_wil[$val["kd"]]['jumlah']+=$val["jumlah"]*1;
				$top_5_wil[$val["kd"]]['kd']=$val["kd"];
			endforeach;
		endif;

		arsort($top_5_wil);

		$data["top5_wil"]=$top_5_wil;

		$sql_wilsic = "SELECT a.kd, a. * , b.uraian AS nama FROM (SELECT kd_sektor AS kd,sum(luas) as tot_luas, count( idx ) AS jumlah FROM ".$maintable." WHERE ".$filter." GROUP BY kd )a LEFT JOIN m_sektor b ON a.kd = b.kode ORDER BY jumlah DESC";
		$arrWil2=$this->conn->GetAssoc($sql_wilsic);

		$lookup_sektor = $this->conn->GetAll("select * from m_sektor");
			if (cek_array($lookup_sektor)) {
				foreach($lookup_sektor as $x=>$val) {
					$data_jml_wil["blbb"]["codes"][]=$val['kode'];
					$data_jml_wil["blbb"]["names"][]=$val["uraian"];
					$data_jml_wil["blbb"]["value"][]=(int)$arrWil2[$val['kode']]['jumlah'];
				}
			}
		$data["top5_bl"]=$arrWil2;
		$data["jml_wil"]=$data_jml_wil;

		$trend_tahun = (!$tahun)?date("Y"):$tahun;
		$arrTrend=$this->conn->GetAll("select year(tgl_kejadian) as tahun,count(idx) as jumlah from ".$maintable." where year(tgl_kejadian)<='".$trend_tahun."' group by year(tgl_kejadian) order by year(tgl_kejadian) ");
		//pre($arrTrend);
		//exit();
		if(cek_array($arrTrend)):
			$tmp_jml=0;
			foreach($arrTrend as $x=>$val):
				$tmp_jml=(int)$val["jumlah"];
				$data_jml_tahunx[$val["tahun"]]=$tmp_jml;
			endforeach;
			//pre($data_jml_tahunx);
			$tmp=array();
			for($thn=$trend_tahun-5;$thn<=$trend_tahun;$thn++):
				$data_tmp[]=$data_jml_tahunx[$thn];
				$tmp=array_sum($data_tmp);
				$data_jml_tahun[$thn]=$tmp;
			endfor;
		endif;

		$i=0;
		for($thn=$trend_tahun-5;$thn<=$trend_tahun;$thn++) {
			$arr_t[$i][]=date("Y-m-d",strtotime($thn."-1-1"));
			$arr_t[$i][]=(int)$data_jml_tahun[$thn];

			$arr_t2[$i][]=date("Y ",strtotime($thn."-1-1"));
			$arr_t2[$i][]=(int)$data_jml_tahun[$thn];
			$i++;
		}
		$data["pasien_per_tahun"] = $arr_t;
		$data["pasien_per_tahun2"] = $arr_t2;

		//TOTAL PER 
		if ($tipe==1):
			$arrJml2=$this->conn->GetAll("select status_konflik,year(tgl_kejadian) as tahun,count(idx) as jumlah from ".$maintable." where ".$filter." group by year(tgl_kejadian),status_konflik");			
			
			if(cek_array($arrJml2)):
				foreach($arrJml2 as $x=>$val):
					$data_jml_tahun[$val["status_konflik"]][$val["tahun"]]=$val["jumlah"]*1;
					$data_jml_tahun['A'][$val["tahun"]]+=$val["jumlah"]*1;
				endforeach;
			endif;
			
			$i=0;
			for($t=$tahun-10;$t<=$tahun;$t++){
				$arr_y[]=(string)$t;
				$arr_["A"][$i]=(int)$data_jml_tahun["A"][$t];
	
				$arr_["BD"][$i]=(int)$data_jml_tahun["BD"][$t];
				$total_jns_tanahpu+=$data_jml_tahun["BD"][$t];
	
				$arr_["PS"][$i]=(int)$data_jml_tahun["PS"][$t];
				$total_jns_tanahp+=$data_jml_tahun["PS"][$t];
	
				$arr_["SL"][$i]=(int)$data_jml_tahun["SL"][$t];
				$total_jns_tanahu+=$data_jml_tahun["SL"][$t];
				$i++;
			}
			$ticks_ = json_encode($arr_y);
			$title_ = 'PER TAHUN TERAKHIR';
		else://tipe=2
			$listMonthAbbr=array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
			if ($mmode)://s/d bulan
				$arrJml2=$this->conn->GetAll("select status_konflik,month(tgl_kejadian) as bulan,year(tgl_kejadian) as tahun,count(idx) as jumlah from ".$maintable." where ".$filter." group by month(tgl_kejadian),year(tgl_kejadian),status_konflik");
			
				if(cek_array($arrJml2)):
					foreach($arrJml2 as $x=>$val):
						$data_jml_month[$val["status_konflik"]][$val["bulan"]]=$val["jumlah"]*1;
						$data_jml_month['A'][$val["bulan"]]+=$val["jumlah"]*1;
					endforeach;
				endif;
				
				$i=0;
				for($m=0;$m<$bulan;$m++){
					$arr_y[]=$listMonthAbbr[$i];
					$arr_["A"][$i]=(int)$data_jml_month["A"][$m];
		
					$arr_["BD"][$i]=(int)$data_jml_month["BD"][$m];
					$total_jns_tanahpu+=$data_jml_month["BD"][$m];
		
					$arr_["PS"][$i]=(int)$data_jml_month["PS"][$m];
					$total_jns_tanahp+=$data_jml_month["PS"][$m];
		
					$arr_["SL"][$i]=(int)$data_jml_month["SL"][$m];
					$total_jns_tanahu+=$data_jml_month["SL"][$m];
					$i++;
				}
				
				
				$ticks_ = json_encode($arr_y);
				$title_ = 'TAHUN '.$tahun.' S/D BULAN '.$listMonth[$bulan-1];
			else://pada bulan
				$arrJml2=$this->conn->GetAll("select status_konflik,day(tgl_kejadian) day,month(tgl_kejadian) as bulan,year(tgl_kejadian) as tahun,count(idx) as jumlah from ".$maintable." where ".$filter." group by day(tgl_kejadian),month(tgl_kejadian),year(tgl_kejadian),status_konflik");
				if(cek_array($arrJml2)):
					foreach($arrJml2 as $x=>$val):
						$data_jml_day[$val["status_konflik"]][$val["day"]]=$val["jumlah"]*1;
						$data_jml_day['A'][$val["day"]]+=$val["jumlah"]*1;
					endforeach;
				endif;
				
				$i=0;
				$last_day_of_month=date("t",strtotime($tahun."-".$bulan."-15"));
				for($d=1;$d<$last_day_of_month;$d++){
					$arr_y[]=(string)$i+1;
					$arr_["A"][$i]=(int)$data_jml_day["A"][$d];
		
					$arr_["BD"][$i]=(int)$data_jml_day["BD"][$d];
					$total_jns_tanahpu+=$data_jml_day["BD"][$d];
		
					$arr_["PS"][$i]=(int)$data_jml_day["PS"][$d];
					$total_jns_tanahp+=$data_jml_day["PS"][$d];
		
					$arr_["SL"][$i]=(int)$data_jml_day["SL"][$d];
					$total_jns_tanahu+=$data_jml_day["SL"][$d];
					$i++;
				}
				$ticks_ = json_encode($arr_y);
				$title_ = 'PERHARI BULAN '.$listMonth[$bulan-1]." ".$tahun;
			endif;
		endif;
		
		//:TOTAL PERBULAN
		$data["pasien_per_bulan"] = $arr_;
		$data["time_tick"] = $ticks_;
		$data["time_title"] = $title_;
		/* data pasien berdasarakan jenis Pulau */
		$arrJenisPulau=$this->conn->GetAll("select jns_pulau,kd_sektor,count(*) as jumlah from ".$maintable." where ".$filter." group by kd_sektor,jns_pulau");

		if(cek_array($arrJenisPulau)):
			foreach($arrJenisPulau as $x=>$val):
				$key=$val["kd_sektor"];
				if($val["jns_pulau"]=="PU"):
					$data_pu[$key][]=$val["jumlah"]*1;
				endif;
				if($val["jns_pulau"]=="P"):
					$data_p[$key][]=$val["jumlah"]*1;
				endif;
				if($val["jns_pulau"]=="U"):
					$data_u[$key][]=$val["jumlah"]*1;
				endif;
			endforeach;
		endif;


		$sekt[S1] = "Airport";
		$sekt[S2] = "Pendidikan";
		$sekt[S3] = "Kesehatan";
		$sekt[S4] = "Manufacture";
		$sekt[PP] = "Power Plant";
		$sekt[PA] = "Wilayah Lindung";
		$sekt[TE] = "Tambang Emas";
		$sekt[TB] = "Tambang Besi";
		$sekt[PB] = "Pabrik Besi";
		$sekt[KW] = "Kawasan Wisata";

		foreach($sekt as $k=>$v){
			$data_pu_arr[$k]=cek_array($data_pu[$k])?array_sum($data_pu[$k]):0;
			$data_p_arr[$k]=cek_array($data_p[$k])?array_sum($data_p[$k]):0;
			$data_u_arr[$k]=cek_array($data_u[$k])?array_sum($data_u[$k]):0;
		}

		$data_pu=array_values($data_pu_arr);
		$data_p=array_values($data_p_arr);
		$data_u=array_values($data_u_arr);

		//LOOKUP MERGE
		$lookup = $this->lookup_instansi2($this->user_instansi,$kd_propinsi,$kd_kab,$kd_org);
		$data = array_merge($data,$lookup);

		//param
		$data["kd_propinsi"] 			= $kd_propinsi;
		$data["kd_kab"] 					= $kd_kab;
		$data["kd_org"] 					= $kd_org;
		$data["tipe_instansi"] 		= $kd_inst;
		$data["selected_tahun"] 	= $tahun;
		$data["selected_bulan"] 	= $bulan;
		$data['level']						= $level;

		$data["data_pu"] 			= $data_pu;
		$data["data_p"] 			= $data_p;
		$data["data_u"] 			= $data_u;
		$data["sektor"]				= $sektor;
		$data["mmode"]				= $mmode;
		//$data["jsmap"]				=	$jsmap;

		$top5_bydate  = $this->conn->GetAll("select idx, judul, kd_sektor, luas, investasi, dampak, tgl_kejadian from t_daftar_jkpp where ".$filter." order by tgl_kejadian desc limit 5");
		$data["top5_bydate"] = $top5_bydate;


		$data["listMonth"] = $listMonth;
		
		if($filter):
			$status_filter	=	" where ".$filter;
		else:
			$status_filter	=	"";
		endif;
		
		$arrStatuskonflik=$this->conn->GetAll("select status_konflik,count(*) as jumlah from t_daftar_jkpp ".$status_filter." group by status_konflik");
		
		if(cek_array($arrStatuskonflik)):
			$dataStatusKonflik=array();
			foreach($arrStatuskonflik as $x=>$val):
				$dataStatusKonflik[$val["status_konflik"]]=$val["jumlah"];
				//pre($val["jenis_kelamin"]);
			endforeach;
		endif;
		
		$dataPersenStatusKonflik["BD"]=$dataStatusKonflik["BD"]*100/($dataStatusKonflik["BD"]+$dataStatusKonflik["PS"]+$dataStatusKonflik["SL"]);
		$dataPersenStatusKonflik["PS"]=$dataStatusKonflik["PS"]*100/($dataStatusKonflik["BD"]+$dataStatusKonflik["PS"]+$dataStatusKonflik["SL"]);
		$dataPersenStatusKonflik["SL"]=$dataStatusKonflik["SL"]*100/($dataStatusKonflik["BD"]+$dataStatusKonflik["PS"]+$dataStatusKonflik["SL"]);
		
		$data_pie[]=array("Belum Ditangani (".number_format($dataStatusKonflik["BD"]).")",(float)$dataPersenStatusKonflik["BD"]);
		$data_pie[]=array("Proses (".number_format($dataStatusKonflik["PS"]).")",(float)$dataPersenStatusKonflik["PS"]);
		$data_pie[]=array("Selesai (".number_format($dataStatusKonflik["SL"]).")",(float)$dataPersenStatusKonflik["SL"]);
		$data['data_pie'] = json_encode($data_pie);
		
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
