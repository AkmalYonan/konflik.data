
<div class="row">
	<div class="col-md-6">
    	<div class="row">
                            	<div class="col-md-4">
                                
                            <div class="form-group">
                                <?php
                                    $tgl_rekam_medis=$data["tgl_rekam_medis"]?$data["tgl_rekam_medis"]:date("Y-m-d H:i:s");
                                ?>
                                <label for="nama">Tgl Rekam Medis</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                      <input type="text" id="tgl_rekam_medis_selector" class="form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_rekam_medis))?>" placeholder="dd/mm/yyyy"/>
                                      <input type="hidden" id="tgl_rekam_medis" name="tgl_rekam_medis" value="<?=date("Y-m-d",strtotime($tgl_rekam_medis));?>" class="required" />
                                </div>
                            
                            </div><!-- end form group -->
                            
                            </div><!-- end col-->
                            
                            <div class="col-md-8">
                            <div class="form-group">
                              <label for="nama">No Rekam Medik</label>
                              <input class="form-control required" name="no_rekam_medis" id="no_rekam_medis" type="text" value="<?php echo $data["no_rekam_medis"];?>" />
                            </div><!-- end form group -->
                            </div><!-- end col-->
                            </div><!-- end row -->
    </div>
</div><!-- end row-->