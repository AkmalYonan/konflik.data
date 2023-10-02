<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="pasca/daftar_pasca"><i class="fa fa-child"></i> <?=$this->parent_module_title?></a></li>
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
                   <!-- <a class="btn btn-white" href="<?php echo $this->module?>form/<?php echo $id;?>" data-toggle='tooltip' title="Edit Assesment">
                        <i class="fa fa-pencil blue"></i>
                    </a>-->
					<a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="Reset">
                        <i class="fa fa-circle-o"></i>
                    </a>	
            </div>
            <div class="box box-widget">				
                <div class="box-body">
                	<div class="row">
						<div class="col-sm-6">
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#homex" aria-controls="homex" role="tab" data-toggle="tab">Data <?=$this->module_title;?></a></li>
                                    </ul>
								    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="homex">
											<h4 class="heading">Data Kegiatan <?=$this->module_title;?> <a class="pull-right btn btn-xs btn-primary btn-add add_clean" data-toggle='tooltip' title="Add <?=$this->module_title?>"><i class="fa fa-plus"></i></a></h4>
											<?=$this->load->view("v_form_entry_unit");?>
										</div>
                                    </div>
						</div>
						<div class="col-sm-6">
						
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Pasien</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rehabilitasi</a></li>
                                         <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Pasca Rehab</a></li>
										<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Pasca / Lanjut</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home" style=" backgorund-color:grey">
											<h4 class="heading" style="margin-top:25px;">Status Program</h4>
											<?=$this->load->view("common_view/pasien/progress_v");?>
											<h4 class="heading">Pasien</h4>
											<?=$this->load->view("common_view/pasien/v_data_pasien");?>
										</div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
											<!--
											<h4 class="heading">History Rehab</h4>
											<?//=$this->load->view("common_view/pasien/v_hstry_rehab");?>
											-->
											<h4 class="heading">Monitoring Rehab</h4>
											<? $data['rawat_inap']='rawat_inap'?>
											<? $data['rawat_jalan']='rawat_jalan'?>
											<?=$this->load->view("common_view/pasien/v_mntr_rehab",$data);?>
											
										
										</div>
										  <div role="tabpanel" class="tab-pane" id="messages">
										  	<!--
											<h4 class="heading">History Pasca</h4>
											<?//=$this->load->view("common_view/pasien/v_hstry_pasca");?>
											-->
											<h4 class="heading">Monitoring Pasca</h4>
											<? $data['rawat_inap_pasca']='rawat_inap_pasca'?>
											<? $data['rawat_jalan_pasca']='rawat_jalan_pasca'?>
											<?=$this->load->view("common_view/pasien/v_mntr_pasca",$data);?>
										
										</div>
										<div role="tabpanel" class="tab-pane" id="settings">
											<!--
											<h4 class="heading">History Lanjut</h4>
											<?//=$this->load->view("common_view/pasien/v_hstry_lanjut");?>
											-->
											<h4 class="heading">Monitoring Lanjut</h4>
											<? $data['rawat_lanjut_pendampingan']='rawat_lanjut_pendampingan'?>
											<?=$this->load->view("common_view/pasien/v_mntr_lanjut",$data);?>
										</div>
                                    </div>
							
						</div>
					</div>
                </div>
            </div>
			
			<div class="box box-widget">
				<div class="box-body">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="heading">Program</h4>
							<div class="form-group">
								<div class="row">
									<div class="col-md-3">
										<label for="nama">Status Program</label>
										<?php
											$lookup_status_p["PS"]="Proses"; 
											// $lookup_status_p["SL"]="Selesai";
											$lookup_status_p["KB"]="Kambuh"; 
											$lookup_status_p["MD"]="Meninggal Dunia";
										?>
										<?=form_dropdown("status_program",$lookup_status_p,
														$data_proses["status_program"],
														"id='status_program' 
														class='form-control select2 required'");?>
									</div>
										<div class="col-md-3 tgl_selesai_program">
											<?php
												if($monitoring_pasca['tgl_dr_selesai']):
													$tgl_limit_prev = $monitoring_pasca['tgl_dr_selesai']; 
												elseif($monitoring_pasca['tgl_dk_selesai']):
													$tgl_limit_prev = $monitoring_pasca['tgl_dk_selesai']; 
												else:
													$tgl_limit_prev = $monitoring_pasca['tgl_mulai_pasca']; 
												endif; 
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
								</div>				
						</div>
					</div>
				</div>
			</div>
            
   </div></div><!-- end row -->
   </form>
</section>    

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