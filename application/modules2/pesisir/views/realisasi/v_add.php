<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
?>
<?php
	$arr_jns_wikera	=	lookup("m_jenis","kode","uraian","status='1'"," order by idx");
	$arr_tahapan	=	lookup("m_tahapan","kode","uraian","status='1'"," order by idx");
	$arr_kawasan	=	lookup("m_kawasan","kode","uraian",""," order by idx");
	$arr_subject	=	array(1=>"Penerima",2=>"Individu",3=>"Kelompok");
	$arr_perhutanan	=	lookup("m_kategori_perhutanan","kode","uraian",""," order by idx");
	$arr_pppbm	=	lookup("m_kategori_pppbm","kode","uraian",""," order by idx");
	$arr_jns_hak	=	lookup("m_jenis_hak_pppbm","kode","uraian","status='1'"," order by idx");
	$arr_prmpuan	=	lookup("m_kelompok_perempuan","kode","uraian",""," order by idx");
?>
<script type="text/javascript" src="assets/js/maskF/my.js"></script>
<script type="text/javascript" src="assets/additional_js/maskMoney/dist/jquery.maskMoney.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>


<style>
.leaflet-top,
.leaflet-bottom {
	z-index: 499;
}
</style>

<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small>Tambah Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
    <li class="active">Tambah</li>
  </ol>
