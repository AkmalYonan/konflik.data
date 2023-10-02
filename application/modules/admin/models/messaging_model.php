<?php

class messaging_model extends LAT_Model{
	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
		$this->tbl_msg='cms_messaging';
        $this->tbl_msg_users='cms_messaging_users';
		$this->tbl_msg_reply='cms_messaging_reply';
	}
	/* MESSAGING */
    function data_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_msg,$data,$sort,$dataColumn);
    }
    
    function data_search_record_where($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->tbl_msg,$where,$sort,$dataColumn);
    }
    
	function message_list($my){
		$sql = "
		SELECT a.*,b.status as status_owner
		FROM ".$this->tbl_msg." a,
		".$this->tbl_msg_users." b 
		WHERE a.idx=b.message_id AND b.message_user='".$my."' 
		";
        
		return $this->conn->GetAll($sql);
    }
	function message_get($where,$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl_msg,$where,$dataColumn);
    }
	function message_update($data,$where){
        $ret=$this->adodbx->Update($this->tbl_msg,$data,$where);
        return $ret;
    }
	function message_insert($data) {
		$ret=$this->adodbx->Insert($this->tbl_msg,$data);
		return $ret;
	}
	function message_last_id($dataColumn="idx") {
		$ret=$this->adodbx->GetLastID($this->tbl_msg,$dataColumn);
		return $ret;
	}
	
	/* MESSAGING USER */
    function user_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_msg_users,$data,$sort,$dataColumn);
    }
    
    function user_search_record_where($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->tbl_msg_users,$where,$sort,$dataColumn);
    }
    function user_list($where=false,$sort='',$dataColumn=false){
        $arrUser = $this->user_search_record_where($where,$sort,$dataColumn);
		if (is_array($arrUser)) {
			foreach($arrUser as $k=>$v) {
				$users['list'][]=$v['message_user'];
				if (!$v['status']) $users['ts']=$v['message_user'];
			}
			return $users;
		}
    }
	function user_new_message($where=false,$sort='',$dataColumn=false){
        $arrUser = $this->user_search_record_where($where,$sort,$dataColumn);
		if (is_array($arrUser)) {
			return $arrUser;
		}
    }
    function user_get($where,$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl_msg_users,$where,$dataColumn);
    }
	function user_update($data,$where){
        $ret=$this->adodbx->Update($this->tbl_msg_users,$data,$where);
        return $ret;
    }
	function user_insert($data) {
		$ret=$this->adodbx->Insert($this->tbl_msg_users,$data);
		return $ret;
	}
	function user_message_list($tid){
		$sql = "SELECT distinct(message_user) FROM ".$this->tbl_msg_users."	WHERE topic_id=".$tid;
		return $this->conn->GetAll($sql);
    }
	
	/* MESSAGING REPLY */
    function reply_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_msg_reply,$data,$sort,$dataColumn);
    }
    
    function reply_search_record_where($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->tbl_msg_reply,$where,$sort,$dataColumn);
    }
    
	function reply_list($filter=false,$limit=15,$offset=0,$order=false){
		$sql = "(
			SELECT a.idx,a.topic_id,a.parent_id,a.message_id,a.pengirim,a.waktu,a.subyek,a.isi_pesan,b.status,b.message_user
			FROM ".$this->tbl_msg_reply." a,
			".$this->tbl_msg_users." b 
			WHERE a.idx=b.message_id AND a.parent_id is null AND a.message_id is null
			) a
		";
        
		return $this->adodbx->search_record_by_limit_where($sql,$filter,$limit,$offset,$order);
    }
	function reply_list_total($filter=false,$limit=15,$offset=0,$order=false){
		$sql = "(
			SELECT a.idx,a.topic_id,a.parent_id,a.message_id,a.pengirim,a.waktu,a.subyek,a.isi_pesan,b.status,b.message_user
			FROM ".$this->tbl_msg_reply." a,
			".$this->tbl_msg_users." b 
			WHERE a.idx=b.message_id AND a.parent_id is null AND a.message_id is null
		) a
		";
		return $this->total_rows_where($sql,$filter,'idx');
        //return $this->total_rows_where($sql,$filter,"idx");
//		return $this->adodbx->search_record_by_limit_where($sql,$filter,$limit,$offset,$order);
		//return $this->conn->GetAll($sql);
    }
	function new_list($filter=false,$limit=15,$offset=0,$order=false){
		$sql = "(
			SELECT a.idx,a.topic_id,a.parent_id,a.message_id,a.pengirim,a.waktu,a.subyek,a.isi_pesan,b.status,b.message_user
			FROM ".$this->tbl_msg_reply." a,
			".$this->tbl_msg_users." b 
			WHERE a.idx=b.message_id
			) a
		";
        
		return $this->adodbx->search_record_by_limit_where($sql,$filter,$limit,$offset,$order);
    }
	function reply_get($where,$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl_msg_reply,$where,$dataColumn);
    }
	function reply_update($data,$where){
        $ret=$this->adodbx->Update($this->tbl_msg_reply,$data,$where);
        return $ret;
    }
	function reply_insert($data) {
		$ret=$this->adodbx->Insert($this->tbl_msg_reply,$data);
		return $ret;
	}
	function reply_last_id($dataColumn="idx") {
		$ret=$this->adodbx->GetLastID($this->tbl_msg_reply,$dataColumn);
		return $ret;
	}
}
