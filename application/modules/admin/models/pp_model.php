<?php

class pp_model extends LAT_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 'cms_pp';

	function __construct(){
		parent::__construct();
		$this->db=$this->conn;
        $this->tbl_link_category="cms_pp_category";
         $this->tbl_link_category_count="cms_pp_category_count";
         $this->tbl_link_stats="cms_pp_stats";
         $this->tbl_link_count="cms_pp_count";
	}
    
    function category_add($data){
        $ret=$this->adodbx->Insert($this->tbl_link_category,$data);
        return $ret;
    }
    
    function category_update($data,$where){
        $ret=$this->adodbx->Update($this->tbl_link_category,$data,$where);
        return $ret;
    }
    
    function category_get($where,$dataColumn=false){
        return $this->adodbx->GetRecord($this->tbl_link_category,$where,$dataColumn);
    }
    
    function category_delete($where){
        return $this->adodbx->Delete($this->tbl_link_category,$where);
    }
    
    function category_search_record($data=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record($this->tbl_link_category,$data,$sort,$dataColumn);
    }
    
    function category_search_record_where($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->tbl_link_category,$where,$sort,$dataColumn);
    }
    
    function category_count_add($category,$total){
        $row=$this->adodbx->GetRecord($this->$this->tbl_link_category_count,"category=$category");
        $total=0;
        if(cek_array($row)):
            $total=$row["total"]+1;
        endif;
    }
    
    function category_count_min($category,$total){
        $row=$this->adodbx->GetRecord($this->$this->tbl_link_category_count,"category=$category");
        $total=0;
        if(cek_array($row)):
            $total=$row["total"]+1;
        endif;
    }
    
    function category_count_get_total($category){
        return $this->conn->GetOne("select total from ".$this->tbl_link_category_count." category=$category");
    }
	
    function category_count_search_record_where($where=false,$sort='',$dataColumn=false){
        return $this->adodbx->search_record_where($this->$this->tbl_link_category_count,$where,$sort,$dataColumn);
    }
	
    
    function category_list_count(){
        $sql="select category,count(idx) as total from ".$this->tbl." group by category";
        $sql="select b.*,coalesce(a.total,0) as total from ($sql) a right join ".$this->tbl_link_category." b on a.category=b.idx";
        $arrData=$this->conn->GetAll($sql);
        foreach($arrData as $x=>$val):
            $totalx[]=$val["total"];
        endforeach;
        $allCatTotal=array_sum($totalx);
        
        $data["arrData"]=$arrData;
        $data["total"]=$allCatTotal;
        return $data;
    }
    
    
    function click_count($id_link){
        $CI=& get_instance();
        $row=$this->adodbx->GetRecord($this->tbl_link_count,"id_link=$id_link");
        $this->conn->StartTrans();
        //update cms link count
        if(cek_array($row)):
            $dataUpdate["click_count"]=$row["click_count"]+1;
            $this->adodbx->Update($this->tbl_link_count, $dataUpdate, "id_link=$id_link");
            $dataUpdateStats=$dataUpdate;
           
        else:
            $dataInsert["click_count"]=1;
            $dataInsert["id_link"]=$id_link;
            $this->adodbx->Insert($this->tbl_link_count,$dataInsert);
        endif;
        
        //udate cms link stat
         $dataUpdateStats["id_link"]=$id_link;
         $dataUpdateStats["click_count"]=1;
         $dataUpdateStats["ip_address"]=$CI->_prepare_ip($this->input->ip_address());
         $this->adodbx->Insert($this->tbl_link_stats,$dataUpdateStats);
         $ok=$this->conn->CompleteTrans();
         if($ok):
            return TRUE;
         else:
            return FALSE;
         endif;   
    }

    function search_by_category($category_id,$rows=5,$offset=0,$sort=false,$dataColumn=false){
        return $this->adodbx->search_record_by_limit_where($this->tbl,"category=$category_id",$rows,$offset,$sort,$dataColumn);
    }
    
}

