<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
	
?>
<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_jenis_instansi[""]="--Pilih--";
	$lookup_jenis_instansi=$lookup_empty+lookup("m_jenis_instansi","kd_jenis_instansi","ur_jenis_instansi","","order by order_num");
	
	$lookup_jenis_kelamin=$lookup_empty+lookup("m_lookup","kd_lookup","ur_lookup","lookup_category='jenis_kelamin'"," order by order_num");
	
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
                    <a class="btn btn-white" href="<?php echo $this->module?>edit/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="Reset">
                        <i class="fa fa-circle-o"></i>
                    </a>	  
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <form id="frm" method="post" action="<?php echo $this->module;?>add">
                  <input type="hidden" name="act" id="act" value="create"/>
                  <div class="row">
                    <div class="col-md-6">
                      	<div class="form-group">
                          <label for="nama">Nama</label>
                          <input class="form-control required" name="nama" id="nama" type="text" value="<?php echo $data["nama"];?>" />
                        </div>
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
                                	<input type="text" name="tgl_lahir" id="tgl_lahir" value="<?=$tgl_lahir?>" />
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
        					<label for="alamat">Alamat</label>
							<textarea class="input-xs form-control" id="alamat" rows="5" name="alamat" placeholder=""><?=$data["alamat"]?></textarea>
            			</div> 
                         
                         <div class="form-group">
                            <label for="category">Tipe</label>
                            
                                <? echo form_dropdown("jenis_instansi",$lookup_jenis_instansi,$data["jenis_instansi"],"id='jenis_instansi' class='form-control select2'");?>
                        </div><!-- /control-group category-->
                        
                        
                        
                        
                        <div class="row">
								<div class="col-md-6">
									<?php
									
										$arrPropinsi=m_lookup("propinsi2","kode_bps","nama");
										$arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
										$arrKab=array();
										if($data["id_propinsi"]):
										$arrKab=m_lookup("kabupaten_kota","kode_bps","nama","kode_prop={$data["id_propinsi"]} and kode_kab!='00'");
										endif;
										
										
									?>
									<div class="form-group">
									<label>Propinsi</label>
									<?=form_dropdown("id_propinsi",$arrPropinsi1,$data["id_propinsi"],"id='id_propinsi' class='form-control required'");?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Kabupaten</label>
									<div id="id_kabupaten_holder">
									<?=form_dropdown("id_kabupaten",$arrKab,$data["id_kabupaten"],"id='id_kabupaten' class='form-control'");?>
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
							</div>
                        
                        
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    
                    	&nbsp;
                    </div>  
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                  <div class="row hidden">
                    <div class="col-md-6">
                    	<div class="form-actions">
                            <!--<button type="submit" class="btn btn-primary">Save changes</button>-->
                            <button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
                        </div>
                    </div>
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
	$("#id_propinsi").select2({'placeholder':"--Pilih Propinsi--"});
	$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
	$("#id_propinsi").change(function(){
   		var id_propinsi = $(this).val();
		var propinsi=$(this).find(":selected").text();
		//console.log(propinsi);
		//search_location(propinsi);
		
		//var nm_propinsi = $("#id_propinsi option:selected").text();
		$("#id_kabupaten_holder").load("<?=base_url()?>lookup/wilayah/get_kab_kota/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#id_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
	
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