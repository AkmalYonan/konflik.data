<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  class adodbx { 
   	var $db = null;
	var $exception=true;
	var $show_errors=false;
	var $adodb=NULL;
    var $result = null;
        
		function adodbx()
					{
					  if ( ! class_exists('ADONewConnection') )
                      {
					  	
					  	if($this->exception):
							//require_once(BASEPATH.'libraries/ADODB/adodb-exceptions.inc'.EXT);
                        endif;
					
						require_once(BASEPATH.'libraries/ADODB/adodb.inc'.EXT);
						require_once(BASEPATH.'libraries/ADODB/tohtml.inc'.EXT);
						require_once(BASEPATH.'libraries/ADODB/pivottable.inc'.EXT);
						//require_once(BASEPATH.'libraries/ADODB/adodb-errorhandler.inc'.EXT);
                        require_once(BASEPATH.'libraries/ADODB/adodb-error.inc'.EXT);
						
						require_once(BASEPATH.'libraries/ADODB/adodb-active-record.inc'.EXT);
                      }
 
              $obj =& get_instance();
              $this->_init_adodb_library($obj);
         }
		 
		 
	function _init_adodb_library(&$ci) {
     $db_var = false;
     $debug = false;
     $show_errors = false;
     $active_record = false;
     $db = NULL;
     
     if (!isset($dsn)) {
        // fallback to using the CI database file 
        include(APPPATH.'config/database'.EXT); 
        $group = 'default'; 
        $dsn = $db[$group]['dbdriver'].'://'.$db[$group]['username'] 
                         .':'.$db[$group]['password'].'@'.$db[$group]['hostname']
                         .'/'.$db[$group]['database']; 
      }
 
 		
      // Show Message Adodb Library PHP
      if ($show_errors) {
         //require_once(BASEPATH.'libraries/ADODB/adodb-errorhandler.inc'.EXT);
      }
 
      // $ci is by reference, refers back to global instance
	  try{      
	  	$ci->adodb =& ADONewConnection($dsn);
      	if(!$ci->adodb){
			show_error("Unable to connect to your database server using the provided settings.
",400,"A Database Error Occurred");
	  		$ci->conn=NULL;
	  		$this->db=NULL;
	  		$ci->adobx=FALSE;
			return false;
		}
	  	$this->adodb=$ci->adodb;
      // Use active record adodbx
      	$ci->adodb->setFetchMode(ADODB_FETCH_ASSOC);
	   
      	if ($db_var) {
          // Also set the normal CI db variable
                  $ci->db =& $ci->adodb;
      	}
 
      	if ($active_record) {
           require_once(BASEPATH.'libraries/ADODB/adodb-active-record.inc'.EXT);
           ADOdb_Active_Record::SetDatabaseAdapter($ci->adodbx);
      	}
 
      if ($debug) {
           $ci->adodb->debug = true;
      }
	  $ci->conn=$ci->adodb;
	  $this->db=$ci->adodb;
	  $ci->adobx=$this;
	  }catch(Exception $e) {
	  		show_error("Unable to connect to your database server using the provided settings.
",400,"A Database Error Occurred");
	  		$ci->conn=NULL;
	  		$this->db=NULL;
	  		$ci->adobx=FALSE;
			return false;
	  }
}
 
/*
* Function Factory for call ADODB Active Record function
*/
function ADOdb_Active_Record_Factory($classname, $tablename = null) {
    // create the class
    eval('class '.$classname.' extends ADOdb_Active_Record{}');
 
    if ($tablename != null) {
        return new $classname($tablename);
    } else {
        return new $classname;
    }
}
 
function loadSession(){
	 require_once(BASEPATH.'libraries/session/adodb-session2'.EXT);
	//include_once(INCLUDE_URL.SEP."ADODB/session/adodb-session2.php");
	$driver = DB_CON; 
	$host = DB_HOST; 
	$user = DB_USER; 
	$pwd = DB_PASS; 
	$database = DB_NAME;

	ADOdb_Session::config($driver, $host, $user, $pwd, $database,false);
	ADOdb_session::Persist(true);
	ADOdb_session::lifetime(100*60);
}


 
 //TAMBAHAN DARI WHOGET
 function cek_array($arr){
	if((is_array($arr))&&(count($arr)>0)):
		$ret=true;
	else:
		$ret=false;
	endif;
	return $ret;
    }

    function GetRecord($table,$where=false,$dataColumn=false) {
        if(($where!=false)&&($where!='')):
            $where=" where ".$where;
        endif;
		if(($dataColumn==false)||($dataColumn=='')):
            $dataColumnList=" * ";
        else:
            $dataColumnList=implode(",",$dataColumn);
        endif;
		$sql = "select ".$dataColumnList." from ".$table." ". $where;
		$res = $this->db->GetRow($sql);
		return $res;
    }

    function Insert($table_name,$data) {
        $ret=$this->db->AutoExecute($table_name,$data,'INSERT');
        return $ret;
    }

    function Update($table_name,$data,$where) {
        $ret=$this->db->AutoExecute($table_name,$data,'UPDATE',$where);
        return $ret;
    }

    function Delete($table_name,$where="") {
		if($where!=""):
        	$sql = "delete from {$table_name} where ".$where;
        else:
			$sql = "delete from {$table_name} ";
        endif;
		$res = $this->db->Execute($sql);

        $aff = $this->db->Affected_Rows();
        if($aff !== 1) {
            //throw new MyException('ERROR_CODE_RECORD_NOT_FOUND');
        }else {
            return $aff;
        }
    }
	
	function GetAll($sql) {
        $arr=$this->db->GetAll($sql);
        return $arr;
    }

    function GetRow($sql) {
        $arr=$this->db->GetRow($sql);
        return $arr;
    }

    function GetOne($sql) {

        $ret=$this->db->GetOne($sql);
        return $ret;

    }

    function AutoExecute($table,$data,$mode,$where="") {
        if(($mode=="UPDATE")&&($where!="")):
            return $this->db->AutoExecute($table,$data,"UPDATE",$where);
        endif;

        if(($mode="INSERT")&&($mode=="")):
            return $this->db->AutoExecute($table,$data,"INSERT");
        endif;
    }

    function SelectLimit($sql,$rows,$offset) {
        $rs= $this->db->SelectLimit($sql, $rows, $offset);
        return $rs;
    }

	function GetDataType($table) {

        $sql="select * from $table";
        $data_type=array();
        $rs=$this->db->SelectLimit($sql,1,1);
        if($rs) {
            $countField=$rs->FieldCount();
            for($i=0;$i<$countField;$i++) {
                $fields=$rs->FetchField($i);
                $data_type[$fields->name]=$this->db->MetaType($fields->type);
            }
        }

        return $data_type;
    }

    public function GetHeader($table) {
        $sql="select * from $table";
        $data_type=array();
        $rs=$this->db->SelectLimit($sql,1,1);
        if($rs) {
            $countField=$rs->FieldCount();
            for($i=0;$i<$countField;$i++) {
                $fields=$rs->FetchField($i);
                $data[]=$fields->name;
            }
        }

        return $data;
    }


    public function GetDataTypeBySql($sql) {

        $sql="select * from ($sql) a";
        $data_type=array();
        $rs=$this->db->SelectLimit($sql,1,1);
        if($rs) {
            $countField=$rs->FieldCount();
            for($i=0;$i<$countField;$i++) {
                $fields=$rs->FetchField($i);
                $data_type[$fields->name]=$this->db->MetaType($fields->type);
            }
        }

        return $data_type;
    }

    public function GetHeaderBySql($sql) {
        $sql="select * from ($sql) a";
        $data_type=array();
        $rs=$this->db->SelectLimit($sql,1,1);
        if($rs) {
            $countField=$rs->FieldCount();
            for($i=0;$i<$countField;$i++) {
                $fields=$rs->FetchField($i);
                $data[]=$fields->name;
            }
        }


        return $data;
    }

    private function _check_error($sql) {
        if($this->db->ErrorNo()) {
            $msg = $this->db->ErrorMsg();
            return $msg;
            //throw new Exception($msg);
        }else {
            return "ok";
        }
    }

    private function _affected($res = null) {
        $aff = $this->db->Affected_Rows($res);
        if($aff !== 1) {
            return false;
        }else {
            return ($aff === 1);
        }
    }

    private function _parse_value($v) {
        return addslashes($v);
    }

    // FROM AR DB CONNECTION PHP CLASSES

    public function TableColumns($table) {
        return $this->db->MetaColumnNames($table,true);
    }

    public function Query($qry) {
        return $this->db->Execute($qry);
    }

    public function FecthQuery($qry,$assoc=1) {
        $data = array();
        if ($assoc==0)
            $ADODB_FETCH_MODE = ADODB_FETCH_NUM;
        $result = $this->db->Execute($qry);
        if ($result === false)
            return $data;
        while (!$result->EOF) {
            $data[] = $result->fields;
            $result->MoveNext();
        }
        $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
        return $data;
    }

    public function Row($res) {
        $ret = $res->fields;
        $res->MoveNext();
        return $ret;
    }

    public function NextID($table) {
        return $this->db->GenID($table);
    }

    public function NextIDPostgresql($table,$id='idx'){
        $id=$this->LastIDPostgresql($table, $id);
        return $id+1;
    }

    public function LastID() {
        return $this->db->Insert_ID();
    }
	public function GetLastID($table,$id='idx'){
		return $this->LastIDPostgresql($table,$id);
	}

    public function LastIDPostgresql($table,$id='idx'){
        $id=$this->db->GetOne("SELECT {$id} FROM {$table} ORDER BY {$id} DESC");
        return $id;
    }
	
	public function TableInfo($table) {
        return $this->db->MetaColumns($table);
    }

    public function EscapeStr($str,$quotes=0,$exchars = '') {
        if (is_array($str)) {
            $str = array_map(array('ADO_DB','escape_str'),$str);
        }
        else {
            if (get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            if (!is_numeric($str)) {
                $str = addslashes($str);
                $str = str_replace("\r",chr(92).'r',$str);
                $str = str_replace("\n",chr(92).'n',$str);
                if (!empty($exchars))
                    for ($i=0; $i<strlen($exchars); $i++)
                        $str = str_replace($exchars[$i],chr(92).$exchars[$i],$str);
                if ($quotes)
                    $str = "'".$str."'";
            }
        }
        return $str;
    }

    public function NumRows($res) {
        return $res->RecordCount();
    }

    public function NumFields($res) {
        return count($res->fields);
    }

    public function AffectedRows() {
        return $this->db->Affected_Rows();
    }


    //FROM SKT WEB SERVICE DB MODEL
    function search_record($table,$data=false,$sort='',$dataColumn=false) {
        $data_type=$this->GetDataType($table);

        $internal_data=array();
        $internal_data=$data;
        if((is_array($data)==true)&&(count($data)>0)):
            foreach($internal_data as $x=>$value):
                if($data_type[$x]=="C"):
                    $data[$x]=$this->_parse_value($value);
                endif;
            endforeach;
        endif;

        $internal_data=array();
        $internal_data=$data;
		$flag_where=false;
        //check with where or not
        if((is_array($data)==true)&&(count($data)>0)):
            foreach($internal_data as $x=>$value):
                if($data[$x]):
                    $flag_where=true;
                    break;
                endif;
            endforeach;
        endif;

        $where = "";
        $filters = array();
        if($flag_where):
            if((is_array($data)==true)&&(count($data)>0)):
                $where .= " where ";

                foreach($data as $x=>$value):
                    if($data[$x]):
                        if($data_type[$x]=='C') {
                            $value="'%".strtolower($value)."%'";
                            $filters[] = " lower($x) like $value ";
                        }else if($data_type[$x]=='T') {
                            $value="'".$value."'";
                            $filters[] = " $x = $value ";
                        }else {
                            $filters[] = " $x = $value ";
                    }
                    endif;
                endforeach;

                $where .= join($filters, " and ");
            endif;
        endif;
        //sql
        if(($dataColumn==false)||($dataColumn=='')):
            $dataColumnList=" * ";
        else:
            $dataColumnList=implode(",",$dataColumn);
        endif;

        $sql = "select ".$dataColumnList." from ".$table." " . $where." ".$sort;

        $res = $this->db->GetAll($sql);
        return $res;
    }

    function search_record_where($table,$where=false,$sort='',$dataColumn=false){
		if(($where!=null)&&($where!=false)):
			$where=" where ".$where;
		endif;

		if(($dataColumn==false)||($dataColumn=='')):
			$dataColumnList=" * ";
		else:
			$dataColumnList=implode(",",$dataColumn);
		endif;

		$sql="select ".$dataColumnList." from ".$table." " . $where." ".$sort;
		$res = $this->db->GetAll($sql);
		return $res;
     }

    function total_rows($table,$data=false) {
        $data_type=$this->GetDataType($table);

        $internal_data=array();
        $internal_data=$data;
        if((is_array($data)==true)&&(count($data)>0)):
            foreach($internal_data as $x=>$value):
                if($data_type[$x]=="C"):
                    $data[$x]=$this->_parse_value($value);
                endif;
            endforeach;
        endif;

        $internal_data=array();
        $internal_data=$data;
        //check with where or not
        if((is_array($data)==true)&&(count($data)>0)):
            foreach($internal_data as $x=>$value):
                if($data[$x]):
                    $flag_where=true;
                    break;
                endif;
            endforeach;
        endif;

        $where = "";
        $filters = array();
        if($flag_where):
            if((is_array($data)==true)&&(count($data)>0)):
                $where .= " where ";

                foreach($data as $x=>$value):
                    if($data[$x]):
                        if($data_type[$x]=='C') {
                            $value="'%".strtolower($value)."%'";
                            $filters[] = " lower($x) like $value ";
                        }else if($data_type[$x]=='T') {
                            $value="'".$value."'";
                            $filters[] = " $x = $value ";
                        }else {
                            $filters[] = " $x = $value ";
                    }
                    endif;
                endforeach;

                $where .= join($filters, " and ");
            endif;
        endif;
        //sql
        $sql = "select count(*) as row_count from ".$table." " . $where;
        $res = $this->db->GetOne($sql);
        return $res;

    }


    function search_record_by_limit($table,$data=false,$rows=false,$offset=false, $sort='',$dataColumn=false) {
        $data_type=$this->GetDataType($table);
		//print_r($data_type);
        $internal_data=array();
        $internal_data=$data;
        if((is_array($data)==true)&&(count($data)>0)):
            foreach($internal_data as $x=>$value):
                if($data_type[$x]=="C"):
                    $data[$x]=$this->_parse_value($value);
                endif;
            endforeach;
        endif;

        $internal_data=array();
        $internal_data=$data;
        $flag_where=false;
        //check with where or not
        if((is_array($data)==true)&&(count($data)>0)):
            foreach($internal_data as $x=>$value):
                if($data[$x]):
                    $flag_where=true;
                    break;
                endif;
            endforeach;
        endif;

        $where = "";
        $filters = array();
        if($flag_where):
            if((is_array($data)==true)&&(count($data)>0)):
                $where .= " where ";

                foreach($data as $x=>$value):
                    if($data[$x]):
                        if($data_type[$x]=='C') {
                            $value="'%".strtolower($value)."%'";
                            $filters[] = " lower($x) like $value ";
                        }else if($data_type[$x]=='T') {
                            $value="'".$value."'";
                            $filters[] = " $x = $value ";
                        }else {
                            $filters[] = " $x = $value ";
                    }
                    endif;
                endforeach;

                $where .= join($filters, " and ");
            endif;
        endif;
        //sql
        if(($dataColumn==false)||($dataColumn=='')):
            $dataColumnList=" * ";
        else:
            $dataColumnList=implode(",",$dataColumn);
        endif;

        $sql = "select ".$dataColumnList." from ".$table." " . $where." ".$sort;

        $res=array();
        $rs= $this->db->SelectLimit($sql, $rows, $offset);
        while  ($data = $rs->FetchRow()) {
            $res[]=$data;
        }
        return $res;
    }


    public function search_record_by_limit_where($table,$where=false,$rows=false,$offset=false,$sort='',$dataColumn=false){
		if(($where!=null)&&($where!=false)):
			$where=" where ".$where;
		endif;
		//sql
		if(($dataColumn==false)||($dataColumn=='')):
			$dataColumnList=" * ";
		else:
			$dataColumnList=implode(",",$dataColumn);
		endif;

		$sql="select ".$dataColumnList." from ".$table." " . $where." ".$sort;
		
		$res=array();
		$rs= $this->db->SelectLimit($sql, $rows, $offset);
		while  ($data = $rs->FetchRow()) {
			$res[]=$data;
		}

		return $res;


	}
	
	
	//ADD SEARCH TEXT 
	public function search_text_from_sql($sql="",$q='',$rows=-1,$offset=-1,$addSql=""){
		//$sql=$sql!=""?$sql:"";
		if(empty($q)):
			return FALSE;
		endif;
		$q=urldecode($q);
		$q=preg_replace("/(\,|\s+|\||\-|\_|\.|\:)/i"," ",$q);
		$q=preg_replace("/\s+/"," ",$q);
		
		$arrField=$this->GetHeaderBySql($sql);
		if($this->cek_array($arrField)==FALSE):
			return FALSE;
		endif;
		
        $field=implode(",",$arrField);
        //$q=urldecode($q);
        
		$search=explode(",",$field);
        $datasearch=array();
        $field="";
        foreach($search as $field):
            $datasearch[]=" lower($field) like '%".strtolower($q)."%' ";
        endforeach;
        $whereSql="";
        $sql="select * from ($sql) a";
        if(cek_array($datasearch)==TRUE):
            $whereSql=" where ".join(" or ",$datasearch);
        endif;
		if(!empty($addSql)):
			if($whereSql==""):
				$whereSql="where 1=1";
			endif;
			$whereSql=" and ".$addSql;
		endif;
		$sql.=$whereSql;
		$arr=FALSE;
        //$arr=$this->db->GetAll($sql);
		$rs= $this->db->SelectLimit($sql, $rows, $offset);
		while  ($data = $rs->FetchRow()) {
			$arr[]=$data;
		}
		
		return $arr;
	}
	
	public function search_text_from_table($table="",$q='',$rows=-1,$offset=-1,$addSql="",$col="*"){
		if(empty($q)):
			return FALSE;
		endif;
		$q=urldecode($q);
		$q=preg_replace("/(\,|\s+|\||\-|\_|\.|\:)/i"," ",$q);
		$q=preg_replace("/\s+/"," ",$q);
		//$sql=$sql!=""?$sql:"";
		//if $col is array
		$arrField=array();
		if($this->cek_array($col)==TRUE):
			$colSql=" ".join(",",$col)." ";
		else:
			$colSql=" * ";
			if(preg_match("/(\,|\s+|\||\-|\_|\.|\:)/",$col)):
				$colSql=preg_replace("/(\,|\s+|\||\-|\_|\.|\:)/i",",",$col);
			endif;
		endif;
		
		
		//get header from query
		$sql=" select $colSql from $table ";
		$arrField=$this->GetHeaderBySql($sql);
		if($this->cek_array($arrField)==FALSE):
			return FALSE;
		endif;
        $field=implode(",",$arrField);
		//$q=urldecode($q);
        
		$search=explode(",",$field);
        $datasearch=array();
        $field="";
        foreach($search as $field):
            $datasearch[]=" lower($field) like '%".strtolower($q)."%' ";
        endforeach;
        $whereSql="";
        $sql="select * from ($sql) a";
        if(cek_array($datasearch)==TRUE):
            $whereSql=" where ".join(" or ",$datasearch);
        endif;
		if(!empty($addSql)):
			if($whereSql==""):
				$whereSql="where 1=1";
			endif;
			$whereSql=" and ".$addSql;
		endif;
		$sql.=$whereSql;
        //$arr=$this->db->GetAll($sql);
		$arr=FALSE;
		$rs= $this->db->SelectLimit($sql, $rows, $offset);
		while  ($data = $rs->FetchRow()) {
			$arr[]=$data;
		}
		
		return $arr;
	}
	
	function search_text($table,$q='',$rows=-1,$offset=-1,$addSql="",$col="*"){
		//$table=preg_match("/(select)/i",$table)?" ($table) a":$table;
		$q=urldecode($q);
		$arr=FALSE;
        if(!empty($q)):
           if(preg_match("/(select)/i",$table)):
                $arr=$this->search_text_from_sql($table,$q,$rows,$offset,$addSql);
           else:
                $arr=$this->search_text_from_table($table,$q,$rows,$offset,$addSql,$col);
           endif;
       else:
	   		$table=preg_match("/(select)/i",$table)?" ($table) a":$table;
            $arr=$this->search_record_by_limit_where($table,false,$rows,$offset);   
	   endif;
	  
       return $arr;
	}
 
 //END TAMBAHAN DARI WHOGET
 
 
 
  }
  
  