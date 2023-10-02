<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?php
	$lookup_jenis_instansi[""]="--Pilih--";
	$lookup_jenis_instansi=$lookup_jenis_instansi+lookup("m_jenis_instansi","kd_jenis_instansi","ur_jenis_instansi","","order by order_num");
	$lookup_strip[""]="--Pilih--";
	$lookup_kepemilikan=$lookup_strip+lookup("m_kepemilikan","kd_kepemilikan","ur_kepemilikan","","order by order_num");
	
	$lookup_tempat_rehab=$lookup_strip+array("BB"=>"Balai Besar","BLK"=>"Balai/Loka");
	
	$lookup_bantuan_modal=lookup("m_bantuan_modal","idx","ur_bantuan","","order by order_num");
	
	$lookup_org=lookup("m_org","idx","nama","kd_org='".$data['kd_bnn']."' and tipe_org='BNNP'","order by idx");
	
?>

<?php $path	=	$this->config->item("dir_balai_loka"); ?>
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.css">
<link rel="stylesheet" href="assets/js/leaflet/leaflet-l-geosearch/css/l.geosearch.css" />

<script src="assets/js/leaflet/leaflet.js"></script>
<script src="assets/js/leaflet/leaflet-awesome-markers/leaflet.awesome-markers.min.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.control.geosearch.js"></script>
<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.google.js"></script>
<!--<script src="assets/js/leaflet/leaflet-l-geosearch/js/l.geosearch.provider.openstreetmap.js"></script>
-->
<style>
	.content{padding:0!important;}
	/*
	#map{
		position:relative;
		box-shadow: 0 0 10px rgba(0,0,0,0.5);
		height: 100%;
		width:auto;
	}*/
</style>

