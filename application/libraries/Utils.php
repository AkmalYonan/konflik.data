<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils {

    function listMonth($Type=1) {
		$FULL_MONTH  = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $SHORT_MONTH = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Ags","Sep","Okt","Nop","Des");
        $FULL_ENGLISH_MONTH  = array("January","February","March","April","May","June","July","August","September","October","November","December");
		switch ($Type) {
            case 1 : $month = $FULL_MONTH; break;
			case 2 : $month = $SHORT_MONTH; break;
			case 3 : $month = $FULL_ENGLISH_MONTH; break;
		}
		return $month;
	}
	function dateToString2($Date,$time=false,$Type=1) {
        $FULL_MONTH  = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
        $SHORT_MONTH = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Ags","Sep","Okt","Nop","Des");
        $FULL_ENGLISH_MONTH  = array("January","February","March","April","May","June","July","August","September","October","November","December");

    //  Pisah tanggal, bulan dan tahun sesuai format US.
		$ddate = explode(" ",$Date);
		$dtime = ($ddate[1] && $time)?" ".$ddate[1]:"";
        list($Year,$Month,$Day) = explode("-",$ddate[0]);

        switch ($Type) {
            case 1 : $String = $Day."-".$Month."-".$Year.$dtime; break;
            case 2 : $String = $Day."/".$Month."/".$Year.$dtime; break; //DD/MM/YYYY
            case 3 : $String = $Day." ".$FULL_MONTH[$Month-1]." ".$Year.$dtime; break;
            case 4 : $String = $Day." ".$SHORT_MONTH[$Month-1]." ".$Year.$dtime; break;
            case 5 : $String = $FULL_ENGLISH_MONTH[$Month-1]." ".$Day.", ".$Year.$dtime; break;
            case 6 : $String = $Day.$Month.$Year.$dtime; break;
			case 7 : $String = $Month."/".$Day."/".$Year.$dtime; break; //MM/DD/YYYY
        }

        return ($String);
    }
	
	function monthToText($m,$abbr=false) {
		$long_m = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$short_m = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sept","Okt","Nov","Des");
		
		$m_array = ($abbr)?$short_m:$long_m;
		return $m_array[(int)$m];
	}
	
	function dateToString($dbtime,$time=false,$type=1) {
		$FULL_DAY  = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
		$FULL_MONTH  = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
        $SHORT_MONTH = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Ags","Sep","Okt","Nop","Des");
        $FULL_ENGLISH_MONTH  = array("January","February","March","April","May","June","July","August","September","October","November","December");

		$day   = date("w", @strtotime($dbtime));
		$month = date("m", @strtotime($dbtime));
		$date  = date("d", @strtotime($dbtime));
		$year  = date("Y", @strtotime($dbtime));
		$time  = ($time)?date("H:i:s", @strtotime($dbtime)):"";
		
		switch ($type) {
            case 1 : $String = $FULL_DAY[$day].", ".$date." ".$FULL_MONTH[$month-1]." ".$year." ".$time; break;
            case 2 : $String = $FULL_DAY[$day].", ".$date."/".$month."/".$year." ".$time; break;
            case 3 : $String = $date." ".$FULL_MONTH[$month-1]." ".$year." ".$time; break;
            case 4 : $String = $date." ".$SHORT_MONTH[$month-1]." ".$year." ".$time; break;
            case 5 : $String = $FULL_ENGLISH_MONTH[$month-1]." ".$date.", ".$year." ".$time; break;
            case 6 : $String = $FULL_DAY[$day].", ".$date.$month.$year." ".$time; break;
			case 7 : $String = $year."-".$month."-".$date." ".$time; break;
			case 8 : $String = $month."/".$date."/".$year." ".$time; break;
			case 9 : $String = $date."/".$month."/".$year." ".$time; break;
			case 10 : $String = $date." ".$FULL_ENGLISH_MONTH[$month-1]." ".$year." ".$time; break;
			case 11 : $String = $year."/".$month."/".$date." ".$time; break;
        }

        return ($String);
	}
	
	function getPerPage($limit=15,$pr_array= array(10,15,20,25,30,40,50)) 
	{
	
		$select .='<div style="margin-right:10px; padding:5px; display:inline"><select class="page_record input-mini" name="page_record" >';
		foreach($pr_array as $k=>$v) {
			$selected = ($v==$limit)?' selected':'';
			$select .='<option value="'.$v.'"'.$selected.'>'.$v.'</option>';
		}
		$select .='</select> </div>';
		return $select;
	}
	function getPerPageAjax($limit=15,$pr_array= array(10,15,20,25,30,40,50)) 
	{
	
		$select .='<div style="margin-right:10px; padding:5px; display:inline"><select class="page_record input-mini" name="page_record" id="select">';
		foreach($pr_array as $k=>$v) {
			$selected = ($v==$limit)?' selected':'';
			$select .='<option value="'.$v.'"'.$selected.'>'.$v.'</option>';
		}
		$select .='</select> </div>';
		return $select;
	}
	/**/
	//function to return the pagination string
	function getPaginationString($page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/", $pagestring = "?page=")
	{		
		//defaults
		if(!$adjacents) $adjacents = 1;
		if(!$limit) $limit = 15;
		if(!$page) $page = 1;
		if(!$targetpage) $targetpage = "/";
		
		//other vars
		$prev = $page - 1;									//previous page is page - 1
		$next = $page + 1;									//next page is page + 1
		$lastpage = ceil($totalitems / $limit);				//lastpage is = total items / items per page, rounded up.
		$lpm1 = $lastpage - 1;								//last page minus 1
		
		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$pagination = "";
		if($lastpage > 1)
		{	
			$pagination .= "<div class=\"pagination\"";
			if($margin || $padding)
			{
				$pagination .= " style=\"";
				if($margin)
					$pagination .= "margin: $margin;";
				if($padding)
					$pagination .= "padding: $padding;";
				$pagination .= "\"";
			}
			$pagination .= ">";
	
			//previous button
			if ($page > 1) 
				$pagination .= "<a href=\"$targetpage$pagestring$prev\">&laquo; prev</a>";
			else
				$pagination .= "<span class=\"disabled\">&laquo; prev</span>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>";					
				}
			}
			elseif($lastpage >= 7 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 3))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>";					
					}
					$pagination .= "<span class=\"elipses\">...</span>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination .= "<a href=\"" . $targetpage . $pagestring . "1\">1</a>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . "2\">2</a>";
					$pagination .= "<span class=\"elipses\">...</span>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>";					
					}
					$pagination .= "...";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination .= "<a href=\"" . $targetpage . $pagestring . "1\">1</a>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . "2\">2</a>";
					$pagination .= "<span class=\"elipses\">...</span>";
					for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>";					
					}
				}
			}
			
			//next button
			if ($page < $counter - 1) 
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $next . "\">next &raquo;</a>";
			else
				$pagination .= "<span class=\"disabled\">next &raquo;</span>";
			$pagination .= "</div>\n";
		}
		
		return $pagination;
	
	}
	
	
	//function to return the pagination string
	function getPaginationString2($page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/", $pagestring = "?page=",$additional_param="")
	{		
		//defaults
		if(!$adjacents) $adjacents = 1;
		if(!$limit) $limit = 15;
		if(!$page) $page = 1;
		if(!$targetpage) $targetpage = "/";
		
		//other vars
		$prev = $page - 1;									//previous page is page - 1
		$next = $page + 1;									//next page is page + 1
		$lastpage = ceil($totalitems / $limit);				//lastpage is = total items / items per page, rounded up.
		$lpm1 = $lastpage - 1;								//last page minus 1
		
		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$pagination = "";
		if($lastpage > 1)
		{	
			$pagination .= "<div";
			if($margin || $padding)
			{
				$pagination .= " style=\"";
				if($margin)
					$pagination .= "margin: $margin;";
				if($padding)
					$pagination .= "padding: $padding;";
				$pagination .= "\"";
			}
			$pagination .= "><ul class=\"pagination pagination-sm no-margin pull-right\">";
	
			//previous button
			if ($page > 1) 
				$pagination .= "<li><a href=\"$targetpage$pagestring$prev$additional_param\">&larr; Prev</a></li>";
			else
				$pagination .= "<li class=\"disabled\"><span>&larr; Prev</span></li>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<li class=\"active\"><span>$counter</span></li>";
					else
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . $additional_param . "\">$counter</a></li>";					
				}
			}
			elseif($lastpage >= 7 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 3))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><span>$counter</span></li>";
						else
							$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . $additional_param . "\">$counter</a></li>";					
					}
					$pagination .= "<li><span class=\"elipses\">...</span></li>";
					$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lpm1 . $additional_param . "\">$lpm1</a></li>";
					$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lastpage . $additional_param . "\">$lastpage</a></li>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "1$additional_param\">1</a></li>";
					$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "2$additional_param\">2</a></li>";
					$pagination .= "<li><span class=\"elipses\">...</span></li>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><span>$counter</span></li>";
						else
							$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . $additional_param . "\">$counter</a></li>";					
					}
					$pagination .= "<li>...</li>";
					$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lpm1 . $additional_param . "\">$lpm1</a></li>";
					$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lastpage . $additional_param . "\">$lastpage</a></li>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "1$additional_param\">1</a></li>";
					$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "2$additional_param\">2</a></li>";
					$pagination .= "<li><span class=\"elipses\">...</span></li>";
					for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><span>$counter</span></li>";
						else
							$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . $additional_param . "\">$counter</a></li>";					
					}
				}
			}
			
			//next button
			if ($page < $counter - 1) 
				$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $next . $additional_param . "\">Next &rarr;</a></li>";
			else
				$pagination .= "<li class=\"disabled\"><a>Next &rarr;</a></li>";
			$pagination .= "</ul></div>\n";
		}
		
		return $pagination;
	
	}
	function getPaginationStringAjax($page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/", $pagestring = "?page=",$additional_param="")
	{		
		//defaults
		if(!$adjacents) $adjacents = 1;
		if(!$limit) $limit = 15;
		if(!$page) $page = 1;
		if(!$targetpage) $targetpage = "/";
		
		//other vars
		$prev = $page - 1;									//previous page is page - 1
		$next = $page + 1;									//next page is page + 1
		$lastpage = ceil($totalitems / $limit);				//lastpage is = total items / items per page, rounded up.
		$lpm1 = $lastpage - 1;								//last page minus 1
		
		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$pagination = "";
		if($lastpage > 1)
		{	
			$pagination .= "<div";
			if($margin || $padding)
			{
				$pagination .= " style=\"";
				if($margin)
					$pagination .= "margin: $margin;";
				if($padding)
					$pagination .= "padding: $padding;";
				$pagination .= "\"";
			}
			$pagination .= "><ul class=\"pagination pagination-sm no-margin pull-right\">";
	
			//previous button
			if ($page > 1) 
				$pagination .= "<li><a class=\"page-numbers\" href=\"$targetpage$pagestring$prev$additional_param\">&larr; Prev</a></li>";
			else
				$pagination .= "<li class=\"disabled\"><span>&larr; Prev</span></li>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<li class=\"active\"><span>$counter</span></li>";
					else
						$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . $counter . $additional_param . "\">$counter</a></li>";					
				}
			}
			elseif($lastpage >= 7 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 3))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><span>$counter</span></li>";
						else
							$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . $counter . $additional_param . "\">$counter</a></li>";					
					}
					$pagination .= "<li><span class=\"elipses\">...</span></li>";
					$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . $lpm1 . $additional_param . "\">$lpm1</a></li>";
					$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . $lastpage . $additional_param . "\">$lastpage</a></li>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . "1$additional_param\">1</a></li>";
					$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . "2$additional_param\">2</a></li>";
					$pagination .= "<li><span class=\"elipses\">...</span></li>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><span>$counter</span></li>";
						else
							$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . $counter . $additional_param . "\">$counter</a></li>";					
					}
					$pagination .= "<li>...</li>";
					$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . $lpm1 . $additional_param . "\">$lpm1</a></li>";
					$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . $lastpage . $additional_param . "\">$lastpage</a></li>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . "1$additional_param\">1</a></li>";
					$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . "2$additional_param\">2</a></li>";
					$pagination .= "<li><span class=\"elipses\">...</span></li>";
					for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><span>$counter</span></li>";
						else
							$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . $counter . $additional_param . "\">$counter</a></li>";					
					}
				}
			}
			
			//next button
			if ($page < $counter - 1) 
				$pagination .= "<li><a class=\"page-numbers\" href=\"" . $targetpage . $pagestring . $next . $additional_param . "\">Next &rarr;</a></li>";
			else
				$pagination .= "<li class=\"disabled\"><a>Next &rarr;</a></li>";
			$pagination .= "</ul></div>\n";
		}
		
		return $pagination;
	
	}
	/* FILE UPLOAD HANDLER */
	// photo handler
	function fileUploadHandler($files,$dir,$prefix=false,$create_thumb=true) {
		$allow = array("jpg","jpeg","gif","png");
		$i=0;
		//print_r($files);
		foreach ($files["file"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				$file_name = ($prefix)?$prefix."_".$files["file"]["name"][$key]:$files["file"]["name"][$key];
				$file_fullname = $dir.$file_name;
				$tmp_fullname = $files["file"]["tmp_name"][$key];
				
				//echo $file_fullname;
				
				$file_info = getimagesize($tmp_fullname);
				$file_ext = explode(".",$file_fullname);
				$scount = count($file_ext);
				$extension = strtolower($file_ext[($scount-1)]);
				if (in_array($extension,$allow)) {
					/*
					if ($photo_info[0]<$this->_cfg['min_photo_dimension'][0] || $photo_info[1]<$this->_cfg['min_photo_dimension'][1]) {
						$dirname[$key]['error'][] = "Dimensi Photo terlalu kecil (min: 600 x 480)";
					}
					else if ($photo_info[0]>$this->_cfg['max_photo_dimension'][0] || $photo_info[1]>$this->_cfg['max_photo_dimension'][1]) {
						$dirname[$key]['error'][] = "Dimensi Photo terlalu besar (max: 800 x 600)";
					}
					else {*/
						move_uploaded_file($files["file"]["tmp_name"][$key], $file_fullname);// or die("Problems with upload");
						$dirname[$key]['dir'] = $dir;
						$dirname[$key]['img_name'] = $file_name;
						if ($create_thumb) {
							$img_thumb = $this->createThumbnail($file_fullname,74,74,'thumb');
							if ($img_thumb) {
								$dirname[$key]['img_thumb'] = $img_thumb;
							}
						}
					/*}*/
				}
				else {
					$dirname[$key]['error'][] = "Tipe File Invalid (*.".$extension.")";
				}
			}
			else {
				switch($error) {
					case 1:
						$err="The uploaded file exceeds the upload_max_filesize directive in php.ini.".ini_get("upload_max_filesize");
						break;
					case 2:
						$err="The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form. ";
						break;
					case 3:
						$err="The uploaded file was only partially uploaded";
						break;
					case 4:
						$err="No file was uploaded";
						break;
					case 6:
						$err="Missing a temporary folder. ";
						break;
					case 7:
						$err="Failed to write file to disk";
						break;
				}
				$dirname[$key]['error'][] = $err;
			}
			$i++;
		}
		return $dirname;
	}
	
	function removePhisycalImage($img)
	{
		if(is_file($img)) {
			return unlink($img)? true:false;
		}
	}
	
	function removeFileInDir($dir)
	{
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					unlink($dir.$file);
				}
			}
			closedir($handle);
		}
	}

	function imgThumbnail($filedir=false,$filename,$newdimension_w,$newdimension_h,$nameprefix="copy_",$mode='resize') 
	{
		$sourceimage=($filedir)?$filedir.$filename:$filename;
		$imgext = preg_split("/\./",$sourceimage);
		//print_r($imgext);
		$scount = count($imgext);
		$extension = strtolower($imgext[($scount-1)]);
		
		$allow = array("jpg","jpeg","gif","png");
		if (in_array($extension,$allow)) {
			switch($extension) {
				case "jpg":
					$sim = imagecreatefromjpeg($sourceimage);
					$imgout = "imagejpeg";
					break;
				case "jpeg":
					$sim = imagecreatefromjpeg($sourceimage);
					$imgout = "imagejpeg";
					break;
				case "gif":
					$sim = imagecreatefromgif($sourceimage);
					$imgout = "imagegif";
					break;
				case "png":
					$sim = imagecreatefrompng($sourceimage);
					$imgout = "imagepng";
					break;
			}
			$orig_w = imagesx($sim); 
			$orig_h = imagesy($sim);
			
			if ($mode=='resize') {
				$new_w = $newdimension_w;
				$new_h = ($orig_h/$orig_w)*$new_w;
				$newim = imagecreatetruecolor( $new_w,$new_h);	
				
				$temp = imagecreatetruecolor( $new_w, $new_h);
				$newim = imagecreatetruecolor( $newdimension_w, $newdimension_h);	
				
				imagecopyresized($temp, $sim, 0, 0, 0, 0, $new_w,$new_h,$orig_w, $orig_h);
				imagecopyresampled($newim, $temp, 0, 0, 0, 0, $newdimension_w, $newdimension_h, $newdimension_w, $newdimension_h);
			}
			else if ($mode='resizenfix') {
				if ($orig_w>$orig_h) {
					$new_h = $newdimension_h;
					$new_w = ($orig_w/$orig_h)*$new_h;
				}
				else {
					$new_w = $newdimension_w;
					$new_h = ($orig_h/$orig_w)*$new_w;
				}
				$temp = imagecreatetruecolor( $new_w, $new_h);
				$newim = imagecreatetruecolor( $newdimension_w, $newdimension_h);	
				
				imagecopyresized($temp, $sim, 0, 0, 0, 0, $new_w,$new_h,$orig_w, $orig_h);
				imagecopyresampled($newim, $temp, 0, 0, 0, 0, $newdimension_w, $newdimension_h, $newdimension_w, $newdimension_h);
			}
			else {
				$new_w = $newdimension_x;
				$new_h = $newdimension_y;
				$posx = ($simx-$newdimension_x)/2;
				$posy = ($simy-$newdimension_y)/2;
				
				$newim = imagecreatetruecolor( $new_w,$new_h);	
				imagecopy($newim, $sim, 0, 0, $posx, $posy, $newdimension_x,$newdimension_y);
			}
			imagedestroy($sim);
			
			if ($filedir) {
				$imname = $filedir.$nameprefix.$filename;
			}
			else {
				$extpos = strrpos($sourceimage,".");
				$slashpos = strrpos($sourceimage,"/");
				$imname = substr($sourceimage,0,$slashpos+1).$nameprefix.substr($sourceimage,-$slashpos);
			}
			eval("$imgout(\$newim,\$imname);");
			return $imname;
		}
	}
	
	function createThumbnail($dir=false,$filename,$w,$h,$p,$m='resizenfix')
	{
		//image yg mau dibuat thumbnailnya
		$imgname = $filename; //"images/feature.jpg";
		//new tumbnail, dengan dimensi 50px x 25 px, dengan nama output imagename_thumb
		
		return $this->imgThumbnail($dir,$imgname,$w,$h,$p,$m); 
	}
	
	function closetags($html) {
		#put all opened tags into an array
		preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
		$openedtags = $result[1];   #put all closed tags into an array
		preg_match_all('#</([a-z]+)>#iU', $html, $result);
		$closedtags = $result[1];
		$len_opened = count($openedtags);
		# all tags are closed
		if (count($closedtags) == $len_opened) {
			return $html;
		}
		
		$openedtags = array_reverse($openedtags);
		# close tags
		for ($i=0; $i < $len_opened; $i++) {
			if (!in_array($openedtags[$i], $closedtags)){
			  $html .= '</'.$openedtags[$i].'>';
			} else {
			  unset($closedtags[array_search($openedtags[$i], $closedtags)]);    }
			}  
			return $html;
		}  
}