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
                          
                          <!-- <a id="btn_down" class="btn btn-sm btn-default hidden" href="#"><i class="icon-download-alt" data-toggle='tooltip' data-original-title="Print/Download"></i>&nbsp;Print/Download </a>
                          <a class="btn btn-sm btn-default dropdown-toggle hidden" data-toggle="dropdown" href="#"><span class="caret"> </span></a>
                          <ul class="dropdown-menu pull-right">
                           <li><a href="#" class="print-pdf" data-url=""><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                            <li><a href="#" class="print-html" data-url=""><i class="fa fa-print"></i> Print</a></li>
                            <li></li>
                            <li><a href="#" class="print-excel" data-url=""><i class="fa fa-file-excel-o"></i> Excel</a></li>
                            
                          </ul>-->
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
			<td width="100" rowspan="4"><img src="<?=$this->base_url?>assets/images/bnn.png" width="80px"></td>
			<td align="center"><b>LAPORAN DATA PASIEN LAMA</b></td>
		</tr>
		<tr>
			<td align="center"><b>NAMA KLINIK PRATAMA BNN/BNNP/BNNK</b></td>
		</tr>
		<tr>
			<td align="center"><b>BALAI/LOKA REHABILITASI BNN</b></td>
		</tr>
		<tr>
			<td align="center"><b>Alamat Klinik Pratama:</b></td>
		</tr>
	</table>
	<br>
	<div id="div_excel">
		<table class="table table-bordered table-condensed" width="100%">
			<thead>
				<tr style="background:#eee">
					<td align="center" height="50" style="padding-top:15px;"><b>TANGGAL</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>NO</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>NAMA</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>NO. REKAM MEDIS</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>ALAMAT</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>UMUR</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>JENIS KELAMIN</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>DIAGNOSA</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>PEMERIKSAAN URIN ZAT</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>TERAPI</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>RUJUKAN</b></td>
					<td align="center" valign="center" style="padding-top:15px;"><b>KETERANGAN</b></td>
				</tr>
				<tr>
					<td align="center"><b>1</b></td>
					<td align="center"><b>2</b></td>
					<td align="center"><b>3</b></td>
					<td align="center"><b>4</b></td>
					<td align="center"><b>5</b></td>
					<td align="center"><b>6</b></td>
					<td align="center"><b>7</b></td>
					<td align="center"><b>8</b></td>
					<td align="center"><b>9</b></td>
					<td align="center"><b>10</b></td>
					<td align="center"><b>11</b></td>
					<td align="center"><b>12</b></td>
				</tr> 				
			</thead>
			<tbody>
				<?php if(cek_array($arrData)):?>
				<?php foreach($arrData as $x=>$data):?>
				<tr>
					<td><?php echo date_format(date_create($data["tgl_registrasi"]),"d-m-Y");?></td>
					<td><?php echo $x+1;?></td>
					<td><?php echo $data["nama"];?></td>
					<td><?php echo $data["no_rekam_medis"];?></td>
					<td><?php echo $data["alamat"];?></td>
					<td><?php echo $data["umur"];?></td>
					<td><?php echo $data["jenis_kelamin"];?></td>
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