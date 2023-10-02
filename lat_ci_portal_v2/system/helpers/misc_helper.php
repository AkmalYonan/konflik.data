<?php
//function to download File
function downloadFile($file){
        $file_name = $file;
        $mime = 'application/force-download';
	header('Pragma: public'); 	// required
	header('Expires: 0');		// no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Cache-Control: private',false);
	header('Content-Type: '.$mime);
	header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
	header('Content-Transfer-Encoding: binary');
	header('Connection: close');
	readfile($file_name);		// push it out
	exit();
}

//get long lat from address
function getLatLong($address){
	if (!is_string($address))die("All Addresses must be passed as a string");
	$_url = sprintf('https://maps.google.com/maps?output=js&q=%s',rawurlencode($address));
	$_result = false;
	if($_result = file_get_contents($_url)) {
		if(strpos($_result,'errortips') > 1 || strpos($_result,'Did you mean:') !== false) return false;
		preg_match('!center:\s*{lat:\s*(-?\d+\.\d+),lng:\s*(-?\d+\.\d+)}!U', $_result, $_match);
		$_coords['lat'] = $_match[1];
		$_coords['long'] = $_match[2];
	}
	return $_coords;
}

//get domain favicons
function get_favicon($url){
  $url = str_replace("http://",'',$url);
  return "https://www.google.com/s2/favicons?domain=".$url;
}


