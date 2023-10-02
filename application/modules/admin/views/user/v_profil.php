<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
	$arrGroup2Wilayah=$this->lat_auth->groups('id','use_organization');
	$url_back =$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:$this->module;
?>
<section class="content-header">
  <h1 class="hidden-xs">
    PROFIL SAYA
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-check-square-o"></i> Profil Saya</li>
  </ol>
</section>
<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
        	<div class="content-toolbar">
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i> Simpan
                    </a>
            </div>
            <form id="frm" method="post" action="<?php echo $this->module;?>profil" enctype="multipart/form-data">
              <input type="hidden" name="act" id="act" value="update"/>
              <input type="hidden" name="active" value="1"/>
              <input type="hidden" name="id" value="<?=$this->encrypt_status==TRUE?encrypt($data['id']):$data['id']?>"/>
        	<div class="box box-widget">
            	<div class="box-header with-border">
                	<div class="row">
                      	<div class="col-md-6">
                          <label class="pull-right">
                              Status: <?php echo $data['active']?'Aktif':'Tidak aktif';?>
                          </label>
                          <h3 class="box-title">Username: <?php echo $data["username"];?></h3>
                        </div>
                    </div>
                </div>
                
                <div class="box-body">
                 <div class="row">
                    <div class="col-md-6">
                      <div class="panel panel-default hide">
                        <div class="panel-heading">Profil Berhasil Diubah: <span id="pv_num"></span></div>
                        <div class="panel-body" id="panel" style="max-height:100px; overflow:auto">
                        	<table class="table table-condensed">
                            </table>
                        </div>
                      </div>
                    </div>
                 </div>
                </div>
                <div class="box-body" id="submit_container">
                  <!-- row data -->
                      <div class="row">
                      	<!-- kolom kiri --> 
                      	<div class="col-md-6">
                              <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Email</label>
                                          <input class="form-control" id="email" name="email" type="text" value="<?php echo $data["email"];?>" />
                                        </div>
                                    </div>
                                </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Nama Lengkap</label>
                                      <input class="form-control" id="nama" name="first_name" type="text" value="<?php echo $data["first_name"];?>" />
                                    </div>
                                </div>
                                <!-- /.col -->
                              </div>
                              <br />
                              <div class="help-block">Isi Password & Confirm Password untuk mengganti</div>
                              <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="hscode" class="control-label">Password</label>
                                    <div class="controls">
                                        <input type="password" id="password" name="password" class="form-control" />
                                        
                                    </div>
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="hscode" class="control-label">Confirm Password</label>
                                    <div class="controls">
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" />
                                        
                                    </div>
                                </div>
                              </div>
                              
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Profil Singkat</label>
                                      <textarea class="form-control" name="profil" style="height:200px"><?=$data['profil']?></textarea>
                                    </div>
                                </div>
                                <!-- /.col -->
                              </div>
                              
                              </div>
                              <!-- end kolom kiri --> 
                              
                              <!-- kolom tengah -->
                              
                              <!-- kolom kanan -->
                           	  <!--<div class="col-md-3">
                               		<div class="form-group">
                                    <label>Profile Photo</label><br />
                                    <img id="previewplay" src="<?=$this->config->item("dir_profil_pasangan").$data['foto']?>" class="img-thumbnail" style="cursor:pointer" height="180" width="180">
                                    <input name="image_name" id="imgInpPlay" class="form-control hidden" style="width:180px;padding:0!important" type="file">
                                    </div>
                              </div>  -->
                              <!-- end kolom kanan --> 
                              
                           </div>
                           
                         </div>
                      <!-- end row data -->
                  
                
                <div class="box-footer hidden">
                	<div class="row">
                        <div class="col-md-6">
                              <div class="form-actions">
                                    <button type="submit" name="save" value="Simpan" class="btn btn-primary btn-block">Simpan</button>
                              </div>
                         </div>
                     </div>
                </div>
        </div>
        </form>
    </div>
</section>
<script language="javascript">
var kd_prop=$("#propinsi option:selected").val()||$("#propinsi").val();
var kd_kab=$("#kabupaten option:selected").val()||$("#kabupaten").val();
var kd_kec=$("#kecamatan option:selected").val()||$("#kecamatan").val();
var kd_desa=$("#desa option:selected").val()||$("#desa").val();
var group2wil=<?=cek_array($arrGroup2Wilayah)?json_encode($arrGroup2Wilayah):'false'?>;
var wil=0;
$(document).ready(function(){   
	$("#group_id").change(function(){
		var tipe=$("#group_id option:selected").val()||$("#group_id").val();
		wil = group2wil[tipe];
		if (wil==2) {
			$("#section_kec").addClass("hidden");
			$("#kecamatan").val($("#kecamatan option").eq(0).val()).attr("disabled",true);

			$("#section_desa").addClass("hidden");
			$("#desa").val($("#desa option").eq(0).val()).attr("disabled",true);
		}
		else if (wil==3) {
			$("#section_kec").removeClass("hidden");
			$("#kecamatan").val(kd_kec).attr("disabled",false);
			$("#kecamatan option").eq(0).attr("disabled","disabled");

			$("#section_desa").addClass("hidden");
			$("#desa").val($("#desa option").eq(0).val()).attr("disabled",true);
		}
		else if (wil==4) {
			$("#section_kec").removeClass("hidden");
			$("#kecamatan").val(kd_kec).attr("disabled",false);
			$("#kecamatan option").eq(0).attr("disabled","disabled");
			$("#kecamatan option").trigger("change");
		}
		else {
			$("#section_kec").removeClass("hidden");
			$("#kecamatan").attr("disabled",false);
			$("#kecamatan option").eq(0).attr("disabled",false);

			$("#section_desa").removeClass("hidden");
			$("#desa").attr("disabled",false);
			$("#desa option").eq(0).attr("disabled",false);
		}
	}).change();   
	
	$("#kecamatan").change(function(){
		$("#desa").html('<option>--loading--<option>');
		var kd_prop=$("#propinsi option:selected").val()||$("#propinsi").val();
		var kd_kab=$("#kabupaten option:selected").val()||$("#kabupaten").val();
		var kd_kec=$("#kecamatan option:selected").val()||$("#kecamatan").val();

		kd_prop=kd_prop?kd_prop:'x';
		$.get("common/service/lookup_desa/"+kd_prop+"/"+kd_kab+"/"+kd_kec,function(ret){
			$("#desa").html(ret);
			if (wil==4) {
				$("#section_desa").removeClass("hidden");
				$("#desa").val(kd_desa).attr("disabled",false);
				$("#desa option").eq(1).attr("selected","selected");
				$("#desa option").eq(0).attr("disabled","disabled");
			}
		});
	}).change();  
	
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
		
		tanggal = $('#tanggal_selector').datepicker({
		format:"dd/mm/yyyy"
		}).on('changeDate', function(ev){
			var newDate = new Date(ev.date);
			$("#tanggal").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
			$('#tanggal_selector').datepicker('hide');
		}).data('datepicker');
		
		$('#tanggal_selector').on("keyup",function(){
			setValDate(tanggal,"#tanggal");
		});
	
		function setValDate(dp,target,sender) {
			if (sender) {
				if ($(sender).val().length<8) {
					$(target).val("");
					return;
				}
			}
			var newDate = new Date(dp.date);
			$(target).val(newDate.getFullYear()+"/"+(newDate.getMonth()+1)+"/"+newDate.getDate());
		};
	})
</script>