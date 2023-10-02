<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-condensed small-font">
			<thead>
				<tr>
					<th>No</th>
					<th>Pertemuan</th>
					<th>Tanggal Kegiatan</th>
					<th>Kegiatan</th>
					<th>Hasil Konseling</th>
					<th>Lampiran</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($history as $k=>$v): ?>
				<tr>
					<td align="center"><?=$k?></td>
					<td align="right"><?=$v['pertemuan_ke']?></td>
					<td align="center"><?=($v['tgl_kegiatan'])?date("d-m-Y",strtotime($v['tgl_kegiatan'])):""?></td>
					<td><?=$v['kegiatan']?></td>
					<td align="center">
						<?php if($v['hasil_tes']==1): ?>
							<span class="label label-success"><i class="fa fa-plus"></i></span>
						<?php elseif($v['hasil_tes']==2): ?>
							<span class="label label-danger"><i class="fa fa-minus"></i></span>
						<?php endif; ?>
					</td>
					<td>
						<?php if($v['lampiran']): ?>
							<a href="<?=$this->config->item("dir_kl").$v['lampiran']?>" target="_blank">
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