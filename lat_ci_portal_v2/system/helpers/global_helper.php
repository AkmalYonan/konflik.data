<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 $config["sparator_digit"]=",";
 $config["sparator_decimal"]=".";

 	/* map bulan function */
 if (!function_exists('GetMapBulan')):
 function GetMapBulan(){
		$mapBulan=array("januari","pebruari","maret","april","mei","juni","juli","agustus","september","oktober","nopember","desember");
		return $mapBulan;
 }
 endif;
 
 function get_post(){
        $CI=& get_instance();    
        $get=$CI->input->get(null,TRUE);
        $post=$CI->input->post(null,TRUE);
        
        $post=$post?$post:array();
        $get=$get?$get:array();
        $getpost=array_merge($get,$post);
        return $getpost;
 }
 
 //mode 1 long 2 short
 function date2indo($date,$mode=1){
        if($mode==1):
            $arrBulan = array("Januari", "Februari", "Maret",  
                           "April", "Mei", "Juni",  
                           "Juli", "Agustus", "September",  
                           "Oktober", "November", "Desember");  
        endif;  
        if($mode=2):
            $arrBulan = array("Jan", "Feb", "Mar",  
                           "Apr", "Mei", "Jun",  
                           "Jul", "Agu", "Sep",  
                           "Okt", "Nov", "Des");  
        endif;                     
 		
        $tahun = substr($date, 0, 4);  
        $bulan = substr($date, 5, 2);  
        $tgl   = substr($date, 8, 2);  
        $tgl=(int)$tgl;  
        $result = $tgl . " " . $arrBulan[(int)$bulan-1] . " ". $tahun;       
        return($result);  
 }  
 
 function indo2date($indoDate,$mode=1){
   if($mode==1):
            $arrBulan = array("Januari", "Februari", "Maret",  
                           "April", "Mei", "Juni",  
                           "Juli", "Agustus", "September",  
                           "Oktober", "November", "Desember");  
        endif;  
        if($mode=2):
            $arrBulan = array("Jan", "Feb", "Mar",  
                           "Apr", "Mei", "Jun",  
                           "Jul", "Agu", "Sep",  
                           "Okt", "Nov", "Des");  
        endif;   
	$arrBulan=array_map("strtolower",$arrBulan);
 	$arrMonth=array_combine(array_values($arrBulan),array_keys($arrBulan));
	
	$indoDate=trim(preg_replace("/\s+/i","|",$indoDate));
	$arrTanggal=explode("|",$indoDate);
	$arrTanggal=array_map("trim",$arrTanggal);
	
	list($tanggal,$strBulan,$tahun)=$arrTanggal;
	$tanggal=str_pad($tanggal,2,0,STR_PAD_LEFT);
	$bulan=$arrMonth[strtolower($strBulan)]+1;
	
	$date="$tahun-".$bulan."-$tanggal";
	return $date;
	
 }
 
 if (!function_exists('appname')):
 	function appname(){
		$CI=& get_instance();
		return $CI->config->item("appname");
	}
 endif;
	
 /* map bulan function */
 if (!function_exists('GetBulan')):
 function GetBulan($i){
		$mapBulan=array("januari","pebruari","maret","april","mei","juni","juli","agustus","september","oktober","nopember","desember");
		return $mapBulan[$i-1];
 }
 endif;
	
	/* format uang */
 if (!function_exists('MoneyFormat')):
 function MoneyFormat($data){
		return number_format($data,2,$config["sparator_decimal"],$config["sparator_digit"]);
 }
 endif;
 
  if (!function_exists('num2indo')):
 function num2indo($data,$decLength=0,$decSparator=".",$digitSparator=","){
		return number_format($data,$decLength,$decSparator,$digitSparator);
 }
 endif;
 
 if (!function_exists('loadFunction')):
	function loadFunction( $name=null ){
		if ($name) :
		require_once (FCPATH."assets/loader/$name.function.php")	;
		endif;
 	}
 endif;


 if (!function_exists('loadFunctionRepeat')):
	function loadFunctionRepeat($name=null ) {
		if ($name):
			require (FCPATH."assets/loader/$name.function.php");
		endif;
	}
 endif;



 function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
    /*
    $interval can be:
    yyyy - Number of full years
    q - Number of full quarters
    m - Number of full months
    y - Difference between day numbers
        (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d - Number of full days
    w - Number of full weekdays
    ww - Number of full weeks
    h - Number of full hours
    n - Number of full minutes
    s - Number of full seconds (default)
    */
    
    if (!$using_timestamps) {
        $datefrom = strtotime($datefrom, 0);
        $dateto = strtotime($dateto, 0);
    }
    $difference = $dateto - $datefrom; // Difference in seconds
     
    switch($interval) {
     
    case 'yyyy': // Number of full years

        $years_difference = floor($difference / 31536000);
        if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
            $years_difference--;
        }
        if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
            $years_difference++;
        }
        $datediff = $years_difference;
        break;

    case "q": // Number of full quarters

        $quarters_difference = floor($difference / 8035200);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $quarters_difference--;
        $datediff = $quarters_difference;
        break;

    case "m": // Number of full months

        $months_difference = floor($difference / 2678400);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $months_difference--;
        $datediff = $months_difference;
        break;

    case 'y': // Difference between day numbers

        $datediff = date("z", $dateto) - date("z", $datefrom);
        break;

    case "d": // Number of full days

        $datediff = floor($difference / 86400);
        break;

    case "w": // Number of full weekdays

        $days_difference = floor($difference / 86400);
        $weeks_difference = floor($days_difference / 7); // Complete weeks
        $first_day = date("w", $datefrom);
        $days_remainder = floor($days_difference % 7);
        $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
        if ($odd_days > 7) { // Sunday
            $days_remainder--;
        }
        if ($odd_days > 6) { // Saturday
            $days_remainder--;
        }
        $datediff = ($weeks_difference * 5) + $days_remainder;
        break;

    case "ww": // Number of full weeks

        $datediff = floor($difference / 604800);
        break;

    case "h": // Number of full hours

        $datediff = floor($difference / 3600);
        break;

    case "n": // Number of full minutes

        $datediff = floor($difference / 60);
        break;

    default: // Number of full seconds (default)

        $datediff = $difference;
        break;
    }    

    return $datediff;

	}

 /*
 * check if curl support
 */
 function _iscurlsupported() {
	if  (in_array  ("curl", get_loaded_extensions())) {
		return true;
	}
	else{
		return false;
	}
 }
 /*
	 format output function: 
	 html as output,
	 json as json type,
	 array as array data
	 no as with no return
	 default as return status
 */
 function return_format($format="",$status=FALSE,$data=array()){
		$ok=$status;
		$html="";
		$ret=array();
		if($ok):
			$ret["status"]="ok";
			$ret["msg"]="Kirim SMS OK";
			$ret["data"]=$data;
		else:
			$ret["status"]="failed";
			$ret["status"]="Kirim SMS Gagal kontak admin!!";
			$ret["data"]=array();
		endif;
		
		switch(strtolower($format)):
			case 'json':
				echo json_encode($ret);
				break;
				
			case 'html':
				print $ret["status"];
				break;
				
			case "no":
				print "";
				break;
				
			case 'array':
				return $ret["data"];
				break;
				
			default:
				return $ok;
		endswitch;
		
	
}


