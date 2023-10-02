<?php 
if ($_POST['uo'] || $_POST['sort'] || $_POST['q']) {
	$class_toggle=" active";
	$class_content="";
}else {
	$class_toggle="";
	$class_content="none";
}
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
						<a id="filter_toggle" class="btn btn-default" >
							<i class="fa fa-search"></i> Search
						</a>
						
						<form class="search_form col-md-3 pull-right" action="<?=$this->module?>listview" method="get">
						<?php $this->load->view("widget/search_box_db"); ?>
						</form>
						</div>
					</div>
				</div>
			</div><!-- ./box-body -->
			<form id="src" class="search_form" style="background:none" action="<?=$this->module?>index" method="post">
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
									<?php if ($groupSess['kd_uo']==''):?>
									<select name="uo" style="margin-top:3px" class="form-control">
										<option value="0">-- PILIH --</option>
										<option <?php if($_POST['uo']=='01'){ echo "selected='selected'";} ?> value="01">BIRO UMUM / SETJEN</option>
										<option <?php if($_POST['uo']=='02'){ echo "selected='selected'";} ?> value="02" >MABES TNI</option>
										<option <?php if($_POST['uo']=='03'){ echo "selected='selected'";} ?> value="03">ANGKATAN DARAT</option>
										<option <?php if($_POST['uo']=='04'){ echo "selected='selected'";} ?> value="04">ANGKATAN LAUT</option>
										<option <?php if($_POST['uo']=='05'){ echo "selected='selected'";} ?> value="05">ANGKATAN UDARA</option>
									</select>
									<?php else:?>
									<? echo form_dropdown("uo",$arr_uo,false,"id='uo' style='margin-top:3px' class='form-control' ");?>
									<?php endif;?>
								</td>
								<td>
								   <select name="sort" style="margin-top:3px" class="form-control">
										<option value="all">-- STATUS --</option>
										<option <?php if($_POST['sort']=='bpjs'){ echo "selected='selected'";} ?> value="bpjs">BPJS</option>
										<option <?php if($_POST['sort']=='belum'){ echo "selected='selected'";} ?> value="belum">BELUM BPJS</option>
									</select>
								</td>
								<td>
								   <select name="sort" style="margin-top:3px" class="form-control">
										<option value="all">-- STATUS --</option>
										<option <?php if($_POST['sort']=='bpjs'){ echo "selected='selected'";} ?> value="bpjs">BPJS</option>
										<option <?php if($_POST['sort']=='belum'){ echo "selected='selected'";} ?> value="belum">BELUM BPJS</option>
									</select>
								</td>
								<td>
									<div style="margin-top:3px">
									<input id="qqq" class="form-control" type="text" value="<?=$_GET['q']?>" name="q"></input>
									</div>
								</td>
								<td>
									<button class="btn btn-primary">Search</button> <button class="btn btn-warning" type="reset">Reset</button>
								</td>
							</tr>
						</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		<div class="box-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th><center>No</center></th>
						<th>NIP, Nama</th>
						<th>Provinsi, Kabupaten</th>
						<th><center>SKPD</center></th>
						<th><center>Verifikasi <br>PUM</center></th>
						<th><center>Verifikasi <br>KUMHAM</center></th>
						<th><center>Lulus Diklat</center></th>
						<th><center>Rekomendasi <br>POLRI</center></th>
						<th><center>Rekomendasi <br>KEJAGUNG</center></th>
						<th><center>SKEP/KTP Dari <br>KUMHAM</center></th>
						<th><center>Pelantikan</th>
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
						<td><?=$key['nip'];?>, <?=$key['nama'];?></td>
						<td>
							<?php 
								$jsonData = file_get_contents($services_prov."?kode_wilayah=00");
								$phpArray = json_decode($jsonData, true);
								foreach($phpArray as $row){
									  $kdprov = $row['kode_dagri'];  
										if($kdprov == $key['propinsi']){
											echo "$row[nama_wilayah]"; 	
										}
									}
								?>, 
								<?php 
									$jsonData = file_get_contents($services_prov."?kode_dagri=$key[id_propinsi]");
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
							if(($data['a'] >= $tot && $key['status']==2) || ($key['status']==2)){?>
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
							<?php } ?>
						</td>
						<td>
							<?php
							if($data['a'] >= $tot){
								if($data['b'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/b">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }elseif($data['b'] < 1){ ?>
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
						<td>
							<?php 
							if($data['a'] >= $tot && $data['b'] >= 1 ){
								if($data['c'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/c">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }elseif($data['c'] < 1){ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/c">
								<!--<span class="badge bg-red"><?php //if($data['c'] < $one) echo $one - $data['c']; else $one; ?></span>-->
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
							if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1){
								if($data['d'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/d">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }elseif($data['d'] < 1){ ?>
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
							if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1){
								if($data['e'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/e">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }elseif($data['e'] < 1){ ?>
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
							if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1){
								if($data['f'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/f">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }elseif($data['f'] < 1){ ?>
								<a class="btn btn-app" style="background:#e7543e;color:white;padding:4px;height:27px;" href="<?=base_url();?>admin/>verifikasi/view/<?=encrypt($key['idx']);?>/f">
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
							if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1 && $data['f'] >= 1){
								if($data['g'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/g">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }elseif($data['g'] < 1){ ?>
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
							if($data['a'] >= $tot){
								if($data['b'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/b">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }elseif($data['b'] < 1){ ?>
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
							if($data['a'] >= $tot && $data['b'] >= 1 ){
								if($data['c'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/c">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }elseif($data['c'] < 1){ ?>
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
							if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 ){
								if($data['d'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/d">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }elseif($data['d'] < 1){ ?>
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
							if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1){
								if($data['e'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/e">
								<center>
									<span class="label label-success">Completed</span>
								</center>
								</a>
								<?php }elseif($data['e'] < 1){ ?>
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
							if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1){
								if($data['f'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/f">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }elseif($data['f'] < 1){ ?>
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
							if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1 && $data['f'] >= 1){
								if($data['g'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/g">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }elseif($data['g'] < 1){ ?>
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
							if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1 && $data['f'] >= 1){
								if($data['g'] >= 1){?>
								<a href="<?=base_url();?>admin/verifikasi/view/<?=encrypt($key['idx']);?>/g">
								<center>
									<span class="label label-success">Approved</span>
								</center>
								</a>
								<?php }elseif($data['g'] < 1){ ?>
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