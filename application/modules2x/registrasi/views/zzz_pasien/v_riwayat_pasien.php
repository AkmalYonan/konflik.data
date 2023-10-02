<?php
	$lookup_empty[""]="--Pilih--";
?>
<h4 class="heading">RIWAYAT REHABILITASI TERAKHIR</h4>
                      
                      <div class="row">
                        
                        <div class="col-md-6">
                        	
                        </div><!-- end col-->
                        
                        <div class="col-md-6">
                        </div><!-- end col-->
                        
                      </div><!-- end row-->
                      
                      <h4 class="heading">RIWAYAT KESEHATAN PASIEN TERAKHIR</h4>
                      <div class="row">
                        
                        
                        <div class="col-md-6">
                        		<div class="form-group">
                                <label for="jenis_pendidikan">Status Rawat</label>
                                <? echo form_dropdown("status_rawat",$lookup_empty+$this->data_lookup["jenis_rawat"],$data["status_rawat"],"id='status_rawat' class='form-control select2 required'");?>                         
                            </div><!-- end form group-->
                        
                        	<div class="form-group">
                                <label for="proses_rawat">Proses Rawat</label>
                                <? echo form_dropdown("proses_rawat",$lookup_empty+$this->data_lookup["proses_rawat"],$data["status_rawat"],"id='proses_rawat' class='form-control select2 required'");?>                         
                            </div><!-- end form group-->
                        
                        </div><!-- end col-->
                        
                        <div class="col-md-6">
                        </div><!-- end col-->
                        
                      </div><!-- end row-->