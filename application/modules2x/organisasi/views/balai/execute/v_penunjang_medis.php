<div class="row">
	<div class="col-sm-6">
		<table class="table table-condensed">
			<?php if(cek_array($penunjang_medis)):?>
				<?php foreach($penunjang_medis as $x=>$val):?>
				<input name="penunjang_medis_kode[]" value="<?=$val['kode']?>" type="hidden" class="form-control">
				<tr>
					<td><?=$val['uraian']?></td>
					<td>
						<input name="penunjang_medis_jumlah[]" value="<?=$val['jumlah']?>" readonly type="number" class="form-control">
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>