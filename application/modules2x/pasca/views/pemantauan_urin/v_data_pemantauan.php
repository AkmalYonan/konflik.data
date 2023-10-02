<div class="row">
	<div class="col-md-12">
		<table class="table table-condensed table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Pertemuan Ke</th>
					<th>Tanggal Kegiatan</th>
					<th>Hasil Tes</th>
					<th>Keterangan</th>
					<th>Lampiran</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($history as $k=>$v): ?>
				<tr>
					<td align="center"><?=$k?></td>
					<td align="right"><?=$v['idx_tes']?></td>
					<td align="center"><?=($v['tgl_tes'])?date("d-m-Y",strtotime($v['tgl_tes'])):""?></td>
					<td align="center">
						<?php if($v['hasil_tes']==1): ?>
							<span class="label label-danger"><i class="fa fa-plus"></i></span>
						<?php elseif($v['hasil_tes']==2): ?>
							<span class="label label-success"><i class="fa fa-minus"></i></span>
						<?php endif; ?>
					</td>
					<td><?=$v['keterangan']?></td>
					<td>
						<?php if($v['lampiran']): ?>
							<a href="<?=$this->config->item("dir_pemantauan_urin").$v['lampiran']?>" target="_blank">
								<span class='label label-info'><i class="fa fa-file">&nbsp;</i>Lampiran</span>
							</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
        </table>
		<div class="well well-sm">
			***) Keterangan:<br />
			<span class="label label-danger"><i class="fa fa-plus"></i></span> Menunjukkan Hasil Tidak Baik<br />
			<span class="label label-success"><i class="fa fa-minus"></i></span> Menunjukkan Hasil Baik
		</div>
    </div>
</div>