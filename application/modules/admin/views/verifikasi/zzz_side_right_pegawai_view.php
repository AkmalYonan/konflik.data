<?php
// debug();
$arr=$this->conn->GetAll("SELECT * FROM m_jenis_berkas ORDER BY id");
foreach($arr as $k => $v):
	$arrD[$v['kode']] = $v['nm_berkas'];
endforeach;
$lookup_berkas=$arrD;
?>
<?
if ($_GET['I'] || $_GET['skpa'] || $_GET['q']) {
	$class_toggle=" active";
	$class_content="";
}
else {
	$class_toggle="";
	$class_content="none";
}
?>
<script>
$(document).ready(function(){
	document.getElementById("file_upload").onchange = function() {
		document.getElementById("form").submit();
	}
});	
</script>
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>Verifikasi <small>Pegawai</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active">Verifikasi pegawai</li>
         </ul>
        <!-- end: breadcrumbs -->

	</div> 
	
	<div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<div class="box" style="padding-top:10px;">
			<div class="col-md-12">
				<div class="row topbar box_shadow">
					<div class="col-md-12">
						<div class="rows well well-sm">
							<div style="vertical-align:middle;line-height:25px">
							<a class="btn btn-default" href="<?php echo $this->module?>">
								<i class="fa fa-list"></i> List
							</a>
							<a class="btn btn-default active" href="<?php echo $this->module?>view/<?=$this->uri->segment(4);?>/<?=$this->uri->segment(5);?>">
								<i class="fa  fa-table"></i> View
							</a>	 
							<a class="btn btn-default" href="<?php echo $this->module?>view/<?=$this->uri->segment(4);?>/<?=$this->uri->segment(5);?>">
								<i class="fa fa-refresh"></i> Refresh
							</a>							
							<!--<div class="pull-right">
							<a class="btn btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?=$this->module?>del/<?=$this->uri->segment(4);?>">	
								<i class="fa fa-trash"></i> Hapus
							</a>
							</div>	-->
							</div>
						</div>
					</div>
				</div><!-- ./box-body -->
			</div>
			<!-- form start -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<?php echo message_box();?>  
						</div>
						
						<!--<div class="col-md-12">							  
						    <div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
								  <li class="active"><a aria-expanded="false" href="#tab_1" data-toggle="tab">Tab 1</a></li>
								  <li class=""><a aria-expanded="true" href="#tab_2" data-toggle="tab">Tab 2</a></li>							  
								</ul>
							<div class="tab-content">
							    <div class="tab-pane active" id="tab_1">
									<b>How to use:</b>
									<p>Exactly like the original bootstrap tabs except you should use
									  the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
									A wonderful serenity has taken possession of my entire soul,
									like these sweet mornings of spring which I enjoy with my whole heart.
									I am alone, and feel the charm of existence in this spot,
									which was created for the bliss of souls like mine. I am so happy,
									my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
									that I neglect my talents. I should be incapable of drawing a single stroke
									at the present moment; and yet I feel that I never was a greater artist than now.
							    </div>
							    <div class="tab-pane" id="tab_2">
								The European languages are members of the same family. Their separate existence is a myth.
								For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
								in their grammar, their pronunciation and their most common words. Everyone realizes why a
								new common language would be desirable: one could refuse to pay expensive translators. To
								achieve this, it would be necessary to have uniform grammar, pronunciation and more common
								words. If several languages coalesce, the grammar of the resulting language is more simple
								and regular than that of the individual languages.
							    </div>
							</div>
						    </div>
						</div>-->
						
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<h4 style="border-bottom:2px solid #aaa;font-weight:bold;">Profil Pegawai</h4>	
									<div class="">
										<table border="0" cellpadding="5" cellspacing="20" width="100%">
										<tbody>
										
										<tr>
											<td>Nama Lengkap</td>
											<td class="tb-val"><?=$data['nama'];?></td>
										</tr>
										<tr>
											<td>Tanggal lahir</td>
											<td class="tb-val"><?=format_tanggal_db3($data['tanggal_lahir'])?></td>
										</tr>
										<tr>
											<td>Tempat Lahir</td>
											<td class="tb-val"><?=$data['tempat_lahir'];?></td>
										</tr>
										<tr>
											<td>Email address</td>
											<td class="tb-val"><?=$data['email'];?></td>
										</tr>
										<tr>
											<td>Jenis Kelamin</td>
											<td class="tb-val"><?=$data['jenis_kelamin'];?></td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td class="tb-val"><?=$data['alamat'];?></td>
										</tr>
									</tbody></table>
									</div>
								</div>
								<div class="col-md-12">
									<h4 style="border-bottom:2px solid #aaa;font-weight:bold;">Data Pegawai</h4>	
									<div class="">
										<table border="0" cellpadding="2" cellspacing="14" width="100%">
										<tbody>
										<tr>
											<td>Nomor Induk Pegawai</td>
											<td class="tb-val"><?=$data['nip'];?></td>
										</tr>
										<tr>
											<td>Nomor SK. PPNS</td>
											<td class="tb-val"><?=$data['no_sk_ppns'];?></td>
										</tr>
										<tr>
											<td>Masa Berlaku Pegawai</td>
											<td class="tb-val"><?=format_tanggal_db3($data['berlaku_pegawai'])?></td>
										</tr>
										<tr>
											<td>No. KTP</td>
											<td class="tb-val"><?=$data['no_ktp'];?></td>
										</tr>
										<tr>
											<td>Masa Berlaku KTP</td>
											<td class="tb-val"><?=format_tanggal_db3($data['berlaku_ktp'])?></td>
										</tr>
										<tr>
											<td>SKPD</td>
											<td class="tb-val"><?=$data['skpd']?></td>
										</tr>
									</tbody></table>
									</div>
								</div>
								<div class="col-md-12">
									<h4 style="border-bottom:2px solid #aaa;font-weight:bold;">Atribut Pegawai <a class="btn<?=$class_toggle?>" id=""> &nbsp;</a></h4>	
									<div class="">
										<table border="0" cellpadding="2" cellspacing="14" width="100%">
										<tbody>
										<tr>
											<td>Gelar Depan</td>
											<td class="tb-val"><?=$data['gelar_depan'];?></td>
										</tr>
										<tr>
											<td>Gelar Belakang</td>
											<td class="tb-val"><?=$data['gelar_belakang'];?></td>
										</tr>
										<tr>
											<td>Provinsi</td>
											<td class="tb-val">
											<?php 
											$jsonData = file_get_contents($services_prov."?kode_wilayah=00");
											$phpArray = json_decode($jsonData, true);
											foreach($phpArray as $row){
												  $kdprov = $row['kode_dagri'];  
													if($kdprov == $data['propinsi']){
														echo "$row[nama_wilayah]"; 	
													}
												}
											?> 	 
											</td>
										</tr>
										<tr>
											<td>Kabupaten</td>
											<td class="tb-val">
											<?php 
											$jsonData = file_get_contents($services_prov."?kode_dagri=$data[propinsi]");
											$phpArray = json_decode($jsonData, true);
											foreach($phpArray as $rowk):
											  $kdkab = $rowk['kode_dagri'];  
											  if($kdkab == $data['kabupaten']){
												 echo "$rowk[nama_wilayah]";
												} 
											?>
											<?php endforeach;?>  
											</td>
										</tr>
										<tr>
											<td>UU Yang Dikawal</td>
											<td class="tb-val"><?=$data['uu_dikawal'];?></td>
										</tr>
										<tr>
											<td>TMT Pegawai</td>
											<td class="tb-val"><?=format_tanggal_db3($data['tmt_pegawai_masuk'])?></td>
										</tr>
										<tr>
											<td>Status</td>
											<td class="tb-val"><?=$data['status_pegawai'];?></td>
										</tr>
										<tr>
											<td>Pangkat/Golongan</td>
											<td class="tb-val">
											<?php foreach($query_gol as $rowG):
												  $ket = $rowG['keterangan'];  
												  if($ket == $data['pangkat']){
													echo "$rowG[keterangan]";
													}  
											?>
											<?php endforeach;?> 
											</td>
										</tr>
										<tr>
											<td>SK. Pangkat/Golongan</td>
											<td class="tb-val"><?=$data['no_sk_pangkat'];?></td>
										</tr>
										<tr>
											<td>Pendidikan terakhir</td>
											<td class="tb-val"><?=$data['pendidikan_terakhir'];?></td>
										</tr>
										<tr>
											<td>Keterangan lain</td>
											<td class="tb-val"><?=$data['keterangan'];?></td>
										</tr>
									</tbody></table>
									</div>
								</div>
							</div>						
						</div>		
						<div class="col-md-6">
							<div class="row">

								<div class="col-md-12">
									<h4 style="margin-top:-5px;border-bottom:2px solid #aaa;font-weight:bold;">Data Pendukung <a class="btn<?=$class_toggle?>" id="filter_toggle"><i class="fa fa-plus bc-icon"></i> Tambah</a>
									<div style="float:right" >
										<?php if($data['status'] == 1){?>
										<a title="Verified/Not Verified" href="<?php echo site_url("admin/pegawai/publish/".encrypt($data['idx'])."/".encrypt($data['status']));?>">													
										<center>
											<span class="label label-info">Verified <i class="fa fa-check"></i></span>
										</center>
										</a>
										<?php }elseif($data['status'] == 0){?>
										<a title="Verified/Not Verified" href="<?php echo site_url("admin/pegawai/publish/".encrypt($data['idx'])."/".encrypt($data['status']));?>">																						
										<center>
											<span class="label label-danger">Not Verified </span>
										</center>
										<?php } ?>
										</a>
									</div>
								</h4>
								<script>
								$(document).ready(function(){
								  $(".menu1").click(function(){
									$("#target").show();
									$(".menu1").hide();
									$(".menu2").show();
								  });
								  $(".menu2").click(function(){
									$("#target").hide();
									 $(".menu2").hide();
									$(".menu1").show();
								  });
								});
								</script>
											
									
								<button class="menu1 btn btn-xs" style="display: none;"><i class="fa fa-plus"></i>&nbsp;&nbsp; <b>Verifikasi PUM</b></button>
								<button style="display: inline-block;" class="menu2 btn btn-xs"><i class="fa fa-minus"></i>&nbsp;&nbsp; <b>Verifikasi PUM</b></button>
								<!--<div class="row topbar box_shadow">
									<div class="col-md-12">
										<div class="rows well well-sm">
											<div style="vertical-align:middle;line-height:15px">
											<span style="font-size:10px;" class="help-block">
											<table>
												<tr>
													<td colspan='2'>BERKAS VERIFIKASI PUM:</td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;1.</td>
													<td> DP3 (2THN TERAKHIR) <i class="fa fa-check"></i></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;2.</td>
													<td> SK Terakhir <i class="fa fa-check"></i></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;3.</td>
													<td> Pas Foto 2x3 <i class="fa fa-check"></i></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;4.</td>
													<td> Ijazah Terakhir <i class="fa fa-check"></i></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;5.</td>
													<td> Surat Keterangan Dokter <i class="fa fa-check"></i></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;6.</td>
													<td> KTP <i class="fa fa-check"></i></td>
												</tr>
											</table>
											</span>
											</div>
										</div>
									</div>
								</div>-->	
								<div class="row" >
									<div class="col-md-12" >
										<div id='target'>
									
										<?php
										$attributes = array('role' => 'form','id' => 'form');
										echo form_open_multipart('admin/verifikasi/insert_dokumen', $attributes);
										$data = array(
												  'idx'  => $data['idx'],
												  'nip' => $data['nip'],
												  'fg' => $this->uri->segment(5)
												);
										echo form_hidden($data);
										?>
										<div class="transparent" style="padding-bottom:0px; margin-top:2px">
											<div id="filter_content" class="box-contents" style="padding-bottom:0px; background:white; display:<?=$class_content?>">
												<table class="table table-condensed small-font" style="margin-top:;">
												<thead style="background:">
													<tr>
														<th>Nama File</th>
														<th>File</th>
														
													</tr>
													 <tr>
														<!--<td><input type="text" id="nm_file" required name="nm_file" class="span12 " /></td>-->
														<td>
															<?=form_dropdown("nm_file",$lookup_berkas,"","id='adds'  class='form-control'");?>
														</td>
														<td><input type="file" id="file_upload" name="file_name" class="span12 " /></td>
													</tr>
												</thead>
												</table>
											</div>
										</div>
										</form>
											<table class="table">
												<tr>
													
													<th></th>
													<th>Nama File</th>
													<!--<th><center>Verified/Not Verified?</center></th>-->
												</tr>
												<?php if(count($data_berkas) > 0){?>
													<?php foreach($data_berkas as $row){
													// $fl = getDataURI("uploads/berkas_ppns/$row[dokumen]");
													?>
												<tr>
													
													<td>
														<a href="uploads/berkas_ppns/<?php echo $row['dokumen'];?>" title="Download"><i class="fa fa-download"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
														<a onclick="return confirm('Berkas akan dihapus?');" title="Delete" href="<?= base_url();?>admin/pegawai/delete_berkas/<?php echo encrypt($row['idx']);?>"><i class="fa fa-trash"></i></a>
																											
													</td>
													<td>
														<? foreach($m_jns_brks as $rows):
															$kode = $rows['kode'];  
															if($kode == $row['nm_file']){
																echo $rows['nm_berkas'];
															}
														?>
														<? endforeach; ?>
													</td>
													<!--<td><center>
														<input data-id="<?php //echo encrypt($row['idx']);?>" <?//=($row['cek'] == 1 ? 'checked' : false);?> type='checkbox' name='ceklis' class="rad_update<?//=$row['idx'];?>">
														</center>
													</td>-->
												</tr>
												<script type="text/javascript">
												$(function() {
													$(".rad_update<?=$row['idx'];?>").change(function(){
														var element = $(this);
														var del_id = element.attr("data-id");
														var info = 'id=' + del_id;
														// if(confirm("Are you sure you want to delete this?"))
														// {
														 $.ajax({
															type: "POST",
															url: "admin/pegawai/update_cek",
															data: info,
															success: function(){

																				}
															});
														  // $("#filediv<?=$x;?>").animate({ backgroundColor: "#003" }, "slow")
														  // .animate({ opacity: "hide" }, "slow");
														return false;
													});
												});
												</script>
												<?php
													}
												}else{?>
												<tr>
													<td colspan="2">Tidak Ada Data</td>
													
												</tr>	
												<?php	
												}
												?>
										</table>						
									</div>
									</div>
								</div>
								<script>
								$(document).ready(function(){
								  $(".menu1b").click(function(){
									$("#target2").show();
									$(".menu1b").hide();
									$(".menu2b").show();
								  });
								  $(".menu2b").click(function(){
									$("#target2").hide();
									 $(".menu2b").hide();
									$(".menu1b").show();
								  });
								 
								});
								</script>
							
								<button class="menu1b btn btn-xs" style="display:none;"><i class="fa fa-plus"></i>&nbsp;&nbsp; <b>Verifikasi KUMHAM</b></button>
								<button class="menu2b btn btn-xs" ><i class="fa fa-minus" ></i>&nbsp;&nbsp; <b>Verifikasi KUMHAM</b></button>
								<div class="row" >
									<div class="col-md-12" >
										<div id='target2'>
											
											<?php
											$attributes = array('role' => 'form','id' => 'form');
											echo form_open_multipart('admin/verifikasi/insert_dokumen', $attributes);
											$data = array(
													  'idx'  => $data['idx'],
													  'nip' => $data['nip'],
													  'fg' => $this->uri->segment(5)
													);
											echo form_hidden($data);
											?>
											<table class="table table-condensed small-font" style="margin-top:;">
												<thead style="background:">
													<tr>
														<th>Nama File</th>
														<th>File</th>
														
													</tr>
													<tr>
														<td>
															<?=form_dropdown("nm_file",$lookup_berkas,"","id='adds'  class='form-control'");?>
														</td>
														<td><input type="file" id="file_upload" name="file_name" class="span12 " /></td>
													</tr>
												</thead>
											</table>
										
											</form>
											<table class="table">
												<tr>
													
													<th></th>
													<th>Nama File</th>
												</tr>
												<?php if(count($data_berkas) > 0){?>
													<?php foreach($data_berkas as $row){
													// $fl = getDataURI("uploads/berkas_ppns/$row[dokumen]");
													?>
												<tr>
													
													<td>
														<a href="uploads/berkas_ppns/<?php echo $row['dokumen'];?>" title="Download"><i class="fa fa-download"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
														<a onclick="return confirm('Berkas akan dihapus?');" title="Delete" href="<?= base_url();?>admin/pegawai/delete_berkas/<?php echo encrypt($row['idx']);?>"><i class="fa fa-trash"></i></a>
																											
													</td>
													<td>
														<? foreach($m_jns_brks as $rows):
															$kode = $rows['kode'];  
															if($kode == $row['nm_file']){
																echo $rows['nm_berkas'];
															}
														?>
														<? endforeach; ?>
													</td>
												</tr>
												<?php
													}
												}else{?>
												<tr>
													<td colspan="2">Tidak Ada Data</td>
													
												</tr>	
												<?php	
												}
												?>
											</table>						
										</div>				
									</div>
								</div>	
								
								
								</div>
							</div>							
						</div>
					</div>	
				</div><!-- /.box-body -->
		
		  </div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->	
</div><!-- end div positioning -->
<?=loadFunction("select2");?>
<script>
	$(function(){
		$("#add").select2({
		placeholder:"-Pilih Berkas-"
		});	
	});		
</script>
<script>  
    $(document).ready(function () {
		$("#filter_toggle").click(function(){
			$(this).toggleClass("active");
			$("#filter_content").slideToggle();
		});
    })
</script>
<script language="javascript">
$(document).ready(function(){      
$('#prov').change(function(){
    $.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
    $('#kab').html(obj);
    });
    });

});
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '300px');
                //$('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>

