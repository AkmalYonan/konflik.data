<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
	
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-user-plus"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>" class="active"><?=$this->module_title?></a></li>
  </ol>
</section>


<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <!-- TOOLBAR -->
        	<div class="content-toolbar">
            		<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="Pendaftaran Rehabilitasi Offline">
                        <i class="fa fa-list"></i>
                    </a>
                    |
                	<a class="btn btn-white" href="<?php echo $this->module?>reg_baru" data-toggle='tooltip' title="Pasien Baru">
                        <i class="fa fa-plus"></i> Pasien Baru
                    </a>
                   
                    <a class="btn btn-white" href="<?php echo $this->module?>pasien_lama" data-toggle='tooltip' title="Pasien Lama">
                        <i class="fa fa-rotate-right"></i> Pasien Lama
                    </a>
            </div>
            <!-- END: TOOLBAR -->
            
        	<div class="box box-widget hides" style="padding:10px;">
                <div class="box-body no-padding">
					<div class="alert alert-info">
                        <h4><a href="<?php echo $this->module?>reg_baru"><i class="icon fa fa-plus"></i>Pasien Baru</a></h4>
                        Pendaftaran Rehabilitasi pasien yang belum pernah/tercatat melakukan Rehabilitasi.
                        <h4><a href="<?php echo $this->module?>pasien_lama"><i class="icon fa fa-rotate-right"></i>Pasien Lama</a></h4>
                        Pendaftaran Rehabilitasi pasien, yang tercatat sudah pernah melakukan Rehabilitasi.
                      </div>
                </div>
               
                <!-- /.box-body -->
                
              </div>
        </div>
    </div>
</section>
<script language="javascript">

</script>