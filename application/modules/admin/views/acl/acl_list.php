<?php
	if(cek_array($arrGroup2Modules)):
		foreach($arrGroup2Modules as $x=>$val):
			$dataACL[$val["group_id"]][$val["module_id"]]=$val["rights"];
		endforeach;
	endif;
	
?>
<section class="content-header">
  <h1>
    Account Manager
    <small>Access Control List</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Account Manager</li>
    <li class="active">ACL</li>
  </ol>
</section>
<section class="content">
	
	<div class="row">
		<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
			<div class="box ">
            	<div class="box-header with-border clearfix">
                	<a class="btn btn-default acl_save" href="#">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-default" href="<?php echo $this->module?>">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <!--<a id="filter_toggle" class="btn btn-default" >
                        <i class="fa fa-search"></i> Search
                    </a>-->
                    
                </div>
			<!-- form start -->
				<div class="box-body no-padding">
					<div class="row">
							<div class="col-md-12">
							<form id="frm" method="post" action="<?php echo $this->module?>acl_save/">
									<div class="box-group" id="accordion">
										<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
										<? foreach($arrGroups as $group):?>
										
										<div class="panel box box-primary">
											<div class="box-header with-borders" data-toggle="collapse" data-parent="#accordion" href="#<?=$group["id"]?>">
												<h4 class="box-title">
													<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#<?=$group["id"]?>">
														<?=$group["name"]?>
													</a>
												</h4>
											</div>
											<div id="<?=$group["id"]?>" class="panel-collapse collapse <?=$group["id"] == 1?"in":""; ?>">
												<div class="box-body no-paddings">
													<table class="table table-condensed">
														<thead class="box_quote">
															<tr>
                                                            	<th>Module</th>
																<? foreach($arrRights as $right):?>
																	<th><label class="radio inline"><input type="radio" name="rb_all[<?=$group["id"]?>]" data-right='<?=$right["right_id"]?>' data-group='<?=$group["id"]?>' class="rb inline all"> <?=$right["description"]?></label></th>
																<? endforeach;?>
															</tr>
														</thead>
														<? foreach($arrModules as $module):?>
															<tr style="background-color:<? echo ($module["is_group"])?"#f4f4f4":""?>">
																<td><? if($module["is_group"]):?>
                                                                        <b><?php echo $module["module_name"]?><b>
                                                                    <? else:?>
                                                                        <span style="padding-left:20px"><?php echo $module["module_name"]?></span>
                                                                    <? endif;?>  </td>
																<? foreach($arrRights as $right):?>
																
																<?php 
																	$checked="";
																	if(isset($dataACL[$group["id"]][$module["idx"]])):
																		$dataACLRight=$dataACL[$group["id"]][$module["idx"]];
																		if($right["right_id"]==$dataACLRight):
																			$checked="checked='checked'";
																		endif;
																	endif;
																?>
                                                                <? if($module["is_group"]):?>
																<td><input type="radio" name="rb[<?=$group["id"]?>][<?=$module["idx"]?>]" class="rb inline g_<?=$group["id"]?> m_<?=$module["idx"]?> r_<?=$right['right_id']?> child" data-group='<?=$group["id"]?>' data-module='<?=$module["idx"]?>' data-right='<?=$right["right_id"]?>'  value="<?=$right["right_id"]?>"  <?php echo $checked?>></td>
                                                                <? else:?>
																<td><input type="radio" name="rb[<?=$group["id"]?>][<?=$module["idx"]?>]" class="rb inline g_<?=$group["id"]?> m_<?=$module["idx"]?> r_<?=$right['right_id']?> p_<?=$module['parent_idx']?>" data-group='<?=$group["id"]?>' data-module='<?=$module["idx"]?>' data-right='<?=$right["right_id"]?>'  value="<?=$right["right_id"]?>"  <?php echo $checked?>></td>
																<? endif;?>
																<? endforeach;?>
                                                                 
															</tr>
														<? endforeach;?>
													</table>
												</div>
											</div>
										</div>
										<? endforeach;?>
									</div>
							
							</form>
					</div>
			
				</div>
			</div><!-- /.box-body -->	
		  </div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->	

	
</section><!-- end div positioning -->
<script>
	//komeng added
	$(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	});
	
	$(".acl_save").click(function(e){
		e.preventDefault();
		$("#frm").submit();
	});
	
	$(".rb.all").click(function(){
		var group=$(this).data("group");
		var right=$(this).data("right");
		$(".g_"+group+".r_"+right).each(function(){
			$(this).trigger("click");
		});
	});
	$(".rb.child").click(function(){
		var group=$(this).data("group");
		var right=$(this).data("right");
		var parent=$(this).data("module");
		$(".g_"+group+".r_"+right+".p_"+parent).each(function(){
			$(this).trigger("click");
		});
	});
</script>