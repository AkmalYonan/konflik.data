<table class="table table-bordered">
	<tr>
    	<td width="50%">Nama : <?=$data["nama"]?></td>
        <td>Nomor Rekam Medis: <?=$data["no_rekam_medis"]?></td>
    </tr>
    <tr>
    	<td colspan="2">Alamat : <?=nl2br($data["alamat"])?></td>
    </tr>
    <tr>
    	<td>Jenis Kelamin : <?=$data["jenis_kelamin"]?></td>
        <td>Pekerjaan: <?=$data["pekerjaan"]?></td>
    </tr>
    <tr>
    	<td>Status Marital : <?=$data["status_nikah"]?></td>
        <td>Riwayat Rehabilitasi: </td>
    </tr>
    <tr>
    	<td>Agama : <?=$data["agama"]?></td>
        <td>Dikirim Oleh: <?=$data["pekerjaan"]?></td>
    </tr>
    
    
</table>