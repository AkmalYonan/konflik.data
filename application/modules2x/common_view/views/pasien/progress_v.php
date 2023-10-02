<style>
*, *:after, *:before {	 margin: 0;padding: 0;box-sizing: border-box; }
.progress { width: 100%;min-height:55px;margin: 8px auto;text-align: center;background-color:white !important;}
.progress .circle,
.progress .bar {display: inline-block; background: #fff; width: 36px; height: 36px;  border-radius: 36px;  border: 1px solid #d5d5da;	}
.progress .bar {position: relative; width: 80px; height: 6px; margin: 0 -5px 33px -5px; border-left: none; border-right: none; border-radius: 0;}
.progress .circle .label {display: inline-block;width: 28px;  height: 28px;line-height: 21px; border-radius: 28px; margin-top: 3px; color: #b5b5ba; font-size: 14px;}
.progress .circle .title {color: #b5b5ba; font-size: 13px;line-height: 28px; margin-left: -5px;}

/* Done / Active */
.progress .bar.done,
.progress .circle.done {background: #eee;}
.progress .bar.active {background: linear-gradient(to right, #EEE 40%, #FFF 60%);}
.progress .circle.done .label { color: #FFF;background: #8bc435;box-shadow: inset 0 0 2px rgba(0,0,0,.2);}
.progress .circle.done .title {color: #444;}
.progress .circle.active .label {color: #FFF;background: #0c95be; box-shadow: inset 0 0 2px rgba(0,0,0,.2);}
.progress .circle.active .title {color: #0c95be;}
</style>
<? 
			 //pre($monitoring_rehab);
//status 
$bend['status_rehab'] = $pasien_assestment_history['status_rehab'];
$bend['status_proses'] = $pasien_assestment_history['status_proses'];
$bend['outcome_pasien'] = $pasien_assestment_history['outcome_pasien'];

//Note
//Pasien Registrasi = status_rehab : 1 sedang  = status_rehab : 1 and status_proses : RG
//Pasien Assestment = status_rehab : 1 && status_proses : 'SS'
//Pasien Rehabilitasi = status_rehab : 2
//Pasien Pasca = status_rehab : 3
//Pasien Outcome = outcome_pasien : '!= NULL'

if($bend['status_rehab']>="1"):
$arr_statsx["Registrasi"] 		= "done"; 
$arr_tgl["Registrasi"] 		= "&radic; ".date("d/m/Y",strtotime($monitoring_rehab['tgl_registrasi'])); 
elseif(($bend['status_rehab']=="1") and ($bend['status_proses']=="RG")):
$arr_statsx["Registrasi"] 		= "active"; 
endif;


if(($bend['status_rehab']=="1") AND ($bend['status_proses']=="SS")):
$arr_stats["Assessment"] 		= "active"; 
elseif($bend['status_rehab']>="2"):
$arr_stats["Assessment"] 		= "done"; 
$arr_tgl["Assessment"] 		= "&radic; ".date("d/m/Y",strtotime($monitoring_rehab['tgl_assesment'])); 
endif;

if(($bend['status_rehab']=="2")):
$arr_stats["Rehabilitasi"] 		= "active"; 
elseif($bend['status_rehab']>"2"):
$arr_stats["Rehabilitasi"] 		= "done"; 
$arr_tgl["Rehabilitasi"] 		= "&radic; ".date("d/m/Y",strtotime($monitoring_rehab['tgl_selesai_rehab'])); 
endif;

if(($bend['status_rehab']=="3")):
$arr_stats["Pasca"] 		= "active"; 
elseif(($bend['status_rehab']>"3") and ($bend['outcome_pasien']==NULL)):
$arr_stats["Pasca"] 		= "done";
$arr_tgl["Pasca"] 		= "&radic; ".date("d/m/Y",strtotime($data['tgl_selesai_pasca'])); 
else:
$arr_stats["Pasca"] 		= ""; 
endif;

if(($bend['outcome_pasien']!=NULL)):
$arr_stats["Outcome"] 		= "active"; 
elseif($bend['outcome_pasien']==NULL):
$arr_stats["Outcome"] 		= "";
endif;

//$arr_stats["Assestment"] 		= (($bend['status_rehab']>="1") and ($bend['status_proses']=="SS") OR ($bend['status_rehab']>="2"))? 1:0;
//$arr_stats["Rehabilitasi"] 		= (($bend['status_rehab']>="2"))? 1:0;
//$arr_stats["Pasca"] 			= (($bend['status_rehab']>="3"))? 1:0;
//$arr_stats["Outcome"] 			= (($bend['outcome_pasien']!=NULL))? 1:0;
?>		
<div class="progress">
	<div class="circle <?=($arr_statsx["Registrasi"])?>" data-toggle="tooltip" title="" data-original-title="<?=$arr_tgl['Registrasi']?>">
				<span class="label"><?=1?></span>
			<span class="title">Registrasi</span>
		</div>
	<? 
	$x=1;
	foreach($arr_stats as $k=>$v):?>
		<span class="bar <?=($v)?>"></span>
		<div class="circle <?=($v)?>" data-toggle="tooltip" title="" data-original-title="<?=$arr_tgl[$k]?>">
			<span class="label"><?=$x+1?></span>
			<span class="title"><?=$k?></span>
		</div>
	
	<? $x++;
	endforeach;?>
	
</div>
						