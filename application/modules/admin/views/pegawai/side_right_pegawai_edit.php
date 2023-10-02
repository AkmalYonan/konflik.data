
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>Edit <small>Pegawai</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active">Edit pegawai</li>
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
							<a class="btn btn-default" href="<?php echo $this->module?>listview">
								<i class="fa fa-list"></i> List
							</a>
							<a class="btn btn-default active" href="<?php echo $this->module?>edit">
								<i class="fa fa-edit"></i> Edit
							</a> 							
							<a class="btn btn-default" href="<?php echo $this->module?>edit/<?=$this->uri->segment(4);?>">
								<i class="fa fa-refresh"></i> Refresh
							</a>
							<div class="pull-right">
							<a class="btn btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?=$this->module?>del/<?=$this->uri->segment(4);?>">	
								<i class="fa fa-trash"></i> Hapus
							</a>
							</div>							
							</div>
						</div>
					</div>
				</div><!-- ./box-body -->
			</div>
			<div class="col-md-12">
				<?php echo message_box();?>  
			</div>
			<!-- form start -->
				<?php
				$attributes = array('role' => 'form');
				echo form_open_multipart('admin/pegawai/update', $attributes);
				$data = array(
						  'id'  => $id_pegawai,
						  'image_url' => $foto
						);
				echo form_hidden($data);
				?>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
						<legend style="background:#f2f2f2">&nbsp; <small>Profil Pegawai</small></legend>
						</div>
						
						<div class="col-md-6">
							<div style="position: relative;" id="imgcontainer">
									<label>Foto <span class="help-block" style="display:inline">(Max filesize: 200kb)</span></label>
									<div style="width:200px; height:200px;" class="img-polaroid">
									<?php if (!empty($foto)){?>
										<img class="img-circle" src="<?= base_url()?>uploads/sppp_data_pegawai/<?php echo $foto;?>" id="previewplay" width="200px" />
									
									<?php }else{ ?>
										<img class="img-circle" src="<?= base_url();?>assets/image/person.jpg" id="previewplay" width="98%">
									<?php } ?>
									</div>
									<div id="image_data" style="display:none">
								</div>
								<br/>
								<input id="imgInpPlay" type="file" name="file_name" />
								<p style="font-size:10px;" class="help-block">File : *.jpg, *.png, *.gif</p>
							</div>
							<label>Nama Lengkap</label>
							<input type="text" id="nama" name="nama" value="<?=$nama;?>" class="form-control" required placeholder="Nama Lengkap"/>
							<label>Tanggal lahir</label>
							<input type="text" id="datepicker2" value="<?=$tanggal_lahir_selector;?>" name="tanggal_lahir_selector" class="form-control" required/>
							<br>
						</div>

						<div class="col-md-6">
							<label>Tempat lahir</label>
							<input type="text" id="tempat_lahir" value="<?=$tempat_lahir;?>" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required />
						</div>
						<div class="col-md-6">
							<label for="exampleInputEmail1">Email address</label>
							<input type="email" name="email" class="form-control" value="<?=$email;?>" id="exampleInputEmail1" placeholder="Enter email">
						</div>
						
						<div class="col-md-6">
							<label>Jenis Kelamin</label>
							<div class="radio">
							<label>
							  <input name="jenis_kelamin" id="optionsRadios1" <?php if($jenis_kelamin == 'L') echo 'checked';?> value="L" checked="" type="radio"> Laki-laki &nbsp;&nbsp;	&nbsp;						  
							</label>

							<label>
							  <input name="jenis_kelamin" id="optionsRadios1" <?php if($jenis_kelamin == 'P') echo 'checked';?> value="P" type="radio"> Perempuan                                        
							</label>
							</div>	
						</div>
						<div class="col-md-6">
							<label>Alamat</label>
							<textarea name="alamat" id="alamat" rows="7" class="form-control required"><?=$alamat;?></textarea>
							<span style="font-size:10px;" class="help-block">Contoh: Jalan Wijaya II/No. 23</span>    
						</div>
					</div>
					

					<div class="row">
						<div class="col-md-12">
							<legend style="background:#f2f2f2">&nbsp; <small>Data Pegawai</small></legend>
						</div>
						<div class="col-md-6">
							<label>Nomor Induk Pegawai</label>
							<input type="text" name="nip" value="<?=$nip;?>" class="form-control" required placeholder="NIP">
						</div>
						<div class="col-md-6">
							<label>Nomor SK. PPNS</label>
							<input type="text" name="skppns" value="<?=$no_sk_ppns;?>" class="form-control" placeholder="No. SK PPNS">
						</div>
						<div class="col-md-6">
							<label>Masa Berlaku Pegawai</label>
							<input id="datepicker4" value="<?=$berlaku_peg;?>" name="berlaku_peg" class="form-control hasDatepicker" required="" type="text">
						</div>
						<div class="col-md-6">
							<label>No. KTP</label>
							<input type="text" id="no_ktp" value="<?=$no_ktp;?>" name="no_ktp" class="form-control" placeholder="No. KTP" required />
						</div>
						<div class="col-md-6">
							<label>Masa Berlaku KTP</label>
							<input type="text" id="datepicker3" value="<?=$berlaku_ktp;?>" name="berlaku_ktp" class="form-control" required/>
						</div>
						<div class="col-md-6">
							<label>SKPD</label>
							<select name="skpd" required class="form-control">
								<option value=''>- Pilih SKPD -</option>
								<? foreach($m_skpd as $rows):
									$nama = $rows['nama'];  
									if($nama == $skpd){
										$selected = 'selected="selected"';
									}else{
										  $selected = '';
									}	
									if($skpd == ''){?>
										<option value="<?=$nama;?>"><?=$nama;?></option>";
									<? }elseif($skpd != ''){
										if($skpd ==  $rows['nama']){?>
											<option <?=$selected;?> value="<?=$nama;?>"><?=$nama;?></option>";
									<?	}
									}else{?>
										<option  value="<?=$nama;?>"><?=$nama;?></option>";
									<?}
								?>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					

					<div class="row">
						<div class="col-md-12"><br>
							<legend style="background:#f2f2f2">&nbsp; <small>Atribut Pegawai</small></legend>
						</div>
						<div class="col-md-6">
							<label>Gelar Depan</label>
							<input type="text" id="gelar_depan" value="<?=$gelar_depan;?>" name="gelar_depan" class="form-control" placeholder="Gelar Depan"/>
							<span style="font-size:10px;" class="help-block">Contoh: Drs., Ir. , H.</span>						
						</div>
						<div class="col-md-6">
							<label>Gelar Belakang</label>
							<input type="text" id="gelar_belakang" value="<?=$gelar_belakang;?>" name="gelar_belakang" class="form-control" placeholder="Gelar Belakang" />
							<span style="font-size:10px;" class="help-block">Contoh: SH, ST, MSc</span>
						</div>
						<!--<div class="col-md-6">
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
						<div class="col-md-6">
							<label>Status Perkawinan</label>
							<select name="status_perkawinan" id='status_perkawinan' class="form-control required">
							<option value="">- Pilih Status Perkawinan -</option>
							<option value="belum_kawin">Belum Kawin</option>
							<option value="kawin">Kawin</option>
							<option value="cerai">Cerai</option>
							</select> 
						</div>-->
					</div>
					<!--<div class="row">
						<div class="col-md-6">
							<label>Golongan Darah</label>
							<select name="golongan_darah" id='golongan_darah' class="form-control required">
							<option value="">- Pilih Golongan Darah -</option>
							<option value="A">A</option>
							<option value="AB">AB</option>
							<option value="B">B</option>
							<option value="O">O</option>
							</select>  
						</div>
						<div class="col-md-6">
							<label>Rhesus</label>
							<select name="golongan_darah_rhesus" id='golongan_darah_rhesus' class="form-control" required>
							<option value="">- Pilih Rhesus -</option>
							<option value="RH0">RH0</option>
							<option value="RH+">RH+</option>
							<option value="RH-">RH-</option>
							</select> 
						</div>
					</div>-->

					<div class="row">
						<div class="col-md-6">
							<label>Provinsi</label>
							<select class="form-control" required name="provinsi" id="prov" >
							<?php 
							if(($prov == '') && ($kabupaten == '')){
								echo "<option value=''>- Pilih Provinsi -</option>";
							}
							// $jsonData = file_get_contents($services_prov."?kode_wilayah=00");
							$jsonData = file_get_contents($services_prov."propinsi");
							$phpArray = json_decode($jsonData, true);
							foreach($phpArray as $row){
								  $kdprov = $row['kode_dagri'];  
									if($kdprov == $provinsi){
										$selected = 'selected="selected"';
									}else{
										$selected = '';
									}	
									if(($prov != '') && ($kabupaten == '')){
										if($prov == $row['kode_dagri']){
											echo "<option $selected value='".$row['kode_dagri']."'>$row[nama_wilayah]</option>"; 
										}
									}elseif(($prov != '') && ($kabupaten != '')){
										if($prov == $row['kode_dagri']){
											echo "<option $selected value='".$row['kode_dagri']."'>$row[nama_wilayah]</option>"; 
										}
									} else{
										echo "<option $selected value='".$row['kode_dagri']."'>$row[nama_wilayah]</option>"; 
									}
										
								}
							?> 	 
							</select>     
							<span style="font-size:10px;" class="help-block">Tempat Personel Bekerja</span>
						</div>
						<div class="col-md-6">
							<label>Kabupaten</label>
							<select class="form-control" name="kabupaten" id="kab" >
								<?php 
									if(($prov == '') && ($kabupaten == '')){
										echo "<option value=''>- Pilih Provinsi -</option>";
									}elseif(($prov != '') && ($kabupaten == '')){
										echo "<option value=''>- Pilih Provinsi -</option>";
									}
									// $jsonData = file_get_contents($services_prov."?kode_dagri=$provinsi");
									$jsonData = file_get_contents($services_prov."kabupaten/$provinsi");
									$phpArray = json_decode($jsonData, true);
									foreach($phpArray as $rowk):
										$kdkab = $rowk['kode_dagri'];  
										if($kdkab == $kab){
											$selected = 'selected="selected"';
										}else{
											$selected = '';
										}	
										if(($prov != '') && ($kabupaten == '')){
											echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";
										}elseif(($prov != '') && ($kabupaten != '')){
											if($kabupaten == $rowk['kode_dagri']){
											echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";
											}
										}else{
											echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";										
										}
								?>
								<?php endforeach;?>  
							</select>
							<span style="font-size:10px;" class="help-block">Tempat Personel Bekerja</span>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<label>UU Yang Dikawal</label>
							<input type="text" id="uu" value="<?=$uu_dikawal;?>"name="uu" class="form-control" required />
						</div>
						<div class="col-md-6">
							<label>TMT Pegawai</label>
							<input type="text" value="<?=$tmt_pegawai_masuk_selector;?>" id="datepicker" name="tmt_pegawai_masuk_selector" class="form-control" required />
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Status</label>
							<select name="status_pegawai" id='status_pegawai' class='form-control required'>
							<option value="">- Pilih Status Pegawai -</option>
							<option <?php if($status_pegawai == 'pns') echo 'selected';?> value="pns">PNS</option>
							<option <?php if($status_pegawai == 'ppns') echo 'selected';?> value="ppns">PPNS</option>
							</select> 
						</div>
						<div class="col-md-6">
							<label>Pangkat/Golongan</label>
							<select name="pangkat" id='pangkat' class='form-control' required>
							<option value="">- Pilih Pangkat/Golongan -</option>
							<?php foreach($query_gol as $rowG):
								  $ket = $rowG['keterangan'];  
								  if($ket == $pangkat){
									$selected = 'selected="selected"';
									}else{
									  $selected = '';
									}	
								  echo "<option $selected value='".$rowG['keterangan']."'>".$rowG['keterangan']."</option>";
								  
							?>
							<?php endforeach;?> 
							</select> 
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<label>SK. Pangkat/Golongan</label>
							<input type="text" value="<?=$no_sk_pangkat;?>" id="no_sk_pangkat" name="no_sk_pangkat" class="form-control required"  />       
						</div>
						<div class="col-md-6">
							<label>Pendidikan terakhir</label>
							<select name="pendidikan_terakhir" id='pendidikan_terakhir' class='form-control required'>
							<option value="">- Pilih Pendidikan Terakhir -</option>
							<option <?php if($pendidikan_terakhir == 'SLTA') echo 'selected';?> value="SLTA">SLTA</option>
							<option <?php if($pendidikan_terakhir == 'S1') echo 'selected';?> value="S1">S1</option>
							<option <?php if($pendidikan_terakhir == 'S2') echo 'selected';?> value="S2">S2</option>
							<option <?php if($pendidikan_terakhir == 'S3') echo 'selected';?> value="S3">S3</option>
							<option <?php if($pendidikan_terakhir == 'D3') echo 'selected';?> value="D3">D3</option>
							</select>       
						</div>
					</div>

					<div class="row">
						
						<div class="col-md-6">
							<label>Keterangan lain</label>
							<textarea name="keterangan" id="ket" rows="3" class="form-control "><?=$keterangan;?></textarea>   
						</div>
					</div>
				</div><!-- /.box-body -->

				<div class="box-footer">
					<button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
				</div>
			</form>		

		
		  </div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->	

	
</div><!-- end div positioning -->
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
				$('#previewplay').attr('width', '200px');
                $('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>










