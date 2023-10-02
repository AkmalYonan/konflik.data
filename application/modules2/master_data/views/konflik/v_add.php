<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
?>
<section class="content-header">
	<h1>
		<?=$this->parent_module_title?>
		<small><?=$this->module_title?></small>
	</h1>
	<ol class="breadcrumb">
		<li><i class="fa fa-puzzle-piece"></i> <?=$this->parent_module_title?></li>
		<li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
		<li class="active">Tambah</li>
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
                        <i class="fa fa-circle-o"></i>
                    </a>	  
                </div>
                <!-- /.box-header -->
                <div class="box-body">
					<form id="frm" method="post" action="<?php echo $this->module;?>add">
					<input type="hidden" name="act" id="act" value="create"/>
					<div class="row">
						<div class="col-md-6">
							<!--<div class="form-group">
								<label for="kode_Konflik">Kode Konflik</label>
								<input class="form-control required" name="kode" type="text" style="width:50%" />
							</div>-->
							<div class="form-group">
								<label for="sektor">Sektor</label>
								<select name="sektor_id" class="form-control">
									<? foreach($sektor as $k=>$v){?>
										<option value="<?=$v['kode']?>"><?=$v['uraian']?></option>
									<? }?>
									
								</select>
							</div>
							
							<div class="form-group">
								<label for="ur_Konflik">Nama Konflik</label>
								<input class="form-control required" name="uraian" placeholder="" type="text" >
							</div>
							<div class="form-group">
								<label for="status_Konflik">Status</label>
								<br />
								<input type="radio" name="status" value="1" checked="checked" />&nbsp;Aktif<br />
								<input type="radio" name="status" value="0" />&nbsp;Tidak Aktif
							</div>
                            <div class="form-group">
								<label for="ur_sektor">Urutan</label>
								<input class="form-control required" name="order_num" style="width:50px"  placeholder="" type="text" >
							</div>
						</div>
						<!-- /.col -->
					<div class="col-md-6">
                    </div>  
                    <!-- /.col -->
				</div>
					<!-- /.row -->
				<div class="row hidden">
                    <div class="col-md-6">
                    	<div class="form-actions">
                            <button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
                        </div>
                    </div>
                  </div>
                </div>
                </form>
                <!-- /.box-body -->
              </div>
        </div>
    </div>
</section>
<script language="javascript">
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
