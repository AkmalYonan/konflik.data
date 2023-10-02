<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
?>
<?php
	$arr_jns_wikera	=	lookup("m_jenis","kode","uraian","status='1'"," order by idx");
	$arr_tahapan	=	lookup("m_tahapan","kode","uraian","status='1'"," order by idx");
	$arr_kawasan	=	lookup("m_kawasan","kode","uraian",""," order by idx");
	$arr_subject	=	array(1=>"Penerima",2=>"Individu",3=>"Kelompok");
?>

<script type="text/javascript" src="assets/js/maskF/my.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>
<!--<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.openstreetmap.js"></script>-->

<style>
.leaflet-top,
.leaflet-bottom {
	z-index: 499;
}
.table_title{
	font-weight:bold;
}
#deskripsi{
	text-indent:50px;
}
.t_title{
	font-weight:bold;
}
</style>

<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small>Detil Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i><a href="<?php echo $this->module?>"><?=$this->parent_module_title?></a></li>
    <li class="active"><?=$this->module_title?></li>
  </ol>
</section>

<section class="content">
<div class="row">
	<div class="col-md-12">
	<div class="box box-default">
    	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
		<div class="box-header with-border clearfix">
			<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
				<i class="fa fa-list"></i>
			</a>
			<a class="btn btn-white" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
				<i class="fa fa-refresh"></i>
			</a>	  
		</div>
		
		<div class="box-body">
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

						<?php//echo form_input('longitude',$data["longitude"],'id="x" data-x="'.$data["longitude"].'" class="form-control hidden required"');?>
						<?php//echo form_input('latitude',$data["latitude"],'id="y" data-y="'.$data["latitude"].'" class="form-control hidden required"');?>

                    
                    	<div class="row">
							<div class="col-md-12">
								<p align="justify"><b>Profil :</b> <?=$data["clip"]?></p>
							</div>
							<div class="col-md-12">
								<p align="justify"><b>Status Validasi Peta :</b> <?=($data["status_validas_peta"]==1)?"Valid":"Tidak Valid"?></p>
							</div>
							

						</div>
						<div class="row">
							<div class="col-md-6">
									
							</div>
						</div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6 table-responsive">
                    	<br />
						<table class="table table-condensed" style="margin-top:-10px;">
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
							<!--
							<tr>
								<td class="table_title">Subject</td>
								<td>:</td>
								<td>&nbsp;</?=$arr_kawasan[$data['subject']]?></td>
							</tr>
							<tr>
								<td class="table_title">Object</td>
								<td>:</td>
								<td>&nbsp;</?=$data['kawasan']?></td>
							</tr>
							-->
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
							<div class="col-md-6 col-xs-12">	
								<h4 class="heading">KONTENT</h4>
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
							
							<div class="col-md-6 col-xs-12">
								<h4 class="heading">Data Mitra/Pendamping</h4>
								<div class="data_table table-responsive">
									<table class="table">
										<tr>
											<td class="t_title" width="">Nama Mitra</td>
											<td><?=$mitra['nama']?></td>
										</tr>
										<tr>
											<td class="t_title" width="">Email</td>
											<td><?=$mitra['email']?></td>
										</tr>
										<tr>
											<td class="t_title" width="">No Telepon</td>
											<td><?=$mitra['no_telepon']?></td>
										</tr>
										<tr>
											<td class="t_title" width="">Alamat</td>
											<td><?=$mitra['alamat']?></td>
										</tr>
									</table>
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





</section>


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
	
	$(".edit_file").on("click",function(){
		
		var	id	=	$(this).data("idx");
		var	url	=	"<?=$this->module?>data_lampiran";
		
		$.ajax({
			
				url		:	url,
				type	:	"POST",
				dataType:	"JSON",
				data	:	{id:id},
				success	:	function(result){
					
					var id_lampiran		=	result.id;
					var nama_lampiran	=	result.lampiran_name;
					var tipe_lampiran	=	result.lampiran_type;
					
					$("#id_lampiran").val(id_lampiran);
					$("#ubah_nama_lampiran").val(nama_lampiran);
					$("#ubah_tipe_lampiran").val(tipe_lampiran);
					
					$("#myModal").modal("show");
				}
		
		});
	});
	
	$(".ubah_data_submit").on("click",function(){
		
		var	id				=	$("#id_lampiran").val();
		var	lampiran_name	=	$("#ubah_nama_lampiran").val();
		var	lampiran_type	=	$("#ubah_tipe_lampiran").val();
		
		var	url				=	"<?=$this->module?>ubah_lampiran";
		
		$.ajax({
			
				url		:	url,
				type	:	"POST",
				dataType:	"JSON",
				data	:	{id:id,lampiran_name:lampiran_name,lampiran_type:lampiran_type},
				success	:	function(result){
					
					if(result){
						
						var lampiran_type_text;
						
						if(lampiran_type==1){
							lampiran_type_text	=	"Private";
						}else{
							lampiran_type_text	=	"Public";
						}
						
						$("#nama_"+id).text(lampiran_name);
						$("#tipe_"+id).text(lampiran_type_text);
						
						$("#myModal").modal("hide");
						new PNotify({
                            title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                            text    :   'Ubah Lampiran Berhasil',
                            type	:	'success',
                            hide    :   true
                        });
                        
					}else{
						
						$("#myModal").modal("hide");
						new PNotify({
                            title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                            text    :   'Ubah Lampiran Gagal',
                            hide    :   true
                        });
                        
					}
				}
		
		});
		
	});
});
</script>
