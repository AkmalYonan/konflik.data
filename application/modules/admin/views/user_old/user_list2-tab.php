<?php 
if ($_POST['uo'] || $_POST['sort'] || $_POST['q']) {
	$class_toggle=" active";
	$class_content="";
}
else {
	$class_toggle="";
	$class_content="none";
}
?>
<section class="content-header">
  <h1 class="hidden-xs">
    Account Manager
    <small>User</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Account Manager</li>
    <li class="active">User</li>
  </ol>
</section>
<section class="content">
    <!--<div class="row">
    	<div class="col-md-12">
            <div class="rows well well-sm no-shadow">
                <a class="btn btn-default active" href="<?php echo $this->module?>">
                    <i class="fa fa-list"></i>
                </a>
                <a class="btn btn-default" href="<?php echo $this->module?>user_add">
                    <i class="fa fa-plus"></i>
                </a>	  
                <a class="btn btn-default" href="<?php echo $this->module?>">
                    <i class="fa fa-refresh"></i>
                </a>
                <form class="search_form col-md-2 pull-right" action="<?=$this->module?>" method="get">
                <?php $this->load->view("widget/search_box_db"); ?>
                </form>
            </div>
        </div>
    </div>-->
    <div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="<?php echo $this->module?>"><i class="fa fa-list"></i></a></li>
              <li><a href="<?php echo $this->module?>add"><i class="fa fa-plus"></i></a></li>
              <li class="dropdown pull-right">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Export <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                </ul>
              </li>
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
              
              
            </ul>
            <!--dummy tab content-->
            <div class="tab-content">
              <!-- filter section -->
              <div class="filter-section">
                  <div class="row">
                    <div class="col-md-1">
                        <a class="btn btn-default btn-flat btn-sms" href="<?php echo $this->module?>">
                            <i class="fa fa-refresh"></i> Refresh
                        </a>
                    </div>
                    <div class="col-md-11">
                        <form class="" action="<?=$this->module?>" method="get">
                        <?php $this->load->view("widget/search_box_db"); ?>
                        </form>
                    </div>
                  </div>
              </div>
              <!-- end: filter section -->
              <div>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                        	<th>No.</th>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Groups</th>
                            <th>Status</th>
                            <th style="width:70px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$value):
                                    $id=$this->encrypt_status==TRUE?encrypt($value[$this->tbl_idx]):$value[$this->tbl_idx];
                            ?>
                                <tr>
                                	<td><?=$x+1?></td>
                                    <td><?php echo $value["username"]?></td>
                                    <td><?php echo $value["first_name"]?></td>
                                    <td><?php echo $value["last_name"]?></td>
                                    <td><?php echo $value["email"]?></td>
                                    <td>
                                    <?php if ($this->lat_auth->multiple_groups): ?>
                                    <?php
										if (cek_array($value['groups'])):
											foreach($value['groups'] as $rows){
												echo '<li>'.$rows['name'].'</li>';
											}
										endif;
                                    ?>
                                    <?php else:?>
                                    	<?php echo $value['groups'][0]['name']?>
                                    <?php endif;?>
                                     </td>
                                    <td>
                                    <? if($value["active"]):?>
                                    <a href="<?=$this->module?>deactivate/<?php echo $id?>"><span class="label label-success"><?php echo lang('index_active_link')?></span></a>		<? else:?>
                                    <a href="<?=$this->module?>activate/<?php echo $id?>"><span class="label bg-gray disabled"><?php echo lang('index_inactive_link')?></span></a>	
                                    <? endif;?>
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-success" href="<?=$this->module?>edit/<?=$id?>"><i class="fa fa-pencil"></i></a> 
                                        <a class="btn btn-xs btn-danger" href="<?php echo $this->module."delete/".$id?>"><i class="fa fa-remove"></i></a> 
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
              </div>
            </div>
            <!-- /.tab-content -->
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
                        Rows/page: <?=form_dropdown("pp_select",$arrPerPageSelect,$pp,"id='pp_select'")?>	
                        <input type="hidden" id="pp" name="pp" value="" />
                            
                             </div>
                        </div><!-- end span 6-->
                        <div class="col-md-4 col-xs-12">
            
                                <?php $page_link=$this->pagination->create_links(); ?>
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
		$("#filter_toggle").click(function(){
			$(this).toggleClass("active");
			$("#filter_content").slideToggle();
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

<script>
	$(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
	})
</script>