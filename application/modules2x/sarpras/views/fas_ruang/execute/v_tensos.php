<div class="row">
	<div class="col-sm-6">
		<table class="table table-condensed">
			<?php if(cek_array($tensos)):?>
				<?php foreach($tensos as $x=>$val):?>
				<input name="tensos_kode[]" value="<?=$val['kode']?>" type="hidden" class="form-control">
				<tr>
					<td><?=$val['uraian']?></td>
					<td>
						<input name="tensos_jumlah[]" value="<?=$val['jumlah']?>" type="number" class="form-control">
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>