<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-condensed small-font">
			<tr>
				<td width="200">Tanggal Konseling</td>
				<td><?=($data_konseling['tgl_konseling'])?date("d-m-Y",strtotime($data_konseling['tgl_konseling'])):"-"?></td>
			</tr>
			<tr>
				<td>Hasil Konseling</td>
				<td>
				<?php if($data_konseling['hasil_konseling']==1): ?>
					<span class="label label-success"><i class="fa fa-plus"></i></span>
				<?php elseif($data_konseling['hasil_konseling']==2): ?>
					<span class="label label-danger"><i class="fa fa-minus"></i></span>
				<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td><?=$data_konseling['keterangan']?></td>
			</tr>
			<tr>
				<td>Lampiran</td>
				<td>				
					<?php if($data_konseling['lampiran']): ?>
						<a href="<?=$this->config->item("dir_pasca_konseling").$data_konseling['lampiran']?>" target="_blank">
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