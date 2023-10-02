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
	
	
?>
<section class="content-header">
  <h1>
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
    <li class="active">Add</li>
  </ol>
</section>


<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
        	<div class="box box-default">
                <div class="box-header with-border clearfix">
                	<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>add" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="Reset">
                        <i class="fa fa-remove"></i>
                    </a>	  
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <form id="frm" method="post" action="<?php echo $this->module;?>add">
                  <input type="hidden" name="act" id="act" value="create"/>
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
                            <label for="nama">Wilayah Adm.</label>
                            <?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["kd_wilayah"],"id='kd_wilayah' class='form-control select2 required'");?>
                            <input type="hidden" id="kd_wilayah_propinsi" name="kd_wilayah_propinsi" value="<?=$data["kd_wilayah_propinsi"]?>" />
                        </div><!-- end form group -->
                    	
                    
                    	<div class="form-group">
                            <label for="nama">Propinsi</label>
                            <input type="text" id="kd_wilayah_propinsi_txt" name="kd_wilayah_propinsi_txt" value="<?=$data_propinsi[$data["kd_wilayah_propinsi"]]?>" class="form-control" readonly="readonly" />
                    	</div><!-- end form group -->
                    </div><!-- end col 6-->
                  </div><!-- end row-->
                  <!-- END FIRST FORM-->
                  
                  <hr>
                  
                  <div class="row">
                    <div class="col-md-6">
                    	<div class="form-group">
                        	<?php
                            	$tgl_registrasi=$data["tgl_registrasi"]?$data["tgl_registrasi"]:date("Y-m-d H:i:s");
							?>
                        	<label for="nama">Tgl Registrasi</label>
                        	<div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" id="tgl_registrasi_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_registrasi))?>" placeholder="dd/mm/yyyy"/>
                                  <input type="hidden" id="tgl_registrasi" name="tgl_registrasi" value="<?=date("Y-m-d",strtotime($tgl_registrasi));?>" class="required" />
                            </div>
                        
                        </div>
                    
                    	<div class="form-group">
                          <label for="nama">No Rekam Medik</label>
                          <input class="form-control required" name="no_rekam_medis" id="no_rekam_medis" type="text" value="<?php echo $data["no_rekam_medis"];?>" />
                        </div>
                        
                        <div class="form-group">
                          <label for="nama">Nama</label>
                          <input class="form-control required" name="nama" id="nama" type="text" value="<?php echo $data["nama"];?>" />
                        </div><!-- end form group -->
                        
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
                        
                        <div class="form-group">
                        	<label for="nama">NIK</label>
                            <input class="form-control required" name="nik" id="nik" type="text" value="<?php echo $data["nik"];?>" />
                       </div><!-- end form -->
                        
                        
                        
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
                        
                         <div class="form-group">
                         	<label for="jenis_pendidikan">Pendidikan Terakhir</label>
                            <? echo form_dropdown("pendidikan",$lookup_empty+$this->data_lookup["jenis_pendidikan"],$data["pendidikan"],"id='pendidikan' class='form-control select2 required'");?>                         
                        </div><!-- end form group-->
                        
                        <div class="form-group">
                         	<label for="jenis_pendidikan">Pekerjaan</label>
                            <? echo form_dropdown("pekerjaan",$lookup_empty+$this->data_lookup["kode_pekerjaan"],$data["pekerjaan"],"id='pekerjaan' class='form-control select2 required'");?>                         
                        </div><!-- end form group-->
                        
                        <div class="form-group">
                         	<label for="jenis_pendidikan">Kewarganegaraan</label>
                            <? echo form_dropdown("warga_negara",$lookup_empty+$this->data_lookup["warga_negara"],$data["warga_negara"],"id='warga_negara' class='form-control select2 required'");?>                         
                        </div><!-- end form group-->
                        
                        
                     </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    
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
							</div>
							<div class="row">
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
							</div><!-- end row -->
                            
                            <div class="row">
								<div class="col-md-6">
									<div class="form-group">
									<label>RT/RW</label>
									<?php echo form_input('rt_rw',$data["rt_rw"],'class="form-control required"');?>
									</div>
                                </div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Kode Pos</label>
									<?php echo form_input('kode_pos',$data["kode_pos"],'class="form-control required"');?>
									</div>
								</div>
							</div><!-- end row -->
                    	
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                </form>
                </div>
               
                <!-- /.box-body -->
                <div class="box-footer well well-sm no-shadow">
                     <!--Username digunakan pada saat login.-->
                </div>
                
              </div>
        </div>
    </div>
</section>


<script language="javascript">
$(function(){
	//$(".select2").select2();
	$("#kd_propinsi").select2({'placeholder':"--Pilih Propinsi--"});
	$("#kd_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	$("#kd_wilayah").select2({'placeholder':"--Pilih Wilayah--"});
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
		//console.log(propinsi);
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

$(document).ready(function(){      
	$('#prov').change(function(){
		$.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
			$('#kab').html(obj);
		});
    });
	$("#previewplay").click(function(){
		$("#imgInpPlay").trigger("click");
	});
});
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '180px');
                //$('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
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