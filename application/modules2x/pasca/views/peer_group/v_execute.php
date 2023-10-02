<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
	$lookup_status["PS"]="Proses";
	$lookup_status["SL"]="Selesai";  
	
	$lookup_status_p["PS"]="Proses"; 
	$lookup_status_p["SL"]="Selesai";
	$lookup_status_p["KB"]="Kambuh"; 
	$lookup_status_p["MD"]="Meninggal Dunia";
 	//$id=$this->encrypt_status==TRUE?encrypt($datax[$this->tbl_idx]):$datax[$this->tbl_idx]; 
	
	$tgl_limit_prev = $monitoring_pasca['tgl_mulai_pasca'];
?>

<section class="content-header">
  <h1 class="hidden-xs">
    <?php if($act=="add"): echo "Tambah"; else: echo "Ubah"; endif; ?>
    <small>Pasien Peer Group</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="pasca/daftar_pasca"><i class="fa fa-child"></i> <?=$this->parent_module_title?></a></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
	<li><a href="<?php echo $this->module?><?=$act?>/<?=$id?>" class="active"><?php if($act=="add"): echo "Tambah Data"; else: echo "Ubah Data"; endif; ?></a></li>
  </ol>
</section>

<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
        	<div class="box box-default">
                <div class="box-header with-border clearfix">
                	<a class="btn btn-white" href="<?php echo $this->module?><?=($act=="add")?"pasien_list":""?>" data-toggle='tooltip' title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?><?=$act?>/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="Reset">
                        <i class="fa fa-circle-o"></i>
                    </a>	  
                </div>
                <!-- /.box-header -->
                <div class="box-body">
				<?php if($act=="add"): ?>
				<ul class="nav nav-tabs" style="margin-bottom:10px">
				  <li><a href="<?=$this->module?>pasien_list"><i class="fa fa-user">&nbsp;</i>Pilih Pasien (Step 1)</a></li>
				  <li class="active"><a href="<?=$this->module?>"><i class="fa fa-file">&nbsp;</i>Form Input (Step 2)</a></li>
				</ul>
				<?php endif; ?>
				
				<div class="row">
					
					<div class="col-sm-6">
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#homex" aria-controls="homex" role="tab" data-toggle="tab">Data Kegiatan Peer Group</a></li>
                                    </ul>
						<div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="homex">
						<h4 class="heading">Data Kegiatan Peer Group <div class="pull-right"><button type="button" class="btn btn-xs btn-primary add_clean"><i class="fa fa-plus"></i></button></div></h4>	
						
						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped table-condensed data_tbl">
									<?php if(count($pasien_pg_history)>0):?>
										<?php foreach($pasien_pg_history as $x=>$val): ?>
										<tr id="tr_<?=$val['idx']?>">
											<td align="center"><?php echo $x+1; ?></td>
											<td><?php echo ($val["tgl_pertemuan"])?date2indo($val["tgl_pertemuan"]):"<center>-</center>"?></td>
											<td align="center">Pertemuan Ke-<?php echo $val["idx_pertemuan"]?></td>
											<td><?php echo $this->lookjns_kgt[$val["idx_jenis_kegiatan"]]?></td>
											<td align="center">
												<?php if($val['lampiran']): ?>
													<a href="<?=$this->config->item("dir_peer_group").$val['lampiran']?>" target="_blank">
														<span class="label label-info"><i class="fa fa-download">&nbsp;</i></span>
													</a>
												<?php else: echo "-"; endif; ?>
											</td>
											<td align="center">
												<?php 
													foreach($val as $k=>$v): 
														$ref[]	=	$k.":'".$v."'";
													endforeach;
													$ref[]	=	"tgl_registrasi:'".date("Y-m-d",strtotime($val["tgl_pertemuan"]))."'";
													$ref[]	=	"tgl_registrasi_selector:'".date("d/m/Y",strtotime($val["tgl_pertemuan"]))."'";
													$data_ref	=	join(',',$ref);
												?>
													
												<div class="btn-group btn-group-xs">
													<a class="btn btn-xs btn-default edit_data" data-toggle='tooltip' data-ref="{<?=$data_ref?>}" title="Edit">
														<i class="fa fa-pencil green"></i>
													</a> 
													<a class="btn btn-xs btn-default del_ajax" data-ref="{<?=$data_ref?>}">
														<i class="fa fa-remove red"></i>
													</a> 
												</div>
											</td>
										</tr>
										<?php endforeach;?>
									<?php else: ?>
									<tr>
										<td align="center"><i>--Belum Ada Kegiatan--</i></td>
									</tr>	
									<?php endif;?>
								</table>
							</div><!-- end input group -->
						</div>
						
						<h4 class="heading title_form">Tambah Data Peer Group</h4>
						
						<form id="frm" method="post" action="<?php echo $this->module;?><?=$act?>/<?=$id?>" enctype="multipart/form-data">
							<!--Hidden Input-->
						  	<? if(cek_array($datax)):?>
								<input type="hidden" name="act" id="act" value="update"/>
							<? else:?>
								<input type="hidden" name="act" id="act" value="create"/>
							<? endif;?>
								<input type="hidden" name="status_rm_sebelumnya" id="status_rm_sebelumnya" value="<?php echo $data["status_rm"];?>"/>
							<input type="hidden" name="status_program_sebelumnya" id="status_program_sebelumnya" value="<?php echo $data["status_program"];?>"/>
							<input type="hidden" name="outcome_pasien_sebelumnya" id="outcome_pasien_sebelumnya" value="<?php echo $data["outcome_pasien"];?>"/>
							<input type="hidden" name="idx" id="idx" />
							<input type="hidden" name="idx_assesment" id="idx_assesment" value="<?=$data_asm["idx"]?>"/>
							<input type="hidden" name="no_rekam_medis" id="no_rekam_medis" value="<?=$data["no_rekam_medis"]?>"/>
							<!--<input type="hidden" name="act" id="act" value="<?//=$act?>"/>-->
						  	<input type="hidden" name="idx_pasien" value="<?=$idx_pasien?>" />
						  	<!--End-->
							<!--Tanggal Kegiatan-->
							<?php
									$tanggal_selector	=	date_format(date_create($datax['tgl_pertemuan']),"d-m-Y");
									$tanggal			=	date_format(date_create($datax['tgl_pertemuan']),"Y-m-d");
							?>
							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="pertemuan">Pertemuan Ke</label>
										<select name="idx_pertemuan" class="form-control" id="pertemuan">
											<option value="1" <?=($datax['idx_pertemuan']==1)?"selected":""?>>Pertemuan Ke - 1</option>
											<option value="2" <?=($datax['idx_pertemuan']==2)?"selected":""?>>Pertemuan Ke - 2</option>
											<option value="3" <?=($datax['idx_pertemuan']==3)?"selected":""?>>Pertemuan Ke - 3</option>
											<option value="4" <?=($datax['idx_pertemuan']==4)?"selected":""?>>Pertemuan Ke - 4</option>
										</select>
									</div>
								</div><!--End Of Col 6-->
								
								<div class="col-sm-6">
									<div class="form-group">
										<label for="tanggal_input" id="id_pertemuan">Tanggal Pertemuan <?=$datax['idx_pertemuan']?"Ke - ".$datax['idx_pertemuan']:"Ke - 1"?></label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="tgl_registrasi_selector" class="form-control input-date required" value="<?=$tanggal_selector?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
												<input type="hidden" id="tgl_registrasi" name="tanggal" value="<?=$tanggal?>" class="required" />
										</div>	
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="pertemuan">Jenis Kegiatan</label>
								<select name="idx_jenis_kegiatan" class="form-control" id="idx_jenis_kegiatan">
									<?php foreach($jenis_kegiatan as $k=>$v): ?>
									<option value="<?=$v['idx']?>" <?=($v['idx']==$datax['idx_jenis_kegiatan'])?"selected":""?>><?=$v['ur_jenis_kegiatan']?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="form-group">
								<label>Keterangan</label>
								<textarea name="keterangan" class="form-control" rows="3" id="keterangan"><?=$datax['keterangan']?></textarea>
							</div>
							<div class="form-group">
								<label for="nm_petugas">Lampiran</label>
								<input type="file" name="lampiran" id="lampiran"  />
								<?php if($datax["lampiran"]){?>
									File: <a target="_blank" href="<?=$this->config->item("dir_peer_group").$datax["lampiran"]?>">Download</a>
								<?php } ?>
								<div class="label_lampiran"></div>
							</div>
							<h4 class="heading">Konfirmasi</h4>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="nama">Status Kegiatan</label>
										<?=form_dropdown("status_pasien",$lookup_status,
												$data_proses["status_pasien"],
												"id='status_pasien' 
												class='form-control select2 required'");?>
									</div>
									<div class="col-md-6 tgl_selesai">
										<?php
											$tgl_selesai=date("Y-m-d H:i:s");
										?>
										<label for="nama">Tgl Selesai Kegiatan</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											<input type="text" id="tgl_selesai_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
											 <input type="hidden" id="tgl_selesai" name="tgl_selesai" value="<?=date("Y-m-d",strtotime($tgl_selesai));?>" class="required" />
										</div><!-- end input group -->
									</div>
								</div>
							</div><!-- end form-->
		
							<?php
								// $lookup["SS"]="Assesment";
								$lookup_proses_berikutnya=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
								$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
								$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
								$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
								$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
								$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
							?>
							<div class="form-group status_proses hidden ">
								<label for="nama">Proses Berikutnya?</label>
								<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
										$data["inst_pasca"],
										"id='status_proses' 
										class='form-control select2 required'");?>
							</div><!-- end form-->
							<div class="form-group bnnp hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='JALAN'):?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_pasca"],"id='bnnp' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_pasca"],"id='bnnp' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group bnnk hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='JALAN'):?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_pasca"],"id='bnnk' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_pasca"],"id='bnnk' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group balailoka hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $data['inst_pasca']=='BL'):?>
									<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_pasca"],"id='balailoka' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_pasca"],"id='balailoka' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group km hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $data['inst_pasca']=='KM'):?>
									<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_pasca"],"id='km' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_pasca"],"id='km' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
							<div class="form-group rd hidden">
								<label for="nama">Tujuan Rujukan</label>
								<?php if($data['status_rawat']=='INAP' && $data['inst_pasca']=='RD'):?>
									<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_pasca"],"id='rd' class='form-control select2 required'");?>
								<?php else: ?>
									<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_pasca"],"id='rd' disabled class='form-control select2 required'");?>
								<?php endif; ?>
							</div><!-- end form group -->
						<!--</form>-->
						</div>
                      </div>
					</div>
					
					<div class="col-sm-6">
						
									<ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Data Pasien</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rehabilitasi</a></li>
                                         <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Pasca Rehab</a></li>
											<!--	<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Pasca / Lanjut</a></li>-->
                                    </ul>
									<h4 class="heading" style="margin-top:25px;">Status Program</h4>
									<?=$this->load->view("common_view/pasien/progress_v");?>
		
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home" style=" backgorund-color:grey">
											
											<h4 class="heading">Pasien</h4>
											<?=$this->load->view("common_view/pasien/v_data_pasien");?>
										</div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
											<!--
											<h4 class="heading">History Rehab</h4>
											<?//=$this->load->view("common_view/pasien/v_hstry_rehab");?>
											-->
											<h4 class="heading">Monitoring Rehab</h4>
											<? $data['rawat_inap']='rawat_inap'?>
											<? $data['rawat_jalan']='rawat_jalan'?>
											<?=$this->load->view("common_view/pasien/v_mntr_rehab",$data);?>
											
										
										</div>
										  <div role="tabpanel" class="tab-pane" id="messages">
										  	<!--
											<h4 class="heading">History Pasca</h4>
											<?//=$this->load->view("common_view/pasien/v_hstry_pasca");?>
											-->
											<h4 class="heading">Monitoring Pasca</h4>
											<? $data['rawat_jalan_pasca']='rawat_jalan_pasca'?>
											<?=$this->load->view("common_view/pasien/v_mntr_pasca",$data);?>
										
										</div>
										<!---<div role="tabpanel" class="tab-pane" id="settings">4</div>-->
                                    </div>
							
					</div>
					
				</div>				
                <!-- /.box-body -->
              </div>
        </div>
		
			<div class="box box-widget">
				<div class="box-body">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="heading">Program</h4>
							<div class="form-group">
								<div class="row">
									<div class="col-md-3">
										<label for="nama">Status Program</label>
										<?php
											$lookup_status_p["PS"]="Proses"; 
											$lookup_status_p["SL"]="Selesai";
											$lookup_status_p["KB"]="Kambuh"; 
											$lookup_status_p["MD"]="Meninggal Dunia";										
										?>										
										<?=form_dropdown("status_program",$lookup_status_p,
												$data_proses["status_program"],
												"id='status_program' 
												class='form-control select2 required'");?>
									</div>
									<div class="col-md-3 tgl_selesai_program">
										<?php
											$tgl_selesai_program=date("Y-m-d H:i:s");
										?>
										<label for="nama">Tgl Selesai Program</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											<input type="text" id="tgl_selesai_program_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_selesai_program))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
											 <input type="hidden" id="tgl_selesai_program" name="tgl_selesai_program" value="<?=date("Y-m-d",strtotime($tgl_selesai_program));?>" class="required" />
										</div><!-- end input group -->
									</div>
								</div>
							</div><!-- end form-->
						</div>
					</div>
				</div>
			</div>
		
    </div>
	</form>
</section>

<script>
$(document).ready(function(){
	$("#status_program").on("change",function(){
		var val	=	$(this).val();
		if(val=="DO" || val=="MD"){
			$(".form-control").removeClass("required");
		}else{
			$(".form-control").addClass("required");
		}
	});
});
</script>

<script>
	$(document).ready(function(){
		$(".del_ajax").click(function(e){
			
			var konfirmasi	=	confirm("Apakah Anda Yakin Akan Menghapus Data Ini?");
			
			if(konfirmasi==true){
				var del_url		=	'<?=$this->module?>delete_ajax';
				
				var string = $(this).data("ref");
				eval('var object='+string);
				var idx		=	object.idx;

				$.ajax({
					type		:	"POST",
					url			:	del_url,
					cache		:	false,
					data		:	object,
					success		:	function(result) {
						if (result){
							$("#tr_"+idx).remove();
							new PNotify({
								title	:	'Info',
								text	:	'Hapus Data Berhasil!',
								type	:	'success'
							});
							var length	=	$(".data_tbl tr").length;							
							if(length==0){
								$("#act").val("create");
							}
						}
					}
				});
			}else{
				e.preventDefault(); 
			}
		});
	});
</script>		  

<script>
	$(document).ready(function(){
		$(".edit_data").on("click",function(){
			$(".title_form").text("Edit Data Peer Group");
				
			var string = $(this).data("ref");
			eval('var object='+string);
				
			<?php foreach($pasien_pg_history[0] as $k=>$v): ?>
			<?php if(($k!=="lampiran") && ($k!=="tgl_selesai")): ?>
			$("#<?=$k?>").val(object.<?=$k?>);		
			<?php endif; ?>
			<?php endforeach; ?>
			
			$("#pertemuan").val(object.idx_pertemuan).change();
			$("#tgl_registrasi").val(object.tgl_registrasi);
			$("#tgl_registrasi_selector").val(object.tgl_registrasi_selector);
			
			var lampiran	=	object.lampiran;
			
			if(lampiran){
				var href	=	'<a href="<?=$this->config->item("dir_peer_group")?>'+lampiran+'" target="_blank">Unduh Lampiran</a>';
				$(".label_lampiran").html(href);
			}else{
				$(".label_lampiran").text('');
			}		
		});
		
		$(".add_clean").on("click",function(){
			$(".title_form").text("Tambah Data Peer Group");
			
			$("#idx").val('');
			$("#tgl_kegiatan").val('<?=date("Y-m-d")?>');
			$("#tgl_kegiatan_selector").val('<?=date("d/m/Y")?>');
			$("#jenis_kegiatan").val("");
			$("#kegiatan").val("");
			$("#pertemuan_ke").val("1").change();
			$(".label_lampiran").text('');
			
		});		
	});
</script>


<script>
	$(function() {
		$(".tgl_selesai").hide();
		$('#tgl_selesai').prop( "disabled", true );
		$('#tgl_selesai_selector').prop( "disabled", true );
		
		$(".tgl_selesai_program").hide();
		$('#tgl_selesai_program').prop( "disabled", true );
		$('#tgl_selesai_program_selector').prop( "disabled", true );
		$("#status_pasien").on("change",function(){
			if($(this).find("option:selected").val()=='PS'){
				$(".tgl_selesai").hide();
				$('#tgl_selesai').prop( "disabled", true );
				$('#tgl_selesai_selector').prop( "disabled", true );
			}else{
				$(".tgl_selesai").show();
				$('#tgl_selesai').prop( "disabled", false );
				$('#tgl_selesai_selector').prop( "disabled", false );
			}
		});
		$("#status_program").on("change",function(){
			if($(this).find("option:selected").val()=='PS'){
				$(".tgl_selesai_program").hide();
				$('#tgl_selesai_program').prop( "disabled", true );
				$('#tgl_selesai_program_selector').prop( "disabled", true );
			}else{
				$(".tgl_selesai_program").show();
				$('#tgl_selesai_program').prop( "disabled", false );
				$('#tgl_selesai_program_selector').prop( "disabled", false );
			}
		});

	});
	
</script>  
<script>
	$(function() {
		var non = $('#status_proses').val();
		// alert(non);
		$("select").select2();
		if(non=='SS'){
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide(); 
			$('.km').hide(); 
			$('.rd').hide(); 
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
		}else if(non=='KM'){
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", false );
			$('#rd').prop( "disabled", true );
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide();	
			$('.km').show();	
			$('.rd').hide();
		}else if(non=='RD'){
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", false );
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide();	
			$('.km').hide();
			$('.rd').show();
		}else if(non=='BNNK'){
			$('#bnnk').prop( "disabled", false );
			$('#bnnp').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
			$('.bnnk').show(); 
			$('.bnnp').hide(); 
			$('.balailoka').hide();
			$('.km').hide();	
			$('.rd').hide();		
		}else if(non=='BNNP'){
			$('#bnnp').prop( "disabled", false );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", true );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
			$('.bnnp').show(); 
			$('.bnnk').hide(); 
			$('.balailoka').hide();
			$('.km').hide();	
			$('.rd').hide();		
		}else if(non=='BL'){
			$('#bnnp').prop( "disabled", true );
			$('#bnnk').prop( "disabled", true );
			$('#balailoka').prop( "disabled", false );
			$('#km').prop( "disabled", true );
			$('#rd').prop( "disabled", true );
			$('.bnnp').hide(); 
			$('.bnnk').hide(); 
			$('.balailoka').show();
			$('.km').hide();	
			$('.rd').hide();		
		}
		$('#status_proses').change(function(){
			// alert($('#status_proses').val());
			if($('#status_proses').val() == 'BL') {
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", false );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('.balailoka').show(); 
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.km').hide();
				$('.rd').hide();		
			} else if($('#status_proses').val() == 'BNNP'){
				$('#bnnp').prop( "disabled", false );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('.bnnp').show(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide();
				$('.km').hide();	
				$('.rd').hide();		
			} else if($('#status_proses').val() == 'BNNK'){
				$('#bnnk').prop( "disabled", false );
				$('#bnnp').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('.bnnk').show(); 
				$('.bnnp').hide(); 
				$('.balailoka').hide();
				$('.km').hide();	
				$('.rd').hide();		

			} else if($('#status_proses').val() == 'KM'){//JALAN=BALAI/LOKA
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", false );
				$('#rd').prop( "disabled", true );
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide();	
				$('.km').show();	
				$('.rd').hide();		
			} else if($('#status_proses').val() == 'RD'){
				$('#bnnp').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", false );
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.balailoka').hide();	
				$('.km').hide();
				$('.rd').show();				
			} else {
				$('#bnnp').prop( "disabled", true );
				$('#balailoka').prop( "disabled", true );
				$('#km').prop( "disabled", true );
				$('#rd').prop( "disabled", true );
				$('#bnnk').prop( "disabled", true );
				$('.balailoka').hide(); 
				$('.bnnp').hide(); 
				$('.bnnk').hide(); 
				$('.km').hide();	
				$('.rd').hide();					
			}
		});
	});
	// $("#balailoka").select2();
		// $("#km").select2({'placeholder':"--Pilih--"});
		// <?php if($data['status_rawat']=='JALAN' && $data['inst_rujuk']=='BNNP'):?>
			// $('.km').hide(); 
			// $('.bnnp').show(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']=='JALAN' && $data['inst_rujuk']=='BNNK'): ?>
			// $('.km').hide(); 
			// $('.bnnp').hide(); 
			// $('.bnnk').show(); 
			// $('.balailoka').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']==NULL): ?>
			// $('.bnnp').hide(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
		// <?php endif; ?>
		// <?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='BL'):?>
			// $('.balailoka').show(); 
			// $('.bnnp').hide();
			// $('.bnnk').hide(); 			
			// $('.km').hide(); 
			// $('.rd').hide(); 
		// <?php elseif($data['status_rawat']==NULL): ?>
			// $('.bnnp').hide(); 
			// $('.bnnk').hide(); 
			// $('.balailoka').hide(); 
			// $('.km').hide(); 
		// <?php endif; ?>
</script> 
<script language="javascript">
$(document).ready(function(){      
	$('#prov').change(function(){
		$.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
			$('#kab').html(obj);
		});
    });
	$("#previewplay").click(function(){
		$("#imgInpPlay").trigger("click");
	});
});
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '180px');
                //$('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>
