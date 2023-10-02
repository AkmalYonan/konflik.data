<?php 
foreach ($query_brks as $key1){
	$a[] = $key1['kode'];
}
if($query->RecordCount() == ''){?>
<tr>
	<td colspan='9'><center><b>Data tidak ditemukan</b></center></td>
</tr>
  <?php }else{
$i = 1;
$tot = 6;
$one = 1;
foreach($query as $key):
	$data['countA'] = $this->verifikasi_model->countFlag($key['id_pegawai'],'a');
		$data['a'] = $data['countA']->RecordCount();
	$data['countB'] = $this->verifikasi_model->countFlag($key['id_pegawai'],'b');
		$data['b'] = $data['countB']->RecordCount();
	$data['countC'] = $this->verifikasi_model->countFlag($key['id_pegawai'],'c');
		$data['c'] = $data['countC']->RecordCount();
	$data['countD'] = $this->verifikasi_model->countFlag($key['id_pegawai'],'d');
		$data['d'] = $data['countD']->RecordCount();
	$data['countE'] = $this->verifikasi_model->countFlag($key['id_pegawai'],'e');
		$data['e'] = $data['countE']->RecordCount();
	$data['countF'] = $this->verifikasi_model->countFlag($key['id_pegawai'],'f');
		$data['f'] = $data['countF']->RecordCount();
	$data['countG'] = $this->verifikasi_model->countFlag($key['id_pegawai'],'g');
		$data['g'] = $data['countG']->RecordCount();
?>
<tr>
	<td><?=$i;?></td>
	<td><?=$key['nip'];?> / <?=$key['nama'];?></td>
	<td>
		<?php 
			$jsonData = services_prov();
			$phpArray = json_decode($jsonData, true);
			foreach($phpArray as $rows){
				  $kode_dagri = $rows['kode_dagri'];  
				  if($kode_dagri == $key['propinsi']){
					echo $rows['nama_wilayah'];  
				  }
			  }
		?>, 
		<?php 
			  if(!empty($key['kabupaten'])){
			  $jsonData2 = services_kab2($key['kabupaten']);
			  $phpArray2 = json_decode($jsonData2, true);
			  foreach($phpArray2 as $rows){
				  $kode_dagri = $rows['kode_dagri'];  
				  if($kode_dagri == $key['kabupaten']){
					echo $rows['nama_wilayah'];  
				  }
			  }
			  }else{echo "-";}
		?>
	</td>
	
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
	<?php if(($level_user == 'op1')){?>
	<td>
		<?php 
		if($data['a'] >= $tot){?>
		<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/a">
		<center>
			<span class="label label-success">Completed</span>
		</center>
		</a>
		<?php }elseif($data['a'] == 0){ ?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/a">
			
			<span class="badge bg-red">
				<div class="tooltip_ar">
					<?php
					$query_com = $this->verifikasi_model->getBerkasAll($key['id_pegawai']);
					foreach ($query_com as $key2){						
						$b[] = $key2['jenis_berkas'];						
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
		<a class="btn btn-app " style="background:#f0ad4e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/a">
			<span class="badge bg-red">
				<div class="tooltip_ar">
					<?php
					$query_com = $this->verifikasi_model->getBerkasAll($key['id_pegawai']);
					$f = array();
					foreach ($query_com as $key2){
						$f[] = $key2['jenis_berkas'];						
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
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/b">
			<center>
				<span class="label label-success">Completed</span>
			</center>
			</a>
			<?php }elseif($data['b'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/b">
			<span class="badge bg-red"><?php if($data['b'] < $one) echo $one - $data['b']; else $one; ?></span>
			Pending
			</a>
		<?php }
		}else{ ?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	<td>
		<?php 
		if($data['a'] >= $tot && $data['b'] >= 1 ){
			if($data['c'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/c">
			<center>
				<span class="label label-success">Completed</span>
			</center>
			</a>
			<?php }elseif($data['c'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/c">
			<span class="badge bg-red"><?php if($data['c'] < $one) echo $one - $data['c']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	<td>
		<?php 
		if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1){
			if($data['d'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/d">
			<center>
				<span class="label label-success">Completed</span>
			</center>
			</a>
			<?php }elseif($data['d'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/d">
			<span class="badge bg-red"><?php if($data['d'] < $one) echo $one - $data['d']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	<td>
		<?php 
		if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1){
			if($data['e'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/e">
			<center>
				<span class="label label-success">Completed</span>
			</center>
			</a>
			<?php }elseif($data['e'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/e">
			<span class="badge bg-red"><?php if($data['e'] < $one) echo $one - $data['e']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	<td>
		<?php
		if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1){
			if($data['f'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/f">
			<center>
				<span class="label label-success">Approved</span>
			</center>
			</a>
			<?php }elseif($data['f'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/f">
			<span class="badge bg-red"><?php if($data['f'] < $one) echo $one - $data['f']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	<td>
		<?php
		if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1 && $data['f'] >= 1){
			if($data['g'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/g">
			<center>
				<span class="label label-success">Approved</span>
			</center>
			</a>
			<?php }elseif($data['g'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/g">
			<span class="badge bg-red"><?php if($data['g'] < $one) echo $one - $data['g']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	
	
	<?php } if($level_user == 'op2'){?> <!-- KUMHAM -->
	<td>
		<?php
		if($data['a'] >= $tot){
			if($data['b'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/b">
			<center>
				<span class="label label-success">Completed</span>
			</center>
			</a>
			<?php }elseif($data['b'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/b">
			<span class="badge bg-red"><?php if($data['b'] < $one) echo $one - $data['b']; else $one; ?></span>
			Pending
			</a>
		<?php }
		}else{ ?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	
	
	<?php } if($level_user == 'op3'){?> <!-- Lulus Diklat -->
	<td>
		<?php 
		if($data['a'] >= $tot && $data['b'] >= 1 ){
			if($data['c'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/c">
			<center>
				<span class="label label-success">Completed</span>
			</center>
			</a>
			<?php }elseif($data['c'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/c">
			<span class="badge bg-red"><?php if($data['c'] < $one) echo $one - $data['c']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	
	
	
	<?php } if($level_user == 'op4'){?> <!-- POLRI -->
	<td>
		<?php
		if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 ){
			if($data['d'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/d">
			<center>
				<span class="label label-success">Completed</span>
			</center>
			</a>
			<?php }elseif($data['d'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/d">
			<span class="btn btn-app"class="badge bg-red"><?php if($data['d'] < $one) echo $one - $data['d']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	
	
	<?php } if($level_user == 'op5'){?> <!-- KEJAGUNG -->
	<td>
		<?php 
		if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1){
			if($data['e'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/e">
			<center>
				<span class="label label-success">Completed</span>
			</center>
			</a>
			<?php }elseif($data['e'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/e">
			<span class="badge bg-red"><?php if($data['e'] < $one) echo $one - $data['e']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	
	<?php } if($level_user == 'op6'){?> <!-- SKEP -->
	<td>
		<?php
		if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1){
			if($data['f'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/f">
			<center>
				<span class="label label-success">Approved</span>
			</center>
			</a>
			<?php }elseif($data['f'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/f">
			<span class="badge bg-red"><?php if($data['f'] < $one) echo $one - $data['f']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	<td>
		<?php
		if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1 && $data['f'] >= 1){
			if($data['g'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/g">
			<center>
				<span class="label label-success">Approved</span>
			</center>
			</a>
			<?php }elseif($data['g'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/g">
			<span class="badge bg-red"><?php if($data['g'] < $one) echo $one - $data['g']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>

	<?php } if($level_user == 'op7'){?> <!-- Pelantikan -->
	<td>
		<?php
		if($data['a'] >= $tot && $data['b'] >= 1 && $data['c'] >= 1 && $data['d'] >= 1 && $data['e'] >= 1 && $data['f'] >= 1){
			if($data['g'] >= 1){?>
			<a href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/g">
			<center>
				<span class="label label-success">Approved</span>
			</center>
			</a>
			<?php }elseif($data['g'] < 1){ ?>
			<a class="btn btn-app" style="background:#e7543e;color:white" href="<?=base_url();?>verifikasi/berkas/<?=$key['id_pegawai'];?>/g">
			<span class="badge bg-red"><?php if($data['g'] < $one) echo $one - $data['g']; else $one; ?></span>
			Pending
			</a>
			<?php } 
		}else{?>
		<a class="btn btn-app" style="background:#e7543e;color:white" href="#">
			<span class="badge bg-red">1</span>
			Pending
		</a>
		<?php } ?>
	</td>
	<?php } ?>
</tr>
<?php $i++; endforeach;}?> 