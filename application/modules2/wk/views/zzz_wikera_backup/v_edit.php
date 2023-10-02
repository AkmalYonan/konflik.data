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
?>

<script type="text/javascript" src="assets/js/maskF/my.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script type="text/javascript" src="assets/additional_js/maskMoney/dist/jquery.maskMoney.min.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>

<link rel="stylesheet" href="assets/js/additional_js/pnotify/pnotify.custom.min.css">
<script src="assets/js/additional_js/pnotify/pnotify.custom.min.js"></script>
<script src="assets/js/additional_js/fileupload/ajaxfileupload.js"></script>
<!--<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.openstreetmap.js"></script>-->

<style>
.leaflet-top,
.leaflet-bottom {
	z-index: 499;
}
</style>

<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small>Edit Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
    <li class="active">Edit</li>
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
                    <a class="btn btn-white" href="<?php echo $this->module?>edit/<?=encrypt($data['idx'])?>" data-toggle='tooltip' title="Refresh">
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
                <form id="frm" method="post" action="<?php echo $this->module;?>edit" enctype="multipart/form-data">
                  <input type="hidden" name="act" id="act" value="update"/>
				  <input type="hidden" name="idx" id="idx" value="<?=$data['idx']?>"/>
                  <div class="row">
                    <div class="col-md-6">
                    	<div class="row">
							<div class="col-md-6">
								<label for="alamat">Tanggal Kejadian</label>
								<div class="input-group">
									<input type="hidden" id="tgl_kejadian" name="tgl_kejadian" value="<?=date_format(date_create($data['tgl_kejadian']),"Y-m-d")?>" />
									<input type="text" id="tgl_kejadian_selector" class="form-control" value="<?=date_format(date_create($data['tgl_kejadian']),"d-m-Y")?>" required  />
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>	
								</div>
							</div> 
						</div>
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="kd_jenis_instansi">Nama Wilayah Kelola</label>
									<input class="form-control required" name="nama_wikera" id="nama_wikera" type="text" value="<?php echo $data["nama_wikera"];?>" />
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
										<label for="nama">Jenis Wilayah Kelola</label>
										<? echo form_dropdown("kode_jns_wikera",$this->lookup_map_group,$data['kode_jns_wikera'],"id='kd_group' class='form-control'");?>
									</div>
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
												<option value="<?=$k?>" <?=($k==$data['kategori_perhutanan'])?"selected":""?>><?=$v?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
						</div>
						
						
						<div class="row">
							<div class="col-md-6">
								<?php
									
									
									$arrKab=array();
									if($this->user_prop):
											
										if($this->user_kab):
											/* Apabila Admin adalah Admin/User Tingkat Kabupaten */
											$arrPropinsi=m_lookup("propinsi","kd_propinsi","nm_propinsi","kd_propinsi='".$this->user_prop."'");
											$arrPropinsi1=$arrPropinsi;
												
											$arrKab=m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$this->user_prop."' and kd_kabupaten='".$this->user_kab."' and kd_kabupaten!='00'");
												
											$arrKec=array();
											
											if($this->user_prop and $this->user_kab):											
												$arrKec	=	m_lookup("kecamatan","KD_KECAMATAN","NM_KECAMATAN","KD_PROPINSI={$this->user_prop} and KD_KABUPATEN={$this->user_kab}");
											endif;
											
											/* End */
										else:
											/* Apabila Admin adalah Admin/User Tingkat Propinsi */
											$arrPropinsi=m_lookup("propinsi","kd_propinsi","nm_propinsi","kd_propinsi='".$this->user_prop."'");
											$arrPropinsi1=$arrPropinsi;
												
											$arrKab=array(""=>"--Pilih--")+m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$this->user_prop."' and kd_kabupaten!='00'");
												
											$arrKec=array();
									
											if($this->user_prop):
												
												$kd_kab	=	substr($data["kd_kabupaten"],2,2);
											
												$arrKec	=	m_lookup("kecamatan","KD_KECAMATAN","NM_KECAMATAN","KD_PROPINSI='".$data["kd_propinsi"]."' and KD_KABUPATEN='".$kd_kab."'");
											endif;
											
											/* End */
										endif;
										
										
									else:
										$arrPropinsi=m_lookup("propinsi","kd_propinsi","nm_propinsi");
										$arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
										$arrKab=array();
										if($data["kd_propinsi"]):
											$arrKab=array(""=>"--Pilih--")+m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$data['kd_propinsi']."' and kd_kabupaten!='00'");
										endif;
										
										$arrKec=array();
										
										if($data["kd_propinsi"] and $data["kd_kabupaten"]):
											
											$kd_kab	=	substr($data["kd_kabupaten"],2,2);
											
											$arrKec	=	m_lookup("kecamatan","KD_KECAMATAN","NM_KECAMATAN","KD_PROPINSI='".$data["kd_propinsi"]."' and KD_KABUPATEN='".$kd_kab."'");
										endif;
									endif;
										
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
										<?=form_dropdown("kd_kabupaten",$arrKab,$data["kd_kabupaten"],"id='id_kabupaten' class='form-control'");?>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Kecamatan <?=$data["kd_kecamatan"];?> </label>
									<div id="id_kecamatan_holder">
										<?=form_dropdown("kd_kecamatan",$arrKec,$data["kd_kecamatan"],"id='id_kecamatan' class='form-control'");?>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Luas</label>
									<div class="pull-right">
										<label style="font-size:10px; color:#FF0000">*) Satuan Hektar (Ha), Ex: 1,123.45</label>
									</div>
									<div class="input-group">	
										<input class="form-control" type="text" id="luas" />
										<input class="form-control" name="luas" type="hidden" id="luas_trans" value="<?php echo $data['luas']; ?>" />
										<span class="input-group-addon">Ha</span>
									</div>
								</div> 
							</div> 
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Desa</label>
									<div class="pull-right">
										<label style="font-size:10px; color:#FF0000">*) Gunakanlah tanda koma (,) sebagai pemisah jika desa lebih dari satu</label>
									</div>
									<div id="id_desa">
										<textarea name="desa" class="form-control"><?=$data['desa']?></textarea>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Tahapan</label>
									<div id="id_tahapan">
										<select name="kode_tahapan" class="form-control">
											<option value="">Pilih Tahapan</option>
											<?php if(cek_array($arr_tahapan)): ?>
												<?php foreach($arr_tahapan as $k=>$v): ?>
													<option value="<?=$k?>" <?=($k==$data['kode_tahapan'])?"selected":""?>><?=$v?></option>
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
													<option value="<?=$k?>" <?=($k==$data['subject'])?"selected":""?>><?=$v?></option>
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
													<option value="<?=$k?>" <?=($k==$data['kawasan'])?"selected":""?>><?=$v?></option>
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
										<input type="object" class="form-control" value="<?=$data['object']?>" />
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
									<textarea id="text" class="hidden form-control"><?=$data['geo']?></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Status Validasi Peta</label>
									<select name="status_validas_peta" required class="form-control">
										<option value="">Pilih Status</option>
										<option value="1" <?=($data['status_validas_peta']==1)?"selected":""?>>Valid</option>
										<option value="2" <?=($data['status_validas_peta']==2)?"selected":""?>>Tidak Valid</option>
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
									<input type="text" name="longitude" class="form-control" placeholder="koordinat -180 sampai 180" value="<?=$data['longitude']?>" id="koordinat_lintang" />
									<label style="font-size:10px; color:#FF0000">*) koordinat -180 sampai 180 </label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group"><br>
									<label>(Y) Latitude</label>
									<input type="text" name="latitude" class="form-control" placeholder="koordinat -90 sampai 90" value="<?=$data['latitude']?>" id="koordinat_bujur" />
									<label style="font-size:10px; color:#FF0000">*) koordinat -90 sampai 90 </label>
									<button id="btn_set_point" class="btn btn-white hidden" data-toggle='tooltip' title="set peta"><i class="fa fa-globe"></i> </button>
							
								</div>
							</div>
						</div>
                
					</div>
					
					<div class="col-md-12">
						<h4 class="heading">Surat Keputusan</h4>
						
						<div class="row">
							<div class="col-sm-12 table-responsive">
								<?php if(cek_array($perda)): ?>
									<strong>Surat Keputusan Tersimpan Tersimpan</strong>
									<table class="table table-condensed table-striped">
										<?php foreach($perda as $k=>$v): ?>
											<tr id="sk_<?=$v['idx']?>">
												<td id="data_sk_<?=$v['idx']?>">Surat Keputusan <?=$v['nomor']?> Tentang <?=$v['tentang']?> Tahun <?=$v['tahun']?></td>
												<td id="lampiran_sk_<?=$v['idx']?>">
													
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
												<td width="150">
													<a class="btn btn-success btn-xs edit_sk" data-idx="<?=$v['idx']?>">
														<i class="fa fa-pencil">&nbsp;</i>Edit
													</a>
													<a class="btn btn-danger btn-xs del_sk" data-idx="<?=$v['idx']?>">
														<i class="fa fa-trash">&nbsp;</i>Delete
													</a>
												</td>
											</tr>
										<?php endforeach; ?>
									</table>
								<?php endif; ?>
							</div>
						</div>
						
						<hr />
						
						<div class="row">
							<div class="col-md-12">
								<label for="alamat">Tambah Surat Keputusan</label> 
								<button id="du-add" class=" pull-right" type="button" style="margin-bottom:3px;"><i class="fa fa-plus"></i></button>
								<div id="detil_urusan">
				 
									<div class="row">
										<div class="col-md-11" style="margin-bottom:2px;">
											<div style="position:relative">
											
												<div class="row">
													<div class="col-sm-3">
														<input type="text" name="no_sk[]" class="form-control" placeholder="No Surat Keputusan" />
													</div>
													<div class="col-sm-4">
														<input type="text" name="tentang[]" class="form-control" placeholder="Tentang" />
													</div>
													<div class="col-sm-2">
														<input type="text" name="tahun[]" class="form-control" placeholder="Tahun" />
													</div>
													<div class="col-sm-3">
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
								<h4 class="heading">Deskripsi</h4>
								<div class="form-group">
									<label for="alamat">Profil</label>
									<textarea class="input-xs form-control" id="klip" rows="2" name="clip" placeholder=""><?=$data["clip"]?></textarea>
								</div> 
								<div class="form-group">
									<label for="category">Deskripsi</label>
									<textarea class="input-xs form-control" id="deksripsi" rows="4" name="deskripsi" placeholder=""><?=$data["deskripsi"]?></textarea>
								</div>
								<div class="form-group">
									<label>Sumber Data</label>
									<input class="form-control required" name="sumber_data" type="text" id="sumber" value="<?php echo $data["sumber_data"];?>" />
								</div>
							</div>
							<div class="col-md-6">	
								
								<h4 class="heading">Data Mitra/Pendukung</h4>
								<div class="form-group">
									<label for="alamat">Nama Mitra</label>
									<input type="text" name="nama_mitra" class="form-control" value="<?=$mitra['nama']?>" />
								</div> 
								
								<div class="form-group">
									<label for="alamat">Email</label>
									<input type="text" name="email_mitra" id="email_mitra" class="form-control" value="<?=$mitra['email']?>" />
								</div> 
								
								<div class="form-group">
									<label for="alamat">No Telepon</label>
									<input type="text" name="no_telepon_mitra" class="form-control" value="<?=$mitra['no_telepon']?>" />
								</div> 
								
								<div class="form-group">
									<label for="alamat">Alamat</label>
									<textarea class="form-control" name="alamat_mitra" rows="2"><?=$mitra['alamat']?></textarea>
								</div> 
								
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<h4 class="heading">LAMPIRAN</h4>
						
						<?php if(cek_array($file)): ?>
						<div class="row">
							<div class="col-sm-12 table-responsive">
								<?php if(cek_array($file)): ?>
									<strong>Lampiran Tersimpan</strong>
									<table class="table table-striped">
										<thead>
											<tr>
												<th>Lampiran</th>
												<th>Tipe</th>
												<th width="250">Lihat Lampiran</th>
												<th width="200"></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($file as $kf=>$vf): ?>
											<tr id="tr_<?=$vf['id']?>">
												<td id="nama_<?=$vf['id']?>"><?=$vf['lampiran_name']?></td>
												<td id="tipe_<?=$vf['id']?>">
													<?php
														if($vf['lampiran_type']==1):
															echo "Private";
														else:
															echo "Public";
														endif;
													?>
												</td>
												<td align="center">
													<a href="<?=$vf['file_path']?>" target="_blank">
														<i class="fa fa-search">&nbsp;</i>View File
													</a>
												</td>
												<td>
													<a class="btn btn-success btn-xs edit_file" data-idx="<?=$vf['id']?>">
														<i class="fa fa-pencil">&nbsp;</i>Edit Attribute
													</a>
													<a class="btn btn-danger btn-xs del_file" data-idx="<?=$vf['id']?>">
														<i class="fa fa-trash">&nbsp;</i>Delete File
													</a>
												</td>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								<?php endif; ?>
							</div>
						</div>
						<hr />
						<?php endif; ?>
						
						<div class="row">
							<div class="col-sm-12 table-responsive">
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
    
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-pencil">&nbsp;</i>Ubah Data Lampiran</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label>Nama Lampiran</label>
							<input type="hidden" id="id_lampiran" class="form-control" />
							<input type="text" id="ubah_nama_lampiran" class="form-control" />
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Tipe Lampiran</label>
							<select id="ubah_tipe_lampiran" class="form-control" style="width:50%">
								<option value="1">Private</option>
								<option value="2">Public</option>
							</select>
						</div>
					</div>
					<!--
					<div class="col-sm-12">
						<div class="form-group">
							<label>Lampiran</label>
							<input type="file" name="ubah_lampiran" id="ubah_lampiran" />
						</div>
					</div>
					-->
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary ubah_data_submit">Simpan</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<!-- Modal -->
<div id="skModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-pencil">&nbsp;</i>Ubah Data Surat Keputusan</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label>Nomor</label>
							<input type="hidden" id="id_sk" class="form-control" />
							<input type="text" id="ubah_nomor_sk" class="form-control" />
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Tentang</label>
							<input type="text" id="ubah_tentang_sk" class="form-control" />
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Tahun</label>
							<input type="text" id="ubah_tahun_sk" class="form-control" style="width:35%" />
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Lampiran</label>
							<input type="file" id="ubah_lampiran_sk" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary ubah_sk_submit">Simpan</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