</section>
<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
        	<div class="box box-default">
                <div class="box-header with-border clearfix">
                	<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>add" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="Reset">
                        <i class="fa fa-circle-o"></i>
                    </a>	  
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <form id="frm" method="post" action="<?php echo $this->module;?>add" enctype="multipart/form-data">
                  <input type="hidden" name="act" id="act" value="create"/>
                  <div class="row">
                    <div class="col-md-6">
						<div class="row">
							<div class="col-md-6">
								<label for="alamat">Tanggal Input</label>
								<div class="input-group">
									<input type="hidden" id="tgl_input" name="tgl_input" value="<?=date('Y-m-d')?>" />
									<input type="text" id="tgl_input_selector" class="form-control" value="<?=date('d-m-Y')?>" required  />
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>	
								</div>
							</div> 
							<div class="col-md-6">
								<div class="form-group">
									<label for="kd_jenis_instansi">Nama Area Kelola</label>
									<input class="form-control required" name="nama_wikera" id="nama_wikera" type="text" value="<?php echo $data["nama_wikera"];?>" />
								</div>
							</div> 
						</div>
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="kd_jenis_instansi">Nama Kelompok Masyarakat</label>
									<input class="form-control required" name="nama_kelompok" id="nama_kelompok" type="text" value="<?php echo $data["nama_kelompok"];?>" />
								</div>
							</div>
							<div class="col-sm-6">
									<div class="form-group">
										<label for="nama">Jenis Wilayah Kelola</label>
										<? echo form_dropdown("kode_jns_wikera",$this->lookup_map_group,$data['kode_jns_wikera'],"id='kd_group' class='form-control'");?>
									</div>
								<!--Lama<div class="form-group">
									<label for="kd_jenis_instansi">Jenis Wilayah Kelola</label>
									<select name="kode_jns_wikera" class="form-control">
										<option value="">Pilih Jenis Wilayah Kelola</option>
										<?php if(cek_array($arr_jns_wikera)): ?>
											<?php foreach($arr_jns_wikera as $k=>$v): ?>
												<option value="<?=$k?>"><?=$v?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>-->
							</div>
						</div>
						
						<div class="row" id="row_kategori_perhutanan">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Kategori Perhutanan</label>
									<select name="kategori_perhutanan" id="kategori_perhutanan" class="form-control">
										<?php if(cek_array($arr_perhutanan)): ?>
											<option value=""></option>
											<?php foreach($arr_perhutanan as $k=>$v): ?>
												<option value="<?=$k?>"><?=$v?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6" id="row_kategori_pppbm">
								<div class="form-group">
									<label>Kategori PPPBM</label>
									<select name="kategori_pppbm" id="kategori_pppbm" class="form-control">
										<?php if(cek_array($arr_pppbm)): ?>
											<option value=""></option>
											<?php foreach($arr_pppbm as $k=>$v): ?>
												<option value="<?=$k?>"><?=$v?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
							<div class="form-group">
									<label for="kode_jenis_hak">Jenis Hak</label>
									<select name="kode_jenis_hak" class="form-control">
										<?php if(cek_array($arr_jns_hak)): ?>
											<?php foreach($arr_jns_hak as $k=>$v): ?>
												<option value="<?=$k?>"><?=$v?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								
								<!--
								</?php
									$arrPropinsi=m_lookup("propinsi2","kode_bps","nama");
									$arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
									$arrKab=array();
									if($data["kd_propinsi"]):
										$arrKab=m_lookup("kabupaten_kota","kode_bps","nama","kode_prop={$data["kd_propinsi"]} and kode_kab!='00'");
									endif;
								?>
								-->
								
								<?php
										
										/* <-- Addition Filter For Admin Filter --> */
										$arrKab=array();
										if($this->user_prop):
											
											if($this->user_kab):
												/* Apabila Admin adalah Admin/User Tingkat Kabupaten */
												$arrPropinsi=m_lookup("propinsi","kd_propinsi","nm_propinsi","kd_propinsi='".$this->user_prop."'");
												$arrPropinsi1=$arrPropinsi;
												
												$arrKab=m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$this->user_prop."' and kd_kabupaten='".$this->user_kab."' and kd_kabupaten!='00'");
												/* End */
												
												if($this->user_prop && $this->user_kab):
													$arrKec=array(""=>"--Pilih--")+m_lookup("kecamatan","KD_KECAMATAN","NM_KECAMATAN","kd_propinsi='".$this->user_prop."' and kd_kabupaten='".$this->user_kab."'");
												endif;
												
												$region_name	=	$arrPropinsi[$this->user_prop]." ".$arrKab[$this->user_prop.$this->user_kab];
												
											else:
												/* Apabila Admin adalah Admin/User Tingkat Propinsi */
												$arrPropinsi=m_lookup("propinsi","kd_propinsi","nm_propinsi","kd_propinsi='".$this->user_prop."'");
												$arrPropinsi1=$arrPropinsi;
												
												$arrKab=array(""=>"--Pilih--")+m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$this->user_prop."' and kd_kabupaten!='00'");
												
												$region_name	=	$arrPropinsi[$this->user_prop];
												
												/* End */
											endif;
											
											//pre($arrPropinsi);
											
										else:
											$arrPropinsi=m_lookup("propinsi","kd_propinsi","nm_propinsi");
											$arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
											if($data["kd_propinsi"]):
												$arrKab=array(""=>"--Pilih--")+m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$data['kd_propinsi']."' and kd_kabupaten!='00'");
											endif;
										endif;
										/* <-- End Addition Filter For Admin Filter --> */
										
								?>
								
								<div class="form-group">
									<label>Propinsi</label>
									<?=form_dropdown("kd_propinsi",$arrPropinsi1,$data["kd_propinsi"],"id='id_propinsi' class='form-control required'");?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Kabupaten</label>
									<div id="id_kabupaten_holder">
										<?=form_dropdown("kd_kabupaten",$arrKab,$data["kd_kabupaten"],"id='id_kabupaten' class='form-control required'");?>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Kecamatan</label>
									<div id="id_kecamatan_holder">
										<?=form_dropdown("kd_kecamatan",$arrKec,$data["kd_kecamatan"],"id='id_kecamatan' class='form-control'");?>
									</div>
								</div>
							</div>
						</div>
						<script>
								$(document).on('keydown', 'input[pattern]', function(e){
									var input = $(this);
									
									var oldVal = input.val();
								
									var regex = new RegExp(input.attr('pattern'), 'g');

								setTimeout(function(){
									var newVal = input.val();
									if(!regex.test(newVal)){
										
									input.val(oldVal); 
									}
								}, 0);
								});

								$("#my_field").blur(function() {
									this.value = parseFloat(this.value).toFixed(2);
									
								});
								$("#my_field2").blur(function() {
									this.value = parseFloat(this.value).toFixed(2);
									
								});
							</script>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Desa</label>
									<div class="pull-right">
										<label style="font-size:10px; color:#FF0000">*) Gunakanlah tanda koma (,) sebagai pemisah jika desa lebih dari satu</label>
									</div>
									<div id="id_desa">
										<textarea name="desa" class="form-control"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Luas Area Larang Ambil</label>
									<div class="pull-right">
										<label style="font-size:10px; color:#FF0000">*) Satuan Hektar (Ha), Ex: 1,123.45</label>
									</div>
									<div class="input-group">
										<input class="form-control" name='luas_larang' type="text" name="my_field" id="my_field" pattern="^\d*(\.\d{0,2})?$" value="<?php echo $data["luas"];?>"  />
										
										<input class="form-control" type="hidden" id="luas_larang" value="<?php echo $data["luas_larang"];?>" />
										<input class="form-control" name="luas_larangx" type="hidden" id="luas_trans" value="<?php echo $data["luas_larang"];?>" />
										<span class="input-group-addon">Ha</span>
									</div>
								</div> 
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Luas Area Kelola Masyarakat</label>
									<div class="pull-right">
										<label style="font-size:10px; color:#FF0000">*) Satuan Hektar (Ha), Ex: 1,123.45</label>
									</div>
									<div class="input-group">
										<input class="form-control" name='luas' type="text" name="my_field2" id="my_field2" pattern="^\d*(\.\d{0,2})?$" value="<?php echo $data["luas"];?>"  />   
										
										<input class="form-control" type="hidden" id="luas" value="<?php echo $data["luas"];?>" />
										<input class="form-control" name="luasx" type="hidden" id="luas_trans" value="<?php echo $data["luas"];?>" />
										<span class="input-group-addon">Ha</span>
									</div>
								</div> 
							</div> 
						</div>
						<div class="row">
							<div class="col-md-7">
									<label>Aturan Pengelolaan Perikanan dan Pesisir</label>
									<div class="pull-right">
										<label style="font-size:10px; color:#FF0000">*) Dapat memilih lebih dari satu</label>
									</div>
								<div class="form-group">
										<div class="col-md-6">
									<div class="input-group">
										<input type="checkbox" id="aturan_pengelolaan" name="aturan_pengelolaan[]" value="Tidak ada"> Tidak ada<br>
										<input type="checkbox" id="aturan_pengelolaan" name="aturan_pengelolaan[]" value="Ada aturan waktu"> Ada aturan waktu<br>
										<input type="checkbox" id="aturan_pengelolaan" name="aturan_pengelolaan[]" value="Ada aturan alat tangkap"> Ada aturan alat tangkap<br>
										<input type="checkbox" id="aturan_pengelolaan" name="aturan_pengelolaan[]" value="Ada aturan konservasi"> Ada aturan konservasi<br>
									</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
										<input type="checkbox" id="aturan_pengelolaan" name="aturan_pengelolaan[]" value="Ada aturan jenis"> Ada aturan jenis<br>
										<input type="checkbox" id="aturan_pengelolaan" name="aturan_pengelolaan[]" value="Ada aturan wilayah"> Ada aturan wilayah<br>
										<input type="checkbox" id="aturan_pengelolaan" name="aturan_pengelolaan[]" value="Ada aturan ukuran"> Ada aturan ukuran<br>
										<input type="checkbox" id="aturan_pengelolaan" name="aturan_pengelolaan[]" value="Ada aturan habitat"> Ada aturan habitat<br>
									</div>
								</div>
									</div>
								</div>
							</div>
						
						<div class="row"><br>
							<div class="col-sm-12">
								<div class="form-group">
									<label>Tahapan</label>
									<div id="id_tahapan">
										<select name="kode_tahapan" class="form-control">
											<option value="">Pilih Tahapan</option>
											<?php if(cek_array($arr_tahapan)): ?>
												<?php foreach($arr_tahapan as $k=>$v): ?>
													<option value="<?=$k?>"><?=$v?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row hidden">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Subject</label>
									<div id="subject">
										<select name="subject" class="form-control">
											<option value=""></option>
											<?php if(cek_array($arr_subject)): ?>
												<?php foreach($arr_subject as $k=>$v): ?>
													<option value="<?=$k?>"><?=$v?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Kawasan</label>
									<div id="kawasan">
										<select name="kawasan" class="form-control">
											<option value=""></option>
											<?php if(cek_array($arr_kawasan)): ?>
												<?php foreach($arr_kawasan as $k=>$v): ?>
													<option value="<?=$k?>"><?=$v?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row hidden">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Object</label>
									<div id="object">
										<input type="object" class="form-control" />
									</div>
								</div>
							</div>
						</div>
						
                    </div>
                    <!-- /.col -->
					<div class="col-md-6">
						<?=$this->load->view("map/v_view_spasial");?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group"><br>
									<label>Lampiran file Peta (Format: GEOJSON)</label>
									<input id="imgInpPlay" type="file" name="file_peta" class="form-control" style="padding:0; margin:-2px" />
									<textarea id="text" class="hidden form-control"><?=$data['the_geom']?></textarea>
								</div>
								</div>
							<div class="col-md-6">
								<div class="form-group"><br>
									<label>Status Validasi Peta</label>
									<select id="valid" name="status_validas_peta" required class="form-control">
										<option value="">Pilih Status</option>
										<option value="1">Valid</option>
										<option value="2">Tidak Valid</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								<div class="callout callout-info" style="margin-bottom:-10px;">
									<p align="justify">File Peta Spasial menggunakan Projection EPSG:4326, Dan Ukuran File Maksimal: 1.2M</p>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group"><br>
									<label>(X) Longitude</label>
									<input type="text" name="longitude" class="form-control" placeholder="koordinat -180 sampai 180" id="koordinat_lintang" />
									<label style="font-size:10px; color:#FF0000">*) koordinat -180 sampai 180 </label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group"><br>
									<label>(Y) Latitude</label>
									<input type="text" name="latitude" class="form-control" placeholder="koordinat -90 sampai 90" id="koordinat_bujur" />
									<label style="font-size:10px; color:#FF0000">*) koordinat -90 sampai 90 </label>
									<button id="btn_set_point" class="btn btn-white hidden" data-toggle='tooltip' title="set peta"><i class="fa fa-globe"></i> </button>
							
								</div>
							</div>
							
						</div>
						
					</div>
					<div class="col-md-12">
						<h4 class="heading">Jenis Aturan Perikanan dan Pengelolaan Pesisir</h4>
						<div class="row">
							<div class="col-md-6">
								<label for="alamat">Jenis Aturan</label> 
								<button id="ja-add" class=" pull-right" type="button" style="margin-bottom:3px;"><i class="fa fa-plus"></i></button>
								<div id="jenis_aturan">
									<div class="row">
										<div class="col-md-11" style="margin-bottom:2px;">
											<div style="position:relative">
												<div class="row">
													<div class="col-sm-6">
														<select id="valid" name="jenis_aturan[]" required class="form-control">
															<option value="">Pilih Jenis Aturan</option>
															<option value="Peraturan adat">Peraturan adat</option>
															<option value="Peraturan kelompok">Peraturan kelompok</option>
															<option value="Peraturan desa">Peraturan desa</option>
														</select>
													</div>
													<div class="col-sm-6">
														<input type="file" name="lampiran[]" />
														<span style="font-size:11px;"><strong>*) Note : File Maksimal 5mb</strong></span>
													</div>
												</div>
											</div>
										</div>
										<span class="btn btn-sm ja-remove" style="right:0px; top:0px"><i class="fa fa-trash"></i></span>
									</div>	
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<h4 class="heading">Surat Keputusan/Legalitas/Status</h4>
						<div class="row">
							<div class="col-md-12">
								<label for="alamat">Surat Keputusan</label> 
								<button id="du-add" class=" pull-right" type="button" style="margin-bottom:3px;"><i class="fa fa-plus"></i></button>
								<div id="detil_urusan">
									<div class="row">
										<div class="col-md-11" style="margin-bottom:2px;">
											<div style="position:relative">
												<div class="row">
													<div class="col-sm-3">
														<select id="valid" name="jenis_surat[]" required class="form-control">
															<option value="">Pilih Jenis Surat Keputusan</option>
															<option value="SK Gubernur">SK Gubernur</option>
															<option value="SK Kabupaten">SK Kabupaten</option>
															<option value="SK Kadis">SK Kadis</option>
															<option value="Kemitraan">Kemitraan</option>
														</select>
													</div>
													<div class="col-sm-2">
														<input type="text" name="no_sk[]" class="form-control" placeholder="No Surat Keputusan" />
													</div>
													<div class="col-sm-3">
														<input type="text" name="tentang[]" class="form-control" placeholder="Tentang" />
													</div>
													<div class="col-sm-2">
														<input type="text" name="tahun[]" class="form-control" placeholder="Tahun" />
													</div>
													<div class="col-sm-2">
														<input type="file" name="lampiran[]" />
														<span style="font-size:11px;"><strong>*) Note : File Maksimal 5mb</strong></span>
													</div>
												</div>
												
											</div>
										</div>
										<span class="btn btn-sm du-remove" style="right:0px; top:0px"><i class="fa fa-trash"></i></span>
									</div>	
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						
						<div class="row">
							<div class="col-md-6">
								<h4 class="heading">Konten</h4>
								<div class="form-group">
									<label for="alamat">Profil</label>
									<textarea class="input-xs form-control" id="klip" rows="2" name="clip" placeholder=""><?=$data["clip"]?></textarea>
								</div> 
								<div class="form-group">
									<label for="category">Deskripsi</label>
									<textarea class="input-xs form-control" id="deksripsi" rows="4" name="deskripsi" placeholder=""><?=$data["deskripsi"]?></textarea>
								</div>
								<div class="form-group">
									<label>Keterlibatan Kelompok Perempuan</label>
									<select name="Keterlibatan_perempuan" id="Keterlibatan_perempuan" class="form-control">
										<?php if(cek_array($arr_prmpuan)): ?>
											<option value="">Tidak Ada</option>
											<?php foreach($arr_prmpuan as $k=>$v): ?>
												<option value="<?=$k?>"><?=$v?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
								<!-- <div class="form-group">
									<label>Sumber Data</label>
									<input class="form-control required" name="sumber_data" type="text" id="sumber" value="<?php echo $data["sumber_data"];?>" />
								</div> -->
							</div>
							<div class="col-md-6">	
								
								<h4 class="heading">Data Mitra/Pendukung</h4>
								<div class="form-group">
									<label for="alamat">Nama Mitra</label>
									<input type="text" name="nama_mitra" class="form-control" />
								</div> 
								
								<div class="form-group">
									<label for="alamat">Email</label>
									<input type="text" name="email_mitra" id="email_mitra" class="form-control" />
								</div> 
								
								<div class="form-group">
									<label for="alamat">No Telepon</label>
									<input type="text" name="no_telepon_mitra" class="form-control" />
								</div> 
								
								<div class="form-group">
									<label for="alamat">Alamat</label>
									<textarea class="form-control" name="alamat_mitra" rows="2"></textarea>
								</div> 
								
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<h4 class="heading">Data Pendukung</h4>
						<div class="row">
							<div class="col-sm-12">
								<?=$this->load->view("v_lampiran");?> 
							</div>
						</div>
					</div>
					
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                </form>
                <!-- /.box-body -->
				
              </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
	$("#row_kategori_pppbm").hide();
	$("#kd_group").on("change",function(){
		var value	=	$(this).val();
									
		if(value=="PPPBM"){
			$("#row_kategori_pppbm").show();
		}else{
			$("#row_kategori_pppbm").hide();
			$("#kategori_pppbm").val("");
		}
	});
});
</script>
<script>
$(document).ready(function(){
	$("#row_kategori_perhutanan").hide();
	$("#kd_group").on("change",function(){
		var value	=	$(this).val();
									
		if(value=="PIAPS"){
			$("#row_kategori_perhutanan").show();
		}else{
			$("#row_kategori_perhutanan").hide();
			$("#kategori_perhutanan").val("");
		}
	});
});
</script>

