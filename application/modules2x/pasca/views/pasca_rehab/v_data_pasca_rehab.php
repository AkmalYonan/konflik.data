<div class="row">
	<div class="col-md-12">
    	<table class="table table-bordered table-condensed small-font">
			<tr>
				<td width="200">No. Rekam Medis</td>
				<td><?=$data_proses['no_rekam_medis']?></td>
			</tr>
			<tr>
				<td>Resume Rehabilitasi</td>
				<td><?=$data_proses['resume_rehab']?></td>
			</tr>
			<tr>
				<td>Hasil Assesment</td>
				<td>
                                    <?php if(cek_array($arr_hsl)): ?>
					<?php $arr_hsl	=	explode(",",$data_proses['hasil_assesment']); ?>
					<?php foreach($arr_hsl as $k=>$v):?> 
					<?=$k+1 .". ".$this->hsl_asses[$v];?> <br/>
					<?php endforeach;?>
                                    <?php endif; ?>    
				</td>
			</tr>
			<tr>
				<td>Tinjauan Rencana Terapi</td>
				<td>
					<?php
						if($data_proses["tinjauan_rencana_terapi"]==1){
							echo "<span class='label label-success'>Sesuai</span>";
						}elseif($data_proses["tinjauan_rencana_terapi"]==2){
							echo "<span class='label label-danger'>Tidak Sesuai</span>";
						}elseif($data_proses["tinjauan_rencana_terapi"]==3){
							echo "<span class='label label-warning'>Sedang Berlangsung</span>";
						};
					?>
				</td>
			</tr>
			<tr>
				<td>Tanggal Penerimaan Pasca Rehabilitasi</td>
				<td>
                                    <?php if($data_proses['tgl_penerimaan_pascarehab']): ?>
                                       <?=date("d-m-Y",strtotime($data_proses['tgl_penerimaan_pascarehab']));?>
                                    <?php endif; ?>
                                </td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td><?=$data_proses['keterangan']?></td>
			</tr>
			<tr>
				<td>Lampiran</td>
				<td>
					<?php if($data_proses['lampiran']): ?>
						<a href="<?=$this->config->item("dir_penerimaan_pasca").$data_proses['lampiran']?>" target="_blank">
							<span class="label label-info"><i class="fa fa-download">&nbsp;</i>Unduh Lampiran</span>
						</a>
					<?php endif; ?>
				</td>
			</tr>
        </table>
    </div>
</div>