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
		<div class="col-md-9 ">
			<form class="form-inline" action="<?=$this->module?>index_rawat_lanjut" method="get">
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
							<li class="active"><a href="<?=$this->module?>index_rawat_lanjut">Rawat Lanjut</a></li>
							<li><a href="<?=$this->module?>index_rujukan">Rujukan Pasien</a></li>
							<li><a href="<?=$this->module?>index_outcome">Outcome Pasca Rehabilitasi</a></li>
							<!--<li><a href="<?=$this->module?>index_status">Status Pasien Rawat Lanjut</a></li>-->
						</ul>
					</div>
				</div><!--End Of Row-->

				<div id="print_this" class="bg-white">
                
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
	$flag_no="<i class='fa red'>&#xf00d;</i>";
	
	//$flag_no="<i class='fa red'>&#xf068;</i>";
	//$flag_no="-";

	//echo $flag_yes;
	//echo $flag_no;
?>
            
					<div id="div_excel">
						<table align="center">
							<tr>
								<td valign="top" width="100px"><img src="<?=$this->base_url?>assets/images/bnn.png" width="80px"></td>
								<td>
									<p style="text-align:center;font-size:12pt;font-weight:bold;letter-spacing:1px;">RAWAT LANJUT</p>
									<p style="text-align:center;font-size:12pt;font-weight:bold;letter-spacing:1px;"><?=$organization;?>
									</p>
									<p style="text-align:center;font-size:12pt;font-weight:bold;">TAHUN <?=$tahun?></p>
								</td>
							</tr>
						</table>
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th width="25" rowspan="2"><p align="center">No</p></th>
									<th rowspan="2"><p align="center">Nama</p></th>
									<th rowspan="2"><p align="center">No. Rekam Medis</p></th>
									<th rowspan="2"><p align="center">Jenis Kelamin</p></th>
									<th colspan="3"><p align="center">Pemantauan</p></th>
									<th colspan="4"><p align="center">Pendampingan</p></th>
									<th rowspan="2"><p align="center">Status Pulih</p></th>
									<th rowspan="2"><p align="center">Keterangan</p></th>
									<!--
									<th rowspan="2" width="100"><p align="center">&nbsp;</p></th>
									-->
								</tr>
								<tr>
									<th><p align="center">Produktif</p></th>
									<th><p align="center">Evaluasi</p></th>
									<th><p align="center">Tes Urin</p></th>
									<th><p align="center">Home Visit</p></th>
									<th><p align="center">Pertemuan Kelompok</p></th>
									<th><p align="center">Konseling</p></th>
									<th><p align="center">Tes Urin</p></th>
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
									<td align="center">
										<?php if($data['pukp']==1): ?>
											<!--<i class="fa fa-check green"></i>-->
                                            <?=$flag_yes;?>
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['puep'==1]): ?>
                                        <?=$flag_yes;?>
											<!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
                                        <?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['putu']==1): ?>
											<?=$flag_yes;?>
                                            <!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['pdhv']==1): ?>
											<?=$flag_yes;?>
                                        	<!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
											<?=$flag_no;?>
                                            <!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['pdpk']==1): ?>
                                        	<?=$flag_yes;?>
											<!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['pdkl']==1): ?>
                                        	<?=$flag_yes;?>
											<!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['pdtu']==1): ?>
											<!--<i class="fa fa-check green"></i>-->
                                            <?=$flag_yes;?>
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php
											if($data['outcome_pasien']=='PP'):
												echo "<span class='label label-primary'>Pulih Produktif</span>";
											elseif($data['outcome_pasien']=='PTP'):
												echo "<span class='label label-info'>Pulih Tidak Produktif</span>";
											elseif($data['outcome_pasien']=='TPP'):
												echo "<span class='label label-warning'>Tidak Pulih Produktif</span>";
											elseif($data['outcome_pasien']=='TPTP'):
												echo "<span class='label label-danger'>Tidak Pulih Tidak Produktif</span>";
											endif;		
										?>
									</td>
									<td align="center">
										<?php
											if($data['outcome_pasien']=='PP'):
												echo "<span class='label label-primary'>Berhasil</span>";
											elseif($data['outcome_pasien']=='PTP'):
												echo "<span class='label label-info'>Pulih Tidak Produktif</span>";
											elseif($data['outcome_pasien']=='TPP'):
												echo "<span class='label label-warning'>Vokasional</span>";
											elseif($data['outcome_pasien']=='TPTP'):
												echo "<span class='label label-danger'>Rawat Ulang</span>";
											endif;		
										?>
									</td>
								</tr>
								<?php endforeach;?>
							<?php endif;?>
							</tbody>  
						</table>
					</div>
				</div><!-- end div print -->
                
                <div id="div_excel2" class="hidden">
                		<? $flag_yes="1";
							$flag_no="0";
						?>
						<p><b><center>RAWAT LANJUT PASCA REHABILITASI<br><?=$organization;?><br>TAHUN <?=$tahun?></center></b></p>
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th width="25" rowspan="2"><p align="center">No</p></th>
									<th rowspan="2"><p align="center">Nama</p></th>
									<th rowspan="2"><p align="center">No. Rekam Medis</p></th>
									<th rowspan="2"><p align="center">Jenis Kelamin</p></th>
									<th colspan="3"><p align="center">Pemantauan</p></th>
									<th colspan="4"><p align="center">Pendampingan</p></th>
									<th rowspan="2"><p align="center">Status Pulih</p></th>
									<th rowspan="2"><p align="center">Keterangan</p></th>
									<!--
									<th rowspan="2" width="100"><p align="center">&nbsp;</p></th>
									-->
								</tr>
								<tr>
									<th><p align="center">Produktif</p></th>
									<th><p align="center">Evaluasi</p></th>
									<th><p align="center">Tes Urin</p></th>
									<th><p align="center">Home Visit</p></th>
									<th><p align="center">Pertemuan Kelompok</p></th>
									<th><p align="center">Konseling</p></th>
									<th><p align="center">Tes Urin</p></th>
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
									<td align="center">
										<?php if($data['pukp']==1): ?>
											<!--<i class="fa fa-check green"></i>-->
                                            <?=$flag_yes;?>
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['puep'==1]): ?>
                                        <?=$flag_yes;?>
											<!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
                                        <?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['putu']==1): ?>
											<?=$flag_yes;?>
                                            <!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['pdhv']==1): ?>
											<?=$flag_yes;?>
                                        	<!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
											<?=$flag_no;?>
                                            <!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['pdpk']==1): ?>
                                        	<?=$flag_yes;?>
											<!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['pdkl']==1): ?>
                                        	<?=$flag_yes;?>
											<!--<i class="fa fa-check green"></i>-->
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php if($data['pdtu']==1): ?>
											<!--<i class="fa fa-check green"></i>-->
                                            <?=$flag_yes;?>
										<?php else: ?>
                                        	<?=$flag_no;?>
											<!--<i class="fa fa-times red"></i>	-->
										<?php endif; ?>
									</td>
									<td align="center">
										<?php
											if($data['outcome_pasien']=='PP'):
												echo "<span class='label label-primary'>Pulih Produktif</span>";
											elseif($data['outcome_pasien']=='PTP'):
												echo "<span class='label label-info'>Pulih Tidak Produktif</span>";
											elseif($data['outcome_pasien']=='TPP'):
												echo "<span class='label label-warning'>Tidak Pulih Produktif</span>";
											elseif($data['outcome_pasien']=='TPTP'):
												echo "<span class='label label-danger'>Tidak Pulih Tidak Produktif</span>";
											endif;		
										?>
									</td>
									<td align="center">
										<?php
											if($data['outcome_pasien']=='PP'):
												echo "<span class='label label-primary'>Berhasil</span>";
											elseif($data['outcome_pasien']=='PTP'):
												echo "<span class='label label-info'>Pulih Tidak Produktif</span>";
											elseif($data['outcome_pasien']=='TPP'):
												echo "<span class='label label-warning'>Vokasional</span>";
											elseif($data['outcome_pasien']=='TPTP'):
												echo "<span class='label label-danger'>Rawat Ulang</span>";
											endif;		
										?>
									</td>
								</tr>
								<?php endforeach;?>
							<?php endif;?>
							</tbody>  
						</table>
					</div>

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
			var file="laporan_pasien_rawat_lanjut_<?="_".date("YmdHis").".xls";?>";
			var base_url="<?=base_url()?>";
			/*get html table */
			var tbl = $('<div>').append($('div#div_excel2').clone()).remove().html();
			/* add table to div to export */
			var div = $('<div>').append(tbl);
			div.find("table").attr("border","1");
			//window.open('data:application/vnd.ms-excel,' + escape(tbl));
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