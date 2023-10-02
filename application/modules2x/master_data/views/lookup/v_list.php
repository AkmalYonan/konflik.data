<?php
	$arrCategory=$this->arr_category;
	$arrCategory[""]="All";
	
	$arrLookupCategory=$this->conn->GetAll("select * from m_lookup_category order by order_num");
	//$arrData=$this->conn->GetAll("select * from m_lookup order by lookup_category,order_num");
	if(cek_array($arrData)):
		foreach($arrData as $x=>$val):
			$lookup[$val["lookup_category"]][]=$val;
		endforeach;
	endif;
	
?>
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
                    <a class="btn btn-white" href="<?php echo $this->module?>add_category" data-toggle='tooltip' data-original-title="Add category">
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
                
                <table class="table table-bordered table-condensed">
                	<thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Lookup</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<? foreach($arrLookupCategory as $x=>$val):?>
                        <?php $id_category=$this->encrypt_status==TRUE?encrypt($val["idx"]):$val["idx"];?>
                    	<tr>
                    		<td width="200px"><?=$val["ur_lookup_category"]?>
                            <div class="btn-group btn-group-xs pull-right">
                            <a class="btn btn-xs btn-success" href="<?=$this->module?>edit_category/<?=$id_category?>" data-toggle='tooltip' title="Edit Kategori"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-xs btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini?');" data-toggle='tooltip' href="<?php echo $this->module."del_category/".$id_category?>" title="Delete Kategori"><i class="fa fa-remove"></i></a> 
                            
                            </div>
                            </td>
                            <td>
                            	<? 
									$lookup_category=$val["kd_lookup_category"];
									$data_detail=$lookup[$lookup_category];
									
									
								?>
                                
                                
                                
                                <!-- start table -->
                                <div class="box box-solid">
                <div class="box-header with-border">
                  <h5 class="box-title"></h5>
                  <div class="pull-right" style="margin-right:40px">
                  	<a class="btn btn-default bg-green" href="<?php echo $this->module?>add/<?=$lookup_category?>" data-toggle='tooltip' data-original-title="Add">
                        <i class="fa fa-plus"></i> Add <?=$val["ur_lookup_category"]?>
                    </a>
                  </div>
                  <div class="box-tools pull-right">
                  		<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div style="display: block;" class="box-body"><table class="table table-condensed table-bordered">
                                	<thead>
                                    	<tr>
                                        	<th>Kode</th>
                                            <th>Uraian</th>
                                            <th>Up</th>
                                            <th>Down</th>
                                            <th>Urutan</th>
                                            <th>&nbsp;</th>
                                            
                                        </tr>
                                    </thead>
                                <? foreach($data_detail as $xx=>$valx):?>
                                	<?php $id=$this->encrypt_status==TRUE?encrypt($valx[$this->tbl_idx]):$valx[$this->tbl_idx];?>
                                	<tr>
                                    	<td width="50px"><?=$valx["kd_lookup"]?></td>
                                        <td><?=$valx["ur_lookup"]?></td>
                                        <td style="text-align:center;width:30px;">
										<?php if($valx["order_num"]>1):?>
                                            <a href="<?=$this->module?>up/<?=$id?>/<?=$lookup_category?>"><i class="fa fa-arrow-up" data-toggle='tooltip' title="up"></i></i>
                                        <? endif;?>
                                    </td>
                                    <td style="text-align:center;width:30px;">
										<?php if($valx["order_num"]< count($arrData)):?>
                                            <a href="<?=$this->module?>down/<?=$id?>/<?=$lookup_category?>" data-toggle='tooltip' title="down"><i class="fa fa-arrow-down"></i></a>
                                        <? endif;?>
                                    </td>
                                        <td width="20px"><?=$valx["order_num"]?></td>
                                       	<td width="80px" align="center">
                                        <a class="btn btn-xs btn-success" href="<?=$this->module?>edit/<?=$id?>" data-toggle='tooltip' title="Edit"><i class="fa fa-pencil"></i></a> 
                                        <a class="btn btn-xs btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini?');" data-toggle='tooltip' href="<?php echo $this->module."del/".$id?>" title="Delete"><i class="fa fa-remove"></i></a> 
                                    	</td> 
                                    </tr>
								<? endforeach;?>
                                </table>
                                </div></div><!--./box-->
                                <!-- end table -->
                                
                                
                                
                            </td>
                    	</tr>
                        <? endforeach;?>
                    </tbody>
                </table>
                
                
                <table class="table table-bordered table-condensed small-font hidden">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Lookup</th>
                            <th>Uraian</th>
                            <th>Group</th>
                            <th width="40px" class="tc">Up</th>
        <th width="40px" class="tc">Down</th>
		<th width="40px"><center>Order</center></th>
                            <th style="width:70px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$value):
                                    $id=$this->encrypt_status==TRUE?encrypt($value[$this->tbl_idx]):$value[$this->tbl_idx];
                            ?>
                                <tr>
                                    <td><?php echo $offset+$x+1?>.</td>
                                    <td><?php echo $value["kd_lookup"]?></td>
                                    <td><?php echo $value["ur_lookup"]?></td>
                                    <td><?php echo $value["lookup_category"]?></td>
                                     <td style="text-align:center">
										<?php if($value["order_num"]>1):?>
                                            <a href="<?=$this->module?>up/<?=$id?>"><i class="fa fa-arrow-up" data-toggle='tooltip' title="up"></i></i>
                                        <? endif;?>
                                    </td>
                                    <td style="text-align:center">
										<?php if($value["order_num"]< count($arrData)):?>
                                            <a href="<?=$this->module?>down/<?=$id?>" data-toggle='tooltip' title="down"><i class="fa fa-arrow-down"></i></a>
                                        <? endif;?>
                                    </td>
                                    
                                    <td align="center" valign="top"><?php echo $value["order_num"]?></td>
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
                <div class="box-footer clearfix hidden">
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