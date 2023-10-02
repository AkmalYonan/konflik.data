<tr>
	<th>No</th>
	<th><center>NIP / Nama</center></th>
	<th><center>Provinsi, Kabupaten</center></th>
	<!-- ADMIN -->
	<?php if(($level_user == 'op1')){?>
	<th width="100"><center>Verifikasi PUM</center></th>
	<th width="100"><center>Verifikasi KUMHAM</center></th>
	<th width="100"><center>Lulus Diklat</center></th>
	<th width="100"><center>Rekomendasi POLRI</center></th>
	<th width="100"><center>Rekomendasi KEJAGUNG</center></th>
	<th width="120"><center>SKEP/KTP Dari KUMHAM</center></th>
	<th width="100"><center>Pelantikan</center></th>
	<?php } if($level_user == 'op2'){?> <!-- KUMHAM -->
	<th width="100"><center>Verifikasi KUMHAM</center></th>
	<?php } if($level_user == 'op3'){?> <!-- Lulus Diklat -->
	<th width="100"><center>Lulus Diklat</center></th>
	<?php } if($level_user == 'op4'){?> <!-- POLRI  -->
	<th width="100"><center>Rekomendasi POLRI</center></th>
	<?php } if($level_user == 'op5'){?> <!-- KEJAGUNG -->
	<th width="100"><center>Rekomendasi KEJAGUNG</center></th>
	<?php } if($level_user == 'op6'){?> <!-- SKEP -->
	<th width="120"><center>SKEP/KTP Dari KUMHAM</center></th>
	<th width="100"><center>Pelantikan</center></th>
	<?php } if($level_user == 'op7'){?> <!-- PELANTIKAN -->
	<th width="100"><center>Pelantikan</center></th>
	<?php } ?>
</tr>