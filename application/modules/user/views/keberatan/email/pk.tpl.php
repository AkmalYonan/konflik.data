
    <table width="100%" border="0" cellpadding="0">
      <tr>
        <td width="100" rowspan="2" align="center"><img src="<?=$site_url;?>assets/image/logo_aceh.png" title="Logo" align="Logo"></td>
        <td><h4>PEMERINTAH PROVINSI ACEH<br>PPID PROVINSI ACEH</h4></td>
      </tr>
      <tr>
        <td style="font-size:small">Alamat : Jl. Sulthan Alaidin Mahmudsyah, Banda Aceh No.14<br>
        Telp      : 0651-33615</td>
      </tr>
      <tr>
        <td colspan="2" align="center" style="border-bottom:3px solid #000">&nbsp;</td>
      </tr>
    </table>
    <div style="margin:10px 0; text-align:center"><strong>FORM KEBERATAN ATAS PERMOHONAN INFORMASI</strong></div>
<p>&nbsp;</p>
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
            <td colspan="3"><div style="margin-left:20px">
              <?=$tujuan_penggunaan?>
            </div></td>
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
            <td colspan="3"><div style="margin-left:20px">
                <table>
                  <?php 
				foreach($m_alasan as $k=>$v) { 
					$checked = (in_array($k,$alasan))?"&radic;":"";
				?>
                  <tr>
                    <td><?=$checked?></td>
                    <td><?=$k?>
                      .</td>
                    <td><?=$v?></td>
                  </tr>
                  <?php
				}
				?>
                </table>
            </div></td>
          </tr>
          <tr>
            <td colspan="3"><strong>3. KASUS POSISI</strong></td>
          </tr>
          <tr>
            <td colspan="3"><div style="margin-left:20px">
              <?=$kasus_posisi;?>
            </div></td>
          </tr>
        <tr>
          <td colspan="3"><strong>4. HARI/TANGGAL TANGGAPAN ATAS KEBERATAN AKAN DIBERIKAN :</strong></td>
          </tr>
        <tr>
          <td colspan="3"><div style="margin-left:20px">-</div></td>
          </tr>
        </table>
<br>

		Demikian keberatan ini saya sampaikan, atas perhatiaan dan tanggapannya, saya ucapkan terima kasih.
<br>
<br>
<br>
<table width="100%" border="0">
  <tr>
    <td width="40%" align="center"><p>Banda Aceh, <?=date("d-m-Y",strtotime($created_date))?><br />
      Petugas Pelayanan Informas<strong>i<br />
      (Penerima Keberatan)</strong></p>
      <p>&nbsp;</p>
      <img src="<?=$site_url;?>assets/image/stempel_online_small.png" alt="" /><br />
      <span style="border-bottom:1px solid #000"><strong>
      Sistem Online
      </strong></span><br />
      <span>
      
    </span> </td>
    <td align="center">&nbsp;</td>
    <td width="40%" align="center"><p>&nbsp;<br>
        <strong>Pengaju Keberatan</strong></p>
      <p>&nbsp;</p>
      <span style="border-bottom:1px solid #000"><strong><?=$user['first_name']?></strong></span><br>
      <span><?=$user['tanda_pengenal']?> No. <?=$user['nomor_pengenal']?></span>      </td>
  </tr>
</table>

<table width="100%" border="0" style="font-size:x-small; margin-top:20px">
  <tr>
    <td colspan="2" style="border-top:1px dotted #000;">KETERANGAN</td>
  </tr>
  <tr>
    <td>*</td>
    <td>Nomor Register pengajuan keberatan diisi berdasarkan buku register pengajuan keberatan.</td>
  </tr>
  <tr>
    <td>**</td>
    <td>Identitas Kuasa pemohon diisi jika ada kuasa pemohonnya dan melampirkan Surat Kuasa.</td>
  </tr>
  <tr>
    <td>***</td>
    <td>Sesuai dengan pasal 17 huruf j UUKIP, dipilih oleh pengaju keberatan sesuai dengan alasan keberatan yang diajukan.</td>
  </tr>
  <tr>
    <td>****</td>
    <td>Diisi sesuai dengan ketentuan jangka waktu dalam UUKIP.</td>
  </tr>
  <tr>
    <td>*****</td>
    <td>Tanggal diisi dengan tanggal diterimanya pengajuan keberatan yaitu sejak keberatan dinyatakan lengkap sesuai dengan buku register pengajuan keberatan.</td>
  </tr>
  <tr>
    <td>******</td>
    <td>Dalam hal keberatan diajukan secara langsung, maka formulir keberatan juga ditandatangani oleh petugas yang menerima pengajuan keberatan</td>
  </tr>
</table>
