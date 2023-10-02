<?php
class Lat_auth_Model extends CI_Model {
	/**
	 * Set Table Name Here
	 */
	function __construct($tbl=false){
		parent::__construct();
		$this->load->helper('cookie');
		
		$this->appname =$this->config->item("appname","lat_auth");
		$this->identity=$this->config->item("identity","lat_auth");
		$this->password=$this->config->item("password","lat_auth");
		
		$this->tables=$this->config->item("tables","lat_auth");

		$this->hash_method=$this->config->item("hash_method","lat_auth");
		$this->default_rounds=$this->config->item("default_rounds","lat_auth");
		$this->salt_length=$this->config->item("salt_length","lat_auth");
		$this->store_salt=$this->config->item("store_salt","lat_auth");

	
		if ($this->hash_method == 'bcrypt') {
			$rounds = array('rounds' => $this->default_rounds);
			$this->load->library('bcrypt',$rounds);
		}
	}
	
	public function hash_password($password, $salt=false)
	{
		if (empty($password))
		{
			return FALSE;
		}

		//bcrypt
		if ($this->hash_method == 'bcrypt')
		{
			return $this->bcrypt->hash($password);
		}
		if ($this->store_salt && $salt) {
			return hash($this->hash_method, $password.$salt);
		}
		else {
			$salt = $this->salt();
			return  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}
	}

