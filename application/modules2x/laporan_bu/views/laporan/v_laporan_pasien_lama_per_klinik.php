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

?>
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
                        <div class="col-md-6">
                            <form action="<?=$this->module?>pasien_lama_per_klinik" method="get">
                            <table border="0" cellpadding="30" cellspacing="30">
                                <tr>
                                <td><strong>Tahun </strong></td>
                                <td width="10" align="center">:</td>
                                <td>
                                	<select name="tahun" class="form-control">
                                    	<? for($i=date(Y);$i>=date(Y)-10;$i--){?>
                                        <option <?=($tahun==$i)? "selected":""?> value="<?=$i?>"><?=$i?></option>
                                        <? }?>
                                    </select>
                                </td>
                                <td width="20">&nbsp;</td>
                                <td><strong>Bulan </strong></td>
                                <td width="10" align="center">:</td>
                                <td>
                                	<select name="bulan" class="form-control">
                                    	<option value="">--Semua Bulan--</option>
										<? foreach($bln as $k=>$v):?>
                                        <option <?=($bulan==$k)? "selected":""?>  value="<?=$k?>"><?=$v?></option>
                                    	<? endforeach;?>
                                    </select>
                                </td>
                                <td width="20">&nbsp;</td>
                                <td><strong>Tingkat </strong></td>
                                <td width="10" align="center">:</td>
                                <td>
                                	<select name="tingkat" class="form-control">
                                    	<option value="">Semua Tingkat</option>
                                        <option value="BNN" <?=($_GET['tingkat']=="BNN")?"selected":""?>>BNN PUSAT</option>
                                        <option value="BNNP" <?=($_GET['tingkat']=="BNNP")?"selected":""?>>BNN PROPINSI</option>
                                        <option value="BNNK" <?=($_GET['tingkat']=="BNNK")?"selected":""?>>BNN KOTA/KABUPATEN</option>
                                    </select>
                                </td>
                                <td width="5">&nbsp;</td>
                                <td>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </td>
                                <td>
                                    <a href="<?=$this->module?>index">
                                        <button type="button" class="btn btn-md btn-default"><i class="fa fa-refresh">&nbsp;</i>Refresh</button>
                                    </a>
                                </td>
                                </tr>
                               </table>
                               
                        	   </form>
                        </div>
                        <div class="col-md-6">
                        
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
                  </div>
            </div>
            <!-- END: TOOLBAR -->

<div class="box box-widget">
<div class="box-header with-border clearfix hidden">
                		  
</div>
<!-- /.box-header -->
<div class="box-body">
<br />
<div id="print_this" class="bg-white">
<table align="center" border="0">
	<tr>
    	<td valign="top" width="100px"><img src="<?=$this->base_url?>assets/images/bnn.png" width="80px"></td>
        <td>
        	<p style="text-align:left;font-size:14pt;font-weight:bold;letter-spacing:1px;">LAPORAN DATA PASIEN LAMA </p>
            <p style="text-align:left;font-size:14pt;font-weight:bold;letter-spacing:1px;">NAMA KLINIK PRATAMA BNN/BNNP/BNNK <br/>
            BALAI/LOKA REHABILITASI BNN
            </p>
            <p style="text-align:left;font-size:12pt;font-weight:bold;">Alamat Klinik Pratama :</p>
		</td>
    </tr>
</table>
<style>
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #CCC;
    margin: 1em 0;
    padding: 0; 
}
</style>
<hr />

<div id="div_excel">
<div class="sch">
<table border="0" >
    <tr>
    <td style="background-color:#CCCCCC; padding:2px 10px">TAHUN</td>
    <td width="20" align="center"></td>
    <td style="text-decoration: underline;font-weight:bold;">
    <?=($tahun)? $tahun:date(Y);?></td>
    <td width="20">&nbsp;</td>
    <td style="background-color:#CCCCCC; padding:2px 10px">BULAN</td>
    <td width="20" align="center"></td>
   	<td style="text-decoration: underline;font-weight:bold;">
    <?=($bulan)? $bln[$bulan]:"Semua Bulan";?></td>
    <td width="20">&nbsp;</td>
    <td style="background-color:#CCCCCC; padding:2px 10px">TINGKAT</td>
    <td width="20" align="center"></td>
    <td style="text-decoration: underline;font-weight:bold;">
    <?=($tingkat)? $tingkat:"Semua Tingkat";?></td>
    </tr>
</table>
</div>
<br />
<div class="formSep">
</div>
<!--
<p style="text-align:center;font-size:12pt;font-weight:bold">LAPORAN DATA PASIEN LAMA</p>
-->
<style>
table th{ vertical-align:top !important; text-align:center; font-size:14px; }
</style>
<table class="table table-bordered table-condensed">
	<thead>
    <tr>
    
    <th>Tanggal</th>
    <th width="180px;">Nama</th>
    <th>No. Rekam Medis</th>
    <th>Alamat</th>
    <th>Umur</th>
	<th>Jenis Kelamin<br>L/P</th>
    <!--
    <th>Pendidikan</th>
    <th>Pekerjaan</th>
    <th>Riwayat Rehab</th>-->
    <th>Status</th>
    <th>Asal Rujukan</th>
    <th>Diagnosa</th>
    <th>Pemeriksaan Urin Zat</th>
    <th>Terapi</th>
    <th>Rujukan</th>
    <th>Keterangan</th>
    </tr>  
    </thead>
    <tbody>
    	<tr>
        <td align="center"><b>0</b></td>
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
       <!-- <td align="center"><b>13</b></td>
        <td align="center"><b>14</b></td>
        <td align="center"><b>15</b></td>-->
        </tr>  
        <? //pre($arrData);?>
    	<?php if(cek_array($arrData)):?>
    	<?php foreach($arrData as $x=>$data):?>
    	<tr>
        	<td><?php  echo date("d/m/Y", strtotime($data["tgl_registrasi"]));?></td>
            <td><?php echo $data["nama"];?></td>
            <td align="center"><?php echo $data["no_rekam_medis"];?></td>
            <td><?php echo $data["alamat"];?></td>
            <td align="center"><?php echo $data["umur"];?></td>
            <td align="center"><?php echo $data["jenis_kelamin"];?></td>
           <!-- <td><?php echo $data["pendidikan"];?></td>
            <td><?php echo $data["pekerjaan"];?></td>
            <td><?php echo $data["riwayat_rehab"];?>
            -->
            <td><?php echo $data["status"];?></td>
            </td>
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