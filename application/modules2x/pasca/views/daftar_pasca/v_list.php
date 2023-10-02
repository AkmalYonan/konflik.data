<style>
.table .table-preview img {
  width: 50px;
  height:50px;
  margin-right: 10px;
  margin-top:2px;
  float: left;
}
.table .identitas{
	float:left;
}
.table .table-preview .name {
  font-weight: bold;
  margin-top: 5px;
  display: block;
}
</style>
<?php
	$lookup_jenis_instansi=lookup("m_jenis_instansi","kd_jenis_instansi","ur_jenis_instansi","","order by order_num");
	$lookup_sumber_biaya=lookup("m_sumber_biaya","kd_sumber","ur_sumber","","order by order_num");
	$data_propinsi=lookup("m_propinsi2","kode_bps","nama");
	foreach($data_propinsi as $x=>$val):
		$data_propinsi[$x]=strtoupper($val);
	endforeach;
	$lookup_empty[""]="";
	$lookup_wilayah=$lookup_empty+lookup("m_kabupaten_kota","kode_bps","nama","","order by kode_bps");
	$lookup_status_rehab[1]="<span class='label label-warning'>Registrasi</label>";
	$lookup_status_rehab[2]="<span class='label label-info'>Rehabilitasi</label>";
	$lookup_status_rehab[3]="<span class='label label-primary'>Pasca</label>";
	$lookup_status=lookup("m_proses_rehab","kd_status_proses","ur_proses","kd_status_rehab='3'","order by order_num");
	$arr_proses_status	=	array("PRAP","PRRIDA","PRRIDR","PRRJPG","PRRIPD","PRRIDK","PRRLPUKP","PRRLPUEP","PRRLPUTU","PRRLPDHV","PRRLPDPK","PRRLPDTU","PRRLPDKN");
	$arr_link_proses	=	array("pasca_rehab","daily_act","discharge","peer_group","pengembangan_diri","dukungan_keluarga","produktif","evaluasi","pemantauan_urin","home_visit","pertemuan_kelompok","pendampingan_urin","konseling");
	$map_all_org=$lookup_bnnp+$lookup_inst;
	
	$pilih[""]="--Instansi--";
	$lookup_instansi_rujuk=lookup("m_tipe_org","kd_tipe_org","ur_tipe_org","kd_tipe_org in ('BNNP','BNNK','BL','RD','KM')","order by idx,order_num");
	$lookup_instansi_rujuk=$pilih+$lookup_instansi_rujuk;
	
	$empty1[""]="Semua BNNP";
	$empty2[""]="Semua BNNK";
	$empty3[""]="Semua Balai/Loka";
	$empty4[""]="Semua Komponen Masyarakat";
	$empty5[""]="Semua Rumah Damping";
	$lookup_wilayah=lookup("m_org","kd_org","nama","(tipe_org='BNNP') and active=1","order by kd_wilayah");
	$lookup_wilayah=$empty1+$lookup_wilayah;
	$lookup_wilayahx=lookup("m_org","kd_org","nama","(tipe_org='BNNK') and active=1","order by kd_wilayah");
	$lookup_wilayahx=$empty2+$lookup_wilayahx;
	$lookup_wilayah2=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK') and active=1","order by id_kabupaten");
	$lookup_wilayah2=$empty3+$lookup_wilayah2;
	$lookup_wilayah3=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='KM') and active=1","order by idx");
	$lookup_wilayah3=$empty4+$lookup_wilayah3;
	$lookup_wilayah4=lookup("m_instansi","kd_instansi","nama_instansi","(jenis_tempat_rehab='RD') and active=1","order by idx");
	$lookup_wilayah4=$empty5+$lookup_wilayah4;
?>
<section class="content-header">
  <h1 class="hidden-xs">
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="pasca/daftar_pasca"><i class="fa fa-child"></i> <?=$this->parent_module_title?></a></li>
    <li><a href="<?php echo $this->module?>" class="active"><?=$this->module_title?></a></li>
  </ol>
</section>

