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
        	<p style="text-align:center;font-size:14pt;font-weight:bold">NAMA KLINIK PRATAMA BNNK JAKSEL</p>
			<p style="text-align:center;font-size:12pt;font-weight:bold">ALAMAT</p>
		</td>
    </tr>
</table>

<br><br>
<div id="div_excel">
<p style="text-align:center;font-size:12pt;font-weight:bold">LAPORAN JUMLAH PASIEN PER TAHUN</p>
<hr>

<table>
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
    	<th colspan="2">Jumlah Client</th>
        <th colspan="21">Diagnosa dan Jumlah Bentuk Layanan</th>
        <th colspan="4">Jumlah Rujukan</th>
    </tr>
    <tr>
    <th style="vertical-align:top;">Lama</th>
    <th style="vertical-align:top;">Baru</th>
    <th style="vertical-align:top;">Asesmen</th>
    <th style="vertical-align:top;">Peme-<br>rik-<br>saan<br>Fisik</th>
	<th style="vertical-align:top;">Urin<br>Zat</th>
    <th style="vertical-align:top;">F10</th>
    <th style="vertical-align:top;">F11</th>
    <th style="vertical-align:top;">F12</th>
    <th style="vertical-align:top;">F13</th>
    <th style="vertical-align:top;">F14</th>
    <th style="vertical-align:top;">F15</th>
    <th style="vertical-align:top;">F16</th>
    <th style="vertical-align:top;">F17</th>
    <th style="vertical-align:top;">F18/<br>F19</th>
    <th style="vertical-align:top;">Lain-<br>lain</th>
    <th style="vertical-align:top;">Tera-<br>pi<br>Medis</th>
    <th style="vertical-align:top;">Detok-<br>sifi-<br>kasi</th>
    <th style="vertical-align:top;">Konseling HIV/IMS</th>
    <th style="vertical-align:top;">Komor<br>dibi<br>tas Psiki<br>atrik</th>
    <th style="vertical-align:top;">Konse<br>ling Adik<br>si</th>
    <th style="vertical-align:top;">MI</th>
    <th style="vertical-align:top;">CBT</th>
    <th style="vertical-align:top;">Pence<br>gahan Kekam<br>buhan</th>
    <th style="vertical-align:top;">Ba<br>lai</th>
    <th style="vertical-align:top;">Pan<br>ti</th>
    <th style="vertical-align:top;">RSUD/<br>RSJ</th>
    <th style="vertical-align:top;">Lain-<br>lain</th>
    
    
    
    
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
            <td><?php echo $data["terapi_medik"];?></td>
            <td><?php echo $data["detoksifikasi"];?></td>
            <td><?php echo $data["konseling_hiv"];?></td>
            <td><?php echo $data["kom_psikiatrik"];?></td>
            <td><?php echo $data["konseling_adiksi"];?></td>
            <td><?php echo $data["mi"];?></td>
            <td><?php echo $data["cbt"];?></td>
            <td><?php echo $data["pencegahan"];?></td>
            <td><?php echo $data["balai"];?></td>
            <td><?php echo $data["panti"];?></td>
            <td><?php echo $data["rsud_rsj"];?></td>
            <td><?php echo $data["lain_lain"];?></td>
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