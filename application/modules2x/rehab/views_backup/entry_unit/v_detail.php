<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="rehab/daftar_rehab"><i class="fa fa-history"></i> <?=$this->parent_module_title?></a></li>
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
                    <a class="btn btn-white" href="<?php echo $this->module?>detail/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
					<a class="btn btn-white btn-save hidden" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
            </div>
			
			<div class="box box-widget">				
                <div class="box-body">
                	<div class="row">
						<div class="col-sm-12">
							<ul class="nav nav-tabs" role="tablist">
                            	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Pasien</a></li>
								<li role="presentation"><a href="#data_pasien" aria-controls="data_pasien" role="tab" data-toggle="tab">Data Pasien</a></li>
                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rehabilitasi</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                            	<div role="tabpanel" class="tab-pane active" id="home" style=" backgorund-color:grey">
									<h4 class="heading">Data Entry Unit</h4>
									<?=$this->load->view("v_detail_eu");?>
								</div>
								<div role="tabpanel" class="tab-pane" id="data_pasien" style=" backgorund-color:grey">
									<!--<h4 class="heading">Pasien</h4>-->
									<?=$this->load->view("common_view/pasien/v_data_pasien_rh");?>
								</div>
                                <div role="tabpanel" class="tab-pane" id="profile">
									<h4 class="heading">History Rehab</h4>
									<?=$this->load->view("common_view/pasien/v_hstry_rehab");?>
									<h4 class="heading">Monitoring Rehab</h4>
									<? $data['rawat_inap'] = "rawat_inap"; ?>
									<?=$this->load->view("common_view/pasien/v_mntr_rehab",$data);?>
								</div>
							</div>
						</div>
						
						<!--
						<div class="col-sm-6">
							<ul class="nav nav-tabs" role="tablist">
                            	<li role="presentation" class="active"><a href="#homex" aria-controls="homex" role="tab" data-toggle="tab">Data Entry Unit</a></li>
                            </ul>
							<div class="tab-content">
                            	<div role="tabpanel" class="tab-pane active" id="homex">
									<h4 class="heading">Data Entry Unit</h4>
									<?//=$this->load->view("v_detail_eu");?>
								</div>
                            </div>
						</div>
						-->
					</div>
                </div>
            </div>
 
   </div></div><!-- end row -->
   
</section>    


