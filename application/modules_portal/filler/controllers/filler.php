<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class filler  extends CI_Controller {

    function __construct(){
        parent::__construct();
        
        $this->folder="filler/";
		$this->module_name="admin";
		$this->module=$this->folder."filler/";
		$this->http_ref=base_url().$this->module;
		
		$this->load->helper(array('form', 'url','file','number','lookup'));
		$this->load->model("user/pg_model","pg_model");
		$this->load->model("user/link_manager_model","link_model");
		
		$this->load->library("user_agent");
		$this->load->library("utils");
		$this->load->library("rssparser");
	}
	
	function index(){
		
	}
	
	function brwa_kepengurusan() {
		$this->load->view("filler/filler/brwa_kepengurusan",$data);
	}
	function social_share($title=false,$pt=false) {
		$data['data_title']=$title;
		$data['page_title']=$pt;
		$this->load->view("filler/filler/social_share",$data);
	}
	function social_ftg($title=false,$pt=false) {
		$data['data_title']=$title;
		$data['page_title']=$pt;
		$this->load->view("filler/filler/social_ftg",$data);
	}
	function brwa_rss($title=0,$limit=3,$page=1){
		$filter="status=1 and (category=1015)";
		
		$arrDB = $this->adodbx->search_record_by_limit_where("cms_pages",$filter,$limit,0," order by idx desc ");
    	
		if (is_array($arrDB)) {
			$arr=array();
			foreach($arrDB as $k=>$v) {
				$arr = array_merge($arr,$this->rss_parse($v['clip'],$v['title']));
			}
			foreach($arr as $k=>$v) {
				$rss[strtotime($v['pubDate'])]=$v;
			}
		}
		krsort($rss,SORT_NUMERIC);
		$data["title"]=$title;
		$data['rss']=$rss;
		$this->load->view("filler/filler/brwa_rss",$data);
	}
	function rss_parse($url,$title=false) {
		$this->rssparser->set_feed_url($url);  // get feed
		//$this->rssparser->set_cache_life(30);                       // Set cache life time in minutes
		$rss = $this->rssparser->getFeed(3);
		if ($rss) {
			foreach($rss as $k=>$v) {
				$v['src']=$title;
				$time = strtotime(substr($v['pubDate'],4,-6));
				$arr[$time]=$v;
			}
		}
		return $arr;
	}
	function brwa_stats(){

		$sql = "SELECT count(idx) as total,(
				CASE 
					WHEN (doc_proses=1 and wa_data_status!= 99) 
					THEN 'Teregistrasi' 
					WHEN (doc_proses=2 and wa_data_status != 99) 
					THEN 'Terverifikasi' 
					WHEN (doc_proses=3 and wa_data_status!=99)
					THEN 'Tersertifikasi'
					WHEN (doc_proses=4 and wa_data_status!=99)
					THEN 'Pengakuan'  
				END
				) AS wa_status
				FROM 
					v_wa_data
				GROUP BY 
					wa_status";
		// $sql = "SELECT * FROM (SELECT count(idx) as total,(
				// CASE 
					// WHEN (doc_proses=1 and doc_status=4 and wa_data_status!= 99) 
					// THEN 'Teregistrasi' 
					// WHEN (doc_proses=2 and doc_status=5 and wa_data_status != 99) 
					// THEN 'Terverifikasi' 
					// WHEN (doc_proses=3 and doc_status=2 and wa_data_status!=99)
					// THEN 'Tersertifikasi' 
					
				// END
				// ) AS wa_status
				// FROM 
					// v_wa_data
				// GROUP BY 
					// doc_proses,doc_status,wa_data_status) stats GROUP BY wa_status";
		$arrData = $this->conn->GetAll($sql);
		
		
		// pre($arrData);exit;
		if (cek_array($arrData)) {
			
			foreach($arrData as $k=>$v) {
				$stats[]='["'.$v['wa_status'].'",'.$v['total']."]";
			}
			
			if (cek_array($stats)) $data['wa_stats']=implode(",",$stats);
			
			$this->load->view("filler/filler/brwa_stats",$data);
		} 
	
		
		
	}
	
	function brwa_stats2(){
		$sql = "select doc_proses,doc_status from v_wa_data order by doc_proses, doc_status";
		$arrData = $this->conn->GetAll($sql);	
		if (cek_array($arrData)) {
			foreach($arrData as $k=>$v) {
				if ($v['doc_proses']==1) {
					$status_badges = '<span class="label label-warning">Teregistrasi</span>';
					if ($v['doc_status']==4) {
						$arr['Teregistrasi']+=1;
					}
					else {
						$arr['Registrasi']+=1;
					}
				}
				else if ($v['doc_proses']==2) {
					if ($v['doc_status']==4) {
						$arr['Terverifikasi']+=1;
					}
					else {
						$arr['Teregistrasi']+=1;
					}
				}
				else if ($v['doc_proses']==3) {
					if ($v['doc_status']==4) {
						$arr['Tersertifikasi']+=1;
					}
					else {
						$arr['Terverifikasi']+=1;
					}
				}
				
				//$arr[$m_jenis[$v['doc_proses']]]=$v['total'];
				//$stats[]='["'.($m_jenis[$v['doc_proses']]).'",'.$v['total']."]";
			}
			//pre ($arr);
			if (cek_array($arr)) {
				foreach($arr as $k=>$v) {
					$stats[]='["'.$k.'",'.$v."]";
				}
			}
		} 
		if (cek_array($stats)) $data['wa_stats']=implode(",",$stats);
		$this->load->view("filler/filler/brwa_stats",$data);
	}
	function brwa_wa(){
		$this->load->view("filler/filler/brwa_wa",$data);
	}
	function brwa_prosedur(){
		$this->load->view("filler/filler/brwa_prosedur",$data);
	}
	function brwa_banner(){
		$this->load->view("filler/filler/brwa_banner",$data);
	}
	
    function news_pages($title=true,$idx=false,$limit=5){
		$filter=($idx)?"idx!=".$idx." and ":"";
		$filter.="status=1 and (category=3 or category=2)";
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter = "title like '%".$key."%' or clip like '%".$key."%'";
			$data["key"]=$key;
		}
		$offset 		= ($page-1)*$limit;
		$data_start 	= $offset+1;
		$data_end 		= $offset+$limit;
		
		if ($forder) {
			$spl = preg_split("/:/",$forder);
			$order = 'order by '.$spl[0].' '.$spl[1];
			$data["forder"]=$spl[0];
			$data["dorder"]=$spl[1];
		}
		else {
			$order = 'order by idx desc';
		}
		//debug();
		//$arrDB=$this->model->SearchRecord(false,'order by id desc');
		//$arrDB=$this->pg_model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
		$arrDB = $this->adodbx->search_record_by_limit_where("cms_pages",$filter,5,0," order by idx desc ");
		if (is_array($arrDB)) {
			$img_dir = $this->config->item("dir_news_image");
			foreach($arrDB as $k=>$v) {
				$arrDB[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,5);
			}
		}
		$data["module"]=$this->module;
		$data["title"]=$title;
		$data["list"]=$arrDB;
        $this->load->view("filler/filler/other_list",$data);
   }
   
   
   function article_pages($title=true,$idx=false,$limit=5){
   
		$filter=($idx)?"idx!=".$idx." and ":"";
		$filter.="status=1 and (category=1)";
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter = "title like '%".$key."%' or clip like '%".$key."%'";
			$data["key"]=$key;
		}
		$offset 		= ($page-1)*$limit;
		$data_start 	= $offset+1;
		$data_end 		= $offset+$limit;
		
		if ($forder) {
			$spl = preg_split("/:/",$forder);
			$order = 'order by '.$spl[0].' '.$spl[1];
			$data["forder"]=$spl[0];
			$data["dorder"]=$spl[1];
		}
		else {
			$order = 'order by idx desc';
		}
		//debug();
		//$arrDB=$this->model->SearchRecord(false,'order by id desc');
		//$arrDB=$this->pg_model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
		$arrDB = $this->adodbx->search_record_by_limit_where("cms_pages",$filter,5,0," order by idx desc ");
		if (is_array($arrDB)) {
			$img_dir = $this->config->item("dir_pages_image");
			foreach($arrDB as $k=>$v) {
				$arrDB[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,5);
			}
		}
		$data["module"]=$this->module;
		$data["title"]=$title;
		$data["list"]=$arrDB;
        $this->load->view("filler/filler/article_list",$data);
   }
   
   
     
   function right_menu($idx=false,$limit=5){
        $this->load->view("filler/filler/right_menu");
   }
   function other_links($cat=9,$limit=5){
   		$filter="active=1 and publish=1";
		
   		$arrDB = $this->adodbx->search_record_by_limit_where("cms_link",$filter,5,0," order by idx ");
   		$data["footer_link_list"]=$arrDB;
        $this->load->view("filler/filler/other_links",$data);
   }
   function map($title=false,$w=false,$h=false){
   		$data["title"]=$title;
		$data["width"]=$w;
		$data["height"]=$h;
        $this->load->view("filler/filler/map",$data);
   }
   
   /* ADMIN */
   function admin_news_pages($title=true,$idx=false,$limit=5){
		$filter=($idx)?"idx!=".$idx." and ":"";
		$filter.="(category=3 or category=2)";
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter = "title like '%".$key."%' or clip like '%".$key."%'";
			$data["key"]=$key;
		}
		$offset 		= ($page-1)*$limit;
		$data_start 	= $offset+1;
		$data_end 		= $offset+$limit;
		
		if ($forder) {
			$spl = preg_split("/:/",$forder);
			$order = 'order by '.$spl[0].' '.$spl[1];
			$data["forder"]=$spl[0];
			$data["dorder"]=$spl[1];
		}
		else {
			$order = 'order by idx desc';
		}
		//debug();
		//$arrDB=$this->model->SearchRecord(false,'order by id desc');
		//$arrDB=$this->pg_model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
		$total_rows=$this->model->total_rows_where("cms_pages",$filter);
		$total_comments=$this->model->total_rows_where("cms_comments","category=4");
		$total_published=$this->model->total_rows_where("cms_pages",$filter."and status=1");
		$arrDB = $this->adodbx->search_record_by_limit_where("cms_pages",$filter,5,0," order by idx desc ");
		if (is_array($arrDB)) {
			$img_dir = $this->config->item("dir_news_image");
			foreach($arrDB as $k=>$v) {
				$arrDB[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,5);
			}
		}
		$data["module"]=$this->module;
		$data["total"]=$total_rows;
		$data["total_comments"]=$total_comments;
		$data["total_published"]=$total_published;
		$data["list"]=$arrDB;
        $this->load->view("filler/filler/admin_news_list",$data);
   }
   
   function admin_article_pages($title=true,$idx=false,$limit=5){
   
		$filter=($idx)?"idx!=".$idx." and ":"";
		$filter.="category=1";
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter = "title like '%".$key."%' or clip like '%".$key."%'";
			$data["key"]=$key;
		}
		$offset 		= ($page-1)*$limit;
		$data_start 	= $offset+1;
		$data_end 		= $offset+$limit;
		
		if ($forder) {
			$spl = preg_split("/:/",$forder);
			$order = 'order by '.$spl[0].' '.$spl[1];
			$data["forder"]=$spl[0];
			$data["dorder"]=$spl[1];
		}
		else {
			$order = 'order by idx desc';
		}
		//debug();
		//$arrDB=$this->model->SearchRecord(false,'order by id desc');
		//$arrDB=$this->pg_model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
		$total_rows=$this->model->total_rows_where("cms_pages",$filter);
		$total_comments=$this->model->total_rows_where("cms_comments","category=1");
		$total_published=$this->model->total_rows_where("cms_pages",$filter."and status=1");
		$arrDB = $this->adodbx->search_record_by_limit_where("cms_pages",$filter,5,0," order by idx desc ");
		if (is_array($arrDB)) {
			$img_dir = $this->config->item("dir_pages_image");
			foreach($arrDB as $k=>$v) {
				$arrDB[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,5);
			}
		}
		$data["module"]=$this->module;
		$data["total"]=$total_rows;
		$data["total_comments"]=$total_comments;
		$data["total_published"]=$total_published;
		$data["list"]=$arrDB;
        $this->load->view("filler/filler/admin_article_list",$data);
   }
   
   function admin_guestbook($title=true,$idx=false,$limit=15){
   		
		$filter=($idx)?"idx!=".$idx." and ":"";
		//$filter.="category=1";
		$key = ($_GET['q'])?$_GET['q']:0;
		if ($key) {
			$filter = "title like '%".$key."%' or clip like '%".$key."%'";
			$data["key"]=$key;
		}
		$offset 		= ($page-1)*$limit;
		$data_start 	= $offset+1;
		$data_end 		= $offset+$limit;
		
		if ($forder) {
			$spl = preg_split("/:/",$forder);
			$order = 'order by '.$spl[0].' '.$spl[1];
			$data["forder"]=$spl[0];
			$data["dorder"]=$spl[1];
		}
		else {
			$order = 'order by idx desc';
		}
		//debug();
		//$arrDB=$this->model->SearchRecord(false,'order by id desc');
		//$arrDB=$this->pg_model->SearchRecordLimitWhere($filter,$limit,$offset,$order);
		$arrDB = $this->adodbx->search_record_by_limit_where("cms_guest_book",$filter,$limit,0," order by idx desc ");
		if (is_array($arrDB)) {
			$img_dir = $this->config->item("dir_pages_image");
			foreach($arrDB as $k=>$v) {
				$arrDB[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,5);
			}
		}
		$data["module"]=$this->module;
		$data["title"]=$title;
		$data["list"]=$arrDB;
        $this->load->view("filler/filler/admin_gb_list",$data);
   }
   
   function admin_forums($limit=5){
   		
   }
   function admin_links($cat=9,$limit=5){
   		$filter="active=1 and publish=1";
   		$sql=" select a.*,b.category as category_name,c.click_count from cms_link a 
                left join cms_link_category b on a.category=b.idx
				left join cms_link_count c on a.idx=c.id_link";

        $table="($sql) a";
        $totalRows=count($this->adodbx->search_record_where("cms_link"));
		$total_active=count($this->adodbx->search_record_where("cms_link","active=1"));
		$total_published=count($this->adodbx->search_record_where("cms_link","publish=1"));

        $sortBy=" order by idx desc";
   		$arrDB = $this->adodbx->search_record_by_limit_where($table,$filter,$limit,0,$sortBy);
		if (is_array($arrDB)) {
			$img_dir = $this->config->item("dir_pages_image");
			foreach($arrDB as $k=>$v) {
				$arrDB[$k]['date_formatted']=$this->utils->dateToString($v['created'],0,5);
			}
		}
   		$data["list"]=$arrDB;
		$data["total"]=$totalRows;
		$data["total_published"]=$total_published;
		$data["total_active"]=$total_active;
        $this->load->view("filler/filler/admin_link_list",$data);
   }
   
   function dash_map($year=false,$theme=false){
		$req 	= get_post();

		//Mode bulan=> 1: s/d bulan, 0 : pada bulan
		$mmode 	= 1;//($req['mmode'])? $req['mmode']:(!isset($req['mmode'])?1:false);

		$tahun 	= ($req['tahun'])? $req['tahun']:(isset($req['tahun'])?0:date("Y"));
		if ($tahun==date("Y")) {
			$bulan = (!$_GET['bulan'])? date("m"):$req['bulan'];
		}
		else {
			$bulan = ($_GET['bulan'])? $_GET['bulan']:12;
		}
		
		if (!$tahun) $bulan=false;
		
		//AddNew
		$maintable = "t_daftar_jkpp";
		if($bulan):
			$filter  = "month(tgl_kejadian) ".(($mmode)?"<=":"=")."'".$bulan."' and year(tgl_kejadian)='".$tahun."'";
			//$filter  = "month(created) = '".$bulan."' and year(created)='".$tahun."'";
		else:
			$filter  = " 1=1";
		endif;
		
		//general
		$getNumber = "
		select
		sum(dampak) as dampak,
		sum(luas) as luas,
		sum(investasi) as investasi,
		count(idx) as konflik from ".$maintable." where ".$filter;

		$general = $this->conn->GetRow($getNumber);
		if (cek_array($general)) {
			foreach($general as $k=>$v) {
				$arr[$k]=curr_format((float)$v,($k=='konflik' || $k=='dampak')?0:2);
			}
		}
		$data["nilai"] = json_encode($arr);

		$as_kd1 = "kd_propinsi as kd,kd_kabupaten as kd2";
		$sql_wil_all = "select a.* from (select ".$as_kd1.","."count(idx) as jumlah from ".$maintable." where ".$filter."  group by kd,kd2) a order by jumlah desc";
		$arrWilx=$this->conn->GetAll($sql_wil_all);

		if(cek_array($arrWilx)):
			foreach($arrWilx as $x=>$val):
				//$data_jml_wil["id"][$val["kd"]]+=$val["jumlah"]*1;
				$data_jml_wil["id"]['values'][$val["kd"]]+=$val["jumlah"]*1;
				$data_jml_wil["id"]['fvalues'][$val["kd"]]=curr_format((float)$data_jml_wil["id"]['values'][$val["kd"]],0);
			endforeach;
		endif;


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
		$data_jml_wil["colors"]=array('#e6aca5', '#A50F15');
		$data["jml_wil"]=$data_jml_wil;

		$sql_wil_dampak = "select a.* from (select ".$as_kd1.","."sum(dampak) as jumlah from ".$maintable." where ".$filter."  group by kd,kd2) a order by jumlah desc";
		$data["jml_wil_dampak"]=$this->getWil($sql_wil_dampak,array('#95c1de', '#177fde'),0);
		
		$sql_wil_lahan = "select a.* from (select ".$as_kd1.","."sum(luas) as jumlah from ".$maintable." where ".$filter."  group by kd,kd2) a order by jumlah desc";
		$data["jml_wil_lahan"]=$this->getWil($sql_wil_lahan,array('#f0d096', '#f09a0a'));
		
		$sql_wil_investasi = "select a.* from (select ".$as_kd1.","."sum(investasi) as jumlah from ".$maintable." where ".$filter."  group by kd,kd2) a order by jumlah desc";
		$data["jml_wil_investasi"]=$this->getWil($sql_wil_investasi,array('#aafbc0', '#0d8142'));
		
		$arr_theme=array("konflik","dampak","luas","investasi");
		$data['jsmap']='00';
		$data["selected_theme"] 	= (!$theme)?$arr_theme[rand(0,3)]:$theme;
		$data["selected_tahun"] 	= $tahun;
		$data["selected_bulan"] 	= $bulan;
		//$this->_render_page($this->module."dashmap",$data,true);
		$this->load->view("filler/filler/dashmap",$data);
	}
	
	function trend_konflik($year=false){
		
		$maintable = "t_daftar_jkpp";
		
		//TREN 5 TAHUN TERAKHIR

		$trend_tahun = (!$tahun)?date("Y"):$tahun;
		$arrTrend=$this->conn->GetAll("select year(tgl_kejadian) as tahun,count(idx) as jumlah from ".$maintable." where year(tgl_kejadian)<='".$trend_tahun."' group by year(tgl_kejadian)");
		if(cek_array($arrTrend)):
			foreach($arrTrend as $x=>$val):
				$data_jml_tahun[$val["tahun"]]=(int)$val["jumlah"];
			endforeach;
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
		
		$this->load->view("filler/filler/trend_konflik",$data);
		
	}
	
	function list_konflik($year=false,$offset=0,$limit=5){
		
		$maintable	=	"t_daftar_jkpp";
		
		if($year):
			$filter		=	" tahun='".$year."'";
		else:
			$filter		=	" tahun='".date('Y')."'";
		endif;
		
		$total			=	$this->conn->GetOne("select count(idx) as total from t_daftar_jkpp where ".$filter);
		
		if($total>$limit):
			$offset	=	(int)rand(0,$total-$limit);
		endif;
		
		$top5_bydate  = $this->conn->GetAll("select idx, judul, kd_sektor, luas, investasi, dampak, created from t_daftar_jkpp where ".$filter." order by created desc limit ".$limit." offset ".$offset);
		
		$data["top5_bydate"] = $top5_bydate;
		
		$this->load->view("filler/filler/list_konflik",$data);
	}
	
	function konflik_terbaru($year=false,$limit=5){
		
		$maintable		=	"t_daftar_jkpp";
		
		if($year):
			$filter		=	" tahun='".$year."'";
		else:
			$filter		=	" tahun='".date('Y')."'";
		endif;
		
		$top5_bydate	= 	$this->conn->GetAll("select idx, judul, kd_sektor, luas, investasi, dampak, created from t_daftar_jkpp where ".$filter." order by tgl_kejadian desc limit ".$limit);
		
		$data["top5_bydate"]	=	$top5_bydate;
		$data["limit"]			=	$limit;
		
		$this->load->view("filler/filler/konflik_terbaru",$data);
	}
	
	function getWil($sql,$colors,$f=2)
	{
		$arrWilx=$this->conn->GetAll($sql);
		if(cek_array($arrWilx)):
			foreach($arrWilx as $x=>$val):
				$data_jml_wil["id"]['values'][$val["kd"]]+=$val["jumlah"]*1;
				$data_jml_wil["id"]['fvalues'][$val["kd"]]=curr_format((float)$data_jml_wil["id"]['values'][$val["kd"]],$f);
				$top_5_wil[$val["kd"]]['jumlah']+=$val["jumlah"]*1;
				$top_5_wil[$val["kd"]]['kd']=$val["kd"];
			endforeach;
		endif;
		$lookup_sektor = $this->conn->GetAll("select * from m_sektor");
		if (cek_array($lookup_sektor)) {
			foreach($lookup_sektor as $x=>$val) {
				$data_jml_wil["blbb"]["codes"][]=$val['kode'];
				$data_jml_wil["blbb"]["names"][]=$val["uraian"];
				$data_jml_wil["blbb"]["value"][]=(int)$arrWil2[$val['kode']]['jumlah'];
			}
		}
		$data_jml_wil["colors"]=$colors;
		return $data_jml_wil;
	}
	
	function kontak_feed($year=false,$offset=0,$limit=5){

       $maintable	=	"cms_guest_book";
		
		if($year):
			$filter		=	" YEAR(created)='".$year."'";
		else:
			$filter		=	" YEAR(created)='".date('Y')."'";
		endif;
		
		$total			=	$this->conn->GetOne("select count(idx) as total from cms_guest_book where ".$filter);
		
		if($total>$limit):
			$offset	=	(int)rand(0,$total-$limit);
		endif;
		
		$top5_bydate  = $this->conn->GetAll("select idx, name, email, subject, comments, reply, status, created from cms_guest_book where ".$filter." and status='1' order by created desc limit ".$limit." offset ".$offset);
		
		$data["top5_bydate"] = $top5_bydate;
		$this->load->view("filler/filler/kontak_feed",$data);
	
    }
	
}	