</section>

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
	var kode_jns_wikera	=	"<?=$data['kode_jns_wikera']?>";
	
	if(kode_jns_wikera=="PIAPS"){
		$("#row_kategori_perhutanan").show();
	}else{
		$("#row_kategori_perhutanan").hide();
		$("#kategori_perhutanan").val("");
	}
	
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
	
	var init_luas		=	ReplaceNumberWithCommas('<?=$data['luas']?>');
	
	$("#luas").val(init_luas);
	
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

<script>
$(document).ready(function(){
	
	$("#ubah_lampiran_sk").on("change",function(){
		
		var url			=	"<?=$this->module?>ubah_lampiran_sk";
		var file_data	=	$('#ubah_lampiran_sk').prop('files')[0];
        var form_data	=	new FormData();
		var idx			=	$("#id_sk").val();
		form_data.append('idx', idx);
		form_data.append('file', file_data);
		

		$.ajax({
			
			url			:	url,
            cache		:	false,
            contentType	: 	false,
            processData	: 	false,
			type		:	"POST",
			data		:	form_data,
			dataType	:	"JSON",
			success		:	function(result){
				
				if(result.hasil==1){
					
					$("#lampiran_sk_"+idx).html(result.data);
					
					new PNotify({
                            title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                            text    :   'Ubah Lampiran Berhasil',
                            type	:	'success',
                            hide    :   true
                        });
					
				}else{
					
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

<script type="text/javascript">
$(function() {
	tanggal = $('#tgl_kejadian_selector').datepicker({
	format:"dd-mm-yyyy"
	}).on('changeDate', function(ev){
		var newDate = new Date(ev.date);
		$("#tgl_kejadian").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
		$('#tgl_kejadian_selector').datepicker('hide');
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

<script>
$(document).ready(function(){
	$(".edit_sk").on("click",function(){
		
		var	idx	=	$(this).data("idx");
		var	url	=	"<?=$this->module?>data_sk";
		
		$.ajax({
			
				url		:	url,
				type	:	"POST",
				dataType:	"JSON",
				data	:	{idx:idx},
				success	:	function(result){
					
					var id_sk			=	result.idx;
					var nomor_sk		=	result.nomor;
					var tentang_sk		=	result.tentang;
					var tahun_sk		=	result.tahun;
					
					$("#id_sk").val(id_sk);
					$("#ubah_nomor_sk").val(nomor_sk);
					$("#ubah_tentang_sk").val(tentang_sk);
					$("#ubah_tahun_sk").val(tahun_sk);
					
					$("#skModal").modal("show");
				}
		
		});
	});
	
	$(".ubah_sk_submit").on("click",function(){
		
		var	idx				=	$("#id_sk").val();
		var nomor			=	$("#ubah_nomor_sk").val();
		var tentang			=	$("#ubah_tentang_sk").val();
		var tahun			=	$("#ubah_tahun_sk").val();
		
		var	url				=	"<?=$this->module?>ubah_sk";
		
		$.ajax({
			
				url		:	url,
				type	:	"POST",
				dataType:	"JSON",
				data	:	{idx:idx,nomor:nomor,tentang:tentang,tahun:tahun},
				success	:	function(result){
					
					if(result){
						
						$("#data_sk_"+idx).text(nomor+" tentang "+tentang+" tahun "+tahun);
						
						$("#skModal").modal("hide");
						new PNotify({
                            title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                            text    :   'Ubah Surat Keputusan Berhasil',
                            type	:	'success',
                            hide    :   true
                        });
                        
					}else{
						
						$("#skModal").modal("hide");
						new PNotify({
                            title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                            text    :   'Ubah Surat Keputusan Gagal',
                            hide    :   true
                        });
                        
					}
				}
		
		});
		
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
			var new_el = '<div class="row"><div class="col-md-11" style="margin-bottom:2px;"><div style="position:relative"><div class="row"><div class="col-sm-3"><input type="text" name="no_sk[]" class="form-control" placeholder="No Surat Keputusan" /></div><div class="col-sm-4"><input type="text" name="tentang[]" class="form-control" placeholder="Tentang" /></div><div class="col-sm-2"><input type="text" name="tahun[]" class="form-control" placeholder="Tahun" /></div><div class="col-sm-3"><input type="file" name="lampiran[]" /><span style="font-size:11px;"><strong>*) Note : File Maksimal 5mb</strong></span></div></div></div></div><span class="btn btn-sm du-remove" style="right:0px; top:0px"><i class="fa fa-trash"></i></span></div>	';
						 
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

<script language="javascript">
$(function(){
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
	
	$("#id_kecamatan").on("change",function(){
		var nm_propinsi = $("#id_propinsi option:selected").text();
		var nm_address1 = nm_propinsi+" "+$("#id_kabupaten option:selected").text();				
		var nm_address2 = nm_address1+" "+$("#id_kecamatan option:selected").text();
		geoCode(nm_address2);
						
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
	  

<script>
$(document).ready(function(){
	$(".del_file").on("click",function(e){
		var	konfirmasi	=	confirm('Anda yakin akan menghapus lampiran ini?');
		
		if(konfirmasi==true){
			
			var	url		=	"<?=$this->module?>delete_lampiran";
			var idx		=	$(this).data("idx");
			
			$.ajax({
				url		:	url,
				type	:	"POST",
				data	:	{idx:idx},
				success	:	function(result){
					if(result){
						$("#tr_"+idx).remove();
						new PNotify({
                            title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                            text    :   'Hapus Lampiran Berhasil',
                            type	:	'success',
                            hide    :   true
                        });
					}else{
						new PNotify({
                            title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                            text    :   'Hapus Lampiran Gagal',
                            hide    :   true
                        });
					}
				}
			
			});
			
		}else{
			e.preventDefault();
		}
	});
});
</script>

<script>
$(document).ready(function(){
	$(".del_sk").on("click",function(e){
		var	konfirmasi	=	confirm('Anda yakin akan menghapus data ini?');
		
		if(konfirmasi==true){
			
			var	url		=	"<?=$this->module?>delete_sk";
			var idx		=	$(this).data("idx");
			
			$.ajax({
				url		:	url,
				type	:	"POST",
				data	:	{idx:idx},
				success	:	function(result){
					if(result){
						$("#sk_"+idx).remove();
						new PNotify({
                            title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                            text    :   'Hapus Surat Keputusan Berhasil',
                            type	:	'success',
                            hide    :   true
                        });
					}else{
						new PNotify({
                            title   :   '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                            text    :   'Hapus Surat Keputusan Gagal',
                            hide    :   true
                        });
					}
				}
			
			});
			
		}else{
			e.preventDefault();
		}
	});
});
</script>
