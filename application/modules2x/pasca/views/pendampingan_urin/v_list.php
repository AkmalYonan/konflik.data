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
                    <a class="btn btn-white hidden" href="<?php echo $this->module?>pasien_list" data-toggle='tooltip' data-original-title="Add">
                        <i class="fa fa-plus"></i>
                    </a>
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
                          <div class="form-group">
                            <?php $this->load->view("widget/search_box_db"); ?>
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
                <div class="box-body table-responsivex">
                <table class="table table-bordered table-condensed small-font">
                    <thead>
                        <tr>
                            <th width="25px" rowspan="2">No.</th>
                            <th rowspan="2">Nama</th>
							<th rowspan="2">Lokasi Pasca/Lanjut</th>
                            <th rowspan="2">No Rekam Medis</th>
                            <th rowspan="2">Jenis Kelamin</th>
							<th colspan="2">Tes Urin Ke-1</th>
							<th colspan="2">Tes Urin Ke-2</th>
							<th colspan="2">Tes Urin Ke-3</th>
							<th colspan="2">Tes Urin Ke-4</th>
							<th rowspan="2">Lampiran</th>
							<th rowspan="2">Nama Petugas Pemantau</th>
                            <th rowspan="2" style="width:100px;"></th>
                        </tr>
						<tr>
							<th>Tanggal</th>
							<th>Hasil</th>
							<th>Tanggal</th>
							<th>Hasil</th>
							<th>Tanggal</th>
							<th>Hasil</th>
							<th>Tanggal</th>
							<th>Hasil</th>
						</tr>
                    </thead>
                    <tbody>
                        <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$val):
							
                                    $id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
                            ?>
							<!--Tanggal Kegiatan-->
							<?php
								for($i=1; $i<5; $i++):
									if($val['tes'.$i]['tgl_tes']):
										$tes[$i]	=	date_format(date_create($val['tes'.$i]['tgl_tes']),"d-m-Y");
									else:
										$tes[$i]	=	"<center>-</center>";
									endif;
								endfor;
							?>
							<!--End-->
                                <tr>
                                    <td align="center"><?php echo $offset+$x+1?>.</td>
                                    <td><?php echo $val["nama"];?></td>
									<td><?=$lookup_jns_org[($val['inst_lanjut'])? $val['inst_lanjut']:$val['inst_pasca']]?><br />
										<? if(($val['inst_lanjut']=='BNNP') || ($val['inst_lanjut']=='BNNK') || ($val['inst_pasca']=='BNNP') || ($val['inst_pasca']=='BNNK')){?>
											<?=$lookup_bnnp[($val["rujuk_lanjut"])? $val["rujuk_lanjut"]:$val["rujuk_pasca"]]?>
										<? }else{?>
											<?=$lookup_inst[($val["rujuk_lanjut"])? $val["rujuk_lanjut"]:$val["rujuk_pasca"]]?>
										<? }?>
									</td>
                                    <td><?php echo $val["no_rekam_medis"];?></td>
                                    <td><?php echo $this->data_lookup["jenis_kelamin"][$val["jenis_kelamin"]];?></td>
									<?php for($i=1; $i<5; $i++): ?>
									<td><?php echo $tes[$i]; ?></td>
									<td align="center">
										<?php if($val['tes'.$i]['hasil_tes']==1): ?>
											<span class="label label-danger"><i class="fa fa-plus"></i></span>
										<?php elseif($val['tes'.$i]['hasil_tes']==2): ?>
											<span class="label label-success"><i class="fa fa-minus"></i></span>
										<?php else: ?>
											-
										<?php endif; ?>
									</td>
									<?php endfor; ?>
									<td align="center">
										<?php if($val['file']): ?>
											<a href="<?=$this->config->item("dir_pendampingan_urin").$val['file']?>" target="_blank">
												<span class='label label-info'><i class="fa fa-file">&nbsp;</i>Lampiran</span>
											</a>
										<?php else: ?>
											-
										<?php endif; ?>
									</td>
                                    <td><?php echo $val["nama_petugas_tes"]?></td>
                                    <td align="center">
                                    	<div class="btn-group btn-group-xs">
                                        	<a class="btn btn-xs btn-default" href="<?=$this->module?>view_detail/<?=$id?>" data-toggle='tooltip' title="Detail"><i class="fa fa-search blue"></i></a>
											<a class="btn btn-xs btn-default" href="<?=$this->module?>edit/<?=$id?>" data-toggle='tooltip' title="Edit"><i class="fa fa-pencil green"></i></a>  
											<!--
											<a class="btn btn-xs btn-default hidden" onclick="return confirm('Apakah Anda Akan Menghapus Data Ini?')" href="<?=$this->module?>del/<?=$id?>" data-toggle='tooltip' title="Delete"><i class="fa fa-remove red"></i></a> 
											-->
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