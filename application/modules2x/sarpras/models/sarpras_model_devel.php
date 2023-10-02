<?php

class sarpras_model_devel extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= '';
	public $tbl_kab = '';
	public $tbl_prop = '';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
        
	}
	
	function attr_insert2($kode,$data){
		
		$table	=	"t_sarpras_".$kode;
		
		$insert	=	$this->adodbx->Insert($table,$data);
		
		return $insert;
		
	}
	
	function attr_update2($kode,$data,$criteria){
		
		$table	=	"t_sarpras_".$kode;
		
		$update	=	$this->adodbx->Update($table,$data,$criteria);
		
		return $update;
		
	}	
	
	function attr_delete2($kode,$criteria){
		
		$table	=	"t_sarpras_".$kode;
		
		$delete	=	$this->adodbx->Delete($table,$criteria);
		
		return $delete;
		
	}	
	
	function get_kd_org_list(){
		
		$sql	=	"select kd_org from t_sarpras_instansi";
		
		$arr	=	$this->conn->GetAll($sql);
		
		foreach($arr as $k=>$v):
			$arr2[$k]	=	"'".$v['kd_org']."'";
		endforeach;
		
		$list	=	join(",",$arr2);
		
		return $list;
		
	}	
	
	//ATTR
	function attr_get($name){
		$tbl = "select * from m_".$name." limit 0,13";
		return $this->conn->GetAll($tbl);
    }
	
	function attr_get_edit($name,$kode){
		
		//$tbl = "select * from t_sarpras_".$name." where kd_org='$kode' limit 0,13";
		$sql	=	"
					select
					a.uraian,
					b.*
					
					from m_".$name." a
					
					left join t_sarpras_".$name." b
					on a.kode=b.kode
					
					where b.kd_org='$kode' limit 0,13					
					";
		
		return $this->conn->GetAll($sql);
    }	
	
	function attr_get2($name){
		$tbl = "select * from m_".$name." limit 14,30";
		return $this->conn->GetAll($tbl);
    }
	function attr_insert($name,$data) {
		$tbl = "attr_".$name;
		$ret=$this->adodbx->Insert($tbl,$data);
		return $ret;
	}
	function attr_update($name,$data,$where) {
		$tbl = "attr_".$name;
		$ret=$this->adodbx->Update($tbl,$data,$where);
		return $ret;
	}
	function attr_delete($name,$where){
		$tbl = "attr_".$name;
        return $this->adodbx->Delete($tbl,$where);
    }
	function attr_idx_by_id($name,$id,$id_txt=false) {
		$idx=$id_txt?$id_txt:"idx";
		$tbl = "attr_".$name;
		$sql = "select ".$idx." as value from ".$tbl." where id_kecamatan='".$id."'";
		return $this->conn->GetOne($sql);	
	}
	function attr_last_idx($name,$id_txt=false) {
		$idx=$id_txt?$id_txt:"idx";
		$tbl = "attr_".$name;
		$sql = "select max($idx) as value from ".$tbl;
		return $this->conn->GetOne($sql);	
	}
	
}
