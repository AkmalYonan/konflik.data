<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
?>
<?php
	$lookup_jns_pulau[""]="--Pilih--";
	$lookup_jns_pulau["P"]="Pribadi";
	$lookup_jns_pulau["U"]="Umum";
	$lookup_jns_pulau["PU"]="Pribadi & Umum";
	
	$lookup_status_konflik[""]="--Pilih--";
	$lookup_status_konflik["BD"]="Belum Ditangani";
	$lookup_status_konflik["PS"]="Dalam Proses";
	$lookup_status_konflik["SL"]="Selesai";
	
	$lookup_status_konflik_proses[""]="--Pilih--";
	$lookup_status_konflik_proses["Mediasi"]="Mediasi";
	$lookup_status_konflik_proses["Hukum"]="Hukum";
	
	$lookup_sifat[""]="--Pilih--";
	$lookup_sifat["Public"]="Public";
	$lookup_sifat["Private"]="Private";
	$lookup_kategori[""]="--Pilih--";
	$lookup_kategori["K1"]="Masyarakat Adat";
	$lookup_kategori["K2"]="Non Masyarakat Adat";
	// $lookup_konflik=lookup("m_konflik","uraian","uraian","","order by uraian");
	$lookup_strip[""]="--Pilih--";
	$lookup_sektor=$lookup_strip+lookup("m_sektor","kode","uraian","","order by uraian");	
	// $arx=array('Industri','Infrastruktur');
	$arx=explode(",",$data['kd_konflik']);
	// pre($data['dataKonflik']);exit;
?>
<script type="text/javascript" src="assets/js/maskF/my.js"></script>
<link rel="stylesheet" href="assets/js/additional_js/pnotify/pnotify.custom.min.css">

<!--<script src="assets/js/leaflet-1.3.1/leaflet.js"></script>
<script src="assets/js/leaflet-1.3.1/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet-1.3.1/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet-1.3.1/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>
<script src="assets/js/leaflet-1.3.1/plugins/leaflet.ajax.min.js"></script>-->

