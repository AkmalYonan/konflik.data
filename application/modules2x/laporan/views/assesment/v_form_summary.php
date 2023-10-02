<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?php
	$lookup_status[0]="Belum diperiksa"; //menunggu verifikasi
	$lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	$lookup_status[2]="Selesai"; //menunggu rekam medik
	$lookup_status[9]="DiTolak";  
	
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	$lookup_proses_current["SS"]="Assesment";
	$lookup_proses_berikutnya=$lookup_proses_current+lookup("m_proses_rehab","kd_status_proses","ur_proses","kd_status_rehab=2 and flag_proses=1","order by kd_status_rehab,order_num");
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
                	<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>edit/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                   <a class="btn btn-white" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="Print Preview">
                        <i class="fa fa-print blue"></i>
                    </a>
                    
                    <!--<a class="btn btn-white btn-delete" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="Cancel/Back To List">
                        <i class="fa fa-remove"></i>
                    </a>	-->  
            </div>
        	<div class="box box-widget">
            	<!--<div class="box-header with-border">
                  <h3 class="box-title">Data User</h3>
                </div>-->
                <div class="box-body">
                <!-- Data Pasien -->
                <h4 class="heading">Data Pasien</h4>
                <?=$this->load->view("v_data_pasien");?>
                <div class="formSep"></div>
                
                 <h4 class="heading">Data Assesment</h4>
                 <form id="frm" method="post" action="<?php echo $this->module;?>summary/<?php echo $id;?>">
                  <input type="hidden" name="act" id="act" value="update"/>
                  <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
                  <input type="hidden" name="idx_pasien" id="id_pasien" value="<?=$data["idx"]?>"/>
                  <!-- FORM STATUS -->	
                  <input type="hidden" name="status_rehab" id="status_rehab" value="1"/>
                  <!--<input type="hidden" name="status_proses" id="status_proses" value="<?=$data["status_proses"]?>"/>-->
                  <?=$this->load->view("v_form_assesment")?>
                  
              		
                   <h4 class="heading">Disclaimer</h4>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Status assesment?</label>
                        <?=form_dropdown("status_check_doc",$lookup_status,
                                $data["status_check_doc"],
                                "id='status_check_doc' 
                                class='form-control select2 required'");?>
                    </div><!-- end form-->
                    
                    
                    <div class="form-group status_proses">
                        <label for="nama">Proses Berikutnya?</label>
                        <?=form_dropdown("status_proses",$lookup_proses_berikutnya,
                                $data["status_proses"],
                                "id='status_proses' 
                                class='form-control select2 required'");?>
                    </div><!-- end form-->
                    
                    </div><!-- end row --> 
                  
                 
                 </form>
                
                </div><!-- end box-body-->
             </div><!-- end box -->
             
             
  </div></div><!-- end row -->
</section>