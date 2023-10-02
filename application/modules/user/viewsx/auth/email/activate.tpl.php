<html>
<body>
	<p>
    PPID - ACEH Online. <br>Anda telah melakukan pendaftaran sebagai member PPID-ACEH dengan data sebagai berikut 
    </p>
	<!--<h1><?php echo sprintf(lang('email_activate_heading'), $identity);?></h1>-->
    <table cellpadding="2" border="0" cellspacing="0">
    	<tr>
        <td>Nama</td><td width="10">:</td><td><?php echo $nama;?></td>
        </tr>
        <tr>
        <td>Tanda Pengenal</td><td width="10">:</td><td><?php echo $tp;?>: <?php echo $np;?></td>
        </tr>
        <tr>
        <td>Tempat,Tgl Lahir</td><td width="10">:</td><td><?php echo $ttl;?></td>
        </tr>
        <tr>
        <td>Jenis Kelamin</td><td width="10">:</td><td><?php echo $jk;?></td>
        </tr>
        <tr>
        <td>Alamat</td><td width="10">:</td><td><?php echo $address;?></td>
        </tr>
        <tr>
        <td>Kode Pos</td><td width="10">:</td><td><?php echo $kp;?></td>
        </tr>
        <tr>
        <td>Kab/Kota</td><td width="10">:</td><td><?php echo $kota;?></td>
        </tr>
        <tr>
        <td>Propinsi</td><td width="10">:</td><td><?php echo $propinsi;?></td>
        </tr>
        <tr>
        <td>Password</td><td width="10">:</td><td><?php echo $password;?></td>
        </tr>
    </table>
    <p>Terima Kasih Telah melakukan Pendaftaran, untuk login silahkan menggunakan email dan sandi anda<br>Untuk melengkapi proses pendaftaran ini, lakukan proses aktifasi dibawah ini</p>
	<h1><?php echo sprintf(lang('email_activate_heading'), anchor("http://".$_SERVER['SERVER_NAME'].$this->config->item('base_url').'user/activate/'. $id .'/'. $activation, $identity));?></h1>
</body>
</html>