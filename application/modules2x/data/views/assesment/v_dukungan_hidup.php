<?php
	$lookup_empty[""]="--Pilih--";
	
	$lookup_ya_tidak[""]="--Pilih--";
	$lookup_ya_tidak[0]="Tidak";
	$lookup_ya_tidak[1]="Ya";
?>

				
                <div class="row">
                  	<div class="col-md-12">
                    	<h4 class="heading">Status Medis/Dukungan Hidup</h4>
                    </div>
                  </div>
                  
                  
                  <div class="row">
                  	<div class="col-md-3">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">Adakah yang memberi dukungan hidup bagi anda</label>
                            <?php echo form_dropdown("dukungan_hidup",$lookup_ya_tidak,$data_assesment["dukungan_hidup"],"id='dukungan_hidup' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    	
                    </div><!-- end col -->
                    <div class="col-md-3">
                    	<div class="form-group">
							<label>Bila ya, siapa?</label>
							<?php echo form_input('dukungan_hidup_siapa',$data_assesment["dukungan_hidup_siapa"],'class="form-control required"');?>
						</div>
                    </div>
                  </div><!-- end row -->
                  
                  <div class="row">
                  	<div class="col-md-6">
                    	<label>Dalam bentuk apakah? </label>
                    </div>
                  </div>
                  <div class="row">
                  	<div class="col-md-2">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">Finansial</label>
                            <? echo form_dropdown("dukungan_finansial",$lookup_empty+$lookup_ya_tidak,$data_assesment["dukungan_finansial"],"id='dukungan_finansial' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    	
                    </div><!-- end col -->
                    <div class="col-md-2">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">Tempat Tinggal</label>
                            <? echo form_dropdown("dukungan_tempat_tinggal",$lookup_empty+$lookup_ya_tidak,$data_assesment["dukungan_tempat_tinggal"],"id='dukungan_tempat_tinggal' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    </div>
                    
                    <div class="col-md-2">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">Makan</label>
                            <? echo form_dropdown("dukungan_makan",$lookup_empty+$lookup_ya_tidak,$data_assesment["dukungan_makan"],"id='dukungan_makan' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    </div>
                    
                    <div class="col-md-2">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">Pengobatan/Perawatan</label>
                            <? echo form_dropdown("dukungan_pengobatan",$lookup_empty+$lookup_ya_tidak,$data_assesment["dukungan_pengobatan"],"id='dukungan_pengobatan' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    </div>
                    
                  </div><!-- end row -->
                  
                  <div class="row">
                  	<div class="col-md-3">
                  <div class="form-group">
							<label>Skala Penilaian Dukungan</label>
							<?php echo form_input('skala_penilaian_dukungan',$data_assesment["skala_penilaian_dukungan"],'class="form-control required"');?>
						</div>
                  </div></div><!-- end row -->