<script>
$(document).ready(function(){
    $("#koordinat_bujur,#koordinat_lintang").blur(function(){
		var x = $("#koordinat_lintang").val();
		var y = $("#koordinat_bujur").val();
		if (x && y) {
			if (x>=-180 && x<=180 && y>=-90 && y<=90) {
				$("#btn_set_point").trigger("click");	
			}
		}
	});
    $("#btn_set_point").click(function(e){
		e.preventDefault();
		var latitude=$("#koordinat_bujur").val()*1;
		var longitude=$("#koordinat_lintang").val()*1; 
		setCoordx(longitude,latitude);
			
	});
    $("#email_mitra").on("blur",function(){
        var email_validation    =   new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
        var email_val           =   $(this).val();
       
        if(!email_validation.test(email_val)){
            $(this).val("");
            new PNotify({
                title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                text    :   'Format Email Salah',
                hide    :   true
            });
        }
       
    });
    
})
</script>

<script>

$(document).ready(function(){
	
	$("#luas").on("blur",function(){
		
		var value		=	$(this).val();
		
		var rem_number	=	RemoveComas(value);

		var new_value	=	ReplaceNumberWithCommas(rem_number);
		
		var save_value	=	RemoveComas(value);

		$(this).val(new_value);
		$("#luas_trans").val(save_value);
	
	});
	
	function ReplaceNumberWithCommas(yourNumber) {
		//Seperates the components of the number
		var components	=	yourNumber.toString().split(".");
		//Comma-fies the first part
		components[0]	=	components[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		//Combines the two sections
		
		return components.join(".");
	}
	
	function RemoveComas(num){
		
		var rem_num	=	num.replace(/\,/g,"");
		
		return rem_num;
		
	}
	
});

</script>

<script type="text/javascript">
$(function() {
	tanggal = $('#tgl_kejadian_selector').datepicker({
	format:"dd-mm-yyyy"
	}).on('changeDate', function(ev){
		var newDate = new Date(ev.date);
		$("#tgl_kejadian").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
		$('#tgl_kejadian_selector').datepicker('hide');
	}).data('datepicker');
	
	tanggal_input = $('#tgl_input_selector').datepicker({
	format:"dd-mm-yyyy"
	}).on('changeDate', function(ev){
		var newDate = new Date(ev.date);
		$("#tgl_input").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
		$('#tgl_input_selector').datepicker('hide');
	}).data('datepicker');
	
	$("#status_konflik_proses").prop("disabled", true);
	$('#status_konflik').on('change', function() {
	  var n = $("#status_konflik").val();
	  $("#status_konflik_proses").val('');
	  if ( n == 'PS'){
		$("#status_konflik_proses").prop("disabled", false);
	  }else{
		$("#status_konflik_proses").prop("disabled", true);
	  }
	});
});
</script>
<script>
function readText(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
		   var text = reader.result;
		   $('#text').val(text);
;
		   deserialize(text);
		}
		reader.readAsText(input.files[0]);
	}
}   
$("#imgInpPlay").change(function(){
	readText(this);
});
</script>
<script type="text/javascript" charset="utf-8">
	function fnHitung() {
		var angka = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('inputku').value)))); //input ke dalam angka tanpa titik
		if (document.getElementById('inputku').value == "") {
			alert("Jangan Dikosongi");
			document.getElementById('inputku').focus();
			return false;
		}else if (angka >= 1) {
			document.getElementById('inputku').focus();
			document.getElementById('inputku').value = tandaPemisahTitik(angka);
			return false; 
		}
	}