//function detect location by ip
function detect_city($ip) {

        $default = 'UNKNOWN';

        if (!is_string($ip) || strlen($ip) < 1 || $ip == '127.0.0.1' || $ip == 'localhost')
            $ip = '8.8.8.8';

        $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';

        $url = 'https://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
        $ch = curl_init();

        $curl_opt = array(
            CURLOPT_FOLLOWLOCATION  => 1,
            CURLOPT_HEADER      => 0,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_USERAGENT   => $curlopt_useragent,
            CURLOPT_URL       => $url,
            CURLOPT_TIMEOUT         => 1,
            CURLOPT_REFERER         => 'http://' . $_SERVER['HTTP_HOST'],
        );

        curl_setopt_array($ch, $curl_opt);

        $content = curl_exec($ch);

        if (!is_null($curl_info)) {
            $curl_info = curl_getinfo($ch);
        }

        curl_close($ch);

        if ( preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs) )  {
            $city = $regs[1];
        }
        if ( preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs) )  {
            $state = $regs[1];
        }

        if( $city!='' && $state!='' ){
          $location = $city . ', ' . $state;
          return $location;
        }else{
          return $default;
        }

    }
	
	//display source code from any web page
	function html2src($url='https://google.com'){
		$lines = file($url);
		foreach ($lines as $line_num => $line) {
			// loop thru each line and prepend line numbers
			echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n";
		}
	}
	
	//display facebook fun count
	function fb_fan_count($facebook_name){
		// Example: https://graph.facebook.com/digimantra
		$data = json_decode(file_get_contents("https://graph.facebook.com/".$facebook_name));
		echo $data->likes;
	}
	
	
	//whois function
	function whois_query($domain) {

		// fix the domain name:
		$domain = strtolower(trim($domain));
		$domain = preg_replace('/^http:\/\//i', '', $domain);
		$domain = preg_replace('/^www\./i', '', $domain);
		$domain = explode('/', $domain);
		$domain = trim($domain[0]);
	
		// split the TLD from domain name
		$_domain = explode('.', $domain);
		$lst = count($_domain)-1;
		$ext = $_domain[$lst];
	
		// You find resources and lists
		// like these on wikipedia:
		//
		// http://de.wikipedia.org/wiki/Whois
		//
		$servers = array(
			"biz" => "whois.neulevel.biz",
			"com" => "whois.internic.net",
			"us" => "whois.nic.us",
			"coop" => "whois.nic.coop",
			"info" => "whois.nic.info",
			"name" => "whois.nic.name",
			"net" => "whois.internic.net",
			"gov" => "whois.nic.gov",
			"edu" => "whois.internic.net",
			"mil" => "rs.internic.net",
			"int" => "whois.iana.org",
			"ac" => "whois.nic.ac",
			"ae" => "whois.uaenic.ae",
			"at" => "whois.ripe.net",
			"au" => "whois.aunic.net",
			"be" => "whois.dns.be",
			"bg" => "whois.ripe.net",
			"br" => "whois.registro.br",
			"bz" => "whois.belizenic.bz",
			"ca" => "whois.cira.ca",
			"cc" => "whois.nic.cc",
			"ch" => "whois.nic.ch",
			"cl" => "whois.nic.cl",
			"cn" => "whois.cnnic.net.cn",
			"cz" => "whois.nic.cz",
			"de" => "whois.nic.de",
			"fr" => "whois.nic.fr",
			"hu" => "whois.nic.hu",
			"ie" => "whois.domainregistry.ie",
			"il" => "whois.isoc.org.il",
			"in" => "whois.ncst.ernet.in",
			"ir" => "whois.nic.ir",
			"mc" => "whois.ripe.net",
			"to" => "whois.tonic.to",
			"tv" => "whois.tv",
			"ru" => "whois.ripn.net",
			"org" => "whois.pir.org",
			"aero" => "whois.information.aero",
			"nl" => "whois.domain-registry.nl"
		);
	
		if (!isset($servers[$ext])){
			die('Error: No matching nic server found!');
		}
	
		$nic_server = $servers[$ext];
	
		$output = '';
	
		// connect to whois server:
		if ($conn = fsockopen ($nic_server, 43)) {
			fputs($conn, $domain."\r\n");
			while(!feof($conn)) {
				$output .= fgets($conn,128);
			}
			fclose($conn);
		}
		else { die('Error: Could not connect to ' . $nic_server . '!'); }
	
		return $output;
	}

	function text2link($text){
		//example:
		//$url = "Jean-Baptiste Jung (http://www.webdevcat.com)";
		$url = preg_replace("#http://([A-z0-9./-]+)#", '$0', $url);
		return $url;
	}
	
	//get between text given
	// GetBetween('foo test bar','foo','bar'); return test;
	function GetBetween($content,$start,$end){
		$r = explode($start, $content);
		if (isset($r[1])){
			$r = explode($end, $r[1]);
			return $r[0];
		}
		return '';
	}

	//search string in string	
	function contains($str, $content, $ignorecase=true){
		if ($ignorecase){
			$str = strtolower($str);
			$content = strtolower($content);
		}
		return strpos($content,$str) ? true : false;
	}
	
	
	//replace file get content to curl
	function file_get_contents_curl($url) {
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $url);
	
		$data = curl_exec($ch);
		curl_close($ch);
	
		return $data;
	}
	
	//TWITTER
	//get latest twitter status
	function get_latest_status($twitter_id, $hyperlinks = true) {
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, "http://twitter.com/statuses/user_timeline/$twitter_id.xml?count=1");
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$src = curl_exec($c);
		curl_close($c);
		preg_match('/<text>(.*)<\/text>/', $src, $m);
		$status = htmlentities($m[1]);
		if( $hyperlinks ) $status = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]", '<a href="%5C%22%5C%5C0%5C%22">\\0</a>', $status);
		return($status);
	}
	
	//get follower
	function get_followers($twitter_id){
		$xml=file_get_contents('http://twitter.com/users/show.xml?screen_name='.$twitter_id);
		if (preg_match('/followers_count>(.*)</',$xml,$match)!=0) {
			$tw['count'] = $match[1];
		}
	
		return $tw['count'];
	}
	
	//count tweet
	function tweetCount($url) {
		$content = file_get_contents("http://api.tweetmeme.com/url_info?url=".$url);
		$element = new SimpleXmlElement($content);
		$retweets = $element->story->url_count;
		if($retweets){
			return $retweets;
		} else {
			return 0;
		}
	}

	//tiny url	
	function getTinyUrl($url) {
		return file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
	}
	
	
	//other higligt text
	function highlight($sString, $aWords) {
		if (!is_array ($aWords) || empty ($aWords) || !is_string ($sString)) {
			return false;
		}
	
		$sWords = implode ('|', $aWords);
		return preg_replace ('@\b('.$sWords.')\b@si', 
				'<strong style="background-color:blue">$1</strong>', $sString	);
	}
	
	//password generator
	function generatePassword($length=9, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength >= 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength >= 2) {
			$vowels .= "AEUY";
		}
		if ($strength >= 4) {
			$consonants .= '23456789';
		}
		if ($strength >= 8 ) {
			$vowels .= '@#$%';
		}
	
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
	
	function age($date){
		$year_diff = '';
		$time = strtotime($date);
		if(FALSE === $time){
			return '';
		}
	
		$date = date('Y-m-d', $time);
        $year=0;
        $month=0;
        $day=0;
        $year_diff=0;
        $month_diff=0;
        $day_diff=0;
        list($year,$month,$day) = explode("-",$date);
          $currYear=date("Y");
          $currMonth=date("m");
          $currDay=date("d");
          $year_diff =$currYear-$year;
		  $month_diff = $currMonth-$month;
		  $day_diff = $currDay-$day;
		if ($day_diff < 0 || $month_diff < 0) $year_diff–;
	
		return $year_diff;
	}
	
	//maintenance mode
	function maintenance($mode = FALSE){
		if($mode){
			if(basename($_SERVER['SCRIPT_FILENAME']) != 'maintenance.php'){
				header("Location: http://example.com/maintenance.php");
				exit;
			}
		}else{
			if(basename($_SERVER['SCRIPT_FILENAME']) == 'maintenance.php'){
				header("Location: http://example.com/");
				exit;
			}
		}
	}


?>
