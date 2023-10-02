<?php 
	
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	
	//$lookup_status[0]='Belum diperiksa'; //tetap baru
	
	$lookup_status[0]="Belum diproses";
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
                		
                		<form id="frm" method="post" action="<?php echo $this->module;?>rekam_medis/<?=$id?>">
                  			<input type="hidden" name="act" id="act" value="update"/>
                            
                            <h4 class="heading">Registrasi Pasien</h4>
                            <?=$this->load->view("common_view/pasien/v_part_form_wilayah_sumber_pasien");?>
                            
                            <div class="formSep"></div>
                            <h4 class="heading">Rekam Medis</h4>
                            <?=$this->load->view("common_view/pasien/v_part_form_rekam_medis");?>
                            
                            <div class="form-group">
                            <label>Disclaimer</label><br>
                            <input type="checkbox" name="flag_rekam_medis" value="1" <?=$data["flag_rekam_medis"]==1?"checked='checked'":""?> id="flag_rekam_medis" /> Isi data rekam medik akan disimpan, dan saya sudah melakukan pengecekan
                            
                            	<span class="help-block"></span>
                            </div>  
                               
                                <div class="well hidden">
                           ***) Proses rekam medis dilakukan secara offline, minta pasien membawa kelengkapan dokumen untuk interview.
                            </div>
                            
                            <? //=$this->load->view("common_view/pasien/v_rekam_medis")?>
                             	
       						
                            
                            <h4 class="heading">File Pendukung</h4>
                            <?=$this->load->view("v_pemeriksaan_dokumen");?>
                              
                        </form>
                        
                        <div class="formSep"></div>
                       <h4 class="heading">Data Pendaftaran</h4>
                        <div class="row">
                        	<div class="col-md-8">
                        		
        						<?=$this->load->view("v_data_pasien");?>   
                                
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
		var flag_ok=1;
		
		$("#frm").submit(function(e){
			
			if(flag_ok==1){
				if($("#flag_rekam_medis").is(":checked")==false){
					alert("Flag disclaimer harus di isi");
					return false;
				}
			}
		});
			
		
			
	})
</script>