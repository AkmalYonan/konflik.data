<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_kosong[0]="Tidak Ada";
	$lookup_jenis_penggunaan=array(0=>"-")+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_penggunaan'"," order by order_num");
?>
					
                      <div class="row">
						<div class="col-md-12">
                        <table class="table table-bordered table-condensed" width='90%'>
							<thead>
								<tr>
									<? if($rawat_inap_pasca):?>
									<th colspan="2"><p align="center">Rawat Inap</p></th>
									<? endif?>
									<? if($rawat_jalan_pasca):?>
									<th colspan="3"><p align="center">Rawat Jalan</p></th>
									<? endif?>
									
									<!--
									<th rowspan="2" width="100"><p align="center">&nbsp;</p></th>
									-->
								</tr>
								<tr>
									<? if($rawat_inap_pasca):?>
									<td align="center"><strong>Daily Activity</strong></td>
									<td align="center"><strong>Discharge / Rujukan</strong></td>
									
									<? endif?>
									<? if($rawat_jalan_pasca):?>
									<td align="center"><strong>Peer Group</strong></td>
									<td align="center"><strong>Pengembangan Diri</strong></td>
									<td align="center"><strong>Dukungan Keluarga</strong></td>
									
									<? endif?>
								</tr>
							</thead>
							<tbody>
							<?php if(cek_array($monitoring_pasca)):?>
								<tr>
									<? if($rawat_inap_pasca):?>
									<td align="center">
										<?=($monitoring_pasca['da'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_pasca['dr'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<? endif?>
									<? if($rawat_jalan_pasca):?>
									<td align="center">
										<?=($monitoring_pasca['pg'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_pasca['pd'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_pasca['dk'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<? endif?>
								</tr>
								
							<?php endif;?>
                            
                            <?php if(cek_array($monitoring_pasca)):?>
								<tr>
									<? if($rawat_inap_pasca):?>
									<td align="center">
										<small><?=($monitoring_pasca['da'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_da_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_pasca['dr'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_dr_selesai"])):"";?></small>
									</td>
									<? endif?>
									<? if($rawat_jalan_pasca):?>
									<td align="center">
										<small><?=($monitoring_pasca['pg'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_pg_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_pasca['pd'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_pd_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_pasca['dk'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_dk_selesai"])):"";?></small>
									</td>
									<? endif?>
								</tr>
								
							<?php endif;?>
							</tbody>  
						</table>
						<div class="well">
							Ket : <br />
								<table border="0">
							    <tr><td width='20'><i class='fa fa-check' style='color:green'></i><td><td>Pasien Sudah Melewati Proses.<td></tr>
							    <tr><td width='20'><i class='fa fa-minus' style='color:red'></i><td><td>Pasien Tidak/Belum Melewati Proses.</td></tr>
								</table>
						</div>
                        </div>
                      </div><!-- end row-->
                      
                     