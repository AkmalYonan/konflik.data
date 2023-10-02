<div class="row">
	<div class="col-sm-8">
		<table class="table table-condensed">
		<?php if(cek_array($peralatan)):?>
			<?php foreach($peralatan as $x=>$val):?>
			<input name="peralatan_kode[]" value="<?=$val['kode']?>" type="hidden" class="form-control">
			<tr>
				<td><?=$val['uraian']?></td>
				<td>
					<select name="peralatan_status1[]" class="form-control">
						<option value=""></option>
						<option <?=($val['status1']=='Ada')?'selected':''?> value="Ada">Ada</option>
						<option <?=($val['status1']=='Tidak Ada')?'selected':''?> value="Tidak Ada">Tidak Ada</option>
					</select>
				</td>
				<td>
					<select name="peralatan_status2[]" class="form-control">
						<option value=""></option>
						<option <?=($val['status2']=='Berfungsi')?'selected':''?> value="Berfungsi">Berfungsi</option>
						<option <?=($val['status2']=='Tidak Berfungsi')?'selected':''?> value="Tidak Berfungsi">Tidak Berfungsi</option>
					</select>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>