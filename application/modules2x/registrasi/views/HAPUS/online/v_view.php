<?php 
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	$status=$data["status"];
	$status_check_doc=$data["status_check_doc"];
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo $this->module?>"><i class="fa fa-globe"></i> <?=$this->parent_module_title?></a></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
    <li class="active">View</li>
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
                    
                    <? if(($status==0)||(($status==1)&&($status_check_doc<2))):?>
                    <a class="btn btn-white" href="<?php echo $this->module?>verifikasi/<?php echo $id;?>" data-toggle='tooltip' title="Verifikasi">
                        <i class="fa fa-check"></i> Verifikasi
                    </a>
                    <? endif;?>
                    <? if(
						(($status==1)&&($status_check_doc==2))||
						(($status==2)&&($status_check_doc<2))
					 	):?>
                    <a class="btn btn-white" href="<?php echo $this->module?>rekam_medis/<?php echo $id;?>" data-toggle='tooltip' title="Rekam Medis">
                   
                        <i class="fa fa-check"></i> Rekam Medis
                    </a>
                     <? endif;?>
            </div><!-- end content toolbar -->	
    
    		<div class="box box-widget">
            	<!--<div class="box-header with-border">
                  <h3 class="box-title">Data User</h3>
                </div>-->
                <div class="box-body">
                    <div class="row">
                        	<div class="col-md-8">
                        		<h4 class="heading">Data Pasien</h4>
								  <?=$this->load->view("common_view/pasien/v_data_pasien");?>
        						<?//=$this->load->view("v_data_pasien");?>   
                                
                		    </div>
                            <div class="col-md-4">
                        	   <h4 class="heading">Status Pendaftaran</h4>
        					   <?=$this->load->view("v_status");?>     
                               <h4 class="heading">Data Pendaftar</h4>
							   <?=$this->load->view("v_pendaftar");?> 
							   <h4 class="heading">File Pendukung</h4>
							   <?=$this->load->view("v_view_pemeriksaan_dokumen");?> 
                               
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