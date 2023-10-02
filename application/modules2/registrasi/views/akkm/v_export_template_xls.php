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
		<td colspan="5"><b>Daftar Data Akkm</b></td>
	</tr>
	<tr>
		<td>Tahun : <?=$header['tahun']?> </td>
	</tr>
</table>
<br />

<div class="box-body table-responsive">
	<table class="blek" border="1">
		<thead>
	
				<tr>
					<th rowspan='2' style="vertical-align: middle;" width="20px"><center>No.</th>
					<th rowspan='2' style="vertical-align: middle;" width="70px"><center>ID</th>
					<th colspan='4' style="vertical-align: middle;"><center>Data Akkm</center></th>
					<th rowspan='2' style="vertical-align: middle;"><center>Status</center></th>
					<th rowspan='2' style="vertical-align: middle;" width="320px"><center>Deskripsi</center></th>
					<th rowspan='2' style="vertical-align: middle;"  width="110px"><center>Entry</center></th>
				</tr>
				<tr>
					<th rowspan='1' style="vertical-align: middle;" width="180"><center>Nama</center></th>
					<th rowspan='1' style="vertical-align: middle;"><center>Pengampu</center></th>
					<th rowspan='1' style="vertical-align: middle;"><center>Luas</center></th>
					<th rowspan='1' style="vertical-align: middle;"><center>Ekosistem</center></th>
				</tr>
					
		</thead>
		
		<tbody >
			<?php if(cek_array($data)):?>
				<?php foreach($data as $x=>$val):
					$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
				?>
					<tr>
						<td><?php echo $offset+$x+1?>.</td>
						<td align='justify'><center><?=$val["ID"]?></center></td>
						<td align='justify'><center><?=$val["nama_akkm"]?>
						<br />
							<span class="text-muted"><em><?=$val['nm_propinsi']?></em>&nbsp;</span><br />
							<span class="text-muted"><em><?=$val['nm_kabupaten']?></em>&nbsp;</span>
						</center>	
						</td>
						<td align='justify'><center><?=$val["pengampu"]?></center></td>
						<td align='justify'><center><?=$val["luas"]?></center></td>
						<td align='justify'><center><?=$val["ekosistem"]?></center></td>
						<td align='justify'>
						<center>
							<span class="label label-primary">
								<?=$val['status_akkm']?>
							</span>
						</center>
						</td>
						<td align='justify'><center><?
						if(strlen($val['deskripsi'])>200):
							print substr($val["deskripsi"],0,200)."....";
						else:
							print ($val["deskripsi"]);
						endif;
						?> </center>
						</td>
						<td align='justify'><center><?=$val["created"]?><br/><?=$val["creator"]?></center></td>
						</tr>
				<?php endforeach;?>
						
			<?php endif;?>
		</tbody>
	</table>
</div>