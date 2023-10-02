<style>
 table.import td {
	 text-align:center;
	 vertical-align:middle!important;
 }
</style>
<?
ini_set('memory_limit', '512M');
$result = ($key)?"Keywords: <strong>".$key."</strong>":"&nbsp;"; 

$lookup_status_konflik[""]="--Pilih--";
$lookup_status_konflik["BD"]="Belum Ditangani";
$lookup_status_konflik["PS"]="Dalam Proses";
$lookup_status_konflik["SL"]="Selesai";
	
$lookup_kategori[""]="--Pilih--";
$lookup_kategori["K1"]="Masyarakat Adat";
$lookup_kategori["K2"]="Non Masyarakat Adat";

$lookup_strip[""]="--Pilih--";
$lookup_sektor=$lookup_strip+lookup("m_sektor","kode","uraian","","order by uraian");

?>

<section class="content">

	<div class="row">
		<div class="col-md-12">
			<div class="content-toolbar">
				<div class="box-header with-border clearfix">
					<a class="btn btn-default" href="javascript:history.back()">
						<i class="fa fa-reply"></i> Back
					</a>
					<a class="btn btn-white btn-save" href="" data-toggle='tooltip' data-placement="bottom" title="Import">
						<i class="fa fa-check"></i> Import
					</a>	 
				</div>
			</div>
			<div class="box box-widget">
				
				<div class="row">
					<div class="col-md-12">
						<div class="tab-content">
							<form id="frm" method="post" action="<?php echo $this->module;?>add_xls" enctype="multipart/form-data">	
								<input type="hidden" name="media" value="<?=$media?>" />
								<div class="box-body table-responsive">		
								
									<p> - Lengkapi data terlebih dahulu dan koreksi data terlebih dahulu sebelum data di submit  !!</p>
									<p> - Klik checkbox <input type="checkbox" checked> disamping kanan untuk memilih data yg akan di submit . </p>
									<table class="table table-bordered table-condensed small-font">
										<tbody> 
										<?php if(cek_array($values)): ?>
										<? $i=0;?>
											<?php foreach($values as $row=>$list): ?>
											<tr>
											<td><?=($row+1)?></td>
											<td>
												<table class="table table-bordered table-condensed small-font">
												<tr>
 													<td>
														<table>
															<tr>
																<td colspan='2'><label>Judul</label><input type="text" class="form-control inputx<?=($row+1)?>" id="E<?=($row+1)?>" value="<?=$list['E']?>"></td>
															</tr>
															<tr>
																<td><label>Nomor Kejadian</label><input type="text" class="form-control inputx<?=($row+1)?>" id="C<?=($row+1)?>" value="<?=$list['C']?>"></td>
																<td><label>Waktu Kejadian</label>
																	<div class="input-group">
																		<input type="hidden" id="tgl_kejadian<?=($row+1)?>" name="tgl_kejadian" value="<?=date_format(date_create($list['D']),"Y-m-d")?>" />
																		<input type="text" id="tgl_kejadian_selector<?=($row+1)?>" class="form-control inputx<?=($row+1)?>" value="<?=date_format(date_create($list['D']),"F Y")?>" required  />
																		<div class="input-group-addon">
																			<i class="fa fa-calendar"></i>
																		</div>	
																	</div>
																</td>
															</tr>	
														</table>
 													 </td>
													<td>
														<table>
															<tr>
																<td><label>Sektor</label>
																	<?=form_dropdown("kd_sektor",$lookup_sektor,$list['F'],"id='F".($row+1)."' class='form-control inputx".($row+1)." '");?>
																</td>
																<td><label>Status Konflik</label>
																	<?=form_dropdown("status_konflik",$lookup_status_konflik,$list['I'],"id='I".($row+1)."' class='form-control inputx".($row+1)." '");?>
																</td>
															</tr>	
															<tr>
																<td colspan='2'><label>Kategori Konflik</label>
																	<?=form_dropdown("kategori",$lookup_kategori,$list['J'],"id='J".($row+1)."' class='form-control inputx".($row+1)."'");?>
																</td>
															</tr>
														</table>
												
													</td>
													<td>
														<table>
															<tr>
																<td><label>Kerugian</label><input type="text" class="form-control inputx<?=($row+1)?>" id="K<?=($row+1)?>" value="<?=$list['K']?>"></td>
																<td><label>Luas</label><input type="text" class="form-control inputx<?=($row+1)?>" id="L<?=($row+1)?>" value="<?=$list['L']?>"></td>
															</tr>	
															<tr>
																<td colspan='2'><label>Dampak Masyarakat</label><input type="text" class="form-control inputx<?=($row+1)?>" id="M<?=($row+1)?>" value="<?=$list['M']?>"></td>
															</tr>
															
														</table>
													
													</td>
													<?php
									
									
													$arrKab=array();
													if($this->user_prop):
															
														if($this->user_kab):
															/* Apabila Admin adalah Admin/User Tingkat Kabupaten */
															$arrPropinsi=m_lookup("propinsi","kd_propinsi","nm_propinsi","kd_propinsi='".$this->user_prop."'");
															$arrPropinsi1=$arrPropinsi;
																
															$arrKab=m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$this->user_prop."' and kd_kabupaten='".$this->user_kab."' and kd_kabupaten!='00'");
																
															$arrKec=array();
															
															if($this->user_prop and $this->user_kab):											
																$arrKec	=	m_lookup("KECAMATAN","KD_KECAMATAN","NM_KECAMATAN","kd_propinsi={$this->user_prop} and kd_kabupaten={$this->user_kab}");
															endif;
															
															/* End */
														else:
															/* Apabila Admin adalah Admin/User Tingkat Propinsi */
															$arrPropinsi=m_lookup("propinsi","kd_propinsi","nm_propinsi","kd_propinsi='".$this->user_prop."'");
															$arrPropinsi1=$arrPropinsi;
																
															$arrKab=array(""=>"--Pilih--")+m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$this->user_prop."' and kd_kabupaten!='00'");
																
															$arrKec=array();
													
															if($this->user_prop):
																
																$kd_kab	=	substr($data["kd_kabupaten"],2,2);
															
																$arrKec	=	array(""=>"--")+m_lookup("KECAMATAN","KD_WILAYAH","NM_KECAMATAN","KD_PROPINSI={$this->user_prop} and KD_KABUPATEN={$kd_kab}");
															endif;
															
															/* End */
														endif;
														
														
													else:
														$arrPropinsi=m_lookup("propinsi","kd_propinsi","nm_propinsi");
														$arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
														$arrKab=array();
														if($data["kd_propinsi"]):
															$arrKab=array(""=>"--Pilih--")+m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$data['kd_propinsi']."' and kd_kabupaten!='00'");
														endif;
														
														$arrKec=array();
														
														if($data["kd_propinsi"] and $data["kd_kabupaten"]):
															
															$kd_kab	=	substr($data["kd_kabupaten"],2,2);
														
															$arrKec	=	array(""=>"--")+m_lookup("KECAMATAN","KD_WILAYAH","NM_KECAMATAN","kd_propinsi={$data["kd_propinsi"]} and kd_kabupaten={$kd_kab}");
														endif;
													endif;
														
												?>
													<td>
														<table>
															<tr>
																<td><label>Propinsi</label>
																<?=form_dropdown("kd_propinsi",$arrPropinsi1,$list['Q'],"id='id_propinsi".($row+1)."' class='form-control  inputx".($row+1)."'");?>
									
																</td>
																<td><label>Kabupaten</label>
																<div id="id_kabupaten_holder<?=($row+1)?>">
																	<?=form_dropdown("kd_kabupaten",$arrKab,$list['R'],"id='id_kabupaten".($row+1)."' class='form-control inputx".($row+1)."'");?>
																</div>
																</td>
															</tr>	
															<tr>
																<td><label>Kecamatan</label>
																<div id="id_kecamatan_holder<?=($row+1)?>">
																	<?=form_dropdown("kd_kecamatan",$arrKec,$list['S'],"id='id_kecamatan".($row+1)."' class='form-control inputx".($row+1)."'");?>
																</div>
																</td>
																<td><label>Desa</label>
																	<input class="form-control inputx<?=($row+1)?>" name="kd_desa" id="kd_desa<?=($row+1)?>" type="text" value="<?php echo $list['T'];?>" />
																</td>
															</tr>
														</table>
													</td>
												
											
												
                                               
											</tr>
 											<tr>	
											 	 <td>
													<table>
 														<tr>
														 	<td><label>Pemerintah</label><input type="text" class="form-control inputx<?=($row+1)?>" id="U<?=($row+1)?>" value="<?=$list['U']?>"></td>
															<td><label>Perusahaan</label><input type="text" class="form-control inputx<?=($row+1)?>" id="V<?=($row+1)?>" value="<?=$list['V']?>"></td>
														</tr>	
														<tr>
														 	<td colspan='2'><label>Masyarakat</label><input type="text" class="form-control inputx<?=($row+1)?>" id="W<?=($row+1)?>" value="<?=$list['W']?>"></td>
															
														</tr>
													</table>
												 </td>
												<td>
													<table>
 														<tr>
														 	<td><label>X (Longitude)</label><input type="text" class="form-control inputx<?=($row+1)?>" id="O<?=($row+1)?>" value="<?=$list['O']?>"></td>
															<td><label>Y (Latitude)</label><input type="text" class="form-control inputx<?=($row+1)?>" id="P<?=($row+1)?>" value="<?=$list['P']?>"></td>
														</tr>	
														<tr>
															<td colspan='2'><label>Confidentiality</label><input type="text" id="N<?=($row+1)?>" class="form-control inputx<?=($row+1)?>" id="N<?=($row+1)?>" value="<?=$list['N']?>"></td>
													
														</tr>
													</table>
												</td>
												<td>
													<table>
														<tr>
														 	<td><label>Nama</label><input type="text" class="form-control inputx<?=($row+1)?>" id="AA<?=($row+1)?>"  value="<?=$list['AA']?>"></td>
															<td><label>Email</label><input type="text" class="form-control inputx<?=($row+1)?>" id="AB<?=($row+1)?>"  value="<?=$list['AB']?>"></td>
														</tr>	
														<tr>
														 	<td colspan='2'><label>Telephone</label><input type="text" class="form-control inputx<?=($row+1)?>" id="AD<?=($row+1)?>"  value="<?=$list['AD']?>"></td>
														</tr>
													</table>
												
												</td>
												<td>
													<table>
														<tr>
														 	<td colspan='2'><label>Alamat</label><textarea  rows="3" cols="50" id="AC<?=($row+1)?>"  class="form-control inputx<?=($row+1)?>" ><?=$list['AC']?></textarea></td>
														</tr>
													</table>
												</td>
											</tr>
											 <tr>
											 	<td colspan='2'>
													<table>
 														<tr>
														 	<td><label>Klip</label><textarea  rows="7" cols="80"  id="X<?=($row+1)?>" class="form-control inputx<?=($row+1)?>" ><?=$list['X']?></textarea></td>
														</tr>	
													</table>
												</td>
												<td colspan='2'>
													<table>
 														<tr>
														 	<td><label>Narasi</label><textarea  rows="4" cols="80" id="Y<?=($row+1)?>" class="form-control inputx<?=($row+1)?>" ><?=$list['Y']?></textarea></td>
														</tr>	
														<tr>
														 	<td ><label>Sumber</label><input type="text" class="form-control inputx<?=($row+1)?>" id="Z<?=($row+1)?>" value="<?=$list['Z']?>"></td>
														</tr>
													</table>
												
												</td>
											   </tr>
											 </table>
											 </td>
											<script>
												function doalert(checkboxElem) {
												if (checkboxElem.checked) {
													 
													
													var C = $('#C'+checkboxElem.value).val();
													var D = $('#tgl_kejadian'+checkboxElem.value).val();
													var E = $('#E'+checkboxElem.value).val();
													var F = $('#F'+checkboxElem.value).val();	
													var I = $('#I'+checkboxElem.value).val();
													var J = $('#J'+checkboxElem.value).val();
													var K = $('#K'+checkboxElem.value).val();
													var L = $('#L'+checkboxElem.value).val();
													var M = $('#M'+checkboxElem.value).val();
													var N = $('#N'+checkboxElem.value).val();
													var O = $('#O'+checkboxElem.value).val();
													var P = $('#P'+checkboxElem.value).val();
													var Q = $('#id_propinsi'+checkboxElem.value).val();
													var R = $('#id_kabupaten'+checkboxElem.value).val();
													var S = $('#id_kecamatan'+checkboxElem.value).val();
													var T = $('#id_desa'+checkboxElem.value).val();
													var U = $('#U'+checkboxElem.value).val();
													var V = $('#V'+checkboxElem.value).val();
													var W = $('#W'+checkboxElem.value).val();
													var X = $('#X'+checkboxElem.value).val();
													var Y = $('#Y'+checkboxElem.value).val();
													var Z = $('#Z'+checkboxElem.value).val();
													
													var AA = $('#AA'+checkboxElem.value).val();
													var AB = $('#AB'+checkboxElem.value).val();
													var AC = $('#AC'+checkboxElem.value).val();
													var AD = $('#AD'+checkboxElem.value).val();

													var zxy = [C,D,E,F,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,AA,AB,AC,AD];
													
													var parseString = zxy.join('|');
													
													$('#data'+checkboxElem.value).val(parseString);
													$(".inputx"+checkboxElem.value).attr('disabled', 'disabled');
													
																						

												} else {
													$('#data'+checkboxElem.value).val("");
													$(".inputx"+checkboxElem.value).prop('disabled', false);
												
												}
												}
											</script>
											 <td>
											 <input  type="checkbox" id="verified<?=($row+1)?>" name="verified" onchange="doalert(this)" value="<?=($row+1)?>"></td>
											 </tr>
											 <input type="hidden" class="form-control" id="data<?=$row+1?>" name="data[<?=$i?>]"  />

											 <?php// foreach($list as $k=>$v):?>
													
													<?php // $val[$i][]	=	$v; ?>
													 <?php // $check	=	implode(" ",$val[$i]); ?>
													
                                                    
											<?php// endforeach; ?>			
											  <?php// $implode	=	implode("|",$val[$i]); ?>
												<!--<input type="text" class="form-control" name="datax[<?=$i?>]" value="<?=$implode?>" />-->
												<?php $i++; ?>
											<?php endforeach; ?>
										<?php endif; ?>
										</tbody>
									</table>
								</div>
							
								</form>
						  

						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<div class="well well-sm">
                        	<p><b>Keterangan:</b></p> 
							<p>&nbsp;<i class='fa fa-circle text-red'></i> - Data sudah ada di database</p>
							<p>&nbsp;<i class='fa fa-circle text-blue'></i> - Data baru</p>
						</div>
					</div>
				</div>
			
			</div>
		</div>
	</div>

