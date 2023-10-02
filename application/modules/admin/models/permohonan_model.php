<?php

class permohonan_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'ppid_permohonan';
	public $tbl_detil= 'ppid_permohonan_detil';
	public $tbl_reply= 'ppid_permohonan_reply';
	public $tbl_dok= 'ppid_dokumen';
	public $tbl_jenis= 'm_jenis';
	public $tbl_user_member= 'users';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	function jenis_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_jenis,$data,$sort,$dataColumn);
    }
	function get_member_record($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl_user_member,$where,$dataColumn);
    }
	function insert_permohonan_detil($data=array()){
       return $this->adobx->Insert($this->tbl_detil, $data);
    }
	function update_permohonan_detil($data,$where){
		return $this->adodbx->Update($this->tbl_detil,$data,$where);
	}
	function get_message_detil($where=false){
       return $this->adodbx->search_record_where($this->tbl_detil,$where,$sort,$dataColumn);
    }
	function insert_permohonan_reply($data=array()){
       return $this->adobx->Insert($this->tbl_reply, $data);
    }
	function get_reply_detil($where=false){
       return $this->adodbx->GetRecord($this->tbl_reply,$where,$sort,$dataColumn);
    }
	function get_permohonan_baru($skpa=false){
		$sql_skpa = ($skpa)?" and skpa=".(int)$skpa:"";
		$sql = "select * from ".$this->tbl." where status=-1".$sql_skpa;
		$arrDB = $this->conn->GetAll($sql);	
		return $arrDB;
	}
	function getRequestFileById($id){
		$sql = "select 
					a.idx,
					a.id_user,
					b.*,
					c.*
				from 
					".$this->tbl." a, 
					".$this->tbl_reply." b, 
					".$this->tbl_dok." c 
				where 
					a.idx=".$id." and
					a.idx=b.id_permohonan and
					b.file_id=c.idx"
				;
		return $this->conn->GetRow($sql);	
	}
}
