<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<section class="content-header">
  <h1>
    Account Manager
    <small>User</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> Account Manager</li>
    <li><a href="<?php echo $this->module?>">User</a></li>
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
                    <a class="btn btn-white btn-delete" href="<?php echo $this->module?>" data-toggle='tooltip' title="Delete">
                        <i class="fa fa-remove"></i>
                    </a>	  
            </div>
        	<div class="box box-widget">
            	<div class="box-header with-border">
                  <h3 class="box-title">Data User</h3>
                </div>
                <div class="box-body">
                <form id="frm" method="post" action="<?php echo $this->module;?>edit/<?php echo $id;?>">
                  <input type="hidden" name="act" id="act" value="update"/>
                  <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
                  <div class="row">
                    <div class="col-md-6">
                      	<div class="form-group">
                          <label for="exampleInputEmail1">Username</label>
                          <label class="pull-right">
                              <input type="checkbox" name="active" class="flat-red" <?php echo $data['active']?'checked':'';?>>
                              Active
                          </label>
                          <input class="form-control required" name="username" type="text" value="<?php echo $data["username"];?>" />
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email</label>
                          <input class="form-control required" name="email" placeholder="Enter email" type="email" value="<?php echo $data["email"];?>">
                        </div>
                        <div class="form-group">
                            <label for="nm_latin" class="control-label">Firstname</label>
                            <div class="controls">
                                <input type="text" id="first_name" name="first_name" class="form-control required" value="<?php echo $data["first_name"];?>" />
                                
                            </div><!-- /control -->
                        </div>
                        <div class="form-group">
                            <label for="hscode" class="control-label">Lastname</label>
                            <div class="controls">
                                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $data["last_name"];?>" />
                                
                            </div><!-- /control -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Group</label>
                        <?php if ($this->lat_auth->multiple_groups): ?>
                        <?php echo form_multiselect("group_id[]",$arrGroup,$data["groups_ids"],"id='group_id' class='form-control select2 select2-hidden-accessible'");?>
                      	<?php else: ?>
                        <?php echo form_dropdown("group_id[]",$arrGroup,$data["groups_ids"][0],"id='group_id' class='form-control select2 select2-hidden-accessible'");?>                        
                        <?php endif;?>
                      </div>
                      <div class="form-group">
                        
                      </div>
        
                      <!-- /.form-group -->
                      <div class="form-group">
                        <label>Profile Photo</label><br />
                        <img id="previewplay" src="assets/images/noimg.jpg" class="profile-user-img img-circle" style="cursor:pointer;width:160px; height:160px">
                        <input name="image_name" id="imgInpPlay" class="form-control hidden" type="file">
                    	</div>
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
                </div>
                </form>
                <!-- /.box-body -->
                <div class="box-footer well well-sm no-shadow">
                     Username digunakan pada saat login.
                </div>
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