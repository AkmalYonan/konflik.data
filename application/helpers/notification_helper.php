<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function offline_notification($index=2){
        
        $CI 	    =	& get_instance();
        
        $where_sql  =   "where flag_notification='1'";
        $and        =   " and ";
        
        if($index):
            $where_sql  .=  $and."status_rehab='".$index."'";
            $and        =   " and ";   
        endif;
        
        if($CI->user_prop):
            if($CI->user_instansi):
                if($index==2):
                    $where_sql	.=	$and."inst_rujuk='".$CI->user_instansi."' and rujuk_rehab='".$CI->user_org."'";
                elseif($index==3):
                    $where_sql	.=	$and."inst_pasca='".$CI->user_instansi."' and rujuk_pasca='".$CI->user_org."'";
                endif;
            endif;
        endif;
        
        $sql        =   "select count(idx) from t_pasien ".$where_sql;           
        $total      =   $CI->conn->GetOne($sql);   
        
        return $total;
        
    }

	function offline_notification_inap($index=2){
        
        $CI 	    =	& get_instance();
        
        $where_sql  =   "where flag_notification='1'";
        $and        =   " and ";
        
        if($index):
            $where_sql  .=  $and."status_rehab='".$index."' and status_proses='RIRMDT'";
            $and        =   " and ";   
        endif;
        
        if($CI->user_prop):
            if($CI->user_instansi):
                if($index==2):
                    $where_sql	.=	$and."inst_rujuk='".$CI->user_instansi."' and rujuk_rehab='".$CI->user_org."'";
                elseif($index==3):
                    $where_sql	.=	$and."inst_pasca='".$CI->user_instansi."' and rujuk_pasca='".$CI->user_org."'";
                endif;
            endif;
        endif;
        
        $sql        =   "select count(idx) from t_pasien ".$where_sql;           
        $total      =   $CI->conn->GetOne($sql);   
        
        return $total;
        
    }

	function offline_notification_jalan($index=2){
        
        $CI 	    =	& get_instance();
        
        $where_sql  =   "where flag_notification='1'";
        $and        =   " and ";
        
        if($index):
            $where_sql  .=  $and."status_rehab='".$index."' and status_proses='RJKL'";
            $and        =   " and ";   
        endif;
        
        if($CI->user_prop):
            if($CI->user_instansi):
                if($index==2):
                    $where_sql	.=	$and."inst_rujuk='".$CI->user_instansi."' and rujuk_rehab='".$CI->user_org."'";
                elseif($index==3):
                    $where_sql	.=	$and."inst_pasca='".$CI->user_instansi."' and rujuk_pasca='".$CI->user_org."'";
                endif;
            endif;
        endif;
        
        $sql        =   "select count(idx) from t_pasien ".$where_sql;           
        $total      =   $CI->conn->GetOne($sql);   
        
        return $total;
        
    }

	function offline_notification_pasca_inap($index=2){
        
        $CI 	    =	& get_instance();
        
        $where_sql  =   "where flag_notification='1'";
        $and        =   " and ";
        
        if($index):
            $where_sql  .=  $and."status_rehab='".$index."' and status_proses='PRRIDA'";
            $and        =   " and ";   
        endif;
        
        if($CI->user_prop):
            if($CI->user_instansi):
                if($index==2):
                    $where_sql	.=	$and."inst_rujuk='".$CI->user_instansi."' and rujuk_rehab='".$CI->user_org."'";
                elseif($index==3):
                    $where_sql	.=	$and."inst_pasca='".$CI->user_instansi."' and rujuk_pasca='".$CI->user_org."'";
                endif;
            endif;
        endif;
        
        $sql        =   "select count(idx) from t_pasien ".$where_sql;           
        $total      =   $CI->conn->GetOne($sql);   
        
        return $total;
        
    }

	function offline_notification_pasca_jalan($index=2){
        
        $CI 	    =	& get_instance();
        
        $where_sql  =   "where flag_notification='1'";
        $and        =   " and ";
        
        if($index):
            $where_sql  .=  $and."status_rehab='".$index."' and status_proses='PRRJPG'";
            $and        =   " and ";   
        endif;
        
        if($CI->user_prop):
            if($CI->user_instansi):
                if($index==2):
                    $where_sql	.=	$and."inst_rujuk='".$CI->user_instansi."' and rujuk_rehab='".$CI->user_org."'";
                elseif($index==3):
                    $where_sql	.=	$and."inst_pasca='".$CI->user_instansi."' and rujuk_pasca='".$CI->user_org."'";
                endif;
            endif;
        endif;
        
        $sql        =   "select count(idx) from t_pasien ".$where_sql;           
        $total      =   $CI->conn->GetOne($sql);   
        
        return $total;
        
    }

	function offline_notification_pasca_lanjut($index=2){
        
        $CI 	    =	& get_instance();
        
        $where_sql  =   "where flag_notification='1'";
        $and        =   " and ";
        
        if($index):
            $where_sql  .=  $and."status_rehab='".$index."' and status_proses='PRRLPUKP'";
            $and        =   " and ";   
        endif;
        
        if($CI->user_prop):
            if($CI->user_instansi):
                if($index==2):
                    $where_sql	.=	$and."inst_rujuk='".$CI->user_instansi."' and rujuk_rehab='".$CI->user_org."'";
                elseif($index==3):
                    $where_sql	.=	$and."inst_pasca='".$CI->user_instansi."' and rujuk_pasca='".$CI->user_org."'";
                endif;
            endif;
        endif;
        
        $sql        =   "select count(idx) from t_pasien ".$where_sql;           
        $total      =   $CI->conn->GetOne($sql);   
        
        return $total;
        
    }

    function offline_notification_list($index=2){
        
        $CI 	=	& get_instance();

        $where_sql  =   "where flag_notification='1'";
        $and        =   " and ";
        
        if($index):
            $where_sql  .=  $and."status_rehab='".$index."'";
            $and        =   " and ";   
        endif;
        
        if($CI->user_prop):
            if($CI->user_instansi):
                if($index==2):
                    $where_sql	.=	$and."inst_rujuk='".$CI->user_instansi."' and rujuk_rehab='".$CI->user_org."'";
                elseif($index==3):
                    $where_sql	.=	$and."inst_pasca='".$CI->user_instansi."' and rujuk_pasca='".$CI->user_org."'";
                endif;
            endif;
        endif;
        
        $sql        =   "select * from t_pasien ".$where_sql;   
        
        $arrData    =   $CI->conn->GetAll($sql);
        
        return $arrData;
        
    }

    function tempat_rehab($kode){
        
        switch($kode):
            case    "BNNP":
                $tempat_rehab   =   "BNNP"; break;
            case    "BNNK":
                $tempat_rehab   =   "BNNK"; break;
            case    "BL":
                $tempat_rehab   =   "BALAI/LOKA"; break;
            case    "KM":
                $tempat_rehab   =   "KOMPONEN MASYARAKAT"; break;
            case    "RD":
                $tempat_rehab   =   "RUMAH DAMPING"; break;
        endswitch;
        
        return $tempat_rehab;
        
    }


    function nama_organisasi($jenis,$kode){
        
        $CI 	=	& get_instance();
        
        if($jenis=="BNNP" or $jenis=="BNNK"):
            $nama_organisasi    =   $CI->conn->GetOne("select nama from m_org where kd_org='".$kode."'");
        elseif($jenis=="BL" or $jenis=="KM" or $jenis=="RD"):
            $nama_organisasi    =   $CI->conn->GetOne("select nama_instansi from m_instansi where kd_instansi='".$kode."'");
        endif;
        
        return $nama_organisasi;
        
    }

    function detail_link($jenis,$idx_pasien){
        
        $CI 	    =	& get_instance();
        
        $id_pasien  =   encrypt($idx_pasien);
        
        if($jenis=="BNNP" or $jenis=="BNNK"):
            $link   =   "rehab/konseling/detail/".$id_pasien;
        elseif($jenis=="BL" or $jenis=="KM" or $jenis=="RD"):
            $link   =   "rehab/detox/detail/".$id_pasien;
        endif;
        
        return $link;
        
    }
    
    function detail_link_pasca($status_proses,$idx_pasien){
        
        $CI 	    =	& get_instance();
        
        $id_pasien  =   encrypt($idx_pasien);
        
        switch($status_proses):
            case    "PRRIDA":
                $link   =   "pasca/daily_act/view_detail/".$id_pasien; break;
            case    "PRRJPG":
                $link   =   "pasca/peer_group/view_detail/".$id_pasien; break;
            case    "PRRLPUKP":
                $link   =   "pasca/produktif/view_detail/".$id_pasien; break;
        endswitch;
        
        return $link;
        
    }

    function switch_off_notification($idx_pasien){
        
        $CI 	    =	& get_instance();
        
        $sql        =   "UPDATE t_pasien SET flag_notification='0' WHERE idx='".$idx_pasien."'";
        
        $update     =   $CI->conn->Execute($sql);
        
        return $update;
        
    }
	
	function online_notification(){
        $CI 	    =	& get_instance();
        
        $where_sql  =   "where flag_notif='1'";
		$and        =   " and ";
        
		if($CI->user_prop):	
			if($CI->user_instansi):
				if($CI->user_instansi=="BNNP"):
					$where_sql	.= $and."jns_org='1'";
					$and        =   " and ";
				elseif($CI->user_instansi=="BNNK"):
					$where_sql	.= $and."jns_org='3'";
					$and        =   " and ";
				elseif($CI->user_instansi=="BL"):
					$where_sql	.= $and."jns_org='2'";
					$and        =   " and ";
				endif;
					
			endif;		
			$where_sql	.=	$and."substr(kd_bnn,1,5)='".$CI->user_prop."-".$CI->user_kab."'";	
		endif;
       
        $sql        =   "select count(idx) from t_pasien_registrasi_online ".$where_sql;           
        $total      =   $CI->conn->GetOne($sql);   
        return $total;
        
    }
	function online_notification_list(){
        
        $CI 	=	& get_instance();

        $where_sql  =   "where flag_notif='1'";
        $and        =   " and ";
        
       
		//belum dicoba
		if($CI->user_prop):	
			if($CI->user_instansi):
				if($CI->user_instansi=="BNNP"):
					$where_sql	.= $and."jns_org='1'";
					$and        =   " and ";
				elseif($CI->user_instansi=="BNNK"):
					$where_sql	.= $and."jns_org='3'";
					$and        =   " and ";
				elseif($CI->user_instansi=="BL"):
					$where_sql	.= $and."jns_org='2'";
					$and        =   " and ";
				endif;
					
			endif;		
			$where_sql	.=	$and."substr(kd_bnn,1,5)='".$CI->user_prop."-".$CI->user_kab."'";	
		endif;
        
       
        
        $sql        =   "select * from t_pasien_registrasi_online ".$where_sql;   
        
        $arrData    =   $CI->conn->GetAll($sql);
        
        return $arrData;
        
    }
	
	function jns_org($kode){
        
        switch($kode):
            case    "1":
                $jns_org   =   "BNNP"; break;
            case    "2":
                $jns_org   =   "BALAI/LOKA"; break;
            case    "3":
                $jns_org   =   "BNNK"; break;
        endswitch;
        
        return $jns_org;
        
    }
	 function nama_org_front($jns_org,$kode){
        
        $CI 	=	& get_instance();
        if($jns_org=="1" or $jns_org=="3"):
            $nama_organisasi    =   $CI->conn->GetOne("select nama from m_org where kd_org='".$kode."'");
        elseif($jns_org=="2"):
            $nama_organisasi    =   $CI->conn->GetOne("select nama_instansi from m_instansi where kd_instansi='".$kode."'");
        endif;
        
        return $nama_organisasi;
        
    }
	function detail_link_front($idx_pasien){
        
        $CI 	    =	& get_instance();
        
        $id_pasien  =   encrypt($idx_pasien);
        $link   =   "registrasi/online/view/".$id_pasien;
        
        return $link;
        
    }
	function switch_off_notification_front($idx_pasien){
        
        $CI 	    =	& get_instance();
        
        $sql        =   "UPDATE t_pasien_registrasi_online SET flag_notif='0' WHERE idx='".$idx_pasien."'";
        
        $update     =   $CI->conn->Execute($sql);
        
        return $update;
        
    }