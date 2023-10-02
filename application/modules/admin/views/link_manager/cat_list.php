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

                <a class="btn btn-app bg-purple" href="<?php echo $this->module?>category_list">
                    <i class="fa fa-bars"></i> Daftar Category
                </a>
                <a class="btn btn-app bg-purple" href="<?php echo $this->module?>category_add" id="addData">
                    <i class="fa fa-plus"></i> Input Category
                </a>
                <a class="btn btn-app bg-purple" href="<?php echo $this->module?>category_list" id="refresh">
                    <i class="fa fa-refresh"></i> Refresh
                </a>
                
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Tabel Daftar Category</h3>
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
                                    <th style="width:300px">Category</th>
							        <th>Description</th>
							        <th class="tc">Publish ?</th>
							        <th width="30px" class="tc">Up</th>
							        <th width="30px" class="tc">Down</th>
							        <th width="40px" class="tc">Order</th>
                                </tr>

                                <?php if(cek_array($arrData)):?>
						        	<?php foreach($arrData as $x=>$val):
											$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
									?>
						            	<tr>
						                	<td class="tc">
						                    <a href="<?php echo $this->module."category_edit/".$id?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
						                    <a onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?php echo $this->module."category_delete/".$id?>"><i class="fa fa-times"></i></a>    
						                    </td>
						                    <td><?php echo $val["category"]?></a></td>
						                    <td><?php echo $val["description"]?></td>
						                    <td class="tc"><?php if($val["publish"]==1):?>
													<span class="label label-info">Yes</span>
												<?php else:?>
													<span class="label label-danger">No</span>
												<?php endif;?>
											</td>
						                    
						                    <td class="tc">
												<?php if($val["order_num"]>1):?>
						                    		<a href="<?=$this->module?>up/<?=$id?>"?><i class="fa fa-level-up"></i></i>
												<? endif;?>
						                    </td>
						                     
						                    <td class="tc">
						                    	<?php if($val["order_num"]< count($arrData)):?>
						                    		<a href="<?=$this->module?>down/<?=$id?>"><i class="fa fa-level-down"></i></a>
												<? endif;?>
						                    
						                    </td>
						                    <td><?php echo $val["order_num"]?></td>
						                    
						                </tr>
						            <?php endforeach;?>
								<?php endif;?>

                            </table>
                        </form>
                    </div><!-- /.box-body -->
                    <!-- <div class="box-footer clearfix">
                        <div class="displaying">
                            Displaying : <?=$data_start;?> - <?=$data_end;?> of <?=$total_rows;?> entries, Rows/page: <?=$perpage;?>
                        </div>
                        <div class="pagination pagination-sm no-margin pull-right">
                            <?=$paging;?>
                        </div>
                    </div> -->
                  </div><!-- /.box -->

            </div>

        </div>
    </div>

</section>





<script>
	$(function(){
		var act_link="<?=$this->module?>category";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>