function num_from_str($str){
	return preg_replace("/[^0-9]/","",$str);
}


function cek_array($arr){
	if((is_array($arr))&&(count($arr)>0)):
		$ret=true;
	else:
		$ret=false;
	endif;
	return $ret;
}

function loadBreadCumbs2($arrBread=false){
	$sparator="<span class=\"divider\">/</span>";
	
	$str= "<ul class='breadcrumb'>";
	$str.= "<li><a href=\"/home\" rel=\"".base_url()."dashboard\"><i class='icon-home'></i> Home</a></li>";
	$str.=$sparator;
	$status=cek_array($arrBread);
	if($status==true):
	foreach($arrBread as $x=>$value):
		$str.="<li>";
		
		if($x==(count($arrBread)-1)):
			$str.=$value["text"];
			continue;
		endif;
		if($value["url"]!=""):
			$str.="<a href=\"/".$value["text"]."\" rel=\"".$value["url"]."\">".$value["text"]."</a>";
			//$str.="<a href=\"/".$value["text"]." rel=\"".$value["url"]."\">".$value["text"]."</a>";
			$str.=$sparator;
		else:
			$str.="<a href=\"/".$value["text"]."\" rel=\"\">".$value["text"]."</a>";
			//$str.="<a href=\"/".$value["text"]."\" rel=''>".$value["text"]."</a>";
		endif; 
		$str.="</li>";
	endforeach;
	endif;
	$str.="</ul>";
	
	$str.="<script>
	$(document).ready(function(){
		$(\".breadcrumb a\").live(\"click\",function(e){
			e.preventDefault();
			var url=$(this).attr(\"rel\");
			if(url!=\"\"){
				location=url;
			}
			return false;
		});
	});
	</script>";
	print $str;
}

function loadBreadCumbs($arrBread=false){
	$str= "<ul id=\"crumbs\">";
	$str.= "<li><a href=\"/home\" rel=\"".HOME_URL."dashboard/dashboard\">Dashboard</a></li>";
	$status=cek_array($arrBread);
	if($status==true):
	foreach($arrBread as $x=>$value):
		$str.="<li>";
		if($x==(count($arrBread)-1)):
			$str.=$value["text"];
			continue;
		endif;
		if($value["url"]!=""):
			$str.="<a href=\"/".$value["text"]."\" rel=\"".$value["url"]."\">".$value["text"]."</a>";
		else:
			$str.="<a href=\"/".$value["text"]."\" rel=\"\">".$value["text"]."</a>";
		endif; 
		$str.="</li>";
	endforeach;
	endif;
	$str.="</ul>";
	
	$str.="<script>
	$(document).ready(function(){
		$(\"#crumbs a\").live(\"click\",function(e){
			e.preventDefault();
			var url=$(this).attr(\"rel\");
			if(url!=\"\"){
				location=url;
			}
			return false;
		});
	});
	</script>";
	print $str;
}

function upload_services(){
	if(isset($_FILES)==true):
	 	//$uploaddir = base_url()."upload/"; 
		$uploaddir = "upload/"; 
	
		$userFileLength=count($_FILES["userfile"]['name']);
		for($i=0;$i<$userFileLength;$i++):
			$file = $uploaddir . basename($_FILES['userfile']['name'][$i]);
			if (move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $file)) { 
				$ret["success"][]=$_FILES['userfile']['name'][$i]; 
			} else {
				$ret["error"][]=$_FILES['userfile']['name'][$i];
			}
		endfor;
	 endif;
	 $retjson=json_encode($ret);
	 print $retjson;
}

function single_upload_service(){
	//$uploaddir = base_url().'uploads/';  
	$uploaddir = 'uploads/';
	$file = $uploaddir . basename($_FILES['uploadfile']['name']);   
	if (move_uploaded_file($_FILES['user_file']['tmp_name'], $file)) {  
	  $ret["success"]=$_FILES['userfile']['name'];  
	} else {  
	  $ret["error"]=$_FILES['userfile']['name']; 
	}
	$retjson=json_encode($ret);
	print $retjson;  
}

