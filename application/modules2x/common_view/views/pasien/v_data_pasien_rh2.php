<?php
	$lookup_empty=array(""=>"--pilih--");
	$lookup_bnnp=lookup("m_org","kd_org","nama",false,"order by idx");
	$lookup_status_nikah=$this->data_lookup["status_kawin"];
	$lookup_balai=$lookup_empty+lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
	$lookup_jns_org=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org",false,"order by idx");
	$lookup_inst=lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
	$data_foto=pasien_foto($data["idx"]);		
	$foto=cek_array($data_foto)?$data_foto["path"].$data_foto["file_name"]:"assets/images/pic.jpg";
?>
<?
	//$inst_rujuk = ($rehab_stat['inst_rujuk'])? $rehab_stat['inst_rujuk']:$data['inst_rujuk'];
	//$rujuk_rehab = ($rehab_stat['rujuk_rehab'])? $rehab_stat['rujuk_rehab']:$data['rujuk_rehab'];
	
	//$inst_pasca = ($pasca_stat['inst_pasca'])? $pasca_stat['inst_pasca']:$data['inst_pasca'];
	//$rujuk_pasca = ($pasca_stat['rujuk_pasca'])? $pasca_stat['rujuk_pasca']:$data['rujuk_pasca'];
	
	$inst_rujuk = $rehab_stat['inst_rujuk'];
	$rujuk_rehab = $rehab_stat['rujuk_rehab'];
	
	$inst_pasca = $pasca_stat['inst_pasca'];
	$rujuk_pasca = $pasca_stat['rujuk_pasca'];
	
	$inst_lanjut = $lanjut_stat['inst_lanjut'];
	$rujuk_lanjut = $lanjut_stat['rujuk_lanjut'];
	
	$lookup_bnnp	=	lookup("m_org","kd_org","nama","tipe_org='BNNP' and active='1'","order by idx");
	$lookup_bnnk	=	lookup("m_org","kd_org","nama","tipe_org='BNNK' and active='1'","order by idx");	
	$lookup_balai	=	lookup("m_instansi","kd_instansi","nama_instansi","","order by idx");

	
?>