<script type="text/javascript" src="assets/additional_js/maskMoney/dist/jquery.maskMoney.min.js"></script>
<script src="assets/js/additional_js/pnotify/pnotify.custom.min.js"></script>
<script src="assets/js/additional_js/fileupload/ajaxfileupload.js"></script>
<!--<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.openstreetmap.js"></script>-->
<script src="assets/js/plugin/datepicker/locales/bootstrap-datepicker.id.js" charset="UTF-8"></script>

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
								<div class="form-group">
									<label for="category">Nomor Kejadian</label>
									<input class="form-control required" name="nomor_kejadian" id="nomor_kejadian" type="text" value="<?php echo $data["nomor_kejadian"];?>" />
								</div>
							</div> 
							<div class="col-md-6">
								<label for="alamat">Waktu Kejadian</label>
								<div class="input-group">
									<input type="hidden" id="tgl_kejadian" name="tgl_kejadian" value="<?=date_format(date_create($data['tgl_kejadian']),"Y-m-d")?>" />
									<input type="text" id="tgl_kejadian_selector" class="form-control" value="<?=date_format(date_create($data['tgl_kejadian']),"F Y")?>" required  />
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>	
								</div>
								<label style="font-size:10px; color:#FF0000">*) Waktu Perkiraan Dari Rangkaian Kejadian</label>
							</div> 
						</div>
						
						<div class="form-group">
                          <label for="kd_jenis_instansi">Judul</label>
                          <input class="form-control required" name="judul" id="judul" type="text" value="<?php echo $data["judul"];?>" />
                        </div>
						
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="alamat">Sektor</label>
									<?=form_dropdown("kd_sektor",$lookup_sektor,$data["kd_sektor"],"id='sektor' class='form-control required'");?>
								</div> 
							</div> 
							<div class="col-md-6">
								<div class="form-group">
									<label for="alamat">Sektor Lain</label>
									<input type="text" class="form-control" name="sektor_lain" id="sektor_lain" value="<?=$data['sektor_lain']?>">
									<label style="font-size:10px; color:#FF0000">*) Jika lebih dari 1 gunakan tanda koma. Ex: Sektor a,  Sektor b</label>
								</div> 
							</div> 
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="alamat">Konflik</label>
									<?=form_dropdown("kd_konflik[]",$data['dataKonflik'],$arx,"id='konflik' multiple='multiple'  class='form-control required'");?>
								</div> 
							</div> 
						</div>
                        <div class="row">
                            <div class="col-md-6">
								<div class="form-group">
									<label for="alamat">Status Konflik</label>
									<?=form_dropdown("status_konflik",$lookup_status_konflik,$data["status_konflik"],"id='status_konflik' class='form-control required'");?>
									<label for="alamat">&nbsp;</label>
									<?=form_dropdown("status_konflik_proses",$lookup_status_konflik_proses,$data["status_konflik_proses"],"id='status_konflik_proses' disabled class='form-control'");?>
								</div>
							</div> 
							<div class="col-md-6">
								<div class="form-group">
								<label for="alamat">Kategori Konflik</label>
								<?=form_dropdown("kategori",$lookup_kategori,$data["kategori"],"id='kategori' class='form-control'");?>
								</div> 
							</div> 
						</div>
						
						<div class="row">
							<div class="col-md-6"  >
								<div class="form-group tanggal_proses">
									<label for="tgl_proses">Tanggal Proses</label>
									<div class="input-group">
									
									<?
										if($data['tgl_proses']):
											$date_proses_hidden = date_format(date_create($data['tgl_proses']),"Y-m-d");
											$date_proses = date_format(date_create($data['tgl_proses']),"d-m-Y");
										else:
											$date_proses_hidden ="";
											$date_proses = "";
										endif;
									?>
									<input type="hidden" id="tgl_proses" name="tgl_proses" value="<?=$date_proses_hidden?>" />
									<input type="text" id="tgl_proses_selector" class="form-control" value="<?=$date_proses?>"  />
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>	
									</div>

									<label style="font-size:10px; color:#FF0000">*) Tanggal proses boleh dikosongkan jika belum ditentukan</label>
								</div> 
							</div>	
						</div>
						<div class="row">
							<div class="col-md-6"  >
								<div class="form-group tanggal_selesai">
									<label for="tgl_selesai">Tanggal Selesai</label>
									<div class="input-group">
									<input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date_format(date_create($data['tgl_selesai']),"Y-m-d")?>" />
									<input type="text" id="tgl_selesai_selector" class="form-control" value="<?=date_format(date_create($data['tgl_selesai']),"d-m-Y")?>" required  />
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>	
									</div>
								</div> 
							</div>	
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="alamat">Kerugian</label>
									<div class="input-group">
										<span class="input-group-addon">Rp</span>
										<input type="text" class="form-control" id="investasi">
										<input type="hidden" class="form-control" name="investasi" id="investasi_trans" value="<?php echo $data["investasi"]; ?>">										
									</div>
									<label style="font-size:10px; color:#FF0000">*) Dalam mata uang Rupiah. Ex: 25,000,000</label>
								</div> 
							</div> 
							<div class="col-md-6">
								<div class="form-group">
									<div class="form-group">
										<label>Luas</label>
										<div class="input-group">
											
											<input class="form-control" name='luas' type="text" name="my_field" id="my_field" pattern="^\d*(\.\d{0,2})?$" value="<?php echo $data["luas"];?>"  />
											<input class="form-control" type="hidden" id="luas" />
											<input class="form-control" name="luasx" type="hidden" id="luas_trans" value="<?php echo $data['luas']; ?>" />
											<span class="input-group-addon">Ha</span>
										</div>
										<label style="font-size:10px; color:#FF0000">*) Satuan Hektar (ha). Ex: 1,123.45</label>
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
								
							</script>
							<script>
								$(function (){
									var n = $('#my_field').val();
									$('#my_field').val(parseFloat(n).toFixed(2));
								});
							</script>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="alamat">Dampak Masyarakat</label>
									<div class="input-group">
										<input type="text" class="form-control" id="dampak">
										<input type="hidden" class="form-control" name="dampak" id="dampak_trans" value="<?php echo $data["dampak"];?>">
										<span class="input-group-addon">Jiwa</span>
									</div>
									<label style="font-size:10px; color:#FF0000">*) Dalam Satuan Jiwa. Ex: 1,000</label>
								</div> 
							</div> 
							<div class="col-md-6">
								<div class="form-group">
								<label for="alamat">Confidentiality</label>
								<?=form_dropdown("sifat",$lookup_sifat,$data["sifat"],"id='sifat' class='form-control '");?>
								</div> 
							</div> 
						</div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    	<div class="row">
                      		<div class="col-md-12">
                            	<div id="map" style="height:310px;"></div>
                        	</div>
                        </div><!-- end row -->
                        
                        
                        <br>
                        <div class="row">
                        	<div class="col-md-6">
                            	<div class="form-group">
									<label>X (Longitude)</label>
									<?php echo form_input('longitude',$data["longitude"],'id="x" placeholder="koordinat -180 sampai 180" data-x="'.$data["longitude"].'" class="form-control "');?>
									<label style="font-size:10px; color:#FF0000">*) koordinat -180 sampai 180 </label>
								</div>
                            </div>
                            <div class="col-md-6">
                            	<div class="form-group">
									<label>Y (Latitude)</label>
									<?php echo form_input('latitude',$data["latitude"],'id="y" placeholder="koordinat -90 sampai 90" data-y="'.$data["latitude"].'" class="form-control "');?>
									<label style="font-size:10px; color:#FF0000">*) koordinat -90 sampai 90 </label>
									</div>
                            </div>
							<button id="btn_set_point" class="btn btn-white hidden" data-toggle='tooltip' title="set peta"><i class="fa fa-globe"></i> </button>
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
											//debug();
											if($this->user_prop and $this->user_kab):											
												$arrKec	=	m_lookup("KECAMATAN","KD_KECAMATAN","NM_KECAMATAN","kd_propinsi={$this->user_prop} and kd_kabupaten={$this->user_kab}");
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
											
												$arrKec	=	array(""=>"--")+m_lookup("KECAMATAN","KD_WILAYAH","NM_KECAMATAN","KD_PROPINSI={$this->user_prop} and KD_KABUPATEN={$kd_kab}");
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
										
											$arrKec	=	array(""=>"--")+m_lookup("kecamatan","KD_WILAYAH","NM_KECAMATAN","kd_wilayah like '{$data["kd_kabupaten"]}%'");
										endif;
									endif;
										//pre($arrKec);
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
									<label title="<?=$data["kd_kecamatan"]?>">Kecamatan</label>
                                    <div id="id_kecamatan_holder">
									<?=form_dropdown("kd_kecamatan",$arrKec,$data["kd_kecamatan"],"id='id_kecamatan' class='form-control '");?>
									</div>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Desa/Kelurahan</label>
                                        <input class="form-control" name="kd_desa" id="kd_desa" type="text" value="<?php echo $data["kd_desa"];?>" />
                                    </div>
                                </div>
							</div>
                    </div>  
					<div class="col-md-12">
						<h4 class="heading">KETERLIBATAN</h4>
						<div class="row">
							<div class="col-md-4">
								<label for="alamat">Pemerintah</label> 
								<button id="du-add" class=" pull-right" type="button" style="margin-bottom:3px;"><i class="fa fa-plus"></i></button>
								<div id="detil_urusan">
								<?php foreach($att1 as $k=>$v): ?>
								 <div class="row">
									<div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="du-item form-control" name="keterangan[]" value="<?=$v['uraian']?>"></div></div>
									<span class="btn btn-sm du-remove" style="right:0px; top:0px"><i class="fa fa-trash"></i></span>
								 </div>	
								<?php endforeach; ?>
								</div>
							</div>
							<div class="col-md-4">
								<label for="alamat">Perusahaan</label> 
								<button id="du-add2" class=" pull-right" type="button" style="margin-bottom:3px;"><i class="fa fa-plus"></i></button>
								<div id="detil_urusan2">
								<?php foreach($att2 as $k=>$v): ?>
								 <div class="row">
									<div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="du-item2 form-control" name="keterangan2[]" value="<?=$v['uraian']?>"></div></div>
									<span class="btn btn-sm du-remove2" style="right:0px; top:0px"><i class="fa fa-trash"></i></span>
								 </div>	
								<?php endforeach; ?>
								</div>
							</div>
							<div class="col-md-4">
								<label for="alamat">Masyarakat</label> 
								<button id="du-add3" class=" pull-right" type="button" style="margin-bottom:3px;"><i class="fa fa-plus"></i></button>
								<div id="detil_urusan3">
								<?php foreach($att3 as $k=>$v): ?>
								 <div class="row">
									<div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="du-item3 form-control" name="keterangan3[]" value="<?=$v['uraian']?>"></div></div>
									<span class="btn btn-sm du-remove3" style="right:0px; top:0px"><i class="fa fa-trash"></i></span>
								 </div>	
								<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">	
								<h4 class="heading">KONTEN</h4>
								<div class="form-group">
									<label for="alamat">Klip</label>
									<textarea class="input-xs form-control" id="klip" rows="2" name="clip" placeholder=""><?=$data["clip"]?></textarea>
								</div> 
								<div class="form-group">
									<label for="category">Narasi</label>
									<textarea class="input-xs form-control" id="narasi" rows="4" name="narasi" placeholder=""><?=$data["narasi"]?></textarea>
								</div>
								<div class="form-group">
									<label>Sumber</label>
									<input class="form-control required" name="sumber" type="text" id="sumber" value="<?php echo $data["sumber"];?>" />
								</div>
							</div>
							<div class="col-md-6">	
									<h4 class="heading">KONTAK PEMILIK DATA</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="alamat">Nama</label>
												<?php echo form_input('nama_kontak',$dataKontak["nama_kontak"],'id="nama_kontak" class="form-control"');?>
											</div> 
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="alamat">Email</label>
												<?php echo form_input('email_kontak',$dataKontak["email_kontak"],'id="email_kontak" class="form-control"');?>
											</div> 
										</div>
									</div>
									<div class="form-group">
										<label for="alamat">Alamat</label>
										<textarea class="input-xs form-control" id="alamat_kontak" rows="3" name="alamat_kontak" placeholder=""><?=$dataKontak["alamat_kontak"]?></textarea>
									</div>
									<div class="form-group">
										<label for="alamat">Telpon/HP</label>
										<?php echo form_input('telpon_kontak',$dataKontak["telpon_kontak"],'id="telpon_kontak" class="form-control"');?>
									</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<h4 class="heading">LAMPIRAN</h4>
						
						<?php if(cek_array($file)): ?>
						<div class="row">
							<div class="col-sm-12">
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
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary ubah_data_submit">Simpan</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
</section>

