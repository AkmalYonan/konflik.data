<div class="row">
	<div class="col-md-12">
    	<table class="table table-condensed table-bordered">
			<thead>
				<tr>
					<th width='20'>No</th>
					<th width='100'>Kegiatan Ke</th>
					<th width='200'>Tanggal Pertemuan Kelompok</th>
					<th width='50'>Hasil</th>
					<th>Keterangan</th>
					<th width='100'>Lampiran</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($history as $k=>$v): ?>
				<tr>
					<td align="center"><?=$k?></td>
					<td align="right"><?=$v['id_hm']?></td>
					<td align="center"><?=($v['tgl_hm'])?date("d-m-Y",strtotime($v['tgl_hm'])):""?></td>
					<td align="center">
						<?php if($v['hsl_hm']==1): ?>
							<span class="label label-success"><i class="fa fa-plus"></i></span>
						<?php elseif($v['hsl_hm']==2): ?>
							<span class="label label-danger"><i class="fa fa-minus"></i></span>
						<?php endif; ?>
					</td>
					<td><?=$v['keterangan']?></td>
					<td>
						<?php if($v['lampiran']): ?>
							<a href="<?=$this->config->item("dir_pk").$v['lampiran']?>" target="_blank">
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