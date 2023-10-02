<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?php
	$lookup_status["PS"]="Proses";
	$lookup_status["SL"]="Selesai";  
	
	$lookup_status_p["PS"]="Proses"; 
	$lookup_status_p["DO"]="DO";
	$lookup_status_p["MD"]="Meninggal Dunia";
	// $lookup_status[0]="Belum diperiksa"; //menunggu verifikasi
	// $lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	// $lookup_status[2]="Selesai"; //menunggu rekam medik
	// $lookup_status[9]="DiTolak";  
	
	// $lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	// $lookup_proses_current["SS"]="Assesment";
	// $lookup_proses_berikutnya=$lookup_proses_current+lookup("m_proses_rehab","kd_status_proses","ur_proses","kd_status_rehab=2 and flag_proses=1","order by kd_status_rehab,order_num");
?>	
<form id="frm" method="post" enctype="multipart/form-data" action="<?php echo $this->module;?>update_detox/<?php echo $id;?>">
    <? if(cek_array($data_detox)):?>
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
    <input type="hidden" name="idx" id="idx" value="<?=$data_detox["idx"]?>"/>
    <div class="row">
    <div class="col-md-12">
    	<!--
		<div class="form-group">
            <?php
                //$tgl_kegiatan=$data_detox["tgl_kegiatan"]?$data_detox["tgl_kegiatan"]:date("Y-m-d H:i:s");
            ?>
                <label for="nama">Tgl Kegiatan</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_kegiatan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_kegiatan))?>" placeholder="dd/mm/yyyy"/>
                     <input type="hidden" id="tgl_kegiatan" name="tgl_kegiatan" value="<?//=date("Y-m-d",strtotime($tgl_kegiatan));?>" class="required" />
                </div>           
        </div>
		-->
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<?php
					$tgl_mulai=$data_detox["tgl_mulai"]?$data_detox["tgl_mulai"]:date("Y-m-d H:i:s");
					?>
					<label for="nama">Tgl Kegiatan</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="text" id="tgl_mulai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_mulai))?>" placeholder="dd/mm/yyyy"/>
						 <input type="hidden" id="tgl_mulai" name="tgl_mulai" value="<?=date("Y-m-d",strtotime($tgl_mulai))?>" class="required" />
					</div><!-- end input group -->
				</div>
				<div class="col-md-6">
					<label for="kd_jenis_instansi">Lama Detoksifikasi</label> 
					<div class="input-group">
						<input class="form-control required" name="lama_detox" id="lama_detox" value="<?php echo $data_detox["lama_detox"];?>" type="text">
						<span class="input-group-addon"><strong>Hari</strong></span>
					</div>
				</div>
			</div>
        </div><!-- end form group-->
		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
				  <label for="jenis_kegiatan">Jenis Kegiatan</label>
				  <input class="form-control required" name="jenis_kegiatan" id="jenis_kegiatan" type="text" value="<?php echo $data_detox["jenis_kegiatan"];?>" />
				</div>
			</div>
		</div>
    	<div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<label for="alamat">Keterangan</label>
					<textarea class="input-xs form-control" id="keterangan" rows="3" name="keterangan" placeholder=""><?=$data_detox["keterangan"]?></textarea>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="nama">Lampiran</label>
			<input type="file" name="lampiran">
			<?php if($data_detox["lampiran"]){?>
				File: <a target="_blank" href="<?=$this->config->item("dir_detok").$data_detox["lampiran"]?>">Download</a>
			<?php } ?>
		</div><!-- end form-->
		
		<h4 class="heading">Konfirmasi</h4>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label for="nama">Status Kegiatan</label>
					<?=form_dropdown("status_pasien",$lookup_status,
							$data_detox["status_pasien"],
							"id='status_pasien' 
							class='form-control select2 required'");?>
				</div>
				<div class="col-md-6 tgl_selesai">
					<?php
						$tgl_selesai=$data_detox["tgl_selesai"]?$data_detox["tgl_selesai"]:date("Y-m-d H:i:s");
					?>
					<label for="nama">Tgl Selesai Kegiatan</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="text" id="tgl_selesai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai))?>" placeholder="dd/mm/yyyy"/>
						 <input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date("Y-m-d",strtotime($tgl_selesai));?>" class="required" />
					</div><!-- end input group -->
				</div>
			</div>
		</div><!-- end form-->

		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label for="nama">Status Program</label>
					<?=form_dropdown("status_program",$lookup_status_p,
							$data_detox["status_program"],
							"id='status_program' 
							class='form-control select2 required'");?>
				</div>
				<div class="col-md-6 tgl_selesai_program">
					<?php
						$tgl_selesai_program=date("Y-m-d H:i:s");
					?>
					<label for="nama">Tgl Selesai Program</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="text" id="tgl_selesai_program_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai_program))?>" placeholder="dd/mm/yyyy"/>
						 <input type="hidden" id="tgl_selesai_program" name="tgl_selesai_program" value="<?=date("Y-m-d",strtotime($tgl_selesai_program));?>" class="required" />
					</div><!-- end input group -->
				</div>
			</div>
		</div><!-- end form-->
		
		
		
		<?php
			$lookup["SS"]="Assesment";
			$lookup_proses_berikutnya=$lookup+lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
			$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
			$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
			$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
			$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
			$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
		?>
		<div class="form-group status_proses hidden">
			<label for="nama">Proses Berikutnya?</label>
			<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
					$data["inst_rujuk"],
					"id='status_proses' 
					class='form-control select2 required'");?>
		</div><!-- end form-->
		<div class="form-group bnnp hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='JALAN'):?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group bnnk hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='JALAN'):?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group balailoka hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='BL'):?>
				<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group km hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='KM'):?>
				<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group rd hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='RD'):?>
				<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		
		
		<!--
		<h4 class="heading">Disclaimer</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nama">Status Detox?</label>
					<?//=form_dropdown("status_check_doc",$lookup_status,
							//$data["status_check_doc"],
							//"id='status_check_doc' 
							//class='form-control select2 required'");?>
				</div>
				<div class="form-group status_proses">
					<label for="nama">Proses Berikutnya?</label>
					<?//=form_dropdown("status_proses",$lookup_proses_berikutnya,
							//$data["status_proses"],
							//"id='status_proses' 
							//class='form-control select2 required'");?>
				</div>
			</div>
		</div>
		-->
		<!--
    	<div class="row">
			<div class="col-md-6">
				<div class="form-actions">
					<button type="submit" class="btn btn-primary">Save changes</button>
					<button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
				</div>
			</div>
		</div>
		-->
    
    </div></div><!-- end row col -->  
