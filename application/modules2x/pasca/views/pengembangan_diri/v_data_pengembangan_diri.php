<div class="row">
	<div class="col-md-12">
    	<table class="table table-condensed table-bordered">
            <tr>
            	<td width="200px">Pertemuan Ke</td>
                <td><?=$data_proses["idx_pertemuan"]?></td>
            </tr>
			<tr>
				<td>Keterangan</td>
				<td><?=$data_proses["keterangan"]?></td>
			</tr>
            <tr>
            	<td>Lampiran</td>
                <td>
					<?php if($data_proses['file']): ?>
						<a href="<?=$this->config->item("dir_pengembangan_diri").$data_proses['file']?>" target="_blank">
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