<script>
	$(function(){
		$("#frm").validate();
		
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
		
		$(".group").click(function(){
			//$("#company").prop("disabled",$(this).data('org')==1 ? false: true);
			var use_org = $(this).data('org');
			$("#company").val(use_org);
			$("#company option").show();
			$("#company option").each(function(){
				if (!use_org) {
					$(this).val()!=0?$(this).hide():$(this).show();
				}
				else {
					$(this).val()!=0?$(this).show():$(this).hide();
				}
			});
		});
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		  checkboxClass: 'icheckbox_flat-green',
		  radioClass: 'iradio_flat-green'
		});
	})
</script>

<script>
$(document).ready(function(){
	$("#lampiran").on("change",function(){
		var lampiran_name	=	$("#lampiran").val();
		$("#lampiran_name").val(lampiran_name);
	});
});
</script>

<script>
$(document).ready(function(){
	$("#pertemuan").on("change",function(){
		var val_pertemuan	=	$("#pertemuan").val();
		$("#id_pertemuan").text("Tanggal Pertemuan Ke - "+val_pertemuan);
		
		<?php if($act=="edit"): ?>
		if(val_pertemuan==1){
			var	tgl_pertemuan_s	=	'<?=$datax['tgl_pertemuan_1']?date_format(date_create($datax['tgl_pertemuan_1']),"d-m-Y"):date("d-m-Y")?>';
			var	tgl_pertemuan	=	'<?=$datax['tgl_pertemuan_1']?date_format(date_create($datax['tgl_pertemuan_1']),"Y-m-d"):date("Y-m-d")?>';
		}else if(val_pertemuan==2){
			var	tgl_pertemuan_s	=	'<?=$datax['tgl_pertemuan_2']?date_format(date_create($datax['tgl_pertemuan_2']),"d-m-Y"):date("d-m-Y")?>';
			var	tgl_pertemuan	=	'<?=$datax['tgl_pertemuan_2']?date_format(date_create($datax['tgl_pertemuan_2']),"Y-m-d"):date("Y-m-d")?>';
		}else if(val_pertemuan==3){
			var	tgl_pertemuan_s	=	'<?=$datax['tgl_pertemuan_3']?date_format(date_create($datax['tgl_pertemuan_3']),"d-m-Y"):date("d-m-Y")?>';
			var	tgl_pertemuan	=	'<?=$datax['tgl_pertemuan_3']?date_format(date_create($datax['tgl_pertemuan_3']),"Y-m-d"):date("Y-m-d")?>';
		}else if(val_pertemuan==4){
			var	tgl_pertemuan_s	=	'<?=$datax['tgl_pertemuan_4']?date_format(date_create($datax['tgl_pertemuan_4']),"d-m-Y"):date("d-m-Y")?>';
			var	tgl_pertemuan	=	'<?=$datax['tgl_pertemuan_4']?date_format(date_create($datax['tgl_pertemuan_4']),"Y-m-d"):date("Y-m-d")?>';
		}
		$("#tgl_registrasi_selector").val(tgl_pertemuan_s);
		$("#tgl_registrasi").val(tgl_pertemuan);
		<?php endif; ?>
	});
});
</script>

