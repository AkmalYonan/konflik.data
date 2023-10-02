<?php 
if ($_POST['provinsi'] || $_POST['kabupaten'] || $_POST['skpd'] || $_POST['posisi'] || $_POST['sort'] || $_POST['q']) {
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
	$pss=$this->input->get_post("posisi",TRUE);
	$q=$q?$q:"";
	$provinsi=$provinsi?$provinsi:"";
	$kabs=$kabs?$kabs:"";
	$skpdx=$skpdx?$skpdx:"";
	$pss=$pss?$pss:"";
?>
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="hidden-lg">
			<h1>List <small>Pegawai</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb lg-only">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active"><?=$this->module_title?></li>
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
						<a class="btn btn-default active" href="<?php echo $this->module?>listview">
							<i class="fa fa-list"></i> List
						</a>
						<a class="btn btn-default" href="<?php echo $this->module?>add">
							<i class="fa fa-plus"></i> Input
						</a>	  
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
							<td>Posisi</td>
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
									if($_POST){
										// $jsonData = file_get_contents($services_prov."?kode_dagri=$provinsi");
										$jsonData = file_get_contents($services_prov."kabupaten/$provinsi");
										$phpArray = json_decode($jsonData, true);
										foreach($phpArray as $rowk):
											if($rowk['kode_dagri'] == $kabs){
												$selected = 'selected="selected"';
											}else{
												$selected = '';
											}	
											// $kdkab = $rowk['kode_dagri'];  
											// if($kdkab == $kabupaten){
												// echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";											 
											// }
											// if($prov !='' && $kabupaten ==''){
												// echo "<option $selected value='".$rowk['kode_dagri']."'>".$rowk['nama_wilayah']."</option>";	
											// }
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
								   <select name="posisi" class="form-control">
									<option value=''>- Pilih Posisi -</option>
									<option <?=($pss == 'a' ? 'selected' : '');?> value='a'>Verifikasi PUM</option>
									<option <?=($pss == 'b' ? 'selected' : '');?> value='b'>Verifikasi KUMHAM</option>
									<option <?=($pss == 'c' ? 'selected' : '');?> value='c'>Lulus Diklat</option>
									<option <?=($pss == 'd' ? 'selected' : '');?> value='d'>Rekomendasi POLRI</option>
									<option <?=($pss == 'e' ? 'selected' : '');?> value='e'>Rekomendasi KEJAGUNG</option>
									<option <?=($pss == 'f' ? 'selected' : '');?> value='f'>SKEP/KTP Dari KUMHAM</option>
									<option <?=($pss == 'g' ? 'selected' : '');?> value='g'>Pelantikan</option>
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
		<div class="col-md-12">
			<?php echo message_box();?>  
		</div>
		<div class="box-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="100"></th>
						<th>No</th>
						<th>NIP</th>
						<th>Nama</th>
						<th>Provinsi</th>
						<th>Kabupaten</th>
						<th>SKPD</th>
						<th>Status Pegawai</th>
						<th><center>Posisi</center></th>
					</tr>
				</thead>
				<tbody>
					<?php if(cek_array($arrData)):?>
						<?php foreach($arrData as $x=>$val):?>
							<? 
								
								$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
							?>	
							<tr >
								<td><center>
									<div class="btn-group">
										<a title="View" class="btn btn-xs btn-default" href="<?php echo site_url("admin/pegawai/view/$id")?> ">
										<i class="fa fa-search icon-white" ></i></a>
									</div>
									<div class="btn-group">
										<a title="Edit" class="btn btn-xs btn-default" href="<?=$this->module?>edit/<?=$id?>"><i class="fa fa-pencil"></i></a>
									</div>
									<div class="btn-group">
										<a title="Hapus" class="btn btn-xs btn-default" onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?=$this->module?>del/<?=$id?>"><i class="fa fa-remove icon-danger"></i></a>
									</div>
									</center>
								</td>
								<td><?=$this->pagination->cur_page+$x+1; ?></td>
								<td valign="top"><?php echo $val["nip"]?></td>
								<td valign="top"><?php echo $val["nama"]?></td>
								<td>
									<?php 
									// $jsonData = file_get_contents($services_prov."?kode_wilayah=00");
									$jsonData = file_get_contents($services_prov."propinsi");
									$phpArray = json_decode($jsonData, true);
									foreach($phpArray as $rows){
											  $kode_dagri = $rows['kode_dagri'];  
											  if($kode_dagri == $val['propinsi']){
												echo $rows['nama_wilayah'];  
											  }
										  }
									?>
								</td>
								<td>
									<?php 
										  if(!empty($val['kabupaten'])){
										  // $jsonData2 = file_get_contents($services_prov."?kode_dagri=$val[propinsi]");
										  $jsonData2 = file_get_contents($services_prov."kabupaten/$val[propinsi]");
										  $phpArray2 = json_decode($jsonData2, true);
										  foreach ($phpArray2 as $key2 => $value2) {
											$a2 = $value2['kode_dagri'];
											$b2 = $value2['nama_wilayah'];
											if($a2 == $val['kabupaten']){
												echo $b2;  
											}
										   }
										  }else{echo "-";}
									?>
								</td>
								<td valign="top"><?php echo $val["skpd"]?></td>
								<td valign="top"><?php echo strtoupper($val["status_pegawai"])?></td>
								<td align="center">
									<?php if($val['posisi'] == 'a'){?>
									<center>
										<span class="label label-info">Verifikasi PUM</span>
									</center>
									<?php }elseif($val['posisi'] == 'b'){?>
									<center>
										<span class="label label-info">Verifikasi KUMHAM</span>
									</center>
									<?php }elseif($val['posisi'] == 'c'){?>
									<center>
										<span class="label label-info">Lulus Diklat</span>
									</center>
									<?php }elseif($val['posisi'] == 'd'){?>
									<center>
										<span class="label label-info">Rekomendasi POLRI</span>
									</center>
									<?php }elseif($val['posisi'] == 'e'){?>
									<center>
										<span class="label label-info">Rekomendasi KEJAGUNG</span>
									</center>
									<?php }elseif($val['posisi'] == 'f'){?>
									<center>
										<span class="label label-info">SKEP/KTP Dari KUMHAM</span>
									</center>
									<?php }elseif($val['posisi'] == 'g'){?>
									<center>
										<span class="label label-info">Pelantikan</span>
									</center>
									<?php }else{ echo "-";} ?>
								</td>
							</tr>
						<?php endforeach;?>
					<?php endif;?>
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