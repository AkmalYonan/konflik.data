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
	
?>

<section class="content-header">
  <h1 class="hidden-xs">
    Tambah
    <small>Pasien Pengembangan Diri</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
	<li><a href="<?php echo $this->module?>pasien_list" class="active">Pilih Pasien</a></li>
  </ol>
</section>

<section class="content">
    <div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <!-- TOOLBAR -->
        	<div class="content-toolbar">
				<div class="row">
					<div class="col-sm-6">
						<a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="List">
							<i class="fa fa-list"></i>
						</a>
						<a class="btn btn-white active" href="<?php echo $this->module?>pasien_list" data-toggle='tooltip' data-original-title="Add">
							<i class="fa fa-plus"></i>
						</a>
						<a class="btn btn-white" href="<?php echo $this->module?>pasien_list" data-toggle='tooltip' data-original-title="Refresh">
							<i class="fa fa-refresh"></i>
						</a>
					</div><!--End Of Col 6-->
					
					<div class="col-sm-6">
						<div class="pull-right">
						<form class="form-inline" action="<?=$this->module?>pasien_list" method="get">
							<div class="form-group">
                            	<?php $this->load->view("widget/search_box_db"); ?>
                          	</div>
                          	<button type="submit" class="btn btn-primary">Search</button>
						</form>
						</div>
					</div>
				</div>
            </div>
            <!-- END: TOOLBAR -->
			
        	<div class="box box-widget">
            	<div class="box-header with-borders">
                <?php 
					/* 
					   ditaro diatas supaya tabel dapet offset dr pagination, 
					   digunakan untuk penomoran tabel 
					*/
					$page_link=$this->pagination->create_links(); 
					$offset=$this->pagination->cur_page>0?($this->pagination->cur_page-1) * $this->pagination->per_page:0;
				?>
				
                <div class="box-body table-responsive">
				
				<ul class="nav nav-tabs" style="margin-bottom:10px">
				  <li class="active"><a href="<?=$this->module?>pasien_list"><i class="fa fa-user">&nbsp;</i>Pilih Pasien (Step 1)</a></li>
				</ul>
				
                <table class="table table-bordered table-condensed small-font">
                    <thead>
                        <tr>
                            <th width="20px">No.</th>
							<th>Nama</th>
							<th>No. Rekam Medis</th>
							<th>Jenis Kelamin</th>
							<th>Alamat</th>
                            <th>Periode</th>
                            <th>Sumber Biaya/Wilayah</th>
                            <th>Sumber Pasien</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$val):
                                    $id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
									$add_link	=	$this->module."add/".$id;
                            ?>
                                <tr>
                                    <td align="center"><?php echo $offset+$x+1?></td>
									<td>
										<a href="<?=$add_link?>">
											<?php echo $val["nama"]?>
										</a>
									</td>
									<td><?php echo $val["no_rekam_medis"]?></td>
									<td><?php echo $this->data_lookup["jenis_kelamin"][$val["jenis_kelamin"]];?></td>
									<td><?php echo $val["alamat"]?></td>
                                    <td><?php echo strtoupper(GetBulan($val["periode_bulan"]))?>  <?php echo $val["periode_tahun"]?></td>
                                    <td>
									<?php
                                    	$kode_wilayah=substr($val["kd_wilayah"],2,2);
										if($kode_wilayah=='00'):
											$flag_propinsi=TRUE;
										else:
											$flag_propinsi=FALSE;
										endif;
									?>
                                    <?php echo $lookup_sumber_biaya[$val["sumber_biaya"]];?><br>
									<?php echo $lookup_wilayah[$val["kd_wilayah"]];?>
									<?php echo $flag_propinsi==FALSE?", ".$data_propinsi[$val["kd_wilayah_propinsi"]]:""?>
									</td>
                                    <td><?php echo $val["sumber_pasien"]?></td>
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