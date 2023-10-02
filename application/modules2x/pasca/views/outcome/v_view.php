<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
    <li class="active">Detail</li>
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
					<a class="btn btn-white btn-save hidden" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                   <!-- <a class="btn btn-white" href="<?php echo $this->module?>form/<?php echo $id;?>" data-toggle='tooltip' title="Edit Assesment">
                        <i class="fa fa-pencil blue"></i>
                    </a>-->
            </div>
			
			<div class="box box-widget">				
                <div class="box-body table-responsive">
                	<div class="row">
						<div class="col-sm-12">
							<ul class="nav nav-tabs" role="tablist">
                            	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Pasien</a></li>
                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rehabilitasi</a></li>
								<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Pasca Rehab</a></li>
								<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Pasca / Lanjut</a></li>
                            </ul>
							<!-- Tab panes -->
                            <div class="tab-content">
                            	<div role="tabpanel" class="tab-pane active" id="home" style=" backgorund-color:grey">
									<!--<h4 class="heading">Pasien</h4>-->
									<?=$this->load->view("common_view/pasien/v_data_pasien_rh");?>
								</div>
                                <div role="tabpanel" class="tab-pane" id="profile">
									<div class="row">
									<div class="col-md-12">
									<div class="col-md-6">
										<h4 class="heading">History Rehab</h4>
										<?=$this->load->view("common_view/pasien/v_hstry_rehab");?>
									</div>
									<div class="col-md-6">
										<h4 class="heading">Monitoring Rehab</h4>
										<? $data['rawat_inap']='rawat_inap'?>
										<? $data['rawat_jalan']='rawat_jalan'?>
										<?=$this->load->view("common_view/pasien/v_mntr_rehab",$data);?>
									</div>
									</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="messages">
											<div class="row">
											<div class="col-md-12">
											<div class="col-md-6">	
											<h4 class="heading">History Pasca</h4>
											<?=$this->load->view("common_view/pasien/v_hstry_pasca");?>
											</div>
											<div class="col-md-6">
											<h4 class="heading">Monitoring Pasca</h4>
											<? $data['rawat_inap_pasca']='rawat_inap_pasca'?>
											<? $data['rawat_jalan_pasca']='rawat_jalan_pasca'?>
											<?=$this->load->view("common_view/pasien/v_mntr_pasca",$data);?>
											</div>
											</div>
											</div>
										</div>
										<div role="tabpanel" class="tab-pane" id="settings">
											<div class="row">
											<div class="col-md-12">
											<div class="col-md-6">	
											<h4 class="heading">History Lanjut</h4>
											<?=$this->load->view("common_view/pasien/v_hstry_lanjut");?>
											</div>
											<div class="col-md-6">
											<h4 class="heading">Monitoring Lanjut</h4>
											<? $data['rawat_lanjut_pendampingan']='rawat_lanjut_pendampingan'?>
											<? $data['rawat_lanjut_pemantauan']='rawat_lanjut_pemantauan'?>
											<?=$this->load->view("common_view/pasien/v_mntr_lanjut",$data);?>
											</div>
											</div>
											</div>
										</div>
                            </div>
						</div>
						
						<div class="col-sm-6 hidden">
							<h4 class="heading">Data Detox  <a class="hidden pull-right btn btn-xs btn-primary btn-add" href="javascript:void()" data-toggle='tooltip' title="Add Detox"><i class="fa fa-plus"></i> Tambah Data Detox</a></h4>
							<?=$this->load->view("v_form_detox");?>
						</div>
					</div>
                </div>
            </div>
 
   </div></div><!-- end row -->
   
</section>    


