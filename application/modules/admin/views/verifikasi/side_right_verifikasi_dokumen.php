<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="right-side">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Verifikasi Berkas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Verifikasi Berkas</li>
			</ol>
		</section>
		
		<!-- Main content -->
		<section class="content">
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-12"> 
					<!-- Box (with bar chart) -->
					<div class="box box-primary" id="loading-example">
						<div class="box-header" style="padding:10px 30px">
							<!-- tools box -->
							<div class="pull-right box-tools">
								<a href=""
								class="btn btn-primary btn-sm refresh-btn" data-toggle="tooltip" title="Muat Ulang">
								<i class="fa fa-refresh"></i></a>
							</div><!-- /. tools -->
								<?php
								if($this->uri->segment(4) == 'a'){
									$title = 'PUM';
								}elseif($this->uri->segment(4) == 'b'){
									$title = 'KUMHAM';
								}elseif($this->uri->segment(4) == 'c'){
									$title = 'Lulus Diklat';
								}elseif($this->uri->segment(4) == 'd'){
									$title = 'Rekomendasi POLRI';
								}elseif($this->uri->segment(4) == 'e'){
									$title = 'Rekomendasi KEJAGUNG';
								}elseif($this->uri->segment(4) == 'f'){
									$title = 'SKEP/KTP Dari KUMHAM';
								}elseif($this->uri->segment(4) == 'g'){
									$title = 'Pelantikan';
								}
								?>
								<h4 >Update Verifikasi Berkas <?=$title;?></h4>
								<hr style="clear:both"/>	
								
							<div class="box-body table-responsive">	
							<div class="box-header">
							<?php if ($this->session->flashdata('error')){ ?>
							<div class="box-body">
								<div class="alert alert-danger alert-dismissable">
									<i class="fa fa-ban"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<b>Alert!</b> <?php echo $this->session->flashdata('error'); ?>
								</div>
							</div><!-- /.box-body -->
							<?php }elseif($this->session->flashdata('success')){ ?>
							<div class="box-body">
								<div class="alert alert-success alert-dismissable">
									<i class="fa fa-check"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<b>Alert!</b> <?php echo $this->session->flashdata('success'); ?>
								</div>
							</div><!-- /.box-body -->
							<?php } ?>
							</div>
								<div class="box-body">
									<div class="row">
										<div class="col-xs-6">
											<div class="row">
												<div class="col-xs-12">
													<label>Nama Lengkap</label>
													<input type="text" id="nama" name="nama" class="form-control" disabled value="<?=$nama;?>"/>
												</div>
											</div><br/>	
											
											<div class="row">
												<div class="col-xs-6">
													<label>Tanggal lahir</label>
													<input type="text" id="datepicker2" name="tanggal_lahir_selector" class="form-control" disabled value="<?=$tanggal_lahir_selector;?>"/>
												</div>
											
												<div class="col-xs-6">
													<label>Status</label>
													<input type="text" id="status_pegawai" name="status_pegawai" class="form-control" disabled value="<?=strtoupper($status_pegawai);?>"/>
												</div>
											</div><br/>
											
											<div class="row">
												<div class="col-xs-12">
													<label>Nomor Induk Pegawai</label>
													<input type="text" name="nip" class="form-control" disabled value="<?=$nip;?>" />
												</div>
											</div><br/>
											<div class="row">
												<div class="col-xs-6">
													<label>Provinsi</label>
													<input type="text" name="sk_ppns" class="form-control" disabled value="<?php $jsonData = services_prov();
												$phpArray = json_decode($jsonData, true);
												foreach ($phpArray as $key => $value) {
													$a = $value['kode_dagri'];
													$b = $value['nama_wilayah'];
													if($a == $provinsi){
														echo $b;  
													}
												}
											?>"/>
												</div>
										
												<div class="col-xs-6">
													<label>Kabupaten</label>
													<input type="text" name="sk_ppns" class="form-control" disabled value="<?php 
																	  if(!empty($kabupaten)){
																		$jsonData2 = services_kab2($kabupaten);
																		$phpArray2 = json_decode($jsonData2, true);
																		foreach ($phpArray2 as $key2 => $value2) {
																			$a2 = $value2['kode_dagri'];
																			$b2 = $value2['nama_wilayah'];
																			if($a2 == $kabupaten){
																				echo $b2;  
																			}
																		}
																	  }else{echo "-";}
																?>" />
												</div>
											</div><br/>
											
											
										</div>
										
										<div class="col-xs-6">
											<div style="position: relative;" id="imgcontainer">
												<label>Foto <span class="help-block" style="display:inline"></span></label>
												<div id="preview" style="width:200px; height:200px;" class="img-polaroid">
													<?php if (!empty($foto)){?>
														<img src="<?= base_url()?>assets/uploads/sppp_data_pegawai/<?php echo $id_pegawai;?>/<?php echo $foto;?>" id="previewplay" width="300px" />
													
													<!--<a href="<?= base_url()?>pegawai/delete_image/<?php //echo $this->uri->segment(3, 0);?>" title="Hapus">
													<div class="file_span file_red">&nbsp;x&nbsp;</div>
													</a>-->
													<?php }else{ ?>
														<img src="<?= base_url();?>assets/images/avatar5.png" id="previewplay" width="98%">
													<?php } ?>
												</div>
												<!--[ <a style="position: relative; z-index: 1;" href="" id="pickfiles">Browse</a> ]-->
												<div id="image_data" style="display:none">
												</div>
											</div>
										</div>
										<?php if($this->uri->segment(4) == 'f'){?>
										<div class="row">
											<div class="col-xs-9">
											<a target="_blank" href="<?=base_url();?>pegawai/edit/<?=$this->uri->segment(3,0);?>"><button type="submit" name="save" class="btn btn-primary" style="float:left;margin-left:15px">Edit Data Pegawai</button></a>
											</div>
										</div>
										<?php } ?>
									</div>								
									</div>										
									<br/>
									<hr />
											<style>
												table.tb_berkas{background:#f4f4f4;margin-bottom:30px;}
												table.tb_berkas tr th{padding:5px 10px;background:#7a714f;color:white;font-weight:bold; }
												table.tb_berkas tr td{padding:5px 10px; }
												div.upload {
												width: 20px;
												height: 20px;
												overflow: hidden;
												cursor:pointer;
												}
												div.upload input[type="file"]
													{opacity: 0.0;
													position:absolute;
													filter: alpha(opacity=40); /* For IE8 and earlier */}
											</style>
											<!-- 1 -->
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
											
											<div class="row">
											<div class="col-xs-9" >
												<button class="menu1 btn btn-xs" style="display:none"><i class="fa fa-plus"></i>&nbsp;&nbsp; <b>Verifikasi PUM</b></button>
												<button class="menu2 btn btn-xs" ><i class="fa fa-minus" ></i>&nbsp;&nbsp; <b>Verifikasi PUM</b></button>
												
												
												<?php if($flag == 'a' || $flag == 'b' || $flag == 'c' || $flag == 'd' || $flag == 'e' || $flag == 'f' || $flag == 'g'){?>
												<table width="100%" id="target" border="0" class="tb_berkas" style="margin:20px 0px 0px 0px;">
													<tr>
														<th>Nama Berkas</th>
														<th style="width:80px;"><center>Status</center></th>
														<th colspan="4" style="width:50px;"><?php if($flag == 'a'){?><center>Aksi</center><?php } ?></th>	
													</tr>
													<tr>
														<td>DP3 (2THN TERAKHIR)</td>	
														<?php 
															if($countSTTb1->RecordCount() != ''){
																foreach($countSTTb1 as $cnt1){?>
																<td align="center" class='text-success'>
																	<center><i style="color:green;" class='fa fa-check' title='Sudah'></i></center>
															<?php } }else{
																echo "<td class='text-danger'>
																		<center><i class='fa fa-times' title='Belum'></i></center>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php 
														if($countSTTb1->RecordCount() != ''){
															foreach($countSTTb1 as $cnt){	
																 
														?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $cnt1['id'];?>/<?php echo $cnt1['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download : <?php echo $cnt1['dokumen'];?>'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'a'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file11").onchange = function() {
																		document.getElementById("form11").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form11','id' => 'form11');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => 'b1'
																		);
																echo form_hidden($data);
																?>
																
																<!--<div class="upload" title="Input/Update">-->
																	<input type='file' name='file_name' id='file11'>
																	<!--<i class='fa  fa-pencil' style="color:green" ></i>
																</div>-->

																
																</form>
																<?php } ?>
														</td>		
														<td>		
														<?php if($flag == 'a'){?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $cnt['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>
														<?php } 
															} 
														}else{
															if($flag == 'a'){ 
																echo "
																<a ><i class='text-muted fa fa-fw fa-download' title='File Kosong'></i></a>
																";
															}
														}
														?>
														</td>
														<td>
														<?php
														if($countSTTb1->RecordCount() == ''){?>
														<script>
														$(document).ready(function(){
															document.getElementById("file1").onchange = function() {
																document.getElementById("form1").submit();
															}
															
														});
														</script>
														<?php
														$attributes = array('role' => 'form1','id' => 'form1');
														echo form_open_multipart('verifikasi/insert_dokumen', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => 'b1'
																);
														echo form_hidden($data);
														?>
															<!--<div class="upload">-->
																<input type='file' name='file_name' id='file1'>
																<!--<i class='fa  fa-pencil' style="color:green" title='File Kosong'></i>
															</div>-->
														</form>
														</td>
														<td>
															<i class='fa fa-times-circle text-muted' title=''></i>
														</td>
														<?php } ?>
														
													</tr>
													<tr>
														<td>SK Terakhir</td>
														<?php 
															if($countSTTb2->RecordCount() != ''){
																foreach($countSTTb2 as $cnt1){?>
																<td class='text-success'>
																	<center><i style="color:green;" class='fa fa-check' title='Sudah'></i>
																	</center>
															<?php } 
															}else{
																echo "<td class='text-danger'>
																		<center><i class='fa fa-times' title='Belum'></i></center>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php 
														if($countSTTb2->RecordCount() != ''){
															foreach($countSTTb2 as $cnt){	
																
														?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $cnt['id'];?>/<?php echo $cnt['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download : <?php echo $cnt['dokumen'];?>'></i>
																</a>
														</td>
														<td>
																<?php if($flag == 'a'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file22").onchange = function() {
																		document.getElementById("form22").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form22','id' => 'form22');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => 'b2'
																		);
																echo form_hidden($data);
																?>
																<!--<div class="upload" title="Input/Update">-->
																	<input type='file' name='file_name' id='file22'>
																	<!--<i class='fa  fa-pencil' style="color:green" ></i>
																</div>-->
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'a'){?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $cnt['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>
														<?php } 
															} 
														}else{
															if($flag == 'a'){ 
															echo "
															<a ><i class='text-muted fa fa-fw fa-download' title='File Kosong'></i></a>
															";
															}
														}
														?>
														</td>
														<td>
														<?php
														if($countSTTb2->RecordCount() == ''){?>
														<script>
														$(document).ready(function(){
															document.getElementById("file2").onchange = function() {
																document.getElementById("form2").submit();
															}
															
														});
														</script>
														<?php
														$attributes = array('role' => 'form2','id' => 'form2');
														echo form_open_multipart('verifikasi/insert_dokumen', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => 'b2'
																);
														echo form_hidden($data);
														?>
														<!--<div class="upload">-->
																<input type='file' name='file_name' id='file2'>
																<!--<i class='fa  fa-pencil' style="color:green" title='File Kosong'></i>
															</div>-->
														</form>
														</td>
														<td>
															<i class='fa fa-times-circle text-muted' title=''></i>
														</td>
														<?php } ?>
														
													</tr>
													<tr>
														<td>Pas Foto 2x3</td>
														<?php 
															if($countSTTb3->RecordCount() != ''){
																foreach($countSTTb3 as $cnt1){?>
																<td class='text-success'>
																	<center><i style="color:green;" class='fa fa-check' title='Sudah'></i>
																	</center>
															<?php } }else{
																echo "<td class='text-danger'>
																		<center><i class='fa fa-times' title='Belum'></i></center>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php 
														if($countSTTb3->RecordCount() != ''){
															foreach($countSTTb3 as $cnt){
																
														?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $cnt['id'];?>/<?php echo $cnt['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download : <?php echo $cnt['dokumen'];?>'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'a'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file33").onchange = function() {
																		document.getElementById("form33").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form33','id' => 'form33');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => 'b3'
																		);
																echo form_hidden($data);
																?>
																
																<!--<div class="upload" title="Input/Update">-->
																	<input type='file' name='file_name' id='file33'>
																	<!--<i class='fa  fa-pencil' style="color:green" ></i>
																</div>-->
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'a'){?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $cnt['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>
														<?php } 
															} 
														}else{
															if($flag == 'a'){ 
															echo "
															<a ><i class='text-muted fa fa-fw fa-download' title='File Kosong'></i></a>
															";
															}
														}
														?>
														</td>
														<td>
														<?php
														if($countSTTb3->RecordCount() == ''){?>
														<script>
														$(document).ready(function(){
															document.getElementById("file3").onchange = function() {
																document.getElementById("form3").submit();
															}
															
														});
														</script>
														<?php
														$attributes = array('role' => 'form3','id' => 'form3');
														echo form_open_multipart('verifikasi/insert_dokumen', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => 'b3'
																);
														echo form_hidden($data);
														?>
														<!--<div class="upload">-->
																<input type='file' name='file_name' id='file3'>
																<!--<i class='fa  fa-pencil' style="color:green" title='File Kosong'></i>
															</div>-->
														</form>
														</td>
														<td>
															<i class='fa fa-times-circle text-muted' title=''></i>
														</td>
														<?php } ?>
														
													</tr>
													<tr>
														<td>Ijazah Terakhir</td>
														<?php 
															if($countSTTb4->RecordCount() != ''){
																foreach($countSTTb4 as $cnt1){?>
																<td class='text-success'>
																	<center><i style="color:green;" class='fa fa-check' title='Sudah'></i>
																	</center>
															<?php } }else{
																echo "<td class='text-danger'>
																		<center><i class='fa fa-times' title='Belum'></i></center>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php 
														if($countSTTb4->RecordCount() != ''){
															foreach($countSTTb4 as $cnt){	
																
														?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $cnt1['id'];?>/<?php echo $cnt1['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download : <?php echo $cnt1['dokumen'];?>'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'a'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file44").onchange = function() {
																		document.getElementById("form44").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form44','id' => 'form44');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => 'b4'
																		);
																echo form_hidden($data);
																?>
																
																
																<!--<div class="upload" title="Input/Update">-->
																	<input type='file' name='file_name' id='file44'>
																	<!--<i class='fa  fa-pencil' style="color:green" ></i>
																</div>-->
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'a'){?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $cnt['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>

														<?php } 
															} 
														}else{
																if($flag == 'a'){ 
																	echo "
																	<a ><i class='text-muted fa fa-fw fa-download' title='File Kosong'></i></a>
																	";
																}
															}
														?>
														</td>
														<td>
														<?php
														if($countSTTb4->RecordCount() == ''){?>
														<script>
														$(document).ready(function(){
															document.getElementById("file4").onchange = function() {
																document.getElementById("form4").submit();
															}
															
														});
														</script>
														<?php
														$attributes = array('role' => 'form4','id' => 'form4');
														echo form_open_multipart('verifikasi/insert_dokumen', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => 'b4'
																);
														echo form_hidden($data);
														?>
														<!--<div class="upload">-->
																<input type='file' name='file_name' id='file4'>
																<!--<i class='fa  fa-pencil' style="color:green" title='File Kosong'></i>
															</div>-->
														</form>
														</td>
														<td>
															<i class='fa fa-times-circle text-muted' title=''></i>
														</td>
														<?php } ?>
														
													</tr>
													<tr>
														<td>Surat Keterangan Dokter</td>
														<?php 
															if($countSTTb5->RecordCount() != ''){
																foreach($countSTTb5 as $cnt1){?>
																<td class='text-success'>
																	<center><i style="color:green;" class='fa fa-check' title='Sudah'></i>
																	</center>
															<?php } }else{
																echo "<td class='text-danger'>
																		<center><i class='fa fa-times' title='Belum'></i></center>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php 
														if($countSTTb5->RecordCount() != ''){
															foreach($countSTTb5 as $cnt){
																
														?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $cnt['id'];?>/<?php echo $cnt['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download : <?php echo $cnt['dokumen'];?>'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'a'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file55").onchange = function() {
																		document.getElementById("form55").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form55','id' => 'form55');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => 'b5'
																		);
																echo form_hidden($data);
																?>
																
																<!--<div class="upload">-->
																<input type='file' name='file_name' id='file55'>
																<!--<i class='fa  fa-pencil' style="color:green" title='File Kosong'></i>
															</div>-->
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'a'){?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $cnt['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>

														<?php } 
															} 
														}else{
																if($flag == 'a'){ 
																	echo "
																	<a ><i class='text-muted fa fa-fw fa-download' title='File Kosong'></i></a>
																	";
																}
															}
														?>
														</td>
														<td>
														<?php
														if($countSTTb5->RecordCount() == ''){?>
														<script>
														$(document).ready(function(){
															document.getElementById("file5").onchange = function() {
																document.getElementById("form5").submit();
															}
															
														});
														</script>
														<?php
														$attributes = array('role' => 'form5','id' => 'form5');
														echo form_open_multipart('verifikasi/insert_dokumen', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => 'b5'
																);
														echo form_hidden($data);
														?>
														<!--<div class="upload">-->
																<input type='file' name='file_name' id='file5'>
																<!--<i class='fa  fa-pencil' style="color:green" title='File Kosong'></i>-->
															</div>
														</form>
														</td>
														<td>
															<i class='fa fa-times-circle text-muted' title=''></i>
														</td>
														<?php } ?>
														</td>
													</tr>
													<tr>
														<td>KTP</td>
														<?php 
															if($countSTTb6->RecordCount() != ''){
																foreach($countSTTb6 as $cnt1){?>
																<td class='text-success'>
																	<center><i style="color:green;" class='fa fa-check' title='Sudah'></i>
																	</center>
															<?php } }else{
																echo "<td class='text-danger'>
																		<center><i class='fa fa-times' title='Belum'></i></center>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php 
														if($countSTTb6->RecordCount() != ''){
															foreach($countSTTb6 as $cnt){	
															
														?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $cnt['id'];?>/<?php echo $cnt['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download : <?php echo $cnt['dokumen'];?>'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'a'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file66").onchange = function() {
																		document.getElementById("form66").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form66','id' => 'form66');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => 'b6'
																		);
																echo form_hidden($data);
																?>
																<input type='file' name='file_name' id='file66'>
																
																<!--<div class="upload">
																<input type='file' name='file_name' id='file66'>
																<i class='fa  fa-pencil' style="color:green" title='File Kosong'></i>
															</div>-->
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'a'){?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $cnt['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>

														<?php }	
															} 
														}else{
																if($flag == 'a'){ 
																	echo "
																	<a ><i class='text-muted fa fa-fw fa-download' title='File Kosong'></i></a>
																	";
																}
															}
														?>
														</td>
														<td>
														<?php
														if($countSTTb6->RecordCount() == ''){?>
														<script>
														$(document).ready(function(){
															document.getElementById("file6").onchange = function() {
																document.getElementById("form6").submit();
															}
															
														});
														</script>
														<?php
														$attributes = array('role' => 'form6','id' => 'form6');
														echo form_open_multipart('verifikasi/insert_dokumen', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => 'b6'
																);
														echo form_hidden($data);
														?>
														<!--<div class="upload">-->
																<input type='file' name='file_name' id='file6'>
																<!--<i class='fa  fa-pencil' style="color:green" title='File Kosong'></i>
															</div>-->
														</form>
														</td>
														<td>
															<i class='fa fa-times-circle text-muted' title=''></i>
														</td>
														<?php } ?>
														</td>
													</tr>
													<tr>
														<td>Lain-lain</td>
														<?php 
															if($countSTTb7->RecordCount() != ''){
																foreach($countSTTb7 as $cnt1){?>
																<td class='text-success'>
																	<center><i style="color:green;" class='fa fa-check' title='Sudah'></i>
																	</center>
															<?php } }else{
																echo "<td class='text-danger'>
																		<center><i class='fa fa-times' title='Belum'></i><center>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php 
														if($countSTTb7->RecordCount() != ''){
															foreach($countSTTb7 as $cnt){	
																
														?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $cnt['id'];?>/<?php echo $cnt['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download : <?php echo $cnt['dokumen'];?>'></i>
																</a>
														</td>
														<td>
																<?php if($flag == 'a'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file77").onchange = function() {
																		document.getElementById("form77").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form77','id' => 'form77');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => 'b7'
																		);
																echo form_hidden($data);
																?>
																<input type='file' name='file_name' id='file77'>
																<!--<div class="upload" title="Input/Update">
																	<input type='file' name='file_name' id='file77'>
																	<i class='fa  fa-pencil' style="color:green" ></i>
																</div>-->
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'a'){?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $cnt['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>

														<?php }
															} 
														}else{
															if($flag == 'a'){ 
																echo "
																<a ><i class='text-muted fa fa-fw fa-download' title='File Kosong'></i></a>
															";
															}
														}
														?>
														</td>
														<td>
														<?php
														if($countSTTb7->RecordCount() == ''){?>
														<script>
														$(document).ready(function(){
															document.getElementById("file7").onchange = function() {
																document.getElementById("form7").submit();
															}	
														});
														</script>
														<?php
														$attributes = array('role' => 'form7','id' => 'form7');
														echo form_open_multipart('verifikasi/insert_dokumen', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => 'b7'
																);
														echo form_hidden($data);
														?>
														<!--<div class="upload">-->
																<input type='file' name='file_name' id='file7'>
																<!--<i class='fa  fa-pencil' style="color:green" title='File Kosong'></i>
															</div>-->
														</form>
														</td>
														<td>
															<i class='fa fa-times-circle text-muted' title=''></i>
														</td>
														<?php } ?>
														</td>
													</tr>
												</table>
											</div>

											</div>
											<br/>
											
											<?php if($a == 6){?>
											
												<?php
													if($this->uri->segment(4, 0) == 'a'){
														echo form_open('verifikasi/update_dokumen');
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'flag' => $flag,
																  'tanggal_post' => date("Y-m-d") 
																);
														echo form_hidden($data);
												?>						
														<table>
															<tr>
																<td><h4><b>Lengkapi No. Surat Pengantar</b></h4></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><label>Tanggal Surat Pengantar</label></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><input id="datepicker8" name="tanggal_sp" class="form-control" required type="text"></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><label>No. Surat Pengantar</label></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><input type="text" name="ns" class="form-control" required placeholder="No. Surat Pengantar"></td>
																<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary" >Simpan</button></td>
															</tr>
														</table>															
													</form>			
											
										
												<?php } }?>
												
											<?php }if($flag == 'b' || $flag == 'c' || $flag == 'd' || $flag == 'e' || $flag == 'f' || $flag == 'g'){ ?>
											<!-- 2 -->
											<?php //if($getSTTb2->RecordCount() != ''){?>
											
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
											<div class="row" >
											<div class="col-xs-9" >
												<button class="menu1b btn btn-xs" style="display:none;"><i class="fa fa-plus"></i>&nbsp;&nbsp; <b>Verifikasi KUMHAM</b></button>
												<button class="menu2b btn btn-xs" ><i class="fa fa-minus" ></i>&nbsp;&nbsp; <b>Verifikasi KUMHAM</b></button>
												
												<table width="100%" id="target2" border="0" class="tb_berkas" style="margin:20px 0px 0px 0px;">
													<tr>
														<th>Nama Berkas</th>
														<th style="width:80px;"><center>Status</center></th>
														<th colspan="3" style="width:80px;"><?php if($flag == 'b'){ ?><center>Aksi</center><?php } ?></th>
													</tr>
													
													<?php 
													if($getSTTb2->RecordCount() != ''){
													foreach($getSTTb2 as $b2){?>
													<tr>
														<td><?=$b2['dokumen'];?></td>	
														<?php if($getSTTb2->RecordCount() != ''){?>
														<td align="center" class='text-success'>
															<center><i style="color:green;" class='fa fa-check' title='Sudah'></i></center>
															
															<?php } else{
																echo "<td class='text-danger'>
																		<i class='fa fa-times' title='Belum'></i>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php if($getSTTb2->RecordCount() != ''){
																
																?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b2['id'];?>/<?php echo $b2['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download : <?php echo $b2['dokumen'];?>'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'b'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file88").onchange = function() {
																		document.getElementById("form88").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form88','id' => 'form88');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => ''
																		);
																echo form_hidden($data);
																?>
																<input type='file' name='file_name' id='file88'>
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'b'){ ?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $b2['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>

														<?php } }else{
																if($flag == 'b'){ 	
																echo "<button class='h1 btn btn-xs' ><i class='fa fa-fw fa-download' title='Download'></i></button>
																<button class='h1 btn btn-xs' ><i class='fa fa-pencil' title='Isi'></i></button>";
																}
															}
														?>
														</td>
													</tr>
													<?php } 
													}else{?>
													<td>-</td>
													<td><center><i class="fa fa-times"></i></center></td>
													<td><center>
														<button class='h1 btn btn-xs' ><i class='fa fa-fw fa-download' title='Download'></i></button>
														</center>
													</td>
													<td>
														<script>
														$(document).ready(function(){
														  document.getElementById("file8").onchange = function() {
																document.getElementById("form8").submit();
															}
														});
														</script>
														
														<?php
														$attributes = array('role' => 'form8','id' => 'form8');
														echo form_open_multipart('verifikasi/insert_dokumen2', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => ''
																);
														echo form_hidden($data);
														?>
														<input type='file' name='file_name' id='file8'>
														</form>
													</td>
													<?php } ?>
												</table>
											</div>
											</div>
											<br />
											
											
											<?php if($b == 1){?>
											
												<?php
													if($this->uri->segment(4, 0) == 'b'){
														echo form_open('verifikasi/update_dokumen');
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'flag' => $flag,
																  'tanggal_post' => date("Y-m-d") 
																);
														echo form_hidden($data);
												?>			
														<table>
															<tr>
																<td><h4><b>Lengkapi No. Surat Verifikasi</b></h4></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><label>Tanggal Surat Verifikasi</label></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><input id="datepicker8" name="tanggal_sp" class="form-control" required type="text"></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><label>No. Surat Verifikasi</label></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><input type="text" name="ns" class="form-control" required placeholder="No. Surat Verifikasi"></td>
																<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary" >Simpan</button></td>
															</tr>
														</table>															
													</form>			
											
											<?php } }?>
											<?php }if($flag == 'c' || $flag == 'd' || $flag == 'e' || $flag == 'f' || $flag == 'g'){ ?>
											
											
											<!-- 3 -->
											<script>
											$(document).ready(function(){
											  $(".menu1c").click(function(){
												$("#target3").show();
												$(".menu1c").hide();
												$(".menu2c").show();
											  });
											  $(".menu2c").click(function(){
												$("#target3").hide();
												 $(".menu2c").hide();
												$(".menu1c").show();
											  });
											});
											</script>
											<div class="row">
											<div class="col-xs-9">
												<button class="menu1c btn btn-xs" style="display:none"><i class="fa fa-plus"></i>&nbsp;&nbsp; <b>Lulus DIKLAT</b></button>
												<button class="menu2c btn btn-xs" ><i class="fa fa-minus" ></i>&nbsp;&nbsp; <b>Lulus DIKLAT</b></button>
												<table width="100%" border="0" id="target3" class="tb_berkas" style="margin:20px 0px 0px 0px;">
													<tr>
														<th>Nama Berkas</th>
														<th style="width:80px;"><center>Status</center></th>
														<th colspan="3" style="width:80px;"></th>
													</tr>
													<?php 
													if($getSTTb3->RecordCount() != ''){
													foreach($getSTTb3 as $b3){?>
													<tr>
														<td><?=$b3['dokumen'];?></td>	
														<?php if($getSTTb3->RecordCount() != ''){?>
														<td align="center" class='text-success'>
															<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b3['id'];?>/<?php echo $b3['dokumen'];?>">
															<i style="color:green;" class='fa fa-check' title='Sudah'></i>
															</a>
															<?php } else{
																echo "<td class='text-danger'>
																		<i class='fa fa-times' title='Belum'></i>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php if($getSTTb3->RecordCount() != ''){
																 
																?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b3['id'];?>/<?php echo $b3['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'c'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file99").onchange = function() {
																		document.getElementById("form99").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form99','id' => 'form99');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => ''
																		);
																echo form_hidden($data);
																?>
																<input type='file' name='file_name' id='file99'>
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'c'){?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $b3['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>
														<?php } }else{
																if($flag == 'c'){ 
																echo "<i class='fa fa-pencil' title='Isi'></i>";
																}
															}
														?>
														</td>
													</tr>
													<?php } }else{ ?>
													<td>-</td>
													<td><center><i class="fa fa-times"></i></center></td>
													<td><center>
														<button class='h1 btn btn-xs' ><i class='fa fa-fw fa-download' title='Download'></i></button>
														</center>
													</td>
													<td>
														<script>
														$(document).ready(function(){
														  document.getElementById("file1010").onchange = function() {
																document.getElementById("form1010").submit();
															}
														});
														</script>
														<?php
														$attributes = array('role' => 'form1010','id' => 'form1010');
														echo form_open_multipart('verifikasi/insert_dokumen2', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => ''
																);
														echo form_hidden($data);
														?>
														<input type='file' name='file_name' id='file1010'>
														</form>
													</td>
													<?php } ?>
												</table>
											</div>
											</div>
											<br />
											
											<?php if($c == 1){?>
											
												<?php
													if($this->uri->segment(4, 0) == 'c'){
														echo form_open('verifikasi/update_dokumen');
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'flag' => $flag,
																  'tanggal_post' => date("Y-m-d")
																);
														echo form_hidden($data);
												?>			
														<table>
															<tr>
																<td><h4><b>Lengkapi No. Sertifikat</b></h4></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><label>Tanggal Sertifikat</label></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><input id="datepicker8" name="tanggal_sp" class="form-control" required type="text"></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><label>No. Sertifikat</label></td>
																<td>&nbsp;</td>
															</tr>
															<tr>
																<td><input type="text" name="ns" class="form-control" required placeholder="No. Sertifikat"></td>
																<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary" >Simpan</button></td>
															</tr>
														</table>															
													</form>			
											
											<?php } }?>

											<?php }if($flag == 'd' || $flag == 'e' || $flag == 'f' || $flag == 'g'){ ?>
											<!-- 4 -->
											<script>
											$(document).ready(function(){
											  $(".menu1d").click(function(){
												$("#target4").show();
												$(".menu1d").hide();
												$(".menu2d").show();
											  });
											  $(".menu2d").click(function(){
												$("#target4").hide();
												 $(".menu2d").hide();
												$(".menu1d").show();
											  });
											});
											</script>
											<div class="row">
											<div class="col-xs-9" >
												<button class="menu1d btn btn-xs" style="display:none"><i class="fa fa-plus"></i>&nbsp;&nbsp; <b>Rekemonendasi POLRI</b></button>
												<button class="menu2d btn btn-xs" ><i class="fa fa-minus" ></i>&nbsp;&nbsp; <b>Rekemonendasi POLRI</b></button>
												<table width="100%" border="0" id="target4" class="tb_berkas" style="margin:20px 0px 0px 0px;">
													<tr>
														<th>Nama Berkas</th>
														<th style="width:80px;"><center>Status</center></th>
														<th colspan="3" style="width:80px;"></th>
													</tr>
													<?php 
													if($getSTTb4->RecordCount() != ''){
													foreach($getSTTb4 as $b4){?>
													<tr>
														<td><?=$b4['dokumen'];?></td>	
														<?php if($getSTTb4->RecordCount() != ''){?>
														<td align="center" class='text-success'>
															<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b4['id'];?>/<?php echo $b4['dokumen'];?>">
															<i style="color:green;" class='fa fa-check' title='Sudah'></i>
															</a>
															<?php } else{
																echo "<td class='text-danger'>
																		<i class='fa fa-times' title='Belum'></i>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php if($getSTTb4->RecordCount() != ''){
																
																?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b4['id'];?>/<?php echo $b4['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'd'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file13").onchange = function() {
																		document.getElementById("form13").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form13','id' => 'form13');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => ''
																		);
																echo form_hidden($data);
																?>
																<input type='file' name='file_name' id='file13'>
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'd'){ ?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $b4['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>
														<?php } }else{
																if($flag == 'd'){ 
																echo "<i class='fa fa-times-circle' title='Hapus'></i>";
																}
															}
														?>
														</td>
													</tr>
													<?php } }else{?>
													<td>-</td>
													<td><center><i class="fa fa-times"></i></center></td>
													<td><center>
														<button class='h1 btn btn-xs' ><i class='fa fa-fw fa-download' title='Download'></i></button>
														</center>
													</td>
													<td>
														<script>
														$(document).ready(function(){
														  document.getElementById("file1212").onchange = function() {
																document.getElementById("form1212").submit();
															}
														});
														</script>
														<?php
														$attributes = array('role' => 'form1212','id' => 'form1212');
														echo form_open_multipart('verifikasi/insert_dokumen2', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => ''
																);
														echo form_hidden($data);
														?>
														<input type='file' name='file_name' id='file1212'>
														</form>
													</td>
													<?php } ?>
												</table>
											</div>
											</div>
											<br />
											
											<?php if($d == 1){?>
												
													<?php
														if($this->uri->segment(4, 0) == 'd'){
															echo form_open('verifikasi/update_dokumen');
															$data = array(
																	  'id_pegawai'  => $id_pegawai,
																	  'flag' => $flag,
																	  'tanggal_post' => date("Y-m-d")
																	);
															echo form_hidden($data);
													?>			
															<table>
																<tr>
																	<td><h4><b>Lengkapi No. Surat Rekomendasi</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Surat Rekomendasi</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" name="tanggal_sp" class="form-control" required type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>No. Surat Rekomendasi</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type="text" name="ns" class="form-control" required placeholder="No. Surat Rekomendasi"></td>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary" >Simpan</button></td>
																</tr>
															</table>															
														</form>			
											
												<?php } }?>
											<!-- 5 -->
											
											
											<?php }if($flag == 'e' || $flag == 'f' || $flag == 'g'){ ?>
											<script>
											$(document).ready(function(){
											  $(".menu1e").click(function(){
												$("#target5").show();
												$(".menu1e").hide();
												$(".menu2e").show();
											  });
											  $(".menu2e").click(function(){
												$("#target5").hide();
												 $(".menu2e").hide();
												$(".menu1e").show();
											  });
											});
											</script>
											<div class="row">
											<div class="col-xs-9" >
												<button class="menu1e btn btn-xs" style="display:none"><i class="fa fa-plus"></i>&nbsp;&nbsp; <b>Rekemonendasi KEJAGUNG</b></button>
												<button class="menu2e btn btn-xs" ><i class="fa fa-minus" ></i>&nbsp;&nbsp; <b>Rekemonendasi KEJAGUNG</b></button>
												
												<table width="100%"  border="0" id="target5" class="tb_berkas" style="margin:20px 0px 0px 0px;">
													<tr>
														<th>Nama Berkas</th>
														<th style="width:80px;"><center>Status</center></th>
														<th colspan="3" style="width:80px;"></th>
													</tr>
													
													<?php 
													if($getSTTb5->RecordCount() != ''){
													foreach($getSTTb5 as $b5){?>
													<tr>
														<td><?=$b5['dokumen'];?></td>	
														<?php if($getSTTb5->RecordCount() != ''){?>
														<td align="center" class='text-success'>
															<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b5['id'];?>/<?php echo $b5['dokumen'];?>">
															<i style="color:green;" class='fa fa-check' title='Sudah'></i>
															</a>
															<?php } else{
																echo "<td class='text-danger'>
																		<i class='fa fa-times' title='Belum'></i>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php if($getSTTb5->RecordCount() != ''){?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b5['id'];?>/<?php echo $b5['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'e'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file15").onchange = function() {
																		document.getElementById("form15").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form15','id' => 'form15');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => ''
																		);
																echo form_hidden($data);
																?>
																<input type='file' name='file_name' id='file15'>
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'e'){ ?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $b5['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>
														<?php } }else{
																if($flag == 'e'){ 
																echo "<i class='fa fa-times-circle' title='Hapus'></i>";
																}
															}
														?>
														</td>
													</tr>
													<?php } }else{?>
													<td>-</td>
													<td><center><i class="fa fa-times"></i></center></td>
													<td><center>
														<button class='h1 btn btn-xs' ><i class='fa fa-fw fa-download' title='Download'></i></button>
														</center>
													</td>
													<td>
														<script>
														$(document).ready(function(){
														  document.getElementById("file14").onchange = function() {
																document.getElementById("form14").submit();
															}
														});
														</script>
														<?php
														$attributes = array('role' => 'form14','id' => 'form14');
														echo form_open_multipart('verifikasi/insert_dokumen2', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => ''
																);
														echo form_hidden($data);
														?>
														<input type='file' name='file_name' id='file14'>
														</form>
													</td>
													<?php } ?>
												</table>
											</div>
											</div>
											<br />
											
											<?php if($e == 1){?>
												
													<?php
														if($this->uri->segment(4, 0) == 'e'){
															echo form_open('verifikasi/update_dokumen');
															$data = array(
																	  'id_pegawai'  => $id_pegawai,
																	  'flag' => $flag,
																	  'tanggal_post' => date("Y-m-d") 
																	);
															echo form_hidden($data);
													?>			
															<table>
																<tr>
																	<td><h4><b>Lengkapi No. Surat Rekomendasi</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Surat Rekomendasi</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" name="tanggal_sp" class="form-control" required type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>No. Surat Rekomendasi</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type="text" name="ns" class="form-control" required placeholder="No. Surat Rekomendasi"></td>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary" >Simpan</button></td>
																</tr>
															</table>															
														</form>			
											
												<?php } }?>
											<!-- 6 -->
											<?php }if($flag == 'f' || $flag == 'g'){ ?>
											<script>
											$(document).ready(function(){
											  $(".menu1f").click(function(){
												$("#target6").show();
												$(".menu1f").hide();
												$(".menu2f").show();
											  });
											  $(".menu2f").click(function(){
												$("#target6").hide();
												 $(".menu2f").hide();
												$(".menu1f").show();
											  });
											});
											</script>
											<div class="row">
											<div class="col-xs-9" >
												<button class="menu1f btn btn-xs" style="display:none"><i class="fa fa-plus"></i>&nbsp;&nbsp; <b>SKEP/KTP Dari KUMHAM</b></button>
												<button class="menu2f btn btn-xs" ><i class="fa fa-minus" ></i>&nbsp;&nbsp; <b>SKEP/KTP Dari KUMHAM</b></button>
												
												<table width="100%"  border="0" id="target6" class="tb_berkas" style="margin:20px 0px 0px 0px;">
													<tr>
														<th>Nama Berkas</th>
														<th style="width:80px;"><center>Status</center></th>
														<th colspan="3" style="width:80px;"></th>
													</tr>
													<?php 
													if($getSTTb6->RecordCount() != ''){
													foreach($getSTTb6 as $b6){?>
													<tr>
														<td><?=$b6['dokumen'];?></td>	
														<?php if($getSTTb6->RecordCount() != ''){?>
														<td align="center" class='text-success'>
															<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b6['id'];?>/<?php echo $b6['dokumen'];?>">
															<i style="color:green;" class='fa fa-check' title='Sudah'></i>
															</a>
															<?php } else{
																echo "<td class='text-danger'>
																		<i class='fa fa-times' title='Belum'></i>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php if($getSTTb6->RecordCount() != ''){?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b6['id'];?>/<?php echo $b6['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'f'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file17").onchange = function() {
																		document.getElementById("form17").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form17','id' => 'form17');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => ''
																		);
																echo form_hidden($data);
																?>
																<input type='file' name='file_name' id='file17'>
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'f'){?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $b6['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>
														<?php } }else{
																if($flag == 'f'){ 
																echo "<i class='fa fa-times-circle' title='Hapus'></i>";
																}
															}
														?>
														</td>
													</tr>
													<?php } }else{?>
													<td>-</td>
													<td><center><i class="fa fa-times"></i></center></td>
													<td><center>
														<button class='h1 btn btn-xs' ><i class='fa fa-fw fa-download' title='Download'></i></button>
														</center>
													</td>
													<td>
														<script>
														$(document).ready(function(){
														  document.getElementById("file16").onchange = function() {
																document.getElementById("form16").submit();
															}
														});
														</script>
														<?php
														$attributes = array('role' => 'form16','id' => 'form16');
														echo form_open_multipart('verifikasi/insert_dokumen2', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => ''
																);
														echo form_hidden($data);
														?>
														<input type='file' name='file_name' id='file16'>
														</form>
													</td>
													<?php } ?>
												</table>
											</div>
											</div>
											<br />
										
											<?php if($f == 1){?>
												
													<?php
														if($this->uri->segment(4, 0) == 'f'){
															echo form_open('verifikasi/update_dokumen');
															$data = array(
																	  'id_pegawai'  => $id_pegawai,
																	  'flag' => $flag,
																	  'tanggal_post' => date("Y-m-d") 
																	);
															echo form_hidden($data);
													?>			
															<table>
																<tr>
																	<td><h4><b>Lengkapi No. Surat</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Surat</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" name="tanggal_sp" class="form-control" required type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>No. Surat</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type="text" name="ns" class="form-control" required placeholder="No. Surat"></td>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary" >Simpan</button></td>
																</tr>
															</table>															
														</form>			
												
												<?php } }?>
											<!-- 7 -->
											<?php }if($flag == 'g'){ ?>
											<script>
											$(document).ready(function(){
											  $(".menu1g").click(function(){
												$("#target7").show();
												$(".menu1g").hide();
												$(".menu2g").show();
											  });
											  $(".menu2g").click(function(){
												$("#target7").hide();
												 $(".menu2g").hide();
												$(".menu1g").show();
											  });
											});
											</script>
											<div class="row">
											<div class="col-xs-9" >
												<button class="menu1g btn btn-xs" style="display:none"><i class="fa fa-plus"></i>&nbsp;&nbsp; <b>SKEP/KTP Dari KUMHAM</b></button>
												<button class="menu2g btn btn-xs" ><i class="fa fa-minus" ></i>&nbsp;&nbsp; <b>SKEP/KTP Dari KUMHAM</b></button>
												
												<table width="100%" border="0" id="target7" class="tb_berkas" style="margin:20px 0px 0px 0px;">
													<tr>
														<th>Nama Berkas</th>
														<th style="width:80px;"><center>Status</center></th>
														<th colspan="3" style="width:80px;"></th>
													</tr>
													<?php 
													if($getSTTb7->RecordCount() != ''){
													foreach($getSTTb7 as $b7){?>
													<tr>
														<td><?=$b7['dokumen'];?></td>	
														<?php if($getSTTb7->RecordCount() != ''){?>
														<td align="center" class='text-success'>
															<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b7['id'];?>/<?php echo $b7['dokumen'];?>">
															<i style="color:green;" class='fa fa-check' title='Sudah'></i>
															</a>
															<?php } else{
																echo "<td class='text-danger'>
																		<i class='fa fa-times' title='Belum'></i>";
															}
														?>
														</td>
														<td class="text-danger" align="center">
														<?php if($getSTTb7->RecordCount() != ''){?>
																<a title="download" style="color:green;" target="_blank" href="<?= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php echo $b7['id'];?>/<?php echo $b7['dokumen'];?>">
																<i class='fa fa-fw fa-download' style="color:green;" title='Download'></i>
																</a>
														</td>
														<td>
																
																<?php if($flag == 'g'){?>
																<script>
																$(document).ready(function(){
																	document.getElementById("file19").onchange = function() {
																		document.getElementById("form19").submit();
																	}
																	
																});
																</script>
																<?php
																$attributes = array('role' => 'form19','id' => 'form19');
																echo form_open_multipart('verifikasi/update_dokumens', $attributes); 
																$data = array(
																		  'id_pegawai'  => $id_pegawai,
																		  'flag' => $flag,
																		  'jenis_berkas' => ''
																		);
																echo form_hidden($data);
																?>
																<input type='file' name='file_name' id='file19'>
																</form>
																<?php } ?>
														</td>
														<td>
														<?php if($flag == 'g'){ ?>
																<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>verifikasi/delete_berkas/<?php echo $b7['id'];?>"><i class='fa fa-times-circle text-danger' title='Hapus'></i></a>
														<?php } }else{
																if($flag == 'g'){ 
																echo "<i class='fa fa-times-circle' title='Hapus'></i>";
																}
															}
														?>
														</td>
													</tr>
													<?php } }else{ ?>
													<td>-</td>
													<td><center><i class="fa fa-times"></i></center></td>
													<td><center>
														<button class='h1 btn btn-xs' ><i class='fa fa-fw fa-download' title='Download'></i></button>
														</center>
													</td>
													<td>
														<script>
														$(document).ready(function(){
														  document.getElementById("file18").onchange = function() {
																document.getElementById("form18").submit();
															}
														});
														</script>
														<?php
														$attributes = array('role' => 'form18','id' => 'form18');
														echo form_open_multipart('verifikasi/insert_dokumen2', $attributes); 
														$data = array(
																  'id_pegawai'  => $id_pegawai,
																  'nip' => $nip,
																  'nama'  => $nama,
																  'no_ktp'  => $no_ktp,
																  'no_sk_ppns' => $no_sk_ppns,
																  'flag' => $flag,
																  'berkas' => ''
																);
														echo form_hidden($data);
														?>
														<input type='file' name='file_name' id='file18'>
														</form>
													</td>
													<?php } ?>
												</table>
											</div>
											</div>
											<br />
											
											<?php if($g == 1){?>
												
													<?php
														if($this->uri->segment(4, 0) == 'g'){
															echo form_open('verifikasi/update_dokumen');
															$data = array(
																	  'id_pegawai'  => $id_pegawai,
																	  'flag' => $flag,
																	  'tanggal_post' => date("Y-m-d")
																	);
															echo form_hidden($data);
													?>			
															<table>
																<tr>
																	<td><h4><b>Lengkapi No. Pelantikan</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Pelantikan</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" name="tanggal_sp" class="form-control" required type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>No. Pelantikan</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type="text" name="ns" class="form-control" required placeholder="No. Pelantikan"></td>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary" >Simpan</button></td>
																</tr>
															</table>															
														</form>			
												
												<?php } }?>
										<?php } ?>
										
									<div class="row">
							
										
									
									<!--<div class="row">
										<div class="col-xs-5">
											<label></label>
											
											<?php //if($getSTTb2->RecordCount() != ''){?>
												<?php //foreach($getSTTb2 as $row2){
												 
												?>
												<table>
													<tr>
														<td>
															<a onclick="return confirm('Berkas akan dihapus?');" href="<?//= base_url();?>verifikasi/delete_berkas/<?php //echo $row2['id'];?>"><button class="btn btn-default">X</button></a><br />
														</td>
														<td width='200'>
															<a target="_blank" href="<?//= base_url();?>assets/uploads/dokumen_sppp_data_pegawai/<?php //echo $row2['id'];?>/<?php //echo $row2['dokumen'];?>">
															<button class="btn btn-default"><?php //if($this->uri->segment(4, 0) == 'a'){foreach($query_brks as $rows){
															  //$kode = $rows['kode'];  
																//if($kode == $row2['jenis_berkas']){
																//	echo $rows['nm_berkas'];
																//}
															//};}else{echo $row2['dokumen'];}?></button>
															</a>
														</td>
														<td>Sudah</td>
													</tr>
												</table>
												<?php //}?>
											<?php  //}else{?>	
											<button class="btn btn-default">Belum ada berkas yang diupload!</button>
											<?php //}?>
										</div>
									</div>-->
								</div><!-- /.box-body -->
							</div>
						</div><!-- /.box-header -->
						
					</div><!-- /.box -->        	
				</section><!-- /.Left col -->
				<!-- right col (We are only adding the ID to make the widgets sortable)-->
			</div><!-- /.row (main row) -->
		</section><!-- /.content -->
	</aside><!-- /.right-side -->