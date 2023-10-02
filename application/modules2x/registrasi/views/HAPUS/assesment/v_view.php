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
			<a class="btn btn-white active" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="List">
            	<i class="fa fa-list"></i>
            </a>
            <a class="btn btn-white hidden" href="<?php echo $this->module?>add" data-toggle='tooltip' data-original-title="Add">
            	<i class="fa fa-plus"></i>
            </a>
            <a class="btn btn-white" href="<?php echo $this->module?>view/<?=$id?>" data-toggle='tooltip' data-original-title="Refresh">
            	<i class="fa fa-refresh"></i>
            </a>
		</div><!--End Of Col 8-->

		<div class="col-sm-4 hidden">
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

<div id="" class="bg-white">
<br>
<div id="div_excel">
	<div class="row">
		<div class="col-sm-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#resume" data-toggle="tab">Resume Assesment</a></li>
				<li><a href="#pasien-data" data-toggle="tab">Data Pasien</a></li>
				<li><a href="#dokumen" data-toggle="tab">File Pendukung</a></li>
			</ul>

			<div class="tab-content">
				<div class="active tab-pane" id="resume">
					<h4 class="heading">Resume Assesment</h4>
					<?=$this->load->view("v_view_summary")?>
				</div>
				<div class="tab-pane print_this" id="pasien-data">
					<!--<h4 class="heading">Data Pasien</h4>-->
					<?=$this->load->view("common_view/pasien/v_data_pasien_rh")?>
				</div>
				<div class="tab-pane" id="dokumen">

						<?=$this->load->view("common_view/pasien/v_view_pemeriksaan_dokumen");?>
				</div>
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
			var html=style+$("div.print_this").html();
			var file="test<?="_".date("YmdHis").".pdf";?>";
			UrlSubmit(base_url+"export/proxy_pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,p:'A4',o:'L',target:"_blank"});
		});

	});
</script>
