<?php $arrGroup=$this->ion_auth->groups()->result_array(); ?>
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>Edit <small>Groups</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active">Edit Groups</li>
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
							<a class="btn btn-default active" href="<?php echo $this->module?>group_edit/<?=$this->uri->segment(4);?>">
								<i class="fa fa-edit"></i> Edit
							</a> 							
							<a class="btn btn-default" href="<?php echo $this->module?>group_edit/<?=$this->uri->segment(4);?>">
								<i class="fa fa-refresh"></i> Refresh
							</a>
							<div class="pull-right">
							<a class="btn btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?=$this->module?>group_delete/<?=$this->uri->segment(4);?>">	
								<i class="fa fa-trash"></i> Hapus
							</a>
							</div>							
							</div>
						</div>
					</div>
				</div><!-- ./box-body -->
			</div>
			<!-- form start -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<?php //echo message_box();?>
							<form id="frm" method="post" action="<?php echo $this->module;?>group_edit/<?php echo $data["id"];?>" class="form-horizontal">
								<input type="hidden" name="act" id="act" value="update"/>
							<!-- control-group category-->
								 <div class="control-group">
									<label for="category" class="control-label">Group</label>
									<div class="controls">
										<input type="text" id="name" name="name" class="form-control input-xlarge required" value="<?php echo $data["name"];?>" />
									</div>
								</div><!-- /control-group category-->
							 
							<!-- control-group category-->
								 <div class="control-group">
									<label for="description" class="control-label">Description</label>
									<div class="controls">
										<textarea class="form-control input-xlarge" id="description" name="description"><?php echo $data["description"]?></textarea>
									</div>
								</div><!-- /control-group description-->
								
								<div class="row">
									<div class="col-md-6">
										<label>Provinsi</label>
										<select class="form-control" name="id_propinsi" id="prov" >
										<option value="">- Pilih Provinsi -</option>    
										<?php 
										// $jsonData = file_get_contents($services_prov."?kode_wilayah=00");
										$jsonData = file_get_contents($services_prov."propinsi");
										$phpArray = json_decode($jsonData, true);
										foreach($phpArray as $row){
											  $kdprov = $row['kode_dagri'];  
												if($kdprov == $data['id_propinsi']){
													$selected = 'selected="selected"';
												}else{
													$selected = '';
												}	
												echo "<option $selected value='".$row['kode_dagri']."'>$row[nama_wilayah]</option>"; 	
											}
										?> 	 
										</select>     
										<span style="font-size:10px;" class="help-block"></span>
									</div>
									<div class="col-md-6">
										<label>Kabupaten</label>
										<select class="form-control" name="id_kabupaten" id="kab" >
											<option value="">- Pilih Kabupaten -</option>
											<?php 
												// $jsonData = file_get_contents($services_prov."?kode_dagri=$data[id_provinsi]");
												$jsonData = file_get_contents($services_prov."kabupaten/$data[id_provinsi]");
												$phpArray = json_decode($jsonData, true);
												foreach($phpArray as $rowk):
												  $kdkab = $rowk['kode_dagri'];  
												  if($kdkab == $data['id_kabupaten']){
													$selected = 'selected="selected"';
													}else{
													  $selected = '';
													}	
												  echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";
												  
											?>
											<?php endforeach;?>  
										</select>
										<span style="font-size:10px;" class="help-block"></span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>Level User</label>
										<select class="form-control" name="level_user" >
											<option id='admin' value="op1">- Pilih Level User -</option>
										<?php foreach($query_cat as $row){
											  $kode = $row['kode'];  
												if($kode == $data["level_user"]){
													$selected = 'selected="selected"';
												}else{
													$selected = '';
												}	
												echo "<option $selected value='".$row['kode']."'>$row[nama]</option>"; 	
											}
										?> 	 
										</select>
									</div>
									<div class="col-md-6">
										<label>SKPD</label>
										<select name="skpd" class="form-control">
											<option value=''>- Pilih SKPD -</option>
											<? foreach($m_skpd as $rows):
												$nama = $rows['nama'];  
												if($nama == $data["skpd"]){
													$selected = 'selected="selected"';
												}else{
													  $selected = '';
												}	
											?>
											<option <?=$selected;?> value='<?=$rows['nama'];?>'><?=$rows['nama'];?></option>
											<? endforeach; ?>
										</select>
									</div>
								</div>
							   <!-- <div class="control-group">
								<div class="controls">
									<label class="checkbox">Publish<input type="checkbox" <?=$data["publish"]==1?"checked":""?> id="publish" name="publish" value="1" /></label>
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
<script language="javascript">
$(document).ready(function(){      
$('#prov').change(function(){
    $.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
    $('#kab').html(obj);
    });
    });
});
</script>
<?=loadFunction("select2");?>
<script>
	$(function(){
		$("#id_propinsi").select2({'placeholder':"--Pilih Propinsi --"});
		var act_link="group";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>