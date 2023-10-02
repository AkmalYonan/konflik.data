<?php
	$lookup_empty[""]="--Pilih--";
    $lookup_ya_tidak[0]="Tidak";
	$lookup_ya_tidak[1]="Ya";
?>
        
        <div class="row">
        	<div class="col-md-12">
             	<h4 class="heading">Status Legal</h4>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-md-6">
       			       <label>Berapa kali kah dalam hidup anda ditangkap dan dituntut berikut: </label>
				  
            </div><!-- end col -->
       </div><!-- end row-->
        
         <div class="row">
        	<div class="col-md-6">
            
              
            
            <table style="width:100%" class="table table-bordered table-condensed">
            	<tr>
                    	<td>1. Mencuri di toko/vandalisme</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="mencuri" class="flat-red" <?php echo $data_assesment_legal['mencuri']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('mencuri_kali',$data_assesment_legal["mencuri_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group-->  
                           </td>
                 </tr>
                <tr>
                    	<td>2. Bebas bersyarat/masa percobaan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="bebas_bersyarat" class="flat-red" <?php echo $data_assesment_legal['bebas_bersyarat']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('bebas_bersyarat_kali',$data_assesment_legal["bebas_bersyarat_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group-->   
                           </td>
                 </tr>
                 
                  <tr>
                    	<td>3. Masalah narkoba</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="narkoba" class="flat-red" <?php echo $data_assesment_legal['narkoba']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          	 <div class="form-group">
                            	<?php echo form_input('narkoba_kali',$data_assesment_legal["narkoba_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group-->  
                           </td>
                 </tr>
                 
                 <tr>
                    	<td>4. Pemalsuan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="pemalsuan" class="flat-red" <?php echo $data_assesment_narkotika['pemalsuan']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          	<div class="form-group">
                            	<?php echo form_input('pemalsuan_kali',$data_assesment_legal["pemalsuan_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group-->  
                          </td>
                 </tr>
                 
                 <tr>
                    	<td>5. Penyerangan bersenjata</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="penyerangan_bersenjata" class="flat-red" <?php echo $data_assesment_legal['penyerangan_bersenjata']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          	<div class="form-group">
                            	<?php echo form_input('penyerangan_bersenjata_kali',$data_assesment_legal["penyerangan_bersenjata_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group-->  
                          </td>
                 </tr>
                 
                 
                  <tr>
                    	<td>6. Pembobolan dan pencurian</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="pencurian" class="flat-red" <?php echo $data_assesment_legal['pencurian']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('pencurian_kali',$data_assesment_legal["pencurian_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group-->  
                          </td>
                 </tr>
                 
                 
                 <tr>
                    	<td>7. Perampokan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="perampokan" class="flat-red" <?php echo $data_assesment_legal['perampokan']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('perampokan_kali',$data_assesment_legal["perampokan_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group-->  
                          </td>
                 </tr>
                 
                 
                  <tr>
                    	<td>8. Penyerangan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="penyerangan" class="flat-red" <?php echo $data_assesment_legal['penyerangan']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('penyerangan_kali',$data_assesment_legal["penyerangan_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group--> 
                          
                          </td>
                 </tr>
                 
                 
                  <tr>
                    	<td>9. Pembakaran rumah</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="pembakaran" class="flat-red" <?php echo $data_assesment_legal['pembakaran']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('pembakaran_kali',$data_assesment_legal["pembakaran_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group--> 
                          </td>
                 </tr>
                 
                 
                  <tr>
                    	<td>10. Perkosaan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="perkosaan" class="flat-red" <?php echo $data_assesment_legal['perkosaan']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('perkosaan_kali',$data_assesment_legal["perkosaan_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group--> 
                          </td>
                 </tr>
                  <tr>
                    	<td>11. Pembunuhan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="pembunuhan" class="flat-red" <?php echo $data_assesment_legal['pembunuhan']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('pembunuhan_kali',$data_assesment_legal["pembunuhan_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group--> 
                          </td>
                 </tr>
                 
                 <tr>
                    	<td>12. Pelacuran</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="pelacuran" class="flat-red" <?php echo $data_assesment_legal['pelacuran']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          	<div class="form-group">
                            	<?php echo form_input('pelacuran_kali',$data_assesment_legal["pelacuran_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group--> 
                          </td>
                 </tr>
                 
                 
                 <tr>
                    	<td>13. Melecehkan pengadilan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="pelecehan_pengadilan" class="flat-red" <?php echo $data_assesment_legal['pelecehan_pengadilan']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          	<div class="form-group">
                            	<?php echo form_input('pelecehan_pengadilan_kali',$data_assesment_legal["pelecehan_pengadilan_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group--> 
                          </td>
                 </tr>
                 
                 <tr>
                    	<td>14. Lain-lain</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="lain_lain" class="flat-red" <?php echo $data_assesment_legal['lain_lain']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('lain_lain_kali',$data_assesment_legal["lain_lain_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group--> 
                          </td>
                 </tr>
                 
                 <tr>
                    	<td>15. Berapa kali tuntutan diatas berakibat vonis hukuman</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="vonis" class="flat-red" <?php echo $data_assesment_legal['vonis']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="100px" class="tc">
                          		<div class="form-group">
                            	<?php echo form_input('vonis_kali',$data_assesment_legal["vonis_kali"],'class="form-control"');?>                    
                 				</div><!-- end form group--> 
                          </td>
                 </tr>
                 
                 
                 
                 
                 
                 
                 
                 
                    
                    
            </table>
            </div><!-- end col -->
            
            
         </div><!-- end row -->
         
         
         <div class="row">
         	<div class="col-md-3">
            	<div class="form-group">
                        	<?php
                            	$tgl_assesment_legal=$data_assesment_legal["tgl_assesment_legal"]?$data_assesment_legal["tgl_assesment_legal"]:date("Y-m-d H:i:s");
							?>
                        	<label for="nama">Tgl Asesmen</label>
                        	<div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" id="tgl_assesment_legal_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_assesment_legal))?>" placeholder="dd/mm/yyyy"/>
                                  <input type="hidden" id="tgl_assesment_legal" name="tgl_assesment_legal" value="<?=date("Y-m-d",strtotime($tgl_assesment_legal));?>" class="required" />
                            </div>
                        
                        </div><!-- end form group -->	
            </div><!-- end col -->
            
            <div class="col-md-3">
            	<div class="form-group">
							<label>Skala Penilaian Pasien</label>
							<?php echo form_input('skala_penilaian_legal',$data_assesment_legal["skala_penilaian_legal"],'class="form-control required"');?>
						</div>
            </div><!-- end col-->
            
         </div><!-- end row -->