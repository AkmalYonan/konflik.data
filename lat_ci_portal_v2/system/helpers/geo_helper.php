<?php 

function wkt2kml($wkt){

// Change coordinate format
$wkt = preg_replace("/([0-9\.\-]+) ([0-9\.\-]+),*/", "$1,$2,0 ", $wkt);

$wkt = substr($wkt, 15);
$wkt = substr($wkt, 0, -3);
$polygons = explode(')),((', $wkt);
$kml = '<MultiGeometry>' . PHP_EOL;

foreach ($polygons as $polygon) {
$kml .= '<Polygon>' . PHP_EOL;
$boundary = explode('),(', $polygon);
$kml .= '<outerBoundaryIs>' . PHP_EOL
. '<LinearRing>' . PHP_EOL
. '<coordinates> ' . $boundary[0] . '</coordinates>' . PHP_EOL
. '</LinearRing>' . PHP_EOL
. '</outerBoundaryIs>' . PHP_EOL;

for ($i=1; $i < count($boundary); $i++) {
$kml .= '<innerBoundaryIs>' . PHP_EOL
. '<LinearRing>' . PHP_EOL
. '<coordinates> ' . $boundary[$i] . '</coordinates>' . PHP_EOL
. '</LinearRing>' . PHP_EOL
. '</innerBoundaryIs>' . PHP_EOL;
}
$kml .= '</Polygon>' . PHP_EOL;
}
$kml .= '</MultiGeometry>' . PHP_EOL;
return $kml;
}

function wkb_to_json($wkb) {
	$CI=& get_instance();
	$CI->load->library("geophp");
	$geom = geoPHP::load($wkb,'wkb');
    return $geom->out('json');
}

function get_centroid_from_json($json){
    $polygon = geoPHP::load($json,'json');
    $centroid = $polygon->getCentroid();
    //$centX = $centroid->getX();
    //$centY = $centroid->getY();
    return $centroid->out("json");
}

function get_centroid_xy_from_json($json){
    $polygon = geoPHP::load($json,'json');
    $centroid = $polygon->getCentroid();
    $centX = $centroid->getX();
    $centY = $centroid->getY();
    $data["x"]=$centX;
    $data["y"]=$centY;
    return $data;
    //return $centroid->out("json");
}

function wkb_to_area($wkb){
	$CI=& get_instance();
	$CI->load->library("geophp");
	$geom = geoPHP::load($wkb,'wkb');
    $area = $geom->getArea();
	return $area;
}


 function interpolate($pBegin, $pEnd, $pStep, $pMax) {
    if ($pBegin < $pEnd) {
      return (($pEnd - $pBegin) * ($pStep / $pMax)) + $pBegin;
    } else {
      return (($pBegin - $pEnd) * (1 - ($pStep / $pMax))) + $pEnd;
    }
  }
  

// return color array
function colorSeries($cs=false,$step=16) {
	$colorseries=($cs)?$cs:"EEEEEE|0066CC";
	$step=($step)?$step:16;
	
	$acol = preg_split("/\||\;|\,|\:|\./",$colorseries);
	
	$anum = count($acol);
	for($i=0;$i<$anum-1;$i++) {
		$arr[$i][0]['r']=(hexdec($acol[$i]) & 0xff0000) >> 16;
		$arr[$i][0]['g']=(hexdec($acol[$i]) & 0x00ff00) >> 8;
		$arr[$i][0]['b']=(hexdec($acol[$i]) & 0x0000ff) >> 0;
		$arr[$i][1]['r']=(hexdec($acol[$i+1]) & 0xff0000) >> 16;
		$arr[$i][1]['g']=(hexdec($acol[$i+1]) & 0x00ff00) >> 8;
		$arr[$i][1]['b']=(hexdec($acol[$i+1]) & 0x0000ff) >> 0;
	}
	$dstep = floor($step/($anum-1));
	foreach($arr as $k=>$v) {
		for ($i = 0; $i <= $dstep; $i++) {
			$theR = interpolate($v[0]['r'], $v[1]['r'], $i, $dstep);
			$theG = interpolate($v[0]['g'], $v[1]['g'], $i, $dstep);
			$theB = interpolate($v[0]['b'], $v[1]['b'], $i, $dstep);
	
			$theVal = ((($theR << 8) | $theG) << 8) | $theB;
			$color[($k*$dstep)+$i]=sprintf("#%06X", $theVal);
		}
	}
	if (count($color)<=$step) $color[]="#".$acol[$anum-1];
	//pre($color);
	return $color;
}