<script>
$(document).ready(function(){
	<?php for($i=1; $i<5; $i++): ?>
		<?php if($datax['tgl_pertemuan_'.$i]): ?>
			$("#cek<?=$i?>").prop("checked",true);
			
			$("#cek<?=$i?>").on("change",function(){
				if($(this).prop("checked")){
					$("#pertemuan_<?=$i?>_selector").prop("disabled",false).val("<?=date_format(date_create($datax['tgl_pertemuan_'.$i]),"d-m-Y")?>");
					$("#pertemuan_<?=$i?>").val("<?=date_format(date_create($datax['tgl_pertemuan_'.$i]),"Y-m-d")?>");
					
				}else{
					$("#pertemuan_<?=$i?>_selector").prop("disabled",true).val("");
					$("#pertemuan_<?=$i?>").val('');
				}
			});
		<?php else: ?>
			$("#pertemuan_<?=$i?>_selector").prop("disabled",true).val('');
			$("#pertemuan_<?=$i?>").prop("disabled",true);
			
			$("#cek<?=$i?>").on("change",function(){
				if($(this).prop('checked')){
					$("#pertemuan_<?=$i?>_selector").prop("disabled",false).val('<?=date("d-m-Y")?>');
					$("#pertemuan_<?=$i?>").prop("disabled",false).val('<?=date("Y-m-d")?>');
				}else{
					$("#pertemuan_<?=$i?>_selector").prop("disabled",true).val('');
					$("#pertemuan_<?=$i?>").prop("disabled",true);
				}
			});		
		<?php endif;?>
	<?php endfor; ?>
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
	$(".del_file_href").click(function(){
		//alert("tes");
		e.preventDefault(); 
        var href 	=	$(this).attr("href");
		
		$.ajax({
        	type	:	"POST",
        	url		:	href,
        	success	:	function(res){
            	if(res=="Success"){
                	alert('Success');
           		}else{
                	alert("Error");
             	}
             	return false;
			}
       });
		
	});
		/*
        
        var btn 	=	this;

        $.ajax({
        	type	:	"POST",
        	url		:	href,
        	success	:	function(res){
            	if(res=="Success"){
                	alert('Success');
           		}else{
                	alert("Error");
             	}
             	return false;
			}
       }
   });
   return false;
   });
   */
});
</script>