<section class="content">
    <div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <!-- TOOLBAR -->
        	<div class="content-toolbar">
                	<a class="btn btn-white active" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <!--<a class="btn btn-white" href="<?php echo $this->module?>add" data-toggle='tooltip' data-original-title="Add">
                        <i class="fa fa-plus"></i>
                    </a>	-->  
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
            </div>
            <!-- END: TOOLBAR -->
        	<div class="box box-widget">
            	<div class="box-header with-borders">
                	<div class="row">
                        <div class="col-md-8 col-xs-12">
                        <form class="form-inline" action="<?=$this->module?>" method="get">
                          <div class="form-group">
                            <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                          </div>
                          <div class="form-group ">
                            <?php $this->load->view("widget/search_box_db"); ?>
                          </div>
						  <div class="form-group instansi_rujuk" >
							  <?=form_dropdown("instansi",$lookup_instansi_rujuk,$instansi,"id='inst_rujuk' class='form-control select2 required' style='width:100%'");?>	
						  </div>
                          <div class="form-group bnnp">
                            <?=form_dropdown("kd_wilayah",$lookup_wilayah,$kode,"id='bnnp' class='form-control select2 required' style='width:100%'");?>
						  </div>
						   <div class="form-group bnnk">
                            <?=form_dropdown("kd_wilayah",$lookup_wilayahx,$kode,"id='bnnk' class='form-control select2 required' style='width:100%'");?>
						  </div>
						   <div class="form-group balailoka">
                            <?=form_dropdown("id_kabupaten",$lookup_wilayah2,$kode,"id='balailoka' class='form-control select2 required' style='width:100%'");?>
						  </div>
						  <div class="form-group km">
                            <?=form_dropdown("id_km",$lookup_wilayah3,$kode,"id='km' class='form-control select2 required' style='width:100%'");?>
						  </div>
						  <div class="form-group rd">
                            <?=form_dropdown("id_rd",$lookup_wilayah4,$kode,"id='rd' class='form-control select2 required' style='width:100%'");?>
						  </div>
						  
                          <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                        </div>
                        <div class="col-md-4 hidden-xs">
                            <div class="btn-group pull-right hidden">
                            	<a class="btn btn-transparent" href=""> <i class="fa fa-question"></i> Help</a>
                            </div>
                            <div class="btn-group pull-right hidden">
                              <button type="button" class="btn btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-share"></i>&nbsp; Export Data <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                              </ul>
                              
                            </div>
                        </div>
                    </div>
                </div>
            	<!--box body-->
                <?php 
					/* 
					   ditaro diatas supaya tabel dapet offset dr pagination, 
					   digunakan untuk penomoran tabel 
					*/
					$page_link=$this->pagination->create_links(); 
					$offset=$this->pagination->cur_page>0?($this->pagination->cur_page-1) * $this->pagination->per_page:0;
				?>
				
                <div class="box-body table-responsive">
                <table class="table table-bordered table-condensed small-font">
                    <thead>
                        <tr>
                            <th width="20px">No.</th>
                            <th>Nama</th>
							<th>Tempat Rujuk</th>
                            <th>No Rekam Medis</th>
                            <th>Jenis Kelamin</th>
							<th>Sisa Waktu Treatment</th>
                            <th>Status</th>
                            <th>Proses</th>
                            <th style="width:70px;"></th>
                        </tr>
                    </thead>
                    <tbody>
						<?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$val):
									//$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
									$id=$this->encrypt_status==TRUE?encrypt($val['idx_pasien']):$val['idx_pasien'];
									
									if($val['jns_treat']=='pt1'):
										$lama_proses=120;	
									elseif($val['jns_treat']=='pt2'):
										$lama_proses=180;	
									endif;
									$tgl_kedatangan=$val['tgl_selesai_assesment'];
									//$tgl_kedatangan=$val['tgl_kedatangan'];
									$date1 = new DateTime(null,new DateTimeZone('Asia/Jakarta'));
									$date2 = strtotime("$tgl_kedatangan + $lama_proses days");
									$date3=date('Y-m-d', $date2);
									$date4=new DateTime($date3) ;
									$str_date_skrg=$date1->format('Y-m-d');
									$str_date_akhir=$date4->format('Y-m-d');
									$sisa_waktu=(rentang_waktu($str_date_akhir,$str_date_skrg) <= 0 ? '<b style="color:red;">Habis</b>' : rentang_waktu($str_date_akhir,$str_date_skrg)."&nbsp; Hari");	
                            
                            ?>
                                <tr>
                                    <td><?php echo $offset+$x+1?>.</td>
                                    <td><?php echo $val["nama"];?></td>
									<td>
										<?
											$instansi=$val["inst_rujuk"]?$val["inst_rujuk"]:"";
											$instansi=$val["inst_pasca"]?$val["inst_pasca"]:$instansi;
											$instansi=$val["inst_lanjut"]?$val["inst_lanjut"]:$instansi;
											
											$kd_org=$val["rujuk_rehab"]?$val["rujuk_rehab"]:"";
											$kd_org=$val["rujuk_pasca"]?$val["rujuk_pasca"]:$kd_org;
											$kd_org=$val["rujuk_lanjut"]?$val["rujuk_lanjut"]:$kd_org;
											$org=$map_all_org[$kd_org];
										?>
                                        <?=$lookup_jns_org[$instansi];?><br>
                                        <?=$org?>
										
										
									</td>
                                    <td><?php echo $val["no_rekam_medis"];?></td>
                                    <td><?php echo $this->data_lookup["jenis_kelamin"][$val["jenis_kelamin"]];?></td>
									<td width='145' align="right"><?php echo $sisa_waktu;?></td>
									<td align="center"><?php echo ($val['status_rehab']==3)?"<span class='label label-warning'>Pasca Rehabilitasi</span>":"" ?></td>
									<td align="center">
										<?php if($lookup_status[$val['status_proses']]): ?>
											<?php foreach($arr_proses_status as $k=>$v): ?>
												<?php if($v==$val['status_proses']): ?>
													<a href="pasca/<?=$arr_link_proses[$k]?>" data-toggle='tooltip' title="Lihat List <?=$lookup_status[$val['status_proses']]?>">
														<span class="label label-info"><?=$lookup_status[$val['status_proses']]?></span>
													</a>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php else: ?>
											<span class="label label-danger">Diluar Proses Pasca Rehabilitasi</span>
										<?php endif; ?>
									</td>
                                    <td align="center">
                                     	<div class="btn-group btn-group-xs">										
                                        	<a class="btn btn-xs btn-default" href="<?=$this->module?>view/<?=$id?>" data-toggle='tooltip' title="View"><i class="fa fa-search blue"></i></a> 
											<?php foreach($arr_proses_status as $k=>$v): ?>
												<?php if($v==$val['status_proses']): ?>
													<a class="btn btn-xs btn-default" href="pasca/<?=$arr_link_proses[$k]?>/view/<?=$id?>" data-toggle='tooltip' title="Ubah Data <?=$val['nama']?>"><i class="fa fa-pencil green"></i></a>
												<?php endif; ?>
											<?php endforeach; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
                </div>
                <!--end: box body-->
                <div class="box-footer clearfix">
                    <div class="row">
                        <div class="col-md-8 col-xs-12">
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
                                5=>5,
                                10=>10,
                                25=>25,
                                50=>50,
                                -1=>"All"
                            );
                            $pp=$perPage;
                        ?>
                        Rows/page: <label><?=form_dropdown("pp_select",$arrPerPageSelect,$pp,"id='pp_select' class='form-control input-sm'")?></label>
                        <input type="hidden" id="pp" name="pp" value="" />
                            
                             </div>
                        </div><!-- end span 6-->
                        <div class="col-md-4 col-xs-12">
            
                                <?php echo $page_link; ?>
            
                        </div><!-- end span 6-->
                    </div>
                    <!-- end class well -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(function(){
	var non = $('#inst_rujuk :selected').val();
		//$("select").select2();
		if(non==''){
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
	
	$("div.instansi_rujuk").on("change","#inst_rujuk",function(){
		if($('#inst_rujuk :selected').val() == 'BL') {
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
		} else if($('#inst_rujuk :selected').val() == 'BNNP'){
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
		} else if($('#inst_rujuk :selected').val() == 'BNNK'){
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

		} else if($('#inst_rujuk :selected').val() == 'KM'){//JALAN=BALAI/LOKA
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
		} else if($('#inst_rujuk :selected').val() == 'RD'){
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