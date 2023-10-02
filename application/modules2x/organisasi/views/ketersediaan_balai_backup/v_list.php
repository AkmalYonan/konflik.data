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
			 <form class="form-inline" action="<?=$this->module?>" method="get">
                          <div class="form-group">
                            <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                          </div>
						  
						  <?php 
						  	$y	=	date("Y");
							
							for($i=0; $i<11; $i++):
								$tahun[$i]	=	$y-$i;
							endfor;
						  ?>
						  
                          <div class="form-group">
                          	<div class="row">
								<div class="col-sm-12">
									<div class="has-feedback">
										<!--
										<select name="tahun" class="form-control select2">
											<?//php foreach($tahun as $k=>$v): ?>
											<option value="<?//=$v?>" <?//=($v==$_GET['tahun'])?"selected":""?>><?//=$v?></option>
											<?//php endforeach; ?>
										</select>
										-->
										<input id="q" name="q" class="form-control input-sms" value="<?=$q?>" placeholder="Search...">
										<span class="glyphicon glyphicon-search form-control-feedback text-muted"></span>
									</div>
								</div>
							</div>
                          </div>
                          <!--<div class="form-group">
                            <label for="exampleInputEmail2">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
                          </div>-->
                          <button type="submit" class="btn btn-primary">Search</button>
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
				<table class="table table-bordered table-condensed small-font">
                    <thead>
                        <tr>
                            <th width="20px">No.</th>
                            <th>Nama Balai</th>
                            <th colspan="2">Kapasitas</th>
                            <th colspan="2">Pasien Masuk</th>
							<th colspan="2">Pasien Keluar</th>
							<th>Tahun</th>
							<th colspan="2">Ketersediaan Ruang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$value):
                                    $id=$this->encrypt_status==TRUE?encrypt($value[$this->tbl_idx]):$value[$this->tbl_idx];
                            ?>
                                <tr>
                                    <td><?php echo $offset+$x+1?>.</td>
                                    <td><?php echo $value["nama_instansi"]?></td>
                                    <td align="right" width="100"><?php echo ($value["jml_laki"]+$value["jml_perempuan"])?></td>
									<td width="100">Pasien</td>
                                    <td width="100" align="right"><?php echo $value["pasien_masuk"]; ?></td>
									<td width="100">Pasien</td>
									<td width="100" align="right"><?php echo $value["pasien_keluar"]; ?></td>
									<td width="100">Pasien</td>
									<td align="center"><?=($_GET['tahun'])?$_GET['tahun']:date("Y")?></td>
									<?php $ketersediaan	=	$value["jml_laki"]+$value["jml_perempuan"]-$value["pasien_masuk"]+$value["pasien_keluar"]; ?>
									<td width="100" align="right"><?=$ketersediaan?></td>
									<td width="100">Ruang</td>
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
			var file="laporan_ketersediaan_balai_<?="_".date("YmdHis").".xls";?>";
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
			var base_url="<?//=base_url()?>";
            var html=$("div#print_this").html();
			var file="penetapan_batas_propinsi_<?//="_".date("YmdHis").".html";?>";
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