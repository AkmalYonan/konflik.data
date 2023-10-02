<?php 
	
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	
	//$lookup_status[0]='Belum diperiksa'; //tetap baru
	
	$lookup_status[0]="Belum diperiksa";
	$lookup_status[1]="Belum OK/Sedang Proses"; // tetap verifikasi
	$lookup_status[2]="OK"; //terdaftar
	$lookup_status[99]="Ditolak";
	
	
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
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
                    <a class="btn btn-white" href="<?php echo $this->module?>edit/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="Reset">
                        <i class="fa fa-remove"></i>
                    </a>	  
            </div><!-- end content toolbar -->	
    
    		<div class="box box-widget">
            	<!--<div class="box-header with-border">
                  <h3 class="box-title">Data User</h3>
                </div>-->
                <div class="box-body">
                		<h4 class="heading">Verifikasi</h4>
                		<form id="frm" method="post" action="<?php echo $this->module;?>verifikasi/<?=$id?>">
                  			<input type="hidden" name="act" id="act" value="verifikasi"/>
                            <div class="row">
                            	<div class="col-md-6">
                            		<div class="form-group">
                                      <label for="nama">Hasil Verifikasi Data</label>
                                      
                                      <?=form_dropdown("status_check_doc",$lookup_status,
									  		$data["status_check_doc"],
											"id='status_check_doc' 
											class='form-control select2 required'");?>
                                     </div><!-- end form group -->
                                      
                                      
                                      <div class="form-group hidden">
                                        <label for="alamat">Keterangan</label>
                                        <textarea class="input-xs form-control" id="status_keterangan" rows="5" name="status_keterangan" placeholder=""><?=$data["status_keterangan"]?></textarea>
                                    </div> 
                                      
                                      <div class="form-group">
									<?php
                                        $tgl_rekam_medis=$data["tgl_rekam_medis"]?$data["tgl_rekam_medis"]:date("Y-m-d H:i:s");
                                    ?>
                                    <div class="formSep"></div>
                                    <label for="nama">Rencana Tanggal Rekam Medis</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" id="tgl_rekam_medis_selector" class="form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_rekam_medis))?>" placeholder="dd/mm/yyyy"/>
                                          <input type="hidden" id="tgl_rekam_medis" name="tgl_rekam_medis" value="<?=date("Y-m-d",strtotime($tgl_rekam_medis));?>" class="required" />
                                    </div>
                                
                                </div><!-- end form group -->
                               
                               <div class="form-group">
                            <label>Konfirmasi Ke Pasien</label><br>
                            <input type="checkbox" name="flag_konfirmasi" value="1" id="flag_konfirmasi" /> Apakah pasien sudah dihubungi, berkenaan dengan jadwal interview?
                            	<span class="help-block"></span>
                            </div>  
                               
                                <div class="well">
                           ***) Proses rekam medis dilakukan secara offline, minta pasien membawa kelengkapan dokumen untuk interview.
                            </div>
                                         
                                </div><!-- end col-->
                            </div><!-- endrow-->
                             	
       						
                            
                            <h4 class="heading">File Pendukung</h4>
                            <?=$this->load->view("v_pemeriksaan_dokumen");?>
                              
                        </form>
                        
                        
                        
                                     
                        
                       
                            
                             
                        
                       <div class="formSep"></div>
                       
                        <div class="row">
                        	<div class="col-md-8">
                        		<h4 class="heading">Data Pasien</h4>
        						<?=$this->load->view("v_data_pasien");?>   
                                
                		    </div>
                            <div class="col-md-4">
                        	   <h4 class="heading">Data Pendaftar</h4>
        					   <?=$this->load->view("v_pendaftar");?> 
                               <h4 class="heading">Status Pendaftaran</h4>
        					   <?=$this->load->view("v_status");?>     
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

<script>
	$(function(){
		var flag_ok=0;
		
		$("#frm").submit(function(e){
			
			if(flag_ok==1){
				if($("#flag_konfirmasi").is(":checked")==false){
					alert("Flag konfirmasi ke pasien harus di isi, lihat keterangan");
					return false;
				}
			}
		});
			
		//$("#﻿status_check_doc").change();
		
		$("#﻿status_check_doc").change(function(){
			var thisval=$(this).find(":selected").val();
			if(thisval=="2"){
				flag_ok=1;
				//$("#status_keterangan").removeClass("required");
			}else{
				flag_ok=0;
				//$("#status_keterangan").removeClass("required");	
			}
		}).change();
			
	})
</script>