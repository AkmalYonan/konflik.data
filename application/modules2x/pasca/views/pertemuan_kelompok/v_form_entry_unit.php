<!--Add-->
<style>
input[type="radio"] {
    -webkit-appearance: checkbox;
    -moz-appearance: checkbox;
    -ms-appearance: checkbox;     /* not currently supported */
    -o-appearance: checkbox;      /* not currently supported */
}
</style>

<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	
	$lookup_pertemuan[1]="1";
	$lookup_pertemuan[2]="2";
	//$lookup_pertemuan[3]="3";
	//$lookup_pertemuan[4]="4";
	
	$lookhasil[1] ="TIdak Produktif";
	$lookhasil[2] ="Family Issue";
	$lookhasil[3] ="Social ";
	$lookhasil[4] ="Environment Issue";
	$lookhasil[5] ="Hukum";
	
	$lookup_status["PS"]="Proses";
	$lookup_status["SL"]="Selesai";
	
	$lookup_status_p["PS"]="Proses"; 
	$lookup_status_p["SL"]="Selesai";
	$lookup_status_p["KB"]="Kambuh"; 
	$lookup_status_p["MD"]="Meninggal Dunia";
	$lookup_status_berikutnya=lookup("m_proses_rehab","kd_status_proses","ur_proses","kd_status_rehab=3 and kd_proses like '3.PR.RL.%' and flag_proses=1","order by kd_status_rehab,order_num");
	
	if($monitoring_pasca['tgl_dr_selesai']):
		$tgl_limit_prev = $monitoring_pasca['tgl_dr_selesai']; 
	elseif($monitoring_pasca['tgl_dk_selesai']):
		$tgl_limit_prev = $monitoring_pasca['tgl_dk_selesai']; 
	else:
		$tgl_limit_prev = $monitoring_pasca['tgl_mulai_pasca']; 
	endif; 	
 	
?>

