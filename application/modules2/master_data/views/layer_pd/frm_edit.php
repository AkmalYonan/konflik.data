<div class="row">
                    <div class="col-md-6">
                      	<div class="form-group">
                          <label for="kd_group">Kode Group</label>
                          <input class="form-control required" name="kd_group" type="text" id="kd_group" value="<?php echo $data["kd_group"];?>" />
                        </div>
                        <div class="form-group">
                          <label for="ur_group">Uraian Group</label>
                          <input class="form-control required" name="ur_group" id="ur_group" placeholder="" value="<?php echo $data["ur_group"];?>">
                        </div>
                        <div class="form-group">
                          <label for="description">Keterangan</label>
                          <input class="form-control required" name="description" id="description" placeholder="" value="<?php echo $data["description"];?>">
                        </div>
                        
                        <!--<div class="form-group">
                          <? $checked=($data['publish'])?" checked":""; ?>
                        <label>
                            <input type="checkbox" value="1" name="publish"<?=$checked;?> />
                            Publish
                        </label>
                        </div>-->
                     </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                      	<!-- KOSONG -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->