function copy_file($jenis_doc="uploads"){
	//$uploaddir = base_url()."uploads/";
	//$destdir= base_url()."docs/".$jenis_doc."/";
	$uploaddir = "uploads/";
	$destdir= "docs/".$jenis_doc."/";
	$filename=isset($_POST["filename"])?basename($_POST["filename"]):"";
	if($filename!==""):
		if(is_file($destdir.$filename)):
			rename($destdir.$filename,$destdir.$filename."_".date("YmdHis").".bak");
		endif;
		if(!copy($uploaddir.$filename,$destdir.$filename)):
			return false;
		else:
			return true;
		endif;
	endif;
}


function check_folder($path){
	if(!is_dir($path)) //create the folder if it's not already exists
    {
      mkdir($path,0777,TRUE);
	  //mkdir($path,0755,TRUE);
    } 
}


function timeBetween($start,$end){
    $time = $end - $start;
 
    if($time <= 20){
        return 'baru saja';
    }
	if($time <= 20){
        return 'kurang dari semenit';
    }
    if(60 < $time && $time <= 3600){
        return round($time/60,0).' menit yang lalu';
    }
    if(3600 < $time && $time <= 86400){
        return round($time/3600,0).' jam yang lalu';
    }
    if(86400 < $time && $time <= (86400*2)){
        return 'kemaren';
    }
	if(86400*2 < $time && $time <= 604800){
        return round($time/86400,0).' hari yang lalu';
    }
    if(604800 < $time && $time <= 2592000){
        return round($time/604800,0).' minggu yang lalu';
    }
    if(2592000 < $time && $time <= 29030400){
        return round($time/2592000,0).' bulan yang lalu';
    }
    if($time > 29030400){
        return date('M d y at h:i A',$start);
    }
}

/*
function relativeTime($dt,$precision=2)
{
	if(is_string($dt)) $dt=strtotime($dt);

	$times=array(	365*24*60*60	=> "tahun",
					30*24*60*60		=> "bulan",
					7*24*60*60		=> "minggu",
					24*60*60		=> "hari",
					60*60			=> "jam",
					60				=> "menit",
					1				=> "detik");
	
	$passed=time()-$dt;
	
	if($passed<5)
	{
		$output='baru';
	}
	else
	{
		$output=array();
		$exit=0;
		
		foreach($times as $period=>$name)
		{
			if($exit>=$precision || ($exit>0 && $period<60)) break;
			
			$result = floor($passed/$period);
			if($result>0)
			{
				$output[]=$result.' '.$name.($result==1?'':'');
				$passed-=$result*$period;
				$exit++;
			}
			else if($exit>0) $exit++;
		}
				
		//$output=implode(' and ',$output).' yang lalu';
		$output=implode(' ',$output).' yang lalu';
	}
	
	return $output;
}
*/
    function plural($num) {
    if ($num != 1)
    return "s";
    }
     
    function relativeTime($dt,$format="d M Y") {
		if(is_string($dt)) $dt=strtotime($dt);
		$diff = time() - $dt;
		if ($diff<60)
		return $diff . " second" . plural($diff) . " ago";
		$diff = round($diff/60);
		if ($diff<60)
		return $diff . " minute" . plural($diff) . " ago";
		$diff = round($diff/60);
		if ($diff<24)
		return $diff . " hour" . plural($diff) . " ago";
		$diff = round($diff/24);
		if ($diff<7)
		return $diff . " day" . plural($diff) . " ago";
		/*
		$diff = round($diff/7);
		if ($diff<4)
		return $diff . " week" . plural($diff) . " ago";
		*/
		return "" . date($format, $dt);
 }


/*
function relativeTime($time,$precision=2) {
	if(is_string($time)) $time=strtotime($time);
	
    $d[0] = array(1,"second");
    $d[1] = array(60,"minute");
    $d[2] = array(3600,"hour");
    $d[3] = array(86400,"day");
    $d[4] = array(604800,"week");
    $d[5] = array(2592000,"month");
    $d[6] = array(31104000,"year");

    $w = array();

    $return = "";
    $now = time();
    $diff = ($now-$time);
    $secondsLeft = $diff;

    for($i=6;$i>-1;$i--)
    {
         $w[$i] = intval($secondsLeft/$d[$i][0]);
         $secondsLeft -= ($w[$i]*$d[$i][0]);
         if($w[$i]!=0)
         {
            $return.= abs($w[$i]) . " " . $d[$i][1] . (($w[$i]>1)?'s':'') ." ";
         }

    }

    $return .= ($diff>0)?"ago":"left";
    return $return;
}*/

