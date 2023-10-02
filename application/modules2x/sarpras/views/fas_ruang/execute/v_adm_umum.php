<div class="row">
	<div class="col-sm-6">
		<table class="table table-condensed">
			<?php if(cek_array($adm_umum)):?>
				<?php foreach($adm_umum as $x=>$val):?>
				<input name="adm_umum_kode[]" value="<?=$val['kode']?>" type="hidden" class="form-control">
				<tr>
					<td><?=$val['uraian']?></td>
					<td>
						<input name="adm_umum_jumlah[]" value="<?=$val['jumlah']?>" type="number" class="form-control">
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>