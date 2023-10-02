<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-condensed small-font">
			<tr>
				<td width="200">No. Rekam Medis</td>
				<td><?=$data_detox['no_rekam_medis']?></td>
			</tr>
			<tr>
				<td>Tanggal Mulai</td>
				<td><?=($data_detox['tgl_mulai'])?date("d-m-Y",strtotime($data_detox['tgl_mulai'])):""?></td>
			</tr>
			<tr>
				<td>Tanggal Selesai</td>
				<td><?=($data_detox['tgl_selesai'])?date("d-m-Y",strtotime($data_detox['tgl_selesai'])):""?></td>
			</tr>
			<tr>
				<td>Jenis Kegiatan</td>
				<td><?=$data_detox['jenis_kegiatan']?></td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td><?=$data_detox['keterangan']?></td>
			</tr>
			<tr>
				<td>Lampiran</td>
				<td>				
					<?php if($data_detox['lampiran']): ?>
						<a href="<?=$this->config->item("dir_detok").$data_detox['lampiran']?>" target="_blank">
							<span class="label label-info"><i class="fa fa-download">&nbsp;</i>Unduh Lampiran</span>
						</a>
					<?php else: ?>
						-
					<?php endif; ?>				
				</td>
			</tr>
		</table>
	</div>
</div>