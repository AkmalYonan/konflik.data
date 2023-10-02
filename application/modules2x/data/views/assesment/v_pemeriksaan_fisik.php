
<div class="row">
        	<div class="col-md-12">
             	<h4 class="heading">PEMERIKSAAN FISIK</h4>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-md-3">
            	<div class="form-group">
					<label>Tekanan Darah</label>
					<?php echo form_input('tekanan_darah',$data_assesment_fisik["tekanan_darah"],'class="form-control required"');?>
				</div><!-- end form group-->
              </div><!-- end col -->
              <div class="col-md-3">  
                <div class="form-group">
					<label>Nadi</label>
					<?php echo form_input('nadi',$data_assesment_fisik["nadi"],'class="form-control required"');?>
				</div><!-- end form group-->
               </div><!-- end col -->
               
               <div class="col-md-3">   
                <div class="form-group">
					<label>Pernapasan (RR)</label>
					<?php echo form_input('pernapasan',$data_assesment_fisik["pernapasan"],'class="form-control required"');?>
				</div><!-- end form group-->
                </div><!-- end col -->
                
              <div class="col-md-3">  
                <div class="form-group">
					<label>Suhu (Celcius)</label>
					<?php echo form_input('suhu',$data_assesment_fisik["suhu"],'class="form-control required"');?>
				</div><!-- end form group-->
            	
            </div><!-- end col-->
        </div><!-- end row-->
        
        <div class="row">
        	<div class="col-md-6">
            	
                
                <label>Hasil Urinalis</label>
            	<table style="width:75%" class="table table-bordered table-condensed">
                	<tr>
                    	<td>Benzodiazepin</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="benzodiazepin_u" class="flat-red" <?php echo $data_assesment_fisik['benzodiazepin_u']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>Kanabis</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="kanabis_u" class="flat-red" <?php echo $data_assesment_fisik['kanabis_u']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>Opiat</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="opiat_u" class="flat-red" <?php echo $data_assesment_fisik['opiat_u']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>Amfetamin</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="ampetamin_u" class="flat-red" <?php echo $data_assesment_fisik['ampetamin_u']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>Kokain</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="kokain_u" class="flat-red" <?php echo $data_assesment_fisik['kokain_u']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>Barbiturat</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="barbiturat_u" class="flat-red" <?php echo $data_assesment_fisik['barbiturat_u']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>Alkohol</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="alkohol_u" class="flat-red" <?php echo $data_assesment_fisik['alkohol_u']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    
                </table>    
                          
            
            </div><!-- end col -->
        </div><!-- end row -->