<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_jenis_instansi[""]="--Pilih--";
	$lookup_jenis_instansi=$lookup_empty+lookup("m_jenis_instansi","kd_jenis_instansi","ur_jenis_instansi","","order by order_num");
	$lookup_tempat_rehab=$lookup_empty+lookup("m_tempat_rehab","idx","ur_tempat","","order by order_num");
	
	$lookup_jenis_kelamin=$lookup_empty+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_kelamin'"," order by order_num");
	
	$lookup_sumber_biaya=$lookup_empty+lookup("m_sumber_biaya","kd_sumber","ur_sumber",""," order by order_num");
	
	
	//debug();
	
	$lookup_wilayah=$lookup_empty+lookup("m_kabupaten_kota","kode_bps","nama","","order by kode_bps");
	$data_propinsi=lookup("m_propinsi2","kode_bps","nama");
	foreach($data_propinsi as $x=>$val):
		$data_propinsi[$x]=strtoupper($val);
	endforeach;
	
	//get pasien foto
	$data["foto_pasien"]=$this->conn->GetOne("select concat(path,file_name) as foto_pasien from t_pasien_foto where idx_parent=".$data["idx"]." and flag_default=1");
	
	
	
?>


<div class="row">
	<div class="col-md-6">
    	<div class="row">
                            	<div class="col-md-4">
                                
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
                            
                            </div><!-- end col-->
                            
                            <div class="col-md-8">
                            <div class="form-group">
                              <label for="nama">No Rekam Medik</label>
                              <input class="form-control required" name="no_rekam_medis" id="no_rekam_medis" type="text" value="<?php echo $data["no_rekam_medis"];?>" />
                            </div><!-- end form group -->
                            </div><!-- end col-->
                            </div><!-- end row -->
    </div>
</div><!-- end row-->

<div class="formSep"></div>

<h4 class="heading">Informasi Pasien</h4>
<div class="row">
                        <div class="col-md-6">
                        
                        	<div class="row">
                            <div class="col-md-3">
                            <? $foto_pasien=$data["foto_pasien"]?$data["foto_pasien"]:"assets/images/pic.jpg"?>
                        <img src="<?=$foto_pasien?>" id="foto_pasien" style="border: 1px solid #ddd;border-radius: 2px;width:120px;height: 140px;">
                        
                            </div><!-- end col -->
                            <div class="col-md-9">
                           <div class="form-group">
                              <label for="nama">Nama Lengkap</label>
                              <input class="form-control required" name="nama" id="nama" type="text" value="<?php echo $data["nama"];?>" />
                            </div><!-- end form group -->
                            
                            <div class="row">
                        <div class="col-md-4">
                        	<div class="form-group">
                            <label>Tanda Pengenal<span class="asterix">&nbsp;*</span></label>
                            <select name="jenis_identitas" id="jenis_identitas" class="form-control required">
