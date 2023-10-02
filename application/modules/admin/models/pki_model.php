<?php

class pki_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'ppid_keberatan';
	public $tbl_dokumen= 'ppid_dokumen';
	public $tbl_detil= 'ppid_keberatan_detil';
	public $tbl_reply= 'ppid_keberatan_reply';
	public $tbl_alasan= 'm_alasan_pk';
	public $tbl_user_member= 'users';
	
	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
	}
	function alasan_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_alasan,$data,$sort,$dataColumn);
    }
	function insert_keberatan_detil($data=array()){
       return $this->adobx->Insert($this->tbl_detil, $data);
    }
	function get_keberatan_detil($where=false){
       return $this->adodbx->search_record_where($this->tbl_detil,$where,$sort,$dataColumn);
    }
	function get_keberatan_detil2($where=false){
       $arrDB =  $this->adodbx->search_record_where($this->tbl_detil,$where,$sort,$dataColumn);
	   if (cek_array($arrDB)) {
	   		foreach($arrDB as $k=>$v) {
				$arr[$v['status']]=$v['created_date'];
			}
	   }
	   return $arr;
    }
	function get_keberatan_reply($where=false){
       return $this->adodbx->GetRecord($this->tbl_reply,$where,$sort,$dataColumn);
    }
	function insert_keberatan_reply($data=array()){
       return $this->adobx->Insert($this->tbl_reply, $data);
    }
	function get_reply_detil($where=false){
       return $this->adodbx->GetRecord($this->tbl_reply,$where,$sort,$dataColumn);
    }
	function get_member_record($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl_user_member,$where,$dataColumn);
    }
	
	function update_keberatan_detil($data,$where){
		return $this->adodbx->Update($this->tbl_detil,$data,$where);
	}
	function get_message_detil($where=false){
       return $this->adodbx->search_record_where($this->tbl_detil,$where,$sort,$dataColumn);
    }
}
