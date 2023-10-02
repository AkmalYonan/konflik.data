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
		<div class="col-sm-8 hidden">
			<form action="<?=$this->module?>index" method="get">
			<table cellpadding="10" cellspacing="10">
				<tr>
					<td width="50" align="center">TAHUN</td>
					<td width="10">&nbsp;</td>
					<td>
						<select name="tahun" class="form-control select2" id="select_tahun">
							<?php foreach($tahun as $k=>$v): ?>
							<option value="<?=$v?>" <?=($v==$_GET['tahun'])?"selected":""?>><?=$v?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td width="10">&nbsp;</td>
					<td width="50">BULAN</td>
					<td width="10">&nbsp;</td>
					<td>
						<select name="bulan" class="form-control select2" id="select_bulan">
							<option value="">Semua Bulan</option>
							<?php foreach($listMonth as $k=>$v): ?>
							<option value="<?=$k?>" <?=($_GET['bulan'] and $k==$_GET['bulan'])?"selected":""?>><?=$v?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td width="10">&nbsp;</td>
					<td width="50">TINGKAT</td>
					<td width="10">&nbsp;</td>
					<td>
						<select name="tingkat" class="form-control select2" id="select_tingkat">
							<option value="">Semua Tingkat</option>
							<option value="BNN" <?=($_GET['tingkat']=="BNN")?"selected":""?>>BNN PUSAT</option>
							<option value="BNNP" <?=($_GET['tingkat']=="BNNP")?"selected":""?>>BNN PROPINSI</option>
							<option value="BNNK" <?=($_GET['tingkat']=="BNNK")?"selected":""?>>BNN KOTA/KABUPATEN</option>
						</select>
					</td>
					<td width="10">&nbsp;</td>
					<td><button type="submit" class="btn btn-primary btn-md">Search</button></td>
					<td width="10">&nbsp;</td>
					<td>
						<a href="<?=$this->module?>index">
							<button type="button" class="btn btn-md btn-default"><i class="fa fa-refresh">&nbsp;</i>Refresh</button>
						</a>
					</td>
				<tr>
			</table>
			</form>
		</div><!--End Of Col 8-->
		
		<div class="col-sm-4 pull-right">
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
							<li><a href="admin/dashboard_rehab">Rujukan Pasien</a></li>
							<li class="active"><a href="<?=$this->module?>index_outcome">Outcome Pasca Rehabilitasi</a></li>
						</ul>
					</div>
				</div><!--End Of Row-->

				<div id="print_this" class="bg-white">
					<br>
					<div id="div_excel">
						<h4>Laporan Outcome Pasien Pasca Rehabilitasi</h4>
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th width="25"><p align="center">No</p></th>
									<th><p align="center">Nama</p></th>
									<th><p align="center">No. Rekam Medis</p></th>
									<th><p align="center">Jenis Kelamin</p></th>
									<th><p align="center">Rawat Inap</p></th>
									<th><p align="center">Rawat Jalan</p></th>
									<th><p align="center">Status Pulih</p></th>
									<th><p align="center">Keterangan</p></th>
									<th width="100"><p align="center">&nbsp;</p></th>
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
										<?php
											if(substr($data['status_proses'],0,2)=="RI"):
												echo "<i class='fa fa-check'></i>";
											else:
												echo "<i class='fa fa-times'></i>";
											endif;
										?>
									</td>
									<td align="center">
										<?php
											if(substr($data['status_proses'],0,2)=="RJ"):
												echo "<i class='fa fa-check'></i>";
											else:
												echo "<i class='fa fa-times'></i>";
											endif;
										?>
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
									<td></td>
									<td></td>
								</tr>
								<?php endforeach;?>
							<?php endif;?>
							</tbody>  
						</table>
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