</script>
<script>
	$(function(){
		$("#du-add").click(function(){
			var length = $(".du-item").length;
			var new_el = '<div class="row"><div class="col-md-11" style="margin-bottom:2px"><div style="position:relative"><div class="row"><div class="col-sm-3"><select id="valid" name="jenis_surat[]" required class="form-control"><option value="">Pilih Jenis Surat Keputusan</option><option value="SK Gubernur">SK Gubernur</option><option value="SK Kabupaten">SK Kabupaten</option><option value="SK Kadis">SK Kadis</option><option value="Kemitraan">Kemitraan</option></select></div><div class="col-sm-2"><input type="text" name="no_sk[]" class="form-control" placeholder="No Surat Keputusan"></div><div class="col-sm-3"><input type="text" name="tentang[]" class="form-control" placeholder="Tentang"></div><div class="col-sm-2"><input type="text" name="tahun[]" class="form-control" placeholder="Tahun"></div><div class="col-sm-2"><input type="file" name="lampiran[]"><span style="font-size:11px"><strong>*) Note : File Maksimal 5mb</strong></span></div></div></div></div><span class="btn btn-sm du-remove" style="right:0;top:0"><i class="fa fa-trash"></i></span></div>';
						 
			if (length<50) {
				$("#detil_urusan").append(new_el);
				$("#jml_urusan").val(length+1)
				}
		});
		$(document).on("click",".du-remove",function(){
			$(this).parent().remove();
				var length = $("#detil_urusan").length;
				$("#jml_urusan").val(length)
			});
		
		
		$("#du-add2").click(function(){
			var length = $(".du-item2").length;
				var new_el2 = '<div class="row"><div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="du-item2 form-control" name="keterangan2[]" placeholder=""></div></div><span class="btn btn-sm du-remove2" style="right:0px; top:0px"><i class="fa fa-trash"></i></span></div>'; 
						 
			if (length<50) {
				$("#detil_urusan2").append(new_el2);
				$("#jml_urusan").val(length+1)
				}
		});
		$(document).on("click",".du-remove2",function(){
			$(this).parent().remove();
				var length = $("#detil_urusan2").length;
				$("#jml_urusan").val(length)
			});
			
		$("#du-add3").click(function(){
			var length = $(".du-item3").length;
				var new_el2 = '<div class="row"><div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="du-item3 form-control" name="keterangan3[]" placeholder=""></div></div><span class="btn btn-sm du-remove3" style="right:0px; top:0px"><i class="fa fa-trash"></i></span></div>'; 
						 
			if (length<50) {
				$("#detil_urusan3").append(new_el2);
				$("#jml_urusan").val(length+1)
				}
		});
		$(document).on("click",".du-remove3",function(){
			$(this).parent().remove();
				var length = $("#detil_urusan3").length;
				$("#jml_urusan").val(length)
			});
	});
