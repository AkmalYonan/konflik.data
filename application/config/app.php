<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config["hrms_service"]["server"]="http://192.168.11.11/hrms/api/";
$config["menu_title"]="XXXX";
$config["app_name"]="brwa";
$config["app_key"]="312cd30ab5cb88e5be1c23be";
//$config["app_key"]="312cd30ab5cb88e5be1";
$config["site_url"]='http://brwa.or.id/';
//$config["wms_url"]='http://flat.dinamof.co.id:5222/';
$config["wms_url"]="https://map.brwa.or.id/";
$config["site_open"]=TRUE;
$config["app_full_path"] = $_SERVER['DOCUMENT_ROOT']."/v2/";
$config["dir_tmp"] = "tmp/plupload/";
//print_r($_SERVER['DOCUMENT_ROOT']);
//Full path for uploaded file using plupload
$config["tmp_full_path"] = $config["dir_tmp"];

$config["public_theme"] = "flat_layout";
$config["admin_theme"] = "admin_lte_layout";

//Administratif
$config["adwil"][1]='prop';
$config["adwil"][2]='kab';
$config["adwil"][3]='kec';
$config["adwil"][4]='desa';

$config["adwil_level"]=0; //0:Indonesia; 1:Provinsi; 2:Kabupaten/Kota; 3:Kecamatan
//$config["kd_prop"]=32;
//$config["kd_kabkot"]=16;

$config["dir_import"]="docs/konflik_xls/";
$config["dir_import_akkm"]="docs/akkm_xls/";


$config["dir_mapfile"] = "/home/map.brwa.or.id/map/";
$config["dir_shapefile"] = "/home/map.brwa.or.id/map/raw/";
$config["dir_geojson"] = "./content/geojson/";

$config["dir_slider"] = "./content/images/slider/";
$config["dir_news"] = "./content/images/news/";
$config["dir_articles"] = "./content/images/articles/";

//assesment
$config["dir_assesment_summary"]    =   "../admin/uploads/assesment_summary/";
//End

//rehab
$config["dir_detok"]	=	"../admin/uploads/detok/";
$config["dir_eu"]	=	"../admin/uploads/eu/";
$config["dir_pt"]	=	"../admin/uploads/pt/";
$config["dir_re"]	=	"../admin/uploads/re/";

$config["dir_kl"]	=	"../admin/uploads/kl/";
$config["dir_tk"]	=	"../admin/uploads/tk/";
$config["dir_ts"]	=	"../admin/uploads/ts/";

$config["dir_da"]	=	"../admin/uploads/da/";
$config["dir_dr"]	=	"../admin/uploads/dr/";

$config["dir_hv"]	=	"../admin/uploads/hv/";
$config["dir_pk"]	=	"../admin/uploads/pk/";
$config["dir_pasca_konseling"]	=	"../admin/uploads/pasca_konseling/";
$config["dir_turin"]	=	"../admin/uploads/turin/";

$config["dir_instansi"]	=	"../admin/uploads/instansi/";
$config["dir_org"]		=	"../admin/uploads/org/";
$config["dir_balai_loka"]=	"../admin/uploads/balai_loka/";
$config["dir_ipnwl"]	=	"../admin/uploads/ipnwl/";

$config["dir_penerimaan_pasca"]	=	"../admin/uploads/penerimaan_pasca/";
//end

//Wikera Files
$config["dir_lampiran_wikera"]	=	"./uploads/lampiran_wikera/";
//End

