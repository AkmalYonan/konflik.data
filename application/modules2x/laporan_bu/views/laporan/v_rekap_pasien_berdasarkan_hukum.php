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
                         
   </div><!-- end pull-right -->
                    <div class="clearfix"></div>
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
    	<td width="100px"><img src="<?=$this->base_url?>assets/images/bnn.png" width="80px"></td>
        <td>
        	<p style="text-align:center;font-size:14pt;font-weight:bold">REKAPITULASI PASIEN REHABILITASI NASIONAL BERDASARKAN HUKUM</p>
			<p style="text-align:center;font-size:12pt;font-weight:bold"></p>
		</td>
    </tr>
</table>

<br><br>
<div id="div_excel">
<hr>

<table>
	<tr>
    	<td>Bulan</td>
        <td><?=$tahun?></td>
    </tr>
    <tr>
    	<td>Tahun</td>
        <td><?=$bulan?></td>
    </tr>
</table>
<br>
<div class="formSep"></div>
<table class="table table-bordered table-condensed">
	<thead>
    <tr>
    	<th class="ttop" width="20px" rowspan="2">No</th>
    	<th rowspan="2">Provinsi</th>
        <th rowspan="2">Sumber Pasien</th>
        <th colspan="12">Berdasarkan PerBulan</th>
		<th rowspan="2" style="vertical-align:top;">Jumlah</th>
    </tr>
    <tr>
    <th style="vertical-align:top;">January</th>
    <th style="vertical-align:top;">Februari</th>
    <th style="vertical-align:top;">Maret</th>
    <th style="vertical-align:top;">April</th>
	<th style="vertical-align:top;">Mei</th>
    <th style="vertical-align:top;">Juni</th>
    <th style="vertical-align:top;">Juli</th>
    <th style="vertical-align:top;">Agustus</th>
    <th style="vertical-align:top;">September</th>
    <th style="vertical-align:top;">Oktober</th>
    <th style="vertical-align:top;">November</th>
    <th style="vertical-align:top;">Desember</th>
    
    </tr>  
   
    </thead>
    <tbody>
    	<?php if(cek_array($arrData)):?>
    	<?php foreach($arrData as $x=>$data):?>
    	<tr>
        	<td><?php echo $x+1;?></td>
        	<td><?php echo $data["baru"];?></td>
            <td><?php echo $data["lama"];?></td>
            <td><?php echo $data["asesmen"];?></td>
            <td><?php echo $data["pemeriksaan_fisik"];?></td>
            <td><?php echo $data["urin_zat"];?></td>
            <td><?php echo $data["f10"];?></td>
            <td><?php echo $data["f11"];?></td>
            <td><?php echo $data["f12"];?></td>
            <td><?php echo $data["f13"];?></td>
            <td><?php echo $data["f14"];?></td>
            <td><?php echo $data["f15"];?></td>
            <td><?php echo $data["f16"];?></td>
            <td><?php echo $data["f17"];?></td>
            <td><?php echo $data["f18_19"];?></td>
            <td><?php echo $data["lain_lain1"];?></td>
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