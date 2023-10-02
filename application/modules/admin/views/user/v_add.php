<?php
	$arrGroup=$this->lat_auth->groups('id','name');
	$arrGroup2Org=$this->lat_auth->groups('id','use_organization');
	$arrGroup2Wil=$this->lat_auth->groups('id','tipe_wilayah');
?>
<section class="content-header">
  <h1 class="hidden-xs">
    USER
    <small>ADD</small>
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
        	<div class="content-toolbar">
                	<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>add/" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i> Save
                    </a>
            </div>
            <form id="frm" method="post" action="<?php echo $this->module;?>add" enctype="multipart/form-data">
              <input type="hidden" name="act" id="act" value="create"/>
              <input type="hidden" name="status" id="act" value="in"/>
            
        	<div class="box box-widget">
            	<div class="box-header with-border">
                  <h3 class="box-title">TAMBAH USER</h3>
                </div>
                
                <div class="box-body">
                 <div class="row">
                    <div class="col-md-6">
                      <div class="panel panel-default hide">
                        <div class="panel-heading">Data Berhasil Ditambahkan: <span id="pv_num"></span></div>
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
                               		<div class="col-md-6">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Username</label>
                                          <label class="pull-right">
                                              <input type="checkbox" name="active" class="flat-green" <?php echo $data['active']?'checked':'';?>>
                                              Active
                                          </label>
                                          <input class="form-control required" id="username" name="username" type="text" value="<?php echo $data["kontak_hp"];?>" />
                                          <span class="help-block">* Digunakan untuk login aplikasi.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Email</label>
                                          <input class="form-control" id="email" name="email" type="text" value="<?php echo $data["kontak_email"];?>" />
                                        </div>
                                    </div>
                                </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Nama Lengkap</label>
                                      <input class="form-control required" id="nama" name="first_name" type="text" value="<?php echo $data["nama"];?>" />
                                    </div>
                                </div>
                                <!-- /.col -->
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Nomor Induk</label>
                                      <input class="form-control required" id="nomor_induk" name="nomor_induk" type="text" value="<?php echo $data["nomor_induk"];?>" />
                                    </div>
                                </div>
                                <!-- /.col -->
                              </div>
							  
                              <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="hscode" class="control-label">Password</label>
                                    <div class="controls">
                                        <input type="password" id="password" name="password" class="form-control" />
                                        
                                    </div><!-- /control -->
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="hscode" class="control-label">Confirm Password</label>
                                    <div class="controls">
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" equalto="#password" />
                                        
                                    </div><!-- /control -->
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
                           	  <div class="col-md-3">
                                <div class="row">
                               		<div class="col-md-12">
                                        <div class="form-group">
                                            <label>Group</label>
                                            <?php if ($this->lat_auth->multiple_groups): ?>
                                            <?php echo form_multiselect("group_id[]",$arrGroup,$data["groups_ids"],"id='group_id' class='form-control'");?>
                                            <?php else: ?>
                                            <?php echo form_dropdown("group_id[]",$arrGroup,$data["groups_ids"][0],"id='group_id' class='form-control'");?>                        
                                            <?php endif;?>   
                                            <span class="help-block">&nbsp;</span>                   
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row">
                               		<div class="col-md-12">
                                    	<div class="form-group">
                                        <label>Propinsi</label>
                                        <? echo form_dropdown("kd_prop",false,false,"id='kd_prop' class='form-control'");?>  
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                               		<div class="col-md-12">
                                    	<div class="form-group">
                                        <label>Kabupaten</label>
                                        <? echo form_dropdown("kd_kab",false,false,"id='kd_kab' class='form-control'");?>  
                                      </div>
                                    </div>
                                </div>
                              
                                
                                <!--<div class="row">
                               		<div class="col-md-12">
                                    	<div class="form-group">
                                        <label>ORGANISASI</label>
                                        <? echo form_dropdown("kd_org",false,false,"id='kd_org' class='form-control'");?>  
                                        </div>
                                        <input type="hidden" name="kd_prop" id="kd_prop" />
                                        <input type="hidden" name="kd_kab" id="kd_kab" />
                                        <input type="hidden" name="tipe_instansi" id="tipe_instansi" />
                                    </div>
                                </div>-->
                              	
                              </div>
                              <!-- end kolom tengah --> 
                              
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
                  
                
                <div class="box-footer">
                	<div class="row hidden">
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

<?=loadFunction("validate");?>

<script language="javascript">
var kd_prop=$("#propinsi option:selected").val()||$("#propinsi").val();
var kd_kab=$("#kabupaten option:selected").val()||$("#kabupaten").val();
var group2org=<?=cek_array($arrGroup2Org)?json_encode($arrGroup2Org):'false'?>;
var group2wil=<?=cek_array($arrGroup2Wil)?json_encode($arrGroup2Wil):'false'?>;
$(document).ready(function(){      
	
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

<script>
var group2org=<?=cek_array($arrGroup2Org)?json_encode($arrGroup2Org):'false'?>;

$(document).ready(function(){      
	
	$("#group_id").change(function(){
		var tipe=$("#group_id option:selected").val()||$("#group_id").val();
		var tipe_wil	=	group2wil[tipe];
		
		var kd_prop=$("#kd_prop option:selected").val()||0;
		var kd_kab=$("#kd_kab option:selected").val()||0;
		
		if(tipe_wil=="Provinsi"){
			$("#kd_prop").html('').attr("disabled",false);
			$("#kd_kab").html('').attr("disabled",true);
			$.get("common/service/lookup_propinsi/"+kd_prop+"/"+kd_prop,function(ret){
				$("#kd_prop").html(ret).change();
			});
		}else if(tipe_wil=="Kabupaten/Kota"){
			$("#kd_prop").html('').attr("disabled",false);
			$("#kd_kab").html('').attr("disabled",false);
			$.get("common/service/lookup_propinsi/"+kd_prop+"/"+kd_prop,function(ret){
				$("#kd_prop").html(ret).change();
			});
		}else{
			$("#kd_prop").html('').attr("disabled",true);
			$("#kd_kab").html('').attr("disabled",true);
		}
		
	});	
	
	$("#kd_prop").change(function(){
		var kd_prop=$("#kd_prop option:selected").val()||0;
		$.get("common/service/lookup_kabupaten/"+kd_prop+"/"+kd_prop,function(ret){
			$("#kd_kab").html(ret).change();
		});
	});
});

</script>