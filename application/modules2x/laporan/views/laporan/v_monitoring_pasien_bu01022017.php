<?
$bln[1] = "Januari";
$bln[2] = "Februari";
$bln[3] = "Maret";
$bln[4] = "April";
$bln[5] = "Mei";
$bln[6] = "Juni";
$bln[7] = "Juli";
$bln[8] = "Agustus";
$bln[9] = "September";
$bln[10] = "Oktober";
$bln[11] = "November";
$bln[12] = "Desember";
$req=get_post();
$bulan=$req["bulan"]?$req["bulan"]:12;
$tahun=$req["tahun"]?$req["tahun"]:date("Y");

$userdata=$this->user_data;
$tipe_instansi_user=$userdata["tipe_instansi"]?$userdata["tipe_instansi"]:"";
$kd_org=$userdata["kd_org"]?$userdata["kd_org"]:"";
if($kd_org==""):
	$kd_org=$req["kd_org"]?$req["kd_org"]:"";
endif;
if($tipe_instansi==""):
	$tipe_instansi=$req["tipe_instansi"]?$req["tipe_instansi"]:"";
endif;

$lookup_empty[""]="--Semua--";	
$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
$lookup_wilayah=$lookup_empty+$lookup_wilayah;
$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
$lookup_wilayahx=$lookup_empty+$lookup_wilayahx;

$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
$lookup_wilayah2=$lookup_empty+$lookup_wilayah2;
$map_org=$lookup_wilayah+$lookup_wilayah2+$lookup_wilayahx;

if($tipe_instansi_user):
	$lookup_instansi=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in ('".$tipe_instansi_user."')","order by idx,order_num");
	$map_org=$lookup_instansi;
	
	$tipe_instansi=$tipe_instansi_user;
	if($tipe_instansi_user=="BNNP"):
		$arr_org=explode($kd_org);
		$myorg=$arr_org[0]."";
		$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and kd_org='".$kd_org."' and active=1","order by kd_wilayah");
		$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and kd_org like '".$myorg."%' active=1","order by kd_wilayah");
		$lookup_wilayahx=$lookup_empty+$lookup_wilayahx;
		$map_org=$lookup_wilayahx;
		
	endif;
	if($tipe_instansi_user=="BNNK"):
		$arr_org=explode($kd_org);
		$myorg=$arr_org[0]."-00-BNNP";
		$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and kd_org='".$myorg."' and active=1","order by kd_wilayah");
		$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and kd_org='".$kd_org."' and active=1","order by kd_wilayah");
		$map_org=$lookup_wilayahx;
	endif;
	
else:
	$tipe_instansi=$req["tipe_instansi"]?$req["tipe_instansi"]:"";
	
	$lookup_instansi=$lookup_empty+lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in ('BNNP','BNNK','BL')","order by idx,order_num");
	
endif;		


$data_empty=array(
	"tahun" => $tahun,
    "bulan" => 0,
    "registrasi" => 0,
    "rehab" => 0,
    "pasca" => 0,
    "selesai" => 0,
    "pp" => 0,
    "ptp" => 0,
    "tpp" => 0,
    "tptp" => 0,
    "inap" => 0,
    "jalan" => 0,
    "prri" => 0,
    "prrj" => 0,
    "prrl" => 0,
    "ss" => 0,
    "rirmdt" => 0,
    "rirmeu" => 0,
    "rirspp" => 0,
    "rirsre" => 0,
    "rjkl" => 0,
    "rjts" => 0,
    "rjtk" => 0,
    "prap" => 0,
    "prrida" => 0,
    "prridr" => 0,
    "prridk" => 0,
    "prripd" => 0,
    "prrjpg" => 0,
    "prrlpukp" => 0,
    "prrlpuep" => 0,
    "prrlputu" => 0,
    "prrlpdhv" => 0,
    "prrlpdpk" => 0,
    "prrlpdtu" => 0,
    "prrlpdkn" => 0,
    "jumlah" => 0
);

	$data_bulan=array();
	foreach($bln as $x=>$val):
		$data_empty["bulan"]=$x;
		$data_bulan[$x]=$data_empty;
	endforeach;
	
