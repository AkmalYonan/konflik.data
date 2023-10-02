<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_status[0]="Belum diperiksa"; //menunggu verifikasi
	$lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	$lookup_status[2]="Selesai"; //menunggu rekam medik
	$lookup_status[9]="Di tolak";  
	// debug();
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	//$lookup["SS"]="Assesment";
	$lookup["RIRMDT"]="Rawat Inap - Detox";
	$lookup["RJKL"]="Rawat Jalan - Konseling";
	$lookup_proses_berikutnya=$lookup;
	//$lookup_proses_berikutnya=$lookup+lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
	$lookup_instansi_rujuk=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
	// exit;
	// $lookup_proses_berikutnya["SS"]="Assesment";
	// $lookup_proses_berikutnya["KM"]="Komponen Masyarakat";
	// $lookup_proses_berikutnya["RD"]="Rumah Damping";
	// $lookup_proses_berikutnya["BBNR"]="Rawat Inap - BALAI/LOKA";
	// $lookup_proses_berikutnya["RJKL"]="Rawat Jalan - BNNP/BNNK";
	// $lookup_proses_berikutnya=$lookup_proses_current+lookup("m_proses_rehab","kd_status_proses","ur_proses","kd_status_rehab=2 and flag_proses=1","order by kd_status_rehab,order_num");
