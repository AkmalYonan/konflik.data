<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_kosong[0]="Tidak Ada";
	
	$lookup_jenis_penggunaan=array(0=>"-")+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_penggunaan'"," order by order_num");
?>
					<h4 class="heading">RIWAYAT REHABILITASI TERAKHIR</h4>
                      
                      <div class="row">
                        
                        <div class="col-md-4">
                        	<div class="form-group">
                                <label for="jenis_rawat">Status Rawat</label>
                                <? echo form_dropdown("jenis_rawat",$lookup_empty+$lookup_kosong+$this->data_lookup["jenis_rawat"],$data["jenis_rawat"],"id='jenis_rawat' class='form-control select2'");?>                         
                            </div><!-- end form group-->
                        
                        	<div class="form-group">
                                <label for="proses_rawat">Proses Rawat</label>
                                <? echo form_dropdown("proses_rawat",$lookup_empty+$lookup_kosong+$this->data_lookup["proses_rawat"],$data["proses_rawat"],"id='proses_rawat' class='form-control select2'");?>                         
                            </div><!-- end form group-->
                        </div><!-- end col-->
                        
                        <div class="col-md-4">
                        
                        	<div class="row">
                            	<div class="col-md-6">
                               
                        	<div class="form-group">
                                <?php
                                    $tgl_masuk_rehab=$data["tgl_masuk_rehab"]?$data["tgl_masuk_rehab"]:date("Y-m-d H:i:s");
                                ?>
                                <label for="nama">Tgl Masuk</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                      <input type="text" id="tgl_masuk_rehab_selector" class="form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_masuk_rehab))?>" placeholder="dd/mm/yyyy"/>
                                      <input type="hidden" id="tgl_masuk_rehab" name="tgl_masuk_rehab" value="<?=date("Y-m-d",strtotime($tgl_masuk_rehab));?>" class="required" />
                                </div>
                            
                            </div><!-- end form group -->
                            </div><!-- end col -->
                            <div class="col-md-6">
                            
                            <div class="form-group">
                                <?php
                                    $tgl_keluar_rehab=$data["tgl_keluar_rehab"]?$data["tgl_keluar_rehab"]:date("Y-m-d H:i:s");
                                ?>
                                <label for="nama">Tgl Registrasi</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                      <input type="text" id="tgl_keluar_rehab_selector" class="form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_keluar_rehab))?>" placeholder="dd/mm/yyyy"/>
                                      <input type="hidden" id="tgl_keluar_rehab" name="tgl_keluar_rehab" value="<?=date("Y-m-d",strtotime($tgl_keluar_rehab));?>" class="required" />
                                </div>
                            
                            </div><!-- end form group -->
                        	 </div><!-- end col -->
                            </div><!-- endrow-->
                            <div class="form-group">
                              <label for="nama">Lama Rehab</label>
                              <input class="form-control" name="lama_rehabilitasi" id="lama_rehabilitasi" type="text" value="<?php echo $data["lama_rehabilitasi"];?>" />
                            </div><!-- end form group -->
                        
                        </div><!-- end col-->
                        
                      </div><!-- end row-->
                      
                      <h4 class="heading">RIWAYAT KESEHATAN PASIEN TERAKHIR</h4>
                      <div class="row">
                        
                        
                        <div class="col-md-4">
                        		<div class="form-group">
                                	<label for="jenis_rawat">Narkoba yang digunakan pertama kali</label>
                                	<? echo form_dropdown("narkoba_pertama_pakai",$lookup_empty+$lookup_kosong+$this->data_lookup["kode_narkoba"],$data["narkoba_pertama_pakai"],"id='narkoba_pertama_pakai' class='form-control select2'");?>                         
                            	</div><!-- end form group-->
                                
                                <div class="form-group">
                                	<label for="jenis_rawat">Penyakit Penyerta</label>
                                	<? echo form_dropdown("penyakit_penyerta",$lookup_empty+$lookup_kosong+$this->data_lookup["kode_penyakit"],$data["penyakit_penyerta"],"id='penyakit_penyerta' class='form-control select2'");?>                         
                            	</div><!-- end form group-->
                            </div><!-- end col -->
                             <div class="col-md-4">    
                                <div class="form-group">
                                	<label for="jenis_rawat">Narkoba yang digunakan 1 tahun terakhir</label>
                                	<? echo form_dropdown("narkoba_terakhir",$lookup_empty+$lookup_kosong+$this->data_lookup["kode_narkoba"],$data["narkoba_terakhir"],"id='narkoba_terakhir' class='form-control select2'");?>                         
                            	</div><!-- end form group-->
                                
                                <div class="form-group">
                                	<label for="jenis_rawat">Cara pakai narkoba 1 tahun terakhir</label>
                                	<? echo form_dropdown("cara_pakai",$lookup_empty+$lookup_kosong+$this->data_lookup["jenis_penggunaan"],$data["cara_pakai"],"id='cara_pakai' class='form-control select2'");?>                         
                            	</div><!-- end form group-->
                        
                        </div><!-- end col-->
                        
                        <div class="col-md-6">
                        </div><!-- end col-->
                        
                      </div><!-- end row-->