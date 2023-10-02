<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-condensed small-font">
			<tr>
				<td width="200">Tanggal Kedatangan</td>
				<td><?=date("d-m-Y",strtotime($data_asm['tgl_kedatangan']))?></td>
			</tr>
			<tr>
				<td>No Rekam Medis</td>
				<td><?=$data_asm['no_rekam_medis']?></td>
			</tr>
			<tr>
				<td>Masalah Yang Dihadapi</td>
				<td>
					<table class="table table-bordered table-condensed small-font">
						<thead>
							<tr>
								<th rowspan="2">No</th>
								<th rowspan="2">Masalah</th>
								<th colspan="9">Nilai</th>
							</tr>
							<tr>
								<?php for($i=0; $i<9; $i++): ?>
								<th class="tmiddle"><?=$i+1?></th>
								<?php endfor; ?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="center">1</td>
								<td>Medis</td>
								<?php for($i=0; $i<9; $i++): ?>
								<?php if($data_asm['masalah_medis']==($i+1)): ?>
								<td align="center"><i class="fa fa-check green"></i></td>
								<?php else: ?>
								<td></td>
								<?php endif; ?>
								<?php endfor; ?>
							</tr>
							<tr>
								<td align="center">2</td>
								<td>Pekerjaan/Dukungan</td>
								<?php for($i=0; $i<9; $i++): ?>
								<?php if($data_asm['masalah_pekerjaan']==($i+1)): ?>
								<td align="center"><i class="fa fa-check green"></i></td>
								<?php else: ?>
								<td></td>
								<?php endif; ?>
								<?php endfor; ?>
							</tr>
							<tr>
								<td align="center">3</td>
								<td>Napza</td>
								<?php for($i=0; $i<9; $i++): ?>
								<?php if($data_asm['masalah_napza']==($i+1)): ?>
								<td align="center"><i class="fa fa-check green"></i></td>
								<?php else: ?>
								<td></td>
								<?php endif; ?>
								<?php endfor; ?>
							</tr>
							<tr>
								<td align="center">4</td>
								<td>Legal</td>
								<?php for($i=0; $i<9; $i++): ?>
								<?php if($data_asm['masalah_legal']==($i+1)): ?>
								<td align="center"><i class="fa fa-check green"></i></td>
								<?php else: ?>
								<td></td>
								<?php endif; ?>
								<?php endfor; ?>
							</tr>
							<tr>
								<td align="center">5</td>
								<td>Keluarga/Sosial</td>
								<?php for($i=0; $i<9; $i++): ?>
								<?php if($data_asm['masalah_keluarga']==($i+1)): ?>
								<td align="center"><i class="fa fa-check green"></i></td>
								<?php else: ?>
								<td></td>
								<?php endif; ?>
								<?php endfor; ?>
							</tr>
							<tr>
								<td align="center">6</td>
								<td>Psikiatris</td>
								<?php for($i=0; $i<9; $i++): ?>
								<?php if($data_asm['masalah_psikiatris']==($i+1)): ?>
								<td align="center"><i class="fa fa-check green"></i></td>
								<?php else: ?>
								<td></td>
								<?php endif; ?>
								<?php endfor; ?>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>Diagnosis Napza</td>
				<td>Klien Memenuhi Kriteria Diagnosis Napza <font color="#0033FF"><strong><?=$data_asm['diagnosis_napza']?></strong></font></td>
			</tr>
			<tr>
				<td>Diagnosis Lain</td>
				<td><?=$data_asm['diagnosis_lain']?></td>
			</tr>
			<tr>
				<td>Rencana Terapi</td>
				<td><?=$data_asm['rencana_terapi']?></td>
			</tr>
			<tr>
				<td>Keterangan Rencana Terapi</td>
				<td><?=$data_asm['rencana_terapi_ket']?></td>
			</tr>
		</table>
	</div>
</div>