<div class="row">
                    <div class="col-md-6">
                      	<div class="form-group">
                          <label for="kd_cat_pp">ID Pustaka</label>
                          <input class="form-control required" name="kd_cat_pp" type="text" id="kd_cat_pp" value="<?php echo $data["kd_cat_pp"];?>" />
                        </div>
                        <div class="form-group">
                          <label for="ur_cat_pp">Jenis Pustaka</label>
                          <input class="form-control required" name="ur_cat_pp" id="ur_cat_pp" placeholder="" value="<?php echo $data["ur_cat_pp"];?>">
                        </div>
                        <div class="form-group">
                          <label for="ur_cat_pp">Keterangan</label>
                          <input class="form-control required" name="description" id="description" placeholder="" value="<?php echo $data["description"];?>">
                        </div>
                        
                        <div class="form-group">
                          <? $checked=($data['publish'])?" checked":""; ?>
                        <label>
                            <input type="checkbox" value="1" name="publish"<?=$checked;?> />
                            Publish
                        </label>
                        </div>
                     </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                      	<!-- KOSONG -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->