</script>

<script>
	$(function(){
		$("#ja-add").click(function(){
			var length = $(".ja-item").length;
			var new_el = '<div class="row"><div class="col-md-11" style="margin-bottom:2px"><div style="position:relative"><div class="row"><div class="col-sm-6"><select id="valid" name="jenis_aturan[]" required class="form-control"><option value="">Pilih Jenis Aturan</option><option value="Peraturan adat">Peraturan adat</option><option value="Peraturan kelompok">Peraturan kelompok</option><option value="Peraturan desa">Peraturan desa</option></select></div><div class="col-sm-6"><input type="file" name="lampiran[]"><span style="font-size:11px"><strong>*) Note : File Maksimal 5mb</strong></span></div></div></div></div><span class="btn btn-sm ja-remove" style="right:0;top:0"><i class="fa fa-trash"></i></span></div>';
						 
			if (length<50) {
				$("#jenis_aturan").append(new_el);
				$("#jml_aturan").val(length+1)
				}
		});
		$(document).on("click",".ja-remove",function(){
			$(this).parent().remove();
				var length = $("#jenis_aturan").length;
				$("#jml_aturan").val(length)
			});
		
		
		$("#ja-add2").click(function(){
			var length = $(".ja-item2").length;
				var new_el2 = '<div class="row"><div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="ja-item2 form-control" name="keterangan2[]" placeholder=""></div></div><span class="btn btn-sm ja-remove2" style="right:0px; top:0px"><i class="fa fa-trash"></i></span></div>'; 
						 
			if (length<50) {
				$("#jenis_aturan").append(new_el2);
				$("#jml_aturan").val(length+1)
				}
		});
		$(document).on("click",".ja-remove2",function(){
			$(this).parent().remove();
				var length = $("#jenis_aturan").length;
				$("#jml_aturan").val(length)
			});
			
		$("#ja-add3").click(function(){
			var length = $(".ja-item3").length;
				var new_el2 = '<div class="row"><div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="ja-item3 form-control" name="keterangan3[]" placeholder=""></div></div><span class="btn btn-sm ja-remove3" style="right:0px; top:0px"><i class="fa fa-trash"></i></span></div>'; 
						 
			if (length<50) {
				$("#jenis_aturan3").append(new_el2);
				$("#jml_aturan").val(length+1)
				}
		});
		$(document).on("click",".ja-remove3",function(){
			$(this).parent().remove();
				var length = $("#jenis_aturan3").length;
				$("#jml_aturan").val(length)
			});
	});