function formatBeritaPrinsip($data)
{
    $dt=$data["created"];
	if(is_string($dt)) $dt=strtotime($dt);

	$message=htmlspecialchars(stripslashes($data["message"]));
    $txtStatus=isset($data["txt_status"])?$data["txt_status"]:"";
	return'
	<li id="msg_'.$data["idx"].'">
	<a href="#">'.image_asset("user.png",'',array("class"=>"avatar","alt"=>"Image")).' </span></a>
	<div class="tweetTxt">
	<strong><a href="#">'.$data["message_from"].'</a>
	<br>No.Surat:'.$data["no_permohonan"].'
	<br>Status:('.$data["status"].')'.$txtStatus.'<br></strong>
	 '. preg_replace('/((?:http|https|ftp):\/\/(?:[A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?[^\s\"\']+)/i','<a href="$1" rel="nofollow" target="blank">$1</a>',nl2br($message)).'
	<div class="date">'.relativeTime($dt).'</div>
	</div><span style="float:right"><a class="btnDeleteMessage" href="#" rel="'.$data["idx"].'"><span style="width:12px" class="iconize icon_del"></span></a></span>
	<div class="clear"></div>
	</li>';
}


/**
 *  setDocReaderOne
 * 
 *  setting doc reader for column doc reader one row
 * 
 *  @param int $groupID is idx of group 
 *  @param int $perusahaanID is idx perusahaan
 *  @param int $userID is idx of user
 *  @Return string
 * 
*/

function setDocReaderOne($groupID='',$perusahaanID='',$userid=''){
    return 'G_'.$groupID.'.P_'.$perusahaanID.'.U_'.$userid;    
}

/**
 *  setDocReader
 * 
 *  setting doc reader for column doc reader doc editor
 *  
 *  @param array $arrGroupPerusahaanID  is array that contain 
 *  group perusahaan and user
 * 
 *  Example:
 *  data=array("group"=>"gr","perusahaan"=>"pr","user"=>"us")
 *   
 *  
 * 
*/
function setDocReader($arrGroupPerusahaanUserID){
    foreach($arrGroupPerusahaanUserID as $x => $value):
        $ret[]=setDocReaderOne($value["group"],$value["perusahaan"],$value["user"]) ;       
    endforeach;
    return implode(",",$ret);
   
}

/**
 *  getDocReader
 * 
 *  get DocReader Array from column doc reader doc editor
 * 
 *  @param string $docReader  is string that 
 *  contain group perusahaan and user
 *  $docReader="G_gr.P_pr.U_us,G_gr1.P_pr1.U_us1"
 *  @Return array
 * 
*/

function getDocReader($docReader){
    $arrDocReader=explode(",",$docReader);
    for($i=0;$i<count($arrDocReader);$i++):
        $arr=explode(".",$arrDocReader[$i]);
        $data["group"]=str_replace('G_','',$arr[0]);
        $data["perusahaan"]=str_replace('P_','',$arr[1]);
        $data["user"]=str_replace('U_','',$arr[2]);
        $ret[]=$data;
    endfor;
    
    return $ret;
}


function getDefaultDJPBDocAccess(){
        return "G_1.P_0.U_0"; 
}

function getDefaultUserAccess(){
        $user=isset($_SESSION["userdata"])?$_SESSION["userdata"]:"";
        if($user!=""):
            $ret=setDocReaderOne($user["group_id"],$user["id_perusahaan"],$user["idx"]);
        else:
            $ret="";
        endif;    
        return $ret;
}

function mpdf_create($html, $filename='', $stream=true) 
{
    $ci =& get_instance();
    $ci->load->library("mpdf");
    $ci->mpdf->WriteHTML($html);
    if ($stream) {
        $ci->mpdf->Output(); 
    } else {
        $ci->mpdf->Output($filename.".pdf","D");
    }
}

//randomString(8,'alphanumeric');
//randomString(8,'0392ie0kls');
function randomString($length = 10, $chars = '1234567890') {

    // Alpha lowercase
    if ($chars == 'alphalower') {
        $chars = 'abcdefghijklmnopqrstuvwxyz';
    }

    // Numeric
    if ($chars == 'numeric') {
        $chars = '1234567890';
    }

    // Alpha Numeric
    if ($chars == 'alphanumeric') {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    }

    // Hex
    if ($chars == 'hex') {
        $chars = 'ABCDEF1234567890';
    }

    $charLength = strlen($chars)-1;

    for($i = 0 ; $i < $length ; $i++)
        {
            $randomString .= $chars[mt_rand(0,$charLength)];
        }

    return $randomString;
}

// Function to create a new random token
// e.g. createKey(3, 4,'UG8D-')
// Might produce: UG8D-6T8Y-FCK7-09PL
function createKey($sections=3, $sectionlength=4,$tokenprefix='')
{
	// Declare salt and prefix
	$key .= $tokenprefix;
	$salt = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';

	// Prepare randomizer
	srand((double) microtime() * 1000000);

	// Create the token
	for($i = 0; $i < $sections; $i++)
	{
		for($n = 0; $n < $sectionlength; $n++)
		{
			$key.=substr($salt, rand() % strlen($salt), 1);
		}

		if($i < ($sections - 1)){ $token .= '-'; }
	}

	// Return the token
	return $key;
}


function createSimpleKey($length=10)
{
	$key = '';
	list($usec, $sec) = explode(' ', microtime());
	mt_srand((float) $sec + ((float) $usec * 100000));
	
   	$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));

   	for($i=0; $i<$length; $i++)
	{
   	    $key .= $inputs{mt_rand(0,61)};
	}
	return $key;
}


function cleanAllRequestData(){
	$_POST=cleanup($_POST);
	$_GET=cleanup($_GET);
	$_REQUEST=cleanup($_REQUEST);
}


function sanitizeAllRequestData(){
	$_POST=sanitize($_POST);
	$_GET=sanitize($_GET);
	$_REQUEST=sanitize($_REQUEST);
}


 function cleanInput($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@',         // Strip multi-line comments
	"/[\s\S].--/" //strip sql injection
  );
 
    $output = preg_replace($search, '', $input);
    return $output;
 }
 

 function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        //$output = mysql_real_escape_string($input);
		if(function_exists("mysql_real_escape_string")) 
		{
			$output= mysql_real_escape_string( $input);
		}else{
			$output = addslashes($input);
		}
    }
    return $output;
}

