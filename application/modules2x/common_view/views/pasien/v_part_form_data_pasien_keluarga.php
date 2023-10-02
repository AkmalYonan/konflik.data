<?php
	$lookup_empty=array(""=>"--pilih--");
	$lookup_bnnp=$lookup_empty+lookup("m_org","kd_org","nama","tipe_org='BNNP'","order by idx");
	
	$lookup_keluarga=$lookup_empty+$this->data_lookup["hubungan_keluarga"];
	
?>

<h4 class="heading">Data Keluarga</h4>
            
            <div class="row">
            	<div class="col-md-6">
                
                
                <div class="form-group">
                         <label for="first_name">Nama Keluarga yang bisa dihubungi:<span class="asterix">&nbsp;*</span></label>                    	 	
                         <input name="klg_nama" value="<?=$data["klg_nama"]?>" id="klg_nama" class="form-control required" type="text">   
                </div>
                
                <div class="form-group">
                    <label for="hubungan_keluarga">Hubungan Keluarga:<span class="asterix">&nbsp;*</span></label>
                    <? echo form_dropdown("klg_hubungan",$lookup_keluarga,$data["klg_hubungan"],"id='klg_hubungan' class='form-control select2 required'");?>
                </div>
                     
                <div class="form-group">
                            <label for="alamat">Alamat:<span class="asterix">&nbsp;*</span></label>                            <textarea name="klg_alamat" class="form-control required" rows="3"><?=$data["klg_alamat"]?></textarea>
                </div>
                
                
                <div class="form-group">
                              <label for="nama">No Telp/HP</label>
                              <input class="form-control required" name="klg_telp" id="klg_telp" type="text" value="<?php echo $data["klg_telp"];?>" />
                            </div><!-- end form group -->
                     
                </div><!-- end col -->
            </div><!-- end row-->