<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
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
        	<div class="content-toolbar">
                	<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>edit/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white btn-delete" href="<?php echo $this->module?>" data-toggle='tooltip' title="Cancel/Back To List">
                        <i class="fa fa-remove"></i>
                    </a>	  
            </div>
			
        	<div class="box box-widget">
            	<!--<div class="box-header with-border">
                  <h3 class="box-title">Data User</h3>
                </div>-->
                <div class="box-body">
				<div>

				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Balai</a></li>
					<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Sarana & Prasarana Balai</a></li>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						<form id="frm" method="post" action="<?php echo $this->module;?>edit/<?php echo $id;?>">
						  <input type="hidden" name="act" id="act" value="update"/>
						  <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
						   <input type="hidden" name="kepemilikan" id="kepemilikan" value="IP"/>
						  <input type="hidden" name="jenis_instansi" id="jenis_instansi" value="bl"/>
						  
						  
						  <div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  <label for="kd_jenis_instansi">Jenis Balai</label>
									<?=form_dropdown("jenis_tempat_rehab",$lookup_tempat_rehab,$data["jenis_tempat_rehab"],"id='jenis_tempat_rehab' class='form-control required select2'");?>
								</div>
							
								<div class="form-group">
								  <label for="kd_jenis_instansi">Nama</label>
								  <label class="pull-right">
									  <input type="checkbox" name="active" class="flat-red" <?php echo $data['active']?"checked='checked'":'';?> value="1">
									  Active
								  </label>	
								  <input class="form-control required" name="nama_instansi" type="text" id="nama_instansi" value="<?php echo $data["nama_instansi"];?>" />
								</div>
								<div class="form-group">
									<label for="alamat">Alamat</label>
									<textarea class="input-xs form-control" id="alamat" rows="5" name="alamat" placeholder=""><?=$data["alamat"]?></textarea>
								</div> 
								 <div class="row">
								 
								 <div class="col-md-12">
									 <div class="form-group">
										<label for="category">Jenis Rawat</label>
										<br>
										<label style="padding-right:10px">
										 <input type="checkbox" name="rawat_inap" class="flat-red" <?php echo $data['rawat_inap']?"checked='checked'":'';?> value="1"> Rawat Inap
									  </label>
									  <label style="padding-right:10px">
										<input type="checkbox" name="rawat_jalan" class="flat-red" <?php echo $data['rawat_jalan']?"checked='checked'":'';?> value="1"> Rawat Jalan
									 </label>
									 <label>
										<input type="checkbox" name="rawat_pasca" class="flat-red" <?php echo $data['rawat_pasca']?"checked='checked'":'';?> value="1"> Rawat Pasca
									 </label>	
											
									</div><!-- /control-group category-->
								</div>
								</div>
								
								<div class="form-group">
									<label>Contact Person</label>
									<input class="form-control required" name="cp" type="text" id="cp" value="<?php echo $data["cp"];?>" />
								</div>
								
								<div class="form-group">
									<label>No Telp</label>
									<input class="form-control required" name="no_telp" type="text" id="no_telp" value="<?php echo $data["no_telp"];?>" />
								</div>
								
								<div class="form-group">
									<label>Email</label>
									<input class="form-control required" name="email" type="text" id="email" value="<?php echo $data["email"];?>" />
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
										<label>Kapasitas Daya Tampung</label>
											<input type="text" class="form-control" id="kapasitas" disabled="disabled" value="<?=$data['jml_laki']+$data['jml_perempuan']?>" />
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
										<label>Jumlah Laki - laki</label>
											<input type="text" name="jml_laki" id="jml_laki" class="form-control" />
										</div>
									</div>
										
									<div class="col-md-3">
										<div class="form-group">
										<label>Jumlah Perempuan</label>
											<input type="text" name="jml_perempuan" id="jml_perempuan" class="form-control" />
										</div>
									</div>
								</div>
								
								<!-- TEST -->
								
							 </div>
							<!-- /.col -->
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
										<div id="map" style="height:300px;"></div>
									</div>
								</div><!-- end row -->
								<br>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>X (Longitude)</label>
											<?php echo form_input('x',$data["x"],'id="x" data-x="'.$data["x"].'" class="form-control required"');?>
											</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Y (Latitude)</label>
											<?php echo form_input('y',$data["y"],'id="y" data-y="'.$data["y"].'" class="form-control required"');?>
											</div>
									</div>
								</div>
								
								
								<div class="row">
										<div class="col-md-6">
											<?php
												$arrPropinsi=m_lookup("propinsi2","kode_bps","nama");
												$arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
												$arrKab=array("00"=>"--Belum Tahu--");
												if($data["id_propinsi"]):
												$arrKab=$arrKab+m_lookup("kabupaten_kota","kode_bps","nama","kode_prop={$data["id_propinsi"]} and kode_kab!='00'");
												endif;
												
											?>
											<div class="form-group">
											<label>Propinsi</label>
											<?=form_dropdown("id_propinsi",$arrPropinsi1,$data["id_propinsi"],"id='id_propinsi' class='form-control required'");?>
												
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<label>Kabupaten</label>
											<div id="id_kabupaten_holder">
											<?=form_dropdown("id_kabupaten",$arrKab,$data["id_kabupaten"],"id='id_kabupaten' class='form-control select2'");?>
											</div>
											</div>
										</div>
									</div>
									<div class="row hidden">
										<div class="col-md-6">
											<div class="form-group">
											<label>Kecamatan</label>
											<?php echo form_input('kecamatan',$data["kecamatan"],'class="form-control required"');?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<label>Desa</label>
											<?php echo form_input('desa',$data["desa"],'class="form-control required"');?>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
											<label>Wilayah BNNP</label>
											<?=form_dropdown("kd_bnn",$lookup_org,$data["kd_bnn"],"id='bnnp' class='form-control' readonly='readonly'");?>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											<label>Bantuan Modal</label>
											<?=form_dropdown("bantuan_modal",$lookup_bantuan_modal,$data["bantuan_modal"],"id='bantuan_modal' class='form-control'");?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<label>No Surat Ijin</label>
											<input type="text" name="no_surat_ijin" class="form-control" value="<?=$data['no_surat_ijin']?>" />
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											<label>Masa Berlaku</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" id="masa_berlaku_selector" class="form-control input-date required" value="<?=date("d/m/Y", strtotime($data['masa_berlaku']))?>" placeholder="dd/mm/yyyy"/>
													<input type="hidden" id="masa_berlaku" name="masa_berlaku" value="<?=date("Y-m-d", strtotime($data['masa_berlaku']))?>" class="required" />
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<label>KMK</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" id="kmk_selector" class="form-control input-date required" value="<?=date("d/m/Y", strtotime($data['kmk']))?>" placeholder="dd/mm/yyyy"/>
													<input type="hidden" id="kmk_berlaku" name="kmk" value="<?=date("Y-m-d",strtotime($data['kmk']))?>" class="required" />
												</div>
											</div>
										</div>
									</div>
							</div>
							<!-- /.col -->
						  </div>
						  <!-- /.row -->
						  
						  <div class="row">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Foto Profil Pejabat</label>
											
											<?php
												if($data['foto_pejabat']):
													$src	=	$path.$data['foto_pejabat'];
												else:
													$src	=	$path."pic.jpg";
												endif;
											?>
											
											<img id="attachment1" src="<?=$src?>" width="200" height="200" style="border:thin solid #CCCCCC" />
											<input type="file" name="foto_pejabat" id="imgInp1" />
											<input type="hidden" name="foto1" id="foto1" />
										</div>
									</div>
									<div class="col-md-8">
										<br />
										<div class="form-group">
											<label>Nama</label>
											<input type="text" name="nama_pejabat" class="form-control" value="<?=$data['nama_pejabat']?>" />
										</div>
										
										<div class="form-group">
											<label>Jabatan</label>
											<input type="text" name="jabatan" class="form-control" value="<?=$data['jabatan']?>" />
										</div>
										
										<div class="form-group">
											<label>TMT Jabatan</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" id="tmt_jabatan_selector" class="form-control input-date required" value="<?=date("d/m/Y", strtotime($data['tmt_jabatan']))?>" placeholder="dd/mm/yyyy"/>
													<input type="hidden" id="tmt_jabatan" name="tmt_jabatan" value="<?=date("Y-m-d", strtotime($data['tmt_jabatan']))?>" class="required" />
												</div>
										</div>
									</div>
								</div>
							</div><!--End Of Col 6-->
							
							<div class="col-sm-6">
								<div class="form-group">
									<label><center>Foto Fasilitas</center></label>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
										
										<?php
											if($data['fasilitas1']):
												$src	=	$path.$data['fasilitas1'];
											else:
												$src	=	$path."noimg.jpg";
											endif;
										?>
										
										<img id="attachment2" src="<?=$src?>" width="275" height="150" style="border:thin solid #CCCCCC" />
										<input type="file" name="fasilitas1" id="imgInp2" />
										<input type="hidden" name="foto2" id="foto2" />
									</div>
									
									<div class="col-sm-6">
									
										<?php
											if($data['fasilitas2']):
												$src	=	$path.$data['fasilitas2'];
											else:
												$src	=	$path."noimg.jpg";
											endif;
										?>
										
										<img id="attachment3" src="<?=$src?>" width="275" height="150" style="border:thin solid #CCCCCC" />
										<input type="file" name="fasilitas2" id="imgInp3" />
										<input type="hidden" name="foto3" id="foto3" />
									</div>
								</div>
							</div>
						  </div><!--End Of Row-->
						  
						  <div class="row">
							<div class="col-md-6">
								<!-- END ROW -->
							</div>
						  </div>
						  
						  
						
						</form>
					</div>
					
					<div role="tabpanel" class="tab-pane" id="profile">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#fasru" aria-controls="fasru" role="tab" data-toggle="tab">Fasilitas Ruangan</a></li>
						<li role="presentation"><a href="#dokter" aria-controls="dokter" role="tab" data-toggle="tab">Dokter</a></li>
						<li role="presentation"><a href="#perbid" aria-controls="perbid" role="tab" data-toggle="tab">Perawat & Bidan</a></li>
						<li role="presentation"><a href="#tensos" aria-controls="tensos" role="tab" data-toggle="tab">Tenaga Sosial</a></li>
						<li role="presentation"><a href="#penmed" aria-controls="penmed" role="tab" data-toggle="tab">Penunjang Medis</a></li>
						<li role="presentation"><a href="#admu" aria-controls="admu" role="tab" data-toggle="tab">Administrasi Umum</a></li>
						<li role="presentation"><a href="#peralatan" aria-controls="peralatan" role="tab" data-toggle="tab">Peralatan</a></li>
					  </ul>
					<div class="row">
						<!--
						<div class="col-md-2">
							<ul id="rhTab" class="nav nav-pills nav-stacked dtab" role="tablist" style="background:#eee">
							  <li class="active"><a data-toggle="tab" href="#homex">Fasilitas Ruangan</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="doket" aria-expanded="true" data-url="sarpras/fas_ruang/attr/dokter" href="#menu1">Dokter</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="perbid" aria-expanded="true" data-url="sarpras/fas_ruang/attr/perbid" href="#menu2">Perawat & Bidan</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="tensos" aria-expanded="true" data-url="sarpras/fas_ruang/attr/tensos" href="#menu3">Tenaga Sosial</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="pnj_medis" aria-expanded="true" data-url="sarpras/fas_ruang/attr/penunjang_medis" href="#menu4">Penunjang Medis</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="adm_umum" aria-expanded="true" data-url="sarpras/fas_ruang/attr/adm_umum" href="#menu5">Administrasi Umum</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="alat" aria-expanded="true" data-url="sarpras/fas_ruang/attr/peralatan" href="#menu6">Peralatan</a></li>
							</ul>
						</div>-->
						<div class="col-md-10">
							<div class="tab-content">
							  <div id="homex" class="tab-pane fade in active">
							   	<div class="col-md-5">
										<br />
										<table class="table">
											<?php if(cek_array($arrSP)):?>
												<?php foreach($arrSP as $x=>$val):?>
													<input name="idx[]" value="<?=$val['idx']?>" type="hidden" class="form-control">
													<tr>
														<td><?=$val['uraian']?></td>
														<td align="right">
															<input style="width:100px;" name="jumlah[]" value="<?=$val['jumlah']?>" type="text" readonly class="form-control">
														</td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</table>
									</div>
									<div class="col-md-5">
										<br />
										<table class="table">
											<?php if(cek_array($arrSP2)):?>
												<?php foreach($arrSP2 as $x2=>$val2):?>
													<input name="idx[]" value="<?=$val2['idx']?>" type="hidden" class="form-control">
													<tr>
														<td><?=$val2['uraian']?></td>
														<td align="right"><input name="jumlah[]" style="width:100px;" type="text" value="<?=$val2['jumlah']?>" readonly class="form-control"></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</table>
									</div>
									
							  </div>
							  <div id="menu1" class="tab-pane fade">
								<h3>Menu 1</h3>
								<p>Some content in menu 1.</p>
							  </div>
							  <div id="menu2" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
							  </div>
							  <div id="menu3" class="tab-pane fade">
								<h3>Menu 1</h3>
								<p>Some content in menu 1.</p>
							  </div>
							  <div id="menu4" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
							  </div>
							  <div id="menu5" class="tab-pane fade">
								<h3>Menu 1</h3>
								<p>Some content in menu 1.</p>
							  </div>
							  <div id="menu6" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
							  </div>
							</div>
						</div>
					</div>
					</div>
				  </div>

				</div>
                
			</div>
                <!-- /.box-body -->
                <div class="box-footer well well-sm no-shadow">
                     <!--Username digunakan pada saat login.-->
                     &nbsp;
                </div>
            </div>
        </div>
    </div>