</section>


<script language="javascript">
$(function(){
	<?php if(cek_array($values)): ?>
	<? $i=0;?>
		<?php foreach($values as $row=>$list): ?>


	$("#id_propinsi<?=($row+1)?>").select2({'placeholder':"--Pilih Propinsi--"});
	$("#id_kabupaten<?=($row+1)?>").select2({'placeholder':"--Pilih Kabupaten--"});
	$("#id_kecamatan<?=($row+1)?>").select2({'placeholder':"--Pilih Kecamatan--"});

	$("#id_propinsi<?=($row+1)?>").change(function(){
   		var id_propinsi = $(this).val();
		var nm_propinsi = $("#id_propinsi<?=($row+1)?> option:selected").text();

		//geo_code(nm_propinsi,7);
		$("#id_kecamatan_holder<?=($row+1)?>").load("<?=$this->module;?>get_kecamatanx/X/?time="+new Date().getTime());
		
		$("#id_kecamatan<?=($row+1)?>").select2({'placeholder':"--"});
		$("#id_kabupaten_holder<?=($row+1)?>").load("<?=$this->module;?>get_kab_kotax/"+id_propinsi+"/?time="+new Date().getTime(),function(){
			$("#id_kecamatan<?=($row+1)?>").select2({'placeholder':"--"});
			$("#id_kabupaten<?=($row+1)?>").select2({'placeholder':"--Pilih Kabupaten--"});
			$("#id_kabupaten<?=($row+1)?>").change(function(){
				var nm_address = nm_propinsi+" "+$("#id_kabupaten<?=($row+1)?> option:selected").text();
				//geo_code(nm_address,10);
				var id_propinsi = $("#id_propinsi<?=($row+1)?> option:selected").val();
				var nm_propinsi	=	$("#id_propinsi<?=($row+1)?> option:selected").text();
				var id_kabupaten = $(this).val();
				var nm_address	=	nm_propinsi+" "+$("#id_kabupaten<?=($row+1)?> option:selected").text();
				//geo_code(nm_address,10);
				//alert("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/?time="+new Date().getTime());
				$("#id_kecamatan_holder<?=($row+1)?>").load("<?=$this->module;?>get_kecamatanx/"+id_kabupaten+"/?time="+new Date().getTime(),function(){
					$("#id_kecamatan<?=($row+1)?>").select2({'placeholder':"--Pilih Kecamatan--"});
					$("#id_kecamatan<?=($row+1)?>").change(function(){
						var nm_address = nm_address+" "+$("#id_kecamatan<?=($row+1)?> option:selected").text();
						//geo_code(nm_address,10);
					});
				});	
		    });
		});	
    });
	
	$("#id_kabupaten<?=($row+1)?>").on("change",function(){
		var id_propinsi = $("#id_propinsi<?=($row+1)?> option:selected").val();
		var nm_propinsi	=	$("#id_propinsi<?=($row+1)?> option:selected").text();
		var id_kabupaten = $(this).val();
		var nm_address	=	nm_propinsi+" "+$("#id_kabupaten<?=($row+1)?> option:selected").text();
		//geo_code(nm_address,10);
		//alert("<?=$this->module;?>get_kecamatan/"+id_propinsi+"/"+id_kabupaten+"/?time="+new Date().getTime());
		$("#id_kecamatan_holder<?=($row+1)?>").load("<?=$this->module;?>get_kecamatan/"+id_kabupaten+"/?time="+new Date().getTime(),function(){
			$("#id_kecamatan<?=($row+1)?>").select2({'placeholder':"--Pilih Kecamatan--"});
			$("#id_kecamatan<?=($row+1)?>").change(function(){
				var nm_address = nm_address+" "+$("#id_kecamatan<?=($row+1)?> option:selected").text();
				//geo_code(nm_address,10);
		    });
		});	
	});

		<?php $i++; ?>
											<?php endforeach; ?>
										<?php endif; ?>
	
});


