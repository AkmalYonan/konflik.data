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
				<li class="active">Pengguna</li>
			</ol>
		</section>
		
		<!-- Main content -->
		<section class="content">
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-12"> 
					<!-- Box (with bar chart) -->
					<div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-list-ol"></i>&nbsp;&nbsp;Daftar Pengguna</a></li>
                                    <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Tambah Pengguna</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
										<!-- tools box -->
										<div class="pull-right box-tools">
											<a href="<?= base_url()?>user"
											class="btn btn-primary btn-sm refresh-btn" data-toggle="tooltip" title="Muat Ulang">
											<i class="fa fa-refresh"></i></a>
										</div><!-- /. tools -->
										
										<h3 >Daftar Pengguna</h3>
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
											<table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0" border="0" id="example">
												<thead>
													<tr>
														<th>No</th>
														<th>Username</th>
														<th>Nama</th>
														<th>Level</th>
														<!--<th>Area Provinsi</th>
														<th>Area Kabupaten</th>-->
														<th colspan="2" ></th>
													</tr>
												</thead>
												  <?php 
												  $i=1;
												  foreach($query as $row): ?>
														<tr>
															<td><?=$i?></td>
															<td><?=$row['username']?></td>
															<td><?=$row['nama']?></td>
															<td>
															<?php foreach($query_cat as $rows){
																  $kode = $rows['kode'];  
																	if($kode == $row['level_user']){
																		echo $rows['nama'];
																	}
																}
															?> 	 
															</td>
															<!--<td>
													   <?php //foreach($query_prov as $rows){
															  // $kdprov = $rows['kode_dagri'];  
															  // if($kdprov == $row['provinsi']){
																// echo $rows['nama_wilayah'];  
																// } 
															// }
														?>
													</td>
															<td>
													   <?php //foreach($query_kab as $rowk){
															  // $kdwil = $rowk['kode_dagri'];  
															  // if($kdwil == $row['kabupaten']){
																// echo $rowk['nama_wilayah'];  
																// } 
															// }
														?>
													</td>-->
													<td style="width:30px">
													  <center>
													  <a href="<?=base_url();?>user/user_management_edit/<?=$row['user_id']?>" class="icon-edit" title="Edit">
													 <i class="fa fa-fw fa-edit" ></i>
													 </a> </center>
													 </td>
													 <td style="width:30px">
														 <center>
													  <a onclick="return confirm('Data akan dihapus???');" href="<?=base_url();?>user/user_management_delete/<?=$row['user_id']?>" class="icon-trash" title="Hapus">
													  <i class="fa fa-fw fa-trash-o" ></i> 
													  </a></center>
													</td>
												</tr>
												<?php $i++; endforeach;?> 
											</table>
											<div class="box-footer clearfix">
												<ul class="pagination pagination-sm no-margin pull-right">
													<?php echo $halaman;?>
												</ul>
											</div>
                                       
											
											
											<hr>
                                    </div><!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
										<?php $attributes = array('id' => 'theForm'); ?>
										<?=form_open('user/user_management_insert', $attributes);?>     
										<!-- tools box -->
										<div class="pull-right box-tools">
											<button type="reset" class="btn btn-primary btn-sm refresh-btn" data-toggle="tooltip" title="Kosongkan">
											<i class="fa fa-eraser"></i></button>
										</div><!-- /. tools -->
										
										<h3 >Tambah Pengguna</h3>
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
										
											
									   <div class="box-body">
											<div class="row">
												<div class="col-xs-6">
													<label>Nama <font color="red">*</font></label>
													<input type="text" name="name" class="form-control" required placeholder="Username">
												</div>
											</div><br/>
											
											<div class="row">
												<div class="col-xs-3">
													<label>Username Login <font color="red">*</font></label>
													<input type="text" name="username" id="name" class="form-control" required placeholder="Username Login">
												</div>
											
												<div class="col-xs-3">
													<label>Email <font color="red">*</font></label>
													<input type="text" id="email" name="email" class="form-control" required placeholder="sample@yahoo.com"/>
								
												</div>
											</div><br/>
											
											<div class="row">
												<div class="col-xs-3">
													<label>Password (5-12 karakter) <font color="red">*</font></label>
													<input type="text" name="password" id="password" class="form-control" required placeholder="Password">
												</div>
											
												<div class="col-xs-3">
													<label>Ulangi Password <font color="red">*</font></label>
													<input type="text" name="passconf" id="pwVerified" class="form-control" required placeholder="Ulangi Password">
												</div>
											</div><br/>
											
											<div class="row">
												<div class="col-xs-3">
													<label>Level User</label>
													<select class="form-control" name="lvl_user">
														<option id='admin' value="op1">Administrator</option>
														<option id='op2' value="op2">Operator KUMHAM</option>
														<option id='op3' value="op3">Operator Lulus Diklat</option>
														<option id='op4' value="op4">Operator POLRI</option>
														<option id='op5' value="op5">Operator KEJAGUNG</option>
														<option id='op6' value="op6">Operator SKEP</option>
														<option id='op7' value="op7">Operator Pelantikan</option>
													</select>
												</div>
											
												<div class="col-xs-3">
													<label>Deskripsi</label>
													<textarea class="form-control" name="desc"></textarea>
												</div>
												
											</div>
											
											
											<br/>
											<br/>
											<div class="row">
												<div class="col-xs-6">
												<button type="button" class="btn btn-default" onclick="window.history.back();return false;" style="float:right">Batal</button>
												<button type="submit" name="save" value="Simpan" class="btn btn-primary" style="float:right;margin-right:20px">Simpan</button>
												</div>
											</div>
											<?=form_close();?> 	
										</div>
									 </div><!-- /.tab-pane -->
                                </div><!-- /.tab-content -->
                            </div>
					  	
				
					</section><!-- /.Left col -->
				<!-- right col (We are only adding the ID to make the widgets sortable)-->
			</div><!-- /.row (main row) -->
		</section><!-- /.content -->
	</aside><!-- /.right-side -->
<script language="javascript">
$(document).ready(function(){      
$('#prov').change(function(){
    $.post("<?php echo base_url();?>pegawai/get_city/"+$('#prov').val(),{},function(obj){
    $('#kab').html(obj);
    });
    });
});
</script>


















