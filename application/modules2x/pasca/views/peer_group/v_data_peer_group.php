<div class="row">
	<div class="col-md-12">
    	<table class="table table-condensed table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Pertemuan Ke</th>
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
					<td align="right"><?=$v['idx_pertemuan']?></td>
					<td><?=($v['tgl_pertemuan'])?date("d-m-Y",strtotime($v['tgl_pertemuan'])):""?></td>
					<td><?=$this->lookjns_kgt[$v['idx_jenis_kegiatan']]?></td>
					<td><?=$v['keterangan']?></td>
					<td>
						<?php if($v['lampiran']): ?>
							<a href="<?=$this->config->item("dir_peer_group")?><?=$v['lampiran']?>" target="_blank">
								<span class="label label-info"><i class="fa fa-file">&nbsp;</i>Lampiran</span>	
							</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
        </table>
    </div>
</div>