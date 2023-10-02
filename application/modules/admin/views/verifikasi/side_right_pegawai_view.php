<?php
// debug();
$arr=$this->conn->GetAll("SELECT * FROM m_jenis_berkas ORDER BY id");
$arrInp=$this->conn->GetAll("SELECT * FROM berkas_sppp_data_pegawai where idx_pegawai = '".$data['idx']."' ");
foreach($arrInp as $kk => $vv):
	$arrDD[$vv['nm_file']] = $vv['nm_file'];
endforeach;
foreach($arr as $k => $v):
	if (!in_array($v['kode'], $arrDD)) {
		$arrD[$v['kode']] = $v['nm_berkas'];
	}
endforeach;
$lookup_berkas=$arrD;
?>
<?
if ($_GET['I'] || $_GET['skpa'] || $_GET['q']) {
	$class_toggle=" active";
	$class_content="";
}
else {
	$class_toggle="";
	$class_content="none";
}
?>
<script>
$(document).ready(function(){
	document.getElementById("file_upload").onchange = function() {
		document.getElementById("form").submit();
	}
});	
</script>
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>Verifikasi <small>Pegawai</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active">Verifikasi pegawai</li>
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
							<a class="btn btn-default" href="<?php echo $this->module?>">
								<i class="fa fa-list"></i> List
							</a>
							<a class="btn btn-default active" href="<?php echo $this->module?>view/<?=$this->uri->segment(4);?>/<?=$this->uri->segment(5);?>">
								<i class="fa  fa-table"></i> View
							</a>	 
							<a class="btn btn-default" href="<?php echo $this->module?>view/<?=$this->uri->segment(4);?>/<?=$this->uri->segment(5);?>">
								<i class="fa fa-refresh"></i> Refresh
							</a>							
							<!--<div class="pull-right">
							<a class="btn btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?=$this->module?>del/<?=$this->uri->segment(4);?>">	
								<i class="fa fa-trash"></i> Hapus
							</a>
							</div>	-->
							</div>
						</div>
					</div>
				</div><!-- ./box-body -->
			</div>
			<!-- form start -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<?php echo message_box();?>  
						</div>
						<div class="col-md-12">
							<center>
							<span class="user-header">
								<?php if($data['nip']==''):?>
									<img src="assets/image/person.jpeg" width="100" class="img-circle" alt="User Image">
								  <? else: ?>
									<img src="uploads/sppp_data_pegawai/<?=$data['foto'];?>" width="100" height="100" class="img-circle" alt="User Image">
								  <? endif; ?>
								<p>
								  <?=$data['nip'];?> - <?=$data['nama'];?><br>
								  <small><?=$data['skpd']?></small>
								</p>
							</span>
							<center>
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-4">
									<h4 style="border-bottom:2px solid #aaa;font-weight:bold;">Profil Pegawai</h4>	
									<div class="">
										<table border="0" cellpadding="5" cellspacing="20" width="100%">
										<tbody>
										
										<tr>
											<td>Nama Lengkap</td>
											<td class="tb-val"><?=$data['nama'];?></td>
										</tr>
										<tr>
											<td>Tanggal lahir</td>
											<td class="tb-val"><?=format_tanggal_db3($data['tanggal_lahir'])?></td>
										</tr>
										<tr>
											<td>Tempat Lahir</td>
											<td class="tb-val"><?=$data['tempat_lahir'];?></td>
										</tr>
										<tr>
											<td>Email address</td>
											<td class="tb-val"><?=$data['email'];?></td>
										</tr>
										<tr>
											<td>Jenis Kelamin</td>
											<td class="tb-val"><?=$data['jenis_kelamin'];?></td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td class="tb-val"><?=$data['alamat'];?></td>
										</tr>
									</tbody></table>
									</div>
								</div>
								<div class="col-md-4">
									<h4 style="border-bottom:2px solid #aaa;font-weight:bold;">Data Pegawai</h4>	
									<div class="">
										<table border="0" cellpadding="2" cellspacing="14" width="100%">
										<tbody>
										<tr>
											<td>Nomor Induk Pegawai</td>
											<td class="tb-val"><?=$data['nip'];?></td>
										</tr>
										<tr>
											<td>Nomor SK. PPNS</td>
											<td class="tb-val"><?=$data['no_sk_ppns'];?></td>
										</tr>
										<tr>
											<td>Masa Berlaku Pegawai</td>
											<td class="tb-val"><?=format_tanggal_db3($data['berlaku_pegawai'])?></td>
										</tr>
										<tr>
											<td>No. KTP</td>
											<td class="tb-val"><?=$data['no_ktp'];?></td>
										</tr>
										<tr>
											<td>Masa Berlaku KTP</td>
											<td class="tb-val"><?=format_tanggal_db3($data['berlaku_ktp'])?></td>
										</tr>
										<tr>
											<td>SKPD</td>
											<td class="tb-val"><?=$data['skpd']?></td>
										</tr>
									</tbody></table>
									</div>
								</div>
								<div class="col-md-4">
									<h4 style="border-bottom:2px solid #aaa;font-weight:bold;">Atribut Pegawai </h4>	
									<div class="">
										<table border="0" cellpadding="2" cellspacing="14" width="100%">
										<tbody>
										<tr>
											<td>Gelar Depan</td>
											<td class="tb-val"><?=$data['gelar_depan'];?></td>
										</tr>
										<tr>
											<td>Gelar Belakang</td>
											<td class="tb-val"><?=$data['gelar_belakang'];?></td>
										</tr>
										<tr>
											<td>Provinsi</td>
											<td class="tb-val">
											<?php 
											// $jsonData = file_get_contents($services_prov."?kode_wilayah=00");
											$jsonData = file_get_contents($services_prov."propinsi");
											$phpArray = json_decode($jsonData, true);
											foreach($phpArray as $row){
												  $kdprov = $row['kode_dagri'];  
													if($kdprov == $data['propinsi']){
														echo "$row[nama_wilayah]"; 	
													}
												}
											?> 	 
											</td>
										</tr>
										<tr>
											<td>Kabupaten</td>
											<td class="tb-val">
											<?php 
											// $jsonData = file_get_contents($services_prov."?kode_dagri=$data[propinsi]");
											$jsonData = file_get_contents($services_prov."kabupaten/$data[propinsi]");
											$phpArray = json_decode($jsonData, true);
											foreach($phpArray as $rowk):
											  $kdkab = $rowk['kode_dagri'];  
											  if($kdkab == $data['kabupaten']){
												 echo "$rowk[nama_wilayah]";
												} 
											?>
											<?php endforeach;?>  
											</td>
										</tr>
										<tr>
											<td>UU Yang Dikawal</td>
											<td class="tb-val"><?=$data['uu_dikawal'];?></td>
										</tr>
										<tr>
											<td>TMT Pegawai</td>
											<td class="tb-val"><?=format_tanggal_db3($data['tmt_pegawai_masuk'])?></td>
										</tr>
										<tr>
											<td>Status</td>
											<td class="tb-val"><?=$data['status_pegawai'];?></td>
										</tr>
										<tr>
											<td>Pangkat/Golongan</td>
											<td class="tb-val">
											<?php foreach($query_gol as $rowG):
												  $ket = $rowG['keterangan'];  
												  if($ket == $data['pangkat']){
													echo "$rowG[keterangan]";
													}  
											?>
											<?php endforeach;?> 
											</td>
										</tr>
										<tr>
											<td>SK. Pangkat/Golongan</td>
											<td class="tb-val"><?=$data['no_sk_pangkat'];?></td>
										</tr>
										<tr>
											<td>Pendidikan terakhir</td>
											<td class="tb-val"><?=$data['pendidikan_terakhir'];?></td>
										</tr>
										<tr>
											<td>Keterangan lain</td>
											<td class="tb-val"><?=$data['keterangan'];?></td>
										</tr>
										<tr>
											<td>Posisi</td>
											<td class="tb-val">
												<?php if($data['posisi'] == 'a'){?>
												
													<span class="label label-info">Verifikasi PUM</span>
												
												<?php }elseif($data['posisi'] == 'b'){?>
												
													<span class="label label-info">Verifikasi KUMHAM</span>
												
												<?php }elseif($data['posisi'] == 'c'){?>
												
													<span class="label label-info">Lulus Diklat</span>
												
												<?php }elseif($data['posisi'] == 'd'){?>
												
													<span class="label label-info">Rekomendasi POLRI</span>
												
												<?php }elseif($data['posisi'] == 'e'){?>
												
													<span class="label label-info">Rekomendasi KEJAGUNG</span>
												
												<?php }elseif($data['posisi'] == 'f'){?>
												
													<span class="label label-info">SKEP/KTP Dari KUMHAM</span>
												
												<?php }elseif($data['posisi'] == 'g'){?>
												
													<span class="label label-info">Pelantikan</span>
												
												<?php }else{ echo "-";} ?>
											</td>
										</tr>
										
									</tbody></table>
									</div>
								</div>
							</div>						
						</div>
						
						
						<div class="col-md-12">
							<hr >
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
<!-- OP1 -->				
						<?php if(($level_user == 'op1')){?>
							<?php 
							//if($data['status']==2){?>
								<li role="presentation" class="<?php if($flag=='a') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/a" >Verifikasi PUM</a></li>
							<?php //} ?>

							<?php
							if($data['status'] == 2){?>
									<li role="presentation" class="<?php if($flag=='b') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/b" >Verifikasi KUMHAM</a></li>
							<? }else{ ?>
								<li><a>Verifikasi KUMHAM</a></li>
							<?php } ?>

							<?php 
							if($data['stt_kumham']==2 && $data['status'] == 2 ){
								?>
									<li role="presentation" class="<?php if($flag=='c') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/c" >Lulus Diklat</a></li>
							<?php 
							}else{?>
								<li><a>Lulus Diklat</a></li>
							<?php } ?>	

							<?php
							if($data['stt_kumham']==2 && $data['status'] == 2 && $data['stt_diklat']==2){
								?>
									<li role="presentation" class="<?php if($flag=='d') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/d" >Rekomendasi POLRI</a></li>
							<?php 
							}else{?>
								<li><a>Rekomendasi POLRI</a></li>
							<?php } ?>

							<?php 
							if($data['stt_kumham']==2 && $data['status'] == 2 && $data['stt_diklat']==2 && $data['stt_polri']==2){
								?>
									<li role="presentation" class="<?php if($flag=='e') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/e" >Rekomendasi KEJAGUNG</a></li>
								
							<?php 
							}else{?>
								<li><a>Rekomendasi KEJAGUNG</a></li>
							<?php } ?>

							<?php
							if($data['stt_kumham']==2 && $data['status'] == 2 && $data['stt_diklat']==2 && $data['stt_polri']==2 && $data['stt_kejagung']==2){
								?>
									<li role="presentation" class="<?php if($flag=='f') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/f" >SKEP/KTP Dari KUMHAM</a></li>
							<?php 
							}else{?>
								<li><a>SKEP/KTP Dari KUMHAM</a></li>
							<?php } ?>

							<?php
							if($data['stt_kumham']==2 && $data['status'] == 2 && $data['stt_diklat']==2 && $data['stt_polri']==2 && $data['stt_kejagung']==2 && $data['stt_skep']){
								?>
									<li role="presentation" class="<?php if($flag=='g') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/g" >Pelantikan</a></li>
							<?php
							}else{?>
								<li><a>Pelantikan</a></li>
							<?php } ?>

<!-- OP2 --><!-- KUMHAM -->						
						<?php } if($level_user == 'op2'){?> 
							<?php
							if($data['status'] == 2){
								if($data['stt_kumham'] == 2){?>
									<li role="presentation" class="<?php if($flag=='b') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/b" >Verifikasi KUMHAM</a></li>
								<?php }else{ ?>
									<li><a>Verifikasi KUMHAM</a></li>
							<?php }
							}else{ ?>
								<li><a>Verifikasi KUMHAM</a></li>
							<?php } ?>

<!-- OP3 --><!-- Lulus Diklat -->					
						<?php } if($level_user == 'op3'){?> 
							<?php 
							if($data['stt_kumham']==2 && $data['status'] == 2 ){
								if($data['stt_diklat']==2){?>
									<li role="presentation" class="<?php if($flag=='c') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/c" >Lulus Diklat</a></li>
								<?php }else{ ?>
									<li><a>Lulus Diklat</a></li>
								<?php } 
							}else{?>
								<li><a>Lulus Diklat</a></li>
							<?php } ?>	
						
<!-- OP4 --><!-- POLRI -->						
						<?php } if($level_user == 'op4'){?>
							<?php
							if($data['stt_kumham']==2 && $data['status'] == 2 && $data['stt_diklat']==2){
								if($data['stt_polri']==2){?>
									<li role="presentation" class="<?php if($flag=='d') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/d" >Rekomendasi POLRI</a></li>
								<?php }else{ ?>
									<li><a>Rekomendasi POLRI</a></li>
								<?php } 
							}else{?>
								<li><a>Rekomendasi POLRI</a></li>
							<?php } ?>
						
<!-- OP5 --><!-- KEJAGUNG -->					
						<?php } if($level_user == 'op5'){?> 
							<?php 
							if($data['stt_kumham']==2 && $data['status'] == 2 && $data['stt_diklat']==2 && $data['stt_polri']==2){
								if($data['stt_kejagung']==2){?>
									<li role="presentation" class="<?php if($flag=='e') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/e" >Rekomendasi KEJAGUNG</a></li>
								<?php }else{ ?>
									<li><a>Rekomendasi KEJAGUNG</a></li>
								<?php } 
							}else{?>
								<li><a>Rekomendasi KEJAGUNG</a></li>
							<?php } ?>

<!-- OP6 --><!-- SKEP -->					
						<?php } if($level_user == 'op6'){?> 
							<?php
							if($data['stt_kumham']==2 && $data['status'] == 2 && $data['stt_diklat']==2 && $data['stt_polri']==2 && $data['stt_kejagung']==2){
								if($data['stt_skep']==2){?>
									<li role="presentation" class="<?php if($flag=='f') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/f" >SKEP/KTP Dari KUMHAM</a></li>
								<?php }else{ ?>
									<li><a>SKEP/KTP Dari KUMHAM</a></li>
								<?php } 
							}else{?>
								<li><a>SKEP/KTP Dari KUMHAM</a></li>
							<?php } ?>

							<?php
							if($data['stt_kumham']==2 && $data['status'] == 2 && $data['stt_diklat']==2 && $data['stt_polri']==2 && $data['stt_kejagung']==2 && $data['stt_skep']){
								if($data['stt_pelantikan']==2){?>
									<li role="presentation" class="<?php if($flag=='g') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/g" >Pelantikan</a></li>
								<?php }else{ ?>
									<li><a>Pelantikan</a></li>
								<?php } 
							}else{?>
								<li><a>Pelantikan</a></li>
							<?php } ?>

<!-- OP7 --><!-- Pelantikan -->						
						<?php } if($level_user == 'op7'){?> <!-- Pelantikan -->
							<?php
							if($data['stt_kumham']==2 && $data['status'] == 2 && $data['stt_diklat']==2 && $data['stt_polri']==2 && $data['stt_kejagung']==2 && $data['stt_skep']){
								if($data['stt_pelantikan']==2){?>
									<li role="presentation" class="<?php if($flag=='g') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/g" >Pelantikan</a></li>
								<?php }else{ ?>
									<li><a>Pelantikan</a></li>
								<?php } 
							}else{?>
								<li><a>Pelantikan</a></li>
							<?php } ?>

						<?php } ?>
							<!--
								<li role="presentation" class="<?php if($flag=='a') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/a" >Verifikasi PUM</a></li>
								<li role="presentation" class="<?php if($flag=='b') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/b" >Verifikasi KUMHAM</a></li>
								<li role="presentation" class="<?php if($flag=='c') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/c" >Lulus Diklat</a></li>
								<li role="presentation" class="<?php if($flag=='d') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/d" >Rekomendasi POLRI</a></li>
								<li role="presentation" class="<?php if($flag=='e') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/e" >Rekomendasi KEJAGUNG</a></li>
								<li role="presentation" class="<?php if($flag=='f') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/f" >SKEP/KTP Dari KUMHAM</a></li>
								<li role="presentation" class="<?php if($flag=='g') echo 'active';?>"><a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($data['idx']);?>/g" >Pelantikan</a></li>
							-->
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<?
								//echo "$data[status] -- $level_user ";exit;
								?>
								<div role="tabpanel" class="tab-pane <?php if($flag=='a') echo 'active';?>" id="home">
									<div class="row" >
										<div class="col-md-8" >
											<h4 style="margin-top:10px;border-bottom:0px solid #aaa;font-weight:bold;"> <a class="btn<?=$class_toggle?>" id="filter_toggle"><i class="fa fa-plus bc-icon"></i> Tambah</a>
												<div style="float:right" >
													<?php //if(($data['status'] == 1 && $group_brwa=='1')||($prov == '' && $kabupaten='' )){?>
													<?php if($data['status'] == 1 && $prov == '' && $kabupaten=='' ){?>
													<!--<a title="Verified/Not Verified" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['status']));?>">	-->												
													<center>
														<span type="button" data-toggle="modal" data-target="#stt" class="label label-warning">Ubah Status? <i class="fa"></i></span>
													</center>
													<div class="modal fade" id="stt" tabindex="-1" role="dialog">
													  <div class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">Ubah Status Dokumen</h4>
														  </div>
														 <?php
														$attributes = array('role' => 'form','id' => 'formx');
														echo form_open('admin/verifikasi/change_status', $attributes);
														$datax = array(
																  'idx_pegawai'  => encrypt($data['idx']),
																  'flag' => encrypt($this->uri->segment(5))
																);
														echo form_hidden($datax);
														?>
														  <div class="modal-body">
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="2" checked="" type="radio">
																  <span class='badge bg-blue'>Proses</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="3" type="radio">
																  <span class='badge bg-green'>Valid</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="4" type="radio">
																  <span class='badge bg-red'>Tolak</span>
																</label>
															</div>
															<div class="form-group">
															  <label>Keterangan</label>
															  <textarea class="form-control" rows="3" name="keterangan" placeholder="Keterangan ..."></textarea>
															</div>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														  </div>
														  </form>
														</div><!-- /.modal-content -->
													  </div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													<!--</a>-->
													<?php }elseif(($data['status'] == 1 && $prov != '' && $kabupaten!='')||($data['status'] == 1 && $prov != '' && $kabupaten=='')){?>
													<center>
														<span type="button" class="label label-warning">Terkirim <i class="fa fa-check"></i></span>
													</center>	
													<? }elseif($data['status'] == 0){?>
													<center>
														<span type="button" data-toggle="modal" data-target="#kirim" class="label label-warning">Kirim data ke pusat ? <i class="fa fa"></i></span>
													</center>
													<div class="modal fade" id="kirim" tabindex="-1" role="dialog">
													  <div class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title"><b>Konfirmasi Pengajuan</b></h4>
														  </div>
														 <?php
														  
														$attributes = array('role' => 'form','id' => 'formx');
														echo form_open('admin/verifikasi/publishx', $attributes);
														$datax = array(
																  'a'  => encrypt($data['idx']),
																  'b' => encrypt($data['status']),
																 'c' => encrypt($flag)
																);
														echo form_hidden($datax);
														?>
															<div class="modal-body">
																Tanggal Pengajuan <input type="text" id="datepicker" name="tanggal_selector" class="form-control" required />
														
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Submit</button>
														  </div>
														  </form>
														</div><!-- /.modal-content -->
													  </div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													<!--<a title="Kirim?" onclick="return confirm('Anda yakin kirim data ini ke pusat?');" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['status'])."/".encrypt($flag));?>">																						
													<center>
														<span class="label label-warning">Kirim &nbsp;<i class="fa fa-arrow-circle-o-up"></i></span>
													</center></a>-->
													<?php } ?>
													
												</div>
											</h4>
											
											<div id='target'>
											<?php
											$attributes = array('role' => 'form','id' => 'form');
											echo form_open_multipart('admin/verifikasi/insert_dokumen', $attributes);
											$datax = array(
													  'idx'  => $data['idx'],
													  'nip' => $data['nip'],
													  'fg' => $this->uri->segment(5)
													);
											echo form_hidden($datax);
											?>
											<div class="transparent" style="padding-bottom:0px; margin-top:2px">
												<div id="filter_content" class="box-contents" style="padding-bottom:0px; background:white; display:<?=$class_content?>">
													<table class="table table-condensed small-font" style="margin-top:;">
													<thead style="background:">
														<tr>
															<th>Nama File</th>
															<th>File</th>
															
														</tr>
														 <tr>
															<!--<td><input type="text" id="nm_file" required name="nm_file" class="span12 " /></td>-->
															<td>
																<?=form_dropdown("nm_file",$lookup_berkas,"","id='adds'  class='form-control'");?>
															</td>
															<td><input type="file" id="file_upload" name="file_name" class="span12 " /></td>
														</tr>
													</thead>
													</table>
												</div>
											</div>
											</form>
												<table class="table table-striped">
													<tr>
														
														<th width="100"><center>#</center></th>
														<th>Nama File</th>
														<!--<th><center>Verified/Not Verified?</center></th>-->
													</tr>
													<?php if(count($data_berkas) > 0){?>
														<?php foreach($data_berkas as $row){
														// $fl = getDataURI("uploads/berkas_ppns/$row[dokumen]");
														?>
													<tr>	
														<td><center>
															<a href="uploads/berkas_ppns/<?php echo $row['dokumen'];?>" title="Download"><i class="fa fa-download"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
															<a onclick="return confirm('Berkas akan dihapus?');" title="Delete" href="<?= base_url();?>admin/verifikasi/delete_berkas_/<?php echo encrypt($row['idx']);?>/<?php echo $flag;?>"><i class="fa fa-trash"></i></a>
															</center>													
														</td>
														<td>
															<? foreach($m_jns_brks as $rows):
																$kode = $rows['kode'];  
																if($kode == $row['nm_file']){
																	echo $rows['nm_berkas'];
																}
															?>
															<? endforeach; ?>
														</td>
														<!--<td><center>
															<input data-id="<?php //echo encrypt($row['idx']);?>" <?//=($row['cek'] == 1 ? 'checked' : false);?> type='checkbox' name='ceklis' class="rad_update<?//=$row['idx'];?>">
															</center>
														</td>-->
													</tr>
													<script type="text/javascript">
													$(function() {
														$(".rad_update<?=$row['idx'];?>").change(function(){
															var element = $(this);
															var del_id = element.attr("data-id");
															var info = 'id=' + del_id;
															// if(confirm("Are you sure you want to delete this?"))
															// {
															 $.ajax({
																type: "POST",
																url: "admin/pegawai/update_cek",
																data: info,
																success: function(){

																					}
																});
															  // $("#filediv<?=$x;?>").animate({ backgroundColor: "#003" }, "slow")
															  // .animate({ opacity: "hide" }, "slow");
															return false;
														});
													});
													</script>
													<?php
														}
													}else{?>
													<tr>
														<td colspan="2">Tidak Ada Data</td>
														
													</tr>	
													<?php	
													}
													?>
												</table>						
											</div>
										</div>
										<div class="col-md-4" >
											<h4 style="margin-top:10px;font-weight:bold;">Status Pengajuan</h4>
											<table class="table table-bordered">
												<tr>												
													<th width="100"><center>Tanggal</center></th>
													<th><center>Status</center></th>
													<th><center>Keterangan</center></th>
												</tr>
												<?php if(count($getLog) > 0){?>
													<?php foreach($getLog as $rowlog){?>
													<tr>												
														<td><?=date("d/m/Y", strtotime($rowlog['tanggal']));?></td>
														<td>
															<?php
															if($rowlog['status']==0 && $rowlog['status_dok']==4){
																echo "<span class='badge bg-red'>Tolak</span>";
															}elseif($rowlog['status']==2 && $rowlog['status_dok']==3){
																echo "<span class='badge bg-green'>Valid</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==2){
																echo "<span class='badge bg-blue'>Proses</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==1){
																echo "<span class='badge bg-yellow'>Terkirim</span>";
															}
															?>	
														</td>
														<td><?=$rowlog['keterangan']?></td>
													</tr>
												<?php }
												}else{ ?>
													<tr>
														<td colspan="3">Tidak ada log</td>
														
													</tr>
												<? } ?>
											</table>
										</div>
									</div>
								</div>
								
								<div role="tabpanel" class="tab-pane <?php if($flag=='b') echo 'active';?>" id="profile">
									<div class="row" >
										<div class="col-md-8" >
											<h4 style="margin-top:10px;border-bottom:0px solid #aaa;font-weight:bold;"> <a class="btn<?=$class_toggle?>" id="filter_toggle2"><i class="fa fa-plus bc-icon"></i> Tambah</a>
												<div style="float:right" >
													
													<?php if($data['stt_kumham'] == 1 && $prov == '' && $kabupaten==''){?>
													<!--<a title="Verified/Not Verified" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_kumham']));?>">	-->												
													<center>
														<span type="button" data-toggle="modal" data-target="#stt2" class="label label-warning">Ubah Status? <i class="fa fa"></i></span>
													</center>
													<div class="modal fade" id="stt2" tabindex="-1" role="dialog">
													  <div class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">Ubah Status Dokumen</h4>
														  </div>
														 <?php
														$attributes = array('role' => 'form','id' => 'formx');
														echo form_open('admin/verifikasi/change_status', $attributes);
														$datax = array(
																  'idx_pegawai'  => encrypt($data['idx']),
																  'flag' => encrypt($this->uri->segment(5))
																);
														echo form_hidden($datax);
														?>
														  <div class="modal-body">
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="2" checked="" type="radio">
																  <span class='badge bg-blue'>Proses</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="3" type="radio">
																  <span class='badge bg-green'>Valid</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="4" type="radio">
																  <span class='badge bg-red'>Tolak</span>
																</label>
															</div>
															<div class="form-group">
															  <label>Keterangan</label>
															  <textarea class="form-control" rows="3" name="keterangan" placeholder="Keterangan ..."></textarea>
															</div>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														  </div>
														  </form>
														</div><!-- /.modal-content -->
													  </div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													<!--</a>-->
													<?php }elseif(($data['stt_kumham'] == 1 && $prov != '' && $kabupaten!='')||($data['stt_kumham'] == 1 && $prov != '' && $kabupaten=='')){?>
													<center>
														<span type="button" class="label label-warning">Terkirim <i class="fa fa-check"></i></span>
													</center>	
													<?php }elseif($data['stt_kumham'] == 0){?>
													<a title="Kirim?" onclick="return confirm('Anda yakin kirim data ini ke pusat?');" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_kumham'])."/".encrypt($flag));?>">																						
													<center>
														<span class="label label-warning">Kirim &nbsp;<i class="fa fa-arrow-circle-o-up"></i></span>
													</center>
													<?php } ?>
													</a>
												</div>
											</h4>
											<div id='target2'>
												<?php
												$attributes = array('role' => 'form88','id' => 'form88');
												echo form_open_multipart('admin/verifikasi/insert_dokumen_kumham', $attributes); 
												$datas = array(
														  'id_pegawai'  => $data['idx'],
														  'nip'  => $data['nip'],
														  'nama'  => $data['nama'],
														  'no_ktp'  => $data['no_ktp'],
														  'no_sk_ppns'  => $data['no_sk_ppns'],
														  'flag' => $flag,
														  'jenis_berkas' => '');
												echo form_hidden($datas);
												?>
													<div class="transparent" style="padding-bottom:0px; margin-top:2px">
														<div id="filter_content2" class="col-md-6 box-contents" style="padding-bottom:0px; background:white; display:<?=$class_content?>">
														<table class="table table-condensed small-font" style="margin-top:;">
															<thead style="background:">
																<tr>
																	<td><h4><b>Lengkapi No. Surat Verifikasi</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Surat</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" size="300" name="tanggal_sp" class="form-control hasDatepicker" required="" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Nomor Surat</label></td>
																	<td>&nbsp;</td>
																</tr>															
																<tr>
																	<td><input name="ns" class="form-control" required="" placeholder="No. Surat Verifikasi" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type='file' name='file_name' required id='file88'></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary">Simpan</button></td>
																	<td>&nbsp;</td>
																</tr>
															</thead>
														</table>
														</div>
													</div>
												</form>
												<table class="table table-striped">
													<tr>
														
														<th width="100"><center>#</center></th>
														<th>Nomor Surat</th>
														<th>Tanggal Surat</th>
													</tr>
													<?php if(count($getSTTb2) > 0){?>
														<?php foreach($getSTTb2 as $row){
														?>
													<tr>
														
														<td><center>
															<a href="uploads/dokumen_sppp_data_pegawai/<?php echo $row['dokumen'];?>" title="Download"><i class="fa fa-download"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
															<a onclick="return confirm('Berkas akan dihapus?');" title="Delete" href="<?= base_url();?>admin/verifikasi/delete_berkas/<?php echo encrypt($row['idx']);?>/<?php echo $row['flag'];?>"><i class="fa fa-trash"></i></a>
															</center>													
														</td>
														
														<td><?=$row['no_surat'];?></td>
														<td><?=format_tanggal_db3($row['tanggal_sp'])?></td>
													</tr>
													<?php
														}
													}else{?>
													<tr>
														<td colspan="2">Tidak Ada Data</td>
														
													</tr>	
													<?php	
													}
													?>
												</table>						
											</div>				
										</div>
										<div class="col-md-4" >
											<h4 style="margin-top:10px;font-weight:bold;">Status Pengajuan</h4>
											<table class="table table-bordered">
												<tr>												
													<th width="100"><center>Tanggal</center></th>
													<th><center>Status</center></th>
													<th><center>Keterangan</center></th>
												</tr>
												<?php if(count($getLog) > 0){?>
													<?php foreach($getLog as $rowlog){?>
													<tr>												
														<td><?=date("d/m/Y", strtotime($rowlog['tanggal']));?></td>
														<td>
															<?php
															if($rowlog['status']==0 && $rowlog['status_dok']==4){
																echo "<span class='badge bg-red'>Tolak</span>";
															}elseif($rowlog['status']==2 && $rowlog['status_dok']==3){
																echo "<span class='badge bg-green'>Valid</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==2){
																echo "<span class='badge bg-blue'>Proses</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==1){
																echo "<span class='badge bg-yellow'>Terkirim</span>";
															}
															?>	
														</td>
														<td><?=$rowlog['keterangan']?></td>
													</tr>
												<?php }
												}else{ ?>
													<tr>
														<td colspan="3">Tidak ada log</td>
														
													</tr>
												<? } ?>
											</table>
										</div>
									</div>
								</div>
								
								<div role="tabpanel" class="tab-pane <?php if($flag=='c') echo 'active';?>" id="messages">
									<div class="row" >
										<div class="col-md-8" >
											<h4 style="margin-top:10px;border-bottom:0px solid #aaa;font-weight:bold;"> <a class="btn<?=$class_toggle?>" id="filter_toggle3"><i class="fa fa-plus bc-icon"></i> Tambah</a>
												<div style="float:right" >
												
													<?php if($data['stt_diklat'] == 1 && $prov == '' && $kabupaten==''){?>
													<!--<a title="Verified/Not Verified" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_diklat']));?>">	-->												
													<center>
														<span type="button" data-toggle="modal" data-target="#stt3" class="label label-warning">Ubah Status? <i class="fa fa"></i></span>
													</center>
													<div class="modal fade" id="stt3" tabindex="-1" role="dialog">
													  <div class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">Ubah Status Dokumen</h4>
														  </div>
														 <?php
														$attributes = array('role' => 'form','id' => 'formx');
														echo form_open('admin/verifikasi/change_status', $attributes);
														$datax = array(
																  'idx_pegawai'  => encrypt($data['idx']),
																  'flag' => encrypt($this->uri->segment(5))
																);
														echo form_hidden($datax);
														?>
														  <div class="modal-body">
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="2" checked="" type="radio">
																  <span class='badge bg-blue'>Proses</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="3" type="radio">
																  <span class='badge bg-green'>Valid</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="4" type="radio">
																  <span class='badge bg-red'>Tolak</span>
																</label>
															</div>
															<div class="form-group">
															  <label>Keterangan</label>
															  <textarea class="form-control" rows="3" name="keterangan" placeholder="Keterangan ..."></textarea>
															</div>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														  </div>
														  </form>
														</div><!-- /.modal-content -->
													  </div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													<!--</a>-->
													<?php }elseif(($data['stt_diklat'] == 1 && $prov != '' && $kabupaten!='')||($data['stt_diklat'] == 1 && $prov != '' && $kabupaten=='')){?>
													<center>
														<span type="button" class="label label-warning">Terkirim <i class="fa fa-check"></i></span>
													</center>	
													<?php }elseif($data['stt_diklat'] == 0){?>
													<a title="Kirim?" onclick="return confirm('Anda yakin kirim data ini ke pusat?');" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_diklat'])."/".encrypt($flag));?>">																						
													<center>
														<span class="label label-warning">Kirim &nbsp;<i class="fa fa-arrow-circle-o-up"></i></span>
													</center>
													<?php } ?>
													</a>
												</div>
											</h4>
											<div id='target2'>
												<?php
												$attributes = array('role' => 'form88','id' => 'form88');
												echo form_open_multipart('admin/verifikasi/insert_dokumen_kumham', $attributes); 
												$datab = array(
														  'id_pegawai'  => $data['idx'],
														  'nip'  => $data['nip'],
														  'nama'  => $data['nama'],
														  'no_ktp'  => $data['no_ktp'],
														  'no_sk_ppns'  => $data['no_sk_ppns'],
														  'flag' => $flag,
														  'jenis_berkas' => '');
												echo form_hidden($datab);
												?>
													<div class="transparent" style="padding-bottom:0px; margin-top:2px">
														<div id="filter_content3" class="col-md-6 box-contents" style="padding-bottom:0px; background:white; display:<?=$class_content?>">
														<table class="table table-condensed small-font" style="margin-top:;">
															<thead style="background:">
																<tr>
																	<td><h4><b>Lengkapi No. Surat</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Surat</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" name="tanggal_sp" class="form-control hasDatepicker" required="" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Nomor Surat</label></td>
																	<td>&nbsp;</td>
																</tr>															
																<tr>
																	<td><input name="ns" class="form-control" required="" placeholder="No. Surat Verifikasi" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type='file' name='file_name' required id='file88'></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary">Simpan</button></td>
																	<td>&nbsp;</td>
																</tr>
															</thead>
														</table>
														</div>
													</div>
												</form>
												<table class="table table-striped">
													<tr>
														
														<th width="100"><center>#</center></th>
														<th>Nomor Surat</th>
														<th>Tanggal Surat</th>
													</tr>
													<?php if(count($getSTTb3) > 0){?>
														<?php foreach($getSTTb3 as $row){
														// $fl = getDataURI("uploads/dokumen_sppp_data_pegawai/$row[dokumen]");
														?>
													<tr>
														
														<td><center>
															<a href="uploads/dokumen_sppp_data_pegawai/<?php echo $row['dokumen'];?>" title="Download"><i class="fa fa-download"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
															<a onclick="return confirm('Berkas akan dihapus?');" title="Delete" href="<?= base_url();?>admin/verifikasi/delete_berkas/<?php echo encrypt($row['idx']);?>/<?php echo $row['flag'];?>"><i class="fa fa-trash"></i></a>
															</center>													
														</td>
														
														<td><?=$row['no_surat'];?></td>
														<td><?=format_tanggal_db3($row['tanggal_sp'])?></td>
													</tr>
													<?php
														}
													}else{?>
													<tr>
														<td colspan="2">Tidak Ada Data</td>
														
													</tr>	
													<?php	
													}
													?>
												</table>						
											</div>				
										</div>
										<div class="col-md-4" >
											<h4 style="margin-top:10px;font-weight:bold;">Status Pengajuan</h4>
											<table class="table table-bordered">
												<tr>												
													<th width="100"><center>Tanggal</center></th>
													<th><center>Status</center></th>
													<th><center>Keterangan</center></th>
												</tr>
												<?php if(count($getLog) > 0){?>
													<?php foreach($getLog as $rowlog){?>
													<tr>												
														<td><?=date("d/m/Y", strtotime($rowlog['tanggal']));?></td>
														<td>
															<?php
															if($rowlog['status']==0 && $rowlog['status_dok']==4){
																echo "<span class='badge bg-red'>Tolak</span>";
															}elseif($rowlog['status']==2 && $rowlog['status_dok']==3){
																echo "<span class='badge bg-green'>Valid</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==2){
																echo "<span class='badge bg-blue'>Proses</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==1){
																echo "<span class='badge bg-yellow'>Terkirim</span>";
															}
															?>	
														</td>
														<td><?=$rowlog['keterangan']?></td>
													</tr>
												<?php }
												}else{ ?>
													<tr>
														<td colspan="3">Tidak ada log</td>
														
													</tr>
												<? } ?>
											</table>
										</div>
									</div>
								</div>
								
								<div role="tabpanel" class="tab-pane <?php if($flag=='d') echo 'active';?>" id="settings">
									<div class="row" >
										<div class="col-md-8" >
											<h4 style="margin-top:10px;border-bottom:0px solid #aaa;font-weight:bold;"> <a class="btn<?=$class_toggle?>" id="filter_toggle4"><i class="fa fa-plus bc-icon"></i> Tambah</a>
												<div style="float:right" >
												
													<?php if($data['stt_polri'] == 1 && $prov == '' && $kabupaten==''){?>
													<!--<a title="Verified/Not Verified" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_polri']));?>">	-->												
													<center>
														<span type="button" data-toggle="modal" data-target="#stt4" class="label label-warning">Ubah Status? <i class="fa fa"></i></span>
													</center>
													<div class="modal fade" id="stt4" tabindex="-1" role="dialog">
													  <div class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">Ubah Status Dokumen</h4>
														  </div>
														 <?php
														$attributes = array('role' => 'form','id' => 'formx');
														echo form_open('admin/verifikasi/change_status', $attributes);
														$datax = array(
																  'idx_pegawai'  => encrypt($data['idx']),
																  'flag' => encrypt($this->uri->segment(5))
																);
														echo form_hidden($datax);
														?>
														  <div class="modal-body">
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="2" checked="" type="radio">
																  <span class='badge bg-blue'>Proses</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="3" type="radio">
																  <span class='badge bg-green'>Valid</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="4" type="radio">
																  <span class='badge bg-red'>Tolak</span>
																</label>
															</div>
															<div class="form-group">
															  <label>Keterangan</label>
															  <textarea class="form-control" rows="3" name="keterangan" placeholder="Keterangan ..."></textarea>
															</div>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														  </div>
														  </form>
														</div><!-- /.modal-content -->
													  </div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													<!--</a>-->
													<?php }elseif(($data['stt_polri'] == 1 && $prov != '' && $kabupaten!='')||($data['stt_polri'] == 1 && $prov != '' && $kabupaten=='')){?>
													<center>
														<span type="button" class="label label-warning">Terkirim <i class="fa fa-check"></i></span>
													</center>	
													<?php }elseif($data['stt_polri'] == 0){?>
													<a title="Kirim?" onclick="return confirm('Anda yakin kirim data ini ke pusat?');" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_polri'])."/".encrypt($flag));?>">																						
													<center>
														<span class="label label-warning">Kirim &nbsp;<i class="fa fa-arrow-circle-o-up"></i></span>
													</center>
													<?php } ?>
													</a>
												</div>
											</h4>
											<div id='target2'>
												<?php
												$attributes = array('role' => 'form88','id' => 'form88');
												echo form_open_multipart('admin/verifikasi/insert_dokumen_kumham', $attributes); 
												$datas = array(
														  'id_pegawai'  => $data['idx'],
														  'nip'  => $data['nip'],
														  'nama'  => $data['nama'],
														  'no_ktp'  => $data['no_ktp'],
														  'no_sk_ppns'  => $data['no_sk_ppns'],
														  'flag' => $flag,
														  'jenis_berkas' => '');
												echo form_hidden($datas);
												?>
													<div class="transparent" style="padding-bottom:0px; margin-top:2px">
														<div id="filter_content4" class="col-md-6 box-contents" style="padding-bottom:0px; background:white; display:<?=$class_content?>">
														<table class="table table-condensed small-font" style="margin-top:;">
															<thead style="background:">
																<tr>
																	<td><h4><b>Lengkapi No. Surat</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Surat</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" name="tanggal_sp" class="form-control hasDatepicker" required="" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Nomor Surat</label></td>
																	<td>&nbsp;</td>
																</tr>															
																<tr>
																	<td><input name="ns" class="form-control" required="" placeholder="No. Surat Verifikasi" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type='file' name='file_name' required id='file88'></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary">Simpan</button></td>
																	<td>&nbsp;</td>
																</tr>
															</thead>
														</table>
														</div>
													</div>
												</form>
												<table class="table table-striped">
													<tr>
														
														<th width="100"><center>#</center></th>
														<th>Nomor Surat</th>
														<th>Tanggal Surat</th>
													</tr>
													<?php if(count($getSTTb4) > 0){?>
														<?php foreach($getSTTb4 as $row){
														// $fl = getDataURI("uploads/dokumen_sppp_data_pegawai/$row[dokumen]");
														?>
													<tr>
														
														<td><center>
															<a href="uploads/dokumen_sppp_data_pegawai/<?php echo $row['dokumen'];?>" title="Download"><i class="fa fa-download"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
															<a onclick="return confirm('Berkas akan dihapus?');" title="Delete" href="<?= base_url();?>admin/verifikasi/delete_berkas/<?php echo encrypt($row['idx']);?>/<?php echo $row['flag'];?>"><i class="fa fa-trash"></i></a>
															</center>													
														</td>
														
														<td><?=$row['no_surat'];?></td>
														<td><?=format_tanggal_db3($row['tanggal_sp'])?></td>
													</tr>
													<?php
														}
													}else{?>
													<tr>
														<td colspan="2">Tidak Ada Data</td>
														
													</tr>	
													<?php	
													}
													?>
												</table>						
											</div>				
										</div>
										<div class="col-md-4" >
											<h4 style="margin-top:10px;font-weight:bold;">Status Pengajuan</h4>
											<table class="table table-bordered">
												<tr>												
													<th width="100"><center>Tanggal</center></th>
													<th><center>Status</center></th>
													<th><center>Keterangan</center></th>
												</tr>
												<?php if(count($getLog) > 0){?>
													<?php foreach($getLog as $rowlog){?>
													<tr>												
														<td><?=date("d/m/Y", strtotime($rowlog['tanggal']));?></td>
														<td>
															<?php
															if($rowlog['status']==0 && $rowlog['status_dok']==4){
																echo "<span class='badge bg-red'>Tolak</span>";
															}elseif($rowlog['status']==2 && $rowlog['status_dok']==3){
																echo "<span class='badge bg-green'>Valid</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==2){
																echo "<span class='badge bg-blue'>Proses</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==1){
																echo "<span class='badge bg-yellow'>Terkirim</span>";
															}
															?>	
														</td>
														<td><?=$rowlog['keterangan']?></td>
													</tr>
												<?php }
												}else{ ?>
													<tr>
														<td colspan="3">Tidak ada log</td>
														
													</tr>
												<? } ?>
											</table>
										</div>
									</div>
								</div>
								
								<div role="tabpanel" class="tab-pane <?php if($flag=='e') echo 'active';?>" id="e">
									<div class="row" >
										<div class="col-md-8" >
											<h4 style="margin-top:10px;border-bottom:0px solid #aaa;font-weight:bold;"> <a class="btn<?=$class_toggle?>" id="filter_toggle5"><i class="fa fa-plus bc-icon"></i> Tambah</a>
												<div style="float:right" >
												
													<?php if($data['stt_kejagung'] == 1 && $prov == '' && $kabupaten==''){?>
													<!--<a title="Verified/Not Verified" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_kejagung']));?>">	-->												
													<center>
														<span type="button" data-toggle="modal" data-target="#stt5" class="label label-warning">Ubah Status? <i class="fa fa"></i></span>
													</center>
													<div class="modal fade" id="stt5" tabindex="-1" role="dialog">
													  <div class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">Ubah Status Dokumen</h4>
														  </div>
														 <?php
														$attributes = array('role' => 'form','id' => 'formx');
														echo form_open('admin/verifikasi/change_status', $attributes);
														$datax = array(
																  'idx_pegawai'  => encrypt($data['idx']),
																  'flag' => encrypt($this->uri->segment(5))
																);
														echo form_hidden($datax);
														?>
														  <div class="modal-body">
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="2" checked="" type="radio">
																  <span class='badge bg-blue'>Proses</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="3" type="radio">
																  <span class='badge bg-green'>Valid</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="4" type="radio">
																  <span class='badge bg-red'>Tolak</span>
																</label>
															</div>
															<div class="form-group">
															  <label>Keterangan</label>
															  <textarea class="form-control" rows="3" name="keterangan" placeholder="Keterangan ..."></textarea>
															</div>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														  </div>
														  </form>
														</div><!-- /.modal-content -->
													  </div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													<!--</a>-->
													<?php }elseif(($data['stt_kejagung'] == 1 && $prov != '' && $kabupaten!='')||($data['stt_kejagung'] == 1 && $prov != '' && $kabupaten=='')){?>
													<center>
														<span type="button" class="label label-warning">Terkirim <i class="fa fa-check"></i></span>
													</center>	
													<?php }elseif($data['stt_kejagung'] == 0){?>
													<a title="Kirim?" onclick="return confirm('Anda yakin kirim data ini ke pusat?');" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_kejagung'])."/".encrypt($flag));?>">																						
													<center>
														<span class="label label-warning">Kirim &nbsp;<i class="fa fa-arrow-circle-o-up"></i></span>
													</center>
													<?php } ?>
													</a>
												</div>
											</h4>
											<div id='target2'>
												<?php
												$attributes = array('role' => 'form88','id' => 'form88');
												echo form_open_multipart('admin/verifikasi/insert_dokumen_kumham', $attributes); 
												$datas = array(
														  'id_pegawai'  => $data['idx'],
														  'nip'  => $data['nip'],
														  'nama'  => $data['nama'],
														  'no_ktp'  => $data['no_ktp'],
														  'no_sk_ppns'  => $data['no_sk_ppns'],
														  'flag' => $flag,
														  'jenis_berkas' => '');
												echo form_hidden($datas);
												?>
													<div class="transparent" style="padding-bottom:0px; margin-top:2px">
														<div id="filter_content5" class="col-md-6 box-contents" style="padding-bottom:0px; background:white; display:<?=$class_content?>">
														<table class="table table-condensed small-font" style="margin-top:;">
															<thead style="background:">
																<tr>
																	<td><h4><b>Lengkapi No. Surat</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Surat</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" name="tanggal_sp" class="form-control hasDatepicker" required="" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Nomor Surat</label></td>
																	<td>&nbsp;</td>
																</tr>															
																<tr>
																	<td><input name="ns" class="form-control" required="" placeholder="No. Surat Verifikasi" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type='file' name='file_name' required id='file88'></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary">Simpan</button></td>
																	<td>&nbsp;</td>
																</tr>
															</thead>
														</table>
														</div>
													</div>
												</form>

												<table class="table table-striped">
													<tr>
														
														<th width="100"><center>#</center></th>
														<th>Nomor Surat</th>
														<th>Tanggal Surat</th>
													</tr>
													<?php if(count($getSTTb5) > 0){?>
														<?php foreach($getSTTb5 as $row){
														// $fl = getDataURI("uploads/dokumen_sppp_data_pegawai/$row[dokumen]");
														?>
													<tr>
														
														<td><center>
															<a href="uploads/dokumen_sppp_data_pegawai/<?php echo $row['dokumen'];?>" title="Download"><i class="fa fa-download"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
															<a onclick="return confirm('Berkas akan dihapus?');" title="Delete" href="<?= base_url();?>admin/verifikasi/delete_berkas/<?php echo encrypt($row['idx']);?>/<?php echo $row['flag'];?>"><i class="fa fa-trash"></i></a>
															</center>													
														</td>
														
														<td><?=$row['no_surat'];?></td>
														<td><?=format_tanggal_db3($row['tanggal_sp'])?></td>
													</tr>
													<?php
														}
													}else{?>
													<tr>
														<td colspan="2">Tidak Ada Data</td>
														
													</tr>	
													<?php	
													}
													?>
												</table>						
											</div>				
										</div>
										<div class="col-md-4" >
											<h4 style="margin-top:10px;font-weight:bold;">Status Pengajuan</h4>
											<table class="table table-bordered">
												<tr>												
													<th width="100"><center>Tanggal</center></th>
													<th><center>Status</center></th>
													<th><center>Keterangan</center></th>
												</tr>
												<?php if(count($getLog) > 0){?>
													<?php foreach($getLog as $rowlog){?>
													<tr>												
														<td><?=date("d/m/Y", strtotime($rowlog['tanggal']));?></td>
														<td>
															<?php
															if($rowlog['status']==0 && $rowlog['status_dok']==4){
																echo "<span class='badge bg-red'>Tolak</span>";
															}elseif($rowlog['status']==2 && $rowlog['status_dok']==3){
																echo "<span class='badge bg-green'>Valid</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==2){
																echo "<span class='badge bg-blue'>Proses</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==1){
																echo "<span class='badge bg-yellow'>Terkirim</span>";
															}
															?>	
														</td>
														<td><?=$rowlog['keterangan']?></td>
													</tr>
												<?php }
												}else{ ?>
													<tr>
														<td colspan="3">Tidak ada log</td>
														
													</tr>
												<? } ?>
											</table>
										</div>
									</div>
								</div>
								
								<div role="tabpanel" class="tab-pane <?php if($flag=='f') echo 'active';?>" id="f">
									<div class="row" >
										<div class="col-md-8" >
											<h4 style="margin-top:10px;border-bottom:0px solid #aaa;font-weight:bold;"> <a class="btn<?=$class_toggle?>" id="filter_toggle6"><i class="fa fa-plus bc-icon"></i> Tambah</a>
												<div style="float:right" >
												
													<?php if($data['stt_skep'] == 1 && $prov == '' && $kabupaten==''){?>
													<!--<a title="Verified/Not Verified" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_skep']));?>">	-->												
													<center>
														<span type="button" data-toggle="modal" data-target="#stt6" class="label label-warning">Ubah Status? <i class="fa fa"></i></span>
													</center>
													<div class="modal fade" id="stt6" tabindex="-1" role="dialog">
													  <div class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">Ubah Status Dokumen</h4>
														  </div>
														 <?php
														$attributes = array('role' => 'form','id' => 'formx');
														echo form_open('admin/verifikasi/change_status', $attributes);
														$datax = array(
																  'idx_pegawai'  => encrypt($data['idx']),
																  'flag' => encrypt($this->uri->segment(5))
																);
														echo form_hidden($datax);
														?>
														  <div class="modal-body">
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="2" checked="" type="radio">
																  <span class='badge bg-blue'>Proses</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="3" type="radio">
																  <span class='badge bg-green'>Valid</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="4" type="radio">
																  <span class='badge bg-red'>Tolak</span>
																</label>
															</div>
															<div class="form-group">
															  <label>Keterangan</label>
															  <textarea class="form-control" rows="3" name="keterangan" placeholder="Keterangan ..."></textarea>
															</div>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														  </div>
														  </form>
														</div><!-- /.modal-content -->
													  </div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													<!--</a>-->
													<?php }elseif(($data['stt_skep'] == 1 && $prov != '' && $kabupaten!='')||($data['stt_skep'] == 1 && $prov != '' && $kabupaten=='')){?>
													<center>
														<span type="button" class="label label-warning">Terkirim <i class="fa fa-check"></i></span>
													</center>	
													<?php }elseif($data['stt_skep'] == 0){?>
													<a title="Kirim?" onclick="return confirm('Anda yakin kirim data ini ke pusat?');" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_skep'])."/".encrypt($flag));?>">																						
													<center>
														<span class="label label-warning">Kirim &nbsp;<i class="fa fa-arrow-circle-o-up"></i></span>
													</center>
													<?php } ?>
													</a>
												</div>
											</h4>
											<div id='target2'>
												<?php
												$attributes = array('role' => 'form88','id' => 'form88');
												echo form_open_multipart('admin/verifikasi/insert_dokumen_kumham', $attributes); 
												$datas = array(
														  'id_pegawai'  => $data['idx'],
														  'nip'  => $data['nip'],
														  'nama'  => $data['nama'],
														  'no_ktp'  => $data['no_ktp'],
														  'no_sk_ppns'  => $data['no_sk_ppns'],
														  'flag' => $flag,
														  'jenis_berkas' => '');
												echo form_hidden($datas);
												?>
													<div class="transparent" style="padding-bottom:0px; margin-top:2px">
														<div id="filter_content6" class="col-md-6 box-contents" style="padding-bottom:0px; background:white; display:<?=$class_content?>">
														<table class="table table-condensed small-font" style="margin-top:;">
															<thead style="background:">
																<tr>
																	<td><h4><b>Lengkapi No. Surat</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Surat</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" name="tanggal_sp" class="form-control hasDatepicker" required="" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Nomor Surat</label></td>
																	<td>&nbsp;</td>
																</tr>															
																<tr>
																	<td><input name="ns" class="form-control" required="" placeholder="No. Surat Verifikasi" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type='file' name='file_name' id='file88'></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary">Simpan</button></td>
																	<td>&nbsp;</td>
																</tr>
															</thead>
														</table>
														</div>
													</div>
												</form>

												<table class="table table-striped">
													<tr>
														
														<th width="100"><center>#</center></th>
														<th>Nomor Surat</th>
														<th>Tanggal Surat</th>
													</tr>
													<?php if(count($getSTTb6) > 0){?>
														<?php foreach($getSTTb6 as $row){
														// $fl = getDataURI("uploads/dokumen_sppp_data_pegawai/$row[dokumen]");
														?>
													<tr>
														
														<td><center>
															<a href="uploads/dokumen_sppp_data_pegawai/<?php echo $row['dokumen'];?>" title="Download"><i class="fa fa-download"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
															<a onclick="return confirm('Berkas akan dihapus?');" title="Delete" href="<?= base_url();?>admin/verifikasi/delete_berkas/<?php echo encrypt($row['idx']);?>/<?php echo $row['flag'];?>"><i class="fa fa-trash"></i></a>
															</center>													
														</td>
														
														<td><?=$row['no_surat'];?></td>
														<td><?=format_tanggal_db3($row['tanggal_sp'])?></td>
													</tr>
													<?php
														}
													}else{?>
													<tr>
														<td colspan="3">Tidak ada log</td>
														
													</tr>	
													<?php	
													}
													?>
												</table>						
											</div>				
										</div>
										<div class="col-md-4" >
											<h4 style="margin-top:10px;font-weight:bold;">Status Pengajuan</h4>
											<table class="table table-bordered">
												<tr>												
													<th width="100"><center>Tanggal</center></th>
													<th><center>Status</center></th>
													<th><center>Keterangan</center></th>
												</tr>
												<?php if(count($getLog) > 0){?>
													<?php foreach($getLog as $rowlog){?>
													<tr>												
														<td><?=date("d/m/Y", strtotime($rowlog['tanggal']));?></td>
														<td>
															<?php
															if($rowlog['status']==0 && $rowlog['status_dok']==4){
																echo "<span class='badge bg-red'>Tolak</span>";
															}elseif($rowlog['status']==2 && $rowlog['status_dok']==3){
																echo "<span class='badge bg-green'>Valid</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==2){
																echo "<span class='badge bg-blue'>Proses</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==1){
																echo "<span class='badge bg-yellow'>Terkirim</span>";
															}
															?>	
														</td>
														<td><?=$rowlog['keterangan']?></td>
													</tr>
												<?php }
												}else{ ?>
													<tr>
														<td colspan="3">Tidak ada log</td>
														
													</tr>
												<? } ?>
											</table>
										</div>
									</div>
								</div>
								
								<div role="tabpanel" class="tab-pane <?php if($flag=='g') echo 'active';?>" id="g">
									<div class="row" >
										<div class="col-md-8" >
											<h4 style="margin-top:10px;border-bottom:0px solid #aaa;font-weight:bold;"> <a class="btn<?=$class_toggle?>" id="filter_toggle7"><i class="fa fa-plus bc-icon"></i> Tambah</a>
												<div style="float:right" >
													<?php if($data['stt_pelantikan'] == 1 && $prov == '' && $kabupaten==''){?>
													<!--<a title="Verified/Not Verified" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_pelantikan']));?>">	-->												
													<center>
														<span type="button" data-toggle="modal" data-target="#stt7" class="label label-warning">Ubah Status? <i class="fa fa"></i></span>
													</center>
													<div class="modal fade" id="stt7" tabindex="-1" role="dialog">
													  <div class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">Ubah Status Dokumen</h4>
														  </div>
														 <?php
														$attributes = array('role' => 'form','id' => 'formx');
														echo form_open('admin/verifikasi/change_status', $attributes);
														$datax = array(
																  'idx_pegawai'  => encrypt($data['idx']),
																  'flag' => encrypt($this->uri->segment(5))
																);
														echo form_hidden($datax);
														?>
														  <div class="modal-body">
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="2" checked="" type="radio">
																  <span class='badge bg-blue'>Proses</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="3" type="radio">
																  <span class='badge bg-green'>Valid</span>
																</label>
															</div>
															<div class="radio">
																<label>
																  <input name="status_dok" id="status_dok" value="4" type="radio">
																  <span class='badge bg-red'>Tolak</span>
																</label>
															</div>
															<div class="form-group">
															  <label>Keterangan</label>
															  <textarea class="form-control" rows="3" name="keterangan" placeholder="Keterangan ..."></textarea>
															</div>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														  </div>
														  </form>
														</div><!-- /.modal-content -->
													  </div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													<!--</a>-->
													<?php }elseif(($data['stt_pelantikan'] == 1 && $prov != '' && $kabupaten!='')||($data['stt_pelantikan'] == 1 && $prov != '' && $kabupaten=='')){?>
													<center>
														<span type="button" class="label label-warning">Terkirim <i class="fa fa-check"></i></span>
													</center>	
													<?php }elseif($data['stt_pelantikan'] == 0){?>
													<a title="Kirim?" onclick="return confirm('Anda yakin kirim data ini ke pusat?');" href="<?php echo site_url("admin/verifikasi/publish/".encrypt($data['idx'])."/".encrypt($data['stt_pelantikan'])."/".encrypt($flag));?>">																						
													<center>
														<span class="label label-warning">Kirim &nbsp;<i class="fa fa-arrow-circle-o-up"></i></span>
													</center>
													<?php } ?>
													</a>
												</div>
											</h4>
											<div id='target2'>
												<?php
												$attributes = array('role' => 'form88','id' => 'form88');
												echo form_open_multipart('admin/verifikasi/insert_dokumen_kumham', $attributes); 
												$datas = array(
														  'id_pegawai'  => $data['idx'],
														  'nip'  => $data['nip'],
														  'nama'  => $data['nama'],
														  'no_ktp'  => $data['no_ktp'],
														  'no_sk_ppns'  => $data['no_sk_ppns'],
														  'flag' => $flag,
														  'jenis_berkas' => '');
												echo form_hidden($datas);
												?>
													<div class="transparent" style="padding-bottom:0px; margin-top:2px">
														<div id="filter_content7" class="col-md-6 box-contents" style="padding-bottom:0px; background:white; display:<?=$class_content?>">
														<table class="table table-condensed small-font" style="margin-top:;">
															<thead style="background:">
																<tr>
																	<td><h4><b>Lengkapi No. Surat</b></h4></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Tanggal Surat</label></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input id="datepicker8" name="tanggal_sp" class="form-control hasDatepicker" required="" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><label>Nomor Surat</label></td>
																	<td>&nbsp;</td>
																</tr>															
																<tr>
																	<td><input name="ns" class="form-control" required="" placeholder="No. Surat Verifikasi" type="text"></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><input type='file' name='file_name' id='file88'></td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td><button type="submit" name="save2" value="Simpan" class="btn btn-primary">Simpan</button></td>
																	<td>&nbsp;</td>
																</tr>
															</thead>
														</table>
														</div>
													</div>
												</form>

												<table class="table table-striped">
													<tr>
														
														<th width="100"><center>#</center></th>
														<th>Nomor Surat</th>
														<th>Tanggal Surat</th>
													</tr>
													<?php if(count($getSTTb7) > 0){?>
														<?php foreach($getSTTb7 as $row){
														// $fl = getDataURI("uploads/dokumen_sppp_data_pegawai/$row[dokumen]");
														?>
													<tr>
														
														<td><center>
															<a href="uploads/dokumen_sppp_data_pegawai/<?php echo $row['dokumen'];?>" title="Download"><i class="fa fa-download"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
															<a onclick="return confirm('Berkas akan dihapus?');" title="Delete" href="<?= base_url();?>admin/verifikasi/delete_berkas/<?php echo encrypt($row['idx']);?>/<?php echo $row['flag'];?>"><i class="fa fa-trash"></i></a>
															</center>													
														</td>
														
														<td><?=$row['no_surat'];?></td>
														<td><?=format_tanggal_db3($row['tanggal_sp'])?></td>
													</tr>
													<?php
														}
													}else{?>
													<tr>
														<td colspan="2">Tidak Ada Data</td>
														
													</tr>	
													<?php	
													}
													?>
												</table>						
											</div>				
										</div>
										<div class="col-md-4" >
											<h4 style="margin-top:10px;font-weight:bold;">Status Pengajuan</h4>
											<table class="table table-bordered">
												<tr>												
													<th width="100"><center>Tanggal</center></th>
													<th><center>Status</center></th>
													<th><center>Keterangan</center></th>
												</tr>
												<?php if(count($getLog) > 0){?>
													<?php foreach($getLog as $rowlog){?>
													<tr>												
														<td><?=date("d/m/Y", strtotime($rowlog['tanggal']));?></td>
														<td>
															<?php
															if($rowlog['status']==0 && $rowlog['status_dok']==4){
																echo "<span class='badge bg-red'>Tolak</span>";
															}elseif($rowlog['status']==2 && $rowlog['status_dok']==3){
																echo "<span class='badge bg-green'>Valid</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==2){
																echo "<span class='badge bg-blue'>Proses</span>";
															}elseif($rowlog['status']==1 && $rowlog['status_dok']==1){
																echo "<span class='badge bg-yellow'>Terkirim</span>";
															}
															?>	
														</td>
														<td><?=$rowlog['keterangan']?></td>
													</tr>
												<?php }
												}else{ ?>
													<tr>
														<td colspan="3">Tidak ada log</td>
														
													</tr>
												<? } ?>
											</table>
										</div>
									</div>
								</div>
								
							</div>
						</div>
						
								
						<div class="col-md-6">
							<div class="row">

								
								
								
								
									
								
								
							</div>
						</div>							
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
		$("#add").select2({
		placeholder:"-Pilih Berkas-"
		});	
	});		
</script>
<script>  
    $(document).ready(function () {
		$("#filter_toggle").click(function(){
			$(this).toggleClass("active");
			$("#filter_content").slideToggle();
		});
		$("#filter_toggle2").click(function(){
			$(this).toggleClass("active");
			$("#filter_content2").slideToggle();
		});
		$("#filter_toggle3").click(function(){
			$(this).toggleClass("active");
			$("#filter_content3").slideToggle();
		});
		$("#filter_toggle4").click(function(){
			$(this).toggleClass("active");
			$("#filter_content4").slideToggle();
		});
		$("#filter_toggle5").click(function(){
			$(this).toggleClass("active");
			$("#filter_content5").slideToggle();
		});
		$("#filter_toggle6").click(function(){
			$(this).toggleClass("active");
			$("#filter_content6").slideToggle();
		});
		$("#filter_toggle7").click(function(){
			$(this).toggleClass("active");
			$("#filter_content7").slideToggle();
		});
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
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '300px');
                //$('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>