	public function hash_password_check($id, $password)
	{
		//$saltx= $this->salt();
		//pre($saltx);
		//echo $this->hash_password($password, $saltx);
		
		if (empty($id) || empty($password))
		{
			return FALSE;
		}

		$sql 	= "select ".$this->password.",salt FROM ".$this->tables["user"]." WHERE id=?";
		$res 	= $this->conn->GetRow($sql,array($id));

		$password_db = $res['password'];
		$salt_db = $res['salt'];
		if (!cek_array($res))
		{
			return FALSE;
		}

		// bcrypt
		if ($this->hash_method == 'bcrypt')
		{
			
			if ($this->bcrypt->verify($password,$password_db))
			{
				//pre("KO");
				return true;
			}

			return false;
		}
		
		// sha1
		if ($this->store_salt)
		{
			$password_in = hash($this->hash_method, $password.$salt_db);
		}
		else
		{
			$salt = substr($password_db, 0, $this->salt_length);
			$password_in =  $salt . substr(hash($this->hash_method, $salt.$password), 0, -$this->salt_length);
		}

		if($password_in == $password_db)
		{
			//pre($password_in);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	function exist_check($input = '',$exception_id=false)
	{
		if (empty($input))
		{
			return FALSE;
		}
		$data[]=$input;
		if ($exception_id) {
			$ex_sql=" and id<>?";
			$data[]=$exception_id;
		}
		return $this->conn->GetOne("select count(".$this->identity.") from ".$this->tables["user"]." where ".$this->identity."=?".$ex_sql,$data);
	}
	function get_last_id($id_txt=false) {
		$idx=$id_txt?$id_txt:"idx";
		
		$sql = "select max($idx) as value from ".$this->tables["user"];
		return $this->conn->GetOne($sql);	
	}
	function salt()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';    
			
		for ($p = 0; $p < $this->salt_length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}
			
		return $string;
	}
	
	public function login($identity, $password, $remember=FALSE)
	{
		if (empty($identity) || empty($password))
		{
			$this->set_error('login_unsuccessful');
			return FALSE;
		}
		$sql 	= "select ".$this->identity.",username,email,id,password,active,last_login FROM ".$this->tables["user"]." WHERE ".$this->identity."=?";
		$res 	= $this->conn->GetRow($sql,array($identity));
		
		
		if (cek_array($res)) {
			$password = $this->hash_password_check($res['id'], $password);
			
			if ($password) {
				if ($res['active']==0) {
					set_message("error","Account Not Active!");
					return false;	
				}
				
				$this->set_session($res);
				$this->update_last_login($res['id']);
				//check remembered login
				if ($remember && $this->config->item("remember_me","lat_auth")) {
					$this->remember_me($res);
				}
				//exit;
				//set message
				return true;
			}
		}
		
		set_message("error","Login failed!");		
		return false;
	}
	public function register($data)
	{
		//debug();
		if ($this->identity == 'email' && $this->exist_check($data['email']))
		{
			set_message("error","Email sudah ada!");
			return FALSE;
		}
		elseif ($this->identity == 'username' && $this->exist_check($data['username']))
		{
			set_message("error","Username sudah ada!");
			return FALSE;
		}
		if ($data['password']!=$data['confirm_password'])
		{
			set_message("error","Password & Konfirmasi Password Berbeda!");
			return FALSE;
		}

		$salt = $this->store_salt ? $this->salt() : FALSE;

		//$data=$this->_add_creator($data);
		$data['active'] 			= $data['active']?1:0;
		$data['password'] 			= $this->hash_password($data['password'], $salt);
		$data['created_on'] 		= time();
		$data['last_login'] 		= time();
		
		if ($this->store_salt)
		{
			$data['salt'] = $salt;
		}

		$this->conn->StartTrans();
		$this->adobx->Insert($this->tables["user"], $data);

		$id = $this->get_last_id('id');
		$groups = $data['group_id'];
		if (!empty($groups))
		{
			//add to groups
			$this->add_to_group($groups,$id);
		}
		
		if ($this->conn->CompleteTrans()) {
			set_message("success","User Baru berhasil ditambahkan");
		}

		return (isset($id)) ? $id : FALSE;
	}
	
	//POST LOGIN
	public function set_session($user)
	{
		session_regenerate_id();
		$_SESSION[$this->appname]["userdata"]=$user;
		$_SESSION[$this->appname]["userdata"]["user_id"]=$user[$this->identity];
		$_SESSION[$this->appname]["groupdata"]=$this->get_users_groups($user["id"]);
		
		//pre($_SESSION[$this->appname]);
		return TRUE;
	}
	public function update_last_login($id)
	{
		$data['last_login'] = time();
		return $this->adodbx->Update($this->tables["user"],$data,"id=$id");
	}
	
	public function _total_where($tbl,$where=false,$selected_column='id'){
		if ($where): 
			$where=" where ".$where;
		endif;
		$sql = "select count($selected_column) as total from ".$tbl.$where;
		return $this->conn->GetOne($sql);	
	}
	
	public function remember_me($user)
	{
		if(!cek_array($user))
		{
			return FALSE;
		}
		//debug();
		//set remember code useing SH1
		$code = sha1($user['password']);
		$data['remember_code'] = $code;
		if ($this->adodbx->Update($this->tables["user"],$data,"id=".$user['id'])) {
			//if set 0 using 14 days
			if($this->config->item('remember_expire', 'lat_auth') === 0) {
				$expire = (60*60*24*14);
			}
			else {
				$expire = $this->config->item('remember_expire', 'lat_auth');
			}

			set_cookie(array(
			    'name'   => 'identity',
			    'value'  => $user[$this->identity],
			    'expire' => $expire
			));

			set_cookie(array(
			    'name'   => 'remember_code',
			    'value'  => $code,
			    'expire' => $expire
			));

			return true;
		}
	}
	
	public function login_remembered_user()
	{
		if (!get_cookie('identity') || !get_cookie('remember_code'))
		{
			return false;
		}

		$sql 	= "select ".$this->identity.",username,email,id,password,active,last_login FROM ".$this->tables["user"]." WHERE ".$this->identity."=? and remember_code=?";
		$res 	= $this->conn->GetRow($sql,array(get_cookie('identity'),get_cookie('remember_code')));
		
		
		if (cek_array($res)) {
			if ($res['active']==0) {
				return false;	
			}
			
			$this->update_last_login($res['id']);
			$this->set_session($res);

			//check extend remembered login
			if ($this->config->item("remember_extend","lat_auth")) {
				$this->remember_me($res);
			}
			return true;
		}
		return false;
	}
	
	
	//USER
	public function user($id = NULL)
	{
		//if no id was passed use the current users id
		$id || $id = $_SESSION[$this->appname]["userdata"]["user_id"];
		$user = $this->adodbx->GetRecord($this->tables["user"],"id=".($this->encrypt_status==TRUE?decrypt($id):$id));
		$user['groups_ids']=$this->get_users_groups($user['id'],true);
		$user['groups']=$this->get_users_groups($user['id']);
		return $user;
	}
	
	public function users($where=false,$rows=false,$offset=false,$sort='',$dataColumn=false)
	{
		$res = $this->adodbx->search_record_by_limit_where($this->tables["user"],$where,$rows,$offset,$sort,$dataColumn);
		if(cek_array($res)):
			foreach($res as $k=>$v):
				$res[$k]["groups"]=$this->get_users_groups($v["id"]);
			endforeach;
		endif;
		return $res;
	}
	
	public function total_users($where=false)
	{
		return $this->_total_where($this->tables["user"],$where,'id');
	}
	
	public function update_user($id,$data)
	{
		pre($id);pre($data);
		debug();
		$id=$this->encrypt_status==TRUE?decrypt($id):$id;
		if ($this->identity == 'email' && $this->exist_check($data['email'],$id))
		{
			set_message("error","Email sudah ada!");
			return FALSE;
		}
		elseif ($this->identity == 'username' && $this->exist_check($data['username'],$id))
		{
			set_message("error","Username sudah ada!");
			return FALSE;
		}
		if ($data['password']) {
			if ($data['password']!=$data['confirm_password'])
			{
				set_message("error","Password & Konfirmasi Password Berbeda!");
				return FALSE;
			}
			$salt = $this->store_salt ? $this->salt() : FALSE;
			$data['password'] = $this->hash_password($data['password'], $salt);
			
			if ($this->store_salt)
			{
				$data['salt'] = $salt;
			}
		}

		$data['id'] = $id;
		$data['active'] = $data['active']?1:0;
		

		$this->conn->StartTrans();
		$this->adobx->Update($this->tables["user"], $data, "id=$id");

		$groups = $data['group_id'];
		if (!empty($groups))
		{
			//clean user from group if exist
			$this->remove_from_group('',$id);
			//add to groups
			$this->add_to_group($groups,$id);
		}
		
		if ($this->conn->CompleteTrans()) {
			set_message("success","Update User berhasil");
		}

		return (isset($id)) ? $id : FALSE;
	}
	public function delete_user($id,$data)
	{
		$id=$this->encrypt_status==TRUE?decrypt($id):$id;
		if ($this->identity == 'email' && !$this->exist_check($data['email']))
		{
			set_message("error","Email Tidak ditemukan!");
			return FALSE;
		}
		elseif ($this->identity == 'username' && !$this->exist_check($data['username']))
		{
			set_message("error","Username tidak ditemukan!");
			return FALSE;
		}

		$this->conn->StartTrans();
		if ($this->adobx->Delete($this->tables["user"], "id=$id")) {
			$this->remove_from_group('',$id);
		}
		
		if ($this->conn->CompleteTrans()) {
			set_message("success","User berhasil dihapus");
		}

		return (isset($id)) ? $id : FALSE;
	}
	
	//GROUPS
	function groups($key=false,$val=false) {
		$arrDB=$this->conn->GetAll("select * from ".$this->tables["group"]); 
		if (!$key && !$val) {
		 	return $arrDB;
		}
		else {
			 if (cek_array($arrDB)) {
				foreach($arrDB as $k=>$v) {
					$arr[$v[$key]]=	$v[$val];
				}
				return $arr;
			 }
		}
	}
	function get_users_groups($user_id,$array_id=false) 
	{
		$res = $this->conn->GetAll("select * from ".$this->tables["user_groups"]." a left join ".$this->tables["group"]." b on a.group_id=b.id where a.user_id=".$user_id); 
		if ($array_id) {
			if(cek_array($res)) {
				foreach($res as $v) {
					$arr[]=$v['id'];
				}
				return $arr;
			}
		}
		return $res;
	}
	
	public function add_to_group($group_ids, $user_id=false)
	{
		if(empty($user_id))
		{
			return FALSE;
		}
		
		// if group id(s) are passed remove user from the group(s)
		if( ! empty($group_ids))
		{
			if(!cek_array($group_ids))
			{
				$group_ids = array($group_ids);
			}

			foreach($group_ids as $group_id)
			{
				$data["user_id"]=$user_id;
				$data["group_id"]=$group_id;
				
				$this->adodbx->Insert($this->tables["user_groups"],$data);
			}

			return TRUE;
		}
		return false;
	}
	public function remove_from_group($group_ids=false, $user_id=false)
	{
		if(empty($user_id))
		{
			return FALSE;
		}

		// if group id(s) are passed remove user from the group(s)
		if( ! empty($group_ids))
		{
			if(!cek_array($group_ids))
			{
				$group_ids = array($group_ids);
			}

			foreach($group_ids as $group_id)
			{
				$this->adodbx->Delete($this->tables["user_groups"],"group_id=$group_id and user_id=$user_id");
			}

			$return = TRUE;
		}
		// otherwise remove user from all groups
		else
		{
			$this->adodbx->Delete($this->tables["user_groups"],"user_id=$user_id");
		}
		return $return;
	}
}
//semoga kita bisa mengontrol sisi manusia kita pada saatnya dihadapkan cobaan seperti mereka