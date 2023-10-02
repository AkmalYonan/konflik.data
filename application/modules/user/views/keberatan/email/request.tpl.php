<html>
<body>
	<p>
    PPID - ACEH Online. <br>
    Anda telah melakukan Pengajuan Keberatan Atas Permohonan Informasi, dengan data sebagai berikut 
    </p>
    <table cellpadding="2" border="0" cellspacing="0">
      <tr>
        <td colspan="3"><strong>1. INFORMASI PENGAJUAN KEBERATAN</strong></td>
      </tr>
      <tr>
        <td width="200"><strong>Nomor Registrasi Keberatan</strong></td>
        <td>:</td>
        <td><?=$nomor_keberatan?></td>
      </tr>
      <tr>
        <td><strong>Nomor Pendaftaran Permohonan Informasi</strong></td>
        <td>:</td>
        <td><?=$nomor_permohonan?></td>
      </tr>
      <tr>
        <td colspan="3"><strong>Tujuan Penggunaan Informasi</strong></td>
      </tr>
      <tr>
        <td colspan="3"><div style="margin-left:20px"><?=$tujuan_penggunaan?></div></td>
      </tr>
      <tr>
        <td colspan="3"><strong>Identitas Pemohon</strong></td>
      </tr>
      <tr>
        <td><div style="margin-left:20px">Nama </div></td>
        <td width="10">:</td>
        <td><?=$nama_pemohon?></td>
      </tr>
      <tr>
        <td><div style="margin-left:20px">Pekerjaan</div></td>
        <td width="10">:</td>
        <td><?=$pekerjaan_pemohon?></td>
      </tr>
      <tr>
        <td><div style="margin-left:20px">Alamat</div></td>
        <td width="10">:</td>
        <td><?=$alamat_pemohon?></td>
      </tr>
      <tr>
        <td><div style="margin-left:20px">Telepon</div></td>
        <td width="10">:</td>
        <td><?=$telepon_pemohon?></td>
      </tr>
      <tr>
        <td><div style="margin-left:20px">Email</div></td>
        <td width="10">:</td>
        <td><?=$email_pemohon?></td>
      </tr>
      <tr>
        <td colspan="3"><strong>Identitas Kuasa Pemohon</strong></td>
      </tr>
      <tr>
        <td><div style="margin-left:20px">Nama </div></td>
        <td width="10">:</td>
        <td><?=$kuasa_nama?></td>
      </tr>
      <tr>
        <td><div style="margin-left:20px">Alamat</div></td>
        <td width="10">:</td>
        <td><?=$kuasa_alamat?></td>
      </tr>
      <tr>
        <td><div style="margin-left:20px">Telepon</div></td>
        <td width="10">:</td>
        <td><?=$kuasa_telepon?></td>
      </tr>
      <tr>
        <td><div style="margin-left:20px">Email</div></td>
        <td width="10">:</td>
        <td><?=$kuasa_email?></td>
      </tr>
      <tr>
        <td colspan="3"><strong>2. ALASAN PENGAJUAN KEBERATAN</strong>***</td>
      </tr>
      <tr>
        <td colspan="3">
        	<div style="margin-left:20px">
            <table>
            	<?php 
				foreach($m_alasan as $k=>$v) { 
					$checked = (in_array($k,$alasan))?"&radic;":"";
				?>
            	<tr>
                	<td><?=$checked?></td><td><?=$k?>.</td><td><?=$v?></td>
                </tr>
                <?php
				}
				?>
            </table>
            </div>
         </td>
      </tr>
      <tr>
        <td colspan="3"><strong>3. KASUS POSISI</strong></td>
      </tr>
      <tr>
        <td colspan="3"><div style="margin-left:20px"><?=$kasus_posisi;?></div></td>
      </tr>
    </table>
    <p>Kami akan merespon keberatan anda secepatnya, &quot;Hari/tanggal tanggapan atas keberatan akan diberikan&quot; akan di isi oleh Petugas penerima keberatan.<br>
    Terima Kasih Telah menggunakan Layanan ini, silahkan login disitus <a href="http://ppid.acehprov.go.id" target="_blank">ppid aceh</a></p>
</body>
</html>