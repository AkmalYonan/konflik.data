<?php

class pppbm_model extends CI_Model{
	/**
	 * Set Table Name Here
	 */
	public $tbl= 't_daftar_pppbm';

	function __construct(){
		parent::__construct();
		$this->tbl=$tbl;
	}
	
	function export_csv($filter,$limit,$offset){
		
		if($filter):
			$filter_sql	=	" where ".$filter;
		else:
			$filter_sql	=	"";
		endif;
		
		if($limit):
			$limit_sql	=	" limit ".$limit;
		else:
			$limit_sql	=	"";
		endif;
		
		if($offset):
			$offset_sql	=	" offset ".$offset;
		else:
			$offset_sql	=	"";
		endif;
		
		$query		=	"
						select
							tgl_kejadian,
							nama_wikera,
							kode_jns_wikera,
							luas,
							desa,
							kd_propinsi,
							kd_kabupaten,
							kd_kecamatan,
							clip,
							deskripsi,
							sumber_data,
							longitude,
							latitude,
							created,
							creator
						from
							t_daftar_pppbm";
		$query		.=	$filter_sql;
		$query		.=	$limit_sql;
		$query		.=	$offset_sql;
		
		$data		=	$this->db->query($query);
		
		return $data;
		
	}

}