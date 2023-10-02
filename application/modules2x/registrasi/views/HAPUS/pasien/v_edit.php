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
	$lookup_status[9]="DiTolak";  
	
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	
	$lookup_proses_berikutnya["RG"]="Registrasi";
	$lookup_proses_berikutnya["SS"]="Assesment";
	
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
                    
                    <a class="btn btn-white" href="<?php echo $this->module?>edit/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>view/<?php echo $id;?>" data-toggle='tooltip' title="View Pasien"><i class="fa fa-search"></i>
                    </a>
                    &nbsp;<span style="color:#EEE;font-size:22px">|</span>&nbsp;
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white btn-delete" href="<?php echo $this->module?>" data-toggle='tooltip' title="Cancel/Back To List">
                        <i class="fa fa-remove"></i>
                    </a>	  
            </div><!-- end content toolbar -->
            
            <div class="box box-widget">
            	<!--<div class="box-header with-border">
                  <h3 class="box-title">Data User</h3>
                </div>-->
                <div class="box-body">
                    <form id="frm" method="post" action="<?php echo $this->module;?>edit/<?php echo $id;?>">
                      	<input type="hidden" name="act" id="act" value="update"/>
                      	<input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
						
						<?=$this->load->view("common_view/pasien/v_part_form_wilayah_sumber_pasien")?>
                  		
                        <div class="formSep"></div>
                        
                        <!--
                        <div class="pull-right" style="margin-right:20px">
                        	<img src="assets/images/pic.jpg" style="border: 1px solid #ddd;border-radius: 2px;width: 100px;height: 100px;">
                        </div>
                        <-->    
                        
                        <?=$this->load->view("common_view/pasien/v_part_form_data_pasien")?> 
                      
                        <? //=$this->load->view("v_riwayat_pasien");?>
                      
                    <h4 class="heading">Konfirmasi</h4>
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
					
					<div class="form-group tgl_asses">
                      <label>Tanggal Rencana Assesment<span class="asterix">&nbsp;*</span></label>
						<div class="input-group" >
									  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                      <input type="text" style="width:220px;" id="tgl_assestment_selector" class="form-control input-date required" value="<?=date("d/m/Y",strtotime(date('Y')))?>" placeholder="dd/mm/yyyy"/>
                                      <input type="hidden" id="tgl_assestment" name="tgl_assestment" value="<?=date("Y-m-d",strtotime(date('Y')));?>" class="required" />
                        </div>
					</div><!-- end form-->
                    </div></div><!-- end row-->
                   
                   <h4 class="heading">Foto Pasien</h4>
                   <div class="row">
                   <div class="col-md-6">
				   		<?=$this->load->view("v_take_picture2");?>
                        <div class="formSep"></div>
                   		<?=$this->load->view("v_list_foto");?>
                   </div>
                   <div class="col-md-6">
                   		
                   </div><!-- end col-->
                   </div><!-- end row-->
                   </form>
                    
                   
                    
                <!-- /.box-body -->
                <div class="box-footer well well-sm no-shadow">
                     <!--Username digunakan pada saat login.-->
                     &nbsp;
                </div>
                
              </div>
        </div>
    </div></div>
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
			if($(this).find(":selected").val()=='SS'){
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
<script>
$(document).ready(function(){
	
	var jns_org	=	'<?=$data['jns_org']?>';
	
	if(jns_org==1){
		$(".bnnp").removeClass("hide");
		$(".balai").addClass("hide");
		$("#kd_bnn").prop("disabled",false);
		$("#kd_balai").prop("disabled",true);
	}else{
		$(".bnnp").addClass("hide");
		$(".balai").removeClass("hide");
		$("#kd_bnn").val("disabled",true);
		$("#kd_balai").prop("disabled",false);
	}
	
	$(".cek_radio").on("change",function(){
	
		var val	=	$(this).val();
		
		if(val==1){
			$(".bnnp").removeClass("hide");
			$(".balai").addClass("hide");
			$("#kd_bnn").prop("disabled",false);
			$("#kd_balai").prop("disabled",true);
		}else{
			$(".bnnp").addClass("hide");
			$(".balai").removeClass("hide");
			$("#kd_bnn").val("disabled",true);
			$("#kd_balai").prop("disabled",false);
		}
	
	});

});
</script>