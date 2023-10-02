<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test extends CI_Controller {
    
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function bnn_helper()
	{
		//$this->load->helper("bnn");
		pre(pasien_data_all(16));
	}
	
	function scan(){
		$this->load->view("test/scan_view");
	}
	
	function status_rehab_per_bulan($tahun=false,$bulan=12,$bulan_mulai=1){
		$arrData=summary_status_rehab_per_bulan($tahun,$bulan,$bulan_mulai);
		pre($arrData);
	}
	
	function update_pasien_all_history_registrasi(){
		$arr=$this->conn->GetAll("select * from t_pasien_assesment_history");
		debug();
		foreach($arr as $x=>$val):
			$idx_pasien=$val["idx_pasien"];
			$idx_assesment=$val["idx_assesment"];
			//pre($val);
			update_pasien_all_history_registrasi($idx_pasien,$idx_assesment);
		endforeach;
	}
	
	function test_pasien_all_history(){
		$this->load->helper("lookup");
		$data["data"]=pasien_all_history(2);
		$this->load->view("test/history",$data,false);
	}
	
	function update_status_proses_in_assesment_history(){
		$arrData=$this->conn->GetAll("select * from t_pasien_all_history order by idx");
		debug();
		if(cek_array($arrData)):
			pre("test_kacang");
			$this->conn->StartTrans();
			foreach($arrData as $x=>$val):
			pre($val);
				$tgl_status_proses=$val["tgl_status_proses"];
				$idx_pasien=$val["idx_pasien"];
				$idx_assesment=$val["idx_assesment"];
				$status_rehab=$val["status_rehab"];
				
				$data_update["tgl_status_proses"]=$tgl_status_proses;
	$this->conn->AutoExecute("t_pasien_assesment_history",$data_update,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	
				if($status_rehab<=2):
					$this->conn->AutoExecute("t_pasien_monitoring_rehab",$data_update,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
				endif;
				if($status_rehab==3):
					$this->conn->AutoExecute("t_pasien_monitoring_pasca",$data_update,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
				endif;
			endforeach;
			pre("selesai");
			$this->conn->CompleteTrans();
		endif;
		pre("selesai2");
		exit();
		/*
	$data_update["tgl_status_proses"]=$tgl_status_proses;
	$CI->conn->AutoExecute("t_pasien_assesment_history",$data_update,"UPDATE","idx_pasien={$idx_pasien} and idx_assesment={$idx_assesment}");
	 */
	}
	
	/*
	function update_all_history(){
		$this->conn->StartTrans();
		$arrData=$this->conn->GetAll("select * from t_pasien_history where inst_rujuk is not null order by idx");
		//pre($arrData);
		foreach($arrData as $x=>$val):
			unset($val["idx"]);
			$dataPasien=$val;
			$dataStatus=$val;
			update_pasien_all_history($dataPasien,$dataStatus);
		endforeach;
		$arrData=$this->conn->GetAll("select * from t_pasien_history_pasca where inst_pasca is not null order by idx");
		//pre($arrData);
		foreach($arrData as $x=>$val):
			unset($val["idx"]);
			$dataPasien=$val;
			$dataStatus=$val;
			update_pasien_all_history($dataPasien,$dataStatus);
		endforeach;
		$arrData=$this->conn->GetAll("select * from t_pasien_history_lanjut where inst_lanjut is not null order by idx");
		//pre($arrData);
		foreach($arrData as $x=>$val):
			unset($val["idx"]);
			$dataPasien=$val;
			$dataStatus=$val;
			update_pasien_all_history($dataPasien,$dataStatus);
		endforeach;
		$this->conn->CompleteTrans();
	}
	*/
	
	function _add_creator($data){
        $data["created"]=date("Y-m-d H:i:s");
        $data["creator"]=$this->userdata["username"];
		//$data["creator"]=$this->data["users"]["user"]["username"];
        $data["edited"]=date("Y-m-d H:i:s");
		$data["editor"]=$this->userdata["username"];
        //$data["editor"]=$this->data["users"]["user"]["username"];
        return $data;
    }
    
    function _add_editor($data){
        $data["edited"]=date("Y-m-d H:i:s");
        //$data["editor"]=$this->data["users"]["user"]["username"];
		$data["editor"]=$this->userdata["username"];
        return $data;
    }
	
	
	/* test statistik */
	function statistik($idx_pasien=2){
		pre("get pasien status by pasien id");
		$this->load->helper("bnn_statistik");
		
		
		// pre(get_status_proses_by_pasien($idx_pasien));
		 /*
		 pre("get pasien status with outcome");
		 
		pre(get_status_proses_with_outcome_by_pasien($idx_pasien));
		pre("get pasien status by assesment");
		pre(get_status_proses_by_assesment());
		
		*/
		
		/* rekap per bulan */
		//pre(get_rekap_status_proses_per_bulan());
		//debug();
		debug();
		pre(get_rekap_status_proses_per_tahun());
		
	}
	
	/*
	function benahi_history(){
		$arrData=$this->conn->GetAll("select * from t_pasien_all_history where kd_bnn is null");
		foreach($arrData as $x=>$val):
			pre($idx_pasien);
		endforeach;
	}*/
    
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */