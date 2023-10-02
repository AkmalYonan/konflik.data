<div class="row">
	<div class="col-md-12">
    	<table class="table table-condensed table-bordered">
            <tr>
            	<td width="200px">Pertemuan Ke - 1</td>
                <td>
					<?php
						if($datax['tgl_pertemuan_1']):
							echo date_format(date_create($datax['tgl_pertemuan_1']),"d-m-Y");
						else:
							echo "-";
						endif;
					?>
				</td>
            </tr>
			<tr>
            	<td width="200px">Pertemuan Ke - 2</td>
                <td>
					<?php
						if($datax['tgl_pertemuan_2']):
							echo date_format(date_create($datax['tgl_pertemuan_2']),"d-m-Y");
						else:
							echo "-";
						endif;
					?>
				</td>
            </tr>
			<tr>
            	<td width="200px">Pertemuan Ke - 3</td>
                <td>
					<?php
						if($datax['tgl_pertemuan_3']):
							echo date_format(date_create($datax['tgl_pertemuan_3']),"d-m-Y");
						else:
							echo "-";
						endif;
					?>
				</td>
            </tr>
			<tr>
            	<td width="200px">Pertemuan Ke - 4</td>
                <td>
					<?php
						if($datax['tgl_pertemuan_4']):
							echo date_format(date_create($datax['tgl_pertemuan_4']),"d-m-Y");
						else:
							echo "-";
						endif;
					?>
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
					<?php if($datax['file']): ?>
						<a href="<?=$this->config->item("dir_peer_group").$datax['file']?>" target="_blank">
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