/*
function sanitize($input){
    if(is_array($input)){
        foreach($input as $k=>$i){
            $output[$k]=sanitize($i);
        }
    }
    else{
        if(get_magic_quotes_gpc()){
            $input=stripslashes($input);
        }        
        
		$output=pg_escape_string($input);
    }    
    
    return $output;
}
*/


/*
 clean all input
$_POST=cleanup($_POST);
$_GET=cleanup($_GET);
$_COOKIE=cleanup($_COOKIE);
$_REQUEST=cleanup($_REQUEST);
$_SERVER['QUERY_STRING']=cleanup($_SERVER['QUERY_STRING']);
*/
function cleanvals($myval) {
   //$myval=trim(htmlentities($myval, ENT_QUOTES, 'UTF-8'));
   $myval=trim(htmlentities($myval));
   //$data = trim(htmlentities(strip_tags($data)));
   if(get_magic_quotes_gpc()){
      $myval=stripslashes($myval);
      //get rid of triple slashes mysql_real_escape_string would create
   }
   return $myval;
}

function cleanup($myinput){
    if(is_array($myinput)){
      foreach($myinput as $key=>$val){
         $myinput[$key] = cleanvals($val);
      }
	  return array_map("addslashes",$myinput);
	  //return array_map("pg_escape_string",$myinput);
	  //return array_map("pg_escape_string",$myinput);
    }
    else{
      $myinput=cleanvals($myinput);
	  return addslashes($myinput);
      //return pg_escape_string($myinput);
    }
}

/* clean up data ver lain */
/* $cleanPost = array_map('confHtmlEnt', $_POST);*/
function confHtmlEnt($data)
{
    return htmlentities($data, ENT_QUOTES, 'UTF-8');
}

function stripSlash($row){
	$escaped = array_map('stripslashes', $row);
	return $escaped;
}


/*$_POST = array_map('cleanData', $_POST);*/
function cleanData($data) {
	$data = trim($data);
	$data = htmlentities($data);
	$data = mysql_real_escape_string($data);
	return $data;
}



function cleanDataForDB($data,$quotes=0,$exchars='') {
	$data = trim(htmlentities(strip_tags($data)));

	if (get_magic_quotes_gpc())
		$data = stripslashes($data);

	//check if this function exists
  	if(function_exists("mysql_real_escape_string")) 
  	{
   		$data= mysql_real_escape_string( $data);
  	}
  	//for PHP version < 4.3.0 use addslashes
  	else 
  	{
   		//$data= addslashes( $data);
		if (!is_numeric($data)) {
          $str = addslashes($data);
          $str = str_replace("\r",chr(92).'r',$data);
          $str = str_replace("\n",chr(92).'n',$data);
          if (!empty($exchars))
          for ($i=0; $i<strlen($exchars); $i++)
             $str = str_replace($exchars[$i],chr(92).$exchars[$i],$data);
          if ($quotes)
          $str = "'".$data."'";
         } 
  	}
	
	return $data;
}


function sql_escape_string($data,$quotes=0,$exchars = ''){
	if(function_exists("mysql_real_escape_string")) 
  	{
   		$data= mysql_real_escape_string( $data);
  	}
  	//for PHP version < 4.3.0 use addslashes
  	else 
  	{
   		//$data= addslashes( $data);
		if (!is_numeric($data)) {
          $str = addslashes($data);
          $str = str_replace("\r",chr(92).'r',$data);
          $str = str_replace("\n",chr(92).'n',$data);
          if (!empty($exchars))
          for ($i=0; $i<strlen($exchars); $i++)
             $data = str_replace($exchars[$i],chr(92).$exchars[$i],$data);
          if ($quotes)
          $data = "'".$data."'";
         } 
  	}
	
	return $data;
}


function xss_clean($string){

    if( is_array( $string ) ){

    	$return_array = array();

        foreach( $string as $key => $item )
        {
			print $item;
            if(!get_magic_quotes_gpc())
            {
                $return_array[$key] =  addslashes( htmlspecialchars( strip_tags( $item ) ) );
            }
            else
            {
                $return_array[$key] =  htmlspecialchars( strip_tags( $item ) );
            }
        }
            return $return_array;
    }
    else
    {
        return htmlspecialchars( strip_tags( $string ) );
    }
}


function time_start(){
	$CI=& get_instance();
	$CI->benchmark->mark('code_start');
}

function time_stop(){
	$CI=& get_instance();
	echo $CI->benchmark->elapsed_time('code_start', 'code_end');
}


function TrimArray($Input){
 
    if (!is_array($Input))
        return trim($Input);
 
    return array_map('TrimArray', $Input);
}

