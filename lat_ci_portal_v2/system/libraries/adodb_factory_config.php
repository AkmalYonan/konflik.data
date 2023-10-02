<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * FORK FROM FUEL PHP 
 * Implement a bridge to use ADOdb Database Abstraction Layer with FuelPHP. This
 * is an alternative option if you project require the use of ADOdb Library.
 *
 * The DB class use the configuration from /app/config/db.php to make it easier
 * to use. All you need to do is download ADOdb5 library and place it in /fuel/vendor/adodb5
 *
 * From there you can just start using ADOdb by enabling adodb package from /app/config/config.php
 *
 *
 * @author Mior Muhammad Zaki <crynobone@gmail.com>
 */

class adodb_factory_config {
        private static $instances = array ();
		public static $dbstatus=array();
		public static $adodbx=array();
		public static $db=null;
		//public static $exception=true;
        /**
         * Accessing ADOdb Library:
         * $db = \Adodb\DB::factory();
         *
         * You can also make multiple connection by adding the connection name as a parameter
         * $name = 'qa';
         * $db = \Adodb\DB::factory($name);
         *
         * @access public
         * @param string $name
         * @return object ADOdb
         */
		public static function factory($config=null,$show_errors=false,$name="") {
                //\Config::load('db', true);
				$ci =& get_instance();
				 
				
				
				if ( ! class_exists('ADONewConnection') )
                {
						
						require_once(BASEPATH.'libraries/ADODB/adodb-exceptions.inc'.EXT);
						require_once(BASEPATH.'libraries/ADODB/adodb.inc'.EXT);
						require_once(BASEPATH.'libraries/ADODB/adodb-error.inc'.EXT);
						
                        if ($show_errors==true) {
        					 //require_once(BASEPATH.'libraries/ADODB/adodb-errorhandler.inc'.EXT);
      					}
						require_once(BASEPATH.'libraries/ADODB/adodb-active-record.inc'.EXT);
                }
				
				
				$name = is_null($config)?"LOCAL":$config;
				if(!is_null($config)){
					include(APPPATH.'config/database'.EXT); 
        			$group = $config;
					$driver=$db[$group]['dbdriver'];
					$user=$db[$group]['username']; 
                    $password=$db[$group]['password'];
					$host=$db[$group]['hostname'];
                    $dbname=$db[$group]['database']; 
				}	  
                //$active = \Config::get('db.active');
				
                if (is_null($config)) {
                        include(APPPATH.'config/database'.EXT); 
        				$group = 'default';
						$driver=$db[$group]['dbdriver'];
						$user=$db[$group]['username']; 
                        $password=$db[$group]['password'];
						$host=$db[$group]['hostname'];
                        $dbname=$db[$group]['database']; 
                }

                if (!isset(self::$instances[$name])) {
						//self::$adodbx[$name]=new adodb_factory();
                        //$config = \Config::get("db.{$name}");
						/*
						if (is_null($config)) {
                                throw new Exception("Unable to get configuration for {$name}");
                        }*/
						if(!isset($port)):
							$port=0;
						endif;
						$port=($port==0)?"":":".$port;
                        $dsn = $driver . '://' . $user
                                           . ':' . $password . '@' . $host .$port
                                           . '/' . $dbname;
						try {
								$myconn =& ADONewConnection($dsn);
								if(!$myconn):
									show_error("Unable to connect to your ".$name." db server using the provided settings.
",400,"A Database Error Occurred");
									self::$dbstatus[$name]=false;
									$ci->dbstatus[$name]=false;
									return false;
									
								endif;
								self::$instances[$name]=$myconn;
                               	//self::$instances[$name] =& ADONewConnection($dsn);
								if(self::$instances[$name]){
									self::$dbstatus[$name]=true;
								}
								
                                ADODB_Active_Record::SetDatabaseAdapter(self::$instances[$name], $name);
								
                        }
                        catch(Exception $e) {
								throw new Exception($e);
							   
								show_error("Unable to connect to your ".$name." db server using the provided settings.
",400,"A Database Error Occurred");
                               self::$dbstatus[$name]=false;
								$ci->dbstatus[$name]=false;
								return false;
								//throw $e;
						}
                }
				self::$adodbx[$name]=new adodb_factory_config();
				
				$ci->dbstatus[$name]=self::$dbstatus[$name];
				$ci->connf[$name]=self::$instances[$name];
				$ci->connf[$name]->SetFetchMode(ADODB_FETCH_ASSOC);
				$ci->dbfactory[$name]=self::$adodbx[$name];
				self::$db=self::$instances[$name];
				return self::$instances[$name];
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
		$res = self::$db->GetRow($sql);
		return $res;
    }

    function Insert($table_name,$data) {
        $ret=self::$db->AutoExecute($table_name,$data,'INSERT');
        return $ret;
    }

    function Update($table_name,$data,$where) {
        $ret=self::$db->AutoExecute($table_name,$data,'UPDATE',$where);
        return $ret;
    }

    function Delete($table_name,$where="") {
		if($where!=""):
        	$sql = "delete from {$table_name} where ".$where;
        else:
			$sql = "delete from {$table_name} ";
        endif;
		$res = self::$db->Execute($sql);

        $aff = self::$db->Affected_Rows();
        if($aff !== 1) {
            //throw new MyException('ERROR_CODE_RECORD_NOT_FOUND');
        }else {
            return $aff;
        }
    }
	
	function GetAll($sql) {
        $arr=self::$db->GetAll($sql);
        return $arr;
    }

    function GetRow($sql) {
        $arr=self::$db->GetRow($sql);
        return $arr;
    }

    function GetOne($sql) {

        $ret=self::$db->GetOne($sql);
        return $ret;

    }

    function AutoExecute($table,$data,$mode,$where="") {
        if(($mode=="UPDATE")&&($where!="")):
            return self::$db->AutoExecute($table,$data,"UPDATE",$where);
        endif;

        if(($mode="INSERT")&&($mode=="")):
            return self::$db->AutoExecute($table,$data,"INSERT");
        endif;
    }

    function SelectLimit($sql,$rows,$offset) {
        $rs= self::$db->SelectLimit($sql, $rows, $offset);
        return $rs;
    }

	function GetDataType($table) {

        $sql="select * from $table";
        $data_type=array();
        $rs=self::$db->SelectLimit($sql,1,1);
        if($rs) {
            $countField=$rs->FieldCount();
            for($i=0;$i<$countField;$i++) {
                $fields=$rs->FetchField($i);
                $data_type[$fields->name]=self::$db->MetaType($fields->type);
            }
        }

        return $data_type;
    }

    public function GetHeader($table) {
        $sql="select * from $table";
        $data_type=array();
        $rs=self::$db->SelectLimit($sql,1,1);
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
        $rs=self::$db->SelectLimit($sql,1,1);
        if($rs) {
            $countField=$rs->FieldCount();
            for($i=0;$i<$countField;$i++) {
                $fields=$rs->FetchField($i);
                $data_type[$fields->name]=self::$db->MetaType($fields->type);
            }
        }

        return $data_type;
    }

    public function GetHeaderBySql($sql) {
        $sql="select * from ($sql) a";
        $data_type=array();
        $rs=self::$db->SelectLimit($sql,1,1);
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
        if(self::$db->ErrorNo()) {
            $msg = self::$db->ErrorMsg();
            return $msg;
            //throw new Exception($msg);
        }else {
            return "ok";
        }
    }

    private function _affected($res = null) {
        $aff = self::$db->Affected_Rows($res);
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
        return self::$db->MetaColumnNames($table,true);
    }

    public function Query($qry) {
        return self::$db->Execute($qry);
    }

    public function FecthQuery($qry,$assoc=1) {
        $data = array();
        if ($assoc==0)
            $ADODB_FETCH_MODE = ADODB_FETCH_NUM;
        $result = self::$db->Execute($qry);
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
        return self::$db->GenID($table);
    }

    public function NextIDPostgresql($table,$id='idx'){
        $id=$this->LastIDPostgresql($table, $id);
        return $id+1;
    }

    public function LastID() {
        return self::$db->Insert_ID();
    }

    public function LastIDPostgresql($table,$id='idx'){
        $id=self::$db->GetOne("SELECT {$id} FROM {$table} ORDER BY {$id} DESC");
        return $id;
    }

    public function TableInfo($table) {
        return self::$db->MetaColumns($table);
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
        return self::$db->Affected_Rows();
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

        $res = self::$db->GetAll($sql);
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
		$res = self::$db->GetAll($sql);
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
        $res = self::$db->GetOne($sql);
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
        $rs= self::$db->SelectLimit($sql, $rows, $offset);
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
		$rs= self::$db->SelectLimit($sql, $rows, $offset);
		while  ($data = $rs->FetchRow()) {
			$res[]=$data;
		}

		return $res;


	}
 
 //END TAMBAHAN DARI WHOGET
}