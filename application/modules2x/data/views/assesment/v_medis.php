<?php
	$lookup_empty[""]="--Pilih--";
	
	$lookup_ya_tidak[""]="--Pilih--";
	$lookup_ya_tidak[0]="Tidak";
	$lookup_ya_tidak[1]="Ya";

?>				
                
                <div class="row">
                  	<div class="col-md-12">
                    	<h4 class="heading">Status Medis</h4>
                    </div>
                  </div>
                  
                  <div class="row">
                  	<div class="col-md-3">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">Riwayat Penyakit Kronis</label>
                            <? echo form_dropdown("riwayat_penyakit_kronis",$lookup_empty+$lookup_ya_tidak,$data_assesment["riwayat_penyakit_kronis"],"id='riwayat_penyakit_kronis' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    	
                    </div><!-- end col -->
                    <div class="col-md-3">
                    	<div class="form-group">
							<label>Jenis Penyakit</label>
							<?php echo form_input('jenis_penyakit_kronis',$data_assesment["jenis_penyakit_kronis"],'class="form-control required"');?>
						</div>
                    </div>
                  </div><!-- end row -->
                  
                  <div class="row">
                  	<div class="col-md-3">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">Saat ini sedang menjalani terapi medis</label>
                            <? echo form_dropdown("terapi_medis",$lookup_empty+$lookup_ya_tidak,$data_assesment["terapi_medis"],"id='terapi_medis' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    	
                    </div><!-- end col -->
                    <div class="col-md-3">
                    	<div class="form-group">
							<label>Jenis Terapi medis yang sedang dijalani</label>
							<?php echo form_input('jenis_terapi_medis',$data_assesment["jenis_terapi_medis"],'class="form-control required"');?>
						</div>
                    </div>
                  </div><!-- end row -->
                  
                  <div class="row">
                  	<div class="col-md-6">
                    	<label>Apakah pernah di tes? </label>
                    </div>
                  </div>
                  <div class="row">
                  	<div class="col-md-2">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">HIV</label>
                            <? echo form_dropdown("test_hiv",$lookup_empty+$lookup_ya_tidak,$data_assesment["test_hiv"],"id='test_hiv' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    	
                    </div><!-- end col -->
                    <div class="col-md-2">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">Hepatitis B</label>
                            <? echo form_dropdown("test_hepatitis_b",$lookup_empty+$lookup_ya_tidak,$data_assesment["test_hepatitis_b"],"id='test_hepatitis_b' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    </div>
                    
                    <div class="col-md-2">
                    	<div class="form-group">
                         	<label for="jenis_pendidikan">Hepatitis C</label>
                            <? echo form_dropdown("test_hepatitis_c",$lookup_empty+$lookup_ya_tidak,$data_assesment["test_hepatitis_c"],"id='test_hepatitis_c' class='form-control required'");?>                         
                        </div><!-- end form group-->
                    </div>
                    
                  </div><!-- end row -->
                  
                  <div class="row">
                  	<div class="col-md-3">
                  <div class="form-group">
							<label>Skala Penilaian Medis</label>
							<?php echo form_input('skala_penilaian_medis',$data_assesment["skala_penilaian_medis"],'class="form-control required"');?>
						</div>
                  </div></div><!-- end row -->