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
									<? if($rawat_lanjut_pemantauan):?>
									<th colspan="4"><p align="center">Pemantauan</p></th>
									<? endif?>
									<? if($rawat_lanjut_pendampingan):?>
									<th colspan="3"><p align="center">Pendampingan</p></th>
									<? endif?>
									<!--
									<th rowspan="2" width="100"><p align="center">&nbsp;</p></th>
									-->
								</tr>
								<tr>
									<? if($rawat_lanjut_pemantauan):?>
									<th><p align="center">Kegiatan Produktif</p></th>
									<th><p align="center">Evaluasi Perkembangan</p></th>
									<th><p align="center">Tes Urin</p></th>
									<? endif?>
									<? if($rawat_lanjut_pendampingan):?>
									<th><p align="center">Home Visit</p></th>
									<th><p align="center">Pertemuan Kelompok</p></th>
									<th><p align="center">Konseling</p></th>
									<th><p align="center">Tes Urin</p></th>
									<? endif?>
								</tr>
							</thead>
							<tbody>  
                                
							<?php if(cek_array($monitoring_pasca)):?>
								<tr>
									<? if($rawat_lanjut_pemantauan):?>
									<td align="center">
										<?=($monitoring_pasca['pukp'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_pasca['puep'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_pasca['putu'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<? endif?>
									<? if($rawat_lanjut_pendampingan):?>
									<td align="center">
										<?=($monitoring_pasca['pdhv'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_pasca['pdpk'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_pasca['pdkl'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<td align="center">
										<?=($monitoring_pasca['pdtu'])? "<i class='fa fa-check' style='color:green'></i>":"<i class='fa fa-minus' style='color:red'></i>";?>
									</td>
									<? endif?>
								</tr>
							<?php endif;?>
                            <?php if(cek_array($monitoring_pasca)):?>
								<tr>
									<? if($rawat_lanjut_pemantauan):?>
									<td align="center">
										<small><?=($monitoring_pasca['pukp'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_pukp_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_pasca['puep'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_puep_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_pasca['putu'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_putu_selesai"])):"";?></small>
									</td>
									<? endif?>
									<? if($rawat_lanjut_pendampingan):?>
									<td align="center">
										<small><?=($monitoring_pasca['pdhv'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_pdhv_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_pasca['pdpk'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_pdpk_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_pasca['pdkl'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_pdkl_selesai"])):"";?></small>
									</td>
									<td align="center">
										<small><?=($monitoring_pasca['pdtu'])? date("d/m/Y",strtotime($monitoring_pasca["tgl_pdtu_selesai"])):"";?></small>
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
							    <tr><td width='20'><i class='fa fa-minus' style='color:red'></i><td><td>Pasien Tidak/Belum Sudah Melewati Proses.</td></tr>
								</table>
						</div>
                        </div>
                      </div><!-- end row-->
                      
                     