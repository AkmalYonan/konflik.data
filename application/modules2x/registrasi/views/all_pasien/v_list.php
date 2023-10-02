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
	
	$lookup_status_program['MD']="MENINGGAL DUNIA";
	$lookup_status_program['KB']="KAMBUH";
	$lookup_status_program['DO']="DROP OUT";//<span class='label label-warning'>Registrasi</span>";
	$lookup_status_program['SLPP']="Selesai (Outcome: Pulih Produktif)";
	$lookup_status_program['SLTPP']="Selesai (Outcome: Tidak Pulih Produktif)";
	$lookup_status_program['SLPTP']="Selesai (Outcome: Pulih Tidak Produktif)";
	$lookup_status_program['SLTPTP']="Selesai (Outcome: Tidak Pulih Tidak Produktif)";

	$lookup_status_rehab[1]="";//<span class='label label-warning'>Registrasi</span>";
	$lookup_status_rehab[2]="<span class='label bg-purple'>Rehabilitasi</span>";
	$lookup_status_rehab[3]="<span class='label label-warning'>Pasca Rehabilitasi</span>";
	
	$lookup_bnnp2=$lookup_empty+lookup("m_org","kd_wilayah","nama","tipe_org='BNNP'","order by idx");
	$lookup_balai=$lookup_empty+lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
	/*
	$bnnpk=lookup("m_org","kd_org","nama","active=1","order by idx");
	$balai=lookup("m_instansi","kd_instansi","nama_instansi","jenis_tempat_rehab in ('BB','BLK','RD','KM')","order by idx");	
	if(cek_array($bnnpk)):
		foreach($bnnpk as $x=>$val):
			$nama=str_replace("BNN PROPINSI","BNNP",$val);
			$nama=str_replace("BNN KABUPATEN","BNNK",$nama);
			$nama=str_replace("BNN KOTA","BNNK KOTA",$nama);
			$bnnpk[$x]=$nama;
		endforeach;
	endif;
	if(cek_array($balai)):
		foreach($balai as $x=>$val):
			$nama=str_replace("REHABILITASI","REHAB.",strtoupper($val));
			$bnnpk[$x]=$nama;
		endforeach;
	endif;
	*/
	$map_all_org=map_all_org();
	
	
	
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");

	$lookup_rehab_ke=$this->conn->GetAssoc("SELECT idx_pasien,count(idx_pasien) jml FROM `t_pasien_assesment_history` group by idx_pasien");

	$arrDataProses=$this->conn->GetAll("select * from m_proses_rehab");
	
	if(cek_array($arrDataProses)):
		foreach($arrDataProses as $x=>$val):
			$label="";
			if($val["kd_status_proses"]=='RG'):
				$label="<span class='label label-default'>".$val["ur_proses"]."</span>";
			endif;
			if($val["kd_status_proses"]=='SS'):
				$label="<span class='label label-default'>".$val["ur_proses"]."</span>";
			endif;
			if($val["kd_status_rehab"]==2):
				$label="<span class='label label-default'>".$val["ur_proses"]."</span>";
			endif;
			if($val["kd_status_rehab"]==3):
				$label="<span class='label label-default'>".$val["ur_proses"]."</span>";
			endif;
			$lookup_status_proses[trim($val["kd_status_proses"])]=$label;
		endforeach;
	endif;
	//pre($lookup_status_proses);
	
	$lookup_active[""]="Semua";
	$lookup_active[0]="Tidak Aktif";
	$lookup_active[1]="Aktif";
	
	$lookup_rehab[""]="Semua";
	$lookup_rehab[1]="Registrasi";
	$lookup_rehab[2]="Rehab";
	$lookup_rehab[3]="Pasca";
	
	
	
	$req=get_post();
	
	$active=$req["active"]!=""?$req["active"]:"";
	$status_rehab=$req["status_rehab"]?$req["status_rehab"]:"";
	