<div class="row">
	<div class="col-md-2">
    	<img class="profile-user-img img-responsive foto-pasien" style="width:100% !important; min-height:200px" src="<?=$foto?>" alt="Foto Pasien">
    </div>
    <div class="col-md-5">
    	<table class="table table-condensed table-bordered">
        	<tr>
            	<td width="150px"><strong>Nama</strong></td>
                <td><?=$data["nama"]?></td>
            </tr>
             <tr>
            	<td><strong>NIK</strong></td>
				<td><?=$data["nik"]?></td>
            </tr>	
            
            <tr>
            	<td><strong>Tempat, Tanggal Lahir</strong></td>
                <td><?=$data["tempat_lahir"]?>, <?=date2indo($data["tgl_lahir"])?></td>
            </tr>	
            
            <tr>
            	<td><strong>Jenis Kelamin & Umur</strong></td>
                <td><?=$this->data_lookup["jenis_kelamin"][$data["jenis_kelamin"]]?> (<?=$data["umur"]*1?> Tahun)</td>
            </tr>	
           <tr>
            	<td><strong>Status Menikah</strong></td>
                <td><?=$lookup_status_nikah[$data["status_nikah"]]?></td>
            </tr>	
            
            
            <tr>
            	<td><strong>Golongan Darah</strong></td>
                <td><?=$data["golongan_darah"]?></td>
            </tr>	
             <tr>
            	<td><strong>Agama</strong></td>
                <td><?=$data["agama"]?></td>
            	
            </tr>	
             <tr>
            	<td><strong>Suku</strong></td>
                <td><?=$data["suku"]?></td>
            	
            </tr>
      </table>
    </div>
    <div class="col-md-5">
    	<table class="table table-condensed table-bordered">
        	 
            <tr>
            	<td><strong>No Rekam Medis</strong></td>
				<td><?=$data["no_rekam_medis"]?></td>
            </tr>
            <tr>
            	<td><strong>Pekerjaan</strong></td>
                <td><?=$data["pekerjaan"]?></td>
            </tr>
        	<tr>
            	<td><strong>No Telepon</strong></td>
                <td><?=$data["no_telp"]?></td>
            	
            </tr>	
            <tr>
            	<td><strong>No HP</strong></td>
                <td><?=$data["no_hp"]?></td>
            </tr>	
            <tr>
            	<td><strong>Alamat Rumah</strong></td>
                <td> <?=$data["alamat"]?> <br><?=$data["kode_pos"]?></td>
            </tr>	
            
            <tr>
            	<td width="150px"><strong>Nama Ibu</strong></td>
                <td> <?=$data["ibu"]?></td>
            	
            </tr>	
             <tr>
            	<td><strong>Nama Ayah</strong></td>
                <td> <?=$data["ayah"]?></td>
            </tr>		
        </table>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
    	<table class="table table-bordered table-condensed hidden" style="width:100%">
			<tr>
				<td rowspan="6" width="180px" align="center">
					<img class="profile-user-img img-responsive foto-pasien" style="width:100% !important; min-height:200px" src="<?=$foto?>" alt="Foto Pasien">
				</td>
				<td width="150"><strong>Nama</strong></td>
                <td><?=$data["nama"]?></td>
				<td width="100"><strong>NIK</strong></td>
				<td><?=$data["nik"]?></td>
				<td width="150"><strong>No Rekam Medis</strong></td>
				<td><?=$data["no_rekam_medis"]?></td>
			</tr>
			<tr>
            	<td><strong>Tempat, Tanggal Lahir</strong></td>
                <td><?=$data["tempat_lahir"]?>, <?=date2indo($data["tgl_lahir"])?></td>
            	<td><strong>Umur</strong></td>
                <td><?=$data["umur"]*1?> Tahun</td>
            	<td><strong>Jenis Kelamin</strong></td>
                <td><?=$this->data_lookup["jenis_kelamin"][$data["jenis_kelamin"]]?></td>
            </tr>
			<tr>
            	<td><strong>Tanda Pengenal</strong></td>
                <td>KTP, <?=$data["nik"]?></td>
            	<td><strong>Nama Ibu</strong></td>
                <td> <?=$data["ibu"]?></td>
            	<td><strong>Nama Ayah</strong></td>
                <td> <?=$data["ayah"]?></td>
			</tr>
			<tr>
            	<td><strong>Agama</strong></td>
                <td><?=$data["agama"]?></td>
            	<td><strong>Suku</strong></td>
                <td><?=$data["suku"]?></td>
            	<td><strong>Status Menikah</strong></td>
                <td><?=$lookup_status_nikah[$data["status_nikah"]]?></td>
            </tr>			
			<tr>
            	<td><strong>Pekerjaan</strong></td>
                <td><?=$data["pekerjaan"]?></td>
            	<td><strong>Alamat Rumah</strong></td>
                <td> <?=$data["alamat"]?></td>
            	<td><strong>Kode Pos</strong></td>
                <td> <?=$data["kode_pos"]?></td>
            </tr>			
			<tr>
            	<td><strong>Golongan Darah</strong></td>
                <td><?=$data["golongan_darah"]?></td>
            	<td><strong>No Telepon</strong></td>
                <td><?=$data["no_telp"]?></td>
            	<td><strong>No HP</strong></td>
                <td><?=$data["no_hp"]?></td>
            </tr>
			
        </table>
		
		<h4 class="heading">Riwayat Pasien</h4>
		
		<div class="box-group" id="accordion">
			<?php foreach($history_rh as $k=>$v): ?>
            
			<div class="panel box box-primary">
				<div class="box-header with-borders" data-toggle="collapse" data-parent="#accordion" href="#panel<?=$k?>">
					<h4 class="box-title">
						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#panel<?=$k?>">
							<h4 style="color:#999999">Riwayat <?=($k+1)?></h4>
						</a>
					</h4>
				</div>
				<div id="panel<?=$k?>" class="panel-collapse collapse <?=$k==($total_rh-1)?"in":""; ?>">
					<div class="box-body no-paddings">
                    	
                        <div class="tab-pane active" id="timeline">
                            <!-- The timeline -->
                            <ul class="timeline timeline-inverse">
                              <!-- timeline time label -->
                              <li class="time-label">
                                    <span class="bg-aqua">
                                      ASSESMENT - <?=date("d-m-Y",strtotime($v['tgl_kedatangan']))?>
                                    </span>
                              </li>
                              <!-- /.timeline-label -->
                              <!-- timeline item -->
                              <li>
                                <i class="fa fa-user bg-blue"></i>
            
                                <div class="timeline-item">
                                  <h3 class="timeline-header">
                                  	<a >Asal Rujukan: </a> 
									<?php 
									if($v['jns_org']==1):
										echo $lookup_bnnp[$v['kd_bnn']];
									elseif($v['jns_org']==3):
										echo $lookup_bnnk[$v['kd_bnn']];
									elseif($v['jns_org']==2):
										echo $lookup_balai[$v['kd_bnn']];
									endif;
									?>
                                  </h3>
            
                                  <div class="timeline-body">
                                    <table class="table table-condensed">
                                    <tr>
                                        <td width="200"><strong>Rujukan Rehabilitasi</strong></td>
                                        <td colspan="5">
                                        <?php 
                                            if($v['inst_rujuk']=="BNNP"):
                                                echo $lookup_bnnp[$v['rujuk_rehab']];
                                            elseif($v['inst_rujuk']=="BNNK"):
                                                echo $lookup_bnnk[$v['rujuk_rehab']];
                                            elseif($v['inst_rujuk']=="BL"):
                                                echo $lookup_balai[$v['rujuk_rehab']];
                                            elseif($v['inst_rujuk']=="KM"):
                                                echo $lookup_balai[$v['rujuk_rehab']];	
                                            elseif($v['inst_rujuk']=="RD"):
                                                echo $lookup_balai[$v['rujuk_rehab']];	
                                            endif;
                                        ?>	
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="200"><strong>Tanggal Kedatangan</strong></td>
                                        <td colspan="5"><?=date("d-m-Y",strtotime($v['tgl_kedatangan']))?></td>
                                    </tr>
                                    <tr>
                                        <td width="200"><strong>Tanggal Assesment</strong></td>
                                        <td colspan="5"><?=date("d-m-Y",strtotime($v['tgl_assesment']))?></td>
                                    </tr>
                                    <tr>
                                        <td width="200"><strong>Diagnosis Napza</strong></td>
                                        <td colspan="5">Klien Memenuhi Kriteria Diagnosis Napza <font color="#0099FF"><?=$v['diagnosis_napza']?></font> [ <?=$v['keterangan_diagnosis_napza']?> ]</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diagnosis Lain</strong></td>
                                        <td align="justify" colspan="5"><?=$v['diagnosis_lain']?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Resume Rencana Terapi</strong></td>
                                        <td align="justify" colspan="5"><?=$v['rencana_terapi_resume']?></td>
                                    </tr>
                                    </table>
                                  </div>
                                  <div class="timeline-footer">
                                    <a class="btn btn-primary btn-xs">Read more</a>
                                    <a class="btn btn-danger btn-xs">Delete</a>
                                  </div>
                                </div>
                              </li>
                              <!-- END timeline item -->
                              <!-- timeline item -->
                              <li>
                                <i class="fa fa-edit bg-aqua"></i>
            
                                <div class="timeline-item">
                                  <span class="time"><i class="fa fa-clock-o"></i> <?=date("d-m-Y",strtotime($v['tgl_assesment']))?></span>
            
                                  <h3 class="timeline-header no-border">Masalah Yang Dihadapi</h3>
                                  
                                  <div class="timeline-body">
                                    <table class="table table-bordered table-condensed small-font">
										<thead>
											<tr>
												<th rowspan="2"><p align="center">No</p></th>
												<th rowspan="2"><p align="center">Masalah</p></th>
												<th colspan="9"><p align="center">Nilai</p></th>
											</tr>
											<tr>
												<?php for($i=0; $i<9; $i++): ?>
												<th class="tmiddle"><p align="center"><?=$i+1?></p></th>
												<?php endfor; ?>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td align="center">1</td>
												<td>Medis</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_medis']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">2</td>
												<td>Pekerjaan/Dukungan</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_pekerjaan']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">3</td>
												<td>Napza</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_napza']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">4</td>
												<td>Legal</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_legal']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">5</td>
												<td>Keluarga/Sosial</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_keluarga']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">6</td>
												<td>Psikiatris</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_psikiatris']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
										</tbody>
									</table>	
                                  </div>
                                </div>
                              </li>
                              <!-- END timeline item -->
                              <!-- timeline time label -->
                              <li class="time-label">
                                    <span class="bg-green">
                                      REHABILITASI -
										<?php
											if($v['tgl_mulai_rehab']):
												echo date("d-m-Y",strtotime($v['tgl_mulai_rehab']));
											else:
												echo "<span class='label label-info'>Belum Mulai</span>";
											endif;
										?>
                                    </span>
                                    
                              </li>
                              <!-- /.timeline-label -->
                              <!-- timeline item -->
                              <li>
                                <i class="fa fa-history bg-green"></i>
            
                                <div class="timeline-item">
                                  <h3 class="timeline-header">
                                  	<a >Rujukan Rehabilitasi: </a> 
									<?php 
                                            if($v['inst_rujuk']=="BNNP"):
                                                echo $lookup_bnnp[$v['rujuk_rehab']];
                                            elseif($v['inst_rujuk']=="BNNK"):
                                                echo $lookup_bnnk[$v['rujuk_rehab']];
                                            elseif($v['inst_rujuk']=="BL"):
                                                echo $lookup_balai[$v['rujuk_rehab']];
                                            elseif($v['inst_rujuk']=="KM"):
                                                echo $lookup_balai[$v['rujuk_rehab']];	
                                            elseif($v['inst_rujuk']=="RD"):
                                                echo $lookup_balai[$v['rujuk_rehab']];	
                                            endif;
                                        ?>	
                                  </h3>
            
                                  <div class="timeline-body">
                                    <table class="table table-condensed">
                                    
                                    <tr>
									<td width="200"><strong>Jenis Rehabilitasi</strong></td>
									<td>
										<?php
											if($v['tgl_dt']):
												echo "Rawat Inap";
											elseif($v['tgl_kl']):
												echo "Rawat Jalan";
											endif;
										?>
									</td>
								</tr>
								<tr>
									<td><strong>Tempat Rujukan</strong></td>
									<td>
									<?php 
										if($v['inst_rujuk']=="BNNP"):
											echo $lookup_bnnp[$v['rujuk_rehab']];
										elseif($v['inst_rujuk']=="BNNK"):
											echo $lookup_bnnk[$v['rujuk_rehab']];
										else:
											echo $lookup_balai[$v['rujuk_rehab']];
										endif;
									?>
									</td>
								</tr>
								<tr>
									<td><strong>Tanggal Mulai</strong></td>
									<td>
										<?php
											if($v['tgl_mulai_rehab']):
												echo date("d-m-Y",strtotime($v['tgl_mulai_rehab']));
											else:
												echo "<span class='label label-info'>Belum Mulai</span>";
											endif;
										?>
									</td>
								</tr>
								<tr>
									<td><strong>Tanggal Selesai</strong></td>
									<td>
										<?php
											if($v['status_program_rehab']!=="MD" && $v['status_program_rehab']!=="DO"):
												if($v['tgl_selesai_rehab']):
													echo date("d-m-Y",strtotime($v['tgl_selesai_rehab']));
												else:
													echo "<span class='label label-info'>Belum Selesai</span>";
												endif;
											else:
												if($v['status_program_rehab']=="MD"):
													echo "Program Berhenti Karena Pasien Meninggal Dunia";	
												elseif($v['status_program_rehab']=="DO"):
													echo "Program Berhenti Karena Pasien Dinyatakan Drop Out";	
												endif;		
											endif;
										?>
									</td>
								</tr>
                                    </table>
                                  </div>
                                  <div class="timeline-footer">
                                    <a class="btn btn-primary btn-xs">Read more</a>
                                    <a class="btn btn-danger btn-xs">Delete</a>
                                  </div>
                                </div>
                              </li>
                              <!-- END timeline item -->
                              <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                              </li>
                            </ul>
                          </div>
                        
                        
                        
                        
                        
                        
						<table class="table table-condensed">
							<tr>
								<td colspan="6"><h4 style="color:#0099FF" class="heading"><strong>Assesment</strong></h4></td>
							</tr>
							<tr>
								<td width="200"><strong>Asal Rujukan</strong></td>
								<td colspan="5">				
								<?php 
									if($v['jns_org']==1):
										echo $lookup_bnnp[$v['kd_bnn']];
									elseif($v['jns_org']==3):
										echo $lookup_bnnk[$v['kd_bnn']];
									elseif($v['jns_org']==2):
										echo $lookup_balai[$v['kd_bnn']];
									endif;
								?>				
								</td>
							</tr>
							<tr>
								<td width="200"><strong>Tanggal Kedatangan</strong></td>
								<td colspan="5"><?=date("d-m-Y",strtotime($v['tgl_kedatangan']))?></td>
							</tr>
							<tr>
								<td width="200"><strong>Tanggal Assesment</strong></td>
								<td colspan="5"><?=date("d-m-Y",strtotime($v['tgl_assesment']))?></td>
							</tr>
							<tr>
								<td width="200"><strong>Rujukan Rehabilitasi</strong></td>
								<td colspan="5">
								<?php 
									if($v['inst_rujuk']=="BNNP"):
										echo $lookup_bnnp[$v['rujuk_rehab']];
									elseif($v['inst_rujuk']=="BNNK"):
										echo $lookup_bnnk[$v['rujuk_rehab']];
									elseif($v['inst_rujuk']=="BL"):
										echo $lookup_balai[$v['rujuk_rehab']];
									elseif($v['inst_rujuk']=="KM"):
										echo $lookup_balai[$v['rujuk_rehab']];	
									elseif($v['inst_rujuk']=="RD"):
										echo $lookup_balai[$v['rujuk_rehab']];	
									endif;
								?>	
								</td>
							</tr>
							<tr>
								<td width="200"><strong>Diagnosis Napza</strong></td>
								<td colspan="5">Klien Memenuhi Kriteria Diagnosis Napza <font color="#0099FF"><?=$v['diagnosis_napza']?></font> [ <?=$v['keterangan_diagnosis_napza']?> ]</td>
							</tr>
							<tr>
								<td><strong>Diagnosis Lain</strong></td>
								<td align="justify" colspan="5"><?=$v['diagnosis_lain']?></td>
							</tr>
							<tr>
								<td><strong>Resume Rencana Terapi</strong></td>
								<td align="justify" colspan="5"><?=$v['rencana_terapi_resume']?></td>
							</tr>
							<tr>
								<td><strong>Masalah Yang Dihadapi</strong></td>
								<td colspan="5">
								
									<table class="table table-bordered table-condensed small-font">
										<thead>
											<tr>
												<th rowspan="2"><p align="center">No</p></th>
												<th rowspan="2"><p align="center">Masalah</p></th>
												<th colspan="9"><p align="center">Nilai</p></th>
											</tr>
											<tr>
												<?php for($i=0; $i<9; $i++): ?>
												<th class="tmiddle"><p align="center"><?=$i+1?></p></th>
												<?php endfor; ?>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td align="center">1</td>
												<td>Medis</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_medis']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">2</td>
												<td>Pekerjaan/Dukungan</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_pekerjaan']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">3</td>
												<td>Napza</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_napza']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">4</td>
												<td>Legal</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_legal']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">5</td>
												<td>Keluarga/Sosial</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_keluarga']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
											<tr>
												<td align="center">6</td>
												<td>Psikiatris</td>
												<?php for($i=0; $i<9; $i++): ?>
												<?php if($v['masalah_psikiatris']==($i+1)): ?>
												<td align="center"><i class="fa fa-check green"></i></td>
												<?php else: ?>
												<td></td>
												<?php endif; ?>
												<?php endfor; ?>
											</tr>
										</tbody>
									</table>				
								</td>
							</tr>
						</table>
						
						<?php if($v['inst_rujuk']): ?>
							<?php
								if($v['status_program_rehab']=='SL'):
									$status_program_rehab	= "<span class='label label-success'>Selesai</span>";
								elseif($v['status_program_rehab']=="MD"):
									$status_program_rehab	= "<span class='label' style='background-color:#990099'>Meninggal Dunia</span>";	
								elseif($v['status_program_rehab']=="DO"):
									$status_program_rehab	= "<span class='label label-danger'>Drop Out</span>";
								endif;		
							?>
							<table class="table table-condensed">
								<tr>
									<td colspan="2"><h4 style="color:#0099FF" class="heading"><strong>Rehabilitasi</strong><div class="pull-right"><?=$status_program_rehab?></div></h4></td>
								</tr>
								<tr>
									<td width="200"><strong>Jenis Rehabilitasi</strong></td>
									<td>
										<?php
											if($v['tgl_dt']):
												echo "Rawat Inap";
											elseif($v['tgl_kl']):
												echo "Rawat Jalan";
											endif;
										?>
									</td>
								</tr>
								<tr>
									<td><strong>Tempat Rujukan</strong></td>
									<td>
									<?php 
										if($v['inst_rujuk']=="BNNP"):
											echo $lookup_bnnp[$v['rujuk_rehab']];
										elseif($v['inst_rujuk']=="BNNK"):
											echo $lookup_bnnk[$v['rujuk_rehab']];
										else:
											echo $lookup_balai[$v['rujuk_rehab']];
										endif;
									?>
									</td>
								</tr>
								<tr>
									<td><strong>Tanggal Mulai</strong></td>
									<td>
										<?php
											if($v['tgl_mulai_rehab']):
												echo date("d-m-Y",strtotime($v['tgl_mulai_rehab']));
											else:
												echo "<span class='label label-info'>Belum Mulai</span>";
											endif;
										?>
									</td>
								</tr>
								<tr>
									<td><strong>Tanggal Selesai</strong></td>
									<td>
										<?php
											if($v['status_program_rehab']!=="MD" && $v['status_program_rehab']!=="DO"):
												if($v['tgl_selesai_rehab']):
													echo date("d-m-Y",strtotime($v['tgl_selesai_rehab']));
												else:
													echo "<span class='label label-info'>Belum Selesai</span>";
												endif;
											else:
												if($v['status_program_rehab']=="MD"):
													echo "Program Berhenti Karena Pasien Meninggal Dunia";	
												elseif($v['status_program_rehab']=="DO"):
													echo "Program Berhenti Karena Pasien Dinyatakan Drop Out";	
												endif;		
											endif;
										?>
									</td>
								</tr>
								
								<?php if($v['tgl_dt']): ?>
								<tr>
									<td><strong>Kegiatan Rawat Inap</strong></td>
									<td>
										<?php $arrInap	=	array("dt","eu","pt","re");?>
										
										<table class="table table-bordered table-condensed" style="width:100%">
											<thead>
												<tr>
													<th colspan="2"><p align="center">Detox</p></th>
													<th colspan="2"><p align="center">Entry Unit</p></th>
													<th colspan="2"><p align="center">Primary Treatment</p></th>
													<th colspan="2"><p align="center">Re Entry</p></th>
												</tr>
												<tr>
													<?php for($i=0; $i<4; $i++): ?>
													<th><p align="center">Tanggal Mulai</p></th>
													<th><p align="center">Tanggal Selesai</p></th>
													<?php endfor; ?>
												</tr>
											</thead>
											<tbody>
												<tr>
													<?php for($i=0; $i<4; $i++): ?>
													<?php
														$mulai	=	"tgl_".$arrInap[$i];
														$selesai=	"tgl_".$arrInap[$i]."_selesai";
													?>
													<td align="center">
														<?php
															if($v[$mulai]):
																echo date_format(date_create($v[$mulai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<?php endfor; ?>
												</tr>
											</tbody>
										</table>									
									</td>
								</tr>
								<?php elseif($v['tgl_kl']): ?>
								<tr>
									<td><strong>Kegiatan Rawat Jalan</strong></td>
									<td>
									
										<?php $arrRawat	=	array("kl","tk","ts");?>
							
										<table class="table table-bordered table-condensed" style="width:100%">
											<thead>
												<tr>
													<th colspan="2"><p align="center">Konseling</p></th>
													<th colspan="2"><p align="center">Terapi Kelompok</p></th>
													<th colspan="2"><p align="center">Terapi Simptomatik</p></th>
												</tr>
												<tr>
													<?php for($i=0; $i<3; $i++): ?>
													<th><p align="center">Tanggal Mulai</p></th>
													<th><p align="center">Tanggal Selesai</p></th>
													<?php endfor; ?>
												</tr>
											</thead>
											<tbody>
												<tr>
													<?php for($i=0; $i<3; $i++): ?>
													<?php
														$mulai	=	"tgl_".$arrRawat[$i];
														$selesai=	"tgl_".$arrRawat[$i]."_selesai";
													?>
													<td align="center">
														<?php
															if($v[$mulai]):
																echo date_format(date_create($v[$mulai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<?php endfor; ?>
												</tr>
											</tbody>
										</table>		
									
									</td>
								</tr>
								<?php endif; ?>
							</table>
						<?php endif; ?>
						<br />
						
						<?php if(($v['inst_pasca'] || $v['inst_lanjut']) && ($v['status_program_rehab']!=="MD" && $v['status_program_rehab']!=="DO")): ?>
							<?php
								if($v['status_program_pasca']=='SL'):
									$status_program_pasca	= "<span class='label label-success'>Selesai</span>";
								elseif($v['status_program_pasca']=="MD"):
									$status_program_pasca	= "<span class='label' style='background-color:#990099'>Meninggal Dunia</span>";	
								elseif($v['status_program_pasca']=="DO"):
									$status_program_pasca	= "<span class='label label-danger'>Drop Out</span>";
								endif;		
							?>
							<table class="table table-condensed">
								<tr>
									<td colspan="2"><h4 style="color:#0099FF" class="heading"><strong>Pasca Rehabilitasi</strong><div class="pull-right"><?=$status_program_pasca?></div></h4></td>
								</tr>
								<tr>
									<td width="200"><strong>Jenis Pasca</strong></td>
									<td>
										<?php
											if($v['tgl_da']):
												echo "Rawat Inap";
											elseif($v['tgl_pg']):
												echo "Rawat Jalan";
											else:
												echo "Rawat Lanjut";
											endif;
										?>
									</td>
								</tr>
								<tr>
									<td width="200"><strong>Tempat Rujukan</strong></td>
									<td>
									<?php 
										if($v['inst_pasca']=="BNNP"):
											echo $lookup_bnnp[$v['rujuk_pasca']];
										elseif($v['inst_pasca']=="BNNK"):
											echo $lookup_bnnk[$v['rujuk_pasca']];
										else:
											echo $lookup_balai[$v['rujuk_pasca']];
										endif;
									?>
									</td>
								</tr>
								<tr>
									<td><strong>Tanggal Mulai</strong></td>
									<td>
										<?php
											if($v['tgl_mulai_pasca']):
												echo date("d-m-Y",strtotime($v['tgl_mulai_pasca']));
											else:
												echo "<span class='label label-info'>Belum Mulai</span>";
											endif;
										?>
									</td>
								</tr>
								<tr>
									<td><strong>Tanggal Selesai</strong></td>
									<td>
										<?php
											if($v['status_program_pasca']!=="MD" && $v['status_program_pasca']!=="DO"):
												if($v['tgl_selesai_pasca']):
													echo date("d-m-Y",strtotime($v['tgl_selesai_pasca']));
												else:
													echo "<span class='label label-info'>Belum Selesai</span>";
												endif;
											else:
												if($v['status_program_pasca']=="MD"):
													echo "Program Berhenti Karena Pasien Meninggal Dunia";	
												elseif($v['status_program_pasca']=="DO"):
													echo "Program Berhenti Karena Pasien Dinyatakan Drop Out";	
												endif;		
											endif;
										?>
									</td>
								</tr>
								<?php if($v['tgl_da']): ?>
								<tr>
									<td><strong>Kegiatan Rawat Inap</strong></td>
									<td>
										
										<?php $arrInap	=	array("da","dr");?>
										<table class="table table-bordered table-condensed" style="width:100%">
											<thead>
												<tr>
													<th colspan="2"><p align="center">Daily Activity</p></th>
													<th colspan="2"><p align="center">Discharge/Rujukan</p></th>
												</tr>
												<tr>
													<?php for($i=0; $i<2; $i++): ?>
													<th><p align="center">Tanggal Mulai</p></th>
													<th><p align="center">Tanggal Selesai</p></th>
													<?php endfor; ?>
												</tr>
											</thead>
											<tbody>
												<tr>
													<?php for($i=0; $i<2; $i++): ?>
													<?php
														$mulai	=	"tgl_".$arrInap[$i];
														$selesai=	"tgl_".$arrInap[$i]."_selesai";
													?>
													<td align="center">
														<?php
															if($v[$mulai]):
																echo date_format(date_create($v[$mulai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<?php endfor; ?>
												</tr>
											</tbody>
										</table>	
									
									</td>
								</tr>
								
								<?php elseif($v['tgl_pg']): ?>
								
								<tr>
									<td><strong>Kegiatan Rawat Jalan</strong></td>
									<td>										
										<?php $arrRawat	=	array("pg","pd","dk");?>										
										<table class="table table-bordered table-condensed" style="width:100%">
											<thead>
												<tr>
													<th colspan="2"><p align="center">Peer Group</p></th>
													<th colspan="2"><p align="center">Perkembangan Diri</p></th>
													<th colspan="2"><p align="center">Dukungan Keluarga</p></th>
												</tr>
												<tr>
													<?php for($i=0; $i<3; $i++): ?>
													<th><p align="center">Tanggal Mulai</p></th>
													<th><p align="center">Tanggal Selesai</p></th>
													<?php endfor; ?>
												</tr>
											</thead>
											<tbody>
												<tr>
													<?php for($i=0; $i<3; $i++): ?>
													<?php
														$mulai	=	"tgl_".$arrRawat[$i];
														$selesai=	"tgl_".$arrRawat[$i]."_selesai";
													?>
													<td align="center">
														<?php
															if($v[$mulai]):
																echo date_format(date_create($v[$mulai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<?php endfor; ?>
												</tr>
											</tbody>
										</table>										
										
									</td>
								</tr>								
								<?php endif; ?>
								
								<?php if($v['inst_lanjut']): ?>
								<tr>
									<td><strong>Kegiatan Rawat Lanjut</strong></td>
									<td>									
										<?php $arrLanjut	=	array("pukp","puep","putu","pdhv","pdpk","pdkl","pdtu"); ?>
										<table class="table table-bordered table-condensed" style="width:100%">
											<thead>
												<tr>
													<th colspan="6"><p align="center">Pemantauan</p></th>
													<th colspan="8"><p align="center">Pendampingan</p></th>
													<th rowspan="3"><p align="center">Status Pulih</p></th>
												</tr>
												<tr>
													<th colspan="2"><p align="center">Kegiatan Produktif</p></th>
													<th colspan="2"><p align="center">Evaluasi Perkembangan</p></th>
													<th colspan="2"><p align="center">Tes Urin</p></th>
													<th colspan="2"><p align="center">Home Visit</p></th>
													<th colspan="2"><p align="center">Pertemuan Kelompok</p></th>
													<th colspan="2"><p align="center">Konseling</p></th>
													<th colspan="2"><p align="center">Tes Urin</p></th>
												</tr>
												<tr>
													<?php for($i=0; $i<7; $i++): ?>
													<th><p align="center">Mulai</p></th>
													<th><p align="center">Selesai</p></th>
													<?php endfor; ?>
												</tr>
											</thead>
											<tbody>
												<tr>
													<?php for($i=0; $i<7; $i++): ?>
													<?php
														$mulai	=	"tgl_".$arrLanjut[$i];
														$selesai=	"tgl_".$arrLanjut[$i]."_selesai";
													?>
													<td align="center">
														<?php
															if($v[$mulai]):
																echo date_format(date_create($v[$mulai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo "<i class='fa fa-minus red'></i>";
															endif;
														?>
													</td>
													<?php endfor; ?>
													<td>
													
													<?php
														if($v['outcome_pasien']=='PP'):
															echo "<span class='label label-primary'>Pulih Produktif</span>";
														elseif($v['outcome_pasien']=='PTP'):
															echo "<span class='label label-info'>Pulih Tidak Produktif</span>";
														elseif($v['outcome_pasien']=='TPP'):
															echo "<span class='label label-warning'>Tidak Pulih Produktif</span>";
														elseif($v['outcome_pasien']=='TPTP'):
															echo "<span class='label label-danger'>Tidak Pulih Tidak Produktif</span>";
														endif;		
													?>
													
													</td>
												</tr>
											</tbody>
										</table>									
									</td>
								</tr>
								<?php endif; ?>
							</table>				
						<?php endif; ?>
						<br />	
						
						<?php if(count($v['hasil_tes_urin'])>0): ?>
						<h4 class="heading">Hasil tes Urin</h4>
						<table class="table table-condensed table-bordered table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>Periode</th>
									<th>Tanggal Tes Urin</th>
									<th>Hasil Tes Urin</th>
									<th>Petugas Tes Urin</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($v['hasil_tes_urin'] as $ku=>$vu): ?>
								<tr>
									<td align="center"><?=$ku+1?></td>
									<td>Pertemuan Ke-<?=$vu['idx_tes']?></td>
									<td><?=date("d-m-Y",strtotime($vu['tgl_tes']))?></td>
									<td align="center">
									<?php
										if($vu['hasil_tes']==1):
											echo "<span class='label label-danger'><i class='fa fa-plus'></i></span>";
										elseif($vu['hasil_tes']==2):
											echo "<span class='label label-success'><i class='fa fa-minus'></i></span>";
										endif;	
									?>
									</td>
									<td><?=$vu['nama_petugas_tes']?></td>
									<td><?=$vu['keterangan']?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<div class="well well-sm" style="margin-top:15px;">
							***) Keterangan:<br />
							<span class='label label-danger'><i class='fa fa-plus'></i></span> Menunjukkan Hasil Tidak Baik<br />
							<span class='label label-success'><i class='fa fa-minus'></i></span> Menunjukkan Hasil Baik			
						</div>
						
						<?php endif; ?>
						
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
    </div>
</div>