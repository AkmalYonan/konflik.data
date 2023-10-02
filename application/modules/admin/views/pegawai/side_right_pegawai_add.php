<script type="text/javascript" src="assets/js/plugin/select2-4.0.0/js/select2.min.js"></script>
<link href="assets/js/plugin/select2-4.0.0/css/select2.css" rel="stylesheet">
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>Input <small>Pegawai</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active">Input pegawai</li>
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
							<a class="btn btn-default active" href="<?php echo $this->module?>add">
								<i class="fa fa-plus"></i> Input
							</a>	  
							<a class="btn btn-default" href="<?php echo $this->module?>add">
								<i class="fa fa-refresh"></i> Refresh
							</a>	
							</div>
						</div>
					</div>
				</div><!-- ./box-body -->
			</div>
			<!-- form start -->
			<?php
			$attributes = array('role' => 'form');

			echo form_open_multipart('admin/pegawai/insert', $attributes);
			?>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
						<legend style="background:#f2f2f2">&nbsp; <small>Profil Pegawai</small></legend>
						</div>
						
						<div class="col-md-6">
							<div style="position: relative;" id="imgcontainer">
								<label>Foto <span class="help-block" style="display:inline">(Max filesize: 200kb)</span></label>
								<div id="preview" style="width:200px; height:200px;" class="img-polaroid">
										<img class="img-circle" src="<?= base_url();?>assets/image/person.jpg" id="previewplay" width="98%">
								</div>
								<!--[ <a style="position: relative; z-index: 1;" href="" id="pickfiles">Browse</a> ]-->
								<div id="image_data" style="display:none">
							</div>
							<input id="imgInpPlay" type="file" name="file_name" />
							<p style="font-size:10px;" class="help-block">File : *.jpg, *.png, *.gif</p>
							</div>
							<!--<label>Nama Lengkap</label>
							<select class="form-control" id="js-data-example-ajax">
								<option >Nama / NIP</option>
							</select> <br>-->
							<label>Nama Lengkap</label>
							<input type="text" id="nama" name="nama" class="form-control" required placeholder="Nama Lengkap"/>
							<label>Tanggal lahir</label>
							<input type="text" id="datepicker2" name="tanggal_lahir_selector" class="form-control" required />
							<br>
						</div>

						<div class="col-md-6">
							<label>Tempat lahir</label>
							<input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required />
						</div>
						<div class="col-md-6">
							<label for="exampleInputEmail1">Email address</label>
							<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
						</div>
						
						
						<div class="col-md-6">
							<label>Jenis Kelamin</label>
							<div class="radio">
							<label>
							  <input name="jenis_kelamin" id="optionsRadios1" value="L" checked="" type="radio"> Laki-laki &nbsp;&nbsp;	&nbsp;						  
							</label>

							<label>
							  <input name="jenis_kelamin" id="optionsRadios1" value="P" type="radio"> Perempuan                                        
							</label>
							</div>	
						</div>
						<div class="col-md-6">
							<label>Alamat</label>
							<textarea name="alamat" id="alamat" rows="7" class="form-control required"></textarea>
							<span style="font-size:10px;" class="help-block">Contoh: Jalan Wijaya II/No. 23</span>    
						</div>
					</div>
					

					<div class="row">
						<div class="col-md-12">
							<legend style="background:#f2f2f2">&nbsp; <small>Data Pegawai</small></legend>
						</div>
						<div class="col-md-6">
							<label>Nomor Induk Pegawai</label>
							<input type="text" name="nip" class="form-control" required placeholder="NIP">
						</div>
						<div class="col-md-6">
							<label>Nomor SK. PPNS</label>
							<input type="text" name="skppns" class="form-control" placeholder="No. SK PPNS">
						</div>
						<div class="col-md-6">
							<label>Masa Berlaku Pegawai</label>
							<input id="datepicker4" name="berlaku_peg" class="form-control hasDatepicker" required="" type="text">
						</div>
						<div class="col-md-6">
							<label>No. KTP</label>
							<input type="text" id="no_ktp" name="no_ktp" class="form-control" placeholder="No. KTP" required />
						</div>
						<div class="col-md-6">
							<label>Masa Berlaku KTP</label>
							<input type="text" id="datepicker3" name="berlaku_ktp" class="form-control" required/>
						</div>
						<div class="col-md-6">
							<label>SKPD</label>
							<select name="skpd" required class="form-control">
								<option value=''>- Pilih SKPD -</option>
								<? foreach($m_skpd as $rows):
										if($skpd == ''){?>
											<option value="<?=$rows['nama'];?>"><?=$rows['nama'];?></option>
										<?}elseif($skpd != ''){
											if($skpd ==  $rows['nama']){?>
												<option selected value="<?=$rows['nama'];?>"><?=$rows['nama'];?></option>
											<?}
										}?>
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
							<input type="text" id="gelar_depan" name="gelar_depan" class="form-control" placeholder="Gelar Depan"/>
							<span style="font-size:10px;" class="help-block">Contoh: Drs., Ir. , H.</span>						
						</div>
						<div class="col-md-6">
							<label>Gelar Belakang</label>
							<input type="text" id="gelar_belakang" name="gelar_belakang" class="form-control" placeholder="Gelar Belakang" />
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
									if($prov == ''){
										echo "<option value=''>- Pilih Provinsi -</option>";
									}
									// $jsonData = file_get_contents($services_prov."?kode_wilayah=00");
									$jsonData = file_get_contents($services_prov."propinsi");
									$phpArray = json_decode($jsonData, true);
									foreach($phpArray as $rows){
										if($prov == $rows['kode_dagri']){
											echo "<option selected value='".$rows['kode_dagri']."'>$rows[nama_wilayah]</option>"; 
										}
										if($prov == ''){
											echo "<option value='".$rows['kode_dagri']."'>$rows[nama_wilayah]</option>"; 	  
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
									if($prov == '' && $kabupaten ==''){
										echo "<option value=''>- Pilih Kabupaten -</option>";
									}
									if($prov != '' && $kabupaten ==''){
										echo "<option value=''>- Pilih Kabupaten -</option>";	
									}
									if($prov != ''){
										// $jsonData = file_get_contents($services_prov."?kode_dagri=$prov");
										$jsonData = file_get_contents($services_prov."kabupaten/$prov");
										$phpArray = json_decode($jsonData, true);
										foreach($phpArray as $rowk):
											$kdkab = $rowk['kode_dagri'];  
											if($kdkab == $kabupaten){
												echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";											 
											}
											if($prov !='' && $kabupaten ==''){
												echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";	
											}
											endforeach;
									}
											
								?>
							</select>
							<span style="font-size:10px;" class="help-block">Tempat Personel Bekerja</span>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<label>UU Yang Dikawal</label>
							<input type="text" id="uu" name="uu" class="form-control" required />
						</div>
						<div class="col-md-6">
							<label>TMT Pegawai</label>
							<input type="text" id="datepicker" name="tmt_pegawai_masuk_selector" class="form-control" required />
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Status</label>
							<select name="status_pegawai" id='status_pegawai' class='form-control required'>
							<option value="">- Pilih Status Pegawai -</option>
							<option value="pns">PNS</option>
							<option value="ppns">PPNS</option>
							</select> 
						</div>
						<div class="col-md-6">
							<label>Pangkat/Golongan</label>
							<select name="pangkat" id='pangkat' class='form-control' required>
							<option value="">- Pilih Pangkat/Golongan -</option>
							<?php foreach($query_gol as $rowG):
								  echo "<option $selected value='".$rowG['keterangan']."'>".$rowG['keterangan']."</option>";  
							?>
							<?php endforeach;?> 
							</select> 
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<label>SK. Pangkat/Golongan</label>
							<input type="text" id="no_sk_pangkat" name="no_sk_pangkat" class="form-control required"  />       
						</div>
						<div class="col-md-6">
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
					</div>

					<div class="row">
						
						<div class="col-md-6">
							<label>Keterangan lain</label>
							<textarea name="keterangan" id="ket" rows="3" class="form-control "></textarea>   
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
<?//=loadFunction("select2");?>
<script>
function formatRepo (repo) {
    if (repo.loading) return repo.text;

    var markup = '<div class="clearfix">' +
    '<div clas="col-sm-12">' +
    '<div class="col-sm-4">' + repo.nip + '</div>' +
    '<div class="col-sm-5">' + repo.nama + '</div>' +
    '<div class="col-sm-3">' + repo.email + ' ' + repo.nip + '</div>' +
    '</div>';
    markup += '</div>';

    return markup;
  }

  function formatRepoSelection (repo) {
  	var pkt = repo.nama? repo.nama+' '+repo.skpd : '';
  	// $("#ttdnama").val(repo.NM_PERS);
  	// $("#ttdnrp").val(repo.NOPERS);
  	// $("#nopers2").val(repo.NRP);
  	// $("#ttdpkt").val(pkt || '');
  	// $("#ttdjab").val(repo.UR_JAB);
    return repo.nama || repo.text;
  }
$(function() {	
	//$("#frmcetak").attr("action",urlcetak);
	$("#js-data-example-ajax").select2({
	  ajax: {
		url: "admin/pegawai/search_personel",
		dataType: 'json',
		delay: 250,
		data: function (params) {
		  return {
			q: params.term, // search term
			page: params.page
		  };
		},
		processResults: function (data, page) {
		  // parse the results into the format expected by Select2.
		  // since we are using custom formatting functions we do not need to
		  // alter the remote JSON data
		  return {
			results: data.items
		  };
		},
		cache: true
	  },
	  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
	  minimumInputLength: 1,
	  templateResult: formatRepo, // omitted for brevity, see the source of this page
	  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	});
});
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
