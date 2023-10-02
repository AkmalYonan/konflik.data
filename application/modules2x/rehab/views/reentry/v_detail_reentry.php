<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-condensed small-font">
			<tr>
				<td width="200">No. Rekam Medis</td>
				<td><?=$reentry['no_rekam_medis']?></td>
			</tr>
			<tr>
				<td>Tanggal Mulai</td>
				<td><?=($reentry['tgl_kegiatan'])?date("d-m-Y",strtotime($reentry['tgl_kegiatan'])):""?></td>
			</tr>
			<tr>
				<td>Tanggal Selesai</td>
				<td><?=($reentry['tgl_selesai'])?date("d-m-Y",strtotime($reentry['tgl_selesai'])):""?></td>
			</tr>
			<tr>
				<td>Jenis Kegiatan</td>
				<td><?=$reentry['jenis_kegiatan']?></td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td><?=$reentry['kegiatan']?></td>
			</tr>
			<tr>
				<td>Lampiran</td>
				<td>
					<?php if($reentry['lampiran']): ?>
						<a href="<?=$this->config->item("dir_re").$reentry['lampiran']?>" target="_blank">
							<span class="label label-info"><i class="fa fa-download">&nbsp;</i>Unduh Lampiran</span>
						</a>
					<?php endif; ?>
				</td>
			</tr>
		</table>
	</div>
</div>