<!--
<section class="main-banner text-center-xs">
    <div class="container text-lite-color" style="background-image:url('assets/images/banner.jpg'); height:100%">
        <h2 class="text-medium">Blog Single Page</h2>
    </div>
</section>
-->

<script type="text/javascript" src="assets/js/maskF/my.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>

<link rel="stylesheet" href="assets/css/rrss.css">
<script src="assets/js/jquery-rrss.js"></script>

<style>
.leaflet-top,
.leaflet-bottom {
	z-index: 499;
}
h4.heading{
	font-size:16px;
	font-weight:bold;
	background-color:#E5E5E5;
	padding:10px;
}
p{
	font-size:14px;
}
.keterlibatan{
	font-size:14px;
}
.mailbox-attachment-info{
	font-size:13px;
}
.mailbox-attachments{
	list-style:none;
}
.table_title{
	font-weight:bold;
}
#narasi{
	text-indent:50px;
}
</style>

<style>
.green{color:#00A65A}
.yellow{color:#F39C12}
.mailbox-messages > .table {
    margin: 0;
}
.mailbox-controls {
    padding: 5px;
}
.mailbox-controls.with-border {
    border-bottom: 1px solid #f4f4f4;
}
.mailbox-read-info {
    border-bottom: 1px solid #f4f4f4;
    padding: 10px;
}
.mailbox-read-info h3 {
    font-size: 20px;
    margin: 0;
}
.mailbox-read-info h5 {
    margin: 0;
    padding: 5px 0 0;
}
.mailbox-read-time {
    color: #999;
    font-size: 13px;
}
.mailbox-read-message {
    padding: 10px;
}
.mailbox-attachments li {
    border: 1px solid #eee;
    float: left;
    margin-bottom: 10px;
    margin-right: 10px;
    width: 200px;
}
.mailbox-attachment-name {
    color: #666;
    font-weight: bold;
}
.mailbox-attachment-icon, .mailbox-attachment-info, .mailbox-attachment-size {
    display: block;
}
.mailbox-attachment-info {
    background: #f4f4f4 none repeat scroll 0 0;
    padding: 10px;
}
.mailbox-attachment-size {
    color: #999;
    font-size: 12px;
}
.mailbox-attachment-icon {
    color: #666;
    font-size: 65px;
    padding: 20px 10px;
    text-align: center;
}
.mailbox-attachment-icon.has-img {
    padding: 0;
}
.mailbox-attachment-icon.has-img > img {
    height: auto;
    max-width: 100%;
}
</style>

<?php
	$lookup_status_konflik["BD"]="Belum Ditangani";
	$lookup_status_konflik["PS"]="Dalam Proses";
	$lookup_status_konflik["SL"]="Selesai";
	
	$arr_tahapan	=	m_lookup("tahapan","kode","uraian");
?>
<!--header-->
<div class="well well-sm sub-head" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-6">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>DATA DETIL WILAYAH KELOLA</strong></h6>
                    </div>
					
                </div>
            </div>
        </div>
    </div>
</div>
<!--end header-->
<div class="main-container container">
    <div class="row">
    	<div class="col-sm-12 col-xs-12">
            <div class="content">
                <div class="row">
                  <!--<div class="container text-center-xs">
                    <ol class="breadcrumb flat">
                      <li><a href="home">Beranda</a></li>
                      <li><a href="<?=$this->module?>list_data">List Data</a></li>
                      <li class="active">Detail</li>
                    </ol>
                  </div>-->
                  <div class="col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-sm-6">
								<div class="text-uppercase block-2">
									<h6 style=" border:none !important; margin-top:10px" class="sub-heading-1 text-center-xs text-spl-color"><strong><?=$data['nama_wikera']?></strong></h6>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="pull-right">
									<? modules::load('filler/filler')->social_share('Tanah Kita - Detail Konflik : '.$data['judul']);?>
								</div>
							</div>
						</div>
						
						<div class="media ">
							<div class="row">
                    <div class="col-md-6">
						<div class="row">
						<div class="col-md-12">
							<p style="opacity: 0.6;background-color:red;width:50%"><b style="color:black">&nbsp;<?=strtoupper($prop)?>, <?=strtoupper($kab)?></b></p>
								
						</div>
						</div>
						<div class="row">
                      		<div class="col-md-12">
								
								
                            	<!--<div id="map" style="height:255px;"></div>-->
								<?=$this->load->view("map/v_view_spasial");?>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group"><br>
											
											<textarea id="text" class="hiddenx form-control hidden"><?=$data['geo']?></textarea>
										</div>
									</div>
									
								</div>
                        	</div>
                        </div><!-- end row -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-6 table-responsive">
                    	<br />
						<table class="table table-condensed" style="font-size:13px;">
							<tr>
								<td class="table_title" width="200">Tanggal Input</td>
								<td>:</td>
								<td>&nbsp;<?=date_format(date_create($data['tgl_kejadian']),"d-m-Y")?></td>
							</tr>
							<tr>
								<td class="table_title">Nama Wilayah Kelola</td>
								<td>:</td>
								<td>&nbsp;<?=$data['nama_wikera']?></td>
							</tr>
							<tr>
								<td class="table_title">Jenis Wilayah Kelola</td>
								<td>:</td>
								<td>&nbsp;<?=$this->lookup_map_group[$data["kode_jns_wikera"]]?></td>
							</tr>
							<tr>
								<td class="table_title">Tahapan</td>
								<td>:</td>
								<td>&nbsp;<?=$arr_tahapan[$data["kode_tahapan"]]?></td>
							</tr>
							
							<?php
								$exp_luas	=	explode(".",$data["luas"]);
								$luas		=	number_format($exp_luas[0]);
							?>
							
							<tr>
								<td class="table_title">Luas&nbsp;</td>
								<td>:</td>
								<td>&nbsp;<?php echo str_replace(",",".",$luas); ?>,<?php echo ($exp_luas[1])?$exp_luas[1]:"00"; ?> Ha</td>
							</tr>
							<tr>
								<td class="table_title">Propinsi</td>
								<td>:</td>
								<td>&nbsp;<?=$prop?></td>
							</tr>
							<tr>
								<td class="table_title">Kabupaten</td>
								<td>:</td>
								<td>&nbsp;<?=$kab?></td>
							</tr>
							<tr>
								<td class="table_title">Kecamatan</td>
								<td>:</td>
								<td>&nbsp;<?=$kec?></td>
							</tr>
							<tr>
								<td class="table_title">Desa</td>
								<td>:</td>
								<td>&nbsp;<?=$data['desa']?></td>
							</tr>
						</table>
                    </div>
                      
					<div class="col-md-12">
						<h4 class="heading">SURAT KEPUTUSAN</h4>
						<div class="row">
							<div class="col-sm-12 table-responsive">
								<?php if(cek_array($perda)): ?>
									<table class="table table-condensed table-bordered">
										<thead>
											<tr>
												<th width="25px">No</th>
												<th>Surat Keputusan</th>
												<th>Lampiran</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($perda as $k=>$v): ?>
												<tr>
													<td><?=($k+1)?></td>
													<td><?=$v['nomor']?> Tentang <?=$v['tentang']?> Tahun <?=$v['tahun']?></td>
													<td align="center">
														<?php if($v['lampiran']): ?>
															<?php
																$dir_file	=	$this->config->item("dir_lampiran_wikera");
																$src_file	=	$dir_file.$v['lampiran'];
															?>
															<a href="<?=$src_file?>" class="btn btn-warning btn-xs" target="_blank">
																<i class="fa fa-cloud-download">&nbsp;</i>Lampiran
															</a>
														<?php endif; ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						
							<div class="col-md-12 col-xs-12">	
								<h4 class="heading">KONTENT</h4>
								<div class="form-group">
									<label for="alamat">Profil</label>
									<p align="justify"><?=$data["clip"]?></p>
								</div>
								<hr /> 
								<div class="form-group">
									<label for="alamat">Deskripsi</label>
									<p align="justify"><?=$data["deskripsi"]?></p>
								</div>
								<hr /> 
								<div class="form-group">
									<label>Sumber</label>
									<p align="justify"><?php echo $data["sumber_data"];?></p>
								</div>
							</div>
							
						</div>
					</div>
					<div class="col-md-12">
						<h4 class="heading">Lampiran</h4>
						<div class="row">
							<div class="col-sm-12">
								<!--</?=pre($file)?>-->
								<?php if(cek_array($file)): ?>
									<ul class="mailbox-attachments clearfix">
										<?php foreach($file as $kf=>$vf): ?>
											<?php
												if($vf['is_image']):
													$icon		=	"fa-file-image-o";
												else:
													if($vf['file_ext']==".pdf"):
														$icon	=	"fa-file-pdf-o";
													elseif($vf['file_ext']==".docx" or $vf['file_ext']==".doc"):
														$icon	=	"fa-file-word-o";
													elseif($vf['file_ext']==".rar" or $vf['file_ext']==".zip"):
														$icon	=	"fa-file-zip-o";
													else:
														$icon	=	"fa-file-o";
													endif;
												endif;
											?>
											<li>
												<?php
													if($vf['lampiran_type']==1):
														$label_type	=	"danger";
														$type_name	=	"Private";
													else:
														$label_type	=	"info";
														$type_name	=	"Public";
													endif;
												?>
												<span class="label label-<?=$label_type?>" style="position:absolute;border-radius:0px;"><?=$type_name?></span>
												<span class="mailbox-attachment-icon"><i class="fa <?=$icon?>"></i></span>

												<div class="mailbox-attachment-info">
													<a href="<?=$vf['file_path']?>" class="mailbox-attachment-name" target="_blank" title="<?=$vf['lampiran_name']?>">
														<i class="fa fa-paperclip"></i>
														<?php
															if(strlen($vf['lampiran_name'])>20):
																echo substr($vf['lampiran_name'],0,20)."...";
															else:
																echo $vf['lampiran_name'];
															endif;
														?>
													</a>
													<span class="mailbox-attachment-size">
														<?=$vf['file_size']?> KB
														<a href="<?=$vf['file_path']?>" class="btn btn-default btn-xs pull-right" target="_blank"><i class="fa fa-cloud-download"></i></a>
													</span>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php else: ?>
									<table class="table">
										<tr>
											<td align="center"><i><strong>--Tidak Ada Lampiran--</strong></i></td>
										</tr>
									</table>
								<?php endif; ?>
							</div>
						</div>
					</div>
                </div>
							
							
						</div>
                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var form = '#fdata_update';
var oload = false;
$(document).ready(function(){
	init();
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  if($(this).parent().index()==1 && !oload) {
	  	
		oload=true;
	  }
	})
});
function refreshMap(act) { 
	$("#map_container").attr("src", "wikera/data/spasial_view/YTJr");
	if (act) {
		$(".submitter").removeClass("hide");
		$("#submitter1").addClass("hide");
		$("#lampiran_peta").val("");

		$(".fdata_").addClass('hide');
		form = act;
		$(form).removeClass('hide');
	}
	//$("#map_container").contentWindow.location.reload(true);
}
</script>
 <script>
function readText(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
		   var text = reader.result;
		   $('#text').val(text);
		   deserialize(text);
		}
		reader.readAsText(input.files[0]);
	}
}   
$("#imgInpPlay").change(function(){
	readText(this);
});
</script>  
<script>
$(document).ready(function(){
	
	var teks=$('#text').val();
	if(teks !=''){
		deserialize(teks);
	}

});
</script>
