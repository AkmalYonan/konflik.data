<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_kosong[0]="Tidak Ada";
	
	$lookup_jenis_penggunaan=array(0=>"-")+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_penggunaan'"," order by order_num");
	
	
	$status_rehab[1] = "Registrasi";
	$status_rehab[2] = "Rehab";
	$status_rehab[3] = "Pasca";

	$lookup_proses_rehab=$lookup_empty+lookup("m_proses_rehab","kd_status_proses","ur_proses",false,"order by idx");
	$lookup_tipe_org=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org",false,"order by idx");
	
	$status_pasien['PS'] = "<span class='label label-primary'>Proses</label>";
	$status_pasien['SL'] = "<span class='label label-success'>Selesai</label>";
	$status_pasien['DO'] = "<span class='label label-danger'>DO</label>";
	$status_pasien['KB'] = "<span class='label label-warning'>Kambuh</label>";
	
	
	
	?>
						
					
                      <div class="row">
						<div class="col-md-12">
                        <table class="table table-bordered table-condensed" width='90%'>
							<thead>
								
								<tr>
									<th><p align="center">Tanggal</p></th>
									<!--<th><p align="center">Status Rehab</p></th>-->
									<th><p align="left">Status Proses</p></th>
									<!--<th><p align="center">Status Rawat</p></th>-->
									<th><p align="center">Status Pasien</p></th>
									<!--
									<th><p align="center">Inst Rujuk</p></th>
									<th><p align="center">Rujuk Rehab</p></th>-->
								</tr>
							</thead>
							<tbody>
							<?php if(cek_array($pasien_history_pasca)):?>
								<? foreach($pasien_history_pasca as $x=>$data):?>
								<tr>
									<td align="center">
										<?=date2indo($data['tgl_kegiatan'])?>
									</td>
									<!--<td align="center">
										<?=$status_rehab[$data['status_rehab']]?>
									</td>-->
									<td align="left">
										<?=$lookup_proses_rehab[$data['status_proses']]?>
									</td>
									<!--
									<td align="center">
										<?=$data['status_rawat']?>
									</td>-->
									<td align="center">
										<?=($pasien_history_pasca[$x+1]['status_pasien'])? $status_pasien[$pasien_history_pasca[$x+1]['status_pasien']]:"<span class='label label-primary'>Proses</label>"?>
									</td>
									<!--<td align="center">
										<?=$lookup_tipe_org[$data['inst_rujuk']]?>
									</td>
									<td align="center">
										<?=$data['rujuk_rehab']?>
									</td>-->
									
								</tr>
							<? endforeach;?>
							<?php endif;?>
							</tbody>  
						</table>
						
                        </div>
                      </div><!-- end row-->
                      
                     