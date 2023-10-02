<?php
	$lookup_empty=array(""=>"--pilih--");
	$lookup_bnnp=lookup("m_org","kd_org","nama",false,"order by idx");
	$lookup_status_nikah=$this->data_lookup["status_kawin"];
	$lookup_balai=$lookup_empty+lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
	$lookup_jns_org=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org",false,"order by idx");
	$lookup_inst=lookup("m_instansi","kd_instansi","nama_instansi",false,"order by idx");
	$data_foto=pasien_foto($data["idx"]);		
	$foto=cek_array($data_foto)?$this->base_url.$data_foto["path"].$data_foto["file_name"]:$this->base_url."assets/images/pic.jpg";
	
?>



<section class="invoice">
<div class="content-toolbar">
	<div class="row">
                    <div class="col-md-12 col-xs-12">
                    &nbsp;
                    <form  class="form-inline hidden" action="<?=$this->module?>pasien_baru_per_klinik" method="get">
                     <input type="hidden" id="kd_org" name="kd_org" value="<?=$kd_org?>" />
                      <div class="form-group">
                        	<label for="tahun">Tahun</label>
                        	<select name="tahun" class="form-control">
                                    	<? for($i=date("Y");$i>=date("Y")-10;$i--){?>
                                        <? $selected="";
											if($tahun==$i):
												$selected="selected=selected";
											else:
												$selected="";
											endif;
											//pre($selected.$i);
											
										?>
                                        <option <?=($tahun==$i)?"selected":"";?> value="<?=$i?>"><?=$i?></option>
                                        <? }?>
                                    </select>
                      </div>
                      <div class="form-group">
                      	<label for="bulan">Bulan</label>
                      	 <?=form_dropdown("bulan",$bln,$bulan,
								"id='bulan' class='form-control required' 
								");?>
                      </div>
                      
                      <div class="form-group">
                        <label for="instansi">Instansi</label>
                         <?=form_dropdown("tipe_instansi",$lookup_instansi,$tipe_instansi,
								"id='tipe_instansi' class='form-control select2 required' 
								");?>
                      	</div>
                      <div class="form-group wilayah">
                      	  <label for="wilayah">Wilayah</label>	
                          <?=form_dropdown("",$lookup_wilayah,$kd_org,
								"id='kd_org_bnnp' class='form-control select2 required' 
								style='display:none;'");?>
                                
                                <?=form_dropdown("",$lookup_wilayah2,$kd_org,
								"id='kd_org_balai' class='form-control select2 required' 
								style='display:none;'");?>
                                
                                <?=form_dropdown("",$lookup_wilayahx,$kd_org,
								"id='kd_org_bnnk' class='form-control select2 required' 
								style='display:none;'");?>
                      </div>
                      <div class="form-group">
                      <button id="btn_search" type="submit" class="btn btn-white">Tampilkan</button>
                      <button type="reset" class="btn btn-white" data-toggle="tooltip" title="" data-original-title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                    	</div><!--end form group -->
                    </form>
                    <div class="pull-right">
                              <a href="#" class="print-pdf hidden" data-url=""><i class="fa fa-file-pdf-o"></i> PDF</a>
                              <div class="btn-group btn-group-sm pull-right">
                                  <a href="/print" class="btn btn-white div_id_print_modal" data-div_id="#print_this" data-page_orientation='L' data-page_size='A4' data-toggle='tooltip' data-original-title="Print Preview"><i class="fa fa-print"></i>&nbsp;Print Preview</a>
                         	 <a href="#" class="btn btn-white print-excel" data-url="" data-toggle='tooltip' data-original-title="Export to Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a>
                         	 </div>
  			 		  	</div><!-- end col -->
                    	<div class="clearfix"></div>
                 	</div><!-- emd col -->
			</div><!-- end row -->
            <div class="clearfix"></div>
  </div>
        <!-- END: TOOLBAR -->

<br>        
<div id="print_this">
<div class="row">
<div class="col-md-12">

	<style>
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #CCC;
    margin: 1em 0;
    padding: 0; 
}
</style>
<style>
	.fa{font-family:fontawesome !important;}
	.red{color:#DD5A43;}
	.green{color:#69AA46;}
	.tr{text-align:right;}
	.tc{text-align:center;}
	.tl{text-align:left;}
	.ttop{vertical-align:top;}
	/*.heading{background-color:#CCCCCC}*/
	.heading {
    	background-color:white;
    	border: medium none !important;
    	padding: 10px !important;
		padding-left:0px !important;
	}
	.heading {
		border-bottom: 1px solid #dcdcdc !important;
		color:#464646;
		font-weight: 600;
		margin-bottom: 15px;
		padding-bottom: 5px;
	}
</style>   
<? 
	$flag_yes="<i class='fa green'>&#xf00c;</i>";
	//$flag_no="<i class='fa red'>&#xf068;</i>";
	$flag_no="-";
	$flag_plus="<i class='fa red'>&#xf067;</i>";
	$flag_minus="<i class='fa green'>&#xf068;</i>";
?>	
       <table width="100%"><tr><td style="border-bottom:1px solid #dcdcdc;background-color:#f9f9f9;padding-left:4px;">
                <h4 style="color:#464646;background-color:#f9f9f9;"><strong>Pasien</strong></h4>
       </td></tr></table>
        <br>        
        <table width="100%">
        	<tr>
            	<td width="200px">
                	<img class="profile-user-img foto-pasien" style="width:130px; height:140px" src="<?=$foto?>" alt="Foto Pasien">
                </td>
                <td valign="top"  width="400px">
                	<table>
                            <tr>
                                <td width="150px"  class="ttop"><strong>Nama</strong></td>
                                <td><?=$data["nama"]?></td>
                            </tr>
                             <tr>
                                <td  class="ttop"><strong>NIK</strong></td>
                                <td><?=$data["nik"]?></td>
                            </tr>	
                            
                            <tr>
                                <td  class="ttop"><strong>Tempat,Tgl. Lahir</strong></td>
                                <td><?=$data["tempat_lahir"]?>, <?=date2indo($data["tgl_lahir"])?></td>
                            </tr>	
                            
                            <tr>
                                <td  class="ttop"><strong>L/P & Umur</strong></td>
                                <td><?=$this->data_lookup["jenis_kelamin"][$data["jenis_kelamin"]]?> (<?=$data["umur"]*1?> Tahun)</td>
                            </tr>	
                           <tr>
                                <td  class="ttop"><strong>Status Menikah</strong></td>
                                <td><?=$lookup_status_nikah[$data["status_nikah"]]?></td>
                            </tr>	
                            
                            
                            <tr>
                                <td  class="ttop"><strong>Golongan Darah</strong></td>
                                <td><?=$data["golongan_darah"]?></td>
                            </tr>	
                             <tr>
                                <td  class="ttop"><strong>Agama</strong></td>
                                <td><?=$data["agama"]?></td>
                                
                            </tr>	
                             <tr>
                                <td  class="ttop"><strong>Suku</strong></td>
                                <td><?=$data["suku"]?></td>
                                
                            </tr>
                      </table>
                </td>
                <td valign="top">
                	<table>
                    		<tr>
                                <td width="150px" class="ttop"><strong>No Rekam Medis</strong></td>
                                <td><?=$data["no_rekam_medis"]?></td>
                            </tr>
                            <tr>
                                <td  class="ttop"><strong>Pekerjaan</strong></td>
                                <td><?=$data["pekerjaan"]?></td>
                            </tr>
                            <tr>
                                <td  class="ttop"><strong>No Telepon</strong></td>
                                <td><?=$data["no_telp"]?></td>
                                
                            </tr>	
                            <tr>
                                <td  class="ttop"><strong>No HP</strong></td>
                                <td><?=$data["no_hp"]?></td>
                            </tr>	
                            <tr>
                                <td  class="ttop"><strong>Alamat Rumah</strong></td>
                                <td> <?=$data["alamat"]?> <br><?=$data["kode_pos"]?></td>
                            </tr>	
                            
                            <tr>
                                <td  class="ttop"><strong>Nama Ibu</strong></td>
                                <td> <?=$data["ibu"]?></td>
                                
                            </tr>	
                             <tr>
                                <td  class="ttop"><strong>Nama Ayah</strong></td>
                                <td> <?=$data["ayah"]?></td>
                            </tr>		
                        </table>
                   </td>
            </tr>
        </table>
        
       <br>
        
        
        
        	<?php foreach($history_rh as $k=>$v): ?>
            	<table width="100%"><tr><td style="border-bottom:1px solid #dcdcdc;background-color:#f9f9f9;padding-left:4px; ">
                <h4 style="color:#464646;background-color:#f9f9f9;"><strong>Riwayat Pasien ke-<?=($k+1)?></strong></h4>
                </td></tr></table>
                
                <div style="padding-left:20px">
                <h4 style="color:#464646;" class="heading"><strong>Assesment</strong></h4>
                <table style="width:100%">
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
								
									<table class="table table-bordered table-condensed small-font" width="100%">
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
												<td align="center"><?=$flag_yes;?></td>
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
												<td align="center"><?=$flag_yes;?></td>
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
												<td align="center"><?=$flag_yes;?></td>
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
												<td align="center"><?=$flag_yes;?></td>
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
												<td align="center"><?=$flag_yes;?></td>
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
												<td align="center"><?=$flag_yes;?></td>
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
                
                </div><!-- end padding div -->
                
                
                <!-- INSTANSI RUJUK -->
                <div style="padding-left:20px">
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
                            <h4  class="heading"><strong>Rehabilitasi</strong><div class="pull-right"><?=$status_program_rehab?></div></h4>
							<table style="width:100%">
								
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
									<td valign="top"><strong>Kegiatan Rawat Inap</strong></td>
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
													<th><p align="center"> Mulai</p></th>
													<th><p align="center">Selesai</p></th>
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
																echo $flag_no;
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo $flag_no;
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
									<td valign="top"><strong>Kegiatan Rawat Jalan</strong></td>
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
													<th><p align="center">Mulai</p></th>
													<th><p align="center">Selesai</p></th>
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
																echo $flag_no;
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo $flag_no;
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
							</table><!-- end div padding -->
						<?php endif; ?>
						<br />
                    </div><!-- end div padding -->   
                <!-- END INSTANSI RUJUK -->
                
                
                <!-- INSTANSI PASCA -->
                <div style="padding-left:20px">
               
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
                           <h4  class="heading"><strong>Pasca Rehabilitasi</strong><div class="pull-right"><?=$status_program_pasca?></div></h4>
							<table width="100%">
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
									<td valign="top"><strong>Kegiatan Rawat Inap</strong></td>
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
													<th><p align="center">Mulai</p></th>
													<th><p align="center">Selesai</p></th>
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
																echo $flag_no;
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo $flag_no;
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
									<td valign="top"><strong>Kegiatan Rawat Jalan</strong></td>
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
													<th><p align="center"> Mulai</p></th>
													<th><p align="center">Selesai</p></th>
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
																echo $flag_no;
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo $flag_no;
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
									<td valign="top"><strong>Kegiatan Rawat Lanjut</strong></td>
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
																echo $flag_no;
															endif;
														?>
													</td>
													<td align="center">
														<?php
															if($v[$selesai]):
																echo date_format(date_create($v[$selesai]),"d-m-Y");
															else:
																echo $flag_no;
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
                
                
                </div><!-- end div padding -->
                <!-- END INSTANSI PASCA-->
                
                
                
                <!-- HASIL TEST URIN -->
                <div style="padding-left:20px;">
                <?php if(count($v['hasil_tes_urin'])>0): ?>
						<h4 class="heading">Hasil Tes Urin</h4>
						<table style="width:100%">
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
											echo "<span class='label label-default'>".$flag_plus."</span>";
										elseif($vu['hasil_tes']==2):
											echo "<span class='label label-default'>".$flag_minus."</span>";
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
							<span class='label label-default'><?=$flag_plus;?></span> Menunjukkan Hasil Tidak Baik<br />
							<span class='label label-default'><?=$flag-minus;?></span> Menunjukkan Hasil Baik			
						</div>
						
						<?php endif; ?>
                        
                </div><!--end padding left-->                
                <!-- END HASIL TEST URIN -->
                
                
                
                
               <!-- <table width="100%">
				<tr>
            	<td style="padding-left:20px">-->
				
						
						
						
						
						
						
						
					<!--</div>-->
				<!--</div>
			</div>-->
            <!-- </td>
         </tr>
          </table>-->
			<?php endforeach; ?>
		
       
       
       
        <hr>
        
        </div>
         </div><!-- end row-->
        
        </div>
        
    </section>