?>
<section class="content-header">
  <h1 class="hidden-xs">
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-user-circle"></i> <?=$this->parent_module_title?></li>
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
                    
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>&nbsp;&nbsp;
                    <a class="btn btn-white" href="registrasi/offline" data-toggle='tooltip' data-original-title="Add">
                        <i class="fa fa-user-plus"></i> Registrasi Pasien
                    </a>	  
            </div>
            <!-- END: TOOLBAR -->
        	<div class="box box-widget">
            	<div class="box-header with-borders">
                	<div class="row">
                        <div class="col-md-8 col-xs-12">
                        <form class="form-inline" action="<?=$this->module?>index/<?=$kategori?>" method="get">
                          <div class="form-group">
                            <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                          </div>
                          <div class="form-group">
                            <?php $this->load->view("widget/search_box_db"); ?>
                          </div>
                          
                          <div class="form-group">
                          	<label for="bulan">Active</label>
                      	 	<?=form_dropdown("active",$lookup_active,$active,
								"id='active' class='form-control required' 
								");?>
                          </div>
                          <div class="form-group">
                          	<label for="bulan">Status</label>
                      	 	<?=form_dropdown("status_rehab",$lookup_rehab,$status_rehab,
								"id='status_rehab' class='form-control required' 
								");?>
                          </div>
                         <!-- <div class="form-group">
                            <label for="exampleInputEmail2">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
                          </div>-->
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
                            <th width="20" rowspan="2">No.</th>
                            <!--<th>Periode</th>
							
                            <th>Sumber Biaya</th>
                           	<th>BNNP/BALAI</th>
							-->
                            <th rowspan="2">Identitas Pasien</th>
                             <th colspan="5" bgcolor="#dddddd">PROGRAM REHABILITASI</th>
                             <!--<th>Status Rehab</th>-->
                            <th rowspan="2"></th>
                        </tr>
                        <tr>
                          <th bgcolor="#eeeeee">Status </th>
                          <th bgcolor="#eeeeee" style="white-space:nowrap">Sumber Pasien</th>
                            
                          <!--<th>Periode</th>
							
                            <th>Sumber Biaya</th>
                           	<th>BNNP/BALAI</th>
							-->
                            <!--<th>Status Rehab</th>-->
                             <th bgcolor="#eeeeee" width="250px">Proses</th>
                             <th bgcolor="#eeeeee">Tempat</th>
                             <th bgcolor="#eeeeee">Entry</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$val):
                                    $id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];

									$jml_rehab = $lookup_rehab_ke[$val[$this->tbl_idx]]?$lookup_rehab_ke[$val[$this->tbl_idx]]." kali":"Belum Pernah";
									$active_pasien = "Tidak aktif";
									$sumber_pasien = "";
									$status_rehab = "";
									$status_proses = "";
									$entry = ""; 
									$stt_rehab ="";
									
									if ($val['status_program']=='DO') {
										$outcome_program = $lookup_status_program['DO'];
									}
									else if ($val['status_program']=='SL') {
										$outcome_program = $lookup_status_program['SL'.$val['outcome_pasien']];
									}else if($val['status_program']=='MD'){
										$outcome_program = $lookup_status_program['MD'];
									}else if($val['status_program']=='KB'){
										$outcome_program = $lookup_status_program['KB'];
									}
									$story = $lookup_rehab_ke[$val[$this->tbl_idx]]?"Pernah melakukan proses rehabilitasi sebanyak ".$jml_rehab.", dengan status terakhir ".$outcome_program:"";
                            		if ($val['active_pasien']) {
										$active_pasien = "Aktif";
										$sumber_pasien = $val["sumber_pasien"];
										$status_rehab = $lookup_status_rehab[$val["status_rehab"]];
										$status_proses = $lookup_status_proses[$val["status_proses"]];
										$entry = $val["created"]."<br>".$val["creator"]; 
										$stt_rehab = ($lookup_rehab_ke[$val[$this->tbl_idx]])?" (Proses berjalan)":"";
										$story="";
									}
							?>
                                <tr>
                                    <td><?php echo $offset+$x+1?>.</td>
                                    <!--<td><?php echo strtoupper(GetBulan($val["periode_bulan"]))?>  <?php echo $val["periode_tahun"]?></td>
									
                                    <td>
									<?php
                                    	$kode_wilayah=substr($val["kd_wilayah"],2,2);
										if($kode_wilayah=='00'):
											$flag_propinsi=TRUE;
										else:
											$flag_propinsi=FALSE;
										endif;
									?>
                                    <?php echo $lookup_sumber_biaya[$val["sumber_biaya"]];?>
									</td>
									<td>
									<?php 
										if($val['jns_org']==1):
											echo $lookup_bnnp2[$val["kd_bnn"]];
										else:
											echo $lookup_balai[$val["kd_bnn"]];
										endif;
									?>
									</td>
                                    -->
                                    <td width="400" style="padding:0">
                                    	<table class=" table-condensed table" style="margin-bottom:0;border:0px">
                                        	<tr><td width="160px">Nama</td><td><strong><?php echo $val["nama"]?></strong></td></tr>
                                            <tr><td>Jenis Kelamin</td><td><?php echo $this->data_lookup["jenis_kelamin"][$val["jenis_kelamin"]];?></td></tr>
											<tr><td>NIK</td><td><?php echo $val["nik"]?></td></tr>
                                            <tr><td>No Rekam Medis</td><td><?php echo $val["no_rekam_medis"]?></td></tr>
                                            <tr><td>Jml. Rehabilitasi</td><td><?php echo $jml_rehab?><?php echo $stt_rehab?></td></tr>
                                            <tr><td>Alamat</td><td><?php echo $val["alamat"]?></td></tr>
                                            
                                        </table>
									</td>
                                    <td><?php echo $active_pasien?></td>
                                    <td><?php echo $sumber_pasien?></td>
                                    
                                    
                                    <td>
										<?php echo $status_rehab?>
										<?php echo $status_proses?>
                                        <?php echo $story?>
                                        
                                    </td>
                                    <td style="padding:0px">
                                    	<table class="table table-condensed table-bordered" style="margin-bottom:0;border:0px">
                                        <tr><td width="100px">1. Registrasi</td><td> <?=$map_all_org[$val["kd_bnn"]]?></td></tr>
                                        <tr><td>2. Rehabilitasi</td><td><?=$map_all_org[$val["rujuk_rehab"]]?$map_all_org[$val["rujuk_rehab"]]:"-"?></td></tr>
                                        <tr><td>3. Pasca</td><td><?=$map_all_org[$val["rujuk_pasca"]]?$map_all_org[$val["rujuk_pasca"]]:"-"?></td></tr>
                                        <tr><td>4. Pasca Lanjut</td><td><?=$map_all_org[$val["rujuk_lanjut"]]?$map_all_org[$val["rujuk_lanjut"]]:"-"?></td></tr>
                                        </table>
                                    </td>
									<th><?php echo $entry?></th>           
                                     <td align="center" >
                                     	<div class="btn-group btn-group-xs">
                                        <a class="btn btn-xs btn-default" href="<?=$this->module?>view/<?=$id?>" data-toggle='tooltip' title="View"><i class="fa fa-search blue"></i></a> 
                                        <a class="btn btn-xs btn-default hidden" href="<?=$this->module?>edit/<?=$id?>" data-toggle='tooltip' title="Edit"><i class="fa fa-pencil green"></i></a> 
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
		$("#active").change(function(){
			var val=$(this).find(":selected").val();
			if(val==""){
				get_query();
			}
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
			// if(pp<0){
				// location=document.URL.split("?")[0];
				// return false;
			// }
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