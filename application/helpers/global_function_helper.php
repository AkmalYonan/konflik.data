<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//services_prov
if ( ! function_exists('services_prov'))
{
	function services_prov($kd='00')
	{
		$CI =& get_instance();
		
		$services_prov = file_get_contents("http://layanandata.ditjenpum.go.id/v1/dagri/wilayah/?kode_wilayah=$kd");
											
		return $services_prov;
	}
}

//services_kab
if ( ! function_exists('services_kab'))
{
	function services_kab($kd_prov)
	{
		$prov = $kd_prov.".";
		$CI =& get_instance();
		
		$services_kab = file_get_contents("http://layanandata.ditjenpum.go.id/v1/dagri/wilayah/?kode_dagri=$prov");
										   
		return $services_kab;
	}
}

//services_kab
if ( ! function_exists('services_kab2'))
{
	function services_kab2($kd_prov)
	{
		$CI =& get_instance();
		
		$services_kab = file_get_contents("http://layanandata.ditjenpum.go.id/v1/dagri/wilayah/?kode_dagri=$kd_prov");
										   
		return $services_kab;
	}
}

//services_provBa
if ( ! function_exists('services_provBa'))
{
	function services_provBa($k)
	{
		$CI =& get_instance();
		
		$services_provBa = file_get_contents("http://layanandata.ditjenpum.go.id/v1/dagri/propinsi/kode_wilayah/$k");
										   
		return $services_provBa;
	}
}

//services_provBaru
if ( ! function_exists('services_provBaru'))
{
	function services_provBaru()
	{
		$CI =& get_instance();
		
		$services_kab = file_get_contents("http://layanandata.ditjenpum.go.id/v1/dagri/propinsi");
										   
		return $services_kab;
	}
}

//services_kabBaru
if ( ! function_exists('services_kabBaru'))
{
	function services_kabBaru($kd_prov)
	{
		$prov = str_replace("00","",$kd_prov);
		$CI =& get_instance();
		
		$services_kab = file_get_contents("http://layanandata.ditjenpum.go.id/v1/dagri/kabupaten/$prov");
										   
		return $services_kab;
	}
}

//path reporting
if ( ! function_exists('path_reporting'))
{
	function path_reporting()
	{
		$CI =& get_instance();
		
		$path_jpgraph = FCPATH."assets/MPDF";

		return $path_jpgraph;
	}
}

//output : images folder path
if ( ! function_exists('images_url'))
{
	function images_url($uri = '')
	{
		$CI =& get_instance();
		return base_url()."asset/media/images/".$uri;
	}
}
 
//output : css folder path
if ( ! function_exists('css_url'))
{
	function css_url($uri = '')
	{
		$CI =& get_instance();
		return base_url()."asset/scripts/css/".$uri;
	}
}
 
//output : javascript folder path
if ( ! function_exists('js_url'))
{
	function js_url($uri = '')
	{
		$CI =& get_instance();
		return base_url()."asset/scripts/js/".$uri;
	}
}
 
//output : libraries folder path
if ( ! function_exists('libraries_url'))
{
	function libraries_url($uri = '')
	{
		$CI =& get_instance();
		return base_url()."asset/libraries/".$uri;
	}
}

//output : images folder path
if ( ! function_exists('upload_url'))
{
	function upload_url($uri = '')
	{
		$CI =& get_instance();
		return base_url()."assets/uploads/".$uri;
	}
}

//---------- END ------------

//---------- FUNCTION HELPER ---------------

//output : print currecny format
if ( ! function_exists('currency_format'))
{
	function currency_format($number)
	{
		return 'Rp '.number_format($number);
	}
}

//output : membuat array tahun pada dropdown box
if ( ! function_exists('get_year'))
{
	function get_year($scr_thn)
	{
		$CI =& get_instance();
		
		echo "<select class='form-control' name='tahun' id='tahun' >";
		echo'<option value="" >- All -</option>'; 
		$years = range(date("Y"), date("Y", strtotime("now - 50 years"))); 
		foreach($years as $year){
			if($scr_thn == $year){
				$selected = 'selected="selected"';
			}else{
				$selected = '';
			}
			echo'<option '.$selected.' value="'.$year.'">'.$year.'</option>'; 
		}
		echo "</select>";
	}
}

//output : membuat array tahun pada dropdown box
if ( ! function_exists('get_year2'))
{
	function get_year2()
	{
		$CI =& get_instance();
		
		echo "<select class='form-control tahun2' name='tahun2' >";
		//echo'<option value="" >- Pilih Tahun -</option>'; 
		$years = range(date("Y"), date("Y", strtotime("now - 50 years"))); 
		foreach($years as $year){
			echo'<option value="'.$year.'">'.$year.'</option>'; 
		}
		echo "</select>";
	}
}

//output : membuat array tahun pada dropdown box
if ( ! function_exists('get_year3'))
{
	function get_year3()
	{
		$CI =& get_instance();
		
		echo "<select class='form-control tahun3' name='tahun3' >";
		//echo'<option value="" >- Pilih Tahun -</option>'; 
		$years = range(date("Y"), date("Y", strtotime("now - 50 years"))); 
		foreach($years as $year){
			echo'<option value="'.$year.'">'.$year.'</option>'; 
		}
		echo "</select>";
	}
}

