<?php
class Pegawai_model extends CI_Model {

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
		$sql = "SELECT skpd,email,berlaku_pegawai,pangkat,no_sk_ppns,no_ktp,berlaku_ktp,uu_dikawal,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,propinsi,kabupaten,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan FROM sppp_data_pegawai WHERE idx = -1";  
		$qry = $this->conn->Execute($sql);
		$insertSQL = $this->conn->GetInsertSQL($qry, $request);
		$this->conn->Execute($insertSQL);
	}
	
	function doEdit($id)
    {
		$sql = "SELECT skpd,email,berlaku_pegawai,pangkat,no_sk_ppns,no_ktp,berlaku_ktp,uu_dikawal,idx,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,propinsi,kabupaten,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan FROM sppp_data_pegawai WHERE idx = $id";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	function doDelete($id)
    {
		$this->conn->Execute("DELETE FROM sppp_data_pegawai WHERE idx = '$id' ");	
	}
	
	public function doUpdate($request)
    { 
		$sql = "SELECT skpd,email,berlaku_pegawai,pangkat,no_sk_ppns,no_ktp,berlaku_ktp,uu_dikawal,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,propinsi,kabupaten,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan FROM sppp_data_pegawai WHERE idx = '".$request['idx']."' ";  
		$qry = $this->conn->Execute($sql);
		$updateSQL  = $this->conn->GetUpdateSQL($qry, $request);
		$this->conn->Execute($updateSQL );
	}
									
	public function doSelect($num,$offset)
    { 
		if((!empty($num)) || (!empty($offset))){ 
			$query = $this->conn->Execute("SELECT skpd,status,email,berlaku_pegawai,pangkat,no_sk_ppns,no_ktp,berlaku_ktp,uu_dikawal,id_pegawai,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,propinsi,kabupaten,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan FROM sppp_data_pegawai GROUP BY nip ORDER BY id_pegawai DESC LIMIT $offset,$num");
		}else{
			$query = $this->conn->Execute("SELECT skpd,status,email,berlaku_pegawai,pangkat,no_sk_ppns,no_ktp,berlaku_ktp,uu_dikawal,id_pegawai,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,propinsi,kabupaten,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan FROM sppp_data_pegawai GROUP BY nip ORDER BY id_pegawai DESC");
		}
		return $query;
    }
	
	public function doSelectSeacrh($num,$offset,$provinsi_scr,$kabupaten_scr,$nip_scr)
    { 
		$query = $this->conn->Execute("SELECT skpd,status,email,berlaku_pegawai,id_pegawai,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,
									foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,
									golongan_darah_rhesus,id_org_unit,tmt_pegawai_masuk,status_pegawai,
									no_sk_pangkat,pendidikan_terakhir,alamat,keterangan,propinsi,kabupaten FROM sppp_data_pegawai
									WHERE propinsi like '%".$provinsi_scr."%' AND kabupaten like '%".$kabupaten_scr."%' AND (nip like '%".$nip_scr."%' OR nama like '%".$nip_scr."%' OR status_pegawai like '".$nip_scr."%' OR status like '%".$nip_scr."%') GROUP BY nip ORDER BY id_pegawai DESC LIMIT $offset,$num");
		return $query;
    }
	
	public function uploadDoc($request)
    { 
		$sql = "SELECT nm_file,nip,dokumen,idx_pegawai,idx FROM berkas_sppp_data_pegawai WHERE idx = -1";  
		$qry = $this->conn->Execute($sql);
		$insertSQL = $this->conn->GetInsertSQL($qry, $request);
		$this->conn->Execute($insertSQL);
	}
	
	public function getDoc($id)
    { 
		$query = $this->conn->GetAll("SELECT cek,dokumen,nm_file,idx_pegawai,nip,idx FROM berkas_sppp_data_pegawai WHERE idx_pegawai = $id");
		return $query;
    }
	
	public function get_golongan()
	{ 
		$sql = "SELECT keterangan FROM m_golongan_pns";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	public function getBerkas($id)
    { 
		$query = $this->conn->Execute("SELECT dokumen,nm_file,idx_pegawai,nip,idx FROM berkas_sppp_data_pegawai WHERE idx = $id");
		return $query;
    }
	
	function doDelete_berkas($id)
    {
		$this->conn->Execute("DELETE FROM berkas_sppp_data_pegawai WHERE idx = $id ");	
	}
	
	public function doPublish($id_enc,$status_enc,$flag_enc,$status_dok,$tgl)
	{
		
		if($status_dok == 4){
			$stt=0;
		}elseif($status_dok == 3){
			$stt=2;
		}else{
			$stt=1;	
		}
		if($flag_enc=='a'){
			$choice = "status = $stt,tanggal_pengajuan='$tgl'";
		}elseif($flag_enc=='b'){
			$choice = "stt_kumham = $stt";
		}elseif($flag_enc=='c'){
			$choice = "stt_diklat = $stt";
		}elseif($flag_enc=='d'){
			$choice = "stt_polri = $stt";
		}elseif($flag_enc=='e'){
			$choice = "stt_kejagung = $stt";
		}elseif($flag_enc=='f'){
			$choice = "stt_skep = $stt";
		}elseif($flag_enc=='g'){
			$choice = "stt_pelantikan = $stt";
		}
		
		$sql = "UPDATE sppp_data_pegawai
								   SET $choice
								   WHERE idx = $id_enc "; 
		$query = $this->conn->Execute($sql);
		$datetime=date("Y-m-d H:i:s");
		$status_doc=1;
		$query_log = $this->conn->Execute("insert into log_alur_verifikasi (tanggal,idx_pegawai,flag,status,status_dok,keterangan) 
		values ('$datetime','$id_enc','$flag_enc','$stt','$status_doc','-')");
		
	}
	
	public function zzz_doPublish($id_enc,$status_enc,$flag_enc)
	{
		$stt=1;
		$sql = "UPDATE sppp_data_pegawai
								   SET status = $stt
								   WHERE idx = $id_enc "; 
		$query = $this->conn->Execute($sql);
		$datetime=date("Y-m-d H:i:s");
		$status_doc=1;
		$query_log = $this->conn->Execute("insert into log_alur_verifikasi (tanggal,idx_pegawai,flag,status,status_dok,keterangan) 
		values ('$datetime','$id_enc','$flag_enc','$stt','$status_doc','-')");
		
	}
  
	public function doUnpublish($id)
	{
		$sql = "UPDATE sppp_data_pegawai
								   SET status = '0'
								   WHERE idx = $id ";
		$query = $this->conn->Execute($sql);
	} 
	
	public function getLog($id,$fg)
    { 
		$query = $this->conn->GetAll("SELECT idx,tanggal,idx_pegawai,flag,status,status_dok,keterangan FROM log_alur_verifikasi WHERE idx_pegawai = $id and flag='$fg' order by idx desc");
		return $query;
    }
}
?>