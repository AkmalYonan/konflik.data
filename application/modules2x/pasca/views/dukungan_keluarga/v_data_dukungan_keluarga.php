<div class="row">
	<div class="col-md-12">
    	<table class="table table-condensed table-bordered">
            <tr>
            	<td width="200px">Tanggal Kegiatan</td>
                <td>
					<?php
						if($datax['tgl_kegiatan']):
							echo date_format(date_create($datax['tgl_kegiatan']),"d-m-Y");
						else:
							echo "-";
						endif;
					?>
				</td>
            </tr>
			<tr>
            	<td width="200px">Keluarga Terlibat</td>
                <td>
					<?=$datax['keluarga_terlibat']?>
				</td>
            </tr>
            <tr>
            	<td>Jenis Kegiatan</td>
                <td><?=$datax['jenis_kegiatan']?></td>
            </tr>
            <tr>
            	<td>Keterangan</td>
                <td> <?=$datax['keterangan']?></td>
            </tr>
            <tr>
            	<td>Lampiran</td>
                <td>
					<?php if($datax['lampiran']): ?>
						<a href="<?=$this->config->item("dir_dukungan_keluarga").$datax['lampiran']?>" target="_blank">
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