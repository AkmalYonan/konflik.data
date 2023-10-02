<style>
.table .table-preview img {
  width: 50px;
  height:50px;
  margin-right: 10px;
  margin-top:2px;
  float: left;
}
.table .identitas{
	float:left;
}
.table .table-preview .name {
  font-weight: bold;
  margin-top: 5px;
  display: block;
}
</style>

<section class="content-header">
  <h1 class="hidden-xs">
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="pasca/daftar_pasca"><i class="fa fa-child"></i> <?=$this->parent_module_title?></a></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
	<li><a href="<?php echo $this->module?>view_detail/<?=$id?>" class="active">Detail</a></li>
  </ol>
</section>

<section class="content">
    <div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <!-- TOOLBAR -->
        	<div class="content-toolbar">
                	<a class="btn btn-white active" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>view_detail/<?=$id?>" data-toggle='tooltip' data-original-title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
            </div>
            <!-- END: TOOLBAR -->
        	<div class="box box-widget">				
                <div class="box-body">
                	<div class="row">
						<div class="col-sm-12">
							<ul class="nav nav-tabs" role="tablist">
                            	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Pertemuan Kelompok</a></li>
								<li role="presentation"><a href="#data_pasien" aria-controls="data_pasien" role="tab" data-toggle="tab">Data Pasien</a></li>
                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rehabilitasi</a></li>
                                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Pasca Rehab</a></li>
								<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Pasca / Lanjut</a></li>
                             </ul>

                             <!-- Tab panes -->
                             <div class="tab-content">
                             	<div role="tabpanel" class="tab-pane active" id="home" style=" backgorund-color:grey">
									<h4 class="heading">Pertemuan Kelompok</h4>
									<?=$this->load->view("v_data_pasca_rehab");?>
								</div>
								<div role="tabpanel" class="tab-pane" id="data_pasien" style=" backgorund-color:grey">
									<!--<h4 class="heading">Pasien</h4>-->
									<?=$this->load->view("common_view/pasien/v_data_pasien_rh");?>
								</div>
                                <div role="tabpanel" class="tab-pane" id="profile">
									<h4 class="heading">History Rehab</h4>
									<?=$this->load->view("common_view/pasien/v_hstry_rehab");?>
									<h4 class="heading">Monitoring Rehab</h4>
									<? $data['rawat_inap']='rawat_inap'?>
									<? $data['rawat_jalan']='rawat_jalan'?>
									<?=$this->load->view("common_view/pasien/v_mntr_rehab",$data);?>
								</div>
								<div role="tabpanel" class="tab-pane" id="messages">
									<h4 class="heading">History Pasca</h4>
									<?=$this->load->view("common_view/pasien/v_hstry_pasca");?>
									<h4 class="heading">Monitoring Pasca</h4>
									<? $data['rawat_inap_pasca']='rawat_inap_pasca'?>
									<? $data['rawat_jalan_pasca']='rawat_jalan_pasca'?>
									<?=$this->load->view("common_view/pasien/v_mntr_pasca",$data);?>
								</div>
								<div role="tabpanel" class="tab-pane" id="settings">
									<h4 class="heading">History Lanjut</h4>
									<?=$this->load->view("common_view/pasien/v_hstry_lanjut");?>
									<h4 class="heading">Monitoring Lanjut</h4>
									<? $data['rawat_lanjut_pendampingan']='rawat_lanjut_pendampingan'?>
									<?=$this->load->view("common_view/pasien/v_mntr_lanjut",$data);?>
								</div>
                        	</div>
						</div>
						
						<div class="col-sm-5 hidden">
							<ul class="nav nav-tabs" role="tablist">
                            	<li role="presentation" class="active"><a href="#homex" aria-controls="homex" role="tab" data-toggle="tab">Data <?=$this->module_title;?></a></li>
                            </ul>
							<div class="tab-content">
                            	<div role="tabpanel" class="tab-pane active" id="homex">
									<h4 class="heading">Data <?=$this->module_title;?></h4>
									<?=$this->load->view("v_data_pasca_rehab");?>
								</div>
                            </div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</section>