//output : membuat array tahun pada dropdown box
if ( ! function_exists('get_year4'))
{
	function get_year4()
	{
		$CI =& get_instance();
		
		echo "<select class='form-control tahun4' name='tahun4' >";
		//echo'<option value="" >- Pilih Tahun -</option>'; 
		$years = range(date("Y"), date("Y", strtotime("now - 50 years"))); 
		foreach($years as $year){
			echo'<option value="'.$year.'">'.$year.'</option>'; 
		}
		echo "</select>";
	}
}

//output : membuat array tahun pada dropdown box
if ( ! function_exists('get_year5'))
{
	function get_year5()
	{
		$CI =& get_instance();
		
		echo "<select class='form-control tahun5' name='tahun5' >";
		//echo'<option value="" >- Pilih Tahun -</option>'; 
		$years = range(date("Y"), date("Y", strtotime("now - 50 years"))); 
		foreach($years as $year){
			echo'<option value="'.$year.'">'.$year.'</option>'; 
		}
		echo "</select>";
	}
}


if ( ! function_exists('input_currency'))
{
	function input_currency()
	{
		$CI =& get_instance();
		echo "
		<script type=\"text/javascript\"/>
			$(document).ready(function () {
				var theme = getDemoTheme();
				 $(\"#currencyInput\").jqxNumberInput({ width: '250px', height: '25px', symbol: 'Rp', theme: theme });
			});
		</script>
		<!--<td><div style='margin-top: 3px;' id='currencyInput'></td>-->
		<td id=\"currencyInput\"></td>
		";

	}
}

//encrypt 
if ( ! function_exists('encryptIt'))
{
	function encryptIt( $q, $cryptKey ) {
		//$cryptKey  = '6i5';
		$qEncoded  = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
		return( $qEncoded );
	}
}

//decrypt
if ( ! function_exists('decryptIt'))
{
	function decryptIt( $q, $cryptKey ) {
		//$cryptKey  = '6i5';
		$qDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		return( $qDecoded );
	}
}

// 04-02-2014 => (2014 Feb 04)
if ( ! function_exists('format_tanggal'))
{
	function format_tanggal($tgl) {
		if($tgl!="0000-00-00" && $tgl!="")
		{
			  $temp=explode(" ", $tgl);
			  $temp=explode("-", $temp[0]);
			  $tahun=$temp[0];
			  $bln=$temp[1];
			  $hari=$temp[2];

			switch($bln)
			{
				case "01" : $namaBln = "Jan";
						  break;
				case "02" : $namaBln = "Feb";
						  break;
				case "03" : $namaBln = "Mar";
						   break;
				case "04" : $namaBln = "Apr";
						   break;
				case "05" : $namaBln = "Mei";
						 break;
				case "06" : $namaBln = "Jun";
						 break;
				case "07" : $namaBln = "Jul";
						 break;
				case "08" : $namaBln = "Agu";
						 break;
				case "09" : $namaBln = "Sep";
						 break;
				case "10" : $namaBln = "Okt";
						 break;
				case "11" : $namaBln = "Nov";
							 break;
				case "12" : $namaBln = "Des";
							 break;
			}
			$tgl_full="$hari $namaBln $tahun";
			return $tgl_full;
		}
		else return "";
	}
}

// 2014 Feb 04 => 04-02-2014 
if ( ! function_exists('format_tanggal_db'))
{
	function format_tanggal_db($tgl) {
		if($tgl!="")
		{
			  $temp=explode(" ", $tgl);
			  $hari=$temp[0];
			  $bln=$temp[1];
			  $tahun=$temp[2];


			switch($bln)
			{
				case "Jan" : $namaBln = "01";
						  break;
				case "Feb" : $namaBln = "02";
						  break;
				case "Mar" : $namaBln = "03";
						   break;
				case "Apr" : $namaBln = "04";
						   break;
				case "Mei" : $namaBln = "05";
						 break;
				case "Jun" : $namaBln = "06";
						 break;
				case "Jul" : $namaBln = "07";
						 break;
				case "Agu" : $namaBln = "08";
						 break;
				case "Sep" : $namaBln = "09";
						 break;
				case "Okt" : $namaBln = "10";
						 break;
				case "Nov" : $namaBln = "11";
							 break;
				case "Des" : $namaBln = "12";
							 break;
			}
			$tgl_full="$tahun-$namaBln-$hari ";
			return $tgl_full;
		}
		else return "";
	}
}

// 04/02/2013 => 2013-02-04
if ( ! function_exists('format_tanggal_db2'))
{
	function format_tanggal_db2($tgl){
	//30/06/2012
	$temp=explode("/",$tgl);
	 
	$hasil=$temp[2]."-".$temp[1]."-".$temp[0];
	return $hasil;
	 
	} 
}

// 2013-02-04 => 04/02/2013
if ( ! function_exists('format_tanggal_db3'))
{ 
	function format_tanggal_db3($tgl){
	//30/06/2012
	$temp=explode("-",$tgl);
	 
	$hasil=$temp[2]."/".$temp[1]."/".$temp[0];
	return $hasil;
	 
	}
}

// 2013-02-04 => 04 Februari 2013
if ( ! function_exists('format_tanggal_db4'))
{
	function format_tanggal_db4($tgl){
	//30/06/2012
	  $temp=explode("-",$tgl);
	  if($temp[1]=='01')
	  {
		$bulan = "Januari";
	  }
	  elseif($temp[1]=='02')
	  {
		$bulan = "Februari";
	  }
	  elseif($temp[1]=='03')
	  {
		$bulan = "Maret";
	  }
	  elseif($temp[1]=='04')
	  {
		$bulan = "April";
	  } 
	  elseif($temp[1]=='05')
	  {
		$bulan = "Mei";
	  }
	  elseif($temp[1]=='06')
	  {
		$bulan = "Juni";
	  }
	  elseif($temp[1]=='07')
	  {
		$bulan = "Juli";
	  }
	  elseif($temp[1]=='08')
	  {
		$bulan = "Agustus";
	  }
	  elseif($temp[1]=='09')
	  {
		$bulan = "September";
	  }
	  elseif($temp[1]=='10')
	  {
		$bulan = "Oktober";
	  }
	  elseif($temp[1]=='11')
	  {
		$bulan = "November";
	  }                     
	  elseif($temp[1]=='12')
	  {
		$bulan = "Desember";
	  }
	  $hasil=$temp[2]." ".$bulan." ".$temp[0];
	  return $hasil;
	 
	}
}

// 2013-02-04 => 04-02-2013
if ( ! function_exists('format_tanggal_db5'))
{ 
	function format_tanggal_db5($tgl){
	//30/06/2012
	$temp=explode("-",$tgl);
	 
	$hasil=$temp[2]."-".$temp[1]."-".$temp[0];
	return $hasil;
	 
	}
}

if ( ! function_exists('get_auto_increment'))
{
	function get_auto_increment($tablename,$dbs){
		$CI =& get_instance();
        $next_increment = 0;
		$qShowStatus = "SHOW TABLE STATUS LIKE '$tablename'";
		$row = $CI->conn->GetRow($qShowStatus);
						   
		$next_increment = $row['Auto_increment'];

		return $next_increment;
	}
}

// brief (ringkasan isi berita)
if ( ! function_exists('brief'))
{
	function brief($isi,$count) 
	{
		$content=trim($isi);
		$temp=explode(" ", $content);
			 $d=count($temp);
			 if($d>$count)
			 {
				$c=-1*($d-$count);
				$temp=explode(" ", $content,$c);
			 }
			 $content=implode(" ", $temp);
		return $content;
	}
}

//tinymce :
if ( ! function_exists('initialize_tinymce'))
{
	function initialize_tinymce($param) {
		$CI =& get_instance();
		if(isset($param['readonly'])){
			$tinymce = '<script src="'.base_url().'asset/scripts/js/tinymce/tinymce.min.js"></script>
						<script>
						tinymce.init({
							selector: "textarea",
							theme: "modern",
							readonly : 1,
							width: 550,
							plugins: [
								 "advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker",
								 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
								 "save table contextmenu directionality emoticons template paste textcolor"
						   ],
							image_advtab: true,
							toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons", 
							style_formats: [
								{title: "Bold text", inline: "b"},
								{title: "Red text", inline: "span", styles: {color: "#ff0000"}},
								{title: "Red header", block: "h1", styles: {color: "#ff0000"}},
								{title: "Example 1", inline: "span", classes: "example1"},
								{title: "Example 2", inline: "span", classes: "example2"},
								{title: "Table styles"},
								{title: "Table row 1", selector: "tr", classes: "tablerow1"}
							]
						});
						</script>'.form_textarea($param);
		}else{
			$tinymce = '<script src="'.base_url().'asset/scripts/js/tinymce/tinymce.min.js"></script>
						<script>
						tinymce.init({
							selector: "textarea",
							theme: "modern",
							width: 550,
							plugins: [
								 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
								 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
								 "save table contextmenu directionality emoticons template paste textcolor"
						   ],
							image_advtab: true,
							toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | link image | bullist numlist outdent indent | print preview media fullpage | forecolor backcolor emoticons", 
							style_formats: [
								{title: "Bold text", inline: "b"},
								{title: "Red text", inline: "span", styles: {color: "#ff0000"}},
								{title: "Red header", block: "h1", styles: {color: "#ff0000"}},
								{title: "Example 1", inline: "span", classes: "example1"},
								{title: "Example 2", inline: "span", classes: "example2"},
								{title: "Table styles"},
								{title: "Table row 1", selector: "tr", classes: "tablerow1"}
							]
						});
						</script>'.form_textarea($param);
		}
		return $tinymce;
	}
}






