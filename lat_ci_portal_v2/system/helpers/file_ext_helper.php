<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function output_file($file, $name, $mime_type='')
{
 /*
 This function takes a path to a file to output ($file),
 the filename that the browser will see ($name) and
 the MIME type of the file ($mime_type, optional).
 
 If you want to do something on download abort/finish,
 register_shutdown_function('function_name');
 */
 if(!is_readable($file)) die('File not found or inaccessible!');
  
 $size = filesize($file);
 $name = rawurldecode($name);
  
 /* Figure out the MIME type (if not specified) */
 $known_mime_types=array(
    "pdf" => "application/pdf",
    "txt" => "text/plain",
    "html" => "text/html",
    "htm" => "text/html",
    "exe" => "application/octet-stream",
    "zip" => "application/zip",
    "doc" => "application/msword",
    "xls" => "application/vnd.ms-excel",
	"xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    "ppt" => "application/vnd.ms-powerpoint",
    "gif" => "image/gif",
    "png" => "image/png",
    "jpeg"=> "image/jpg",
    "jpg" =>  "image/jpg",
    "php" => "text/plain"
 );
       
 if($mime_type==''){
     $file_extension = strtolower(substr(strrchr($file,"."),1));
     if(array_key_exists($file_extension, $known_mime_types)){
        $mime_type=$known_mime_types[$file_extension];
     } else {
        $mime_type="application/force-download";
     };
 };
  
 @ob_end_clean(); //turn off output buffering to decrease cpu usage
  
 // required for IE, otherwise Content-Disposition may be ignored
 if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');
   
 header('Content-Type: ' . $mime_type);
 header('Content-Disposition: attachment; filename="'.$name.'"');
 header("Content-Transfer-Encoding: binary");
 header('Accept-Ranges: bytes');
  
 /* The three lines below basically make the
    download non-cacheable */
 header("Cache-control: private");
 header('Pragma: private');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 
 // multipart-download and download resuming support
 if(isset($_SERVER['HTTP_RANGE']))
 {
    list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
    list($range) = explode(",",$range,2);
    list($range, $range_end) = explode("-", $range);
    $range=intval($range);
    if(!$range_end) {
        $range_end=$size-1;
    } else {
        $range_end=intval($range_end);
    }
 
    $new_length = $range_end-$range+1;
    header("HTTP/1.1 206 Partial Content");
    header("Content-Length: $new_length");
    header("Content-Range: bytes $range-$range_end/$size");
 } else {
    $new_length=$size;
    header("Content-Length: ".$size);
 }
 
 /* output the file itself */
 $chunksize = 1*(1024*1024); //you may want to change this
 $bytes_send = 0;
 if ($file = fopen($file, 'r'))
 {
    if(isset($_SERVER['HTTP_RANGE']))
    fseek($file, $range);
     
    while(!feof($file) &&
        (!connection_aborted()) &&
        ($bytes_send<$new_length)
          )
    {
        $buffer = fread($file, $chunksize);
        print($buffer); //echo($buffer); // is also possible
        flush();
        $bytes_send += strlen($buffer);
    }
 fclose($file);
 } else die('Error - can not open file.');
  
die();
}  
 
/*********************************************
            Example of use
**********************************************/
 
/*
Make sure script execution doesn't time out.
Set maximum execution time in seconds (0 means no limit).
*/
/*set_time_limit(0); 
$file_path='that_one_file.txt';
output_file($file_path, 'some file.txt', 'text/plain');
*/


/**
 *  function _push_file($path, $name)
 * This function pushes a file out to a user for download.
 * @param    STRING    $path    The full absolute path to the file to be pushed.
 * @param    STRING    $name    The file name of the file to be pushed.
 * @author   Matthew Craig 
 * @copyright 2010 Matthew Craig.
 */
function push_file($path, $name)
{
	$CI=& get_instance();
  // make sure it's a file before doing anything!
  if(is_file($path))
  {
    // required for IE
    if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

    // get the file mime type using the file extension
    $CI->load->helper('file');

    /**
     * This uses a pre-built list of mime types compiled by Codeigniter found at
     * /system/application/config/mimes.php 
     * Codeigniter says this is prone to errors and should not be dependant upon
     * However it has worked for me so far. 
     * You can also add more mime types as needed.
     */
    $mime = get_mime_by_extension($path);

    // Build the headers to push out the file properly.
    header('Pragma: public');     // required
    header('Expires: 0');         // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
    header('Cache-Control: private',false);
    header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
    header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($path)); // provide file size
    header('Connection: close');
    readfile($path); // push it out
    exit();
	}
	
	// Original PHP code by Chirp Internet: www.chirp.com.au 
	// Please acknowledge use of this code by including this header. 
	//EXAMPLE //
	// single directory 
		//$dirlist = getFileList("./"); 
	// include all subdirectories recursively 
		//$dirlist = getFileList("./", true); 
	// include just one or two levels of subdirectories 
		//$dirlist = getFileList("./", true, 1); $dirlist = getFileList("./", true, 2);
	
	function getFileList($dir, $recurse=false, $depth=false) { 
			// array to hold return value 
			$retval = array(); 
			// add trailing slash if missing 
			if(substr($dir, -1) != "/") $dir .= "/"; 
			// open pointer to directory and read list of files 
			$d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading"); 
			while(false !== ($entry = $d->read())) { 
			// skip hidden files 
			if($entry[0] == ".") continue; 
			if(is_dir("$dir$entry")) { 
				$retval[] = array( 
								"name" => "$dir$entry/", 
								"type" => filetype("$dir$entry"), 
								"size" => 0, 
								"lastmod" => filemtime("$dir$entry") 
							); 
				if($recurse && is_readable("$dir$entry/")) { 
					if($depth === false) { 
						$retval = array_merge($retval, getFileList("$dir$entry/", true)); 
					}elseif($depth > 0) { 
						$retval = array_merge($retval, getFileList("$dir$entry/", true, $depth-1)); } 
					} 
				}elseif(is_readable("$dir$entry")) { 
						$retval[] = array( 
										"name" => "$dir$entry", 
										"type" => mime_content_type("$dir$entry"), 
										"size" => filesize("$dir$entry"), 
										"lastmod" => filemtime("$dir$entry") 
									); 
				} 
			} 
					
			$d->close(); 
			return $retval; 
	 } //end function 
	 
	 //get from above function and then print it;
	 function getFileListHtml($dirlist){
	 	// output file list as HTML table 
		echo "<table border=\"1\">\n"; 
		echo "<tr><th>Name</th><th>Type</th><th>Size</th><th>Last Mod.</th></tr>\n"; 
		foreach($dirlist as $file) { 
			echo "<tr>\n"; echo "<td>{$file['name']}</td>\n"; 
			echo "<td>{$file['type']}</td>\n"; 
			echo "<td>{$file['size']}</td>\n"; 
			echo "<td>",date('r', $file['lastmod']),"</td>\n"; 
			echo "</tr>\n"; } echo "</table>\n\n";
	 	}
	}
	
}