</section>

<script language="javascript">
$(function(){
	$("#id_propinsi").select2({'placeholder':"--Pilih Propinsi--"});
	$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
	$("#jenis_tempat_rehab").change(function(){
			var thisval=$(this).find(":selected").val();
			if(thisval=='BB'){
				$("#jenis_instansi").val("bb");
			}
			if(thisval=='BLK'){
				$("#jenis_instansi").val("bl");
			}
	});
	
	$("#id_propinsi").change(function(){
   		var id_propinsi = $(this).val();
		var propinsi=$(this).find(":selected").text();
		//console.log(propinsi);
		//search_location(propinsi);
		
		//var nm_propinsi = $("#id_propinsi option:selected").text();
		$("#id_kabupaten_holder").load("<?=base_url()?>lookup/wilayah/get_kab_kota/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
			//getgeoCode(nm_propinsi);
			/*
			$("#id_kabupaten").change(function(){
				var nm_address = nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				getgeoCode(nm_address);
		   });*/
		   
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


<script>
	var cloudmade =L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
				maxZoom: 18
			});
			
		var mapquestOSM = L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
		  maxZoom: 19,
		  subdomains: ["otile1", "otile2", "otile3", "otile4"],
		  attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
		});
		var mapquestOAM = L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
		  maxZoom: 18,
		  subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"],
		  attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>. Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency'
		});
		var mapquestHYB = L.layerGroup([L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
		  maxZoom: 18,
		  subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"]
		}), L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/hyb/{z}/{x}/{y}.png", {
		  maxZoom: 19,
		  subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"],
		  attribution: 'Labels courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA. Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency'
		})]);
		
		var baseLayers = {
		  "OSM CloudMade": cloudmade,	
		  "Street Map": mapquestOSM,
		  "Aerial Imagery": mapquestOAM,
		  "Imagery with Streets": mapquestHYB
		};	

	
		
		var map=null;
		var jsonlayer=null;
		var markers=[];
		var markerFlag=1;
		var info=null;
		var legend=null;
		var mark_location_new=null;
		var mark_location=null;
		var lat=null;
		var lon=null;
		
		var blueMarker = L.AwesomeMarkers.icon({
			prefix:'fa',
			icon: 'home',
			markerColor: 'blue'
		});
		var orangeMarker = L.AwesomeMarkers.icon({
			prefix:'fa',
			icon: 'home',
			markerColor: 'orange'
		});
		
		function loadMap(){
			if(map==null){
				/*
				map = L.map('mapx').setView([1, 114],4);
				 cloudmade = L.tileLayer('http://{s}.tile.cloudmade.com/{key}/{styleId}/256/{z}/{x}/{y}.png', {
					attribution: 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
					key: 'BC9A493B41014CAABB98F0471D759707',
					styleId: 22677
				}).addTo(map);
				*/
				/*
				console.log(cloudmade);
				var map = L.map('mapx', {
					layers: [cloudmade] // only add one!
				}).setView([1, 114],10);
				*/
				
				map = L.map('mapx').setView([1, 114],4);
				map.addLayer(cloudmade);
				
				/*
				L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
					maxZoom: 18
				}).addTo(map);
				*/
				//cloudmade.addTo(map);
				
				L.control.layers(baseLayers).addTo(map);
				
				/* add search control */
				/*
				new L.Control.GeoSearch({
						provider: new L.GeoSearch.Provider.Google(),
						//provider: new L.GeoSearch.Provider.OpenStreetMap(),
						showMarker: false
				}).addTo(map);
				*/
				new L.Control.GeoSearch({
						provider: new L.GeoSearch.Provider.Google(),
						showMarker: false
				}).addTo(map);
				
			}	
			
				var longitude=$("#x").val();
				var latitude=$("#y").val();
				var zoom=10;
				if (!mark_location) {
					mark_location = L.marker([latitude,longitude],{icon:blueMarker}).bindPopup("Data").addTo(map);
					map.setView([latitude, longitude], zoom);
				}
			
		}
		
		$(function(){
			$("#mapx").remove();
			$("#map").html("<div id='mapx' style='width:100%;height:100%'></div>");
			lon=$("#x").val();
			lat=$("#y").val();
			
			/*
			$("#map").css("max-height", $(window).height() - $(".navbar-static-top").height() -35);
			$("#map").css("height", $(window).height() - $(".navbar-static-top").height()-35);
			
			$(window).resize(function() {
				$("#map").css("max-height", $(window).height() - $(".navbar-static-top").height() -35);
				$("#map").css("height", $(window).height() - $(".navbar-static-top").height() -35);
			});
			*/
			loadMap();	
			
			//map.on('click', addMarker);	
			
			
			map.on('click', function(e) {
    			//alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
				var latitude=e.latlng.lat;
				var longitude=e.latlng.lng;
				
				$("#x").val(e.latlng.lng);
				$("#y").val(e.latlng.lat);
				if (!mark_location) {
					mark_location = L.marker([latitude,longitude]).bindPopup("Data").addTo(map);
				}else{
					mark_location.setOpacity(0.5);
					if (!mark_location_new) {
						mark_location_new = L.marker([latitude,longitude],{icon:orangeMarker}).bindPopup("Data").addTo(map);
					}
					mark_location_new.setLatLng([latitude,longitude]).update();
				}
			});
		});
		
		function search_location(q){
			var limit=10;
				$.getJSON("http://nominatim.openstreetmap.org/search?format=json&limit="+limit+"&q="+q,function(data){
					latitude=data[0].lat;
					longitude=data[0].lon;
					map.setView([latitude, longitude], 6);
				});	
		}
		
		
		function addMarker(e){
			// Add marker to map at click location; add popup window
			var newMarker = new L.marker(e.latlng).addTo(map);
		}
		
