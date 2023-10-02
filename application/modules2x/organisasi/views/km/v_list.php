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
	$lookup_propinsi=lookup("m_provinsi","kodeProp","namaProvinsi","","order by idx");
	$lookup_bnnp=lookup("m_org","kd_org","nama","tipe_org='BNNP'","order by idx");
	$lookup_bantuan_modal=lookup("m_bantuan_modal","idx","ur_bantuan","","order by order_num");
?>
<section class="content-header">
  <h1 class="hidden-xs">
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
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
                    <a class="btn btn-white" href="<?php echo $this->module?>add" data-toggle='tooltip' data-original-title="Add">
                        <i class="fa fa-plus"></i>
                    </a>	  
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                       <a class="pull-right btn btn-white" href="<?php echo $this->module?>peta" data-toggle='tooltip' data-original-title="Peta">
                        <i class="fa fa-globe green"></i>
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
                          <!--<div class="form-group">
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
                            <th width="20px">No.</th>
							<th>Propinsi</th>
                            <th>Nama Lembaga</th>
                            <th>Alamat</th>
							<!--<th>Kota</th>-->
							<th>Telepon</th>
							<th>Email</th>
							<th>Contact Person</th>
							<th width="200px;">Layanan</th>
							<th>Tahun Operasi</th>
							<th>Ijin Operasional</th>
							<th>Akta Notaris</th>
							<!--
							<th>NPWP</th>
							<th>Nomor Rekening</th>
							<th>Wilayah Kerja BNNP</th>
                            <th>IPWL</th>
							<th>Kerjasama</th>
							-->
							<th>Sumber Dana</th>
                            <th width="20px" >Active</th>
                            <th style="width:100px;"></th>
                        </tr>
                    </thead>
                    <tbody>
						
                        <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$value):
                                    $id=$this->encrypt_status==TRUE?encrypt($value[$this->tbl_idx]):$value[$this->tbl_idx];
                            ?>
                                <tr>
                                    <td><?php echo $offset+$x+1?>.</td>
                                    <td><?php echo $lookup_propinsi[$value["id_propinsi"]]?></td>
									<td><?php echo $value["nama_instansi"]?></td>
                                    <td><?php echo $value["alamat"]?></td>
									<!--
									<td><?//php echo $value["id_kabupaten"]?></td>
									-->
									<td><?php echo $value["no_telp"]?></td>
									<td><?php echo $value["email"]?></td>
									<td><?php echo $value["cp"]?></td>
									<td>
										<?php
											$layanan	=	"";
											$br			=	"";
											if($value['rawat_jalan']):
												$layanan	.=	$br." Rawat Jalan";
												$br			=	",";
											endif;
											
											if($value['rawat_inap']):
												$layanan	.=	$br." Rawat Inap";
												$br			=	",";
											endif;
											
											if($value['rawat_pasca']):
												$layanan	.=	$br." Rawat Pasca";
												$br			=	",";
											endif;
										?>
										
										<?=($layanan);?>
									</td>
									<td><?php echo $value["tahun_operasi"]?></td>
									<td><?php echo $value["no_surat_ijin"]?></td>
									<td><?php echo $value["akte_notaris"]?></td>
									<!--
									<td><?php echo $value["npwp"]?></td>
									<td><?php echo $value["no_rekening"]?></td>
									<td><?php echo $lookup_bnnp[$value["kd_bnn"]]?></td>
									<td><?php echo $value["ipwl"]?></td>
									<td><?php echo $value["kerjasama"]?></td>
									-->
									<td><?php echo $lookup_bantuan_modal[$value["bantuan_modal"]]?></td>
                                    <td style="text-align:center">
                                    	<? if($value["active"]==1):?>
                              				<a class="" href="<?=$this->module?>activate/<?=$id?>" data-toggle='tooltip' title="Deactivate"><i class="fa fa-check"></i></a> 
                                          <? else:?>
                                            <a class="" href="<?=$this->module?>activate/<?=$id?>" data-toggle='tooltip' title="Activate"><i class="fa fa-close"></i></a> 
                                           <? endif;?> 
                                           
                          </td>
                                     <td align="center">
                                        <a class="btn btn-xs btn-success" href="<?=$this->module?>edit/<?=$id?>" data-toggle='tooltip' title="Edit"><i class="fa fa-pencil"></i></a> 
                                        <a class="btn btn-xs btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini?');" data-toggle='tooltip' href="<?php echo $this->module."del/".$id?>" title="Delete"><i class="fa fa-remove"></i></a> 
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

<? //$this->load->view("active_menu");?>