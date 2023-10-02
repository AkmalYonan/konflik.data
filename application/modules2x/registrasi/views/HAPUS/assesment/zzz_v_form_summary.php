<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?php
	$lookup_status[0]="Belum diperiksa"; //menunggu verifikasi
	$lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	$lookup_status[2]="Selesai"; //menunggu rekam medik
	$lookup_status[9]="Di tolak";  
	// debug();
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	$lookup["SS"]="Assesment";
	$lookup_proses_berikutnya=$lookup+lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
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
					
				  <form id="frm" method="post" action="<?php echo $this->module;?>summary/<?php echo $id;?>">	
				  <div class="tab-content">
					<div id="home" class="tab-pane fade in active">
						<br>
						
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
								$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
								
								$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
								$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
								$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
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
									
									<div class="form-group status_proses" >
											<label for="nama">Proses Berikutnya?</label>
											<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
													$data["inst_rujuk"],
													"id='status_proses' 
													class='form-control select2 required'");?>
										</div><!-- end form-->
                                        
                                        
										<div class="form-group bnnp">
											<label for="nama">Tujuan Rujukan</label>
											<?php if($data['status_rawat']=='JALAN'):?>
												<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' class='form-control select2 required'");?>
											<?php else: ?>
												<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' disabled class='form-control select2 required'");?>
											<?php endif; ?>
										</div><!-- end form group -->
                                        
                                        
										<div class="form-group bnnk">
											<label for="nama">Tujuan Rujukan</label>
											<?php if($data['status_rawat']=='JALAN'):?>
												<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' class='form-control select2 required'");?>
											<?php else: ?>
												<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' disabled class='form-control select2 required'");?>
											<?php endif; ?>
										</div><!-- end form group -->
										
                                        <div class="form-group balailoka">
											<label for="nama">Tujuan Rujukan</label>
											<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='BL'):?>
												<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' class='form-control select2 required'");?>
											<?php else: ?>
												<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' disabled class='form-control select2 required'");?>
											<?php endif; ?>
										</div><!-- end form group -->
										
                                        
                                        <div class="form-group km">
											<label for="nama">Tujuan Rujukan</label>
											<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='KM'):?>
												<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' class='form-control select2 required'");?>
											<?php else: ?>
												<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' disabled class='form-control select2 required'");?>
											<?php endif; ?>
										</div><!-- end form group -->
                                        
                                        
										<div class="form-group rd">
											<label for="nama">Tujuan Rujukan</label>
											<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='RD'):?>
												<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' class='form-control select2 required'");?>
											<?php else: ?>
												<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' disabled class='form-control select2 required'");?>
											<?php endif; ?>
										</div><!-- end form group -->
										
										<div class="row">
											<div class="col-md-4 tgl_selesai_assesment">
												<div class="form-group">
														<?php
														$tgl_selesai_asm=$data_asmHis["tgl_selesai_assesment"]?$data_asmHis["tgl_selesai_assesment"]:date("Y-m-d H:i:s");
														?>
														<label for="nama">Tgl Selesai Assesment</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															<input type="text" id="tgl_selesai_assesment_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai_asm))?>" placeholder="dd/mm/yyyy"/>
															 <input type="hidden" id="tgl_selesai_assesment" name="tgl_selesai_assesment" value="<?=date("Y-m-d",strtotime($tgl_selesai_asm));?>" class="required" />
														</div><!-- end input group -->			
												</div><!-- end form group-->
											</div>
										</div>
										
								</div>
									
							</div>
				
							
						 
				  </div>
				  <div id="menu1" class="tab-pane fade">
					<br>
					<?=$this->load->view("v_data_pasien_assesment");?>
				  </div>
				</div>
				</form>
             </div><!-- end box -->   
	</div>
  </div><!-- end row -->
</section>
<script>
	$(function() {
		$('.tgl_selesai_assesment').hide(); 
		$('#tgl_selesai_assesment').prop( "disabled", true );
		<?php if($data_asmHis["tgl_selesai_assesment"] !=''){?>
			// alert("deiiii");
			$('#tgl_selesai_assesment').prop( "disabled", false );
			$('.tgl_selesai_assesment').show(); 
		<?php } ?>
		
		// $("div.status_proses").hide();
		$("#status_check_doc").on("change",function(){
			if($(this).val()==2){
				$("div.status_proses").show();
				$('.tgl_selesai_assesment').show(); 
				$('#tgl_selesai_assesment').prop( "disabled", false );
			}else{
				$("div.status_proses").hide();
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
		
		var non = $('#status_proses').val();
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
	// <?php if($data['status_rawat']=='JALAN' && $data_assesment['inst_rujuk']=='BNNP'):?>
			// $('.km').hide(); 
			// $('.bnnp').show(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']=='JALAN' && $data_assesment['inst_rujuk']=='BNNK'): ?>
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
		// <?php if($data['status_rawat']=='INAP' && $data_assesment['inst_rujuk']=='BL'):?>
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
