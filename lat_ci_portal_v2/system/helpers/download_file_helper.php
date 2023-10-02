<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// grab the requested file's name
function download_file($file_name=false){
	// make sure it's a file before doing anything!
	if(!$file_name):
		$file_name=$_REQUEST["file"];
	endif;
	
	if(is_file($file_name))
	{
	
		/*
			Do any processing you'd like here:
			1.  Increment a counter
			2.  Do something with the DB
			3.  Check user permissions
			4.  Anything you want!
		*/
	
		// required for IE
		if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}
	
		// get the file mime type using the file extension
		switch(strtolower(substr(strrchr($file_name,'.'),1)))
		{
			//image
			case 'jpeg': $mime = 'image/jpg'; break;
			case 'jpg': $mime = 'image/jpg'; break;
			case 'png': $mime = 'image/png'; break;
			case 'bmp': $mime = 'image/bmp'; break;
			case 'gif': $mime = 'image/gif'; break;
			
			//text
			case 'php': $mime = 'text/plain'; break;
			case 'phps': $mime = 'text/plain'; break;
			case 'html': $mime = 'text/html'; break;
			case 'htm': $mime = 'text/html'; break;
			case 'txt': $mime = 'text/plain'; break;
			
			/* exe */
			case 'exe': $mime = 'application/octet-stream'; break;
			
			/* office */
			case 'doc': $mime = 'application/msword'; break;
			case 'xls': $mime = 'application/vnd.ms-excel'; break;
			case 'jpeg': $mime = 'application/vnd.ms-powerpoint'; break;
			
			/* application */
			case 'pdf': $mime = 'application/pdf'; break;
			case 'zip': $mime = 'application/zip'; break;
			
			/* default */
			default: $mime = 'application/force-download';
		}
		
		header('Pragma: public'); 	// required
		header('Expires: 0');		// no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($file_name));	// provide file size
		readfile($file_name);		// push it out
		exit();
	
	}
}
/* End of file download_file_helper.php */
/* Location: ./application/helpers/download_file_helper.php */