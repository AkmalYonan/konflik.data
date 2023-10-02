<script>
$(document).ready(function(){
	document.getElementById("file").onchange = function() {
		document.getElementById("form").submit();
	}
});	
</script>
<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="right-side">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Pegawai
				<!--<small>Control panel</small>-->
			</h1>
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li><a href="#">Pegawai</a></li>
				<li class="active">Dokumen</li>
			</ol>
		</section>
		
		<!-- Main content -->
		<section class="content">
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-12 connectedSortable"> 
					<!-- Box (with bar chart) -->
					<div class="box box-primary" id="loading-example">
						<div class="box-header " style="padding:10px 30px">
							<!-- tools box -->
					
							
							
							<div class="box-body table-responsive">	
							<div class="box-header">
									<div class="pull-right box-tools">
										<a href=""
										class="btn btn-primary btn-sm refresh-btn" data-toggle="tooltip" title="Muat Ulang">
										<i class="fa fa-refresh"></i></a>
									</div><!-- /. tools -->
								
								<h3 >Edit Dokumen Pegawai</h3>
								<hr style="clear:both"/>				
												
												
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
												
											</div><br>
											
											<div class="row">
												<div class="col-xs-6">
													<label>Provinsi</label>
													<input type="text" name="sk_ppns" class="form-control" disabled value="<?php foreach($query_prov as $rows){
																		  $kode_dagri = $rows['kode_dagri'];  
																		  if($kode_dagri == $provinsi){
																			echo $rows['nama_wilayah'];  
																		  }
																	  }
																?>" />
												</div>
												
												<div class="col-xs-6">
													<label>Kabupaten</label>
													<input type="text" name="sk_ppns" class="form-control" disabled value="<?php 
																	  if(!empty($kabupaten)){
																	  foreach($query_kab as $rows){
																		  $kode_dagri = $rows['kode_dagri'];  
																		  if($kode_dagri == $kabupaten){
																			echo $rows['nama_wilayah'];  
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
										
										
									</div>
									<br/>
									
									<hr />
									<div class="row">
										<div class="col-xs-5">
											<label>Upload Berkas Pendukung</label>
												<?php
												$attributes = array('role' => 'form','id' => 'form');
												echo form_open_multipart('pegawai/insert_dokumen', $attributes);
												$data = array(
														  'id_pegawai'  => $id_pegawai,
														  'nip' => $nip,
														  'no_ktp'  => $no_ktp,
														  'no_sk_ppns' => $no_sk_ppns
														);
												echo form_hidden($data);
												?>
												<input type="file" name="file_name" id="file"><br />
											</form>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12">
										
											<?php if($getDoc->RecordCount() != ''){?>
												<?php foreach($getDoc as $row){?>
												<a target="_blank" href="<?= base_url();?>assets/uploads/berkas_sppp_data_pegawai/<?php echo $row['id'];?>/<?php echo $row['dokumen'];?>"><button class="btn btn-default">Download: <?php echo $row['dokumen'];?></button></a>
												
												<a onclick="return confirm('Berkas akan dihapus?');" href="<?= base_url();?>pegawai/delete_berkas/<?php echo $row['id'];?>"><button class="btn btn-danger" title="Hapus">X</button></a><br /><br />
												<?php }?>
											<?php  }else{?>	
											<button class="btn btn-default">Belum ada berkas yang diupload!</button>
											<?php }?>
										</div>
									</div>
								</div><!-- /.box-body -->
							</div>
						</div><!-- /.box-header -->
						
					</div><!-- /.box -->        	
				</section><!-- /.Left col -->
				<!-- right col (We are only adding the ID to make the widgets sortable)-->
			</div><!-- /.row (main row) -->
		</section><!-- /.content -->
	</aside><!-- /.right-side -->