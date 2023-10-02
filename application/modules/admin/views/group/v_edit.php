<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
	$id=($this->encrypt_status==TRUE?encrypt($data['id']):$data['id'])
?>
<section class="content-header">
  <h1 class="hidden-xs">
    GROUP
    <small>EDIT</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
    <li class="active">Edit</li>
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
            <form id="frm" method="post" action="<?php echo $this->module;?>edit/<?=$id?>" enctype="multipart/form-data">
              <input type="hidden" name="act" id="act" value="update"/>
              <input type="hidden" name="id" value="<?=$id?>"/>
            
        	<div class="box box-widget">
            	<div class="box-header with-border">
                  <h3 class="box-title">EDIT GROUP</h3>
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
                                          <label for="exampleInputEmail1">GROUP</label>
                                          <input class="form-control required" id="name" name="name" type="text" value="<?php echo str_replace(" ".$data['tipe_wilayah'],"",$data['name']);?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 hidden">
                                          <div class="form-group">
                                         <label for="exampleInputEmail1">Tipe Organisasi</label>
                                          <? echo form_dropdown("tipe_wilayah",$this->lookup_tipe_wil,$data['tipe_wilayah'],"id='tipe' class='form-control'");?>                        
                                          </div>
                                    </div>
                                </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Deskripsi</label>
                                      <textarea class="form-control" name="description" style="height:200px"><?=$data['description']?></textarea>
                                    </div>
                                </div>
                                <!-- /.col -->
                              </div>
                              
                              </div>
                              <!-- end kolom kiri --> 
                              
                              
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
$(document).ready(function(){      
	$("#kecamatan").change(function(){
		var kd_prop=$("#propinsi option:selected").val()||$("#propinsi").val();
		var kd_kab=$("#kabupaten option:selected").val()||$("#kabupaten").val();
		var kd_kec=$("#kecamatan option:selected").val()||$("#kecamatan").val();
		$("#desa").html('<option>--loading--<option>');
		kd_prop=kd_prop?kd_prop:'x';
		$.get("common/service/lookup_desa/"+kd_prop+"/"+kd_kab+"/"+kd_kec,function(ret){
			$("#desa").html(ret);
		});
	});
	$("#desa").change(function(){
		var kd_prop=$("#propinsi option:selected").val()||$("#propinsi").val();
		var kd_kab=$("#kabupaten option:selected").val()||$("#kabupaten").val();
		var kd_kec=$("#kecamatan option:selected").val()||$("#kecamatan").val();
		var kd_desa=$("#desa option:selected").val()||$("#desa").val();
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