function drawLegend($color,$min=0,$max='?',$type='horz') {
	switch($type) {
		case 1:
		case "horz":
			$tbl=horz($color,$min,$max);
			break;
		case 2:
		case "vert":
			$tbl=vert($color,$min,$max);
			break;
		case 3:
		case "box":
			$tbl=box($color,$min,$max);
			break;
	}
	return $tbl;
}

function bd_nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",","",$n));
       
        // is this a number?
        if(!is_numeric($n)) return false;
       
        // now filter it;
        if($n>1000000000000) return round(($n/1000000000000),1).' T';
        else if($n>1000000000) return round(($n/1000000000),1).' B';
        else if($n>1000000) return round(($n/1000000),1).' M';
        else if($n>1000) return round(($n/1000),0).' K';
       
        return number_format($n);
    }

function box($color,$min,$max){
	$tbl='<div style="padding:6px; border:1px solid #ccc; background-color:#fff">';
	$tbl.='<table cellpadding="0" cellspacing="0" border="0">';
	//$lgd .='<tr><td>'.number_format($min,0,0,".").' &nbsp; </td>';
	//$ind .='<tr><td>&nbsp;</td>';
	$d = round($max-$min)/count($color);
	krsort($color);
	foreach($color as $k=>$v) {
		$val = bd_nice_number(($d*$k))." - ".bd_nice_number(($d*($k+1)));
		$lgd.='<tr>';
		$lgd.='<td><div id="'.$k.'" style="width:15px;height:12px;background:'.$v.'"></td>';
		$lgd.='<td width="9"><div class="ind" id="ind_'.$k.'" style="display:none;width:8px;height:9px;background:url(images/arrow_left.gif) no-repeat left center"></td>';
		$lgd.='<td><div style="margin-left:2px">'.$val.'</td>';
		$lgd.='</tr>';
	}
	//$lgd .='<td> &nbsp; '.number_format($max,0,0,".").'</td></tr>';
	$tbl .=$lgd.$ind;
	$tbl.='</table>';
	$tbl.='</div>';
	
	return $tbl;
}

function horz($color,$min,$max){
	
	$tbl='<table cellpadding="0" cellspacing="0" border="0">';
	$lgd ='<tr><td>'.number_format($min,0,0,".").' &nbsp; </td>';
	$ind ='<tr><td>&nbsp;</td>';
	foreach($color as $k=>$v) {
		$lgd.='<td><div id="'.$k.'" style="width:9px;height:15px;background:'.$v.'"></td>';
		$ind.='<td height="15"><div class="ind" id="ind_'.$k.'" style="display:none;width:9px;height:15px;background:url(images/arrow_down.gif) no-repeat center bottom"></td>';
	}
	$lgd .='<td> &nbsp; '.number_format($max,0,0,".").'</td></tr>';
	$ind .='<td>&nbsp;</td></tr>';
	$tbl .=$ind.$lgd;
	$tbl.='</table>';
	return $tbl;
}


function vert($color,$min,$max){
	$tbl='<table cellpadding="0" cellspacing="0" border="0">';
	//$lgd .='<tr><td>'.number_format($min,0,0,".").' &nbsp; </td>';
	//$ind .='<tr><td>&nbsp;</td>';
	krsort($color);
	$lgd="";
	$ind="";
	foreach($color as $k=>$v) {
		$lgd.='<tr>';
		$lgd.='<td><div id="'.$k.'" style="width:15px;height:9px;background:'.$v.'"></td>';
		$lgd.='<td height="9"><div class="ind" id="ind_'.$k.'" style="display:none;width:15px;height:9px;background:url(images/arrow_left.gif) no-repeat left center"></td>';
		$lgd.='</tr>';
	}
	//$lgd .='<td> &nbsp; '.number_format($max,0,0,".").'</td></tr>';
	$tbl .=$lgd.$ind;
	$tbl.='</table>';
	return $tbl;
}

function indicator_data($id=false){
	$CI=& get_instance();
	
	if($id):
		$arr=$CI->conn->GetRow("select * from tb_indicator where id=$id");
	else:
		$arr=$CI->conn->GetRow("select * from tb_indicator");
	endif;
	return $arr;
}

function category_data($parent=0,$level=1){
	$CI=& get_instance();
	$arr=$CI->conn->GetAll("select * from tb_category where category_level=$level and category_parent_id=$parent");
	return $arr;
}
		