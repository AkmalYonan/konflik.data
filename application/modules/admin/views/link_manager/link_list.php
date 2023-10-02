<?php
	$arrCategory=$this->arr_category;
	$arrCategory[""]="All";
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$this->module_title?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin/dashboard"><i class="fa fa-chain"></i> Home</a></li>
    <li class="active"><?=$this->module_title?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <?php echo message_box();?> 

        <div id="print_this">

            <div class="col-xs-12">

                <a class="btn btn-app bg-purple" href="<?php echo $this->module?>link_list">
                    <i class="fa fa-bars"></i> Daftar Link
                </a>
                <a class="btn btn-app bg-purple" href="<?php echo $this->module?>link_add" id="addData">
                    <i class="fa fa-plus"></i> Input Link
                </a>
                <a class="btn btn-app bg-purple" href="<?php echo $this->module?>link_list" id="refresh">
                    <i class="fa fa-refresh"></i> Refresh
                </a>

                
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title"><?php echo form_dropdown("cat_id",$arrCategory,$this->input->get_post("cat_id"),"id='cat_id' class='input-xlarge select2' style='width:300px'");?></h3>
                      <div class="box-tools">
                        <form action="<?=$this->module?>" method="get">
                        <?php $this->load->view("widget/search_box_db"); ?>
                        </form>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body  table-responsive no-padding">
                        <form name="frmMain" action="<?=$this->module.'del_cek'?>" method="post" OnSubmit="return onDelete();">
                            <table class="table table-hover table-bordered">
                                
                                <tr>
                                    <th width="70">
                                        &nbsp;
                                    </th>
                                    <th style="width:300px">Name</th>
							        <th style="width:300px">URL</th>
							        <th>Description</th>
							        <th>Category</th>
							        <th class="tc">Publish?</th>
                                </tr>

                                <?php if(cek_array($arrData)):?>
						        	<?php foreach($arrData as $x=>$val):
											$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
									?>
						            	<tr>
						                	<td class="tc">
											<a href="<?php echo $this->module."link_edit/".$id?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
						                    <a onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?php echo $this->module."link_delete/".$id?>"><i class="fa fa-times"></i></a>    
											</td>
						                    <td><?php echo $val["name"]?></td>
						                    <td><a href="<?php echo $val["link_url"]?>" target="_blank"><?php echo $val["link_url"]?></a></td>
						                    <td><?php echo $val["description"]?></td>
						                    <td><?php echo $val["category_name"]?></td>
						                    <td class="tc"><?php if($val["publish"]==1):?>
													<span class="label label-info">Yes</span>
												<?php elseif($val["publish"]==0):?>
													<span class="label label-danger">No</span>
												<?php endif;?>
											</td>
						                    
						                </tr>
						            <?php endforeach;?>
								<?php endif;?>

                            </table>
                        </form>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php $page_link=$this->pagination->create_links(); ?>
							<!--<div class="row pagination_bar box_quote">-->
							<div class="rows well well-sm" >
							<div class="col-md-8">
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
												$this->pagination->total_rows." entries, ";		
									endif;		
								?>
								<?php
								$arrPerPageSelect=array(
										3=>3,
										10=>10,
										25=>25,
										50=>50,
										-1=>"All"
									);
									$pp=$perPage;
								?>
								Rows/page: &nbsp;<?=form_dropdown("pp_select",$arrPerPageSelect,$pp,"id='pp_select' class='input-mini'")?>	
								<input type="hidden" id="pp" name="pp" value="" />
								</div>
							</div><!-- end span 6-->
							<div class="col-md-4">
								<span class="pull-right">
									<div style="margin-top:-23px; margin-right:10px">
									<?php echo $page_link; ?>
									</div>
								</span>
							</div><!-- end span 6-->
							<div class="clearfix" style="height:24px"></div>

							</div><!-- end class well -->
                    </div>
                  </div><!-- /.box -->

            </div>

        </div>
    </div>

</section>






<script>
	$(function(){
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
		
		$("#cat_id").change(function(){
			get_query();
		});
			
	
	});
	
	
	function get_query(){
			var q =$("#q").val()||"";
			var perPage=$("#pp_select option:selected").val();
			$("#pp").val(perPage);
			var pp =$("#pp").val()||"";
			
			var cat_id =$("#cat_id option:selected").val()||"";
			
			var data=[];
			if(cat_id){
				data.push("cat_id="+cat_id);
			}
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
<?php echo css_asset("plugin/select2.css");?>
<?php echo js_asset("plugin/select2.js");?>
<script>
	$(function(){
		$(".select2").select2();
	});
</script>

<script>
	$(function(){
		var act_link="<?=$this->module?>link";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>