<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped table-condensed data_tbl">
			<?php if(count($pasien_pk_history)>0):?>
				<?php foreach($pasien_pk_history as $x=>$val): ?>
					<tr id="tr_<?=$val['idx']?>">
						<td align="center"><?php echo $x+1?></td>
						<td><?php echo ($val["tgl_hm"])?date2indo($val["tgl_hm"]):"<center>-</center>"?></td>
						<td align="center">Pertemuan Ke-<?php echo $val["id_hm"]?></td>
						<td align="center">
							<?php
								if($val['hsl_hm']==1):
									echo "<span class='label label-success'><i class='fa fa-plus'></i></span>";
								elseif($val['hsl_hm']==2):
									echo "<span class='label label-danger'><i class='fa fa-minus'></i></span>";
								endif;
							?>
						</td>
						<td><?php echo $val["keterangan"]?></td>
						<td align="center">
							<?php if($val['lampiran']): ?>
								<a href="<?=$this->config->item("dir_hv").$val['lampiran']?>" target="_blank">
									<span class="label label-info"><i class="fa fa-download">&nbsp;</i></span>
								</a>
							<?php else: echo "-"; endif; ?>
						</td>
						<td align="center">
							<?php 
								foreach($val as $k=>$v): 
									$ref[]	=	$k.":'".$v."'";
								endforeach;
								$ref[]	=	"tgl_hm:'".date("Y-m-d",strtotime($val["tgl_hm"]))."'";
								$ref[]	=	"tgl_hm_selector:'".date("d/m/Y",strtotime($val["tgl_hm"]))."'";
								$data_ref	=	join(',',$ref);
							?>
							<div class="btn-group btn-group-xs">
								<a class="btn btn-xs btn-default edit_data" data-toggle='tooltip' data-ref="{<?=$data_ref?>}" title="Edit"><i class="fa fa-pencil green"></i></a>
								<a class="btn btn-xs btn-default del_ajax" data-ref="{<?=$data_ref?>}">
									<i class="fa fa-remove red"></i>
								</a> 
							</div>
						</td>
					</tr>
				<?php endforeach;?>
			<?php else: ?>
				<tr>
					<td align="center"><i>--Belum Ada Kegiatan--</i></td>
				</tr>
			<?php endif;?>
		</table>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".del_ajax").click(function(e){
			
			var konfirmasi	=	confirm("Apakah Anda Yakin Akan Menghapus Data Ini?");
			
			if(konfirmasi==true){
				var del_url		=	'<?=$this->module?>delete_ajax';
				
				var string = $(this).data("ref");
				eval('var object='+string);
				var idx		=	object.idx;

				$.ajax({
					type		:	"POST",
					url			:	del_url,
					cache		:	false,
					data		:	object,
					success		:	function(result) {
						if (result){
							$("#tr_"+idx).remove();
							new PNotify({
								title	:	'Info',
								text	:	'Hapus Data Berhasil!',
								type	:	'success'
							});
							var length	=	$(".data_tbl tr").length;							
							if(length==0){
								$("#act").val("create");
							}
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
		$(".edit_data").on("click",function(){
			$(".title_form").text("Edit Data Pertemuan Kelompok");
				
			var string = $(this).data("ref");
			eval('var object='+string);
			
			<?php foreach($pasien_pk_history[0] as $k=>$v): ?>
			<?php if(($k!=="lampiran") && ($k!=="tgl_selesai")): ?>
			$("#<?=$k?>").val(object.<?=$k?>);		
			<?php endif; ?>
			<?php endforeach; ?>
			
			$("#id_hm").val(object.id_hm).change();
			$("#tgl_hm").val(object.tgl_hm);
			$("#tgl_hm_selector").val(object.tgl_hm_selector);
			
			var hsl_hm		=	object.hsl_hm;
			
			if(hsl_hm==1){
				$("#hsl_hm1").prop("checked",true);
				$("#hsl_hm2").prop("checked",false);
			}else{
				$("#hsl_hm1").prop("checked",false);
				$("#hsl_hm2").prop("checked",true);
			}
			
			var lampiran	=	object.lampiran;

			if(lampiran){
				var href	=	'<a href="<?=$this->config->item("dir_pk")?>'+lampiran+'" target="_blank">Unduh Lampiran</a>';
				$(".label_lampiran").html(href);
			}else{
				$(".label_lampiran").text('');
			}	
		});
		
		$(".add_clean").on("click",function(){
			$(".title_form").text("Tambah Data Pertemuan Kelompok");
			
			$("#idx").val('');
			$("#tgl_hm").val('<?=date("Y-m-d")?>');
			$("#tgl_hm_selector").val('<?=date("d/m/Y")?>');
			$("#id_hm").val("1").change();
			$("#hsl_hm1").prop("checked",true);
			$("#hsl_hm2").prop("checked",false);
			$("#keterangan").val("");			
			$("#notlp_keluarga").val("");
			$("#nm_keluarga").val("");
			$("#alamat").val("");
			$("#nm_petugas").val("");
			$("#lokasi_kegiatan").val("");	
			$("#jml_anggota").val("");		
			$(".label_lampiran").text("");
			
		});		
	});
</script>

<h4 class="heading">Tambah Data Pertemuan Kelompok</h4>

<form id="frm" method="post" enctype="multipart/form-data" action="<?php echo $this->module;?>update_proses/<?php echo $id;?>">
	<? if(cek_array($data_proses)):?>
		
    	<input type="hidden" name="act" id="act" value="update"/>
    <? else:?>
		<input type="hidden" name="act" id="act" value="create"/>
    <? endif;?>
		<input type="hidden" name="status_rm_sebelumnya" id="status_rm_sebelumnya" value="<?php echo $data["status_rm"];?>"/>
	<input type="hidden" name="status_program_sebelumnya" id="status_program_sebelumnya" value="<?php echo $data["status_program"];?>"/>
	<input type="hidden" name="outcome_pasien_sebelumnya" id="outcome_pasien_sebelumnya" value="<?php echo $data["outcome_pasien"];?>"/>
	
	<input type="hidden" name="idx_assesment" id="idx_assesment" value="<?=$data_asm["idx"]?>"/>
	<input type="hidden" name="no_rekam_medis" id="no_rekam_medis" value="<?=$data["no_rekam_medis"]?>"/>
    <input type="hidden" name="idx_pasien" id="idx_pasien" value="<?=$data["idx"]?>"/>
    <input type="hidden" name="idx" id="idx" />
    <div class="row">
    <div class="col-md-12">
		
		<?
		$new_hm[1] = $data_proses["tgl_hm1"]; 
		$new_hm[2] = $data_proses["tgl_hm2"]; 
		//$new_hm[3] = $data_proses["tgl_hm3"]; 
		//$new_hm[4] = $data_proses["tgl_hm4"];
		if($data_proses['tgl_kegiatan']):
			$kegiatan_selector	=	date_format(date_create($data_proses['tgl_kegiatan']),"d-m-Y");
			$kegiatan			=	date_format(date_create($data_proses['tgl_kegiatan']),"Y-m-d");
		else:
			$kegiatan_selector	=	date("d-m-Y");
			$kegiatan			=	date("Y-m-d");
		endif;
		
		?>			
		
		<div class="row" style="margin-bottom:10px;">
			<div class="col-sm-6">
				<label for="header-home">Pertemuan Kelompok Ke :</label>
				<select name="id_hm" class="form-control" id="id_hm">							
					<? 
						foreach($new_hm as $k=>$v){
							if($v != '')continue;
								$xcount[] = $v;
					?>
					<option value="<?=$k?>" <?=($data_proses['id_hm']==$k)?"selected":""?>>Pertemuan Kelompok Ke - <?=$k?></option>								
					<? }?>							
				</select>
			</div>
			
			<div class="col-sm-6">
				<?php
                	$tgl_hm=$data_proses["tgl_hm"]?$data_proses["tgl_hm"]:date("Y-m-d H:i:s");
                ?>				
                <label for="tgl_hm" id="id_kunjungan">Tanggal Pertemuan Kelompok</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_hm_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_hm))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
                     <input type="hidden" id="tgl_hm" name="tgl_hm" value="<?=date("Y-m-d",strtotime($tgl_hm));?>" class="required" />
                </div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<label for="hsl" id="hsl_kunjungan">Hasil Pertemuan Kelompok</label>
                <table style="margin-bottom:10px">
					<tr>
					<td><label>Positif [ <i class="fa fa-plus green"></i> ]  </label></td><td width="10"></td><td><input type="radio" <?=($data_proses["hsl_hm"]==1)? "checked" : ""?> name="hsl" value="1" id="hsl_hm1"></td><td width="30">
					<td><label>Negatif [ <i class="fa fa-minus red"></i> ]</label></td> <td width="10"></td><td><input type="radio" name="hsl" <?=($data_proses["hsl_hm"]==2)? "checked" : ""?> value="2" id="hsl_hm2"></td><td width="30">
					</tr>
				</table>
			</div>
			
			<div class="col-sm-6">
				<div class="well well-sm">
					**) Keterangan:<br /> [ <i class="fa fa-plus green"></i> ] Menunjukkan Hasil Evaluasi Baik <br />[ <i class="fa fa-minus red"></i> ] Menunjukkan Hasil Evaluasi Tidak Baik. 
				</div>
			</div>
		</div>
		
    	<div class="form-group">
                <label for="lokasi">Keterangan Pertemuan Kelompok</label>
				<textarea class="input-xs form-control" id="keterangan" rows="3" name="keterangan" placeholder=""><?=$data_proses["keterangan"]?></textarea>							
        </div>
		<div class="form-group">
                <label for="nm_petugas">Lokasi Kegiatan</label>
				<input type="text" class="form-control" name="lokasi_kegiatan" id="lokasi_kegiatan" value="<?=$data_proses["lokasi_kegiatan"]?>" />
		</div>
		<div class="form-group">
                <label for="nm_petugas">Jumlah Anggota Hadir</label>
				<input type="number" class="form-control" style="width:40%" name="jml_anggota" id="jml_anggota" value="<?=$data_proses["jml_anggota"]?>" />
		</div>
		<div class="form-group">
                <label for="nm_petugas">Nama PJ/Keluarga</label>
				<input type="text" class="form-control" name="nm_keluarga" id="nm_keluarga" value="<?=$data_proses["nm_keluarga"]?>" />
		</div>
		<div class="form-group">
                <label for="lokasi">Alamat </label>
				<textarea class="input-xs form-control" id="alamat" rows="3" name="alamat" placeholder=""><?=$data_proses["alamat"]?></textarea>							
        </div>
		
    
		<div class="form-group">
                <label for="nm_petugas">Nama Petugas</label>
				<input type="text" class="form-control" name="nm_petugas" id="nm_petugas" value="<?=$data_proses["nm_petugas"]?>" />
		</div>
		<div class="form-group">
                <label for="nm_petugas">Lampiran</label>
				<input type="file" name="lampiran" id="lampiran"  />
				<div class="label_lampiran">
                <?php if($data_proses["lampiran"]){?>
					File: <a target="_blank" href="<?=$this->config->item("dir_pk").$data_proses["lampiran"]?>">Download</a>
				<?php } ?>
				</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
                <label for="nama">Status Kegiatan</label>
				<?=form_dropdown("status_pasien",$lookup_status,
						$data_proses["status_pasien"],
						"id='status_pasien' 
						class='form-control select2 required'");?>
                </div>
				<div class="col-md-6 tgl_selesai">
					<?php
						$tgl_selesai=date("Y-m-d H:i:s");
					?>
					<label for="nama">Tgl Selesai Kegiatan</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="text" id="tgl_selesai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
						 <input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date("Y-m-d",strtotime($tgl_selesai));?>" class="required" />
					</div><!-- end input group -->
				</div>
			</div>
		</div>
		
		<div class="form-group status_prosesx">
								<div class="row">
									<div class="col-md-6">
									<label for="nama">Proses Berikutnya?</label>
									<?=form_dropdown("status_prosesx",$lookup_status_berikutnya,
											$data["status_proses"],
											"id='status_prosesx' 
											style='width:100%' class='form-control select2 required'");?>
									</div>
								</div>
							</div><!-- end form-->
							
							<div class="row">
								<div class="col-md-6">	
								</div>
							</div>
							
							<?php
								// $lookup["SS"]="Assesment";
								$lookup_proses_berikutnya=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
								$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
								$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
								$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
								$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
								$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
							?>
							<div class="form-group status_proses hidden">
								<label for="nama">Penempatan Berikutnya?</label>
								<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
										$kondisi["inst_pasca"],
										"id='status_proses' 
										class='form-control select2 required'");?>
							</div><!-- end form-->
							<div class="form-group bnnp hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='JALAN'):?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayah,$kondisi["rujuk_pasca"],"id='bnnp' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayah,$kondisi["rujuk_pasca"],"id='bnnp' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group bnnk hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='JALAN'):?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$kondisi["rujuk_pasca"],"id='bnnk' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$kondisi["rujuk_pasca"],"id='bnnk' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group balailoka hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $kondisi['inst_pasca']=='BL'):?>
									<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$kondisi["rujuk_pasca"],"id='balailoka' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$kondisi["rujuk_pasca"],"id='balailoka' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group km hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $kondisi['inst_pasca']=='KM'):?>
									<?=form_dropdown("id_km",$lookup_wilayah3,$kondisi["rujuk_pasca"],"id='km' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_km",$lookup_wilayah3,$kondisi["rujuk_pasca"],"id='km' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group rd hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $kondisi['inst_pasca']=='RD'):?>
									<?=form_dropdown("id_rd",$lookup_wilayah4,$kondisi["rujuk_pasca"],"id='rd' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_rd",$lookup_wilayah4,$kondisi["rujuk_pasca"],"id='rd' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
    </div></div><!-- end row col -->  
<!--</form>-->
<script>
	$(function() {
		$(".tgl_selesai").hide();
		$('#tgl_selesai').prop( "disabled", true );
		$('#tgl_selesai_selector').prop( "disabled", true );
		
		$(".tgl_selesai_program").hide();
		$('#tgl_selesai_program').prop( "disabled", true );
		$('#tgl_selesai_program_selector').prop( "disabled", true );
		
		$(".status_prosesx").hide();
		$('#status_prosesx').prop( "disabled", true );
		$("#status_pasien").on("change",function(){
			if($(this).find("option:selected").val()=='PS'){
				$(".tgl_selesai").hide();
				$('#tgl_selesai').prop( "disabled", true );
				$('#tgl_selesai_selector').prop( "disabled", true );
				
				$(".status_prosesx").hide();
				$('#status_prosesx').prop( "disabled", true );
			}else{
				$(".tgl_selesai").show();
				$('#tgl_selesai').prop( "disabled", false );
				$('#tgl_selesai_selector').prop( "disabled", false );
				
				$(".status_prosesx").show();
				$('#status_prosesx').prop( "disabled", false );
			}
		});
		$("#status_program").on("change",function(){
			if($(this).find("option:selected").val()=='PS'){
				$(".tgl_selesai_program").hide();
				$('#tgl_selesai_program').prop( "disabled", true );
				$('#tgl_selesai_program_selector').prop( "disabled", true );
			}else{
				$(".tgl_selesai_program").show();
				$('#tgl_selesai_program').prop( "disabled", false );
				$('#tgl_selesai_program_selector').prop( "disabled", false );
			}
		});

	});
	
</script>
<script>
	$(function() {
		var non = $('#status_proses').val();
		$("select").select2();
		if(non=='SS'){
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide(); 
			$('.km').hide(); 
			$('.rd').hide(); 
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
		}else if(non=='KM'){
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", false );
			$('#rd').prop( "disabled", true );
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide();	
			$('.km').show();	
			$('.rd').hide();
		}else if(non=='RD'){
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", false );
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide();	
			$('.km').hide();
			$('.rd').show();
		}else if(non=='BNNK'){
			$('#bnnk').prop( "disabled", false );
			$('#bnnp').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
			$('.bnnk').show(); 
			$('.bnnp').hide(); 
			$('.balailoka').hide();
			$('.km').hide();	
			$('.rd').hide();		
		}else if(non=='BNNP'){
			$('#bnnp').prop( "disabled", false );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
			$('.bnnp').show(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide();
			$('.km').hide();	
			$('.rd').hide();		
		}else if(non=='BL'){
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", false );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').show();
			$('.km').hide();	
			$('.rd').hide();		
		}
		$('#status_proses').change(function(){
			// alert($('#status_proses').val());
			if($('#status_proses').val() == 'BL') {
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", false );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('.balailoka').show(); 
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.km').hide();
				$('.rd').hide();		
			} else if($('#status_proses').val() == 'BNNP'){
				$('#bnnp').prop( "disabled", false );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('.bnnp').show(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide();
				$('.km').hide();	
				$('.rd').hide();		
			} else if($('#status_proses').val() == 'BNNK'){
				$('#bnnk').prop( "disabled", false );
				$('#bnnp').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('.bnnk').show(); 
				$('.bnnp').hide(); 
				$('.balailoka').hide();
				$('.km').hide();	
				$('.rd').hide();		

			} else if($('#status_proses').val() == 'KM'){//JALAN=BALAI/LOKA
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", false );
				$('#rd').prop( "disabled", true );
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide();	
				$('.km').show();	
				$('.rd').hide();		
			} else if($('#status_proses').val() == 'RD'){
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", false );
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide();	
				$('.km').hide();
				$('.rd').show();				
			} else {
				$('#bnnp').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('.balailoka').hide(); 
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.km').hide();	
				$('.rd').hide();					
			}
		});
	});
	// $("#balailoka").select2();
		// $("#km").select2({'placeholder':"--Pilih--"});
		// <?php if($data['status_rawat']=='JALAN' && $data['inst_rujuk']=='BNNP'):?>
			// $('.km').hide(); 
			// $('.bnnp').show(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']=='JALAN' && $data['inst_rujuk']=='BNNK'): ?>
			// $('.km').hide(); 
			// $('.bnnp').hide(); 
			// $('.bnnk').show(); 
			// $('.balailoka').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']==NULL): ?>
			// $('.bnnp').hide(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
		// <?php endif; ?>
		// <?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='BL'):?>
			// $('.balailoka').show(); 
			// $('.bnnp').hide();
			// $('.bnnk').hide(); 			
			// $('.km').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']==NULL): ?>
			// $('.bnnp').hide(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
			// $('.km').hide(); 
		// <?php endif; ?>
</script>