</form>
<script>
	$(function() {
		$(".tgl_selesai").hide();
		$('#tgl_selesai').prop( "disabled", true );
		$('#tgl_selesai_selector').prop( "disabled", true );
		
		$(".tgl_selesai_program").hide();
		$('#tgl_selesai_program').prop( "disabled", true );
		$('#tgl_selesai_program_selector').prop( "disabled", true );
		$("#status_pasien").on("change",function(){
			if($(this).find("option:selected").val()=='PS'){
				$(".tgl_selesai").hide();
				$('#tgl_selesai').prop( "disabled", true );
				$('#tgl_selesai_selector').prop( "disabled", true );
			}else{
				$(".tgl_selesai").show();
				$('#tgl_selesai').prop( "disabled", false );
				$('#tgl_selesai_selector').prop( "disabled", false );
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
<?
function IntervalDays($CheckIn,$CheckOut){
			$CheckInX 	= 	explode("-", $CheckIn);
			$CheckOutX 	=  	explode("-", $CheckOut);
			
			$date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
			$date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
			//pre($date1);pre($date2);exit;
			$interval =($date2 - $date1)/(3600*24);
			// returns numberofdays
			return  $interval ;
		}
?>
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
<script>
	$("#a_hitung_umur").click(function(e){
		e.preventDefault();
		hitung_umur();	
	})
	
	function hitung_umur(){
		var dob = new Date($("#tgl_lahir").val());
        var today = new Date();
		alert(dob);
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        $('#umur').val(age);	
	}
	
	///function IntervalDays(){
	//	var date1 = $("#tgl_mulai").val();
	///	var date2 = $("#tgl_selesai").val();

	//	arr1 = date1.split('-');
	//	alert(arr1[0]);
        //var numD1 = <?php mktime()?>;
	//	var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
    //   $('#umur').val(age);	
	//}
</script>