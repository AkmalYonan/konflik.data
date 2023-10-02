<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<!--<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>-->
<script type="text/javascript" src="assets/js/plugin/ckeditor4.4.2/ckeditor.js"></script>
<script type="text/javascript" src="assets/js/plugin/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<!-- Place inside the <head> of your HTML -->
<style>
@import url(http://fonts.googleapis.com/css?family=Monda:400,700);
@import url(http://fonts.googleapis.com/css?family=Open+Sans);
.carousel-caption {
  background-color: transparent;
  position: absolute;
  top:0;
  left:0;
  max-width: 350px;
  padding: 0 5px;
  margin-top: 50px;
  margin-left:20px;
}
.carousel-caption h1,
.carousel-caption h2,
.carousel-caption h3,
.carousel-caption .lead {
  font-family:"Monda";
  margin: 0px;
  line-height: 1.25;
  color: #fff;
  text-shadow: 0 1px 1px rgba(0,0,0,.4);
}
.carousel-caption .btn {
  margin-top: 10px;
}
</style>

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
                <form id="frm" method="post" action="<?php echo $this->module;?>add" enctype="multipart/form-data">
                  <input type="hidden" name="act" id="act" value="create"/>
                  <div class="row">
                  <div class="col-md-12">
                  <?=$this->load->view("frm_edit");?>
                  </div></div>
                  
                  
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