</script>

<script>
$(document).ready(function(){
	
	$("#jml_laki").val("<?=$data['jml_laki']?>");
	$("#jml_perempuan").val("<?=$data['jml_perempuan']?>");		
	function calc(){
		var jml_laki 			=	($.trim($("#jml_laki").val()) != "" && !isNaN($("#jml_laki").val())) ? parseInt($("#jml_laki").val()) : 0;
        var jml_perempuan		=	($.trim($("#jml_perempuan").val()) != "" && !isNaN($("#jml_perempuan").val())) ? parseInt($("#jml_perempuan").val()) : 0;
        var kapasitas			=	$("#kapasitas").val(jml_laki+jml_perempuan);		
	}
    $("#jml_laki,#jml_perempuan").keyup(function(){
        calc();		
    });
});
</script>

<script>
$(document).ready(function(){

	$("#id_propinsi").change(function(){
		
		var kd_propinsi	=	$(this).val() || '<?=$data['kd_bnn']?>';
		
		$("#bnnp").html('<option>--loading--<option>');
		
		$.get("common/service/lookup_bnnp_by_propinsi/"+kd_propinsi,function(ret){
			$("#bnnp").html(ret);
		});
	});

});
</script>

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
	$(function(){
		var active_frm = 'frmd';
		//TAB DATA URL
		$('.dtab a').click(function (e) {
			if ($(this).data("url")) {
				e.preventDefault();
				
				var tabcontent = $(this).attr("href");
				var tahun = $("#tahun option:selected").val();
				$("#shadow-year").text(tahun);
				// var url = $(this).data("url")+'/'+active_kec+'/'+tahun;
				var url = $(this).data("url");
				// alert(url);
				$(tabcontent).html("Loading...");
				$(this).tab('show');
				$(tabcontent).load(url,function(){
					active_frm = $(tabcontent).find("form").attr("id");
					// alert(active_frm);
					$(tabcontent).find(".tahun").val($("#tahun option:selected").val());
				});
			}
			else {
				active_frm = 'frmd';
				$("#shadow-year").text("");
			}
			
		});
		$(".btn-save").click(function(e){
			e.preventDefault();
			$("#"+active_frm).submit();	
		});
		$("#tb_cancel").click(function(e){
			e.preventDefault();
			$(".tb_reset").trigger("click");	
		});
	})
</script>
	  