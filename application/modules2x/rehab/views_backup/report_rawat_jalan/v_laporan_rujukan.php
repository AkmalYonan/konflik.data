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

$lookup_bnnp	=	lookup("m_org","kd_org","nama","tipe_org='BNNP' and active='1'","order by idx");
$lookup_bnnk	=	lookup("m_org","kd_org","nama","tipe_org='BNNK' and active='1'","order by idx");	
$lookup_balai	=	lookup("m_instansi","kd_instansi","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
$lookup_rd	=	lookup("m_instansi","kd_instansi","nama_instansi","jenis_tempat_rehab='RD' ","order by idx");
$lookup_km	=	lookup("m_instansi","kd_instansi","nama_instansi","jenis_tempat_rehab='KM' ","order by idx");

?>
<style>
#view_tahun,#view_bulan,#view_tingkat{
	text-decoration: underline;
	font-weight:bold;
}
</style>
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
        <div class="col-md-9 col-xs-9">
			<form class="form-inline" action="<?=$this->module?>index_rujukan" method="get">
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
		</div><!--End Of Col 8-->
		
		<div class="col-md-3 pull-right">
			<a href="#" class="print-pdf hidden" data-url=""><i class="fa fa-file-pdf-o"></i> PDF</a>
			<div class="btn-group btn-group-sm pull-right">
				<a href="/print" class="btn btn-white div_id_print_modal" data-div_id="#print_this" data-page_orientation='L' data-page_size='A4' data-toggle='tooltip' data-original-title="Print Preview"><i class="fa fa-print"></i>&nbsp;Print Preview</a>
				<a href="#" class="btn btn-white print-excel" data-url="" data-toggle='tooltip' data-original-title="Export to Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a>
			</div>
		</div><!--End Of Col 4-->
	</div><!--End Of Row-->
        <div class="clearfix"></div>
        </div>
        <!-- END: TOOLBAR -->

		<div class="box box-widget">
        	<div class="box-header with-border clearfix hidden">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
				<div class="row">
					<div class="col-sm-12" style="margin-bottom:10px">
						<ul class="nav nav-tabs">
							<li class="active"><a href="<?=$this->module?>index_rujukan">Rujukan Pasien</a></li>
							<li><a href="<?=$this->module?>index_outcome">Outcome Rehabilitasi</a></li>
						</ul>
					</div>
				</div><!--End Of Row-->

				<div id="print_this" class="bg-white">
				<div class="col-md-12" >
					<table align="center">
						<tr>
							<td valign="top" width="100px"><img src="<?=$this->base_url?>assets/images/bnn.png" width="80px"></td>
							<td>
								<p style="text-align:center;font-size:12pt;font-weight:bold;letter-spacing:1px;">RUJUKAN PASIEN</p>
								<p style="text-align:center;font-size:12pt;font-weight:bold;letter-spacing:1px;"><?=$organization;?>
								</p>
								<p style="text-align:center;font-size:12pt;font-weight:bold;">TAHUN <?=$tahun?></p>
							</td>
						</tr>
					</table>
					<div id="">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th width="25"><p align="center">No</p></th>
									<th><p align="center">Nama</p></th>
									<th><p align="center">No. Rekam Medis</p></th>
									<th><p align="center">Jenis Kelamin</p></th>
									<th><p align="center">Asal BNNP</p></th>
									<th><p align="center">Asal Balai Besar/Loka</p></th>
									<th><p align="center">Status Rujukan</p></th>
									<th><p align="center">Di Rujuk Ke</p></th>
									<th><p align="center">Keterangan</p></th>
								</tr>
							</thead>
							<tbody>
							<?php if(cek_array($arrData)):?>
								<?php foreach($arrData as $x=>$data):?>
								<tr>
									<td align="center"><?php echo ($x+1);?></td>
									<td><?php echo $data["nama"];?></td>
									<td><?php echo $data["no_rekam_medis"];?></td>
									<td align="center"><?php echo $data["jenis_kelamin"];?></td>
									<td>
										<?php 
											if($data['jns_org']==1):
												echo $lookup_bnnp[$data['kd_bnn']];
											elseif($data['jns_org']==3):
												echo $lookup_bnnk[$data['kd_bnn']];
											else:
												echo "<center>-</center>";
											endif;
										?>
										
									</td>
									<td>
										<?php 
											if($data['jns_org']==2): 
												echo $lookup_balai[$data['kd_bnn']];
											else:
												echo "<center>-</center>";
											endif;
										?>
										
									</td>
									<td>
										<?php
											if($data['status_rawat']=="INAP"):
												echo "Rawat Inap";
											elseif($data['status_rawat']=="JALAN"):
												echo "Rawat Jalan";
											endif;
										?>
									</td>
									<td>
										<?php
											switch($data['inst_rujuk']):
												case "BNNP": echo $lookup_bnnp[$data['rujuk_rehab']]; break;
												case "BNNK": echo $lookup_bnnk[$data['rujuk_rehab']]; break;
												case "BL": echo $lookup_balai[$data['rujuk_rehab']]; break;
												case "RD": echo $lookup_rd[$data['rujuk_rehab']]; break;
												case "KM": echo $lookup_km[$data['rujuk_rehab']]; break;
											endswitch;
										?>
									</td>
									<td></td>
								</tr>
								<?php endforeach;?>
							<?php endif;?>
							</tbody>  
						</table>
					</div>
				</div><!-- end div print -->
				
					

