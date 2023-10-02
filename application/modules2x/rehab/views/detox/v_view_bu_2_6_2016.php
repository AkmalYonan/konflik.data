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
    <li class="active">Edit</li>
  </ol>
</section>
<section class="content">
    <div class="row">
    <div class="col-md-12">
			<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
    		<div class="content-toolbar">
                	<div class="row">
					<div class="col-md-4">
					<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
					<a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
					</div>
					<div class="col-sm-6" style="float:right">
					<?//=$this->load->view("common_view/pasien/progress_v");?>
					</div>
					</diV>
                   <!-- <a class="btn btn-white" href="<?php echo $this->module?>form/<?php echo $id;?>" data-toggle='tooltip' title="Edit Assesment">
                        <i class="fa fa-pencil blue"></i>
                    </a>-->
			
					
            </div>
			
			
			<div class="box box-widget">				
                <div class="box-body table-responsive">
					
					<div class="row">
						
						<div class="col-sm-6">
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#homex" aria-controls="homex" role="tab" data-toggle="tab">Data Detox</a></li>
										<!--
										<li role="presentation" ><a href="#page2" aria-controls="page2" role="tab" data-toggle="tab">Data Kegiatan Detoksifikasi</a></li>
										-->
                                    </ul>
								    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="homex">
											<h4 class="heading">Data Detox  <a class="hidden pull-right btn btn-xs btn-primary btn-add" href="javascript:void()" data-toggle='tooltip' title="Add Detox"><i class="fa fa-plus"></i> Tambah Data Detox</a></h4>
											<?=$this->load->view("v_form_detox");?>
										</div>
										
										<!--
										<div role="tabpanel" class="tab-pane" id="page2">
											<h4 class="heading">Daftar Kegiatan Detoksifikasi</h4>
											<div class="box-body table-responsive">
												<table class="table table-bordered table-condensed small-font">
													<thead>
														<tr>
															<th width="20px">No.</th>
															<th width="80px"><center>Tgl Kegiatan</center></th>
															<th width="80px"><center>Lama Detoksifikasi</center></th>
															<th><center>Jenis<br> Kegiatan</center></th>
															<th width="30px">Lampiran</th>
															<th style="width:30px;"></th>
														</tr>
													</thead>
													<tbody>	
														<?php if(cek_array($pasien_detox_history)):?>
															<?php foreach($pasien_detox_history as $x=>$val):
															
																	$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
															?>
																<tr>
																	<td><?php echo $x+1?>.</td>
																	<td><?php echo ($val["tgl_kegiatan"])?date2indo($val["tgl_kegiatan"]):"<center>-</center>"?></td>
																	<td width="80" align="right"><?php echo $val["lama_detox"]?> Hari</td>
																	<td><?php echo $val["jenis_kegiatan"]?></td>

																	 <td align="center">
																		<?php if($val['lampiran']): ?>
																			<a href="<?=$this->config->item("dir_detok").$val['lampiran']?>" target="_blank">
																				<span class="label label-info"><i class="fa fa-download">&nbsp;</i></span>
																			</a>
																		<?php else: echo "-"; endif; ?>
																	 </td>
																	 <td align="center">
																		<div class="btn-group btn-group-xs">
																		<a class="btn btn-xs btn-default" href="<?=$this->module?>edit/<?=encrypt($val["idx_pasien"])?>/<?=encrypt($val["idx"])?>" data-toggle='tooltip' title="Edit"><i class="fa fa-pencil green"></i></a> 
																		</div>
																	</td>
																</tr>
															<?php endforeach;?>
														<?php endif;?>
													</tbody>
												</table>
											</div>
										</div>
										-->
                                    </div>
						</div>
						<div class="col-sm-6">
									
									<ul class="nav nav-tabs" role="tablist">
                                      
                                        <li role="presentation" class="active" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Pasien</a></li>
										  <li role="presentation" ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rehabilitasi</a></li>
                                        <!-- <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Pasca Rehab</a></li>
												<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Pasca / Lanjut</a></li>-->
                                    </ul>
									
									<!--<h4 style=" margin-top:25px !important;" class="heading">Status Pasien</h4>-->
									
					
									
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home" style=" backgorund-color:grey">
											<h4 class="heading">Status Pasien</h4>
										
											<?=$this->load->view("common_view/pasien/progress_v");?>
											<h4 class="heading">Pasien</h4>
											<?=$this->load->view("common_view/pasien/v_data_pasien");?>
										</div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
											
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
 
   </div></div><!-- end row -->
   
</section>    


