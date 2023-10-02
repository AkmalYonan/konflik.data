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
									<? if($rawat_inap):?>
									<th colspan="4"><p align="center">Rawat Inap</p></th>
									<? endif?>
									<? if($rawat_jalan):?>
									<th colspan="3"><p align="center">Rawat Jalan</p></th>
									<? endif?>
									<!--
									<th rowspan="2" width="100"><p align="center">&nbsp;</p></th>
									-->
								</tr>
								<tr>
									<? if($rawat_inap):?>
									<td align="center"><strong>Detoxifikasi</strong></td>
									<td align="center"><strong>Entry Unit</strong></td>
									<td align="center"><strong>Primary Treatment</strong></td>
									<td align="center"><strong>Re-Entry</strong></td>
									<? endif?>
									<? if($rawat_jalan):?>
									
									<td align="center"><strong>Konseling</strong></td>
									<td align="center"><strong>Terapi Kelompok</strong></td>
									<td align="center"><strong>Terapi Simtomatik</strong></td>
									<? endif?>
								</tr>
							</thead>
							<tbody>
								
							<?php if(cek_array($monitoring_rehab)):?>
								
								<tr>
									<? if($rawat_inap):?>
									<td align="center">
										<?=($monitoring_rehab['dt'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_rehab['eu'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_rehab['pt'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_rehab['re'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<? endif?>
									<? if($rawat_jalan):?>
									
									<td align="center">
										<?=($monitoring_rehab['kl'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_rehab['tk'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_rehab['ts'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<? endif?>
								</tr>
                                
                                <!-- TANGGAL -->
                                <tr>
									<? if($rawat_inap):?>
									<td align="center">
										<small><?=($monitoring_rehab['dt'])? date("d/m/Y",strtotime($monitoring_rehab["tgl_dt_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_rehab['eu'])? date("d/m/Y",strtotime($monitoring_rehab["tgl_eu_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_rehab['pt'])? date("d/m/Y",strtotime($monitoring_rehab["tgl_pt_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_rehab['re'])? date("d/m/Y",strtotime($monitoring_rehab["tgl_re_selesai"])):"";?></small>
									</td>
									<? endif?>
									<? if($rawat_jalan):?>
									<td align="center">
										<small><?=($monitoring_rehab['kl'])? date("d/m/Y",strtotime($monitoring_rehab["tgl_kl_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_rehab['tk'])? date("d/m/Y",strtotime($monitoring_rehab["tgl_tk_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_rehab['ts'])? date("d/m/Y",strtotime($monitoring_rehab["tgl_ts_selesai"])):"";?></small>
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
                      
                     