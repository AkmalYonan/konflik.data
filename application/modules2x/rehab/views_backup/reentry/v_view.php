<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	$tgl_limit_prev = $monitoring_rehab['tgl_pt_selesai'];
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="rehab/daftar_rehab"><i class="fa fa-history"></i> <?=$this->parent_module_title?></a></li>
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
                    <a class="btn btn-white" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
					<a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                   <!-- <a class="btn btn-white" href="<?php echo $this->module?>form/<?php echo $id;?>" data-toggle='tooltip' title="Edit Assesment">
                        <i class="fa fa-pencil blue"></i>
                    </a>-->
            </div>
			
			<div class="box box-widget">				
                <div class="box-body">
                	<div class="row">
						<div class="col-sm-6">
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#homex" aria-controls="homex" role="tab" data-toggle="tab">Data Re-Entry </a></li>
                                    </ul>
								    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="homex">
											<h4 class="heading">Data Re-Entry  <a class="hidden pull-right btn btn-xs btn-primary btn-add" href="javascript:void()" data-toggle='tooltip' title="Add Detox"><i class="fa fa-plus"></i> Tambah Data Detox</a></h4>
											<?=$this->load->view("v_form_re_entry");?>
											
										</div>
                                    </div>
						</div>
						<div class="col-sm-6">
						
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Pasien</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rehabilitasi</a></li>
                                        <!-- <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Pasca Rehab</a></li>
												<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Pasca / Lanjut</a></li>-->
                                    </ul>
									<h4 class="heading" style="margin-top:25px;">Status Program</h4>
											<?=$this->load->view("common_view/pasien/progress_v");?>
	
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home" style=" backgorund-color:grey">
											
											<h4 class="heading">Pasien</h4>
											<?=$this->load->view("common_view/pasien/v_data_pasien");?>
										</div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
											<!--
											<h4 class="heading">History Rehab</h4>
											<?//=$this->load->view("common_view/pasien/v_hstry_rehab");?>
											-->
											<h4 class="heading">Monitoring Rehab</h4>
											<? $data['rawat_inap'] = "rawat_inap"; ?>
											<?=$this->load->view("common_view/pasien/v_mntr_rehab",$data);?>
											
										</div>
                                      
                                      
										<!---
										  <div role="tabpanel" class="tab-pane" id="messages">
											<h4 class="heading">History Pasca</h4>
											<?//$this->load->view("common_view/pasien/v_hstry_pasca");?>
											<h4 class="heading">Monitoring Pasca</h4>
											<?//$this->load->view("common_view/pasien/v_mntr_pasca");?>
										
										</div>
										<div role="tabpanel" class="tab-pane" id="settings">4</div>-->
                                    </div>
							
						</div>
						
						
					</div>
					
                </div>
            </div>
 			<div class="box box-widget">				
                <div class="box-body table-responsives">
                	<div class="row">
						<div class="col-sm-12">
                        
							<?php							
								$lookup_status_p["PS"]="Proses"; 
								$lookup_status_p["DO"]="DO";
								$lookup_status_p["MD"]="Meninggal Dunia";							
							?>						
						
							<h4 class="heading">Program</h4>
							<div class="form-group">
								<div class="row">
									<div class="col-md-3">
										<label for="nama">Status Program</label>
										<?=form_dropdown("status_program",$lookup_status_p,
												$data_proses["status_program"],
												"id='status_program' 
												class='form-control select2 required' style='width:100%'");?>
									</div>
									<div class="col-md-3 tgl_selesai_program">
										<?php
											$tgl_selesai_program=date("Y-m-d H:i:s");
										?>
										<label for="nama">Tgl Selesai Program</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											<input type="text" id="tgl_selesai_program_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai_program))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
											 <input type="hidden" id="tgl_selesai_program" name="tgl_selesai_program" value="<?=date("Y-m-d",strtotime($tgl_selesai_program));?>" class="required" />
										</div><!-- end input group -->
									</div>
								</div>
							</div><!-- end form-->
                        
                        </div>
                    </div>
                 </div>
              </div>
   </div></div><!-- end row -->
   
</section>    
</form>

<script>
$(document).ready(function(){
	$("#status_program").on("change",function(){
		var val	=	$(this).val();
		if(val=="DO" || val=="MD"){
			$(".form-control").removeClass("required");
		}else{
			$(".form-control").addClass("required");
		}
	});
});
</script>

<script>
	$(document).ready(function(){			
		$("#status_pasien").on("change",function(){
		var val	=	$(this).val();
			if(val=="SL"){
				$(".tempat_rujukan").removeClass("hide");
			}else{
				$(".tempat_rujukan").addClass("hide");
			}					
		});			
	});
</script>

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
<script>
	$(function() {

		
		var non = $('#status_proses').val();
		
		$('#status_pasien').change(function(){
			// alert($('#status_pasien').val());
			if($('#status_pasien').val() == 'SL') {
				$('#status_proses').show(); 
				$('.status_proses').show(); 
				
				if(non=='KM'){
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
							
			} else {
				$('#status_proses').hide(); 
				$('#bnnp').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('.status_proses').hide(); 
				$('.balailoka').hide(); 
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.km').hide();	
				$('.rd').hide();					
			}
		});
		
		// var non = $('#status_proses').val();
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

			} else if($('#status_proses').val() == 'KM'){
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

