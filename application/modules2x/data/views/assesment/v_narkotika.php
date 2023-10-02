<?php
	$lookup_empty[""]="--Pilih--";
    $lookup_ya_tidak[0]="Tidak";
	$lookup_ya_tidak[1]="Ya";
	
	$lookup_jenis_penggunaan=array(0=>"-")+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_penggunaan'"," order by order_num");
?>
        
        <div class="row">
        	<div class="col-md-12">
             	<h4 class="heading">Status Penggunaan Narkotika</h4>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-md-6">
       			<div class="form-group">
                       <label>Cara Pemakaian</label><br>
                       <span style="padding-right:20px">1. Oral</span>
                       <span style="padding-right:20px">2. Nasal/sublingual/suppositoria</span>
                       <span style="padding-right:20px">3. Merokok</span>
                       <span style="padding-right:20px">4. Injeksi Non-IV</span>
                       <span style="padding-right:20px">5. IV</span>
                       
					<?php //echo form_input('cara_penggunaan',$data_assesment_narkotika["cara_penggunaan"],'class="form-control required"');?>                    
           		</div><!-- end form group-->      
            </div><!-- end col -->
            
       </div><!-- end row-->
        
         <div class="row">
        	<div class="col-md-6">
            
              
            
            <table style="width:100%" class="table table-bordered table-condensed">
            	<tr><th>Jenis NAPZA</th><th>30 Hari Terakhir</th><th>Sepanjang Hidup</th><th>Cara Pakai</th></tr>
                <tr>
                    	<td>D.1. Alkohol</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="alkohol_30" class="flat-red" <?php echo $data_assesment_narkotika['alkohol_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="alkohol_sh" class="flat-red" <?php echo $data_assesment_narkotika['alkohol_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="150px" class="tc">
                          	 <div class="form-group">
                         	<? echo form_dropdown("alkohol_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["alkohol_cp"],"id='alkohol_cp' class='form-control'");?>                            </div><!-- end form group-->
                          
                          </td>
                 </tr>
                 <tr>
                    	<td>D.2. Heroin</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="heroin_30" class="flat-red" <?php echo $data_assesment_narkotika['heroin_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="heroin_sh" class="flat-red" <?php echo $data_assesment_narkotika['heroin_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td class="tc"><div class="form-group">
                         	<? echo form_dropdown("heroin_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["heroin_cp"],"id='heroin_cp' class='form-control'");?>                            </div><!-- end form group--></td>
                 </tr>
                  <tr>
                    	<td>D.3. Metadon/Bufrenorfin</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="metadon_30" class="flat-red" <?php echo $data_assesment_narkotika['metadon_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="metadon_sh" class="flat-red" <?php echo $data_assesment_narkotika['metadon_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc"><span class="form-group"><? echo form_dropdown("metadon_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["metadon_cp"],"id='metadon_cp' class='form-control'");?></span></td>
                 </tr>
                 <tr>
                    	<td>D.4. Opiat lain/Analgesik</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="opiat_30" class="flat-red" <?php echo $data_assesment_narkotika['opiat_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="opiat_sh" class="flat-red" <?php echo $data_assesment_narkotika['opiat_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc"><span class="form-group"><? echo form_dropdown("opiat_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["opiat_cp"],"id='opiat_cp' class='form-control'");?></span></td>
                 </tr>
                 <tr>
                    	<td>D.5. Barbiturat</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="barbiturat_30" class="flat-red" <?php echo $data_assesment_narkotika['barbiturat_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="barbiturat_sh" class="flat-red" <?php echo $data_assesment_narkotika['barbiturat_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc"><span class="form-group"><? echo form_dropdown("barbiturat_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["barbiturat_cp"],"id='barbiturat_cp' class='form-control'");?></span></td>
                 </tr>
                 
                 
                  <tr>
                    	<td>D.6. Sediatif/Hipnotik</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="sediatif_30" class="flat-red" <?php echo $data_assesment_narkotika['sediatif_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="sediatif_sh" class="flat-red" <?php echo $data_assesment_narkotika['sediatif_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc"><span class="form-group"><? echo form_dropdown("sediatif_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["sediatif_cp"],"id='sediatif_cp' class='form-control'");?></span></td>
                 </tr>
                 
                 
                  <tr>
                    	<td>D.7. Kokain</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="kokain_30" class="flat-red" <?php echo $data_assesment_narkotika['kokain_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="kokain_sh" class="flat-red" <?php echo $data_assesment_narkotika['kokain_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc"><span class="form-group"><? echo form_dropdown("kokain_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["kokain_cp"],"id='kokain_cp' class='form-control'");?></span></td>
                 </tr>
                 
                 
                  <tr>
                    	<td>D.8. Ampetamin</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="ampetamin_30" class="flat-red" <?php echo $data_assesment_narkotika['ampetamin_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="ampetamin_sh" class="flat-red" <?php echo $data_assesment_narkotika['ampetamin_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc"><span class="form-group"><? echo form_dropdown("ampetamin_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["ampetamin_cp"],"id='ampetamin_cp' class='form-control'");?></span></td>
                 </tr>
                 
                 
                  <tr>
                    	<td>D.9. Kanabis</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="kanabis_30" class="flat-red" <?php echo $data_assesment_narkotika['kanabis_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="kanabis_sh" class="flat-red" <?php echo $data_assesment_narkotika['kanabis_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc"><span class="form-group"><? echo form_dropdown("kanabis_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["kanabis_cp"],"id='kanabis_cp' class='form-control'");?></span></td>
                 </tr>
                 
                  <tr>
                    	<td>D.10. Halusinogen</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="halusinogen_30" class="flat-red" <?php echo $data_assesment_narkotika['halusinogen_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="halusinogen_sh" class="flat-red" <?php echo $data_assesment_narkotika['halusinogen_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc"><span class="form-group"><? echo form_dropdown("halusinogen_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["halusinogen_cp"],"id='halusinogen_cp' class='form-control'");?></span></td>
                 </tr>
                 
                 
                  <tr>
                    	<td>D.11. Inhalan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="inhalan_30" class="flat-red" <?php echo $data_assesment_narkotika['inhalan_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="inhalan_sh" class="flat-red" <?php echo $data_assesment_narkotika['inhalan_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc"><span class="form-group"><? echo form_dropdown("inhalan_cp",$lookup_jenis_penggunaan,$data_assesment_narkotika["inhalan_cp"],"id='inhalan_cp' class='form-control'");?></span></td>
                 </tr>
                 
                 
                  <tr>
                    	<td>D.12. Lebih dari 1 zat/hari</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="lebih_30" class="flat-red" <?php echo $data_assesment_narkotika['lebih_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="lebih_sh" class="flat-red" <?php echo $data_assesment_narkotika['lebih_sh']?"checked='checked'":'';?> value="1">
                          </td>
                          <td width="50px" class="tc">&nbsp;</td>
                 </tr>
                 
                 
                    
                    
            </table>
            </div><!-- end col -->
            
            <div class="col-md-6">
            	<div class="form-group">
					<label>Jenis zat utama yang di salah gunakan</label>
					<?php echo form_input('jenis_zat_utama',$data_assesment_narkotika["jenis_zat_utama"],'class="form-control required"');?>
				</div>
                
                <div class="form-group">
                         	<label for="jenis_pendidikan">Pernah menjalani tes rehabilitasi?</label>
                            <? echo form_dropdown("test_rehab",$lookup_empty+$lookup_ya_tidak,$data_assesment_narkotika["test_rehab"],"id='test_rehab' class='form-control required'");?>                         
                        </div><!-- end form group-->
                        
                 <div class="form-group">
					<label>Jenis Terapi medis yang sedang dijalani</label>
					<?php echo form_input('terapi_rehab',$data_assesment_narkotika["terapi_rehab"],'class="form-control required"');?>
				</div>       
            	
                
                <div class="form-group">
                         	<label for="jenis_pendidikan">Pernah mengalami overdosis?</label>
                            <? echo form_dropdown("pernah_od",$lookup_empty+$lookup_ya_tidak,$data_assesment_narkotika["pernah_od"],"id='pernah_od' class='form-control required'");?>                         
                        </div><!-- end form group-->
                        
                        
                <div class="form-group">
                       <label>Waktu Overdosis</label>
					<?php echo form_input('waktu_od',$data_assesment_narkotika["waktu_od"],'class="form-control required"');?>                    
                 </div><!-- end form group-->   
                 
                 <div class="form-group">
                       <label>Cara Penanggulangan</label>
					<?php echo form_input('cara_penanggulangan',$data_assesment_narkotika["cara_penanggulangan"],'class="form-control required"');?>                    
                 </div><!-- end form group-->    
                 
                     
            </div>
         </div><!-- end row -->
         
         <div class="row">
         	<div class="col-md-3">
            	<div class="form-group">
                        	<?php
                            	$tgl_assesment_narkotika=$data_assesment_narkotika["tgl_assesment_narkotika"]?$data_assesment_narkotika["tgl_assesment_narkotika"]:date("Y-m-d H:i:s");
							?>
                        	<label for="nama">Tgl Asesmen</label>
                        	<div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" id="tgl_assesment_narkotika_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_assesment_narkotika))?>" placeholder="dd/mm/yyyy"/>
                                  <input type="hidden" id="tgl_assesment_narkotika" name="tgl_assesment_narkotika" value="<?=date("Y-m-d",strtotime($tgl_assesment_narkotika));?>" class="required" />
                            </div>
                        
                        </div><!-- end form group -->	
            </div><!-- end col -->
            
            <div class="col-md-3">
            	<div class="form-group">
							<label>Skala Penilaian Pasien</label>
							<?php echo form_input('skala_penilaian_narkotika',$data_assesment_narkotika["skala_penilaian_narkotika"],'class="form-control required"');?>
						</div>
            </div><!-- end col-->
            
         </div><!-- end row -->