</script>


<script>
$(document).ready(function(){
	$("#investasi").maskMoney({prefix:'Rp ', allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
	$("#dampak").maskMoney({suffix:' Jiwa', allowNegative: false, thousands:'.',decimal:',',precision:'0', affixesStay: false});
	//$("#luas").maskMoney({suffix:' Ha',allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
});
</script>

<script language="javascript">

$(function(){
	
	<?php if($this->user_prop): ?>
		<?php if($this->user_kab): ?>
			geoCode('<?=$region_name?>',10);
		<?php else: ?>
			geoCode('<?=$region_name?>',7);
		<?php endif; ?>
	<?php endif; ?>
	
	$("#id_propinsi").select2({'placeholder':"--Pilih Propinsi--"});
	$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	$("#id_kecamatan").select2({'placeholder':"--Pilih Kecamatan--"});
	
	$("#konflik").select2();
	
	$("#id_propinsi").change(function(){
   		var id_propinsi = $(this).val();
		var nm_propinsi = $("#id_propinsi option:selected").text();
		
		geoCode(nm_propinsi);
		
		$("#id_kabupaten_holder").load("<?=$this->module;?>get_kab_kota/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
			
			$("#id_kabupaten").on("change",function(){
				var id_kabupaten	=	$("#id_kabupaten").val();
				var nm_address1 = nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				geoCode(nm_address1);
				
				$("#id_kecamatan_holder").load("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/?time="+new Date().getTime(),function(){
					$("#id_kecamatan").select2({'placeholder':"--Pilih Kecamatan--"});
					
					$("#id_kecamatan").on("change",function(){
						
						var nm_address2 = nm_address1+" "+$("#id_kecamatan option:selected").text();
						geoCode(nm_address2);
						
					});
					
				});
			});
			
		});

		$("#id_kecamatan_holder").load("<?=$this->module;?>get_kecamatan/0000/?time="+new Date().getTime(),function(){
			$("#id_kecamatan").select2({'placeholder':"--Pilih Kecamatan--"});
		});
		
    });
	
	$("#id_kabupaten").on("change",function(){
		var id_kabupaten	=	$("#id_kabupaten").val();
		var nm_propinsi = $("#id_propinsi option:selected").text();
		var nm_address1 = nm_propinsi+" "+$("#id_kabupaten option:selected").text();
		geoCode(nm_address1);
				
		$("#id_kecamatan_holder").load("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/?time="+new Date().getTime(),function(){
			$("#id_kecamatan").select2({'placeholder':"--Pilih Kecamatan--"});
			
			$("#id_kecamatan").on("change",function(){
						
				var nm_address2 = nm_address1+" "+$("#id_kecamatan option:selected").text();
				geoCode(nm_address2);
						
			});
			
		});
	});
	
});

$(document).ready(function(){      
	$('#prov').change(function(){
		$.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
			$('#kab').html(obj);
		});
    });
	$("#previewplay").click(function(){
		$("#imgInpPlay").trigger("click");
	});
});

