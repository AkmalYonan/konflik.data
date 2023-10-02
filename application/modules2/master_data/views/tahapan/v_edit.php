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
				<a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
					<i class="fa fa-check"></i>
				</a>
				<a class="btn btn-white btn-delete" href="<?php echo $this->module?>" data-toggle='tooltip' title="Cancel/Back To List">
					<i class="fa fa-remove"></i>
				</a>
            </div>
        	<div class="box box-widget">
                <div class="box-body">
                <form id="frm" method="post" action="<?php echo $this->module;?>edit/<?php echo $id;?>">
					<input type="hidden" name="act" id="act" value="update"/>
					<input type="hidden" name="idx" id="id" value="<?=$data['idx']?>"/>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="kode_Konflik">Kode Tahapan</label>
								<input class="form-control required" readonly name="kode" type="text" style="width:50%" value="<?=$data['kode']?>" />
							</div>
							<div class="form-group">
								<label for="ur_Konflik">Nama Tahapan</label>
								<input class="form-control required" name="uraian" placeholder="" type="text" value="<?=$data['uraian']?>" >
							</div>
							<div class="form-group">
								<label for="status_Konflik">Status</label>
								<br />
								<input type="radio" name="status" value="1" <?=($data['status']==1)?"checked='checked'":""?> />&nbsp;Aktif<br />
								<input type="radio" name="status" value="0" <?=($data['status']==0)?"checked='checked'":""?> />&nbsp;Tidak Aktif
							</div>
						</div>
					</div>
                    <!-- /.col -->
                    <div class="col-md-6">
                      	<!-- KOSONG -->
                    </div>
                    <!-- /.col -->
                </form>
				</div>
                  <!-- /.row -->
			</div>
        </div>
    </div>
</section>
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
