<div class="row">
	<div class="col-md-12">
    	<table class="table table-condensed table-bordered">
            <tr>
            	<td width="200px">No. Rekam Medis</td>
                <td><?=$data_proses['no_rekam_medis']?></td>
            </tr>
			<tr>
            	<td>Tanggal Mulai</td>
                <td><?=($data_proses['tgl_mulai'])?date("d-m-Y",strtotime($data_proses['tgl_mulai'])):"-"?></td>
            </tr>
			<tr>
            	<td>Tanggal Selesai</td>
                <td><?=($data_proses['tgl_selesai'])?date("d-m-Y",strtotime($data_proses['tgl_selesai'])):"-"?></td>
            </tr>
			<tr>
				<td>Jenis Kegiatan</td>
				<td><?=$this->lookjns_kgt[$data_proses["jenis_kegiatan"]]?></td>
			</tr>
			<tr>
            	<td>Keterangan</td>
                <td><?=$data_proses['keterangan']?></td>
            </tr>
            <tr>
            	<td>Lampiran</td>
                <td>
					<?php if($data_proses['lampiran']): ?>
						<a href="<?=$this->config->item("dir_da").$data_proses['lampiran']?>" target="_blank">
							<span class="label label-info"><i class="fa fa-file">&nbsp;</i>Lampiran</span>
						</a>
					<?php else: ?>
						-
					<?php endif; ?>
				</td>
            </tr>
        </table>
    </div>
</div>