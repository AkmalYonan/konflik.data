
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>Edit <small>SKPD</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active">Edit SKPD</li>
         </ul>
        <!-- end: breadcrumbs -->

	</div> 
	
	<div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<div class="box" style="padding-top:10px;">
			<div class="col-md-12">
				<div class="row topbar box_shadow">
					<div class="col-md-12">
						<div class="rows well well-sm">
							<div style="vertical-align:middle;line-height:25px">
							<a class="btn btn-default" href="<?php echo $this->module?>listview">
								<i class="fa fa-list"></i> List
							</a>
							<a class="btn btn-default active" href="<?php echo $this->module?>edit">
								<i class="fa fa-edit"></i> Edit
							</a> 							
							<a class="btn btn-default" href="<?php echo $this->module?>edit/<?=$this->uri->segment(4);?>">
								<i class="fa fa-refresh"></i> Refresh
							</a>
							<div class="pull-right">
							<a class="btn btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?=$this->module?>del/<?=$this->uri->segment(4);?>">	
								<i class="fa fa-trash"></i> Hapus
							</a>
							</div>							
							</div>
						</div>
					</div>
				</div><!-- ./box-body -->
			</div>
			<div class="col-md-12">
				<?php echo message_box();?>  
			</div>
			<!-- form start -->
				<?php
				$attributes = array('role' => 'form');
				echo form_open('admin/master/update', $attributes);
				$data = array(
						  'id'  => $ids,
						);
				echo form_hidden($data);
				?>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<label>Nama</label>
							<input type="text" id="nama" name="nama" value="<?=$nama;?>" class="form-control" required />
						</div>
					</div>
				</div><!-- /.box-body -->

				<div class="box-footer">
					<button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
				</div>
			</form>		

		
		  </div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->	

	
</div><!-- end div positioning -->
<script language="javascript">
$(document).ready(function(){      
$('#prov').change(function(){
    $.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
    $('#kab').html(obj);
    });
    });
});
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '200px');
                $('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>










