<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="right-side">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Pegawai
				<small>Control panel</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Pegawai</li>
			</ol>
		</section>
		
		<!-- Main content -->
		<section class="content">
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-12"> 
					<!-- Box (with bar chart) -->
					<div class="box box-primary" id="loading-example">
						<div class="box-header">
							<!-- tools box -->
							<div class="pull-right box-tools">
								<button class="btn btn-primary btn-sm refresh-btn" data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
								<button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
							</div><!-- /. tools -->
							<i class="fa fa-cloud"></i>

							<h3 class="box-title">Tambah Pengguna</h3>
								<div class="box-body table-responsive">
									<br/><br/>
									<?php if ($this->session->flashdata('success')) : ?>
									<div class="box-body">
										<div class="alert alert-success alert-dismissable">
											<i class="fa fa-check"></i>
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											<b>Alert!</b> <?php echo $this->session->flashdata('success'); ?>
										</div>
									</div><!-- /.box-body -->
									<?php endif; ?>
										<?php $attributes = array('id' => 'theForm'); ?>
										<?=form_open('user/user_management_insert', $attributes);?>     	
									   <div class="box-body">
											<div class="row">
												<div class="col-xs-5">
													<label>Nama <font color="red">*</font></label>
													<input type="text" name="name" class="form-control" required placeholder="Username">
												</div>
											</div>
											<div class="row">
												<div class="col-xs-5">
													<label>Username Login <font color="red">*</font></label>
													<input type="text" name="username" id="name" class="form-control" required placeholder="Username Login">
												</div>
											</div>
											<div class="row">
												<div class="col-xs-5">
													<label>Email <font color="red">*</font></label>
													<input type="text" id="email" name="email" class="form-control" required placeholder="sample@yahoo.com"/>
								
												</div>
											</div>
											<div class="row">
												<div class="col-xs-5">
													<label>Password (5-12 karakter) <font color="red">*</font></label>
													<input type="text" name="password" id="password" class="form-control" required placeholder="Password">
												</div>
											</div>
											<div class="row">
												<div class="col-xs-5">
													<label>Ulangi Password <font color="red">*</font></label>
													<input type="text" name="passconf" id="pwVerified" class="form-control" required placeholder="Ulangi Password">
												</div>
											</div>
											<div class="row">
												<div class="col-xs-5">
													<label>Deskripsi</label>
													<textarea class="form-control" name="desc"></textarea>
												</div>
											</div>
											
											<div class="row">
												<div class="col-xs-5">
													<label>Level User</label>
													<select class="form-control" name="lvl_user">
														<option id='admin' value="op1">Admin</option>
														<option id='op2' value="op2">Operator KUMHAM</option>
														<option id='op3' value="op3">Operator Lulus Diklat</option>
														<option id='op4' value="op4">Operator POLRI</option>
														<option id='op5' value="op5">Operator KEJAGUNG</option>
														<option id='op6' value="op6">Operator SKEP</option>
														<option id='op7' value="op7">Operator Pelantikan</option>
													</select>
												</div>
											</div>
											<!--
											<div class="row">
												<div class="col-xs-5">
													<label>Provinsi</label>
													<select class="form-control" required name="provinsi" id="prov2" >
													<option value="">- Pilih Provinsi -</option>   
													<?php 
													 // foreach($query_prov as $row): 
														// echo "<option value='".$row['kode_dagri']."'>$row[nama_wilayah]</option>"; 
													?> 	 
													<?php //endforeach;?>             
													</select>     
													<span style="font-size:10px;" class="help-block">Tempat Personel Bekerja</span>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-5">
													<label>Kabupaten</label>
													<select class="form-control" name="kabupaten" id="kab2" >
														<option value="">- Pilih Kabupaten -</option>
													</select>
													<span style="font-size:10px;" class="help-block">Tempat Personel Bekerja</span>
												</div>
											</div>
											-->
											<div class="box-footer">
												<button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
												<button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
											</div>
											<?=form_close();?> 	
										</div>
						
						</div><!-- /.box-header -->
						
					</div><!-- /.box -->        	
				</section><!-- /.Left col -->
				<!-- right col (We are only adding the ID to make the widgets sortable)-->
			</div><!-- /.row (main row) -->
		</section><!-- /.content -->
	</aside><!-- /.right-side -->
<script language="javascript">
$(document).ready(function(){      
$('#prov2').change(function(){
    $.post("<?php echo base_url();?>pegawai/get_city/"+$('#prov').val(),{},function(obj){
    $('#kab2').html(obj);
    });
    });
});
</script>

























