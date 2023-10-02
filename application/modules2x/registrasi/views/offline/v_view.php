<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i><a href="<?php echo $this->module?>"><?=$this->parent_module_title?></a></li>
    <li class="active"><?=$this->module_title?></li>
  </ol>
</section>

<section class="content">
<div class="row">
	<div class="col-md-12">
    	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
        	<div class="content-toolbar">
                	<a class="btn btn-white" href="<?php echo $this->module?>pasien_lama/" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
					<!--
                     <a class="btn btn-white" href="<?php echo $this->module?>edit/<?php echo $id;?>" data-toggle='tooltip' title="Edit Pasien">
                        <i class="fa fa-pencil blue"></i>
                    </a>
					-->
            </div><!-- end content toolbar -->	
    
    		<?=$this->load->view("v_pasien_profile");?>
    
    		<div class="box box-widget">
            	<div class="box-header with-border hidden">
                  <h3 class="box-title">Data User</h3>
                <div class="box-tools pull-right">
                    <a href="/print" class="btn btn-xs btn-default div_id_print_modal" data-div_id="#div_print"><i class="fa fa-print"></i> Cetak</a>
                    
                    <!--<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
                  </div><!-- /.box-tools -->
                
                </div>
                <div class="box-body">
                	<div class="row">
                        	<div class="col-md-12">
                        		<div id="div_print">
                                   
                                </div>
                		    </div>
                            
                        </div><!-- end row-->
                		
                
                </div><!-- end boxbody-->
                <div class="box-footer well well-sm no-shadow">
                     <!--Username digunakan pada saat login.-->
                     &nbsp;
                </div>
                
            </div><!-- end box-->
    
    	
    </div>
</div>





</section>