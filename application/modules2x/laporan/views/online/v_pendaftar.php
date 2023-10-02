		<table class="table table-condensed table-bordered">
        	<tr>
            	<td width="100px">Nama</td>
                <td><?=$pendaftar["nama"]?></td>
            </tr>
            <tr>
            	<td>Alamat</td>
                <td><?=nl2br($pendaftar["alamat"])?></td>
            </tr>
            <tr>
            	<td>Identitas</td>
                <td><?=$pendaftar["jenis_identitas"]?>: <?=$pendaftar["no_identitas"]?></td>
            </tr>
            <tr>
            	<td>Email</td>
                <td><?=$pendaftar["email"]?></td>
            </tr>
            
        </table>