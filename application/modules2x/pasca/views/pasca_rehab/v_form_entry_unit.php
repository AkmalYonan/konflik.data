<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	
	$lookup_pertemuan[1]="1";
	$lookup_pertemuan[2]="2";
	$lookup_pertemuan[3]="3";
	$lookup_pertemuan[4]="4";
	
	$lookhasil[1] ="TIdak Produktif";
	$lookhasil[2] ="Family Issue";
	$lookhasil[3] ="Social ";
	$lookhasil[4] ="Environment Issue";
	$lookhasil[5] ="Hukum";

	$lookup_status[0]="Belum diperiksa"; //menunggu verifikasi
	$lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	$lookup_status[2]="Selesai"; //menunggu rekam medik
	$lookup_status[9]="DiTolak";  
	
	$lookup_status_proses_rujuk_rujuk=lookup("m_proses_rehab","kd_status_proses_rujuk_rujuk","ur_proses","","order by kd_status_rehab,order_num");
	
	//pre($monitoring_rehab);
	$tgl_limit_prev = $monitoring_rehab['tgl_selesai_rehab'];
?>

<form id="frm" method="post" enctype="multipart/form-data" action="<?php echo $this->module;?>update_proses/<?php echo $id;?>">
	<? if(cek_array($data_proses)):?>
		
    	<input type="hidden" name="act" id="act" value="update"/>
    <? else:?>
		<input type="hidden" name="act" id="act" value="create"/>
    <? endif;?>
	<input type="hidden" name="idx_assesment" id="idx_assesment" value="<?=$data_asm["idx"]?>"/>
	<input type="hidden" name="no_rekam_medis" id="no_rekam_medis" value="<?=$data["no_rekam_medis"]?>"/>
    <input type="hidden" name="idx_pasien" id="idx_pasien" value="<?=$data["idx"]?>"/>
    <input type="hidden" name="idx" id="idx" value="<?=$data_proses["idx"]?>"/>
    <div class="row">
    <div class="col-md-12">
    	<!-- <div class="form-group">
            <?php
                $tgl_kegiatan=$data_proses["tgl_kegiatan"]?$data_proses["tgl_kegiatan"]:date("Y-m-d H:i:s");
                                ?>
                <label for="nama">Tgl Kegiatan</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_kegiatan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_kegiatan))?>" placeholder="dd/mm/yyyy"/>
                     <input type="hidden" id="tgl_kegiatan" name="tgl_kegiatan" value="<?=date("Y-m-d",strtotime($tgl_kegiatan));?>" class="required" />
                </div>
                            
        </div>end form group-->
    
    	<div class="form-group">
            <label for="resume">Resume Rehabilitasi dan Rekomendasi Jenis Layanan Rehabilitasi</label>
            <input class="form-control required" name="resume_rehab" id="resume_rehab" type="text" value="<?php echo $data_proses["resume_rehab"];?>" />
        </div>
		
		<? if($data_proses["hasil_assesment"]):
				$arr_hsl =explode(",",$data_proses["hasil_assesment"]);	
			endif;
		?>
		
        <div class="form-group">
            <label for="hasil_assement">Hasil Assesment</label>
            <br />
			<div class="row" style="margin-left:-55px !important;">
			<div class="col-md-6">
			<ul style="list-style:none !important;">
			<table>
			<? foreach($lookhasil as $k=>$v):?>
			<tr><li><td><label><?=$v?></label></td> <td width="40"></td><td><input type="checkbox"  <?=(in_array($k,$arr_hsl))? "Checked":""?>  name="hasil_assesmentx[]" value="<?=$k?>"></td></li></tr>
			<? endforeach?>
			</table>
			</ul>
			</div>
			
			</div>
		</div>
		<div class="form-group">
            <label for="jns_ketrampilan">Jenis Keterampilan Teknis Yang Dimiliki</label>
            <input class="form-control required" name="ketrampilan" id="ketrampilan" type="text" value="<?php echo $data_proses["ketrampilan"];?>" />
        </div>
		 <div class="form-group">
            <label for="tinjauan">Tinjauan Rencana Terapi</label>
            <br />
			<div class="row" >
			<div class="col-md-12">
			<table style="margin-bottom:10px">
			<tr>
			<td><label>Sesuai  </label></td><td width="10"></td><td><input type="radio" <?=($data_proses["tinjauan_rencana_terapi"]==1)? "checked" : ""?> name="tinjauan_rencana_terapi" value="1"></td><td width="30">
			<td><label>Tidak Sesuai</label></td> <td width="10"></td><td><input type="radio" name="tinjauan_rencana_terapi" <?=($data_proses["tinjauan_rencana_terapi"]==2)? "checked" : ""?> value="2"></td><td width="30">
			<td><label>Sedang Berlangsung</label></td> <td width="10"></td><td><input type="radio" name="tinjauan_rencana_terapi" <?=($data_proses["tinjauan_rencana_terapi"]==3)? "checked" : ""?> value="3"></td><td width="30"></tr>
			
			</table>
			</div>
			
		</div>
    	<div class="form-group">
            <?php
                $tgl_penerimaan_pascarehab=$data_proses["tgl_penerimaan_pascarehab"]?$data_proses["tgl_penerimaan_pascarehab"]:date("Y-m-d H:i:s");
            ?>
			<label for="tgl_rehab">Tgl Penerimaan Pasca Rehab</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				<input type="text" id="tgl_penerimaan_pascarehab_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_penerimaan_pascarehab))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
				 <input type="hidden" id="tgl_penerimaan_pascarehab" name="tgl_penerimaan_pascarehab" value="<?=date("Y-m-d",strtotime($tgl_penerimaan_pascarehab));?>" class="required" />
			</div>                   
        </div>
    	<div class="form-group">
			<label for="keterangan">Keterangan</label>
			<textarea class="input-xs form-control" id="keterangan" rows="3" name="keterangan" placeholder=""><?=$data_proses["keterangan"]?></textarea>							
        </div>
		<div class="form-group">
			<label for="nama">Lampiran</label>
			<input type="file" name="lampiran">
			<?php if($data_proses["lampiran"]){?>
				File: <a target="_blank" href="<?=$this->config->item("dir_penerimaan_pasca").$data_proses["lampiran"]?>">Download</a>
			<?php } ?>
		</div><!-- end form-->
		
		<?php
			$lookup_empty[0]="--Pilih--";
			$lookup_empty2[0]="--Pilih--";
			$lookup_wilayah=$lookup_empty+lookup("m_org","kd_wilayah_propinsi","nama","(tipe_org='BNNP' or tipe_org='BNNK') and active=1","order by kd_wilayah_propinsi");
			$lookup_wilayah2=$lookup_empty2+lookup("m_instansi","id_kabupaten","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
		?>
	   <h4 class="heading">Konfirmasi</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nama">Status assesment?</label>
					<?=form_dropdown("status_check_doc",$lookup_status,
							$data["status_check_doc"],
							"id='status_check_doc' 
							class='form-control select2 required'");?>
				</div><!-- end form-->
				
				<script>
					$(document).ready(function(){
						$("#status_check_doc").on("change",function(){
							var val	=	$(this).val();
							
							if(val==2){
								$(".rujukan_group").removeClass("hide");
							}else{
								$(".rujukan_group").addClass("hide");
							}
						});
					});
				</script>
				
				<div class="rujukan_group hide">
							<div class="form-group tgl_selesai_assesment">
									<?php
									$tgl_selesai_asm=$data_asmHis["tgl_mulai_pasca"]?$data_asmHis["tgl_mulai_pasca"]:date("Y-m-d H:i:s");
									?>
									<label for="nama">Tgl Selesai</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" id="tgl_selesai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai_asm))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
										 <input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date("Y-m-d",strtotime($tgl_selesai_asm));?>" class="required" />
									</div><!-- end input group -->			
							</div><!-- end form group-->
							
							<?php
								
								if(($data["inst_pasca"]=="BL") or ($data["inst_pasca"]=="RD") or ($data["inst_pasca"]=="KM")):
									$checked_status1	=	"checked='checked'";
									$checked_status2	=	"";
								else:
									$checked_status1	=	"";
									$checked_status2	=	"checked='checked'";
								endif;
								
							?>
							
						<div class="form-group">
							<label>Proses Selanjutnya</label><br />
							<input type="radio" class="rwt" name="rawat" value="1" <?=$checked_status1?>> Rawat Inap - Daily Activity<br />
							<input type="radio" class="rwt" name="rawat" value="2" <?=$checked_status2?>> Rawat Jalan - Peer Group<br />
							<input type="radio" class="rwt" name="rawat" value="3"> Rawat Lanjut - Pemantauan - Kegiatan Produktif
						</div><!-- end form-->				
						<?php
						
						$lookup_proses_berikutnya=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
						
						$lookup_proses_berikutnya1=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='18' or idx='19' or idx='20'","order by idx,order_num");
						
						$lookup_proses_berikutnya2=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16'","order by idx,order_num");
						
						$lookup_proses_berikutnya3=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
						
						$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
						$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
						$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
						$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
						$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
					?>
					
					<div class="form-group status_proses rujukan_criteria1">
						<label for="nama">Tempat Rujukan</label>
						
						<?
						if($data["inst_pasca"]=="BL" or $data["inst_pasca"]=="RD" or $data["inst_pasca"]=="KM"):
							$hide1	=	"";
							$hide2	=	"hide";
							$hide3	=	"hide";
						else:
							$hide1	=	"hide";
							$hide2	=	"";
							$hide3	=	"hide";
						endif;
						?>
						
						<div class="rujukan1 <?=$hide1?>">
						<?=form_dropdown("",$lookup_proses_berikutnya1,
								$data["inst_pasca"],
								"id='status_proses_rujuk1' class='form-control select2 required status_proses_rujuk1' style='width:100%'");?>
						</div>
						
						<div class="rujukan2 <?=$hide2?>">
						<?=form_dropdown("",$lookup_proses_berikutnya2,
								$data["inst_pasca"],
								"id='status_proses_rujuk2' class='form-control select2 required status_proses_rujuk2' style='width:100%'");?>
						</div>
						
						<div class="rujukan3 <?=$hide3?>">
						<?=form_dropdown("",$lookup_proses_berikutnya3,
								"",
								"id='status_proses_rujuk3' class='form-control select2 required status_proses_rujuk3' style='width:100%'");?>
						</div>
						
						<input type="hidden" name="status_proses" value="<?=$data['inst_pasca']?>" id="status_proses_val" />											
					</div><!-- end form-->					
							
							<script>
								$(document).ready(function(){
									
									$(".rwt").on("change",function(){
										var val_rwt	=	$(this).val();
										
										if(val_rwt==1){
											
											<?php if($data["inst_pasca"]=="BL"): ?>								
												$("#status_proses_val").val("BL");
											<?php elseif($data["inst_pasca"]=="KM"): ?>
												$("#status_proses_val").val("KM");
											<?php elseif($data["inst_pasca"]=="RD"): ?>
												$("#status_proses_val").val("RD");
											<?php else: ?>
												$("#status_proses_val").val("BL");
											<?php endif; ?>
											
											$("#status_proses_rujuk1").on("change",function(){
												$("#status_proses_val").val($(this).val());
											});
										}else if(val_rwt==2){
											
											<?php if($data["inst_pasca"]=="BNNP"): ?>	
												$("#status_proses_val").val("BNNP");
											<?php elseif($data["inst_pasca"]=="BNNK"): ?>
												$("#status_proses_val").val("BNNK");
											<?php else: ?>
												$("#status_proses_val").val("BNNP");
											<?php endif; ?>	
											
											$("#status_proses_rujuk2").on("change",function(){
												$("#status_proses_val").val($(this).val());
											});
											
										}else if(val_rwt==3){
											
											$("#status_proses_val").val("BNNP");
											
											$("#status_proses_rujuk3").on("change",function(){
												$("#status_proses_val").val($(this).val());
											});
										}
										
									});
								
								});
							</script>
							
							<script>
								$(document).ready(function(){
									$(".rwt").on("change",function(){
										var val	=	$(this).val();
										
										if(val==1){
											
											var inst1	=	'<?=$data['inst_pasca']?>';
											
											$(".rujukan1").removeClass('hide').prop("disabled",false);
											$(".rujukan2").addClass('hide').prop("disabled",true);
											$(".rujukan3").addClass('hide').prop("disabled",true);
											
											if(inst1=="BL"){
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
											}else if(inst1=="KM"){
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
											}else if(inst1=="RD"){
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
											}else{
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
											
										}else if(val==2){
											$(".rujukan1").addClass('hide').prop("disabled",true);
											$(".rujukan2").removeClass('hide').prop("disabled",false);
											$(".rujukan3").addClass('hide').prop("disabled",true);
											
											var inst2	=	'<?=$data['inst_pasca']?>';
											
											if(inst2=="BNNP"){
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
											}else if(inst2=="BNNK"){
												$('#bnnp').prop( "disabled", true );
												$('#bnnk').prop( "disabled", false );
												$('#balailoka').prop( "disabled", true );
												$('#km').prop( "disabled", true );
												$('#rd').prop( "disabled", true );
												$('.bnnp').hide(); 
												$('.bnnk').show(); 
												$('.balailoka').hide();
												$('.km').hide();	
												$('.rd').hide();
											}else{
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
											}
											
										}else if(val==3){
											$(".rujukan1").addClass('hide').prop("disabled",true);
											$(".rujukan2").addClass('hide').prop("disabled",true);
											$(".rujukan3").removeClass('hide').prop("disabled",false);
											
											$('#bnnp').prop( "disabled", false);
											$('#bnnk').prop( "disabled", true);
											$('#balailoka').prop( "disabled", true);
											$('#km').prop( "disabled", true );
											$('#rd').prop( "disabled", true );
											$('.bnnp').show(); 
											$('.bnnk').hide(); 
											$('.balailoka').hide();
											$('.km').hide();	
											$('.rd').hide();
											
										}
									});
								});
							</script>
							
					<script>
						$(document).ready(function(){
							var inst	=	'<?=$data['inst_pasca']?>';
							
							if(inst=='BNNP'){
								$(".bnnp").show();
								$(".bnnk").hide();
								$(".balailoka").hide();
								$(".km").hide();
								$(".rd").hide();
							}else if(inst=='BNNK'){
								$(".bnnp").hide();
								$(".bnnk").show();
								$(".balailoka").hide();
								$(".km").hide();
								$(".rd").hide();
							}else if(inst=='BL'){
								$(".bnnp").hide();
								$(".bnnk").hide();
								$(".balailoka").show();
								$(".km").hide();
								$(".rd").hide();
							}else if(inst=='KM'){
								$(".bnnp").hide();
								$(".bnnk").hide();
								$(".balailoka").hide();
								$(".km").show();
								$(".rd").hide();
							}else if(inst=="RD"){
								$(".bnnp").hide();
								$(".bnnk").hide();
								$(".balailoka").hide();
								$(".km").hide();
								$(".rd").show();
							}
							
						});
					</script>					
					
					<div class="form-group bnnp">
						<label for="nama">Instansi</label>
						<?php if($data["inst_pasca"]=="BNNP"):?>
							<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_pasca"],"id='bnnp' class='form-control select2 required' style='width:100%'");?>
						<?php else: ?>
							<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_pasca"],"id='bnnp' disabled class='form-control select2 required' style='width:100%'");?>
						<?php endif; ?>
					</div>
					
					<div class="form-group bnnk">
						<label for="nama">Instansi</label>
						<?php if($data["inst_pasca"]=="BNNK"):?>
							<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_pasca"],"id='bnnk' class='form-control select2 required' style='width:100%'");?>
						<?php else: ?>
							<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_pasca"],"id='bnnk' disabled class='form-control select2 required' style='width:100%'");?>
						<?php endif; ?>
					</div>
			
					<div class="form-group balailoka">
						<label for="nama">Instansi</label>
						<?php if($data["inst_pasca"]=="BL"):?>
							<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_pasca"],"id='balailoka' class='form-control select2 required' style='width:100%'");?>
						<?php else: ?>
							<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_pasca"],"id='balailoka' disabled class='form-control select2 required' style='width:100%'");?>
						<?php endif; ?>
					</div>
					
					<div class="form-group km">
						<label for="nama">Instansi</label>
						<?php if($data["inst_pasca"]=="KM"):?>
							<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_pasca"],"id='km' class='form-control select2 required' style='width:100%'");?>
						<?php else: ?>
							<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_pasca"],"id='km' disabled class='form-control select2 required' style='width:100%'");?>
						<?php endif; ?>
					</div>
							
					<div class="form-group rd">
						<label for="nama">Instansi</label>
						<?php if($data["inst_pasca"]=="RD"):?>
							<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_pasca"],"id='rd' class='form-control select2 required' style='width:100%'");?>
						<?php else: ?>
							<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_pasca"],"id='rd' disabled class='form-control select2 required' style='width:100%'");?>
						<?php endif; ?>
					</div>
					
				</div>	
		
			</div>
				
		</div>
		
	  </div>				
	</div><!-- end row col -->  
</form>
<script>
	$(function() {	
		$('.tgl_selesai_assesment').hide(); 
		$('#tgl_selesai_assesment').prop( "disabled", true );
		<?php if($data_asmHis["tgl_mulai_pasca"] !=''){?>
			// alert("deiiii");
			$('#tgl_selesai_assesment').prop( "disabled", false );
			$('.tgl_selesai_assesment').show(); 
		<?php } ?>
		$("#status_check_doc").on("change",function(){
			if($(this).val()==2){
				$('.tgl_selesai_assesment').show(); 
				$('#tgl_selesai_assesment').prop( "disabled", false );
			}else{
				$('.tgl_selesai_assesment').hide(); 
				$('#tgl_selesai_assesment').prop( "disabled", true );	
			}
		});
		
		var non = $('.status_proses_rujuk').val();
		$("select").select2();
		// alert(non);
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
		
		$(".status_proses_rujuk_1").on("change",function(){
			
			var non1 = $('.status_proses_rujuk1').val();
			$("select").select2();
			alert(non1);
			if(non1=='SS'){
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
			}else if(non1=='KM'){
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
			}else if(non1=='RD'){
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
			}else if(non1=='BNNK'){
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
			}else if(non1=='BNNP'){
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
			}else if(non1=='BL'){
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
		});
		
		$(".status_proses_rujuk_2").on("change",function(){
			
			var non2 = $('.status_proses_rujuk2').val();
			$("select").select2();
			//alert(non2);
			if(non2=='SS'){
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
			}else if(non2=='KM'){
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
			}else if(non2=='RD'){
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
			}else if(non2=='BNNK'){
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
			}else if(non2=='BNNP'){
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
			}else if(non2=='BL'){
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
		});
		
		$(".status_proses_rujuk_3").on("change",function(){
			var non3 = $('.status_proses_rujuk3').val();
			$("select").select2();
			//alert(non3);
			if(non3=='SS'){
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
			}else if(non3=='KM'){
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
			}else if(non3=='RD'){
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
			}else if(non3=='BNNK'){
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
			}else if(non3=='BNNP'){
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
			}else if(non3=='BL'){
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
		});						
		
		$('.status_proses_rujuk').change(function(){
			//alert($('.status_proses_rujuk').val());
			if($('.status_proses_rujuk').val() == 'BL') {
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
			} else if($('.status_proses_rujuk').val() == 'BNNP'){
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
			} else if($('.status_proses_rujuk').val() == 'BNNK'){
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

			} else if($('.status_proses_rujuk').val() == 'KM'){//JALAN=BALAI/LOKA
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
			} else if($('.status_proses_rujuk').val() == 'RD'){
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
			} else if($('.status_proses_rujuk').val() == 'RL'){
				// $('#bnnp').prop( "disabled", true );
				// $('#balailoka').prop( "disabled", true );
				// $('#km').prop( "disabled", true );
				// $('#rd').prop( "disabled", true );
				// $('#bnnk').prop( "disabled", true );
				$('.balailoka').show(); 
				$('.bnnp').show(); 
				$('.bnnk').show(); 
				$('.km').show();	
				$('.rd').show();					
			}
		});
		
		$('.status_proses_rujuk1').change(function(){
			//alert($(this).val());
			if($(this).val() == 'BL') {
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
			} else if($(this).val() == 'BNNP'){
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
			} else if($(this).val() == 'BNNK'){
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

			} else if($(this).val() == 'KM'){//JALAN=BALAI/LOKA
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
			} else if($(this).val() == 'RD'){
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
			} else if($(this).val() == 'RL'){
				// $('#bnnp').prop( "disabled", true );
				// $('#balailoka').prop( "disabled", true );
				// $('#km').prop( "disabled", true );
				// $('#rd').prop( "disabled", true );
				// $('#bnnk').prop( "disabled", true );
				$('.balailoka').show(); 
				$('.bnnp').show(); 
				$('.bnnk').show(); 
				$('.km').show();	
				$('.rd').show();					
			}
		});
		
		$('.status_proses_rujuk2').change(function(){
			
			if($(this).val() == 'BL') {
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
			} else if($(this).val() == 'BNNP'){
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
			} else if($(this).val() == 'BNNK'){
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

			} else if($(this).val() == 'KM'){//JALAN=BALAI/LOKA
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
			} else if($(this).val() == 'RD'){
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
			} else if($(this).val() == 'RL'){
				// $('#bnnp').prop( "disabled", true );
				// $('#balailoka').prop( "disabled", true );
				// $('#km').prop( "disabled", true );
				// $('#rd').prop( "disabled", true );
				// $('#bnnk').prop( "disabled", true );
				$('.balailoka').show(); 
				$('.bnnp').show(); 
				$('.bnnk').show(); 
				$('.km').show();	
				$('.rd').show();					
			}
		});	
		
		$('.status_proses_rujuk3').change(function(){
			//alert($(this).val());
			if($(this).val() == 'BL') {
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
			} else if($(this).val() == 'BNNP'){
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
			} else if($(this).val() == 'BNNK'){
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

			} else if($(this).val() == 'KM'){//JALAN=BALAI/LOKA
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
			} else if($(this).val() == 'RD'){
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
			} else if($(this).val() == 'RL'){
				// $('#bnnp').prop( "disabled", true );
				// $('#balailoka').prop( "disabled", true );
				// $('#km').prop( "disabled", true );
				// $('#rd').prop( "disabled", true );
				// $('#bnnk').prop( "disabled", true );
				$('.balailoka').show(); 
				$('.bnnp').show(); 
				$('.bnnk').show(); 
				$('.km').show();	
				$('.rd').show();					
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