?>	
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
                    <a class="btn btn-white" href="<?php echo $this->module?>summary/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                   <a class="btn btn-white hidden" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="Print Preview">
                        <i class="fa fa-print blue"></i>
                    </a>
                    
                    <!--<a class="btn btn-white btn-delete" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="Cancel/Back To List">
                        <i class="fa fa-remove"></i>
                    </a>	-->  
            </div>
			<form id="frm" method="post" action="<?php echo $this->module;?>summary/<?php echo $id;?>">	
        	<div class="box box-widget">
            	<!--<div class="box-header with-border">
                  <h3 class="box-title">Data User</h3>
                </div>-->
                <div class="box-body">
                <!-- Data Pasien -->
				<ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#home">Data Resume Assesment</a></li>
				  <li><a data-toggle="tab" href="#menu1">Data Pasien</a></li>
				</ul>
					
				  <div class="tab-content">
					<div id="home" class="tab-pane fade in active">
						<br>
							<input type="hidden" name="status_rm_sebelumnya" id="status_rm_sebelumnya" value="<?php echo $data["status_rm"];?>"/>
							<input type="hidden" name="status_program_sebelumnya" id="status_program_sebelumnya" value="<?php echo $data["status_program"];?>"/>
							<input type="hidden" name="outcome_pasien_sebelumnya" id="outcome_pasien_sebelumnya" value="<?php echo $data["outcome_pasien"];?>"/> 
						
						  <input type="hidden" name="act" id="act" value="update"/>
						  <input type="hidden" name="tgl_registrasi" id="tgl_registrasi" value="<?php echo $data["tgl_registrasi"];?>"/>
						  <input type="hidden" name="no_rekam_medis" id="no_rekam_medis" value="<?php echo $data["no_rekam_medis"];?>"/>
						 <input type="hidden" name="idx_assesment" id="idx_assesment" value="<?php echo $data_assesment["idx"];?>"/>
						 
						 <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
						  <input type="hidden" name="idx_pasien" id="id_pasien" value="<?=$data["idx"]?>"/>
						  <!-- FORM STATUS -->	
						  <input type="hidden" name="status_rehab" id="status_rehab" value="1"/>
						  <!--<input type="hidden" name="status_proses" id="status_proses" value="<?=$data["status_proses"]?>"/>-->
						  <?=$this->load->view("v_form_assesment")?>
						  
							<?php
								$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
								$lookup_wilayah=$lookup_empty+$lookup_wilayah;
								$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
								$lookup_wilayahx=$lookup_empty+$lookup_wilayahx;
								$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
								$lookup_wilayah2=$lookup_empty+$lookup_wilayah2;
								$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
								$lookup_wilayah3=$lookup_empty+$lookup_wilayah3;
								$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
								$lookup_wilayah4=$lookup_empty+$lookup_wilayah4;
							?>
						   <h4 class="heading">Konfirmasi</h4>
							<div class="row">
								<div class="col-md-6">
                                
                                	<div class="row">
                                    <div class="col-md-6">
									<div class="form-group">
										<label for="nama">Status assesment?</label>
										<?=form_dropdown("status_check_doc",$lookup_status,
												$data["status_check_doc"],
												"id='status_check_doc' 
												class='form-control select2 required'");?>
									</div><!-- end form-->
									
									<!--add after tarining-->
									<div class="form-group alasan">
										<label for="nama">Alasan</label><br>
										<textarea id="alasan" rows="4" cols="40" name='alasan'><?=$data_assesment['alasan'];?></textarea>
									</div><!-- end form group -->
									<!--end add after tarining-->
                                    
                                    </div><!-- end col -->
                                    <div class="col-md-6">
                                            	<? $status_cek_doc=$data["status_check_doc"];
													 if($status_cek_doc==2):
													 	$display="";
													 else:
													 	$display="display:none";
													 endif;
												?>
										<div class="form-group tgl_selesai_assesment" style="<?=$display?>">
										<?php
										$tgl_selesai_asm=$data_asmHis["tgl_selesai_assesment"]?$data_asmHis["tgl_selesai_assesment"]:date("Y-m-d H:i:s");
										?>
										<label for="nama">Tgl Selesai Assesment</label>
										<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															<input type="text" id="tgl_selesai_assesment_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai_asm))?>" placeholder="dd/mm/yyyy"   data-mindate="<?=date("d/m/Y",strtotime($data_assesment["tgl_kedatangan"]?$data_assesment["tgl_kedatangan"]:$data['tgl_registrasi']))?>"/>
															 <input type="hidden" id="tgl_selesai_assesment" name="tgl_selesai_assesment" value="<?=date("Y-m-d",strtotime($tgl_selesai_asm));?>" class="required" />
										</div><!-- end input group -->			
									</div><!-- end form group-->
									</div></div><!-- end row --> 
									
									<script>
										$(document).ready(function(){
											$("#status_check_doc").on("change",function(){
												var val	=	$(this).val();
												if(val==2){
													$(".tempat_rujukan").removeClass("hide");
												}else{
													$(".tempat_rujukan").addClass("hide");
												}
											});
										});
									</script>
									
									<div class="tempat_rujukan hide">
										<div class="form-group status_proses" >
												<label for="nama">Proses Berikutnya?</label>
												<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
														$data["status_proses"],
														"id='status_proses' 
														class='form-control select2 required' style='width:100%'");?>
											</div><!-- end form-->
											
											<div class="form-group instansi_rujuk" >
												<?=$this->load->view("v_lookup_instansi_rujuk")?>
											</div>
											
											<!--$data["inst_rujuk"]-->
											<div class="wilayah row">
											<div class="col-md-12">
											<div class="form-group bnnp">
												<label for="nama">Tujuan Rujukan</label>
												<?php if($data['status_rawat']=='JALAN'):?>
													<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' class='form-control select2 required' style='width:100%'");?>
												<?php else: ?>
													<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' disabled class='form-control select2 required' style='width:100%'");?>
												<?php endif; ?>
											</div><!-- end form group -->
											
											
											<div class="form-group bnnk">
												<label for="nama">Tujuan Rujukan</label>
												<?php if($data['status_rawat']=='JALAN'):?>
													<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' class='form-control select2 required' style='width:100%'");?>
												<?php else: ?>
													<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' disabled class='form-control select2 required' style='width:100%'");?>
												<?php endif; ?>
											</div><!-- end form group -->
											
											<div class="form-group balailoka">
												<label for="nama">Tujuan Rujukan</label>
												<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='BL'):?>
													<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' class='form-control select2 required' style='width:100%'");?>
												<?php else: ?>
													<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' disabled class='form-control select2 required' style='width:100%'");?>
												<?php endif; ?>
											</div><!-- end form group -->
											
											
											<div class="form-group km">
												<label for="nama">Tujuan Rujukan</label>
												<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='KM'):?>
													<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' class='form-control select2 required' style='width:100%'");?>
												<?php else: ?>
													<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' disabled class='form-control select2 required' style='width:100%'");?>
												<?php endif; ?>
											</div><!-- end form group -->
											
											
											<div class="form-group rd">
												<label for="nama">Tujuan Rujukan</label>
												<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='RD'):?>
													<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' class='form-control select2 required' style='width:100%'");?>
												<?php else: ?>
													<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' disabled class='form-control select2 required' style='width:100%'");?>
												<?php endif; ?>
											</div><!-- end form group -->
											</div> <!-- end col -->
											</div><!-- end wilayah -->
									</div>	
								</div>
									
							</div>
				
							
						 
				  </div>
				  <div id="menu1" class="tab-pane fade">
					<br>
					<?=$this->load->view("v_data_pasien_assesment");?>
					
				  </div>
				</div>
             </div><!-- end box -->   
			 </form>
	</div>
  </div><!-- end row -->
