<div class="row">
	<div class="col-sm-6">	
		<table class="table table-condensed">
			<?php if(cek_array($arrData)):?>
				<?php foreach($arrData as $x=>$val):?>
					<input name="fas_ruang_kode[]"  value="<?=$val['kode']?>" type="hidden" class="form-control" />
					<tr>
						<td><?=$val['uraian']?></td>
						<td>
							<input name="fas_ruang_jumlah[]" value="<?=$val['jumlah']?>" readonly type="number" class="form-control">
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>	
	</div><!--End of col 6-->
	
	<div class="col-sm-6">
		<table class="table table-condensed">
			<?php if(cek_array($arrData2)):?>
				<?php foreach($arrData2 as $x2=>$val2):?>
				<input name="fas_ruang_kode[]" value="<?=$val2['kode']?>" type="hidden" class="form-control" />
				<tr>
					<td><?=$val2['uraian']?></td>
					<td><input name="fas_ruang_jumlah[]" type="number" readonly value="<?=$val2['jumlah']?>" class="form-control"></td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>