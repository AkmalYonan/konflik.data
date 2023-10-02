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

	$lookup_konflik=lookup("m_konflik","uraian","uraian","","order by uraian");
	$lookup_strip[""]="--Pilih--";
	$lookup_sektor=$lookup_strip+lookup("m_sektor","kode","uraian","","order by uraian");	
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
								<div class="form-group">
									<label for="category">Nomor Kejadian</label>
									<input class="form-control required" name="nomor_kejadian" id="nomor_kejadian" type="text" value="<?php echo $data["nomor_kejadian"];?>" />
								</div>
							</div> 
							<div class="col-md-6">
								<label for="alamat">Tanggal Kejadian</label>
								<div class="input-group">
									<input type="hidden" id="tgl_kejadian" name="tgl_kejadian" value="<?=date('Y-m-d')?>" />
									<input type="text" id="tgl_kejadian_selector" class="form-control" value="<?=date('d-m-Y')?>" required  />
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>	
								</div>
								<label style="font-size:10px; color:#FF0000">*) Tanggal Perkiraan Dari Rangkaian Kejadian</label>
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
									<input type="text" class="form-control" name="sektor_lain" id="sektor_lain">
									<label style="font-size:10px; color:#FF0000">*) Jika lebih dari 1 gunakan tanda koma. Ex: Sektor a,  Sektor b</label>
								</div> 
							</div> 
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="alamat">Konflik</label>
									<?=form_dropdown("kd_konflik[]",false,0,"id='konflik' multiple='multiple'  class='form-control required'");?>
									<? //echo form_dropdown("konflik",false,$key,"id='konflik' class='form-control'");?>
								</div> 
							</div> 
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="alamat">Status Konflik</label>
									<?=form_dropdown("status_konflik",$lookup_status_konflik,$data["status_konflik"],"id='status_konflik' class='form-control required'");?>
								</div> 
							</div> 
							<div class="col-md-6">
								<div class="form-group">
									<label for="alamat">&nbsp;</label>
									<?=form_dropdown("status_konflik_proses",$lookup_status_konflik_proses,$data["status_konflik_proses"],"id='status_konflik_proses' disabled class='form-control'");?>
								</div> 
							</div> 
						</div>
						<div class="row">
							<div class="col-md-6"  >
								<div class="form-group tanggal_proses">
									<label for="tgl_proses">Tanggal Proses</label>
									<div class="input-group">
									<input type="hidden" id="tgl_proses" name="tgl_proses" value="<?=date('Y-m-d')?>" />
									<input type="text" id="tgl_proses_selector" class="form-control" value="<?=date('d-m-Y')?>" required  />
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>	
									</div>
								</div> 
							</div>	
						</div>
						<div class="row">
							<div class="col-md-6"  >
								<div class="form-group tanggal_selesai">
									<label for="tgl_selesai">Tanggal Selesai</label>
									<div class="input-group">
									<input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date('Y-m-d')?>" />
									<input type="text" id="tgl_selesai_selector" class="form-control" value="<?=date('d-m-Y')?>" required  />
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
									<label for="alamat">Investasi</label>
									<div class="input-group">
										<span class="input-group-addon">Rp</span>
										<input type="text" class="form-control" id="investasi" placeholder="">
										<input type="hidden" class="form-control" name="investasi" id="investasi_trans" placeholder="">
									</div>
									<label style="font-size:10px; color:#FF0000">*) Dalam mata uang Rupiah. Ex: 25,000,000</label>
								</div> 
							</div> 
							<div class="col-md-6">
								<div class="form-group">
									<div class="form-group">
										<label>Luas</label>
										<div class="input-group">
											<input class="form-control" type="text" id="luas" value="<?php echo $data["luas"];?>" />
											<input class="form-control" name="luas" type="hidden" id="luas_trans" value="<?php echo $data["luas"];?>" />
											<span class="input-group-addon">Ha</span>
										</div>
										<label style="font-size:10px; color:#FF0000">*) Satuan Hektar (ha). Ex: 1,123.45</label>
									</div>
								</div> 
							</div> 
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="alamat">Dampak Masyarakat</label>
									<div class="input-group">
										<input type="text" class="form-control" id="dampak">
										<input type="hidden" class="form-control" name="dampak" id="dampak_trans">
										<span class="input-group-addon">Jiwa</span>
									</div>
									<label style="font-size:10px; color:#FF0000">*) Dalam Satuan Jiwa. Ex: 1,000</label>
								</div> 
							</div> 
							<div class="col-md-6">
								<div class="form-group">
								<label for="alamat">Confidentiality</label>
								<?=form_dropdown("sifat",$lookup_sifat,$data["sifat"],"id='sifat' class='form-control required'");?>
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
									<?php echo form_input('longitude',$data["x"],'id="x" placeholder="koordinat -180 sampai 180" data-x="'.$data["x"].'" class="form-control required"');?>
									<label style="font-size:10px; color:#FF0000">*) koordinat -180 sampai 180 </label>
								</div>
								
                            </div>
							
                            <div class="col-md-6">
                            	<div class="form-group">
									<label>Y (Latitude)</label>
									<?php echo form_input('latitude',$data["y"],'id="y" placeholder="koordinat -90 sampai 90" data-y="'.$data["y"].'" class="form-control required"');?>
									<label style="font-size:10px; color:#FF0000">*) koordinat -90 sampai 90 </label>
									</div>
                            </div>
							
							<button id="btn_set_point" class="btn btn-white hidden" data-toggle='tooltip' title="set peta"><i class="fa fa-globe"></i> </button>
                        </div>
                    
                    	<div class="row">
								<div class="col-md-6">
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
									<?=form_dropdown("kd_kabupaten",$arrKab,$data["kd_kabupaten"],"id='id_kabupaten' class='form-control'");?>
									</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									
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
				 
								 <div class="row">
									<div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="du-item form-control" name="keterangan[]" placeholder=""></div></div>
									<span class="btn btn-sm du-remove" style="right:0px; top:0px"><i class="fa fa-trash"></i></span>
								 </div>	
								</div>
							</div>
							<div class="col-md-4">
								<label for="alamat">Perusahaan</label> 
								<button id="du-add2" class=" pull-right" type="button" style="margin-bottom:3px;"><i class="fa fa-plus"></i></button>
								<div id="detil_urusan2">
				 
								 <div class="row">
									<div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="du-item2 form-control" name="keterangan2[]" placeholder=""></div></div>
									<span class="btn btn-sm du-remove2" style="right:0px; top:0px"><i class="fa fa-trash"></i></span>
								 </div>	
								</div>
							</div>
							<div class="col-md-4">
								<label for="alamat">Masyarakat</label> 
								<button id="du-add3" class=" pull-right" type="button" style="margin-bottom:3px;"><i class="fa fa-plus"></i></button>
								<div id="detil_urusan3">
				 
								 <div class="row">
									<div class="col-md-10" style="margin-bottom:2px;"><div style="position:relative"><input type="text" class="du-item3 form-control" name="keterangan3[]" placeholder=""></div></div>
									<span class="btn btn-sm du-remove3" style="right:0px; top:0px"><i class="fa fa-trash"></i></span>
								 </div>	
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">	
								<h4 class="heading">KONTENT</h4>
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
									<h4 class="heading">KONTAK</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="alamat">Nama</label>
												<?php echo form_input('nama_kontak',$data["nama_kontak"],'id="nama_kontak" class="form-control"');?>
											</div> 
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="alamat">Email</label>
												<?php echo form_input('email_kontak',$data["email_kontak"],'id="email_kontak" class="form-control"');?>
											</div> 
										</div>
									</div>
									<div class="form-group">
										<label for="alamat">Alamat</label>
										<textarea class="input-xs form-control" id="alamat_kontak" rows="3" name="alamat_kontak" placeholder=""><?=$data["alamat_kontak"]?></textarea>
									</div>
									<div class="form-group">
										<label for="alamat">Telpon/HP</label>
										<?php echo form_input('telpon_kontak',$data["telpon_kontak"],'id="telpon_kontak" class="form-control"');?>
									</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<h4 class="heading">LAMPIRAN</h4>
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
	$("#x,#y").blur(function(){
		var x = $("#x").val();
		var y = $("#y").val();
		if (x && y) {
			if (x>=-180 && x<=180 && y>=-90 && y<=90) {
				$("#btn_set_point").trigger("click");	
			}
		}
	});
	
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
	
	$("#status_konflik_proses").prop("disabled", true);
	$("div.tanggal_proses").hide();
	$("div.tanggal_selesai").hide();
	
	$('#tgl_selesai').prop( "disabled", true );
	$('#tgl_selesai_selector').prop( "disabled", true );
	$('#tgl_proses').prop( "disabled", true );
	$('#tgl_proses_selector').prop( "disabled", true );
	
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
	// $("#sektor").change(function(){
		// $("#konflik").select2("val", "");
		// var sektor=$("#sektor option:selected").val()||$("#sektor").val();
		// sektor=sektor?sektor:'x';
		// $.get("home/lookup_konflik_admin/"+sektor,function(rets){
			// $("#konflik").html(rets);
		// });
	// });
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