</section>

<script>
	$(function() {
		// $("div.status_proses").hide();
		$("#status_check_doc").on("change",function(){
			
			if($(this).find("option:selected").val()==2){
				$("div.status_proses").show();
				$('.tgl_selesai_assesment').show(); 
				$('#tgl_selesai_assesment').prop( "disabled", false );
				
			//add after training
				$('div.instansi_rujuk').show();
				$('div.wilayah').show();
				$('.balailoka').show(); 
				$('.tgl_selesai_assesment').show(); 
				$('#tgl_selesai_assesment').prop( "disabled", false );
				$('#balailoka').prop( "disabled", false );
				$("div.alasan").hide();
				$('#alasan').prop( "disabled", true );
				
			}else if($(this).find("option:selected").val()==9){
				$("div.alasan").show();
				$('#alasan').prop( "disabled", false );
				
				$("div.status_proses").hide();
				$('div.instansi_rujuk').hide(); 
				$('div.wilayah').hide(); 
				
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide(); 
				$('.km').hide(); 
				$('.rd').hide(); 
				$('.tgl_selesai_assesment').hide(); 
				$('#tgl_selesai_assesment').prop( "disabled", true );
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
			//end add after training
			}else{
				$("div.alasan").hide();
				$('#alasan').prop( "disabled", true );
				
				$("div.status_proses").hide();
				$('div.instansi_rujuk').hide(); 
				$('div.wilayah').hide(); 
				
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide(); 
				$('.km').hide(); 
				$('.rd').hide(); 
				$('.tgl_selesai_assesment').hide(); 
				$('#tgl_selesai_assesment').prop( "disabled", true );
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );	
			}
		});
		
		$("#status_check_doc").change();
		
		$("#status_proses").on("change",function(){
			var status_proses=$(this).find("option:selected").val();
			if((status_proses!='SS')&&(status_proses!='')){
				$("div.instansi_rujuk").load("<?=$this->module?>lookup_instansi_rujuk/"+status_proses+"/?time="+new Date().getTime(),function(){
					$('div.instansi_rujuk').show();
					$('div.wilayah').show();
					$("#inst_rujuk").select2().change();
					
				});
			}else{
				$('div.instansi_rujuk').hide();
				$('div.wilayah').hide();
			
			}
			//$("div.instansi_rujuk").load("<?=$this->module?>lookup_instansi_rujuk/"+status_proses);
		});
		
		$("#status_proses").change();
		
		
		var non = $('#inst_rujuk :selected').val();
		$("select").select2();
		// $("#balailoka").select2();
		// $("#km").select2({'placeholder':"--Pilih--"});
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
		
		
		$("div.instansi_rujuk").on("change","#inst_rujuk",function(){
			// alert($('#status_proses').val());
			if($('#inst_rujuk :selected').val() == 'BL') {
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
			} else if($('#inst_rujuk :selected').val() == 'BNNP'){
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
			} else if($('#inst_rujuk :selected').val() == 'BNNK'){
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

			} else if($('#inst_rujuk :selected').val() == 'KM'){//JALAN=BALAI/LOKA
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
			} else if($('#inst_rujuk :selected').val() == 'RD'){
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
	
</script>  
