<?php
class Master_model extends CI_Model {

	public function __construct()
	{
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 2014 05:00:00 GMT"); 
		$this->load->database();  
	}
	
	
	public function doCreate($request)
    { 
		$sql = "SELECT idx,nama FROM m_skpd WHERE idx = -1";  
		$qry = $this->conn->Execute($sql);
		$insertSQL = $this->conn->GetInsertSQL($qry, $request);
		$this->conn->Execute($insertSQL);
	}
	
	function doEdit($id)
    {
		$sql = "SELECT idx,nama FROM m_skpd WHERE idx = $id";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	function doDelete($id)
    {
		$this->conn->Execute("DELETE FROM m_skpd WHERE idx = '$id' ");	
	}
	
	public function doUpdate($request)
    { 
		$sql = "SELECT idx,nama FROM m_skpd WHERE idx = '".$request['idx']."' ";  
		$qry = $this->conn->Execute($sql);
		$updateSQL  = $this->conn->GetUpdateSQL($qry, $request);
		$this->conn->Execute($updateSQL );
	}
}
?>