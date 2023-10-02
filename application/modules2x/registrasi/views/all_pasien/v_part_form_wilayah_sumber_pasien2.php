<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_sumber_biaya=$lookup_empty+lookup("m_sumber_biaya","kd_sumber","ur_sumber",""," order by order_num");
	
	$lookup_wilayah=$lookup_empty+lookup("m_kabupaten_kota","kode_bps","nama","","order by kode_bps");
	$data_propinsi=lookup("m_propinsi2","kode_bps","nama");
	foreach($data_propinsi as $x=>$val):
		$data_propinsi[$x]=strtoupper($val);
	endforeach;
	$lookup_jenis_kelamin=$lookup_empty+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_kelamin'"," order by order_num");
	
	$lookup_bnnp=$lookup_empty+lookup("m_org","kd_org","nama","tipe_org='BNNP'","order by idx");
	$lookup_bnnp2=$lookup_empty+lookup("m_org","kd_wilayah","nama","tipe_org='BNNP'","order by idx");
	$lookup_balai=$lookup_empty+lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
	
	
?>

<?php
	$lookup_empty=array(""=>"--pilih--");
	$lookup_bnnp=lookup("m_org","kd_org","nama","tipe_org='BNNP'","order by idx");
	$lookup_balai=lookup("m_instansi","id_kabupaten","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK')","order by idx");
	$lookup_status_nikah=$this->data_lookup["status_kawin"];
?>

<?php
                            $tahun_awal=date("Y")-10;
                            $tahun_akhir=date("Y");
                            for($i=$tahun_akhir;$i>=$tahun_awal;$i--):
                                $lookup_periode_tahun[$i]=$i;
                            endfor;
                            $lookup_periode_tahun=$lookup_empty+$lookup_periode_tahun;
                            $lookup_periode_bulan=array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                            $periode_bulan=$data["periode_bulan"]?$data["periode_bulan"]:date("m");
                            $periode_tahun=$data["periode_tahun"]?$data["periode_tahun"]:date("Y");
                            
                          ?>
                      
                              <div class="row">
                                <div class="col-md-6">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="nama">Bulan</label>
                                          <?=form_dropdown("periode_bulan",$lookup_periode_bulan,$periode_bulan,"id='periode_bulan' class='form-control select2 required'");?>
                                         </div><!-- end form group --> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="nama">Tahun</label>
                                        <?=form_dropdown("periode_tahun",$lookup_periode_tahun,$periode_tahun,"id='periode_tahun' class='form-control select2 required'");?>
                                        </div><!-- end form group-->
                                    </div>
                              </div><!-- end row -->
                       
                               <div class="row">      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="nama">Sumber Biaya</label>
                                            <?=form_dropdown("sumber_biaya",$lookup_sumber_biaya,$data["sumber_biaya"],"id='sumber_biaya' class='form-control select2 required'");?>
                                            </div><!-- end form group-->
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama">Sumber Pasien</label>
                                                <?=form_dropdown("sumber_pasien",$lookup_empty+$this->data_lookup["sumber_pasien"],$data["sumber_pasien"],"id='sumber_pasien' class='form-control select2 required'");?>
                                             </div><!-- end form group -->
                                        </div>
                                    </div><!-- end row-->
                            
                            
                            
                        			</div><!-- end col 6 LEFT SIDE-->
                        
                        
                        			<div class="col-md-6">
										
										<div class="form-group">
											<?php
												$tgl_registrasi=$data["tgl_registrasi"]?$data["tgl_registrasi"]:date("Y-m-d H:i:s");
											?>
											<label for="nama">Tgl Registrasi</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												  <input type="text" id="tgl_registrasi_selector" class="form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_registrasi))?>" placeholder="dd/mm/yyyy"/>
												  <input type="hidden" id="tgl_registrasi" name="tgl_registrasi" value="<?=date("Y-m-d",strtotime($tgl_registrasi));?>" class="required" />
											</div>
										
										</div><!-- end form group -->
										
										<div class="form-group">
										  <label for="nama">No Rekam Medik</label>
										  <input class="form-control required" name="no_rekam_medis" id="no_rekam_medis" type="text" value="<?php echo $data["no_rekam_medis"];?>" <?=($action=="execute")?"":"readonly='readonly'"?> />
										</div><!-- end form group -->
                                	</div><!-- end col 6-->
                      		</div><!-- end row-->
                      		<!-- END FIRST FORM-->
                            
                            
<script>
	$(function(){
		//$("#kd_wilayah").select2({'placeholder':"--Pilih Wilayah--"});
		$("#kd_balai").change(function(){
			var data_propinsi=<?=json_encode($data_propinsi)?>||"";
			var kd_propinsi=$(this).find(":selected").val();
			var id_propinsi=kd_propinsi;
			$("#kd_balai").val(id_propinsi);
			$("#kd_wilayah_propinsi_txt").val(data_propinsi[id_propinsi.substr(0,2)]);
		}).change();	
		
		$("#kd_bnn").change(function(){
			var data_propinsi=<?=json_encode($data_propinsi)?>||"";
			var kd_propinsi=$(this).find(":selected").val();
			var id_propinsi=kd_propinsi;
			$("#kd_bnn").val(id_propinsi);
			$("#kd_wilayah_propinsi_txt").val(data_propinsi[id_propinsi.substr(0,2)]);
		}).change();	
	});
</script>                            