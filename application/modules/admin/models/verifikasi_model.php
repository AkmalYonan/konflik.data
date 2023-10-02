<?php
class Verifikasi_model extends CI_Model {

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
		$sql = "SELECT pangkat,no_sk_ppns,no_ktp,berlaku_ktp,uu_dikawal,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,propinsi,kabupaten,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan FROM sppp_data_pegawai WHERE idx_pegawai = -1";  
		$qry = $this->conn->Execute($sql);
		$insertSQL = $this->conn->GetInsertSQL($qry, $request);
		$this->conn->Execute($insertSQL);
	}
	
	function doEdit($id)
    {
		$sql = "SELECT pangkat,no_sk_ppns,no_ktp,berlaku_ktp,uu_dikawal,idx,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,propinsi,kabupaten,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan,status,skpd FROM sppp_data_pegawai WHERE idx = $id";
		$query = $this->conn->GetAll($sql);
		return $query;
	}
	
	public function doSelect($num,$offset)
    { 
		if((!empty($num)) || (!empty($offset))){ 
			$query = $this->conn->Execute("SELECT pangkat,no_sk_ppns,no_ktp,berlaku_ktp,uu_dikawal,idx_pegawai,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,propinsi,kabupaten,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan FROM sppp_data_pegawai WHERE status = 1 GROUP BY nip ORDER BY idx_pegawai DESC LIMIT $offset,$num");
		}else{
			$query = $this->conn->Execute("SELECT pangkat,no_sk_ppns,no_ktp,berlaku_ktp,uu_dikawal,idx_pegawai,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,golongan_darah_rhesus,propinsi,kabupaten,tmt_pegawai_masuk,status_pegawai,no_sk_pangkat,pendidikan_terakhir,alamat,keterangan FROM sppp_data_pegawai WHERE status = 1 GROUP BY nip ORDER BY idx_pegawai DESC");
		}
		return $query;
    }
	
	public function uploadDoc($request)
    { 
			$sql = "SELECT tanggal_sp,nip,dokumen,no_sk_ppns,no_ktp,idx_pegawai,no_surat,jenis_berkas,flag FROM dokumen_sppp_data_pegawai WHERE idx = -1";  
			//pre($request);exit;
			$qry = $this->conn->Execute($sql);
			$insertSQL = $this->conn->GetInsertSQL($qry, $request);
			$this->conn->Execute($insertSQL);
	}
	
	public function updateDoc($request)
    { 
		$sql = "SELECT idx_pegawai,no_surat,flag,dokumen,tanggal_sp,tanggal_post FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = '".$request['id_pegawai']."' AND flag = '".$request['flag']."' ";  
		$qry = $this->conn->Execute($sql);
		$updateSQL  = $this->conn->GetUpdateSQL($qry, $request);
		$this->conn->Execute($updateSQL );
	}
	
	public function updateDok($request)
    { 
		$sql = "SELECT idx_pegawai,no_surat,flag,dokumen,jenis_berkas FROM dokumen_sppp_data_pegawai WHERE idx = '".$request['id']."' AND flag = '".$request['flag']."' AND jenis_berkas = '".$request['jenis_berkas']."' ";  
		$qry = $this->conn->Execute($sql);
		$updateSQL  = $this->conn->GetUpdateSQL($qry, $request);
		$this->conn->Execute($updateSQL );
	}
	
	public function getDocNew($id,$fg)
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' ORDER BY idx ASC LIMIT 1");
		return $query;
    }
	
	public function getDoc($id,$fg)
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' ORDER BY idx ASC LIMIT 1");
		return $query;
    }
	
	public function getOneDoc($id,$fg,$jb)
    { 
		$query = $this->conn->GetAll("SELECT idx,idx_pegawai,no_surat,flag,dokumen FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = '$id' AND flag = '$fg' AND jenis_berkas = '$jb' ");
		return $query;
    }
	
	public function getBerkas($id)
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx = $id");
		return $query;
    }
	
	public function m_berkas()
    { 
		$query = $this->conn->GetAll("SELECT id,kode,nm_berkas FROM m_jenis_berkas");
		return $query;
    }
	
	public function doPublish($id_enc,$status_enc,$flag_enc)
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
	
	public function changeStatus($id_enc,$status_dok,$flag_enc,$ket)
	{
		if($status_dok == 4){
			$stt=0;
			if($ket==''):
				$ket='-';
			else:
				$ket=$ket;
			endif;
		}elseif($status_dok == 3){
			$stt=2;
			if($ket==''):
				$ket='-';
			else:
				$ket=$ket;
			endif;
		}else{
			$stt=1;
			if($ket==''):
				$ket='-';
			else:
				$ket=$ket;
			endif;	
		}
		if($flag_enc=='a'){
			$choice = "status = $stt,posisi='$flag_enc'";
		}elseif($flag_enc=='b'){
			$choice = "stt_kumham = $stt,posisi='$flag_enc'";
		}elseif($flag_enc=='c'){
			$choice = "stt_diklat = $stt,posisi='$flag_enc'";
		}elseif($flag_enc=='d'){
			$choice = "stt_polri = $stt,posisi='$flag_enc'";
		}elseif($flag_enc=='e'){
			$choice = "stt_kejagung = $stt,posisi='$flag_enc'";
		}elseif($flag_enc=='f'){
			$choice = "stt_skep = $stt,posisi='$flag_enc'";
		}elseif($flag_enc=='g'){
			$choice = "stt_pelantikan = $stt,posisi='$flag_enc'";
		}
		$sql = "UPDATE sppp_data_pegawai
								   SET $choice
								   WHERE idx = $id_enc "; 
		$query = $this->conn->Execute($sql);
		$datetime=date("Y-m-d H:i:s");
		$query_log = $this->conn->Execute("insert into log_alur_verifikasi (tanggal,idx_pegawai,flag,status,status_dok,keterangan) 
		values ('$datetime','$id_enc','$flag_enc','$stt','$status_dok','$ket')");
		
	}
	
	public function m_berkas2()
    { 
		$query = $this->conn->GetAll("SELECT kode,nm_berkas FROM m_jenis_berkas WHERE kode != 'b7' ");
		return $query;
    }
	
	public function doSelectSeacrh($num,$offset,$provinsi_scr,$kabupaten_scr,$nip_scr)
    { 
		$query = $this->conn->GetAll("SELECT idx_pegawai,nip,nama,jenis_kelamin,gelar_depan,gelar_belakang,
									foto,tempat_lahir,tanggal_lahir,agama,status_perkawinan,golongan_darah,
									golongan_darah_rhesus,id_org_unit,tmt_pegawai_masuk,status_pegawai,
									no_sk_pangkat,pendidikan_terakhir,alamat,keterangan,propinsi,kabupaten FROM sppp_data_pegawai
									WHERE status = 1 AND propinsi like '%".$provinsi_scr."%' AND kabupaten like '%".$kabupaten_scr."%' AND (nip like '%".$nip_scr."%' OR nama like '%".$nip_scr."%') GROUP BY nip ORDER BY idx_pegawai DESC LIMIT $offset,$num");
		return $query;
    }
	
	function doDelete_berkas($id)
    {
		$this->conn->Execute("DELETE FROM dokumen_sppp_data_pegawai WHERE idx = $id ");	
	}
	
	public function countFlagNew($id)
    { 
		$query = $this->conn->GetAll("SELECT idx,dokumen,nip,nm_file,idx_pegawai,cek FROM berkas_sppp_data_pegawai WHERE idx_pegawai = $id  AND nm_file != 'b7' ");
		return $query;
    }
	
	public function countFlag($id,$fg)
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas != 'b7' ");
		return $query;
    }
	
	//count b1
	public function countSTTb1($id,$fg='a',$kd_berkas='b1')
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//count b2
	public function countSTTb2($id,$fg='a',$kd_berkas='b2')
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//count b3
	public function countSTTb3($id,$fg='a',$kd_berkas='b3')
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//count b4
	public function countSTTb4($id,$fg='a',$kd_berkas='b4')
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//count b5
	public function countSTTb5($id,$fg='a',$kd_berkas='b5')
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//count b6
	public function countSTTb6($id,$fg='a',$kd_berkas='b6')
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//count b7
	public function countSTTb7($id,$fg='a',$kd_berkas='b7')
    { 
		$query = $this->conn->GetAll("SELECT dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//get b1
	public function getSTTb1($id,$fg,$kd_berkas='')
    { 
		$query = $this->conn->GetAll("SELECT tanggal_sp,dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//get b2
	public function getSTTb2($id,$fg,$kd_berkas='')
    { 
		// debug();
		$query = $this->conn->GetAll("SELECT tanggal_sp,dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//get b3
	public function getSTTb3($id,$fg,$kd_berkas='')
    { 
		$query = $this->conn->GetAll("SELECT tanggal_sp,dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//get b4
	public function getSTTb4($id,$fg,$kd_berkas='')
    { 
		$query = $this->conn->GetAll("SELECT tanggal_sp,dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//get b5
	public function getSTTb5($id,$fg,$kd_berkas='')
    { 
		$query = $this->conn->GetAll("SELECT tanggal_sp,dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//get b6
	public function getSTTb6($id,$fg,$kd_berkas='')
    { 
		$query = $this->conn->GetAll("SELECT tanggal_sp,dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//get b7
	public function getSTTb7($id,$fg,$kd_berkas='')
    { 
		$query = $this->conn->GetAll("SELECT tanggal_sp,dokumen,no_sk_ppns,no_ktp,idx_pegawai,nip,idx,no_surat,jenis_berkas,flag,checks FROM dokumen_sppp_data_pegawai WHERE idx_pegawai = $id AND flag = '".$fg."' AND jenis_berkas = '".$kd_berkas."' ");
		return $query;
    }
	
	//get all
	public function getBerkasAll($id)
    { 
		$query = $this->conn->GetAll("SELECT idx_pegawai,jenis_berkas FROM dokumen_sppp_data_pegawai WHERE jenis_berkas != 'b7' AND flag = 'a' AND idx_pegawai = '".$id."' GROUP BY idx_pegawai,jenis_berkas");
		
		return $query;
    }
	
	public function getBerkasAllNew($id)
    { 
		$query = $this->conn->GetAll("SELECT idx,dokumen,nip,nm_file,idx_pegawai,cek FROM berkas_sppp_data_pegawai WHERE nm_file != 'b7' AND idx_pegawai = '".$id."' GROUP BY idx_pegawai,nm_file");
		
		return $query;
    }
}
?>