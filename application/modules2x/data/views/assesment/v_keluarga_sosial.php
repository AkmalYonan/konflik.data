		<div class="row">
        	<div class="col-md-12">
             	<h4 class="heading">Riwayat Keluarga Sosial</h4>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-md-6">
            	<label>Dalam situasi seperti apakah anda tinggal 3 tahun belakangan ini? *</label>
            	<table style="width:75%" class="table table-bordered table-condensed">
                	<tr>
                    	<td>Dengan pasangan dan anak</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="pasangan_anak" class="flat-red" <?php echo $data_assesment_keluarga['pasangan_anak']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>Dengan pasangan saja</td>
                        <td><input type="checkbox" name="pasangan" class="flat-red" <?php echo $data_assesment_keluarga['pasangan']?"checked='checked'":'';?> value="1"></td>
                    </tr>
                    <tr>
                    	<td>Dengan anak saja</td>
                        <td><input type="checkbox" name="anak" class="flat-red" <?php echo $data_assesment_keluarga['anak']?"checked='checked'":'';?> value="1"></td>
                    </tr>
                    <tr>
                    	<td>Dengan orang tua</td>
                        <td><input type="checkbox" name="orang_tua" class="flat-red" <?php echo $data_assesment_keluarga['orang_tua']?"checked='checked'":'';?> value="1"></td>
                    </tr>
                    <tr>
                    	<td>Dengan keluarga</td>
                        <td><input type="checkbox" name="keluarga" class="flat-red" <?php echo $data_assesment_keluarga['keluarga']?"checked='checked'":'';?> value="1"></td>
                    </tr>
                    <tr>
                    	<td>Dengan teman</td>
                        <td><input type="checkbox" name="teman" class="flat-red" <?php echo $data_assesment_keluarga['teman']?"checked='checked'":'';?> value="1"></td>
                    </tr>
                    <tr>
                    	<td>Sendiri</td>
                        <td><input type="checkbox" name="sendiri" class="flat-red" <?php echo $data_assesment_keluarga['sendiri']?"checked='checked'":'';?> value="1"></td>
                    </tr>
                    <tr>
                    	<td>Lingkungan terkontrol</td>
                        <td><input type="checkbox" name="lingkungan_terkontrol" class="flat-red" <?php echo $data_assesment_keluarga['lingkungan_terkontrol']?"checked='checked'":'';?> value="1"></td>
                    </tr>
                    <tr>
                    	<td>Kondisi tidak stabil</td>
                        <td><input type="checkbox" name="active" class="flat-red" <?php echo $data_assesment_keluarga['kondisi_tidak_stabil']?"checked='checked'":'';?> value="1"></td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
            	<label>Apakah anda hidup dengan seseorang yang mempunyai masalah penyalahgunaan zat sekarang ini? </label>
                <table style="width:75%" class="table table-bordered table-condensed">
                	<tr>
                    	<td>1. Saudara Kandung/Tiri</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="residen_saudara" class="flat-red" <?php echo $data_assesment_keluarga['residen_saudara']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>2. Ayah/Ibu</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="residen_ayah_ibu" class="flat-red" <?php echo $data_assesment_keluarga['residen_ayah_ibu']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>3. Om/Tante</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="residen_om_tante" class="flat-red" <?php echo $data_assesment_keluarga['residen_om_tante']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>4. Pasangan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="residen_pasangan" class="flat-red" <?php echo $data_assesment_keluarga['residen_pasangan']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>4. Teman</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="residen_teman" class="flat-red" <?php echo $data_assesment_keluarga['residen_teman']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    <tr>
                    	<td>5. Lainnya</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="residen_lain" class="flat-red" <?php echo $data_assesment_keluarga['residen_lain']?"checked='checked'":'';?> value="1">
                          </label></td>
                    </tr>
                    
                    
                </table>
                
                <p>* (Pilih situasi yang paling menggambarkan 3 tahun terakhir. Jika terdapat situasi yang berganti-ganti maka pilihlah situasi yang paling terakhir)
            </div>
            
        </div><!-- end row-->
        
        <div class="row">
        	<div class="col-md-6">
            	<label>Apakah anda hidup dengan seseorang yang mempunyai masalah penyalahgunaan zat sekarang ini? </label>
                <table style="width:75%" class="table table-bordered table-condensed">
                	<tr>
                    	<td>1. Ibu</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="ibu_30" class="flat-red" <?php echo $data_assesment_keluarga['ibu_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="ibu_sh" class="flat-red" <?php echo $data_assesment_keluarga['ibu_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    <tr>
                    	<td>2. Ayah</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="ayah_30" class="flat-red" <?php echo $data_assesment_keluarga['ayah_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="ayah_sh" class="flat-red" <?php echo $data_assesment_keluarga['ayah_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    <tr>
                    	<td>3. Adik/Kakak</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="adik_kakak_30" class="flat-red" <?php echo $data_assesment_keluarga['adik_kakak_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="adik_kakak_sh" class="flat-red" <?php echo $data_assesment_keluarga['adik_kakak_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                     <tr>
                    	<td>4. Pasangan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="pasangan_30" class="flat-red" <?php echo $data_assesment_keluarga['pasangan_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="pasangan_sh" class="flat-red" <?php echo $data_assesment_keluarga['pasangan_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    <tr>
                    	<td>5. Anak-anak</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="anak_anak_30" class="flat-red" <?php echo $data_assesment_keluarga['anak_anak_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="anak_anak_sh" class="flat-red" <?php echo $data_assesment_keluarga['anak_anak_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    <tr>
                    	<td>6. Keluarga lain yang berarti (dijelaskan)</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="keluarga_lain_30" class="flat-red" <?php echo $data_assesment_keluarga['keluarga_lain_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="keluarga_lain_sh" class="flat-red" <?php echo $data_assesment_keluarga['keluarga_lain_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    <tr>
                    	<td>7. Teman akrab</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="anak_anak_30" class="flat-red" <?php echo $data_assesment_keluarga['anak_anak_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="anak_anak_sh" class="flat-red" <?php echo $data_assesment_keluarga['anak_anak_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    
                     <tr>
                    	<td>8. Tetangga</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="tetangga_30" class="flat-red" <?php echo $data_assesment_keluarga['tetangga_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="tetangga_sh" class="flat-red" <?php echo $data_assesment_keluarga['tetangga_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    <tr>
                    	<td>9. Teman Sekerja</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="teman_kerja_30" class="flat-red" <?php echo $data_assesment_keluarga['teman_kerja_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="teman_kerja_sh" class="flat-red" <?php echo $data_assesment_keluarga['teman_kerja_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    
                    
                    
                </table>
            
            </div><!-- end col -->
        </div><!-- end row -->
        
        
        <div class="row">
        	<div class="col-md-8">
            	<label>Apakah anda hidup dengan seseorang yang mempunyai masalah penyalahgunaan zat sekarang ini? </label>
                <table style="width:100%" class="table table-bordered table-condensed">
                <tr>
                    	<td>1. Mengalami Depresi serius (kesedihan, putus asa, kehilangan minat, susah konstentrasi)</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="depresi_30" class="flat-red" <?php echo $data_assesment_keluarga['depresi_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="depresi_sh" class="flat-red" <?php echo $data_assesment_keluarga['depresi_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    
                     <tr>
                    	<td>2. Mengalamin rasa cemas serius/ketegangan, gelisah, merasa khawatir berlebihan?</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="cemas_30" class="flat-red" <?php echo $data_assesment_keluarga['cemas_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="cemas_sh" class="flat-red" <?php echo $data_assesment_keluarga['cemas_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    
                    <tr>
                    	<td>3. Mengalami halusinasi (melihat/mendengar sesuatu yang tidak ada objeknya)</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="halusinasi_30" class="flat-red" <?php echo $data_assesment_keluarga['halusinasi_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="halusinasi_sh" class="flat-red" <?php echo $data_assesment_keluarga['halusinasi_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    <tr>
                    	<td>4. Mengalami kesulitan mengingat atau fokus pada sesuatu</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="kesulitan_mengingat_30" class="flat-red" <?php echo $data_assesment_keluarga['kesulitan_mengingat_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="kesulitan_mengingat_sh" class="flat-red" <?php echo $data_assesment_keluarga['kesulitan_mengingat_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    
                     <tr>
                    	<td>5. Mengalami kesukaran mengontrol perilaku kasar, termasuk kemarahan atau kekerasan</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="kontrol_perilaku_30" class="flat-red" <?php echo $data_assesment_keluarga['kontrol_perilaku_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="kontrol_perilaku_sh" class="flat-red" <?php echo $data_assesment_keluarga['kontrol_perilaku_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    
                    <tr>
                    	<td>6. Mengalami pikiran serius untuk bunuh diri</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="pikiran_bunuh_diri_30" class="flat-red" <?php echo $data_assesment_keluarga['pikiran_bunuh_diri_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="pikiran_bunuh_diri_sh" class="flat-red" <?php echo $data_assesment_keluarga['pikiran_bunuh_diri_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    
                    <tr>
                    	<td>7. Berusaha untuk bunuh diri</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="usaha_bunuh_diri_30" class="flat-red" <?php echo $data_assesment_keluarga['usaha_bunuh_diri_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc"><input type="checkbox" name="usaha_bunuh_diri_sh" class="flat-red" <?php echo $data_assesment_keluarga['usaha_bunuh_diri_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                    <tr>
                    	<td>8. Menerima pengobatan dari psikiater</td>
                        <td width="20px" class="tc"><label>
                              <input type="checkbox" name="psikiater_30" class="flat-red" <?php echo $data_assesment_keluarga['psikiater_30']?"checked='checked'":'';?> value="1">
                          </label></td>
                          <td width="20px" class="tc">
                          <input type="checkbox" name="psikiater_sh" class="flat-red" <?php echo $data_assesment_keluarga['psikiater_sh']?"checked='checked'":'';?> value="1">
                          </td>
                    </tr>
                	</table>
        	</div><!-- end col -->
        </div><!-- end row-->