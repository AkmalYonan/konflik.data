<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
	$id=($this->encrypt_status==TRUE?encrypt($data['id']):$data['id'])
?>
<section class="content-header">
  <h1 class="hidden-xs">
    GROUP
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
              <!--<input type="hidden" name="status" value="1"/>-->
              <input type="hidden" name="id" value="<?=$id?>"/>
            
        	<div class="box box-widget">
            	<!--<div class="box-header with-border">
                  <h3 class="box-title">EDIT GROUP</h3>
                </div>-->
                
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
                                          <input class="form-control required" id="name" name="name" type="text" value="<?php echo $data["name"];?>" />
                                        </div>
                                    </div>
                              		<div class="col-md-6 hidden">
                                          <div class="form-group">
                                         <label for="exampleInputEmail1">Wilayah Organisasi</label>
                                          <? echo form_dropdown("tipe_wilayah",$this->lookup_tipe_wil,false,"id='tipe' class='form-control'");?>
                                          </div>
                                    </div>
                               </div>
							   <!--
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
                                        <?=form_dropdown("kd_propinsi",$arrPropinsi1,$data["kd_propinsi"],"id='kd_propinsi' class='form-control'");?>
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
								-->
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
$(function(){
	$(".required").each(function(i){
		$(this).closest("div").find(".asterix").remove();
		$(this).closest("div").find("label").append("<span class='asterix'>&nbsp;*</span>");
   });	
});

$(function(){
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
		$("#id_kabupaten_holder").load("<?=base_url()?>lookup/wilayah/get_kab_kota2/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#kd_kabupaten").select2({'placeholder':"--Pilih Kabupaten--"});
		});		
   });
   
   
   
});


</script>