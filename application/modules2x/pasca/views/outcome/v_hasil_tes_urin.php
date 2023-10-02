<div class="row">
	<div class="col-sm-12">
		<table class="table table-condensed table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Periode</th>
					<th>Tanggal Tes Urin</th>
					<th>Hasil Tes Urin</th>
					<th>Petugas Tes Urin</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($tes_urin as $k=>$v): ?>
				<tr>
					<td align="center"><?=$k+1?></td>
					<td>Pertemuan Ke-<?=$v['idx_tes']?></td>
					<td><?=date("d-m-Y",strtotime($v['tgl_tes']))?></td>
					<td align="center">
					<?php
						if($v['hasil_tes']==1):
							echo "<span class='label label-danger'><i class='fa fa-plus'></i></span>";
						elseif($v['hasil_tes']==2):
							echo "<span class='label label-success'><i class='fa fa-minus'></i></span>";
						endif;	
					?>
					</td>
					<td><?=$v['nama_petugas_tes']?></td>
					<td><?=$v['keterangan']?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="well well-sm">
			***) Keterangan:<br />
			<span class='label label-danger'><i class='fa fa-plus'></i></span> Menunjukkan Hasil Tidak Baik<br />
			<span class='label label-success'><i class='fa fa-minus'></i></span> Menunjukkan Hasil Baik			
		</div>
	</div>
</div>