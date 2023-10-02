<?php

class dms_model extends ADODBX_Model{
	/**
	 * Set Table Name Here
	 */
	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
		$this->tbl_dms_category='dms_category';
        $this->tbl_dms_data='dms_data';
		$this->tbl_dms_file_type='dms_file_type';
		$this->tbl_dms_group_file_type='dms_group_file_type';
        $this->tbl_dms_access_log="dms_access_log";
        $this->tbl_dms_data="dms_data";
        $this->tbl_dms_history="dms_history";
        $this->tbl_dms_admin="dms_admin";
        $this->tbl_dms_reviewer="dms_group_reviewer";
        $this->tbl_user_perms="dms_user_perms";
        
	}
    
    /* DMS DATA */
    function data_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_dms_data,$data,$sort,$dataColumn);
    }
    
    function data_search_record_where($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->tbl_dms_data,$where,$sort,$dataColumn);
    }
    
    function dms_get($where,$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl_dms_data,$where,$dataColumn);
    }
    
    
    function dms_update($data,$where){
        $ret=$this->adodbx->Update($this->tbl_dms_data,$data,$where);
        return $ret;
    }
    
    
    /* DMS ACCESS LOG */
    function access_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_dms_access_log,$data,$sort,$dataColumn);
    }
    
    function access_search_record_where($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->tbl_dms_access_log,$where,$sort,$dataColumn);
    }
    
    
    function access_action($action=false){
        $arr=array(
            "A"=>"Add New file",
            "D"=>"Downloaded file",
            "Y"=>"Authorized file",
            "R"=>"Rejected file",
            "V"=>"View File",
            "I"=>"check in file",
            "O"=>"Check out file",
            "M"=>"Modified file",
            "X"=>"Deleted file"
        );
        if(!$action):
            return $arr;
        else:
            return $arr[$id];
        endif;
    }
    
    /* action :
     * A : Add file
     * Y : Authorize
     * R : Reject
     * V : View
     * D : Download
     * I : Check IN
     * O : Check Oout
     * M : Modified
     * X : Delete 
     */
    function access_log($action,$file_id){
        $row=$this->dms_get("id=$file_id");
        $data["action"]=$action;
        $data["file_id"]=$file_id;
        $data["user_id"]=isset($this->data["users"]["user"]["id"])?$this->data["users"]["user"]["id"]:0;
        $data["file_ext"]=$row["file_ext"];
        $data["title"]=$row["title"];
        $data["realname"]=$row["realname"];
        //$data["access_time"]=date("Y-m-d H:i:s");
        $this->adodbx->Insert($this->tbl_dms_access_log,$data);
    }
    
    
    function history_get($id){
        return $this->adodbx->search_record_where($this->tbl_dms_history,"id=$id");
    }
    
    function history_add($id,$note=""){
        $countRevisi=$this->adodbx->GetOne("select count(id) from ".$this->tbl_dms_history." where id=$id");
        //initial file
        $dmsData=$this->dms_get("id=$id");
        if($countRevisi==0):
            $dataInsert["id"]=$id;
            $dataInsert["note"]=!empty($note)?$note:"Initial File";
            $dataInsert["editor"]=$this->data['users']['user']['username'];
            $dataInsert["edited"]=date("Y-m-d H:i:s");
            $dataInsert["revision"]="current";
            $dataInsert["id_file_upload"]=$dmsData["id_file_upload"];
            $dataInsert["file_ext"]=$dmsData["file_ext"];
            $dataInsert["realname"]=$dmsData["realname"];
            $dataInsert["title"]=$dmsData["title"];
            
            $this->adodbx->Insert($this->tbl_dms_history,$dataInsert);
        elseif($countRevisi>=1):
            $dataUpdate["revision"]=$countRevisi-1;
            $this->adodbx->Update($this->tbl_dms_history,$dataUpdate,"id=$id and revision='current'");
            
            $dataInsert["id"]=$id;
            $dataInsert["note"]=$note;
            $dataInsert["editor"]=$this->data['users']['user']['username'];
            $dataInsert["edited"]=date("Y-m-d H:i:s");
            $dataInsert["revision"]="current";
            $dataInsert["id_file_upload"]=$dmsData["id_file_upload"];
            $dataInsert["file_ext"]=$dmsData["file_ext"];
            $dataInsert["title"]=$dmsData["title"];
            
            $this->adodbx->Insert($this->tbl_dms_history,$dataInsert);
        endif;
    }
	
	function get_revision($id){
		return $this->conn->GetOne("select count(id) from ".$this->tbl_dms_history." where id=$id");
	}
    
    /*DMS CATEGORY*/
	
	function category_add($data){
		$ret=$this->adodbx->Insert($this->tbl_dms_category,$data);
		return $ret;
	}
	
	function category_update($data,$where){
		$ret=$this->adodbx->Update($this->tbl_dms_category,$data,$where);
		return $ret;
	}
	
	function category_get($where,$dataColumn=false){
		return $this->adodbx->GetRecord($this->tbl_dms_category,$where,$dataColumn);
	}
	
	function category_delete($where){
		return $this->adodbx->Delete($this->tbl_dms_category,$where);
	}
	
	function category_search_record($data=false,$sort='',$dataColumn=false){
		return $this->adodbx->search_record($this->tbl_dms_category,$data,$sort,$dataColumn);
	}
	
	function category_search_record_where($where=false,$sort='',$dataColumn=false){
		return $this->adodbx->search_record_where($this->tbl_dms_category,$where,$sort,$dataColumn);
	}
	
    
    /* review */
    function count_dms_data_review_all(){
        return $this->conn->GetOne("select count(id) from ".$this->tbl_dms_data." where publishable=0");
    }
    
    
    function dms_data_review_all(){
        return $this->adodbx->search_record_where($this->tbl_dms_data,"publishable=0");
    }
    
    function count_dms_data_review_file($userid=false){
        if(!$userid):
            $userid=$this->data['users']['user']['id'];
        endif;    
            
        return $this->conn->GetOne("select count(id) from ".$this->tbl_dms_data." where publishable=0 and reviewer=$userid");
    }
    
    function dms_data_review_file($userid=false){
        if(!$userid):
            $userid=$this->data['users']['user']['id'];
        endif;    
        return $this->adodbx->search_record_where($this->tbl_dms_data,"publishable=0 and reviewer=$userid");
    }
    
    function dms_data_review_group($group_id){
        if(!$userid):
            $userid=$this->data['users']['user']['id'];
        endif;    
        return $this->adodbx->search_record_where($this->tbl_dms_data,"publishable=0 and group=$group_id");
    }
    
    function count_dms_data_review_group($group_id){
        return $this->conn->GetOne("select count(id) from ".$this->tbl_dms_data." where publishable=0 and group=$group_id");
    }
    
    
    
    function is_dms_admin($userid=false){
        if(!$userid):
            $userid=$this->data['users']['user']['id'];
        endif;
        $count=$this->adodbx->GetOne("select count(*) from ".$this->tbl_dms_admin." where id=$userid and admin=1");
        if($count>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function is_dms_file_reviewer($file_id,$userid=false){
        if(!$userid):
            $userid=$this->data['users']['user']['id'];
        endif;
        $row=$this->dms_get("id=$id");
        if(cek_array($row)):
            if($row["reviewer"]==$userid):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
           return FALSE;         
        endif;
    }
    
    
    function is_dms_group_reviewer($group_id,$userid=false){
        if(!$userid):
            $userid=$this->data['users']['user']['id'];
        endif;
        $count=$this->adodbx->GetOne("select count(id) from ".$this->tbl_dms_reviewer." where id=$userid and group_id=$group_id and reviewer=1");
        if($count>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function get_user_id($user_id=false){
        if(!$userid):
            $userID=$this->data['users']['user']['id'];
        endif;
        $this->userID=$userID;
        return $userID;
    }
    
    function dms_user_perms_update($fid,$rights=0,$uid=false){
        debug();    
        $uid=$this->get_user_id($uid);
        $row=$this->conn->GetRow("select fid from ".$this->tbl_user_perms." where fid=? and uid=?",array($fid,$uid));
        $found=0;
        if(cek_array($row)):
            $found=1;
        endif;
        
        $this->conn->StartTrans();
        if($found==0):
            $dataInsert["fid"]=$fid;
            $dataInsert["uid"]=$uid;
            $dataInsert["rights"]=$rights;
            
            $this->adodbx->Insert($this->tbl_user_perms,$dataInsert);
        else:
            $dataUpdate["rights"]=$rights;
            $this->adodbx->Insert($this->tbl_user_perms,$data,"UPDATE","fid=$fid and uid=$uid");
        endif;
        $ok=$this->conn->CompleteTrans();
        return $ok;
    }
	
	
	
}

