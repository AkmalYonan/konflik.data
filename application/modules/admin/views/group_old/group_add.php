<?php $arrGroup=$this->ion_auth->groups()->result_array(); ?>
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>Input <small>Groups</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active">Input Groups</li>
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
							<a class="btn btn-default" href="<?php echo $this->module?>group_list">
								<i class="fa fa-list"></i> List
							</a>
							<a class="btn btn-default active" href="<?php echo $this->module?>group_add">
								<i class="fa fa-plus"></i> Input
							</a>	  
							<a class="btn btn-default" href="<?php echo $this->module?>group_add">
								<i class="fa fa-refresh"></i> Refresh
							</a>	
							</div>
						</div>
					</div>
				</div><!-- ./box-body -->
			</div>
			<!-- form start -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<form id="frm" method="post" action="<?php echo $this->module;?>group_add/" class="form-horizontal">
								<input type="hidden" name="act" id="act" value="create"/>
							<!-- control-group category-->
								 <div class="control-group">
									<label for="category" class="control-label">Name</label>
									<div class="controls">
										<input type="text" id="name" name="name" class="form-control input-xlarge required" value="" />
									</div>
								</div><!-- /control-group category-->
							 
							<!-- control-group category-->
								 <div class="control-group">
									<label for="description" class="control-label">Description</label>
									<div class="controls">
										<textarea class="form-control input-xlarge" id="description" name="description"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>Provinsi</label>
										<select class="form-control" name="id_provinsi" id="prov" >
										<option value="">- Pilih Provinsi -</option>   
										<?php 
												// $jsonData = file_get_contents($services_prov."?kode_wilayah=00");
												$jsonData = file_get_contents($services_prov."propinsi");
												$phpArray = json_decode($jsonData, true);
												foreach($phpArray as $rows){
													echo "<option value='".$rows['kode_dagri']."'>$rows[nama_wilayah]</option>"; 	  
												}
										?>           
										</select>     
										<span style="font-size:10px;" class="help-block"></span>
									</div>
									<div class="col-md-6">
										<label>Kabupaten</label>
										<select class="form-control" name="id_kabupaten" id="kab" >
											<option value="">- Pilih Kabupaten -</option>
										</select>
										<span style="font-size:10px;" class="help-block"></span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>Level User</label>
										<select class="form-control" name="level_user">
											<option id='admin' value="op1">- Pilih Level User -</option>
											<option id='op2' value="op2">Operator KUMHAM</option>
											<option id='op3' value="op3">Operator Lulus Diklat</option>
											<option id='op4' value="op4">Operator POLRI</option>
											<option id='op5' value="op5">Operator KEJAGUNG</option>
											<option id='op6' value="op6">Operator SKEP</option>
											<option id='op7' value="op7">Operator Pelantikan</option>
										</select>
									</div>
									<div class="col-md-6">
										<label>SKPD</label>
										<select name="skpd" class="form-control">
											<option value=''>- Pilih SKPD -</option>
											<? foreach($m_skpd as $rows):?>
											<option value='<?=$rows['nama'];?>'><?=$rows['nama'];?></option>
											<? endforeach; ?>
										</select>
									</div>
								</div>
								<!-- <div class="control-group">
								<div class="controls">
									<label class="checkbox">Publish<input type="checkbox" checked="checked" id="publish" name="publish" value="1" /></label>
								</div>
								</div>-->
								<br>
								 <div class="form-actions">
									<button type="submit" class="btn btn-primary">Simpan</button>
									<button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
								</div>
							</form>
							
						</div>
						</div>
				</div><!-- /.box-body -->	

		
		  </div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->	

	
</div><!-- end div positioning -->
<?=loadFunction("select2");?>
<script>
	$(function(){
		var act_link="group";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>
<script>
	$(function(){

		$("#id_propinsi").select2({'placeholder':"--Pilih Propinsi --"});
		var act_link="group";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>
<script language="javascript">
$(document).ready(function(){      
$('#prov').change(function(){
    $.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
    $('#kab').html(obj);
    });
    });
});
</script>