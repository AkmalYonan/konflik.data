<?php 
	$lookup_bnnp=lookup("m_org","kd_org","nama","tipe_org='BNNP'","order by idx");
	$lookup_status[0]="Baru"; //menunggu verifikasi
	$lookup_status[1]="Verifikasi"; //menunggu hasil verifikasi
	$lookup_status[2]="Terdaftar"; //menunggu rekam medik
	$lookup_status[9]="DiTolak";  
	
	
	
?>
<table class="table table-condensed table-bordered">
        	<tr>
            	<td>Jenis Daftar</td>
                <td>Online</td>
            </tr>
            <tr>
            	<td>Tanggal Pengajuan</td>
                <td><?=date2indo($pasien["created"])?></td>
            </tr>
            <tr>
            	<td width="150px">BNNP Tujuan</td>
                <td><?=$lookup_bnnp[$pasien["kd_bnn"]]?></td>
            </tr>
            <tr>
            	<td>Status</td>
                <td><?=$lookup_status[$pasien["status"]]?></td>
            </tr>
            <tr>
            	<td>Konfirmasi Pasien</td>
                <td><?=$pasien["flag_konfirmasi"]?"Sudah":"Belum"?></td>
            </tr>
			<tr>
            	<td>Tanggal Konfirmasi</td>
                <td><?=$pasien["flag_konfirmasi"]?date2indo($pasien["tgl_konfirmasi"]):"-"?></td>
            </tr>
            <tr>
            	<td>Jadwal Rekam Medis</td>
                <td><?=$pasien["flag_konfirmasi"]?date2indo($pasien["jadwal_rekam_medis"]):"-"?></td>
            </tr>
            <tr>
            	<td>RM</td>
                <td><?=$pasien["flag_rekam_medis"]?"Sudah":"Belum"?></td>
            </tr>
            <tr>
            	<td>Tgl RM</td>
                <td><?=$pasien["flag_rekam_medis"]?date2indo($pasien["tgl_rekam_medis"]):"-"?></td>
            </tr>

            
            
        </table>