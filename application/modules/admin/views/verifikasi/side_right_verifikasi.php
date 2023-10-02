<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="right-side">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Verifikasi Berkas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Verifikasi Berkas</li>
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
						<div class="box-header" style="padding:10px 50px">
							
							<div class="pull-right box-tools">
								<a href=""
								class="btn btn-primary btn-sm refresh-btn" data-toggle="tooltip" title="Muat Ulang">
								<i class="fa fa-refresh"></i></a>
							</div><!-- /. tools -->
								
								<h3 >Daftar Verifikasi Berkas</h3>
								<hr style="clear:both"/>		
							
							
											
											<?php if ($this->session->flashdata('success')) : ?>
											<div class="box-body">
												<div class="alert alert-success alert-dismissable">
													<i class="fa fa-check"></i>
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
													<b>Alert!</b> <?php echo $this->session->flashdata('success'); ?>
												</div>
											</div><!-- /.box-body -->
											<?php endif;
											echo form_open('verifikasi/search');?>
											
											<div class="row">
												
												<div class="col-lg-3">
													 <div class="form-group">
													  <label class="control-label" for="focusedInput">Provinsi</label>
													  <select class="form-control" name="provinsi" id="prov" >

														<option value="">- All -</option>   
														<?php 
															$jsonData = services_prov();
															$phpArray = json_decode($jsonData, true);
															foreach ($phpArray as $key => $value) {
																$a = $value['kode_dagri'];
																$b = $value['nama_wilayah'];
																if($a == $scr_prov){
																	$selected = 'selected="selected"';
																}else{
																	$selected = '';
																}	
																echo "<option $selected value='".$a."'>$b</option>";
															}
														?> 	           
													</select>
													</div>
												</div><!-- /.col-lg-6 -->
												
												<div class="col-lg-3">
													<div class="form-group">
														<label class="control-label" for="focusedInput">Kabupaten</label>
														<select class="form-control" name="kabupaten" id="kab" >
														<option value="">- All -</option>
														<?php
														if($this->uri->segment(2) == 'search'){
															$jsonData = services_kab($scr_prov);
															$phpArray = json_decode($jsonData, true);
															foreach ($phpArray as $key => $value) {
																$a = $value['kode_dagri'];
																$b = $value['nama_wilayah'];
																if($a == $scr_kab){
																	$selected = 'selected="selected"';
																}else{
																	$selected = '';
																}	
																echo "<option $selected value='".$a."'>$b</option>";
															}
														}
														?>
														</select>
													</div>
												</div><!-- /.col-lg-6 -->
												
												<div class="col-lg-3">
													<div class="form-group">
													  <label class="control-label" for="focusedInput">NIP/Nama</label>
													  <input name="q" value="<?= ($this->uri->segment(2) == 'search') ?   $scr :  '';?>" class="form-control" placeholder="Masukkan NIP/Nama" type="text">
													</div>
												</div>
												<div class="col-lg-1">
													<div class="form-group">
													  <label class="control-label" for="focusedInput">&nbsp;</label>
													  <button class="form-control btn btn-default btn-flat" type="submit" name="search"><i class="fa fa-search"></i></button>
													</div>
												</div>
													
													
												</div><!-- /.col-lg-6 -->
										
											
											</form>
											<table class="table-bordered table-hover table">
												<?php $this->load->view('verifikasi/side_right_content');?>
												<?php $this->load->view('verifikasi/side_right_content2');?>
											</table>
											<div class="box-footer clearfix">
												<ul class="pagination pagination-sm no-margin pull-right">
													<?php echo $halaman;?>
												</ul>
											</div>
											
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
$('#prov').change(function(){
    $.post("<?php echo base_url();?>pegawai/get_city/"+$('#prov').val(),{},function(obj){
    $('#kab').html(obj);
    });
    });
$('#prov2').change(function(){
    $.post("<?php echo base_url();?>pegawai/get_city/"+$('#prov2').val(),{},function(obj){
    $('#kab2').html(obj);
    });
    });
});
</script>