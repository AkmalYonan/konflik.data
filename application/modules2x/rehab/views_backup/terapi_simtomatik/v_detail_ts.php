<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-condensed small-font">
			<thead>
				<tr>
					<th>No</th>
					<th>Pertemuan</th>
					<th>Tanggal Kegiatan</th>
					<th>Jenis Kegiatan</th>
					<th>Keterangan</th>
					<th>Lampiran</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($history as $k=>$v): ?>
				<tr>
					<td align="center"><?=$k?></td>
					<td align="right"><?=$v['pertemuan_ke']?></td>
					<td align="center"><?=($v['tgl_kegiatan'])?date("d-m-Y",strtotime($v['tgl_kegiatan'])):""?></td>
					<td><?=$v['jenis_kegiatan']?></td>
					<td><?=$v['kegiatan']?></td>
					<td>
						<?php if($v['lampiran']): ?>
							<a href="<?=$this->config->item("dir_ts").$v['lampiran']?>" target="_blank">
								<span class="label label-info"><i class="fa fa-download">&nbsp;</i>Unduh Lampiran</span>
							</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>