<script>
$(document).ready(function(){
	

	$("#x,#y").blur(function(){
		var x = $("#x").val();
		var y = $("#y").val();
		if (x && y) {
			if ((x>=-180 && x<=180) && (y>=-90 && y<=90)) {
				$("#btn_set_point").trigger("click");	
			}
		}
	});
    
    $("#email_kontak").on("blur",function(){
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
	
	var init_investasi	=	ReplaceNumberWithCommas(<?=$data['investasi']?>);
	var init_luas		=	ReplaceNumberWithCommas(<?=$data['luas']?>);
	var init_dampak		=	ReplaceNumberWithCommas(<?=$data['dampak']?>);
	
	$("#investasi").val(init_investasi);
	$("#luas").val(init_luas);
	$("#dampak").val(init_dampak);
	
	$("#investasi").keyup(function(){
		
		var value		=	$(this).val();
		
		var rem_number	=	RemoveComas(value);

		var new_value	=	ReplaceNumberWithCommas(rem_number);
		
		var save_value	=	RemoveComas(value);

		$(this).val(new_value);
		$("#investasi_trans").val(save_value);
	
	});
	
	$("#investasi").on("blur",function(){
		
		var value		=	$(this).val();
		
		var rem_number	=	RemoveComas(value);

		var new_value	=	ReplaceNumberWithCommas(rem_number);
		
		var save_value	=	RemoveComas(value);

		$(this).val(new_value);
		$("#investasi_trans").val(save_value);
	
	});
	
	$("#dampak").keyup(function(){
		
		var value		=	$(this).val();
		
		var rem_number	=	RemoveComas(value);

		var new_value	=	ReplaceNumberWithCommas(rem_number);
		
		var save_value	=	RemoveComas(value);

		$(this).val(new_value);
		$("#dampak_trans").val(save_value);
	
	});
	
	$("#dampak").on("blur",function(){
		
		var value		=	$(this).val();
		
		var rem_number	=	RemoveComas(value);

		var new_value	=	ReplaceNumberWithCommas(rem_number);
		
		var save_value	=	RemoveComas(value);

		$(this).val(new_value);
		$("#dampak_trans").val(save_value);
	
	});
	
	$("#luas").keyup(function(){
		
		var value		=	$(this).val();
		
		var rem_number	=	RemoveComas(value);

		var new_value	=	ReplaceNumberWithCommas(rem_number);
		
		var save_value	=	RemoveComas(value);

		$(this).val(new_value);
		$("#luas_trans").val(save_value);
	
	});
	
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
		//alert(JSON.stringify(employee););
		//Comma-fies the first part
	
		//components[0] = components[0].toLocaleString(
		//undefined, // leave undefined to use the browser's locale,
					// or use a string like 'en-US' to override it.
	//	{ minimumFractionDigits: 2 }
	//	);
	
	// In en-US, logs '100,000.00'
	// In de-DE, logs '100.000,00'
	// In hi-IN, logs '1,00,000.00'
		components[0]	=	components[0].replace(/\B(?=(\d{2})+(?!\d))/g, ",");
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
	minViewMode: 1,
	language: "id",
	format:"MM yyyy"
	}).on('changeDate', function(ev){
		var newDate = new Date(ev.date);
		$("#tgl_kejadian").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
		$('#tgl_kejadian_selector').datepicker('hide');
	}).data('datepicker');
	
	tanggal_proses = $('#tgl_proses_selector').datepicker({
	format:"dd-mm-yyyy"
	}).on('changeDate', function(ev){
		var newDate = new Date(ev.date);
		$("#tgl_proses").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
		$('#tgl_proses_selector').datepicker('hide');
	}).data('datepicker');
	
	tanggal_selesai = $('#tgl_selesai_selector').datepicker({
	format:"dd-mm-yyyy"
	}).on('changeDate', function(ev){
		var newDate = new Date(ev.date);
		$("#tgl_selesai").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
		$('#tgl_selesai_selector').datepicker('hide');
	}).data('datepicker');
	
	<?php if($data["status_konflik"]=='PS'): ?>
		$("#status_konflik_proses").prop("disabled", false);
		$("div.tanggal_proses").show();
		$('#tgl_proses').prop( "disabled", false );
		$('#tgl_proses_selector').prop( "disabled", false );
		$("div.tanggal_selesai").hide();
		$('#tgl_selesai').prop( "disabled", true );
		$('#tgl_selesai_selector').prop( "disabled", true );
	<?php elseif($data["status_konflik"]=='SL'): ?>
		$("#status_konflik_proses").prop("disabled", true);
		$("div.tanggal_selesai").show();
		$('#tgl_selesai').prop( "disabled", false );
		$('#tgl_selesai_selector').prop( "disabled", false );
		$("div.tanggal_proses").hide();
		$('#tgl_proses').prop( "disabled", true );
		$('#tgl_proses_selector').prop( "disabled", true );

	<?php else: ?>
	
		$("#status_konflik_proses").prop("disabled", true);
		$("div.tanggal_proses").hide();
		$("div.tanggal_selesai").hide();
		$('#tgl_selesai').prop( "disabled", true );
		$('#tgl_selesai_selector').prop( "disabled", true );
		$('#tgl_proses').prop( "disabled", true );
		$('#tgl_proses_selector').prop( "disabled", true );
	<?php endif; ?>
	
	$('#status_konflik').on('change', function() {
	  var n = $("#status_konflik").val();
	  $("#status_konflik_proses").val('');
	  if ( n == 'PS'){
		$("#status_konflik_proses").prop("disabled", false);
		$("div.tanggal_proses").show();
		$('#tgl_proses').prop( "disabled", false );
		$('#tgl_proses_selector').prop( "disabled", false );
		$("div.tanggal_selesai").hide();
		$('#tgl_selesai').prop( "disabled", true );
		$('#tgl_selesai_selector').prop( "disabled", true );
		
	  }
	  else if ( n == 'SL'){
		$("#status_konflik_proses").prop("disabled", true);
		$("div.tanggal_selesai").show();
		$('#tgl_selesai').prop( "disabled", false );
		$('#tgl_selesai_selector').prop( "disabled", false );
		$("div.tanggal_proses").hide();
		$('#tgl_proses').prop( "disabled", true );
		$('#tgl_proses_selector').prop( "disabled", true );
	  }
	  else{
		$("#status_konflik_proses").prop("disabled", true);
		$("div.tanggal_proses").hide();
		$("div.tanggal_selesai").hide();
		$('#tgl_selesai').prop( "disabled", true );
		$('#tgl_selesai_selector').prop( "disabled", true );
		$('#tgl_proses').prop( "disabled", true );
		$('#tgl_proses_selector').prop( "disabled", true );
	  }
	});
	
	$("#sektor").change(function(){
		$("#konflik").select2("val", "");
		// $("#konflik").html('<option>--loading--<option>');
		var sektor=$("#sektor option:selected").val()||$("#sektor").val();
		sektor=sektor?sektor:'x';
		$.get("home/lookup_konflik_admin/"+sektor,function(rets){
			$("#konflik").html(rets);
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
	
	<?php if($data["status_konflik"]=='PS'): ?>
	$("#status_konflik_proses").prop("disabled", false);
	<?php else: ?>
	$("#status_konflik_proses").prop("disabled", true);
	<?php endif; ?>
	
	$('#status_konflik').on('change', function() {
	  var n = $("#status_konflik").val();
	  $("#status_konflik_proses").val('');
	  if ( n == 'PS'){
		$("#status_konflik_proses").prop("disabled", false);
	  }else{
		$("#status_konflik_proses").prop("disabled", true);
	  }
	});
	$("#sektor").change(function(){
		$("#konflik").select2("val", "");
		// $("#konflik").html('<option>--loading--<option>');
		var sektor=$("#sektor option:selected").val()||$("#sektor").val();
		sektor=sektor?sektor:'x';
		$.get("home/lookup_konflik_admin/"+sektor,function(rets){
			$("#konflik").html(rets);
		});
	});
});
</script>
<script>
$(document).ready(function(){
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
	//$("#investasi").maskMoney({prefix:'Rp ', allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
	//$("#dampak").maskMoney({suffix:' Jiwa', allowNegative: false, thousands:'.',decimal:',',precision:'0', affixesStay: false});
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
				var new_el = '<div class="row"><div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="du-item form-control" name="keterangan[]" placeholder=""></div></div><span class="btn btn-sm du-remove" style="right:0px; top:0px"><i class="fa fa-trash"></i></span></div>'; 
						 
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
		var id_kabupaten = $("#id_kabupaten option:selected").val();
		//var id_kecamatan = $("#id_kecamatan option:selected").val();

		//geo_code(nm_propinsi,7);
		$("#id_kecamatan_holder").load("<?=$this->module;?>get_kecamatan/X/?time="+new Date().getTime());
		//alert("<?=$this->module;?>get_kab_kota/"+id_propinsi+"/"+id_kabupaten);
		$("#id_kecamatan").select2({'placeholder':"--"});
		$("#id_kabupaten_holder").load("<?=$this->module;?>get_kab_kota/"+id_propinsi+"/"+id_kabupaten+"?time="+new Date().getTime(),function(){
			$("#id_kecamatan").select2({'placeholder':"--"});
			$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
			$("#id_kabupaten").change(function(){
				var nm_address = nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				//geo_code(nm_address,10);
				var id_propinsi = $("#id_propinsi option:selected").val();
				var nm_propinsi	=	$("#id_propinsi option:selected").text();
				var id_kabupaten = $(this).val();
				//var id_kecamatan = $("#id_kecamatan option:selected").val();
				var nm_address	=	nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				//geo_code(nm_address,10);
				//alert("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/"+id_kecamatan+"?time="+new Date().getTime());
				$("#id_kecamatan_holder").load("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/"+id_kecamatan+"?time="+new Date().getTime(),function(){
					$("#id_kecamatan").select2({'placeholder':"--Pilih Kecamatan--"});
					$("#id_kecamatan").change(function(){
						var nm_address = nm_address+" "+$("#id_kecamatan option:selected").text();
						//geo_code(nm_address,10);
					});
				});	
		    });
		});	
    });
	
	$("#id_kabupaten").on("change",function(){
		var id_propinsi = $("#id_propinsi option:selected").val();
		var nm_propinsi	=	$("#id_propinsi option:selected").text();
		var id_kabupaten = $(this).val();
		var id_kecamatan = $("#id_kecamatan option:selected").val();
		var nm_address	=	nm_propinsi+" "+$("#id_kabupaten option:selected").text();
		//geo_code(nm_address,10);
		//alert("<?=$this->module;?>get_kecamatan/"+id_propinsi+"/"+id_kabupaten+"/?time="+new Date().getTime());
		$("#id_kecamatan_holder").load("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/"+id_kecamatan+"?time="+new Date().getTime(),function(){
			$("#id_kecamatan").select2({'placeholder':"--Pilih Kecamatan--"});
			$("#id_kecamatan").change(function(){
				var nm_address = nm_address+" "+$("#id_kecamatan option:selected").text();
				//geo_code(nm_address,10);
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
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '180px');
                //$('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
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
<?=$this->load->view("map_coordinate_picker");?> 