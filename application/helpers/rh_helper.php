<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function rh_pasien($idx_pasien){
	
		$CI 	=	& get_instance();
		$sql	=	"
					select
					a.idx as id_assesment,
					a.tgl_kedatangan,
					a.masalah_medis,
					a.masalah_pekerjaan,
					a.masalah_napza,
					a.masalah_legal,
					a.masalah_keluarga,
					a.masalah_psikiatris,
					a.diagnosis_napza,
					a.diagnosis_lain,
					a.rencana_terapi_resume,
					b.*,
					c.*,
					c.status_proses as status_proses_rehab,
					c.status_program as status_program_rehab,
					d.*,
					d.status_program as status_program_pasca,
					d.outcome_pasien as outcome_pasien_pasca,
					d.status_proses as status_proses_pasca,
					e.keterangan as keterangan_diagnosis_napza
					
					from t_pasien_assesment_summary a
					
					left join t_pasien_assesment_history b
					on a.idx=b.idx_assesment
					
					left join t_pasien_monitoring_rehab c
					on a.idx=c.idx_assesment
					
					left join t_pasien_monitoring_pasca d
					on a.idx=d.idx_assesment
					
					left join m_diagnosa_kerja e
					on a.diagnosis_napza=e.kode
					
					where a.idx_pasien='$idx_pasien'
					
					order by a.idx asc
					";
		
		$arrHistoryRh		=	$CI->conn->GetAll($sql);
		
		foreach($arrHistoryRh as $k=>$v):
			if($v['status_proses_pasca']=="PRRLPUTU"):
				$arrHistoryRh[$k]['hasil_tes_urin']	=	$CI->conn->GetAll("select * from t_pasien_pasca_pu_history where idx_pasien='".$v['idx_pasien']."' and idx_assesment='".$v['id_assesment']."'");
			elseif($v['status_proses_pasca']=="PRRLPDTU"):
				$arrHistoryRh[$k]['hasil_tes_urin']	=	$CI->conn->GetAll("select * from t_pasien_pasca_du_history where idx_pasien='".$v['idx_pasien']."' and idx_assesment='".$v['id_assesment']."'");
			endif;
		endforeach;
		
		$rh['history_rh']	=	$arrHistoryRh;
		$rh['total_rh']		=	$CI->conn->GetOne("select count(idx) from t_pasien_assesment_summary where idx_pasien='$idx_pasien'");
		
		return $rh;

	}

	function rh_pasien_rev($idx_pasien,$idx_assesment){
	
		$CI 	=	& get_instance();
		$sql	=	"
					select
					a.idx as id_assesment,
					a.tgl_kedatangan,
					a.masalah_medis,
					a.masalah_pekerjaan,
					a.masalah_napza,
					a.masalah_legal,
					a.masalah_keluarga,
					a.masalah_psikiatris,
					a.diagnosis_napza,
					a.diagnosis_lain,
					a.rencana_terapi_resume,
					b.*,
					c.*,
					c.status_proses as status_proses_rehab,
					c.status_program as status_program_rehab,
					d.*,
					d.status_program as status_program_pasca,
					d.outcome_pasien as outcome_pasien_pasca,
					d.status_proses as status_proses_pasca,
					e.keterangan as keterangan_diagnosis_napza
					
					from t_pasien_assesment_summary a
					
					left join t_pasien_assesment_history b
					on a.idx=b.idx_assesment
					
					left join t_pasien_monitoring_rehab c
					on a.idx=c.idx_assesment
					
					left join t_pasien_monitoring_pasca d
					on a.idx=d.idx_assesment
					
					left join m_diagnosa_kerja e
					on a.diagnosis_napza=e.kode
					
					where a.idx_pasien='$idx_pasien' and a.idx='".$idx_assesment."'
					
					order by a.idx asc
					";
		
		$arrHistoryRh		=	$CI->conn->GetAll($sql);
		
		foreach($arrHistoryRh as $k=>$v):
			if($v['status_proses_pasca']=="PRRLPUTU"):
				$arrHistoryRh[$k]['hasil_tes_urin']	=	$CI->conn->GetAll("select * from t_pasien_pasca_pu_history where idx_pasien='".$v['idx_pasien']."' and idx_assesment='".$v['id_assesment']."'");
			elseif($v['status_proses_pasca']=="PRRLPDTU"):
				$arrHistoryRh[$k]['hasil_tes_urin']	=	$CI->conn->GetAll("select * from t_pasien_pasca_du_history where idx_pasien='".$v['idx_pasien']."' and idx_assesment='".$v['id_assesment']."'");
			endif;
		endforeach;
		
		$rh['history_rh']	=	$arrHistoryRh;
		$rh['total_rh']		=	$CI->conn->GetOne("select count(idx) from t_pasien_assesment_summary where idx_pasien='$idx_pasien'");
		
		return $rh;

	}