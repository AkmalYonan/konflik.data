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
				<li class="active">Pegawai</li>
			</ol>
		</section>
		
		<!-- Main content -->
		<section class="content">
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-12"> 
					<!-- Box (with bar chart) -->
					<div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-list-ol"></i>&nbsp;&nbsp;Daftar Pegawai</a></li>
                                    <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Tambah Pegawai</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
										<!-- tools box -->
										<div class="pull-right box-tools">
											<a href="<?= base_url()?>pegawai"
											class="btn btn-primary btn-sm refresh-btn" data-toggle="tooltip" title="Muat Ulang">
											<i class="fa fa-refresh"></i></a>
										</div><!-- /. tools -->
										
										<h3 >Daftar Pegawai</h3>
										<hr/>
							
                                        <?php if ($this->session->flashdata('success')) : ?>
											<div class="box-body">
												<div class="alert alert-success alert-dismissable">
													<i class="fa fa-check"></i>
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
													<b>Alert!</b> <?php echo $this->session->flashdata('success'); ?>
												</div>
											</div><!-- /.box-body -->
											<?php endif; 
											echo form_open('pegawai/search');?>
											
											<div class="row">
												
												<div class="col-lg-3">
													<div class="form-group">
													  <label class="control-label" for="focusedInput">Provinsi</label>
														 <select class="form-control" name="provinsi" id="prov" >
															<option value="">- All -</option>   	 
															<?php 
															$jsonData = services_prov();
															$phpArray = json_decode($jsonData, true);
															foreach ($phpArray as $key => $value) {
																$a = $value['kode_dagri'];
																$b = $value['nama_wilayah'];
																if($a == $scr_prov){
																	$selected = 'selected="selected"';
																}else{
																	$selected = '';
																}	
																echo "<option $selected value='".$a."'>$b</option>";
															}
														?> 	         
														</select> 
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
													  <label class="control-label" for="focusedInput">Kabupaten</label>
														<select class="form-control" name="kabupaten" id="kab" >
															<option value="">- All -</option>
															<?php
															if($this->uri->segment(2) == 'search'){
																$jsonData = services_kab($scr_prov);
																$phpArray = json_decode($jsonData, true);
																foreach ($phpArray as $key => $value) {
																	$a = $value['kode_dagri'];
																	$b = $value['nama_wilayah'];
																	if($a == $scr_kab){
																		$selected = 'selected="selected"';
																	}else{
																		$selected = '';
																	}	
																	echo "<option $selected value='".$a."'>$b</option>";
																}
															}
															?>
														</select>
													</div>
												</div>
												
												<div class="col-lg-3">
													<div class="form-group">
													  <label class="control-label" for="focusedInput">Kata Kunci</label>
													  <input name="q" class="form-control" type="text" value="<?= ($this->uri->segment(2) == 'search') ?   $scr :  '';?>">
													</div>
												</div>
												<div class="col-lg-1">
													<div class="form-group">
													  <label class="control-label" for="focusedInput">&nbsp;</label>
													  <button class="form-control btn btn-default btn-flat" name="search" type="submit"><i class="fa fa-search"></i></button>
													</div>
												</div>

												
												
												
											</div><!-- /.row -->
											
											</form>
											<table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0" border="0" id="example" width="100%">
												<thead>
												<tr>
													<th>No</th>
													<th><center>NIP / Nama</center></th>
													<th><center>Provinsi, Kabupaten</center></th>
													<!--<th><center>Tanggal Lahir</center></th>-->
													<th><center>Status Pegawai</center></th>
													<th><center>Status</center></th>
													<th colspan="3"><center>Aksi</center></th>
												</tr>
												</thead>
												<?php 
												if($query->RecordCount() == ''){?>
												<tr>
													<td colspan='7'><center><b>Data tidak ditemukan</b></center></td>
												</tr>
												 <?php }else{
												$i = 1;
												foreach($query as $key):
												?>
												<tr>
													<td><?=$i;?></td>
													<td><?=$key['nip'];?> / <?=$key['nama'];?></td>
													<td>
														<?php 
														$jsonData = services_prov();
															$phpArray = json_decode($jsonData, true);
														foreach($phpArray as $rows){
																  $kode_dagri = $rows['kode_dagri'];  
																  if($kode_dagri == $key['propinsi']){
																	echo $rows['nama_wilayah'];  
																  }
															  }
														?>, 
														<?php 
															  if(!empty($key['kabupaten'])){
															  $jsonData2 = services_kab($key['propinsi']);
															  $phpArray2 = json_decode($jsonData2, true);
															  foreach ($phpArray2 as $key2 => $value2) {
																$a2 = $value2['kode_dagri'];
																$b2 = $value2['nama_wilayah'];
																if($a2 == $key['kabupaten']){
																	echo $b2;  
																}
															   }
															  }else{echo "-";}
														?>
													</td>
													<!--<td align="center"><?=$key['tanggal_lahir'];?></td>-->
													
													<td align="center"><?=strtoupper($key['status_pegawai']);?></td>
													<td align="center">
														<?php if($key['status'] == 1){?>
														<center>
															<span class="label label-info">Verified</span>
														</center>
														<?php }elseif($key['status'] == 0){?>
														<center>
															<span class="label label-danger">Not Verified</span>
														</center>
														<?php } ?>
													</td>
													<!--<td>
														</a>
														<a href="<?//=base_url();?>pegawai/dokumen/<?//=$key['id_pegawai'];?>" title="Dokumen">														   <i class="fa  fa-folder-open-o" ></i>
														</a>
													</td>-->
													<td>
														<a href="<?=base_url();?>pegawai/edit/<?=$key['id_pegawai'];?>" title="Edit">
														<i class="fa fa-edit" ></i>
														</a>
													</td>
													<td>
														<a title="Verified/Not Verified" href="<?php echo site_url("pegawai/publish/".$key['id_pegawai']."/".$key['status']."/".$this->uri->segment(2, 0)."/".$this->uri->segment(3, 0));?>">
															<i class="fa  fa-check-circle" ></i>
														</a>
								
													</td>
													<td>
														<a onclick="return confirm('Data akan dihapus?');" href="<?=base_url();?>pegawai/delete/<?=$key['id_pegawai'];?>" title="Hapus">
														<i class="fa fa-trash-o" ></i>
														</a>
													</td>
													
												</tr>
												<?php $i++; endforeach;}?> 
											</table>
											<div class="box-footer clearfix">
												<ul class="pagination pagination-sm no-margin pull-right">
													<?php echo $halaman;?>
												</ul>
											</div>
											<hr>
                                    </div><!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
										 <?php
											$attributes = array('role' => 'form');

											echo form_open_multipart('pegawai/insert', $attributes);
										?>
										<!-- tools box -->
										<div class="pull-right box-tools">
											<button type="reset" class="btn btn-primary btn-sm refresh-btn" data-toggle="tooltip" title="Kosongkan">
											<i class="fa fa-eraser"></i></button>
										</div><!-- /. tools -->
										
										
										<h3 class="box-title">Tambah Pegawai</h3>
										<hr/> 
										
                                       
													<div class="box-body">
													<fieldset>
														<legend style="background:#f2f2f2">&nbsp; Profil Pegawai</legend>
													<div class="row">
														
														<div class="col-xs-6">
															<div class="row">
																	<div class="col-xs-6">
																		<label>Nomor Induk Pegawai</label>
																		<input type="text" name="nip" class="form-control" required placeholder="NIP">
																	</div>
																
																	<div class="col-xs-6">
																		<label>Nomor SK. PPNS</label>
																		<input type="text" name="skppns" class="form-control" placeholder="No. SK PPNS">
																	</div>
															</div>
															<br/>
															
															<div class="row">
																<div class="col-xs-12">
																	<label>Nama Lengkap</label>
																	<input type="text" id="nama" name="nama" class="form-control" required placeholder="Nama Lengkap"/>
																</div>
															</div>
															<br/>
															
															<div class="row">
																<div class="col-xs-6">
																	<label>Tempat lahir</label>
																	<input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required />
																</div>
																<div class="col-xs-6">
																	<label>Tanggal lahir</label>
																		<input type="text" id="datepicker2" name="tanggal_lahir_selector" class="form-control" required/>
																</div>
															</div>
															<br/>
															
															<div class="row">
																<div class="col-xs-12">
																	<label>Alamat</label>
																	<textarea name="alamat" id="alamat" rows="5" class="form-control required"></textarea>
																	<span style="font-size:10px;" class="help-block">Contoh: Jalan Wijaya II/No. 23</span>    
																</div>
															</div>
															<br/>
															
															
															
															
														</div>
														<div class="col-xs-6">
															<div style="position: relative;" id="imgcontainer">
																	<label>Foto <span class="help-block" style="display:inline">(Max filesize: 200kb)</span></label>
																	<div id="preview" style="width:200px; height:200px;" class="img-polaroid">
																			<img src="<?= base_url();?>assets/images/avatar5.png" id="previewplay" width="98%">
																	</div>
																	<!--[ <a style="position: relative; z-index: 1;" href="" id="pickfiles">Browse</a> ]-->
																	<div id="image_data" style="display:none">
																</div>
																<br/>
																<input id="imgInpPlay" type="file" name="file_name" />
																<p style="font-size:10px;" class="help-block">File : *.jpg, *.png, *.gif</p>
																</div>
														</div>
													</div>
													<div class="row">
															
																<div class="col-xs-3">
																	<label>Provinsi</label>
																	<select class="form-control" required name="provinsi" id="prov2" >
																	<option value="">- Pilih Provinsi -</option>   
																	<?php
																	$jsonData = services_prov();
																	$phpArray = json_decode($jsonData, true);
																		foreach ($phpArray as $key => $value) {
																			$a = $value['kode_dagri'];
																			$b = $value['nama_wilayah'];
																			echo "<option value='".$a."'>$b</option>";
																		}
																	?> 	       
																	</select>     
																	<span style="font-size:10px;" class="help-block">Tempat Personel Bekerja</span>
																</div>
															
																<div class="col-xs-3">
																	<label>Kabupaten</label>
																	<select class="form-control" name="kabupaten" id="kab2" >
																		<option value="">- Pilih Kabupaten -</option>
																	</select>
																	<span style="font-size:10px;" class="help-block">Tempat Personel Bekerja</span>
																</div>
															
															
																<div class="col-xs-3">
																		<label for="exampleInputEmail1">Email address</label>
																		<input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter email">
																</div>
																
															</div>
															<fieldset>
														
														<br/><hr/><br/>
														
														<div class="row">
															<fieldset>
															<legend style="background:#f2f2f2">&nbsp; Data Pegawai</legend>
															<div class="col-xs-3">
																<label>Masa Berlaku Pegawai</label>
																<input type="text" id="datepicker4" name="berlaku_peg" class="form-control" required/>
															</div>
															<div class="col-xs-3">
																<label>No. KTP</label>
																<input type="text" id="no_ktp" name="no_ktp" class="form-control" placeholder="No. KTP" required />
															</div>
														
															<div class="col-xs-3">
																<label>Masa Berlaku KTP</label>
																<input type="text" id="datepicker3" name="berlaku_ktp" class="form-control" required/>
															</div>
															<div class="col-xs-3">
																<label>Jenis Kelamin</label><br>
																<label class="radio inline">
																  <input name="jenis_kelamin" class="form-control" value="L" checked="" type="radio"> Laki-laki                                        
																</label>
																<label class="radio inline">&nbsp;&nbsp;&nbsp;
																  <input name="jenis_kelamin" class="form-control" value="P" type="radio"> Perempuan                                        
																</label>
															</div>
															<!--<div class="col-xs-3">
																<label>Agama</label>
																<select name="agama" class="form-control" id='agama' required>
																	<option value="">- Pilih Agama -</option>
																	<option value="ISLAM">ISLAM</option>
																	<option value="KATOLIK">KATOLIK</option>
																	<option value="KRISTEN">KRISTEN</option>
																	<option value="HINDU">HINDU</option>
																	<option value="BUDHA">BUDHA</option>
																	<option value="KONG HU CHU">KONG HU CHU</option>
																</select>  
															</div>
														
															<div class="col-xs-3">
																<label>Status Perkawinan</label>
																<select name="status_perkawinan" id='status_perkawinan' class="form-control required">
																<option value="">- Pilih Status Perkawinan -</option>
																<option value="belum_kawin">Belum Kawin</option>
																<option value="kawin">Kawin</option>
																<option value="cerai">Cerai</option>
																</select> 
															</div>-->
															</fieldset>
														</div>
														<br/>
														
														<div class="row">
															<!--<div class="col-xs-3">
																<label>Golongan Darah</label>
																<select name="golongan_darah" id='golongan_darah' class="form-control required">
																<option value="">- Pilih Golongan Darah -</option>
																<option value="A">A</option>
																<option value="AB">AB</option>
																<option value="B">B</option>
																<option value="O">O</option>
																</select>  
															</div>
														
															<div class="col-xs-3">
																<label>Rhesus</label>
																<select name="golongan_darah_rhesus" id='golongan_darah_rhesus' class="form-control" required>
																<option value="">- Pilih Rhesus -</option>
																<option value="RH0">RH0</option>
																<option value="RH+">RH+</option>
																<option value="RH-">RH-</option>
																</select> 
															</div>-->
														
															
														</div>
														<br/><hr/><br/>
														
														<fieldset>
														<legend style="background:#f2f2f2">&nbsp; Atribut Pegawai</legend>
														<div class="row">
															
															<div class="col-xs-2">
																<label>Pendidikan terakhir</label>
																<select name="pendidikan_terakhir" id='pendidikan_terakhir' class='form-control required'>
																<option value="">- Pilih Pendidikan Terakhir -</option>
																<option value="SLTA">SLTA</option>
																<option value="S1">S1</option>
																<option value="S2">S2</option>
																<option value="S3">S3</option>
																<option value="D3">D3</option>
																</select>       
															</div>
															
															
															<div class="col-xs-2">
																<label>Gelar Depan</label>
																<input type="text" id="gelar_depan" name="gelar_depan" class="form-control" placeholder="Gelar Depan"/>
																<span style="font-size:10px;" class="help-block">Contoh: Drs., Ir. , H.</span>						
															</div>
															
															
															<div class="col-xs-2">
																<label>Gelar Belakang</label>
																<input type="text" id="gelar_belakang" name="gelar_belakang" class="form-control" placeholder="Gelar Belakang" />
																<span style="font-size:10px;" class="help-block">Contoh: SH, ST, MSc</span>
															</div>
															
															
														
															<div class="col-xs-3">
																<label>UU Yang Dikawal</label>
																<input type="text" id="uu" name="uu" class="form-control" required />
															</div>
														
															<div class="col-xs-3">
																<label>TMT Pegawai</label>
																<input type="text" id="datepicker" name="tmt_pegawai_masuk_selector" class="form-control" required />
															</div>
														</div>
														<br/>
														
														<div class="row">
															<div class="col-xs-3">
																<label>Status</label>
																<select name="status_pegawai" id='status_pegawai' class='form-control required'>
																<option value="">- Pilih Status Pegawai -</option>
																<option value="pns">PNS</option>
																<option value="ppns">PPNS</option>
																</select> 
															</div>
													
															<div class="col-xs-3">
																<label>Pangkat/Golongan</label>
																<select name="pangkat" id='pangkat' class='form-control' required>
																<option value="">- Pilih Pangkat/Golongan -</option>
																<?php foreach($query_gol as $rowG):
																			  $ket = $rowG['keterangan'];  
			
																			  echo "<option $selected value='".$rowG['keterangan']."'>".$rowG['keterangan']."</option>";
																			  
																		?>
																		<?php endforeach;?> 
																</select> 
															</div>
													
															<div class="col-xs-3">
																<label>SK. Pangkat/Golongan</label>
																<input type="text" id="no_sk_pangkat" name="no_sk_pangkat" class="form-control required"  />       
															</div>
														
															<div class="col-xs-3">
																<label>Keterangan lain</label>
																<textarea name="keterangan" id="ket" rows="3" class="form-control "></textarea>   
															</div>
														</div>
														</fieldset>
															
														<br/>
														
														
														<br>
														<br>
						<div class="row">
							<div class="col-xs-12">
							<button type="button" class="btn btn-default" onclick="window.history.back();return false;" style="float:right">Batal</button>
							<button type="submit" name="save" value="Simpan" class="btn btn-primary" style="float:right;margin-right:20px">Simpan</button>
							</div>
						</div>
													
														
														
														
														
													</div><!-- /.box-body -->

													<div class="box-footer">
														<br/>
														
														
														
													</div>
												</form>	
                                    </div><!-- /.tab-pane -->
                                </div><!-- /.tab-content -->
                            </div>
					  	
				</section><!-- /.Left col -->
				<!-- right col (We are only adding the ID to make the widgets sortable)-->
			</div><!-- /.row (main row) -->
		</section><!-- /.content -->
	</aside><!-- /.right-side -->
<script language="javascript">
$(document).ready(function(){      
$('#prov').change(function(){
    $.post("<?php echo base_url();?>pegawai/get_city/"+$('#prov').val(),{},function(obj){
    $('#kab').html(obj);
    });
    });
$('#prov2').change(function(){
    $.post("<?php echo base_url();?>pegawai/get_city/"+$('#prov2').val(),{},function(obj){
    $('#kab2').html(obj);
    });
    });
});
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '300px');
                $('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>