<option value="KTP">KTP</option>
<option value="SIM">SIM</option>
<option value="PASSPOR">Paspor</option>
</select>                            </div>
                        </div>
                        <div class="col-md-8">
                        	<div class="form-group">
                            <label>Nomor<span class="asterix">&nbsp;*</span></label>
                            <input name="no_identitas" value="<?=$data["no_identitas"]?>" id="no_identitas" class="form-control required" type="text">                            </div>
                        </div>
                    </div>
                            
                            
                            </div><!-- end col-->
                            </div><!-- endrow-->
                            
                            
                            
                            <div class="formSep"></div>
                    		<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="nama">Tempat Lahir</label>
                                      <input class="form-control required" name="tempat_lahir" id="tempat_lahir" type="text" value="<?php echo $data["tempat_lahir"];?>" />
                                    </div><!-- end form -->
                                </div><!-- end col -->
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="nama">Tgl Lahir</label>
                                      <?
                                            $batas_umur_bawah=10;
                                            $batas_umur_atas=90;
                                            $tahun_ini=date("Y");
                                            $tahun_akhir=$tahun_ini-$batas_umur_bawah;
                                            $tahun_awal=$tahun_ini-$batas_umur_atas;
                                            for($i=$tahun_akhir;$i>=$tahun_awal;$i--):
                                                $lookup_tahun[$i]=$i;
                                            endfor;
                                            $lookup_tahun=$lookup_empty+$lookup_tahun;
                                            $lookup_bulan=array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                            
                                            $tanggal_lahir=$data["tgl_lahir"]?date("d",strtotime($data["tgl_lahir"])):"";
                                            $bulan_lahir=$data["tgl_lahir"]?date("m",strtotime($data["tgl_lahir"])):"";
                                            $tahun_lahir=$data["tgl_lahir"]?date("Y",strtotime($data["tgl_lahir"])):"";
                                            $tgl_lahir=$data["tgl_lahir"]?date("Y-m-d",strtotime($data["tgl_lahir"])):"";
                                            
                                            
                                      ?>
                                      <div class="row">
                                      <div class="col-md-3">
                                      <input class="form-control required" name="tanggal_lahir" id="tanggal_lahir" type="text" value="<?php echo $tanggal_lahir;?>" />
                                      </div>
                                      <div class="col-md-5">
                                      <?=form_dropdown("bulan_lahir",$lookup_bulan,$bulan_lahir,"id='bulan_lahir' class='form-control select2 required tgl_lahir'");?>
                                      </div>
                                      <div class="col-md-4">
                                      <?=form_dropdown("tahun_lahir",$lookup_tahun,$tahun_lahir,"id='tahun_lahir' class='form-control select2 required tgl_lahir'");?>
                                      </div>
                                        <input type="hidden" name="tgl_lahir" id="tgl_lahir" value="<?=$tgl_lahir?>" />
                                        </div><!-- end row-->
                                    </div><!-- end form group -->
                                </div><!-- end col -->
                            </div><!-- end row-->
                            
                            <script>
                                $(function(){
                                    $("#tgl_lahir").blur(function(){
                                        set_tanggal_lahir();
                                    });
                                    $(".tgl_lahir").change(function(){
                                        set_tanggal_lahir();	
                                    });
                                });
                                
                                function set_tanggal_lahir(){
                                    var tahun=$("#tahun_lahir").val();
                                    var bulan=$("#bulan_lahir").val();
                                    var tanggal=$("#tanggal_lahir").val();
                                    var tgl_lahir=tahun+"-"+bulan+"-"+tanggal;
                                    
                                    $("#tgl_lahir").val(tgl_lahir);
                                    
                                }
                            </script>
                            
                            
                            
                            
                            <div class="form-group">
                                <label for="nama">Umur</label>
                                <a href="#" class="btn-xs btn-primary pull-right" id="a_hitung_umur"><i class="fa fa-calendar"></i> Hitung Umur dari tanggal lahir</a>
                                <input class="form-control required" name="umur" id="umur" type="text" value="<?php echo $data["umur"];?>" />
                            </div><!-- end form -->
                            
                            
                            
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <? echo form_dropdown("jenis_kelamin",$lookup_jenis_kelamin,$data["jenis_kelamin"],"id='jenis_kelamin' class='form-control select2 required'");?>
                                    </div><!-- end form group -->
                                </div><!-- end col-->
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="golongan_darah">Golongan Darah</label>
                                            <? echo form_dropdown("golongan_darah",$lookup_empty+$this->data_lookup["golongan_darah"],$data["golongan_darah"],"id='golongan_darah' class='form-control select2 required'");?>
                                    </div><!-- /control-group category-->
                                </div><!-- end col -->
                            </div><!-- end row-->
                            
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Agama</label>
                                            <? echo form_dropdown("agama",$lookup_empty+$this->data_lookup["agama"],$data["agama"],"id='agama' class='form-control select2 required'");?>
                                    </div><!-- end form group -->
                                </div><!-- end col-->
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="golongan_darah">Status Nikah</label>
                                            <? echo form_dropdown("status_nikah",$lookup_empty+$this->data_lookup["status_kawin"],$data["status_nikah"],"id='status_nikah' class='form-control select2 required'");?>
                                    </div><!-- /control-group category-->
                                </div><!-- end col -->
                            </div><!-- end row-->
                            
                            
                            <div class="row">
                            <div class="col-md-6">
                             <div class="form-group">
                                <label for="jenis_pendidikan">Pendidikan Terakhir</label>
                                <? echo form_dropdown("pendidikan",$lookup_empty+$this->data_lookup["jenis_pendidikan"],$data["pendidikan"],"id='pendidikan' class='form-control select2 required'");?>                         
                            </div><!-- end form group-->
                            </div><!-- end col-->
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_pendidikan">Pekerjaan</label>
                                <? echo form_dropdown("pekerjaan",$lookup_empty+$this->data_lookup["kode_pekerjaan"],$data["pekerjaan"],"id='pekerjaan' class='form-control select2 required'");?>                         
                            </div><!-- end form group-->
                            </div><!-- end col-->
                            </div><!-- end row-->
                            
                            <div class="form-group">
                                    <label for="suku">Suku</label>                                
                                    <input name="suku" id="suku" class="form-control" value="<?=$data["suku"]?>" type="text">                    
                                </div>
                            
                            <div class="form-group">
                                <label for="jenis_pendidikan">Kewarganegaraan</label>
                                <? echo form_dropdown("warga_negara",$lookup_empty+$this->data_lookup["warga_negara"],$data["warga_negara"],"id='warga_negara' class='form-control select2 required'");?>                         
                            </div><!-- end form group-->
                          </div>
                        <!-- /.col -->
                        
                        
                        <div class="col-md-6">
                        <!--<h4 class="heading">Lokasi Pasien</h4>-->
                        
                        
                        
                        
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="input-xs form-control" id="alamat" rows="5" name="alamat" placeholder=""><?=$data["alamat"]?></textarea>
                            </div> 
                             
                             <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                        
                                            $arrPropinsi=m_lookup("propinsi2","kode_bps","nama");
                                            $arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
											$arrKab=array();
                                            if($data["kd_propinsi"]):
                                            $arrKab=m_lookup("kabupaten_kota","kode_bps","nama","kode_prop={$data["kd_propinsi"]} and kode_kab!='00'");
                                            endif;
                                            
                                        ?>
                                        <div class="form-group">
                                        <label>Propinsi</label>
                                        <?=form_dropdown("kd_propinsi",$arrPropinsi1,$data["kd_propinsi"],"id='kd_propinsi' class='form-control required'");?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label>Kabupaten</label>
                                        <div id="id_kabupaten_holder">
                                        <?=form_dropdown("kd_kabupaten",$arrKab,$data["kd_kabupaten"],"id='kd_kabupaten' class='form-control'");?>
                                        </div>
                                        </div>
                                    </div>
                                </div><!-- end row -->
                                
                               <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label>Kecamatan</label>
                                        <?php echo form_input('kecamatan',$data["kecamatan"],'class="form-control required"');?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label>Desa</label>
                                        <?php echo form_input('desa',$data["desa"],'class="form-control required"');?>
                                        </div>
                                    </div>
                                </div>-->
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label>RT/RW</label>
                                        <?php echo form_input('rt_rw',$data["rt_rw"],'class="form-control "');?>
                                        </div>
                                    </div><!-- end col -->
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label>Kode Pos</label>
                                        <?php echo form_input('kode_pos',$data["kode_pos"],'class="form-control"');?>
                                        </div>
                                    </div>
                                </div><!-- end row -->
                                
                                
                                <div class="form-group">
                         <label for="first_name">Nama Ayah:<span class="asterix">&nbsp;*</span></label>                    	 	<input name="ayah" value="<?=$data["ayah"]?>" id="ayah" class="form-control required" type="text">   
                </div>
                
                        <div class="form-group">
                            <label for="first_name">Nama Ibu:<span class="asterix">&nbsp;*</span></label>                    <input name="ibu" value="<?=$data["ibu"]?>" id="ibu" class="form-control required" type="text">   
                        </div>
                                
                                
                            
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->