//Kelompok Umur
$config["kelompok_umur"]["U1"]	=	array(0,18);
$config["kelompok_umur"]["U2"]	=	array(18,25);
$config["kelompok_umur"]["U3"]	=	array(26,30);
$config["kelompok_umur"]["U4"]	=	array(31,35);
$config["kelompok_umur"]["U5"]	=	array(36,40);
$config["kelompok_umur"]["U6"]	=	array(41,45);
$config["kelompok_umur"]["U7"]	=	array(45);
//Pasca Files
$config["dir_peer_group"]			=	"../admin/uploads/peer_group/";
$config["dir_pengembangan_diri"]	=	"../admin/uploads/pengembangan_diri/";
$config["dir_dukungan_keluarga"]	=	"../admin/uploads/dukungan_keluarga/";
$config["dir_produktif"]			=	"../admin/uploads/produktif/";
$config["dir_evaluasi"]				=	"../admin/uploads/evaluasi/";
$config["dir_pemantauan_urin"]		=	"../admin/uploads/pemantauan_urin/";
$config["dir_pendampingan_urin"]	=	"../admin/uploads/pendampingan_urin/";
$config["dir_discharge"]			=	"../admin/uploads/rujukan/";
$config["dir_rumah_damping"]		=	"../admin/uploads/rumah_damping/";
//End

$config["dir_pp"] = "docs/pp/";
$config["base_path_upload"]="docs/";


//$config["dir_tmp"] = "tmp/plupload/";
$config["dir_tmp_news_image"] = "tmp/plupload/";
$config["dir_news_image"] = "assets/image/news_tanahkita/";

$config["dir_tmp_link_image"] = "tmp/plupload/";
$config["dir_link_image"] = "assets/image/links/";
 
$config["dir_tmp_pages_image"] = "tmp/plupload/";
$config["dir_pages_image"] = "assets/image/pages/";


$config["dir_tmp_members"] = "tmp/plupload/";
$config["dir_members"] = "assets/image/members/";

$config["dir_tmp_regulasi"] = "tmp/plupload/";
$config["dir_regulasi"] = "assets/image/regulasi/";
$config["dir_rujukan"] = "assets/image/rujukan/";
$config["dir_spasial"] = "docs/brwa/spasial/";

$config["dir_brwa_admin"] = "/brwa_admin/";
$config["dir_ppid"] = "/";
$config["dir_tmp_files"] = "tmp/plupload/";
//$config["dir_files"] = "assets/dokumen/files/";
$config["dir_files"] = "../../brwa_admin-dokumen/files/";

$config['ssl_email'] = 'humasbp2taceh@gmail.com';
$config['ssl_pwd'] = 'humasaceh';
$config['ssl_from'] = 'humasbp2taceh@gmail.com';

/*
 | -------------------------------------------------------------------------
 | Document---Email Notification.
 | -------------------------------------------------------------------------
 | Folder where email templates are stored.
 | Default: dip/
 */
$config['email_templates'] = 'dip/email/';
$config['email_templates_pk'] = 'keberatan/email/';

/*
 | -------------------------------------------------------------------------
 | Request Notification 
 | -------------------------------------------------------------------------
 | Default: request.tpl.php
 */

$config['email_request'] = 'request.tpl.php';
$config['email_request_pk'] = 'request.tpl.php';
$config['file_path']=$_SERVER['DOCUMENT_ROOT']."/../ppid-dokumen/surat/";//."/ppid_admin/assets/permohonan/";

$config["path_docs"]="docs/bnn/";
$config["path_img"]="docs/bnn/img/";
$config["path_img_ori"]="docs/bnn/img/ori/";
$config["path_img_resize"]="docs/bnn/img/resize/";
$config["path_img_thumb"]="docs/bnn/img/thumb/";

$config["path_pasien_img"]="pasien_files/img/";

$config["pic_resize_height"]=400;
$config["pic_resize_width"]=400;

$config["encrypt_id_enable"]=TRUE;
//$config["map_service"]["server"]="http://192.168.11.11/layanan_data/map/";
$config["map_service"]["server"]="http://project.dinamof.co.id/pum2014/layanandata/map/";
//$config["brwa_service"]["server"]="http://192.168.11.11/layanan_data/v1/data/dagri/";

//$config["dagri_service"]["server"]="http://project.dinamof.co.id/pum2014/layanandata/v1/dagri/";
// $config["dagri_service"]["server"]="http://192.168.11.11/layanan_data/v1/data/dagri/";
// $config["dagri_service"]["server"]="http://layanandata.ditjenpum.go.id/v1/dagri/wilayah/";
$config["dagri_service"]["server"]="http://layanandata.ditjenpum.go.id/v1/dagri/";

