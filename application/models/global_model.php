<?php
class Global_model extends CI_Model {

	public function __construct()
	{
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 2014 05:00:00 GMT"); 
		$this->load->database();  
	}
  
	public function get_provinsi()
	{ 
		$sql = "SELECT kode_dagri, kode_wilayah, nama_wilayah, ibu_kota, parent, kategori FROM m_wilayah WHERE parent = '0'";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	public function get_provinsi_where($kd)
	{ 
		$sql = "SELECT kode_dagri, kode_wilayah, nama_wilayah, ibu_kota, parent, kategori FROM m_wilayah WHERE kode_dagri = '$kd'";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	public function search_provkab($search_scr)
	{ 
		$sql = "SELECT kode_dagri, nama_wilayah FROM m_wilayah WHERE nama_wilayah LIKE '%".$search_scr."%' LIMIT 1";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	public function search_jeniskerja($search_scr)
	{ 
		$sql = "SELECT kd_jk, nm_jk FROM m_jeniskerjasama WHERE nm_jk LIKE '%".$search_scr."%' LIMIT 1";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	public function get_kabupaten()
	{ 
		$sql = "SELECT kode_dagri, kode_wilayah, nama_wilayah, ibu_kota, parent, kategori FROM m_wilayah WHERE parent != '0'";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	public function get_potensi()
	{ 
		$sql = "SELECT id, kd_potensi, nm_potensi, parent FROM m_potensi WHERE parent = '0'";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	public function search_pot($search_scr)
	{ 
		$sql = "SELECT id, kd_potensi, nm_potensi, parent FROM m_potensi WHERE nm_potensi LIKE '%".$search_scr."%' LIMIT 1";
		$query = $this->conn->GetAll($sql);
		return $query;
	}

	public function get_spotensi() //parent != 0
	{ 
		$sql = "SELECT id, kd_potensi, nm_potensi, parent FROM m_potensi WHERE parent != '0'";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	public function getSpotensi($id) //parent = $id
	{ 
		$sql = "SELECT id, kd_potensi, nm_potensi, parent FROM m_potensi WHERE parent = '$id'";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	//ketinggalan
	function get_city_by_state($kode) 
	{
		$query = $this->db->get_where('m_wilayah', array('parent' => $kode));
		if ($query->num_rows() > 0) return $query->result_array();             
	}
	
	function get_jenispotensi($kode) 
	{
		$sql = "SELECT id, kd_potensi, nm_potensi, parent FROM m_potensi WHERE parent = '$kode' ";
		$query = $this->conn->GetAll($sql);
		return $query;        
	}
	
	public function get_kerja_daerah()
	{ 
		$sql = "SELECT id,kd_jk, nm_jk FROM m_jeniskerjasama";
		$query = $this->conn->GetAll($sql);
		return $query;
	}

}
?>