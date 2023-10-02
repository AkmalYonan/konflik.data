<?php 
if ($_POST['provinsi'] || $_POST['kabupaten'] || $_POST['skpd'] || $_POST['sort'] || $_POST['q']) {
	$class_toggle=" active";
	$class_content="";
}else {
	$class_toggle="";
	$class_content="none";
}
?>
<?php 
	$q=$this->input->get_post("q",TRUE);
	$provinsi=$this->input->get_post("provinsi",TRUE);
	$kabs=$this->input->get_post("kabupaten",TRUE);
	$skpdx=$this->input->get_post("skpd",TRUE);
	$q=$q?$q:"";
	$provinsi=$provinsi?$provinsi:"";
	$kabs=$kabs?$kabs:"";
	$skpdx=$skpdx?$skpdx:"";
?>
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>List <small>Verifikasi Berkas</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active"><?=$this->module_title?> Berkas</li>
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
							<i class="fa fa-refresh"></i> Refresh
						</a>
						<a id="filter_toggle" class="btn btn-default pull-right" >
							<i class="fa fa-search"></i> Search
						</a>
						
						<!--<form class="search_form col-md-3 pull-right" action="<?//=$this->module?>listview" method="get">
						<?php //$this->load->view("widget/search_box_db"); ?>
						</form>-->
						</div>
					</div>
				</div>
			</div><!-- ./box-body -->
			<form id="src" class="search_form" style="background:none" action="<?=$this->module?>listview" method="post">
				<div class="box transparent" style=" margin-top:-20px;border:0px;">
						<div id="filter_content" class="box-content" style="padding-bottom:0px; background:#eeee; display:<?=$class_content?>">
						<table class="table table-condensed small-font" style="margin-bottom:0;">
						<thead style="background:#eee">
							<td>Provinsi</td>
							<td>Kabupaten</td>
							<td>SKPD</td>
							<td></td>
							<td></td>
						</thead>
						<tbody>
							<tr>
								<td>
									<select class="form-control" name="provinsi" id="prov" >						
									<?php 
										if($prov == ''){
											echo "<option value=''>- Pilih Provinsi -</option>";
										}
										// $jsonData = file_get_contents($services_prov."?kode_wilayah=00");
										$jsonData = file_get_contents($services_prov."propinsi");
										$phpArray = json_decode($jsonData, true);
										foreach($phpArray as $rows){
											if($rows['kode_dagri'] == $provinsi){
												$selected = 'selected="selected"';
											}else{
												$selected = '';
											}	
											if($prov == $rows['kode_dagri']){
												echo "<option selected value='".$rows['kode_dagri']."'>$rows[nama_wilayah]</option>"; 
											}
											if($prov == ''){
												echo "<option $selected value='".$rows['kode_dagri']."'>$rows[nama_wilayah]</option>"; 	  
											}
											
										}
									?>           
									</select> 
								</td>
								<td>
								   <select class="form-control" name="kabupaten" id="kab" width='200'>
								<?php 
									if($prov == '' && $kabupaten ==''){
										echo "<option value=''>- Pilih Kabupaten -</option>";
									}
									if($prov != '' && $kabupaten ==''){
										echo "<option value=''>- Pilih Kabupaten -</option>";	
									}
									// $jsonData = file_get_contents($services_prov."?kode_dagri=$prov");
									$jsonData = file_get_contents($services_prov."kabupaten/$prov");
									$phpArray = json_decode($jsonData, true);
									if(!$_POST){
										if($prov != ''){
											foreach($phpArray as $rowk):
												if($rowk['kode_dagri'] == $kabs){
													$selected = 'selected="selected"';
												}else{
													$selected = '';
												}	
												$kdkab = $rowk['kode_dagri'];  
												if($kdkab == $kabupaten){
													echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";											 
												}
												if($prov !='' && $kabupaten ==''){
													echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";	
												}
												endforeach;
										}
									}
									if($_POST){
										$jsonData = file_get_contents($services_prov."kabupaten/$provinsi");
										$phpArray = json_decode($jsonData, true);
										foreach($phpArray as $rowk):
											if($rowk['kode_dagri'] == $kabs){
												$selected = 'selected="selected"';
											}else{
												$selected = '';
											}	
											$kdkab = $rowk['kode_dagri'];  
											if($kdkab == $kabupaten){
												echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";											 
											}
											if($prov !='' && $kabupaten ==''){
												echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";	
											}
											if($provinsi || $kabs){
												echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";	
											}
										endforeach;
									}		
								?>
							</select>
								</td>
								<td>
								   <select name="skpd" class="form-control">
									<option value=''>- Pilih SKPD -</option>
									<? foreach($m_skpd as $rows):
											if($skpdx == $rows['nama']){
												$selected = 'selected="selected"';
											}else{
												$selected = '';
											}	
											if($skpd == ''){?>
												<option <?=$selected;?> value="<?=$rows['nama'];?>"><?=$rows['nama'];?></option>
											<?}elseif($skpd != ''){
												if($skpd ==  $rows['nama']){?>
													<option selected value="<?=$rows['nama'];?>"><?=$rows['nama'];?></option>
												<?}
											}?>
									<? endforeach; ?>
								</select>
								</td>
								<td>
									<div>
									<input type="text" id="q" name="q" class="form-control" value="<?=$q?>" placeholder="Search...">
									</div>
								</td>
								<td>
									<button type="submit" class="btn btn-primary">Search</button> <!--<button class="btn btn-warning" type="reset">Reset</button>-->
								</td>
							</tr>
						</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		<div class="box-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<tr>
							<th>No</th>
							<th><center>Tgl Pengajuan</center></th>
							<th><center>NIP, Nama</center></th>
							<th><center>Provinsi, Kabupaten</center></th>
							<th><center>SKPD</center></th>
							<!-- ADMIN -->
							<?php if(($level_user == 'op1')){?>
							<th width="100"><center>Verifikasi <br >PUM</center></th>
							<th width="100"><center>Verifikasi <br >KUMHAM</center></th>
							<th width="100"><center>Lulus Diklat</center></th>
							<th width="100"><center>Rekomendasi POLRI</center></th>
							<th width="100"><center>Rekomendasi KEJAGUNG</center></th>
							<th width="120"><center>SKEP/KTP Dari KUMHAM</center></th>
							<th width="100"><center>Pelantikan</center></th>
							<?php } if($level_user == 'op2'){?> <!-- KUMHAM -->
							<th width="100"><center>Verifikasi KUMHAM</center></th>
							<?php } if($level_user == 'op3'){?> <!-- Lulus Diklat -->
							<th width="100"><center>Lulus Diklat</center></th>
							<?php } if($level_user == 'op4'){?> <!-- POLRI  -->
							<th width="100"><center>Rekomendasi POLRI</center></th>
							<?php } if($level_user == 'op5'){?> <!-- KEJAGUNG -->
							<th width="100"><center>Rekomendasi KEJAGUNG</center></th>
							<?php } if($level_user == 'op6'){?> <!-- SKEP -->
							<th width="120"><center>SKEP/KTP Dari KUMHAM</center></th>
							<th width="100"><center>Pelantikan</center></th>
							<?php } if($level_user == 'op7'){?> <!-- PELANTIKAN -->
							<th width="100"><center>Pelantikan</center></th>
							<?php } ?>
						</tr>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($query_brks as $key1){
						$a[] = $key1['kode'];
					}
					if(count($arrData) == 0){?>
						<tr>
							<td colspan='10'><center><b>Data tidak ditemukan</b></center></td>
						</tr>
					<?php }else{
					$i = 1;
					$tot = 6;
					$one = 1;
					foreach($arrData as $key):
						$data['countA'] = $this->verifikasi_model->countFlagNew($key['idx']);
							$data['a'] = count($data['countA']);
							// pre($data['a']);
						$data['countB'] = $this->verifikasi_model->countFlag($key['idx'],'b');
							$data['b'] = count($data['countB']);
						$data['countC'] = $this->verifikasi_model->countFlag($key['idx'],'c');
							$data['c'] = count($data['countC']);
						$data['countD'] = $this->verifikasi_model->countFlag($key['idx'],'d');
							$data['d'] = count($data['countD']);
						$data['countE'] = $this->verifikasi_model->countFlag($key['idx'],'e');
							$data['e'] = count($data['countE']);
						$data['countF'] = $this->verifikasi_model->countFlag($key['idx'],'f');
							$data['f'] = count($data['countF']);
						$data['countG'] = $this->verifikasi_model->countFlag($key['idx'],'g');
							$data['g'] = count($data['countG']);
					?>
					<tr>
						<td><?=$i;?></td>
						<td><?=format_tanggal_db3($key['tanggal_pengajuan']);?></td>
						<td><?=$key['nip'];?>, <?=$key['nama'];?></td>
						<td>
							<?php 
								// $jsonData = file_get_contents($services_prov."?kode_wilayah=00");
								$jsonData = file_get_contents($services_prov."propinsi");
								$phpArray = json_decode($jsonData, true);
								foreach($phpArray as $row){
									  $kdprov = $row['kode_dagri'];  
										if($kdprov == $key['propinsi']){
											echo "$row[nama_wilayah]"; 	
										}
									}
								?>, 
								<?php 
									// $jsonData = file_get_contents($services_prov."?kode_dagri=$key[id_propinsi]");
									$jsonData = file_get_contents($services_prov."kabupaten/$key[id_propinsi]");
									$phpArray = json_decode($jsonData, true);
									foreach($phpArray as $rowk):
									  $kdkab = $rowk['kode_dagri'];  
									  if($kdkab == $key['kabupaten']){
										 echo "$rowk[nama_wilayah]";
										} 
								?>
								<?php endforeach;?>  
						</td>
						<td><?=$key['skpd'];?></td>
						<!-- ADMIN -->
						<style>
							span div.tooltip_ar{
								display:none;
								padding:10px;
								background:white;
								color:black;
								font-size:11px;
								position:absolute;
								border-radius:3px;
								-moz-border-radius:3px;
								-webkit-border-radius:3px;
								text-align:left;
								box-shadow: 5px 5px 30px rgba(0,0,0,0.5);
							}
							span:hover div.tooltip_ar{display:inline;position:absolute;left:30px;top:-10px;z-index:200}
							
						</style>
<!-- OP1 -->
						<?php if(($level_user == 'op1')){?>
						<td>
							<?php 
							if($key['status']==2){?>
							<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/a">
							<center>
								<span class="label label-success">Completed</span>
							</center>
							</a>
							<?php }elseif($data['a'] == 0){ ?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/a">
								
								<span class="badge bg-red">
									<div class="tooltip_ar">
										<?php
										$query_com = $this->verifikasi_model->getBerkasAllNew($key['idx']);
										// pre($query_com);
										foreach ($query_com as $key2){						
											$b[] = $key2['nm_file'];						
										}
										if(!isset($b)){
											$c = $a;
										}else{
											$c = array_diff($a,$b);
										}
										foreach($c as $y){
												// echo $y."<br />";
												foreach ($query_brks as $key11){
													
													if($key11['kode'] == $y){
														echo "- ".$key11['nm_berkas']."<br />";  
													  }
												}
										}
										?>
									</div>
								<?php if($data['a'] < $tot) echo $tot - $data['a']; else $tot; ?>
								</span>
								Pending
							</a>
							<?php }elseif($data['a'] < $tot){ ?>
							<a class="btn btn-app " style="background:#f0ad4e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/a">
								<span class="badge bg-red">
									<div class="tooltip_ar">
										<?php
										$query_com = $this->verifikasi_model->getBerkasAllNew($key['idx']);
										$f = array();
										foreach ($query_com as $key2){
											$f[] = $key2['nm_file'];						
										}
										$g = array_diff($a,$f);
										foreach($g as $y){
												// echo $y."<br />";
												foreach ($query_brks as $key1){
													
													if($key1['kode'] == $y){
														echo "- ".$key1['nm_berkas']."<br />"; 
													  }
												}
										}
										?>
									</div>
								<?php if($data['a'] < $tot) echo $tot - $data['a']; else $tot; ?>
								</span>
								Pending
							</a>
							<?php }elseif(($key['status']==0 && $data['a'] <= $tot) || ($key['status']==1 && $data['a'] <= $tot)){ ?>
							<a class="btn btn-app " style="background:#f0ad4e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/a">
								<span class="badge bg-red">
									<div class="tooltip_ar">
										<?php
										$query_com = $this->verifikasi_model->getBerkasAllNew($key['idx']);
										$f = array();
										foreach ($query_com as $key2){
											$f[] = $key2['nm_file'];						
										}
										$g = array_diff($a,$f);
										foreach($g as $y){
												// echo $y."<br />";
												foreach ($query_brks as $key1){
													
													if($key1['kode'] == $y){
														echo "- ".$key1['nm_berkas']."<br />"; 
													  }
												}
										}
										?>
									</div>
								<?php //if($data['a'] < $tot) echo $tot - $data['a']; else $tot; ?>0
								</span>
								Pending
							</a>
							<?php } ?>
							
							
						</td>
						<td>
							<?php
							if($key['status'] == 2){
								if($key['stt_kumham'] == 2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/b">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/b">
								<!--<span class="badge bg-red"><?php //if($data['b'] < $one) echo $one - $data['b']; else $one; ?></span>-->
								Pending
								</a>
							<?php }
							}else{ ?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" >
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						<td>
							<?php 
							if($key['stt_kumham']==2 && $key['status'] == 2 ){
								if($key['stt_diklat']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/c">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/c">
								<!--<span class="badge bg-red"><?php //if($data['c'] < $one) echo $one - $data['c']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" >
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						<td>
							<?php 
							if($key['stt_kumham']==2 && $key['status'] == 2 && $key['stt_diklat']==2){
								if($key['stt_polri']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/d">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/d">
								<!--<span class="badge bg-red"><?php //if($data['d'] < $one) echo $one - $data['d']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						<td>
							<?php 
							if($key['stt_kumham']==2 && $key['status'] == 2 && $key['stt_diklat']==2 && $key['stt_polri']==2){
								if($key['stt_kejagung']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/e">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/e">
								<!--<span class="badge bg-red"><?php //if($data['e'] < $one) echo $one - $data['e']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						<td>
							<?php
							if($key['stt_kumham']==2 && $key['status'] == 2 && $key['stt_diklat']==2 && $key['stt_polri']==2 && $key['stt_kejagung']==2){
								if($key['stt_skep']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/f">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/f">
								<!--<span class="badge bg-red"><?php //if($data['f'] < $one) echo $one - $data['f']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						<td>
							<?php
							if($key['stt_kumham']==2 && $key['status'] == 2 && $key['stt_diklat']==2 && $key['stt_polri']==2 && $key['stt_kejagung']==2 && $key['stt_skep']){
								if($key['stt_pelantikan']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/g">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/g">
								<!--<span class="badge bg-red"><?php //if($data['g'] < $one) echo $one - $data['g']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						
<!-- OP2 --><!-- KUMHAM -->						
						<?php } if($level_user == 'op2'){?> <!-- KUMHAM -->
						<td>
							<?php
							if($key['status'] == 2){
								if($key['stt_kumham'] == 2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/b">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/b">
								<!--<span class="badge bg-red"><?php //if($data['b'] < $one) echo $one - $data['b']; else $one; ?></span>-->
								Pending
								</a>
							<?php }
							}else{ ?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						
<!-- OP3 --><!-- Lulus Diklat -->					
						<?php } if($level_user == 'op3'){?> <!-- Lulus Diklat -->
						<td>
							<?php 
							if($key['stt_kumham']==2 && $key['status'] == 2 ){
								if($key['stt_diklat']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/c">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/c">
								<!--<span class="badge bg-red"><?php if($data['c'] < $one) echo $one - $data['c']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						
						
<!-- OP4 --><!-- POLRI -->						
						<?php } if($level_user == 'op4'){?> <!-- POLRI -->
						<td>
							<?php
							if($key['stt_kumham']==2 && $key['status'] == 2 && $key['stt_diklat']==2){
								if($key['stt_polri']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/d">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/d">
								<!--<span class="btn btn-app"class="badge bg-red"><?php if($data['d'] < $one) echo $one - $data['d']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						
<!-- OP5 --><!-- KEJAGUNG -->					
						<?php } if($level_user == 'op5'){?> <!-- KEJAGUNG -->
						<td>
							<?php 
							if($key['stt_kumham']==2 && $key['status'] == 2 && $key['stt_diklat']==2 && $key['stt_polri']==2){
								if($key['stt_kejagung']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/e">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/e">
								<!--<span class="badge bg-red"><?php if($data['e'] < $one) echo $one - $data['e']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
<!-- OP6 --><!-- SKEP -->					
						<?php } if($level_user == 'op6'){?> <!-- SKEP -->
						<td>
							<?php
							if($key['stt_kumham']==2 && $key['status'] == 2 && $key['stt_diklat']==2 && $key['stt_polri']==2 && $key['stt_kejagung']==2){
								if($key['stt_skep']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/f">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/f">
								<!--<span class="badge bg-red"><?php //if($data['f'] < $one) echo $one - $data['f']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						<td>
							<?php
							if($key['stt_kumham']==2 && $key['status'] == 2 && $key['stt_diklat']==2 && $key['stt_polri']==2 && $key['stt_kejagung']==2 && $key['stt_skep']){
								if($key['stt_pelantikan']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/g">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/g">
								<!--<span class="badge bg-red"><?php //if($data['g'] < $one) echo $one - $data['g']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>

<!-- OP7 --><!-- Pelantikan -->						
						<?php } if($level_user == 'op7'){?> <!-- Pelantikan -->
						<td>
							<?php
							if($key['stt_kumham']==2 && $key['status'] == 2 && $key['stt_diklat']==2 && $key['stt_polri']==2 && $key['stt_kejagung']==2 && $key['stt_skep']){
								if($key['stt_pelantikan']==2){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/g">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }else{ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/g">
								<!--<span class="badge bg-red"><?php //if($data['g'] < $one) echo $one - $data['g']; else $one; ?></span>-->
								Pending
								</a>
								<?php } 
							}else{?>
							<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="#">
								<!--<span class="badge bg-red">1</span>-->
								Pending
							</a>
							<?php } ?>
						</td>
						<?php } ?>
					</tr>
					<?php $i++; endforeach;}?> 

				</tbody>
			</table>
		</div>
		<div class="box-footer">
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<div class="col-md-12">
					<?php $page_link=$this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
			<div class="rows well well-sm">
			<div class="col-md-8">
				<div style="vertical-align:middle;line-height:25px">
				<?php 
					$to_page=$this->pagination->cur_page * $this->pagination->per_page;
					$from_page=($to_page-$this->pagination->per_page+1);
					if($from_page>$to_page):
						$from_page=1;
						$to_page=$from_page;
					endif;
					$total_rows=$this->pagination->total_rows;
					if($to_page>1):
						echo "Displaying : ".$from_page." - ".$to_page." of ". 
								$this->pagination->total_rows." entries";
					endif;
					if($to_page<=1):
						echo "Displaying : 1 of ". 
								$this->pagination->total_rows." entries";		
					endif;		
				?>,
				<?php
			$arrPerPageSelect=array(
					3=>3,
					10=>10,
					25=>25,
					50=>50,
					-1=>"All"
				);
				$pp=$perPage;
			?>
			Rows/page:<?=form_dropdown("pp_select",$arrPerPageSelect,$pp,"id='pp_select' class='input-mini'")?>	
			<input type="hidden" id="pp" name="pp" value="" />
				
				 </div>
			</div><!-- end span 6-->
			<div class="col-md-4">

			<span class="pull-right">
				<div style="margin-top:-23px; margin-right:10px">
				<?php echo $page_link; ?>
				</div>
			</span>

			</div><!-- end span 6-->
			<div class="clearfix" style="height:24px"></div>

			</div><!-- end class well -->
		</div><!-- /.box-footer -->
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


<script>
	$(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	
		$(".pagination .active a").click(function(e){
			e.preventDefault();
		});
		
		$("#pp_select").change(function(){
			var pp=parseInt($(this).find("option:selected").val());
			if(pp<0){
				location=document.URL.split("?")[0];
				return false;
			}
			get_query();
		});
		
		$("#frm-search").submit(function(e){
			e.preventDefault();
			get_query();
		});
		$("#filter_toggle").click(function(){
			$(this).toggleClass("active");
			$("#filter_content").slideToggle();
		});
	});
	
	
	function get_query(){
			var q =$("#q").val()||"";
			var perPage=$("#pp_select option:selected").val();
			$("#pp").val(perPage);
			var pp =$("#pp").val()||"";
			
			
			var data=[];
			if(q){
				data.push("q="+q);
			}
			
			if((pp)&&(pp!=25)){
				data.push("pp="+pp);
			}
			var param='';
			if(data){
				param="?"+data.join("&");
			}
			var url=document.URL.split("?")[0];
			location=url+param;
	}
</script>
<script>
	$(function(){
		var act_link="<?=substr(trim($this->module), 0, -1);?>";	
		$(".menu-bar").find("li.active").removeClass("active");
		$(".menu-bar").find("a[href*='"+act_link+"']").parents("li:last").addClass("active");
	});
</script>

<? //$this->load->view("active_menu");?>