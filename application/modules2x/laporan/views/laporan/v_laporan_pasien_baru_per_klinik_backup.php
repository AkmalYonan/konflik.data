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
		<a href="#" class="print-pdf hidden" data-url=""><i class="fa fa-file-pdf-o"></i> PDF</a>
		<div class="btn-group btn-group-sm pull-right">
        	<a href="/print" class="btn btn-white div_id_print_modal" data-div_id="#print_this" data-page_orientation='L' data-page_size='A4' data-toggle='tooltip' data-original-title="Print Preview"><i class="fa fa-print"></i>&nbsp;Print Preview</a>
        	<a href="#" class="btn btn-white print-excel" data-url="" data-toggle='tooltip' data-original-title="Export to Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a>
		</div>
        <div class="clearfix"></div>
        </div>
        <!-- END: TOOLBAR -->

		<div class="box box-widget">
                <div class="box-header with-border clearfix hidden">
                		  
                </div>
                <!-- /.box-header -->
                <div class="box-body">

<div id="print_this" class="bg-white">
<!--
<table align="center">
	<tr>
    	<td width="100px"><img src="<?=$this->base_url?>assets/images/bnn.png" width="80px"></td>
        <td>
        	<p style="text-align:center;font-size:14pt;font-weight:bold">NAMA KLINIK PRATAMA BNNK JAKSEL</p>
			<p style="text-align:center;font-size:12pt;font-weight:bold">ALAMAT</p>
		</td>
    </tr>
</table>
-->
<table align="center">
	<tr>
    	<td width="100px"><img src="<?=$this->base_url?>assets/images/bnn.png" width="80px"></td>
        <td>
        	<p style="text-align:center;font-size:14pt;font-weight:bold">LAPORAN DATA PASIEN BARU</p>
			<p style="text-align:center;font-size:12pt;font-weight:bold">NAMA KLINIK PRATAMA BNN/BNNP/BNNK</p>
			<p style="text-align:center;font-size:12pt;font-weight:bold">BALAI/LOKA REHABILITASI BNN</p>
			<p style="text-align:center;font-size:10pt;font-weight:bold">ALAMAT KLINIK PRATAMA:</p>
		</td>
    </tr>
</table>
<br><br>
<div id="div_excel">
<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th><p align="center">Tanggal</p></th>
			<th><p align="center">No</p></th>
			<th><p align="center">Nama</p></th>
			<th><p align="center">No. Rekam Medis</p></th>
			<th><p align="center">Alamat</p></th>
			<th><p align="center">Umur</p></th>
			<th align="center"><p align="center">Jenis Kelamin<br />L/P</p></th>
			<th><p align="center">Pendidikan</p></th>
			<th><p align="center">Pekerjaan</p></th>
			<th><p align="center">Status</p></th>
			<th><p align="center">Riwayat Rehab<font color="#FF0000">*</font></p></th>
			<th><p align="center">Asal Rujukan<font color="#FF0000">*</font></p></th>
			<th><p align="center">Diagnosa</p></th>
			<th><p align="center">Pemeriksaan Urin Zat</p></th>
			<th><p align="center">Terapi</p></th>
			<th><p align="center">Rujukan</p></th>
			<th><p align="center">Keterangan</p></th>
		</tr>
		<tr>
			<?php for($i=0; $i<17; $i++): ?>
			<th><p align="center"><?=($i+1)?></p></th>
			<?php endfor; ?>
		</tr>
	</thead>
	<tbody>
    <?php if(cek_array($arrData)):?>
    	<?php foreach($arrData as $x=>$data):?>
    	<tr>
			<td><?php echo date_format(date_create($data['tgl_registrasi']),"d-m-Y");?></td>
			<td><?php echo ($x+1);?></td>
        	<td><?php echo $data["nama"];?></td>
            <td><?php echo $data["no_rekam_medis"];?></td>
            <td><?php echo $data["alamat"];?></td>
            <td><?php echo $data["umur"];?></td>
            <td><?php echo $data["jenis_kelamin"];?></td>
            <td><?php echo $data["pendidikan"];?></td>
            <td><?php echo $data["pekerjaan"];?></td>
            <td><?php echo $data["status"];?></td>
            <td><?php echo $data["riwayat_rehab"];?></td>
            <td><?php echo $data["asal_rujukan"];?></td>
            <td><?php echo $data["diagnosa"];?></td>
            <td><?php echo $data["pemeriksaan_urin_zat"];?></td>
            <td><?php echo $data["terapi"];?></td>
            <td><?php echo $data["rujukan"];?></td>
            <td><?php echo $data["keterangan"];?></td>
        </tr>
        <?php endforeach;?>
    <?php endif;?>
    </tbody>  
</table>
<p><strong>Keterangan : <font color="#FF0000">*</font> Bila Ada</strong></p>
<!--
<table class="table table-bordered table-condensed">
	<thead>
    <tr>
    <th>Nama</th>
    <th>No. Rekam Medis</th>
    <th>Alamat</th>
    <th>Umur</th>
	<th>Jenis Kelamin<br>L/P</th>
    <th>Pendidikan</th>
    <th>Pekerjaan</th>
    <th>Status</th>
    <th>Riwayat Rehab</th>
    <th>Asal Rujukan</th>
    <th>Diagnosa</th>
    <th>Pemeriksaan Urin Zat</th>
    <th>Terapi</th>
    <th>Rujukan</th>
    <th>Keterangan</th>
    </tr>  
    </thead>
    <tbody>
    	<?php if(cek_array($arrData)):?>
    	<?php foreach($arrData as $x=>$data):?>
    	<tr>
        	<td><?php echo $data["nama"];?></td>
            <td><?php echo $data["no_rekam_medis"];?></td>
            <td><?php echo $data["alamat"];?></td>
            <td><?php echo $data["umur"];?></td>
            <td><?php echo $data["jenis_kelamin"];?></td>
            <td><?php echo $data["pendidikan"];?></td>
            <td><?php echo $data["pekerjaan"];?></td>
            <td><?php echo $data["status"];?></td>
            <td><?php echo $data["riwayat_rehab"];?></td>
            <td><?php echo $data["asal_rujukan"];?></td>
            <td><?php echo $data["diagnosa"];?></td>
            <td><?php echo $data["pemeriksaan_urin_zat"];?></td>
            <td><?php echo $data["terapi"];?></td>
            <td><?php echo $data["rujukan"];?></td>
            <td><?php echo $data["keterangan"];?></td>
        </tr>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>  
</table>
-->
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