function array_trim($ar){
  
  foreach($ar as $key=>$val)
    if(empty($ar[$key]))
      unset($ar[$key]);
       
  return $ar;
};  

    /************** 
    *@length - length of random string (must be a multiple of 2) 
    **************/  
    function readable_random_string($length = 6){  
        $conso=array("b","c","d","f","g","h","j","k","l",  
        "m","n","p","r","s","t","v","w","x","y","z");  
        $vocal=array("a","e","i","o","u");  
        $password="";  
        srand ((double)microtime()*1000000);  
        $max = $length/2;  
        for($i=1; $i<=$max; $i++)  
        {  
        $password.=$conso[rand(0,19)];  
        $password.=$vocal[rand(0,4)];  
        }  
        return $password;  
    }  
	
	
	    /************* 
    *@l - length of random string 
    */  
    function generate_rand($l=8){  
      $c= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";  
      srand((double)microtime()*1000000);  
      for($i=0; $i<$l; $i++) {  
          $rand.= $c[rand()%strlen($c)];  
      }  
      return $rand;  
     }  
	 
	 
	function GetIPAddress()  
    {  
        if (!empty($_SERVER['HTTP_CLIENT_IP']))  
        {  
            $ip=$_SERVER['HTTP_CLIENT_IP'];  
        }  
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
        //to check ip is pass from proxy  
        {  
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
        else  
        {  
            $ip=$_SERVER['REMOTE_ADDR'];  
        }  
        return $ip;  
    }  
	
	
	/******************** 
    *@file - path to file 
    */  
	
    function force_download_file($file)  
    {  
        if ((isset($file))&&(file_exists($file))) {  
           header("Content-length: ".filesize($file));  
           header('Content-Type: application/octet-stream');  
           header('Content-Disposition: attachment; filename="' . $file . '"');  
           readfile("$file");  
        } else {  
           echo "No file selected";  
        }  
    } 
	 
	
	
	// Original PHP code by Chirp Internet: www.chirp.com.au  
	// Please acknowledge use of this code by including this header.  
	function myTruncate($string, $limit, $break=".", $pad="...") {  
		// return with no change if string is shorter than $limit  
		if(strlen($string) <= $limit)  
			return $string;   
	  
		// is $break present between $limit and the end of the string?  
		if(false !== ($breakpoint = strpos($string, $break, $limit))) {  
			if($breakpoint < strlen($string) - 1) {  
				$string = substr($string, 0, $breakpoint) . $pad;  
			}  
		}  
		return $string;  
	}  
	/***** Example ****/  
	//$short_string=myTruncate($long_string, 100, ' '); 
	
	
	    /********************** 
    *@filename - path to the image 
    *@tmpname - temporary path to thumbnail 
    *@xmax - max width 
    *@ymax - max height 
    */  
    function resize_image($filename, $tmpname, $xmax, $ymax)  
    {  
        $ext = explode(".", $filename);  
        $ext = $ext[count($ext)-1];  
      
        if($ext == "jpg" || $ext == "jpeg")  
            $im = imagecreatefromjpeg($tmpname);  
        elseif($ext == "png")  
            $im = imagecreatefrompng($tmpname);  
        elseif($ext == "gif")  
            $im = imagecreatefromgif($tmpname);  
      
        $x = imagesx($im);  
        $y = imagesy($im);  
      
        if($x <= $xmax && $y <= $ymax)  
            return $im;  
      
        if($x >= $y) {  
            $newx = $xmax;  
            $newy = $newx * $y / $x;  
        }  
        else {  
            $newy = $ymax;  
            $newx = $x / $y * $newy;  
        }  
      
        $im2 = imagecreatetruecolor($newx, $newy);  
        imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);  
        return $im2;  
    }  
	
	
function random_password1($len=8) {
    $chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   	srand((double)microtime()*1000000);

    $i = 0;
	$pass = '' ;
  	while ($i <= $len) {

        $num = rand() % 33;

        $tmp = substr($chars, $num, 1);

        $pass = $pass . $tmp;

        $i++;
	}
  	return $pass;

}

function random_password($cnt=8)
{
	// characters to be included for randomization, 
	$chars= str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
	// Here specify the 2nd parameter as start position, it can be anything, default 0
	return substr($chars,0,$cnt);
}