</div></div><!-- end box -->
<div id="div_excel" class="hidden">
						<p><b><center>RUJUKAN PASIEN<br><?=$organization;?><br>TAHUN <?=$tahun?></center></b></p>
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th width="25"><p align="center">No</p></th>
									<th><p align="center">Nama</p></th>
									<th><p align="center">No. Rekam Medis</p></th>
									<th><p align="center">Jenis Kelamin</p></th>
									<th><p align="center">Asal BNNP</p></th>
									<th><p align="center">Asal Balai Besar/Loka</p></th>
									<th><p align="center">Status Rujukan</p></th>
									<th><p align="center">Di Rujuk Ke</p></th>
									<th><p align="center">Keterangan</p></th>
								</tr>
							</thead>
							<tbody>
							<?php if(cek_array($arrData)):?>
								<?php foreach($arrData as $x=>$data):?>
								<tr>
									<td align="center"><?php echo ($x+1);?></td>
									<td><?php echo $data["nama"];?></td>
									<td><?php echo $data["no_rekam_medis"];?></td>
									<td align="center"><?php echo $data["jenis_kelamin"];?></td>
									<td>
										<?php 
											if($data['jns_org']==1):
												echo $lookup_bnnp[$data['kd_bnn']];
											elseif($data['jns_org']==3):
												echo $lookup_bnnk[$data['kd_bnn']];
											else:
												echo "<center>-</center>";
											endif;
										?>
										
									</td>
									<td>
										<?php 
											if($data['jns_org']==2): 
												echo $lookup_balai[$data['kd_bnn']];
											else:
												echo "<center>-</center>";
											endif;
										?>
										
									</td>
									<td>
										<?php
											if($data['status_rawat']=="INAP"):
												echo "Rawat Inap";
											elseif($data['status_rawat']=="JALAN"):
												echo "Rawat Jalan";
											endif;
										?>
									</td>
									<td>
										<?php
											switch($data['inst_rujuk']):
												case "BNNP": echo $lookup_bnnp[$data['rujuk_rehab']]; break;
												case "BNNK": echo $lookup_bnnk[$data['rujuk_rehab']]; break;
												case "BL": echo $lookup_balai[$data['rujuk_rehab']]; break;
												case "RD": echo $lookup_rd[$data['rujuk_rehab']]; break;
												case "KM": echo $lookup_km[$data['rujuk_rehab']]; break;
											endswitch;
										?>
									</td>
									<td></td>
								</tr>
								<?php endforeach;?>
							<?php endif;?>
							</tbody>  
						</table>
					</div>
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
			var file="laporan_rujukan_<?="_".date("YmdHis").".xls";?>";
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
			$("#kd_org").val("");
			$(".wilayah").hide();
			$("#kd_org_bnnp").val("");
			$("#kd_org_balai").val("");
			$("#kd_org_bnnk").val("");
			
		}
	}
</script>