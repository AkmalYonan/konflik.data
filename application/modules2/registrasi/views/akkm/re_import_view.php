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
								</div>
							
								<div class="box-body table-responsive">		
								<table class="table table-bordered table-condensed small-font">
									<thead>
										<tr>
											<td rowspan='3' style="vertical-align: middle;" width="20px"><center>No.</td>
											<td rowspan='3' style="vertical-align: middle;" ><input type="checkbox" name="select-all" id="select-all" /></td>
											<td rowspan='3' style="vertical-align: middle;" width="70px"><center>ID</td>
											<td colspan='4' style="vertical-align: middle;"><center>DATA AKKM</center></td>
											<td colspan='3' style="vertical-align: middle;"><center>Wilayah</center></td>
											<td rowspan='3' style="vertical-align: middle;"><center>Longitude</center></td>
											<td rowspan='3' style="vertical-align: middle;"><center>Langitude</center></td>
											<td rowspan='3' style="vertical-align: middle;"><center>Status</center></td>
											<td rowspan='3' style="vertical-align: middle;"><center>Desc</center></td>
											<td rowspan='3' style="vertical-align: middle;"><center>#</center></td>
										</tr>
										<tr>
											<td rowspan='2' style="vertical-align: middle;" width="220px"><center>Nama</center></td>
											<td rowspan='2' style="vertical-align: middle;"><center>Pengampu</center></td>
											<td rowspan='2' style="vertical-align: middle;"><center>Luas</center></td>
											<td rowspan='2' style="vertical-align: middle;"><center>Ekosistem</center></td>

											<td style="vertical-align: middle;"><center>Provinsi</center></td>
											<td style="vertical-align: middle;"><center>Kabupaten</center></td>
											<td style="vertical-align: middle;"><center>Kecamatan</center></td>
										</tr>
										<tr>
											<td colspan="3"><center><small>*data wilayah harus diselect ulang ketika data sudah masuk</small></center></td>
										</tr>
									</thead>
										<tbody>
											<?php if(cek_array($value)):?>
												<?php foreach($value as $row=>$val):?>
													<tr>
														<td><?php echo $offset+$row+1?>.</td>
														<script>
															function doalert(checkboxElem) {
																if (checkboxElem.checked) {
																	
																	var B = $('#B'+checkboxElem.value).val();
																	var C = $('#C'+checkboxElem.value).val();
																	var D = $('#D'+checkboxElem.value).val();
																	var E = $('#E'+checkboxElem.value).val();
																	var F = $('#F'+checkboxElem.value).val();	
																	var G = $('#G'+checkboxElem.value).val();
																	var H = $('#H'+checkboxElem.value).val();
																	var I = $('#I'+checkboxElem.value).val();
																	var J = $('#J'+checkboxElem.value).val();
																	var JParse = J.replace(/[^\d,-]/g, '');
																	
																	var K = $('#K'+checkboxElem.value).val();
																	var L = $('#L'+checkboxElem.value).val();
																	
																	var O = $('#O'+checkboxElem.value).val();
																	
																			
																	var zxy = [B,C,D,E,F,G,H,I,JParse+" ",K,L,O];
																	
																	var parseString = zxy.join('|');
																	
																	$('#data'+checkboxElem.value).val(parseString);
																	$(".inputx"+checkboxElem.value).attr('disabled', 'disabled');
																	
																										

																} else {
																	$('#data'+checkboxElem.value).val("");
																	$(".inputx"+checkboxElem.value).prop('disabled', false);
																
																}
															}
														</script>
														 <td><input  type="checkbox" id="verified<?=($row+1)?>" name="verified" onchange="doalert(this)" value="<?=($row+1)?>"></td>
											
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="B<?=($row+1)?>" value="<?=$val['B']?>"></td> 
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="C<?=($row+1)?>" value="<?=$val['C']?>" ></td>
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="I<?=($row+1)?>" value="<?=$val['I']?>" ></td>
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="J<?=($row+1)?>" value="<?=$val['J']?>" ></td>
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="K<?=($row+1)?>" value="<?=$val['K']?>" ></td>
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="F<?=($row+1)?>" value="<?=$val['F']?>" ></td>
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="E<?=($row+1)?>" value="<?=$val['E']?>" ></td>
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="D<?=($row+1)?>" value="<?=$val['D']?>" ></td>
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="G<?=($row+1)?>" value="<?=$val['G']?>" ></td>
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="H<?=($row+1)?>" value="<?=$val['H']?>" ></td>
														
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="L<?=($row+1)?>" value="<?=$val['L']?>" ></td>
														<td><input type="text" class="form-control inputx<?=($row+1)?>" id="O<?=($row+1)?>" value="<?=$val['O']?>" ></td>
														<td><i class='fa fa-circle text-blue'></i></td>
														
													</tr>
													<input type="hidden" class="form-control" id="data<?=$row+1?>" name="data[<?=$i?>]"  />

												<?php endforeach;?>
											<?php endif;?>
										</tbody>
									</table>
									</div>
								</form>
						  

						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
					<div class="box-body table-responsive">		
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
	</div>

</section>


<script language="javascript">
$(function(){

	$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;                       
        });
    }
});

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