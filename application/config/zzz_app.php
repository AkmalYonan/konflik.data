<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config["hrms_service"]["server"]="http://192.168.11.11/hrms/api/";
$config["menu_title"]="XXXX";
$config["app_name"]="brwa";
$config["app_key"]="312cd30ab5cb88e5be1";
$config["site_url"]='http://brwa.or.id/';
$config["site_open"]=TRUE;

$config["admin_theme"] = "admin_lte_layout";

//Administratif
$config["adwil"][1]='prop';
$config["adwil"][2]='kab';
$config["adwil"][3]='kec';
$config["adwil"][4]='desa';

$config["adwil_level"]=0; //0:Indonesia; 1:Provinsi; 2:Kabupaten/Kota; 3:Kecamatan
//$config["kd_prop"]=32;
//$config["kd_kabkot"]=16;

$config["dir_slider"] = "../content/images/slider/";
$config["dir_news"] = "../content/images/news/";
$config["dir_articles"] = "../content/images/articles/";


$config["dir_tmp"] = "tmp/plupload/";
$config["dir_tmp_news_image"] = "tmp/plupload/";
$config["dir_news_image"] = "assets/image/news/";

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


