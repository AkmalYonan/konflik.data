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
    <li><a href="<?php echo $this->module?>">Daftar Pasien</a></li>
    <li class="active"><?=$this->module_title?></li>
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
							<!--<h4 class="heading">Pasien</h4>-->
                			<?=$this->load->view("common_view/pasien/v_data_pasien_rh");?>
							
						</div>
						
						<div class="col-sm-6 hidden">
							<h4 class="heading">Data</h4>
							<?=$this->load->view("v_form_detox");?>
						</div>
					</div>
                </div>
            </div>
 
   </div></div><!-- end row -->
   
</section>    