<script>
$(document).ready(function(){
	//$("#investasi").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
	//$("#dampak").maskMoney({suffix:' Jiwa', allowNegative: false, thousands:'.',decimal:',',precision:'0', affixesStay: false});
	//$("#luas").maskMoney({suffix:' Ha',allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
});
</script>

<script language="javascript">
$(function(){
	$("#id_propinsi").select2({'placeholder':"--Pilih Propinsi--"});
	$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	$("#konflik").select2();
	$("#id_propinsi").change(function(){
   		var id_propinsi = $(this).val();
		var nm_propinsi = $("#id_propinsi option:selected").text();

		geo_code(nm_propinsi,7);
		
		$("#id_kabupaten_holder").load("<?=$this->module;?>get_kab_kota/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
			$("#id_kabupaten").change(function(){
				var nm_address = nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				geo_code(nm_address,10);
		    });
		});	
    });
	
	$("#id_kabupaten").on("change",function(){
		var nm_propinsi	=	$("#id_propinsi option:selected").text();
		var nm_address	=	nm_propinsi+" "+$("#id_kabupaten option:selected").text();
		geo_code(nm_address,10);
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
			
		var baseLayers = {
		  "OSM CloudMade": cloudmade,	
		  //"Street Map": mapquestOSM,
		  //"Aerial Imagery": mapquestOAM,
		  //"Imagery with Streets": mapquestHYB
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
		
		function geo_code(region_name,zoom_val){
			
			var url		=	"https://maps.googleapis.com/maps/api/geocode/json?address="+region_name;
			
			$.getJSON(url,function(data,status){
				
				if(status=="success"){
					
					var	coordinate	=	data.results[0].geometry.location;
					
					var	region_lat	=	coordinate.lat;
					var	region_long	=	coordinate.lng;
					
					map.setView([region_lat, region_long], zoom_val);
					
				}
				
			});
			
		}
		
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
				
				<?php if($this->user_prop): ?>
					<?php if($this->user_kab): ?>
						geo_code('<?=$region_name?>',10);
					<?php else: ?>
						geo_code('<?=$region_name?>',7);
					<?php endif; ?>
				<?php endif; ?>

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
						provider: new L.GeoSearch.Provider.Google({
							bounds: { north: 6, east: 145, south: -11, west: 92 }	
						}),
						showMarker: false
				}).addTo(map);
				
			}	
			
			    var loc=map.getCenter();
				
				var validLon=$("#x").val()>95?true:false;
				var longitude=$("#x").val()||loc.lng;
				var latitude=$("#y").val()||loc.lat;
				var zoom=4;
				if(validLon){
					zoom=10;
				}
				if (!mark_location) {
					mark_location = L.marker([latitude,longitude],{icon:blueMarker}).bindPopup("Lokasi Sekarang").addTo(map);
					map.setView([latitude, longitude], zoom);
				}
			
		}
		
		$(function(){
			$("#mapx").remove();
			$("#map").html("<div id='mapx' style='width:100%;height:100%'></div>");
			lon=$("#x").val();
			lat=$("#y").val();
			//alert(lon);
			//alert(lat);
			
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
			
			$("#btn_set_point").click(function(e){
				e.preventDefault();
				var latitude=$("#y").val()*1 || map.getCenter().lat;
				var longitude=$("#x").val()*1 || map.getCenter().lng; 
				
				if (!mark_location) {
					mark_location = L.marker([latitude,longitude]).bindPopup("Lokasi Sekarang").addTo(map);
				}else{
					mark_location.setOpacity(0.5);
					if (!mark_location_new) {
						mark_location_new = L.marker([latitude,longitude],{icon:orangeMarker}).bindPopup("Lokasi Baru").addTo(map);
					}
					mark_location_new.setLatLng([latitude,longitude]).update();
					//
					var markerArray = [];
					markerArray.push(mark_location);
					markerArray.push(mark_location_new);
					var group = L.featureGroup(markerArray); //add markers array to featureGroup
        			if(mark_location.getLatLng().toString()!=mark_location_new.getLatLng().toString()){
						//console.log("test");
						//console.log(mark_location.getLatLng());
						//console.log(mark_location_new.getLatLng());
						map.fitBounds(group.getBounds());  
					}else{
						console.log("test2");
						map.setView([latitude, longitude], 10);
					}
				}
				
				
			});
			
			
			map.on('click', function(e) {
    			//alert("test");
				//alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
				var latitude=e.latlng.lat;
				var longitude=e.latlng.lng;
				
				$("#x").val(e.latlng.lng);
				$("#y").val(e.latlng.lat);
				if (!mark_location) {
					mark_location = L.marker([latitude,longitude]).bindPopup("Lokasi Sekarang").addTo(map);
				}else{
					mark_location.setOpacity(0.5);
					if (!mark_location_new) {
						mark_location_new = L.marker([latitude,longitude],{icon:orangeMarker}).bindPopup("Lokasi Baru").addTo(map);
					}
					mark_location_new.setLatLng([latitude,longitude]).update();
				}
			});
		});
		
		function search_location(q){
			var limit=10;
				$.getJSON("http://nominatim.openstreetmap.org/search?format=json&limit="+limit+"&q="+q+"&countrycodes=id",function(data){
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
