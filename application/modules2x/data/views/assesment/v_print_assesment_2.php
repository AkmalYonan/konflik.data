<!-- HALAMAN 2 -->
	<? $lookup_jenis_penggunaan=array(0=>"-")+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_penggunaan'"," order by order_num");
	?>
    
    <table class="table table-bordered table-condensed">
    	<tr>
        	<td width="20" rowspan="11">4</td>
            <td width="200" rowspan="11">STATUS PENGGUNAAN NARKOTIKA</td>
        	<td colspan="4">Jenis Cara Penggunaan: 
            	<br>
            	 <span style="padding-right:20px">1. Oral </span>
                 <span style="padding-right:20px">2. Nasal/sublingual/suppositoria</span>
                 <span style="padding-right:20px">3. Merokok</span>
                 <span style="padding-right:20px">4. Injeksi Non-IV</span>
                 <span style="padding-right:20px">5. IV</span>
            </td>
        </tr>
        <tr>
          <td colspan="4" style="padding:0">
          	<table class="table table-bordered table-condensed" width="100%" style="width:100%;min-width:100%">
            <tr>
            	<td colspan="2">Jenis Napza</td>
                <td width="100px">30 hari terakhir</td>
                <td width="100px">Sepanjang hidup (thn)</td>
                <td width="100px">Cara Pakai</td>
            </tr>
            <tr>
                <td>D.1</td>
                <td>Alkohol</td>
                <td><?=$data_assesment_narkotika["alkohol_30"]?></td>
                <td><?=$data_assesment_narkotika["alkohol_sh"]?></td>
                <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["alkohol_cp"]]?></td>
            </tr>
         <tr>
            <td>D.2</td>
            <td>Heroin</td>
            <td><?=$data_assesment_narkotika["heroin_30"]?></td>
            <td><?=$data_assesment_narkotika["heroin_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["heroin_cp"]]?></td>
        </tr> <tr>
            <td>D.3</td>
            <td>Metadon / Buprenorfin</td>
            <td><?=$data_assesment_narkotika["metadon_30"]?></td>
            <td><?=$data_assesment_narkotika["metadon_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["metadon_cp"]]?></td>
        </tr> <tr>
            <td>D.4</td>
            <td>Opiat lain / Analgesik</td>
            <td><?=$data_assesment_narkotika["opiat_30"]?></td>
            <td><?=$data_assesment_narkotika["opiat_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["opiat_cp"]]?></td>
        </tr> <tr>
            <td>D.5</td>
            <td>Barbiturat</td>
            <td><?=$data_assesment_narkotika["barbiturat_30"]?></td>
            <td><?=$data_assesment_narkotika["barbiturat_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["barbiturat_cp"]]?></td>
        </tr> <tr>
            <td>D.6</td>
            <td>Sedatif / Hipnotik</td>
            <td><?=$data_assesment_narkotika["sedatif_30"]?></td>
            <td><?=$data_assesment_narkotika["sedatif_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["sedatif_cp"]]?></td>
        </tr> <tr>
            <td>D.7</td>
            <td>Kokain</td>
            <td><?=$data_assesment_narkotika["kokain_30"]?></td>
            <td><?=$data_assesment_narkotika["kokain_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["kokain_cp"]]?></td>
        </tr> <tr>
            <td>D.8</td>
            <td>Amfetamin</td>
            <td><?=$data_assesment_narkotika["ampetamin_30"]?></td>
            <td><?=$data_assesment_narkotika["ampetamin_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["ampetamin_cp"]]?></td>
        </tr> <tr>
            <td>D.9</td>
            <td>Kanabis</td>
            <td><?=$data_assesment_narkotika["kanabis_30"]?></td>
            <td><?=$data_assesment_narkotika["kanabis_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["kanabis_cp"]]?></td>
        </tr> <tr>
            <td>D.10</td>
            <td>Halusinogen</td>
            <td><?=$data_assesment_narkotika["halusinogen_30"]?></td>
            <td><?=$data_assesment_narkotika["halusinogen_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["halusinogen_cp"]]?></td>
        </tr> <tr>
            <td>D.11</td>
            <td>Inhalan</td>
            <td><?=$data_assesment_narkotika["inhalan_30"]?></td>
            <td><?=$data_assesment_narkotika["inhalan_sh"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["inhalan_cp"]]?></td>
        </tr> <tr>
            <td>D.12</td>
            <td>Lebih dari 1 zat/hari (termasuk alkohol)</td>
            <td><?=$data_assesment_narkotika["lebih_30"]?></td>
            <td><?=$lookup_jenis_penggunaan[$data_assesment_narkotika["lebih_sh"]]?></td>
            <td>&nbsp;</td>
        </tr>
            </table>
          </td>
        </tr>
        
        <tr>
          <td>13</td>
          <td>Jenis zat utama yang disalahgunakan</td>
          <td width="250"><?=$data_assesment_narkotika["jenis_zat_utama"]?></td>
          <td width="40">&nbsp;</td>
        </tr>
        <tr>
          <td>14</td>
          <td>Pernahkah menjalani terapi rehabilitasi</td>
          <td>Ya = 1, Tidak = 0</td>
          <td><?=$data_assesment_narkotika["test_rehab"]?></td>
        </tr>
        <tr>
          <td>15</td>
          <td colspan="3">Bila ya, jenis terapi rehabilitasi yang dijalani ?<br>Keterangan : 
            <?=$data_assesment_narkotika["terapi_rehab"]?></td>
        </tr>
        <tr>
          <td>16</td>
          <td>Pernahkah mengalami overdosis ?</td>
          <td>Ya = 1, Tidak = 0</td>
          <td><?=$data_assesment_narkotika["pernah_od"]?></td>
          
        </tr>
        <tr>
          <td>17</td>
          <td colspan="3">Bila ya, kapan dan bagaimana penanggulangannya</td>
        </tr>
        <tr>
          <td>18</td>
          <td>Waktu overdosis</td>
          <td colspan="2"><?=$data_assesment_narkotika["waktu_od"]?date2indo($data_assesment_narkotika["waktu_od"]):""?></td>
        </tr>
        <tr>
          <td>19</td>
         <td>Cara penanggulangan </td>
          <td>Perawatan di RS = 1</td>
           <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>Perawatan di Puskesmas = 2</td>
           <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>Sendiri = 3</td>
           <td>&nbsp;</td>
        </tr>
        <tr>
          <td rowspan="18">5</td>
          <td rowspan="18">STATUS LEGAL</td>
          <td>&nbsp;</td>
          <td colspan="3">Berapa kali kah dalam hidup anda ditangkap dan dituntut dengan hal berikut : 		  </td>
        </tr>
        <tr>
          <td>1</td>
          <td>Mencuri / vandalisme</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["mencuri"]?></td>
        </tr>
        <tr>
          <td>2</td>
          <td>Bebas bersyarat / masa percobaan</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["bebas_bersyarat"]?></td>
        </tr>
        <tr>
          <td>3</td>
          <td>Masalah Narkoba</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["narkoba"]?></td>
        </tr>
        <tr>
          <td>4</td>
          <td>Pemalsuan</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["pemalsuan"]?></td>
        </tr>
        <tr>
          <td>5</td>
          <td>Penyerangan bersenjata</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["penyerangan_bersenjata"]?></td>
        </tr>
        <tr>
          <td>6</td>
          <td>Pembobolan pencurian</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["pencurian"]?></td>
        </tr>
        <tr>
          <td>7</td>
          <td>Perampokan</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["perampokan"]?></td>
        </tr>
        <tr>
          <td>8</td>
          <td>Penyerangan</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["penyerangan"]?></td>
        </tr>
        <tr>
          <td>9</td>
          <td>Pembakaran rumah</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["pembakaran"]?></td>
        </tr>
        <tr>
          <td>10</td>
          <td>Perkosaan</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["perkosaan"]?></td>
        </tr>
        <tr>
          <td>11</td>
          <td>Pembunuhan</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["pembunuhan"]?></td>
        </tr>
        <tr>
          <td>12</td>
          <td>Pelacuran</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["pelacuran"]?></td>
        </tr>
        <tr>
          <td>13</td>
          <td>Melecehkan pengadilan</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["pelecehan_pengadilan"]?></td>
        </tr>
        <tr>
          <td>14</td>
          <td>lain-lain</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["lain_lain"]?></td>
        </tr>
        <tr>
          <td>&nbsp; </td>
          <td>&nbsp; </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>15</td>
          <td>Berapakali tuntutan di atas berakibat vonis hukuman?</td>
          <td>&nbsp;</td>
          <td><?=$data_assesment_legal["vonis"]?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
    	
    </table>