</script>
<script>
	$(function(){
		$("#frm").validate();
		
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
		
		$(".group").click(function(){
			//$("#company").prop("disabled",$(this).data('org')==1 ? false: true);
			var use_org = $(this).data('org');
			$("#company").val(use_org);
			$("#company option").show();
			$("#company option").each(function(){
				if (!use_org) {
					$(this).val()!=0?$(this).hide():$(this).show();
				}
				else {
					$(this).val()!=0?$(this).show():$(this).hide();
				}
			});
		});
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		  checkboxClass: 'icheckbox_flat-green',
		  radioClass: 'iradio_flat-green'
		});
	})
</script>

<!--
<script>
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
		
        reader.onload = function (e) {
            $('#attachment').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
	
	if(this.files[0].size>500000){
		alert("Ukuran Foto Melebihi 500 kb");
	}else{
		readURL(this);
	}
	
});
</script>
-->

<script>
<?php for($i=1; $i<4; $i++): ?>
document.getElementById("imgInp<?=$i?>").onchange = function () {
    var reader = new FileReader();

    reader.onload = function (e) {
        // get loaded data and render thumbnail.
        document.getElementById("attachment<?=$i?>").src = e.target.result;
    };

    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
};
<?php endfor; ?>
</script>
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
$(document).ready(function(){
	$("#imgInp1").on("change",function(){
		var val1	=	$(this).val();
		
		$("#foto1").val(val1);
	});
	
	$("#imgInp2").on("change",function(){
		var val2	=	$(this).val();
		
		$("#foto2").val(val2);
	});
	
	$("#imgInp3").on("change",function(){
		var val3	=	$(this).val();
		
		$("#foto3").val(val3);
	});
});
</script>
