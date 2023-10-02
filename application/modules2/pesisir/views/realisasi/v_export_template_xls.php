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
	$arr_tahapan	=	lookup("m_tahapan","kode","uraian",""," order by idx");
	// pre($arr_tahapan);
	

?>
<table>
	<tr>
		<td align="center" colspan="9"><b>Daftar Realisasi Wilayah Kelola</b></td>
	</tr>
</table>
<br />

<div class="box-body table-responsive">
	<table class="blek" border="1">
		<thead >
	
			<tr >
				<td align="center" class="ret blek" width="20px"><b>No.</b></td>
				<td align="center" class="ret blek"><b>Tanggal Input</b></td>
				<td align="center" class="ret blek"><b>Nama Wilayah</b></td>
				<td align="center" class="ret blek"><b>Provinsi</b></td>
				<td align="center" class="ret blek"><b>Kabupaten</b></td>
				<td align="center" class="ret blek"><b>Luas</b></td>
				<td align="center" class="ret blek"><b>Profil</b></td>
				<td align="center" class="ret blek"><b>Jenis Wilayah Kelola</b></td>
				<td align="center" class="ret blek"><b>Tahapan</b></td>
				<td align="center" class="ret blek"><b>Status Peta</b></td>
				<td align="center" class="ret blek"><b>Entry</b></td>
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
						<td align="center"><?php echo $offset+$x+1?></td>
						<td><?=date_format(date_create($val['tgl_kejadian']),"d-m-Y")?></td>
						<td>
							<?=$val["nama_wikera"]?>
						</td>
						<td align="justify"><?=$val['nm_propinsi']?></td>
						<td align="justify"><?=$val['nm_kabupaten']?></td>
						<td align="justify"><?=$val["luas"]?> Ha</td>
						<td align="justify"><?=$val["clip"]?></td>
						<td>
							<?=$this->lookup_map_group[$val["kode_jns_wikera"]]?>
							<?php if($val["kode_jns_wikera"]=="PIAPS"): ?>
								<br /><span class="text-muted"><?=$this->lookup_kategori_perhutanan[$val['kategori_perhutanan']]?></span>
							<?php endif; ?>
						</td>
						<td><?=$arr_tahapan[$val["kode_tahapan"]]?></td>
						<td>	
							<?php if($val['status_validas_peta']==1): ?>
								Valid
							<?php elseif($val['status_validas_peta']==2): ?>
								Tidak/Belum Valid
							<?php endif; ?>
						</td>
						<td align='justify'><?=$val["created"]?><br/><?=$val["creator"]?></td>
					</tr>
				<?php endforeach;?>
						
			<?php endif;?>
		</tbody>
	</table>
</div>