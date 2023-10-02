<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//sensus 2010 penduduk wilayah agama
$id=1;
$config["file"][$id]["name"]="sensus_2010_penduduk_wilayah_agama.csv";
$config["file"][$id]["alias"]="sp2010_pdd_agama";
$config["file"][$id]["properties"]["description"]="Penduduk Menurut Wilayah dan Agama yang Dianut Tahun 2010";
$config["file"][$id]["properties"]["source"]="Data Sensus Penduduk 2010 - Badan Pusat Statistik Republik Indonesia";
$config["file"][$id]["properties"]["tbl_model"]="flat";
$config["file"][$id]["properties"]["tbl_type"]="file";
$config["file"][$id]["properties"]["col_desc"]="kd_bps,provinsi";
$config["file"][$id]["properties"]["col_val"]="islam,kristen,katolik,hindu,budha,konghucu,lainnya,tidak_terjawab	tidak_ditanyakan,jumlah";
$config["file"][$id]["properties"]["col_all"]=$config["file"][$id]["properties"]["col_desc"].$config["file"][$id]["properties"]["col_val"];
$config["file"][$id]["properties"]["col_name"]="Kode BPS,Provinsi,Islam,Kristen,Katolik,Hindu,Budha,Kong Hu Chu,Lainnya,Tidak Terjawab,Tidak di tanyakan,Jumlah";

//sensus 2010 penduduk wilayah jenis_kelamin
$id=2;
$config["file"][$id]["name"]="sensus_2010_wilayah_jenis_kelamin.csv";
$config["file"][$id]["alias"]="sp2010_pdd_jk";
$config["file"][$id]["properties"]["description"]="Penduduk Menurut Wilayah dan Jenis Kelamin Tahun 2010";
$config["file"][$id]["properties"]["source"]="Data Sensus Penduduk 2010 - Badan Pusat Statistik Republik Indonesia";
$config["file"][$id]["properties"]["tbl_model"]="flat";
$config["file"][$id]["properties"]["tbl_type"]="file";
$config["file"][$id]["properties"]["col_desc"]="kd_bps,provinsi";
$config["file"][$id]["properties"]["col_val"]="laki_laki,perempuan,jumlah";
$config["file"][$id]["properties"]["col_all"]=$config["file"][$id]["properties"]["col_desc"].$config["file"][$id]["properties"]["col_val"];
$config["file"][$id]["properties"]["col_name"]="Kode BPS,Provinsi,Laki-laki,Perempuan,Jumlah";

//sensus 2010 penduduk wilayah jenis_kelamin
$id=3;
$config["file"][$id]["name"]="sensus_2010_wilayah_status_sekolah.csv";
$config["file"][$id]["alias"]="sp2010_wil_ss";
$config["file"][$id]["properties"]["description"]="Penduduk Berumur 5 Tahun Keatas Menurut Wilayah dan Status Sekolah Tahun 2010";
$config["file"][$id]["properties"]["source"]="Data Sensus Penduduk 2010 - Badan Pusat Statistik Republik Indonesia";
$config["file"][$id]["properties"]["tbl_model"]="flat";
$config["file"][$id]["properties"]["tbl_type"]="file";
$config["file"][$id]["properties"]["col_desc"]="kd_bps,provinsi";
$config["file"][$id]["properties"]["col_val"]="tidak_belum_bersekolah,masih_sekolah,tidak_bersekolah_lagi,tidak_ditanyakan,jumlah";
$config["file"][$id]["properties"]["col_all"]=$config["file"][$id]["properties"]["col_desc"].$config["file"][$id]["properties"]["col_val"];
$config["file"][$id]["properties"]["col_name"]="Kode BPS,Provinsi,Tidak/belum pernah sekolah,Masih sekolah,Tidak bersekolah lagi,Tidak Ditanyakan,Jumlah";





