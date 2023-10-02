<?php

/***
 * Name:       ADODB ABSTRACT CLASS
 * About:      ADODB ABSTRACT CLASS
 * Copyright:  (C) 2010 - whoget.
 * Author:     whoget@yahoo.com
 * License:    LGPL, see included license file
 ***/



/**
 * 
 * ADODB database access
 *
 * @package		LATF
 * @author		whoget
 */

class Adodb_Model {
    var $db = null;
    var $result = null;

    function __construct($db=false) {

        //if(empty($config))
        //throw new Exception("database definitions required.");

        //if(empty($config['charset']))
        //$config['charset'] = 'UTF-8';
        if($db==false) {
            try {

                $this->connect();

            } catch (exception $e) {

                var_dump($e);
                adodb_backtrace($e->gettrace());

            }
        }else{
            $this->db=$db;
            $this->db->SetFetchMode(ADODB_FETCH_ASSOC);
        }
    }

    function connect() {
        if(DB_CON=='odbc_mssql'):
            $this->db =& ADONewConnection(DB_CON);
            $dsn = "Driver={SQL Server};Server=".DB_HOST.";Port=".DB_SERVER_PORT.";Database=".DB_NAME.";";
            $conStatus=$this->db->Connect($dsn,DB_PASS,DB_USER);
        else:
            $this->db = &ADONewConnection(DB_CON);
            $conStatus = $this->db->Connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        endif;

        $this->db->SetFetchMode(ADODB_FETCH_ASSOC);

        $this->db->conStatus=$conStatus;
        return $this->db;
    }

    function disconnect() {
        if ($this->db) {
            $this->db->close();
        }
    }

    function cek_array($arr){
	if((is_array($arr))&&(count($arr)>0)):
		$ret=true;
	else:
		$ret=false;
	endif;
	return $ret;
    }

    function get_record($table,$where=false,$dataColumn=false) {
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

    function Delete($table_name,$where) {
        $sql = "delete from {$table_name} where ".$where;
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

    public function LastIDPostgresql($table,$id='idx'){
        $id=$this->db->GetOne("SELECT {$id} FROM {$table} ORDER BY {$id} DESC   LIMIT 1");
        return $id;
    }

    public function TableInfo($table) {
        return $this->db->MetaColumns($table);
    }

    public function UseDB($dbn) {
        $this->database = $dbn;
        $this->db->Close();
        $this->db->Connect($config["host"], $config["user"], $config["pass"], $this->database);
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
                            $value="'%".$value."%'";
                            $filters[] = " $x like $value ";
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

    function search_record_where($table,$where=false,$sort=false,$dataColumn=false){
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
                            $value="'%".$value."%'";
                            $filters[] = " $x like $value ";
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


    function search_record_by_limit($table,$data=false,$rows=false,$offset=false, $sort=false,$dataColumn=false) {
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
                            $value="'%".$value."%'";
                            $filters[] = " $x like $value ";
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


    public function search_record_by_limit_where($table,$where=false,$rows=false,$offset=false,$sort=false,$dataColumn=false){
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

    /**
     * class destructor
     *
     * @access	public
     */
    //function __destruct() {
      //  $this->disconnect();
      //  $this->db=null;
    //}

}
?>