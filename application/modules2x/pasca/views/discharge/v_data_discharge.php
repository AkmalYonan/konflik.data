<div class="row">
	<div class="col-md-12">
    	<table class="table table-condensed table-bordered">
            <tr>
            	<td width="200px">No. Rekam Medis</td>
                <td><?=$data_proses['no_rekam_medis']?></td>
            </tr>
			<tr>
				<td>Tanggal Rujukan</td>
				<td><?=($data_proses['tgl_rujukan'])?date("d-m-Y",strtotime($data_proses['tgl_rujukan'])):"-"?></td>
			</tr>
			<tr>
				<td>Jenis Rujukan</td>
				<td><?=$this->data_lookup["jenis_discharge"][$data_proses['jns_rujukan']]?></td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td><?=$data_proses['keterangan']?></td>
			</tr>
            <tr>
            	<td>Lampiran</td>
                <td>
					<?php if($data_proses['lampiran']): ?>
						<a href="<?=$this->config->item("dir_discharge").$data_proses['lampiran']?>" target="_blank">
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