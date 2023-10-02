<table class="table table-bordered table-condensed">
    	<tr>
        	<td width="20" rowspan="8">1.</td>
            <td width="200" rowspan="8">Informasi Demografis</td>
        	<td width="20" rowspan="3">1</td>
            <td rowspan="3">Status Perkawinan</td>
            <td width="300">Belum Menikah=1</td>
          <td rowspan="3" width="40px"><?=$data_assesment["status_nikah"]?></td>
        </tr>
    	<tr>
    	  <td>Sudah Menikah=2</td>
  	  	</tr>
    	<tr>
    	  <td>Duda/Janda=3</td>
  	  	</tr>
    	<tr>
    	  <td rowspan="5">2</td>
    	  <td rowspan="5">Pendidikan Terakhir </td>
    	  <td>Tamat SD = 1</td>
    	  <td rowspan="5"><?=$data_assesment["status_pendidikan"]?></td>
  	  	</tr>
    	<tr>
    	  <td>Tamat SLTP = 2</td>
  	  	</tr>
    	<tr>
    	  <td>Tamat SLTA = 3</td>
  	  	</tr>
    	<tr>
    	  <td>Tamat Akademi = 4</td>
  	  	</tr>
    	<tr>
    	  <td>Tamat PT = 5</td>
  	  	</tr>
    	<tr>
    	  <td rowspan="9">2</td>
    	  <td rowspan="9">STATUS MEDIS</td>
    	  <td>1</td>
    	  <td colspan="3"><p>Riwayat kesehatan yang tidak terkait dengan masalah narkoba</p>
   	      	<table class="table table-bordered table-condensed" width="100%" border="1px">
            	<tr>
                	<td>Jenis Penyakit</td>
                    <td>Dirawat tahun</td>
                    <td>Lamanya</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                
            </table>
          </td>
   	  </tr>
      <tr>
    	  <td rowspan="2">2</td>
    	  <td>Riwayat Penyakit Kronis</td>
    	  <td>Ya = 1, Tidak = 0</td>
    	  <td><?=$data_assesment["riwayat_penyakit_kronis"]?></td>
  	  </tr>
      <tr>
    	  <td>Jenis Penyakit</td>
    	  <td colspan="2"><?=$data_assesment["jenis_penyakit_kronis"]?></td>
   	  </tr>
      <tr>
    	  <td rowspan="2">3</td>
    	  <td>Saat ini sedang menjalani terapi medis?</td>
    	  <td>Ya = 1, Tidak = 0</td>
    	  <td><?=$data_assesment["terapi_medis"]?></td>
  	  </tr>
      <tr>
    	  <td colspan="3"><p>Jenis Terapi medis yang sedang di jalani..</p>
   	      <p><?=$data_assesment["jenis_terapi_medis"]?></p></td>
   	  </tr>
      <tr>
    	  <td rowspan="4">4</td>
    	  <td>Status Kesehatan</td>
    	  <td>Apakah pernah di test</td>
    	  <td><?=$data_assesment["pernah_ditest"]?></td>
  	  </tr>
      <tr>
    	  <td>4.1 HIV</td>
    	  <td>Ya = 1, Tidak = 0</td>
    	  <td><?=$data_assesment["test_hiv"]?></td>
  	  </tr>
      <tr>
    	  <td>4.2 Hepatitis B</td>
    	  <td>Ya = 1, Tidak = 0</td>
    	  <td><?=$data_assesment["test_hepatitis_b"]?></td>
  	  </tr>
      <tr>
    	  <td>4.3 Hepatitis C</td>
    	  <td>Ya = 1, Tidak = 0</td>
    	  <td><?=$data_assesment["test_hepatitis_c"]?></td>
  	  </tr>
      <tr>
    	  <td rowspan="17">3</td>
    	  <td rowspan="17">STATUS PEKERJAAN/DUKUNGAN HIDUP</td>
    	  <td rowspan="4">1</td>
    	  <td rowspan="4">Status Pekerjaan</td>
    	  <td>Tidak Bekerja = 1</td>
    	  <td rowspan="4"><?=$data_assesment["status_pekerjaan"]?></td>
  	  </tr>
      <tr>
        <td>Bekerja = 2</td>
      </tr>
      <tr>
        <td>Mahasiswa / Pelajar = 8</td>
      </tr>
      <tr>
        <td>Ibu rumah tangga = 9</td>
      </tr>
      <tr>
        <td rowspan="3">2</td>
        <td rowspan="3">Bila bekerja, pola pekerjaan</td>
        <td>Purna waktu = 1</td>
        <td rowspan="3"><?=$data_assesment["pola_pekerjaan"]?></td>
      </tr>
     
      <tr>
        <td>Paruh waktu = 2</td>
      </tr>
      <tr>
        <td>Tidak tentu = 99</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Kode Pekerjaan</td>
        <td>(Lihat Petunjuk)</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>4</td>
        <td>Keterampilan teknis yang dimiliki</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>5</td>
        <td>Adakah yang memberi dukungan hidup pada anda?</td>
        <td>Ada = 1, Tidak = 0</td>
        <td><?=$data_assesment["dukungan_hidup"]?></td>
      </tr>
      <tr>
        <td>6</td>
        <td>Bila ya, siapakah?</td>
        <td colspan="2"><?=$data_assesment["dukungan_hidup_siapa"]?></td>
      </tr>
      <tr>
        <td rowspan="6">7</td>
        <td colspan="3">Dalam bentuk apakah?</td>
      </tr>
      <tr>
        <td>Finansial</td>
        <td>Ya = 1, Tidak = 0</td>
        <td><?=$data_assesment["dukungan_finansial"]?></td>
      </tr>
      <tr>
        <td>Tempat tinggal</td>
        <td>Ya = 1, Tidak = 0</td>
        <td><?=$data_assesment["dukungan_tempat_tinggal"]?></td>
      </tr>
      <tr>
        <td>Makan</td>
        <td>Ya = 1, Tidak = 0</td>
        <td><?=$data_assesment["dukungan_makan"]?></td>
      </tr>
      <tr>
        <td>Pengobatan/Perawatan</td>
        <td>Ya = 1, Tidak = 0</td>
        <td><?=$data_assesment["dukungan_pengobatan"]?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    	
    </table>