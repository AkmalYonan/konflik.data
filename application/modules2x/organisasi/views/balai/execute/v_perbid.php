<div class="row">
	<div class="col-sm-6">
		<table class="table table-condensed">
			<?php if(cek_array($perbid)):?>
				<?php foreach($perbid as $x=>$val):?>
				<input name="perbid_kode[]" value="<?=$val['kode']?>" type="hidden" class="form-control">
				<tr>
					<td><?=$val['uraian']?></td>
					<td>
						<input name="perbid_jumlah[]" value="<?=$val['jumlah']?>" readonly type="number" class="form-control">
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>