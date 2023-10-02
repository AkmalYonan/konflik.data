<?php

class offline_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 't_pasien_list';

	function __construct(){
		parent::__construct();
		$this->tbl=$tbl;
		$this->db=$this->conn;
	}
	
	public function GetDaftarNik(){
	
		$sql		=	"select nik from t_pasien";
		
		$arr		=	$this->conn->GetAll($sql);
		
		foreach($arr as $k=>$v):
			$nik[$k]=	"'".$v['nik']."'";
		endforeach;
		
		$nik_list	=	join(",",$nik);	
		
		return $nik_list;
	
	}
	
	public function GetDaftarNoRekamMedis(){

		$sql		=	"select no_rekam_medis from t_pasien";
		
		$arr		=	$this->conn->GetAll($sql);
		
		foreach($arr as $k=>$v):
			$no_rekam_medis[$k]=	"'".$v['no_rekam_medis']."'";
		endforeach;
		
		$no_rekam_medis_list	=	join(",",$no_rekam_medis);	
		
		return $no_rekam_medis_list;
	
	}
	
	public function CekNik($nik){
		
		$where_sql		=	" where nik='".$nik."'";
		
		$sql			=	"select nik from t_pasien".$where_sql;
		
		$nik			=	$this->conn->GetOne($sql);
		
		return $nik;
		
	}
	
	public function CekDataPasien($nik,$no_rekam_medis=false){
		
		if($no_rekam_medis):
			$where_sql	=	" where nik='".$nik."' and no_rekam_medis='".$no_rekam_medis."' and active";
		else:
			$where_sql	=	" where nik='".$nik."'";
		endif;
		
		$sql			=	"select idx from t_pasien ".$where_sql;
		
		$idx			=	$this->conn->GetOne($sql);
		
		return $idx;
		
	}
	
	public function CekPasienActive($idx){
		
		$where_sql		=	" where idx='".$idx."' and active_pasien='1'";
		
		$sql			=	"select idx from t_pasien".$where_sql;
		
		$idx			=	$this->conn->GetOne($sql);
		
		return $idx;
		
	}
	
	public function CekNoRekamMedis($idx,$no_rekam_medis){
		
		$where_sql		=	" where idx='".$idx."' and no_rekam_medis='".$no_rekam_medis."'";
		
		$sql			=	"select idx from t_pasien".$where_sql;
		
		$idx			=	$this->conn->GetOne($sql);
		
		return $idx;
		
	}
	
	public function VerifikasiNoRekamMedis($no_rekam_medis){
	
		$where_sql		=	" where no_rekam_medis='".$no_rekam_medis."'";
		
		$sql			=	"select no_rekam_medis from t_pasien".$where_sql;
		
		$no_rekam_medis	=	$this->conn->GetOne($sql);
		
		return $no_rekam_medis;
	
	}
}