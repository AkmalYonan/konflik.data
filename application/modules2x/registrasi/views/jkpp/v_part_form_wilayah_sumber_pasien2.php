<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_sumber_biaya=$lookup_empty+lookup("m_sumber_biaya","kd_sumber","ur_sumber",""," order by order_num");
	
	$lookup_wilayah=$lookup_empty+lookup("m_kabupaten_kota","kode_bps","nama","","order by kode_bps");
	$data_propinsi=lookup("m_propinsi2","kode_bps","nama");
	foreach($data_propinsi as $x=>$val):
		$data_propinsi[$x]=strtoupper($val);
	endforeach;
	$lookup_jenis_kelamin=$lookup_empty+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_kelamin'"," order by order_num");
	
	if($this->user_instansi):
		if($this->user_instansi=="BNNP"):
			$lookup_bnnp=lookup("m_org","kd_org","nama","(kd_org='".$this->user_org."' and tipe_org='BNNP' and active='1')","order by idx");
		elseif($this->user_instansi=="BNNK"):
			$lookup_bnnk=lookup("m_org","kd_org","nama","(kd_org='".$this->user_org."' and tipe_org='BNNK' and active='1')","order by idx");
		elseif($this->user_instansi=="BL"):
			$lookup_balai=lookup("m_instansi","kd_instansi","nama_instansi","kd_instansi='".$this->user_org."' and (jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK')","order by idx");
		endif;
	else:
		$lookup_bnnp=$lookup_empty+lookup("m_org","kd_org","nama","tipe_org='BNNP' and active='1'","order by idx");
		$lookup_bnnp2=$lookup_empty+lookup("m_org","kd_wilayah","nama","tipe_org='BNNP'","order by idx");
		$lookup_bnnk=$lookup_empty+lookup("m_org","kd_org","nama","tipe_org='BNNK' and active='1'","order by idx");
		$lookup_balai=$lookup_empty+lookup("m_instansi","kd_instansi","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
	endif;
	
	
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
                            
										<div class="row" style="margin-bottom:10px">
											<div class="col-md-12">
												<label for="kd_bnn">Tempat Pendaftaran</label>
												<br />
												<div style=" padding-left:5px;">
												
												<?php if($this->user_instansi): ?>
													<?php if($this->user_instansi=="BNNP"): ?>
														<input type="radio" value="1" name="jns_org" class="cek_radio" required checked="checked" />&nbsp;BNNP
													<?php elseif($this->user_instansi=="BNNK"): ?>
														<input type="radio" value="3" name="jns_org" class="cek_radio" required checked="checked" />&nbsp;BNNK
													<?php elseif($this->user_instansi=="BL"): ?>
														<input type="radio" value="2" name="jns_org" class="cek_radio" required checked="checked" />&nbsp;Balai Loka
													<?php endif; ?>
												<?php else: ?>
													<input type="radio" value="1" name="jns_org" class="cek_radio" required <?=(($data['jns_org']==1) or (!$data['jns_org']))?"checked":""?> />&nbsp;BNNP<br />
													<input type="radio" value="3" name="jns_org" class="cek_radio" required <?=($data['jns_org']==3)?"checked":""?> />&nbsp;BNNK<br />
													<input type="radio" value="2" name="jns_org" class="cek_radio" required <?=($data['jns_org']==2)?"checked":""?> />&nbsp;Balai Loka
												<?php endif; ?>
												</div>
											</div>
										</div>
										
										<?php if($this->user_instansi): ?>
										<?php if($this->user_instansi=="BNNP"): ?>
										<div class="row bnnp">
											<div class="col-md-12">
												<label for="kd_bnn">Pilih BNNP</label>
												<? echo form_dropdown("kd_bnn",$lookup_bnnp,$data['kd_bnn'],"id='kd_bnnp' class='form-control select2 required'");?>
											</div>
										</div>
										<?php elseif($this->user_instansi=="BNNK"): ?>
										<div class="row bnnk">
											<div class="col-md-12">
												<label for="kd_bnn">Pilih BNNK</label>
												<? echo form_dropdown("kd_bnn",$lookup_bnnk,$data['kd_bnn'],"id='kd_bnnk' class='form-control select2 required'");?>
											</div>
										</div>
										<?php elseif($this->user_instansi=="BL"): ?>
										<div class="row balai">
											<div class="col-md-12">
												<label for="kd_bnn">Pilih BALAI</label>
												<? echo form_dropdown("kd_bnn",$lookup_balai,$data['kd_bnn'],"id='kd_balai' class='form-control select2 required'");?>
											</div>
										</div>
										<?php endif; ?>
										
										<?php else: ?>
										<div class="row bnnp hide">
											<div class="col-md-12">
												<label for="kd_bnn">Pilih BNNP</label>
												<? echo form_dropdown("kd_bnn",$lookup_bnnp,$data['kd_bnn'],"id='kd_bnnp' class='form-control select2 required'");?>
											</div>
										</div>
										
										<div class="row bnnk hide">
											<div class="col-md-12">
												<label for="kd_bnn">Pilih BNNK</label>
												<? echo form_dropdown("kd_bnn",$lookup_bnnk,$data['kd_bnn'],"id='kd_bnnk' class='form-control select2 required'");?>
											</div>
										</div>
										
										<div class="row balai hide">
											<div class="col-md-12">
												<label for="kd_bnn">Pilih BALAI</label>
												<? echo form_dropdown("kd_bnn",$lookup_balai,$data['kd_bnn'],"id='kd_balai' class='form-control select2 required'");?>
											</div>
										</div>
										<?php endif; ?>										
										
										<div class="form-group hidden">
											<label for="nama">Wilayah Adm.</label>
											<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["kd_wilayah"],"id='kd_wilayah' class='form-control select2 required'");?>
											<input type="hidden" id="kd_wilayah_propinsi" name="kd_wilayah_propinsi" value="<?=$data["kd_wilayah_propinsi"]?>" />
										</div><!-- end form group -->
									
										<div class="form-group hidden">
											<label for="nama">Propinsi</label>
											<input type="text" id="kd_wilayah_propinsi_txt" value="<?=$data_propinsi[substr($data['kd_bnn'],0,2)]?>" name="kd_wilayah_propinsi_txt" class="form-control" readonly="readonly" />
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