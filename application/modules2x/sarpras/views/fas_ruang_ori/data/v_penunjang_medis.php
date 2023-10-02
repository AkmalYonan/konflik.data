							<div class="tab-content">
							  <div id="home" class="tab-pane fade in active">
							 <form id="frm1" action="<?php echo $this->module;?>" method="POST" enctype="multipart/form-data" >
								<p><b>Penunjang Medis</b></p>
								<input type="hidden" name="attr" id="attr" value="penunjang"/>
								<input type="hidden" name="act" id="act" value="add"/>
									<div class="col-md-8">
										<table class="table">
											<?php if(cek_array($data)):?>
												<?php foreach($data as $x=>$val):?>
													<input name="idx[]" value="<?=$val['idx']?>" type="hidden" class="form-control">
													<tr>
														<td><?=$val['uraian']?></td>
														<td>
															<input name="jumlah[]" value="<?=$val['jumlah']?>" type="number" class="form-control">
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