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
<?php
	$lookup_status[0]="Baru/Draft"; //menunggu verifikasi
	$lookup_status[1]="Sedang dalam proses"; //menunggu hasil verifikasi
	$lookup_status[2]="Selesai"; //menunggu rekam medik
	$lookup_status[9]="Ditolak";  
	
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	$lookup_proses_berikutnya["RG"]="Registrasi";
	//$lookup_proses_berikutnya["SS"]="Assesment";
	
	$lookup_empty=array(""=>"--pilih--");
	$lookup_bnnp=$lookup_empty+lookup("m_org","kd_org","nama","tipe_org='BNNP'","order by idx");
	$lookup_balai=$lookup_empty+lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
	$lookup_keluarga=$lookup_empty+$this->data_lookup["hubungan_keluarga"];
	
	
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
                	<a class="btn btn-white" href="<?php echo $this->module?>add" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>add" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white hidden" href="<?php echo $this->module?>" data-toggle='tooltip' title="Reset">
                        <i class="fa fa-remove"></i>
                    </a>	  
                </div>
                <!-- /.box-header -->
                <div class="box-body">
				<h4 class="heading">Tambah Data Pasien Baru</h4>
                <form id="frm" method="post" action="<?php echo $this->module;?>add_pasien_baru">
                  <input type="hidden" name="act" id="act" value="create"/>

                  <?=$this->load->view("v_part_form_wilayah_sumber_pasien2")?>
                  <div class="formSep"></div>
				  <?=$this->load->view("v_part_form_data_pasien2")?>
                  
                  <!--<h4 class="heading">Disclaimer</h4>-->
				  
					<div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Status Registrasi?</label>
                        <?=form_dropdown("status_check_doc",$lookup_status,
                                $data["status_check_doc"],
                                "id='status_check_doc' 
                                class='form-control select2 required'");?>
                    </div><!-- end form-->
                    
                    <div class="form-group status_proses">
                        <label for="nama">Proses Berikutnya?</label>
                        <?=form_dropdown("status_proses",$lookup_proses_berikutnya,
                                $data["status_proses"],
                                "id='status_cek_proses' 
                                class='form-control select2 required'");?>
                    </div><!-- end form-->
					
					<div class="form-group tgl_asses hide">
                      <label>Tanggal Rencana Assesment<span class="asterix">&nbsp;*</span></label>
						<div class="input-group" >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                      <input type="text" style="width:220px;" id="tgl_assestment_selector" class="form-control input-date required" value="<?=date("d/m/Y",strtotime(date('Y')))?>" placeholder="dd/mm/yyyy"/>
                                      <input type="hidden" id="tgl_assestment" name="tgl_assestment" value="<?=date("Y-m-d",strtotime(date('Y')));?>" class="required" />
                        </div>
					</div><!-- end form-->
					</div>

					
					</div><!-- end row-->
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
	$("#status_check_doc").change(function(){
		if($(this).find(":selected").val()==2){
			$("div.status_proses").show();
			$("div.tgl_asses").show();
		}else{
			$("div.status_proses").hide();
			$("div.tgl_asses").hide();
		}
	}).change();	
});

$(function(){
		$("#status_cek_proses").change(function(){
			if($(this).val()=='SS'){
				$("div.tgl_asses").hide();
			}else{
				$("div.tgl_asses").show();
			}
		}).change();
		
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
</script>
<script>
$(document).ready(function(){
	
	var jns_org	=	'<?=$data['jns_org']?>';
	
	if(jns_org){
		if(jns_org==1){
			$(".bnnp").removeClass("hide");
			$(".bnnk").addClass("hide");
			$(".balai").addClass("hide");
			
			
			$("#kd_bnnp").prop("disabled",false);
			$("#kd_bnnk").prop("disabled",true);
			$("#kd_balai").prop("disabled",true);
		}else if(jns_org==2){
			$(".bnnp").addClass("hide");
			$(".bnnk").addClass("hide");
			$(".balai").removeClass("hide");
			
			$("#kd_bnnp").prop("disabled",true);
			$("#kd_bnnk").prop("disabled",true);
			$("#kd_balai").prop("disabled",false);
		}else if(jns_org==3){
			$(".bnnp").addClass("hide");
			$(".bnnk").removeClass("hide");
			$(".balai").addClass("hide");
			
			$("#kd_bnnp").prop("disabled",true);
			$("#kd_bnnk").prop("disabled",false);
			$("#kd_balai").prop("disabled",true);
		}
	}else{
		
		$(".bnnp").removeClass("hide");
		$(".bnnk").addClass("hide");
		$(".balai").addClass("hide");
			
			
		$("#kd_bnnp").prop("disabled",false);
		$("#kd_bnnk").prop("disabled",true);
		$("#kd_balai").prop("disabled",true);
		
	}
	
	$(".cek_radio").on("change",function(){
	
		var val	=	$(this).val();
		
		if(val==1){
			$(".bnnp").removeClass("hide");
			$(".bnnk").addClass("hide");
			$(".balai").addClass("hide");
			
			
			$("#kd_bnnp").prop("disabled",false);
			$("#kd_bnnk").prop("disabled",true);
			$("#kd_balai").prop("disabled",true);
		}else if(val==2){
			$(".bnnp").addClass("hide");
			$(".bnnk").addClass("hide");
			$(".balai").removeClass("hide");
			
			$("#kd_bnnp").prop("disabled",true);
			$("#kd_bnnk").prop("disabled",true);
			$("#kd_balai").prop("disabled",false);
		}else if(val==3){
			$(".bnnp").addClass("hide");
			$(".bnnk").removeClass("hide");
			$(".balai").addClass("hide");
			
			$("#kd_bnnp").prop("disabled",true);
			$("#kd_bnnk").prop("disabled",false);
			$("#kd_balai").prop("disabled",true);
		}
	
	});

});
</script>