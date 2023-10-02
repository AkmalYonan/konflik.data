<?
	$bln[""]="Semua Bulan";
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
	$bulan=$req["bulan"]?$req["bulan"]:"";
	$tahun=$req["tahun"]?$req["tahun"]:date("Y");
	
	
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

<?php

	$y	=	date("Y");
	
	for($i=0; $i<11; $i++):
		$tahun[$i]	=	$y-$i;
	endfor;

?>

<div class="content-toolbar">
		<div class="row">
		<div class="col-sm-8">
			<form action="<?=$this->module?>rekap_sumber_pasien" method="get">
			<table cellpadding="10" cellspacing="10">
				<tr>
					<td width="50" align="center">TAHUN</td>
					<td width="10">&nbsp;</td>
					<td>
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
					</td>
					<td width="10">&nbsp;</td>
					<td width="50">BULAN</td>
					<td width="10">&nbsp;</td>
					<td>
						<?=form_dropdown("bulan",$bln,$bulan,
								"id='bulan' class='form-control required' 
								");?>
					</td>
					<td width="10">&nbsp;</td>
					<!--<td width="50">TINGKAT</td>
					<td width="10">&nbsp;</td>
					<td>
						<select name="tingkat" class="form-control select2" id="select_tingkat">
							<option value="">Semua Tingkat</option>
							<option value="BNN" <?=($_GET['tingkat']=="BNN")?"selected":""?>>BNN PUSAT</option>
							<option value="BNNP" <?=($_GET['tingkat']=="BNNP")?"selected":""?>>BNN PROPINSI</option>
							<option value="BNNK" <?=($_GET['tingkat']=="BNNK")?"selected":""?>>BNN KOTA/KABUPATEN</option>
						</select>
					</td>
					<td width="10">&nbsp;</td>-->
					<td><button type="submit" class="btn btn-primary btn-md">Search</button></td>
					<td width="10">&nbsp;</td>
					<td>
						<a href="<?=$this->module?>rekap_status_rawat">
							<button type="button" class="btn btn-md btn-default"><i class="fa fa-refresh">&nbsp;</i>Refresh</button>
						</a>
					</td>
				<tr>
			</table>
			</form>
		</div><!--End Of Col 8-->
		
		<div class="col-sm-4">
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

<div id="print_this" class="bg-white">
<div id="div_excel">
	
	<div class="row">
		<div class="col-sm-12">
			<h4 align="center">REKAPITULASI PASIEN REHABILITASI NASIONAL</h4>
			<h4 align="center">BERDASARKAN HUKUM</h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th rowspan="2"><p align="center">NO</p></th>
						<th rowspan="2"><p align="center">PROVINSI</p></th>
						<th rowspan="2"><p align="center">SUMBER PASIEN</p></th>
						<th colspan="12"><p align="center">BERDASARKAN PERBULAN</p></th>
						<th rowspan="2"><p align="center">JUMLAH</p></th>
					</tr>
					<tr>
						<?php foreach($listMonth as $k=>$v): ?>
						<th><p align="center"><?=strtoupper($v)?></p></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
				<?php if(cek_array($arrData)):?>
					<?php foreach($arrData as $x=>$v):?>
					<tr>
						<td align="center" rowspan="4" valign="middle"><?=($x+1)?></td>
						<td rowspan="4" valign="middle"><?=$v['namaProvinsi']?></td>
						<td>Sukarela</td>
						<?php foreach($listMonth as $ki=>$vi): ?>
						<td align="right"><?=$v['sukarela_'.($ki+1)]?></td>
						<?php endforeach; ?>
						<td align="right"><strong><?=$v['total_sukarela']?></strong></td>
					</tr>
					<tr>
						<td>Hukum</td>
						<?php foreach($listMonth as $ki=>$vi): ?>
						<td align="right"><?=$v['hukum_'.($ki+1)]?></td>
						<?php endforeach; ?>
						<td align="right"><strong><?=$v['total_hukum']?></strong></td>
					</tr>
					<tr>
						<td>Warga Binaan Permasyarakatan</td>
						<?php foreach($listMonth as $ki=>$vi): ?>
						<td align="right"><?=$v['wbp_'.($ki+1)]?></td>
						<?php endforeach; ?>
						<td align="right"><strong><?=$v['total_wbp']?></strong></td>
					</tr>
					<tr>
						<td>Vonis Hukum</td>
						<?php foreach($listMonth as $ki=>$vi): ?>
						<td align="right"><?=$v['vh_'.($ki+1)]?></td>
						<?php endforeach; ?>
						<td align="right"><strong><?=$v['total_vh']?></strong></td>
					</tr>		
					<?php endforeach;?>
					<tr>
						<td>&nbsp;</td>
						<td align="center" colspan="2"><strong>JUMLAH PERBULAN</strong></td>
						<?php foreach($listMonth as $k=>$v): ?>
						<td align="right"><strong><?=$total[$k+1]?></strong></td>
						<?php endforeach; ?>
						<td align="right"><strong><?=$jumlah?></strong></td>
					</tr>
				<?php endif;?>
				</tbody>  
			</table>
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
			var file="rekap_laporan_status_rawat_<?="_".date("YmdHis").".xls";?>";
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