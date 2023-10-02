<?
	$lookup_status_konflik["BD"]="Belum Ditangani";
	$lookup_status_konflik["PS"]="Dalam Proses";
	$lookup_status_konflik["SL"]="Selesai";

	$label_status_konflik["BD"]="warning";
	$label_status_konflik["PS"]="info";
	$label_status_konflik["SL"]="primary";
	
	$lookup_kategori["K1"]="Masyarakat Adat";
	$lookup_kategori["K2"]="Non Masyarakat Adat";
	
	$lookup_status_konflik_proses["Mediasi"]="Mediasi";
	$lookup_status_konflik_proses["Hukum"]="Hukum";
	
	$label_sifat['Public']="info";
	$label_sifat['Private']="danger";
	

?>
<table>
	<tr>
		<td colspan="5"><b>Daftar Data Konflik</b></td>
	</tr>
	<tr>
		<td>Tahun : <?=$header['tahun']?> </td>
	</tr>
</table>
<br />

<div class="box-body table-responsive">
	<table class="blek" border="1">
		<thead >
	
			<tr >
				<td align="center" style="vertical-align: text-top;" class="ret blek" rowspan='2' width="20px"><b>No.</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Tanggal <br/> Kejadian</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>X (Longitude)</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>X (Longitude)</b></td>
				<!--<td align="center" class="ret blek" rowspan='2'><b>Nomor <br/> Kejadian</b></td>-->
				<td align="center" class="ret blek" colspan="3"><b>Konten</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Konflik</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Sektor</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Status</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Kategori</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Investasi <br> (Rp) </b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Luas <br> (Ha)</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Dampak Masyarakat <br> (Jiwa)</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Confidentiality</b></td>
				<td align="center" class="ret blek" rowspan='2'><b>Entry</b></td>
			</tr>
			<tr>
				<td align="center" class="ret blek"><b>Judul</b></td>
				<td align="center" class="ret blek"><b>Clip</b></td>
				<td align="center" class="ret blek"><b>Narasi</b></td>
			</tr>
					
		</thead>
		
		<tbody >
			<?php if(cek_array($data)):?>
				<?php foreach($data as $x=>$val):
					
					$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];

					$exp_luas	=	explode(".",$val["luas"]);
					$luas		=	number_format($exp_luas[0]);
					$exp_investasi	=	explode(".",$val["investasi"]);
					$investasi		=	number_format($exp_investasi[0]);

				?>
					<tr class="blek">
						<td class="blek"><?php echo $offset+$x+1?>.</td>
						<td class="blek"><?=date_format(date_create($val['tgl_kejadian']),"d-m-Y")?></td>
						<td class="blek" align='justify'><?=$val["longitude"]?></td>
						<td class="blek" align='justify'><?=$val["latitude"]?></td>
						<!--<td class="blek" align='justify'><?=$val["nomor_kejadian"]?></td>-->
						<td class="blek" align='justify'><?=$val["judul"]?></td>
						<td class="blek" align='justify'><?=$val["clip"]?></td>
						<td class="blek" align='justify'><?=$val["narasi"]?></td>
						<td class="blek">
							<?=$val["kd_konflik"];?>
						</td>
						<td class="blek" align="left"><?=$val["sektor"]?></td>
						<td class="blek">
							<?php if($val['status_konflik']=='PS'): ?>
								<span>
									<?=$lookup_status_konflik[$val['status_konflik']]?>&nbsp;<?=$lookup_status_konflik_proses[$val['status_konflik_proses']]?>
								</span>
							<?php else: ?>
								<span>
									<?=$lookup_status_konflik[$val['status_konflik']]?>
								</span>
							<?php endif; ?>
						</td>
						<td>
							<?=$lookup_kategori[$val['kategori']?$val['kategori']:""]?>
						</td>
						<td class="blek" align="right"><?php echo str_replace(",",".",$investasi); ?>,<?php echo ($exp_investasi[1])?$exp_investasi[1]:"00"; ?></td>
						<td class="blek" align="right"><?php echo str_replace(",",".",$luas); ?>,<?php echo ($exp_luas[1])?$exp_luas[1]:"00"; ?></td>
						<td class="blek" align="right"><?php echo str_replace(",",".",number_format($val["dampak"]));?></td>
						<td class="blek">
							<span>
								<?=$val['sifat']?>
							</span>
						</td>
						<td class="blek">
							<span>
								<?=$val["created"]?><br/><?=$val["creator"]?>
							</span>
						</td>
					</tr>
				<?php endforeach;?>
						
			<?php endif;?>
		</tbody>
	</table>
</div>