if(cek_array($arrData)):
	foreach($arrData as $x=>$val):
		$data_bulan[$val["bulan"]]=$val;
	endforeach;
	
endif;

$organization=$map_org[$kd_org]?strtoupper($map_org[$kd_org]):"";
if($tipe_instansi=="BNNP"):
	if($kd_org==""):
		$organization="SELURUH BNN PROPINSI";
	endif;
endif;
if($tipe_instansi=="BNNK"):
	if($kd_org==""):
		$organization="SELURUH BNN KABUPATEN";
	endif;
endif;
if($tipe_instansi=="BL"):
	if($kd_org==""):
		$organization="SELURUH BALAI/LOKA";
	endif;
endif;
if($tipe_instansi==""):
	if($kd_org==""):
		$organization="BNNP/BNNK/BALAI/LOKA SELURUH INDONESIA";
	endif;
endif;
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb hidden">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->modul_title?></a></li>
    <li class="active">Add</li>
  </ol>
</section>


<section class="content">
<div class="row">
<div class="col-md-12">

<div class="content-toolbar">
					
					<div class="row">
                    <div class="col-md-12 col-xs-12">
                    <form class="form-inline" action="<?=$this->module?>monitoring_pasien" method="get">
                     <input type="hidden" id="kd_org" name="kd_org" value="<?=$kd_org?>" />
                      <div class="form-group">
                        	<label for="tahun">Tahun</label>
                        	<select name="tahun" class="form-control">
                                    	<? for($i=date("Y");$i>=date("Y")-10;$i--){?>
                                        <? $selected="";
											if($tahun==$i):
												$selected="selected=selected";
											else:
												$selected="";
											endif;
											//pre($selected.$i);
											
										?>
                                        <option <?=($tahun==$i)?"selected":"";?> value="<?=$i?>"><?=$i?></option>
                                        <? }?>
                                    </select>
                      </div>
                      
                      <div class="form-group">
                        <label for="instansi">Instansi</label>
                         <?=form_dropdown("tipe_instansi",$lookup_instansi,$tipe_instansi,
								"id='tipe_instansi' class='form-control select2 required' 
								");?>
                      	</div>
                      <div class="form-group wilayah">
                      	  <label for="wilayah">Wilayah</label>	
                          <?=form_dropdown("",$lookup_wilayah,$kd_org,
								"id='kd_org_bnnp' class='form-control select2 required' 
								style='display:none;'");?>
                                
                                <?=form_dropdown("",$lookup_wilayah2,$kd_org,
								"id='kd_org_balai' class='form-control select2 required' 
								style='display:none;'");?>
                                
                                <?=form_dropdown("",$lookup_wilayahx,$kd_org,
								"id='kd_org_bnnk' class='form-control select2 required' 
								style='display:none;'");?>
                      </div>
                      <div class="form-group">
                      <button id="btn_search" type="submit" class="btn btn-white">Tampilkan</button>
                      <button type="reset" class="btn btn-white" data-toggle="tooltip" title="" data-original-title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                    	</div><!--end form group -->
                    </form>
                    <div class="pull-right" style="margin-top:-32px">
                              <a href="#" class="print-pdf hidden" data-url=""><i class="fa fa-file-pdf-o"></i> PDF</a>
                              <div class="btn-group btn-group-sm pull-right">
                                  <a href="/print" class="btn btn-white div_id_print_modal" data-div_id="#print_this" data-page_orientation='L' data-page_size='A4' data-toggle='tooltip' data-original-title="Print Preview"><i class="fa fa-print"></i>&nbsp;Print Preview</a>
                         	 <a href="#" class="btn btn-white print-excel" data-url="" data-toggle='tooltip' data-original-title="Export to Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a>
                         	 </div>
  			 		  	</div><!-- end col -->
                    	<div class="clearfix"></div>
                 	</div><!-- emd col -->
			</div><!-- end row -->
</div>
            <!-- END: TOOLBAR -->

<div class="box box-widget">
                <div class="box-header with-border clearfix hidden">
                		  
                </div>
                <!-- /.box-header -->
                <div class="box-body">

<div id="print_this" class="bg-white">
<table align="center">
	<tr>
    	<td valign="top" width="100px"><img src="<?=$this->base_url?>assets/images/bnn.png" width="80px"></td>
        <td>
        	<p style="text-align:center;font-size:14pt;font-weight:bold;letter-spacing:1px;">MONITORING PASIEN </p>
            <p style="text-align:center;font-size:14pt;font-weight:bold;letter-spacing:1px;"><?=$organization;?>
            </p>
            <p style="text-align:center;font-size:12pt;font-weight:bold;">S/D TAHUN <?=$tahun?></p>
		</td>
    </tr>
</table>
<style>
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #CCC;
    margin: 1em 0;
    padding: 0; 
}
</style>
<hr />
<div id="div_excel">
<div class="sch">
<table border="0" width="100%" >
    <tr>
    <td width="100px">S/D TAHUN</td>
    <td width="20" align="center"></td>
    <td style="font-weight:bold;">
    <?=($tahun)? $tahun:date(Y);?></td>
    </tr>
    
</table>
</div>
<br />
<div class="formSep">
</div>


<!--<link rel="stylesheet" href="assets/fa/4.7.0/css/font-awesome.min.css">-->
<style>
	.fa{font-family:fontawesome !important;}
	.red{color:#DD5A43;}
	.green{color:#69AA46;}
	.tr{text-align:right;}
	.tc{text-align:center;}
	.tl{text-align:left;}
</style>                    
<? 
	$flag_yes="<i class='fa green'>&#xf00c;</i>";
	//$flag_no="<i class='fa red'>&#xf068;</i>";
	$flag_no="-";

	//echo $flag_yes;
	//echo $flag_no;
?>
<div class="table-responsive">
<table class="table table-bordered" style="width:100%">
	<thead>
    <tr>
    <th rowspan="3" style="vertical-align:top;text-align:center">No</th>
    <!--<th rowspan="3" style="vertical-align:top;text-align:center">Tahun</th>-->
    <th rowspan="3" style="vertical-align:top;text-align:center">PASIEN</th>
    <th colspan="7" style="vertical-align:top;text-align:center">REHABILITASI</th>
    <th colspan="13" style="vertical-align:top;text-align:center">PASCA</th>
    <th colspan="4" rowspan="2" style="vertical-align:top;text-align:center">OUTCOME</th>
    <!--<th rowspan="3" style="vertical-align:top;text-align:center">TOTAL<br>(ASSESMENT)</th>-->
    <th colspan="4" rowspan="2" style="vertical-align:top;text-align:center">STATUS</th>
    </tr>
    <tr>
    <th colspan="4" style="vertical-align:top;text-align:center">INAP</th>
    <th colspan="3" style="vertical-align:top;text-align:center">JALAN</th>
    <th style="vertical-align:top;text-align:center">PRAP</th>
    <th colspan="2" style="vertical-align:top;text-align:center">INAP</th>
     <th colspan="3" style="vertical-align:top;text-align:center">JALAN</th>
    <th colspan="7" style="vertical-align:top;text-align:center">LANJUT</th>
    </tr>
    <tr>
    <th style="vertical-align:top;">DT</th>
    <th style="vertical-align:top;">EU</th>
    <th style="vertical-align:top;">PP</th>
	<th style="vertical-align:top;">RE</th>
    <th style="vertical-align:top;">KL</th>
    <th style="vertical-align:top;">TK</th>
    <th style="vertical-align:top;">TS</th>
    <th style="vertical-align:top;">PRAP</th>
    <th style="vertical-align:top;">DA</th>
     <th style="vertical-align:top;">DR</th>
    
    <th style="vertical-align:top;">PG</th>
    <th style="vertical-align:top;">PD</th>
    <th style="vertical-align:top;">DK</th>
    
    <th style="vertical-align:top;">PUKP</th>
    <th style="vertical-align:top;">PUEP</th>
    <th style="vertical-align:top;">PUTU</th>
    <th style="vertical-align:top;">PDHV</th>
    <th style="vertical-align:top;">PDPK</th>
    
    <th style="vertical-align:top;">PDKN</th>
    <th style="vertical-align:top;">PDTU</th>
    <th style="vertical-align:top;">PP</th>
    <th style="vertical-align:top;">PTP</th>
    <th style="vertical-align:top;">TPP</th>
    <th style="vertical-align:top;">TPTP</th>
    <th style="vertical-align:top;">SL</th>
    <th style="vertical-align:top;">DO</th>
    <th style="vertical-align:top;">MD</th>
    <th style="vertical-align:top;">KB</th>
    </tr>  
    <tr style="text-align:center !important;">
    	<th class="tc">1</th>
        <th class="tc">2</th>
        <th class="tc">3</th>
        <th class="tc">4</th>
        <th class="tc">5</th>
        <th class="tc">6</th>
        <th class="tc">7</th>
        <th class="tc">8</th>
        <th class="tc">9</th>
        <th class="tc">10</th>
        <th class="tc">11</th>
        <th class="tc">12</th>
        <th class="tc">13</th>
        <th class="tc">14</th>
        <th class="tc">15</th>
        <th class="tc">16</th>
        <th class="tc">17</th>
        <th class="tc">18</th>
        <th class="tc">19</th>
        <th class="tc">20</th>
        <th class="tc">21</th>
        <th class="tc">22</th>
        <th class="tc">23</th>
        <th class="tc">24</th>
        <th class="tc">25</th>
        <th class="tc">26</th>
        <th class="tc">27</th>
        <th class="tc">28</th>
        <th class="tc">29</th>
        <th class="tc">30</th>
       <!-- <th class="tc">31</th>-->
    </tr>
    </thead>
    <tbody>
    	<?php if(cek_array($arrData)):?>
    	<?php foreach($arrData as $x=>$data):?>
        
        <tr>
        	<td><?php echo $x+1;?></td>
            <!--<td><?php echo $data["tahun"];?></td>-->
        	<td><?php echo $data["nama"];?></td>
            <td class="tc"><?php echo $data["rirmdt"]?$flag_yes:$flag_no;?></td>
            <td class="tc" ><?php echo $data["rirmeu"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["rirspp"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["rirsre"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["rjkl"]?$flag_yes:$flag_no;?></td>
            
            <td class="tc"><?php echo $data["rjtk"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["rjts"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prap"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prrida"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prridr"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prrjpg"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prripd"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prridk"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prrlpukp"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prrlpuep"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prrlputu"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prrlpdhv"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prrlpdpk"]?$flag_yes:$flag_no;?></td>
            <td class="tc" ><?php echo $data["prrlpdkn"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["prrlpdtu"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["pp"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["ptp"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["tpp"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["tptp"]?$flag_yes:$flag_no;?></td>
            <!--<td class="tc"><?php echo $data["jumlah"]?$flag_yes:$flag_no;?></td>-->
            <td class="tc"><?php echo $data["selesai"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["do"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["md"]?$flag_yes:$flag_no;?></td>
            <td class="tc"><?php echo $data["kb"]?$flag_yes:$flag_no;?></td>
        </tr>
        <? 
			$total["rirmdt"][]=$data["rirmdt"];
			$total["rirmeu"][]=$data["rirmeu"];
			$total["rirspp"][]=$data["rirspp"];
			$total["rirsre"][]=$data["rirsre"];
			$total["rjkl"][]=$data["rjkl"];
			$total["rjts"][]=$data["rjts"];
			$total["rjtk"][]=$data["rjtk"];
			
			$total["prap"][]=$data["prap"];
			$total["prrida"][]=$data["prrida"];
			$total["prridr"][]=$data["prridr"];
			$total["prridk"][]=$data["prridk"];
			$total["prripd"][]=$data["prripd"];
			
			
			$total["prrjpg"][]=$data["prrjpg"];
			
			$total["pukp"][]=$data["prrlpukp"];
			$total["puep"][]=$data["prrlpuep"];
			$total["putu"][]=$data["prrlputu"];
			$total["pdhv"][]=$data["prrlpdhv"];
			
			
			$total["pdpk"][]=$data["prrlpdpk"];
			$total["pdtu"][]=$data["prrlpdtu"];
			$total["pdkn"][]=$data["prrlpdkn"];
			
			
			$total["pp"][]=$data["pp"];
			$total["ptp"][]=$data["ptp"];
			$total["tpp"][]=$data["tpp"];
			$total["tptp"][]=$data["tptp"];
			
			$total["selesai"][]=$data["selesai"];
			$total["kb"][]=$data["kb"];
			$total["do"][]=$data["do"];
			$total["md"][]=$data["md"];
			
			
			$total["jumlah"][]=$data["jumlah"];
			
			
			
			
		
		?>
        <?php endforeach;?>
        
        <?
			
			$total_rirmdt=array_sum($total["rirmdt"]);
			$total_rirmeu=array_sum($total["rirmeu"]);
			$total_rirspp=array_sum($total["rirspp"]);
			$total_rirsre=array_sum($total["rirsre"]);
			$total_rjkl=array_sum($total["rjkl"]);
			$total_rjts=array_sum($total["rjts"]);
			$total_rjtk=array_sum($total["rjtk"]);
			
			$total_prap=array_sum($total["prap"]);
			$total_da=array_sum($total["prrida"]);
			$total_dk=array_sum($total["prridk"]);
			$total_dr=array_sum($total["prridr"]);
			$total_pd=array_sum($total["prripd"]);
			$total_pg=array_sum($total["prrjpg"]);
			
			$total_pukp=array_sum($total["pukp"]);
			$total_puep=array_sum($total["puep"]);
			$total_putu=array_sum($total["putu"]);
			$total_pdhv=array_sum($total["pdhv"]);
			
			
			$total_pdpk=array_sum($total["pdpk"]);
			$total_pdtu=array_sum($total["pdtu"]);
			$total_pdkn=array_sum($total["pdkn"]);
			
			$total_pp=array_sum($total["pp"]);
			$total_ptp=array_sum($total["ptp"]);
			$total_tpp=array_sum($total["tpp"]);
			$total_tptp=array_sum($total["tptp"]);
			
			$total_do=array_sum($total["do"]);
			$total_md=array_sum($total["md"]);
			$total_kb=array_sum($total["kb"]);
			$total_selesai=array_sum($total["selesai"]);
			
			$total_jumlah=array_sum($total["jumlah"]);
		
		?>
        <?php endif;?>
    </tbody>
    <tfoot>
    	<tr style="font-weight:bold">
        <td></td>
        <td>Total :</td>
        <td class="tr"><?=$total_rirmdt?></td>
        <td class="tr"><?=$total_rirmeu?></td>
        <td class="tr"><?=$total_rirspp?></td>
        <td class="tr"><?=$total_rirsre?></td>
        <td class="tr"><?=$total_rjkl?></td>
        
        <td class="tr"><?=$total_rjtk?></td>
        <td class="tr"><?=$total_rjts?></td>
        
        <td class="tr"><?=$total_prap?></td>
        
        <td class="tr"><?=$total_da?></td>
        <td class="tr"><?=$total_dr?></td>
        <td class="tr"><?=$total_pg?></td>
        <td class="tr"><?=$total_pd?></td>
        <td class="tr"><?=$total_dk?></td>
        
        
        <td class="tr"><?=$total_pukp?></td>
        <td class="tr"><?=$total_puep?></td>
        <td class="tr"><?=$total_putu?></td>
        <td class="tr"><?=$total_pdhv?></td>
        
        <td class="tr"><?=$total_pdpk?></td>
        <td class="tr"><?=$total_pdkn?></td>
        <td class="tr"><?=$total_pdtu?></td>
        
        <td class="tr"><?=$total_pp?></td>
        <td class="tr"><?=$total_ptp?></td>
        <td class="tr"><?=$total_tpp?></td>
        <td class="tr"><?=$total_tptp?></td>
       <!-- <td class="tr"><?=$total_jumlah?></td>-->
        <td class="tr"><?=$total_selesai?></td>
        <td class="tr"><?=$total_do?></td>
        <td class="tr"><?=$total_md?></td>
        <td class="tr"><?=$total_kb?></td>
        </tr>
    </tfoot>  
</table>

<div class="row">
    <h4 style="margin-left:15px;">Keterangan</h4>
    <div class="col-sm-6">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Proses</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center" width="25">1</td>
                    <td>DT</td>
                    <td>Detox</td>
                </tr>
                <tr>
                    <td align="center" width="25">2</td>
                    <td>EU</td>
                    <td>Entry Unit</td>
                </tr>
                <tr>
                    <td align="center" width="25">3</td>
                    <td>RE</td>
                    <td>Re-Entry</td>
                </tr>
                <tr>
                    <td align="center" width="25">4</td>
                    <td>PP</td>
                    <td>Primary Treatment</td>
                </tr>
                <tr>
                    <td align="center" width="25">5</td>
                    <td>KL</td>
                    <td>Konseling</td>
                </tr>
                <tr>
                    <td align="center" width="25">6</td>
                    <td>TS</td>
                    <td>Terapi Simptomatik</td>
                </tr>
                <tr>
                    <td align="center" width="25">7</td>
                    <td>TK</td>
                    <td>Terapi Kelompok</td>
                </tr>
                <tr>
                    <td align="center" width="25">8</td>
                    <td>PRAP</td>
                    <td>Penerimaan Pasca Rehab</td>
                </tr>
                <tr>
                    <td align="center" width="25">9</td>
                    <td>DA</td>
                    <td>Daily Activity</td>
                </tr>
                <tr>
                    <td align="center" width="25">10</td>
                    <td>DR</td>
                    <td>Discharge/Rujukan</td>
                </tr>
                <tr>
                    <td align="center" width="25">11</td>
                    <td>DK</td>
                    <td>Dukungan Keluarga</td>
                </tr>
                <tr>
                    <td align="center" width="25">12</td>
                    <td>PD</td>
                    <td>Pengembangan Diri</td>
                </tr>
                <tr>
                    <td align="center" width="25">13</td>
                    <td>PG</td>
                    <td>Peer Group</td>
                </tr>
                <tr>
                    <td align="center" width="25">14</td>
                    <td>PUKP</td>
                    <td>Pemantauan - Kegiatan Produktif</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-sm-6">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Proses</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <td align="center" width="25">15</td>
                    <td>PUEP</td>
                    <td>Pemantauan - Evaluasi Perkembangan</td>
                </tr>
                <tr>
                    <td align="center" width="25">16</td>
                    <td>PUTU</td>
                    <td>Pemantauan - Tes Urin</td>
                </tr>
                <tr>
                    <td align="center" width="25">17</td>
                    <td>PDHV</td>
                    <td>Pendampingan - Home Visit</td>
                </tr>
                <tr>
                    <td align="center" width="25">18</td>
                    <td>PDPK</td>
                    <td>Pendampingan - Pertemuan Kelompok</td>
                </tr>
                <tr>
                    <td align="center" width="25">19</td>
                    <td>PDTU</td>
                    <td>Pendampingan - Tes Urin</td>
                </tr>
                <tr>
                    <td align="center" width="25">20</td>
                    <td>PDKN</td>
                    <td>Pendampingan - Konseling</td>
                </tr>
                <tr>
                    <td align="center" width="25">21</td>
                    <td>PP</td>
                    <td>Pulih, Produktif</td>
                </tr>
                <tr>
                    <td align="center" width="25">22</td>
                    <td>PTP</td>
                    <td>Pulih, Tidak Produktif</td>
                </tr>
                <tr>
                    <td align="center" width="25">23</td>
                    <td>TPP</td>
                    <td>Tidak Pulih, Produktif</td>
                </tr>
                <tr>
                    <td align="center" width="25">24</td>
                    <td>TPTP</td>
                    <td>Tidak Pulih, Tidak Produktif</td>
                </tr>
                <tr>
                    <td align="center" width="25">25</td>
                    <td>SL</td>
                    <td>Selesai</td>
                </tr>
                <tr>
                    <td align="center" width="25">26</td>
                    <td>DO</td>
                    <td>Drop Out</td>
                </tr>
                <tr>
                    <td align="center" width="25">27</td>
                    <td>MD</td>
                    <td>Meninggal Dunia</td>
                </tr>
                <tr>
                    <td align="center" width="25">28</td>
                    <td>KB</td>
                    <td>Kambuh</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</div>
</div>
</div><!-- end div print -->

</div></div><!-- end box -->

</div></div><!-- end row -->

</section>

<script type="text/javascript" src="assets/js/lingkar/jquery.export2excel.js"></script>
<script type="text/javascript" src="assets/js/lingkar/jquery.table2csv.js"></script>

<script>
	$(function(){
		var style = '<style>table {font-family:chelvetica, Arial;font-size:9px;margin:0;width:100%}table.section{margin-top:10px;}th {text-align:left!important;}h5 {font-family:chelvetica, Arial;}.val{font-weight:bold}</style>';
		
		$("a.print-excel").click(function(e){
			e.preventDefault();
			//var file="file_20140929134835.xls";
			var file="laporan_pasien_baru_per_klinik_<?="_".date("YmdHis").".xls";?>";
			var base_url="<?=base_url()?>";
			/*get html table */
			var tbl = $('<div>').append($('div#div_excel').clone()).remove().html();
			/* add table to div to export */
			var div = $('<div>').append(tbl);
			div.find("table").attr("border","1");
			$(div).Export2XLS({filename:file,urlAction:base_url+"export/xls/"});
		});
		
		/*
		$("a.print-html").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
            var html=$("div#print_this").html();
			var file="penetapan_batas_propinsi_<?="_".date("YmdHis").".html";?>";
            UrlSubmit(base_url+"export/html_print/",{filename:file,tbl:encodeURIComponent(html),target:"_blank"});
			return false;
			//$(this).attr("target","_blank");
		});
		
		*/
		
		
		$("a.print-pdf").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
			var html=style+$("div#print_this").html();
			var file="test<?="_".date("YmdHis").".pdf";?>";
			UrlSubmit(base_url+"export/proxy_pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,p:'A4',o:'L',target:"_blank"});
		});
		
	});
</script>

<script>
	$(function(){
	    $("#tipe_instansi").change(function(){
			cek_instansi();
		});
		
		
		$("#tipe_instansi").change();
		
		$("#kd_org_bnnp").change(function(){
			$("#kd_org").val($(this).find(":selected").val());
		});
		
		$("#kd_org_bnnk").change(function(){
			$("#kd_org").val($(this).find(":selected").val());
		});
		
		$("#kd_org_balai").change(function(){
			$("#kd_org").val($(this).find(":selected").val());
		});
		
	});
	
	function cek_instansi(){
		var tipe_instansi=$("#tipe_instansi :selected").val();
		if(tipe_instansi=="BNNP"){
			$(".wilayah").show();
			$("#kd_org_bnnp").show();
			$("#kd_org_balai").hide();
			$("#kd_org_bnnk").hide();
			$("#kd_org_bnnp").change();
		}
		if(tipe_instansi=="BNNK"){
			$(".wilayah").show();
			$("#kd_org_bnnp").hide();
			$("#kd_org_bnnk").show();
			$("#kd_org_balai").hide();
			$("#kd_org_bnnk").change();
		}
		if(tipe_instansi=="BL"){
			$(".wilayah").show();
			$("#kd_org_bnnp").hide();
			$("#kd_org_balai").show();
			$("#kd_org_bnnk").hide();
			$("#kd_org_balai").change();
		}
		if(tipe_instansi==""){
			$(".wilayah").hide();
			$("#kd_org_bnnp").val("");
			$("#kd_org_balai").val("");
			$("#kd_org_bnnk").val("");
			
		}
	}
</script>