</script>

<script>
  $(function () {
    $('#myTab a:first').tab('show')
  })
</script>

<script>  
	var forder='<?=$forder;?>';
	var dorder='<?=$dorder;?>';
	var query ='<?=($key)?"?q=".$key:"";?>';
    $(document).ready(function () {
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	
		$("#button_list").click(function(){
			var key=($("#key_list").val())?$("#key_list").val():'0';
			var prc=$("#page_record").val();
			var order=(forder!='' && dorder!='')?forder+':'+dorder:0;
			window.location.href='<?=$module;?>index/'+key+'/'+order+'/'+prc+'/1';
		});
		
		$(".page_record").change(function(){
			var order=(forder!='' && dorder!='')?forder+':'+dorder:0;
			var page_record = $(this).val();
			var url = '<?=$module;?>index/'+order+'/'+page_record+'/1'+query;
			window.location.href=url;
		});
		
    })
</script>

<script type="text/javascript">
$(function() {
	tanggal = $('#tgl_kejadian_selector').datepicker({
	minViewMode: 1,
	language: "id",
	format:"MM yyyy"
	}).on('changeDate', function(ev){
		var newDate = new Date(ev.date);
		$("#tgl_kejadian").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
		$('#tgl_kejadian_selector').datepicker('hide');
	}).data('datepicker');
	
});
</script>