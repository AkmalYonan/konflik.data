<?php	
	$lookup_pertemuan[1]="1";
	$lookup_pertemuan[2]="2";
	$lookup_pertemuan[3]="3";
	$lookup_pertemuan[4]="4";
	
	$lookup_jenis_kegiatan["pt1"]="4 Bulan";
	$lookup_jenis_kegiatan["pt2"]="6 Bulan";
	
	$lookup_status["PS"]="Proses";
	$lookup_status["SL"]="Selesai";  
	
	$lookup_status_p["PS"]="Proses"; 
	$lookup_status_p["DO"]="DO";
	$lookup_status_p["MD"]="Meninggal Dunia";
	
	//pre($monitoring_rehab);
	$tgl_limit_prev = $monitoring_rehab['tgl_eu_selesai'];
?>

<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped table-condensed small-font data_tbl">
			<?php if(count($pasien_pt_history)>0):?>
				<?php foreach($pasien_pt_history as $x=>$val): ?>
				<tr id="tr_<?=$val['idx']?>">
					<td><?php echo $x+1?>.</td>
					<td><?php echo ($val["tgl_kegiatan"])?date2indo($val["tgl_kegiatan"]):"<center>-</center>"?></td>
					<td align="center">Pertemuan Ke-<?php echo $val["pertemuan_ke"]?></td>
					<td><?php echo $val["jenis_kegiatan"]?></td>
					<td align="center">
						<?php if($val['lampiran']): ?>
							<a href="<?=$this->config->item("dir_pt").$val['lampiran']?>" target="_blank">
								<span class="label label-info"><i class="fa fa-download">&nbsp;</i></span>
							</a>
						<?php else: echo "-"; endif; ?>
					</td>
					<td align="center">
						<?php 
							foreach($val as $k=>$v): 
								$ref[]	=	$k.":'".$v."'";
							endforeach;
							$ref[]	=	"tgl_kegiatan:'".date("Y-m-d",strtotime($val["tgl_kegiatan"]))."'";
							$ref[]	=	"tgl_kegiatan_selector:'".date("d/m/Y",strtotime($val["tgl_kegiatan"]))."'";
							$data_ref	=	join(',',$ref);
						?>
							
						<div class="btn-group btn-group-xs">
							<a class="btn btn-xs btn-default edit_data" data-toggle='tooltip' data-ref="{<?=$data_ref?>}" title="Edit"><i class="fa fa-pencil green"></i></a> 
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
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<h4 class="heading title_form">Tambah Data Primary Treatment</h4>
	</div>
</div>

<?php $id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; ?>

<form id="frm" method="post" enctype="multipart/form-data" action="<?php echo $this->module;?>update_proses/<?php echo $id;?>">
    <? if(cek_array($data_proses)):?>
    	<input type="hidden" name="act" id="act" value="update"/>
    <? else:?>
		<input type="hidden" name="act" id="act" value="create"/>
    <? endif;?>
		<input type="hidden" name="status_rm_sebelumnya" id="status_rm_sebelumnya" value="<?php echo $data["status_rm"];?>"/>
	<input type="hidden" name="status_program_sebelumnya" id="status_program_sebelumnya" value="<?php echo $data["status_program"];?>"/>
	<input type="hidden" name="outcome_pasien_sebelumnya" id="outcome_pasien_sebelumnya" value="<?php echo $data["outcome_pasien"];?>"/>
	
	<input type="hidden" name="idx_assesment" id="idx_assesment" value="<?=$data_asm["idx"]?>"/>
	<input type="hidden" name="no_rekam_medis" id="no_rekam_medis" value="<?=$data["no_rekam_medis"]?>"/>
	
    <input type="hidden" name="idx_pasien" id="idx_pasien" value="<?=$data["idx"]?>"/>
    <input type="hidden" name="idx" id="idx" />
    <div class="row">
    <div class="col-md-12">
    	<div class="form-group">
			<div class="row">
				<div class="col-md-6">
            <?php
                $tgl_kegiatan=date("Y-m-d H:i:s");
                                ?>
                <label for="nama">Tgl Kegiatan</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tgl_kegiatan_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_kegiatan))?>" placeholder="dd/mm/yyyy" data-mindate="<?=date("d/m/Y",strtotime($tgl_limit_prev))?>" />
                     <input type="hidden" id="tgl_kegiatan" name="tgl_kegiatan" value="<?=date("Y-m-d",strtotime($tgl_kegiatan));?>" class="required" />
                </div><!-- end input group -->
            </div></div>                
        </div><!-- end form group-->
		<div class="form-group">
            <label for="kd_jenis_instansi">Jenis Kegiatan</label>
            <input class="form-control required" name="jenis_kegiatan" id="jenis_kegiatan" type="text"  />
        </div>
		<!--
    	<div class="form-group">
                         	<label for="jenis_pendidikan">Jenis Treatment</label>
                            <?//echo form_dropdown("jenis_treatment",$lookup_jenis_kegiatan,$data_proses["jenis_treatment"],"id='jenis_treatment' class='form-control required'");?>                         
                        </div>
		-->
    	<div class="form-group">
        					<label for="alamat">Keterangan</label>
							<textarea class="input-xs form-control" id="kegiatan" rows="5" name="kegiatan" placeholder=""></textarea>
        </div>
    
    	<div class="form-group">
			<div class="row">
				<div class="col-md-6">
                         	<label for="jenis_pendidikan">Pertemuan Ke</label>
                            <? echo form_dropdown("pertemuan_ke",$lookup_pertemuan,"","id='pertemuan_ke' class='form-control required'");?>                         
                        </div><!-- end form group-->
			</div>
		</div>
		<div class="form-group">
					<label for="nama">Lampiran</label>
					<input type="file" name="lampiran">
					<div class="label_lampiran" style="color:#0099FF"></div>
				</div><!-- end form-->
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
			$lookup["SS"]="Assesment";
			$lookup_proses_berikutnya=$lookup+lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","idx='15' or idx='16' or idx='18' or idx='19' or idx='20'","order by idx,order_num");
			$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
			$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
			$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
			$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
			$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
		?>
		<div class="form-group status_proses hidden">
			<label for="nama">Proses Berikutnya?</label>
			<?=form_dropdown("status_proses",$lookup_proses_berikutnya,
					$data["inst_rujuk"],
					"id='status_proses' 
					class='form-control select2 required'");?>
		</div><!-- end form-->
		<div class="form-group bnnp hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='JALAN'):?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayah,$data["rujuk_rehab"],"id='bnnp' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group bnnk hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='JALAN'):?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("kd_wilayah",$lookup_wilayahx,$data["rujuk_rehab"],"id='bnnk' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group balailoka hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='BL'):?>
				<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("id_kabupaten",$lookup_wilayah2,$data["rujuk_rehab"],"id='balailoka' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group km hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='KM'):?>
				<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("id_km",$lookup_wilayah3,$data["rujuk_rehab"],"id='km' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
		<div class="form-group rd hidden">
			<label for="nama">Tujuan Rujukan</label>
			<?php if($data['status_rawat']=='INAP' && $data['inst_rujuk']=='RD'):?>
				<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' class='form-control select2 required'");?>
			<?php else: ?>
				<?=form_dropdown("id_rd",$lookup_wilayah4,$data["rujuk_rehab"],"id='rd' disabled class='form-control select2 required'");?>
			<?php endif; ?>
		</div><!-- end form group -->
    
    </div></div><!-- end row col -->  
	
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
