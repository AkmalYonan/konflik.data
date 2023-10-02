<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
?>
<?php
	// $lookup_status_akkm["Usulan"]="Registrasi Nasional";	
	// $lookup_status_akkm["RI"]="Registrasi Internasional";
	$lookup_status_akkm["Usulan"]="Usulan";	
	
?>
<script type="text/javascript" src="assets/js/maskF/my.js"></script>
<script type="text/javascript" src="assets/additional_js/maskMoney/dist/jquery.maskMoney.min.js"></script>
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
							<div class="col-md-12">
								<label for="alamat">Nama AKKM</label>
								<textarea class="form-control required" name="nama_akkm" id="nama_akkm" ><?php echo $data["nama_akkm"];?></textarea>
								
							</div> 
						</div>
						<div class="row">
							<div class="col-md-9">
								<div class="form-group">
									<label for="category">Pengampu Akkm</label>
									<input class="form-control required" name="pengampu" id="pengampu" type="text" value="<?php echo $data["pengampu"];?>" />
								</div>
							</div> 
							<div class="col-md-3">
								<div class="form-group">
									<label for="id">ID </label>
									<input class="form-control required" name="ID" id="ID" type="text" value="<?php echo $data["ID"];?>" />
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label for="alamat">Ekosistem</label>
										<input type="text" class="form-control" id="ekosistem" value="<?=$data['ekosistem']?>">
								</div> 
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<div class="form-group">
										<label>Luas</label>
										<div class="input-group">

											<input class="form-control" name='luas' type="text" name="my_field" id="my_field" pattern="^\d*(\.\d{0,2})?$" value="<?php echo $data["luas"];?>"  />
										

											<input class="form-control" type="hidden" id="luas" />
											<input class="form-control" name="luasc" type="hidden" id="luas_trans" value="<?php echo $data['luas']; ?>" />
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

                    	<div class="row">
							
							<div class="col-md-8">
								<div class="form-group">
								<label for="alamat">Status Akkm</label>
								<?=form_dropdown("status_akkm",$lookup_status_akkm,$data["status_akkm"],"id='status_akkm' class='form-control '");?>
								</div> 
							</div>  	
							<div class="col-md-4">
								<label for="alamat">Tanggal</label>
								<div class="input-group">
									<input type="hidden" id="tanggal" name="tanggal" value="<?=date_format(date_create($data['tanggal']),"Y-m-d")?>" />
									<input type="text" id="tanggal_selector" class="form-control" value="<?=date_format(date_create($data['tanggal']),"F Y")?>" required  />
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>	
								</div>
								<label style="font-size:10px; color:#FF0000">*) Waktu Penginputan data</label>
							</div> 
							
							
						</div>
						
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="category">Jenis Kebijakan </label>
									<?=form_dropdown("jenis_kebijakan",$lookup_kebijakan,$data["jenis_kebijakan"],"id='jenis_kebijakan' class='form-control '");?>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
								<label for="alamat">Judul Kebijakan</label>
								<input class="form-control " name="judul_kebijakan" id="judul_kebijakan" type="text" value="<?php echo $data["judul_kebijakan"];?>" />
								
								</div> 
							</div>  
						</div>

						<div class="row">
							
							<div class="col-md-12">
								<label for="alamat">Deskripsi</label>
								<textarea class="form-control required" cols='10' rows='10' name="deskripsi" id="deskripsi"  > <?php echo $data["deskripsi"];?></textarea>
							</div> 
						</div>



                    </div>
                    <div class="col-md-6">
                    	<div class="row">
                      		<div class="col-md-12">
                            	<div id="map" style="height:310px;"></div>
                        	</div>
                        </div><!-- end row -->

						<div class="row">
							<br />
							<div class="col-md-12">
								<div class="form-group">
									<label>Lampiran file Peta (Format: GEOJSON)</label>
									<div class="row">
										<div class="col-md-5">
											<input id="imgInpPlay" type="file" name="file_peta" class="form-control" style="padding:0; margin:-2px" />
											<textarea id="text" class="hidden form-control"><?=$data['geo']?></textarea>
										</div>
										<!--<div class="col-md-7">
											<!--<input type="checkbox" checked readonly>
											<input type="text"  class="form-control" readonly value="<?=$data["file_peta"]?>">
											<i class="fa fa-file-archive-o" aria-hidden="true"></i>
											<i class="fa fa-times" aria-hidden="true"></i>


										</div>-->
									</div>
									
								</div>
							</div>
							
							
						</div>
                        <div class="row">
							<div class="col-sm-12">
								<p align="justify">
									<small>
									**File Peta Spasial menggunakan Projection EPSG:4326, Dan Ukuran File Maksimal: 1.2M
									</small>
								</p>
							</div>
						</div>
                        
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
											
											if($this->user_prop and $this->user_kab):											
												$arrKec	=	m_lookup("kecamatan","kd_kecamatan","nm_kecamatan","kd_propinsi={$this->user_prop} and kd_kabupaten={$this->user_kab}");
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
											
												$arrKec	=	array(""=>"--")+m_lookup("kecamatan","kd_wilayah","nm_kecamatan","kd_propinsi={$this->user_prop} and kd_kabupaten={$kd_kab}");
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
										
											$arrKec	=	array(""=>"--")+m_lookup("kecamatan","KD_WILAYAH","NM_KECAMATAN","KD_PROPINSI={$data["kd_propinsi"]} and KD_KABUPATEN={$kd_kab}");
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
									<label>Kecamatan</label>
									
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
	$("#id_kecamatan").select2({'placeholder':"--Pilih Kecamatan--"});
	$("#konflik").select2();
	$("#id_propinsi").change(function(){
   		var id_propinsi = $(this).val();
		var nm_propinsi = $("#id_propinsi option:selected").text();

		//geo_code(nm_propinsi,7);
		$("#id_kecamatan_holder").load("<?=$this->module;?>get_kecamatan/X/?time="+new Date().getTime());
		
		$("#id_kecamatan").select2({'placeholder':"--"});
		$("#id_kabupaten_holder").load("<?=$this->module;?>get_kab_kota/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#id_kecamatan").select2({'placeholder':"--"});
			$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
			$("#id_kabupaten").change(function(){
				var nm_address = nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				//geo_code(nm_address,10);
				var id_propinsi = $("#id_propinsi option:selected").val();
				var nm_propinsi	=	$("#id_propinsi option:selected").text();
				var id_kabupaten = $(this).val();
				var nm_address	=	nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				//geo_code(nm_address,10);
				//alert("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/?time="+new Date().getTime());
				$("#id_kecamatan_holder").load("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/?time="+new Date().getTime(),function(){
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
		var nm_address	=	nm_propinsi+" "+$("#id_kabupaten option:selected").text();
		//geo_code(nm_address,10);
		//alert("<?=$this->module;?>get_kecamatan/"+id_propinsi+"/"+id_kabupaten+"/?time="+new Date().getTime());
		$("#id_kecamatan_holder").load("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/?time="+new Date().getTime(),function(){
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
<?=$this->load->view("map_coordinate_picker");?> 