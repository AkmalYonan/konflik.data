<div class="row">
	<div class="col-md-12">
    	<table class="table table-condensed table-bordered">
            <tr>
            	<td width="200px">Tanggal Evaluasi</td>
                <td>
					<?php
						if($datax['tgl_evaluasi']):
							echo date_format(date_create($datax['tgl_evaluasi']),"d-m-Y");
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
                <td><?=$datax['keterangan']?></td>
            </tr>
			<tr>
				<td>Nama PJ/Keluarga</td>
				<td><?=$datax['nama_pj_keluarga']?></td>
			</tr>
			<tr>
				<td>No. Telepon PJ/Keluarga</td>
				<td><?=$datax['no_telp_pj_keluarga']?></td>
			</tr>
			<tr>
				<td>Alamat PJ Keluarga</td>
				<td><?=$datax['alamat_pj_keluarga']?></td>
			</tr>
			<tr>
				<td>Hasil Evaluasi</td>
				<td>
					<?php
						if($datax['hasil_evaluasi']==1):
							echo "<span class='label label-success'><i class='fa fa-plus'></i></span>";
						elseif($datax['hasil_evaluasi']==2):
							echo "<span class='label label-danger'><i class='fa fa-minus'></i></span>";
						endif;
					?>
				</td>
			</tr>
			<tr>
				<td>Nama Petugas Evaluasi</td>
				<td><?=$datax['nama_petugas_evaluasi']?></td>
			</tr>
            <tr>
            	<td>Lampiran</td>
                <td>
					<?php if($datax['lampiran']): ?>
						<a href="<?=$this->config->item("dir_evaluasi").$datax['lampiran']?>" target="_blank">
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