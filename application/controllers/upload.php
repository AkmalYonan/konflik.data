<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class upload extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->conn=$this->adodbx->db;
	}
	
	function image(){
		$uploadPath="docs/img/ori";
		$uploadThumb="docs/img/thumb";
		$uploadResize="docs/img/resize";
		
		check_folder($uploadPath);
		check_folder($uploadThumb);
		check_folder($uploadResize);
		
		$config['upload_path'] = $uploadPath;
    	$config['allowed_types'] = "png|jpg|bmp|jpeg";
		$this->load->library('upload', $config);
        $this->upload_action();
	}
	
	function image_id(){
		$uploadPath="docs/img/ori";
		$uploadThumb="docs/img/thumb";
		$uploadResize="docs/img/resize";
		
		check_folder($uploadPath);
		check_folder($uploadThumb);
		check_folder($uploadResize);
		
		$config['upload_path'] = $uploadPath;
    	$config['allowed_types'] = "png|jpg|bmp|jpeg";
		$this->load->library('upload', $config);
        $this->upload_action_id();
	}
	
	
	function doc(){
		$uploadPath="docs/doc/";
		check_folder($uploadPath);
		$config['upload_path'] = $uploadPath;
    	$config['allowed_types'] = "docx|doc|pdf";
        $this->load->library('upload', $config);
		$this->upload_action();
	}
    
    function all(){
		/*
        $uploadPath="docs/hrm";
        $uploadImage="docs/hrm/img/ori";
        $uploadThumb="docs/hrm/img/thumb";
        $uploadResize="docs/hrm/img/resize";
        */
		
		$uploadPath=$this->config->item("path_docs");
        $uploadImage=$this->config->item("path_img_ori");;
        $uploadThumb=$this->config->item("path_img_thumb");
        $uploadResize=$this->config->item("path_img_resize");
        
		$this->uploadPath=$uploadPath;
		$this->uploadImage=$uploadImage;
		$this->uploadThumb=$uploadThumb;
		$this->uploadResize=$uploadResize;
        
		check_folder($uploadPath);
        check_folder($uploadThumb);
        check_folder($uploadResize);
        check_folder($uploadImage);
		
		$config['allowed_types'] = "docx|doc|pdf|png|jpg|bmp|jpeg|xls|csv|txt|xlsx|zip|rar";
        $config['upload_path'] = $uploadPath;
        
		$imgType =  $_FILES['userfile']['type'];
		if($imgType == 'image/jpeg' || $imgType == 'image/gif' || $imgType == 'image/png' || $imgType == 'image/bmp') {
			$config['upload_path'] = $uploadImage;
        }
        $this->load->library('upload', $config);
        $this->upload_action();
    }
	
	function data(){
		$uploadPath="docs/spreadsheet/";
		check_folder($uploadPath);
		$config['upload_path'] = $uploadPath;
    	$config['allowed_types'] = "xls|csv|txt|xlsx";
        $this->load->library('upload', $config);
		$this->upload_action();
	}
	
	
	
	function upload_action(){
		$dataret["msg"]="";
		$dataret["status"]="";
		$dataret["data"]=array();
		
		if ( ! $this->upload->do_upload()):
     		//print $this->upload->display_errors();
			$dataret["msg"]=$this->upload->display_errors();
			$dataret["status"]=false;
		else:
			$tmpName=basename($_FILES["userfile"]["tmp_name"]);
			
			$data=$this->upload->data();
            
			$data["relative_path"]=str_replace(str_replace("\\","/",FCPATH),"",$data["full_path"]);
			if($data["is_image"]==TRUE):
                /*
				$new_full_path=str_replace("skp/","skp/img/ori/",$data["full_path"]);
                $new_relative_path=str_replace("skp/","skp/img/ori/",$data["relative_path"]);
                $new_file_path=str_replace("skp/","skp/img/ori/",$data["file_path"]);
				*/
				
				//$new_full_path=str_replace("/".$this->uploadImage,"/".$this->uploadImage,$data["full_path"]);
                //$new_relative_path=str_replace($this->uploadImage,$this->uploadImage,$data["relative_path"]);
                //$new_file_path=str_replace("/".$this->uploadPath,"/".$this->uploadImage,$data["file_path"]);
				
                //rename($data["relative_path"],$new_relative_path);
				//$data["full_path"]=$new_full_path;
                //$data["relative_path"]=$new_relative_path;
                //$data["file_path"]=$new_file_path;
                 $this->createThumbnail($data);
				//$this->createThumbnail($data,"resize",200,200);
				$this->createThumbnail($data,"resize",$this->config->item("pic_resize_width"),$this->config->item("pic_resize_height"));
				$data["file_path_view"]=str_replace($this->uploadImage,$this->uploadResize,$data["relative_path"]);
				$data["file_path_thumb"]=str_replace($this->uploadImage,$this->uploadThumb,$data["relative_path"]);
			endif;
			
			
			$data["file_temp"]=$tmpName;
			$id=$this->save_uploaded_file($data);
			$dataFile=$this->conn->GetRow("select * from t_file_upload where idx=$id");
			$dataret["msg"]="File telah berhasil di upload";
			$dataret["status"]="ok";
			$dataret["id_file"]=$id;
			$dataret["data"]=$data;
			$dataret["data_file"]=$dataFile;
		endif;
		
		echo json_encode($dataret);
	}
	
	function upload_action_id(){
		$dataret["msg"]="";
		$dataret["status"]="";
		$dataret["data"]=array();
		
		if ( ! $this->upload->do_upload()):
     		//print $this->upload->display_errors();
			$dataret["msg"]=$this->upload->display_errors();
			$dataret["status"]=false;
		else:
			$tmpName=basename($_FILES["userfile"]["tmp_name"]);
			
			$data=$this->upload->data();
			$data["relative_path"]=str_replace(str_replace("\\","/",FCPATH),"",$data["full_path"]);
			if($data["is_image"]==TRUE):
                $this->createThumbnail($data);
				$this->createThumbnail($data,"resize",$this->config->item("pic_resize_width"),$this->config->item("pic_resize_height"));
				$data["file_path_view"]=str_replace("img/ori","img/resize",$data["relative_path"]);
				$data["file_path_thumb"]=str_replace("img/ori","img/thumb",$data["relative_path"]);
			endif;
			
			
			$data["file_temp"]=$tmpName;
			$id=$this->save_uploaded_file($data);
			//$dataFile=$this->conn->GetRow("select * from t_file_upload where idx=$id");
			$dataret["msg"]="File telah berhasil di upload";
			$dataret["status"]="ok";
			$dataret["id_file"]=encrypt($id);
		endif;
		echo json_encode($dataret);
	}
	
	function createThumbnail($data,$subpath="thumb",$width=50,$height=50,$subpath_ori="ori"){
		// clear config array
		$config = array();
		// create resized image
		$config['image_library'] = 'GD2';
		$config['source_image'] = $data['full_path'];
		$config['new_image'] =str_replace("/".$subpath_ori."/","/".$subpath."/",$data["full_path"]);
		$config['create_thumb'] = false;
		$config['maintain_ratio'] = true;
		$config['width'] = $width;
		$config['height'] =$height;
		if(!isset($this->image_lib)):
			$this->load->library('image_lib', $config);
		else:
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
		endif;
		$this->image_lib->resize();
	}
	
	 function delete_file($id=false){
	 	if(!$id):
			print "failed";
			exit();
		endif;
	 	$file=$this->conn->GetRow("select * from t_file_upload where idx=$id");
	 	$ok=$this->conn->Execute("delete from t_file_upload where idx=$id");
		if($ok):
			if(is_file('./' . $file["relative_path"]))
			unlink('./' . $file["relative_path"]);
			if(is_file('./' . $file["relative_path_view"]))
			unlink('./' . $file["relative_path_view"]);
			if(is_file('./' . $file["relative_path_thumb"]))
			unlink('./' . $file["relative_path_thumb"]);
			print "ok";
		else:
			print "failed";
		endif;
	 }
	
	function test_upload(){
		$this->load->view("test_upload");
	}
	
	function upload_stream(){
		/*
			This file receives the JPEG snapshot
			from webcam.swf as a POST request.
		*/
		
		// We only need to handle POST requests:
		if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
			exit;
		}
		
		$folder = 'uploads/';
		check_folder($folder);
		$filename = md5($_SERVER['REMOTE_ADDR'].rand()).'.jpg';
		
		$original = $folder.$filename;
		
		// The JPEG snapshot is sent as raw input:
		$input = file_get_contents('php://input');
		
		if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
			// Blank image. We don't need this one.
			exit;
		}
		
		$result = file_put_contents($original, $input);
		if (!$result) {
			echo '{
				"error"		: 1,
				"message"	: "Failed save the image. Make sure you chmod the uploads folder and its subfolders to 777."
			}';
			exit;
		}
		
		$info = getimagesize($original);
		if($info['mime'] != 'image/jpeg'){
			unlink($original);
			exit;
		}
		$file_path="uploads/original/";
		$file_tb_path="uploads/thumbs/";
		
		check_folder("uploads/original/");
		check_folder("uploads/thumbs/");
		
		// Moving the temporary file to the originals folder:
		rename($original,'uploads/original/'.$filename);
		$original = 'uploads/original/'.$filename;
		$thumbs = 'uploads/thumbs/'.$filename;
		
		// Using the GD library to resize 
		// the image into a thumbnail:
		/*
		$origImage	= imagecreatefromjpeg($original);
		$newImage	= imagecreatetruecolor(154,110);
		imagecopyresampled($newImage,$origImage,0,0,0,0,154,110,520,370); 
		*/
		
		$config = array();
		// create resized image
		$config['image_library'] = 'GD2';
		$config['source_image'] =$original;
		$config['new_image'] =$thumbs;
		$config['create_thumb'] = false;
		$config['maintain_ratio'] = true;
		$config['width'] = 50;
		$config['height'] =50;
		if(!isset($this->image_lib)):
			$this->load->library('image_lib', $config);
		else:
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
		endif;
		$this->image_lib->resize();
        
		//imagejpeg($newImage,'uploads/thumbs/'.$filename);
		
		//echo '{"status":1,"message":"Success!","filename":"'.$filename.'"}';
		
		$data_ret["status"]=1;
		$data_ret["message"]="Success!";
		$data_ret["filename"]=$filename;
		$data_ret["file_path"]=$file_path;
		$data_ret["file_tb_path"]=$file_tb_path;
		print json_encode($data_ret);
	}
	
	
	function peta(){
		$uploadPath="docs/brwa/peta";
		
		check_folder($uploadPath);
		
		$config['upload_path'] = $uploadPath;
    	$config['allowed_types'] = "*";
		$this->load->library('upload', $config);
        $this->upload_peta_action();
	}
	
	function upload_peta_action(){
		$dataret["msg"]="";
		$dataret["status"]="";
		$dataret["data"]=array();
		
		if ( ! $this->upload->do_upload()):
     		//print $this->upload->display_errors();
			$dataret["msg"]=$this->upload->display_errors();
			$dataret["status"]=false;
		else:
			$tmpName=basename($_FILES["userfile"]["tmp_name"]);
			
			$data=$this->upload->data();
            
			$data["relative_path"]=str_replace(str_replace("\\","/",FCPATH),"",$data["full_path"]);
			$data["file_temp"]=$tmpName;
			$id=$this->save_uploaded_file_peta($data);
			$dataFile=$this->conn->GetRow("select * from wa_spasial_file_upload where idx=$id");
			$dataret["msg"]="File telah berhasil di upload";
			$dataret["status"]="ok";
			$dataret["id_file"]=$id;
			$dataret["data"]=$data;
			$dataret["data_file"]=$dataFile;
		endif;
		
		echo json_encode($dataret);
	}
	
	function save_uploaded_file($data){
		$data["upload_time"]=time();
		
		$stamp = date("Ymdhis");
		$ip = get_client_ip(); //from conf php
		$id_file = basename($data["file_temp"],".tmp")."-"."$stamp-".inet_aton($ip);
		$data["id_file_str"]=$id_file;
		
		//$this->conn->debug=true;
		$this->conn->StartTrans();
		$data["ip_client"]=get_ip_address();
		$this->conn->AutoExecute("t_file_upload",$data,"INSERT");
		$ID=$this->conn->GetOne("select max(idx) from t_file_upload");
		$ok=$this->conn->CompleteTrans();
		//$ID=FALSE;
		//if($ok):
		//endif;
		if($ok):
			return $ID;
		else:
			return FALSE;
		endif;
	}
	
	function save_uploaded_file_peta($data){
		$data["upload_time"]=time();
		
		$stamp = date("Ymdhis");
		$ip = get_client_ip(); //from conf php
		$id_file = basename($data["file_temp"],".tmp")."-"."$stamp-".inet_aton($ip);
		$data["id_file_str"]=$id_file;
		
		//$this->conn->debug=true;
		$this->conn->StartTrans();
		$data["ip_client"]=get_ip_address();
		$this->conn->AutoExecute("wa_spasial_file_upload",$data,"INSERT");
		$ID=$this->conn->GetOne("select max(idx) from wa_spasial_file_upload");
		$ok=$this->conn->CompleteTrans();
		if($ok):
			return $ID;
		else:
			return FALSE;
		endif;
	}
	
	
	
	function chunk($config_path="base_path_upload"){
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		// Uncomment this one to fake upload time
		// usleep(5000);
		$targetDir=$this->config->item($config_path)?$this->config->item($config_path):FCPATH."uploads";
		// Settings
		if(isset($_REQUEST["path"])):
			$targetDir= $_REQUEST["path"];
		else:
			$targetDir = $this->config->item($config_path);
		endif;
		//$targetDir = 'uploads';
		$cleanupTargetDir = false; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


		// Remove old temp files	
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}.part") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}	


		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {	
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off 
			rename("{$filePath}.part", $filePath);
		}

		// Return Success JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
	
}
	