/* http://wiki.jumba.com.au/wiki/PHP_Generate_random_password */
function random_password2($PwdLength=8, $PwdType='standard')
    {
    // $PwdType can be one of these:
    //    test .. .. .. always returns the same password = "test"
    //    any  .. .. .. returns a random password, which can contain strange characters
    //    alphanum . .. returns a random password containing alphanumerics only
    //    standard . .. same as alphanum, but not including l10O (lower L, one, zero, upper O)
    //
    $Ranges='';
 
    if('test'==$PwdType)         return 'test';
    elseif('standard'==$PwdType) $Ranges='65-78,80-90,97-107,109-122,50-57';
    elseif('alphanum'==$PwdType) $Ranges='65-90,97-122,48-57';
    elseif('any'==$PwdType)      $Ranges='40-59,61-91,93-126';
 
    if($Ranges<>'')
        {
        $Range=explode(',',$Ranges);
        $NumRanges=count($Range);
        mt_srand(time()); //not required after PHP v4.2.0
        $p='';
        for ($i = 1; $i <= $PwdLength; $i++)
            {
            $r=mt_rand(0,$NumRanges-1);
            list($min,$max)=explode('-',$Range[$r]);
            $p.=chr(mt_rand($min,$max));
            }
        return $p;			
        }
    }
	
	function ci_random_password($length=8){
		$CI=& get_instance();
		$CI->load->helper("string");
		$is_numeric=0;
		$is_numeric=0;
		$pass=random_string('alnum',$length);
		//$is_special = preg_match('/[+#!\?]/', $pass); //sample only
		
		$is_numeric = preg_match('/[0-9]/', $pass);
		$is_char = preg_match('/[a-zA-Z]/', $pass);
		$val=$is_char+$is_numeric;
		if ($val < 2) {
    		return ci_random_password($length);
		}
		return $pass;
		
	}
	
	function createRandomString($length = 8, $type = "")
	{
			$alphabets = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$numbers = "1234567890";
			$symbols = "!@#$%^*()+?";
	 
			switch(strtoupper($type))
			{
				case 'ALPHANUMSYM': $charString = $alphabets . strtolower($alphabets) . $numbers . $symbols; break;
				case 'ALPHANUM': $charString = $alphabets . strtolower($alphabets) . $numbers; break;
				case 'UPPERALPHANUMSYM': $charString = $alphabets . $numbers . $symbols; break;
				case 'LOWERALPHANUMSYM': $charString = strtolower($alphabets) . $numbers . $symbols; break;
				case 'ALPHASYM': $charString = $alphabets . strtolower($alphabets) . $symbols; break;
				case 'ALPHA': $charString = $alphabets . strtolower($alphabets); break;
				case 'LOWERALPANUM': $charString = strtolower($alphabets) . $numbers; break;
				case 'UPPERALPHANUM': $charString = $alphabets . $numbers; break;
				case 'NUMSYM': $charString = $numbers . $symbols; break;
				case 'LOWERALPHASYM': $charString = strtolower($alphabets) . $symbols; break;
				case 'UPPERALPHASYM': $charString = $alphabets . $symbols; break;
				case 'LOWERALPHA':$charString = strtolower($alphabets); break;
				case 'UPPERALPHA': $charString = $alphabets; break;
				case 'NUM': $charString = $numbers; break;
				case 'SYM': $charString = $symbols; break;
				default: $charString = $alphabets . strtolower($alphabets) . $numbers . $symbols;
			}
			 
			srand((double)microtime() * 1000000);
			$count = 1;
			$randomString = "";
			 
			while ($count <= $length)
			{
					$startChar = rand(0, strlen($charString) - 1);
					$tempChar = substr($charString, $startChar, 1);
					$randomString = $randomString . $tempChar;
					$count++;      
			}
	 
			return $randomString;
	}
	
	 //get full base url for email or other needed dns base url
	 function getBaseURL(){
	 	 $baseURL=base_url();
		 $url=selfURL();
		 $isHttp=preg_match("/^(http|https)/",$baseURL);
		 if($isHttp):
			return $baseURL;
		 else:
			return substr($url,0,strpos($url,$baseURL)).$baseURL;
		 endif;
	 }	
	 
	 // Get the full URL of the current page
	function current_page_url(){
		$page_url   = 'http';
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
				$page_url .= 's';
		}
		return $page_url.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}
	
	function get_referrer(){
		/* (Assuming session already started) */
		if(isset($_SESSION['referrer'])){
			// Get existing referrer
			$referrer   = $_SESSION['referrer'];
		
		} elseif(isset($_SERVER['HTTP_REFERER'])){
			// Use given referrer
			$referrer   = $_SERVER['HTTP_REFERER'];
		
		} else {
			$referrer=FALSE;
		}	
		return $referrer;
	}
	
	function set_referrer(){
		$_SESSION['referrer']  = current_page_url();
	}
	
	function unset_referrer(){
		if(isset($_SESSION["referrer"])):
			unset($_SESSION["referrer"]);
		endif;
	}
		
	 //Get Full URL
	 function selfURL(){
		if(!isset($_SERVER['REQUEST_URI'])){
			$serverrequri = $_SERVER['PHP_SELF'];
		}else{
			$serverrequri =    $_SERVER['REQUEST_URI'];
		}
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;   
	}
	
	 function GetServerURI(){
		if(!isset($_SERVER['REQUEST_URI'])){
			$serverrequri = $_SERVER['PHP_SELF'];
		}else{
			$serverrequri =    $_SERVER['REQUEST_URI'];
		}
		return $serverrequri;   
	}	
	
	 function GetServerURL(){
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol."://".$_SERVER['SERVER_NAME'].$port;   
	}
	
	function GetCurrentURL(){
		return selfURL();
	}

	function strleft($s1, $s2) {
		return substr($s1, 0, strpos($s1, $s2));
	}
	
	
	function search_engine_query_string($url = false) {

		if(!$url && !$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false) {
			return '';
		}
	
		$parts_url = parse_url($url);
		$query = isset($parts_url['query']) ? $parts_url['query'] : (isset($parts_url['fragment']) ? $parts_url['fragment'] : '');
		if(!$query) {
			return '';
		}
			parse_str($query, $parts_query);
		return isset($parts_query['q']) ? $parts_query['q'] : (isset($parts_query['p']) ? $parts_query['p'] : '');

	}
	
	function growl_message($msg){
		$ci=& get_instance();
		$ci->session->set_flashdata('growl_message', $msg);
	}
	
	function sticky_message($msg){
		$ci=& get_instance();
		$ci->session->set_flashdata('sticky_message', $msg);
	}
	
	
	function allhtmlentities($string,$decode_first=true) {
	   // this is to ensure that any entities already coded are not "messed up"
	   if($decode_first) $string = html_entity_decode($string);
	   // "encode"
	   return preg_replace(
	'/([^\x09\x0A\x0D\x20-\x7F]|[\x21-\x2F]|[\x3A-\x40]|[\x5B-\x60])/e'
			  , '"&#".ord("$0").";"', $string);
	 }
	 
	 function parseTable($html)
	 {
	  // Find the table
	  preg_match("/<table.*?>.*?<\/[\s]*table>/s", $html, $table_html);
	 
	  // Get title for each row
	  preg_match_all("/<th.*?>(.*?)<\/[\s]*th>/", $table_html[0], $matches);
	  $row_headers = $matches[1];
	 
	  // Iterate each row
	  preg_match_all("/<tr.*?>(.*?)<\/[\s]*tr>/s", $table_html[0], $matches);
	 
	  $table = array();
	 
	  foreach($matches[1] as $row_html)
	  {
		preg_match_all("/<td.*?>(.*?)<\/[\s]*td>/", $row_html, $td_matches);
		$row = array();
		for($i=0; $i<count($td_matches[1]); $i++)
		{
		  $td = strip_tags(html_entity_decode($td_matches[1][$i]));
		  $row[$row_headers[$i]] = $td;
		}
	 
		if(count($row) > 0)
		  $table[] = $row;
	  }
	  return $table;
	}
	
	
	function array_to_excel($array, $filename='xlsoutput')
	{
		 $headers = ''; // variable untuk menampung header
		 $data = ''; // variable untuk menampung data
	 
		 $obj =& get_instance();
	 
		 //$fields = $query->field_data();
		 if (sizeof($array) == 0) {
			  echo 'The table appears to have no data.';
		 } else {
			  foreach ($array as $row) {
				   $line = '';
				   foreach($row as $value) {
						if ((!isset($value)) OR ($value == "")) {
							 $value = "\t";
						} else {
							 $value = str_replace('"', '""', $value);
							 $value = '"' . $value . '"' . "\t";
						}
						$line .= $value;
				   }
				   $data .= trim($line)."\n";
			  }
	 
			  $data = str_replace("\r","",$data);
	 
	 
			header('Content-type: application/ms-excel');
			header("Content-Disposition: attachment; filename=$filename.xls");
			echo $data;
		 }
	}
	
	
	function arr_to_text($arr,$strjoin=","){
		$ret=join($strjoin,$arr);
		return $ret;
	}
	
	function text_to_arr($str){
		$arr=preg_split("/[\,\:\|]+/i",$str);
		foreach($arr as $val):
			if(!empty($val)):
				$ret[]=$val;
			endif;
		endforeach;
		return $ret;
	}
	
	//array("A","B","C") to [A][B][C]=C;
	function flat2nested($tmpArr,$val=""){
		$arr = array();
		$ref = &$arr;
		foreach ($tmpArr as $key) {
			$ref[$key] = array();
			$ref = &$ref[$key];
		}
		$ref = !empty($val)?$val:$key;
		$tmpArr = $arr;
		return $tmpArr;
	}
	
	
	
	//convert $[A][B][C]=val to $[A.B.C]=val
	function nested2flatWithFormat($array, $prefix = null) {
	  if ($prefix) $prefix .= '.';
	
	  $items = array();
	
	  foreach ($array as $key => $value) {
		if (is_array($value))
		  $items = array_merge($items,  flatten_array($value, $prefix . $key));
		else
		  $items[$prefix . $key] = $value;
	  }
	
	  return $items;
	}
	
	function flatWithFormat2nested($input) {
	// Start out with an empty array.
		$arr = array();
		foreach($input as $k => $v) {
		// This turns 'a.b' into array('a', 'b')
			$key_parts = explode('.', $k);
		// Here's the magic.  PHP references aren't to values, but to
		// the variables that contain the values.  This lets us point at
		// array keys without a problem.  Sometimes this gets in the way...
			$ref = &$arr;
			foreach($key_parts as $part) {
			// If we didn't already turn the thing we're refering to into an array, do so.
				if(!is_array($ref))
					$ref = array();
			// If the key doesn't exist in our reference, create it as an empty array
				if(!array_key_exists($part, $ref))
					$ref[$part] = array();
			// Reset the reference to our new array.
				$ref = &$ref[$part];
			}
		// Now that we're pointing deep into the nested array, we can
		// set the inner-most value to what it should be.
			$ref = $v;
		}
		return $arr;
	}

	
	function rebuild_query_string($arrAssoc=array()){
		$CI=& get_instance();
		$queryString = array();
		
		$arrGET= $CI->input->get(NULL,TRUE);
		$arrGET=cek_array($arrGET)?$arrGET:array();
		
		$arrGET = array_merge($arrGET, $arrAssoc);
		if(cek_array($arrGET)==TRUE):
			$queryString = "?".htmlspecialchars(http_build_query($arrGET),ENT_QUOTES);
		else:
			$queryString="";
		endif;
		
		return $queryString;
	}
	
	
	
	
	function get_where_from_searchbox($field=""){
			$CI=& get_instance();
			/*
			$queryString = array();
			$queryString = $CI->input->get(NULL,TRUE);
			if(cek_array($queryString)):
				$queryString = "?".htmlspecialchars(http_build_query($arrGET),ENT_QUOTES);
			else:
				$queryString="";
			endif;
			*/
			$q=$CI->input->get_post("q",TRUE);
			$q=$q?$q:"";
			$q=urldecode($q);
			$q=preg_replace("/(\,|\s+|\||\-|\_|\.|\:)/i","%",$q);
			$q=preg_replace("/\s+/"," ",$q);
			
			$search=explode(",",$field);
			$datasearch=array();
			$field="";
			foreach($search as $field):
				$datasearch[]=" $field like '%$q%' ";
			endforeach;
			$whereSql="";
			if(cek_array($datasearch)==TRUE):
				$whereSql=join(" or ",$datasearch);
			endif;
			return $whereSql;
	}
	
	
	function create_unique_slug($string,$table,$field='slug',$key=NULL,$value=NULL)
    {
        $t =& get_instance();
        $slug = url_title($string);
        $slug = strtolower($slug);
        $i = 0;
        $params = array ();
        $params[$field] = $slug;
     
        if($key)$params["$key !="] = $value;
     
        while ($t->db->where($params)->get($table)->num_rows())
        {  
            if (!preg_match ('/-{1}[0-9]+$/', $slug ))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
             
            $params [$field] = $slug;
        }  
        return $slug;  
    }
	
	if (!function_exists('cek_var')):
	function cek_var($var){
		if( empty($var) && ($var !== 0) && ($var !== '0') ):
			return FALSE;  
		else:
			return TRUE;
		endif;
	}
	endif;




/* End of file global_helper.php */
/* Location: ./application/helpers/global_helper.php */