<script language="javascript">
$(function(){
	$(".required").each(function(i){
		$(this).closest("div").find(".asterix").remove();
		$(this).closest("div").find("label").append("<span class='asterix'>&nbsp;*</span>");
   });	
});

$(function(){
	//$(".select2").select2();
	$("#kd_propinsi").select2({'placeholder':"--Pilih Propinsi--"});
	$("#kd_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
	$("#kd_wilayah").change(function(){
		var data_propinsi=<?=json_encode($data_propinsi)?>||"";
		var kd_propinsi=$(this).find(":selected").val();
		var id_propinsi=kd_propinsi.substr(0,2);
		$("#kd_wilayah_propinsi").val(id_propinsi);
		$("#kd_wilayah_propinsi_txt").val(data_propinsi[id_propinsi]);
	}).change();
	
	$("#kd_propinsi").change(function(){
   		var id_propinsi = $(this).val();
		var propinsi=$(this).find(":selected").text();
		console.log(propinsi);
		//search_location(propinsi);
		
		//var nm_propinsi = $("#id_propinsi option:selected").text();
		$("#id_kabupaten_holder").load("<?=base_url()?>lookup/wilayah/get_kab_kota2/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#kd_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
			//getgeoCode(nm_propinsi);
			/*
			$("#id_kabupaten").change(function(){
				var nm_address = nm_propinsi+" "+$("#id_kabupaten option:selected").text();
				getgeoCode(nm_address);
		   });*/
		   
		});
		
   });
   
   
   
});


</script>
<script>
	$(function(){
		$("#frm").validate();
		
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
		
		$(".group").click(function(){
			//$("#company").prop("disabled",$(this).data('org')==1 ? false: true);
			var use_org = $(this).data('org');
			$("#company").val(use_org);
			$("#company option").show();
			$("#company option").each(function(){
				if (!use_org) {
					$(this).val()!=0?$(this).hide():$(this).show();
				}
				else {
					$(this).val()!=0?$(this).show():$(this).hide();
				}
			});
		});
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		  checkboxClass: 'icheckbox_flat-green',
		  radioClass: 'iradio_flat-green'
		});
	})
</script>

<script>
	$("#a_hitung_umur").click(function(e){
		e.preventDefault();
		hitung_umur();	
	})
	
	function hitung_umur(){
		var dob = new Date($("#tgl_lahir").val());
        var today = new Date();
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        $('#umur').val(age);	
	}
</script>