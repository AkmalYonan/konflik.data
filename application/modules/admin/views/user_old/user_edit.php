<script>
$(document).ready(function(){ 
		//$("#prov2").attr("disabled",true);
		//$("#kab2").attr("disabled",true);
		//$('select#prov2').val('');
		//$('select#kab2').val('');
		$("#op").click(function(){ 
			$("#prov2").removeAttr("disabled",true);
			$("#kab2").removeAttr("disabled",true);
		});	
		$("#admin").click(function(){ 
			$('select#prov2').val('');
			$('select#kab2').val('');
			$("#prov2").attr("disabled",true);
			$("#kab2").attr("disabled",true);
		});	
	});	
</script>
<script type="text/javascript" src="<?= base_url();?>assets/js/FormValidation.js"></script>
<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="right-side">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Pengguna
				<!--<small>Control panel</small>-->
			</h1>
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li><a href="#">Pengguna</a></li>
				<li class="active">Edit Pengguna</li>
			</ol>
		</section>
		
		<!-- Main content -->
		<section class="content">
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-12 "> 
					<!-- Box (with bar chart) -->
					<div class="box box-primary  id="loading-example">
						<div class="box-header" style="padding:10px 30px">
							<!-- tools box -->
										<div class="box-body table-responsive">
										
												<div class="box-header">
													<div class="pull-right box-tools">
														<a href=""
														class="btn btn-primary btn-sm refresh-btn" data-toggle="tooltip" title="Muat Ulang">
														<i class="fa fa-refresh"></i></a>
													</div><!-- /. tools -->
													
													<h3 >Edit  Pegawai</h3>
													<hr/>
													
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
														<?=form_open('user/user_management_update', $attributes);?> 
														<?=form_hidden('user_id', $this->uri->segment(3));?> 
														<?php 
														  foreach($query as $row): 
															$lvl_user = $row['level_user'];
															$prov = $row['provinsi'];
															$kab = $row['kabupaten'];
															$password = $row['password'];
															$passconf = $row['passconf'];
															$descript = b64decode($password);
															$passconf_dec = b64decode($passconf);       
														?>
														<?php endforeach; ?>  
										
													   <div class="box-body">
															<div class="row">
																<div class="col-xs-6">
																	<label>Nama <font color="red">*</font></label>
																	<input type="text" name="name" value="<?=$row['nama']?>" class="form-control" required placeholder="Username">
																</div>
															</div><br/>
															
															<div class="row">
																<div class="col-xs-3">
																	<label>Username Login <font color="red">*</font></label>
																	<input type="text" name="username" value="<?=$row['username']?>" id="name" class="form-control" required placeholder="Username Login">
																</div>
															
																<div class="col-xs-3">
																	<label>Email <font color="red">*</font></label>
																	<input type="text" id="email" name="email" value="<?=$row['email']?>" class="form-control" required placeholder="sample@yahoo.com"/>
												
																</div>
															</div><br/>
															
															<div class="row">
																<div class="col-xs-3">
																	<label>Password (5-12 karakter) <font color="red">*</font></label>
																	<input type="password" name="password" id="password" value="<?=$descript;?>" class="form-control" required placeholder="Password">
																</div>
															
																<div class="col-xs-3">
																	<label>Ulangi Password <font color="red">*</font></label>
																	<input type="password" name="passconf" id="pwVerified" value="<?=$passconf_dec;?>" class="form-control" required placeholder="Ulangi Password">
																</div>
															</div><br/>
															
															
															<div class="row">
																
															
																<div class="col-xs-3">
																	<label>Level User</label>
																	<select class="form-control" name="lvl_user" >
																	<?php foreach($query_cat as $row){
																		  $kode = $row['kode'];  
																			if($kode == $lvl_user){
																				$selected = 'selected="selected"';
																			}else{
																				$selected = '';
																			}	
																			echo "<option $selected value='".$row['kode']."'>$row[nama]</option>"; 	
																		}
																	?> 	 
																	</select>
																</div>
																<div class="col-xs-3">
																	<label>Deskripsi</label>
																	<textarea class="form-control" name="desc"><?=$row['deskripsi']?></textarea>
																</div>
														</div>
															
													
												
												</div><!-- /.box-header -->
												<!-- form start -->
												
															
															
															<br>
															<br>
							<div class="row">
								<div class="col-xs-6">
								<button type="button" class="btn btn-default" onclick="window.history.back();return false;" style="float:right">Batal</button>
								<button type="submit" name="save" value="Simpan" class="btn btn-primary" style="float:right;margin-right:20px">Simpan</button>
									<?=form_close();?> 	
								</div>
							</div>
														
															
															
															
															
														</div><!-- /.box-body -->
													</div>
													
												</form>										
										</div>
						</div><!-- /.box-header -->
						
					</div><!-- /.box -->        	
				</section><!-- /.Left col -->
				<!-- right col (We are only adding the ID to make the widgets sortable)-->
			</div><!-- /.row (main row) -->
		</section><!-- /.content -->
	
		
		<script language="javascript">
$(document).ready(function(){      
$('#prov2').change(function(){
    $.post("<?php echo base_url();?>pegawai/get_city/"+$('#prov2').val(),{},function(obj){
    $('#kab2').html(obj);
    });
    });
});
</script>

























