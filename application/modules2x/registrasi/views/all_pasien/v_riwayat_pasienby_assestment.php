<?php
	$lookup_empty[""]="--Pilih--";
?>
<h4 class="heading">RIWAYAT ASSESTMENT PASIEN </h4>
 <div class="row">
    <div class="col-md-12">
		
		<? if(cek_array($assestment)):?>
		<? foreach($assestment as $x=>$val):?>
       
		
			<table class="table table-bordered table-condensed small-font">
			<tr>
				<th colspan="2">Assestment ke <?=$x+1?></th>
			</tr>
			
			<tr>
				<td width="200">Tanggal Kedatangan</td>
				<td><?=date("d-m-Y",strtotime($val['tgl_kedatangan']))?></td>
			</tr>
			<tr class="hidden">
				<td >Masalah Yang Dihadapi</td>
				<td colspan="3">
					<table class="table table-bordered table-condensed small-font hidden">
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
								<?php if($val['masalah_medis']==($i+1)): ?>
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
								<?php if($val['masalah_pekerjaan']==($i+1)): ?>
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
								<?php if($val['masalah_napza']==($i+1)): ?>
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
								<?php if($val['masalah_legal']==($i+1)): ?>
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
								<?php if($val['masalah_keluarga']==($i+1)): ?>
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
								<?php if($val['masalah_psikiatris']==($i+1)): ?>
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
				<td >Diagnosis Napza</td>
				<td colspan="3">Klien Memenuhi Kriteria Diagnosis Napza <font color="#0033FF"><strong><?=$val['diagnosis_napza']?></strong></font></td>
			</tr>
			<tr>
				<td >Status Program</td>
				<td colspan="3"><font color="#0033FF"><strong><?=$val['status_program']?></strong></font></td>
			</tr>
			<tr>
				<td >Outcome Pasien</td>
				<td colspan="3"><font color="#0033FF"><strong><?=$val['outcome_pasien']?></strong></font></td>
			</tr>
			<tr>
				<td colspan="4"><a id="btn<?=$x?>" class="btn btn-xs btn-default" href="javascript: void(0)" data-toggle='tooltip' title="View"><i class="fa fa-search blue"></i> | Detail</a>
				</td>
			
			</tr>
			<tr>
				<td colspan="4">
				<div style="display:none;" id="butt<?=$x?>">
							
				
					<!--<?// pre($val['monitoring_rehab']);?>-->
				</div>
				</td>
				
			</tr>
			
		</table>
		<? endforeach;?>
        <? endif;?>
		
	
	
	</div><!-- end col-->

   
 
</div><!-- end row-->
<script>

$(document).ready(function(){
    <? foreach($assestment as $key=>$valz){?>
	$("#btn<?=$key?>").click(function(){
        $("#butt<?=$key?>").slideToggle('slow');
    });
	<? } ?>
});

</script>

<table class="table table-bordered table-condensed table-foto hidden">
    	<thead>
        	<tr>
            	<th>#</th>
                <th>#</th>
                <th>#</th>
                <th>#</th>
                
            </tr>
        </thead>
        <tbody>
        <tr>
        	<td><a class="btn btn-xs btn-default" href="<?=$this->module?>view/<?=$id?>" data-toggle='tooltip' title="View"><i class="fa fa-search blue"></i></a>
			<button id="btn<?=$x?>">Toggle slideUp()</button>
			</td>
			
        	<td></td>
        	<td class="tc"><input type="radio" name="flag_default" data-id="<?=$val["idx"]?>" class="flag_default" id="flag_default_<?=$val["idx"]?>" value="1" <?=$val["flag_default"]==1?"checked='checked'":""?> /></td>
            <td class="tc"> <a class="btn btn-xs btn-delete-foto" data-toggle='tooltip' data-id="<?=$val["idx"]?>" href="javascript:void()" title="Hapus Foto"><i class="fa fa-remove red"></i></a>
            </td>
        </tr>
		<tr>
			<td colspan="4"><p style="display:none;" id="butt<?=$x?>">
			</p></td>
        	
		</tr>
		
		</tbody>
    </table>