<?php 
	$arrGroup=$this->lauth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; 
?>
<section class="content-header">
  <h1>
    Account Manager
    <small>User</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Account Manager</li>
    <li class="active">Delete User</li>
  </ol>
</section>
<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<div class="box box-default">
                <div class="box-header with-border clearfix">
                	<a class="btn btn-default" href="<?php echo $this->module?>">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-default" href="<?php echo $this->module?>edit/<?php echo $id;?>">
                        <i class="fa fa-pencil"></i>
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                
                <form id="frm" method="post" action="<?php echo $this->module;?>delete/<?php echo $id;?>">
                  <input type="hidden" name="act" id="act" value="delete"/>
                  <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
                  <input type="hidden" name="username" value="<?php echo $data["username"];?>"/>
                  <input type="hidden" name="email" value="<?php echo $data["email"];?>"/>
                  <div class="row">
                    <div class="col-md-6">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                          
                              <table class="table table-bordered">
                                <tbody>
                                <tr>
                                  <td width="90">Username</td>
                                  <th><?php echo $data["username"];?></th>
                                </tr>
                                <tr>
                                  <td>Email</td>
                                  <th><?php echo $data["email"];?></th>
                                </tr>
                                <tr>
                                  <td width="90">Name</td>
                                  <th><?php echo $data["first_name"];?> <?php echo $data["last_name"];?></th>
                                </tr>
                                <tr>
                                  <td>Group</td>
                                  <th>
								  <?php  if (cek_array($data['groups'])) : ?>
								  	<?php foreach($data['groups'] as $rows):?>
                                            &bull; <?php echo $rows['name']?><br />
                                    <?php endforeach; ?>
                                   <?php endif ?>
                                </tr>
                                <tr>
                                  <td>Last Login</td>
                                  <td><?php echo date("d-m-Y H:i",$data['last_login'])?></td>
                                </tr>
                              </tbody></table>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                      <!-- /.form-group -->
                      <div class="form-group">
                        <img id="previewplay" src="assets/images/noimg.jpg" class="img-thumbnail" style="cursor:pointer" height="180" width="180">
                        <input name="image_name" id="imgInpPlay" class="form-control hidden" style="width:180px;padding:0!important" type="file">
                    	</div>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                  <div class="row">
                    <div class="col-md-6">
                    	<div class="form-actions">
                            <!--<button type="submit" class="btn btn-primary">Save changes</button>-->
                            <button type="submit" name="save" value="Simpan" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
                        </div>
                    </div>
                  </div>
                </div>
                </form>
                <!-- /.box-body -->
                <div class="box-footer well well-sm no-shadow">
                     <i class="fa fa-warning text-red"></i>
    
                  Silahkan cek kembali sebelum melakukan penghapusan.
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