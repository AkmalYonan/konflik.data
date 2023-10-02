							<div class="tab-content">
							  <div id="home" class="tab-pane fade in active">
							  <form id="frm1" action="<?php echo $this->module;?>" method="POST" enctype="multipart/form-data" >
								<p><b>Peralatan</b></p>
								<input type="hidden" name="attr" id="attr" value="alat"/>
								<input type="hidden" name="act" id="act" value="add"/>
									<div class="col-md-6">
										<table class="table">
											<?php if(cek_array($data)):?>
												<?php foreach($data as $x=>$val):?>
													<input name="idx[]" value="<?=$val['idx']?>" type="hidden" class="form-control">
													<tr>
														<td><?=$val['uraian']?></td>
														<td>
															<select name="status1[]" class="form-control">
																<option value="">--Pilih--</option>
																<option <?=($val['status1']=='Ada')?'selected':''?> value="Ada">Ada</option>
																<option <?=($val['status1']=='Tidak Ada')?'selected':''?> value="Tidak Ada">Tidak Ada</option>
															</select>
														</td>
														<td>
															<select name="status2[]" class="form-control">
																<option value="">--Pilih--</option>
																<option <?=($val['status2']=='Berfungsi')?'selected':''?> value="Berfungsi">Berfungsi</option>
																<option <?=($val['status2']=='Tidak Berfungsi')?'selected':''?> value="Tidak Berfungsi">Tidak Berfungsi</option>
															</select>
														</td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</table>
									</div>
									<div class="col-md-6">
										<table class="table">
											<?php if(cek_array($data2)):?>
												<?php foreach($data2 as $x2=>$val2):?>
													<input name="idx[]" value="<?=$val2['idx']?>" type="hidden" class="form-control">
													<tr>
														<td><?=$val2['uraian']?></td>
														<td>
															<select name="status1[]" class="form-control">
																<option value="">--Pilih--</option>
																<option <?=($val2['status1']=='Ada')?'selected':''?> value="Ada">Ada</option>
																<option <?=($val2['status1']=='Tidak Ada')?'selected':''?> value="Tidak Ada">Tidak Ada</option>
															</select>
														</td>
														<td>
															<select name="status2[]" class="form-control">
																<option value="">--Pilih--</option>
																<option <?=($val2['status2']=='Berfungsi')?'selected':''?> value="Berfungsi">Berfungsi</option>
																<option <?=($val2['status2']=='Tidak Berfungsi')?'selected':''?> value="Tidak Berfungsi">Tidak Berfungsi</option>
															</select>
														</td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</table>
									</div>
									</form>
							  </div>
							  <div id="menu1" class="tab-pane fade">
								<h3>Menu 1</h3>
								<p>Some content in menu 1.</p>
							  </div>
							  <div id="menu2" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
							  </div>
							  <div id="menu3" class="tab-pane fade">
								<h3>Menu 1</h3>
								<p>Some content in menu 1.</p>
							  </div>
							  <div id="menu4" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
							  </div>
							  <div id="menu5" class="tab-pane fade">
								<h3>Menu 1</h3>
								<p>Some content in menu 1.</p>
							  </div>
							  <div id="menu6" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
							  </div>
							</div>
						</div>