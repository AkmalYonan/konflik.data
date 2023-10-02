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
	
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	$lookup_proses_berikutnya["PRAP"]="Form Penerimaan Pasca";
	$lookup_proses_berikutnya["PRRIDA"]="Pasca Rehabilitasi Rawat Inap - Rumah Damping";
	$lookup_proses_berikutnya["PRRJPG"]="Pasca Rehabilitasi Rawat Jalan - BNNP/BNNK";
	$lookup_proses_berikutnya["PRRLPUKP"]="Pasca Rehabilitasi Rawat Lanjut";
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
				<input type="text" id="tgl_penerimaan_pascarehab_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_penerimaan_pascarehab))?>" placeholder="dd/mm/yyyy"/>
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
	   <h4 class="heading">Disclaimer</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nama">Status assesment?</label>
					<?=form_dropdown("status_check_doc",$lookup_status,
							$data["status_check_doc"],
							"id='status_check_doc' 
							class='form-control select2 required'");?>
				</div><!-- end form-->
				<div class="form-group tgl_selesai_assesment">
						<?php
						$tgl_selesai_asm=$data_asmHis["tgl_mulai_pasca"]?$data_asmHis["tgl_mulai_pasca"]:date("Y-m-d H:i:s");
						?>
						<label for="nama">Tgl Selesai</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input type="text" id="tgl_selesai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai_asm))?>" placeholder="dd/mm/yyyy"/>
							 <input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date("Y-m-d",strtotime($tgl_selesai_asm));?>" class="required" />
						</div><!-- end input group -->			
				</div><!-- end form group-->
				<div class="form-group">
					<label><input type="radio" checked class="rwt1" name="rawat" value="1"> RAWAT INAP/JALAN</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label><input type="radio" class="rwt2" name="rawat" value="2"> RAWAT LANJUT</label>
				</div><!-- end form-->
				<?php
			// $lookup["PRAP"]="Form Penerimaan Pasca";
			$lookup_proses_berikutnya=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
			$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
			$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
			$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
			$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
			$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
		?>
		<div class="form-group status_proses">
			<label for="nama">Proses Berikutnya?</label>
			<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
					$data["inst_pasca"],
					"id='status_proses' 
					class='form-control select2 required'");?>
		</div><!-- end form-->
		<div class="form-group bnnp">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='JALAN'):?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_pasca"],"id='bnnp' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_pasca"],"id='bnnp' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group bnnk">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='JALAN'):?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_pasca"],"id='bnnk' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_pasca"],"id='bnnk' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group balailoka">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='BL'):?>
				<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_pasca"],"id='balailoka' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_pasca"],"id='balailoka' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group km">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='KM'):?>
				<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_pasca"],"id='km' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_pasca"],"id='km' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group rd">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='RD'):?>
				<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_pasca"],"id='rd' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_pasca"],"id='rd' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
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
		
		var non = $('#status_proses').val();
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
			} else if($('#status_proses').val() == 'RL'){
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